<?php
/*
	Plugin Name: Plugin Inspector
	Description: Easy and safe way to check plugin and make sure that it doesn't use deprecated WordPress functions, contain known security vulnerabilities and some unsafe/dangerous PHP functions that may be used to hack the site or to load and execute malicious code (malware). Feel free to send any suggestions via inspector@wpcerber.com.
	Author: Gregory M
    Author URI: http://wpcerber.com
	Version: 1.5
	Text Domain: pluch
	Domain Path: /languages
	Network: true
*/

define('PI_MAX_FILES',15); // per one AJAX request
define('PI_REQ_PHP','5.3.0');
define('PI_REQ_WP','3.3');
define('PI_FILE',__FILE__);
define('WPVULNDB_API_PLUGIN','https://wpvulndb.com/api/v2/plugins/');
define('PI_CAP','activate_plugins');
include_once('unsafe.php');
include_once('wp-deprecated.php');

/*
	Add admin menu
*/
add_action('admin_menu', 'pi_admin_menu');
function pi_admin_menu(){
    add_plugins_page(__('Plugin Inspector','pluch'),'Plugin Inspector',PI_CAP,'plipl', 'pi_main_page');
    add_management_page('Plugin Inspector','Plugin Inspector',PI_CAP,'plitl', 'pi_main_page');
}

function pi_main_page(){
    global $wpdb;
    echo '<div class="wrap">';
    echo '<h1>'.__('Plugin Inspector','pluch').'</h1>';
    $all_plugins = get_plugins();
    if (isset($_GET['check'])) {
        pc_init_scan();
    }
    else {
        pi_show_plugin_list($all_plugins);
    }
    echo '</div>';
}
/*
 * Show all plugins
 */
function pi_show_plugin_list($all_plugins){
    $all_plugins = get_plugins();
    if(!empty($all_plugins)) {
        $list=array();
        foreach($all_plugins as $path => $plugin){
            if (!is_plugin_active($path)) $css='inactive'; else $css='';
            $list[]='<div class="one-plugin '.$css.'"><table width="100%"><tr><td width="80%"><h3>'.$plugin['Name'].'</h3><p>'.$plugin['Description'].'</p></td><td width="20%" style="text-align:center;"><a class="button button-primary" href="'.wp_nonce_url(esc_url_raw(add_query_arg(array('check'=>urlencode($plugin['Name'])))),'control','pi_nonce').'">Check It</a></td></tr></table></div>';
        }
    }
/* // Must use plugins
    $mu_plugins = glob(get_wp_content_dir().'/*.php');
    foreach($mu_plugins as $path){
        $plugin = get_plugin_data($path);
        $list[]='<td width="50%"><h3>'.$plugin['Name'].'</h3><p>'.$plugin['Description'].'</p></td><td><a href="'.wp_nonce_url(add_query_arg(array('scan'=>urlencode($plugin['Name']))),'control','cerber_nonce').'">SCAN</a></td>';
    }
*/
    if(!empty($list)) echo '<div id="plu-list">'.implode('',$list).'</div>';
}

/*
	Start checking selected plugin
*/
function pc_init_scan(){
    global $wpdb;
    //if (!current_user_can(PI_CAP)) return;
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !isset($_GET['pi_nonce']) || !wp_verify_nonce($_GET['pi_nonce'], 'control')) return;
    $all_plugins = get_plugins();
    $name = stripslashes(urldecode($_GET['check']));
    $plugin = null;
    foreach($all_plugins as $path => $item) {
        if($item['Name'] == $name) {
            $plugin = $item;
            break;
        }
    }
    if ($plugin) {
        if (false !== strpos($path,'/')) { // plugin has its own folder?
            $files = glob_recursive(pi_plugins_dir() . '/' . dirname($path) . '/*.php');
            $slug = dirname($path);
        }
        else { // plugin is a one file plugin in the root of plugins folder
            $files = array(pi_plugins_dir().'/'.$path);
            $slug = sanitize_title($name);
        }
        $list = array();
        foreach ($files as $file) {
            $list[]=array($file, pi_shortfilename($file), false, array(), array());
        }
        $option = array('plugin'=>$plugin,'files'=>$list,'time'=>time());
        //update_option('check_it_baby',$option);
        update_option('pi-'.$slug,$option);

        $vul = pc_check_vulndb_file($slug, $plugin);

        $assets_url = plugin_dir_url(__FILE__).'assets/';

        add_thickbox();

        echo '<div class="one-plugin"><h3>Now scanning: '.$plugin['Name'].' v. '.$plugin['Version'].'</h3>';
        echo '<h3>Number of files to scan: '.count($files).'</h3><h3>Files remain: <span id="counter">'.count($files).'</span></h3><input type="checkbox" id="verbose" checked> Verbose output
        <p>You can ignore all Unsafe messages if you trust the author and the source of this plugin.</div>';
        echo '<div id="scanning"><ol id="result"></ol><img id="spinner" src="'.$assets_url.'ajax-loader.gif" /></div><div id="report-wrap"><div id="report">'.$vul.'</div></div><div id="status"></div>';
        //echo '<div id="scanning"><ol id="result"></ol><img id="spinner" src="'.$assets_url.'ajax-loader.gif" /></div>';

        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                window.onbeforeunload = function () {
                    return 'Scanning files in progress';
                }

                function gogogo(server_data){
                    var mill =  $.parseJSON(server_data);
                    if (typeof mill['checked'] === 'undefined') return;
                    if (typeof mill['remain'] !== 'number') return;
                    $.each(mill['checked'], function(index, item){
                        $("#result").append(item);
                    });
                    if (!$("#verbose").prop('checked')){
                        $(".satisfy").addClass('pi-hidden');
                    }
                    $("#counter").html(mill['remain']);
                    if (mill['remain'] > 0) {
                        setTimeout(callInspector, 1500); // safe interval to avoid overload server
                    }
                    else {
                        $('#spinner').remove();
                        window.onbeforeunload = null;
                    }
                }
                function callInspector() {
                    $.post(ajaxurl, {action: 'inspector_ajax', plugin: <?php echo '"'.$slug.'"'; ?>, width:window.innerWidth, height: window.innerHeight }, gogogo);
                }
                // Start scanning
                callInspector();

                $("#verbose").click(function() {
                    if ($(this).prop('checked')){
                        //$(".satisfy").show();
                        $(".satisfy").removeClass('pi-hidden');
                    }
                    else{
                        //$(".satisfy").hide();
                        $(".satisfy").addClass('pi-hidden');
                    }
                });

            });
        </script>
        <?php
    }
}

/*
	AJAX admin requests is landing here
*/
add_action('wp_ajax_inspector_ajax', 'pc_ajax_scan');
function pc_ajax_scan(){
    global $wpdb;
    if (!current_user_can(PI_CAP)) return array();
    //if (!$task = get_option('check_it_baby')) return array();
    $key = 'pi-'.sanitize_title($_POST['plugin']);
    if (!$task = get_option($key)) return array();

    // Popup size
    $width = absint($_POST['width']);
    $width = $width ? absint($width * 0.8): 800;
    $height = absint($_POST['height']);
    $height = $height ? absint($height * 0.8) : 600;

    $files = $task['files'];
    $i = 0;
    $checked = array();
    $ajax_nonce = wp_create_nonce("my-stuff");

    while (!empty($files)){
        $file = $files[0];
        $check_file = pc_check_file($file[0]);
        array_shift($files);
        $class = '';
        $tag = '';
        $view='';
        $info = '';
        if ($check_file === false) $tag='<span class="red_lab">Unable to open file</span>';
        elseif ($check_file['result'] == 'OK') {
            $tag='<span class="green_lab">OK</span>';
            $class='satisfy';
        }
        else{
            $source_lines = array();
            $file_date = pi_date(filemtime($file[0]));
            $file_size = pi_human_filesize(filesize($file[0]));
            $title = 'Viewing: '.$file[1].' &nbsp; [ modified: '.$file_date.' | size: '.$file_size.' ]';
            if (!empty($check_file['wp_deprecated'])) {

                $tag='<span class="red_lab">Deprecated</span>';
                $list = array();
                foreach ($check_file['wp_deprecated'] as $item) {
                    $view_url = esc_url_raw(add_query_arg(array('inspector_nonce'=>$ajax_nonce,'action'=>'inspector_ajax_view','sheight'=>$height,'view_source'=>$file[1],'lines'=>$item['line'],'TB_iframe'=>'true','width'=>$width,'height'=>$height)));
                    $list[] = '<a href="'.$view_url.'" title = "'.$title.'" class="thickbox view-source-block"><span class="fname">'.$item['fname'].'</span> at line '.$item['line'].':<br/><span class="source">'.$item['source'].'</span><br/><span class="pi-notes">'.$item['notes'].'</span></a>';
                    $source_lines[] = $item['line'];
                }
                $info='<p><ul class="wp-deprecated"><li>'.implode('</li><li>',$list).'</li></ul>';
            }
            if (!empty($check_file['unsafe'])) {
                $tag.='<span class="yellow_lab">Unsafe</span>';
                $list = array();
                foreach ($check_file['unsafe'] as $item) {
                    $view_url = esc_url_raw(add_query_arg(array('inspector_nonce'=>$ajax_nonce,'action'=>'inspector_ajax_view','sheight'=>$height,'view_source'=>$file[1],'lines'=>$item['line'],'TB_iframe'=>'true','width'=>$width,'height'=>$height)));
                    $list[] = '<a href="'.$view_url.'" title = "'.$title.'" class="thickbox view-source-block"><span class="fname">'.$item['fname'].'</span> at line '.$item['line'].':<br/><span class="source">'.$item['source'].'</span><br/><span class="pi-notes">'.$item['notes'].'</span></a>';
                    $source_lines[] = $item['line'];
                }
                $info.='<p><ul class="unsafe"><li>'.implode('</li><li>',$list).'</li></ul>';
            }
            // View source button -->
            $source_lines = implode('-',$source_lines);
            // BUG! Important! All GET parameters that placed in the url after TB_iframe will be removed by stupid Thickbox!
            $view_url = esc_url_raw(add_query_arg(array('inspector_nonce'=>$ajax_nonce,'action'=>'inspector_ajax_view','sheight'=>$height,'view_source'=>$file[1],'lines'=>$source_lines,'TB_iframe'=>'true','width'=>$width,'height'=>$height)));
            $view = ' <a href="'.$view_url.'" title = "'.$title.'" class="thickbox view-source gray_lab">view source</a>';
            // <---- View source button
        }
        $checked[]='<li class="'.$class.'">'.$tag.$file[1].$view.$info.'</li>';

        $i++;
        if ($i >= PI_MAX_FILES) break;
    }
    $task['files'] = $files;
    $remain = count($files);
    update_option($key,$task);
    //update_option('check_it_baby',$task);
    echo json_encode(array('remain'=>$remain,'checked'=>$checked));
    wp_die();
}
/*
	Launch cool source code viewer
*/
add_action('wp_ajax_inspector_ajax_view', 'pc_ajax_view_source');
function pc_ajax_view_source(){
    check_ajax_referer('my-stuff','inspector_nonce');
    $file_name = pi_plugins_dir().$_GET['view_source'];
    if (!current_user_can(PI_CAP) || !@is_file($file_name)) {
        wp_die();
    }
    $sh_url = plugin_dir_url(__FILE__).'assets/sh/';
    $sheight = absint($_GET['sheight']) - 40; // highlighter is un-responsible, so we need tell him real height
    $source = htmlspecialchars(@file_get_contents($file_name)); // Load PHP source to view it
    if (strpos($_GET['lines'],'-')) {
        $source_lines = array_map('absint',explode('-',$_GET['lines']));
        $scroll_to = $source_lines[0] - 10;
        $line = ' new Array ('.implode(', ',$source_lines).')';
    }
    else {
        $line = absint($_GET['lines']);
        $scroll_to = $line - 10;
    }
    ?>
    <!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <script type="text/javascript" src="<?php echo $sh_url ?>scripts/shCore.js"></script>
    <script type="text/javascript" src="<?php echo $sh_url; ?>scripts/shBrushPhp.js"></script>
    <link href="<?php echo $sh_url; ?>styles/shCore.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $sh_url; ?>styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
    <style type="text/css" media="all">
        .syntaxhighlighter{
            max-height: <?php echo $sheight; ?>px;
        }
    </style>
    </head>

    <body>
    <pre class="brush: php; toolbar: false;"><?php echo $source; ?></pre>

    <script type="text/javascript">
        SyntaxHighlighter.defaults["highlight"] = <?php echo $line; ?>
        //SyntaxHighlighter.defaults["first-line"] = '.$line.';
        SyntaxHighlighter.all();
        function waitUntilRender(){
            linex = document.getElementsByClassName("number<?php echo $scroll_to; ?>");
            if (typeof linex === 'undefined') return;
            linex[0].scrollIntoView();
            clearInterval(intervalID);
        }
        var intervalID  = setInterval(waitUntilRender, 200);

    </script>
    </body></html>
    <?php
    wp_die();
}

/*
 *
 * Check file for deprecated WordPress functions and unsafe functions calls
 *
 */
function pc_check_file($file){
    $ret = array('result'=>'OK','unsafe'=>array(),'wp_deprecated'=>array());
    $source = @file_get_contents($file);
    if ($source === false) return false;
    $lines = file($file);
    $tokens = token_get_all($source);
    $undesirable = pi_get_unsafe();
    $wp_deprecated = pc_get_wp_depricated();
    foreach($tokens as $token) {
        if ($token[0] == T_STRING) {
            if (array_key_exists($token[1],$wp_deprecated)) {
                if (strpos($lines[$token[2]-1],'->'.$token[1])) continue;
                if (strpos($lines[$token[2]-1],'::'.$token[1])) continue;
                if (strpos($lines[$token[2]-1],'function '.$token[1])) continue;
                $ret['wp_deprecated'][] = array('fname' =>$token[1],'line'=>$token[2],'source'=>htmlspecialchars($lines[$token[2]-1]),'notes'=>$wp_deprecated[$token[1]]);
            }
            if (array_key_exists($token[1],$undesirable)) {
                $ret['unsafe'][] = array('fname' =>$token[1],'line'=>$token[2],'source'=>htmlspecialchars($lines[$token[2]-1]),'notes'=>pi_get_risk($undesirable[$token[1]][1]).'. '.$undesirable[$token[1]][0]);
            }
        }
    }
    if (!empty($ret['unsafe'])) $ret['result']='found';
    if (!empty($ret['wp_deprecated'])) $ret['result']='found';
    return $ret;
}
/*
 * Human readable risk level
 *
 * */
function pi_get_risk($level){
    switch ($level) {
        case 1: $ret = 'Low'; break;
        case 2: $ret = 'Medium'; break;
        case 3: $ret = 'High'; break;
        default: $ret = 'Unknown';
    }
    return ' Potential risk: '.$ret;
}
/*
 * Check vulnerabilities in the WPScan Vulnerability Database
 *
 */
function pc_check_vulndb_file($plugin_slug,$plugin){
    $ret = 'No information found.';
    $key = 'v-'.$plugin_slug;
    if (!$vu = get_transient($key)) {
        if (!$json = @file_get_contents(WPVULNDB_API_PLUGIN . $plugin_slug)) return $ret;
        if (!$vu = json_decode($json)) return $ret;
        set_transient($key,$vu,3600);
    }

    $vulnerabilities = $vu->$plugin_slug->vulnerabilities;
    if (!is_array($vulnerabilities)) return $ret;

    $ret = '<h3>No vulnerabilities found</h3>';
    if (!empty($vulnerabilities)) {
        $report=array();
        foreach($vulnerabilities as $v){
            $r=array();
            if (version_compare($v->fixed_in,$plugin['Version'],'>')) {
                $r[]='<b>'.$v->title.'</b>';
                $r[]='<a target="_blank" href="https://wpvulndb.com/vulnerabilities/'.$v->id.'">ID:'.$v->id.'</a>';
                $r[]="Type: $v->vuln_type";
                $r[]='Published: '.date(get_option('date_format'),strtotime($v->published_date));
                $r[]="Fixed in version: $v->fixed_in";
                if ($v->references->url) {
                    $r[]='References:';
                    foreach ($v->references->url as $ref) {
                        $r[]='<a target="_blank" href="'.$ref.'">'.$ref.'</a>';
                    }
                }
            }
            if (!empty($r)) $report[]=implode('<br/>',$r);
        }
        if (!empty($report)) $ret = '<h3 style="color:#FF0000">Vulnerability found!</h3>You need to update this plugin immediately! <ol><li>'.implode('</li><li>',$report).'</li></ol><p>Information provided by <a href="https://wpvulndb.com/">WPScan Vulnerability Database</a></p>';
    }
    return $ret;
}


/*
 * Recursive Glob
 * Does not support flag GLOB_BRACE
 * */
if ( ! function_exists('glob_recursive')) {
    function glob_recursive($pattern, $flags = 0) {
        $files = glob($pattern, $flags);
        if (!is_array($files)) $files=array();
        $glob = glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT);
        if (is_array($glob)) {
            foreach ($glob as $dir) {
                $recursive = glob_recursive($dir . '/' . basename($pattern), $flags);
                $files = array_merge($files, $recursive);
            }
        }
        return $files;
    }
}
/*
 *
 * Auxiliary functions - keep it in the main plugin file!
 *
 * */
function pi_wp_content_dir(){
    return dirname(dirname(plugin_dir_path(__FILE__)));
}
function pi_plugins_dir(){
    return dirname(plugin_dir_path(__FILE__));
}
function pi_shortfilename($file){
    $pos = strlen(pi_plugins_dir());
    return substr($file,$pos);
}
/*
 *
 * Format date
 *
 */
function pi_date($time){
	$gmt_offset = get_option('gmt_offset') * 3600;
	$tf = get_option('time_format');
	$df = get_option('date_format');
	return date($tf.', '.$df, $gmt_offset + $time);
}
/*
 *
 * Filesize for humanoids. (C) Jeffrey Sambells
 *
 */
function pi_human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
/*
	Just notices in dashboard
*/
add_action( 'admin_notices', 'pi_admin_notice' , 9999 );
add_action( 'network_admin_notices', 'pi_admin_notice' , 9999 );
function pi_admin_notice(){
    if ($notices = get_site_option('pi_admin_message'))
        echo '<div class="updated pi-msg"><p>'.$notices.'</p></div>'; // class="updated" - green, class="update-nag" - yellow and above the page title,
    update_site_option('pi_admin_message','');
}

/*
	Plugin activation
*/
register_activation_hook( __FILE__, 'pi_activate' );
function pi_activate(){
    global $wpdb, $wp_version;
    if ( version_compare( PI_REQ_PHP, phpversion(), '>' ) ) {
        pi_stop_activating('<h3>'.sprintf(__('The Plugin Inspector requires PHP %s or higher. You are running','cerber'),PI_REQ_PHP).' '.phpversion().'</h3>');
    }
    if ( !function_exists('token_get_all') ) {
        pi_stop_activating('<h3>'.__('Tokenizer not found. The Plugin Inspector can not be activated on your web server.','pluch').'</h3>');
    }
    if ( version_compare( PI_REQ_WP, $wp_version, '>' ) ) {
        pi_stop_activating('<h3>'.sprintf(__('The Plugin Inspector requires WordPress %s or higher. You are running','cerber'),PI_REQ_WP).' '.$wp_version.'</h3>');
    }
    update_site_option('pi_admin_message',__('To check installed plugins use this page: ','cerber').
        ' <a href="'.admin_url('plugins.php?page=plipl').'">'.__('Plugin Inspector','cerber').'</a>');
}
/*
	Stop activating plugin!
*/
function pi_stop_activating($msg){
    deactivate_plugins( plugin_basename( __FILE__ ) );
    wp_die($msg);
}
/*
 *
 * Some admin styles & JS
 *
 * */
add_action('admin_head','pc_admin_head');
function pc_admin_head(){
    if (!isset($_GET['page']) || ($_GET['page']!='plipl' && $_GET['page']!='plitl')) return;
    $assets_url = plugin_dir_url(__FILE__).'assets/';
    ?>
    <style type="text/css" media="all">
        #plu-list {
            margin-top: 18px;
            /*max-width: 50%;*/
            max-width: 1000px;
        }
        .one-plugin {
            background-color: #fff;
            border: 1px solid #E5E5E5;
            padding: 10px;
            margin-bottom:6px;
        }
        .inactive h3{
            color: #777;
        }
        .green_lab {
            display:inline-block;
            padding:3px 5px 3px 5px;
            margin:1px;
            margin-right:8px;
            background-color:#83CE77;
            color:#000;
            border-radius: 5px;
        }
        .red_lab {
            display:inline-block;
            padding:3px 5px 3px 5px;
            margin:1px;
            margin-right:8px;
            background-color:#FF5733;
            color:#000;
            border-radius: 5px;
        }
        .yellow_lab {
            display:inline-block;
            padding:3px 5px 3px 5px;
            margin:1px;
            margin-right:8px;
            background-color:#FFFF80;
            color:#000;
            border-radius: 5px;
        }
        .gray_lab {
            display:inline-block;
            padding:3px 5px 3px 5px;
            margin:1px;
            margin-right:8px;
            background-color:#888;
            color:#fff;
            border-radius: 5px;
            text-decoration: none;
        }
        #scanning {
            float:left;
            width:60%;
            min-height: 80px;
            background-color:#FFF;
            border: 1px solid #E5E5E5;
            /*padding: 4px;*/
            padding-bottom: 20px;
            margin-bottom:4px;
            font-size: 110%;
        }
        #report-wrap {
            padding-left:60.5%;
        }
        #report {
            min-height: 50px;
            background-color:#FFF;
            border: 1px solid #E5E5E5;
            padding: 1em;
            padding-bottom: 2em;
            font-size: 110%;
        }
        @media (max-width: 1000px) {
            #scanning {
                float: none;
                width: auto;
            }
            #report-wrap {
                padding-left:0;
            }
        }
        #scanning ul {
            margin-left: 8px;
            margin-bottom: 16px;
            list-style-type: none;
            line-height: 160%;
        }
        #scanning ul li {
            padding-left: 6pt;
            margin-bottom: 1em;
        }
        ul.wp-deprecated li {
            border-left: 4px solid #FF5733;
        }
        ul.unsafe li {
            border-left: 4px solid #FFFF80;
        }
        ul.unsafe li:hover{
            background-color:#FFFEDA;
        }
        ul.wp-deprecated li:hover{
            background-color:#FFC9BF;
        }
        #scanning .fname {
            font-weight: bold;
            /*text-decoration: underline;*/
        }
        #scanning .source {
            color: navy;
            font-weight: bold;
        }
        #scanning .pi-notes {
            color:#000;
            font-style: italic;
            display:inline-block;
            margin-top: 0.5em;
        }
        #scanning .pi-notes::first-letter {
            text-transform: capitalize;
        }
        #scanning #spinner {
            margin-left: 18px;
        }
        .pi-hidden{
            display:none;
        }
        a.view-source {
            text-decoration: none;
        }
        a.view-source-line {
            text-decoration: none;
        }
        a.view-source-block{
            display:block;
            text-decoration: none;
            color:#000;
        }

        /* Thickbox decoration */
        #TB_title {
            background-color: #487ddd !important;
            color:#fff;
            /*height:100px !important;*/
        }
        .tb-close-icon {
            color:#fff !important;
        }
    </style>
    <?php
}