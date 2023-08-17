<?php

if(!class_exists('WP_List_Table')){
   require_once( dirname(__FILE__) . '/class-wp-list-table.php' );
}


class DBLogList extends WP_List_Table {
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
            'view'      => sprintf('<a href="?page=%s&tab=details&action=%s&logid=%s">' . esc_attr__('View Message', 'wp_reroute_email') . '</a>', esc_attr($page),'view', esc_attr($item->id))
        );

        return sprintf('%1$s %2$s', wp_kses_post($item->subject), $this->row_actions($actions));
    }
    
    function column_sent_on($item){
        return get_date_from_gmt($item->sent_on, 'j F, Y H:i:s');
    }

    function get_columns(){
        $columns = array(
            'id' => 'ID',
            'subject'     => esc_attr__('Subject', 'wp_reroute_email'),
            'recipients_to'    => esc_attr__('Sent To', 'wp_reroute_email'),
            'sent_on'  => esc_attr__('Sent On', 'wp_reroute_email')
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
            'delete_all_messages'    => esc_attr__('Delete All Messages', 'wp_reroute_email')
        );

        return $actions;
    }

    function process_bulk_action() {
        if( 'delete_all_messages' === $this->current_action() ) {
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->prefix}wpre_emails");
        }
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
        $order = !empty($order) && in_array($order, ['ASC', 'DESC']) ? esc_sql($order) : 'DESC';

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