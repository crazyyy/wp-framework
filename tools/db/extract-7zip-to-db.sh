

#!/bin/bash

archiveFile="./DB/exported-wp-sql.7z"  # Path to the archive file
outputDir="./DB"  # Directory where files will be extracted

# Prompt the user for the archive password
read -s -p "Enter the archive password: " password
echo  # Move to a new line after entering the password

# Check if the archive file exists
if [ -e "$archiveFile" ]; then
  # Extract the archive with the provided password
  7z x -p$password -o"$outputDir" "$archiveFile"

  if [ $? -eq 0 ]; then
    echo "Archive successfully extracted to $outputDir."
  else
    echo "Error: Failed to extract the archive. Please check the password."
  fi
else
  echo "Error: Archive file not found."
fi
