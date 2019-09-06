<?php
	
	/**
	 * This class configures the parameters advanced
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2017 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WbcrCmp_ConfigComments extends Wbcr_FactoryClearfy206_Configurate {

		private $modified_types = array();

		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			parent::__construct($plugin);
			$this->plugin = $plugin;
		}

		public function registerActionsAndFilters()
		{
			// These need to happen now
			if( $this->isDisabledAllPosts() ) {
				add_action('widgets_init', array($this, 'disableRcWidget'));
				add_action('template_redirect', array($this, 'filterQuery'), 9);    // before redirect_canonical

				// Admin bar filtering has to happen here since WP 3.6
				add_action('template_redirect', array($this, 'filterAdminBar'));
				add_action('admin_init', array($this, 'filterAdminBar'));
			} else {

				if( $this->getPopulateOption('comment_text_convert_links_pseudo') || $this->getPopulateOption('pseudo_comment_author_link') ) {
					add_action('wp_enqueue_scripts', array($this, 'assetsUrlSpanScripts'));
				}

				if( $this->getPopulateOption('comment_text_convert_links_pseudo') ) {
					add_filter('comment_text', array($this, 'commentTextConvertLinksPseudo'));
				}

				if( $this->getPopulateOption('pseudo_comment_author_link') ) {
					add_filter('get_comment_author_link', array($this, 'pseudoCommentAuthorLink'), 100, 3);
				}

				if( $this->getPopulateOption('remove_url_from_comment_form') ) {
					add_filter('comment_form_default_fields', array($this, 'removeUrlFromCommentForm'));
				}
			}

			// These can happen later
			//add_action('plugins_loaded', array($this, 'register_text_domain'));
			add_action('wp_loaded', array($this, 'initWploadedFilters'));
		}

		/*
	     * Remove comment links from the admin bar in a multisite network.
	     */
		public function removeNetworkCommentLinks($wp_admin_bar)
		{
			if( $this->plugin->isNetworkActive() && is_user_logged_in() ) {
				foreach((array)$wp_admin_bar->user->blogs as $blog) {
					$wp_admin_bar->remove_menu('blog-' . $blog->userblog_id . '-c');
				}
			} else {
				// We have no way to know whether the plugin is active on other sites, so only remove this one
				$wp_admin_bar->remove_menu('blog-' . get_current_blog_id() . '-c');
			}
		}

		private function isDisabledAllPosts()
		{
			return $this->getPopulateOption('disable_comments', 'enable_comments') == 'disable_comments';
		}

		private function isDisabledCertainPostTypes()
		{
			return $this->getPopulateOption('disable_comments', 'enable_comments') == 'disable_certain_post_types_comments';
		}

		private function isEnabledComments()
		{
			return $this->getPopulateOption('disable_comments', 'enable_comments') == 'enable_comments';
		}

		/*
		 * Get an array of disabled post type.
		 */
		private function getDisabledPostTypes()
		{
			return wbcr_cmp_get_disabled_post_types();
		}

		/*
	      * Check whether comments have been disabled on a given post type.
		 */
		private function isPostTypeDisabled($type)
		{
			return $this->isDisabledCertainPostTypes() && in_array($type, $this->getDisabledPostTypes());
		}

		public function initWploadedFilters()
		{
			$disabled_post_types = $this->getDisabledPostTypes();

			if( !empty($disabled_post_types) && !$this->isEnabledComments() ) {
				foreach($disabled_post_types as $type) {
					// we need to know what native support was for later
					if( post_type_supports($type, 'comments') ) {
						$this->modified_types[] = $type;
						remove_post_type_support($type, 'comments');
						remove_post_type_support($type, 'trackbacks');
					}
				}
				add_filter('comments_array', array($this, 'filterExistingComments'), 20, 2);
				add_filter('comments_open', array($this, 'filterCommentStatus'), 20, 2);
				add_filter('pings_open', array($this, 'filterCommentStatus'), 20, 2);
			}

			// Filters for the admin only
			if( is_admin() ) {
				add_action('admin_print_footer_scripts', array($this, 'discussionNotice'));

				// if only certain types are disabled, remember the original post status
				if( !$this->isDisabledAllPosts() ) {
					add_action('edit_form_advanced', array($this, 'editFormInputs'));
					add_action('edit_page_form', array($this, 'editFormInputs'));
				} else {
					add_action('admin_menu', array($this, 'filterAdminMenu'), 9999);    // do this as late as possible
					add_action('admin_print_footer_scripts-index.php', array($this, 'dashboardJs'));
					add_action('wp_dashboard_setup', array($this, 'filterDashboard'));
					add_filter('pre_option_default_pingback_flag', '__return_zero');
				}
			} // Filters for front end only
			else {
				add_action('template_redirect', array($this, 'checkCommentTemplate'));

				if( $this->isDisabledAllPosts() ) {
					add_filter('feed_links_show_comments_feed', '__return_false');
				}
			}
		}

		/*
		 * Replace the theme's comment template with a blank one.
		 * To prevent this, define DISABLE_COMMENTS_REMOVE_COMMENTS_TEMPLATE
		 * and set it to True
	    */
		public function checkCommentTemplate()
		{
			if( is_singular() && ($this->isDisabledAllPosts() || $this->isPostTypeDisabled(get_post_type())) ) {
				if( !defined('DISABLE_COMMENTS_REMOVE_COMMENTS_TEMPLATE') || DISABLE_COMMENTS_REMOVE_COMMENTS_TEMPLATE == true ) {
					// Kill the comments template.
					add_filter('comments_template', array($this, 'dummyCommentsTemplate'), 20);
				}
				// Remove comment-reply script for themes that include it indiscriminately
				wp_deregister_script('comment-reply');
				// feed_links_extra inserts a comments RSS link
				remove_action('wp_head', 'feed_links_extra', 3);
			}
		}

		public function dummyCommentsTemplate()
		{
			return WCM_PLUGIN_DIR . '/includes/comments-template.php';
		}

		/*
		 * Issue a 403 for all comment feed requests.
		 */
		public function filterQuery()
		{
			if( is_comment_feed() ) {
				wp_die(__('Comments are closed.'), '', array('response' => 403));
			}
		}

		/*
		 * Remove comment links from the admin bar.
		 */
		public function filterAdminBar()
		{
			if( is_admin_bar_showing() ) {
				// Remove comments links from admin bar
				remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
			}
			
			if( is_multisite() ) {
				add_action('admin_bar_menu', array($this, 'removeNetworkCommentLinks'), 500);
			}
		}

		public function editFormInputs()
		{
			global $post;
			// Without a dicussion meta box, comment_status will be set to closed on new/updated posts
			if( in_array($post->post_type, $this->modified_types) ) {
				echo '<input type="hidden" name="comment_status" value="' . $post->comment_status . '" /><input type="hidden" name="ping_status" value="' . $post->ping_status . '" />';
			}
		}

		public function discussionNotice()
		{
			$disabled_post_types = $this->getDisabledPostTypes();
			if( get_current_screen()->id == 'options-discussion' && !empty($disabled_post_types) ) {
				$names = array();
				foreach($disabled_post_types as $type) {
					$type_object = get_post_type_object($type);
					if( empty($type_object) ) {
						continue;
					}
					$names[$type] = $type_object->labels->name;
				}

				?>
				<script>
					jQuery(document).ready(function($) {
						$(".wrap h2").first().after(<?php echo json_encode( '<div style="color: #900"><p>' . sprintf( __( 'Note: The <em>%s</em> plugin is currently active, and comments are completely disabled on: %s. Many of the settings below will not be applicable for those post types.', 'comments-plus' ), $this->plugin->getPluginTitle(), implode(', ', $names ) ) . '</p></div>' );?>);
					});
				</script>
			<?php
			}
		}

		public function filterAdminMenu()
		{
			global $pagenow;

			if( $pagenow == 'comment.php' || $pagenow == 'edit-comments.php' || $pagenow == 'options-discussion.php' ) {
				wp_die(__('Comments are closed.'), '', array('response' => 403));
			}

			remove_menu_page('edit-comments.php');
			remove_submenu_page('options-general.php', 'options-discussion.php');
		}

		public function filterDashboard()
		{
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		}

		public function dashboardJs()
		{
			echo '<script>
		jQuery(function($){
			$("#dashboard_right_now .comment-count, #latest-comments").hide();
		 	$("#welcome-panel .welcome-comments").parent().hide();
		});
		</script>';
		}

		public function filterExistingComments($comments, $post_id)
		{
			$post = get_post($post_id);

			return ($this->isDisabledAllPosts() || $this->isPostTypeDisabled($post->post_type)) ? array() : $comments;
		}

		public function filterCommentStatus($open, $post_id)
		{
			$post = get_post($post_id);

			return ($this->isDisabledAllPosts() || $this->isPostTypeDisabled($post->post_type)) ? false : $open;
		}

		public function disableRcWidget()
		{
			unregister_widget('WP_Widget_Recent_Comments');
		}

		/**
		 * Convert links in comment text into span pseudo links
		 *
		 * @param $comment_text
		 * @return mixed
		 */

		public function commentTextConvertLinksPseudo($comment_text)
		{

			return $this->convertLinksPseudo($comment_text);
		}

		/**
		 * Convert links into span pseudo links
		 *
		 * @param $text
		 * @return mixed
		 */

		public function convertLinksPseudo($text)
		{

			return preg_replace_callback('/<a[^>]+href=[\'"](https?:\/\/[^"\']+)[\'"][^>]+>(.*?)<\/a>/i', array(
				$this,
				'replaceLinks'
			), $text);
		}

		public function replaceLinks($matches)
		{
			if( $matches[1] == get_home_url() ) {
				return $matches[0];
			}

			return '<span class="wbcr-clearfy-pseudo-link" data-uri="' . $matches[1] . '" > ' . $matches[2] . '</span>';
		}

		/**
		 * Convert author link to pseudo link
		 *
		 * @return string
		 */

		public function pseudoCommentAuthorLink($return, $author, $comment_ID)
		{
			$url = get_comment_author_url($comment_ID);
			$author = get_comment_author($comment_ID);

			if( empty($url) || 'http://' == $url ) {
				$return = $author;
			} else {
				$return = '<span class="wbcr-clearfy-pseudo-link" data-uri="' . $url . '">' . $author . '</span>';
			}

			return $return;
		}

		/**
		 * Remove url field from comment form
		 *
		 * @param $fields
		 * @return mixed
		 */

		public function removeUrlFromCommentForm($fields)
		{
			if( isset($fields['url']) ) {
				unset($fields['url']);
			}

			return $fields;
		}


		// todo: Убрать это грязное решение со скриптами.
		public function assetsUrlSpanScripts()
		{
			if( !is_singular() ) {
				return;
			}

			wp_enqueue_style('wbcr-comments-plus-url-span', WCM_PLUGIN_URL . '/assets/css/url-span.css', array(), $this->plugin->getPluginVersion());
			wp_enqueue_script('wbcr-comments-plus-url-span', WCM_PLUGIN_URL . '/assets/js/url-span.js', array('jquery'), $this->plugin->getPluginVersion(), true);
		}
	}
