COMPOSE_FILE = srcs/docker-compose.yml

# Build all Docker images
build:
	docker-compose -f $(COMPOSE_FILE) build

# Start containers
up:
	docker-compose -f $(COMPOSE_FILE) up -d

# Stop and remove containers
down:
	docker-compose -f $(COMPOSE_FILE) down

logs:
	docker-compose -f $(COMPOSE_FILE) logs -f

# Show status
ps:
	docker-compose -f $(COMPOSE_FILE) ps

# Remove unused volumes
prune:
	docker volume prune -f

# Clean rebuild
clean: down
	docker volume rm srcs_wordpress_files srcs_database 2>/dev/null || true
	$(MAKE) build up
	@echo "Clean rebuild complete"

rebuild: down build up
	@echo "Rebuild complete"

# Forward traffic from thopgood.42.fr to localhost
forward:
	sudo sh -c 'echo "127.0.0.1 thopgood.42.fr" >> /etc/hosts'

# Crash tests
crashdb:
	docker exec mariadb pkill mysqld
	sleep 1
	make ps

crashwp:
	docker exec wordpress pkill php-fpm
	sleep 1
	make ps

crashng:
	docker exec nginx nginx -s stop
	sleep 1
	make ps

# Create secrets folder/files (maybe not necessary)
secrets:
	chmod +x secrets_setup.sh
	./secrets_setup.sh

# Launch db terminal
database:
	docker exec -it mariadb mysql -u root -p
# use wordpress
# show tables;
# select user_login from wp_users;

.PHONY: build up down logs ps clean prune rebuild
