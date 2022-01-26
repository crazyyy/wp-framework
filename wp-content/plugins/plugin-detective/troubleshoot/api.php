<?php
// If you're here wondering why we're building our own API
// instead of using the WP REST API... we're doing it this way
// so that we can actually troubleshoot issues when the WP API
// is down (like a fatal/white-screen error for example)
// 
// We're still doing things safely, we connect to the DB directly
// authenticate requests, use nonces, and all that good stuff :)

// Initialization
require_once dirname( __FILE__ ) . '/troubleshoot.php';
$app = pd_troubleshoot();
$api = $app->api->process_request();