<?php
namespace AIOWPS\Firewall;

/**
 * A class for accessing constants (including from wp-config) from the firewall
 * Only supports parsing 'defines' that have scalar types: int, float, boolean, string and null
 */
class Constants implements \ArrayAccess, \IteratorAggregate {

	/**
	 * The list of constants parsed
	 *
	 * @var array
	 */
	protected $constants;

	/**
	 * The token part of the token identifier
	 *
	 * @see https://www.php.net/manual/en/function.token-get-all#refsect1-function.token-get-all-returnvalues
	 */
	const TOKEN = 0;

	/**
	 * The string content of the token identifier
	 *
	 * @see https://www.php.net/manual/en/function.token-get-all#refsect1-function.token-get-all-returnvalues
	 */
	const CONTENT = 1;

	/**
	 * The line number of the token identifier
	 *
	 * @see https://www.php.net/manual/en/function.token-get-all#refsect1-function.token-get-all-returnvalues
	 */
	const LINE = 2;

	/**
	 * Offset for define's name [ define(NAME, VALUE); ]
	 */
	const DEFINE_NAME_OFFSET = 2;

	/**
	 * Offset for define's value [ define(NAME, VALUE); ]
	 */
	const DEFINE_VALUE_OFFSET = 4;

	/**
	 * Constructs our object
	 */
	public function __construct() {
		$this->constants = array();
		$this->populate_constants();
	}

	/**
	 * Populates our internal constant array with the defines from wp-config
	 *
	 * @return void
	 */
	protected function populate_constants() {

		$wpconfig = Utility::get_wpconfig_path();

		clearstatcache();
		if (!file_exists($wpconfig)) return;

		$source = file_get_contents($wpconfig);

		if (false === $source) return;

		$tokens = token_get_all($source);

		//Filter out any unwanted tokens
		$tokens = array_values(array_filter($tokens, function($token) {

			//All tokens that are not arrays are allowed
			if (!is_array($token)) return true;

			$unwanted_tokens = array(
				'T_COMMENT',
				'T_WHITESPACE',
				'T_DOC_COMMENT',
			);

			return (!in_array(token_name($token[self::TOKEN]), $unwanted_tokens));
		}));

		$token_count = count($tokens);
		for ($i = 0; $i < $token_count; $i++) {

			$current = $tokens[$i];

			if (!is_array($current)) continue;

			if ('T_STRING' === token_name($current[self::TOKEN]) && 'define' === strtolower($current[self::CONTENT])) {

				// Name of the define without the surrounding quotes
				$name = substr($tokens[$i + self::DEFINE_NAME_OFFSET][self::CONTENT], 1, -1);

				// Grabs the value of the define
				$value = $tokens[$i + self::DEFINE_VALUE_OFFSET];

				if (!is_array($value)) continue;

				// We need to interpret the data type of the define's value
				switch (token_name($value[self::TOKEN])) {
					case 'T_CONSTANT_ENCAPSED_STRING':
						$this->constants[$name] = substr($value[self::CONTENT], 1, -1);
						break;
					case 'T_LNUMBER':
						$this->constants[$name] = intval($value[self::CONTENT]);
						break;
					case 'T_DNUMBER':
						$this->constants[$name] = floatval($value[self::CONTENT]);
						break;
					case 'T_STRING':
						$this->constants[$name] = filter_var($value[self::CONTENT], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
						break;
					default:
						continue 2;
				}
			}
		}

	}

	/**
	 * Access the constants as properties
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this[$name];
	}

	/**
	 * Iterate over the constants
	 *
	 * @return iterable
	 */
	#[\ReturnTypeWillChange]
	public function getIterator() {
		foreach ($this->constants as $name => $value) yield $name => $value;
		foreach (get_defined_constants() as $name => $value) yield $name => $value;
	}

	/**
	 * Gives us array access to the constants
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet($offset) {
		if (defined($offset)) {
			return constant($offset);
		} elseif (isset($this->constants[$offset])) {
			return $this->constants[$offset];
		} else {
			return null;
		}
	}
	
	/**
	 * Checks if the constant exists
	 *
	 * @param mixed $offset
	 * @return boolean
	 */
	#[\ReturnTypeWillChange]
	public function offsetExists($offset) {
		return defined($offset) || isset($this->constants[$offset]);
	}

	/**
	 * Check if constant exists
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name) {
		return $this->offsetExists($name);
	}

	/**
	 * Sets the constant. This is disabled as we want it read-only
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 * @throws \Exception - Throws an exception if called to ensure it's read-only.
	 */
	#[\ReturnTypeWillChange]
	public function offsetSet($offset, $value) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		throw new \Exception('Constants are read-only.');
	}

	/**
	 * Unsets the constant. This is disabled as we want it read-only
	 *
	 * @param mixed $offset
	 * @return void
	 * @throws \Exception - Throws an exception if called to ensure it's read-only.
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset($offset) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		throw new \Exception('Constants are read-only.');
	}

}
