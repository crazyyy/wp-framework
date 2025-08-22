<?php

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * Handles converting the audit log's details column to a text representation
 */
class AIOWPSecurity_Audit_Text_Handler {

	/**
	 * Return the text version of 'successful_login' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function successful_login_to_text($info) {
		/* translators: %s: User name */
		return sprintf(__('Successful login with username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
	}

	/**
	 * Return the text version of 'successful_logout' event
	 *
	 * @param array $info - contains info used to generate the returned string
	 *
	 * @return string - the text to be shown for details on audit log table
	 */
	public static function successful_logout_to_text($info) {
		return __('Successful logout with username:', 'all-in-one-wp-security-and-firewall') . ' ' . $info['username'] . ' ' . $info['force_logout'];
	}
	
	/**
	 * Return the text version of 'core_updated' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function core_updated_to_text($info) {
		/* translators: 1: Old version, 2: New version */
		return sprintf(__('WordPress updated from version %1$s to %2$s', 'all-in-one-wp-security-and-firewall'), $info['old_version'], $info['new_version']);
	}

	/**
	 * Return the text version of 'plugin' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function plugin_to_text($info) {
		return sprintf(__('Plugin', 'all-in-one-wp-security-and-firewall').': %s %s %s (v%s)', $info['name'], $info['network'], $info['action'], $info['version']);
	}

	/**
	 * Return the text version of 'theme' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function theme_to_text($info) {
		if ('activated' == $info['action']) {
			return sprintf(__('Theme', 'all-in-one-wp-security-and-firewall').': %s %s', $info['name'], $info['action']);
		} else {
			return sprintf(__('Theme', 'all-in-one-wp-security-and-firewall').': %s %s %s (v%s)', $info['name'], $info['network'], $info['action'], $info['version']);
		}
	}

	/**
	 * Return the text version of 'entity_changed' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function entity_changed_to_text($info) {
		if ($info['entity']) {
			/* translators: %s: Entity name */
			return sprintf(__('Entity: "%s" has changed, please check the stacktrace for more details', 'all-in-one-wp-security-and-firewall'), $info['entity']);
		} else {
			return __('An unknown entity has changed, please check the stacktrace for more details', 'all-in-one-wp-security-and-firewall');
		}
	}

	/**
	 * Return the text version of 'translation_updated' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function translation_updated_to_text($info) {
		if ('core' == $info['type']) {
			/* translators: 1: Language name, 2: Version */
			return sprintf(__('Core %1$s translations updated to version %2$s', 'all-in-one-wp-security-and-firewall'), $info['language'], $info['version']);
		} elseif ('plugin' == $info['type']) {
			/* translators: 1: Slug, 2: Language, 3: Version */
			return sprintf(__('Plugin "%1$s" %2$s translations updated to version %3$s', 'all-in-one-wp-security-and-firewall'), $info['slug'], $info['language'], $info['version']);
		} elseif ('theme' == $info['type']) {
			/* translators: 1: Slug, 2: Language name, 3: Version */
			return sprintf(__('Theme "%1$s" %2$s translations updated to version %3$s', 'all-in-one-wp-security-and-firewall'), $info['slug'], $info['language'], $info['version']);
		}
	}

	/**
	 * Return the text version of 'failed_login' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function failed_login_to_text($info) {
		if ($info['imported']) {
			return __('Event imported from the failed logins table', 'all-in-one-wp-security-and-firewall');
		} elseif ($info['known']) {
			/* translators: %s: User name */
			return sprintf(__('Failed login attempt with a known username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
		} else {
			/* translators: %s: User name */
			return sprintf(__('Failed login attempt with a unknown username: %s', 'all-in-one-wp-security-and-firewall'), $info['username']);
		}
	}

	/**
	 * Return the text version of 'user_registration' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function user_registration_to_text($info) {
		if ('admin' == $info['type']) {
			/* translators: 1: Admin User name, 2: Registered User name */
			return sprintf(__('Admin %1$s registered new user: %2$s', 'all-in-one-wp-security-and-firewall'), $info['admin_username'], $info['registered_username']);
		} elseif ('pending' == $info['type']) {
			/* translators: %s: Registered User name */
			return sprintf(__('User %s registered and set to pending', 'all-in-one-wp-security-and-firewall'), $info['registered_username']);
		} elseif ('registered' == $info['type']) {
			/* translators: %s: Registered User name */
			return sprintf(__('User %s registered', 'all-in-one-wp-security-and-firewall'), $info['registered_username']);
		}
	}

	/**
	 * Return the text version of 'table_migration' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function table_migration_to_text($info) {
		if ($info['success']) {
			/* translators: 1: From table, 2: To table */
			return sprintf(__('Successfully migrated the `%1$s` table data to the `%2$s` table', 'all-in-one-wp-security-and-firewall'), $info['from_table'], $info['to_table']);
		} else {
			/* translators: 1: From table, 2: To table */
			return sprintf(__('Failed to migrate the `%1$s` table data to the `%2$s` table', 'all-in-one-wp-security-and-firewall'), $info['from_table'], $info['to_table']);
		}
	}

	/**
	 * Return the text version of 'firewall_event' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function firewall_event_to_text($info) {
		$output = '';
		switch ($info['event']) {
			case 'triggered':
				/* translators: 1: Rule name, 2: Rule family */
				$output = sprintf(__('"%1$s [%2$s]" rule has been triggered.', 'all-in-one-wp-security-and-firewall'),  $info['rule_name'], $info['rule_family']);
				break;
			case 'not_triggered':
				/* translators: 1: Rule name, 2: Rule family */
				$output = sprintf(__('"%1$s [%2$s]" rule was not triggered.', 'all-in-one-wp-security-and-firewall'),  $info['rule_name'], $info['rule_family']);
				break;
			case 'active':
				/* translators: 1: Rule name, 2: Rule family */
				$output = sprintf(__('"%1$s [%2$s]" rule is active.', 'all-in-one-wp-security-and-firewall'),  $info['rule_name'], $info['rule_family']);
				break;
			case 'not_active':
				/* translators: 1: Rule name, 2: Rule family */
				$output = sprintf(__('"%1$s [%2$s]" rule is not active.', 'all-in-one-wp-security-and-firewall'),  $info['rule_name'], $info['rule_family']);
				break;
			default:
				$output = array(
					'status' => $info['event'],
					'rule_name' => $info['rule_name'],
					'rule_family' => $info['rule_family'],
				);
				break;
		}

		// Add a link to the rule, if present
		if (isset($info['location'])) {
			$output .= "<br><br><a href='{$info['location']}'target='_blank'>".__('Configure this rule', 'all-in-one-wp-security-and-firewall').'</a>';
		}

		return is_array($output) ? wp_json_encode($output) : $output;
	}

	/**
	 * Return the text version of 'password_reset' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function password_reset_to_text($info) {
		/* translators: %s: User login */
		return sprintf(__('Password for user account: `%s` successfully changed', 'all-in-one-wp-security-and-firewall'), $info['user_login']);
	}

	/**
	 * Return the text version of 'user_deleted' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function user_deleted_to_text($info) {
		if (empty($info['reassign'])) {
			/* translators: 1: User login, 2: User ID */
			return sprintf(__('User account: %1$s with ID: `%2$s` has been deleted', 'all-in-one-wp-security-and-firewall'), $info['user_login'], $info['user_id']);
		} else {
			/* translators: 1: User login, 2: User ID, 3: Reassign */
			return sprintf(__('User account: `%1$s` with ID: `%2$s` has been deleted and all content has been reassigned to user with ID: `%3$s`', 'all-in-one-wp-security-and-firewall'), $info['user_login'], $info['user_id'], $info['reassign']);
		}
	}

	/**
	 * Return the text version of 'user_removed' event
	 *
	 * @param array $info
	 * @return string
	 */
	public static function user_removed_to_text($info) {
		if (empty($info['reassign'])) {
			/* translators: 1: User login, 2: User ID, 3: Blog ID */
			return sprintf(__('User account: %1$s with ID: `%2$s` has been removed from the blog with ID: `%3$s`', 'all-in-one-wp-security-and-firewall'), $info['user_login'], $info['user_id'], $info['blog_id']);
		} else {
			/* translators: 1: User login, 2: User ID, 3: Blog ID, 4: Reassign */
			return sprintf(__('User account: `%1$s` with ID: `%2$s` has been removed from the blog with ID: `%3$s` and all content has been reassigned to user with  ID: `%4$s`', 'all-in-one-wp-security-and-firewall'), $info['user_login'], $info['user_id'], $info['blog_id'], $info['reassign']);
		}
	}
}
