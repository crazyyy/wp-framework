<?php

/* Parent class for all admin menu classes */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

abstract class AIOWPSecurity_Admin_Menu {
	
	/**
	 * Specify the menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug;

	/**
	 * Specify all the tabs of this menu
	 *
	 * @var array
	 */
	protected $menu_tabs;

	/**
	 * Constructor adds a admin menu
	 */
	public function __construct($title) {
		$this->setup_menu_tabs();
		$this->render_page($title);
	}

	/**
	 * Render the menu page
	 *
	 * @param string $title - the page title
	 *
	 * @return void
	 */
	protected function render_page($title) {
		$current_tab = $this->get_current_tab();
		?>
		<div class="wrap">
			<h2><?php echo esc_html($title); ?></h2>
			<?php $this->render_tabs($current_tab); ?>
			<div id="poststuff">
				<div id="post-body">
					<?php call_user_func($this->menu_tabs[$current_tab]['render_callback']); ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the menu tabs for this page
	 *
	 * @param string $current_tab - the current tab
	 *
	 * @return void
	 */
	protected function render_tabs($current_tab) {
		echo '<h2 class="nav-tab-wrapper">';
		foreach ($this->menu_tabs as $tab_key => $tab_info) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menu_page_slug . '&tab=' . $tab_key . '">' . esc_html($tab_info['title']) . '</a>';
		}
		echo '</h2>';
	}

	/**
	 * Get valid current tab slug.
	 *
	 * @return string - current valid tab slug or empty string
	 */
	protected function get_current_tab() {
		if (is_array($this->menu_tabs) && !empty($this->menu_tabs)) {
			$tab_keys = array_keys($this->menu_tabs);
			if (empty($_GET['tab'])) {
				return $tab_keys[0];
			} else {
				$current_tab = sanitize_text_field($_GET['tab']);
				return in_array($current_tab, $tab_keys) ? $current_tab : $tab_keys[0];
			}
		} else {
			return '';
		}
	}

	/**
	 * This function checks to see if there is a display condition for the tab and if so runs it otherwise it returns true to display the tab
	 *
	 * @param array $tab_info - the tab information array contains keys like title, render_callback and display_condition_callback
	 *
	 * @return boolean - true if the tab should be displayed or false to hide it
	 */
	protected function should_display_tab($tab_info) {
		if (!empty($tab_info['display_condition_callback']) && is_callable($tab_info['display_condition_callback'])) {
			return call_user_func($tab_info['display_condition_callback']);
		} elseif (!empty($tab_info['display_condition_callback']) && !is_callable($tab_info['display_condition_callback'])) {
			error_log("Callback function set but not callable (coding error)");
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Shows postbox for settings menu
	 *
	 * @param string $id css ID for postbox
	 * @param string $title title of the postbox section
	 * @param string $content the content of the postbox
	 **/
	protected function postbox_toggle($id, $title, $content) {
		//Always send string with translation markers in it
		?>
		<div id="<?php echo $id; ?>" class="postbox">
			<div class="handlediv" title="<?php echo __('Press to toggle'); ?>"><br /></div>
			<h3 class="hndle"><span><?php echo $title; ?></span></h3>
			<div class="inside">
			<?php echo $content; ?>
			</div>
		</div>
		<?php
	}
	
	public function postbox($title, $content)  {
		// Always send string with translation markers in it
		?>
		<div class="postbox">
			<h3 class="hndle"><label for="title"><?php echo $title; ?></label></h3>
			<div class="inside">
				<?php echo $content; ?>
			</div>
		</div>
		<?php
	} 
	
	public function show_msg_settings_updated() {
		echo '<div id="message" class="updated fade"><p><strong>';
		_e('Settings successfully updated.','all-in-one-wp-security-and-firewall');
		echo '</strong></p></div>';
	}

	/**
	 * Renders record(s) successfully deleted message at top of page.
	 *
	 * @return Void
	 */
	public static function show_msg_record_deleted_st() {
		AIOWPSecurity_Admin_Menu::show_msg_updated_st(__('Successfully deleted the selected record(s).', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * Renders record(s) unsuccessfully deleted message at top of page.
	 *
	 * @return Void
	 */
	public static function show_msg_record_not_deleted_st() {
		AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to delete the selected record(s).', 'all-in-one-wp-security-and-firewall'));
	}

	public function show_msg_updated($msg) {
		echo '<div id="message" class="updated fade"><p><strong>';
		echo $msg;
		echo '</strong></p></div>';
	}
	
	public static function show_msg_updated_st($msg) {
		echo '<div id="message" class="updated fade"><p><strong>';
		echo wp_kses_post($msg);
		echo '</strong></p></div>';
	}
	
	public function show_msg_error($error_msg) {
		echo '<div id="message" class="error"><p><strong>';
		echo wp_kses_post($error_msg);
		echo '</strong></p></div>';
	}
	
	public static function show_msg_error_st($error_msg) {
		echo '<div id="message" class="error"><p><strong>';
		echo wp_kses_post($error_msg);
		echo '</strong></p></div>';
	}
	
	protected function start_buffer() {
		ob_start();
	}
	
	protected function end_buffer_and_collect() {
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}
