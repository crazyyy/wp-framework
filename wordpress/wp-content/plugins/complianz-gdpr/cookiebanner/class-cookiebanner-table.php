<?php
/**
 * CookieBanner Reports Table Class
 *
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Load WP_List_Table if not loaded
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class cmplz_CookieBanner_Table extends WP_List_Table {

    /**
     * Number of items per page
     *
     * @var int
     * @since 1.5
     */
    public $per_page = 50;

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
        $status = $this->get_status();
        if ( ! empty( $_REQUEST['orderby'] ) )
            echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
        if ( ! empty( $_REQUEST['order'] ) )
            echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';


        if (!$this->show_default_only) { ?>

        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
           <select name="status">
               <option value="active" <?php if ($status==='active') echo "selected"?>><?php _e('Active cookiebanners','complianz-gdpr')?></option>
               <option value="archived" <?php if ($status==='archived') echo "selected"?>><?php _e('Archived cookiebanners','complianz-gdpr')?></option>
           </select>
            <?php submit_button( $text, 'button', false, false, array('ID' => 'search-submit') ); ?>
        </p>
        <?php
        }
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
        $value='';
        $banner = new CMPLZ_COOKIEBANNER($item['ID']);
        $banner_count = count(cmplz_get_cookiebanners());
        if ($column_name === 'request_date') {
            $value = date_i18n(get_option('date_format'), strtotime($item['request_date']));
        } elseif($column_name === 'best_performer') {
            /**
             * After the best performer is enabled, we should not check the best performing variation anymore: these data will not be valid, as settings will be cleared.
             *
             * */
            if ((COMPLIANZ()->statistics->best_performer_enabled() || (COMPLIANZ()->cookie_admin->ab_testing_enabled()) && COMPLIANZ()->statistics->best_performing_cookiebanner() === $item['ID'])) {
                $value = '<img class="cmplz-bestperformericon" src="'.cmplz_url.'core/assets/fontawesome/check.svg'.'">';
            }
        } elseif($column_name==='default-banner'){
            if ($banner->default) {
                $value = '<img class="cmplz-bestperformericon" src="' . cmplz_url . 'core/assets/fontawesome/check.svg' . '">';
            }
        }elseif($column_name==='archive'){
            if ($banner->archived) {
                $value = '<button type="button" class="button cmplz-restore-cookiebanner" data-banner_id="' . $item['ID'] . '">' . __('Restore', 'complianz-gdpr') . '</button>';
            } elseif($banner_count>1) {
                $value = '<button type="button" class="button cmplz-archive-cookiebanner" data-banner_id="' . $item['ID'] . '">' . __('Archive', 'complianz-gdpr') . '</button>';
            }
        }else{
            $value = $banner->conversion_percentage($column_name) . '%';
        }

        return apply_filters( 'cmplz_cookiebanner_column_' . $column_name, $value, $item['ID'] );
    }

    public function column_name( $item ) {
        $name       = ! empty( $item['name'] ) ? $item['name'] : '<em>' . __( 'Unnamed cookie banner','complianz-gdpr') . '</em>';
        $name = apply_filters('cmplz_cookiebanner_name', $name);

        $actions     = array(
            'edit' => '<a href="' . admin_url( 'admin.php?page=cmplz-cookiebanner&id=' . $item['ID'] ) . '">' . __( 'Edit', 'complianz-gdpr') . '</a>',
            'delete' => '<a class="cmplz-delete-banner" data-id="'.$item['ID'].'" href="#">' . __( 'Delete', 'complianz-gdpr') . '</a>'
        );

        $banner_count = count(cmplz_get_cookiebanners());
        if ($this->show_default_only || $banner_count==1) unset($actions['delete']);
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
            'name'          => __( 'Name', 'complianz-gdpr'),
        );

        if (!$this->show_default_only){
            $columns['best_performer'] = __('Best performer', 'complianz-gdpr');
            $columns['default-banner'] = __('Default', 'complianz-gdpr');
        }

        if (class_exists('cmplz_statistics')) {
            $consenttypes = cmplz_get_used_consenttypes();
            foreach ($consenttypes as $consenttype) {
                $columns[$consenttype] = cmplz_consenttype_nicename($consenttype) . ' ' . __('conversion', 'complianz-gdpr');
            }
        }

        if (!$this->show_default_only) {
            $columns['archive'] = __('Archive', 'complianz-gdpr');
        }
        return apply_filters( 'cmplz_report_customer_columns', $columns );

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
     * Retrieve the current status
     *
     * @since 2.1.7
     * @return int Current status
     */
    public function get_status() {
        return isset( $_GET['status'] ) ? sanitize_title($_GET['status'] ) : 'active';
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
        $status  = $this->get_status();
        $order   = isset( $_GET['order'] )   ? sanitize_text_field( $_GET['order'] )   : 'DESC';
        $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'id';

        $args    = array(
            'number'  => $this->per_page,
            'offset'  => $offset,
            'order'   => $order,
            'orderby' => $orderby,
            'status'  => $status,
        );

        $args['name']  = $search;

        if ($this->show_default_only){
            $args['default'] = true;
        }

        $this->args = $args;
        $banners  = cmplz_get_cookiebanners( $args );
        if ( $banners ) {

            foreach ( $banners as $banner ) {
                $data[] = array(
                    'ID'            => $banner->ID,
                    'name'          => $banner->title,
                    'EU'            => '',
                );
            }
        }

        return $data;
    }


    public function prepare_items() {

        $columns  = $this->get_columns();
        $hidden   = array(); // No hidden columns
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->items = $this->reports_data();

        $this->total = $this->show_default_only ? 1 : count(cmplz_get_cookiebanners());

        // Add condition to be sure we don't divide by zero.
        // If $this->per_page is 0, then set total pages to 1.
        $total_pages = $this->per_page ? ceil( (int) $this->total / (int) $this->per_page ) : 1;

        $this->set_pagination_args( array(
            'total_items' => $this->total,
            'per_page'    => $this->per_page,
            'total_pages' => $total_pages,
        ) );
    }
}
