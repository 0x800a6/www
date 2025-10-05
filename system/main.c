#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/wait.h>
#include <jansson.h>

#define PORT 3000
#define BUFFER_SIZE 4096

void log_message(const char *level, const char *message) {
    time_t now;
    time(&now);
    struct tm *tm_info = localtime(&now);
    char timestamp[64];
    strftime(timestamp, sizeof(timestamp), "%Y-%m-%d %H:%M:%S", tm_info);
    printf("[%s] [%s] %s\n", timestamp, level, message);
    fflush(stdout);
}

int starts_with(const char *str, const char *prefix) {
    while (*prefix) {
        if (*str++ != *prefix++) return 0;
    }
    return 1;
}

int is_cloudflare_tunnel_request(const char *request) {
    // Check for Cloudflare tunnel headers
    return (strstr(request, "cf-ray:") != NULL || 
            strstr(request, "cf-connecting-ip:") != NULL ||
            strstr(request, "cf-visitor:") != NULL);
}

int execute_command(const char *command) {
    log_message("INFO", "Executing command");
    printf("Command: %s\n", command);
    int result = system(command);
    if (result != 0) {
        log_message("ERROR", "Command failed");
        printf("Exit code: %d\n", result);
        return 0;
    }
    log_message("INFO", "Command executed successfully");
    return 1;
}

int is_github_push_event(const char *payload) {
    log_message("DEBUG", "Parsing GitHub webhook payload");
    json_t *root;
    json_error_t error;
    
    root = json_loads(payload, 0, &error);
    if (!root) {
        log_message("ERROR", "JSON parse error");
        printf("Error: %s\n", error.text);
        return 0;
    }
    
    json_t *ref = json_object_get(root, "ref");
    if (!ref || !json_is_string(ref)) {
        log_message("WARN", "No ref field found in payload");
        json_decref(root);
        return 0;
    }
    
    const char *ref_str = json_string_value(ref);
    log_message("INFO", "Checking ref branch");
    printf("Ref: %s\n", ref_str);
    
    int is_push = (strcmp(ref_str, "refs/heads/master") == 0 || 
                   strcmp(ref_str, "refs/heads/main") == 0);
    
    if (is_push) {
        log_message("INFO", "Valid push event detected");
    } else {
        log_message("INFO", "Push event not to master/main branch");
    }
    
    json_decref(root);
    return is_push;
}

int handle_github_webhook(const char *payload) {
    log_message("INFO", "Handling GitHub webhook");
    
    if (!is_github_push_event(payload)) {
        log_message("WARN", "Not a push event to master/main branch");
        return 0;
    }
    
    log_message("INFO", "GitHub push event detected, starting deployment");
    
    // Execute git pull
    if (!execute_command("git pull")) {
        log_message("ERROR", "Git pull failed");
        return 0;
    }
    
    // Execute systemctl restart www (user service)
    if (!execute_command("systemctl --user restart www")) {
        log_message("ERROR", "Service restart failed");
        return 0;
    }
    
    log_message("INFO", "Deployment completed successfully");
    return 1;
}

int main(void) {
    log_message("INFO", "Starting webhook server");
    
    int server_fd, new_socket;
    struct sockaddr_in address;
    int addrlen = sizeof(address);

    server_fd = socket(AF_INET, SOCK_STREAM, 0);
    if (server_fd == -1) {
        log_message("ERROR", "Failed to create socket");
        perror("socket failed");
        return 1;
    }
    log_message("DEBUG", "Socket created successfully");

    int opt = 1;
    setsockopt(server_fd, SOL_SOCKET, SO_REUSEADDR, &opt, sizeof(opt));
    log_message("DEBUG", "Socket options set");

    address.sin_family = AF_INET;
    address.sin_addr.s_addr = inet_addr("127.0.0.1");
    address.sin_port = htons(PORT);

    log_message("INFO", "Attempting to bind to 127.0.0.1:3000");
    if (bind(server_fd, (struct sockaddr *)&address, sizeof(address)) < 0) {
        log_message("ERROR", "Failed to bind socket");
        perror("bind failed");
        close(server_fd);
        return 1;
    }
    log_message("INFO", "Successfully bound to 127.0.0.1:3000");

    if (listen(server_fd, 1) < 0) {
        log_message("ERROR", "Failed to listen on socket");
        perror("listen failed");
        close(server_fd);
        return 1;
    }
    log_message("INFO", "Server listening for connections");

    log_message("INFO", "Server is running on http://127.0.0.1:3000/ (ready for Cloudflare tunnel)");

    while (1) {
        log_message("DEBUG", "Waiting for incoming connection");
        new_socket = accept(server_fd, (struct sockaddr *)&address, (socklen_t *)&addrlen);
        if (new_socket < 0) {
            log_message("ERROR", "Failed to accept connection");
            perror("accept failed");
            continue;
        }
        
        char client_ip[INET_ADDRSTRLEN];
        inet_ntop(AF_INET, &address.sin_addr, client_ip, INET_ADDRSTRLEN);
        log_message("INFO", "New connection accepted");
        printf("Client IP: %s\n", client_ip);

        char buffer[BUFFER_SIZE];
        ssize_t read_size = recv(new_socket, buffer, BUFFER_SIZE - 1, 0);
        if (read_size <= 0) {
            log_message("WARN", "Failed to read from socket or connection closed");
            close(new_socket);
            continue;
        }
        buffer[read_size] = '\0';
        
        log_message("DEBUG", "Request received");
        printf("Request size: %zd bytes\n", read_size);

        // Check for POST /webhook
        if (starts_with(buffer, "POST /webhook ")) {
            log_message("INFO", "POST /webhook request received");
            
            // Log if this is a Cloudflare tunnel request
            if (is_cloudflare_tunnel_request(buffer)) {
                log_message("INFO", "Cloudflare tunnel request detected");
            }
            
            // Find the start of the JSON payload (after headers)
            char *payload_start = strstr(buffer, "\r\n\r\n");
            if (payload_start) {
                payload_start += 4; // Skip the \r\n\r\n
                log_message("DEBUG", "JSON payload found, processing webhook");
                
                // Handle the GitHub webhook
                int success = handle_github_webhook(payload_start);
                
                const char *response_msg = success ? "Deployment successful" : "Deployment failed";
                const char *status_code = success ? "200 OK" : "500 Internal Server Error";
                
                log_message("INFO", "Sending response");
                printf("Status: %s\n", status_code);
                
                char response[512];
                snprintf(response, sizeof(response),
                    "HTTP/1.1 %s\r\n"
                    "Content-Type: text/plain\r\n"
                    "Content-Length: %zu\r\n"
                    "Access-Control-Allow-Origin: *\r\n"
                    "Access-Control-Allow-Methods: POST, OPTIONS\r\n"
                    "Access-Control-Allow-Headers: Content-Type, Authorization\r\n"
                    "\r\n"
                    "%s\n", status_code, strlen(response_msg), response_msg);
                
                send(new_socket, response, strlen(response), 0);
            } else {
                log_message("ERROR", "No JSON payload found in request");
                const char bad_request_response[] =
                    "HTTP/1.1 400 Bad Request\r\n"
                    "Content-Type: text/plain\r\n"
                    "Content-Length: 12\r\n"
                    "Access-Control-Allow-Origin: *\r\n"
                    "\r\n"
                    "Bad Request";
                send(new_socket, bad_request_response, strlen(bad_request_response), 0);
            }
        } else if (starts_with(buffer, "GET / ")) {
            log_message("INFO", "GET / request received (root endpoint)");
            const char *html_content = 
                "<!DOCTYPE html>\n"
                "<html lang=\"en\">\n"
                "<head>\n"
                "    <meta charset=\"UTF-8\">\n"
                "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n"
                "    <title>Webhook Service</title>\n"
                "    <style>\n"
                "        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }\n"
                "        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }\n"
                "        h1 { color: #333; border-bottom: 2px solid #007acc; padding-bottom: 10px; }\n"
                "        .status { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 20px 0; }\n"
                "        .endpoint { background: #f8f9fa; padding: 15px; border-left: 4px solid #007acc; margin: 20px 0; }\n"
                "        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-family: monospace; }\n"
                "    </style>\n"
                "</head>\n"
                "<body>\n"
                "    <div class=\"container\">\n"
                "        <h1>Webhook Service</h1>\n"
                "        <div class=\"status\">\n"
                "            <strong>✓ Service Active</strong><br>\n"
                "            Webhook service is running and ready to receive requests.\n"
                "        </div>\n"
                "        <div class=\"endpoint\">\n"
                "            <strong>Webhook Endpoint:</strong><br>\n"
                "            <code>POST /webhook</code>\n"
                "        </div>\n"
                "        <p>This service handles GitHub webhook events for automated deployments.</p>\n"
                "    </div>\n"
                "</body>\n"
                "</html>";
            
            char response[2048];
            int content_length = strlen(html_content);
            snprintf(response, sizeof(response),
                "HTTP/1.1 200 OK\r\n"
                "Content-Type: text/html; charset=utf-8\r\n"
                "Content-Length: %d\r\n"
                "Access-Control-Allow-Origin: *\r\n"
                "Cache-Control: no-cache\r\n"
                "\r\n"
                "%s", content_length, html_content);
            send(new_socket, response, strlen(response), 0);
        } else if (starts_with(buffer, "OPTIONS ")) {
            log_message("INFO", "OPTIONS request received (CORS preflight)");
            // Handle CORS preflight requests for Cloudflare tunnel
            const char options_response[] =
                "HTTP/1.1 200 OK\r\n"
                "Access-Control-Allow-Origin: *\r\n"
                "Access-Control-Allow-Methods: POST, OPTIONS\r\n"
                "Access-Control-Allow-Headers: Content-Type, Authorization\r\n"
                "Content-Length: 0\r\n"
                "\r\n";
            send(new_socket, options_response, strlen(options_response), 0);
        } else {
            log_message("WARN", "Unknown request received");
            printf("Request: %.100s...\n", buffer); // Print first 100 chars
            const char not_found_response[] =
                "HTTP/1.1 404 Not Found\r\n"
                "Content-Type: text/plain\r\n"
                "Content-Length: 10\r\n"
                "Access-Control-Allow-Origin: *\r\n"
                "\r\n"
                "Not Found";
            send(new_socket, not_found_response, strlen(not_found_response), 0);
        }

        log_message("DEBUG", "Closing connection");
        close(new_socket);
    }

    log_message("INFO", "Server shutting down");
    close(server_fd);
    return 0;
}