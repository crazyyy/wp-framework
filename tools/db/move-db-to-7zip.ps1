$sourceFile = "./DB/exported-wp-sql.sql"  # Path to the source file
$archiveFile = "./DB/exported-wp-sql.7z"  # Path to the archive file to be created

# Prompt the user for the password
$password = Read-Host "Enter the archive password" -AsSecureString

# Convert the secure string password to plain text
$passwordPlainText = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($password))

# Check if the archive file exists and delete it if it does
if (Test-Path -Path $archiveFile) {
  Remove-Item -Path $archiveFile -Force
}

# Create a 7z archive with the provided password
7z a -t7z -p"$passwordPlainText" $archiveFile $sourceFile

# Check if the archive file was created successfully
if (Test-Path -Path $archiveFile) {
  # If the file was created successfully, delete the original file
  Remove-Item -Path $sourceFile -Force
  Write-Host "Original file deleted, and the archive has been created."
} else {
  Write-Host "An error occurred while creating the archive."
}
