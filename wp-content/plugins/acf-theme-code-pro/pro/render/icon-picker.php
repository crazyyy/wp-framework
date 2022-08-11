<?php
// ACF Icon Selector Field
// https://github.com/houke/acf-icon-picker/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
echo $this->indent . htmlspecialchars("<?php if ( \${$this->var_name} ) : ?>\n");
echo $this->indent . htmlspecialchars("	<img src=\"<?php echo get_stylesheet_directory_uri(); ?>/assets/img/acf/<?php echo esc_url( \${$this->var_name} ); ?>.svg\" />\n");
echo $this->indent . htmlspecialchars("<?php endif; ?>\n");
