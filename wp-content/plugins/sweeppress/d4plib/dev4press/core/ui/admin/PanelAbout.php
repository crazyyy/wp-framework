<?php

namespace Dev4Press\v42\Core\UI\Admin;

use Dev4Press\v42\Core\Admin\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PanelAbout extends Panel {
	protected $sidebar = false;
	protected $history = false;
	protected $default_subpanel = 'whatsnew';
	protected $wrapper_class = 'd4p-page-about';

	public function __construct( $admin ) {
		parent::__construct( $admin );

		$this->init_default_subpanels();
	}

	protected function init_default_subpanels() {
		$this->subpanels = array(
			'whatsnew'  => array(
				'title' => __( "What&#8217;s New", "d4plib" ),
				'icon'  => ''
			),
			'donate'    => array(
				'title' => __( "Donations", "d4plib" ),
				'icon'  => ''
			),
			'info'      => array(
				'title' => __( "Info", "d4plib" ),
				'icon'  => ''
			),
			'changelog' => array(
				'title' => __( "Changelog", "d4plib" ),
				'icon'  => ''
			),
			'history'   => array(
				'title' => __( "History", "d4plib" ),
				'icon'  => ''
			),
			'system'    => array(
				'title' => __( "System", "d4plib" ),
				'icon'  => ''
			),
			'dev4press' => array(
				'title' => __( "Dev4Press", "d4plib" ),
				'icon'  => ''
			)
		);

		if ( ! ( $this->a()->settings()->i()->edition === 'free' && ! empty( $this->a()->settings()->i()->github_url ) ) ) {
			unset( $this->subpanels[ 'donate' ] );
		}

		if ( ! $this->history ) {
			unset( $this->subpanels[ 'history' ] );
		}

		$translations = $this->a()->settings()->i()->translations;

		if ( empty( $translations ) ) {
			unset( $this->subpanels[ 'translations' ] );
		}
	}

	public function enqueue_scripts() {
		$this->a()->enqueue->css( 'about' );
	}
}
