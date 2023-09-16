<?php

    class Nevma_Performance_Profiler_Plugin_DB {

        private static $instance = null;

        private static $table_slug = 'nppp';

        private $table_name;



        public static function get_instance () {

            if ( null == self::$instance ) {

                self::$instance = new self();

            }

            return self::$instance;
            
        }



        public function __construct () {

            global $wpdb;

            $this->table_name = $wpdb->prefix . 'nppp';

        }



        public function get_table_name () {

            return $this->table_name;

        }



        public function create_table () {

            global $wpdb;

            $table = $this->get_table_name();

            $sql = 
                "CREATE TABLE IF NOT EXISTS `" . "$table" . "` (

                    `ID`               int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Uniqueue row ID',
                    `timestamp`        datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when the request finished on the server side',
                    `type`             enum('theme','admin','cron') NOT NULL COMMENT 'Whether the request targeted the frontend, the backend, an AJAX request or a cron job',
                    `ajax`             tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether this was an AJAX request or not',
                    `url`              varchar(2048) NOT NULL COMMENT 'The url which was requested by the client',
                    `method`           enum('get','post') NOT NULL DEFAULT 'get' COMMENT 'Whether the method of the request was a GET or a POST',
                    `loggedIn`         tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the request was made by a logged in user or not',
                    `user`             varchar(255) DEFAULT NULL COMMENT 'The user under whom the request was sent, if there was a user logged in',
                    `referer`          varchar(2048) DEFAULT NULL COMMENT 'The request HTTP referer string',
                    `userAgent`        varchar(2048) DEFAULT NULL COMMENT 'The request user agent string',
                    `duration`         int(11) UNSIGNED DEFAULT NULL COMMENT 'The time the request took on the server',
                    `RAM`              int(11) UNSIGNED DEFAULT NULL COMMENT 'Tha maximum RAM used for the request',
                    `queries`          int(11) UNSIGNED DEFAULT NULL COMMENT 'The number of database queries executed during the request',
                    `timeToFirstByte`  int(11) UNSIGNED DEFAULT NULL COMMENT 'The time until the first byte of the response reached the client',
                    `DOMContentLoaded` int(11) UNSIGNED DEFAULT NULL COMMENT 'The time until the Javascript DOMContentLoaded event',
                    `load`             int(11) UNSIGNED DEFAULT NULL COMMENT 'The time until the Javascript load event',
                    `requests`         int(11) UNSIGNED DEFAULT NULL COMMENT 'The total number of HTTP requests in the client',

                    PRIMARY KEY (`ID`),
                    KEY `type` (`type`),
                    KEY `method` (`method`),
                    KEY `loggedIn` (`loggedIn`)

                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nevma Performance Profiler Plugin';";

            $result = $wpdb->query( $sql );

        }



        public function drop_table () {

            global $wpdb;

            $table = $this->get_table_name();

            $sql = 
                "DROP TABLE  `" . "$table" . "`;";

            $result = $wpdb->query( $sql );

        }



        public function insert_row ( $data=array() ) {

            global $wpdb;

            $wpdb->show_errors();

            $table = $this->get_table_name();

            $result = $wpdb->insert( $table, 
                array( 
                    'type'             => isset( $data['type'] )             ? $data['type']             : NULL,
                    'ajax'             => isset( $data['ajax'] )             ? $data['ajax']             : NULL,
                    'url'              => isset( $data['url'] )              ? $data['url']              : NULL,
                    'method'           => isset( $data['method'] )           ? $data['method']           : NULL,
                    'loggedIn'         => isset( $data['loggedIn'] )         ? $data['loggedIn']         : NULL,
                    'user'             => isset( $data['user'] )             ? $data['user']             : NULL,
                    'referer'          => isset( $data['referer'] )          ? $data['referer']          : NULL,
                    'userAgent'        => isset( $data['userAgent'] )        ? $data['userAgent']        : NULL,
                    'duration'         => isset( $data['duration'] )         ? $data['duration']         : NULL,
                    'RAM'              => isset( $data['RAM'] )              ? $data['RAM']              : NULL,
                    'queries'          => isset( $data['queries'] )          ? $data['queries']          : NULL,
                    'timeToFirstByte'  => isset( $data['timeToFirstByte'] )  ? $data['timeToFirstByte']  : NULL,
                    'DOMContentLoaded' => isset( $data['DOMContentLoaded'] ) ? $data['DOMContentLoaded'] : NULL,
                    'load'             => isset( $data['load'] )             ? $data['load']             : NULL,
                    'requests'         => isset( $data['requests'] )         ? $data['requests']         : NULL
                )
            );

        }



        public function truncate_table () {

            global $wpdb;

            $table = $this->get_table_name();

            $sql = "TRUNCATE TABLE `" . "$table" . "`;";

            return $wpdb->query( $sql );

        }



        public function get_record_count () {

            global $wpdb;

            $sql = "SELECT COUNT(*) FROM " . $this->get_table_name() . ";";

            return $wpdb->get_var( $sql );
          
        }



        public function get_table_size () {

            global $wpdb;

            $sql = "SHOW TABLE STATUS WHERE Name = '" . $this->get_table_name() . "';";

            $row = $wpdb->get_row( $sql, ARRAY_A );

            return Nevma_Utils::file_size_human( $row['Data_length'] + $row['Index_length'] );
          
        }



        public function get_time_window () {

            global $wpdb;

            $sql = "SELECT MAX(`timestamp`) FROM " . $this->get_table_name() . ";";

            $max = $wpdb->get_var( $sql );
          
            $sql = "SELECT MIN(`timestamp`) FROM " . $this->get_table_name() . ";";

            $min = $wpdb->get_var( $sql );

            return array( 'min' => $min, 'max' => $max );
          
        }



        public function get_count_by_type ( $type, $ajax=NULL ) {

            global $wpdb;

            $sql = "SELECT COUNT(*) 
                    FROM `" . $this->get_table_name() . "` 
                    WHERE `type` = %s" . 
                    (
                        isset( $ajax ) ? 
                            " AND `ajax` = " . ( $ajax ? 1 : 0 ) : 
                            ""
                    ) . ";" ;

            return $wpdb->get_var( $wpdb->prepare( $sql, array( $type ) ) );
          
        }



        public function get_count_of_ajax () {

            global $wpdb;

            $sql = "SELECT COUNT(*) 
                    FROM `" . $this->get_table_name() . "` 
                    WHERE `ajax` = 1;";

            return $wpdb->get_var( $sql );
          
        }



        public function get_max_resource_by_type ( $resource, $type, $ajax=NULL ) {

            global $wpdb;

            $sql = "SELECT MAX($resource) 
                    FROM `" . $this->get_table_name() . "` 
                    WHERE `type` = %s"  . 
                    (
                        isset( $ajax ) ? 
                            " AND `ajax` = " . ( $ajax ? 1 : 0 ) : 
                            ""
                    ) . ";";

            return $wpdb->get_var( $wpdb->prepare( $sql, array( $type ) ) );
          
        }



        public function get_average_resource_by_type ( $resource, $type, $ajax=NULL  ) {

            global $wpdb;

            $sql = "SELECT AVG($resource) 
                    FROM `" . $this->get_table_name() . "` 
                    WHERE `type` = %s" . 
                    (
                        isset( $ajax ) ? 
                            " AND `ajax` = " . ( $ajax ? 1 : 0 ) : 
                            ""
                    ) . ";";

            return round( $wpdb->get_var( $wpdb->prepare( $sql, array( $type ) ) ), 1 );
          
        }

    }

?>