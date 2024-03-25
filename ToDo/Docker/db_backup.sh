#!/bin/bash
CURRENT_DIR="$PWD"

BACKUP_DIR="$CURRENT_DIR/backups/db"
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
fi


# Load values from the .env file
set -a
source "$CURRENT_DIR/docker/env/.env"
set +a

# Variables from the .env file
DB_CONTAINER_NAME='PENTE_DB'
DB_NAME=$MYSQL_DATABASE
DB_USER=$MYSQL_USER
DB_PASSWORD=$MYSQL_PASSWORD

# Create a timestamp for the backup file name
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
DUMP_FILE="$BACKUP_DIR/$DB_NAME-$TIMESTAMP.sql"

# Create a database dump
docker exec "$DB_CONTAINER_NAME" /usr/bin/mysqldump -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$DUMP_FILE"

if [ $? -eq 0 ]; then
    echo "Database backup created: $DUMP_FILE"
else
    echo "Error"
fi

