<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class for field functionality
 */
class ACFTC_Pro_Field extends ACFTC_Field {

	/**
	 * Get location paramater to be rendered
	 * 
	 * @return string Containing a variable name or value
	 **/
	protected function get_location_rendered_param() {

		// If location set to options page, add the options parameter
		if ($this->location_rule_param == 'options_page') {

			return ', \'option\'';

		} elseif ( $this->location_rule_param == 'current_user' ||
				   $this->location_rule_param == 'current_user_role' || 
				   $this->location_rule_param == 'user_role' || 
				   $this->location_rule_param == 'user_form' ) {

			return ', $user_id_prefixed';

		} elseif ($this->location_rule_param == 'taxonomy') {

			return ', $term_id_prefixed';

		} elseif ($this->location_rule_param == 'attachment') {

			return ', $attachment_id';

		} elseif ($this->location_rule_param == 'widget') {

			return ', $widget_id_prefixed';

		} elseif ($this->location_rule_param == 'comment') {

			return ', $comment_id_prefixed';

		} else {

			return '';

		}

	}
	
	// Get the path to the partial used for rendering the field
	protected function get_render_partial() {

		if ( $this->type ) {

			// TODO Remove all the code here that's the same as the class extended?

            // Basic field types with a shared partial
            if ( in_array( $this->type, ACFTC_Core::$field_types_basic ) ) {

                $render_partial = ACFTC_PLUGIN_DIR_PATH . 'render/basic.php';
                
            }

			// Field types only supported in TC Pro
			elseif ( in_array( $this->type, ACFTC_Core::$field_types_all_tc_pro ) ) {

				$render_partial = ACFTC_PLUGIN_DIR_PATH . 'pro/render/' . $this->type . '.php';
        
            }
			
			// Field types with their own partial
			else {

                $render_partial = ACFTC_PLUGIN_DIR_PATH . 'render/' . $this->type . '.php';
                
			}

			return $render_partial;

		}

	}


    /**
	 * Is ignored field type
	 *
	 * @param string $field_type
	 * @return bool
	 **/
	protected function is_ignored_field_type( $field_type = '' ) {

		return in_array( $field_type, ACFTC_Core::$ignored_field_types ); // TODO only difference here from exteneded classs is the PRO class name

	}


	/**
	 * Get the HTML for the body of the field's code block
	 *
	 * @return string 
	 **/
	protected function get_field_html_body() {

		ob_start();

		if ( file_exists( $this->render_partial ) ) {

			include( $this->render_partial );

		} else {
			
			echo $this->indent . htmlspecialchars( "<?php // The " . $this->type  . " field type is not supported in this version of the plugin. ?>" ) . "\n";
			echo $this->indent . htmlspecialchars( "<?php // Contact http://www.hookturn.io to request support for this field type. ?>" ) . "\n";

		}

		return ob_get_clean();

	}


}
