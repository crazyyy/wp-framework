<?php
namespace Ari_Adminer\Controllers\Adminer_Runner;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

use Ari\Controllers\Display as Display_Controller;
use Ari\Utils\Response as Response;

class Display extends Display_Controller {
    public function display( $tmpl = null ) {
        parent::display( $tmpl );
    }
}
