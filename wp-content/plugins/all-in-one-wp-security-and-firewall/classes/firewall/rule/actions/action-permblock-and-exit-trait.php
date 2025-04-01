<?php
namespace AIOWPS\Firewall;

trait Action_Permblock_and_Exit_Trait {

	/**
	 * Use the forbid and exit trait
	 */
	use Action_Forbid_and_Exit_Trait {
		Action_Forbid_and_Exit_Trait::do_action as protected do_action_forbid_and_exit;
	}

	/**
	 * Holds the reason for the perm. block
	 *
	 * @var string
	 */
	private $permblock_reason = '';

	/**
	 * Holds the IP for the perm. block
	 *
	 * @var string
	 */
	private $permblock_ip = '';

	/**
	 * Sets the reason for the perm. block
	 *
	 * @param string $reason
	 * @return void
	 */
	public function set_perm_block_reason($reason) {
		$this->permblock_reason = $reason;
	}

	/**
	 * Sets the IP for the perm. block
	 *
	 * @param string $ip
	 * @return void
	 */
	public function set_perm_block_ip($ip) {
		$this->permblock_ip = $ip;
	}

	/**
	 * Permanently ban the IP and exit when the rule condition is satisfied.
	 *
	 * @return void
	 */
	public function do_action() {
		
		if (!Utility::attempt_to_access_wpdb()) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- PCP warning. Part of AIOS error reporting system.
			error_log('AIOS: Unable to access wpdb to ban IP address.');
			$this->do_action_forbid_and_exit();
		}
		
		global $wpdb;

		$table = $wpdb->prefix.'aiowps_permanent_block';

		$ip = empty($this->permblock_ip) ? \AIOS_Helper::get_user_ip_address() : $this->permblock_ip;

		$data = array(
			'blocked_ip'   => $ip,
			'block_reason' => empty($this->permblock_reason) ? 'firewall_generic' : $this->permblock_reason,
			'blocked_date' => current_time('mysql')
		);

		// Check if the IP already exists
		// phpcs:ignore WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- PCP error. Table name cannot be done via prepare.
		$already_exists = $wpdb->get_var($wpdb->prepare("SELECT blocked_ip FROM `{$table}` WHERE blocked_ip = %s", $ip));

		// If it does exist, no point adding it again so just forbid and exit
		if (!is_null($already_exists)) $this->do_action_forbid_and_exit();

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP error. Table name cannot be done via prepare.
		if (false === $wpdb->query($wpdb->prepare("INSERT INTO " .$table." (blocked_ip, block_reason, blocked_date, created) VALUES (%s, %s, %s, UNIX_TIMESTAMP())", $data['blocked_ip'], $data['block_reason'], $data['blocked_date']))) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- PCP warning. Needed for error reporting.
			error_log('AIOS: Unable to insert IP address into table.');
		}

		$this->do_action_forbid_and_exit();
	}

}
