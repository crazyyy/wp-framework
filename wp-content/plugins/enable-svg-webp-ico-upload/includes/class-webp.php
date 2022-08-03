<?php
class ITC_SVG_Upload_Webp{

    /*This allows to upload webp files */
    function webp_file_ext( $types, $file, $filename, $mimes ) {
        if ( false !== strpos( $filename, '.webp' ) ) {
            $types['ext'] = 'webp';
            $types['type'] = 'image/webp';
        }
        return $types;
    }

    function webp_file_upload( $mimes ) {
        $mimes['webp'] = 'image/webp';
      return $mimes;
    }

    /*Preview Webp files */
    function preview_webp_thumnail($result, $path) {
        if ($result === false) {
            $displayable_image_types = array( IMAGETYPE_WEBP );
            $info = @getimagesize( $path );

            if (empty($info)) {
                $result = false;
            } elseif (!in_array($info[2], $displayable_image_types)) {
                $result = false;
            } else {
                $result = true;
            }
        }

        return $result;
    }
}