<?php
namespace AIOWPS\Firewall;

class Allow_List {

	/**
	 * Include a file prefix when the file is created
	 */
	use File_Prefix_Trait;

	/**
	 * Holds the path to the allow list
	 *
	 * @var string
	 */
	private static $path;

	/**
	 * Overwrite the prefix description from File_Prefix_Trait
	 *
	 * @return string
	 */
	public static function get_prefix_description() {
		return " * The file is required for storing and retrieving your firewall's allow list.\n";
	}

	/**
	 * Checks whether the user's IP address is in the allow list
	 *
	 * @return bool
	 */
	public static function is_ip_allowed() {

		$ips = self::get_ips();

		if (empty($ips)) return false;

		$ips = explode("\n", $ips);

		return \AIOS_Helper::is_user_ip_address_within_list($ips);
	}

	/**
	 * Returns the list of IP addresses in the allow list
	 *
	 * @return string
	 */
	public static function get_ips() {

		clearstatcache();
		if (!file_exists(self::$path)) return '';

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Cannot use WP API. Firewall is loaded independent of WP.
		$contents = file_get_contents(self::$path, false, null, strlen(self::get_file_content_prefix()));

		return (false !== $contents ? trim($contents) : '');
	}

	/**
	 * Set the path of the allow list
	 *
	 * @param string $path
	 * @return void
	 */
	public static function set_path($path) {
		self::$path = $path;
	}

	/**
	 * Add IPs to the allow list
	 * This overwrites the whole allow list with the given IPs
	 *
	 * @param mixed $ips - A string of IPs; one per line or an array of individual IPs
	 * @return bool
	 */
	public static function add_ips($ips) {

		if (is_array($ips)) $ips = implode("\n", $ips);

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Cannot use WP API. Firewall is loaded independent of WP.
		return (false !== file_put_contents(self::$path, self::get_file_content_prefix().$ips));
	}

}
