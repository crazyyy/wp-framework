<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('sd_log')) {
    function sd_log($text, String $fileName = 'sd_log')
    {
        $myFile = SDLOG_PLUGIN_PATH . "log/$fileName.log";
        $fh = fopen($myFile, 'a') or wp_die("can't open file");
        
        $datetime = date('Y-m-d H:i:s', strtotime(current_time('mysql')));

        if (is_array($text) || is_object($text)) {
            fwrite($fh, "\n[$datetime]: ".print_r($text, true));
        } else {
            fwrite($fh, "\n[$datetime]: $text");
        }

        fclose($fh);
    }
}
