<?php
namespace Ari\Controllers;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

class Ajax_Options extends Controller_Options {
    public $nopriv = false;

    public $json_encode_options = 0;
}
