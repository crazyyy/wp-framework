<?php
	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_SeoPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "seo";

		public $page_menu_dashicon = 'dashicons-star-filled';

		public $page_menu_position = 16;
		
		public $available_for_multisite = true;

		/**
		 * @param WCL_Plugin $plugin
		 */
		public function __construct(WCL_Plugin $plugin)
		{
			$this->menu_title = __('SEO', 'clearfy');
			$this->page_menu_short_description = __('Additional small fixes SEO', 'clearfy');

			parent::__construct($plugin);

			$this->plugin = $plugin;
		}

		/**
		 * Conflict notites
		 */
		public function warningNotice()
		{
			$notices = apply_filters('wbcr_clr_seo_page_warnings', array());

			if( !empty($notices) ) {
				foreach($notices as $message) {
					$this->printWarningNotice($message);
				}
			}
		}


		/**
		 * Permalinks options.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getPageOptions()
		{
			$options = array();

			$options[] = array(
				'type' => 'html',
				'html' => '<div class="wbcr-factory-page-group-header">' . __('<strong>Basic SEO optimization settings</strong>.', 'clearfy') . '<p>' . __('Recommended settings that can complement your SEO plugin.', 'clearfy') . '</p></div>'
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'content_image_auto_alt',
				'title' => __('Automatically set the alt attribute', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
				'layout' => array('hint-type' => 'icon'),
				'hint' => __('The alt attribute is mandatory, so most SEO experts say. If you missed or did not fill it at all, it will be automatically assigned and will be equal to the title of the article.', 'clearfy') . '<br><br><b>Clearfy: </b>' . sprintf(__('Replaces the %s, on attribute with an article name %s', 'clearfy'), '<code>img scr="" alt=""</code>', '<code>img scr="" alt="Hello world"</code>'),
				'default' => false
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'right_robots_txt',
				'title' => __('Create right robots.txt', 'clearfy'),
				'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
				'hint' => __('After installation, WP does not contain a robots.txt file and create it manually. We re-read about 30 different articles, instructions from Yandex and Google to create the perfect robots.txt', 'clearfy') . '<br><br><b>Clearfy: </b>' . __('Automatically creates the perfect robots.txt file', 'clearfy'),
				'default' => false,
				'eventsOn' => array(
					'show' => '.factory-control-robots_txt_text'
				),
				'eventsOff' => array(
					'hide' => '.factory-control-robots_txt_text'
				)
			);

			$options[] = array(
				'type' => 'textarea',
				'name' => 'robots_txt_text',
				'title' => __('You can edit the robots.txt file in the box below:', 'clearfy'),
				'default' => WCL_Helper::getRightRobotTxt(),
				'height' => '300'
			);

			$options[] = array(
				'type' => 'html',
				'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __('Server headers and response', 'clearfy') . '</strong>' . '<p>' . __('WordPress does not know how to give the Last Modified header in the server\'s responses. You can do this using the settings below.', 'clearfy') . '</p>' . '</div>'
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'set_last_modified_headers',
				'title' => __('Automatically insert the Last Modified header', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
				'default' => false,
				'eventsOn' => array(
					'show' => '.factory-control-last_modified_exclude, .factory-control-disable_frontpage_last_modified_headers'
				),
				'eventsOff' => array(
					'hide' => '.factory-control-last_modified_exclude, .factory-control-disable_frontpage_last_modified_headers'
				)
			);
			
			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'disable_frontpage_last_modified_headers',
				'title' => __('Disable Last Modified header on front page', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
				'default' => true,
			);

			$options[] = array(
				'type' => 'textarea',
				'name' => 'last_modified_exclude',
				'height' => '120',
				'title' => __('Exclude pages:', 'clearfy'),
				'layout' => array('hint-type' => 'icon'),
				'hint' => sprintf(__('You can specify a page mask, for example: %s or %s. All pages that contain the string will be excluded. Each exclude must begin with a new line.', 'clearfy'), '/s=', '/manager/'),
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'if_modified_since_headers',
				'title' => __('Return an If-Modified-Since responce', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
				'default' => false
			);

			if( $this->plugin->isActivateComponent('yoast_seo') ) {
				$options[] = array(
					'type' => 'html',
					'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __('For the Yoast SEO plugin', 'clearfy') . '</strong>' . '<p>' . __('These settings will help you eliminate some problems associated with the popular Yoast SEO plugin', 'clearfy') . '</p>' . '</div>'
				);

				$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'remove_last_item_breadcrumb_yoast',
					'title' => __('Remove duplicate names in breadcrumbs WP SEO by Yoast', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
					'layout' => array('hint-type' => 'icon'),
					'hint' => __('The last element in the breadcrumbs in the Yoast SEO plugin duplicates the title of the article. Some SEO-specialists consider this duplication to be superfluous.', 'clearfy') . '<br><br><b>Clearfy: </b>' . __('Removes duplication of the name in the breadcrumbs of the WP SEO plugin from Yoast.', 'clearfy'),
					'default' => false
				);

				$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'yoast_remove_image_from_xml_sitemap',
					'title' => sprintf(__('Remove the tag %s from XML site map', 'clearfy'), 'image:image') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
					'hint' => __('Yandex.Webmaster swears on a standard XML card from the plugin Yoast, tk. it has a specific tag', 'clearfy') . 'image:image<br><br><b>Clearfy: </b>' . sprintf(__('Remove the tag %s from XML site map of the plugin Yoast SEO.', 'clearfy'), 'image:image') . '<br>--<br><span class="wbcr-factory-light-orange-color">' . __('Attention! After activation, turn off the site map and enable it back to regenerate it.', 'clearfy') . '</span>' . '<br><span class="wbcr-factory-light-orange-color">' . __('In older versions of Yoast SEO may not work - update the plugin Yoast', 'clearfy') . '</span>',
					'default' => false,
					'eventsOn' => array()
				);

				/*$options[] = array(
					'type' => 'html',
					'id' => 'wbcr-clearfy-image-xml-sitemap-warning',
					'cssClass' => 'factory-hints',
					'html' => array($this, 'sfsdfsdf')
				);*/

				$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'yoast_remove_json_ld_search',
					'title' => __('Disable JSON-LD sitelinks searchbox', 'clearfy') . '</span>',
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('If you’re not familiar with Search Action it’s the mark-up that helps search engines add a shiny Sitelinks Search Box below your search engine results. For the majority of webmasters the extra search box is an absolutely fantastic feature but for many it’s not required or wanted, especially if a site only has a few pages or if the site uses a customised search platform that only searches blog posts and not pages.', 'clearfy') . ' <br><b>Clearfy: </b>' . __('Disable JSON-LD sitelinks searchbox using WordPress in plugin Yoast SEO.', 'clearfy'),
					'default' => false
				);

				$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'yoast_remove_json_ld_output',
					'title' => __('Disable Yoast Structured Data', 'clearfy') . ' <span class="wbcr-clearfy-recomended-text"></span>',
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('Prevents output of the script tag of type application/ld+json containing
schema.org data from the popular Yoast SEO and Yoast SEO Premium plugins.
There is currently no UI to do so.', 'clearfy') . ' <br><b>Clearfy: </b>' . __('Disable Structured Data in plugin Yoast SEO.', 'clearfy'),
					'default' => false
				);

				/*$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'yoast_canonical_pagination',
					'title' => sprintf(__('Canonical on pagination pages', 'clearfy'), 'head'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('It’s a well-known fact, that the Yoast SEO plugin outputs canonical links on pagination pages, such as /page/2/, /page/3/ and so on. While various search engines treat canonical links differently, it is always better to replace them with the link leading to the main pagination page.
If enabled, this feature changes the canonical link to the main page or category link.
When you deactivate some components, permanent links may work incorrectly. If this happens, please, update the structure of the permanent links, so you could complete the deactivation.
', 'clearfy'),
					'default' => false
				);*/

				$options[] = array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'yoast_remove_head_comment',
					'title' => sprintf(__('Remove comment from %s section', 'clearfy'), 'head') . ' <span class="wbcr-clearfy-recomended-text">(' . __('Recommended', 'clearfy') . ')</span>',
					'layout' => array('hint-type' => 'icon'),
					'hint' => sprintf(__('The Yoast SEO plugin displays a comment of the form %s in %s section', 'clearfy'), '!-- This site is optimized with the Yoast SEO plugin v3.1.1 - https://yoast.com/wordpress/plugins/seo/ --', 'head') . '<br><br><b>Clearfy: </b>' . sprintf(__('Removes the Yoast SEO plugin comment of their section %s', 'clearfy'), 'head'),
					'default' => false
				);
			}

			$form_options = array();

			$form_options[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_clr_seo_form_options', $form_options, $this);
		}
	}


