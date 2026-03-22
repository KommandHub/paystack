.PHONY: help install test lint format up down build logs shell

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Install composer dependencies locally
	composer install

test: ## Run PHPUnit tests
	composer test

lint: ## Run static analysis (PHPStan)
	composer lint

format: ## Automatically fix code style issues
	composer format

up: ## Start the Docker environment
	docker-compose up -d

down: ## Stop the Docker environment
	docker-compose down

build: ## Build/rebuild the Docker image
	docker-compose up -d --build

logs: ## Follow Docker logs
	docker-compose logs -f app

shell: ## Access the app container shell
	docker-compose exec app sh
