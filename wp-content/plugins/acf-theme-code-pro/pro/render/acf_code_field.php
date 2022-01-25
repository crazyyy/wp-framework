<?php
// Code field
// https://wordpress.org/plugins/acf-code-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Return the field wrapped in markup for a code block
echo $this->indent . htmlspecialchars("<pre><code><?php echo esc_html( " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ) ); ?></code></pre>")."\n";
