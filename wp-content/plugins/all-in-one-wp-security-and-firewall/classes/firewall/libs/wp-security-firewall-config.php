<?php
namespace AIOWPS\Firewall;

/**
 * Gives us access to our firewall's config
 */
class Config {

	use File_Prefix_Trait;

	/**
	 * The path to our config file
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Constructs object
	 *
	 * @param string $path
	 */
	public function __construct($path) {
		$this->path = $path;
		$this->init_file();
	}

	/**
	 * Initialise the file if it doesn't exist
	 *
	 * @return void
	 */
	private function init_file() {
		clearstatcache();
		if (!file_exists($this->path)) {
			
			$dir = dirname($this->path);
			if (!file_exists($dir)) Utility::wp_mkdir_p($dir);

			file_put_contents($this->path, self::get_file_content_prefix() . json_encode(array()));
		}
	}

	/**
	 * Update the config file with the new prefix whenever the prefix changes.
	 *
	 * @return void
	 */
	public function update_prefix() {

		$valid_prefix   = self::get_file_content_prefix();
		$current_prefix = file_get_contents($this->path, false, null, 0, strlen($valid_prefix));

		if ($current_prefix === $valid_prefix) return; // prefix is valid

		$contents = file_get_contents($this->path);

		$matches = array();
		if (preg_match('/\{.*\}/', $contents, $matches)) {
			//update settings
			file_put_contents($this->path, $valid_prefix . $matches[0]);
		} else {
			//reset settings
			file_put_contents($this->path, $valid_prefix . json_encode(array()));
		}
	}

	/**
	 * Gets the value from the config array
	 *
	 * @param string $key
	 * @return mixed|null
	 */
	public function get_value($key) {

		$contents = $this->get_contents();

		if (null === $contents) {
			return null;
		}

		if (!isset($contents[$key])) {
			return null;
		}

		return $contents[$key];

	}

	/**
	 * Sets a value in our config array
	 *
	 * @param string $key
	 * @param mixed  $value
	 * @return boolean
	 */
	public function set_value($key, $value) {

		$contents = $this->get_contents();

		if (null === $contents) {
			return false;
		}

		$contents[$key] = $value;

		return (false !== file_put_contents($this->path, self::get_file_content_prefix() . json_encode($contents), LOCK_EX));
	}

	/**
	 * Loads the config array from file
	 *
	 * @return string
	 */
	public function get_contents() {

		clearstatcache();
		if (!file_exists($this->path)) $this->init_file();

		// __COMPILER_HALT_OFFSET__ doesn't define in a few PHP versions. It's a PHP bug.
		// https://bugs.php.net/bug.php?id=70164
		$contents = file_get_contents($this->path, false, null, strlen(self::get_file_content_prefix()));

		if (false === $contents) {
			return null;
		}

		if (empty($contents)) {
			return array();
		}

		return json_decode($contents, true);
	}

	/**
	 * Sets entire firewall config from array.
	 *
	 * @param Array $contents
	 *
	 * @return Boolean
	 */
	public function set_contents($contents) {

		if (null === $contents) {
			return false;
		}

		return (false !== file_put_contents($this->path, self::get_file_content_prefix() . json_encode($contents), LOCK_EX));
	}

	/**
	 * Returns the path
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->path;
	}

}
