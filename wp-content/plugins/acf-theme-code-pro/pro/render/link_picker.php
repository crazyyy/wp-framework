<?php
// Link picker field
// https://wordpress.org/plugins/acf-link-picker-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Basic support for the link field
echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
echo $this->indent . htmlspecialchars("<a href=\"<?php echo \$".$this->var_name."['url']; ?>\" target=\"<?php echo \$".$this->var_name."['target']; ?>\" > ")."\n";
echo $this->indent . htmlspecialchars("    <?php echo \$".$this->var_name."['title']; ?>")."\n";
echo $this->indent . htmlspecialchars("</a>")."\n";
