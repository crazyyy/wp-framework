<?php 

    class Nevma_Utils {

        /**
         * Gets a human readable version of a file size. For instance 1024 bytes means 1kb.
         * 
         * @author Nevma (info@nevma.gr)
         * 
         * @param int $size The given file size.
         * 
         * @return string The human readable version of the file size.
         */

        public static function file_size_human ( $size ) {

            $kilo_byte = 1024;
            $mega_byte = 1024 * $kilo_byte;
            $giga_byte = 1024 * $mega_byte;

            if ( $size == 0 ) {

                return '0';

            } else if ( $size < $kilo_byte ) {
                
                return $size . 'b';

            } else if ( $size < $mega_byte ) {

                return round( $size / $kilo_byte, 2 ) . 'kb';
            
            } else if ( $size < $giga_byte ) {

                return round( $size / $mega_byte, 2 ) . 'mb';

            } else {

                return round( $size / $giga_byte, 2 ) . 'gb';

            }
            
        }



        /**
         * Calculates the contents of a directory recursively. Warning: this might be a long process.
         * 
         * @author Nevma (info@nevma.gr)
         * 
         * @param string $dir The directory whose contents to calculate recursively.
         * 
         * @return int The total size of the directory and its children recursively in bytes.
         */

        public static function dir_size ( $dir ) {

            // Keep count of recursively accessed files.

            static $total_files = 0;
            static $total_size  = 0;
            static $total_dirs  = 0;



            // Do not take into acount files and symbolic links.

            if ( is_dir( $dir ) && ! is_link( $dir ) ) {

                $objects = scandir( $dir );

                foreach ( $objects as $object ) {

                    if ( $object != "." && $object != ".." ) {

                        $file = $dir . "/" . $object;

                        if ( filetype( $file ) != "dir" ) { 

                            // Add file size in total.
                            
                            $total_files++;
                            $total_size += filesize( $file );

                        } else {

                            // Descend into directory children.

                            $total_dirs++;
                            self::dir_size( $file );

                        }

                    }
                }

            }



            return array( 'files' => $total_files, 'size' => $total_size, 'dirs' => $total_dirs );

        }

    }
?>