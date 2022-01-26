<?php
/*
 * Unsafe function in context of plugin/themes for safe websites
 * Generally, those functions are safe, but under certain circumstances those functions may be used to hack site or to lead to the disclosure of vital information
 *
 *
 */
function pi_get_unsafe(){
    $rh=' You can prevent that using constant WP_HTTP_BLOCK_EXTERNAL or restrict hosts with WP_ACCESSIBLE_HOSTS constant.';
    return array(
            'eval' => array('May be used to execute malicious code on the web server. Often paired with base64_decode function to execute malicious code.',3),
            'system' => array('May be used to get/change vital system information or to call unwanted system utilities.',3),
            'base64_decode' => array('Decode data encoded with MIME base64. May be used to obfuscate (hide) malicious code. Often paired with eval function to execute malicious code.',3),
            'shell_exec' => array('Execute command via shell and return the complete output as a string.',3),
            'exec' => array('Execute almost any system program on the web server.',3),
            'assert' => array('Allow arbitrary code execution. Should be used as a debugging feature only.',3),
            'passthru' => array('Execute almost any system program on the web server and display raw output.',3),
            'pcntl_exec' => array('Execute specified program on the web server in current process space.',3),
            'proc_open' => array('Execute a command on the web server and open file pointers for input/output.',3),
            'popen' => array('Open process (system program) file pointer on the web server.',3),
            'dl' => array('Load a PHP extension on the web server at runtime.',3),
            'socket_create' => array('Create point for network connection with any remote host. May be used to load malicious code from the external source without any restrictions.',3),
            'file_get_contents' => array('Read entire file into a string. May be used to load malicious code from the external source/website without any restrictions.',2),
            'curl_exec' => array('Load external data from any web server. May be used to load malicious code from the external source without any restrictions.',2),
            'create_function' => array('Create an anonymous (lambda-style) function. A native anonymous function should be used instead.',1),
            'call_user_func' => array('Call any function given by the first parameter. May be used to hide facts of using unsafe system commands or to mislead code inspection.',1),
            'call_user_func_array' => array('Call any function with an array of parameters. May be used to hide facts of using unsafe system commands or to mislead code inspection.',1),
            'wp_remote_request' => array('Load external data from any web server. May be used to load malicious code from the external source.'.$rh,2),
            'wp_remote_get' => array('Load external data from any web server. May be used to load malicious code from the external source.'.$rh,2),
            'wp_remote_post' => array('Upload or download data from/to any web server. May be used to load malicious code from the external source.'.$rh,2),
            'wp_safe_remote_post' => array('Upload or download data from/to any web server. May be used to load malicious code from the external source.'.$rh,2),
            'wp_remote_head' => array('Load external data from any web server. May be used to load malicious code from the external source.'.$rh,2),
        );
}