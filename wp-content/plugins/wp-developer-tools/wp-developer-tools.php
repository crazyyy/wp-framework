<?php
/**
 * @package WP Developer Tools
 * @author PressPage Entertainment Inc
 */

/*
Plugin Name: WP Developer Tools
Plugin URI: https://wordpress.org/plugins/wp-developer-tools/
Description: Collection of useful developer tools
Author: PressPage Entertainment Inc. DBA PINGLEWARE
Author URI: https://pingleware.work
Version: 1.1.1
License: GPLv2
*/

//avoid direct calls to this file, because now WP core and framework has been used
if ( !function_exists('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if ( function_exists('add_action') ) {
	if ( error_reporting(E_ALL) )
		error_reporting(E_ALL ^ E_NOTICE);
}

if ( !class_exists('PhpQuickProfiler') ) require_once( 'classes/PhpQuickProfiler.php' );
if ( !class_exists('MySqlDatabase') ) require_once( 'classes/MySqlDatabase.php' );
if ( !class_exists('Console') ) require_once( 'classes/Console.php' );

require_once( 'display.php' );

if (!class_exists( 'WP_Developer_Tools' ))
{
	class WP_Developer_Tools
	{
		private $profiler;
		private $db = '';

		private $filter_list = array(
				'attachment_fields_to_edit',
				'attachment_icon',
				'attachment_innerHTML',
				'content_edit_pre',
				'excerpt_edit_pre',
				'get_attached_file',
				'get_enclosed',
				'get_pages',
				'get_pung',
				'get_the_excerpt',
				'get_the_guid',
				'get_to_ping',
				'icon_dir',
				'icon_dir_uri',
				'prepend_attachment',
				'sanitize_title',
				'single_post_title',
				'the_content',
				'the_content_rss',
				'the_content_feed',
				'the_editor_content',
				'the_excerpt',
				'the_excerpt_rss',
				'the_tags',
				'the_title',
				'the_title_rss',
				'title_edit_pre',
				'wp_dropdown_pages',
				'wp_list_pages',
				'wp_list_pages_excludes',
				'wp_get_attachment_metadata',
				'wp_get_attachment_thumb_file',
				'wp_get_attachment_thumb_url',
				'wp_get_attachment_url',
				'wp_mime_type_icon',
				'wp_title',
				'add_ping',
				'attachment_fields_to_save',
				'attachment_max_dims',
				'category_save_pre',
				'comment_status_pre',
				'content_filtered_save_pre',
				'content_save_pre',
				'excerpt_save_pre',
				'name_save_pre',
				'phone_content',
				'ping_status_pre',
				'post_mime_type_pre',
				'status_save_pre',
				'thumbnail_filename',
				'wp_thumbnail_creation_size_limit',
				'wp_thumbnail_max_side_length',
				'title_save_pre',
				'update_attached_file',
				'wp_delete_file',
				'wp_generate_attachment_metadata',
				'wp_update_attachment_metadata',
				'comment_excerpt',
				'comment_flood_filter',
				'comment_post_redirect',
				'comment_text',
				'comment_text_rss',
				'comments_array',
				'comments_number',
				'get_comment_excerpt',
				'get_comment_ID',
				'get_comment_text',
				'get_comment_type',
				'get_comments_number',
				'post_comments_feed_link',
				'comment_save_pre',
				'pre_comment_approved',
				'pre_comment_content',
				'preprocess_comment',
				'wp_insert_post_data',
				'category_description',
				'category_feed_link',
				'category_link',
				'get_categories',
				'get_category',
				'list_cats',
				'list_cats_exclusions',
				'single_cat_title',
				'the_category',
				'the_category_rss',
				'wp_dropdown_cats',
				'wp_list_categories',
				'wp_get_object_terms',
				'pre_category_description',
				'pre_category_name',
				'pre_category_nicename',
				'attachment_link',
				'author_feed_link',
				'author_link',
				'comment_reply_link',
				'day_link',
				'feed_link',
				'get_comment_author_link',
				'get_comment_author_url_link',
				'month_link',
				'page_link',
				'post_link',
				'post_type_link',
				'the_permalink',
				'year_link',
				'tag_link',
				'get_comment_date',
				'get_comment_time',
				'get_the_modified_date',
				'get_the_modified_time',
				'get_the_time',
				'the_date',
				'the_modified_date',
				'the_modified_time',
				'the_time',
				'the_weekday',
				'the_weekday_date',
				'login_redirect',
				'author_email',
				'comment_author',
				'comment_author_rss',
				'comment_email',
				'comment_url',
				'get_comment_author',
				'get_comment_author_email',
				'get_comment_author_IP',
				'get_comment_author_url',
				'login_errors',
				'login_headertitle',
				'login_headerurl',
				'login_message',
				'sanitize_user',
				'the_author',
				'the_author_email',
				'pre_comment_author_email',
				'pre_comment_author_name',
				'pre_comment_author_url',
				'pre_comment_user_agent',
				'pre_comment_user_ip',
				'pre_user_id',
				'pre_user_description',
				'pre_user_display_name',
				'pre_user_email',
				'pre_user_first_name',
				'pre_user_last_name',
				'pre_user_login',
				'pre_user_nicename',
				'pre_user_nickname',
				'pre_user_url',
				'registration_errors',
				'user_registration_email',
				'validate_username',
				'get_bookmarks',
				'link_category',
				'link_description',
				'link_rating',
				'link_title',
				'pre_link_description',
				'pre_link_image',
				'pre_link_name',
				'pre_link_notes',
				'pre_link_rel',
				'pre_link_rss',
				'pre_link_target',
				'pre_link_url',
				'all_options',
				'bloginfo',
				'bloginfo_rss',
				'bloginfo_url',
				'loginout',
				'register',
				'upload_dir',
				'upload_mimes',
				'attribute_escape',
				'js_escape',
				'locale_stylesheet_uri',
				'stylesheet',
				'stylesheet_directory',
				'stylesheet_directory_uri',
				'stylesheet_uri',
				'template',
				'template_directory',
				'template_directory_uri',
				'theme_root',
				'theme_root_uri',
				'404_template',
				'archive_template',
				'attachment_template',
				'author_template',
				'category_template',
				'comments_popup_template',
				'comments_template',
				'date_template',
				'home_template',
				'page_template',
				'paged_template',
				'search_template',
				'single_template',
				'template_include',
				'allowed_redirect_hosts',
				'author_rewrite_rules',
				'category_rewrite_rules',
				'comments_rewrite_rules',
				'create_user_query',
				'date_rewrite_rules',
				'found_posts',
				'found_posts_query',
				'get_editable_authors',
				'gettext',
				'override_load_textdomain',
				'get_next_post_join',
				'get_next_post_sort',
				'get_next_post_where',
				'get_others_drafts',
				'get_previous_post_join',
				'get_previous_post_sort',
				'get_previous_post_where',
				'get_users_drafts',
				'locale',
				'mod_rewrite_rules',
				'post_limits',
				'posts_distinct',
				'posts_fields',
				'posts_groupby',
				'posts_join_paged',
				'posts_orderby',
				'posts_request',
				'post_rewrite_rules',
				'root_rewrite_rules',
				'page_rewrite_rules',
				'posts_where_paged',
				'posts_join',
				'posts_where',
				'query_string',
				'query_vars',
				'request',
				'rewrite_rules_array',
				'search_rewrite_rules',
				'the_posts',
				'excerpt_length',
				'excerpt_more',
				'post_edit_form_tag',
				'update_user_query',
				'wp_redirect',
				'xmlrpc_methods',
				'wp_mail_from',
				'wp_mail_from_name',
				'widget_archives_dropdown_args',
				'widget_links_args',
				'widget_pages_args',
				'widget_tag_cloud_args',
				'widget_text',
				'widget_title',
		);

		// constructor
		function __construct()
		{
			if ( function_exists( 'register_activation_hook' ) )
				register_activation_hook(__FILE__, array( &$this, 'activate' ) );
			if ( function_exists( 'register_uninstall_hook' ) )
				register_uninstall_hook(__FILE__, array( 'Debug_Queries', 'deactivate' ) );
			if ( function_exists( 'register_deactivation_hook' ) )
				register_deactivation_hook(__FILE__, array( &$this, 'deactivate' ) );

			if (is_admin()) {
				// Show warning message to admin
				add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

				// Catch options page
				add_action( 'load-settings_page_'.substr( plugin_basename( __FILE__ ), 0, -4 ), array( &$this, 'load_settings_page' ) );

				// Create options menu
				add_action( 'admin_menu', array( &$this, 'admin_menu' ) );

			}

			add_action('init',array(&$this,'wpdt_init'));
			add_action('wp_footer',array(&$this,'wpdt_end'));
			add_action('wp_logout',array(&$this,'wpdt_logout'));
		}

		function wpdt_init() {
			if (!is_admin() && current_user_can("activate_plugins") && get_option('wpdt_quick_profiler')) {
				$this->db = new MySqlDatabase(DB_HOST,DB_USER,DB_PASSWORD);
				$this->db->connect(DB_NAME);
				$this->db->changeDatabase(DB_NAME);

				$this->profiler = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime());

                                Console::logSpeed('Initializing...');
				if (get_option('wpdt_log_predefined_php') == 'checked') {

					//PHP Predefined Variables
					Console::log($_COOKIE, '_COOKIE');
					Console::log($_ENV, '_ENV');
					Console::log($_FILES, '_FILES');
					Console::log($_GET, '_GET');
					Console::log($PHP_SELF, '_PHP_SELF');
					Console::log($_POST, '_POST');
					Console::log($_REQUEST, '_REQUEST');
					Console::log($_SERVER, '_SERVER');
					Console::log($_SESSION, '_SESSION');
				}

				foreach($this->filter_list as $filter) {
					if (get_option('wpdt_'.$filter) == 'checked') {
						add_filter($filter,'wpdt_'.$filter);
					} else {
						remove_filter($filter,'wpdt_'.$filter);
					}
				}
			} else {
				remove_action('init',array(&$this,'wpdt_init'));
				remove_action('wp_footer',array(&$this,'wpdt_end'));
			}
		}

		function wpdt_end() {
			if (!is_admin() && current_user_can("activate_plugins") && get_option('wpdt_quick_profiler')) {
				Console::logSpeed('Concluding!');
				$this->profiler->display($this->db);
				remove_action('init',array(&$this,'wpdt_init'));
				remove_action('wp_footer',array(&$this,'wpdt_end'));

				foreach($this->filter_list as $filter) {
					if (get_option('wpdt_'.$filter) == 'checked') {
						remove_filter($filter,'wpdt_'.$filter);
					}
				}
			}
		}

		function wpdt_logout() {
			update_option('wpdt_quick_profiler',FALSE);
		}

		function activate()
		{
			global $wp_roles;
                        
			if (!function_exists('mysqli_connect')) {
				deactivate_plugins(basename(__FILE__)); 
				wp_die('Missing MySQLi extension');
			}

			add_option('wpdt_quick_profiler',FALSE);
			add_option('save_log_predefined_php',FALSE);
			add_option('wpdt_log_predefined_php',' ');

			foreach($this->filter_list as $filter) {
				add_option('wpdt_'.$filter, ' ');
			}


			$wp_roles->add_cap( 'administrator', 'WPDeveloperTools' );
		}

		function deactivate()
		{
			global $wp_roles;

			delete_option('wpdt_quick_profiler');
			delete_option('save_log_predefined_php');
			delete_option('wpdt_log_predefined_php');

			foreach($this->filter_list as $filter) {
				delete_option('wpdt_'.$filter);
			}

			remove_action('init',array(&$this,'wpdt_init'));
			remove_action('wp_footer',array(&$this,'wpdt_end'));
			remove_action('wp_logout',array(&$this,'wpdt_logout'));

			$wp_roles->remove_cap( 'administrator', 'WPDeveloperTools' );
		}

		// Create options menu
		function admin_menu() {
			add_submenu_page( 'options-general.php', 'WP Developer Tools', 'WP Developer Tools',
				'manage_options', __FILE__, array( &$this, 'options_page' ) );
		}

		function admin_notices() {
		}

		function load_settings_page() {
			$this->settings_page = true;
		}

		// Settings page
		function options_page() {
			if (isset($_POST['checkall_quick_profiler'])) {
				foreach($this->filter_list as $filter) {
					update_option('wpdt_'.$filter,'checked');
				}

				update_option('wpdt_log_predefined_php','checked');
				echo "<div class='updated fade'><p>WP Developer Tools parameters saved.</p></div>";
			}

			if (isset($_POST['uncheckall_quick_profiler'])) {
				foreach($this->filter_list as $filter) {
					update_option('wpdt_'.$filter,' ');
				}
				update_option('wpdt_log_predefined_php',' ');
				echo "<div class='updated fade'><p>WP Developer Tools parameters saved.</p></div>";
			}

			if (isset($_POST['save_log_predefined_php'])) {
				if (isset($_POST['enable_quick_profiler'])) {
					update_option('wpdt_quick_profiler',TRUE);
				} else {
					update_option('wpdt_quick_profiler',FALSE);
				}
				echo "<div class='updated fade'><p>WP Developer Tools parameters saved.</p></div>";
			}

			if (isset($_POST['save_quick_profiler'])) {
				if (isset($_POST['enable_quick_profiler'])) {
					update_option('wpdt_quick_profiler',TRUE);
				} else {
					update_option('wpdt_quick_profiler',FALSE);
				}

				if (isset($_POST['wpdt_log_predefined_php'])) {
					update_option('wpdt_log_predefined_php','checked');
				} else {
					update_option('wpdt_log_predefined_php',' ');
				}

				if (isset($_POST['qpopt'])) {
					foreach($this->filter_list as $filter) {
						if (get_option('wpdt_'.$filter) == false) {
							add_option('wpdt_'.$filter,' ');
						} else {
							update_option('wpdt_'.$filter,' ');
						}
					}

					$qpopts = $_POST['qpopt'];


					foreach($qpopts as $key => $qpopt) {
						$filter = $this->filter_list[$key];
						update_option('wpdt_'.$filter,'checked');
					}


				}

				echo "<div class='updated fade'><p>WP Developer Tools parameters saved.</p></div>";
			}

			$wpdt_quick_profiler = (get_option('wpdt_quick_profiler') == TRUE ? 'checked' : '');

?>
<div class="wrap">
	<h2>WP Developer Tools</h2>
	<div class="left">
		<br><br>
		<hr>
		<form name="qpform" method="post">
			<fieldset>
				<legend><h3><u>PHP Quick Profiler</u></h3></legend><br>
				<img src="<?php echo WP_PLUGIN_URL;?>/wp-developer-tools/images/wp-developer-tools.png" width="256" height="68"><br>
				<p><i>The profiler will automatically be disabled when the Admin has logged off!</i></p>
				Enable: <input type="checkbox" name="enable_quick_profiler" <?php echo $wpdt_quick_profiler; ?>></br>
				<input type="submit" name="save_log_predefined_php" value="Save">&nbsp;<small><i>This Save button is only for turning on the Profiler.</i></small><br>
			</fieldset>
			<fieldset>
				<legend><h4><u>Logging</u></h4></legend>
				<p><small><i>Use the Save button at the bottom for these settings.</i></small></p>
				<b>PHP Predefined Variables</b><br>
				<input type="checkbox" name="wpdt_log_predefined_php" <?php echo get_option('wpdt_log_predefined_php'); ?>>(<small><i>$_COOKIE,$_ENV,$_FILES,$_GET,$PHP_SELF,$_POST,$_REQUEST,$_SERVER,$_SESSION</i></small>)<br><br>
				<table>
					<th align="left">Post, Page &amp; Attachment</th>
					<th align="left">Comment, Trackback, &amp; Ping</th>
					<tr>
						<td>
							<table>
								<tr>
									<td><u>Database Reads</u><br></td>
									<td><u>Database Writes</u><br></td>
								</tr><tr>
									<td valign="top">
										<?php
											for($i=0;$i<36;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
									<td valign="top">
										<?php
											for($i=36;$i<56;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td><u>Database Reads</u></td>
									<td><u>Database Writes</u></td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=57;$i<70;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
    								</td>
    								<td valign="top">
										<?php
											for($i=70;$i<75;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
    								</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table>
					<th align="left">Category &amp; Term</th>
					<th align="left">Link</th>
					<th align="left">Date &amp; Time</th>
					<tr>
						<td valign="top">
							<table>
								<tr>
									<td><u>Database Reads</u></td>
									<td><u>Database Writes</u></td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=75;$i<88;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
									<td valign="top">
										<?php
											for($i=88;$i<91;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=91;$i<106;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=106;$i<117;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table>
					<th align="left">Author &amp; User</th>
					<th align="left">Blogroll</th>
					<th align="left">Blog Information &amp; Option</th>
					<th align="left">General Text</th>
					<tr>
						<td>
							<input type="checkbox" name="qpopt[117]" <?php echo get_option('wpdt_login_redirect'); ?>  >login_redirect <br>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">
							<table>
								<tr>
									<td><u>Database Reads</u></td>
									<td><u>Database Writes</u></td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=118;$i<135;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
									<td valign="top">
										<?php
											for($i=135;$i<153;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td valign="top">
										<?php
											for($i=153;$i<166;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>
										<?php
											for($i=166;$i<174;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>
										<?php
											for($i=174;$i<176;$i++) {
												echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
											}
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table>
					<th align="left">Template</th>
					<th align="left">Advance Wordpress</th>
					<th align="left">Widgets</th>
					<tr>
						<td valign="top">
							<table>
								<tr><td>
									<?php
										for($i=176;$i<200;$i++) {
											echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
										}
									?>
								</td></tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr><td>
									<?php
										for($i=200;$i<248;$i++) {
											echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
										}
									?>
								</td></tr>
							</table>
						</td>
						<td valign="top">
							<table>
								<tr><td>
									<?php
										for($i=248;$i<254;$i++) {
											echo '<input type="checkbox" name="qpopt['.$i.']" '.get_option('wpdt_'.$this->filter_list[$i]).' >'.$this->filter_list[$i].'<br>';
										}
									?>
								</td></tr>
							</table>
						</td>
					</tr>
				</table>
				<input type="submit" name="save_quick_profiler" value="Save">&nbsp;<input type="submit" name="checkall_quick_profiler" value="Check all">&nbsp;<input type="submit" name="uncheckall_quick_profiler" value="Uncheck All"><br>
			</fieldset>
		</form>
	</div>
</div>
<?php
		}
	}

	$WP_developer_tools = new WP_Developer_Tools();

	function wpdt_log($message) {
		Console::log($message);
	}

	function wpdt_log_memory($object) {
		Console::logMemory($object);
	}

	function wpdt_log_error($exception,$message) {
		Console::logError($exception,$message);
	}

	function wpdt_log_speed($name) {
		Console::logSpeed($name);
	}

	/**
	 *
	 * Hook Procedures
	 * @param string $content
	 */
	function wpdt_attachment_fields_to_edit($content) {
		Console::log($content,'attachment_fields_to_edit');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_attachment_icon($content) {
		Console::log($content,'attachment_icon');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_attachment_innerHTML($content) {
		Console::log($content,'attachment_innerHTML');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_content_edit_pre($content) {
		Console::log($content,'content_edit_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_excerpt_edit_pre($content) {
		Console::log($content,'excerpt_edit_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_attached_file($content) {
		Console::log($content,'get_attached_file');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_enclosed($content) {
		Console::log($content,'get_enclosed');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_pages($content) {
		Console::log($content,'get_pages');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_pung($content) {
		Console::log($content,'get_pung');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_the_excerpt($content) {
		Console::log($content,'the_excerpt');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_the_guid($content) {
		Console::log($content,'the_guid');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_get_to_ping($content) {
		Console::log($content,'to_ping');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_icon_dir($content) {
		Console::log($content,'icon_dir');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_icon_dir_uri($content) {
		Console::log($content,'icon_dir_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_prepend_attachment($content) {
		Console::log($content,'prepend_attachment');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_sanitize_title($content) {
		Console::log($content,'sanitize_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_single_post_title($content) {
		Console::log($content,'post_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_content($content) {
		Console::log($content,'the_content');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_content_rss($content) {
		Console::log($content,'the_content_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_content_feed($content) {
		Console::log($content,'the_content_feed');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_editor_content($content) {
		Console::log($content,'the_editor_content');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_excerpt($content) {
		Console::log($content,'the_excerpt');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_excerpt_rss($content) {
		Console::log($content,'the_excerpt_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_tags($content) {
		Console::log($content,'the_tags');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_title($content) {
		Console::log($content,'the_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_the_title_rss($content) {
		Console::log($content,'the_title_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_title_edit_pre($content) {
		Console::log($content,'title_edit_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_dropdown_pages($content) {
		Console::log($content,'wp_dropdown_pages');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_list_pages($content) {
		Console::log($content,'wp_list_pages');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_list_pages_excludes($content) {
		Console::log($content,'wp_list_pages_excludes');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_get_attachment_metadata($content) {
		Console::log($content,'wp_get_attachment_metadata');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_get_attachment_thumb_file($content) {
		Console::log($content,'wp_get_attachment_thumb_file');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_get_attachment_thumb_url($content) {
		Console::log($content,'wp_get_attachment_thumb_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_get_attachment_url($content) {
		Console::log($content,'wp_get_attachment_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_mime_type_icon($content) {
		Console::log($content,'wp_mime_type_icon');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_title($content) {
		Console::log($content,'wp_title');
		Console::logMemory();
		Console::logMemory($content,'wp_title');
		Console::logSpeed();
		return $content;
	}
	function wpdt_add_ping($content) {
		Console::log($content,'add_ping');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_attachment_fields_to_save($content) {
		Console::log($content,'attachment_fields_to_save');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_attachment_max_dims($content) {
		Console::log($content,'attachment_max_dims');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_save_pre($content) {
		Console::log($content,'category_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_status_pre($content) {
		Console::log($content,'comment_status_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_content_filtered_save_pre($content) {
		Console::log($content,'content_filtered_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_content_save_pre($content) {
		Console::log($content,'content_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_excerpt_save_pre($content) {
		Console::log($content,'excerpt_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_name_save_pre($content) {
		Console::log($content,'name_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_phone_content($content) {
		Console::log($content,'phone_content');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_ping_status_pre($content) {
		Console::log($content,'ping_status_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_mime_type_pre($content) {
		Console::log($content,'post_mime_type_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_status_save_pre($content) {
		Console::log($content,'status_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_thumbnail_filename($content) {
		Console::log($content,'thumbnail_filename');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_thumbnail_creation_size_limit($content) {
		Console::log($content,'wp_thumbnail_creation_size_limit');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_thumbnail_max_side_length($content) {
		Console::log($content,'wp_thumbnail_max_side_length');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_title_save_pre($content) {
		Console::log($content,'title_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_update_attached_file($content) {
		Console::log($content,'update_attached_file');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_delete_file($content) {
		Console::log($content,'wp_delete_file');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_generate_attachment_metadata($content) {
		Console::log($content,'wp_generate_attachment_metadata');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_update_attachment_metadata($content) {
		Console::log($content,'wp_update_attachment_metadata');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_excerpt($content) {
		Console::log($content,'comment_excerpt');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_flood_filter($content) {
		Console::log($content,'comment_flood_filter');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_post_redirect($content) {
		Console::log($content,'comment_post_redirect');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_text($content) {
		Console::log($content,'comment_text');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_text_rss($content) {
		Console::log($content,'comment_text_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comments_array($content) {
		Console::log($content,'comments_array');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comments_number($content) {
		Console::log($content,'comments_number');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_excerpt($content) {
		Console::log($content,'get_comment_excerpt');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_ID($content) {
		Console::log($content,'get_comment_ID');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_text($content) {
		Console::log($content,'get_comment_text');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_type($content) {
		Console::log($content,'get_comment_type');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comments_number($content) {
		Console::log($content,'get_comments_number');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_comments_feed_link($content) {
		Console::log($content,'post_comments_feed_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_save_pre($content) {
		Console::log($content,'comment_save_pre');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_approved($content) {
		Console::log($content,'pre_comment_approved');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_content($content) {
		Console::log($content,'pre_comment_content');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_preprocess_comment($content) {
		Console::log($content,'preprocess_comment');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_insert_post_data($content) {
		Console::log($content,'wp_insert_post_data');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_description($content) {
		Console::log($content,'category_description');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_feed_link($content) {
		Console::log($content,'category_feed_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_link($content) {
		Console::log($content,'category_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_categories($content) {
		Console::log($content,'get_categories');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_category($content) {
		Console::log($content,'get_category');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_list_cats($content) {
		Console::log($content,'list_cats');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_list_cats_exclusions($content) {
		Console::log($content,'list_cats_exclusions');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_single_cat_title($content) {
		Console::log($content,'single_cat_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_category($content) {
		Console::log($content,'the_category');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_category_rss($content) {
		Console::log($content,'the_category_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_dropdown_cats($content) {
		Console::log($content,'wp_dropdown_cats');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_list_categories($content) {
		Console::log($content,'wp_list_categories');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_get_object_terms($content) {
		Console::log($content,'wp_get_object_terms');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_category_description($content) {
		Console::log($content,'pre_category_description');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_category_name($content) {
		Console::log($content,'pre_category_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_category_nicename($content) {
		Console::log($content,'pre_category_nicename');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_attachment_link($content) {
		Console::log($content,'attachment_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_author_feed_link($content) {
		Console::log($content,'author_feed_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_author_link($content) {
		Console::log($content,'author_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_reply_link($content) {
		Console::log($content,'comment_reply_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_day_link($content) {
		Console::log($content,'day_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_feed_link($content) {
		Console::log($content,'feed_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author_link($content) {
		Console::log($content,'comment_author_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author_url_link($content) {
		Console::log($content,'get_comment_author_url_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_month_link($content) {
		Console::log($content,'month_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_page_link($content) {
		Console::log($content,'page_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_link($content) {
		Console::log($content,'post_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_type_link($content) {
		Console::log($content,'post_type_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_permalink($content) {
		Console::log($content,'the_permalink');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_year_link($content) {
		Console::log($content,'year_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_tag_link($content) {
		Console::log($content,'tag_link');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_date($content) {
		Console::log($content,'get_comment_date');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_time($content) {
		Console::log($content,'get_comment_time');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_the_modified_date($content) {
		Console::log($content,'the_modified_date');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_the_modified_time($content) {
		Console::log($content,'get_the_modified_time');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_the_time($content) {
		Console::log($content,'get_the_time');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_date($content) {
		Console::log($content,'the_date');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_modified_date($content) {
		Console::log($content,'the_modified_date');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_modified_time($content) {
		Console::log($content,'the_modified_time');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_time($content) {
		Console::log($content,'the_time');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_weekday($content) {
		Console::log($content,'the_weekday');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_weekday_date($content) {
		Console::log($content,'the_weekday_date');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_login_redirect($content) {
		Console::log($content,'login_redirect');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_author_email($content) {
		Console::log($content,'author_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_author($content) {
		Console::log($content,'comment_author');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_author_rss($content) {
		Console::log($content,'comment_author_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_email($content) {
		Console::log($content,'comment_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comment_url($content) {
		Console::log($content,'comment_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author($content) {
		Console::log($content,'get_comment_author');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author_email($content) {
		Console::log($content,'get_comment_author_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author_IP($content) {
		Console::log($content,'get_comment_author_IP');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_comment_author_url($content) {
		Console::log($content,'get_comment_author_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_login_errors($content) {
		Console::log($content,'login_errors');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_login_headertitle($content) {
		Console::log($content,'login_headertitle');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_login_headerurl($content) {
		Console::log($content,'login_headerurl');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_login_message($content) {
		Console::log($content,'login_message');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_sanitize_user($content) {
		Console::log($content,'sanitize_user');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_author($content) {
		Console::log($content,'the_author');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_author_email($content) {
		Console::log($content,'the_author_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_author_email($content) {
		Console::log($content,'pre_comment_author_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_author_name($content) {
		Console::log($content,'pre_comment_author_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_author_url($content) {
		Console::log($content,'pre_comment_author_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_user_agent($content) {
		Console::log($content,'pre_comment_user_agent');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_comment_user_ip($content) {
		Console::log($content,'pre_comment_user_ip');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_id($content) {
		Console::log($content,'pre_user_id');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_description($content) {
		Console::log($content,'pre_user_description');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_display_name($content) {
		Console::log($content,'pre_user_display_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_email($content) {
		Console::log($content,'pre_user_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_first_name($content) {
		Console::log($content,'pre_user_first_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_last_name($content) {
		Console::log($content,'pre_user_last_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_login($content) {
		Console::log($content,'pre_user_login');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_nicename($content) {
		Console::log($content,'pre_user_nicename');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_nickname($content) {
		Console::log($content,'pre_user_nickname');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_user_url($content) {
		Console::log($content,'pre_user_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_registration_errors($content) {
		Console::log($content,'registration_errors');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_user_registration_email($content) {
		Console::log($content,'user_registration_email');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_validate_username($content) {
		Console::log($content,'validate_username');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_bookmarks($content) {
		Console::log($content,'get_bookmarks');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_link_category($content) {
		Console::log($content,'link_category');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_link_description($content) {
		Console::log($content,'link_description');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_link_rating($content) {
		Console::log($content,'link_rating');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_link_title($content) {
		Console::log($content,'link_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_description($content) {
		Console::log($content,'pre_link_description');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_image($content) {
		Console::log($content,'pre_link_image');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_name($content) {
		Console::log($content,'pre_link_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_notes($content) {
		Console::log($content,'pre_link_notes');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_rel($content) {
		Console::log($content,'pre_link_rel');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_rss($content) {
		Console::log($content,'pre_link_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_target($content) {
		Console::log($content,'pre_link_target');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_pre_link_url($content) {
		Console::log($content,'pre_link_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_all_options($content) {
		Console::log($content,'all_options');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_bloginfo($content) {
		Console::log($content,'bloginfo');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_bloginfo_rss($content) {
		Console::log($content,'bloginfo_rss');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_bloginfo_url($content) {
		Console::log($content,'bloginfo_url');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_loginout($content) {
		Console::log($content,'loginout');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_register($content) {
		Console::log($content,'register');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_upload_dir($content) {
		Console::log($content,'upload_dir');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_upload_mimes($content) {
		Console::log($content,'upload_mimes');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_attribute_escape($content) {
		Console::log($content,'attribute_escape');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_js_escape($content) {
		Console::log($content,'js_escape');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

	function wpdt_locale_stylesheet_uri($content) {
		Console::log($content,'locale_stylesheet_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_stylesheet($content) {
		Console::log($content,'stylesheet');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_stylesheet_directory($content) {
		Console::log($content,'stylesheet_directory');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_stylesheet_directory_uri($content) {
		Console::log($content,'stylesheet_directory_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_stylesheet_uri($content) {
		Console::log($content,'stylesheet_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_template($content) {
		Console::log($content,'template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_template_directory($content) {
		Console::log($content,'template_directory');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_template_directory_uri($content) {
		Console::log($content,'template_directory_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_theme_root($content) {
		Console::log($content,'theme_root');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_theme_root_uri($content) {
		Console::log($content,'theme_root_uri');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_404_template($content) {
		Console::log($content,'404_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_archive_template($content) {
		Console::log($content,'archive_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_attachment_template($content) {
		Console::log($content,'attachment_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_author_template($content) {
		Console::log($content,'author_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_template($content) {
		Console::log($content,'category_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comments_popup_template($content) {
		Console::log($content,'comments_popup_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comments_template($content) {
		Console::log($content,'comments_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_date_template($content) {
		Console::log($content,'date_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_home_template($content) {
		Console::log($content,'home_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_page_template($content) {
		Console::log($content,'page_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_paged_template($content) {
		Console::log($content,'paged_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_search_template($content) {
		Console::log($content,'search_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_single_template($content) {
		Console::log($content,'single_template');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_template_include($content) {
		Console::log($content,'template_include');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_allowed_redirect_hosts($content) {
		Console::log($content,'allowed_redirect_hosts');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_author_rewrite_rules($content) {
		Console::log($content,'author_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_category_rewrite_rules($content) {
		Console::log($content,'category_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_comments_rewrite_rules($content) {
		Console::log($content,'comments_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_create_user_query($content) {
		Console::log($content,'create_user_query');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_date_rewrite_rules($content) {
		Console::log($content,'date_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_found_posts($content) {
		Console::log($content,'found_posts');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_found_posts_query($content) {
		Console::log($content,'found_posts_query');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_editable_authors($content) {
		Console::log($content,'get_editable_authors');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_gettext($content) {
		Console::log($content,'gettext');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_override_load_textdomain($content) {
		Console::log($content,'override_load_textdomain');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_next_post_join($content) {
		Console::log($content,'get_next_post_join');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_next_post_sort($content) {
		Console::log($content,'get_next_post_sort');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_next_post_where($content) {
		Console::log($content,'get_next_post_where');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_others_drafts($content) {
		Console::log($content,'get_others_drafts');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_previous_post_join($content) {
		Console::log($content,'get_previous_post_join');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_previous_post_sort($content) {
		Console::log($content,'get_previous_post_sort');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_previous_post_where($content) {
		Console::log($content,'get_previous_post_where');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_get_users_drafts($content) {
		Console::log($content,'get_users_drafts');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_locale($content) {
		Console::log($content,'locale');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_mod_rewrite_rules($content) {
		Console::log($content,'mod_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_limits($content) {
		Console::log($content,'post_limits');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_distinct($content) {
		Console::log($content,'posts_distinct');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_fields($content) {
		Console::log($content,'posts_fields');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_groupby($content) {
		Console::log($content,'posts_groupby');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_join_paged($content) {
		Console::log($content,'posts_join_paged');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_orderby($content) {
		Console::log($content,'posts_orderby');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_request($content) {
		Console::log($content,'posts_request');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_rewrite_rules($content) {
		Console::log($content,'post_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_root_rewrite_rules($content) {
		Console::log($content,'root_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_page_rewrite_rules($content) {
		Console::log($content,'page_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_where_paged($content) {
		Console::log($content,'posts_where_paged');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_join($content) {
		Console::log($content,'posts_join');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_posts_where($content) {
		Console::log($content,'posts_where');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_query_string($content) {
		Console::log($content,'query_string');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_query_vars($content) {
		Console::log($content,'query_vars');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_request($content) {
		Console::log($content,'request');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_rewrite_rules_array($content) {
		Console::log($content,'rewrite_rules_array');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_search_rewrite_rules($content) {
		Console::log($content,'search_rewrite_rules');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_the_posts($content) {
		Console::log($content,'the_posts');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_excerpt_length($content) {
		Console::log($content,'excerpt_length');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_excerpt_more($content) {
		Console::log($content,'excerpt_more');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_post_edit_form_tag($content) {
		Console::log($content,'post_edit_form_tag');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_update_user_query($content) {
		Console::log($content,'update_user_query');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_redirect($content) {
		Console::log($content,'wp_redirect');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_xmlrpc_methods($content) {
		Console::log($content,'xmlrpc_methods');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_mail_from($content) {
		Console::log($content,'wp_mail_from');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_wp_mail_from_name($content) {
		Console::log($content,'wp_mail_from_name');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_archives_dropdown_args($content) {
		Console::log($content,'widget_archives_dropdown_args');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_links_args($content) {
		Console::log($content,'widget_links_args');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_pages_args($content) {
		Console::log($content,'widget_pages_args');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_tag_cloud_args($content) {
		Console::log($content,'widget_tag_cloud_args');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_text($content) {
		Console::log($content,'widget_text');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}
	function wpdt_widget_title($content) {
		Console::log($content,'widget_title');
		Console::logMemory();
		Console::logSpeed();
		return $content;
	}

}
?>