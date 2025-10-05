# Lexi's Website

A personal website built with Go that focuses on privacy, accessibility, and clean design. The site serves static content with dynamic features like rate limiting and theme switching.

## Features

- **Go Backend**: Built with Go 1.25 and minimal dependencies
- **Responsive Design**: Works on mobile and desktop with dark and light themes
- **Accessibility**: Meets WCAG 2.1 standards with screen reader support
- **Performance**: HTML minification and static file serving with cache headers
- **Rate Limiting**: Token bucket algorithm prevents abuse
- **Security**: HTTP security headers and CORS protection
- **Docker**: Multi-stage build with Alpine Linux for production
- **Health Checks**: Built-in monitoring endpoints

## Requirements

- Go 1.25 or newer
- Docker and Docker Compose (optional)

## Installation

### Local Development

1. Clone the repository:

   ```bash
   git clone https://github.com/0x800a6/www.git
   cd www
   ```

2. Install dependencies:

   ```bash
   cd www
   go mod download
   ```

3. Run the application:

   ```bash
   go run cmd/website/main.go
   ```

4. Open [http://localhost:8080](http://localhost:8080) in your browser

### Docker Deployment

Run with Docker Compose:

```bash
docker-compose up --build
```

For production with Nginx:

```bash
docker-compose --profile production up -d
```

## Project Structure

```
www/
├── cmd/website/          # Main application entry point
├── internal/             # Private application code
│   ├── handlers/         # HTTP request handlers
│   ├── middleware/       # HTTP middleware
│   ├── models/           # Data structures
│   └── utils/            # Utility functions
├── html/                 # Page templates
├── static/               # Static assets (CSS, JS, images)
├── templates/            # Base templates
└── go.mod               # Go module dependencies
```

## Configuration

The application runs on port 8080 by default. Rate limiting is set to 60 requests per minute with a burst of 10 requests.

## API Endpoints

- `/` - Home page
- `/resume` - Resume page
- `/projects` - Projects page
- `/sitemap` - Sitemap page
- `/sitemap.xml` - XML sitemap
- `/ratelimit` - Rate limit exceeded page
- `/health` - Health check endpoint

## Development

### Building

Use the Makefile for common tasks:

```bash
make build    # Build the application
make fmt      # Format Go code
make clean    # Clean build artifacts
```

### Dependencies

The project uses minimal external dependencies:

- `github.com/tdewolff/minify/v2` - HTML minification

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
