#!/bin/bash

# Step 2: Install additional packages
apt-get update
apt-get install -y mc nano git zip unzip

# Step 2: Install Docker
# Check if Docker is already installed
if ! command -v docker &> /dev/null; then
    echo "Docker is not installed. Installing Docker..."
    # Install Docker
    curl -fsSL https://get.docker.com -o get-docker.sh
    sudo sh get-docker.sh
    sudo usermod -aG docker $USER
    apt-get update

    echo "Docker has been installed successfully."
else
    echo "Docker is already installed."
fi

# Step 3: Install Docker Compose
# Check if Docker Compose is already installed
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose is not installed. Installing Docker Compose..."
    # Install Docker Compose
    sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
    apt-get update

    echo "Docker Compose has been installed successfully."
else
    echo "Docker Compose is already installed."
fi

# Step 4: Build the project using Docker Compose
DOCKER_COMPOSE_FILE="docker-compose.prod.yml"  # Specify the name of your Docker Compose file
docker-compose -f "$DOCKER_COMPOSE_FILE" build

# Confirmation message
echo "Project built successfully."
