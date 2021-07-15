<?php
/**
 * CookieSnapshot Table Class
 *
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Load WP_List_Table if not loaded
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class cmplz_CookieStatement_Snapshots_Table extends WP_List_Table {

    /**
     * Number of items per page
     *
     * @var int
     * @since 1.5
     */
    public $per_page = 30;

    /**
     * Number of customers found
     *
     * @var int
     * @since 1.7
     */
    public $count = 0;

    /**
     * Total customers
     *
     * @var int
     * @since 1.95
     */
    public $total = 0;

    /**
     * The arguments for the data set
     *
     * @var array
     * @since  2.6
     */
    public $args = array();

    /**
     * If true, only one banner is shown, without the "default" column
     * @var bool
     */

    private $show_default_only = false;

    /**
     * Get things started
     *
     * @since 1.5
     * @see WP_List_Table::__construct()
     */


    public function __construct() {
        global $status, $page;

        // Set parent defaults
        parent::__construct( array(
            'singular' => __( 'Cookiebanner', 'complianz-gdpr'),
            'plural'   => __( 'Cookiebanners', 'complianz-gdpr'),
            'ajax'     => false,
        ) );

        //if ab testing is not enabled, show only the default.
        $this->show_default_only = apply_filters('cmplz_default_only', true);

    }

    /**
     * Show the search field
     *
     * @since 1.7
     *
     * @param string $text Label for the search box
     * @param string $input_id ID of the search box
     *
     * @return void
     */

    public function search_box( $text, $input_id ) {
        $input_id = $input_id . '-search-input';
        if ( ! empty( $_REQUEST['orderby'] ) )
            echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
        if ( ! empty( $_REQUEST['order'] ) )
            echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
        $search = $this->get_search();
        ?>

            <p class="search-box">
                <label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
                <input type="search" name="s" placeholder="<?php _e("Search","complianz-gdpr")?>" value = "<?php echo $search?>">
                <?php submit_button( $text, 'button', false, false, array('ID' => 'search-submit') ); ?>
            </p>
            <?php

    }

    /**
     * Gets the name of the primary column.
     *
     * @since 2.5
     * @access protected
     *
     * @return string Name of the primary column.
     */
    protected function get_primary_column_name() {
        return __('name','complianz-gdpr');
    }

    /**
     * This function renders most of the columns in the list table.
     *
     * @since 1.5
     *
     * @param array $item Contains all the data of the customers
     * @param string $column_name The name of the column
     *
     * @return string Column Name
     */
    public function column_default( $item, $column_name ) {

        $date = date(get_option('date_format'), $item['time']);
        $date = cmplz_localize_date($date);
        $time = date(get_option('time_format'), $item['time']);
        $value= $date." ".$time;
        return apply_filters( 'cmplz_cookiestatement_snapshots_column_' . $column_name, $value, $item['file'] );
    }

    public function column_name( $item ) {
        $name       = ! empty( $item['file'] ) ? $item['file'] : '<em>' . __( 'File not found','complianz-gdpr') . '</em>';

        $uploads = wp_upload_dir();
        $upload_dir = $uploads['basedir'];
        $upload_url = $uploads['baseurl'];
        $url = str_replace($upload_dir, $upload_url, $item['path']);
        $actions     = array(
            'download' => '<a href="' . $url . '" target="_blank">' . __( 'Download', 'complianz-gdpr') . '</a>',
            'delete' => '<a class="cmplz-delete-snapshot" data-id="'.$item['file'].'" href="#">' . __( 'Delete', 'complianz-gdpr') . '</a>'
        );

        return $name  . $this->row_actions( $actions );
    }


    /**
     * Retrieve the table columns
     *
     * @since 1.5
     * @return array $columns Array of all the list table columns
     */
    public function get_columns() {
        $columns = array(
            'name'          => __( 'File', 'complianz-gdpr'),
            'time'          => __( 'Created', 'complianz-gdpr'),
        );

        return apply_filters( 'cmplz_cookie_snapshots_columns', $columns );

    }

    /**
     * Get the sortable columns
     *
     * @since 2.1
     * @return array Array of all the sortable columns
     */
    public function get_sortable_columns() {
        $columns = array(
            'name'          => array( 'name', true ),
        );

        return $columns;
    }

    /**
     * Outputs the reporting views
     *
     * @since 1.5
     * @return void
     */
    public function bulk_actions( $which = '' ) {
        // These aren't really bulk actions but this outputs the markup in the right place
    }

    /**
     * Retrieve the current page number
     *
     * @since 1.5
     * @return int Current page number
     */
    public function get_paged() {
        return isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
    }




    /**
     * Retrieves the search query string
     *
     * @since 1.7
     * @return mixed string If search is present, false otherwise
     */
    public function get_search() {
        return ! empty( $_GET['s'] ) ? urldecode( trim( $_GET['s'] ) ) : false;
    }

    /**
     * Build all the reports data
     *
     * @since 1.5
     * @global object $wpdb Used to query the database using the WordPress
     *   Database API
     * @return array $reports_data All the data for customer reports
     */
    public function reports_data() {

        if (!cmplz_user_can_manage()) return array();

        $data    = array();
        $paged   = $this->get_paged();
        $offset  = $this->per_page * ( $paged - 1 );
        $search  = $this->get_search();
        $order   = isset( $_GET['order'] )   ? sanitize_text_field( $_GET['order'] )   : 'DESC';
        $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'id';

        $args    = array(
            'number'  => $this->per_page,
            'offset'  => $offset,
            'order'   => $order,
            'orderby' => $orderby,
            'search'  => $search,
        );

        $this->args = $args;
        $files  = $this->get_cookie_snapshot_list( $args );


        return $files;
    }


    public function prepare_items() {

        $columns  = $this->get_columns();
        $hidden   = array(); // No hidden columns
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->items = $this->reports_data();

        $list = $this->get_cookie_snapshot_list();
        $this->total = is_array($list) ? count($list) : 0;

        // Add condition to be sure we don't divide by zero.
        // If $this->per_page is 0, then set total pages to 1.
        $total_pages = $this->per_page ? ceil( (int) $this->total / (int) $this->per_page ) : 1;

        $this->set_pagination_args( array(
            'total_items' => $this->total,
            'per_page'    => $this->per_page,
            'total_pages' => $total_pages,
        ) );
    }

    public function get_cookie_snapshot_list($args=array()){
        $defaults = array(
                'number' =>10,
                'offset' =>0,
                'order' => 'DESC',
        );
        $args = wp_parse_args($args, $defaults);
        $uploads = wp_upload_dir();
        $upload_dir = $uploads['basedir'];
        $path = $upload_dir . '/complianz/snapshots/';
        $filelist = array();
        $extensions = array("pdf");
        if (file_exists($path) && $handle = opendir($path)) {
            while (false !== ($file = readdir($handle)))
            {
                if ($file != "." && $file != "..")
                {
                    $file   = $path.$file;
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    //we also exclude backup files generated by really simple ssl, rsssl-bkp-
                    if(is_file($file) && in_array($ext, $extensions) ){
                        if (empty($args['search']) || strpos($file, $args['search'])!==FALSE) {
                            $filelist[filemtime($file)]["path"] = $file;
                            $filelist[filemtime($file)]["file"] = basename($file);
                            $filelist[filemtime($file)]["time"] = filemtime($file);
                        }
                    }
                }
            }
            closedir($handle);

        }

        if ($args['order']==='DESC'){
            krsort($filelist);
        } else {
            ksort($filelist);
        }

        if (empty($filelist)) return false;

        $page = (int)$args['offset'];
        $total = count($filelist); //total items in array
        $limit = $args['number'];
        $totalPages = ceil($total / $limit); //calculate total pages
        $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
        $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
        $offset = ($page - 1) * $limit;
        if ($offset < 0) $offset = 0;

        $filelist = array_slice($filelist, $offset, $limit);

        if (empty($filelist)) return false;

        return $filelist;

    }


}
