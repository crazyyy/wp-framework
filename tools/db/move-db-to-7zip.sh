#!/bin/bash
# sudo apt install p7zip-full
# 7z --version

sourceFile="./DB/exported-wp-db.sql"  # Path to the source file
archiveFile="./DB/exported-wp-db.7z"  # Path to the archive file to be created

# Prompt the user for the password
read -s -p "Enter the archive password: " password
echo  # Print an empty line to move to a new line

# Create a 7z archive with the provided password
7z a -t7z -p"$password" "$archiveFile" "$sourceFile"

# Check if the archive file was created successfully
if [ -e "$archiveFile" ]; then
  # If the file was created successfully, delete the original file
  rm -f "$sourceFile"
  echo "Original file deleted, and the archive has been created."
else
  echo "An error occurred while creating the archive."
fi
