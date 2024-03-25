#!/bin/bash

# Stop project

DOCKER_COMPOSE_FILE="docker-compose.prod.yml"  # Specify the name of your Docker Compose file
docker-compose -f "$DOCKER_COMPOSE_FILE" down

# Confirmation message
echo "Project stopped successfully."
