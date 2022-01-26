<?php
// ini_set( 'display_errors', false );
require_once dirname( dirname( __FILE__ ) ) . '/troubleshoot.php';
$app = pd_troubleshoot();
$path_to_pd_config = dirname( dirname( dirname( dirname ( $app->dir() ) ) ) ) . '/' . 'plugin-detective-config.php';
if ( @file_exists( $path_to_pd_config ) ) {
	include_once( $path_to_pd_config );
}

$params = $app->get_api_params();
$site_url = $params['site_url'];
foreach ($params as $key => &$value) {
	$value = str_replace( $site_url, 'http://localhost:8080', $value );
}
echo json_encode( $params );