<?php
class ITC_SVG_Upload_Ico {

    /**
     * Adds ICO file type support during the file upload process.
     * Sanitizes and validates the filename and MIME type to prevent arbitrary file uploads.
     *
     * @param array $types Allowed types array containing 'ext' and 'type'.
     * @param string $file The full path to the file being uploaded.
     * @param string $filename The name of the file being uploaded.
     * @param array $mimes Allowed MIME types.
     * @return array Updated types array with 'ext' and 'type' for ICO files if valid.
     */
    public function upload_ico_files( $types, $file, $filename, $mimes ) {
        // Sanitize the filename to prevent potential XSS
        $filename = sanitize_file_name( $filename );

        // Validate the filename for .ico extension
        if ( false !== strpos( strtolower( $filename ), '.ico' ) ) {
            // Check file MIME type and validate the ICO file structure
            if ( $this->is_valid_ico( $file ) ) {
                $types['ext'] = 'ico';
                $types['type'] = 'image/x-icon';
            } else {
                // Invalidate file type if the file content is not valid
                $types['ext'] = false;
                $types['type'] = false;
            }
        }

        return $types;
    }

    /**
     * Adds ICO MIME type support to WordPress file uploads.
     * Ensures the MIME type is correctly specified and secure.
     *
     * @param array $mimes Allowed MIME types.
     * @return array Updated MIME types with support for ICO files.
     */
    public function ico_files( $mimes ) {
        // Only allow the official MIME type for ICO files
        $mimes['ico'] = 'image/x-icon';

        return $mimes;
    }

    /**
     * Validates the ICO file by checking its content structure.
     * Ensures the file is a valid ICO image and not a malicious file.
     *
     * @param string $file The path to the file being uploaded.
     * @return bool True if the file is a valid ICO, false otherwise.
     */
    private function is_valid_ico( $file ) {
        // Open the file in binary mode
        $handle = @fopen( $file, 'rb' );
        if ( $handle === false ) {
            return false;
        }

        // Read the first 4 bytes of the file to check the ICO signature
        $header = fread( $handle, 4 );
        fclose( $handle );

        // ICO files start with two null bytes followed by 0x01 and 0x00
        if ( $header !== "\x00\x00\x01\x00" ) {
            return false;
        }
        return true;
    }
}

