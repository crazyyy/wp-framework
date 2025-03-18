<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

class WP_Optimization_usermeta extends WP_Optimization {

	public $ui_sort_order = 8001;

	public $available_for_auto = true;

	public $available_for_saving = true;

	public $auto_default = false;

	/**
	 * Prepare data for preview widget.
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function preview($params) {
		// get data requested for preview.
		// `$this->wpdb->prepare` is global `$wpdb->prepare`
		// phpcs:disable
		$sql = $this->wpdb->prepare(
			"SELECT um.* FROM `" . $this->wpdb->usermeta . "` um".
			" LEFT JOIN `" . $this->wpdb->users . "` wu ON wu.ID = um.user_id".
			" WHERE wu.ID IS NULL".
			" ORDER BY um.umeta_id LIMIT %d, %d;",
			array(
				$params['offset'],
				$params['limit'],
			)
		);

		$users = $this->wpdb->get_results($sql, ARRAY_A);
		// phpcs:enable

		// get total count user meta for optimization.
		$sql = "SELECT COUNT(*) FROM `" . $this->wpdb->usermeta . "` um LEFT JOIN `" . $this->wpdb->users . "` wu ON wu.ID = um.user_id WHERE wu.ID IS NULL;";

		$total = $this->wpdb->get_var($sql); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- safe, no user input used

		return array(
			'id_key' => 'umeta_id',
			'columns' => array(
				'umeta_id' => __('ID', 'wp-optimize'),
				'user_id' => __('User ID', 'wp-optimize'),
				'meta_key' => __('Meta Key', 'wp-optimize'),
				'meta_value' => __('Meta Value', 'wp-optimize'),
			),
			'offset' => $params['offset'],
			'limit' => $params['limit'],
			'total' => $total,
			'data' => $this->htmlentities_array($users, array('ID')),
			'message' => $total > 0 ? '' : __('No orphaned user meta data in your database', 'wp-optimize'),
		);
	}

	/**
	 * Do actions after optimize() function.
	 */
	public function after_optimize() {
		// translators: %s is the number of orphaned user metadata deleted
		$message = sprintf(_n('%s orphaned user meta data deleted', '%s orphaned user meta data deleted', $this->processed_count, 'wp-optimize'), number_format_i18n($this->processed_count));

		if ($this->is_multisite_mode()) {
			// translators: %s is the number sites
			$message .= ' ' . sprintf(_n('across %s site', 'across %s sites', count($this->blogs_ids), 'wp-optimize'), count($this->blogs_ids));
		}

		$this->logger->info($message);
		$this->register_output($message);
	}

	/**
	 * Do optimization.
	 */
	public function optimize() {
		$clean = "DELETE um FROM `" . $this->wpdb->usermeta . "` um LEFT JOIN `" . $this->wpdb->users . "` wu ON wu.ID = um.user_id WHERE wu.ID IS NULL";

		// if posted ids in params, then remove only selected items. used by preview widget.
		if (isset($this->data['ids'])) {
			$clean .= ' AND um.umeta_id in ('.join(',', $this->data['ids']).')';
		}

		$clean .= ";";

		$usermeta = $this->query($clean);
		$this->processed_count += $usermeta;
	}

	/**
	 * Do actions after get_info() function.
	 */
	public function after_get_info() {
		if ($this->found_count) {
			// translators: %s is the number of orphaned user metadata
			$message = sprintf(_n('%s orphaned user meta data in your database', '%s orphaned user meta data in your database', $this->found_count, 'wp-optimize'), number_format_i18n($this->found_count));
		} else {
			$message = __('No orphaned user meta data in your database', 'wp-optimize');
		}

		if ($this->is_multisite_mode()) {
			// translators: %s is the number sites
			$message .= ' ' . sprintf(_n('across %s site', 'across %s sites', count($this->blogs_ids), 'wp-optimize'), count($this->blogs_ids));
		}

		// add preview link to message.
		if ($this->found_count > 0) {
			$message = $this->get_preview_link($message);
		}

		$this->register_output($message);
	}

	/**
	 * Get count of unoptimized items.
	 */
	public function get_info() {
		$sql = "SELECT COUNT(*) FROM `" . $this->wpdb->usermeta . "` um LEFT JOIN `" . $this->wpdb->users . "` wu ON wu.ID = um.user_id WHERE wu.ID IS NULL;";
		$usermeta = $this->wpdb->get_var($sql); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- safe, no user input used

		$this->found_count += $usermeta;
	}

	/**
	 * Get settings label.
	 */
	public function settings_label() {
		return __('Clean user meta data', 'wp-optimize');
	}

	/**
	 * Get auto option description.
	 */
	public function get_auto_option_description() {
		return __('Remove orphaned user meta', 'wp-optimize');
	}
}
