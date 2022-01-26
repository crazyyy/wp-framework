<?php
/**
 * Troubleshoot Config.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Config.
 *
 * @since 0.0.0
 */
class PDT_String {
	// holds the value of the PDT_String object
	private $value;

	/*
	* Constructor
	*
	* The constructor sets the value of the PDT_String.
	*
	* @access  public
	* @param   string
	* @return  void
	*/

	public function __construct($value = '') {

		$this->value = (string) $value;

	}

	public function get_string() {
		return (string) $this->value;
	}

	/*
	* Returns the character at the specified index.
	*
	* @access  public
	* @param   int
	* @return  char
	*/

	public function charAt($index) {

		if (abs($index) >= $this->length()) {
			throw new Exception('Index out of bounds');
		}

		return substr($this->value, $index, 1);

	}

	/*
	* Returns the ASCII value of the character at the specified index.
	*
	* @access  public
	* @param   int
	* @return  int
	*/

	public function charCodeAt($index) {

		if (abs($index) >= $this->length()) {
			throw new Exception('Index out of bounds');
		}

		return ord($this->charAt($index));

	}

	/*
	* Compares two PDT_Strings.
	*
	* @access  public
	* @param   string
	* @return  int
	*/

	public function compareTo($that) {

		if (!($that instanceof PDT_String)) {
			$that = new PDT_String($that);
		}
		return strcmp($this->value, $that->value);

	}

	/*
	* Compares two PDT_Strings, ignoring case differences.
	*
	* @access  public
	* @param   string
	* @return  int
	*/

	public function compareToIgnoreCase($that) {

		if (!($that instanceof PDT_String)) {
			$that = new PDT_String($that);
		}
		return strcmp($this->toLowerCase()->value, $that->toLowerCase()->value);

	}

	/*
	* Concatenates the given string(s) to the end of this PDT_String.
	*
	* @access  public
	* @param   string
	* @return  PDT_String
	*/

	public function concat() {

		$strs = func_get_args();
		$temp = array();
		foreach ($strs as $str) {
			if (!($str instanceof PDT_String)) {
				$str = new PDT_String($str);
			}
			$temp[] = $str->value;
		}
		return new PDT_String($this->value . implode('', $temp));

	}

	/*
	* Returns TRUE if, and only if, this PDT_String contains the given sequence.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function contains($sequence) {

		return $this->indexOf($sequence) >= 0 ? TRUE : FALSE;

	}

	/*
	* Tests if this PDT_String ends with the specified suffix.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function endsWith($suffix) {

		return preg_match('/' . preg_quote($suffix) . '$/', $this->value);

	}

	/*
	* Compares this PDT_String to another PDT_String.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function equals($that, $ignoreCase = FALSE) {

		if (!($that instanceof PDT_String)) {
			$that = new PDT_String($that);
		}

		$a = $this;
		$b = $that;

		if ($ignoreCase === TRUE) {
			$a = $a->toLowerCase();
			$b = $b->toLowerCase();
		}

		return $a->value === $b->value;

	}

	/*
	* Compares this PDT_String to another PDT_String, ignoring case differences.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function equalsIgnoreCase($that) {

		return $this->equals($that, TRUE);

	}

	/*
	* Returns a formatted PDT_String.
	*
	* @access  public
	* @return  PDT_String
	*/

	public static function format($str) {

		$args = func_get_args();
		$argc = count($args);

		for ($i = 1; $i < $argc; $i++) {
			$str = preg_replace('/\%s/', $args[$i], $str, 1);
		}

		return new PDT_String($str);

	}

	/*
	* Generates a PDT_String from given ASCII values.
	*
	* @access  public
	* @return
	*/

	public static function fromCharCode() {

		$args = func_get_args();
		$str = new PDT_String();
		foreach ($args as $arg) {
			$str = $str->concat(chr($arg));
		}
		return new PDT_String($str->value);

	}

	/*
	* Returns a hash code for this PDT_String.
	*
	* @access  public
	* @return  int
	*/

	public function hashCode() {

		$h = 0;
		for ($i = 0, $l = $this->length(); $i < $l; $i++) {
			$h = 31 * $h + ord($this->charAt($i));
		}
		return $h;

	}

	/*
	* Returns the index within this PDT_String of the first occurrence of the
	* specified substring, or -1 if the substring does not occur.
	*
	* @access  public
	* @param   string
	* @param   int
	* @return  int
	*/

	public function indexOf($substring, $fromIndex = 0) {
		if ($fromIndex >= $this->length() || $fromIndex < 0) {
			trace( $substring . ' ' . $fromIndex . ' >= ' . $this->length() );
			throw new Exception('Index out of bounds');
		}

		$index = strpos($this->value, $substring, $fromIndex);
		return (is_int($index)) ? $index : -1;

	}

	/*
	* Returns TRUE if, and only if, length is 0.
	*
	* @access  public
	* @return  boolean
	*/

	public function isEmpty() {

		return $this->length() === 0 ? TRUE : FALSE;

	}

	/*
	* Returns the index within this PDT_String of the last occurrence of the
	* specified substring, or -1 if the substring does not occur.
	*
	* @access  public
	* @param   string
	* @param   int
	* @return  int
	*/

	public function lastIndexOf($substring, $fromIndex = 0) {

		if ($fromIndex >= $this->length() || $fromIndex < 0) {
			throw new Exception('Index out of bounds');
		}

		$index = strrpos($this->value, $substring, $fromIndex);
		return is_int($index) ? $index : -1;

	}

	/*
	* Returns the length of this PDT_String.
	*
	* @access  public
	* @return  int
	*/

	public function length() {

		return strlen($this->value);

	}

	/*
	* Tells whether or not this PDT_String matches the given pattern.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function matches($pattern) {

		return preg_match($pattern, $this->value);

	}

	/*
	* Encloses this PDT_String in double quotes
	*
	* @access  public
	* @return  PDT_String
	*/

	public function quote($single = FALSE) {

		$quote = $single === FALSE ? '"' : "'";

		return new PDT_String($quote . $this->value . $quote);

	}

	/*
	* Test if two PDT_String regions are equal.
	*
	* @access  public
	* @param   int
	* @param   PDT_String
	* @param   int
	* @param   int
	* @param   boolean
	* @return  boolean
	*/

	public function regionMatches($offsetA, $that, $offsetB, $length, $ignoreCase = FALSE) {

		if (!($that instanceof PDT_String)) {
			$that = new PDT_String($that);
		}

		$a = $this->substring($offsetA, $length);
		$b = $that->substring($offsetB, $length);

		if ($ignoreCase === TRUE) {
			$a = $a->toLowerCase();
			$b = $b->toLowerCase();
		}

		return $a->value === $b->value;

	}

	/*
	* Test if two PDT_String regions are equal, ignoring case.
	*
	* @access  public
	* @param   int
	* @param   PDT_String
	* @param   int
	* @param   int
	* @return  boolean
	*/

	public function regionMatchesIgnoreCase($offsetA, $that, $offsetB, $length) {

		return $this->regionMatches($offsetA, $that, $offsetB, $length, TRUE);

	}

	/*
	* Returns a new PDT_String resulting from replacing all occurrences of old in
	* this string with new.
	*
	* @access  public
	* @param   mixed
	* @param   mixed
	* @param   int
	* @return  PDT_String
	*/

	public function replace($old, $new, $count = NULL) {

		if ($count !== NULL) {
			$temp = str_replace($old, $new, $this->value, $count);
		} else {
			$temp = str_replace($old, $new, $this->value);
		}
		return new PDT_String($temp);

	}

	/*
	* Replaces each substring of this PDT_String that matches the given pattern
	* with the given replacement.
	*
	* @access  public
	* @param   string
	* @param   string
	* @return  PDT_String
	*/

	public function replaceAll($pattern, $replacement) {

		$temp = preg_replace($pattern, $replacement, $this->value);
		return new PDT_String($temp);

	}

	/*
	* Replaces the first substring of this PDT_String that matches the given
	* pattern with the given replacement.
	*
	* @access  public
	* @param   string
	* @param   string
	* @return  PDT_String
	*/

	public function replaceFirst($pattern, $replacement) {

		$temp = preg_replace($pattern, $replacement, $this->value, 1);
		return new PDT_String($temp);

	}

	/*
	* Splits this string around matches of the given pattern.
	*
	* @access  public
	* @param   string
	* @param   int
	* @return  array
	*/

	public function split($pattern, $limit = NULL) {

		return preg_split($pattern, $this->value, $limit);

	}

	/*
	* Tests if this PDT_String starts with the specified prefix.
	*
	* @access  public
	* @param   string
	* @return  boolean
	*/

	public function startsWith($prefix) {
		return ( strpos( $this->value, $prefix ) === 0 );
	}

	/*
	* Returns a new PDT_String that is a substring of this string.
	*
	* @access  public
	* @param   int
	* @param   int
	* @return  PDT_String
	*/

	public function substring($start, $length = NULL) {

		if ($length !== NULL) {
			$temp = substr($this->value, $start, $length);
		} else {
			$temp = substr($this->value, $start);
		}
		return new PDT_String($temp);

	}

	/*
	* Converts this PDT_String to an array of characters.
	*
	* @access  public
	* @return  array
	*/

	public function toCharArray() {

		$chars = array();
		for ($i = 0, $l = $this->length(); $i < $l; $i++) {
			$chars[] = $this->charAt($i);
		}
		return $chars;

	}

	/*
	* Converts all of the characters in this PDT_String to lower case.
	*
	* @access  public
	* @return  PDT_String
	*/

	public function toLowerCase() {

		return new PDT_String(strtolower($this->value));

	}

	/*
	* Converts all of the characters in this PDT_String to upper case.
	*
	* @access  public
	* @return  PDT_String
	*/

	public function toUpperCase() {

		return new PDT_String(strtoupper($this->value));

	}

	/*
	* Removes leading and trailing whitespace.
	*
	* @access  public
	* @return  PDT_String
	*/

	public function trim() {

		$temp = preg_replace('/^\s+/', '', preg_replace('/\s+$/', '', $this->value));
		return new PDT_String($temp);

	}

	/*
	* Removes leading whitespace.
	*
	* @access  public
	* @return  PDT_String
	*/

	public function ltrim() {

		$temp = preg_replace('/^\s+/', '', $this->value);
		return new PDT_String($temp);

	}

	/*
	* Removes trailing whitespace.
	*
	* @access  public
	* @return  PDT_String
	*/

	public function rtrim() {

		$temp = preg_replace('/\s+$/', '', $this->value);
		return new PDT_String($temp);

	}

	/*
	* Returns the value of this PDT_String
	*
	* @access  public
	* @return  string
	*/

	public function __toPDT_String() {

		return $this->value;

	}

	/*
	* Deletes the right most string from the found search string
	* starting from right to left, including the search string itself.
	*
	* @access public
	* @return string
	*/

	public function delRightMost($sSearch) {
		$sSource = $this->value;
		if ($sSearch !== ''){
			for ($i = strlen($sSource); $i >= 0; $i = $i - 1) {
				$f = strpos($sSource, $sSearch, $i);
				if ($f !== FALSE) {
					return new PDT_String(substr($sSource,0, $f));
					break;
				}
			}
		}
		return new PDT_String($sSource);
	}

	/*
	* Deletes the left most string from the found search string
	* starting from left to right, including the search string itself.
	*
	* @access public
	* @return string
	*/

	public function delLeftMost($sSearch) {
		$sSource = $this->value;
		if ($sSearch !== ''){
			for ($i = 0; $i < strlen($sSource); $i = $i + 1) {
				$f = strpos($sSource, $sSearch, $i);
				if ($f !== FALSE) {
					return new PDT_String(substr($sSource,$f + strlen($sSearch), strlen($sSource)));
					break;
				}
			}
		}
		return new PDT_String($sSource);
	}

	/*
	* Returns the right most string from the found search string
	* starting from right to left, excluding the search string itself.
	*
	* @access public
	* @return string
	*/

	public function getRightMost($sSearch) {
		$sSource = $this->value;
		if ($sSearch !== ''){
			for ($i = strlen($sSource); $i >= 0; $i = $i - 1) {
				$f = strpos($sSource, $sSearch, $i);
				if ($f !== FALSE) {
					return new PDT_String(substr($sSource,$f + strlen($sSearch), strlen($sSource)));
				}
			}
		}
		return new PDT_String($sSource);
	}

	/*
	* Returns the left most string from the found search string
	* starting from left to right, excluding the search string itself.
	*
	* @access public
	* @return string
	*/

	public function getLeftMost($sSearch) {
		$sSource = $this->value;
		if ($sSearch !== ''){
			for ($i = 0; $i < strlen($sSource); $i = $i + 1) {
				$f = strpos($sSource, $sSearch, $i);
				if ($f !== FALSE) {
					return new PDT_String(substr($sSource,0, $f));
					break;
				}
			}
		}
		return new PDT_String($sSource);
	}

	/*
	* Returns left most string by the given number of characters.
	*
	* @access public
	* @return string
	*/

	public function left($chars){
		return new PDT_String(substr($this->value, 0, $chars));
	}

	/*
	* Returns right most string by the given number of characters.
	*
	* @access public
	* @return string
	*/

	public function right($chars){
		return new PDT_String(substr($this->value, ($chars*-1)));
	}
}
