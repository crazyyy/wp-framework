#!/bin/bash

# Change to the directory containing your Git repository
cd /home/vinwolves.org/public_html

# Add all changes to the repository
git add .

# Commit the changes with the current date and time
commit_message="backup $(date +%Y-%m-%d-%H%M)"
git commit -m "$commit_message"

# Push the changes to the remote repository
git push
