.PHONY: all up down restart logs build run-scripts

# Default target
all: up run-scripts

up:
	@if [ "$(shell docker ps -q -f name=php-webserver)" ]; then \
	  echo "Container is already running. Restarting..."; \
	  docker-compose restart; \
	else \
	  echo "Container is not running. Building and starting..."; \
	  docker-compose up -d --build; \
	fi

down:
	-@docker-compose down || true

build:
	docker-compose build

restart:
	-@docker-compose down || true
	docker-compose build
	docker-compose up -d

logs:
	tail -f logs/php_error.log logs/apache_error.log logs/apache_access.log

run-scripts:
	@echo "Running all PHP scripts in the build-scripts directory..."
	@for script in $$(ls build-scripts/*.php); do \
	  echo "Running $$script..."; \
	  docker exec php-webserver php /var/www/$$script | sed 's/.*php-webserver//' | grep -v "What's next"; \
	done
