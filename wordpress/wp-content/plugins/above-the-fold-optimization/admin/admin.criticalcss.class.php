<?php

/**
 * Critical CSS admin controller
 *
 * @since      2.5.4
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_CriticalCSS
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * Options
     */
    public $options;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL =& $CTRL;
        $this->options =& $CTRL->options;

        /**
         * Admin panel specific
         */
        if (is_admin()) {

            // Hook in the admin styles and scripts
            $this->CTRL->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts', 30);

            /**
             * Handle form submissions
             */
            $this->CTRL->loader->add_action('admin_post_abtf_criticalcss_update', $this, 'update_settings');
            $this->CTRL->loader->add_action('admin_post_abtf_add_ccss', $this, 'add_conditional_criticalcss');
            $this->CTRL->loader->add_action('admin_post_abtf_delete_ccss', $this, 'delete_conditional_criticalcss');

            // AJAX page search
            $this->CTRL->loader->add_action('wp_ajax_abtf_condition_search', $this, 'ajax_condition_search');

            // Clear CSS condition cache
            $this->CTRL->loader->add_action('save_post', $this, 'clear_conditioncache');
            $this->CTRL->loader->add_action('edit_category', $this, 'clear_conditioncache');
            $this->CTRL->loader->add_action('delete_category', $this, 'clear_conditioncache');
            $this->CTRL->loader->add_action('add_category', $this, 'clear_conditioncache');
            $this->CTRL->loader->add_action('edited_terms', $this, 'clear_conditioncache');
            $this->CTRL->loader->add_action('delete_term', $this, 'clear_conditioncache');

            // init global.css on theme switch
            $this->CTRL->loader->add_action('after_switch_theme', $this, 'switch_theme');
        }
    }

    /**
     * Clear CSS condition cache
     */
    public function clear_conditioncache()
    {
        delete_option('abtf-conditionoptions');
    }

    /**
     * Switch theme
     */
    public function switch_theme()
    {

        // get theme critical CSS
        $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();

        $cssfile = 'global.css';

        // add empty global.css
        if (!isset($criticalcss_files[$cssfile])) {
            $criticalcss_dir = $this->CTRL->theme_path('critical-css');

            $config = (isset($criticalcss_files[$cssfile]) && is_array($criticalcss_files[$cssfile])) ? $criticalcss_files[$cssfile] : array();

            // name
            if (!isset($config['name'])) {
                $config['name'] = 'Global';
            }

            if (file_exists($criticalcss_dir . $cssfile) && !is_writable($criticalcss_dir . $cssfile)) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
            } else {

                // save file with config header
                $error = $this->CTRL->criticalcss->save_file_contents($cssfile, $config, '/* automatically added on theme switch */');
                if ($error && is_array($error)) {
                    foreach ($error as $err) {
                        $this->CTRL->admin->set_notice('<p style="font-size:18px;">'.$err['message'].'</p>', 'ERROR');
                    }
                }
            }
        }
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook)
    {
        if (!isset($_REQUEST['page']) || ($_GET['page'] !== 'pagespeed-criticalcss' && $_GET['page'] !== 'pagespeed-above-the-fold')) {
            return;
        }

        // get active tab
        $tab = $this->CTRL->admin->active_tab();

        switch ($tab) {
            case "criticalcss":

                $options = get_option('abovethefold');
                if (!isset($options['csseditor']) || intval($options['csseditor']) === 1) {

                    /**
                     * Codemirror CSS highlighting
                     */
                    wp_enqueue_style('abtf_codemirror', plugin_dir_url(__FILE__) . 'css/codemirror.min.css');
                    wp_enqueue_script('abtf_codemirror', plugin_dir_url(__FILE__) . 'js/codemirror.min.js', array( 'jquery','jquery-ui-resizable','abtf_admincp' ));
                }
            break;
        }
    }

    /**
     * Get default conditional options
     */
    public function get_default_conditional_options()
    {
        $conditional_options = array();

        $conditional_options[] = array(
            'value' => 'is_front_page()',
            'title' => 'Front Page',
            'optgroup' => 'pagetype',
            'class' => 'pagetype'
        );
        $conditional_options[] = array(
            'value' => 'is_category()',
            'title' => 'Categories',
            'optgroup' => 'pagetype',
            'class' => 'pagetype'
        );
        $conditional_options[] = array(
            'value' => 'is_tag()',
            'title' => 'Tags',
            'optgroup' => 'pagetype',
            'class' => 'pagetype'
        );

        $post_types = get_post_types();
        foreach ($post_types as $pt) {
            if (in_array($pt, array('revision','nav_menu_item'))) {
                continue 1;
            }
            switch ($pt) {
                case "page":
                case "attachment":
                    $conditional_options[] = array(
                        'value' => 'is_'.$pt.'()',
                        'title' => ''.ucfirst($pt).'s',
                        'optgroup' => 'pagetype',
                        'class' => 'pagetype'
                    );
                break;
                case "post":
                    $conditional_options[] = array(
                        'value' => 'is_single()',
                        'title' => 'Posts',
                        'optgroup' => 'pagetype',
                        'class' => 'pagetype'
                    );
                    $conditional_options[] = array(
                        'value' => 'is_singular():'.$pt,
                        'title' => 'Blog Posts',
                        'optgroup' => 'pagetype',
                        'class' => 'pagetype'
                    );
                break;
                default:
                    $conditional_options[] = array(
                        'value' => 'is_singular():'.$pt,
                        'title' => 'Post Type: '.$pt.'',
                        'optgroup' => 'pagetype',
                        'class' => 'pagetype'
                    );
                break;
            }
        }

        /**
         * Templates
         */
        $templates = get_page_templates();
        foreach ($templates as $tplname => $file) {
            $conditional_options[] = array(
                'value' => 'is_page_template():'.htmlentities($file, ENT_COMPAT, 'utf-8').'',
                'title' => 'Template: '.htmlentities($tplname, ENT_COMPAT, 'utf-8').'',
                'optgroup' => 'pagetype',
                'class' => 'pagetype'
            );
        }

        /**
         * WooCommerce
         *
         * @link https://docs.woocommerce.com/document/conditional-tags/
         */
        if (class_exists('WooCommerce')) {
            $wcopts = array(
                'is_shop()',
                'is_product_category()',
                'is_product_tag()',
                'is_product()',
                'is_cart()',
                'is_checkout()',
                'is_account_page()'
            );
            foreach ($wcopts as $opt) {
                $conditional_options[] = array(
                    'value' => $opt,
                    'title' => 'WC: ' . $opt,
                    'titlelong' => 'WooCommerce: ' . $opt,
                    'optgroup' => 'woocommerce',
                    'class' => 'woocommerce'
                );
            }
        }

        // categories
        $taxonomy = 'category';
        $terms = get_terms($taxonomy);
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $conditional_options[] = array(
                    'value' => 'is_category():' . $term->term_id,
                    'title' => $term->term_id . ': '.$term->slug,
                    'optgroup' => 'category',
                    'class' => 'cat'
                );
            }
        }

        // blog categories
        $taxonomy = 'category';
        $terms = get_terms($taxonomy);
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $conditional_options[] = array(
                    'value' => 'has_category():' . $term->term_id,
                    'title' => 'P/w/c: ' . $term->term_id . ': '.$term->slug,
                    'titlelong' => 'Posts with category: ' . $term->term_id . ': '.$term->slug,
                    'optgroup' => 'post',
                    'class' => 'cat'
                );
            }
        }

        // Taxomies
        $taxs = get_taxonomies();
        if (!empty($taxs)) {
            foreach ($taxs as $tax) {
                switch ($tax) {
                    case "category":
                    case "post_tag":
                        // ignore
                    break;
                    default:
                        $conditional_options[] = array(
                            'value' => 'is_tax():' . $tax,
                            'title' => $tax,
                            'optgroup' => 'taxonomy',
                            'class' => 'post'
                        );
                    break;
                }
            }
        }

        $conditional_groups = array();
        $conditional_groups['pagetype'] = array(
            'title' => __('Page Types', 'abovethefold'),
            'class' => 'optgroup-pagetype'
        );
        $conditional_groups['category'] = array(
            'title' => __('Category', 'abovethefold'),
            'class' => 'optgroup-cat'
        );
        $conditional_groups['taxonomy'] = array(
            'title' => __('Taxonomy', 'abovethefold'),
            'class' => 'optgroup-post'
        );
        $conditional_groups['page'] = array(
            'title' => __('Pages', 'abovethefold'),
            'class' => 'optgroup-page'
        );
        $conditional_groups['post'] = array(
            'title' => __('Posts', 'abovethefold'),
            'class' => 'optgroup-post'
        );
        $conditional_groups['filter'] = array(
            'title' => __('Custom Filters', 'abovethefold'),
            'class' => 'optgroup-filter'
        );
        $conditional_groups['woocommerce'] = array(
            'title' => __('WooCommerce', 'abovethefold'),
            'class' => 'optgroup-woocommerce'
        );

        // apply filters
        $conditional_options = apply_filters('abtf_default_conditional_options', $conditional_options);

        // apply filters
        $conditional_groups = apply_filters('abtf_default_conditional_groups', $conditional_groups);

        return array($conditional_options,$conditional_groups);
    }

    /**
     * Get condition values
     */
    public function get_condition_values($conditionConfig)
    {

        // options to return
        $conditions = array();

        foreach ($conditionConfig as $key => $references) {
            switch ($key) {
                case "filter":
                    if (is_array($references) && !empty($references)) {
                        foreach ($references as $filter_name => $filter_vars) {
                            if (is_array($filter_vars)) {
                                $filter_name .= ':' . trim(json_encode($filter_vars), '[]');
                            }
                            $conditions[] = array(
                                'value' => $key . ':' . $filter_name,
                                'title' => $key . ':' . $filter_name,
                                'optgroup' => 'filter',
                                'class' => 'filter'
                            );
                        }
                    }
                break;
                default:
                    if (is_array($references) && !empty($references)) {
                        foreach ($references as $refid) {
                            if (is_array($refid)) {
                                $refid = trim(json_encode($filter_vars), '[]');
                            }

                            // not found
                            $conditions[] = array(
                                'value' => $key . ':' . $refid,
                                'title' => $key . ':' . $refid
                            );
                        }
                    } else {

                        // not found
                        $conditions[] = array(
                            'value' => $key,
                            'title' => $key
                        );
                    }
                break;
            }
        }

        return $conditions;
    }

    /**
     * Return options for page selection menu
     */
    public function ajax_condition_search()
    {
        global $wpdb; // this is how you get access to the database

        $query = (isset($_POST['query'])) ? trim($_POST['query']) : '';
        $limit = (isset($_POST['maxresults']) && intval($_POST['maxresults']) > 10 && intval($_POST['maxresults']) < 30) ? intval($_POST['maxresults']) : 10;

        $results = array();

        $post_types = get_post_types();
        foreach ($post_types as $pt) {
            if (in_array($pt, array('revision','nav_menu_item'))) {
                continue 1;
            }
            if (count($results) >= $limit) {
                break;
            }
            
            // Get random post
            $args = array( 'post_type' => $pt, 'posts_per_page' => $limit, 's' => $query );
            query_posts($args);
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    switch ($pt) {
                        case "page":
                            $results[] = array(
                                'value' => 'is_'.$pt.'():' . get_the_ID(),
                                'title' => get_the_ID(),
                                'titlelong' => get_the_ID() . '. ' . str_replace(home_url(), '', get_permalink(get_the_ID())) . ' - ' . get_the_title(),
                                'optgroup' => 'page',
                                'class' => 'page'
                            );
                        break;
                        case "attachment":
                            // ignore
                        break;
                        default:
                            $results[] = array(
                                'value' => 'is_single():' . get_the_ID(),
                                'title' => get_the_ID(),
                                'titlelong' => get_the_ID() . '. ' . str_replace(home_url(), '', get_permalink(get_the_ID())) . ' - ' . get_the_title(),
                                'optgroup' => 'post',
                                'class' => 'post'
                            );
                        break;
                    }
                    if (count($results) >= $limit) {
                        break;
                    }
                }
            }
        }

        $taxonomies = get_taxonomies();
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                if (count($results) >= $limit) {
                    break;
                }
                switch ($taxonomy) {
                    case "category":
                        // ignore
                    break;
                    case "post_tag":
                    case "product_cat":
                    case "product_brand":
                        $terms = get_terms($taxonomy, array(
                            'orderby'    => 'title',
                            'order'      => 'ASC',
                            'number'     => $limit,
                            'hide_empty' => false,
                            'name__like' => $query
                        ));
                        if ($terms) {
                            foreach ($terms as $term) {
                                switch ($taxonomy) {
                                    case "product_cat":
                                    case "product_brand":
                                        $results[] = array(
                                            'value' => 'is_tax():' . $taxonomy . ':' . $term->slug,
                                            'title' => 'Term: ' . $taxonomy . '/' . $term->name,
                                            'titlelong' => 'Term: ' . $term->term_id.'. ' . str_replace(home_url(), '', get_category_link($term->term_id)) . ' - ' . $term->name,
                                            'optgroup' => 'category',
                                            'class' => 'cat'
                                        );
                                    break;
                                    case "post_tag":
                                        $results[] = array(
                                            'value' => 'is_tag():' . $term->slug,
                                            'title' => 'Tag: ' . $term->name,
                                            'titlelong' => 'Tag: ' . $term->term_id.'. ' . str_replace(home_url(), '', get_category_link($term->term_id)) . ' - ' . $term->name,
                                            'optgroup' => 'category',
                                            'class' => 'cat'
                                        );
                                    break;
                                    default:
                                        $results[] = array(
                                            'value' => 'is_tax():' . $taxonomy . ':' . $term->slug,
                                            'title' => 'Term: ' . $taxonomy . '/' . $term->name,
                                            'titlelong' => 'Term: ' . $term->term_id.'. ' . str_replace(home_url(), '', get_category_link($term->term_id)) . ' - ' . $term->name,
                                            'optgroup' => 'category',
                                            'class' => 'cat'
                                        );
                                    break;
                                }

                                if (count($results) >= $limit) {
                                    break;
                                }
                            }
                        }
                    break;
                    default:
                        
                    break;
                }
            }
        }

        if ($returnSingle) {
            return (!empty($results)) ? $results[0] : false;
        }

        $json = json_encode($results);

        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($json));
        print $json;

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    /**
     * Update settings
     */
    public function update_settings()
    {
        check_admin_referer('abovethefold');

        // stripslashes should always be called
        // @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
        $_POST = array_map('stripslashes_deep', $_POST);

        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        }

        // input
        $input = (isset($_POST['abovethefold']) && is_array($_POST['abovethefold'])) ? $_POST['abovethefold'] : array();

        /**
         * Critical CSS settings
         */
        $options['csseditor'] = (isset($input['csseditor']) && intval($input['csseditor']) === 1) ? true : false;

        /**
         * HTTP/2 Server Push optimization
         */
        $options['http2_push_criticalcss'] = (isset($input['http2_push_criticalcss']) && intval($input['http2_push_criticalcss']) === 1) ? true : false;

        $criticalcss_dir = $this->CTRL->theme_path('critical-css');

        /**
         * Save Critical CSS
         */
        if (!is_writable($criticalcss_dir)) {
            $this->CTRL->admin->set_notice('<p style="font-size:18px;">Critical CSS storage directory is not writable. Please check the write permissions for the following directory:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir).'</strong></p>', 'ERROR');
        } else {

            // get current critical css config
            $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();

            $cssfile = 'global.css';

            /**
             * Store global critical CSS
             */
            $config = (isset($criticalcss_files[$cssfile]) && is_array($criticalcss_files[$cssfile])) ? $criticalcss_files[$cssfile] : array();

            // name
            if (!isset($config['name'])) {
                $config['name'] = 'Global';
            }

            if (file_exists($criticalcss_dir . $cssfile) && !is_writable($criticalcss_dir . $cssfile)) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
            } else {

                // save file with config header
                $error = $this->CTRL->criticalcss->save_file_contents($cssfile, $config, trim($input['css']));
                if ($error && is_array($error)) {
                    foreach ($error as $err) {
                        $this->CTRL->admin->set_notice('<p style="font-size:18px;">'.$err['message'].'</p>', 'ERROR');
                    }
                }

                // failed to store Critical CSS
                if (!file_exists($criticalcss_dir . $cssfile) || !is_writable($criticalcss_dir . $cssfile)) {
                    $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
                }
            }

            /**
             * Store conditional critical CSS
             */
            if (!empty($input['conditional_css'])) {
                foreach ($input['conditional_css'] as $cssfile => $data) {
                    if (!isset($criticalcss_files[$cssfile])) {
                        $error = true;
                        $this->CTRL->admin->set_notice('Conditional Critical CSS not configured.', 'ERROR');
                    } else {
                        $criticalcss_files[$cssfile]['conditions'] = explode('|==abtf==|', $data['conditions']);
                        $criticalcss_files[$cssfile]['weight'] = (isset($data['weight']) && intval($data['weight']) > 0) ? intval($data['weight']) : 1;

                        if (isset($data['appendToAny']) && intval($data['appendToAny']) === 1) {
                            $criticalcss_files[$cssfile]['appendToAny'] = true;
                        } else {
                            unset($criticalcss_files[$cssfile]['appendToAny']);
                        }
                        if (isset($data['prependToAny']) && intval($data['prependToAny']) === 1) {
                            $criticalcss_files[$cssfile]['prependToAny'] = true;
                        } else {
                            unset($criticalcss_files[$cssfile]['prependToAny']);
                        }

                        if (file_exists($criticalcss_dir . $cssfile) && !is_writable($criticalcss_dir . $cssfile)) {
                            $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Conditional Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
                        } else {

                            // save file with config header
                            $error = $this->CTRL->criticalcss->save_file_contents($cssfile, $criticalcss_files[$cssfile], trim($data['css']));

                            if ($error && is_array($error)) {
                                foreach ($error as $err) {
                                    $this->CTRL->admin->set_notice('<p style="font-size:18px;">'.$err['message'].'</p>', 'ERROR');
                                }
                            }

                            // failed to store Critical CSS
                            if (!file_exists($criticalcss_dir . $cssfile) || !is_writable($criticalcss_dir . $cssfile)) {
                                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Conditional Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
                            }
                        }
                    }
                }
            }
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'Critical CSS saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')));
        exit;
    }


    /**
     * Add conditional critical CSS
     */
    public function add_conditional_criticalcss()
    {
        check_admin_referer('abovethefold');

        // @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
        $_POST = array_map('stripslashes_deep', $_POST);

        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        }

        $criticalcss_dir = $this->CTRL->theme_path('critical-css');

        // get current critical css config
        $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();

        // name (reference)
        $name = (isset($_POST['name'])) ? trim($_POST['name']) : '';
        if ($name === '') {
            $this->CTRL->admin->set_notice('You did not enter a name.', 'ERROR');
            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')));
            exit;
        }

        $cssfile = trim(preg_replace(array('|\s+|is','|[^a-z0-9\-]+|is'), array('-',''), strtolower($name))) . '.css';

        if (isset($criticalcss_files[$cssfile])) {
            $this->CTRL->admin->set_notice('A conditional critical CSS configuration with the filename <strong>'.htmlentities($cssfile, ENT_COMPAT, 'utf-8').'</strong> already exists.', 'ERROR');
            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')));
            exit;
        }

        $config = array(
            'name' => $name,
            'weight' => 1
        );

        $config['conditions'] = explode('|==abtf==|', $_POST['conditions']);

        if (file_exists($criticalcss_dir . $cssfile) && !is_writable($criticalcss_dir . $cssfile)) {
            $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Conditional Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
        } else {

            // save file with config header
            $this->CTRL->criticalcss->save_file_contents($cssfile, $config, ' ');

            // failed to store Critical CSS
            if (!file_exists($criticalcss_dir . $cssfile) || !is_writable($criticalcss_dir . $cssfile)) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Failed to write to Conditional Critical CSS storage file. Please check the write permissions for the following file:</p><p style="font-size:22px;color:red;"><strong>'.str_replace(trailingslashit(ABSPATH), '/', $criticalcss_dir . $cssfile).'</strong></p>', 'ERROR');
            }
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'Conditional Critical CSS created.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php'))  . '#conditional');
        exit;
    }

    /**
     * Delete conditional critical CSS
     */
    public function delete_conditional_criticalcss()
    {
        check_admin_referer('abovethefold');

        // @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
        $_POST = array_map('stripslashes_deep', $_POST);

        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        }


        // conditional css id
        $file = (isset($_POST['file'])) ? trim($_POST['file']) : '';

        $this->CTRL->criticalcss->delete_file($file);

        // update settings
        $this->CTRL->admin->save_settings($options, 'Conditional Critical CSS deleted.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')) . '#conditional');
        exit;
    }
}
