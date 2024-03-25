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

# Prompt the user for the dump file name
read -p "Enter the dump file name: " DUMP_FILE_NAME
DUMP_FILE="$BACKUP_DIR/$DUMP_FILE_NAME"

# Restore the database from the dump
cat "$DUMP_FILE" | docker exec -i "$DB_CONTAINER_NAME" /usr/bin/mysql -u "$DB_USER" --password="$DB_PASSWORD" "$DB_NAME"

# Confirmation message for successful database restore
if [ $? -eq 0 ]; then
    echo "Database restored from dump: $DUMP_FILE"
else
    echo "Error"
fi
