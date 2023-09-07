#!/bin/bash

sourceFile="./DB/exported-wp-sql.sql"  # Path to the source file
archiveFile="./DB/exported-wp-sql.7z"  # Path to the archive file to be created

# Prompt the user for the archive password
read -s -p "Enter the archive password: " password
echo  # Move to a new line after entering the password

# Check if the archive file exists and delete it if it does
if [ -e "$archiveFile" ]; then
  rm -f "$archiveFile"
fi

# Create a 7z archive with the provided password
7z a -t7z -p$password "$archiveFile" "$sourceFile"

# Check if the archive file was created successfully
if [ -e "$archiveFile" ]; then
  # If the file was created successfully, delete the original file
  rm -f "$sourceFile"
  echo "Original file deleted, and the archive has been created."
else
  echo "An error occurred while creating the archive."
fi
