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
class PDT_Config {
	// *** Private
	private $block_begin_line = false;
	private $block_end_line = 0;
	private $last_key_line = -1;
	private $last_key = '';
	private $block = array();
	private $data = array();

	private function mergeBlockData() {
		$line_no = 0;
		$data = array();
		if ( $this->block_begin_line !== false ) {
			for ($line_no = 0; $line_no < count( $this->data ); $line_no++ ) {
				if ( $line_no < $this->block_begin_line ) {
					array_push( $data, $this->data[$line_no] );
				}
				if ( $line_no > $this->block_begin_line && $line_no < $this->block_end_line ) {
					foreach( $this->block as $line ) {
						array_push( $data, $line );
					}
					$line_no = $this->block_end_line;
				}
				if ( $line_no > $this->block_end_line ) {
					array_push( $data, $this->data[$line_no] );
				}
			}
		}
		if ( $this->block_end_line >= count( $this->data ) ) {
			foreach( $this->block as $line ) {
				array_push( $data, $line );
			}
		}

		// Trim last line, prevent line feed creep
		if ( $data[count( $data )-1] === "" && $data[count( $data ) - 2] === "" ) {
			array_pop( $data );
			array_pop( $data );
		}
		$this->data = $data;
	}

	/**
	 * Load the given file if provided.
	 */
	function __construct( $file = '', $normalize = false ) {
		if ( $file !== '' ){
			$this->load( $file, $normalize );
		}
	}

	// *** Public
	public $ignore_spaces = false;
	public $comment_chars = '';
	public $prepend_value = '';
	public $append_value = '';
	public $block_begin = '';
	public $prepend_key = '';
	public $append_key = '';
	public $block_end = '';

	/**
	 * Load a file for analysis
	 *
	 * @param string $file The path and filename of the file to load.
	 */
	function load( $file, $normalize = false ) {
		// Set configuration file type based on extension
		$s = new PDT_String( $file );
		$this->set_type( $s->getRightMost( '.' )->get_string() );

		// Convert Windows CRLF to LF
		$d = str_replace( "\r\n", "\n", file_get_contents( $file ) );
		if ( !empty( $normalize ) ) {
			$d = str_replace( "\\\"", "\\escapeddoublequote", $d );
			$d = str_replace( "\"", "'", $d );
			$d = str_replace( "\\escapeddoublequote", "\\\"", $d );
		}

		$this->data = explode( "\n", $d );
		$this->block = $this->data;
		$this->block_end_line = count( $this->data );
	}

	/**
	 * Overwrites the current block of data with the given content.
	 *
	 * @param string $contents the string data to replace the block with.
	 */
	function set_block( $contents ) {

		// Trim last line, prevent line feed creep
		if ( substr( $contents, -1 ) === "\n" && substr( $contents, -2, 1 ) === "\n" ) {
			$contents = substr( $contents, 0, -1 );
		}
		$block = str_replace( "\r\n", "\n", $contents );
		$block = explode( "\n", $block );
		array_unshift( $block, $this->block[0] );
		array_push( $block, $this->block[count( $this->block ) - 1] );
		$this->block = $block;
	}

	/**
	 * Set the given boundary markers and options for parsing the file. This
	 * method is automatically called from our load file method.
	 *
	 * @param string $ext The file extension.
	 */
	function set_type( $ext ) {
		switch ( $ext ) {
			case 'ini': // PHP ini file
				$this->comment_chars = "; ";
				$this->ignore_spaces = true;
				$this->prepend_value = "";
				$this->append_value = "";
				$this->prepend_key = "";
				$this->append_key = "=";
				break;
			case 'php-define':
			case 'php': // PHP source code file, where define('key', 'value');
				$this->comment_chars = "//";
				$this->ignore_spaces = true;
				$this->prepend_value = " '";
				$this->append_value = "');";
				$this->prepend_key = "define('";
				$this->append_key = "',";
				break;
			case 'php-define-double-quote':
				$this->comment_chars = "//";
				$this->ignore_spaces = true;
				$this->prepend_value = " \"";
				$this->append_value = "\");";
				$this->prepend_key = "define(\"";
				$this->append_key = "\",";
				break;
			case 'php-unquoted': // PHP source code file, where define('key', unquoted value);
				$this->comment_chars = "//";
				$this->ignore_spaces = true;
				$this->prepend_value = " ";
				$this->append_value = ");";
				$this->prepend_key = "define('";
				$this->append_key = "',";
				break;
			case 'conf': // Apache configuration file
				$this->comment_chars = "# ";
				$this->prepend_value = "";
				$this->append_value = "";
				$this->prepend_key = "";
				$this->append_key = " ";
				break;
			case 'cnf': // MySQL my.cnf
				$this->comment_chars = "# ";
				$this->ignore_spaces = true;
				$this->prepend_value = "";
				$this->append_value = "";
				$this->prepend_key = "";
				$this->append_key = "=";
				break;
			case 'php-variable':
				$this->comment_chars = "// ";
				$this->ignore_spaces = true;
				$this->prepend_value = " '";
				$this->append_value = "';";
				$this->prepend_key = "$";
				$this->append_key = " =";
				break;
			default:
				$this->comment_chars = "//";
				$this->ignore_spaces = true;
				$this->prepend_value = "'";
				$this->append_value = "';";
				$this->prepend_key = "";
				$this->append_key = "=";
				break;
		}
	}
	/**
	 * Narrow the focus of our methods to the given unique block within the
	 * configuration file. Our methods (find, get, set, add, remove, etc) will
	 * only act within the given valid region. If the region does not exist or
	 * the arguments are empty, then our methods will apply to the entire file.
	 *
	 * @param string $begin A unique string that markes the beginning of the region.
	 * @param string $end A unique string that identifies the end of the region.
	 * @return boolean Returns true if an existing isolated block could be found.
	 */
	function isolate_block( $begin, $end ) {
		$this->mergeBlockData();
		if ( $begin === null && $end === null || $begin === '' || $end === '' ) {
			$this->block_begin_line = false;
			$this->block_end_line = 0;
			$this->last_key_line = -1;
			$this->last_key = '';
			$this->block = $this->data;
			$this->block_end_line = count( $this->data );
			return;
		}
		$this->block_begin_line = false;
		$this->block_begin = $begin;
		$this->block_end = $end;
		$this->last_key = '';
		$this->block = array();
		$line_no = 0;
		foreach ( $this->data as $line ) {
			if ( false !== strpos( $line, $begin ) ) {
				$this->block_begin_line = $line_no;
				array_push( $this->block, $line );
			}else{
				if ( false !== strpos( $line, $end ) ) {
					array_push( $this->block, $line );
					$this->block_end_line = $line_no;
					return true;
				}else{
					if ( false !== $this->block_begin_line ) {
						array_push( $this->block, $line );
					}
				}
			}
			$line_no++;
		}

		// Use last blank line if present
		if ( end($this->data) === "" ) {
			$line_no--;
		}
		$this->block_begin_line = $line_no;
		$this->block_end_line = $line_no + 1;
		$this->block = array( $begin, $end );
		return false;
	}

	/**
	 * Finds the given key within the configuration file and within the narrowed
	 * scope of an isolated block of code if the "isolate_block" method was used
	 * prior. Invoking the method with the same parameter finds the next instance
	 * of the key if present.
	 *
	 * @param string $key The key to find within the configuration file.
	 * @return boolean Returns true if the key could be found or false if missing.
	 */
	function find( $key ) {
		// Reset to top of block
		if ( $key === '' || $key === null ) {
			$this->last_key_line = -1;
			$this->last_key = '';
			return false;
		}

		// Search for the key in the current block
		$line_no = 0;
		$find = $this->prepend_key . $key . $this->append_key;
		if ( $this->ignore_spaces ) {
			$find = str_replace( ' ', '', $find );
		}
		if ( $this->last_key !== $key ) {
			$this->last_key_line = -1;
		}
		$this->last_key = $key;
		$this->last_key_line = -1;
		foreach ( $this->block as $line ) {
			if ( ! $this->is_string_commented( $line ) ) {			
				if ( $line_no > $this->last_key_line ) {
					if ( $this->ignore_spaces ) {
						$line = str_replace( ' ', '', $line );
					}
					if ( false !== strpos( $line, $find ) ) {
						$this->last_key_line = $line_no;
						return true;
					}
				}
			}
			$line_no++;
		}
		return false;
	}

	/**
	 * Comments out the line containing the key that was found from a prior find
	 * method call.
	 *
	 */
	function comment() {
		if ( $this->last_key_line === -1  ) {
			return;
		}
		$line = new PDT_String( $this->block[$this->last_key_line] );
		if ( false === $this->is_commented() ) {
			$this->block[$this->last_key_line] = $this->comment_chars . $line->get_string();
		}
	}

	/**
	 * Checks if the line containing the key that was found from a prior find
	 * method call is commented or uncommented.
	 *
	 * @return boolean Returns true if the given line is commented out.
	 */
	function is_commented() {
		if ( $this->last_key_line === -1  ) {
			return false;
		}

		$line = new PDT_String( $this->block[$this->last_key_line] );
		$cc = $this->comment_chars;
		if ( $this->ignore_spaces ) {
			$line = $line->replace(' ', '');
			$cc = str_replace( ' ', '', $cc );
		}

		return $line->trim()->startsWith( $cc );
	}

	/**
	 * Checks if the line containing the key that was found from a prior find
	 * method call is commented or uncommented.
	 *
	 * @return boolean Returns true if the given line is commented out.
	 */
	function is_string_commented($string) {
		$line = new PDT_String( $string );
		$cc = $this->comment_chars;
		if ( $this->ignore_spaces ) {
			$line = $line->replace(' ', '');
			$cc = str_replace( ' ', '', $cc );
		}

		return $line->trim()->startsWith( $cc );
	}


	/**
	 * Uncomments out the line containing the key that was found from a prior find
	 * method call.
	 *
	 */
	function uncomment() {
		if ( $this->last_key_line === -1  ) {
			return;
		}
		$line = new PDT_String( $this->block[$this->last_key_line] );
		if ( true === $this->is_commented() ) {
			$this->block[$this->last_key_line] = $line->delLeftMost( $this->comment_chars )->get_string();
		}
	}

	/**
	 * The get_key method provides a single method to find and return the existing
	 * value for a single given matching key. The default is returned if no key
	 * has been found.
	 *
	 * @param string $key
	 * @return string
	 */
	function get_key( $key, $default = '' ) {
		$this->find( $key );
		if ( $this->last_key_line === -1 ) {
			return $default;
		} else {
			return $this->get();
		}
	}

	/**
	 * Gets the current value of a key that was found with a last prior method call
	 * to find. Returns null if no valid key was originally found.
	 *
	 * @return string The value of the key found from a prior find method call.
	 */
	function get() {
		if ( $this->last_key_line === -1 || $this->last_key === '' ) {
			return null;
		}
		$line = $this->block[$this->last_key_line];
		$key = $this->prepend_key . $this->last_key . $this->append_key;
		if ( $this->ignore_spaces ) {
			$line = str_replace( ' ', '', $line );
			$key = str_replace( ' ', '', $key );
		}
		$s = new PDT_String( $line );
		$s = $s->delLeftMost( $key );
		$pre = $this->prepend_value;
		$app = $this->append_value;
		if ( $this->ignore_spaces ) {
			$pre = str_replace( ' ', '', $this->prepend_value);
			$app = str_replace( ' ', '', $this->append_value);
		}
		return $s->delLeftMost( $pre )->getLeftMost( $app )->get_string();
	}

	/**
	 * The set_key method provides one convenient call to set an existing a value
	 * for a single key in a given configuration file. The key is automatically
	 * added if it does not exist prior.
	 *
	 * @param string $key
	 * @param string $value
	 */
	function set_key( $key, $value ) {
		$this->find( $key );
		if ( $this->last_key_line === -1 ) {
			$this->add( $value );
		} else {
			$this->set( $value );
		}
	}

	/**
	 * Adds a value to the end of the current block for the given key that was
	 * searched for via the find method. Ignored if no prior find was invoked or
	 * no valid key could be found.
	 *
	 * @param string $value The value to add to the block.
	 */
	function add( $value ) {
		$new = $this->prepend_key . $this->last_key . $this->append_key;
		$new .= $this->prepend_value . $value . $this->append_value;
		if ( $this->block[count( $this->block ) -1] === $this->block_end ) {
			array_splice( $this->block, -1, 0, $new );
		}else{
			array_push( $this->block, $new );
		}
	}

	/**
	 * Sets or updates the value for the given key that was found from a prior
	 * find method call. Ignored if no prior find was invoked or no valid key
	 * could be found.
	 *
	 * @param string $value The new value to
	 */
	function set( $value ) {
		if ( $this->last_key_line === -1 ) {
			return;
		}
		$update =  $this->prepend_key . $this->last_key . $this->append_key;
		$update .= $this->prepend_value . $value . $this->append_value;
		$this->block[$this->last_key_line] = $update;
	}

	/**
	 * Removes the line containing the key that was found from a prior find
	 * method call.
	 *
	 */
	function remove() {
		if ( $this->last_key_line === -1 ) {
			return;
		}
		unset( $this->block[$this->last_key_line] );
	}

	/**
	 * Saves the current configuration file data from memory to the given file.
	 *
	 * @param string $file The file path and name to save the configuration data to.
	 */
	function save( $file ) {
		$this->mergeBlockData();

		// Too large for impload, concat ourselves
		$data = '';
		foreach( $this->data as $line ) {
			$data .= $line . "\n";
		}

		file_put_contents( $file, $data );
	}
}
