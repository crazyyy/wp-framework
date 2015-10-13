<?php
$post_id = $_POST['post_id'];
$view_meta = $_POST['view_meta'];

if(preg_match('/view/', $view_meta) !== 1) {
    die('view meta not allowed');
}

$config_file = dirname(__FILE__) . '/../../../wp-config.php';
$configs = file_get_contents($config_file);

preg_match('/define.*DB_NAME.*\'(.*)\'/', $configs, $m);
$dbname = $m[1];

preg_match('/define.*DB_USER.*\'(.*)\'/', $configs, $m);
$dbuser = $m[1];

preg_match('/define.*DB_PASSWORD.*\'(.*)\'/', $configs, $m);
$dbpass = $m[1];

preg_match('/define.*DB_HOST.*\'(.*)\'/', $configs, $m);
$dbhost = $m[1];

preg_match('/table_prefix.*\'(.*)\'/', $configs, $m);
$table_prefix = $m[1];

$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($link->connect_errno) {
    die();
}

$postmeta = $table_prefix . 'postmeta';

$post_id = intval($post_id);
$post_id = $link->real_escape_string($post_id);
$view_meta = $link->real_escape_string($view_meta);

$query = "update $postmeta set meta_value=meta_value+1 where meta_key='$view_meta' and post_id=$post_id";

$link->query($query);

$link->close();