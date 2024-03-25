#!/bin/bash

# Restart project

DOCKER_COMPOSE_FILE="docker-compose.prod.yml"  # Specify the name of your Docker Compose file
docker-compose -f "$DOCKER_COMPOSE_FILE" restart

# Confirmation message
echo "Project restarted successfully."
