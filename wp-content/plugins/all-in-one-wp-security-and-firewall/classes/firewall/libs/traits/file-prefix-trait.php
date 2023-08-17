<?php
namespace AIOWPS\Firewall;

trait File_Prefix_Trait {

	/**
	 * Get the file's prefix content. N.B. Some code assumes that this doesn't change, so review all consumers of this method before changing its output.
	 *
	 * @return string
	 */
	public static function get_file_content_prefix() {
		$prefix  = "<?php __halt_compiler();\n";
		$prefix .= "/**\n";
		$prefix .= " * This file was created by All In One Security (AIOS) plugin.\n";
		$prefix .= self::get_prefix_description();
		$prefix .= " */\n";
		return $prefix;
	}

	/**
	 * Returns the description of the file
	 * You can override this method for each file that needs a file prefix in order to give it its own description
	 *
	 * @return string
	 */
	public static function get_prefix_description() {
		return " * The file is required for storing and retrieving your firewall's settings.\n";
	}

}
