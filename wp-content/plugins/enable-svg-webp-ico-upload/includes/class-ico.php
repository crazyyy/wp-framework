<?php
class ITC_SVG_Upload_Ico{

    public function upload_ico_files( $types, $file, $filename, $mimes ) {
        if ( false !== strpos( $filename, '.ico' ) ) {
            $types['ext'] = 'ico';
            $types['type'] = 'image/ico';
        }
    
        return $types;
    } 

    public function ico_files( $mimes ) {
        $mimes['ico'] = 'image/ico';
    
      return $mimes;
    }
}