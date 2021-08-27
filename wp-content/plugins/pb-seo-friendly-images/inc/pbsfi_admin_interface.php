<?php
/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class pbsfi_admin_interface
{
	/** @var pbSEOFriendlyImages */
	var $pbSEOFriendlyImages;

	/** @var pbSettingsFramework_2 */
	var $settingsFramework;

	public function __construct( pbSEOFriendlyImages &$pb_SEO_friendly_images )
	{
		$this->pbSEOFriendlyImages = $pb_SEO_friendly_images;
	}

	/**
	 * Initialize Backend functions
	 */
	public function initialize()
	{
		add_action( 'admin_enqueue_scripts', [ $this, 'css_js' ] );

		add_action('admin_menu', [ $this, 'options_page_menu' ]);
		add_action('admin_init', [ $this, 'init_settings' ]);

		add_filter('plugin_action_links_'.$this->pbSEOFriendlyImages->plugin['basename'], [ $this, 'settings_link' ]);
	}

	/**
	 * Backend Assets
	 */
	public function css_js()
	{
		wp_register_style(
			'pbsfi-admin-css',
			$this->pbSEOFriendlyImages->plugin['url'].'/assets/css/admin.css',
			false,
			$this->pbSEOFriendlyImages->version
		);

		wp_enqueue_style( 'pbsfi-admin-css' );
	}

	/**
	 * Settings Link for Plugin Overview
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function settings_link( $data )
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

		if( ! $this->pbSEOFriendlyImages->isProVersion() ) {
			$data = array_merge(
				$data,
				array(
					sprintf(
						'<a href="%s" style="color: #e00; font-weight: bold;" target="_blank">%s</a>',
						$this->pbSEOFriendlyImages->proURL,
						__('Get Pro Version', 'pb-seo-friendly-images')
					)
				)
			);
		}

		return $data;
	}

	/**
	 * Settings
	 */
	public function init_settings()
	{
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images',
			'option-group' => 'pb-seo-friendly-images'
		));

		//register_setting('pbseofriendlyimages_settings', 'pbseofriendlyimages_settings');
		$this->settingsFramework->registerSetting( 'pb-seo-friendly-images' );

		$this->settingsFramework->addSettingsSection(
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

				echo '</div>';

				if( ! $this->pbSEOFriendlyImages->isProVersion() ) {
					echo '<div class="pb-custom-message info"><p>';
					echo sprintf(
						__('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use more features and support the development of this plugin.', 'pb-seo-friendly-images'),
						$this->pbSEOFriendlyImages->proURL

					);
					echo '</p><a href="'.$this->pbSEOFriendlyImages->proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
				}
			}
		);

		$this->settingsFramework->addSettingsField(
			'optimize_img',
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

		$this->settingsFramework->addSettingsField(
			'sync_method',
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

		$this->settingsFramework->addSettingsField(
			'override_alt',
			__('override "alt"', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => '',
				'desc' => __('override existing image alt attributes', 'pb-seo-friendly-images')
			)
		);

		$this->settingsFramework->addSettingsField(
			'override_title',
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

		$this->settingsFramework->addSettingsField(
			'alt_scheme',
			__('alt scheme', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '%name - %title',
				'desc' => __('default', 'pb-seo-friendly-images').': <code>%name - %title</code><br />'.$placeholder
			)
		);

		$this->settingsFramework->addSettingsField(
			'title_scheme',
			__('title scheme', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '%title',
				'desc' => __('default', 'pb-seo-friendly-images').': <code>%title</code><br />'.$placeholder
			)
		);

		/**
		 * Section Pro 4
		 */
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-pro5',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
			'pb-seo-friendly-images-pro5',
			'',
			function()
			{
				echo '<h2 class="pro-section"><span>'.__('Pro Features', 'pb-seo-friendly-images').'</span></h2>';

				echo '<h2 class="pb-section-title">'.__('Caching', 'pb-seo-friendly-images').'</h2>';
				echo '<div class="pb-section-wrap no-margin-bottom">';
				echo '<p>'.__('Caching can highly increase the performance of your website with PB SEO Friendly Images. If you already use a caching plugin you do not need to enable this function.', 'pb-seo-friendly-images').'</p>';
				echo '<p>'.sprintf(__('We recommend to use <a href="%1$s" target="_blank">WP Rocket</a> as one of the best Performance and Caching Solutions for WordPress. If you are interested in a professional and individual Performance-Optimization <a href="%2$s" target="_blank">get a free quote here</a>.', 'pb-seo-friendly-images'), 'https://shareasale.com/r.cfm?b=1075949&u=1974809&m=74778&urllink=&afftrack=pb-seo-friendly-images', __('https://www.pascal-bajorat.com/en/lp/wordpress-performance-optimization/', 'pb-seo-friendly-images')).'</p>';
				echo '</div>';

				if( ! $this->pbSEOFriendlyImages->isProVersion() ) {
					echo '<div class="pb-custom-message info"><p>';
					echo sprintf(
						__('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use this feature.', 'pb-seo-friendly-images'),
						$this->pbSEOFriendlyImages->proURL
					);
					echo '</p><a href="'.$this->pbSEOFriendlyImages->proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
				}
			}
		);

		$this->settingsFramework->addSettingsField(
			'enable_caching',
			__('enable content caching', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => true,
				'desc' => __('enable content caching and boost up your site speed with PB SEO Friendly Images', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'caching_ttl',
			__('TTL', 'pb-seo-friendly-images'),
			array(
				'type' => 'number',
				'default' => '86400',
				'desc' => __('TTL in seconds: 86400 = 24h; 3600 = 1h; 0 = never expire;', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		/**
		 * Section Pro
		 */
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-pro',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
			'pb-seo-friendly-images-pro',
			'',
			function()
			{
				echo '<h2 class="pb-section-title">'.__('Lazy Load settings', 'pb-seo-friendly-images').'</h2>';
				echo '<div class="pb-section-wrap no-margin-bottom">';
				echo '<p>'.__('This function is very useful and it boosts performance by delaying loading of images in long web pages, because images outside of viewport (visible part of web page) won\'t be loaded until the user scrolls to them.', 'pb-seo-friendly-images').'</p>';
				echo '<p>'.__('The lazy load is powered by unveil.js, one of the fastest and thinnest lazy loader in the web. The implementation is highly seo compatible with a no js fallback.', 'pb-seo-friendly-images').'</p>';
				echo '<p>'.__('If enabled the lazy load will be added automatically to images in your post or page content and also to post thumbnails.', 'pb-seo-friendly-images').'</p>';
				echo '</div>';

				if( ! $this->pbSEOFriendlyImages->isProVersion() ) {
					echo '<div class="pb-custom-message info"><p>';
					echo sprintf(
						__('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use this feature.', 'pb-seo-friendly-images'),
						$this->pbSEOFriendlyImages->proURL
					);
					echo '</p><a href="'.$this->pbSEOFriendlyImages->proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
				}
			}
		);

		$this->settingsFramework->addSettingsField(
			'enable_lazyload',
			__('enable lazy load', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => true,
				'desc' => __('enable lazy load and boost up your site speed', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'enable_lazyload_acf',
			__('enable lazy load for acf', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => true,
				'desc' => __('enable lazy load for AdvancedCustomFields', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'enable_lazyload_styles',
			__('lazy load default styles', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => false,
				'desc' => __('enable lazy load default styles', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'lazyload_threshold',
			__('threshold', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '0',
				'desc' => __('By default, images are only loaded when the user scrolls to them and they became visible on the screen (default value for this field <code>0</code>). If you want your images to load earlier than that, lets say 200px then you need to type in <code>200</code>.', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		/**
		 * Section Pro 2
		 */
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-pro2',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
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
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-pro3',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
			'pb-seo-friendly-images-pro3',
			'',
			function()
			{
				echo '<h2 class="pb-section-title">'.__('WooCommerce settings', 'pb-seo-friendly-images').'</h2>';
				echo '<div class="pb-section-wrap no-margin-bottom">';
				echo '<p>'.__('This settings are specially for images inside your WooCommerce Shop. In most cases you need to activate the override to use your custom settings.', 'pb-seo-friendly-images').'</p>';
				echo '</div>';

				if( ! $this->pbSEOFriendlyImages->isProVersion() ) {
					echo '<div class="pb-custom-message info"><p>';
					echo sprintf(
						__('Please consider upgrading to <a href="%s" target="_blank">PB SEO Friendly Images Pro</a> if you want to use this feature.', 'pb-seo-friendly-images'),
						$this->pbSEOFriendlyImages->proURL
					);
					echo '</p><a href="'.$this->pbSEOFriendlyImages->proURL2.'" class="pb-btn" target="_blank">'.__('Upgrade now', 'pb-seo-friendly-images').'</a></div>';
				}
			}
		);

		$this->settingsFramework->addSettingsField(
			'wc_title',
			__('WooCommerce', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => false,
				'desc' => __('Use the product name as alt and title for WooCommerce product images', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'wc_sync_method',
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
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'wc_override_alt',
			__('override "alt"', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => '',
				'desc' => __('override existing image alt attributes', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'wc_override_title',
			__('override "title"', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => '',
				'desc' => __('override existing image title attributes', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'wc_alt_scheme',
			__('alt scheme', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '%name - %title',
				'desc' => __('default', 'pb-seo-friendly-images').': <code>%name - %title</code><br />'.$placeholder,
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'wc_title_scheme',
			__('title scheme', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '%title',
				'desc' => __('default', 'pb-seo-friendly-images').': <code>%title</code><br />'.$placeholder,
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		/**
		 * Additional features
		 */
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-pro4',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
			'pb-seo-friendly-images-pro4',
			'',
			function()
			{
				echo '<h2 class="pb-section-title">'.__('Additional features', 'pb-seo-friendly-images').'</h2>';
			}
		);

		$this->settingsFramework->addSettingsField(
			'link_title',
			__('set title for links', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => false,
				'desc' => __('Use the power of PB SEO Friendly Images also for seo friendly links. This will set the title depending on the link text and only if there is no existing title', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		$this->settingsFramework->addSettingsField(
			'disable_srcset',
			__('disable srcset', 'pb-seo-friendly-images'),
			array(
				'type' => 'checkbox',
				'default' => false,
				'desc' => __('disable srcset attribute and responsive images in WordPress if you don\'t need them', 'pb-seo-friendly-images'),
				'disabled' => (($this->pbSEOFriendlyImages->isProVersion())?false:true)
			)
		);

		/**
		 * Section Encoding and Parser
		 */
		$this->settingsFramework = new pbSettingsFramework_2(array(
			'text-domain' => 'pb-seo-friendly-images',
			'page' => 'pb-seo-friendly-images',
			'section' => 'pb-seo-friendly-images-encoding',
			'option-group' => 'pb-seo-friendly-images'
		));

		$this->settingsFramework->addSettingsSection(
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

		$this->settingsFramework->addSettingsField(
			'encoding',
			__('encoding', 'pb-seo-friendly-images'),
			array(
				'type' => 'text',
				'default' => '',
				'desc' => __('leave blank to use WordPress default encoding or type in something like "utf-8"', 'pb-seo-friendly-images')
			)
		);

		$this->settingsFramework->addSettingsField(
			'encoding_mode',
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

	/**
	 * Admin Menu
	 */
	public function options_page_menu()
	{
		add_submenu_page(
			'options-general.php',
			__('PB SEO Friendly Images', 'pb-seo-friendly-images'),
			__('SEO Friendly Images', 'pb-seo-friendly-images'),
			'manage_options',
			'pb-seo-friendly-images',
			[ $this, 'options_page' ]
		);
	}

	/**
	 * Load Options Page
	 */
	public function options_page()
	{
		if ( ! current_user_can('manage_options') ) {
			return;
		}

		// Backend Template
		require_once $this->pbSEOFriendlyImages->plugin['path'] . 'templates/options_page.php';
	}
}