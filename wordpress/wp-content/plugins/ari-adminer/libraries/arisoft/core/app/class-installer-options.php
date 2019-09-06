<?php
namespace Ari\App;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

use Ari\Utils\Options as Options;

class Installer_Options extends Options {
    public $installed_version = '';

    public $version = '';
}
