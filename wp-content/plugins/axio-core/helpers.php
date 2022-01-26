<?php
/**
 * Helper functions
 */

/**
 * Send debugging messages when WP_DEBUG is enbaled.
 *
 * @param string $msg the message for error
 * @param array  $functions the functions used
 */
function axio_core_debug_msg($msg, $functions) {

  if (WP_DEBUG === true) {

    // init warning to get source
    $e = new Exception($msg);

    // find file and line for problem
    $trace_line = '';
    foreach ($e->getTrace() as $trace) {
      if (in_array($trace['function'], $functions)) {
        $trace_line = ' in ' . $trace['file'] . ':' . $trace['line'];
      }
    }

    // compose error message
    $error_msg = $e->getMessage() . $trace_line;

    // trigger errors
    trigger_error($error_msg, E_USER_WARNING);
    error_log($error_msg);

  }

}

/**
 * Support legacy function
 */
if (!function_exists('aucor_core_debug_msg')) {

  function aucor_core_debug_msg($msg, $functions) {

    axio_core_debug_msg($msg, $functions);

  }

}
