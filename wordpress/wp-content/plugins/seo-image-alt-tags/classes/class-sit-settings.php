<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

interface i_SitSettings {

}
/**
 * PLUGIN SETTINGS PAGE
 */
class SitSettings {
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	public $sit_settings;
	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_sit_menu_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );

	}
	/**
	 * Add options page
	 */
	public function add_sit_menu_page() {

		add_submenu_page(
			'tools.php',
			'SEO Toolbox',
			'SEO Toolbox',
			'manage_options',
			'seo-image-tags',
			array( $this, 'create_sit_menu_page' )//,
		);
	}

	public function create_sit_menu_page() {
		// Set class property
		$this->sit_settings = get_option( 'sit_settings' );
		?>
        <div class="sit-wrap wrap">
            <div>
                <h1>SEO Image Toolbox</h1>
                <form method="post" action="options.php">
					<?php

					// Create an nonce for a link.
					// We pass it as a GET parameter.
					// The target page will perform some action based on the 'do_something' parameter.

					settings_fields( 'sit_settings_group' );
					do_settings_sections( 'sit-options-admin' );
					//submit_button('Save All Options');
					?>
                </form>
            </div>
			<?php //echo gtm_get_sidebar(); ?>
        </div>
		<?php
	}


	/**
	 * Register and add settings
	 */
	public function page_init() {
		//global $geo_mashup_options;
		register_setting(
			'sit_settings_group', // Option group
			'sit_settings', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'sit_settings_section', // ID
			'', // Title
			array( $this, 'sit_info' ), // Callback
			'sit-options-admin' // Page
		);

		add_settings_section(
			'sit_option', // ID
			'', // Title
			array( $this, 'sit_option_callback' ), // Callback
			'sit-options-admin', // Page
			'sit_settings_section' // Section
		);

	}
	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();
		if( isset( $input['sit_settings'] ) )
			$new_input['sit_settings'] = absint( $input['sit_settings'] );

		return $input;
	}


	public function sit_info() {

		if ($this->sit_settings['update']) {

			$count = array();
			$count = batch_update_image_tags(true);

			echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p>';

			foreach( $count as $key => $value ) {
				echo '<strong>'.$key.':</strong>&nbsp;'.$value.'<br>';
			}
			update_option($sit_settings['update'], '');
			echo '</p></div>';

		} elseif ($this->sit_settings['delete']) {
			$count = array();
			$count = batch_update_image_tags(false);
			echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p>';

			foreach( $count as $key => $value ) {
				echo '<strong>'.$key.':</strong>&nbsp;'.$value.'<br>';
			}
			update_option($sit_settings['delete'], '');

			echo '</p></div>';

		}

	}
	/**
	 * Print the Section text
	 */

	/**
	 * Get the settings option array and print one of its values
	 */
	public function sit_option_callback() {
		//Get plugin options

		global $sit_settings;
		wp_enqueue_media();

		// Get trail story options
		$sit_settings = (array) get_option( 'sit_settings' ); ?>

        <div id="sit-settings" class="sit-settings plugin-info header">


            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        Database
                    </th>
                    <td>
                        <fieldset><?php $key = 'update'; ?>

                            <input class="button button-primary" id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="submit" value="Update Tags"  />


							<?php $key = 'delete'; ?>
                            &nbsp;
                            <input class="button-secondary delete" id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="submit" value="Delete Tags"  />

                        </fieldset>
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        Link Targetting
                    </th>
                    <td>
                        <fieldset><?php $key = 'enable_seo_links'; ?>
                            <label for="sit_settings[<?php echo $key; ?>]">
                                <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                Open external links in new tab.
                            </label>
                        </fieldset>
                        <fieldset><?php $key = 'enable_pdf_ext'; ?>

                            <label for="sit_settings[<?php echo $key; ?>]">
                                <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                Open internal PDFs in a new tab.
                            </label>

                        </fieldset>



                    </td>
                </tr>

                <tr>
                    <th> <?php submit_button('Save Settings'); ?></th>

                </tr>

                </tbody>
            </table>

            <hr>
            <br><br>


        </div>
	<?php }
}

if( is_admin() )
	$sit = new SitSettings();


