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

build-system: ## Build the system application
	mkdir -p system/bin
	cd system && gcc -o bin/main main.c -ljansson

clean-system: ## Clean build artifacts
	rm -rf system/bin/
	find system -name '*.o' -type f -delete

# Service management targets
run-system: build-system ## Run the system application in background
	@if pgrep -f "system/bin/main" > /dev/null; then \
		echo "System service is already running"; \
	else \
		echo "Starting system service in background..."; \
		nohup system/bin/main > system/logs/system.log 2>&1 & \
		echo $$! > system/bin/system.pid; \
		echo "System service started with PID $$!"; \
	fi

stop-system: ## Stop the system application
	@if [ -f system/bin/system.pid ]; then \
		PID=$$(cat system/bin/system.pid); \
		if kill $$PID 2>/dev/null; then \
			echo "System service stopped (PID: $$PID)"; \
			rm -f system/bin/system.pid; \
		else \
			echo "System service was not running"; \
			rm -f system/bin/system.pid; \
		fi; \
	else \
		echo "No PID file found, attempting to kill by process name..."; \
		pkill -f "system/bin/main" && echo "System service stopped" || echo "System service was not running"; \
	fi

install-system-service: build-system ## Install systemd user service for startup
	@mkdir -p ~/.config/systemd/user
	@echo "[Unit]" > ~/.config/systemd/user/www-webhook.service
	@echo "Description=WWW Webhook Service" >> ~/.config/systemd/user/www-webhook.service
	@echo "After=network.target" >> ~/.config/systemd/user/www-webhook.service
	@echo "" >> ~/.config/systemd/user/www-webhook.service
	@echo "[Service]" >> ~/.config/systemd/user/www-webhook.service
	@echo "Type=simple" >> ~/.config/systemd/user/www-webhook.service
	@echo "WorkingDirectory=$(PWD)" >> ~/.config/systemd/user/www-webhook.service
	@echo "ExecStart=$(PWD)/system/bin/main" >> ~/.config/systemd/user/www-webhook.service
	@echo "Restart=always" >> ~/.config/systemd/user/www-webhook.service
	@echo "RestartSec=5" >> ~/.config/systemd/user/www-webhook.service
	@echo "StandardOutput=append:$(PWD)/system/logs/system.log" >> ~/.config/systemd/user/www-webhook.service
	@echo "StandardError=append:$(PWD)/system/logs/system.log" >> ~/.config/systemd/user/www-webhook.service
	@echo "" >> ~/.config/systemd/user/www-webhook.service
	@echo "[Install]" >> ~/.config/systemd/user/www-webhook.service
	@echo "WantedBy=default.target" >> ~/.config/systemd/user/www-webhook.service
	@systemctl --user daemon-reload
	@echo "Systemd user service installed"

enable-system-service: install-system-service ## Enable system service to start on boot
	@systemctl --user enable www-webhook.service
	@echo "System service enabled for startup"

disable-system-service: ## Disable system service from starting on boot
	@systemctl --user disable www-webhook.service
	@echo "System service disabled from startup"

status-system: ## Check system service status
	@if [ -f system/bin/system.pid ]; then \
		PID=$$(cat system/bin/system.pid); \
		if kill -0 $$PID 2>/dev/null; then \
			echo "System service is running (PID: $$PID)"; \
		else \
			echo "System service PID file exists but process is not running"; \
			rm -f system/bin/system.pid; \
		fi; \
	else \
		echo "System service is not running"; \
	fi
	@echo "Systemd service status:"
	@systemctl --user status www-webhook.service --no-pager || echo "Systemd service not installed"