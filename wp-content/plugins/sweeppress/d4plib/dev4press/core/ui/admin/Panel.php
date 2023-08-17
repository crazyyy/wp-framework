<?php

namespace Dev4Press\v42\Core\UI\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Panel {
	private static $_current_instance = null;

	/** @var \Dev4Press\v42\Core\Admin\Plugin|\Dev4Press\v42\Core\Admin\Menu\Plugin|\Dev4Press\v42\Core\Admin\Submenu\Plugin */
	private $admin;

	/** @var \Dev4Press\v42\Core\UI\Admin\Render */
	private $render;

	protected $sidebar = true;
	protected $form = false;
	protected $table = false;
	protected $cards = false;
	protected $subpanels = array();
	protected $render_class = '\\Dev4Press\\v42\\Core\\UI\\Admin\\Render';
	protected $wrapper_class = '';
	protected $default_subpanel = 'index';
	protected $form_multiform = false;
	protected $form_autocomplete = "off";
	protected $form_method = 'post';

	public $storage = array();

	public function __construct( $admin ) {
		$this->admin = $admin;

		$render       = $this->render_class;
		$this->render = $render::instance();

		add_action( 'load-' . $this->a()->screen_id, array( $this, 'screen_options_show' ) );

		add_action( $this->h( 'enqueue_scripts_early' ), array( $this, 'enqueue_scripts_early' ) );
		add_action( $this->h( 'enqueue_scripts' ), array( $this, 'enqueue_scripts' ) );
	}

	/** @return static */
	public static function instance( $admin = null ) {
		if ( is_null( self::$_current_instance ) && ! is_null( $admin ) ) {
			self::$_current_instance = new static( $admin );
		}

		return self::$_current_instance;
	}

	public function a() {
		return $this->admin;
	}

	public function r() {
		return $this->render;
	}

	public function h( $hook ) : string {
		return $this->a()->plugin_prefix . '_' . $hook;
	}

	public function subpanels() : array {
		return $this->subpanels;
	}

	public function header_fill() : string {
		return '';
	}

	public function object() : object {
		$subpanel = $this->current_subpanel();

		if ( isset( $this->subpanels[ $subpanel ] ) ) {
			return (object) $this->subpanels[ $subpanel ];
		}

		return $this->a()->panel_object();
	}

	public function current_subpanel() : string {
		$_subpanel = $this->a()->subpanel;

		if ( ! empty( $this->subpanels ) ) {
			$_available = array_keys( $this->subpanels );

			if ( ! in_array( $_subpanel, $_available ) ) {
				$_subpanel = $this->default_subpanel;
			}
		}

		return $_subpanel;
	}

	public function has_form() : bool {
		return $this->form;
	}

	public function has_sidebar() : bool {
		return $this->sidebar;
	}

	public function has_table() : bool {
		return $this->table;
	}

	public function has_cards() : bool {
		return $this->cards;
	}

	public function validate_subpanel( $name ) {
		if ( empty( $this->subpanels ) ) {
			return '';
		}

		if ( isset( $this->subpanels[ $name ] ) ) {
			return $name;
		}

		$valid = array_keys( $this->subpanels );

		return $valid[ 0 ];
	}

	public function enqueue_scripts_early() {

	}

	public function enqueue_scripts() {

	}

	public function screen_options_show() {
	}

	public function wrapper_class() : array {
		$_classes = array(
			'd4p-wrap',
			'd4p-plugin-' . $this->a()->plugin,
			'd4p-panel-' . $this->a()->panel
		);

		$_subpanel = $this->current_subpanel();

		if ( ! empty( $_subpanel ) ) {
			$_classes[] = 'd4p-subpanel-' . $_subpanel;
		}

		if ( $this->has_sidebar() ) {
			$_classes[] = 'd4p-with-sidebar';
		} else {
			$_classes[] = 'd4p-full-width';
		}

		if ( $this->table ) {
			$_classes[] = 'd4p-with-table';
		}

		if ( $this->cards ) {
			$_classes[] = 'd4p-with-cards';
		}

		if ( ! empty( $this->wrapper_class ) ) {
			$_classes[] = $this->wrapper_class;
		}

		return $_classes;
	}

	public function prepare() {
	}

	public function show() {
		$this->include_header();

		echo '<div class="d4p-inside-wrapper">';
		if ( $this->has_form() ) {
			echo $this->form_tag_open();
		}

		echo '<div class="d4p-content-wrapper">';
		if ( $this->has_sidebar() ) {
			$this->include_sidebar();
		}

		$this->include_content();
		echo '</div>';

		if ( $this->has_form() ) {
			echo $this->form_tag_close();
		}
		echo '</div>';

		$this->include_footer();
	}

	public function forms_path_library() : string {
		return $this->a()->path . 'd4plib/forms/';
	}

	public function forms_path_plugin() : string {
		return $this->a()->path . 'forms/';
	}

	public function include_messages() {
		$this->load( 'message.php' );
	}

	public function include_notices() {
		if ( $this->a()->panel == 'dashboard' ) {
			if ( $this->a()->settings()->i()->is_bbpress_plugin ) {
				$this->load( 'notices-bbpress.php' );
			}
		}
	}

	public function include_header( $name = '', $subname = '' ) {
		$this->interface_colors();
		$this->include_generic( 'header', $name, $subname );
	}

	public function include_footer( $name = '', $subname = '' ) {
		$this->include_generic( 'footer', $name, $subname );
	}

	public function include_sidebar( $name = '', $subname = '' ) {
		$this->include_generic( 'sidebar', $name, $subname );
	}

	public function include_content( $name = '', $subname = '' ) {
		$this->include_generic( 'content', $name, $subname );
	}

	public function form_tag_open() : string {
		$id  = $this->a()->plugin_prefix . '-form-' . $this->a()->panel;
		$enc = $this->form_multiform ? 'enctype="multipart/form-data"' : '';

		return '<form method="' . esc_attr( $this->form_method ) . '" action="" id="' . esc_attr( $id ) . '" ' . $enc . ' autocomplete="' . esc_attr( $this->form_autocomplete ) . '">';
	}

	public function form_tag_close() : string {
		return '</form>';
	}

	public function include_accessibility_control() {
	}

	protected function interface_colors() {
		if ( $this->a()->auto_mod_interface_colors ) {
			?>

            <style>
                .<?php echo 'd4p-plugin-'.esc_html( $this->a()->plugin ); ?> {
                    --d4p-color-layout-accent: <?php echo esc_html( $this->a()->settings()->i()->color() ); ?>;
                    --d4p-color-sidebar-icon-text: <?php echo esc_html( $this->a()->settings()->i()->color() ); ?>;
                }
            </style>

			<?php
		}
	}

	protected function include_generic( $base, $name = '', $subname = '' ) {
		$name     = empty( $name ) ? $this->a()->panel : $name;
		$subname  = empty( $subname ) ? ( empty( $this->a()->subpanel ) ? '' : $this->a()->subpanel ) : $subname;
		$fallback = $content = $base . '-' . $name;

		if ( ! empty( $subname ) ) {
			$content .= '-' . $subname;
		}

		$fallback .= '.php';
		$content  .= '.php';

		$this->load( $content, $fallback, $base . '.php' );
	}

	protected function load( $name, $fallback = '', $default = '' ) {
		$list = array(
			$this->forms_path_plugin() . $name,
			$this->forms_path_library() . $name
		);

		if ( ! empty( $fallback ) ) {
			$list[] = $this->forms_path_plugin() . $fallback;
			$list[] = $this->forms_path_library() . $fallback;
		}

		if ( ! empty( $default ) ) {
			$list[] = $this->forms_path_plugin() . $default;
			$list[] = $this->forms_path_library() . $default;
		}

		foreach ( $list as $path ) {
			if ( file_exists( $path ) ) {
				include( $path );
				break;
			}
		}
	}
}
