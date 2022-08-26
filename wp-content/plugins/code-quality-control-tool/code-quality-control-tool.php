<?php
/*
Plugin Name: Code Quality Control Tool
Description: Trace all PHP error types. Creates logs file. Useful for PHP code analytics. 
Version: 0.1
Author: GoodCodeTeam
License: GPLv2
*/ 


if( is_admin() ) 
{
	add_action( 'admin_init', 'cqctphp_admin_init' );
	function cqctphp_admin_init()
	{
		wp_register_style( 'cqctphp_Load_CSS', plugins_url('css/style.css', __FILE__) );	
	}
    
    wp_enqueue_style( 'cqctphp_Load_CSS' );

    
    
    
    add_action( 'admin_bar_menu', 'cqctphp_frontend_shortcut', 95 );
	
	function cqctphp_frontend_shortcut()
	{
		global $wp_admin_bar;
		
        $errors_count = PHPCodeControl_general::GetErrorCount();
        
        if ($errors_count > 0) $alert_html = ' <span class="numcirc">'.$errors_count.'</span>';
        else $alert_html = '';
        
		$wp_admin_bar->add_menu( array(
			'id'	=> 'php-code-control-menu',
            'class' => 'dashicons-before dashicons-dashboard',
			'title'	=> 'PHP Code Control'.$alert_html,
			'href'	=> get_admin_url( null, 'options-general.php?page=php-code-control-settings' ),
			'meta'	=> array( 'tabindex' => 0, 'class' => 'code-control-top-toolbar'),
		) );
	}
    

    // Catch log download action
    add_action('init','cqctphp_download_file');
    function cqctphp_download_file()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'download_log' && check_admin_referer( 'cqctphp_save_settings_BF944B' ))
        {
            PHPCodeControl_general::Download_Log_File();
            exit;
        }
    }


    add_action( 'admin_menu', 'cqctphp_register_page_settings' );
    function cqctphp_register_page_settings() 
    {
        add_options_page( 'PHP Code Control', 'PHP Code Control', 'manage_options', 'php-code-control-settings', 'cqctphp_page_settings' );
    }
    
    function cqctphp_page_settings()
    {
        // Add code into wp-config if it was removed manually
        PHPCodeControl_general::Patch_WPconfig_file(true);
        
        $show_message = false;
        $message_text = '';
        $support_link = array("https:","//","www.","safety","bis",".com","/contact/");
        $support_link = implode("", $support_link)."?".get_site_url();
        
        if (isset($_POST['action']) && check_admin_referer( 'cqctphp_save_settings_BF944B' ))
        {
            $action = isset($_POST['action']) ? trim($_POST['action']) : '';
            
            switch ($action)
            {
                case 'clear_log':
                    PHPCodeControl_general::Clear_Log_File();
                    $show_message = true;
                    $message_text = 'Log cleared.';
                    break;
                    
                case 'save_settings':
                    $settings = array(
                        'is_active' => intval($_POST['is_active']),
                        'errortypes' => implode(",", $_POST['errortypes']),
                        'filer_by_ip' => explode("\n", sanitize_textarea_field($_POST['filer_by_ip'])),
                        'logsize' => intval($_POST['logsize']),
                        'object_check' => $_POST['object_check'],
                        'skip_dups' => intval($_POST['skip_dups']),
                    );
                    
                    // Objects to trace
                    if (in_array("ALL", $settings['object_check'])) $settings['object_check'] = array("ALL");
                    $settings['object_check'] = array_values(array_filter($settings['object_check']));
                    if (count($settings['object_check']) == 0) $settings['object_check'] = array("ALL");
                    
                    // Validate entered IP addresses
                    if (count($settings['filer_by_ip']))
                    {
                        $valid_ip_addresses = array();
                        foreach ($settings['filer_by_ip'] as $ip)
                        {
                            $ip = trim($ip);
                            if (filter_var($ip, FILTER_VALIDATE_IP)) $valid_ip_addresses[$ip] = $ip;
                        }
                        
                        $settings['filer_by_ip'] = array_values($valid_ip_addresses);
                    }

                    PHPCodeControl_general::SaveSettings($settings);
                    
                    $show_message = true;
                    $message_text = 'Settings saved.';
                    break;
            }
        }
        
        $settings = PHPCodeControl_general::LoadSettings();
        ?>
        <div class="wrap">
        
        <?php 
        if ($settings['is_active'] == 0) $html_logger_status = '<span class="numcirc">Logger is disabled</span>';
        else $html_logger_status = '<span class="numcirc greennumcirc">Logger is active</span>';
        ?>
        <h1>PHP Code Control <?php echo $html_logger_status; ?></h1>
        
        <?php
        if ($show_message)
        {
            ?>
            <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
            <p><strong><?php echo $message_text; ?></strong></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
            </div>
            <?php
        }
        ?>
        
        <p>Checks the PHP code quality of installed plugins and themes on your server PHP version.</p>
        
        <p>Your PHP version: <b><?php echo phpversion(); ?></b></p>
        <?php
            $errors_count = PHPCodeControl_general::GetErrorCount();
            if ($errors_count > 0) $html_counter = '<span class="numcirc">'.$errors_count.'</span>';
            else $html_counter = $errors_count;
        ?>
        <p>Total detected issues: <b><?php echo $html_counter; ?></b></p>
        <?php
        if ($errors_count > 0)
        {
            ?>
            <p><b>Please note:</b> Errors/Notices/Warnings are there for a reason to inform you that something is not right. Treat them as such and don't just act like they don't exist. At a moment you'll rewrite some code, just a little bit, a weird bug will appear in a specific case. You'll find it later and it could do bad stuff to your application.</p>
            <p>We recomend to contact your developers. If you don't any advanced developers contact <a href="<?php echo $support_link; ?>" target="_blank">SafetyBis.com</a></p>
            <p>
                <a href="<?php echo $support_link; ?>" target="_blank">
    			 <img src="<?php echo plugins_url('images/livechat.png', __FILE__); ?>"/>
    		  </a>
            </p>
            <?php
        }
        ?>

        
        <hr />
        
        <h2>Settings</h2>
        
            <form method="post" action="options-general.php?page=php-code-control-settings">
            
            <table class="form-table" role="presentation">
            <tbody>
            <tr>
            <th scope="row">Error Logger</th>
            <td>
            <select name="is_active">
            	<option <?php if ($settings['is_active'] == 0) echo 'selected="selected"'; ?> value="0">Not active</option>
            	<option <?php if ($settings['is_active'] == 1) echo 'selected="selected"'; ?> value="1">Active</option>
             </select>
            <br>
            </td>
            </tr>


            <tr>
            <th scope="row">Error types to trace</th>
            <td>
            <?php
            $list = 'E_ERROR,E_WARNING,E_PARSE,E_NOTICE,E_CORE_ERROR,E_CORE_WARNING,E_COMPILE_ERROR,E_COMPILE_WARNING,E_USER_ERROR,E_USER_WARNING,E_USER_NOTICE,E_STRICT,E_RECOVERABLE_ERROR,E_DEPRECATED,E_USER_DEPRECATED';
            $list = explode(",", $list);
            
            $selected_list = $settings['errortypes'];
            $selected_list = explode(",", $selected_list);
            
            foreach ($list as $v)
            {
                ?>
                <label for="type_<?php echo $v; ?>">
                <input class="errortypes <?php echo $v; ?>" name="errortypes[]" type="checkbox" id="type_<?php echo $v; ?>" value="<?php echo $v; ?>" <?php if (in_array($v, $selected_list)) echo 'checked="checked"'; ?>>
                PHP error type: <?php echo $v; ?></label>
                <br>
                <?php
            }
            ?>
            <p>
                <a href="javascript:;" onclick="ManageErrorTypes('uncheck')">Uncheck All</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManageErrorTypes('all')">Select All</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManageErrorTypes('error')">Select ERROR only</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManageErrorTypes('warning')">Select WARNING only</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManageErrorTypes('notice')">Select NOTICE only</a>
            </p>
            <p>Error handling is the process of catching errors raised by your program and then taking appropriate action. If you would handle errors properly then it may lead to many unforeseen consequences.</p>
            <p>For more information please read <a href="https://www.php.net/manual/en/errorfunc.constants.php" target="_blank">https://www.php.net/manual/en/errorfunc.constants.php</a></p>
            </td>
            </tr>
            
            <tr>
            <th scope="row">File size of log file (Mb)</th>
            <td>
            <input name="logsize" type="number" step="1" min="0" value="<?php echo $settings['logsize']; ?>" class="small-text"> Mb (0 for unlimited)
            <br>
            </td>
            </tr>
            
            
            <tr>
            <th scope="row">Error Dups</th>
            <td>
            <select name="skip_dups">
            	<option <?php if ($settings['skip_dups'] == 0) echo 'selected="selected"'; ?> value="0">Log all errors</option>
            	<option <?php if ($settings['skip_dups'] == 1) echo 'selected="selected"'; ?> value="1">Log uniq errors only (skip dups)</option>
             </select>
            <br>
            <p>Skip dups - will skip logging if error is already logged before</p>
            </td>
            </tr>
            
            <tr>
            <th scope="row">Filter by IP</th>
            <td>
            <p>
            <textarea name="filer_by_ip" id="filer_by_ip" rows="5" cols="50" class="large-text code"><?php if (isset($settings['filer_by_ip']) && is_array($settings['filer_by_ip'])) echo implode("\n", $settings['filer_by_ip']); ?></textarea>
            </p>
            <p>It will save logs for specific IP addresses only (one IP per row)</p>
            <p>Your current IP is <b><?php echo $_SERVER['REMOTE_ADDR']; ?></b> <a href="javascript:;" onclick="AddMyIP()">[Add to List]</a></p>
            </td>
            
            <tr>
            <th scope="row">Filter by Object</th>
            <td>
            <select name="object_check[]" id="object_check" onchange="ManageThemesPlugins()">
            	<option <?php if (in_array("ALL", $settings['object_check'])) echo 'selected="selected"'; ?> value="ALL">Trace everything (plugins, themes and WordPress core files)</option>
            	<option <?php if (!in_array("ALL", $settings['object_check'])) echo 'selected="selected"'; ?> value="">Trace selected objects only</option>
             </select>
            <br>
            </td>
            </tr>
            
            <tr class="selected_object" <?php if (in_array("ALL", $settings['object_check'])) echo 'style="display:none"'; ?>>
            <th scope="row">Trace WordPress Themes</th>
            <td>
            <?php
            $list = PHPCodeControl_general::Get_List_WP_Themes();

            foreach ($list as $v)
            {
                ?>
                <label for="type_<?php echo $v['theme_slug']; ?>">
                <input class="obj_themes" name="object_check[]" type="checkbox" id="type_<?php echo $v['theme_slug']; ?>" value="<?php echo $v['theme_path']; ?>" <?php if (in_array($v['theme_path'], $settings['object_check'])) echo 'checked="checked"'; ?>>
                <?php echo $v['theme_name'].' ('.$v['theme_slug'].')'; ?></label>
                <br>
                <?php
            }
            ?>
            <p>
                <a href="javascript:;" onclick="ManageThemes('uncheck')">Uncheck All</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManageThemes('all')">Select All</a>
            </p>
            <p>It will save logs for selected themes only</p>
            </td>
            </tr>
            

            <tr class="selected_object" <?php if (in_array("ALL", $settings['object_check'])) echo 'style="display:none"'; ?>>
            <th scope="row">Trace WordPress Plugins</th>
            <td>
            <?php
            $list = PHPCodeControl_general::Get_List_WP_Plugins();
            
            foreach ($list as $v)
            {
                ?>
                <label for="type_<?php echo $v['plugin_slug']; ?>">
                <input class="obj_plugins" name="object_check[]" type="checkbox" id="type_<?php echo $v['plugin_slug']; ?>" value="<?php echo $v['plugin_path']; ?>" <?php if (in_array($v['plugin_path'], $settings['object_check'])) echo 'checked="checked"'; ?>>
                <?php echo $v['plugin_name'].' ('.$v['plugin_slug'].')'; ?></label>
                <br>
                <?php
            }
            ?>
            <p>
                <a href="javascript:;" onclick="ManagePlugins('uncheck')">Uncheck All</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:;" onclick="ManagePlugins('all')">Select All</a>
            </p>
            <p>It will save logs for selected plugins only</p>
            </td>
            </tr>
            
            
            
            </tbody>
            </table>
            
            <script>
            function AddMyIP()
            {
                var v = jQuery("#filer_by_ip").val();
                var sep = "";
                if (v != "") sep = "\n";
                jQuery("#filer_by_ip").val(v + sep + "<?php echo $_SERVER['REMOTE_ADDR']; ?>");
            }
            
            function ManageErrorTypes(t)
            {
                if (t == 'uncheck') {jQuery(".errortypes").prop( "checked", false );}
                if (t == 'all') {jQuery(".errortypes").prop( "checked", true );}
                if (t == 'error') {jQuery(".errortypes").prop( "checked", false ); jQuery(".E_ERROR,.E_PARSE,.E_CORE_ERROR,.E_COMPILE_ERROR,.E_USER_ERROR,.E_STRICT,.E_RECOVERABLE_ERROR").prop( "checked", true );}
                if (t == 'warning') {jQuery(".errortypes").prop( "checked", false ); jQuery(".E_WARNING,.E_CORE_WARNING,.E_COMPILE_WARNING,.E_USER_WARNING").prop( "checked", true );}
                if (t == 'notice') {jQuery(".errortypes").prop( "checked", false ); jQuery(".E_NOTICE,.E_USER_NOTICE").prop( "checked", true );}
            }
            
            function ManageThemesPlugins()
            {
                var v = jQuery("#object_check").val();
                
                if (v == 'ALL')
                {
                    ManageThemes('uncheck');
                    ManagePlugins('uncheck');
                    jQuery(".selected_object").hide();
                }
                else {
                    ManageThemes('all');
                    ManagePlugins('all');
                    jQuery(".selected_object").show();
                }
            }
            
            function ManageThemes(t)
            {
                if (t == 'uncheck') {jQuery(".obj_themes").prop( "checked", false );}
                if (t == 'all') {jQuery(".obj_themes").prop( "checked", true );}
            }
            
            function ManagePlugins(t)
            {
                if (t == 'uncheck') {jQuery(".obj_plugins").prop( "checked", false );}
                if (t == 'all') {jQuery(".obj_plugins").prop( "checked", true );}
            }
            </script>
            
            
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings"></p>
            
            <input type="hidden" name="action" value="save_settings">

            <?php
            wp_nonce_field( 'cqctphp_save_settings_BF944B' );
            ?>
            
            </form>
            
            
        <hr />
            
        <h2>Logs actions</h2>
        
        <?php
        $log_file_info = PHPCodeControl_general::GetLogFileInfo();
        
        if ($log_file_info['filesize'] == 0)
        {
            $is_disabled = true;
            $html_label = '';
        }
        else {
            $is_disabled = false;
            $html_label = ' ('.$log_file_info['filesize_mb'].' Mb)';
        }
        ?>
        
        <a href="javascript:;" <?php if (!$is_disabled) echo 'onclick="FormActions(\'download_log\');"'; ?> class="button action" <?php if ($is_disabled) echo 'disabled="disabled"'; ?>>Download Log<?php echo $html_label; ?></a>
        <a href="javascript:;" <?php if (!$is_disabled) echo 'onclick="FormActions(\'clear_log\');"'; ?> class="button action" <?php if ($is_disabled) echo 'disabled="disabled"'; ?>>Clear Log</a>
        
        <script>
        function FormActions(v)
        {
            jQuery('#action_value').val(v);
            jQuery('#FormActions').submit();
        }
        </script>
            <form method="post" id="FormActions" action="options-general.php?page=php-code-control-settings">
            
            <input type="hidden" name="action" id="action_value" value="">

            <?php
            wp_nonce_field( 'cqctphp_save_settings_BF944B' );
            ?>
            
            </form>
        
        <h3>Latest 100 lines of log file</h3>
        
        <?php
        $log_file = PHPCodeControl_general::GetLogFile();
        if (file_exists($log_file)) 
        {
            $lines = file($log_file);
            if ($lines === false) $lines = array();
        }
        else $lines = array();
        
        
        $total_lines = count($lines);
        
        if ($total_lines > 0)
        {
            if ($total_lines > 100)
            {
                ?>
                <p>If you need to see all <?php echo $total_lines; ?> lines of log, please download the log file.</p>
                <?php
            }
            ?>
            <table class="wp-list-table widefat striped">
            <thead>
                <th><span>Date / IP</span></th>
                <th><span>Type / Line</span></th>
                <th><span>Message / File / URL</span></th>
            </thead>
            
            <tbody id="the-list">
            
            <?php
            $lines = array_reverse($lines);
            $i = 100;
            if (count($lines))
            {
                foreach ($lines as $line)
                {
                    $line = explode("| ", $line);
                    ?>
                    <tr>
                        <td><?php echo $line[0]."<br>".$line[1]; ?></td>
                        <td><?php echo $line[2]."<br>".$line[5]; ?></td>
                        <td><?php echo $line[3]."<br>".$line[4]."<br>".$line[6]; ?></td>
                    </tr>
                    <?php
                    $i--;
                    if ($i == 0) break;
                }
            }
            ?>
            
            </tbody>
            </table>
            
            <?php
        }
        else {
            ?>
            <p>Log file is empty</p>
            <?php
        }
        ?>

        <?php
        
    }
    















    register_uninstall_hook(__FILE__, 'cqctphp_delete_plugin');
	function cqctphp_delete_plugin()
	{
	    // Delete old log file 
	    $log_file = WP_CONTENT_DIR.'/_php_errors.log';
        if (file_exists($log_file)) unlink($log_file);

	}


	function cqctphp_plugin_activation()
	{
	    // Create default settings
        PHPCodeControl_general::SaveSettings();
        
        // Add code into wp-config.php
        PHPCodeControl_general::Patch_WPconfig_file(true);
        
        add_option('cqctphp_activation_redirect', true);
	}
	register_activation_hook( __FILE__, 'cqctphp_plugin_activation' );
    
	
	function cqctphp_plugin_deactivation() 
    {
        // Remove code from wp-config.php
        PHPCodeControl_general::Patch_WPconfig_file(false);
	}
    register_deactivation_hook( __FILE__, 'cqctphp_plugin_deactivation');
    
    function cqctphp_activation_do_redirect() 
    {
		if (get_option('cqctphp_activation_redirect', false)) 
        {
			delete_option('cqctphp_activation_redirect');
            wp_redirect("options-general.php?page=php-code-control-settings");
            exit;
		}
	}
    add_action('admin_init', 'cqctphp_activation_do_redirect');   
}







class PHPCodeControl_general {
          
    public static function Clear_Log_File()
    {
        $log_file = self::GetLogFile();
        
        if (file_exists($log_file)) unlink($log_file);
        
        $log_counter_file = self::GetErrorCounterFile();
        
        if (file_exists($log_counter_file)) unlink($log_counter_file);
    }

    public static function Download_Log_File()
    {
        $log_file = self::GetLogFile();
        
        if (file_exists($log_file))
        {
            $name = '_php_errors_'.time().'.log';
            $type = 'text/plain';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Transfer-Encoding: binary');
            header('Content-Disposition: attachment; filename="'.$name.'";');
            header('Content-Type: ' . $type);
            header('Content-Length: ' . filesize($log_file));
            
            ob_clean();
            flush();
            @readfile($log_file);
            exit;
        }
    }
    
    
    public static function GetErrorCount()
    {
        $counter_file = self::GetErrorCounterFile();
        
        if (file_exists($counter_file)) $counter = filesize($counter_file);
        else $counter = 0;
        
        return $counter;
    }
    
    public static function GetLogFile()
    {
        return WP_CONTENT_DIR.'/_php_errors.log';
    }
    
    public static function GetErrorCounterFile()
    {
        return WP_CONTENT_DIR.'/_php_errors.count.log';
    }
    
    public static function GetSettingsFile()
    {
        return WP_CONTENT_DIR.'/_php_code_control.ini';
    }
    
    public static function GetLogFileInfo()
    {
        $log_file = self::GetLogFile();
        
        if (file_exists($log_file)) $log_filesize = filesize($log_file);
        else $log_filesize = 0;
        
        $log_filesize_mb = round($log_filesize / 1024 / 1024, 2);
        
        $a = array(
            'file' => $log_file,
            'filesize' => $log_filesize,
            'filesize_mb' => $log_filesize_mb,
        );
        
        return $a;
    }
    
    public static function SaveSettings($settings = array())
    {
        $blank_settings = array(
            'is_active' => 1,
            'errortypes' => 'E_ERROR,E_WARNING,E_PARSE,E_NOTICE,E_CORE_ERROR,E_CORE_WARNING,E_COMPILE_ERROR,E_COMPILE_WARNING,E_USER_ERROR,E_USER_WARNING,E_USER_NOTICE,E_STRICT,E_RECOVERABLE_ERROR,E_DEPRECATED,E_USER_DEPRECATED',
            'filer_by_ip' => array(),
            'logsize' => 1,
            'object_check' => array('ALL'),
            'skip_dups' => 0,
        );
        
        foreach ($settings as $k => $v)
        {
            $blank_settings[$k] = $v;
        }

        $fp = fopen(self::GetSettingsFile(), 'w');
        fwrite($fp, self::build_ini_string($blank_settings) );
        fclose($fp);
    }
    
    public static function LoadSettings()
    {
        $settings_file = self::GetSettingsFile();
        if (!file_exists($settings_file)) self::SaveSettings();
        
        $settings = parse_ini_file(self::GetSettingsFile());
        if (!isset($settings['object_check']) || !is_array($settings['object_check'])) $settings['object_check'] = array("ALL");
        
        return $settings;
    }


    public static function build_ini_string(array $a) 
    {
        $out = '';
        $sectionless = '';
        foreach($a as $rootkey => $rootvalue){
            if(is_array($rootvalue)){
                // find out if the root-level item is an indexed or associative array
                $indexed_root = array_keys($rootvalue) == range(0, count($rootvalue) - 1);
                // associative arrays at the root level have a section heading
                if(!$indexed_root) $out .= PHP_EOL."[$rootkey]".PHP_EOL;
                // loop through items under a section heading
                foreach($rootvalue as $key => $value){
                    if(is_array($value)){
                        // indexed arrays under a section heading will have their key omitted
                        $indexed_item = array_keys($value) == range(0, count($value) - 1);
                        foreach($value as $subkey=>$subvalue){
                            // omit subkey for indexed arrays
                            if($indexed_item) $subkey = "";
                            // add this line under the section heading
                            $out .= "{$key}[$subkey] = $subvalue" . PHP_EOL;
                        }
                    }else{
                        if($indexed_root){
                            // root level indexed array becomes sectionless
                            $sectionless .= "{$rootkey}[]=\"$value\"" . PHP_EOL;
                        }else{
                            // plain values within root level sections
                            $out .= "$key=\"$value\"" . PHP_EOL;
                        }
                    }
                }
    
            }else{
                // root level sectionless values
                $sectionless .= "$rootkey = $rootvalue" . PHP_EOL;
            }
        }
        return $sectionless.$out;
    }



	public static function Patch_WPconfig_file($action = true)   // true - insert, false - remove
	{
	    if (!defined('DIRSEP'))
        {
    	    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') define('DIRSEP', '\\');
    		else define('DIRSEP', '/');
        }
        
		$file = dirname(__FILE__).DIRSEP."error_logger.php";

        $integration_code = '<?php /* PHP Code Control A8E15CA27213-START */if(file_exists("'.$file.'"))include_once("'.$file.'");/* PHP Code Control A8E15CA27213-END */?>';
        
        // Insert code
		if (!defined('ABSPATH') || strlen(ABSPATH) < 8) 
		{
			$root_path = dirname(dirname(dirname(dirname(__FILE__))));
		}
        else $root_path = ABSPATH;
        
        $filename = $root_path.DIRSEP.'wp-config.php';
        $handle = fopen($filename, "r");
        if ($handle === false) return false;
        $contents = fread($handle, filesize($filename));
        if ($contents === false) return false;
        fclose($handle);
        
        $pos_code = stripos($contents, $integration_code);
        
        if ($action === false)
        {
            // Remove block
            $contents = str_replace($integration_code, "", $contents);
        }
        else {
            // Insert block
            if ( $pos_code !== false/* && $pos_code == 0*/)
            {
                // Skip double code injection
                return true;
            }
            else {
                // Insert
                $contents = $integration_code.$contents;
            }
        }
        
        $handle = fopen($filename, 'w');
        if ($handle === false) 
        {
            // 2nd try , change file permssion to 666
            $status = chmod($filename, 0666);
            if ($status === false) return false;
            
            $handle = fopen($filename, 'w');
            if ($handle === false) return false;
        }
        
        $status = fwrite($handle, $contents);
        if ($status === false) return false;
        fclose($handle);

        
        return true;
	}
    
    
    public static function Get_List_WP_Themes()
    {
        $result = array();
        
        $themes = wp_get_themes();
        foreach ($themes as $theme_slug => $theme_block)
        {
            $theme_info = wp_get_theme($theme_slug);
            
            $result[] = array(
                'theme_name' => $theme_info->get('Name'),
                'theme_path' => str_replace(ABSPATH, "", $theme_info->theme_root.'/'.$theme_slug),
                'theme_slug' => $theme_slug,
            );
        }
        
        return $result;
    }
    
    
    public static function Get_List_WP_Plugins()
    {
        $result = array();
        
        $plugins = get_plugins();
        foreach ($plugins as $plugin_file => $plugin_block)
        {
            $result[] = array(
                'plugin_name' => $plugin_block['Name'],
                'plugin_path' => str_replace(ABSPATH, "", WP_CONTENT_DIR.'/plugins/'.dirname($plugin_file)),
                'plugin_slug' => dirname($plugin_file),
            );
        }
        
        return $result;
    }
}