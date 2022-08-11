<?php
/**
 * Advanced Custom Fields: Gravityforms Add-on
 * https://wordpress.org/plugins/acf-gravityforms-add-on/
 * 
 * Advanced Custom Fields: Ninjaforms Add-on
 * https://wordpress.org/plugins/acf-ninjaforms-add-on/
 * 
 * These two plugins are created by the same person and both use the `forms` slug.
 * 
 * Note the same test fields are used for Gravity Forms and Ninja Forms.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = isset( $this->settings['return_format'] ) ? $this->settings['return_format'] : '';
$multiple = isset( $this->settings['multiple'] ) ? $this->settings['multiple'] : '';

// Render generic `get_field()` code
echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name }'{$this->location_rendered_param} ); ?>\n");

// If both add ons are active (unlilkely as they conflict)
if ( is_plugin_active( 'acf-gravityforms-add-on/acf-gravityforms-add-on.php' )
	&& is_plugin_active( 'acf-ninjaforms-add-on/acf-ninjaforms-add-on.php' ) ) {

	// Render generic `var_dump()` code
	echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");

}

// Gravity Forms add on active
elseif ( is_plugin_active( 'acf-gravityforms-add-on/acf-gravityforms-add-on.php' ) ) {

	echo $this->indent . htmlspecialchars("<?php if ( \${$this->var_name} ) : ?>\n");

	if ( $multiple == '0' ) {

		if ( $return_format == 'post_object' ) {
			echo $this->indent . htmlspecialchars("	<?php gravity_form( \${$this->var_name}['id'] ); ?>\n");
		}
		elseif ( $return_format == 'id' ) {
			echo $this->indent . htmlspecialchars("	<?php gravity_form( \${$this->var_name} ); ?>\n");
		}
		else {
			echo $this->indent . htmlspecialchars("	<?php // var_dump( \${$this->var_name} ); ?>\n");
		}

	}

	elseif ( $multiple == '1' ) {

		// Add `foreach` and indenting
		echo $this->indent . htmlspecialchars("	<?php foreach ( \${$this->var_name} as \$form ) : ?>\n");
		
		if ( $return_format == 'post_object' ) {
			echo $this->indent . htmlspecialchars("		<?php gravity_form( \$form['id'] ); ?>\n");
		}
		elseif ( $return_format == 'id' ) {
			echo $this->indent . htmlspecialchars("		<?php gravity_form( \$form ); ?>\n");
		}
		else {
			echo $this->indent . htmlspecialchars("		<?php // var_dump( \$form ); ?>\n");
		}

		echo $this->indent . htmlspecialchars("	<?php endforeach; ?>\n");

	}

	echo $this->indent . htmlspecialchars("<?php endif; ?>\n");

}

// Ninja Forms add on active
elseif ( is_plugin_active( 'acf-ninjaforms-add-on/acf-ninjaforms-add-on.php' ) ) {

	echo $this->indent . htmlspecialchars("<?php if ( \${$this->var_name} ) : ?>\n");

	if ( $multiple == '0' ) {

		if ( $return_format == 'post_object' ) {
			echo $this->indent . htmlspecialchars("	<?php Ninja_Forms()->display( \${$this->var_name}->get_id() ); ?>\n");
		}
		elseif ( $return_format == 'id' ) {
			echo $this->indent . htmlspecialchars("	<?php Ninja_Forms()->display( \${$this->var_name} ); ?>\n");
		}
		else {
			echo $this->indent . htmlspecialchars("	<?php // var_dump( \${$this->var_name} ); ?>\n");
		}

	}

	elseif ( $multiple == '1' ) {

		// Add `if` and `foreach`
		echo $this->indent . htmlspecialchars("	<?php foreach ( \${$this->var_name} as \$form ) : ?>\n");

		if ( $return_format == 'post_object' ) {
			echo $this->indent . htmlspecialchars("		<?php Ninja_Forms()->display( \$form->get_id() ); ?>\n");
		} elseif ( $return_format == 'id' ) {
			echo $this->indent . htmlspecialchars("		<?php Ninja_Forms()->display( \$form ); ?>\n");
		}
		else {
			echo $this->indent . htmlspecialchars("		<?php // var_dump( \$form ); ?>\n");
		}

		echo $this->indent . htmlspecialchars("	<?php endforeach; ?>\n");

	}

	echo $this->indent . htmlspecialchars("<?php endif; ?>\n");

}
