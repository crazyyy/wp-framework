<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Spam_Menu extends AIOWPSecurity_Admin_Menu {
	
	/**
	 * Spam menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_SPAM_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Spam prevention
	 */
	public function __construct() {
		parent::__construct(__('Spam prevention', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'comment-spam' => array(
				'title' => __('Comment spam', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_comment_spam'),
			),
			'comment-spam-ip-monitoring' => array(
				'title' => __('Comment spam IP monitoring', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_comment_spam_ip_monitoring'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's comment spam ip monitoring tab body.
	 *
	 * @return Void
	 */
	protected function render_comment_spam() {
		global $aiowps_feature_mgr, $aio_wp_security;
		$aio_wp_security->include_template('wp-admin/spam-prevention/comment-spam.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Renders the submenu's comment spam ip monitoring tab body.
	 *
	 * @return Void
	 */
	protected function render_comment_spam_ip_monitoring() {
		global $aio_wp_security, $aiowps_feature_mgr, $wpdb;
		include_once 'wp-security-list-comment-spammer-ip.php'; // For rendering the AIOWPSecurity_List_Table in tab2
		$spammer_ip_list = new AIOWPSecurity_List_Comment_Spammer_IP();

		$block_comments_output = '';

		$min_block_comments = $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments_block');
		if (!empty($min_block_comments)) {
			$sql = $wpdb->prepare('SELECT * FROM '.AIOWPSEC_TBL_PERM_BLOCK.' WHERE block_reason=%s', 'spam');
			$total_res = $wpdb->get_results($sql);
			$block_comments_output = '<div class="aio_yellow_box">';
			if (empty($total_res)) {
				$block_comments_output .= '<p><strong>'.__('You currently have no IP addresses permanently blocked due to spam.', 'all-in-one-wp-security-and-firewall').'</strong></p></div>';
			} else {
				$total_count = count($total_res);
				$todays_blocked_count = 0;
				foreach ($total_res as $blocked_item) {
					$now_date_time = new DateTime('now', new DateTimeZone('UTC'));
					$blocked_date = new DateTime('@'.$blocked_item->created); //@ with timestamp creates correct DateTime
					if ($blocked_date->format('Y-m-d') == $now_date_time->format('Y-m-d')) {
						//there was an IP added to permanent block list today
						++$todays_blocked_count;
					}
				}
				$block_comments_output .= '<p><strong>'.__('Spammer IPs added to permanent block list today:', 'all-in-one-wp-security-and-firewall'). ' ' . $todays_blocked_count.'</strong></p>'.'<hr><p><strong>'.__('All time total:', 'all-in-one-wp-security-and-firewall'). ' ' .$total_count.'</strong></p>'.'<p><a class="button" href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=permanent-block" target="_blank">'.__('View blocked IPs', 'all-in-one-wp-security-and-firewall').'</a></p></div>';
			}
		}

		$page = $_REQUEST['page'];
		$tab = $_REQUEST['tab'];

		$aio_wp_security->include_template('wp-admin/spam-prevention/comment-spam-ip-monitoring.php', false, array('spammer_ip_list' => $spammer_ip_list, 'aiowps_feature_mgr' => $aiowps_feature_mgr, 'block_comments_output' => $block_comments_output, 'page' => $page, 'tab' => $tab));
	}
}
