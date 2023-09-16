<?php

namespace PostSnippets;

/**
 * Post Snippets Settings.
 *
 * Class that renders out the HTML for the settings screen and contains helpful
 * methods to simply the maintainance of the admin screen.
 *
 */
class Admin {
    /**
     * Plugin settings.
     *
     * @var array
     */
    protected $settings;

    // const   GROUP_CLASS = 'PostSnippets\Group';

    /**
     * Defines hooks and filters for admin page.
     */
    public function __construct() {
        add_action( 'admin_menu', array( &$this, 'menu' ) );
        add_action( 'admin_init', array( &$this, 'init' ) );
        add_action( 'current_screen', array( &$this, 'addHeaderXss' ) );
        add_filter( 'plugin_action_links_' . plugin_basename(PS_MAIN_FILE_PATH), array(
            $this,
            'actionLinks'
        ) );

        // Newsletter sign-up admin notice
        add_action( 'admin_notices', array( $this, 'admin_notice_newsletter' ) );

        // Get started admin notice
		add_action( 'admin_notices', array( $this, 'admin_notice_get_started' ) );

		// add_action( 'wp_ajax_sync_up', array( $this, 'sync_up' ) );
		// add_action( 'wp_ajax_sync_down', array( $this, 'sync_down' ) );

		add_action('init', array($this, 'load_block') );

        add_filter('set-screen-option', array($this,'all_snippets_set_option' ), 10, 3);

        add_action('wp_footer', array('PostSnippets\PSallSnippets', 'run_frontend_footer_js_css') );

        add_action('wp_head',   array('PostSnippets\PSallSnippets', 'run_frontend_header_js') );
        
        add_action('admin_print_scripts', function(){

            PSallSnippets::run_admin_js_css();

        } );

	}

	public function load_block() {

        wp_register_script(
            'post-snippets-block',
            PS_URL . 'dist/blocks.build.js',
            array('wp-blocks','wp-editor','wp-element')
        );

        register_block_type('greentreelabs/post-snippets-block', array(
            'editor_script'     => 'post-snippets-block',
            // 'render_callback'   => array($this, 'render_block_content'),
            'render_callback'   => function($attributes){
                return PSallSnippets::render_block_content($attributes); 
            },
        ));
          
        wp_localize_script( 'post-snippets-block', 'all_snippets', array(
            
            'all_snippets'  => PSallSnippets::get_all_snippets_gutenberg()

        ) );

	}

    // -------------------------------------------------------------------------
    // Setup
    // -------------------------------------------------------------------------

    /**
     * Register the administration page.
     *
     * @return void
     */
	public function menu() {
		$capability = $this->get_allowed_capability();
        
        if ( $capability == 'edit_posts' ) {
            $allowed = true;
        }

		if ( current_user_can( 'manage_options' ) or isset( $allowed ) ) {

			$optionPage = add_menu_page( __( 'Post Snippets', 'post-snippets'), __( 'Post Snippets', 'post-snippets'),
            $capability, 'post-snippets', array(
				$this,
				'allSnippetsPage',
			), PS_URL . 'assets/icon.svg' );

            add_action( "load-$optionPage", array($this,'add_screen_options' ) );
            
			
            $allSnippets = add_submenu_page( 'post-snippets',
						__( 'All Snippets', 'post-snippets' ),
						__( 'All Snippets', 'post-snippets' ), $capability, 'post-snippets', array(
				$this,
				'allSnippetsPage',
			) );
            
            $editSnippets = add_submenu_page( 'post-snippets',
						__( 'Add Custom Code', 'post-snippets' ),
						__( 'Add Custom Code', 'post-snippets' ), $capability, 'post-snippets-edit', array(
				$this,
				'editPage',
			) );

            add_action('load-'.$editSnippets,  array(\PostSnippets::EDIT_CLASS,'page_actions'),9);    
		    add_action('admin_footer-'.$editSnippets, array(\PostSnippets::EDIT_CLASS,'footer_scripts'));
            add_filter('admin_title', array(\PostSnippets::EDIT_CLASS, 'change_edit_snippet_page_title'), 10, 2 );
            
            /**Add CSS */
            $editCSS = add_submenu_page( 'post-snippets',
						__( 'Add Custom CSS', 'post-snippets' ),
						__( 'Add Custom CSS', 'post-snippets' ), $capability, 'post-snippets-edit-css', array(
				$this,
				'editPage',
			) );

            add_action('load-'.$editCSS,  array(\PostSnippets::EDIT_CLASS,'page_actions'), 9);    
		    add_action('admin_footer-'.$editCSS, array(\PostSnippets::EDIT_CLASS,'footer_scripts'));
            add_filter('admin_title', array(\PostSnippets::EDIT_CLASS, 'change_edit_snippet_page_title'), 10, 2 );
            
            /**Add JS */
            $editJS = add_submenu_page( 'post-snippets',
						__( 'Add Custom JS', 'post-snippets' ),
						__( 'Add Custom JS', 'post-snippets' ), $capability, 'post-snippets-edit-js', array(
				$this,
				'editPage',
			) );

            add_action('load-'.$editJS,  array(\PostSnippets::EDIT_CLASS,'page_actions'),9);    
		    add_action('admin_footer-'.$editJS, array(\PostSnippets::EDIT_CLASS,'footer_scripts'));
            add_filter('admin_title', array(\PostSnippets::EDIT_CLASS, 'change_edit_snippet_page_title'), 10, 2 );

            
            
            $snippetsOptions = add_submenu_page( 'post-snippets',
						__( 'Options', 'post-snippets' ),
						__( 'Options', 'post-snippets' ), $capability, 'post-snippets-options', array(
				$this,
				// 'optionsPage',
                'tabOptions'
			) );
            
  

            $snippetsImpExp = add_submenu_page( 'post-snippets',
						__( 'Import/Export', 'post-snippets' ),
						__( 'Import/Export', 'post-snippets' ), $capability, 'post-snippets-imp-exp', array(
				$this,
				'tabTools',
			) );


			$newsPage = add_submenu_page( 'post-snippets',
						__( 'News', 'post-snippets' ),
						__( 'News', 'post-snippets' ), $capability, 'post-snippets-news', array(
				$this,
				'newsPage',
			) );
			/*$optionPage = add_submenu_page(
				__( 'Post Snippets', 'post-snippets'),
				__( 'Post Snippets', 'post-snippets'),
				$capability,
				'post-snippets',
				array ( &$this, 'optionsPage' )
			);*/
			new Help( $editSnippets );
		} else {
			add_menu_page( __( 'Post Snippets', 'post-snippets'), __( 'Post Snippets', 'post-snippets'),
							'manage_options', 'post-snippets', array(
				$this,
				'overviewPage',
			), PS_URL . 'assets/icon.svg' );
		}
	}

    function add_screen_options() {
        $option = 'per_page';
        $args = array(
               'label' => __( 'Number of items per page', 'post-snippets'),
               'default' => 10,
               'option' => 'psp_snippets_per_page'
               );
        add_screen_option( $option, $args );
    }

    function all_snippets_set_option($status, $option, $value){
        return $value;

    }

    /**
     * Initialize assets for the administration page.
     *
     * @return void
     */
    public function init() {
        wp_register_script( 'post-snippets', plugins_url( '/assets/post-snippets.js', \PostSnippets::FILE ), array( 'jquery', 'wp-i18n' ), PS_VERSION, true );
        if ( postsnippets_fs()->can_use_premium_code__premium_only() ) {
            wp_register_script( 'post-snippets-pro', plugins_url( '/assets-pro/post-snippets-pro.js', \PostSnippets::FILE ), array(
                'jquery',
                'post-snippets'
            ), PS_VERSION, true );
            // wp_register_script( 'quill', plugins_url( '/assets-pro/quill.min.js', \PostSnippets::FILE ), array(
            //     'post-snippets-pro'
            // ), PS_VERSION, true );
		}
        wp_set_script_translations( 'post-snippets', 'post-snippets' ); /**To use wp i18n in JS */
		$this->scripts();
        $this->registerSettings();
    }

    /**
     * Enqueue scripts to be loaded.
     *
     * @return void
     */
    public function scripts() {
        // Localize the strings in the script
        $translation_array = array(
            'invalid_shortcode' => __( 'Invalid shortcode name', 'post-snippets' ),
            'save_title_nonce' => wp_create_nonce('ps-save-title-nonce'),
            'update_snippet_nonce' => wp_create_nonce('ps-update-snippet-nonce'),
        );
        wp_localize_script( 'post-snippets', 'post_snippets', $translation_array );

        // Add CSS for Pro features page
        $features_style_url = plugins_url( '/assets/features.css', \PostSnippets::FILE );
        wp_register_style( 'post-snippets-icons', $features_style_url, array(), PS_VERSION );
		wp_enqueue_style( 'post-snippets-icons' );

		// Add CSS for icons
        $features_style_url = plugins_url( '/assets/icons.css', \PostSnippets::FILE );
        wp_register_style( 'post-snippets-features', $features_style_url, array(), PS_VERSION );
        wp_enqueue_style( 'post-snippets-features' );

        // Add CSS for newsletter opt-in
        $features_style_url = plugins_url( '/assets/newsletter.css', \PostSnippets::FILE );
        wp_register_style( 'post-snippets-newsletter', $features_style_url, array(), PS_VERSION );
		wp_enqueue_style( 'post-snippets-newsletter' );

        // wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'underscore' );


        
        wp_enqueue_script( 'post-snippets' );
	}


    /**
     * Add X-XSS-Protection header.
     *
     * Newer versions of Chrome does not allow form tags to be submitted in the
     * forms. This header disables that functionlity on the Post Snippets admin
     * screen only.
     */
    public function addHeaderXss( $current_screen ) {
        if ( $current_screen->base == 'settings_page_post-snippets/post-snippets' ) {
            header( 'X-XSS-Protection: 0' );
        }
    }

    /**
     * Quick link to the Post Snippets Settings page from the Plugins page.
     *
     * @param array $links Array of all plugin links
     *
     * @return array $links Array with all the plugin's action links
     */
    public function actionLinks( $links ) {

        $links[] = '<a href="' . PS_MAIN_PAGE_URL . '">' . __( 'Settings', 'post-snippets' ) . '</a>';

        return $links;
    }

   
    public static function pspro_object_to_array($obj) {
        //only process if it's an object or array being passed to the function
        if(is_object($obj) || is_array($obj)) {
            $ret = (array) $obj;
            foreach($ret as &$item) {
                //recursively process EACH element regardless of type
                $item = self::pspro_object_to_array($item);
            }
            return $ret;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return $obj;
        }
    }



    /**
     * Update User Option.
     *
     * Sets the per user option for the read-only overview page.
     *
     * @since   Post Snippets 1.9.7
     */
    private function setUserOptions() {
        if ( isset( $_POST['post_snippets_user_nonce'] )
             && wp_verify_nonce( $_POST['post_snippets_user_nonce'], 'post_snippets_user_options' )
        ) {
            $id     = get_current_user_id();
            $render = isset( $_POST['render'] ) ? true : false;
            update_user_meta( $id, \PostSnippets::USER_META_KEY, $render );
        }
    }

    /**
     * Get User Option.
     *
     * Gets the per user option for the read-only overview page.
     *
     * @since   Post Snippets 1.9.7
     * @return  boolean If overview should be rendered on output or not
     */
    private function getUserOptions() {
        $id      = get_current_user_id();
        $options = get_user_meta( $id, \PostSnippets::USER_META_KEY, true );

        return $options;
    }


    // -------------------------------------------------------------------------
    // HTML generation for option pages
    // -------------------------------------------------------------------------

    /**
     * Display Flashing Message.
     *
     * @param   string $message Message to display to the user.
     */
    private function message( $message ) {
        if ( $message ) {
            echo "<div class='updated'><p><strong>{$message}</strong></p></div>";
        }
	}

	public function newsPage() {
		$plugins = array( array(
            "name"        => "myCred",
            "description" => "myCred makes it simple to create a loyalty program or gamify your website so that you can increase the average customer value with less marketing effort.",
            "image"       => "myCred.png",
            "url"         => "https://wordpress.org/plugins/mycred",
        ), array(
            "name"        => "WP Contact Slider",
            "description" => "WP contact slider is simple contact slider to display contactform7, Gravity forms, Wp Forms, Caldera forms, Constant Contact Forms or display random text or HTML.",
            "image"       => "ContactSlider.png",
            "url"         => "https://wordpress.org/plugins/wp-contact-slider/",
        ), array(
            "name"        => "Wholesale For WooCommerce",
            "description" => "Sign up wholesale customers and display wholesale prices based on multiple wholesale user roles on your existing WooCommerce store",
            "image"       => "WholesaleForWoocommerce.png",
            "url"         => "https://woocommerce.com/products/wholesale-for-woocommerce/",
        ), array(
            "name"        => "WooCommerce Product Disclaimer",
            "description" => "Woocommerce extension where you can set some products to accept terms and conditions before adding product to cart.            ",
            "image"       => "ProductDisclaimer.png",
            "url"         => "https://wordpress.org/plugins/woo-product-disclaimer/",
        ) );

		include PS_PATH . "/views/admin_news.php";
	}

    public function restPage(){
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php settings_fields('ps_rest_fields'); ?>
                
                <?php do_settings_sections('ps-rest-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }



    /**
     * Creates the all snippets administration page.
     *
     * For users with manage_options capability (admin, super admin).
     *
     * @since   Post Snippets 3.1.4
    */
    public function allSnippetsPage() {
        
        $allSnippets = new PSallSnippets();
        
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <!-- H4 is used below cause admin notices are appended to first H1 or H2 -->
                <h4 class="wp-heading-inline- all_snippets_heading"><?php esc_html_e( 'All', 'post-snippets' ); ?> Snippets</h4>
                <a href="<?php echo esc_url("?page=post-snippets-edit") ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'post-snippets' ); ?></a>
                <form id="posts-filter" method="get">
                    <input type="hidden" name="page" value="post-snippets">
                    
                <?php
                    wp_nonce_field( 'pspro_all_snippets', 'pspro_all_snippets_nonce', false );
                    // wp_nonce_field('sync_up', 'sync_up');
                    // wp_nonce_field('sync_down', 'sync_down');
                    $allSnippets->prepare_items();
                    $allSnippets->display();
                    
                ?>
                </form>
            </div>

        <?php
        
        
    }

    public function editPage(){

        $snippet = new Edit();

    }





    /**
     * Tab to set options for the plugin.
     *
     * @return void
     */
    public function tabOptions() {
        // echo '<p class="description post-snippets-documentation-note">';
        // _e( 'Click \'Help\' in the top right for the documentation!', 'post-snippets' );
        // echo '</p>';

        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h1 class="wp-heading-inline"><?php esc_html_e( 'Options', 'post-snippets' ); ?></h1>
                <!-- <form id="posts-filter" method="post"> -->
                <?php
                    $data = array();
                    echo View::render( 'admin_options', $data );
                ?>
                <!-- </form> -->
            </div>

        <?php

        
    }

    /**
     * Tab for Import/Export
     *
     * @since   Post Snippets 2.0
     */
    public function tabTools() {
        // echo '<p class="description post-snippets-documentation-note">';
        // _e( 'Click \'Help\' in the top right for the documentation!', 'post-snippets' );
        // echo '</p>';

        $ie = new ImportExport();

        // Create header and export html form
        printf( "<h3>%s</h3>", __( 'Import/Export', 'post-snippets' ) );
        printf( "<h4>%s</h4>", __( 'Export', 'post-snippets' ) );
        echo '<form method="post">';
        echo '<p>';
        _e( 'Export your snippets for backup or to import them on another site.', 'post-snippets' );
        echo '</p>';
        printf( "<input type='submit' class='button' name='postsnippets_export' value='%s' />", __( 'Export Snippets', 'post-snippets' ) );
        echo '</form>';

        // Export logic, and import html form and logic
        $ie->exportAllSnippets();
        echo $ie->importSnippets();
    }

    /**
     * Tab for Pro features
     *
     * @since   Post Snippets 2.5.4
     */
    private function tabFeatures() {
        $features = new Features();

        echo $features->showFeatures();

    }


    /**
     * Creates a read-only overview page.
     *
     * For users with edit_posts capability but without manage_options
     * capability.
     *
     * @since   Post Snippets 1.9.7
     */
    public function overviewPage() {
        // Header
        echo '<div class="wrap">';
        echo '<h2>Post Snippets</h2>';
        echo '<p>';
        _e( 'This is an overview of all snippets defined for this site. These snippets are inserted into posts from the post editor using the Post Snippets button. You can choose to see the snippets here as-is or as they are actually rendered on the website. Enabling rendered snippets for this overview might look strange if the snippet have dependencies on variables, CSS or other parameters only available on the frontend. If that is the case it is recommended to keep this option disabled.', 'post-snippets' );
        echo '</p>';

        // Form
        $this->setUserOptions();
        $render = $this->getUserOptions();

        echo '<form method="post" action="">';
        wp_nonce_field( 'post_snippets_user_options', 'post_snippets_user_nonce' );

        $this->checkbox( __( 'Display rendered snippets', 'post-snippets' ), 'render', $render );
        $this->submit( 'update-post-snippets-user', __( 'Update', 'post-snippets' ) );
        echo '</form>';

        // Snippet List
        $snippets = get_option( \PostSnippets::OPTION_KEY );
        if ( ! empty( $snippets ) ) {
            foreach ( $snippets as $key => $snippet ) {
                echo "<hr style='border: none;border-top:1px dashed #aaa; margin:24px 0;' />";

                echo "<h3>{$snippet['title']}";
                if ( $snippet['description'] ) {
                    echo "<span class='description'> {$snippet['description']}</span>";
                }
                echo "</h3>";

                if ( $snippet['vars'] ) {
                    printf( "<strong>%s:</strong> {$snippet['vars']}<br/>", __( 'Variables', 'post-snippets' ) );
                }

                // echo "<strong>Variables:</strong> {$snippet['vars']}<br/>";

                $options = array();
                if ( $snippet['shortcode'] ) {
                    array_push( $options, 'Shortcode' );
                }
                if ( $snippet['php'] ) {
                    array_push( $options, 'PHP' );
                }
                if ( $snippet['wptexturize'] ) {
                    array_push( $options, 'wptexturize' );
                }
                if ( $options ) {
                    printf( "<strong>%s:</strong> %s<br/>", __( 'Options', 'post-snippets' ), implode( ', ', $options ) );
                }

                printf( "<br/><strong>%s:</strong><br/>", __( 'Snippet', 'post-snippets' ) );
                if ( $render ) {
                    echo do_shortcode( $snippet['snippet'] );
                } else {
                    echo "<code>";
                    echo nl2br( htmlspecialchars( $snippet['snippet'], ENT_NOQUOTES ) );
                    echo "</code>";
                }
            }
        }
        // Close
        echo '</div>';
    }


    // -------------------------------------------------------------------------
    // Register and callbacks for the options tab
    // -------------------------------------------------------------------------

    /**
     * Register settings for the options tab.
     *
     * @return void
     */
    protected function registerSettings() {
        $this->settings = get_option( \PostSnippets::SETTINGS );

        register_setting(
            \PostSnippets::SETTINGS,
            \PostSnippets::SETTINGS
        );

        add_settings_section(
            'general_section',
            __( 'General', 'post-snippets' ),
            null,
            'post-snippets'
        );

        add_settings_field(
            'exclude_from_custom_editors',
            __( 'Exclude from Custom Editors', 'post-snippets' ),
            array( $this, 'cbExcludeFromCustomEditors' ),
            'post-snippets',
            'general_section',
            array(
                'id'          => 'exclude_from_custom_editors',
                'label_for'   => 'exclude_from_custom_editors',
                'description' => __( 'Checking this only includes Post Snippets on standard WordPress post editing screens.', 'post-snippets' )
            )
        );
        
        
        add_settings_field(
            'complete_uninstall',
            __( 'Complete Uninstall', 'post-snippets' ),
            array( $this, 'cbCompleteUninstall' ),
            'post-snippets',
            'general_section',
            array(
                'id'          => 'complete_uninstall',
                'label_for'   => 'complete_uninstall',
                'description' => __( 'When the plugin is deleted, also delete all snippets and plugin settings.', 'post-snippets' )
            )
        );


        add_settings_section(
            'duplicate_section',
            __( 'Duplicate Snippets', 'post-snippets' ),
            null,
            'post-snippets'
        );

        add_settings_field(
            'allow_duplicate',
            __( 'Allow Duplicate', 'post-snippets' ),
            array( $this, 'cbAllowDuplicate' ),
            'post-snippets',
            'duplicate_section',
            array(
                'id'          => 'allow_duplicate',
                'label_for'   => 'allow_duplicate',
                'description' => __( 'Allow duplicate snippets: import all snippets from the file regardless and leave all existing snippets unchanged.', 'post-snippets' )
            )
        );
        
        
        add_settings_field(
            'replace_duplicate',
            __( 'Replace Duplicate', 'post-snippets' ),
            array( $this, 'cbReplaceDuplicate' ),
            'post-snippets',
            'duplicate_section',
            array(
                'id'          => 'replace_duplicate',
                'label_for'   => 'replace_duplicate',
                'description' => __( 'Replace any existing snippets with a newly imported snippet of the same name.', 'post-snippets' )
            )
        );
        
        
        add_settings_field(
            'skip_duplicate',
            __( 'Do not Import Duplicate', 'post-snippets' ),
            array( $this, 'cbSkipDuplicate' ),
            'post-snippets',
            'duplicate_section',
            array(
                'id'          => 'skip_duplicate',
                'label_for'   => 'skip_duplicate',
                'description' => __( 'Do not import any duplicate snippets; leave all existing snippets unchanged.', 'post-snippets' )
            )
        );

    }  

    /**
     * Callback for HTML generator for exlusion of custom editors.
     *
     * @param  array $args
     *
     * @return  void
     */
    public function cbExcludeFromCustomEditors( $args ) {
        $checked = isset( $this->settings[ $args['id'] ] ) ?
            $this->settings[ $args['id'] ] :
            false;

        echo "<input type='checkbox' id='{$args['id']}' ";
        echo "name='" . \PostSnippets::SETTINGS . "[{$args['id']}]' value='1' ";
        if ( $checked ) {
            echo 'checked ';
        }
        echo " />";

        echo "<span class='description'>{$args['description']}</span>";
    }
    
    
    /**
     * Callback for Complete Uninstallation Option.
     *
     * @param  array $args
     *
     * @return  void
     */
    public function cbCompleteUninstall( $args ) {
        $checked = isset( $this->settings[ $args['id'] ] ) ?
            $this->settings[ $args['id'] ] :
            false;

        echo "<input type='checkbox' id='{$args['id']}' ";
        echo "name='" . \PostSnippets::SETTINGS . "[{$args['id']}]' value='1' ";
        if ( $checked ) {
            echo 'checked ';
        }
        echo " />";

        echo "<span class='description'>{$args['description']}</span>";
    }
    
    
    /**
     * Callback for Allow Duplicate selection.
     *
     * @param  array $args
     *
     * @return  void
     */
    public function cbAllowDuplicate( $args ) {
        $checked = $this->pspro_isDuplicateOptionChecked($args['id']);

        echo "<input type='radio' id='{$args['id']}' ";
        echo "name='" . \PostSnippets::SETTINGS . "[".\PostSnippets::DUPLICATE_SETTINGS."]' value='{$args['id']}' ";
        if ( $checked ) {
            echo 'checked ';
        }
        echo " />";

        echo "<span class='description'>{$args['description']}</span>";
    }
    
    
    /**
     * Callback for Complete Uninstallation Option.
     *
     * @param  array $args
     *
     * @return  void
     */
    public function cbReplaceDuplicate( $args ) {
        $checked = $this->pspro_isDuplicateOptionChecked($args['id']);

        echo "<input type='radio' id='{$args['id']}' ";
        echo "name='" . \PostSnippets::SETTINGS . "[".\PostSnippets::DUPLICATE_SETTINGS."]' value='{$args['id']}' ";
        if ( $checked ) {
            echo 'checked ';
        }
        echo " />";

        echo "<span class='description'>{$args['description']}</span>";
    }
    
    
    /**
     * Callback for Complete Uninstallation Option.
     *
     * @param  array $args
     *
     * @return  void
     */
    public function cbSkipDuplicate( $args ) {
        $checked = $this->pspro_isDuplicateOptionChecked($args['id']);

        echo "<input type='radio' id='{$args['id']}' ";
        echo "name='" . \PostSnippets::SETTINGS . "[".\PostSnippets::DUPLICATE_SETTINGS."]' value='{$args['id']}' ";
        if ( $checked ) {
            echo 'checked ';
        }
        echo " />";

        echo "<span class='description'>{$args['description']}</span>";
    }

    public function pspro_isDuplicateOptionChecked( $option = '' ){

        if( empty($option) ){
            return false;
        }

        if( isset( $this->settings['duplicate_option'] ) && $this->settings['duplicate_option'] == $option){
            return true;
        }

        return false;        

    }


    // -------------------------------------------------------------------------
    // HTML and Form element methods for Snippets form
    // -------------------------------------------------------------------------

    /**
     * Checkbox.
     *
     * Renders the HTML for an input checkbox.
     *
     * @param   string  $label The label rendered to screen
     * @param   string  $name The unique name and id to identify the input
     * @param   boolean $checked If the input is checked or not
     *
     * @return  void
     */
    public static function checkbox( $label, $name, $checked ) {
        echo "<label for=\"{$name}\">";
        printf( '<input type="checkbox" name="%1$s" id="%1$s" value="true"', $name );
        if ( $checked ) {
            echo ' checked';
        }
        echo ' />';
        echo " {$label}</label><br/>";
    }

    /**
     * Submit.
     *
     * Renders the HTML for a submit button.
     *
     * @since   Post Snippets 1.9.7
     *
     * @param   string  $name The name that identifies the button on submit
     * @param   string  $label The label rendered on the button
     * @param   string  $class Optional. Button class. Default: button-primary
     * @param   boolean $wrap Optional. Wrap in a submit div. Default: true
     *
     * @return  void
     */
    public static function submit( $name, $label, $class = 'button-primary', $wrap = true ) {
        $btn = sprintf( '<input type="submit" name="%s" value="%s" class="%s" />&nbsp;&nbsp;&nbsp;', $name, $label, $class );

        if ( $wrap ) {
            $btn = "<div class=\"submit\">{$btn}</div>";
        }

        echo $btn;
    }

    /**
     *
     * Show newsletter opt-in, only in Post Snippets.
     * Not on Pro features tab/page.
     * Not when user selected to Hide opt-in.
     *
     * @since   2.5.4
     */
    public function admin_notice_newsletter() {

        // Hide newsletter opt-in if option is true
        if ( get_option( 'ps_hide_admin_notice_newsletter' ) == true ) {
            return;
        }

        // Set option if "hide" button click detected (custom querystring value set to 1).
        if ( ! empty( $_REQUEST['ps-dismiss-newsletter-nag'] ) ) {
            update_option( 'ps_hide_admin_notice_newsletter', true );

            return;
        }

        // Show newsletter notice.
        if ( get_current_screen()->id == 'settings_page_post-snippets/post-snippets' ) {
            $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'snippets';
            if ( $active_tab != 'features' ) {
                include_once( PS_PATH . '/views/admin_notice_newsletter.php' );
            }

        }
    }


    /**
     *
     * Show 'Get started' admin notice', everywhere.
     * Not when user already clicked or dismissed.
     *
     * @since   2.5.4
     */
    public function admin_notice_get_started() {

        // Hide newsletter opt-in if option is true
        if ( get_option( 'ps_hide_admin_notice_get_started' ) == true ) {
            return;
        }

        // Set option if "hide" button click detected (custom query string value set to 1).
        if ( ! empty( $_REQUEST['ps-dismiss-get-started-nag'] ) ) {
            update_option( 'ps_hide_admin_notice_get_started', true );

            return;
        }

        // Show newsletter notice.
        if ( strpos( get_current_screen()->id, '/post-snippets' ) == false ) {
            $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'snippets';
            if ( $active_tab != 'features' ) {
                include_once( PS_PATH . '/views/admin_notice_get_started.php' );
            }

        }
    }

    public function get_allowed_capability(){
        $capability = 'manage_options';
        
        if ( defined( 'POST_SNIPPETS_ALLOW_EDIT_POSTS' ) and current_user_can( 'edit_posts' ) ) {
            $capability = 'edit_posts';
        }

        return $capability;
    }

}
