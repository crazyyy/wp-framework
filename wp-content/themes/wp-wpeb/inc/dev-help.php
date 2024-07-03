<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Custom functions that's help to debug
*/

/**
 * Debugger function
 * Writes the output of var_dump to a file.
 *
 * This function takes a data parameter and writes the output of var_dump to a file.
 * The file path is set to 'wp-content/dump.txt' in the root directory of the WordPress installation.
 * The function starts output buffering, echoes the current timestamp, performs var_dump on the provided data,
 * and captures the output into a variable. The output is then appended to the file using file_put_contents.
 * If the operation is successful, it returns the number of bytes written to the file; otherwise, it returns false.
 *
 * @param mixed $data The data to be dumped and written to the file.
 * @param string $filename The name of the file to which data should be dumped. Optional.
 * @return int|bool The number of bytes written to the file, or false on failure.
 *
 * @example
 * // Example 1: Dump a variable and write it to the file
 * $value = 'Hello, world!';
 * write_var_dump_to_file($value);
 *
 * // Example 2: Dump an array and write it to the file
 * $array = array('apple', 'banana', 'cherry');
 * write_var_dump_to_file($array);
 *
 * // Example 3: Dump an object and write it to the file
 * $object = new stdClass();
 * $object->name = 'John Doe';
 * $object->age = 25;
 * write_var_dump_to_file($object);
 */
function write_var_dump_to_file(mixed $data, string $filename = 'dump.txt'): bool|int
{
  $file_path = WP_CONTENT_DIR . '/' . $filename; // Path to the dump file in the wp-content directory
  ob_start(); // Start output buffering
  echo date('Y-m-d H:i:s') . ' '; // Output the current timestamp
  $caller_info = debug_backtrace()[0];
  echo '[' . $caller_info['file'] . ':' . $caller_info['line'] . '] '; // Output the caller info
  if (is_array($data)) {
    echo '(array) ';
  } elseif (is_object($data)) {
    echo '(object) ';
  }
  var_dump($data); // Dump the data
  $output = ob_get_clean(); // Get the buffered output and clean the buffer

  // Write the output to the file and append it with locking
  return file_put_contents($file_path, $output . "\n--- END -------------\n", FILE_APPEND | LOCK_EX);
}

/**
 * Sets the admin color scheme and favicon based on the domain.
 * This function retrieves the current domain and sets the admin color scheme
 * and favicon based on the domain name. It uses conditional logic to map specific
 * domains to different admin color schemes and sets a custom favicon for a specific domain.
 * By default, the function returns the 'default' color scheme if no match is found.
 * @return string The admin color scheme slug.
 */
function custom_admin_color_scheme_and_favicon(): string {
  // Define the domains and corresponding color schemes and favicons
  $config = array(
    'development' => array(
      'color_scheme' => 'sunrise',
      'favicon_url' => WPEB_TEMPLATE_URL . '/img/favicon/icon.png'
    ),
    'production' => array(
      'color_scheme' => 'ocean',
      'favicon_url' => null
    )
  );

  $environment_type = defined('WP_ENVIRONMENT_TYPE') ? WP_ENVIRONMENT_TYPE : 'default';

  // Set the favicon URL and enqueue a new stylesheet to replace the default favicon
  if (array_key_exists($environment_type, $config)) {
    $environment_config = $config[$environment_type];
    $favicon_url = $environment_config['favicon_url'];

    if (!empty($favicon_url)) {
      echo '<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" />';
    }

    return $environment_config['color_scheme'];
  }

  return 'default';
}

add_filter('get_user_option_admin_color', 'custom_admin_color_scheme_and_favicon');
