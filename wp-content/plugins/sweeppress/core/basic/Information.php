<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\v42\Core\Plugins\Information as BaseInformation;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Information extends BaseInformation {
	public $code = 'sweeppress';

	public $version = '2.3';
	public $build = 90;
	public $updated = '2023.08.11';
	public $status = 'stable';
	public $edition = 'lite';
	public $released = '2022.03.03';
}
