<?php
/* Security-Check */
if ( !class_exists('WP') ) {
    die();
}

if( !class_exists('pbSEOFriendlyImagesSettings') ):

    class pbSEOFriendlyImagesSettings extends pbSEOFriendlyImages
    {
        public static $settings = false;

        public static function addSettings()
        {
            add_action('admin_menu', array(__CLASS__, 'optionsPageMenu'));
            add_action('admin_init', array(__CLASS__, 'initSettings'));

            add_filter('plugin_action_links_'.pbSEOFriendlyImages::$basename, array(__CLASS__, 'settingsLink'));

            $showUpgradeBanner = get_option('pbsfi_upgrade_notice');

            if( $showUpgradeBanner != pbSEOFriendlyImages::$verMajor && pbSEOFriendlyImages::getArrayKey('page', $_GET) != 'pb-seo-friendly-images' ) {
                add_action( 'admin_notices', array(__CLASS__, 'adminUpgradeNotice') );
            }
        }

        public static function adminUpgradeNotice()
        {
            $current_user = wp_get_current_user();

            $username = ((!empty($current_user->user_firstname)) ? $current_user->user_firstname : $current_user->user_login );

            echo '<div class="notice pb-custom-message" style="max-width: 100%;"><p>';
            echo sprintf(
                __('<strong>Hey %s</strong>, we have updated <a href="%s">PB SEO Friendly Images</a>. Visit the <a href="%s">plugin settings page</a> to get deeper insights about the new features. This message will disappear automatically after you\'ve visited the plugin settings.', 'pb-seo-friendly-images'),
                $username,
                admin_url('options-general.php?page=pb-seo-friendly-images'),
                admin_url('options-general.php?page=pb-seo-friendly-images')
            );
            echo '</p><a href="'.admin_url('options-general.php?page=pb-seo-friendly-images').'" class="pb-btn">'.__('Close', 'pb-seo-friendly-images').'</a></div>';
        }

        public static function settingsLink( $data )
        {
            if( ! current_user_can('manage_options') ) {
                return $data;
            }

            $data = array_merge(
                $data,
                array(
                    sprintf(
                        '<a href="%s">%s</a>',
                        add_query_arg(
                            array(),
                            admin_url('options-general.php?page=pb-seo-friendly-images')
                        ),
                        __('Settings', 'pb-seo-friendly-images')
                    )
                )
            );

            if( ! pbSEOFriendlyImages::$proVersion ) {
                $data = array_merge(
                    $data,
                    array(
                        sprintf(
                            '<a href="%s" style="color: #e00; font-weight: bold;" target="_blank">%s</a>',
                            pbSEOFriendlyImages::$proURL,
                            __('Get Pro Version', 'pb-seo-friendly-images')
                        )
                    )
                );
            }

            return $data;
        }

        public static function initSettings()
        {
            pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
                'text-domain' => 'pb-seo-friendly-images',
                'page' => 'pb-seo-friendly-images',
                'section' => 'pb-seo-friendly-images',
                'option-group' => 'pb-seo-friendly-images'
            ));

            // register a new setting for "wporg" page
            register_setting('pb-seo-friendly-images', 'pbsfi_options');

            pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
                'pb-seo-friendly-images',
                __('Image "alt" and "title" Settings', 'pb-seo-friendly-images'),
                function()
                {
                    echo '<div class="pb-section-wrap no-margin-bottom">';
                    echo '<p>'.__('PB SEO Friendly Images automatically adds "alt" and "title" attributes to all images and post thumbnails in your posts. The default options are a good starting point for the optimization and basically fine for most websites.', 'pb-seo-friendly-images').'</p>';
                    echo '<p><strong>'.__('Override feature', 'pb-seo-friendly-images').':</strong> '.__('Enable the override means that a possible sync and also hand picked "alt" / "title" attributes will be overwritten with the selected scheme. If you have good hand picked "alt" or "title" attributes in your images, I can not recommend to use the override. Automatic sync between "alt" and "title" will do it\'s best for you.', 'pb-seo-friendly-images').'</p>';

                    echo '<p>'.sprintf(
                            __('PB SEO Friendly Images Pro is a WordPress Plugin by <a href="%s" target="_blank">Pascal Bajorat</a> and made with %s in Berlin, Germany.', 'pb-seo-friendly-images'),
                            'https://www.pascal-bajorat.com',
                            '<span style="color: #f00;">&#9829;</span>'
                        ).'</p>';

                    echo '<hr />';
                    echo '<p><strong style="text-decoration: underline;">'.__('How it works', 'pb-seo-friendly-images').':</strong> '.__('You only need to configure the plugin with the following settings. The plugin will optimize your HTML code on-the-fly. This means, that you see the "alt" and "title" directly in the HTML code output and not in your media library or editor. This is not a hard rewrite of your media library values. You can change this values without the risk to damage some media library data.', 'pb-seo-friendly-images').'</p>';

                    echo '</div> <!-- .pb-section-wrap -->';

                    if( ! pbSEOFriendlyImages::$proVersion ) {
                        echo '<div class="pb-custom-message info"><p>';
                        echo sprintf(
                            __('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use more features and support the development of this plugin.', 'pb-seo-friendly-images'),
                            pbSEOFriendlyImages::$proURL
                        );
                        echo '</p><a href="'.pbSEOFriendlyImages::$proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
                    }
                }
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_optimize_img',
                __('optimize images', 'pb-seo-friendly-images'),
                array(
                    'type' => 'select',
                    'default' => 'all',
                    'select' => array(
                        'all' => __('post thumbnails and images in post content', 'pb-seo-friendly-images').' ('.__('recommended', 'pb-seo-friendly-images').')',
                        'thumbs' => __('only post thumbnails', 'pb-seo-friendly-images'),
                        'post' => __('only images in post content', 'pb-seo-friendly-images'),
                    ),
                    'desc' => __('which images should be optimized', 'pb-seo-friendly-images'),
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_sync_method',
                __('sync method', 'pb-seo-friendly-images'),
                array(
                    'type' => 'select',
                    'default' => 'both',
                    'select' => array(
                        'both' => __('alt <=> title', 'pb-seo-friendly-images').' ('.__('recommended', 'pb-seo-friendly-images').')',
                        'alt' => __('alt => title', 'pb-seo-friendly-images'),
                        'title' => __('alt <= title', 'pb-seo-friendly-images'),
                    ),
                    'desc' => __('select sync method for "alt" and "title" attribute.', 'pb-seo-friendly-images').'<br />'.
                        __('<code>alt <=> title</code> - if one attribute is set use it also for the other one', 'pb-seo-friendly-images').'<br />'.
                        __('<code>alt => title</code> - if "alt" is set use it for the title attribute', 'pb-seo-friendly-images').'<br />'.
                        __('<code>alt <= title</code> - if "title" is set use it for the alt attribute', 'pb-seo-friendly-images')
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_override_alt',
                __('override "alt"', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => '',
                    'desc' => __('override existing image alt attributes', 'pb-seo-friendly-images')
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_override_title',
                __('override "title"', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => '',
                    'desc' => __('override existing image title attributes', 'pb-seo-friendly-images')
                )
            );

            $placeholder = __('possible variables:', 'pb-seo-friendly-images').'<br />'.
                '<code>%title</code> - '.__('replaces post title', 'pb-seo-friendly-images').'<br />'.
                '<code>%desc</code> - '.__('replaces post excerpt', 'pb-seo-friendly-images').'<br />'.
                '<code>%name</code> - '.__('replaces image filename (without extension)', 'pb-seo-friendly-images').'<br />'.
                '<code>%category</code> - '.__('replaces post category', 'pb-seo-friendly-images').'<br />'.
                '<code>%tags</code> - '.__('replaces post tags', 'pb-seo-friendly-images').'<br />'.
                '<code>%media_title</code> - '.__('replaces attachment title (could be empty if not set)', 'pb-seo-friendly-images').'<br />'.
                '<code>%media_alt</code> - '.__('replaces attachment alt-text (could be empty if not set)', 'pb-seo-friendly-images').'<br />'.
                '<code>%media_caption</code> - '.__('replaces attachment caption (could be empty if not set)', 'pb-seo-friendly-images').'<br />'.
                '<code>%media_description</code> - '.__('replaces attachment description (could be empty if not set)', 'pb-seo-friendly-images');

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_alt_scheme',
                __('alt scheme', 'pb-seo-friendly-images'),
                array(
                    'type' => 'text',
                    'default' => '%name - %title',
                    'desc' => __('default', 'pb-seo-friendly-images').': <code>%name - %title</code><br />'.$placeholder
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_title_scheme',
                __('title scheme', 'pb-seo-friendly-images'),
                array(
                    'type' => 'text',
                    'default' => '%title',
                    'desc' => __('default', 'pb-seo-friendly-images').': <code>%title</code><br />'.$placeholder
                )
            );

            /**
             * Section Pro
             */
            pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
                'text-domain' => 'pb-seo-friendly-images',
                'page' => 'pb-seo-friendly-images',
                'section' => 'pb-seo-friendly-images-pro',
                'option-group' => 'pb-seo-friendly-images'
            ));

            pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
                'pb-seo-friendly-images-pro',
                '',
                function()
                {
                    echo '<h2 class="pro-section"><span>'.__('Pro Features', 'pb-seo-friendly-images').'</span></h2>';

                    echo '<h2 class="pb-section-title">'.__('Lazy Load settings', 'pb-seo-friendly-images').'</h2>';
                    echo '<div class="pb-section-wrap no-margin-bottom">';
                    echo '<p>'.__('This function is very useful and it boosts performance by delaying loading of images in long web pages, because images outside of viewport (visible part of web page) won\'t be loaded until the user scrolls to them.', 'pb-seo-friendly-images').'</p>';
                    echo '<p>'.__('The lazy load is powered by unveil.js, one of the fastest and thinnest lazy loader in the web. The implementation is highly seo compatible with a no js fallback.', 'pb-seo-friendly-images').'</p>';
                    echo '<p>'.__('If enabled the lazy load will be added automatically to images in your post or page content and also to post thumbnails.', 'pb-seo-friendly-images').'</p>';
                    echo '</div>';

                    if( ! pbSEOFriendlyImages::$proVersion ) {
                        echo '<div class="pb-custom-message info"><p>';
                        echo sprintf(
                            __('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use this feature.', 'pb-seo-friendly-images'),
                            pbSEOFriendlyImages::$proURL
                        );
                        echo '</p><a href="'.pbSEOFriendlyImages::$proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
                    }
                }
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_enable_lazyload',
                __('enable lazy load', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => true,
                    'desc' => __('enable lazy load and boost up your site speed', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_enable_lazyload_acf',
                __('enable lazy load for acf', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => true,
                    'desc' => __('enable lazy load for AdvancedCustomFields', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_enable_lazyload_styles',
                __('lazy load default styles', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => false,
                    'desc' => __('enable lazy load default styles', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_lazyload_threshold',
                __('threshold', 'pb-seo-friendly-images'),
                array(
                    'type' => 'text',
                    'default' => '0',
                    'desc' => __('By default, images are only loaded when the user scrolls to them and they became visible on the screen (default value for this field <code>0</code>). If you want your images to load earlier than that, lets say 200px then you need to type in <code>200</code>.', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

            /**
             * Section Pro 2
             */
            pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
                'text-domain' => 'pb-seo-friendly-images',
                'page' => 'pb-seo-friendly-images',
                'section' => 'pb-seo-friendly-images-pro2',
                'option-group' => 'pb-seo-friendly-images'
            ));

            pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
                'pb-seo-friendly-images-pro2',
                '',
                function()
                {
                    echo '<h3 class="pb-section-title">'.__('Theme-Integration (only for developers relevant)', 'pb-seo-friendly-images').'</h3>';
                    echo '<div class="pb-section-wrap" style="margin-bottom: 2px">';
                    echo '<p>'.__('Want to add lazy load to images in your theme? You only need to do some small modifications. Add class "lazy" and modify the "src" like this:', 'pb-seo-friendly-images').'</p>';
                    echo '</div>';

                    echo '<div class="pb-custom-message code">';
                    echo '<p><code>&lt;img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<strong>'.__('REAL SRC HERE', 'pb-seo-friendly-images').'</strong>" class="pb-seo-lazy" /&gt;</code></p>';
                    echo '</div>';
                }
            );

	        /**
	         * Section WooCommerce
	         */
	        pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
		        'text-domain' => 'pb-seo-friendly-images',
		        'page' => 'pb-seo-friendly-images',
		        'section' => 'pb-seo-friendly-images-pro3',
		        'option-group' => 'pb-seo-friendly-images'
	        ));

	        pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
		        'pb-seo-friendly-images-pro3',
		        '',
		        function()
		        {
			        echo '<h2 class="pb-section-title">'.__('WooCommerce settings', 'pb-seo-friendly-images').'</h2>';
			        echo '<div class="pb-section-wrap no-margin-bottom">';
			        echo '<p>'.__('This settings are specially for images inside your WooCommerce Shop. In most cases you need to activate the override to use your custom settings.', 'pb-seo-friendly-images').'</p>';
			        echo '</div>';

			        if( ! pbSEOFriendlyImages::$proVersion ) {
				        echo '<div class="pb-custom-message info"><p>';
				        echo sprintf(
					        __('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use this feature.', 'pb-seo-friendly-images'),
					        pbSEOFriendlyImages::$proURL
				        );
				        echo '</p><a href="'.pbSEOFriendlyImages::$proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
			        }
		        }
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_title',
		        __('WooCommerce', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'checkbox',
			        'default' => false,
			        'desc' => __('Use the product name as alt and title for WooCommerce product images', 'pb-seo-friendly-images'),
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_sync_method',
		        __('sync method', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'select',
			        'default' => 'both',
			        'select' => array(
				        'both' => __('alt <=> title', 'pb-seo-friendly-images').' ('.__('recommended', 'pb-seo-friendly-images').')',
				        'alt' => __('alt => title', 'pb-seo-friendly-images'),
				        'title' => __('alt <= title', 'pb-seo-friendly-images'),
			        ),
			        'desc' => __('select sync method for "alt" and "title" attribute.', 'pb-seo-friendly-images').'<br />'.
			                  __('<code>alt <=> title</code> - if one attribute is set use it also for the other one', 'pb-seo-friendly-images').'<br />'.
			                  __('<code>alt => title</code> - if "alt" is set use it for the title attribute', 'pb-seo-friendly-images').'<br />'.
			                  __('<code>alt <= title</code> - if "title" is set use it for the alt attribute', 'pb-seo-friendly-images'),
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_override_alt',
		        __('override "alt"', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'checkbox',
			        'default' => '',
			        'desc' => __('override existing image alt attributes', 'pb-seo-friendly-images'),
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_override_title',
		        __('override "title"', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'checkbox',
			        'default' => '',
			        'desc' => __('override existing image title attributes', 'pb-seo-friendly-images'),
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_alt_scheme',
		        __('alt scheme', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'text',
			        'default' => '%name - %title',
			        'desc' => __('default', 'pb-seo-friendly-images').': <code>%name - %title</code><br />'.$placeholder,
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_wc_title_scheme',
		        __('title scheme', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'text',
			        'default' => '%title',
			        'desc' => __('default', 'pb-seo-friendly-images').': <code>%title</code><br />'.$placeholder,
			        'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
		        )
	        );

	        /**
	         * Additional features
	         */
	        pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
		        'text-domain' => 'pb-seo-friendly-images',
		        'page' => 'pb-seo-friendly-images',
		        'section' => 'pb-seo-friendly-images-pro4',
		        'option-group' => 'pb-seo-friendly-images'
	        ));

	        pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
		        'pb-seo-friendly-images-pro4',
		        '',
		        function()
		        {
			        echo '<h2 class="pb-section-title">'.__('Additional features', 'pb-seo-friendly-images').'</h2>';
		        }
	        );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_link_title',
                __('set title for links', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => false,
                    'desc' => __('Use the power of PB SEO Friendly Images also for seo friendly links. This will set the title depending on the link text and only if there is no existing title', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

            pbSEOFriendlyImagesSettings::$settings->addSettingsField(
                'pbsfi_disable_srcset',
                __('disable srcset', 'pb-seo-friendly-images'),
                array(
                    'type' => 'checkbox',
                    'default' => false,
                    'desc' => __('disable srcset attribute and responsive images in WordPress if you don\'t need them', 'pb-seo-friendly-images'),
                    'disabled' => ((pbSEOFriendlyImages::$proVersion)?false:true)
                )
            );

	        /**
	         * Section Encoding and Parser
	         */
	        pbSEOFriendlyImagesSettings::$settings = new pbSettingsFramework(array(
		        'text-domain' => 'pb-seo-friendly-images',
		        'page' => 'pb-seo-friendly-images',
		        'section' => 'pb-seo-friendly-images-encoding',
		        'option-group' => 'pb-seo-friendly-images'
	        ));

	        pbSEOFriendlyImagesSettings::$settings->addSettingsSection(
		        'pb-seo-friendly-images-encoding',
		        '',
		        function()
		        {
			        echo '<h2 class="pb-section-title">'.__('Encoding and Parser', 'pb-seo-friendly-images').'</h2>';
			        echo '<div class="pb-section-wrap no-margin-bottom">';
			        echo '<p>'.__('Here you can configure the HTML-Parser of the plugin. You <u>only</u> need to change this settings if you have <u>problems with your encoding</u> after activating the plugin.', 'pb-seo-friendly-images').'</p>';
			        echo '</div>';
		        }
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_encoding',
		        __('encoding', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'text',
			        'default' => '',
			        'desc' => __('leave blank to use WordPress default encoding or type in something like "utf-8"', 'pb-seo-friendly-images')
		        )
	        );

	        pbSEOFriendlyImagesSettings::$settings->addSettingsField(
		        'pbsfi_encoding_mode',
		        __('encoding mode', 'pb-seo-friendly-images'),
		        array(
			        'type' => 'select',
			        'default' => 'entities',
			        'select' => array(
				        'entities' => __('HTML-ENTITIES', 'pb-seo-friendly-images').' ('.__('default', 'pb-seo-friendly-images').')',
				        'off' => __('disable convert encoding', 'pb-seo-friendly-images'),
			        )
		        )
	        );
        }

        public static function optionsPageMenu()
        {
            add_submenu_page(
                'options-general.php',
                __('PB SEO Friendly Images', 'pb-seo-friendly-images'),
                __('SEO Friendly Images', 'pb-seo-friendly-images'),
                'manage_options',
                'pb-seo-friendly-images',
                array(__CLASS__, 'optionsPage')
            );
        }

        public static function optionsPage()
        {
            if (!current_user_can('manage_options')) {
                return;
            }

            update_option( 'pbsfi_upgrade_notice', pbSEOFriendlyImages::$verMajor, false );
            ?>
            <div class="wrap pb-wp-app-wrapper">
                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <div class="pb-wrapper">
                    <div class="pb-main">
                        <form action="<?php echo admin_url('options.php') ?>" method="post" target="_self">
                            <?php
                            settings_fields('pb-seo-friendly-images');
                            pbSettingsFramework::doSettingsSections('pb-seo-friendly-images');
                            submit_button();
                            ?>
                        </form>
                    </div>
                    <div class="pb-sidebar">
                        <h3><?php esc_html_e('Plugins & Support', 'pb-seo-friendly-images') ?></h3>

                        <?php if( strstr(get_locale(), 'de') ): ?>
                            <div class="pb-support-box">
                                <h4><?php _e('WordPress Kurs', 'pb-seo-friendly-images') ?></h4>
                                <p><?php _e('Möchtest du mit WordPress richtig durchstarten? In meinem WordPress Kurs erfährst du spannende Tipps und Tricks zu WordPress und SEO!', 'pb-seo-friendly-images') ?></p>

                                <p>
                                    <a href="https://wordpress-kurs.pascal-bajorat.com/" class="button" target="_blank"><?php _e('Jetzt Kurs ansehen', 'pb-seo-friendly-images') ?></a>
                                </p>
                            </div>
	                    <?php endif; ?>

                        <div class="pb-plugin-box">
                            <h4>
                                <span class="icon">
                                    <img src="<?php echo plugins_url( 'img/primusnote.png', constant('pbsfi_file') ); ?>" alt="<?php _e('PrimusNote', 'pb-seo-friendly-images') ?>" />
                                </span>
                                <span class="text"><?php _e('PrimusNote', 'pb-seo-friendly-images') ?><br /><?php _e('Project Management', 'pb-seo-friendly-images') ?></span>
                            </h4>
                            <div class="desc">
                                <p><?php _e('PrimusNote is a Project Management and Team Collaboration software based on WordPress.', 'pb-seo-friendly-images') ?></p>
                                <p><a href="https://goo.gl/b7SZvA" target="_blank" class="button"><?php _e('Install Plugin', 'pb-seo-friendly-images') ?></a></p>
                            </div>
                        </div>

                        <div class="pb-plugin-box">
                            <h4>
                                <span class="icon">
                                    <img src="<?php echo plugins_url( 'img/mailcrypt.png', constant('pbsfi_file') ); ?>" alt="<?php _e('MailCrypt - AntiSpam Email Encryption', 'pb-seo-friendly-images') ?>" />
                                </span>
                                <span class="text"><?php _e('MailCrypt - AntiSpam Email Encryption', 'pb-seo-friendly-images') ?></span>
                            </h4>
                            <div class="desc">
                                <p><?php _e('This Plugin provides a Shortcode to encrypt email addresses / links and protect them against spam.', 'pb-seo-friendly-images') ?></p>
                                <p><a href="<?php echo admin_url('plugin-install.php?s=PB+MailCrypt+-+AntiSpam+Email+Encryption&tab=search&type=term') ?>" class="button"><?php _e('Install Plugin', 'pb-seo-friendly-images') ?></a></p>
                            </div>
                        </div>

                        <div class="pb-support-box">
                            <h4><?php _e('Support', 'pb-seo-friendly-images') ?></h4>
                            <p><?php _e('Do you need some help with this plugin? I am here to help you. Get in touch:', 'pb-seo-friendly-images') ?></p>

                            <p>
                            <?php if( ! pbSEOFriendlyImages::$proVersion ): ?>
                            <a href="https://wordpress.org/support/plugin/pb-seo-friendly-images" class="button" target="_blank"><?php _e('Support Forum', 'pb-seo-friendly-images') ?></a>
                            <?php else: ?>
                            <a href="https://codecanyon.net/item/seo-friendly-images-pro-for-wordpress/19296704/support?ref=Pascal-Bajorat" class="button" target="_blank"><?php _e('Contact Support', 'pb-seo-friendly-images') ?></a>
                            <?php endif; ?>
                            &nbsp;<a href="https://wordpress.org/plugins/pb-seo-friendly-images/#developers" class="button" target="_blank"><?php _e('Changelog', 'pb-seo-friendly-images') ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){

                    var $wc_setting_elements = jQuery('#pbsfi_wc_sync_method, label[for="pbsfi_wc_sync_method"], #pbsfi_wc_override_alt, label[for="pbsfi_wc_override_alt"], #pbsfi_wc_override_title, label[for="pbsfi_wc_override_title"], #pbsfi_wc_alt_scheme, label[for="pbsfi_wc_alt_scheme"], #pbsfi_wc_title_scheme, label[for="pbsfi_wc_title_scheme"]');

                    if( jQuery('#pbsfi_wc_title').is(':checked') ) {
                        console.log('fade out');
                        $wc_setting_elements.css('opacity', .4);
                    }

                    jQuery('#pbsfi_wc_title').on('change', function(e){
                       if( jQuery(this).is(':checked') ) {
                           $wc_setting_elements.css('opacity', .4);
                       } else {
                           $wc_setting_elements.css('opacity', 1);
                       }
                    });
                });
            </script>
            <?php
        }


    }

endif; // class_exists