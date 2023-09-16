<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @category   WP-Plugin
 * @package    Jerc
 * @subpackage Jerc/admin
 * @author     James Amner <jdamner@me.com>
 * @license    TBC https://example.com
 * @link       https://amner.me
 * @since      1.0.0
 */


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jerc
 * @subpackage Jerc/admin
 */
class JercAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $name The ID of this plugin.
     */
    private $name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $version The current version of this plugin.
     */
    private $version;

    /**
     * Export Action
     */
    public $action;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * 
     * @param string $name    The name of this plugin.
     * @param string $version The version of this plugin.
     */
    public function __construct($name, $version)
    {
        $this->name = $name;
        $this->version = $version;
        $this->action = $this->name . "_export";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style(
            $this->name,
            plugin_dir_url(__FILE__) . 'css/jerc-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @param string $hook The hook suffix for the current admin page
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function enqueueScripts($hook)
    {
        if ($hook == 'plugins.php') {
            wp_enqueue_script(
                $this->name,
                plugin_dir_url(__FILE__) . 'js/jerc-admin.js',
                array(),
                $this->version,
                false
            );
        }
    }

    /**
     * Adds the admin-page to the admin menu
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function adminMenu()
    {
        $this->slug = add_submenu_page(
            'tools.php',
            'Javascript Errors',
            'Javascript Errors',
            'manage_options',
            $this->name,
            array($this, 'renderAdminPage')
        );
    }

    /**
     * Outputs the admin page
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function renderAdminPage()
    {
        include __DIR__ . '/partials/jerc-admin-display.php';
    }

    /**
     * Returns the query needed for data with relevant filters applied
     * 
     * @since 1.0.0
     * 
     * @global wpdb $wpdb WPDB
     * @return string
     */
    private function getFilteredQuery()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->name . "_data";
        $q = 'SELECT * FROM ' . $table_name;
        $q .= ' WHERE 1=1';
        $filters = $this->getFilters();
        foreach ($filters as $key => $value) {
            
            if ($key !== 'time_from' && $key !== 'time_to') {
                $q .= ' AND ' . esc_sql($key) . ' = \'' . esc_sql($value) . '\'';
            } 
        }

        if (isset($filters['time_from']) && isset($filters['time_to'])) {
            $from = new DateTime($filters['time_from'], wp_timezone());
            $to = new DateTime($filters['time_to'], wp_timezone());
            if ($from > $to) {
                $q .= ' AND timestamp BETWEEN \'' . $to->format('Y-m-d H:i:s') . '\' AND \'' . $from->format('Y-m-d H:i:s') . '\'';
            } else {
                $q .= ' AND timestamp BETWEEN \'' . $from->format('Y-m-d H:i:s') . '\' AND \'' . $to->format('Y-m-d H:i:s') . '\'';
            }
        }
        $q .= ' ORDER BY timestamp DESC';
        return $q;
    }

    /**
     * Returns the data needed for to display
     * 
     * @param bool $paging To enable paging filters on the data
     * 
     * @since 1.0.0
     * 
     * @global wpdb $wpdb WPDB
     * @return array
     */
    private function getData($paging = true)
    {
        
        $q = $this->getFilteredQuery();

        if ($paging) {
            $q .= ' LIMIT ' . esc_sql(intval(isset($_REQUEST['paged']) ? 10 * $_REQUEST['paged'] : 0)) . ', 10';
        }
        global $wpdb;
        return $wpdb->get_results($q);
    }

    /**
     * Gets count of results in the current query
     * 
     * @return int
     */
    private function getCount()
    {
        $q = $this->getFilteredQuery();
        
        $q = str_replace('SELECT * FROM', 'SELECT COUNT(*) FROM', $q);
        global $wpdb;

        return $wpdb->get_var($q);
    }

    /**
     * Gets all the filter keys currently possible
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function getFilterKeys()
    {
        return array(
            'time_from',
            'time_to',
            'message',
            'script',
            'userId',
            'userIp',
            'pageUrl',
            'agent'
        );
    }

    /**
     * Gets a key-value associated array of filters to apply to the data
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function getFilters()
    {
        $filters = array();
        foreach ($this->getFilterKeys() as $key) {
            if (isset($_REQUEST[$key]) && ($_REQUEST[$key] !== '') && is_string($_REQUEST[$key])) {
                $filters[$key] = sanitize_text_field($_REQUEST[$key]);
            }
        }
        return $filters;
    }

    /**
     * Gets the URL to use for filtering data based on the current filters
     * with an additional filter value
     * 
     * @param string $key   The key for the filter
     * @param mixed  $value The value for the filter
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function getFilterUrl($key, $value)
    {
        $filters = $this->getFilters();
        $filters[$key] = $value;
        $filters['page'] = $this->name;
        return '?'. http_build_query($filters);
    }

    /**
     * Gets the URL with a given filter URL removed
     * 
     * @param string $key The filter to remove
     * 
     * @return string
     * 
     * @since 1.0.0
     */
    private function removeFilterUrl($key)
    {
        $filters = $this->getFilters();
        if (isset($filters[$key])) {
            unset($filters[$key]);
        }
        $filters['page'] = $this->name;
        return '?' . http_build_query($filters);
    }


    /**
     * Exports the current data as a CSV
     * 
     * Hooked to admin_post
     *  
     * @return void
     * 
     * @since 1.0.0
     */
    public function exportCSV()
    {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], $this->action)) {
            wp_die("Unable to verify CRSF data", 'Error');
        }
        $data = $this->getData(false);
        if (empty($data)) {
            return;
        }

        $out = fopen('php://output', 'w');

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=export.csv');
        header('Pragma: no-cache');
        $headers = array_keys(get_object_vars(reset($data)));
        fputcsv($out, $headers);
        
        foreach ($data as $row) {
            fputcsv($out, get_object_vars($row));
        }
        fclose($out);
        exit;
    }

    /**
     * Outputs the pagination
     * 
     * Yes, copied from class WP_List_Table
     * 
     * @return void
     */
    private function displayPagination()
    {
        $output = '<span class="displaying-num">' . sprintf(
            /* translators: %s: Number of items. */
            _n('%s item', '%s items', $this->getCount()),
            number_format_i18n($this->getCount())
        ) . '</span>';

        $current = intval(isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1);
        $total_pages = floor($this->getCount() / 10);

        $current_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

        $current_url = remove_query_arg(wp_removable_query_args(), $current_url);

        $page_links = array();

        $total_pages_before = '<span class="paging-input">';
        $total_pages_after  = '</span></span>';

        $disable_first = false;
        $disable_last  = false;
        $disable_prev  = false;
        $disable_next  = false;

        if (1 == $current ) {
            $disable_first = true;
            $disable_prev  = true;
        }
        if (2 == $current ) {
            $disable_first = true;
        }
        if ($total_pages == $current ) {
            $disable_last = true;
            $disable_next = true;
        }
        if ($total_pages - 1 == $current ) {
            $disable_last = true;
        }

        if ($disable_first ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>';
        } else {
            $page_links[] = sprintf(
                "<a class='first-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
                esc_url(remove_query_arg('paged', $current_url)),
                __('First page'),
                '&laquo;'
            );
        }

        if ($disable_prev ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>';
        } else {
            $page_links[] = sprintf(
                "<a class='prev-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
                esc_url(add_query_arg('paged', max(1, $current - 1), $current_url)),
                __('Previous page'),
                '&lsaquo;'
            );
        }

        $total_pages_before = '<span class="screen-reader-text">' . __('Current Page') . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';

        $html_total_pages = sprintf("<span class='total-pages'>%s</span>", number_format_i18n($total_pages));
        $page_links[]     = $total_pages_before . sprintf(
            /* translators: 1: Current page, 2: Total pages. */
            _x('%1$s of %2$s', 'paging'),
            $current,
            $html_total_pages
        ) . $total_pages_after;

        if ($disable_next ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>';
        } else {
            $page_links[] = sprintf(
                "<a class='next-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
                esc_url(add_query_arg('paged', min($total_pages, $current + 1), $current_url)),
                __('Next page'),
                '&rsaquo;'
            );
        }

        if ($disable_last ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span>';
        } else {
            $page_links[] = sprintf(
                "<a class='last-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
                esc_url(add_query_arg('paged', $total_pages, $current_url)),
                __('Last page'),
                '&raquo;'
            );
        }

        $output .= "\n<span class='pagination-links'>" . implode("\n", $page_links) . '</span>';
        if ($total_pages) {
            $page_class = $total_pages < 2 ? ' one-page' : '';
        } else {
            $page_class = ' no-pages';
        }

        echo wp_kses_post("<div class='tablenav-pages{$page_class}'>$output</div>");
    }    
}
