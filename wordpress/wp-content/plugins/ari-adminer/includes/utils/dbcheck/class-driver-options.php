<?php
namespace Ari_Adminer\Utils\Dbcheck;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

use Ari\Utils\Options as Options;

class Driver_Options extends Options {
    public $db_name  = '';

    public $host = '';

    public $user = '';

    public $pass = '';
}
