#!/bin/bash

# Build the project using Docker Compose
DOCKER_COMPOSE_FILE="docker-compose.prod.yml"  # Specify the name of your Docker Compose file
docker-compose -f "$DOCKER_COMPOSE_FILE" build

# Confirmation message
echo "Project rebuilt successfully."
