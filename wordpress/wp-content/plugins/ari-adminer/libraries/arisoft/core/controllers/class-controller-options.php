<?php
namespace Ari\Controllers;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

use Ari\Utils\Options as Options;

class Controller_Options extends Options {
    public $class_prefix  = '';

    public $domain = '';

    public $path = '';

    public $model_options = array();
}
