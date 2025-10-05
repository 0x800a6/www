#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/wait.h>
#include <jansson.h>

#define PORT 3000
#define BUFFER_SIZE 4096


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
    printf("Executing: %s\n", command);
    int result = system(command);
    if (result != 0) {
        printf("Command failed with exit code: %d\n", result);
        return 0;
    }
    return 1;
}

int is_github_push_event(const char *payload) {
    json_t *root;
    json_error_t error;
    
    root = json_loads(payload, 0, &error);
    if (!root) {
        printf("JSON parse error: %s\n", error.text);
        return 0;
    }
    
    json_t *ref = json_object_get(root, "ref");
    if (!ref || !json_is_string(ref)) {
        json_decref(root);
        return 0;
    }
    
    const char *ref_str = json_string_value(ref);
    int is_push = (strcmp(ref_str, "refs/heads/master") == 0 || 
                   strcmp(ref_str, "refs/heads/main") == 0);
    
    json_decref(root);
    return is_push;
}

int handle_github_webhook(const char *payload) {
    if (!is_github_push_event(payload)) {
        printf("Not a push event to master/main branch\n");
        return 0;
    }
    
    printf("GitHub push event detected, executing deployment...\n");
    
    // Execute git pull
    if (!execute_command("git pull")) {
        printf("Git pull failed\n");
        return 0;
    }
    
    // Execute systemctl restart www (user service)
    if (!execute_command("systemctl --user restart www")) {
        printf("Service restart failed\n");
        return 0;
    }
    
    printf("Deployment completed successfully\n");
    return 1;
}

int main(void) {
    int server_fd, new_socket;
    struct sockaddr_in address;
    int addrlen = sizeof(address);

    server_fd = socket(AF_INET, SOCK_STREAM, 0);
    if (server_fd == -1) {
        perror("socket failed");
        return 1;
    }

    int opt = 1;
    setsockopt(server_fd, SOL_SOCKET, SO_REUSEADDR, &opt, sizeof(opt));

    address.sin_family = AF_INET;
    address.sin_addr.s_addr = inet_addr("127.0.0.1");
    address.sin_port = htons(PORT);

    if (bind(server_fd, (struct sockaddr *)&address, sizeof(address)) < 0) {
        perror("bind failed");
        close(server_fd);
        return 1;
    }

    if (listen(server_fd, 1) < 0) {
        perror("listen failed");
        close(server_fd);
        return 1;
    }

    printf("Server is running on http://127.0.0.1:%d/\n", PORT);

    while (1) {
        new_socket = accept(server_fd, (struct sockaddr *)&address, (socklen_t *)&addrlen);
        if (new_socket < 0) {
            perror("accept failed");
            continue;
        }

        char buffer[BUFFER_SIZE];
        ssize_t read_size = recv(new_socket, buffer, BUFFER_SIZE - 1, 0);
        if (read_size <= 0) {
            close(new_socket);
            continue;
        }
        buffer[read_size] = '\0';

        // Check for POST /webhook
        if (starts_with(buffer, "POST /webhook ")) {
            // Find the start of the JSON payload (after headers)
            char *payload_start = strstr(buffer, "\r\n\r\n");
            if (payload_start) {
                payload_start += 4; // Skip the \r\n\r\n
                
                // Handle the GitHub webhook
                int success = handle_github_webhook(payload_start);
                
                const char *response_msg = success ? "Deployment successful" : "Deployment failed";
                const char *status_code = success ? "200 OK" : "500 Internal Server Error";
                
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
            const char not_found_response[] =
                "HTTP/1.1 404 Not Found\r\n"
                "Content-Type: text/plain\r\n"
                "Content-Length: 10\r\n"
                "Access-Control-Allow-Origin: *\r\n"
                "\r\n"
                "Not Found";
            send(new_socket, not_found_response, strlen(not_found_response), 0);
        }

        close(new_socket);
    }

    close(server_fd);
    return 0;
}