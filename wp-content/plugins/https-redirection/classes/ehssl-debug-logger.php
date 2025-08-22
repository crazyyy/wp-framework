<?php
/**
 * Logs debug data to a file.
 */
class EHSSL_Logger
{
    public static $log_folder_path = EASY_HTTPS_SSL_PATH . '/logs';
    public static $default_log_file = 'log.txt';
    public static $debug_status = array('SUCCESS', 'STATUS', 'NOTICE', 'WARNING', 'FAILURE', 'CRITICAL');
    public static $section_break_marker = "\n----------------------------------------------------------\n\n";
    public static $log_reset_marker = "-------- Log File Reset --------\r\n";

    /**
     * Checks whether debug logging is enabled or not.
     *
     * @return boolean
     */
    public static function is_logging_enabled()
    {
        global $httpsrdrctn_options;

        $enable_debug_logging = isset($httpsrdrctn_options['enable_debug_logging']) ? esc_attr($httpsrdrctn_options['enable_debug_logging']) : 0;

        return $enable_debug_logging == '1';
    }

    /**
     * Generates a unique suffix for filename.
     *
     * @return string File name suffix.
     */
    public static function get_log_file_suffix()
    {
        global $httpsrdrctn_options;

        $suffix = isset($httpsrdrctn_options['ehssl_logfile_suffix']) ? esc_attr($httpsrdrctn_options['ehssl_logfile_suffix']) : '';
        if (!empty($suffix)) {
            return $suffix;
        }

        $suffix = uniqid();
        $httpsrdrctn_options['ehssl_logfile_suffix'] = $suffix;
        update_option('httpsrdrctn_options', $httpsrdrctn_options);

        return $suffix;
    }

    /**
     * Get the log file with a unique name.
     *
     * @return string Log file name.
     */
    public static function get_log_file_name()
    {
        return 'log-' . self::get_log_file_suffix() . '.txt';
    }

    /**
     * Get the log filename with absolute path.
     *
     * @return string Debug log file.
     */
    public static function get_log_file()
    {
        return self::$log_folder_path . '/' . self::get_log_file_name();
    }

    public static function get_debug_timestamp()
    {
        return '[' . gmdate( 'm/d/Y h:i:s A' ) . ']';
    }

    public static function get_debug_status($level)
    {
        $size = count(self::$debug_status);
        if ($level >= $size) {
            return 'UNKNOWN';
        } else {
            return self::$debug_status[$level];
        }
    }

    public static function get_section_break($section_break)
    {
        if ($section_break) {
            return self::$section_break_marker;
        }
        return "";
    }

    public static function write_to_file($content, $file_name, $overwrite = false)
    {
        if (empty($file_name)) {
            $file_name = self::$default_log_file;
        }

        $debug_log_file = self::$log_folder_path . '/' . $file_name;

        //Write to the log file
        if (!file_put_contents($debug_log_file, $content . "\r\n", ( ! $overwrite ? FILE_APPEND : 0))) {
            return false;
        }
        return true;
    }

    public static function reset_log_file($file_name = '')
    {
        if (empty($file_name)) {
            $file_name = self::$default_log_file;
        }

        $debug_log_file = self::$log_folder_path . '/' . $file_name;
        $content = self::get_debug_timestamp() . ' ' . self::$log_reset_marker;
        $fp = fopen($debug_log_file, 'w');
        fwrite($fp, $content);
        fclose($fp);
    }

    /**
     * Logs the message is a log-<uniqueId>-.txt
     *
     * @param string|array $message Data to write to the log file
     * @param integer $level Specify the log level.
     * @param boolean $section_break Whether to add a line break.
     * @param boolean $overwrite Whether to overwrite the file content.
     * @return boolean True if file write is success, false if not.
     */
    public static function log($message, $level = 0, $section_break = false,  $overwrite = false)
    {
        if (!self::is_logging_enabled()) {
            return;
        }

        $file_name = self::get_log_file_name();

        //Timestamp
        $content = self::get_debug_timestamp();
        //Debug status
        $content .= '[' . self::get_debug_status($level) . ']';
        $content .= ' - ';

        if (is_array($message)) {
            // Print the array content into a string.
            ob_start();
            print_r($message);
            $printed_array = ob_get_contents();
            ob_end_clean();
            $content .= $printed_array;
        }else{
            $content .= $message;
        }

        $content .= self::get_section_break($section_break);
        return self::write_to_file($content, $file_name, $overwrite);
    }
}
