<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

new Responsive_Lightbox_Welcome_Page();

/**
 * Responsive_Lightbox_Welcome_Page class.
 * 
 * @class Responsive_Lightbox_Welcome_Page
 */
class Responsive_Lightbox_Welcome_Page {

	public function __construct() {
		// actions
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome' ) );
	}

	/**
	 * Add admin menus/screens.
	 */
	public function admin_menus() {
		$welcome_page_title = __( 'Welcome to Responsive Lightbox & Gallery', 'responsive-lightbox' );
		// about
		$about = add_dashboard_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'responsive-lightbox-about', array( $this, 'about_screen' ) );
	}

	/**
	 * Add styles just for this page, and remove dashboard page links.
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'responsive-lightbox-about' );
	}

	/**
	 * Intro text/links shown on all about pages.
	 * 
	 * @return mixed
	 */
	private function intro() {

		// get plugin version
		$plugin_version = substr( get_option( 'responsive_lightbox_version' ), 0, 3 );
		?>
		<h2 style="text-align: left; font-size: 29px; padding-bottom: 0;"><?php _e( 'Welcome to', 'responsive-lightbox' ); ?></h2>
		<h1 style="margin-top: 0;"><?php printf( __( 'Responsive Lightbox & Gallery %s', 'responsive-lightbox' ), $plugin_version ); ?></h1>

		<div class="about-text">
			<?php
			printf( __( 'Thank you for choosing Responsive Lightbox & Gallery - the most popular lightbox plugin and a powerful gallery builder for WordPress.', 'responsive-lightbox' ), $plugin_version );
			?>
		</div>
		
		<div class="rl-badge" style="position: absolute; top: 0; right: 0; box-shadow: 0 1px 3px rgba(0,0,0,.1); max-width: 180px;"><img src="<?php echo RESPONSIVE_LIGHTBOX_URL . '/images/logo-rl.png'; ?>" width="180" height="180" /></div>

		<div class="changelog">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=responsive-lightbox-tour' ) ); ?>" class="button button-primary button-large"><?php _e( 'Start Tour', 'responsive-lightbox' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=responsive-lightbox-settings' ) ); ?>" class="button button-primary button-large"><?php _e( 'Settings', 'responsive-lightbox' ); ?></a>
			<a href="https://dfactory.eu/docs/responsive-lightbox/?utm_source=responsive-lightbox-welcome&utm_medium=button&utm_campaign=documentation" class="button button-secondary button-large" target="_blank"><?php _e( 'Documentation', 'responsive-lightbox' ); ?></a>
			<a href="https://dfactory.eu/support/?utm_source=responsive-lightbox-welcome&utm_medium=button&utm_campaign=support" class="button button-secondary button-large" target="_blank"><?php _e( 'Support', 'responsive-lightbox' ); ?></a>
			<a href="https://dfactory.eu/?utm_source=responsive-lightbox-welcome&utm_medium=button&utm_campaign=dfactory-plugins" class="button button-secondary button-large" target="_blank"><?php _e( 'dFactory Plugins', 'responsive-lightbox' ); ?></a>
		</div>
		
		<hr />
		<?php
	}

	/**
	 * Ootput the about screen.
	 * 
	 * @return mixed
	 */
	public function about_screen() {
		?>
		<div class="wrap about-wrap full-width-layout">

			<?php $this->intro(); ?>
			
			<div class="feature-section">
				<h2><?php _e( 'Advanced Gallery Builder', 'responsive-lightbox' ); ?></h2>			
				<p><?php _e( 'Responsive Lightbox & Gallery comes with a powerful gallery builder right out of the box that lets you manage galleries the same way you manage posts and pages on your WordPress website. You can add images to your gallery, adjust its settings and lightbox scripts, and configure its display options.', 'responsive-lightbox' ); ?></p>	
				<img src="<?php echo RESPONSIVE_LIGHTBOX_URL . '/images/welcome.png'; ?>" />
			</div>

			<div class="feature-section">
				<h2><?php _e( 'Multiple Lightbox Effects', 'responsive-lightbox' ); ?></h2>
				<p><?php _e( "Responsive Lightbox & Gallery gives you the control to beautify your images, videos, and galleries using lightbox scripts that look great on all devices. We've got everything from lightweight, functional lightboxes to heavy-customizable, fancy ones.", 'responsive-lightbox' ); ?></p>
			</div>

			<div class="feature-section">
				<h2><?php _e( 'Easy Setup', 'responsive-lightbox' ); ?></h2>
				<p><?php _e( 'A lot goes into making a good first impression - especially when your site is doing all the talking. Responsive Lightbox & Gallery automatically adds lightbox effects to all of your image galleries, image links, and video links so you can sit back and relax while we make sure your website looks its best.', 'responsive-lightbox' ); ?></p>
			</div>
			
			<div class="feature-section">
				<h2><?php _e( 'Powerful Addons', 'responsive-lightbox' ); ?></h2>
				<p><?php printf( __( 'Responsive Lightbox & Gallery enhances your site by making its images and galleries look visually appealing to your site users. And when you want to kick things up a notch you can pair the free, core plugin with <del>one of 10</del> one of 12 <a href="%s">premium extensions.</a>', 'responsive-lightbox' ), esc_url( admin_url( 'admin.php?page=responsive-lightbox-addons' ) ) ); ?></p>
			</div>
			
			<hr />

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=responsive-lightbox-settings' ) ); ?>"><?php _e( 'Go to Settings', 'responsive-lightbox' ); ?></a>
			</div>
			
		</div>
		<?php
	}

	/**
	 * Send user to the welcome page on first activation.
	 */
	public function welcome() {

		// bail if no activation redirect transient is set
		if ( ! get_transient( 'rl_activation_redirect' ) )
			return;

		// delete the redirect transient
		delete_transient( 'rl_activation_redirect' );

		// bail if activating from network, or bulk, or within an iFrame
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) || defined( 'IFRAME_REQUEST' ) )
			return;

		if ( (isset( $_GET['action'] ) && 'upgrade-plugin' == $_GET['action']) && (isset( $_GET['plugin'] ) && strstr( $_GET['plugin'], 'responsive-lightbox.php' )) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=responsive-lightbox-about' ) );
		exit;
	}

}