<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Help {
	public function __construct() {
		if ( $this->a()->panel == 'dashboard' ) {
			$this->_for_dashboard();
		} else if ( $this->a()->panel == 'statistics' ) {
			$this->_for_statistics();
		} else if ( $this->a()->panel == 'sweep' ) {
			$this->_for_sweep();
		} else if ( $this->a()->panel == 'sweepers' ) {
			$this->_for_sweepers();
		}

		if ( $this->a()->panel == 'dashboard' || $this->a()->panel == 'statistics' || $this->a()->panel == 'sweep' ) {
			$this->_for_every_panel();
		}
	}

	public static function instance() : Help {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Help();
		}

		return $instance;
	}

	private function a() : Plugin {
		return sweeppress_admin();
	}

	private function _for_every_panel() {
		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-shared-help',
				'title'   => __( "Sweeping Process", "sweeppress" ),
				'content' => '<h2>' . __( "Sweeping Process", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "There are few important things to know about the sweeping process.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "All the sweepers use SQL queries to estimate the number of records to remove and data to save from the database.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "And, every sweeper is using only SQL queries to perform the data removal. The main reason for this approach is performance, and to ensure that each sweeper finishes as fast as possible, even with huge data sets that need to be removed.", "sweeppress" ) . '</li>' .
				             '</ul>' .
				             '<p>' . __( "As for the list of records for deletion, database size you should know few more things.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "Displayed number of records and sizes for each sweeper are just estimations. Actual data size depends on the database server configuration, indexing, encoding and more.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "Estimted size is not taking into account index that tables always have, and is estimation based on data size, so in most cases, actual gains after sweeping can be bigger than estimation.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "After the sweeper has finished, displayed information about deleted records and recovered database space is also just an estimation!", "sweeppress" ) . '</li>' .
				             '</ul>',
			)
		);
	}

	private function _for_dashboard() {
		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-dashboard-auto',
				'title'   => __( "Auto Sweep", "sweeppress" ),
				'content' => '<h2>' . __( "Auto Sweep", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "The fastest way to clean up the WordPress database is by using Auto Sweep.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "Auto Sweep will run most of the sweepers with all the tasks, but not all.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "Make sure you check the list of all Sweepers included and where they can be used from.", "sweeppress" )
				             . '<br/><a href="admin.php?page=sweeppress-sweepers">' . esc_html__( "List of all Sweepers and where they can be used", "sweeppress" ) . '</a>' . '</li>' .
				             '</ul>',
			)
		);

		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-dashboard-quick',
				'title'   => __( "Quick Sweep", "sweeppress" ),
				'content' => '<h2>' . __( "Quick Sweep", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "If you want to quickly choose what to clean up, Quick Sweep on Dashboard will do that.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "This method shows quick overview of only available sweepers and tasks.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "You can choose one more sweepers and tasks to run from Dashboard.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "Quick Sweep will run most of the sweepers with all the tasks.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "Make sure you check the list of all Sweepers included and where they can be used from.", "sweeppress" )
				             . '<br/><a href="admin.php?page=sweeppress-sweepers">' . esc_html__( "List of all Sweepers and where they can be used", "sweeppress" ) . '</a>' . '</li>' .
				             '</ul>',
			)
		);
	}

	private function _for_sweep() {
		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-sweep-help',
				'title'   => __( "Sweeper", "sweeppress" ),
				'content' => '<h2>' . __( "Sweeper", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "This panel shows all the sweepers, all the tasks and more about sweepers.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "From this panel, you can run all available sweepers.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "For each sweeper, you can show explanation and other important information about each sweeper.", "sweeppress" ) . '</li>' .
				             '</ul>',
			)
		);
	}

	private function _for_statistics() {
		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-statistics-help',
				'title'   => __( "Sweeping Statistics", "sweeppress" ),
				'content' => '<h2>' . __( "Sweeping Statistics", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "The plugin keeps basic aggregated statistics information about sweepers cleanup, removed records and saved database space.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "The plugin keeps overall statistics and the monthly statistics. Via this panel, you can view this by choosing from the dropdown.", "sweeppress" ) . '</li>' .
				             '</ul>',
			)
		);
	}

	private function _for_sweepers() {
		$this->a()->screen()->add_help_tab(
			array(
				'id'      => 'sweeppress-sweepers-help',
				'title'   => __( "Sweepers List", "sweeppress" ),
				'content' => '<h2>' . __( "Sweepers List Overview", "sweeppress" ) . '</h2>' .
				             '<p>' . __( "This panel shows the list of all available sweepers with the availability indicators.", "sweeppress" ) . '</p>' .
				             '<ul>' .
				             '<li>' . __( "For each sweeper you can see the category, name and code. Code is important for use with the REST API and WP-CLI.", "sweeppress" ) . '</li>' .
				             '<li>' . __( "Indicator columns show the sweeper modes where the each sweeper can be used. All sweepers work from the main Sweep panel, but some sweepers have various limitations when it comes to availability.", "sweeppress" ) . '</li>' .
				             '</ul>',
			)
		);
	}
}
