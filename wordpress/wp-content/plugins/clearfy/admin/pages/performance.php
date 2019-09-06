<?php
/**
 * The page Settings.
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_PerformancePage extends Wbcr_FactoryClearfy206_PageBase {

	/**
	 * The id of the page in the admin menu.
	 *
	 * Mainly used to navigate between pages.
	 *
	 * @since 1.0.0
	 * @see   FactoryPages410_AdminPage
	 *
	 * @var string
	 */
	public $id = "performance";

	/**
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-performance';

	/**
	 * @var int
	 */
	public $page_menu_position = 20;

	public $available_for_multisite = true;

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		$this->menu_title                  = __( 'Performance', 'clearfy' );
		$this->page_menu_short_description = __( 'Optimization js, css, fonts', 'clearfy' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

	public function afterFormSave() {
		if ( $this->getPopulateOption( 'disable_gravatars' ) ) {
			update_option( 'show_avatars', false );
		} else {
			update_option( 'show_avatars', true );
		}
	}

	public function warningNotice() {
		parent::warningNotice();

		if ( ! $this->plugin->getPopulateOption( 'revisions_disable' ) && $this->is_post_revision_constant() ) {
			$this->printWarningNotice( __( 'Warning! In the wp-config.php file, a constant WP_POST_REVISIONS is found, it determines the number of revisions. Delete it so you can change this value through the admin panel.', 'clearfy' ) );
		}
	}

	/**
	 * Permalinks options.
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {
		$options = [];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __( '<strong>Clear the unnecessary scripts</strong>', 'clearfy' ) . '<p>' . __( 'This set of settings will help you remove unnecessary links and code from the head section, as well as reduce your website\'s pages weight.', 'clearfy' ) . '</p></div>'
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'disable_feed',
			'title'     => __( 'Disable RSS feeds', 'clearfy' ),
			'layout'    => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'      => __( 'By default, WordPress generates all types of different RSS feeds for your site. While RSS feeds can be useful if you are running a blog, businesses might not always utilize these. Not every site out there has a blog.', 'clearfy' ) . '<br><b>Clearfy: </b>' . sprintf( __( 'Removes a link to the RSS-feed from the %s section, closes and puts the redirect from all RSS-feeds.', 'clearfy' ), '&lt;head&gt;' ),
			'default'   => false,
			'eventsOn'  => [
				'show' => '.factory-control-disabled_feed_behaviour'
			],
			'eventsOff' => [
				'hide' => '.factory-control-disabled_feed_behaviour'
			]
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'disabled_feed_behaviour',
			'data'    => [
				[ 'redirect_301', __( 'Redirect 301', 'clearfy' ) ],
				[ 'redirect_404', __( 'Page 404', 'clearfy' ) ],
			],
			'title'   => __( 'Redirect feed requests', 'clearfy' ),
			'hint'    => __( 'Forward all requests to page 404 or to the main page through 301 redirects.', 'clearfy' ),
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'default' => 'redirect_301'
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'disable_json_rest_api',
			'title'     => __( 'Remove REST API Links', 'clearfy' ),
			'layout'    => [ 'hint-type' => 'icon', 'hint-icon-color' => 'red' ],
			'hint'      => __( 'The WordPress REST API provides API endpoints for WordPress data types that allow developers to interact with sites remotely by sending and receiving JSON (JavaScript Object Notation) objects. However, a lot of sites don’t use this, and therefore in most cases, it is just unnecessary code.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes REST API link tag from the front end and the REST API header link from page requests.', 'clearfy' ),
			'default'   => false,
			'eventsOn'  => [
				'show' => '#wbcr-clearfy-rest-api-danger-message'
			],
			'eventsOff' => [
				'hide' => '#wbcr-clearfy-rest-api-danger-message'
			]
		];

		$options[] = [
			'type' => 'html',
			'html' => [ $this, 'restApiDangerMessage' ]
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_emoji',
			'title'   => __( 'Disable Emojis', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'Emojis are fun and all, but if you are aren’t using them they actually load a JavaScript file (wp-emoji-release.min.js) on every page of your website. For a lot of businesses, this is not needed and simply adds load time to your site. So we recommend disabling this.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes WordPress Emojis JavaScript file (wp-emoji-release.min.js).', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_jquery_migrate',
			'title'   => __( 'Remove jQuery Migrate', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'red' ],
			'hint'    => __( 'They started adding jQuery migrate in WordPress 3.6. Most up-to-date frontend code and plugins don’t require jquery-migrate.min.js. In most cases, this simply adds unnecessary load to your site. You can see this running if you launch Chrome Devtools console.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes jQuery Migrate JavaScript file (jquery-migrate.min.js).', 'clearfy' ) . '<br>--<br><span class="wbcr-factory-light-orange-color">' . __( 'Warning! If there is a broke on your site, disable this option!', 'clearfy' ) . '</span>',
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_embeds',
			'title'   => __( 'Disable Embeds', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Embeds were released with WordPress 4.4. This is basically the magic that auto converts your YouTube videos, Tweets, and URLs into pretty previews while you are editing. However, this actually loads a JavaScript file (wp-embed.min.js) on every page of your website. If you don’t care about the auto converting preview (which we don’t), you can disable this across your site.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes WordPress Embed JavaScript file (wp-embed.min.js)', 'clearfy' ),
			'default' => false
		];

		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_dns_prefetch',
			'title' => __('Remove dns-prefetch', 'clearfy'),
			'layout' => array('hint-type' => 'icon'),
			'hint' => sprintf(__('Since version 4.6.1 in WordPress there are new links in the section %s this type of: ', 'clearfy'), 'head') . ' <code>link rel="dns-prefetch" href="//s.w.org"</code><br><br><b>Clearfy: </b>' . sprintf(__('Removes dns-prefetch links from the %s section', 'clearfy'), 'head'),
			'default' => false
		);*/
		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_rsd_link',
			'title'   => __( 'Remove RSD Link', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'The above link is used by blog clients. If you edit your site from your browser then you don’t need this. It is also used by some 3rd party applications that utilize XML-RPC requests. In most cases, this is just unnecessary code.', 'clearfy' ) . '<br><code>link rel="EditURI" type="application/rsd+xml" title="RSD"</code><br><br><b>Clearfy: </b>' . __( 'Remove RSD (Real Simple Discovery) link tag.', 'clearfy' ),
			'default' => false
		];
		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_xfn_link',
			'title'   => __( 'Removing XFN (XHTML Friends Network) Profile Link', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'The profile attribute specifies the metadata profile address. Usually, the browser recognizes the value of this attribute and executes some conventions related to the specified profile. Loading the document itself at the specified address does not really happen, moreover, it may not exist at all.
In particular, the profile is used for the XFN microformat (XHTML Friends Network) - a way of representing relationships between people using links and rel attributes with different values. WordPress also actively uses profile in its templates.
', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Remove link tag', 'clearfy' ) . '<br><code>link rel="profile" href="http://gmpg.org/xfn/11"</code>',
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_wlw_link',
			'title'   => __( 'Remove wlwmanifest Link', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => '<code>link rel="wlwmanifest" type="application/wlwmanifest+xml"</code><br>' . __( 'This link is actually used by Windows Live Writer. If you don’t know use Windows Live Writer, which we are guessing you don’t, this is just unnecessary code.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Remove wlwmanifest (Windows Live Writer) link tag.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_shortlink_link',
			'title'   => __( 'Remove Shortlink', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => sprintf( __( 'By default, the following tag shows up in every WordPress install. %s This is used for a shortlink to your pages and posts. However, if you are already using pretty permalinks, such as domain.com/post, then there is no reason to keep this, it is just unnecessary code.', 'clearfy' ), '<br><code>link rel="shortlink" href="https://domain.com?p=712"</code><br>' ) . '<br><br><b>Clearfy: </b>' . __( 'Remove Shortlink link tag.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_adjacent_posts_link',
			'title'   => __( 'Remove links to previous, next post', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'If you use Wordpress as a CMS, then you can delete these links, they can only come in handy for a blog.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Remove the previous and next post links within the wp_head of your wordpress theme.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_recent_comments_style',
			'title'   => __( 'Remove .recentcomments styles', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'WP by default for the widget "recent comments" prescribes in the code styles that are almost impossible to change, because to them apply! important.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes .recentcomments styles from head section.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'lazy_load_font_awesome',
			'title'   => __( 'Font Awesome asynchronous', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'By default, WordPress loads Font Awesome icons synchronously, that is, your page will not be fully loaded until Font Awesome icons are loaded. This algorithm slows down the loading of your page and leads to errors when checking the site in Google Page Speed. Using this option, your Font Awesome icons will be loaded after your page is fully loaded. This method has a negative — you and visitors of your site will see changes while loading a page, from the placeholders to icons.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_dashicons',
			'title'   => __( 'Disable Dashicons', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Dashicons is the official icon font of the WordPress admin as of 3.8. Some of you have requested that we add a feature to remove Dashicons. Some themes and developers utilize this (dashicons.min.css) on the front-end of their sites.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_gravatars',
			'title'   => __( 'Disable gravatars', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'This function that prevents the user’s gravatar being automatically obtained from gravatar.com based on their registered email. This would be useful for sites where users require an extra layer of privacy, or if you just want to prevent potentially silly or embarrasing avatar accidents.
			If you’re using Identicons or any other generated default avatar, the user should keep a consistent avatar unless they change their registered email.
			', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Classic editor and Gutenberg', 'clearfy' ) . '</strong>' . '<p>' . __( 'In this group of options, you can manage revisions and post autosave.', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'revisions_disable',
			'title'     => __( 'Disable revision', 'clearfy' ),
			'default'   => false,
			'eventsOn'  => [
				'hide' => '.factory-control-revision_limit'
			],
			'eventsOff' => [
				'show' => '.factory-control-revision_limit'
			],
		];

		$options[] = [
			'type'    => 'dropdown',
			'name'    => 'revision_limit',
			'title'   => __( 'Limit Post Revisions', 'clearfy' ),
			'data'    => [
				[ 'default', __( 'Wordpress default', 'clearfy' ) ],
				[ '15', '15 ' . __( 'revisions', 'clearfy' ) ],
				[ '20', '20 ' . __( 'revisions', 'clearfy' ) ],
				[ '25', '25 ' . __( 'revisions', 'clearfy' ) ],
				[ '30', '30 ' . __( 'revisions', 'clearfy' ) ],
				[ '35', '35 ' . __( 'revisions', 'clearfy' ) ],
				[ '40', '40 ' . __( 'revisions', 'clearfy' ) ],
				[ '45', '45 ' . __( 'revisions', 'clearfy' ) ],
				[ '50', '50 ' . __( 'revisions', 'clearfy' ) ],
				[ '55', '55 ' . __( 'revisions', 'clearfy' ) ],
				[ '60', '60 ' . __( 'revisions', 'clearfy' ) ]
			],
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'WordPress automatically saves revisions when you are working on posts and pages. These can begin to add up pretty quick. By default, there is no limit in place. We have seen posts with over 1,000 revisions. Multiply this by 50 pages and suddenly you have over 50,000 revisions sitting in your database. The problem with this is that you will most likely never use them and they can start slowing down your database as well as using disk space.
So we recommend either disabling or limiting your revisions. ', 'clearfy' ),
			'default' => 'default'
		];

		if ( version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
			$options[] = [
				'type'    => 'checkbox',
				'way'     => 'buttons',
				'name'    => 'gutenberg_autosave_control',
				'title'   => __( 'Gutenberg autosave control', 'clearfy' ),
				'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
				'hint'    => __( 'By activating this option autosave feature in the Gutenberg editor will be disabled. Alternatively it also provides options in the editor to select a longer autosave interval time than the default 10 seconds.', 'clearfy' ),
				'default' => false
			];
		} else {
			$options[] = [
				'type'    => 'checkbox',
				'way'     => 'buttons',
				'name'    => 'disable_post_autosave',
				'title'   => __( 'Disable autosave', 'clearfy' ),
				'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
				'hint'    => __( 'WordPress by default automatically saves a draft every 60 seconds (1 minute). There are reasons why you might want to change this.', 'clearfy' ) . '<br><b>Clearfy</b>: ' . __( 'Disables automatic saving of drafts.', 'clearfy' ),
				'default' => false
			];
		}

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Remove query strings from static resources', 'clearfy' ) . '</strong>' . '<p>' . __( 'This funcitons will remove query strings from static resources like CSS & JS files inside the HTML <head> element to improve your speed scores in services like Pingdom, GTmetrix, PageSpeed and YSlow. <b style="color:#ff5722">Important:</b> This does not work for authorized users. To avoid problems after plugins update!', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_js_version',
			'title'   => __( 'Remove Version from Script', 'clearfy' ) . ' <span class="wbcr-clearfy-recomended-text">(' . __( 'Recommended', 'clearfy' ) . ')</span>',
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'To make it more difficult for others to hack your website you can remove the WordPress version number from your site, your css and js. Without that number it\'s not possible to see if you run not the current version to exploit bugs from the older versions. <br><br>
					Additionally it can improve the loading speed of your site, because without query strings in the URL the css and js files can be cached.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes wordpress version number from scripts (not logged in user only).', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_style_version',
			'title'   => __( 'Remove Version from Stylesheet', 'clearfy' ) . ' <span class="wbcr-clearfy-recomended-text">(' . __( 'Recommended', 'clearfy' ) . ')</span>',
			'layout'  => [ 'hint-type' => 'icon' ],
			'hint'    => __( 'To make it more difficult for others to hack your website you can remove the WordPress version number from your site, your css and js. Without that number it\'s not possible to see if you run not the current version to exploit bugs from the older versions. <br><br>
					Additionally it can improve the loading speed of your site, because without query strings in the URL the css and js files can be cached.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Removes the wordpress version number from stylesheets (not logged in user only).', 'clearfy' ),
			'default' => false
			/*'eventsOn' => array(
				'show' => '.factory-control-disable_remove_style_version_for_auth_users'
			),
			'eventsOff' => array(
				'hide' => '.factory-control-disable_remove_style_version_for_auth_users'
			)*/
		];

		/*$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_remove_style_version_for_auth_users',
			'title'   => __( 'Disable remove versions for auth users', 'clearfy' ) . ' <span class="wbcr-clearfy-recomended-text">(' . __( 'Recommended', 'clearfy' ) . ')</span>',
			'layout'  => array( 'hint-type' => 'icon' ),
			'default' => false
		);*/

		$options[] = [
			'type'   => 'textarea',
			'name'   => 'remove_version_exclude',
			'height' => '120',
			'title'  => __( 'Exclude stylesheet/script file names', 'clearfy' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( 'Enter Stylesheet/Script file names to exclude from version removal (each exclude file starts with a new line)', 'clearfy' ) . '<br><br><b>' . __( 'Example', 'clearfy' ) . ':</b>' . ' http://testwp.dev/wp-includes/js/jquery/jquery.js',
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Heartbeat', 'clearfy' ) . '</strong>' . '<p>' . __( 'The WordPress Heartbeat API uses /wp-admin/admin-ajax.php to run AJAX calls from the web-browser. While this is great and all it can also cause high CPU usage and crazy amounts of PHP calls. For example, if you leave your dashboard open it will keep sending POST requests to this file on a regular interval, every 15 seconds. Here is an example below of it happening.', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'    => 'dropdown',
			'name'    => 'disable_heartbeat',
			'way'     => 'buttons',
			'title'   => __( 'Disable Heartbeat', 'clearfy' ),
			'data'    => [
				[ 'default', __( 'Default', 'clearfy' ) ],
				[ 'everywhere', __( 'Everywhere', 'clearfy' ) ],
				[ 'on_dashboard_page', __( 'On dashboard page', 'clearfy' ) ],
				[ 'allow_only_on_post_edit_pages', __( 'Only allow when editing Posts/Pages', 'clearfy' ) ]
			],
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			//'hint' => __('You can disable all plugin updates or choose manual or automatic update mode.', 'clearfy'),
			'events'  => [
				'default'                       => [
					'show' => '.factory-control-heartbeat_frequency'
				],
				'on_dashboard_page'             => [
					'show' => '.factory-control-heartbeat_frequency'
				],
				'allow_only_on_post_edit_pages' => [
					'show' => '.factory-control-heartbeat_frequency'
				],
				'everywhere'                    => [
					'hide' => '.factory-control-heartbeat_frequency'
				]
			],
			'default' => 'default',
		];

		$options[] = [
			'type'    => 'dropdown',
			'name'    => 'heartbeat_frequency',
			'title'   => __( 'Heartbeat frequency', 'clearfy' ),
			'data'    => [
				[ 'default', __( 'Wordpress default', 'clearfy' ) ],
				[ '20', '20 ' . __( 'seconds', 'clearfy' ) ],
				[ '25', '25 ' . __( 'seconds', 'clearfy' ) ],
				[ '30', '30 ' . __( 'seconds', 'clearfy' ) ],
				[ '35', '35 ' . __( 'seconds', 'clearfy' ) ],
				[ '40', '40 ' . __( 'seconds', 'clearfy' ) ],
				[ '45', '45 ' . __( 'seconds', 'clearfy' ) ],
				[ '50', '50 ' . __( 'seconds', 'clearfy' ) ],
				[ '55', '55 ' . __( 'seconds', 'clearfy' ) ],
				[ '60', '60 ' . __( 'seconds', 'clearfy' ) ],
				[ '80', '80 ' . __( 'seconds', 'clearfy' ) ],
				[ '120', '120 ' . __( 'seconds', 'clearfy' ) ],
				[ '150', '150 ' . __( 'seconds', 'clearfy' ) ],
				[ '200', '200 ' . __( 'seconds', 'clearfy' ) ],
				[ '250', '250 ' . __( 'seconds', 'clearfy' ) ],
				[ '300', '300 ' . __( 'seconds', 'clearfy' ) ],
				[ '400', '400 ' . __( 'seconds', 'clearfy' ) ],
				[ '500', '500 ' . __( 'seconds', 'clearfy' ) ]
			],
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Select the heartbeat frequency wordpress. We recommend you 60 seconds, default is 20 seconds.', 'clearfy' ),
			'default' => 'default'
		];

		$form_options = [];

		$form_options[] = [
			'type'  => 'form-group',
			'items' => $options,
			//'cssClass' => 'postbox'
		];

		return apply_filters( 'wbcr_clr_code_clean_form_options', $form_options, $this );
	}

	/**
	 * Adds an html warning notification html markup.
	 */
	public function restApiDangerMessage() {
		?>
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="control-group col-sm-8">
                <div id="wbcr-clearfy-rest-api-danger-message" class="wbcr-clearfy-danger-message">
					<?php _e( '<b>Use this option carefully!</b><br> Plugins like Contact form 7, Anycomments may have problems using this option.', 'clearfy' ) ?>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Check if WP_POST_REVISIONS is installed in wp-config file
	 *
	 * @return bool
	 */
	protected function is_post_revision_constant() {
		$config_path = ABSPATH . '/wp-config.php';

		if ( file_exists( $config_path ) ) {
			$file    = fopen( $config_path, 'r' );
			$content = fread( $file, filesize( $config_path ) );
			fclose( $file );

			if ( ! empty( $content ) && preg_match( '/define(.+?)WP_POST_REVISIONS/', $content ) ) {
				return true;
			}
		}

		return false;
	}
}
