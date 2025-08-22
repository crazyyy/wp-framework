<?php

if(!class_exists('WP_List_Table')){
   require_once( dirname(__FILE__) . '/class-wp-list-table.php' );
}

class DBLogList extends WP_List_Table {
    public $message;

    function __construct(){
        global $status, $page;

        parent::__construct( array(
            'singular'  => 'db_log',
            'plural'    => 'db_logs',
            'ajax'      => FALSE
        ) );

    }

    function column_default($item, $column_name){
        return $item->$column_name;
    }

    function column_subject($item){
        $page = sanitize_text_field(filter_input(INPUT_GET, 'page'));
        $actions = array(
            'view'      => sprintf('<a href="?page=%s&tab=details&action=%s&logid=%s">' . esc_attr__('View Message', 'wp-reroute-email') . '</a>', esc_attr($page),'view', esc_attr($item->id))
        );

        return sprintf('%1$s %2$s', wp_kses_post($item->subject), $this->row_actions($actions));
    }
    
    function column_sent_on($item){
        return get_date_from_gmt($item->sent_on, 'j F, Y H:i:s');
    }

    function get_columns(){
        $columns = array(
            'id' => 'ID',
            'subject'     => esc_attr__('Subject', 'wp-reroute-email'),
            'recipients_to'    => esc_attr__('Sent To', 'wp-reroute-email'),
            'sent_on'  => esc_attr__('Sent On', 'wp-reroute-email')
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'sent_on'     => array('sent_on',false)
        );

        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete_messages_1'    => esc_attr__('Delete Messages Older Than 1 Day', 'wp-reroute-email'),
            'delete_messages_7'    => esc_attr__('Delete Messages Older Than 7 Days', 'wp-reroute-email'),
            'delete_messages_15'    => esc_attr__('Delete Messages Older Than 15 Days', 'wp-reroute-email'),
            'delete_messages_30'    => esc_attr__('Delete Messages Older Than 30 Days', 'wp-reroute-email'),
            'delete_all_messages'    => esc_attr__('Delete All Messages', 'wp-reroute-email'),
        );

        return $actions;
    }

    function process_bulk_action() {
        global $wpdb;
        if( 'delete_all_messages' === $this->current_action() ) {
            $wpdb->query("DELETE FROM {$wpdb->prefix}wpre_emails");
            $this->message = esc_attr__('Messages have been deleted', 'wp-reroute-email');
        }
        else if(in_array($this->current_action(), ['delete_messages_1', 'delete_messages_7', 'delete_messages_15', 'delete_messages_30'])){
            $days = (int)substr(strrchr($this->current_action(), '_'), 1);

            if($days) {
                $wpdb->query("DELETE FROM {$wpdb->prefix}wpre_emails WHERE  sent_on < NOW() - INTERVAL " . $days . " DAY");
            }
            $this->message = esc_attr__('Messages have been deleted', 'wp-reroute-email');
        }
    }

    function bulk_actions( $which = '' ) {
        if ( is_null( $this->_actions ) ) {
            $this->_actions = $this->get_bulk_actions();
            $this->_actions = apply_filters( "bulk_actions-{$this->screen->id}", $this->_actions );
            $two = '';
        } else {
            $two = '2';
        }

        if ( empty( $this->_actions ) ) {
            return;
        }

        echo '<label for="bulk-action-selector-' . esc_attr( $which ) . '" class="screen-reader-text">' .
            /* translators: Hidden accessibility text. */
            __( 'Select bulk action' ) .
        '</label>';
        echo '<select name="action' . $two . '" id="bulk-action-selector-' . esc_attr( $which ) . "\">\n";
        echo '<option value="-1">' . __( 'Bulk actions' ) . "</option>\n";

        foreach ( $this->_actions as $key => $value ) {
            if ( is_array( $value ) ) {
                echo "\t" . '<optgroup label="' . esc_attr( $key ) . '">' . "\n";

                foreach ( $value as $name => $title ) {
                    $class = ( 'edit' === $name ) ? ' class="hide-if-no-js"' : '';

                    echo "\t\t" . '<option value="' . esc_attr( $name ) . '"' . $class . '>' . $title . "</option>\n";
                }
                echo "\t" . "</optgroup>\n";
            } else {
                $class = ( 'edit' === $key ) ? ' class="hide-if-no-js"' : '';

                echo "\t" . '<option value="' . esc_attr( $key ) . '"' . $class . '>' . $value . "</option>\n";
            }
        }

        echo "</select>\n";

        submit_button( __( 'Apply' ), 'action', 'wpre_bulk_action', false, array( 'id' => "dobulkaction$two" ) );
        echo "\n";
	}

    function prepare_items() {
        global $wpdb;

        $per_page = 25;
        $columns = $this->get_columns();
        $hidden = array('id');
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $query = "SELECT * FROM {$wpdb->prefix}wpre_emails";

        $orderby = sanitize_text_field(filter_input(INPUT_GET, 'orderby'));
        $order = sanitize_text_field(filter_input(INPUT_GET, 'order'));
        $paged = sanitize_text_field(filter_input(INPUT_GET, 'paged', FILTER_VALIDATE_INT));

        $orderby = !empty($orderby) && in_array($orderby, ['sent_on']) ? esc_sql($orderby) : 'sent_on';
        $order = !empty($order) && in_array($order, ['asc', 'desc']) ? esc_sql($order) : 'DESC';

        if(!empty($orderby) & !empty($order)){
            $query.= ' ORDER BY ' . $orderby . ' ' . $order;
        } 

        $total_items = $wpdb->query($query);

        $paged = !empty($paged) && is_numeric($paged) && $paged > 0 ? esc_sql($paged) : 1;
        $total_pages = ceil($total_items/$per_page);

        if(!empty($paged) && !empty($per_page)){
            $offset = ($paged - 1) * $per_page;
            $query.= ' LIMIT '. $offset . ',' . $per_page;
        }

        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'per_page' => $per_page,
        ) );

        $this->items = $wpdb->get_results($query);
    }

    public function get_item($id){
        global $wpdb;
        $id = (int) $id;

        if($id){
            $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wpre_emails WHERE id = '$id'");

            if($result){
                return $result;
            }
        }

        return FALSE;
    }
}