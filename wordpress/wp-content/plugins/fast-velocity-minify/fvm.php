<?php
/*
Plugin Name: Fast Velocity Minify
Plugin URI: http://fastvelocity.com
Description: Improve your speed score on GTmetrix, Pingdom Tools and Google PageSpeed Insights by merging and minifying CSS and JavaScript files into groups, compressing HTML and other speed optimizations. 
Author: Raul Peixoto
Author URI: http://fastvelocity.com
Version: 2.2.6
License: GPL2

------------------------------------------------------------------------
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


# check for minimum requirements and prevent activation or disable if not fully compatible
function fvm_compat_checker() {
	global $wp_version; 
	
	# defaults
	$error = '';
	$nwpv = implode('.', array_slice(explode('.', $wp_version), 0, 2)); # get 2 p only
	
	# php version requirements
	if (version_compare( PHP_VERSION, '5.4', '<' )) { 
		$error = 'Fast Velocity Minify requires PHP 5.4 or higher. You’re still on '. PHP_VERSION; 
	}

	# php extension requirements	
	if (!extension_loaded('mbstring')) { 
		$error = 'Fast Velocity Minify requires the PHP mbstring module to be installed on the server.'; 
	}
	
	# wp version requirements
	if ( $nwpv < '4.5' ) { 
		$error = 'Fast Velocity Minify requires WP 4.5 or higher. You’re still on ' . $wp_version; 
	}

	
	if ((is_plugin_active(plugin_basename( __FILE__ )) && !empty($error)) || !empty($error)) { 
		if (isset($_GET['activate'])) { unset($_GET['activate']); }
			deactivate_plugins( plugin_basename( __FILE__ )); 
			add_action('admin_notices', function() use ($error){ 
				echo '<div class="notice notice-error is-dismissible"><p><strong>'.$error.'</strong></p></div>'; 
			});
	} 
}
add_action('admin_init', 'fvm_compat_checker');


# get the plugin directory and include functions
$plugindir = plugin_dir_path( __FILE__ ); # with trailing slash
include($plugindir.'inc/functions.php');
include($plugindir.'inc/functions-serverinfo.php');

# get cache directories and urls
$cachepath = fvm_cachepath();
$tmpdir = $cachepath['tmpdir'];
$cachedir =  $cachepath['cachedir'];
$cachedirurl = $cachepath['cachedirurl'];

$wp_home = site_url();   # get the current wordpress installation url
$wp_domain = trim(str_ireplace(array('http://', 'https://'), '', trim($wp_home, '/')));
$wp_home_path = ABSPATH;

# cleanup, delete any minification files older than 45 days (most probably unused files)
if ($handle = opendir($cachedir.'/')) {
while (false !== ($file = readdir($handle))) { $file = $cachedir.'/'.$file; if (is_file($file) && time() - filemtime($file) >= 86400 * 45) { unlink($file); } }
closedir($handle);
}

# default globals
$fastvelocity_min_global_js_done = array();


###########################################
# build control panel pages ###############
###########################################

# options from the database, false if not set
$ignore = array_map('trim', explode("\n", get_option('fastvelocity_min_ignore', '')));
$blacklist = array_map('trim', explode("\n", get_option('fastvelocity_min_blacklist', '')));
$ignorelist = array_map('trim', explode("\n", get_option('fastvelocity_min_ignorelist', '')));
$merge_allowed_urls = array_map('trim', explode("\n", get_option('fastvelocity_min_merge_allowed_urls', '')));
$default_protocol = get_option('fastvelocity_min_default_protocol', 'dynamic');
$disable_js_merge = get_option('fastvelocity_min_disable_js_merge');
$disable_css_merge = get_option('fastvelocity_min_disable_css_merge');
$disable_js_minification = get_option('fastvelocity_min_disable_js_minification');
$disable_css_minification = get_option('fastvelocity_min_disable_css_minification');
$use_yui = get_option('fastvelocity_min_use_yui');
$remove_print_mediatypes = get_option('fastvelocity_min_remove_print_mediatypes'); 
$skip_html_minification = get_option('fastvelocity_min_skip_html_minification');
$use_alt_html_minification = get_option('fastvelocity_min_use_alt_html_minification');
$strip_htmlcomments = get_option('fastvelocity_min_strip_htmlcomments');
$skip_cssorder = get_option('fastvelocity_min_skip_cssorder');
$skip_google_fonts = get_option('fastvelocity_min_skip_google_fonts');
$skip_emoji_removal = get_option('fastvelocity_min_skip_emoji_removal');
$enable_defer_js = get_option('fastvelocity_min_enable_defer_js');
$exclude_defer_jquery = get_option('fastvelocity_min_exclude_defer_jquery');
$force_inline_css = get_option('fastvelocity_min_force_inline_css');
$force_inline_css_footer = get_option('fastvelocity_min_force_inline_css_footer');
$force_inline_googlefonts = get_option('fastvelocity_min_force_inline_googlefonts');
$remove_googlefonts = get_option('fastvelocity_min_remove_googlefonts');
$defer_for_pagespeed = get_option('fastvelocity_min_defer_for_pagespeed');
$exclude_defer_login = get_option('fastvelocity_min_exclude_defer_login');
$preload = array_map('trim', explode("\n", get_option('fastvelocity_min_preload')));
$preconnect = array_map('trim', explode("\n", get_option('fastvelocity_min_preconnect')));
$fvm_fix_editor = get_option('fastvelocity_min_fvm_fix_editor');
$loadcss = get_option('fastvelocity_min_loadcss');
$fvm_remove_css = get_option('fastvelocity_min_fvm_removecss');
$critical_path_css = get_option('fastvelocity_min_critical_path_css');
$fvm_cdn_url = get_option('fastvelocity_min_fvm_cdn_url');

# default options
$used_css_files = array();

# default blacklist
$exc = array('/html5shiv.js', '/excanvas.js', '/avada-ie9.js', '/respond.js', '/respond.min.js', '/selectivizr.js', '/Avada/assets/css/ie.css', '/html5.js', '/IE9.js', '/fusion-ie9.js', '/vc_lte_ie9.min.css', '/old-ie.css', '/ie.css', '/vc-ie8.min.css', '/mailchimp-for-wp/assets/js/third-party/placeholders.min.js', '/assets/js/plugins/wp-enqueue/min/webfontloader.js', '/a.optnmstr.com/app/js/api.min.js');
if(!is_array($blacklist) || strlen(implode($blacklist)) == 0) { update_option('fastvelocity_min_blacklist', implode("\n", $exc)); }

# default ignore list
$exc = array('/Avada/assets/js/main.min.js', '/woocommerce-product-search/js/product-search.js', '/includes/builder/scripts/frontend-builder-scripts.js', '/assets/js/jquery.themepunch.tools.min.js');
if(!is_array($ignorelist) || strlen(implode($ignorelist)) == 0) { update_option('fastvelocity_min_ignorelist', implode("\n", $exc)); }



# add admin page and rewrite defaults
if(is_admin()) {
    add_action('admin_menu', 'fastvelocity_min_admin_menu');
    add_action('admin_enqueue_scripts', 'fastvelocity_min_load_admin_jscss');
    add_action('wp_ajax_fastvelocity_min_files', 'fastvelocity_min_files_callback');
    add_action('admin_init', 'fastvelocity_min_register_settings');
    register_deactivation_hook( __FILE__, 'fastvelocity_min_plugin_deactivate');
} else {
		
	# skip on certain post_types or if there are specific keys on the url or if editor or admin
	if(!fastvelocity_exclude_contents()) {	
	
	# actions for frontend only
	if(!$disable_js_merge) { 
		add_action( 'wp_print_scripts', 'fastvelocity_min_merge_header_scripts', PHP_INT_MAX );
		add_action( 'wp_print_footer_scripts', 'fastvelocity_min_merge_footer_scripts', 9.999999 ); 
	}
	if(!$disable_css_merge) { 
		add_action('wp_head', 'fvm_buffer_placeholder_top', 0);
		add_action('wp_print_styles', 'fastvelocity_min_merge_header_css', PHP_INT_MAX ); 
		add_action('wp_print_footer_scripts', 'fastvelocity_min_merge_footer_css', 9.999999 );
	}
	if(!$skip_emoji_removal) { 
		add_action( 'init', 'fastvelocity_min_disable_wp_emojicons' );
	}

	}
}



# exclude processing for editors and administrators (fix editors)
add_action( 'plugins_loaded', 'fastvelocity_fix_editor' );
function fastvelocity_fix_editor() {
global $fvm_fix_editor, $disable_js_merge, $disable_css_merge, $skip_emoji_removal;
if($fvm_fix_editor == true && is_user_logged_in()) {
	if(!$disable_js_merge) {	
		remove_action( 'wp_print_scripts', 'fastvelocity_min_merge_header_scripts', PHP_INT_MAX );
		remove_action( 'wp_print_footer_scripts', 'fastvelocity_min_merge_footer_scripts', 9.999999 ); 
	}
	if(!$disable_css_merge) { 
		remove_action('wp_head', 'fvm_buffer_placeholder_top', 0);
		remove_action('wp_print_styles', 'fastvelocity_min_merge_header_css', PHP_INT_MAX ); 
		remove_action('wp_print_footer_scripts', 'fastvelocity_min_merge_footer_css', 9.999999 );
	}
	if(!$skip_emoji_removal) { 
		remove_action( 'init', 'fastvelocity_min_disable_wp_emojicons' );
	}
} 
}


# delete the cache when we deactivate the plugin
function fastvelocity_min_plugin_deactivate() { fvm_purge_all(); }


# create admin menu
function fastvelocity_min_admin_menu() {
add_options_page('Fast Velocity Minify Settings', 'Fast Velocity Minify', 'manage_options', 'fastvelocity-min', 'fastvelocity_min_settings');
}


# function to list all cache files
function fastvelocity_min_files_callback() {
	global $cachedir;

	# default
	$size = fastvelocity_get_cachestats();
    $return = array('js' => array(), 'css' => array(), 'stamp' => $_POST['stamp'], 'cachesize'=> $size);
	
	# inspect directory with opendir, since glob might not be available in some systems
	clearstatcache();
	if ($handle = opendir($cachedir.'/')) {
		while (false !== ($file = readdir($handle))) {
			$file = $cachedir.'/'.$file;
			$ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($ext, array('js', 'css'))) {
                $log = file_get_contents($file.'.txt');
                $mincss = substr($file, 0, -4).'.min.css';
                $minjs = substr($file, 0, -3).'.min.js';
                $filename = basename($file);
                if ($ext == 'css' && file_exists($mincss)) { $filename = basename($mincss); }
                if ($ext == 'js' && file_exists($minjs)) { $filename = basename($minjs); }
				$fsize = fastvelocity_format_filesize(filesize($file));
				
				# get location, hash, log
				$info = explode('-', $filename);
				$hash = $info['1'];
                array_push($return[$ext], array('hash' => $hash, 'filename' => $filename, 'log' => $log, 'fsize' => $fsize));
            }
		}
	closedir($handle);
	}

    header('Content-Type: application/json');
    echo json_encode($return);
    wp_die();
}


# load wp-admin css and js files
function fastvelocity_min_load_admin_jscss($hook) {
	if ('settings_page_fastvelocity-min' != $hook) { return; }
	wp_enqueue_script('postbox');
    wp_enqueue_style('fastvelocity-min', plugins_url('fvm.css', __FILE__), array(), filemtime(plugin_dir_path( __FILE__).'fvm.css'));
    wp_enqueue_script('fastvelocity-min', plugins_url('fvm.js', __FILE__), array('jquery'), filemtime(plugin_dir_path( __FILE__).'fvm.js'), true);
}


# register plugin settings
function fastvelocity_min_register_settings() {
    register_setting('fvm-group', 'fastvelocity_min_ignore');
	register_setting('fvm-group', 'fastvelocity_min_default_protocol');
    register_setting('fvm-group', 'fastvelocity_min_disable_js_merge');
    register_setting('fvm-group', 'fastvelocity_min_disable_css_merge');
    register_setting('fvm-group', 'fastvelocity_min_disable_js_minification');
    register_setting('fvm-group', 'fastvelocity_min_disable_css_minification');
	register_setting('fvm-group', 'fastvelocity_min_use_yui');
    register_setting('fvm-group', 'fastvelocity_min_remove_print_mediatypes');
    register_setting('fvm-group', 'fastvelocity_min_skip_html_minification');
    register_setting('fvm-group', 'fastvelocity_min_use_alt_html_minification');
	register_setting('fvm-group', 'fastvelocity_min_strip_htmlcomments');
    register_setting('fvm-group', 'fastvelocity_min_skip_cssorder');
	register_setting('fvm-group', 'fastvelocity_min_skip_google_fonts');
	register_setting('fvm-group', 'fastvelocity_min_skip_fontawesome_fonts');
	register_setting('fvm-group', 'fastvelocity_min_skip_emoji_removal');
	register_setting('fvm-group', 'fastvelocity_min_enable_defer_js');
	register_setting('fvm-group', 'fastvelocity_min_exclude_defer_jquery');
	register_setting('fvm-group', 'fastvelocity_min_force_inline_css');
	register_setting('fvm-group', 'fastvelocity_min_force_inline_css_footer');
	register_setting('fvm-group', 'fastvelocity_min_force_inline_googlefonts');
	register_setting('fvm-group', 'fastvelocity_min_remove_googlefonts');
	register_setting('fvm-group', 'fastvelocity_min_defer_for_pagespeed');
	register_setting('fvm-group', 'fastvelocity_min_exclude_defer_login');
	register_setting('fvm-group', 'fastvelocity_min_preload');
	register_setting('fvm-group', 'fastvelocity_min_preconnect');
	register_setting('fvm-group', 'fastvelocity_min_fvm_fix_editor');
	register_setting('fvm-group', 'fastvelocity_min_fvm_cdn_url');
	
	# pro version (for private usage... or if you know what you're doing)
	register_setting('fvm-group-pro', 'fastvelocity_min_loadcss');
	register_setting('fvm-group-pro', 'fastvelocity_min_fvm_removecss');
	register_setting('fvm-group-pro', 'fastvelocity_min_critical_path_css');
    register_setting('fvm-group-pro', 'fastvelocity_min_ignorelist');
    register_setting('fvm-group-pro', 'fastvelocity_min_blacklist');
    register_setting('fvm-group-pro', 'fastvelocity_min_merge_allowed_urls');
    register_setting('fvm-group-pro', 'fastvelocity_min_change_cache_path');
	register_setting('fvm-group-pro', 'fastvelocity_min_change_cache_base_url');
}



# add settings link on plugin page
function fastvelocity_min_settings_link($links) {
if (is_plugin_active(plugin_basename( __FILE__ ))) { 
$settings_link = '<a href="options-general.php?page=fastvelocity-min&tab=settings">Settings</a>'; 
array_unshift($links, $settings_link); 
}
return $links;
}
add_filter("plugin_action_links_".plugin_basename(__FILE__), 'fastvelocity_min_settings_link' );



# manage settings page
function fastvelocity_min_settings() {
if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.')); }

# tmp folder
global $tmpdir, $cachedir, $plugindir;

# get active tab, set default
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'status';

?>
<div class="wrap">
<h1>Fast Velocity Minify</h1>

<?php

# purge all caches
if(isset($_POST['purgeall']) && $_POST['purgeall'] == 1) { 
fvm_purge_all(); # purge all
echo  __('<div class="notice notice-success is-dismissible"><p>The <strong>CSS and JS</strong> files have been purged!</p></div>');
echo fastvelocity_purge_others(); # purge third party caches
}
?>

<h2 class="nav-tab-wrapper wp-clearfix">
    <a href="?page=fastvelocity-min&tab=status" class="nav-tab <?php echo $active_tab == 'status' ? 'nav-tab-active' : ''; ?>">Status</a> 
    <a href="?page=fastvelocity-min&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
	<a href="?page=fastvelocity-min&tab=pro" class="nav-tab <?php echo $active_tab == 'pro' ? 'nav-tab-active' : ''; ?>">Pro</a>
	<a href="?page=fastvelocity-min&tab=server" class="nav-tab <?php echo $active_tab == 'server' ? 'nav-tab-active' : ''; ?>">Server Info</a>
	<a href="?page=fastvelocity-min&tab=help" class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>">Help</a>
</h2>


<?php if( $active_tab == 'status' ) { ?>

<div id="fastvelocity-min">
    <div id="poststuff">
        <div id="fastvelocity_min_processed" class="postbox-container">
			<div class="meta-box">
			
				<div class="postbox" id="tab-purge">
                    <h3 class="hndle"><span>Purge the cache files </span></h3>
                    <div class="inside" id="fastvelocity_min_topbtns">
                        <ul class="processed">
						<li id="purgeall-row">
							<span class="filename">Purge FVM cache directory (<span id="fvm_cache_size"><?php echo fastvelocity_get_cachestats(); ?></span>)</span> 
							<span class="actions">
							<form method="post" id="fastvelocity_min_clearall" action="<?php echo admin_url('options-general.php?page=fastvelocity-min&tab=status'); ?>">
							<input type="hidden" name="purgeall" value="1" />
							<?php submit_button('Delete', 'button-secondary', 'submit', false); ?>
							</form>
						</li>
						</ul>
                    </div>
                </div>				
			
                <div class="postbox" id="tab-js">
                    <h3 class="hndle"><span>List of processed JS files</span></h3>
                    <div class="inside" id="fastvelocity_min_jsprocessed">
					<ul class="processed"></ul>
                    </div>
                </div>

                <div class="postbox" id="tab-css">
                    <h3 class="hndle"><span>List of processed CSS files</span></h3>
                    <div class="inside" id="fastvelocity_min_cssprocessed">
                        <ul class="processed"></ul>
                    </div>
                </div>
					
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if( $active_tab == 'settings' ) { ?>
<form method="post" action="options.php">
<?php settings_fields('fvm-group'); do_settings_sections('fvm-group'); ?>


<div style="height: 20px;"></div>
<h2 class="title">Basic Options</h2>
<p class="fvm-bold-green">These options are generaly safe to edit as needed. If you use a cache plugin, kindly purge all your caches once you're done with the changes.</p>

<table class="form-table fvm-settings">
<tbody>

<tr>
<th scope="row">Troubleshooting</th>
<td>
<p class="fvm-bold-green fvm-rowintro">It's recommended that you enable this, if your theme comes with some sort of visual frontend editor.</p>
<fieldset>
<label for="fastvelocity_min_fvm_fix_editor">
<input name="fastvelocity_min_fvm_fix_editor" type="checkbox" id="fastvelocity_min_fvm_fix_editor" value="1" <?php echo checked(1 == get_option('fastvelocity_min_fvm_fix_editor'), true, false); ?>>
Fix Page Editors <span class="note-info">[ If selected, logged in users will bypass all optimizations ]</span></label>
</fieldset></td>
</tr>


<tr>
<th scope="row">URL Options</th>
<td>
<?php 
# what to select
$sel = get_option('fastvelocity_min_default_protocol');
$a = ''; if($sel == 'dynamic' || empty($sel)) { $a = ' checked="checked"'; }
$b = ''; if($sel == 'http') { $b = ' checked="checked"'; }
$c = ''; if($sel == 'https') { $c = ' checked="checked"'; }
?>
<p class="fvm-bold-green fvm-rowintro">You may need to force http or https, for some CDN plugins to work:</p>
<fieldset>
	<label><input type="radio" name="fastvelocity_min_default_protocol" value="dynamic" <?php echo $a; ?>> Use the dynamic "//" protocol</label><br>
	<label><input type="radio" name="fastvelocity_min_default_protocol" value="http"<?php echo $b; ?>> Force HTTP urls</label><br>
	<label><input type="radio" name="fastvelocity_min_default_protocol" value="https"<?php echo $c; ?>> Force HTTPS urls</span></label><br>
</fieldset>
</td>
</tr>

<tr>
<th scope="row">HTML Options</th>
<td>
<p class="fvm-bold-green fvm-rowintro">The HTML minification is ON by default, but you can:</p>

<fieldset>
<label for="fastvelocity_min_skip_html_minification">
<input name="fastvelocity_min_skip_html_minification" type="checkbox" id="fastvelocity_min_skip_html_minification" value="1" <?php echo checked(1 == get_option('fastvelocity_min_skip_html_minification'), true, false); ?>>
Disable HTML Minification <span class="note-info">[ This will disable HTML minification ]</span></label>
<br />

<label for="fastvelocity_min_strip_htmlcomments">
<input name="fastvelocity_min_strip_htmlcomments" type="checkbox" id="fastvelocity_min_strip_htmlcomments" value="1" <?php echo checked(1 == get_option('fastvelocity_min_strip_htmlcomments'), true, false); ?>>
Strip HTML comments <span class="note-info">[ Only works with the default HTML minification, but note that some plugins need HTML comments to work properly ]</span></label>
<br />

<label for="fastvelocity_min_use_alt_html_minification">
<input name="fastvelocity_min_use_alt_html_minification" type="checkbox" id="fastvelocity_min_use_alt_html_minification" value="1" <?php echo checked(1 == get_option('fastvelocity_min_use_alt_html_minification'), true, false); ?>>
Use the alternative HTML minification <span class="note-info">[ Select this, ONLY if you have trouble with the default HTML minification ]</span></label>
<br />

</fieldset></td>
</tr>


<tr>
<th scope="row">Fonts Options</th>
<td>
<p class="fvm-bold-green fvm-rowintro">It's recommended that you enable the "Inline Google Fonts CSS" option.</p>
<fieldset>
<label for="fastvelocity_min_skip_emoji_removal">
<input name="fastvelocity_min_skip_emoji_removal" type="checkbox" id="fastvelocity_min_skip_emoji_removal" class="jsprocessor" value="1" <?php echo checked(1 == get_option('fastvelocity_min_skip_emoji_removal'), true, false); ?> >
Stop removing Emojis and smileys <span class="note-info">[ If selected, Emojis will be left alone and won't be removed from wordpress ]</span></label>
<br />

<label for="fastvelocity_min_skip_google_fonts">
<input name="fastvelocity_min_skip_google_fonts" type="checkbox" id="fastvelocity_min_skip_google_fonts" value="1" <?php echo checked(1 == get_option('fastvelocity_min_skip_google_fonts'), true, false); ?> >
Disable Google Fonts merging <span class="note-info">[ If selected, Google Fonts will no longer be merged into one request ]</span></label>
<br />

<label for="fastvelocity_min_force_inline_googlefonts">
<input name="fastvelocity_min_force_inline_googlefonts" type="checkbox" id="fastvelocity_min_force_inline_googlefonts" value="1" <?php echo checked(1 == get_option('fastvelocity_min_force_inline_googlefonts'), true, false); ?> >
Inline Google Fonts CSS <span class="note-info">[ If selected, Google Fonts CSS code will be inlined using "*.woof" format - NOTE: IE9+ and <a target="_blank" href="http://caniuse.com/#feat=woff">modern browsers</a> only]</span></label>
<br />

<label for="fastvelocity_min_remove_googlefonts">
<input name="fastvelocity_min_remove_googlefonts" type="checkbox" id="fastvelocity_min_remove_googlefonts" value="1" <?php echo checked(1 == get_option('fastvelocity_min_remove_googlefonts'), true, false); ?> >
Remove Google Fonts <span class="note-info">[ If selected, all enqueued Google Fonts will be removed from the site ]</span></label>
<br />

</fieldset></td>
</tr>




<tr>
<th scope="row">CSS Options</th>
<td>
<p class="fvm-bold-green fvm-rowintro">It's recommended that you Inline all CSS files, if they are small enough.</p>

<fieldset>
<label for="fastvelocity_min_disable_css_merge">
<input name="fastvelocity_min_disable_css_merge" type="checkbox" id="fastvelocity_min_disable_css_merge" value="1" <?php echo checked(1 == get_option('fastvelocity_min_disable_css_merge'), true, false); ?>>
Disable CSS processing<span class="note-info">[ If selected, this plugin will ignore CSS files completely ]</span></label>
<br />
<label for="fastvelocity_min_disable_css_minification">
<input name="fastvelocity_min_disable_css_minification" type="checkbox" id="fastvelocity_min_disable_css_minification" value="1" <?php echo checked(1 == get_option('fastvelocity_min_disable_css_minification'), true, false); ?>>
Disable minification on CSS files <span class="note-info">[ If selected, CSS files will be merged but not minified ]</span></label>
<br />
<label for="fastvelocity_min_skip_cssorder">
<input name="fastvelocity_min_skip_cssorder" type="checkbox" id="fastvelocity_min_skip_cssorder" value="1" <?php echo checked(1 == get_option('fastvelocity_min_skip_cssorder'), true, false); ?> >
Preserve the order of CSS files <span class="note-info">[ If selected, you will have better CSS compatibility but possibly more CSS files]</span></label>
<br />
<label for="fastvelocity_min_remove_print_mediatypes">
<input name="fastvelocity_min_remove_print_mediatypes" type="checkbox" id="fastvelocity_min_remove_print_mediatypes" value="1" <?php echo checked(1 == get_option('fastvelocity_min_remove_print_mediatypes'), true, false); ?> >
Remove the "Print" related stylesheets <span class="note-info">[ If selected, CSS files of mediatype "print" will be removed from the site ]</span></label>
<br />
<label for="fastvelocity_min_force_inline_css">
<input name="fastvelocity_min_force_inline_css" type="checkbox" id="fastvelocity_min_force_inline_css" value="1" <?php echo checked(1 == get_option('fastvelocity_min_force_inline_css'), true, false); ?>>
Inline all header CSS files <span class="note-info">[ If selected, the header CSS will be inlined to avoid the "render blocking" on pagespeed insights tests ]</span></label>
<br />
<label for="fastvelocity_min_force_inline_css_footer">
<input name="fastvelocity_min_force_inline_css_footer" type="checkbox" id="fastvelocity_min_force_inline_css_footer" value="1" <?php echo checked(1 == get_option('fastvelocity_min_force_inline_css_footer'), true, false); ?>>
Inline all footer CSS files <span class="note-info">[ If selected, the footer CSS will be inlined to avoid the "render blocking" on pagespeed insights tests ]</span></label>
<br />
</fieldset></td>
</tr>


<tr>
<th scope="row">JavaScript Options</th>
<td>
<p class="fvm-bold-green fvm-rowintro">Try to disable minification (and purge the cache), if you have trouble with JavaScript in the frontend.</p>
<fieldset>
<label for="fastvelocity_min_disable_js_merge">
<input name="fastvelocity_min_disable_js_merge" type="checkbox" id="fastvelocity_min_disable_js_merge" value="1" <?php echo checked(1 == get_option('fastvelocity_min_disable_js_merge'), true, false); ?> >
Disable JavaScript processing <span class="note-info">[ If selected, this plugin will ignore JS files completely ]</span></label>
<br />

<?php
# check for exec + a supported java version
if(function_exists('exec') && exec('command -v java >/dev/null && echo "yes" || echo "no"') == 'yes') {
?>
<label for="fastvelocity_min_use_yui">
<input name="fastvelocity_min_use_yui" type="checkbox" id="fastvelocity_min_use_yui" class="jsprocessor" value="1" <?php echo checked(1 == get_option('fastvelocity_min_use_yui'), true, false); ?> >
Minify with YUI Compressor <span class="note-info">[ If selected, it will try to use the YUI Compressor to minify JS files ]</span></label>
<br />
<?php } ?>

<label for="fastvelocity_min_disable_js_minification">
<input name="fastvelocity_min_disable_js_minification" type="checkbox" id="fastvelocity_min_disable_js_minification" value="1" <?php echo checked(1 == get_option('fastvelocity_min_disable_js_minification'), true, false); ?> >
Disable minification on JS files <span class="note-info">[ If selected, JS files will be merged but not minified ]</span></label>
<br />
</fieldset></td>
</tr>
</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">JS Advanced Options</h2>
<p class="fvm-bold-green">It's highly recommended that you only select the options below if you're an advanced user or developer and understand what these options mean.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Render-blocking JS</th>
<td>
<fieldset><legend class="screen-reader-text"><span>Render-blocking</span></legend>

<p class="fvm-bold-green fvm-rowintro">Some themes and plugins "need" render blocking scripts to work, so please take a look at the dev console for errors.</p>
<label for="fastvelocity_min_enable_defer_js">
<input name="fastvelocity_min_enable_defer_js" type="checkbox" id="fastvelocity_min_enable_defer_js" value="1" <?php echo checked(1 == get_option('fastvelocity_min_enable_defer_js'), true, false); ?>>
Enable defer parsing of JS files globally <span class="note-info">[ Not all browsers, themes or plugins support this. Beware of broken functionality and design ]</span></label>
<br />
<label for="fastvelocity_min_defer_for_pagespeed">
<input name="fastvelocity_min_defer_for_pagespeed" type="checkbox" id="fastvelocity_min_defer_for_pagespeed" value="1" <?php echo checked(1 == get_option('fastvelocity_min_defer_for_pagespeed'), true, false); ?>>
Enable defer of JS for Pagespeed Insights <span class="note-info">[ Defer JS files for Pagespeed Insights only, <a target="_blank" href="https://www.chromestatus.com/feature/5718547946799104">except external scripts</a> (avoid using a CDN for JS files) ]</span></label>
<br />

<label for="fastvelocity_min_exclude_defer_jquery">
<input name="fastvelocity_min_exclude_defer_jquery" type="checkbox" id="fastvelocity_min_exclude_defer_jquery" value="1" <?php echo checked(1 == get_option('fastvelocity_min_exclude_defer_jquery'), true, false); ?> >
Skip deferring the jQuery library <span class="note-info">[ Will fix "undefined jQuery" errors on the Google Chrome console log ]</span></label>
<br />
<label for="fastvelocity_min_exclude_defer_login">
<input name="fastvelocity_min_exclude_defer_login" type="checkbox" id="fastvelocity_min_exclude_defer_login" value="1" <?php echo checked(1 == get_option('fastvelocity_min_exclude_defer_login'), true, false); ?> >
Skip deferring completely on the login page <span class="note-info">[ If selected, will disable JS deferring on your login page ]</span></label>
<br />


</fieldset></td>
</tr>
</tbody></table>



<div style="height: 20px;"></div>
<h2 class="title">JS and CSS Exceptions</h2>
<p class="fvm-bold-green">You can use this section to exclude certain CSS or JS files from being processed in case of conflicts while merging.<br />Read the HELP section for information on why you may need to use this.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Ignore List</th>
<td><fieldset>
<label for="blacklist_keys"><span class="fvm-label-pad">Ignore the following CSS and JS paths below:</span></label>
<p>
<textarea name="fastvelocity_min_ignore" rows="10" cols="50" id="fastvelocity_min_ignore" class="large-text code" placeholder="ex: /wp-includes/js/jquery/jquery.js"><?php echo get_option('fastvelocity_min_ignore'); ?></textarea>
</p>
<p class="description">[ Your own list of js /css files to ignore with wildcard support (read the faqs) ]</p>
</fieldset></td>
</tr>
</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">CDN Options</h2>
<p class="fvm-bold-green">If the "Enable defer of JS for Pagespeed Insights" option is enabled, JS and CSS files will not be loaded from the CDN.<br />However, the static assets used inside the CSS and JS files will load from the CDN directly.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row"><span class="fvm-label-special">Your CDN domain</span></th>
<td><fieldset>
<label for="fastvelocity_min_fvm_cdn_url">
<p><input type="text" name="fastvelocity_min_fvm_cdn_url" id="fastvelocity_min_fvm_cdn_url" value="<?php echo get_option('fastvelocity_min_fvm_cdn_url', ''); ?>" size="80" /></p>
<p class="description">[ Load the generated CSS and JS urls (only) from your cdn domain name, ie: cdn.example.com ]</p></label>
</fieldset></td>
</tr>
</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">Preconnect Optimization</h2>
<p class="fvm-bold-green">Please make sure you understand these options before using them.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Preconnect Headers</th>
<td><fieldset><legend class="screen-reader-text"><span>Preconnect</span></legend>
<label for="fastvelocity_min_preconnect"><span class="fvm-label-pad">Insert one domain name url per line:</span></label>
<p>
<textarea name="fastvelocity_min_preconnect" rows="10" cols="50" id="fastvelocity_min_preconnect" class="large-text code" placeholder="ex: //fonts.gstatic.com"><?php echo get_option('fastvelocity_min_preconnect'); ?></textarea>
</p>
<p class="description">[ Use only the necessary domain names, such as remote font domain names, ex: //fonts.gstatic.com ]</p>
</fieldset></td>
</tr>

</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">Homepage Optimization</h2>
<p class="fvm-bold-green">Use this only for images above the fold that exist in all pages, such as your logo.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Preload Images</th>
<td><fieldset><legend class="screen-reader-text"><span>Preload Images</span></legend>
<label for="fastvelocity_min_preload"><span class="fvm-label-pad">Insert one image url per line:</span></label>
<p>
<textarea name="fastvelocity_min_preload" rows="10" cols="50" id="fastvelocity_min_preload" class="large-text code" placeholder="ex: //yoursite.com/wp-content/plugins/some-slider/large.img"><?php echo get_option('fastvelocity_min_preload'); ?></textarea>
</p>
<p class="description">[ Use only for large images that first load above the fold. Read the Help section for more details. ]</p>
</fieldset></td>
</tr>
</tbody></table>


<p class="submit"><input type="submit" name="fastvelocity_min_save_options" id="fastvelocity_min_save_options" class="button button-primary" value="Save Changes"></p>
</form>
<?php } ?>


<?php if( $active_tab == 'pro' ) { ?>

<form method="post" action="options.php">
<?php settings_fields('fvm-group-pro'); do_settings_sections('fvm-group-pro'); ?>


<div style="height: 20px;"></div>
<h2 class="title">Pro Optimization</h2>
<p class="fvm-bold-green">Do NOT touch these settings, unless you're a developer that understands exactly what this does.<br />This section is experimental and may or may not be removed or restructured in the future.</p>


<table class="form-table fvm-settings">
<tbody>


<tr>
<th scope="row">Critical Path CSS</th>
<td>
<fieldset>
<label for="blacklist_keys"><span class="fvm-label-pad">The CSS code here, will show up inside "style" tags in the header globally:</span></label>
<p>
<textarea name="fastvelocity_min_critical_path_css" rows="10" cols="50" id="fastvelocity_min_critical_path_css" class="large-text code" placeholder="your css code here"><?php echo get_option('fastvelocity_min_critical_path_css'); ?></textarea>
</p>
<p class="description">[ Use this if you're familiar with <a target="_blank" href="https://github.com/giakki/uncss">UnCSS</a> or have the correct critical path css. ]</p>
</fieldset>
</td>
</tr>


<tr>
<th scope="row">Extra CSS Options</th>
<td><fieldset>
<label for="fastvelocity_min_fvm_removecss">
<input name="fastvelocity_min_fvm_removecss" type="checkbox" id="fastvelocity_min_fvm_removecss" value="1" <?php echo checked(1 == get_option('fastvelocity_min_fvm_removecss'), true, false); ?>>
Dequeue all CSS files <span class="note-info">[ Use this if you have your uncss code, your own css file or want to test how the critical path css looks like ]</span></label>
</td> 
</tr>
</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">Async CSS</h2>
<p class="fvm-bold-green">If you have multiple css files per media type, they may load out of order and break your design.<br />Pagespeed will still complain about render blocking, until you have the correct critical path CSS code.</p>

<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Enable Async CSS</th>
<td><fieldset>
<label for="fastvelocity_min_loadcss">
<input name="fastvelocity_min_loadcss" type="checkbox" id="fastvelocity_min_loadcss" value="1" <?php echo checked(1 == get_option('fastvelocity_min_loadcss'), true, false); ?>>
Async CSS with LoadCSS<span class="note-info">[ Only works if "Inline all header / footer CSS files" is disabled ]</span></label>
</fieldset>
</td>
</tr>

</tbody></table>





<div style="height: 20px;"></div>
<h2 class="title">Special JS and CSS Exceptions</h2>
<p class="fvm-bold-green">You can use this section to edit or change our default exclusions, as well as to add your own.<br />It's recommeded that you use the Ignore List before touching these settings.</p>

<div style="height: 20px;"></div>
<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">External URLs to Merge</th>
<td><fieldset><label for="blacklist_keys"><span class="fvm-label-pad">List of external domains that can be fetched and merged together:</span></label>
<p>
<textarea name="fastvelocity_min_merge_allowed_urls" rows="10" cols="50" id="fastvelocity_min_merge_allowed_urls" class="large-text code" placeholder="ex: example.com"><?php echo get_option('fastvelocity_min_merge_allowed_urls'); ?></textarea>
</p>
<p class="description">[ Add any external "domains" for JS or CSS files than can be merged fetched and merged together by FVM, ie: example.com ]</p>
</fieldset></td>
</tr>
</tbody></table>

<div style="height: 20px;"></div>
<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Default Ignore List</th>
<td>
<fieldset><label for="blacklist_keys"><span class="fvm-label-pad">Do not edit, if you're not sure what this is:</span></label>
<p>
<textarea name="fastvelocity_min_ignorelist" rows="10" cols="50" id="fastvelocity_min_ignorelist" class="large-text code" placeholder="ex: /wp-includes/js/jquery/jquery.js"><?php echo get_option('fastvelocity_min_ignorelist'); ?></textarea>
</p>
<p class="description">[ Files that have been reported by other users to cause trouble when merged and that should always be ignored ]</p>
</fieldset></td>
</tr>
</tbody></table>

<div style="height: 20px;"></div>
<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row">Default Blacklist</th>
<td><fieldset><label for="blacklist_keys"><span class="fvm-label-pad">Do not edit, if you're not sure what this is:</span></label>
<p>
<textarea name="fastvelocity_min_blacklist" rows="10" cols="50" id="fastvelocity_min_blacklist" class="large-text code" placeholder="ex: /wp-includes/js/jquery/jquery.js"><?php echo get_option('fastvelocity_min_blacklist'); ?></textarea>
</p>
<p class="description">[ Usually, any IE css /js files that should always be ignored without incrementing the groups ]</p>
</fieldset></td>
</tr>
</tbody></table>


<div style="height: 20px;"></div>
<h2 class="title">Cache Location</h2>
<p class="fvm-bold-green">Make sure you choose a publicly available directory and that there are writting permissions on that directory.</p>
<table class="form-table fvm-settings">
<tbody>
<tr>
<th scope="row"><span class="fvm-label-special">Cache Path</span></th>
<td><fieldset>
<label for="fastvelocity_min_change_cache_path">
<p><input type="text" name="fastvelocity_min_change_cache_path" id="fastvelocity_min_change_cache_path" value="<?php echo get_option('fastvelocity_min_change_cache_path', ''); ?>" size="80" /></p>
<p class="description">[ Default cache path is: <?php echo rtrim(wp_upload_dir()['basedir'], '/'); ?> ]</p>
</label>
</fieldset></td>
</tr>
<tr>
<th scope="row"><span class="fvm-label-special">Cache Base URL</span></th>
<td><fieldset>
<label for="fastvelocity_min_change_cache_base_url">
<p><input type="text" name="fastvelocity_min_change_cache_base_url" id="fastvelocity_min_change_cache_base_url" value="<?php echo get_option('fastvelocity_min_change_cache_base_url', ''); ?>" size="80" /></p>
<p class="description">[ Default cache base url is: <?php echo trim(fvm_get_protocol(wp_upload_dir()['baseurl']), '/'); ?> ]</p>
</label>
</fieldset></td>
</tr>
</tbody></table>


<p class="submit"><input type="submit" name="fastvelocity_min_save_options" id="fastvelocity_min_save_options" class="button button-primary" value="Save Changes"></p>
</form>

<?php 
}

if( $active_tab == 'server' ) { 
fvm_get_generalinfo();
}
?>

<?php if( $active_tab == 'help' ) { ?>

<div class="wrap" id="fastvelocity-min">
    <div id="poststuff">
        <div id="fastvelocity_min_processed" class="postbox-container">
			<div class="meta-box-sortables ui-sortable">
		
				<div class="postbox" id="tab-info">
                    <h3 class="hndle"><span>Frequently Asked Questions</span></h3>
                    <div class="inside"><? echo fastvelocity_min_readme($plugindir.'readme.txt'); ?></div>
                </div>
			
            </div>
        </div>
    </div>
</div>
<?php } ?>



</div>

<div class="clear"></div>

<?php
}


###########################################
# process header javascript ###############
###########################################
function fastvelocity_min_merge_header_scripts() {
global $wp_scripts, $wp_domain, $wp_home, $wp_home_path, $cachedir, $cachedirurl, $ignore, $disable_js_merge, $disable_js_minification, $enable_defer_js, $exclude_defer_jquery;
if(!is_object($wp_scripts)) { return false; }
$scripts = wp_clone($wp_scripts);
$scripts->all_deps($scripts->queue);
$ctime = get_option('fvm-last-cache-update', '0'); 
$header = array();

# mark as done (as we go)
$done = $scripts->done;

# add defaults to ignore list
$ignore = fastvelocity_default_ignore($ignore);

# get groups of handles
foreach( $scripts->to_do as $handle ) :

# is it a footer script?
$is_footer = 0; if (isset($wp_scripts->registered[$handle]->extra["group"]) || isset($wp_scripts->registered[$handle]->args)) { $is_footer = 1; }

	# skip footer scripts for now
	if($is_footer != 1) {
		
	# get full url
	$hurl = fastvelocity_min_get_hurl($wp_scripts->registered[$handle]->src, $wp_domain, $wp_home);
	
	# IE only files don't increment things
	$ieonly = fastvelocity_ie_blacklist($hurl);
	if($ieonly == true) { continue; }
	
	# skip ignore list, scripts with conditionals, external scripts
	if ((!fastvelocity_min_in_arrayi($hurl, $ignore) && !isset($wp_scripts->registered[$handle]->extra["conditional"]) && fvm_internal_url($hurl, $wp_home)) || empty($hurl)) {
			
		# process
		if(isset($header[count($header)-1]['handle']) || count($header) == 0) {
			array_push($header, array('handles'=>array()));
		}
			
		# push it to the array
		array_push($header[count($header)-1]['handles'], $handle);

		# external and ignored scripts
	} else { 
		array_push($header, array('handle'=>$handle));
	}
	
	# make sure that the scripts skipped here, show up in the footer
	} else {
		$hurl = fastvelocity_min_get_hurl($wp_scripts->registered[$handle]->src, $wp_domain, $wp_home);
		wp_enqueue_script($handle, $hurl, array(), null, true);
	}
endforeach;


# loop through header scripts and merge
for($i=0,$l=count($header);$i<$l;$i++) {
	if(!isset($header[$i]['handle'])) {
		
		# static cache file info + done
		$done = array_merge($done, $header[$i]['handles']);		
		$hash = 'header-'.hash('adler32',implode('',$header[$i]['handles']));

		# create cache files and urls
		$file = $cachedir.'/'.$hash.'-'.$ctime.'.min.js';
		$file_url = fvm_get_protocol($cachedirurl.'/'.$hash.'-'.$ctime.'.min.js');
		
		# generate a new cache file
		clearstatcache();
		if (!file_exists($file)) {
			
			# code and log initialization
			$log = '';
			$code = '';	
		
			# minify and write to file
			foreach($header[$i]['handles'] as $handle) :
				if(!empty($wp_scripts->registered[$handle]->src)) {
					
					# get hurl per handle
					$hurl = fastvelocity_min_get_hurl($wp_scripts->registered[$handle]->src, $wp_domain, $wp_home);
					$printurl = str_ireplace(array(site_url(), home_url(), 'http:', 'https:'), '', $hurl);
					
					# get css from hurl, if available and valid
					$tkey = 'fvm-cache-'.$ctime.hash('adler32', $hurl);
					$newcode = false; $newcode = get_transient($tkey);
					if ( $newcode === false) {
						$res = fvm_download_and_cache($hurl, $tkey, null, $disable_js_minification, 'js', $handle);
						if(is_array($res)) {
							$newcode = $res['code'];
							$newlog = $res['log'];
						}
					} else {
						$newlog = "$printurl --- Debug: Fetched from transients cache with key $tkey ---\n";
					}
		
					# append
					if($newcode !== false) { 
						$code.= $newcode;
						$log.= $newlog;					
					}	
			
				# consider dependencies on handles with an empty src
				} else {
					wp_dequeue_script($handle); wp_enqueue_script($handle);
				}
			endforeach;	
			
			# prepare log
			$log = "PROCESSED on ".date('r')."\n".$log."PROCESSED from ".home_url(add_query_arg( NULL, NULL ))."\n";
			
			# generate cache, write log
			file_put_contents($file.'.txt', $log);
			file_put_contents($file, $code);
			file_put_contents($file.'.gz', gzencode(file_get_contents($file), 9));
		}
		
		# register minified file
		wp_register_script("fvm-header-$i", $file_url, array(), null, false); 
		
		# add all extra data from wp_localize_script
		$data = array();
		foreach($header[$i]['handles'] as $handle) { 					
			if(isset($wp_scripts->registered[$handle]->extra['data'])) { $data[] = $wp_scripts->registered[$handle]->extra['data']; }
		}
		if(count($data) > 0) { $wp_scripts->registered["fvm-header-$i"]->extra['data'] = implode("\n", $data); }
		
		# enqueue file
		wp_enqueue_script("fvm-header-$i");
	
	# other scripts need to be requeued for the order of files to be kept
	} else {
		wp_dequeue_script($header[$i]['handle']); wp_enqueue_script($header[$i]['handle']);
	}
}

# remove from queue
$wp_scripts->done = $done;
}
###########################################



###########################################
# process js in the footer ################
###########################################
function fastvelocity_min_merge_footer_scripts() {
global $wp_scripts, $wp_domain, $wp_home, $wp_home_path, $cachedir, $cachedirurl, $ignore, $disable_js_merge, $disable_js_minification, $enable_defer_js, $exclude_defer_jquery;
if(!is_object($wp_scripts)) { return false; }
$ctime = get_option('fvm-last-cache-update', '0'); 
$scripts = wp_clone($wp_scripts);
$scripts->all_deps($scripts->queue);
$footer = array();

# mark as done (as we go)
$done = $scripts->done;

# add defaults to ignore list
$ignore = fastvelocity_default_ignore($ignore);


# get groups of handles
foreach( $scripts->to_do as $handle ) :

	# get full url
	$hurl = fastvelocity_min_get_hurl($wp_scripts->registered[$handle]->src, $wp_domain, $wp_home);
	
	# IE only files don't increment things
	$ieonly = fastvelocity_ie_blacklist($hurl);
	if($ieonly == true) { continue; }
	
	# skip ignore list, scripts with conditionals, external scripts
	if ((!fastvelocity_min_in_arrayi($hurl, $ignore) && !isset($wp_scripts->registered[$handle]->extra["conditional"]) && fvm_internal_url($hurl, $wp_home)) || empty($hurl)) {
			
		# process
		if(isset($footer[count($footer)-1]['handle']) || count($footer) == 0) {
			array_push($footer, array('handles'=>array()));
		}
		
		# push it to the array
		array_push($footer[count($footer)-1]['handles'], $handle);
				
	# external and ignored scripts
	} else { 
		array_push($footer, array('handle'=>$handle));
	}
endforeach;

# loop through footer scripts and merge
for($i=0,$l=count($footer);$i<$l;$i++) {
	if(!isset($footer[$i]['handle'])) {
		
		# static cache file info + done
		$done = array_merge($done, $footer[$i]['handles']);		
		$hash = 'footer-'.hash('adler32',implode('',$footer[$i]['handles']));

		# create cache files and urls
		$file = $cachedir.'/'.$hash.'-'.$ctime.'.min.js';
		$file_url = fvm_get_protocol($cachedirurl.'/'.$hash.'-'.$ctime.'.min.js');
	
		# generate a new cache file
		clearstatcache();
		if (!file_exists($file)) {
			
			# code and log initialization
			$log = '';
			$code = '';	
		
			# minify and write to file
			foreach($footer[$i]['handles'] as $handle) :
				if(!empty($wp_scripts->registered[$handle]->src)) {
					
					# get hurl per handle
					$hurl = fastvelocity_min_get_hurl($wp_scripts->registered[$handle]->src, $wp_domain, $wp_home);
					$printurl = str_ireplace(array(site_url(), home_url(), 'http:', 'https:'), '', $hurl);
					
					# get css from hurl, if available and valid
					$tkey = 'fvm-cache-'.$ctime.hash('adler32', $hurl);
					$newcode = false; $newcode = get_transient($tkey);
					if ( $newcode === false) {
						$res = fvm_download_and_cache($hurl, $tkey, null, $disable_js_minification, 'js', $handle);
						if(is_array($res)) {
							$newcode = $res['code'];
							$newlog = $res['log'];
						}
					} else {
						$newlog = "$printurl --- Debug: Fetched from transients cache with key $tkey ---\n";
					}
		
					# append
					if($newcode !== false) { 
						$code.= $newcode;
						$log.= $newlog;					
					}	
			
				# consider dependencies on handles with an empty src
				} else {
					wp_dequeue_script($handle); wp_enqueue_script($handle);
				}
			endforeach;	
			
			# prepare log
			$log = "PROCESSED on ".date('r')."\n".$log."PROCESSED from ".home_url(add_query_arg( NULL, NULL ))."\n";
		
			# generate cache, write log
			file_put_contents($file.'.txt', $log);
			file_put_contents($file, $code);
			file_put_contents($file.'.gz', gzencode(file_get_contents($file), 9));
		}
		
		# register minified file
		wp_register_script("fvm-footer-$i", $file_url, array(), null, false); 
		
		# add all extra data from wp_localize_script
		$data = array();
		foreach($footer[$i]['handles'] as $handle) { 					
			if(isset($wp_scripts->registered[$handle]->extra['data'])) { $data[] = $wp_scripts->registered[$handle]->extra['data']; }
		}
		if(count($data) > 0) { $wp_scripts->registered["fvm-footer-$i"]->extra['data'] = implode("\n", $data); }
		
		# enqueue file
		wp_enqueue_script("fvm-footer-$i");
	
	# other scripts need to be requeued for the order of files to be kept
	} else {
		wp_dequeue_script($footer[$i]['handle']); wp_enqueue_script($footer[$i]['handle']);
	}
}

# remove from queue
$wp_scripts->done = $done;
}
##############################



###########################################
# enable defer for JavaScript (WP 4.1 and above) and remove query strings for ignored files
###########################################
function fastvelocity_min_defer_js($tag, $handle, $src) {
global $ignore, $blacklist, $ignorelist, $enable_defer_js, $defer_for_pagespeed, $wp_domain, $exclude_defer_login, $fvm_fix_editor;

# no query strings
$tag = trim($tag); # must cleanup
if (stripos($src, '?ver') !== false) { 
	$srcf = stristr($src, '?ver', true); 
	$tag = str_ireplace($src, $srcf, $tag); 
	$src = $srcf; 
}

# should we exclude defer on the login page?
if($exclude_defer_login == true && stripos($_SERVER["SCRIPT_NAME"], strrchr(wp_login_url(), '/')) !== false){ return $tag; }

# reprocess the ignore list to remove the /fvm/cache/ from the list (else won't defer)
$nignore = array(); if(is_array($ignore)) { foreach ($ignore as $i) { if($i != '/fvm/cache/') { $nignore[] = $i; } } }

# return if in any ignore list
if (count($nignore) > 0 && fastvelocity_min_in_arrayi($src, $nignore)) { return $tag; }
if (count($blacklist) > 0 && fastvelocity_min_in_arrayi($src, $blacklist)) { return $tag; }
if (count($ignorelist) > 0 && fastvelocity_min_in_arrayi($src, $ignorelist)) { return $tag; }

# fix page editors
if($fvm_fix_editor == true && is_user_logged_in()) { return $tag; }

# get available nodes and add create with defer tag (if not async)
$dom = new DOMDocument();
libxml_use_internal_errors(true);
@$dom->loadHTML($tag);
$nodes = $dom->getElementsByTagName('script'); 
$tagdefer = '';
if ($nodes->length != 0) { 
	$node = $dom->getElementsByTagName('script')->item(0);
	if (!$node->hasAttribute('async')) { $node->setAttribute('defer','defer'); };
	$tagdefer = $dom->saveHTML($node);
}

# when to defer, order matters
if($enable_defer_js == true) { return $tagdefer; }

# return if no defer, and there's no defer for pagespeed... else pagespeed processing
if ($defer_for_pagespeed != true) { return $tag; } else { 

# return if external script url https://www.chromestatus.com/feature/5718547946799104
if (fvm_is_local_domain($src) == true) { return $tag; }

# return if there are linebreaks (will break document.write)
if (stripos($tag, "\n") !== false) { return $tag; }

# print code if there are no linebreaks, or return
if(!empty($tagdefer)) { 
	$deferinsights = '<script type="text/javascript">if(navigator.userAgent.match(/speed|gtmetrix|x11.*firefox\/53|x11.*chrome\/39/i)){document.write('.json_encode($tagdefer).');}else{document.write('.json_encode($tag).');}</script>';	
	return preg_replace('#<script(.*?)>(.*?)</script>#is', $deferinsights, $tag);
}

# fallback
return $tag; 
}

}
###########################################



###########################################
# process header css ######################
###########################################
function fastvelocity_min_merge_header_css() {
global $wp_styles, $wp_domain, $wp_home, $wp_home_path, $cachedir, $cachedirurl, $ignore, $disable_css_merge, $disable_css_minification, $skip_google_fonts, $skip_cssorder, $remove_print_mediatypes, $force_inline_css, $force_inline_googlefonts, $remove_googlefonts, $loadcss, $critical_path_css, $fvm_remove_css;
if(!is_object($wp_styles)) { return false; }
$ctime = get_option('fvm-last-cache-update', '0'); 
$styles = wp_clone($wp_styles);
$styles->all_deps($styles->queue);
$done = $styles->done;
$header = array();
$google_fonts = array();
$process = array();
$inline_css = array();

# dequeue all styles
if($fvm_remove_css != false) {
	foreach( $styles->to_do as $handle ) :
		$done = array_merge($done, array($handle));
	endforeach;
	
	# remove from queue
	$wp_styles->done = $done;
	return false;
}

# add defaults to ignore list
$ignore = fastvelocity_default_ignore($ignore);


# get list of handles to process, dequeue duplicate css urls and keep empty source handles (for dependencies)
$uniq = array(); $gfonts = array();
foreach( $styles->to_do as $handle):

	# conditionals
	$conditional = NULL; if(isset($wp_styles->registered[$handle]->extra["conditional"])) { 
		$conditional = $wp_styles->registered[$handle]->extra["conditional"]; # such as ie7, ie8, ie9, etc
	}
	
	# mediatype
	$mediatype = isset($wp_styles->registered[$handle]->args) ? $wp_styles->registered[$handle]->args : 'all'; # such as all, print, mobile, etc
	if ($mediatype == 'screen' || $mediatype == 'screen, print') { $mediatype = 'all'; } 
	
	# full url or empty
	$hurl = fastvelocity_min_get_hurl($wp_styles->registered[$handle]->src, $wp_domain, $wp_home); 	
	
	# mark duplicates as done and remove from the queue
	if(!empty($hurl)) {
		$key = hash('adler32', $hurl); 
		if (isset($uniq[$key])) { $done = array_merge($done, array($handle)); continue; } else { $uniq[$key] = $handle; }
	}
	
	# array of info to save
	$arr = array('handle'=>$handle, 'url'=>$hurl, 'conditional'=>$conditional, 'mediatype'=>$mediatype);
	
	# google fonts to the top (collect and skip process array)
	if (stripos($hurl, 'fonts.googleapis.com') !== false) { 
	if($remove_googlefonts != false) { $done = array_merge($done, array($handle)); continue; } # mark as done if to be removed
	if(!$skip_google_fonts) { $google_fonts[$handle] = $hurl; } else {
		wp_enqueue_style($handle); # skip google fonts optimization?
	}
	continue; 
	} 
	
	# all else
	$process[$handle] = $arr;

endforeach;


# concat google fonts, if enabled
if(!$skip_google_fonts && count($google_fonts) > 0) {
	$concat_google_fonts = fastvelocity_min_concatenate_google_fonts($google_fonts);
	foreach ($google_fonts as $h=>$a) { $done = array_merge($done, array($h)); } # mark as done
	if($force_inline_googlefonts == false) {
			wp_enqueue_style('header-fvm-fonts', fvm_get_protocol($concat_google_fonts), array(), null, 'all');
	} else {
		
		# google fonts download and inlining, ignore logs
		$tkey = 'fvm-cache-'.$ctime.hash('adler32', $concat_google_fonts);
		$newcode = false; $newcode = get_transient($tkey);
		if ( $newcode === false) {
			$res = fvm_download_and_cache($concat_google_fonts, $tkey, null, $disable_css_minification, 'css');
			if(is_array($res)) { $newcode = $res['code']; }
		}
		
		# inline css or fail
		if($newcode !== false) { 
			echo '<style type="text/css" media="all">'.$newcode.'</style>'."\n";				
		} else {
			echo "<!-- GOOGLE FONTS REQUEST FAILED for $concat_google_fonts -->\n";     # log if failed
		}	
	}
}


# get groups of handles
foreach( $styles->to_do as $handle ) :

# skip already processed google fonts and empty dependencies
if(isset($google_fonts[$handle])) { continue; }                     # skip google fonts
if(empty($wp_styles->registered[$handle]->src)) { continue; } 		# skip empty src
if (fastvelocity_min_in_arrayi($handle, $done)) { continue; }       # skip if marked as done before
if (!isset($process[$handle])) { continue; } 						# skip if not on our unique process list

# get full url
$hurl = $process[$handle]['url'];
$conditional = $process[$handle]['conditional'];
$mediatype = $process[$handle]['mediatype'];

	# IE only files don't increment things
	$ieonly = fastvelocity_ie_blacklist($hurl);
	if($ieonly == true) { continue; }
	
	# skip ignore list, conditional css, external css
	if ((!fastvelocity_min_in_arrayi($hurl, $ignore) && !isset($conditional) && fvm_internal_url($hurl, $wp_home)) || empty($hurl)) {
	
	# colect inline css for this handle
	if(isset($wp_styles->registered[$handle]->extra['after']) && is_array($wp_styles->registered[$handle]->extra['after'])) { 
		$inline_css[$handle] = fastvelocity_min_minify_css_string(implode('', $wp_styles->registered[$handle]->extra['after'])); # save
		$wp_styles->registered[$handle]->extra['after'] = null; # dequeue
	}	
	
	# process
	if(isset($header[count($header)-1]['handle']) || count($header) == 0 || $header[count($header)-1]['media'] != $mediatype) {
		array_push($header, array('handles'=>array(), 'media'=>$mediatype)); 
	}
	
	# push it to the array
	array_push($header[count($header)-1]['handles'], $handle);

	# external and ignored css
	} else {
		
		# normal enqueuing
		array_push($header, array('handle'=>$handle));
	}
endforeach;


# reorder CSS by mediatypes
if(!$skip_cssorder) {
	if(count($header) > 0) {

		# get unique mediatypes
		$allmedia = array(); 
		foreach($header as $array) { 
			if(isset($array['media'])) { $allmedia[$array['media']] = ''; } 
		}

		# extract handles by mediatype
		$grouphandles = array(); 
		foreach ($allmedia as $md=>$var) { 
			foreach($header as $array) { 
				if (isset($array['media']) && $array['media'] == $md) { 
					foreach($array['handles'] as $h) { $grouphandles[$md][] = $h; } 
				} 
			} 
		}

		# reset and reorder header by mediatypes
		$newheader = array();
		foreach ($allmedia as $md=>$var) { $newheader[] = array('handles' => $grouphandles[$md], 'media'=>$md); }
		if(count($newheader) > 0) { $header = $newheader; }
	}
}

# critical path
if(!empty($critical_path_css) && $critical_path_css != false) {
	echo '<style id="critical-path-global" type="text/css" media="all">'.$critical_path_css.'</style>'."\n"; 
}


# loop through header css and merge
for($i=0,$l=count($header);$i<$l;$i++) {
	if(!isset($header[$i]['handle'])) {
		
		# get has for the inline css in this group
		$inline_css_group = array();
		foreach($header[$i]['handles'] as $h) { if(isset($inline_css[$h]) && !empty($inline_css[$h])) { $inline_css_group[] = $inline_css[$h]; } }
		$inline_css_hash = md5(implode('',$inline_css_group));
		
		# static cache file info + done
		$done = array_merge($done, $header[$i]['handles']);		
		$hash = 'header-'.hash('adler32',implode('',$header[$i]['handles']).$inline_css_hash);

		# create cache files and urls
		$file = $cachedir.'/'.$hash.'-'.$ctime.'.min.css';
		$file_url = fvm_get_protocol($cachedirurl.'/'.$hash.'-'.$ctime.'.min.css'); 
		
		# generate a new cache file
		clearstatcache();
		if (!file_exists($file)) {
			
			# code and log initialization
			$log = '';
			$code = '';	
		
			# minify and write to file
			foreach($header[$i]['handles'] as $handle) :
				if(!empty($wp_styles->registered[$handle]->src)) {
					
					# get hurl per handle
					$hurl = fastvelocity_min_get_hurl($wp_styles->registered[$handle]->src, $wp_domain, $wp_home);
					$printurl = str_ireplace(array(site_url(), home_url(), 'http:', 'https:'), '', $hurl);
					
					# get css from hurl, if available and valid
					$tkey = 'fvm-cache-'.$ctime.hash('adler32', $hurl);
					$newcode = false; $newcode = get_transient($tkey);
					if ( $newcode === false) {
						$res = fvm_download_and_cache($hurl, $tkey, null, $disable_css_minification, 'css', $handle);
						if(is_array($res)) {
							$newcode = $res['code'];
							$newlog = $res['log'];
						}
					} else {
						$newlog = "$printurl --- Debug: Fetched from transients cache with key $tkey ---\n";
					}
		
					# append
					if($newcode !== false) { 
						$code.= $newcode; 
						if(isset($inline_css[$handle]) && !empty($inline_css[$handle])) { $code.= $inline_css[$handle]; } # add inline css on the fly
						$log.= $newlog;					
					}	
			
				# consider dependencies on handles with an empty src
				} else {
					wp_dequeue_script($handle); wp_enqueue_script($handle);
				}
			endforeach;	
			
			# prepare log
			$log = "PROCESSED on ".date('r')."\n".$log."PROCESSED from ".home_url(add_query_arg( NULL, NULL ))."\n";
			
			# generate cache, write log
			file_put_contents($file.'.txt', $log);
			file_put_contents($file, $code);
			file_put_contents($file.'.gz', gzencode(file_get_contents($file), 9));
						
		}
		
		# register and enqueue minified file, consider excluding of mediatype "print" and inline css
		if ($remove_print_mediatypes != 1 || ($remove_print_mediatypes == 1 && $header[$i]['media'] != 'print')) {
			if($force_inline_css != false) {
				echo '<style type="text/css" media="'.$header[$i]['media'].'">'.file_get_contents($file).'</style>';
			} else {
				
				# move CSS to footer with loadCSS ?
				if($loadcss != false) {
					if($fvm_remove_css != true) {

# save to some sort of global and show it on the footer
$mt = $header[$i]['media'];
echo '<link rel="preload" href="'.$file_url.'" as="style" media="'.$mt.'" onload="this.onload=null;this.rel=\'stylesheet\'">';
echo '<noscript><link rel="stylesheet" type="text/css" media="'.$mt.'" href="'.$file_url.'"></noscript>';
echo '<!--[if IE]><link rel="stylesheet" type="text/css" media="'.$mt.'" href="'.$file_url.'"><![endif]-->';

/*
# alternative way
echo <<<EOF
<script type="text/javascript">var ldfvm$i=document.createElement("link");ldfvm$i.rel="stylesheet",ldfvm$i.type="text/css",ldfvm$i.media="bogus",ldfvm$i.href="$file_url",ldfvm$i.onload=function(){ldfvm$i.media="$mt"},document.getElementsByTagName("head")[0].appendChild(ldfvm$i);</script>
EOF;
*/

					}
				} else {
				
					# default
					wp_register_style("fvm-header-$i", $file_url, array(), null, $header[$i]['media']); 
					wp_enqueue_style("fvm-header-$i");
				
				}
			}
		}

	# other css need to be requeued for the order of files to be kept
	} else {
		wp_dequeue_style($header[$i]['handle']); wp_enqueue_style($header[$i]['handle']);
	}
}

# remove from queue
$wp_styles->done = $done;

}
###########################################


###########################################
# process css in the footer ###############
###########################################
function fastvelocity_min_merge_footer_css() {
global $wp_styles, $wp_domain, $wp_home, $wp_home_path, $cachedir, $cachedirurl, $ignore, $disable_css_merge, $disable_css_minification, $skip_google_fonts, $skip_cssorder, $remove_print_mediatypes, $force_inline_css_footer, $force_inline_googlefonts, $remove_googlefonts, $loadcss, $fvm_remove_css;
if(!is_object($wp_styles)) { return false; }
$ctime = get_option('fvm-last-cache-update', '0'); 
$styles = wp_clone($wp_styles);
$styles->all_deps($styles->queue);
$done = $styles->done;
$footer = array();
$google_fonts = array();
$inline_css = array();

# dequeue all styles
if($fvm_remove_css != false) {
	foreach( $styles->to_do as $handle ) :
		$done = array_merge($done, array($handle));
	endforeach;
	
	# remove from queue
	$wp_styles->done = $done;
	return false;
}


# add defaults to ignore list
$ignore = fastvelocity_default_ignore($ignore);

# google fonts to the top
foreach( $styles->to_do as $handle ) :
	# dequeue and get a list of google fonts, or requeue external
	$hurl = fastvelocity_min_get_hurl($wp_styles->registered[$handle]->src, $wp_domain, $wp_home);
	if (stripos($hurl, 'fonts.googleapis.com') !== false) { 
		wp_dequeue_style($handle); 
		if($remove_googlefonts != false) { $done = array_merge($done, array($handle)); continue; } # mark as done if to be removed
		if(!$skip_google_fonts) { $google_fonts[$handle] = $hurl; } else { 
				wp_enqueue_style($handle); # skip google fonts optimization?
		} 
	} else { 
		wp_dequeue_style($handle); wp_enqueue_style($handle); # failsafe
	}
endforeach;


# concat google fonts, if enabled
if(!$skip_google_fonts && count($google_fonts) > 0) {
	$concat_google_fonts = fastvelocity_min_concatenate_google_fonts($google_fonts);
	foreach ($google_fonts as $h=>$a) { $done = array_merge($done, array($h)); } # mark as done
	if($force_inline_googlefonts == false) {
		wp_enqueue_style('footer-fvm-fonts', fvm_get_protocol($concat_google_fonts), array(), null, 'all');
	} else {
		
		# google fonts download and inlining, ignore logs
		$tkey = 'fvm-cache-'.$ctime.hash('adler32', $concat_google_fonts);
		$newcode = false; $newcode = get_transient($tkey);
		if ( $newcode === false) {
			$res = fvm_download_and_cache($concat_google_fonts, $tkey, null, $disable_css_minification, 'css');
			if(is_array($res)) { $newcode = $res['code']; }
		}
		
		# inline css or fail
		if($newcode !== false) { 
			echo '<style type="text/css" media="all">'.$newcode.'</style>';				
		} else {
			echo "<!-- GOOGLE FONTS REQUEST FAILED for $concat_google_fonts -->\n";     # log if failed
		}	
	}
}


# get groups of handles
foreach( $styles->to_do as $handle ) :

	# skip already processed google fonts
	if(isset($google_fonts[$handle])) { continue; }

	# get full url
	$hurl = fastvelocity_min_get_hurl($wp_styles->registered[$handle]->src, $wp_domain, $wp_home);
	
	# media type
	$media = isset($wp_styles->registered[$handle]->args) ? $wp_styles->registered[$handle]->args : 'all';
	
	# IE only files don't increment things
	$ieonly = fastvelocity_ie_blacklist($hurl);
	if($ieonly == true) { continue; }
	
	# conditionals
	$conditional = NULL; if(isset($wp_styles->registered[$handle]->extra["conditional"])) { 
		$conditional = $wp_styles->registered[$handle]->extra["conditional"]; # such as ie7, ie8, ie9, etc
	}
	
	# skip ignore list, conditional css, external css
	if ((!fastvelocity_min_in_arrayi($hurl, $ignore) && !isset($conditional) && fvm_internal_url($hurl, $wp_home)) || empty($hurl)) {
			
		# colect inline css for this handle
		if(isset($wp_styles->registered[$handle]->extra['after']) && is_array($wp_styles->registered[$handle]->extra['after'])) { 
			$inline_css[$handle] = fastvelocity_min_minify_css_string(implode('', $wp_styles->registered[$handle]->extra['after'])); # save
			$wp_styles->registered[$handle]->extra['after'] = null; # dequeue
		}	
			
		# process
		if(isset($footer[count($footer)-1]['handle']) || count($footer) == 0 || $footer[count($footer)-1]['media'] != $wp_styles->registered[$handle]->args) {
			array_push($footer, array('handles'=>array(),'media'=>$media));
		}
	
		# push it to the array get latest modified time
		array_push($footer[count($footer)-1]['handles'], $handle);
		
	# external and ignored css
	} else {
		
		# normal enqueueing
		array_push($footer, array('handle'=>$handle));
	}
endforeach;


# reorder CSS by mediatypes
if(!$skip_cssorder) {
	if(count($footer) > 0) {

		# get unique mediatypes
		$allmedia = array(); 
		foreach($footer as $key=>$array) { 
			if(isset($array['media'])) { $allmedia[$array['media']] = ''; } 
		}

		# extract handles by mediatype
		$grouphandles = array(); 
		foreach ($allmedia as $md=>$var) { 
			foreach($footer as $array) { 
				if (isset($array['media']) && $array['media'] == $md) { 
					foreach($array['handles'] as $h) { $grouphandles[$md][] = $h; } 
				} 
			} 
		}

		# reset and reorder footer by mediatypes
		$newfooter = array();
		foreach ($allmedia as $md=>$var) { $newfooter[] = array('handles' => $grouphandles[$md], 'media'=>$md); }
		if(count($newfooter) > 0) { $footer = $newfooter; }
	}
}

# loop through footer css and merge
for($i=0,$l=count($footer);$i<$l;$i++) {
	if(!isset($footer[$i]['handle'])) {
		
		# get has for the inline css in this group
		$inline_css_group = array();
		foreach($footer[$i]['handles'] as $h) { if(isset($inline_css[$h]) && !empty($inline_css[$h])) { $inline_css_group[] = $inline_css[$h]; } }
		$inline_css_hash = md5(implode('',$inline_css_group));
		
		# static cache file info + done
		$done = array_merge($done, $footer[$i]['handles']);		
		$hash = 'footer-'.hash('adler32',implode('',$footer[$i]['handles']).$inline_css_hash);

		# create cache files and urls
		$file = $cachedir.'/'.$hash.'-'.$ctime.'.min.css';
		$file_url = fvm_get_protocol($cachedirurl.'/'.$hash.'-'.$ctime.'.min.css');
		
		# generate a new cache file
		clearstatcache();
		if (!file_exists($file)) {
			
			# code and log initialization
			$log = '';
			$code = '';	
		
			# minify and write to file
			foreach($footer[$i]['handles'] as $handle) :
				if(!empty($wp_styles->registered[$handle]->src)) {
					
					# get hurl per handle
					$hurl = fastvelocity_min_get_hurl($wp_styles->registered[$handle]->src, $wp_domain, $wp_home);
					$printurl = str_ireplace(array(site_url(), home_url(), 'http:', 'https:'), '', $hurl);
					
					# get css from hurl, if available and valid
					$tkey = 'fvm-cache-'.$ctime.hash('adler32', $hurl);
					$newcode = false; $newcode = get_transient($tkey);
					if ( $newcode === false) {
						$res = fvm_download_and_cache($hurl, $tkey, null, $disable_css_minification, 'css', $handle);
						if(is_array($res)) {
							$newcode = $res['code'];
							$newlog = $res['log'];
						}
					} else {
						$newlog = "$printurl --- Debug: Fetched from transients cache with key $tkey ---\n";
					}
		
					# append
					if($newcode !== false) { 
						$code.= $newcode;
						if(isset($inline_css[$handle]) && !empty($inline_css[$handle])) { $code.= $inline_css[$handle]; } # add inline css on the fly
						$log.= $newlog;					
					}	
			
				# consider dependencies on handles with an empty src
				} else {
					wp_dequeue_script($handle); wp_enqueue_script($handle);
				}
			endforeach;	
			
			# prepare log
			$log = "PROCESSED on ".date('r')."\n".$log."PROCESSED from ".home_url(add_query_arg( NULL, NULL ))."\n";
			
			# generate cache, add inline css, write log
			file_put_contents($file.'.txt', $log);
			file_put_contents($file, $code); # preserve style tags
			file_put_contents($file.'.gz', gzencode(file_get_contents($file), 9));
		
		}

		# register and enqueue minified file, consider excluding of mediatype "print" and inline css
		if ($remove_print_mediatypes != 1 || ($remove_print_mediatypes == 1 && $footer[$i]['media'] != 'print')) {
			if($force_inline_css_footer != false) {
				echo '<style type="text/css" media="'.$footer[$i]['media'].'">'.file_get_contents($file).'</style>';
			} else {
				
				# footer css
				if($loadcss != false) {
					if($fvm_remove_css != true) {
						echo '<link rel="stylesheet" type="text/css" media="'.$footer[$i]['media'].'" href="'.$file_url.'">';
					}
				} else {
					wp_register_style("fvm-footer-$i", $file_url, array(), null, $footer[$i]['media']); 
					wp_enqueue_style("fvm-footer-$i");
				}
			}
		}

	# other css need to be requeued for the order of files to be kept
	} else {
		wp_dequeue_style($footer[$i]['handle']); wp_enqueue_style($footer[$i]['handle']);
	}
}

# remove from queue
$wp_styles->done = $done;
}
###########################################



###########################################
# defer CSS globally from the header (order matters)
###########################################
function fvm_add_loadcss() { 
global $force_inline_css, $loadcss, $fvm_remove_css; 
if($force_inline_css == true && $loadcss != false && $fvm_remove_css != true) {

		# echo LoadCSS scripts
		echo '<script>
		/*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */
		!function(t){"use strict";t.loadCSS||(t.loadCSS=function(){});var e=loadCSS.relpreload={};if(e.support=function(){var e;try{e=t.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),e.bindMediaToggle=function(t){function e(){t.media=a}var a=t.media||"all";t.addEventListener?t.addEventListener("load",e):t.attachEvent&&t.attachEvent("onload",e),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(e,3e3)},e.poly=function(){if(!e.support())for(var a=t.document.getElementsByTagName("link"),n=0;n<a.length;n++){var o=a[n];"preload"!==o.rel||"style"!==o.getAttribute("as")||o.getAttribute("data-loadcss")||(o.setAttribute("data-loadcss",!0),e.bindMediaToggle(o))}},!e.support()){e.poly();var a=t.setInterval(e.poly,500);t.addEventListener?t.addEventListener("load",function(){e.poly(),t.clearInterval(a)}):t.attachEvent&&t.attachEvent("onload",function(){e.poly(),t.clearInterval(a)})}"undefined"!=typeof exports?exports.loadCSS=loadCSS:t.loadCSS=loadCSS}("undefined"!=typeof global?global:this);
		</script>';
}
}

if (!is_admin()) { add_action('wp_head', 'fvm_add_loadcss', PHP_INT_MAX); }




###########################################
# add preconnect and preload headers
###########################################
function fvm_buffer_placeholder_top() { 
global $preload, $preconnect;

# defaults
$meta = array();

# preconnect resources
# https://css-tricks.com/prefetching-preloading-prebrowsing/
if(count($preconnect) > 0) {
	$a = array(); foreach ($preconnect as $b) { 
		if(!empty($b)) { $a[] = '<link href="'.str_ireplace(array('http://', 'https://'), '//', $b).'" rel="preconnect">'; } 
	}
	if(count($a) > 0) { $meta[] = implode('', $a); }
}

# preload resources (beta: homepage only)
# https://css-tricks.com/prefetching-preloading-prebrowsing/
if((is_home() || is_front_page()) && count($preload) > 0) {
	$a = array(); 
	foreach ($preload as $b) { 
	if(!empty($b)) { 
		$meta[] = '<link rel="preload" as="image" href="'.str_ireplace(array('http://', 'https://'), '//', $b).'">'; 
	}
	}
}

# output on top
echo implode('', $meta);
}


# remove query from static assets and process defering (if enabled)
if (!is_admin()) {
add_filter('script_loader_tag', 'fastvelocity_min_defer_js', 10, 3); 
add_filter('style_loader_src', 'fastvelocity_remove_cssjs_ver', 10, 2);
}


# enable html minification
if(!$skip_html_minification && !is_admin()) {
	add_action('template_redirect', 'fastvelocity_min_html_compression_start', PHP_INT_MAX);
}

