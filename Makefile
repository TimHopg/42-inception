# Root Makefile for Inception project# Inception Makefile - Simple version

# This file orchestrates building and running the entire Docker infrastructure

COMPOSE_FILE = srcs/docker-compose.yml

# Define the path to docker-compose file (must be in srcs/ folder per subject)

COMPOSE_FILE = srcs/docker-compose.yml.PHONY: build up down logs ps clean



# Define phony targets (targets that don't produce files, just run commands)build:

.PHONY: build up down	docker-compose -f $(COMPOSE_FILE) build



# Target: buildup:

# Purpose: Build all Docker images defined in docker-compose.yml	docker-compose -f $(COMPOSE_FILE) up -d

# What it does: Reads Dockerfiles from requirements/ and creates images

build:down:

	docker-compose -f $(COMPOSE_FILE) build	docker-compose -f $(COMPOSE_FILE) down



# Target: uplogs:

# Purpose: Start all containers in detached mode (-d = runs in background)	docker-compose -f $(COMPOSE_FILE) logs -f

# What it does: Creates and starts nginx, wordpress, and mariadb containers

up:ps:

	docker-compose -f $(COMPOSE_FILE) up -d	docker-compose -f $(COMPOSE_FILE) ps



# Target: downclean:

# Purpose: Stop and remove all running containers	docker-compose -f $(COMPOSE_FILE) down

# What it does: Gracefully shuts down all services	docker system prune -f

down:
	docker-compose -f $(COMPOSE_FILE) down

# Target: logs
# Purpose: View real-time logs from all containers
# Useful for debugging: shows what's happening inside containers
logs:
	docker-compose -f $(COMPOSE_FILE) logs -f

# Target: ps
# Purpose: Show status of all containers (running, stopped, etc)
ps:
	docker-compose -f $(COMPOSE_FILE) ps
