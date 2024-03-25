#!/bin/bash

# Start project

DOCKER_COMPOSE_FILE="docker-compose.prod.yml"  # Specify the name of your Docker Compose file
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

# Confirmation message
echo "Project start successfully."
