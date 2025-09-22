<?php

if (!defined('ABSPATH')) die('Access denied.');

class Simba_TFA_Encryption_Muplugin {

	/**
	 * The simba tfa object
	 *
	 * @var object
	 */
	private $simba_tfa;

	/**
	 * Full path to the file we're managing
	 *
	 * @var string
	 */
	private $file_path;

	/**
	 * The class constructor
	 *
	 * @param object $simba_tfa - the simba tfa object
	 */
	public function __construct($simba_tfa) {
		$this->simba_tfa = $simba_tfa;
		$this->file_path = path_join($this->get_mu_plugin_dir(), 'simba-tfa-encryption-key.php');
	}

	/**
	 * Returns full path to mu-plugin directory
	 *
	 * @return string - the mu-plugin directory path
	 */
	public function get_mu_plugin_dir() {
		return WPMU_PLUGIN_DIR;
	}

	/**
	 * Returns the full path to the mu-plugin file
	 *
	 * @return string - the mu-plugin path
	 */
	public function get_file_path() {
		return $this->file_path;
	}

	/**
	 * This function checks if our mu-plugin exists
	 *
	 * @return boolean - true if the file exists otherwise false
	 */
	public function muplugin_exists() {
		return file_exists($this->file_path);
	}

	/**
	 * Inserts our code into our mu-plugin.
	 *
	 * The mu-plugin and the mu-plugin directory will be created if they don't already exists
	 *
	 * @return boolean|WP_Error - true on success or WP_Error on failure
	 */
	public function insert_contents() {

		$info = pathinfo($this->file_path);
	
		if (!isset($info['dirname'])) {
			return new WP_Error(
				'file_no_directory',
				/* translators: %s: Multi user plugin directory */
				__('Encrypt secrets feature not enabled: no directory has been set.', 'all-in-one-wp-security-and-firewall') . ' ' . sprintf(__('Please check your %s constant is valid', 'all-in-one-wp-security-and-firewall'), 'WPMU_PLUGIN_DIR'),
				$this->file_path
			);
		}

		if (false === wp_mkdir_p($info['dirname'])) {
			return new WP_Error(
				'file_no_directory_created',
				/* translators: %s: Multi user plugin directory */
				sprintf(__('The encrypt secrets feature was not enabled: your mu-plugins directory could not be automatically created; therefore, please use your web hosting file manager or FTP to manually create this folder and then try again: %s', 'all-in-one-wp-security-and-firewall'), $this->get_mu_plugin_dir()),
				$info['dirname']
			);
		}

		if (false === @file_put_contents($this->file_path, $this->get_contents())) { // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- ignore this as it is handled by the caller
			return new WP_Error(
				'file_no_contents',
				/* translators: %s: File path. */
				__('The encrypt secrets feature was not enabled: attempting to write the mu-plugin file contents failed; therefore, please create the file manually.', 'all-in-one-wp-security-and-firewall') . "<br><br>" . sprintf(__('Add the following code to the file %s', 'all-in-one-wp-security-and-firewall'), $this->get_file_path()) . "\n" . '<br><br><code>' . nl2br(esc_html($this->get_contents())) . '</code><br><br>' . __('Once you have added the above code then press the button to turn on encryption again', 'all-in-one-wp-security-and-firewall'),
				$info['dirname']
			);
		}

		return true;
	}

	/**
	 * This function creates the contents for the mu-plugin
	 *
	 * @return string - the contents of the mu-plugin
	 */
	public function get_contents() {
		$encryption_key = base64_encode($this->simba_tfa->random_bytes(16));
		$code = "<?php\n";
		$code .= "// Simba TFA Database encryption key. Do not change this unless you wish all your existing encrypted keys to become unusable (e.g. if you intend to then replace them all).\n";
		$code .= "if (!defined('SIMBA_TFA_DB_ENCRYPTION_KEY')) define('SIMBA_TFA_DB_ENCRYPTION_KEY', '{$encryption_key}');";

		return $code;
	}
}

