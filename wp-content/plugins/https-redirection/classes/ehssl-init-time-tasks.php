<?php 

class EHSSL_Init_Time_Tasks {
    
    // Constructor
    public function __construct() {
        // Add the init action hook
        add_action('init', array($this, 'early_priority_init_handler'), 0);// Early priority init.
        add_action('init', array($this, 'run_init_time_tasks'));//Normal priority init.
    }

    // Method to run at 'init' action hook.
    public function run_init_time_tasks() {
		// Register custom post types.
		EHSSL_Custom_Post_Types::get_instance()->register_custom_post_types();
    }

    public function early_priority_init_handler() {
        //This is the early priority init handler (needed for some features of the plugin).
        global $httpsrdrctn_options;
        if (empty($httpsrdrctn_options)) {
            $httpsrdrctn_options = get_option('httpsrdrctn_options');
        }

        //Mixed content fix feature. Do force resource embedded using HTTPS.
        if (isset($httpsrdrctn_options['force_resources']) && $httpsrdrctn_options['force_resources'] == '1') {
            // Handle the appropriate content filters to force the static resources to use HTTPS URL.
            if (is_admin()) {
                add_action("admin_init", array($this, "ehssl_start_buffer"));
            } else {
                add_action("init", array($this, "ehssl_start_buffer"));
            }
            add_action("shutdown", array($this, "ehssl_end_buffer"));
        }

    }

    public function ehssl_start_buffer(){
        ob_start(array($this, "ehssl_the_content"));
    }

    public function ehssl_end_buffer() {
        if (ob_get_length()) {
            ob_end_flush();
        }
    }

    public function ehssl_the_content($content) {
        global $httpsrdrctn_options;
        if (empty($httpsrdrctn_options)) {
            $httpsrdrctn_options = get_option('httpsrdrctn_options');
        }

        $current_page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
        // Get the page slug
        $slug = str_replace(home_url() . '/', '', get_permalink($current_page));
        $slug = rtrim($slug, "/"); //remove trailing slash if it's there

        if ($httpsrdrctn_options['force_resources'] == '1' && $httpsrdrctn_options['https'] == 1) {
            if ($httpsrdrctn_options['https_domain'] == 1) {
                $content = $this->ehssl_filter_content($content);
            } else if (!empty($httpsrdrctn_options['https_pages_array'])) {
                $pages_str = '';
                $on_https_page = false;
                foreach ($httpsrdrctn_options['https_pages_array'] as $https_page) {
                    $pages_str .= preg_quote($https_page, '/') . '[\/|][\'"]|'; //let's add page to the preg expression string in case we'd need it later
                    if ($https_page == $slug) { //if we are on the page that is in the array, let's set the var to true
                        $on_https_page = true;
                    } else { //if not - let's replace all links to that page only to https
                        $http_domain = home_url();
                        $https_domain = str_replace('http://', 'https://', home_url());
                        $content = str_replace($http_domain . '/' . $https_page, $https_domain . '/' . $https_page, $content);
                    }
                }
                if ($on_https_page) { //we are on one of the https pages
                    $pages_str = substr($pages_str, 0, strlen($pages_str) - 1); //remove last '|'
                    $content = $this->ehssl_filter_content($content); //let's change everything to https first
                    $http_domain = str_replace('https://', 'http://', home_url());
                    $https_domain = str_replace('http://', 'https://', home_url());
                    //now let's change all inner links to http, excluding those that user sets to be https in plugin settings
                    $content = preg_replace('/<a .*?href=[\'"]\K' . preg_quote($https_domain, '/') . '\/((?!' . $pages_str . ').)(?=[^\'"]+)/i', $http_domain . '/$1', $content);
                    $content = preg_replace('/' . preg_quote($https_domain, '/') . '([\'"])/i', $http_domain . '$1', $content);
                }
            }
        }
        return $content;
    }

    /**
     * Function that changes "http" embeds to "https"
     */
    public function ehssl_filter_content($content) {
        //filter buffer
        $home_no_www = str_replace("://www.", "://", get_option('home'));
        $home_yes_www = str_replace("://", "://www.", $home_no_www);
        $http_urls = array(
            str_replace("https://", "http://", $home_yes_www),
            str_replace("https://", "http://", $home_no_www),
            "src='http://",
            'src="http://',
        );
        $ssl_array = str_replace("http://", "https://", $http_urls);
        //now replace these links
        $str = str_replace($http_urls, $ssl_array, $content);

        //replace all http links except hyperlinks
        //all tags with src attr are already fixed by str_replace

        $pattern = array(
            '/url\([\'"]?\K(http:\/\/)(?=[^)]+)/i',
            '/<link .*?href=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
            '/<meta property="og:image" .*?content=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
            '/<form [^>]*?action=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
        );
        $str = preg_replace($pattern, 'https://', $str);
        return $str;
    }

}