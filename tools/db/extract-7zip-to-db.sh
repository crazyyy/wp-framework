#!/bin/bash
# sudo apt install p7zip-full
# 7z --version

# Prompt the user for the archive password
read -s -p "Enter the archive password: " password
echo  # Print an empty line to move to a new line

archiveFile="./DB/exported-wp-db.7z"  # Path to the archive file
outputDir="./DB"  # Directory where files will be extracted

# Check if the archive file exists
if [ -e "$archiveFile" ]; then
  # Extract the archive with the provided password
  7z x "$archiveFile" -p"$password" -o"$outputDir"

  # Check if the extraction was successful
  if [ $? -eq 0 ]; then
    echo "Archive successfully extracted to $outputDir."
  else
    echo "Error: Failed to extract the archive. Please check the password."
  fi
else
  echo "Error: Archive file not found."
fi
