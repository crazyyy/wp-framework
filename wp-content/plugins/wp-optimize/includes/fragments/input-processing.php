<?php

namespace TeamUpdraft\InputProcessing;

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * Return the value of a member of a superglobal, after slash-stripping and sanitisation.
 *
 * When using, it is recommended that if the $type or $sanitisation parameters are not used then a code comment is added to state the reason.
 *
 * @param String		$superglobal  - should be one of 'get', 'post', 'request', 'cookie' or 'server'; case insensitive
 * @param String		$key		  - the key to fetch from the superglobal array
 * @param String|Null	$type		  - if specified, then this must (modulo case) match what is returned by gettype() upon the returned value; otherwise, $default will be used. If it is not possible to return a value of the correct type (e.g. if $default itself is not of the correct type) then a TypeError will be thrown. This can be useful if the caller wishes to distinguish between the fetched value being equal to the default, and being invalid (the caller can catch the TypeError to detect this).
 * @param Callable|Null $sanitisation - the sanitisation function to run the result through (any function), with the first parameter being the putative value. Any $default value will not be sanitised, which allows different cases to be distinguished as described above.
 * @param Mixed			$default	  - value to return if the key is not found or if the value is invalid
 *
 * @return Mixed
 * @throws TypeError    If the fetched value does not match the specified $type or if $default itself is not of the correct type.
 *
 * @see https://developer.wordpress.org/apis/security/sanitizing/
 * @see https://www.php.net/manual/en/function.gettype.php
 */
function fetch_superglobal(string $superglobal, string $key, ?string $type = null, ?callable $sanitisation = null, $default = null) {

	$superglobal = '_'.strtoupper($superglobal);
	
	// N.B. Superglobals can only be dereferenced by variable variables in the global scope; this is why we have to use $GLOBALS
	if (!is_array($GLOBALS[$superglobal]) || !isset($GLOBALS[$superglobal][$key])) {
		$putative_return = $default;
	} else {
		$putative_return = stripslashes_deep($GLOBALS[$superglobal][$key]);
		if (null !== $sanitisation) {
			$putative_return = call_user_func($sanitisation, $putative_return);
		}
		if (null !== $type) {
			if (strtolower(gettype($putative_return)) !== strtolower($type)) {
				$putative_return = $default;
			}
		}
	}
	
	if (null !== $type) {
		if (strtolower(gettype($putative_return)) !== strtolower($type)) {
			throw new \TypeError('fetch_superglobal() was unable to return any value of the required type '.esc_html($type), 255);
		}
	}
	
	return $putative_return;

}

/**
 * Used to verify a nonce
 *
 * @param string     $name   Nonce name
 * @param string|int $action Nonce action
 *
 * @throws RuntimeException Thrown if nonce verification fails.
 *
 * @return bool
 */
function verify_nonce($name, $action = -1): bool {
	if (function_exists('wp_verify_nonce')) {
		if (wp_verify_nonce(fetch_superglobal('request', $name, null, 'sanitize_key'), $action)) {
			return true;
		}
	}
	throw new \RuntimeException('Nonce verification failed');
}
