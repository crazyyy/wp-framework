#!/bin/bash

# Variables from the .env file
WP_CONTAINER_NAME='PENTE_WP'
WP_ROOT_DIR='/var/www/html'

# Path to the .maintenance file
MAINTENANCE_FILE="$WP_ROOT_DIR/.maintenance"

# Check if the file exists in the container
docker exec "$WP_CONTAINER_NAME" bash -c \
  "if [ -f $MAINTENANCE_FILE ]; then
    echo 'File exists. Deleting it...'
    rm $MAINTENANCE_FILE
    echo 'The .maintenance file has been removed.'
  else
    echo 'The .maintenance file does not exist.'
  fi"
