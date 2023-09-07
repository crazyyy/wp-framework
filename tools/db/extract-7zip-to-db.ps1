# Prompt the user for the archive password
$password = Read-Host -Prompt "Enter the archive password" -AsSecureString
$passwordPlainText = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($password))

$archiveFile = "./DB/exported-wp-sql.7z"  # Path to the archive file
$outputDir = "./DB"  # Directory where files will be extracted

# Check if the archive file exists
if (Test-Path -Path $archiveFile -PathType Leaf) {
  # Extract the archive with the provided password
  7z x $archiveFile -p"$passwordPlainText" -o"$outputDir"

  if ($LASTEXITCODE -eq 0) {
    Write-Host "Archive successfully extracted to $outputDir."
  } else {
    Write-Host "Error: Failed to extract the archive. Please check the password."
  }
} else {
  Write-Host "Error: Archive file not found."
}
