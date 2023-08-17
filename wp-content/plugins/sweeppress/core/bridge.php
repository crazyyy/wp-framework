<?php

use Dev4Press\Plugin\SweepPress\Admin\AJAX;
use Dev4Press\Plugin\SweepPress\Admin\Plugin as Admin;
use Dev4Press\Plugin\SweepPress\Basic\DB;
use Dev4Press\Plugin\SweepPress\Basic\Prepare;
use Dev4Press\Plugin\SweepPress\Basic\Plugin;
use Dev4Press\Plugin\SweepPress\Basic\Settings;
use Dev4Press\Plugin\SweepPress\Basic\Sweep;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sweeppress() : Plugin {
	return Plugin::instance();
}

function sweeppress_settings() : Settings {
	return Settings::instance();
}

function sweeppress_core() : Sweep {
	return Sweep::instance();
}

function sweeppress_db() : DB {
	return DB::instance();
}

function sweeppress_prepare() : Prepare {
	return Prepare::instance();
}

function sweeppress_admin() : Admin {
	return Admin::instance();
}

function sweeppress_ajax() : AJAX {
	return AJAX::instance();
}
