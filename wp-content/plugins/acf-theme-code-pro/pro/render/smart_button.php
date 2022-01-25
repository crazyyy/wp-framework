<?php
// Smart_button field
// https://github.com/gillesgoetsch/acf-smart-button

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Basic support for the smart button field
echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name." ): ?>")."\n";
echo $this->indent . htmlspecialchars("     <a href=\"<?php echo \$".$this->var_name."['url']; ?>\" <?php echo \$".$this->var_name."['target']; ?> > ")."\n";
echo $this->indent . htmlspecialchars("         <?php echo \$".$this->var_name."['text']; ?>")."\n";
echo $this->indent . htmlspecialchars("     </a>")."\n";
echo $this->indent . htmlspecialchars("<?php endif; ?>")."\n";
