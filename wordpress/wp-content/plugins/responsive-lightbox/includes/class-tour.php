<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

new Responsive_Lightbox_Tour();

/**
 * Responsive_Lightbox_Tour class.
 * 
 * @class Responsive_Lightbox_Tour
 */
class Responsive_Lightbox_Tour {

	public function __construct() {
		// actions
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_tour' ) );
		add_action( 'wp_ajax_rl-ignore-tour', array( $this, 'ignore_tour' ) );
	}

	/**
	 * Initialize tour.
	 */
	public function init_tour() {
		if ( ! current_user_can( apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ) ) )
			return;

		global $pagenow;

		if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'responsive-lightbox-tour' ) {
			set_transient( 'rl_active_tour', 1, 0 );

			if ( Responsive_Lightbox()->options['builder']['gallery_builder'] )
				wp_redirect( admin_url( 'edit.php?post_type=rl_gallery' ) );
			else
				wp_redirect( admin_url( 'admin.php?page=responsive-lightbox-settings' ) );

			exit;
		}

		if ( (int) get_transient( 'rl_active_tour' ) === 1 ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'tour_scripts_styles' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'start_tour' ) );
		}
	}

	/**
	 * Add temporary admin menu.
	 */
	public function admin_menu() {
		global $pagenow;

		if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'responsive-lightbox-tour' )
			add_submenu_page( 'responsive-lightbox-settings', '', '', apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ), 'responsive-lightbox-tour', array( $this, 'temporary_submenu' ) );
	}

	/**
	 *
	 */
	function temporary_submenu() {
		// nothing to do here
	}

	/**
	 * Load pointer scripts.
	 */
	public function tour_scripts_styles() {
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_script( 'utils' );
	}

	/**
	 * Load the introduction tour.
	 */
	public function start_tour() {
		global $pagenow;

		$pointer = array();
		$rl = Responsive_Lightbox();

		// galleries
		if ( $pagenow === 'edit.php' ) {
			if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'rl_gallery' && $rl->options['builder']['gallery_builder'] ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'Gallery Builder', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'This is an advanced gallery builder. Here you can see a preview of all created galleries along with their settings, such as the name, type, source of images, author or date of publication. You can also add a new gallery, edit existing ones or quickly copy the code allowing its use on the site.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content h1'
				);

				// next categories?
				if ( $rl->options['builder']['categories'] )
					$pointer['function'] = 'window.location="' . admin_url( 'edit-tags.php?taxonomy=rl_category&post_type=rl_gallery' ) . '";';
				// next tags?
				elseif ( $rl->options['builder']['tags'] )
					$pointer['function'] = 'window.location="' . admin_url( 'edit-tags.php?taxonomy=rl_tag&post_type=rl_gallery' ) . '";';
				// or settings?
				else
					$pointer['function'] = 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-settings' ) . '";';
			}
			// gallery taxonomies
		} elseif ( $pagenow === 'edit-tags.php' ) {
			if ( isset( $_GET['taxonomy'], $_GET['post_type'] ) && $_GET['post_type'] === 'rl_gallery' ) {
				if ( $_GET['taxonomy'] === 'rl_category' ) {
					$pointer = array(
						'content'	 => '<h3>' . __( 'Gallery Categories', 'responsive-lightbox' ) . '</h3>' . 
						'<p>' . __( 'Gallery categories allow you to arrange galleries into individual groups that you can potentially use. Here you can create, name and edit them. However, assigning the gallery to the category takes place on the gallery editing screen.', 'responsive-lightbox' ) . '</p>',
						'button2'	 => __( 'Next', 'responsive-lightbox' ),
						'id'		 => '#wpbody-content h1'
					);

					// next tags?
					if ( $rl->options['builder']['tags'] )
						$pointer['function'] = 'window.location="' . admin_url( 'edit-tags.php?taxonomy=rl_tag&post_type=rl_gallery' ) . '";';
					// or settings?
					else
						$pointer['function'] = 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-settings' ) . '";';
				} elseif ( $_GET['taxonomy'] === 'rl_tag' ) {
					$pointer = array(
						'content'	 => '<h3>' . __( 'Gallery Tags', 'responsive-lightbox' ) . '</h3>' . 
						'<p>' . __( 'Gallery tags, like categories, allow you to arrange galleries into groups. You can think of them as keywords, which you can use to further specify your galleries. Here you can create, name and edit them.', 'responsive-lightbox' ) . '</p>',
						'button2'	 => __( 'Next', 'responsive-lightbox' ),
						'id'		 => '#wpbody-content h1',
						'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-settings' ) . '";'
					);
				}
			}
			// settings
		} elseif ( $pagenow === 'admin.php' && isset( $_GET['page'] ) ) {
			// general
			if ( $_GET['page'] === 'responsive-lightbox-settings' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'General Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( "Here are the main settings for Responsive Lightbox & Gallery. They allow you to specify general rules of the plugin's operation and technical parameters of the lightbox effect and gallery. For example - you can choose your favorite lightbox effect, specify for which elements it will automatically launch and set its parameters. You can also choose the default gallery with its settings.", 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-configuration' ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-configuration' ) {
				// get additional plugins based on tabs
				$plugins = array_values( array_diff( array_keys( $rl->settings->tabs ), array( 'settings', 'configuration', 'gallery', 'builder', 'folders', 'licenses', 'addons' ) ) );

				if ( ! empty( $plugins ) ) {
					// get first plugin tab key
					$plugin_key = $plugins[0];
				} else
					$plugin_key = 'gallery';

				$pointer = array(
					'content'	 => '<h3>' . __( 'Lightboxe Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'Each lightbox has different look, possibilities and parameters. Here is a list of available lightbox effects along with their settings. After entering the tab you can see the settings of the currently selected lightbox, but you can also modify or restore the settings of the others.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-' . $plugin_key ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-gallery' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'Gallery Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( "This is the screen of the default gallery settings. As in the case of lightbox effects, there is a list of available galleries and their parameters. After entering the tab you can see the settings of the currently selected gallery. You can modify and adjust them to your needs or restore it's default settings.", 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-builder' ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-builder' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'Builder Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'You can use the galleries in many ways - insert them into posts using the Add Gallery button, insert manually using shortcodes or add to the theme using functions. But you can also display them in archives just like other post types. Use these settings to specify the functionality of the gallery builder like categories, tags, archives and permalinks.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-' . ( $rl->options['folders']['active'] ? 'folders' : ( ! empty( $rl->settings->tabs['licenses'] ) ? 'licenses' : 'addons' ) ) ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-folders' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'Folders Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'Responsive Lithbox & Gallery comes with an optional Media Folders feature that extends your WordPress Media Library with visual folders. It allows you to organize your attachments in a folder tree structure. Move, copy, rename and delete files and folders with a nice drag and drop interface.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-' . ( ! empty( $rl->settings->tabs['licenses'] ) ? 'licenses' : 'addons' ) ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-licenses' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'License Settings', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'This section contains a list of currently installed premium extensions. Activate your licenses to have access to automatic updates from your site. To activate the license, copy and paste the license key for the extension and save the changes. Available license keys can be found on your account on our website.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => __( 'Next', 'responsive-lightbox' ),
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => 'window.location="' . admin_url( 'admin.php?page=responsive-lightbox-addons' ) . '";'
				);
			} elseif ( $_GET['page'] === 'responsive-lightbox-addons' ) {
				$pointer = array(
					'content'	 => '<h3>' . __( 'Add-ons', 'responsive-lightbox' ) . '</h3>' . 
					'<p>' . __( 'Responsive Lightbox & Gallery is more than that. Do you need a beautiful lightbox effect, integration with social media, an attractive image gallery? Among our products you will surely find something for yourself. Boost your creativity and enhance your website with these beautiful, easy to use extensions, designed with Responsive Lightbox & Gallery integration in mind.', 'responsive-lightbox' ) . '</p>',
					'button2'	 => '',
					'id'		 => '#wpbody-content .wrap h2:first',
					'function'	 => ''
				);
				// plugins related tabs
			} else {
				$pointer = apply_filters( 'rl_tour_pointer', array(), esc_attr( $_GET['page'] ) );
			}
		}

		// valid pointer?
		if ( ! empty( $pointer ) ) {
			$valid_pointer = array(
				'content'		 => $pointer['content'],
				'position'		 => array(
					'edge'	 => 'top',
					'align'	 => is_rtl() ? 'right' : 'left'
				),
				'pointerWidth'	 => 400,
			);

			$this->print_scripts( $pointer['id'], $valid_pointer, __( 'Close', 'responsive-lightbox' ), $pointer['button2'], $pointer['function'] );
		}
	}

	/**
	 * Ignore tour.
	 */
	public function ignore_tour() {
		if ( isset( $_POST['rl_nonce'] ) && wp_verify_nonce( $_POST['rl_nonce'], 'rl-ignore-tour' ) !== false )
			delete_transient( 'rl_active_tour' );

		exit;
	}

	/**
	 * Prints the pointer script
	 */
	public function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '',	$button1_function = '' ) {
		?>
		<script type="text/javascript">
			//<![CDATA[
			( function ( $ ) {
				$( document ).ready( function ( $ ) {
					var rl_pointer_options = <?php echo json_encode( $options ); ?>,
						setup;

					function rl_set_ignore( option, hide, nonce ) {
						$.post( ajaxurl, {
							action: 'rl-ignore-tour',
							rl_nonce: nonce
						}, function ( data ) {
							if ( data ) {
								$( '#' + hide ).hide();
								$( '#hidden_ignore_' + option ).val( 'ignore' );
							}
						}
						);
					}

					rl_pointer_options = $.extend( rl_pointer_options, {
						buttons: function ( event, t ) {
							var button = $( '<a id="rl-pointer-close" style="margin-left: 5px;" class="button-secondary">' + '<?php echo $button1; ?>' + '</a>' );

							button.bind( 'click.pointer', function () {
								t.element.pointer( 'close' );
							} );

							return button;
						},
						close: function () {}
					} );

					setup = function () {
						$( '<?php echo $selector; ?>' ).pointer( rl_pointer_options ).pointer( 'open' );

						<?php if ( $button2 ) { ?>

							$( '#rl-pointer-close' ).after( '<a id="pointer-primary" class="button-primary">' + '<?php echo $button2; ?>' + '</a>' );
							$( '#pointer-primary' ).click( function () {
								<?php echo $button2_function; ?>
							} );

						<?php } ?>

						$( '#rl-pointer-close' ).click( function () {
							rl_set_ignore( 'tour', 'wp-pointer-0', '<?php echo esc_js( wp_create_nonce( 'rl-ignore-tour' ) ); ?>' );
						} );
					};

					if ( rl_pointer_options.position && rl_pointer_options.position.defer_loading )
						$( window ).bind( 'load.wp-pointers', setup );
					else
						$( document ).ready( setup );
				} );
			} )( jQuery );
			//]]>
		</script>
		<?php
	}

}
