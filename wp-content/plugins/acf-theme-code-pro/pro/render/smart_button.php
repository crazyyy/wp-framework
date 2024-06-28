<?php
// ACF Smart Button
// https://github.com/gillesgoetsch/acf-smart-button

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo $this->indent . htmlspecialchars("<?php \$".$this->var_name." = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name." ) : ?>")."\n";
echo $this->indent . htmlspecialchars("	<a href=\"<?php echo esc_url( \$".$this->var_name."['url'] ); ?>\" <?php echo \$".$this->var_name."['target']; ?> ><?php echo esc_html( \$".$this->var_name."['text'] ); ?></a>")."\n";
echo $this->indent . htmlspecialchars("<?php endif; ?>\n");