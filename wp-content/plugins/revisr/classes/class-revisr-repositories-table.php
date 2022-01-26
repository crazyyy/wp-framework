<?php
/**
 * class-revisr-repository-table.php
 *
 * Displays the custom WP_List_Table on the Revisr Repositories page.
 *
 * @package 	Revisr
 * @license 	GPLv3
 * @link 		https://revisr.io
 * @copyright 	Expanded Fronts
 */

 // Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Include WP_List_Table if it isn't already loaded.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/class-wp-list-table.php' );
}

class Revisr_Repositories_Table extends WP_List_Table {

	/**
	 * Constructs the class.
	 * @access public
	 */
	public function __construct() {
		// Load the parent class on the appropriate hook.
		add_action( 'load-revisr_page_revisr_repositories', array( $this, 'load' ) );
		add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );
	}

	/**
	 * Construct the parent class.
	 * @access public
	 */
	public function load() {
		global $status, $page;

		parent::__construct( array(
			'singular' 	=> 'repository',
			'plural'	=> 'repositories'
		) );

		add_screen_option(
			'per_page',
			array(
				'default' => 10,
				'label'   => __( 'Repositories per page', 'revisr' ),
				'option'  => 'edit_revisr_repositories_per_page',
			)
		);

		set_screen_options();
	}

	/**
	 * Sets the screen options for the Revisr branches page.
	 * @access public
	 * @param  boolean 	$status This seems to be false
	 * @param  string 	$option The name of the option
	 * @param  int 		$value 	The number of events to display
	 * @return int|boolean
	 */
	public function set_screen_option( $status, $option, $value ) {
		if ( 'edit_revisr_repositories_per_page' === $option ) {
			return $value;
		}
		return $status;
	}

	/**
	 * Returns an array of the column names.
	 * @access public
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'name' 		=> __( 'Name', 'revisr' ),
			'path'		=> __( 'Path', 'revisr' ),
			'actions' 	=> __( 'Actions', 'revisr' ),
		);
		return $columns;
	}

	/**
	 * Returns an array of columns that are sortable.
	 * @access public
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'name'	=> array( 'name', false )
		);
		return $sortable_columns;
	}

	/**
	 * Returns an array containing the branch information.
	 * @access public
	 * @return array
	 */
	public function get_data() {

		if ( file_exists( ABSPATH . 'revisr-config.php' ) ) {
			$repos = require ABSPATH . 'revisr-config.php';
		} else {
			$repos = array();
		}

		$repositories_array = array();

		$c = 0;
		foreach ( $repos as $name => $path ) {
			$repositories_array[$c]['name'] 		= $name;
			$repositories_array[$c]['path'] 		= $path;
			$repositories_array[$c]['actions'] 		= $this->get_actions();
			$c++;
		}

		return $repositories_array;
	}

	/**
	 * Returns possible actions for a given branch.
	 * @access public
	 * @return string
	 */
	public function get_actions() {
		$actions = sprintf( __( '', 'revisr' ) );
		return $actions;
	}

	/**
	 * Renders the default data for a column.
	 * @access 	public
     * @param 	array 	$item 			A singular item (one full row's worth of data)
     * @param 	array 	$column_name 	The name/slug of the column to be processed
     * @return 	string
     */
	public function column_default( $item, $column_name ) {
		return $item[$column_name];
	}

	/**
	 * Called when no branches are found.
	 * @access public
	 */
	public function no_items() {
		_e( 'No repositories found.', 'revisr' );
	}

	/**
	 * Prepares the data for display.
	 * @access public
	 */
	public function prepare_items() {
		global $wpdb;

		// Number of items per page.
		$per_page = $this->get_items_per_page( 'edit_revisr_repositories_per_page', 10 );

		// Set up the custom columns.
        $columns 	= $this->get_columns();
        $hidden 	= array();
        $sortable 	= $this->get_sortable_columns();

        // Builds the list of column headers.
        $this->_column_headers = array( $columns, $hidden, $sortable );

        // Get the data to populate into the table.
        $data = $this->get_data();

        // Handle sorting of the data.
        function usort_reorder($a,$b){
            $orderby 	= ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'name'; //If no sort, default to name.
            $order 		= ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'desc'; //If no order, default to desc
            $result 	= strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ( $order==='asc' ) ? $result : -$result; //Send final sort direction to usort
        }
        usort( $data, 'usort_reorder' );

        // Pagination.
        $current_page 	= $this->get_pagenum();
        $total_items 	= count($data);
       	$data 			= array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;
        $this->set_pagination_args( array(
            'total_items' 	=> $total_items,
            'per_page'    	=> $per_page,
            'total_pages' 	=> ceil($total_items/$per_page),
            'orderby'		=> ! empty( $_REQUEST['orderby'] ) && '' != $_REQUEST['orderby'] ? $_REQUEST['orderby'] : 'time',
            'order'			=> ! empty( $_REQUEST['order'] ) && '' != $_REQUEST['order'] ? $_REQUEST['order'] : 'desc'
        ) );
	}

	/**
	 * Displays the table.
	 * @access public
	 */
	public function display() {
		wp_nonce_field( 'revisr-repositories-nonce', 'revisr_repositories_nonce' );

		echo '<input type="hidden" id="order" name="order" value="' . $this->_pagination_args['order'] . '" />';
		echo '<input type="hidden" id="orderby" name="orderby" value="' . $this->_pagination_args['orderby'] . '" />';

		parent::display();
	}

}
