# Go Website Makefile

.PHONY: help build clean fmt

# Default target
help: ## Show this help message
	@echo "Available targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# Development targets
build: ## Build the Go application
	cd www && go build -o bin/website ./cmd/website && cp -r html bin/ && cp -r static bin/ && cp -r templates bin/ && cp -r ../CHANGELOG.md bin/

fmt: ## Format Go code
	cd www && go fmt ./...

clean: ## Clean build artifacts
	rm -rf www/bin/
	rm -f www/main