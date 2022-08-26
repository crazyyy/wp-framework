<?php
if (!defined('ABSPATH')) {
     exit();
}
/**
 * read file content
 * 
 * @param type $fileName
 * @return boolean
 */
function debug_file_read($fileName) {
    $filePath = get_home_path() . $fileName;
    if (file_exists($filePath)) {
        $file = fopen($filePath, "r");
        $responce = '';
        fseek($file, -1048576, SEEK_END);
        while (!feof($file)) {
            $responce .= fgets($file);
        }

        fclose($file);
        return $responce;
    }
    return false;
}

/**
 * write file content
 * 
 * @param type $content
 * @param type $fileName
 * @return type
 */
function debug_file_write($content, $fileName) {
    $output = error_log('/*test*/', '3', get_home_path() . $fileName);
    if ($output) {
        unlink(get_home_path() . $fileName);
        error_log($content, '3', get_home_path() . $fileName);
        chmod(get_home_path() . $fileName, 0600);
    }
    return $output;
}

/**
 * unlink debug.log file
 * 
 * @return type
 */
function debug_clearlog() {
    $filePath = get_home_path() . 'wp-content/debug.log';
    $result['class'] = 'error';
    $result['message'] = __('File debug.log not Removed.', 'debug');
    if (file_exists($filePath)) {
        $status = unlink($filePath);
        if ($status) {
            $result['class'] = 'updated';
            $result['message'] = __('debug.log file Remove successfully.', 'debug');
        }
    }
    return $result;
}

/**
 * save debug setting from UI
 */
function debug_save_setting() {
    if (isset($_POST['debugsetting']) && !empty($_POST['debugsetting'])) {
        $is_update = 1;
        $enable_notification = isset($_POST['enable_notification']) ? trim($_POST['enable_notification']) : '0';
        $email_notification = isset($_POST['email_notification']) ? trim($_POST['email_notification']) : '';
        $error_reporting = isset($_POST['error_reporting']) ? trim($_POST['error_reporting']) : '0';
        $error_log = isset($_POST['error_log']) ? trim($_POST['error_log']) : '0';
        $display_error = isset($_POST['display_error']) ? trim($_POST['display_error']) : '0';
        $error_script = isset($_POST['error_script']) ? trim($_POST['error_script']) : '0';
        $error_savequery = isset($_POST['error_savequery']) ? trim($_POST['error_savequery']) : '0';
        if ($enable_notification == '1') {
            $error_reporting = $error_log = $error_script = $error_savequery = '1';
            if (!is_email($email_notification)) {
                $is_update = 0;
            }
        }
        $fileName = 'wp-config.php';
        $fileContent = debug_file_read($fileName);
        $fileContent = debug_add_option($error_reporting, 'WP_DEBUG', $fileContent);
        $fileContent = debug_add_option($error_log, 'WP_DEBUG_LOG', $fileContent);
        $fileContent = debug_add_option($display_error, 'WP_DEBUG_DISPLAY', $fileContent);
        $fileContent = debug_add_option($error_script, 'SCRIPT_DEBUG', $fileContent);
        $fileContent = debug_add_option($error_savequery, 'SAVEQUERIES', $fileContent);

        if (debug_file_write($fileContent, $fileName)) {
            update_option('debug_notification', array('enable' => $enable_notification, 'email' => $email_notification));
            ?>
            <script>
                window.location = '<?php echo admin_url('admin.php?page=' . trim($_GET['page']) . '&update=' . $is_update); ?>';
            </script>
            <?php
        } else {
            echo '<div class="error settings-error">';
            echo '<p><strong>' . __('Your wp-config file not updated. Copy and paste following code in your wp-config.php file.', 'debug') . '</strong></p>';
            echo '</div>';
            echo '<textarea style="width:100%; height:400px">' . htmlentities($fileContent) . '</textarea>';
        }
    } elseif (isset($_GET['update']) && $_GET['page'] == 'debug_settings') {
        $output['status'] = 'updated';
        $output['message'] = 'setting saved successfully.';
        if ($_GET['update'] == 0) {
            $output['status'] = 'error';
            $output['message'] = 'Please enter Email Address.';
        }
        ?>
        <div class="<?php echo $output['status']; ?> settings-error"> 
            <p><strong><?php _e($output['message'], 'debug'); ?></strong></p>
        </div>
        <?php
    }
}

/**
 * modify content of wp-config.php file and add debug variable
 * 
 * @param type $option
 * @param type $define
 * @param type $fileContent
 * @return type
 */
function debug_add_option($option, $define, $fileContent) {
    if ($option == 1) {
        $fileContent = str_replace(array("define('" . $define . "', true);", "define('" . $define . "', false);"), "define('" . $define . "', true);", $fileContent, $count);
        if ($count == 0) {
            $fileContent = str_replace('$table_prefix', "define('" . $define . "', true);" . "\r\n" . '$table_prefix', $fileContent);
        }
    } else {
        $fileContent = str_replace(array("define('" . $define . "', true);", "define('" . $define . "', false);"), "define('" . $define . "', false);", $fileContent);
    }
    return $fileContent;
}

/**
 * Add thank you link on admin pages
 */
function debug_footer_link() {
    $text = '<div class="alignright">' . __('Thank you for Debugging your wordpress with ', 'debug') . '<a href="http://www.soninow.com" target="_blank">SoniNow</a></div>';
    ?>
    <script>
        jQuery(document).ready(function () {
            debug_options_setting();
            jQuery('#footer-thankyou').html('<?php echo $text; ?>');
            jQuery('#footer-upgrade').html('Current Version <?php echo DEBUG_PLUGIN_VERSION; ?>');
            if (typeof jQuery('#debug-log')[0] != 'undefined') {
                jQuery('#debug-log').animate({scrollTop: jQuery('#debug-log')[0].scrollHeight}, 800);
            }
            jQuery('#enable_notification').click(function () {
                debug_options_setting()
            });
        });
        function debug_options_setting() {
            if (jQuery('#enable_notification').is(':checked')) {
                jQuery('.emailnotification').show();
                jQuery('.noemailnotification').hide();
            } else {
                jQuery('.emailnotification').hide();
                jQuery('.noemailnotification').show();
            }
        }
    </script>
    <?php
}

/**
 * 
 * @param type $path
 * 
 * Allow a file to download
 */
function debug_file_download($path) {
    $content = debug_file_read($path);
    header('Content-type: application/octet-stream', true);
    header('Content-Disposition: attachment; filename="' . basename($path) . '"', true);
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $content;
    exit();
}

/**
 * Allow to download debug.log file for make report.
 */
function debug_downloadlog() {
    if(is_super_admin()){
        debug_file_download('wp-content/debug.log');
    }
}

/**
 * Allow to download wp-config file for backup.
 */
function debug_downloadconfig() {
    if(is_super_admin()){
        debug_file_download('wp-config.php');
    }
}

/**
 * 
 * @return type
 */
function debug_get_options() {
    return get_option('debug_notification');
}

/**
 * 
 * @param type $array
 * @return string
 */
function debug_create_table_format($array) {
    if (is_array($array) && count($array) > 0) {
        $errorContent = "<table border = 1><tr><td>";
        foreach ($array as $key => $val) {
            $errorContent .= $key . "</td><td>";
            if (is_array($val) && count($val) > 0) {
                $errorContent .= debug_create_table_format(json_decode(json_encode($val), true));
            } else {
                $errorContent .= print_r($val, true);
            }
        }
        $errorContent .= "</td></tr></table>";
        return $errorContent;
    }
    return '';
}

/**
 * 
 * @param type $errorNumber
 * @param type $errorString
 * @param type $errorFile
 * @param type $errorLine
 * @param type $errorContext
 */
function debug_error_handler($errorNumber, $errorString, $errorFile, $errorLine, $errorContext) {
    $debug_setting = debug_get_options();

    $emailMessage = '<h2>' . __('Error Reporting on', 'debug') . ' :- </h2>[' . date("Y-m-d h:i:s", time()) . ']<br>';
    $emailMessage .= '<h2>' . __('Error Number', 'debug') . ' :- </h2>' . print_r($errorNumber, true) . '<br>';
    $emailMessage .= '<h2>' . __('Error String', 'debug') . ' :- </h2>' . print_r($errorString, true) . '<br>';
    $emailMessage .= '<h2>' . __('Error File', 'debug') . ' :- </h2>' . print_r($errorFile, true) . '<br>';
    $emailMessage .= '<h2>' . __('Error Line', 'debug') . ' :- </h2>' . print_r($errorLine, true) . '<br>';
    $emailMessage .= '<h2>' . __('Error Context', 'debug') . ' :- </h2>' . debug_create_table_format($errorContext);

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    wp_mail($debug_setting['email'], 'Error Reporting from <b>' . get_bloginfo('name') . '</b> with the help of <a href="http://www.soninow.com" target=_blank">www.soninow.com</a>', $emailMessage, $headers);
}
