<?php
	/**
	 * * This file groups the settings for quick setup
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 18.09.2017, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	return apply_filters('wbcr_clearfy_group_options', array(
		/** ------------------------ Google services ----------------------------- */
		array(
			'name' => 'lazy_load_google_fonts',
			'title' => __('Google Fonts asynchronous', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_google_fonts',
			'title' => __('Disable Google Fonts', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'remove_iframe_google_maps',
			'title' => __('Remove iframe Google maps', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'exclude_from_disable_google_maps',
			'title' => __('Exclude pages from Disable Google Maps filter', 'clearfy'),
			'tags' => array()
		),
		/** ------------------------ End google services ----------------------------- */
		array(
			'name' => 'disable_google_maps',
			'title' => __('Disable Google maps', 'clearfy'),
			'tags' => array()
		),
		/** ------------------------ Performance page ----------------------------- */
		array(
			'name' => 'remove_xfn_link',
			'title' => __('Removing XFN (XHTML Friends Network) Profile Link', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'lazy_load_font_awesome',
			'title' => __('Font Awesome asynchronous', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_dashicons',
			'title' => __('Disable Dashicons', 'clearfy'),
			'tags' => array('hide_my_wp')
		),
		array(
			'name' => 'disable_gravatars',
			'title' => __('Disable gravatars', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_json_rest_api',
			'title' => __('Remove REST API Links', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_emoji',
			'title' => __('Disable Emojis', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		/*array(
			'name' => 'remove_dns_prefetch',
			'title' => __('Remove dns-prefetch', 'clearfy'),
			'tags' => array('clear_code')
		),*/

		array(
			'name' => 'remove_rsd_link',
			'title' => __('Remove RSD Link', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		array(
			'name' => 'remove_wlw_link',
			'title' => __('Remove wlwmanifest Link', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		array(
			'name' => 'remove_shortlink_link',
			'title' => __('Remove Shortlink', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		array(
			'name' => 'remove_adjacent_posts_link',
			'title' => __('Remove links to previous, next post', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		array(
			'name' => 'remove_recent_comments_style',
			'title' => __('Remove .recentcomments styles', 'clearfy'),
			'tags' => array('clear_code', 'hide_my_wp')
		),
		/** ------------------------ End Performance page ----------------------------- */
		array(
			'name' => 'content_image_auto_alt',
			'title' => __('Automatically set the alt attribute', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'set_last_modified_headers',
			'title' => __('Automatically insert the Last Modified header', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'if_modified_since_headers',
			'title' => __('Return an If-Modified-Since responce', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'remove_last_item_breadcrumb_yoast',
			'title' => __('Remove duplicate names in breadcrumbs WP SEO by Yoast', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'yoast_remove_image_from_xml_sitemap',
			'title' => sprintf(__('Remove the tag %s from XML site map', 'clearfy'), 'image:image'),
			'tags' => get_locale() == 'ru_RU' ? array('clear_code') : array()
		),
		array(
			'name' => 'yoast_remove_json_ld_search',
			'title' => __('Disable JSON-LD sitelinks searchbox', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'yoast_remove_json_ld_output',
			'title' => __('Disable Yoast Structured Data', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'yoast_remove_head_comment',
			'title' => sprintf(__('Remove comment from %s section', 'clearfy'), 'head'),
			'tags' => array('clear_code')
		),
		array(
			'name' => 'redirect_archives_date',
			'title' => __('Remove archives date', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'redirect_archives_author',
			'title' => __('Remove author archives ', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'redirect_archives_tag',
			'title' => __('Remove archives tag', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'attachment_pages_redirect',
			'title' => __('Remove attachment pages', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'remove_single_pagination_duplicate',
			'title' => __('Remove post pagination', 'clearfy'),
			'tags' => array('recommended')
		),
		array(
			'name' => 'remove_replytocom',
			'title' => __('Remove ?replytocom', 'clearfy'),
			'tags' => array('seo_optimize')
		),
		array(
			'name' => 'remove_meta_generator',
			'title' => __('Remove meta generator', 'clearfy'),
			'tags' => array('clear_code', 'defence', 'hide_my_wp')
		),
		array(
			'name' => 'protect_author_get',
			'title' => __('Hide author login', 'clearfy'),
			'tags' => array('defence', 'hide_my_wp')
		),
		array(
			'name' => 'change_login_errors',
			'title' => __('Hide errors when logging into the site', 'clearfy', 'hide_my_wp'),
			'tags' => array('defence', 'hide_my_wp')
		),
		array(
			'name' => 'remove_style_version',
			'title' => __('Remove Version from Stylesheet', 'clearfy', 'hide_my_wp'),
			'tags' => array('clear_code', 'defence', 'hide_my_wp')
		),
		array(
			'name' => 'remove_js_version',
			'title' => __('Remove Version from Script', 'clearfy'),
			'tags' => array('clear_code', 'defence', 'hide_my_wp')
		),
		array(
			'name' => 'remove_unneeded_widget_page',
			'title' => __('Remove the "Pages" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_calendar',
			'title' => __('Remove calendar widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_tag_cloud',
			'title' => __('Remove the "Cloud of tags" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_archives',
			'title' => __('Remove the "Archives" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_links',
			'title' => __('Remove the "Links" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_meta',
			'title' => __('Remove the "Meta" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_search',
			'title' => __('Remove the "Search" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_text',
			'title' => __('Remove the "Text" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_categories',
			'title' => __('Remove the "Categories" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_recent_posts',
			'title' => __('Remove the "Recent Posts" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_recent_comments',
			'title' => __('Remove the "Recent Comments" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_text',
			'title' => __('Remove the "Text" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_rss',
			'title' => __('Remove the "RSS" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_menu',
			'title' => __('Remove the "Menu" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array(
			'name' => 'remove_unneeded_widget_twenty_eleven_ephemera',
			'title' => __('Remove the "Twenty Eleven Ephemera" widget', 'clearfy'),
			'tags' => array('remove_default_widgets')
		),
		array('name' => 'revisions_disable', 'title' => __('Disable revision', 'clearfy'), 'tags' => array()),
		array('name' => 'revision_limit', 'title' => __('Limit Post Revisions', 'clearfy'), 'tags' => array()),
		array('name' => 'last_modified_exclude', 'title' => __('Exclude pages:', 'clearfy'), 'tags' => array()),
		array(
			'name' => 'right_robots_txt',
			'title' => __('Create right robots.txt', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'robots_txt_text',
			'title' => __('You can edit the robots.txt file in the box below:', 'clearfy'),
			'tags' => array()
		),
		array('name' => 'quick_modes', 'title' => __('Quick mode', 'clearfy'), 'tags' => array()),
		array(
			'name' => 'remove_jquery_migrate',
			'title' => __('Remove jQuery Migrate', 'clearfy'),
			'tags' => array()
		),
		array('name' => 'disable_embeds', 'title' => __('Disable Embeds', 'clearfy'), 'tags' => array()),
		array('name' => 'disable_feed', 'title' => __('Disable RSS feeds', 'clearfy'), 'tags' => array()),
		array(
			'name' => 'remove_unnecessary_link_admin_bar',
			'title' => __('Removes links to wordpress.org site from the admin bar', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'remove_style_version',
			'title' => __('Remove Version from Stylesheet', 'clearfy'),
			'tags' => array('hide_my_wp')
		),
		array(
			'name' => 'remove_js_version',
			'title' => __('Remove Version from Script', 'clearfy'),
			'tags' => array('hide_my_wp')
		),
		array(
			'name' => 'remove_version_exclude',
			'title' => __('Eclude stylesheet/script file names', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'enable_wordpres_sanitize',
			'title' => __('Enable Sanitization of WordPress', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_admin_bar',
			'title' => __('Disable admin top bar', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_admin_bar_logo',
			'title' => __('Remove admin bar WP logo', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'replace_howdy_welcome',
			'title' => __('Replace "Howdy" text with "Welcome"', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'revisions_disable',
			'title' => __('Disable revision', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'revision_limit',
			'title' => __('Limit Post Revisions', 'update-services'),
			'tags' => array()
		),
		array(
			'name' => 'disable_post_autosave',
			'title' => __('Disable autosave', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_texturization',
			'title' => __('Disable Texturization - Smart Quotes', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_auto_correct_dangit',
			'title' => __('Disable capitalization in Wordpress branding', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_auto_paragraph',
			'title' => __('Disable auto inserted paragraphs (i.e. p tags)', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'disable_heartbeat',
			'title' => __('Disable Heartbeat', 'update-services'),
			'tags' => array()
		),
		array(
			'name' => 'heartbeat_frequency',
			'title' => __('Heartbeat frequency', 'update-services'),
			'tags' => array()
		),
		array(
			'name' => 'remove_html_comments',
			'title' => __('Remove html comments', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'deactive_preinstall_components',
			'title' => __('Deactivate preinstall components', 'clearfy'),
			'tags' => array()
		),
		array(
			'name' => 'freemius_activated_addons',
			'title' => __('Freemius activated addons', 'clearfy'),
			'tags' => array()
		),
		/** ------------------------ Clearfy settings ----------------------------- */
		array(
			'name' => 'disable_clearfy_extra_menu',
			'title' => __('Disable menu in adminbar', 'clearfy'),
			'tags' => array()
		)

	));
