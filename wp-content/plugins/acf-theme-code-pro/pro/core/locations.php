<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Content of theme code meta box
*/
class ACFTC_Pro_Locations extends ACFTC_Locations {

	/**
	 * Get HTML for a single location
	 *
	 * @param Array $location_rule
	 * Array (
	 *	[param] => block
	 *	[operator] => ==
	 *	[value] => acf/example
	 * ) 
	 * @param int $index Identifier for the location
	 * @return string 
	**/
	protected function get_single_location_html( $location_rule, $index ) {
		
		ob_start();

		$args = array(
			'field_group_id' => $this->field_group_post_ID,
			'location_rule_param' => $location_rule['param'] // included this time
		);

		$parent_field_group = new ACFTC_Group( $args ); 
		
		// Wrapping div used for show and hide functionality

?>
<div id="acftc-group-<?php echo $index; ?>" class="location-wrap">
<?php 

			echo $this->get_location_helper_html( $location_rule );
			
			if ( $location_rule['param'] != 'block' ) { 
				echo $parent_field_group->get_field_group_html(); 
			}
			
?>
</div>
<?php

		return ob_get_clean();

	}


	/**
	 * Get html for location helper
	 *
	 * @param Array $location_rule
	 * Array (
	 *	[param] => block
	 *	[operator] => ==
	 *	[value] => acf/example
	 * )
	 * @return string 
	 */
	private function get_location_helper_html( $location_rule ) { 

		$location_helper_title = $this->get_location_helper_title( $location_rule );
		$location_helper_php = $this->get_location_helper_php( $location_rule );
		
		if ( !$location_helper_title || !$location_helper_php ) {
			return "";
		}
		
		ob_start();

?>
	<div class="acftc-field-meta">
		<span class="acftc-field-meta__title" data-pseudo-content="<?php echo $location_helper_title; ?>"></span>
	</div>

	<div class="acftc-field-code">
		<a href="#" class="acftc-field__copy acf-js-tooltip" title="<?php _e( 'Copy to clipboard', 'acf-theme-code' ) ?>"></a>
		<pre class="line-numbers"><code class="language-php"><?php echo $location_helper_php; ?></code></pre>
	</div>
<?php

		return ob_get_clean();
		
	}


	/**
	 * Get location helper block title
	 * 
	 * @param Array $location_rule
	 * Array (
	 *	[param] => block
	 *	[operator] => ==
	 *	[value] => acf/example
	 * )
	 * @return string/false
     *
	 */
	private function get_location_helper_title( $location_rule ) { 

		if ( empty( $location_rule ) ) {
			return false;
		}

		$location_slug = $location_rule['param'];

		switch ( $location_slug ) {

			case 'current_user':
				return __( 'User Variables', 'acf-theme-code' );
				break;	

			case 'current_user_role':
				return __( 'User Variables', 'acf-theme-code' );
				break;				

			case 'user_form':
				return __( 'User Variables', 'acf-theme-code' );
				break;

			case 'user_role':
				return __( 'User Variables', 'acf-theme-code' );
				break;

            case 'attachment':
                return __( 'Attachment Variables', 'acf-theme-code' );
                break;
               
            case 'taxonomy':
                return __( 'Taxonomy Term Variables', 'acf-theme-code' );
                break;

            case 'comment':
                return __( 'Comment Variables', 'acf-theme-code' );
                break;
                
            case 'widget':
                return __( 'Widget Variables', 'acf-theme-code' );
                break;

			case 'block':
				return __( 'Block Template', 'acf-theme-code' );
                break;

			default:
				return false;
				break;
		}

	}

	
	/**
	 * Get location helper php
	 *
	 * @param Array $location_rule
	 * Array (
	 *	[param] => block
	 *	[operator] => ==
	 *	[value] => acf/example
	 * )
	 * @return string
	 */
	private function get_location_helper_php( $location_rule ) { 
		
		// TODO Block partial is dependent on $location_rule
		
		ob_start();

		$location_slug = $location_rule['param'];

		$location_helper_partial = ACFTC_PLUGIN_DIR_PATH . 'pro/location-helpers/' . $location_slug . '.php';

		if ( file_exists( $location_helper_partial ) ) {
			include( $location_helper_partial );
		} 

		return ob_get_clean();

	}

	
	/**
	 * Get HTML for any notices to be added below field group
	 * 
	 * @return string 
	 */
	protected function get_after_field_group_notice_html() { 
		
		return ''; // No upgrade notices

	}

}
