COMPOSE_FILE = srcs/docker-compose.yml

# Build all Docker images
build:
	docker-compose -f $(COMPOSE_FILE) build

# Start containers in detached mode
up:
	docker-compose -f $(COMPOSE_FILE) up -d

# Stop and remove all containers
down:
	docker-compose -f $(COMPOSE_FILE) down

# View real-time logs
logs:
	docker-compose -f $(COMPOSE_FILE) logs -f

# Show status of all containers
ps:
	docker-compose -f $(COMPOSE_FILE) ps

# Remove unused volumes (for clean rebuild)
prune:
	docker volume prune -f

# Clean rebuild: stop, prune volumes, build, and start fresh
clean: down prune build up
	@echo "Clean rebuild complete"

# Rebuild and restart (for when you've updated Dockerfiles)
rebuild: down build up
	@echo "Rebuild complete"

.PHONY: build up down logs ps clean prune rebuild
