<?php

/**
 * Settings class file.
 *
 * @package WordPress Plugin Template/Settings
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings class.
 */
class Generate_WP_Fields {


	/**
	 * Get fields for all tools
	 *
	 * @return array
	 */
	public static function get_fields() {
		global $wp_version;

// <editor-fold>
		$settings['Readme'] = array(
			'tab'		 => 'Readme',
			'tab_descr'	 => 'Plugin Readme Generator',
			'title'		 => 'Use this tool to create custom <a href="https://wordpress.org/plugins/about/readme.txt" target="_blank">readme.txt</a> file for your WordPress plugin.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Plugin Name',
					'description'	 => 'The name of the plugin.',
					'id'			 => 'plugin_name',
					'placeholder'	 => 'Test Plugin',
					'type'			 => 'text',
					'default'		 => '',
				),
				1	 =>
				array(
					'label'			 => 'Contributors',
					'description'	 => 'Comma separated list of <a href="https://wordpress.org/" target="_blank">WordPress.org usernames</a>.',
					'id'			 => 'contributors',
					'placeholder'	 => 'user, user, user',
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Tags',
					'description'	 => 'Comma separated list of tags.',
					'id'			 => 'tags',
					'placeholder'	 => 'tag, tag, tag',
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Donate Link',
					'description'	 => 'The link to your donations page.',
					'id'			 => 'donate_link',
					'placeholder'	 => 'http://example.com/',
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'License',
					'description'	 => 'Plugin license.',
					'id'			 => 'license',
					'placeholder'	 => 'GPLv2 or later',
					'type'			 => 'text',
					'default'		 => 'GPLv2 or later',
				),
				5	 =>
				array(
					'label'			 => 'License URI',
					'description'	 => 'Plugin license URI.',
					'id'			 => 'license_uri',
					'placeholder'	 => 'http://www.gnu.org/licenses/gpl-2.0.html',
					'type'			 => 'text',
					'default'		 => 'http://www.gnu.org/licenses/gpl-2.0.html',
				),
				6	 =>
				array(
					'label'			 => 'Required WordPress version',
					'description'	 => 'The lowest WordPress version the plugin will work on.',
					'id'			 => 'version_requires_at_least',
					'placeholder'	 => '4.0',
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Tested up to',
					'description'	 => 'The highest WordPress version the plugin test on.',
					'id'			 => 'version_tested_up_to',
					'placeholder'	 => '5.7',
					'type'			 => 'text',
					'default'		 => $wp_version,
				),
				8	 =>
				array(
					'label'			 => 'Required PHP version',
					'description'	 => 'The lowest PHP version required to run the plugin.',
					'id'			 => 'required_php_version',
					'placeholder'	 => '5.6',
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Stable tag',
					'description'	 => 'The subversion "tag" of the latest stable version, or "trunk". Default: trunk',
					'id'			 => 'version_stable_tag',
					'placeholder'	 => '1.1',
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Short Description',
					'description'	 => 'Description in 2-3 sentences, up to 150 characters, no markup.',
					'id'			 => 'short_description',
					'placeholder'	 => 'Short description of this great plugin. No more than 150 characters, no markup.',
					'type'			 => 'textarea',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Long Description',
					'description'	 => 'Plugin full description. No characters limit.',
					'id'			 => 'long_description',
					'placeholder'	 => 'Long description of this great plugin. No characters limit, and you can use markdown.

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
markdown parsed.

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown\'s Syntax Documentation][markdown syntax].

Titles are optional, naturally.

Asterisks for *emphasis*.

Double it up  for **strong**.',
					'type'			 => 'textarea',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Installation',
					'description'	 => 'Plugin installation instruction.',
					'id'			 => 'installation',
					'placeholder'	 => '1. Upload "test-plugin.php" to the "/wp-content/plugins/" directory.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Place "do_action( \'plugin_name_hook\' );" in your templates.',
					'type'			 => 'textarea',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'FAQ',
					'description'	 => 'Plugin frequently asked questions.',
					'id'			 => 'faq',
					'placeholder'	 => '= A question that someone might have =
An answer to that question.

= What about foo bar? =
Answer to foo bar dilemma.',
					'type'			 => 'textarea',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Screenshot #1',
					'description'	 => 'Screenshot description.',
					'id'			 => 'screenshot-1',
					'placeholder'	 => 'The screenshot description corresponds to screenshot-1.(png|jpg|jpeg|gif).',
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Screenshot #2',
					'description'	 => 'Screenshot description.',
					'id'			 => 'screenshot-2',
					'placeholder'	 => 'The screenshot description corresponds to screenshot-2.(png|jpg|jpeg|gif).',
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'Screenshot #3',
					'description'	 => 'Screenshot description.',
					'id'			 => 'screenshot-3',
					'placeholder'	 => 'The screenshot description corresponds to screenshot-3.(png|jpg|jpeg|gif).',
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Change Log',
					'description'	 => 'List versions from most recent at top to oldest at bottom.',
					'id'			 => 'change_log',
					'placeholder'	 => '= 0.2 =
* A change since the previous version.
* Another change.

= 0.1 =
* Initial release.',
					'type'			 => 'textarea',
					'default'		 => '= 0.1 =
* Initial release.',
				),
				18	 =>
				array(
					'label'			 => 'Upgrade Notice',
					'description'	 => 'Upgrade notices describe the reason a user should upgrade. No more than 300 characters.',
					'id'			 => 'upgrade_notice',
					'placeholder'	 => '= 0.2 =
Upgrade notices describe the reason a user should upgrade

= 0.1 =
This version fixes a security related bug. Upgrade immediately.',
					'type'			 => 'textarea',
					'default'		 => '= 0.2 =
Upgrade notices describe the reason a user should upgrade

= 0.1 =
This version fixes a security related bug. Upgrade immediately.',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Menu'] = array(
			'tab'		 => 'Menu',
			'tab_descr'	 => 'Menu Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Navigation_Menus" target="_blank">Navigation Menus</a> with <a href="https://developer.wordpress.org/reference/functions/register_nav_menus/" target="_blank">register_nav_menus()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => 'custom_navigation_menus',
					'type'			 => 'text',
					'default'		 => 'custom_navigation_menus',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				2	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => 'text_domain',
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Menu 1 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Menu 1 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'description1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Menu 2 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Menu 2 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'description2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Menu 3 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Menu 3 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'description3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Menu 4 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Menu 4 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'description4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Menu 5 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Menu 5 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'description5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Sidebar'] = array(
			'tab'		 => 'Sidebar',
			'tab_descr'	 => 'Sidebar Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Widgets_API" target="_blank">Sidebars</a> with <a href="https://developer.wordpress.org/reference/functions/register_sidebar/" target="_blank">register_sidebar()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => 'custom_sidebars',
					'type'			 => 'text',
					'default'		 => 'custom_sidebars',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				2	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => 'text_domain',
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'ID',
					'description'	 => 'ID used in the code. Lowercase, without spaces.',
					'id'			 => 'id1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Class',
					'description'	 => 'Sidebar CSS class name.',
					'id'			 => 'class1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Name',
					'description'	 => 'Sidebar name presented in the the dashboard.',
					'id'			 => 'name1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'Short descriptive summary of the sidebar.',
					'id'			 => 'description1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Before Title',
					'description'	 => 'HTML to place before every widget title.',
					'id'			 => 'before_title1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'After Title',
					'description'	 => 'HTML to place after every widget title.',
					'id'			 => 'after_title1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Before Widget',
					'description'	 => 'HTML to place before every widget.',
					'id'			 => 'before_widget1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'After Widget',
					'description'	 => 'HTML to place after every widget.',
					'id'			 => 'after_widget1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'ID',
					'description'	 => 'ID used in the code. Lowercase, without spaces.',
					'id'			 => 'id2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Class',
					'description'	 => 'Sidebar CSS class name.',
					'id'			 => 'class2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Name',
					'description'	 => 'Sidebar name presented in the the dashboard.',
					'id'			 => 'name2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'Short descriptive summary of the sidebar.',
					'id'			 => 'description2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Before Title',
					'description'	 => 'HTML to place before every widget title.',
					'id'			 => 'before_title2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'After Title',
					'description'	 => 'HTML to place after every widget title.',
					'id'			 => 'after_title2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Before Widget',
					'description'	 => 'HTML to place before every widget.',
					'id'			 => 'before_widget2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'After Widget',
					'description'	 => 'HTML to place after every widget.',
					'id'			 => 'after_widget2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'ID',
					'description'	 => 'ID used in the code. Lowercase, without spaces.',
					'id'			 => 'id3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Class',
					'description'	 => 'Sidebar CSS class name.',
					'id'			 => 'class3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Name',
					'description'	 => 'Sidebar name presented in the the dashboard.',
					'id'			 => 'name3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'Short descriptive summary of the sidebar.',
					'id'			 => 'description3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'Before Title',
					'description'	 => 'HTML to place before every widget title.',
					'id'			 => 'before_title3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'After Title',
					'description'	 => 'HTML to place after every widget title.',
					'id'			 => 'after_title3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Before Widget',
					'description'	 => 'HTML to place before every widget.',
					'id'			 => 'before_widget3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'After Widget',
					'description'	 => 'HTML to place after every widget.',
					'id'			 => 'after_widget3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'ID',
					'description'	 => 'ID used in the code. Lowercase, without spaces.',
					'id'			 => 'id4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Class',
					'description'	 => 'Sidebar CSS class name.',
					'id'			 => 'class4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				29	 =>
				array(
					'label'			 => 'Name',
					'description'	 => 'Sidebar name presented in the the dashboard.',
					'id'			 => 'name4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				30	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'Short descriptive summary of the sidebar.',
					'id'			 => 'description4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Before Title',
					'description'	 => 'HTML to place before every widget title.',
					'id'			 => 'before_title4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'After Title',
					'description'	 => 'HTML to place after every widget title.',
					'id'			 => 'after_title4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Before Widget',
					'description'	 => 'HTML to place before every widget.',
					'id'			 => 'before_widget4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'After Widget',
					'description'	 => 'HTML to place after every widget.',
					'id'			 => 'after_widget4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				35	 =>
				array(
					'label'			 => 'ID',
					'description'	 => 'ID used in the code. Lowercase, without spaces.',
					'id'			 => 'id5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				36	 =>
				array(
					'label'			 => 'Class',
					'description'	 => 'Sidebar CSS class name.',
					'id'			 => 'class5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				37	 =>
				array(
					'label'			 => 'Name',
					'description'	 => 'Sidebar name presented in the the dashboard.',
					'id'			 => 'name5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				38	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'Short descriptive summary of the sidebar.',
					'id'			 => 'description5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				39	 =>
				array(
					'label'			 => 'Before Title',
					'description'	 => 'HTML to place before every widget title.',
					'id'			 => 'before_title5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				40	 =>
				array(
					'label'			 => 'After Title',
					'description'	 => 'HTML to place after every widget title.',
					'id'			 => 'after_title5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				41	 =>
				array(
					'label'			 => 'Before Widget',
					'description'	 => 'HTML to place before every widget.',
					'id'			 => 'before_widget5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				42	 =>
				array(
					'label'			 => 'After Widget',
					'description'	 => 'HTML to place after every widget.',
					'id'			 => 'after_widget5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Theme_Headers'] = array(
			'tab'		 => 'Theme Headers',
			'tab_descr'	 => 'Default Theme Headers Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Custom_Headers" target="_blank" rel="noopener noreferrer">Default Theme Headers</a> with <a href="https://developer.wordpress.org/reference/functions/register_default_headers/" target="_blank" rel="noopener noreferrer">register_default_headers()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => 'custom_default_headers',
					'type'			 => 'text',
					'default'		 => 'custom_default_headers',
				),
				1	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => 'text_domain',
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Header 1 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Menu Description',
					'description'	 => 'A short descriptive summary.',
					'id'			 => 'description1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Image URL',
					'description'	 => 'URL to the header image.',
					'id'			 => 'url1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Thumbnail Image URL',
					'description'	 => 'URL to the header image thumbnail.',
					'id'			 => 'thumbnail_url1',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Header 2 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Menu Description',
					'description'	 => 'A short descriptive summary.',
					'id'			 => 'description2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Image URL',
					'description'	 => 'URL to the header image.',
					'id'			 => 'url2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Thumbnail Image URL',
					'description'	 => 'URL to the header image thumbnail.',
					'id'			 => 'thumbnail_url2',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Header 3 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Menu Description',
					'description'	 => 'A short descriptive summary.',
					'id'			 => 'description3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Image URL',
					'description'	 => 'URL to the header image.',
					'id'			 => 'url3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Thumbnail Image URL',
					'description'	 => 'URL to the header image thumbnail.',
					'id'			 => 'thumbnail_url3',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Header 4 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Menu Description',
					'description'	 => 'A short descriptive summary.',
					'id'			 => 'description4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'Image URL',
					'description'	 => 'URL to the header image.',
					'id'			 => 'url4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Thumbnail Image URL',
					'description'	 => 'URL to the header image thumbnail.',
					'id'			 => 'thumbnail_url4',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Header 5 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'name5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Menu Description',
					'description'	 => 'A short descriptive summary.',
					'id'			 => 'description5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Image URL',
					'description'	 => 'URL to the header image.',
					'id'			 => 'url5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Thumbnail Image URL',
					'description'	 => 'URL to the header image thumbnail.',
					'id'			 => 'thumbnail_url5',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// todo: add search
// todo: add hook description
// todo: add autofil used veriables
// <editor-fold>
		$settings['Hooks'] = array(
			'tab'		 => 'Hooks',
			'tab_descr'	 => 'Hooks Generator',
			'title'		 => 'Use this tool to create custom <a href="https://codex.wordpress.org/Plugin_API/Hooks" target="_blank">Hooks</a> with <a href="https://developer.wordpress.org/reference/functions/add_filter/" target="_blank">add_filter()</a> and <a href="https://developer.wordpress.org/reference/functions/add_action/" target="_blank">add_action()</a> functions.',
			'fields'	 =>
			array(
				0			 =>
				array(
					'label'			 => 'Hook Type',
					'description'	 => 'Actions of filters.',
					'id'			 => 'hook_type',
					'placeholder'	 => 'add_filter',
					'type'			 => 'select',
					'options'		 =>
					array(
						'add_filter' => 'Filter',
						'add_action' => 'Action',
					),
					'default'		 => 'add_filter',
				),
				'actions'	 => array(
					'label'			 => 'Action Name',
					'description'	 => 'Which filter/action you want to hook into?<br><span class="wpg_action_description"></span>', //<span class="hook-helper">Hook Information</span>',
					'id'			 => 'hook_name',
					'placeholder'	 => '',
					'type'			 => 'select',
					'data'			 => array(
						'parent'	 => 'hook_type',
						'parent-val' => 'add_action',
					),
					'options'		 => array(
// <editor-fold>
						'pre_trackback_post'							 => 'pre_trackback_post',
						'trackback_post'								 => 'trackback_post',
						'opml_head'										 => 'opml_head',
						'signup_header'									 => 'signup_header',
						'before_signup_header'							 => 'before_signup_header',
						'before_signup_form'							 => 'before_signup_form',
						'signup_blogform'								 => 'signup_blogform',
						'signup_extra_fields'							 => 'signup_extra_fields',
						'signup_hidden_fields'							 => 'signup_hidden_fields',
						'signup_finished'								 => 'signup_finished',
						'preprocess_signup_form'						 => 'preprocess_signup_form',
						'after_signup_form'								 => 'after_signup_form',
						'ms_loaded'										 => 'ms_loaded',
						'customize_render_panel'						 => 'customize_render_panel',
						'wp_print_footer_scripts'						 => 'wp_print_footer_scripts',
						'wp_enqueue_scripts'							 => 'wp_enqueue_scripts',
						'set_current_user'								 => 'set_current_user',
						'phpmailer_init'								 => 'phpmailer_init',
						'wp_login_failed'								 => 'wp_login_failed',
						'wp_logout'										 => 'wp_logout',
						'auth_cookie_malformed'							 => 'auth_cookie_malformed',
						'auth_cookie_expired'							 => 'auth_cookie_expired',
						'auth_cookie_bad_username'						 => 'auth_cookie_bad_username',
						'auth_cookie_bad_hash'							 => 'auth_cookie_bad_hash',
						'auth_cookie_bad_session_token'					 => 'auth_cookie_bad_session_token',
						'auth_cookie_valid'								 => 'auth_cookie_valid',
						'set_auth_cookie'								 => 'set_auth_cookie',
						'set_logged_in_cookie'							 => 'set_logged_in_cookie',
						'clear_auth_cookie'								 => 'clear_auth_cookie',
						'auth_redirect'									 => 'auth_redirect',
						'check_admin_referer'							 => 'check_admin_referer',
						'check_ajax_referer'							 => 'check_ajax_referer',
						'wp_verify_nonce_failed'						 => 'wp_verify_nonce_failed',
						'load_feed_engine'								 => 'load_feed_engine',
						'wp_default_styles'								 => 'wp_default_styles',
						'media_buttons'									 => 'media_buttons',
						'print_default_editor_scripts'					 => 'print_default_editor_scripts',
						'before_wp_tiny_mce'							 => 'before_wp_tiny_mce',
						'wp_tiny_mce_init'								 => 'wp_tiny_mce_init',
						'after_wp_tiny_mce'								 => 'after_wp_tiny_mce',
						'http_api_curl'									 => 'http_api_curl',
						'rdf_ns'										 => 'rdf_ns',
						'rdf_header'									 => 'rdf_header',
						'rdf_item'										 => 'rdf_item',
						'registered_post_type'							 => 'registered_post_type',
						'unregistered_post_type'						 => 'unregistered_post_type',
						'post_stuck'									 => 'post_stuck',
						'post_unstuck'									 => 'post_unstuck',
						'before_delete_post'							 => 'before_delete_post',
						'delete_post'									 => 'delete_post',
						'deleted_post'									 => 'deleted_post',
						'after_delete_post'								 => 'after_delete_post',
						'wp_trash_post'									 => 'wp_trash_post',
						'trashed_post'									 => 'trashed_post',
						'untrash_post'									 => 'untrash_post',
						'untrashed_post'								 => 'untrashed_post',
						'trash_post_comments'							 => 'trash_post_comments',
						'trashed_post_comments'							 => 'trashed_post_comments',
						'untrash_post_comments'							 => 'untrash_post_comments',
						'untrashed_post_comments'						 => 'untrashed_post_comments',
						'pre_post_update'								 => 'pre_post_update',
						'edit_attachment'								 => 'edit_attachment',
						'attachment_updated'							 => 'attachment_updated',
						'add_attachment'								 => 'add_attachment',
						'edit_post'										 => 'edit_post',
						'post_updated'									 => 'post_updated',
						'save_post'										 => 'save_post',
						'wp_insert_post'								 => 'wp_insert_post',
						'transition_post_status'						 => 'transition_post_status',
						'delete_attachment'								 => 'delete_attachment',
						'clean_post_cache'								 => 'clean_post_cache',
						'clean_page_cache'								 => 'clean_page_cache',
						'clean_attachment_cache'						 => 'clean_attachment_cache',
						'private_to_published'							 => 'private_to_published',
						'xmlrpc_publish_post'							 => 'xmlrpc_publish_post',
						'generate_rewrite_rules'						 => 'generate_rewrite_rules',
						'permalink_structure_changed'					 => 'permalink_structure_changed',
						'customize_render_section'						 => 'customize_render_section',
						'admin_bar_init'								 => 'admin_bar_init',
						'add_admin_bar_menus'							 => 'add_admin_bar_menus',
						'rest_api_init'									 => 'rest_api_init',
						'atom_ns'										 => 'atom_ns',
						'atom_head'										 => 'atom_head',
						'atom_author'									 => 'atom_author',
						'atom_entry'									 => 'atom_entry',
						'start_previewing_theme'						 => 'start_previewing_theme',
						'stop_previewing_theme'							 => 'stop_previewing_theme',
						'customize_register'							 => 'customize_register',
						'customize_post_value_set'						 => 'customize_post_value_set',
						'customize_preview_init'						 => 'customize_preview_init',
						'customize_save_validation_before'				 => 'customize_save_validation_before',
						'customize_save'								 => 'customize_save',
						'customize_save_after'							 => 'customize_save_after',
						'add_user_role'									 => 'add_user_role',
						'remove_user_role'								 => 'remove_user_role',
						'set_user_role'									 => 'set_user_role',
						'wp_maybe_auto_update'							 => 'wp_maybe_auto_update',
						'wp_default_scripts'							 => 'wp_default_scripts',
						'admin_bar_menu'								 => 'admin_bar_menu',
						'wp_before_admin_bar_render'					 => 'wp_before_admin_bar_render',
						'wp_after_admin_bar_render'						 => 'wp_after_admin_bar_render',
						'switch_locale'									 => 'switch_locale',
						'restore_previous_locale'						 => 'restore_previous_locale',
						'change_locale'									 => 'change_locale',
						'add_user_to_blog'								 => 'add_user_to_blog',
						'remove_user_from_blog'							 => 'remove_user_from_blog',
						'after_signup_site'								 => 'after_signup_site',
						'after_signup_user'								 => 'after_signup_user',
						'wpmu_activate_user'							 => 'wpmu_activate_user',
						'wpmu_activate_blog'							 => 'wpmu_activate_blog',
						'wpmu_new_user'									 => 'wpmu_new_user',
						'wpmu_new_blog'									 => 'wpmu_new_blog',
						'added_existing_user'							 => 'added_existing_user',
						'wp_print_scripts'								 => 'wp_print_scripts',
						'wp_feed_options'								 => 'wp_feed_options',
						'shutdown'										 => 'shutdown',
						'parse_site_query'								 => 'parse_site_query',
						'pre_get_sites'									 => 'pre_get_sites',
						'rss_head'										 => 'rss_head',
						'rss_item'										 => 'rss_item',
						'do_robotstxt'									 => 'do_robotstxt',
						'deprecated_function_run'						 => 'deprecated_function_run',
						'deprecated_constructor_run'					 => 'deprecated_constructor_run',
						'deprecated_file_included'						 => 'deprecated_file_included',
						'deprecated_argument_run'						 => 'deprecated_argument_run',
						'deprecated_hook_run'							 => 'deprecated_hook_run',
						'doing_it_wrong_run'							 => 'doing_it_wrong_run',
						'delete_usermeta'								 => 'delete_usermeta',
						'deleted_usermeta'								 => 'deleted_usermeta',
						'update_usermeta'								 => 'update_usermeta',
						'added_usermeta'								 => 'added_usermeta',
						'updated_usermeta'								 => 'updated_usermeta',
						'rest_insert_comment'							 => 'rest_insert_comment',
						'rest_delete_comment'							 => 'rest_delete_comment',
						'rest_insert_attachment'						 => 'rest_insert_attachment',
						'rest_delete_revision'							 => 'rest_delete_revision',
						'rest_insert_user'								 => 'rest_insert_user',
						'rest_delete_user'								 => 'rest_delete_user',
						'wp_authenticate'								 => 'wp_authenticate',
						'wp_login'										 => 'wp_login',
						'clean_user_cache'								 => 'clean_user_cache',
						'profile_update'								 => 'profile_update',
						'user_register'									 => 'user_register',
						'retreive_password'								 => 'retreive_password',
						'retrieve_password'								 => 'retrieve_password',
						'retrieve_password_key'							 => 'retrieve_password_key',
						'password_reset'								 => 'password_reset',
						'after_password_reset'							 => 'after_password_reset',
						'register_post'									 => 'register_post',
						'register_new_user'								 => 'register_new_user',
						'wp_print_styles'								 => 'wp_print_styles',
						'parse_term_query'								 => 'parse_term_query',
						'pre_get_terms'									 => 'pre_get_terms',
						'print_media_templates'							 => 'print_media_templates',
						'template_redirect'								 => 'template_redirect',
						'do_robots'										 => 'do_robots',
						'atom_comments_ns'								 => 'atom_comments_ns',
						'comments_atom_head'							 => 'comments_atom_head',
						'comment_atom_entry'							 => 'comment_atom_entry',
						'parse_comment_query'							 => 'parse_comment_query',
						'pre_get_comments'								 => 'pre_get_comments',
						'metadata_lazyloader_queued_objects'			 => 'metadata_lazyloader_queued_objects',
						'wpmu_blog_updated'								 => 'wpmu_blog_updated',
						'make_spam_blog'								 => 'make_spam_blog',
						'make_ham_blog'									 => 'make_ham_blog',
						'mature_blog'									 => 'mature_blog',
						'unmature_blog'									 => 'unmature_blog',
						'archive_blog'									 => 'archive_blog',
						'unarchive_blog'								 => 'unarchive_blog',
						'make_delete_blog'								 => 'make_delete_blog',
						'make_undelete_blog'							 => 'make_undelete_blog',
						'clean_site_cache'								 => 'clean_site_cache',
						'_deprecated refresh_blog_details'				 => '_deprecated refresh_blog_details',
						'switch_blog'									 => 'switch_blog',
						'update_blog_public'							 => 'update_blog_public',
						'clean_network_cache'							 => 'clean_network_cache',
						'customize_render_partials_before'				 => 'customize_render_partials_before',
						'customize_render_partials_after'				 => 'customize_render_partials_after',
						'parse_query'									 => 'parse_query',
						'parse_tax_query'								 => 'parse_tax_query',
						'pre_get_posts'									 => 'pre_get_posts',
						'posts_selection'								 => 'posts_selection',
						'loop_start'									 => 'loop_start',
						'loop_end'										 => 'loop_end',
						'loop_no_results'								 => 'loop_no_results',
						'comment_loop_start'							 => 'comment_loop_start',
						'the_post'										 => 'the_post',
						'update_postmeta'								 => 'update_postmeta',
						'updated_postmeta'								 => 'updated_postmeta',
						'delete_postmeta'								 => 'delete_postmeta',
						'deleted_postmeta'								 => 'deleted_postmeta',
						'get_header'									 => 'get_header',
						'get_footer'									 => 'get_footer',
						'get_sidebar'									 => 'get_sidebar',
						'pre_get_search_form'							 => 'pre_get_search_form',
						'wp_meta'										 => 'wp_meta',
						'wp_head'										 => 'wp_head',
						'wp_footer'										 => 'wp_footer',
						'wp_enqueue_code_editor'						 => 'wp_enqueue_code_editor',
						'switch_theme'									 => 'switch_theme',
						'after_switch_theme'							 => 'after_switch_theme',
						'rss_tag_pre'									 => 'rss_tag_pre',
						'rss2_ns'										 => 'rss2_ns',
						'rss2_head);'									 => 'rss2_head);',
						'rss2_item'										 => 'rss2_item',
						'update_option'									 => 'update_option',
						'updated_option'								 => 'updated_option',
						'add_option'									 => 'add_option',
						'added_option'									 => 'added_option',
						'delete_option'									 => 'delete_option',
						'deleted_option'								 => 'deleted_option',
						'deleted_transient'								 => 'deleted_transient',
						'setted_transient'								 => 'setted_transient',
						'add_site_option'								 => 'add_site_option',
						'delete_site_option'							 => 'delete_site_option',
						'update_site_option'							 => 'update_site_option',
						'deleted_site_transient'						 => 'deleted_site_transient',
						'setted_site_transient'							 => 'setted_site_transient',
						'begin_fetch_post_thumbnail_html'				 => 'begin_fetch_post_thumbnail_html',
						'end_fetch_post_thumbnail_html'					 => 'end_fetch_post_thumbnail_html',
						'rss2_comments_ns'								 => 'rss2_comments_ns',
						'commentsrss2_head'								 => 'commentsrss2_head',
						'commentrss2_item'								 => 'commentrss2_item',
						'grant_super_admin'								 => 'grant_super_admin',
						'granted_super_admin'							 => 'granted_super_admin',
						'revoke_super_admin'							 => 'revoke_super_admin',
						'revoked_super_admin'							 => 'revoked_super_admin',
						'wp_playlist_scripts'							 => 'wp_playlist_scripts',
						'wp_enqueue_media'								 => 'wp_enqueue_media',
						'xmlrpc_call'									 => 'xmlrpc_call',
						'xmlrpc_call_success_wp_deletePage'				 => 'xmlrpc_call_success_wp_deletePage',
						'xmlrpc_call_success_wp_newCategory'			 => 'xmlrpc_call_success_wp_newCategory',
						'xmlrpc_call_success_wp_deleteCategory'			 => 'xmlrpc_call_success_wp_deleteCategory',
						'xmlrpc_call_success_wp_deleteComment'			 => 'xmlrpc_call_success_wp_deleteComment',
						'xmlrpc_call_success_wp_editComment'			 => 'xmlrpc_call_success_wp_editComment',
						'xmlrpc_call_success_wp_newComment'				 => 'xmlrpc_call_success_wp_newComment',
						'xmlrpc_call_success_blogger_newPost'			 => 'xmlrpc_call_success_blogger_newPost',
						'xmlrpc_call_success_blogger_editPost'			 => 'xmlrpc_call_success_blogger_editPost',
						'xmlrpc_call_success_blogger_deletePost'		 => 'xmlrpc_call_success_blogger_deletePost',
						'xmlrpc_call_success_mw_newPost'				 => 'xmlrpc_call_success_mw_newPost',
						'xmlrpc_call_success_mw_editPost'				 => 'xmlrpc_call_success_mw_editPost',
						'xmlrpc_call_success_mw_newMediaObject'			 => 'xmlrpc_call_success_mw_newMediaObject',
						'pingback_post'									 => 'pingback_post',
						'registered_taxonomy'							 => 'registered_taxonomy',
						'unregistered_taxonomy'							 => 'unregistered_taxonomy',
						'pre_delete_term'								 => 'pre_delete_term',
						'edit_term_taxonomies'							 => 'edit_term_taxonomies',
						'edited_term_taxonomies'						 => 'edited_term_taxonomies',
						'delete_term_taxonomy'							 => 'delete_term_taxonomy',
						'deleted_term_taxonomy'							 => 'deleted_term_taxonomy',
						'delete_term'									 => 'delete_term',
						'create_term'									 => 'create_term',
						'created_term'									 => 'created_term',
						'add_term_relationship'							 => 'add_term_relationship',
						'added_term_relationship'						 => 'added_term_relationship',
						'set_object_terms'								 => 'set_object_terms',
						'delete_term_relationships'						 => 'delete_term_relationships',
						'deleted_term_relationships'					 => 'deleted_term_relationships',
						'edit_term_taxonomy'							 => 'edit_term_taxonomy',
						'edited_term_taxonomy'							 => 'edited_term_taxonomy',
						'edit_term'										 => 'edit_term',
						'edited_term'									 => 'edited_term',
						'clean_object_term_cache'						 => 'clean_object_term_cache',
						'clean_term_cache'								 => 'clean_term_cache',
						'clean_taxonomy_cache'							 => 'clean_taxonomy_cache',
						'split_shared_term'								 => 'split_shared_term',
						'enqueue_embed_scripts'							 => 'enqueue_embed_scripts',
						'wp_roles_init'									 => 'wp_roles_init',
						'embed_content'									 => 'embed_content',
						'embed_content_meta);'							 => 'embed_content_meta);',
						'embed_head'									 => 'embed_head',
						'embed_footer'									 => 'embed_footer',
						'http_api_debug'								 => 'http_api_debug',
						'pre_get_users'									 => 'pre_get_users',
						'pre_user_query'								 => 'pre_user_query',
						'wp_delete_nav_menu'							 => 'wp_delete_nav_menu',
						'wp_create_nav_menu'							 => 'wp_create_nav_menu',
						'wp_update_nav_menu'							 => 'wp_update_nav_menu',
						'wp_add_nav_menu_item'							 => 'wp_add_nav_menu_item',
						'wp_update_nav_menu_item'						 => 'wp_update_nav_menu_item',
						'_wp_put_post_revision'							 => '_wp_put_post_revision',
						'wp_restore_post_revision'						 => 'wp_restore_post_revision',
						'wp_delete_post_revision'						 => 'wp_delete_post_revision',
						'ms_network_not_found'							 => 'ms_network_not_found',
						'ms_site_not_found'								 => 'ms_site_not_found',
						'comment_form_comments_closed'					 => 'comment_form_comments_closed',
						'comment_form_before'							 => 'comment_form_before',
						'comment_form_must_log_in_after'				 => 'comment_form_must_log_in_after',
						'comment_form_top'								 => 'comment_form_top',
						'comment_form_logged_in_after'					 => 'comment_form_logged_in_after',
						'comment_form_before_fields'					 => 'comment_form_before_fields',
						'comment_form_after_fields'						 => 'comment_form_after_fields',
						'comment_form'									 => 'comment_form',
						'comment_form_after'							 => 'comment_form_after',
						'register_sidebar'								 => 'register_sidebar',
						'wp_register_sidebar_widget'					 => 'wp_register_sidebar_widget',
						'wp_unregister_sidebar_widget'					 => 'wp_unregister_sidebar_widget',
						'dynamic_sidebar_before'						 => 'dynamic_sidebar_before',
						'dynamic_sidebar'								 => 'dynamic_sidebar',
						'dynamic_sidebar_after'							 => 'dynamic_sidebar_after',
						'the_widget'									 => 'the_widget',
						'widgets_init'									 => 'widgets_init',
						'customize_render_control'						 => 'customize_render_control',
						'load_textdomain'								 => 'load_textdomain',
						'unload_textdomain'								 => 'unload_textdomain',
						'parse_network_query'							 => 'parse_network_query',
						'pre_get_networks'								 => 'pre_get_networks',
						'parse_request'									 => 'parse_request',
						'send_headers'									 => 'send_headers',
						'wp'											 => 'wp',
						'comment_duplicate_trigger'						 => 'comment_duplicate_trigger',
						'comment_flood_trigger'							 => 'comment_flood_trigger',
						'wp_blacklist_check'							 => 'wp_blacklist_check',
						'delete_comment'								 => 'delete_comment',
						'deleted_comment'								 => 'deleted_comment',
						'trash_comment'									 => 'trash_comment',
						'trashed_comment'								 => 'trashed_comment',
						'untrash_comment'								 => 'untrash_comment',
						'untrashed_comment'								 => 'untrashed_comment',
						'spam_comment'									 => 'spam_comment',
						'spammed_comment'								 => 'spammed_comment',
						'unspam_comment'								 => 'unspam_comment',
						'unspammed_comment'								 => 'unspammed_comment',
						'transition_comment_status'						 => 'transition_comment_status',
						'wp_insert_comment'								 => 'wp_insert_comment',
						'comment_post'									 => 'comment_post',
						'wp_set_comment_status'							 => 'wp_set_comment_status',
						'edit_comment'									 => 'edit_comment',
						'wp_update_comment_count'						 => 'wp_update_comment_count',
						'pre_ping'										 => 'pre_ping',
						'clean_comment_cache'							 => 'clean_comment_cache',
						'comment_id_not_found'							 => 'comment_id_not_found',
						'comment_closed'								 => 'comment_closed',
						'comment_on_trash'								 => 'comment_on_trash',
						'comment_on_draft'								 => 'comment_on_draft',
						'comment_on_password_protected'					 => 'comment_on_password_protected',
						'pre_comment_on_post'							 => 'pre_comment_on_post',
						'in_widget_form'								 => 'in_widget_form',
						'xmlrpc_rsd_apis'								 => 'xmlrpc_rsd_apis',
						'set_comment_cookies'							 => 'set_comment_cookies',
						'add_meta_boxes_comment'						 => 'add_meta_boxes_comment',
						'myblogs_allblogs_options'						 => 'myblogs_allblogs_options',
						'try_gutenberg_panel'							 => 'try_gutenberg_panel',
						'welcome_panel'									 => 'welcome_panel',
						'after_menu_locations_table'					 => 'after_menu_locations_table',
						'add_category_form_pre'							 => 'add_category_form_pre',
						'add_link_category_form_pre'					 => 'add_link_category_form_pre',
						'add_tag_form_pre'								 => 'add_tag_form_pre',
						'add_tag_form_fields'							 => 'add_tag_form_fields',
						'edit_category_form'							 => 'edit_category_form',
						'edit_link_category_form'						 => 'edit_link_category_form',
						'add_tag_form'									 => 'add_tag_form',
						'admin_post_nopriv'								 => 'admin_post_nopriv',
						'admin_post'									 => 'admin_post',
						'customize_controls_init'						 => 'customize_controls_init',
						'customize_controls_enqueue_scripts'			 => 'customize_controls_enqueue_scripts',
						'customize_controls_print_styles'				 => 'customize_controls_print_styles',
						'customize_controls_print_scripts'				 => 'customize_controls_print_scripts',
						'customize_controls_print_footer_scripts'		 => 'customize_controls_print_footer_scripts',
						'admin_enqueue_scripts'							 => 'admin_enqueue_scripts',
						'admin_print_styles'							 => 'admin_print_styles',
						'admin_print_scripts'							 => 'admin_print_scripts',
						'admin_head'									 => 'admin_head',
						'in_admin_header'								 => 'in_admin_header',
						'network_admin_notices'							 => 'network_admin_notices',
						'user_admin_notices'							 => 'user_admin_notices',
						'admin_notices'									 => 'admin_notices',
						'all_admin_notices'								 => 'all_admin_notices',
						'adminmenu'										 => 'adminmenu',
						'export_filters'								 => 'export_filters',
						'delete_user_form'								 => 'delete_user_form',
						'core_upgrade_preamble'							 => 'core_upgrade_preamble',
						'add_meta_boxes_link'							 => 'add_meta_boxes_link',
						'personal_options_update'						 => 'personal_options_update',
						'edit_user_profile_update'						 => 'edit_user_profile_update',
						'user_edit_form_tag'							 => 'user_edit_form_tag',
						'admin_color_scheme_picker'						 => 'admin_color_scheme_picker',
						'personal_options'								 => 'personal_options',
						'profile_personal_options'						 => 'profile_personal_options',
						'show_user_profile'								 => 'show_user_profile',
						'edit_user_profile'								 => 'edit_user_profile',
						'dbx_post_advanced'								 => 'dbx_post_advanced',
						'add_meta_boxes'								 => 'add_meta_boxes',
						'do_meta_boxes'									 => 'do_meta_boxes',
						'post_edit_form_tag'							 => 'post_edit_form_tag',
						'edit_form_top'									 => 'edit_form_top',
						'edit_form_before_permalink'					 => 'edit_form_before_permalink',
						'edit_form_after_title'							 => 'edit_form_after_title',
						'edit_form_after_editor'						 => 'edit_form_after_editor',
						'submitpage_box'								 => 'submitpage_box',
						'submitpost_box'								 => 'submitpost_box',
						'edit_page_form'								 => 'edit_page_form',
						'edit_form_advanced'							 => 'edit_form_advanced',
						'dbx_post_sidebar'								 => 'dbx_post_sidebar',
						'blog_privacy_selector'							 => 'blog_privacy_selector',
						'pre_current_active_plugins'					 => 'pre_current_active_plugins',
						'tool_box'										 => 'tool_box',
						'wpmuadminedit'									 => 'wpmuadminedit',
						'pre_network_site_new_created_user'				 => 'pre_network_site_new_created_user',
						'network_site_new_created_user'					 => 'network_site_new_created_user',
						'network_site_new_form'							 => 'network_site_new_form',
						'activate_blog'									 => 'activate_blog',
						'deactivate_blog'								 => 'deactivate_blog',
						'after_mu_upgrade'								 => 'after_mu_upgrade',
						'wpmu_upgrade_site'								 => 'wpmu_upgrade_site',
						'wpmu_upgrade_page'								 => 'wpmu_upgrade_page',
						'network_user_new_created_user'					 => 'network_user_new_created_user',
						'network_user_new_form'							 => 'network_user_new_form',
						'wpmu_update_blog_options'						 => 'wpmu_update_blog_options',
						'wpmueditblogaction'							 => 'wpmueditblogaction',
						'network_site_users_created_user'				 => 'network_site_users_created_user',
						'network_site_users_after_list_table'			 => 'network_site_users_after_list_table',
						'update_wpmu_options'							 => 'update_wpmu_options',
						'wpmu_options'									 => 'wpmu_options',
						'after_db_upgrade'								 => 'after_db_upgrade',
						'admin_init'									 => 'admin_init',
						'load-page-new.php'								 => 'load-page-new.php',
						'load-page.php'									 => 'load-page.php',
						'load-categories.php'							 => 'load-categories.php',
						'load-edit-link-categories.php'					 => 'load-edit-link-categories.php',
						'load-edit-tags.php'							 => 'load-edit-tags.php',
						'invite_user'									 => 'invite_user',
						'user_new_form_tag'								 => 'user_new_form_tag',
						'user_new_form'									 => 'user_new_form',
						'in_admin_footer'								 => 'in_admin_footer',
						'admin_footer'									 => 'admin_footer',
						'admin_print_footer_scripts'					 => 'admin_print_footer_scripts',
						'edit_category_form_pre'						 => 'edit_category_form_pre',
						'edit_link_category_form_pre'					 => 'edit_link_category_form_pre',
						'edit_tag_form_pre'								 => 'edit_tag_form_pre',
						'edit_category_form_fields'						 => 'edit_category_form_fields',
						'edit_link_category_form_fields'				 => 'edit_link_category_form_fields',
						'edit_tag_form_fields'							 => 'edit_tag_form_fields',
						'edit_tag_form'									 => 'edit_tag_form',
						'custom_header_options'							 => 'custom_header_options',
						'wp_create_file_in_uploads'						 => 'wp_create_file_in_uploads',
						'sidebar_admin_setup'							 => 'sidebar_admin_setup',
						'delete_widget'									 => 'delete_widget',
						'widgets_admin_page'							 => 'widgets_admin_page',
						'sidebar_admin_page'							 => 'sidebar_admin_page',
						'manage_themes_custom_column'					 => 'manage_themes_custom_column',
						'after_theme_row'								 => 'after_theme_row',
						'heartbeat_nopriv_tick'							 => 'heartbeat_nopriv_tick',
						'load-widgets.php'								 => 'load-widgets.php',
						'widgets.php'									 => 'widgets.php',
						'heartbeat_tick'								 => 'heartbeat_tick',
						'wp_ajax_crop_image_pre_save'					 => 'wp_ajax_crop_image_pre_save',
						'post_locked_dialog'							 => 'post_locked_dialog',
						'post_lock_lost_dialog'							 => 'post_lock_lost_dialog',
						'wp_creating_autosave'							 => 'wp_creating_autosave',
						'manage_link_custom_column'						 => 'manage_link_custom_column',
						'install_themes_table_header'					 => 'install_themes_table_header',
						'activate_plugin'								 => 'activate_plugin',
						'activated_plugin'								 => 'activated_plugin',
						'deactivate_plugin'								 => 'deactivate_plugin',
						'deactivated_plugin'							 => 'deactivated_plugin',
						'delete_plugin'									 => 'delete_plugin',
						'deleted_plugin'								 => 'deleted_plugin',
						'pre_uninstall_plugin'							 => 'pre_uninstall_plugin',
						'_network_admin_menu'							 => '_network_admin_menu',
						'_user_admin_menu'								 => '_user_admin_menu',
						'_admin_menu'									 => '_admin_menu',
						'network_admin_menu'							 => 'network_admin_menu',
						'user_admin_menu'								 => 'user_admin_menu',
						'admin_menu'									 => 'admin_menu',
						'admin_page_access_denied'						 => 'admin_page_access_denied',
						'restrict_manage_posts'							 => 'restrict_manage_posts',
						'manage_posts_extra_tablenav'					 => 'manage_posts_extra_tablenav',
						'manage_pages_custom_column'					 => 'manage_pages_custom_column',
						'manage_posts_custom_column'					 => 'manage_posts_custom_column',
						'bulk_edit_custom_box'							 => 'bulk_edit_custom_box',
						'quick_edit_custom_box'							 => 'quick_edit_custom_box',
						'manage_plugins_custom_column'					 => 'manage_plugins_custom_column',
						'after_plugin_row'								 => 'after_plugin_row',
						'add_inline_data'								 => 'add_inline_data',
						'admin_xml_ns'									 => 'admin_xml_ns',
						'export_wp'										 => 'export_wp',
						'pre_user_search'								 => 'pre_user_search',
						'_core_updated_successfully'					 => '_core_updated_successfully',
						'check_passwords'								 => 'check_passwords',
						'user_profile_update_errors'					 => 'user_profile_update_errors',
						'edit_user_created_user'						 => 'edit_user_created_user',
						'delete_user'									 => 'delete_user',
						'deleted_user'									 => 'deleted_user',
						'wp_privacy_personal_data_erased'				 => 'wp_privacy_personal_data_erased',
						'manage_media_custom_column'					 => 'manage_media_custom_column',
						'install_plugins_table_header'					 => 'install_plugins_table_header',
						'post_submitbox_minor_actions'					 => 'post_submitbox_minor_actions',
						'post_submitbox_misc_actions'					 => 'post_submitbox_misc_actions',
						'post_submitbox_start'							 => 'post_submitbox_start',
						'attachment_submitbox_misc_actions'				 => 'attachment_submitbox_misc_actions',
						'post_comment_status_meta_box-options'			 => 'post_comment_status_meta_box-options',
						'page_attributes_meta_box_template'				 => 'page_attributes_meta_box_template',
						'page_attributes_misc_attributes'				 => 'page_attributes_misc_attributes',
						'submitlink_box'								 => 'submitlink_box',
						'restrict_manage_users'							 => 'restrict_manage_users',
						'manage_users_extra_tablenav'					 => 'manage_users_extra_tablenav',
						'restrict_manage_comments'						 => 'restrict_manage_comments',
						'manage_comments_nav'							 => 'manage_comments_nav',
						'manage_comments_custom_column'					 => 'manage_comments_custom_column',
						'current_screen'								 => 'current_screen',
						'pre_auto_update'								 => 'pre_auto_update',
						'automatic_updates_complete'					 => 'automatic_updates_complete',
						'upgrader_process_complete'						 => 'upgrader_process_complete',
						'wp_install'									 => 'wp_install',
						'wp_upgrade'									 => 'wp_upgrade',
						'wpmublogsaction'								 => 'wpmublogsaction',
						'manage_sites_custom_column'					 => 'manage_sites_custom_column',
						'wp_network_dashboard_setup'					 => 'wp_network_dashboard_setup',
						'wp_user_dashboard_setup'						 => 'wp_user_dashboard_setup',
						'wp_dashboard_setup'							 => 'wp_dashboard_setup',
						'rightnow_end'									 => 'rightnow_end',
						'activity_box_end'								 => 'activity_box_end',
						'wpmuadminresult'								 => 'wpmuadminresult',
						'mu_rightnow_end'								 => 'mu_rightnow_end',
						'mu_activity_box_end'							 => 'mu_activity_box_end',
						'admin_print_styles-media-upload-popup'			 => 'admin_print_styles-media-upload-popup',
						'admin_print_scripts-media-upload-popup'		 => 'admin_print_scripts-media-upload-popup',
						'admin_head-media-upload-popup'					 => 'admin_head-media-upload-popup',
						'upload_ui_over_quota'							 => 'upload_ui_over_quota',
						'pre-upload-ui'									 => 'pre-upload-ui',
						'pre-plupload-upload-ui'						 => 'pre-plupload-upload-ui',
						'post-plupload-upload-ui'						 => 'post-plupload-upload-ui',
						'pre-html-upload-ui'							 => 'pre-html-upload-ui',
						'post-html-upload-ui'							 => 'post-html-upload-ui',
						'post-upload-ui'								 => 'post-upload-ui',
						'wp_edit_form_attachment_display'				 => 'wp_edit_form_attachment_display',
						'populate_options'								 => 'populate_options',
						'delete_link'									 => 'delete_link',
						'deleted_link'									 => 'deleted_link',
						'edit_link'										 => 'edit_link',
						'add_link'										 => 'add_link',
						'delete_blog'									 => 'delete_blog',
						'deleted_blog'									 => 'deleted_blog',
						'wpmu_delete_user'								 => 'wpmu_delete_user',
						'make_spam_user'								 => 'make_spam_user',
						'make_ham_user'									 => 'make_ham_user',
						'wp_privacy_personal_data_export_file_created'	 => 'wp_privacy_personal_data_export_file_created',
						'wp_privacy_personal_data_export_file'			 => 'wp_privacy_personal_data_export_file',
						'login_enqueue_scripts'							 => 'login_enqueue_scripts',
						'login_head'									 => 'login_head',
						'login_header'									 => 'login_header',
						'login_footer'									 => 'login_footer',
						'lostpassword_post'								 => 'lostpassword_post',
						'login_init'									 => 'login_init',
						'lost_password'									 => 'lost_password',
						'lostpassword_form'								 => 'lostpassword_form',
						'validate_password_reset'						 => 'validate_password_reset',
						'resetpass_form'								 => 'resetpass_form',
						'register_form'									 => 'register_form',
						'user_request_action_confirmed'					 => 'user_request_action_confirmed',
						'login_form'									 => 'login_form',
						'muplugins_loaded'								 => 'muplugins_loaded',
						'plugins_loaded'								 => 'plugins_loaded',
						'sanitize_comment_cookies'						 => 'sanitize_comment_cookies',
						'setup_theme'									 => 'setup_theme',
						'after_setup_theme'								 => 'after_setup_theme',
						'init'											 => 'init',
						'wp_loaded'										 => 'wp_loaded',
						'wp-mail.php'									 => 'wp-mail.php',
						'publish_phone'									 => 'publish_phone',
						'activate_header'								 => 'activate_header',
						'activate_wp_head'								 => 'activate_wp_head',
					)
// </editor-fold>
				),
				1			 =>
				array(
// <editor-fold>
					'label'			 => 'Filter Name',
					'description'	 => 'Which filter/action you want to hook into?<br><span class="wpg_filter_description"></span>', //<span class="hook-helper">Hook Information</span>',
					'id'			 => 'filter_name',
					'placeholder'	 => '',
					'type'			 => 'select',
					'data'			 => array(
						'parent'	 => 'hook_type',
						'parent-val' => 'add_filter',
					),
					'options'		 =>
					array(
						'link_category'								 => 'link_category',
						'link_title'								 => 'link_title',
						'signup_another_blog_init'					 => 'signup_another_blog_init',
						'signup_create_blog_meta'					 => 'signup_create_blog_meta',
						'add_signup_meta'							 => 'add_signup_meta',
						'signup_user_init'							 => 'signup_user_init',
						'signup_blog_init'							 => 'signup_blog_init',
						'signup_get_available_languages'			 => 'signup_get_available_languages',
						'wpmu_active_signup'						 => 'wpmu_active_signup',
						'wp_http_cookie_value'						 => 'wp_http_cookie_value',
						'customize_panel_active'					 => 'customize_panel_active',
						'register_post_type_args'					 => 'register_post_type_args',
						'http_origin'								 => 'http_origin',
						'allowed_http_origins'						 => 'allowed_http_origins',
						'allowed_http_origin'						 => 'allowed_http_origin',
						'wp_mail'									 => 'wp_mail',
						'wp_mail_from'								 => 'wp_mail_from',
						'wp_mail_from_name'							 => 'wp_mail_from_name',
						'wp_mail_content_type'						 => 'wp_mail_content_type',
						'wp_mail_charset'							 => 'wp_mail_charset',
						'authenticate'								 => 'authenticate',
						'auth_cookie'								 => 'auth_cookie',
						'auth_cookie_expiration'					 => 'auth_cookie_expiration',
						'secure_auth_cookie'						 => 'secure_auth_cookie',
						'secure_logged_in_cookie'					 => 'secure_logged_in_cookie',
						'secure_auth_redirect'						 => 'secure_auth_redirect',
						'auth_redirect_scheme'						 => 'auth_redirect_scheme',
						'wp_redirect'								 => 'wp_redirect',
						'wp_redirect_status'						 => 'wp_redirect_status',
						'wp_safe_redirect_fallback'					 => 'wp_safe_redirect_fallback',
						'allowed_redirect_hosts'					 => 'allowed_redirect_hosts',
						'comment_notification_recipients'			 => 'comment_notification_recipients',
						'comment_notification_notify_author'		 => 'comment_notification_notify_author',
						'comment_notification_text'					 => 'comment_notification_text',
						'comment_notification_subject'				 => 'comment_notification_subject',
						'comment_notification_headers'				 => 'comment_notification_headers',
						'notify_moderator'							 => 'notify_moderator',
						'comment_moderation_recipients'				 => 'comment_moderation_recipients',
						'comment_moderation_text'					 => 'comment_moderation_text',
						'comment_moderation_subject'				 => 'comment_moderation_subject',
						'comment_moderation_headers'				 => 'comment_moderation_headers',
						'wp_password_change_notification_email'		 => 'wp_password_change_notification_email',
						'wp_new_user_notification_email_admin'		 => 'wp_new_user_notification_email_admin',
						'wp_new_user_notification_email'			 => 'wp_new_user_notification_email',
						'nonce_life'								 => 'nonce_life',
						'nonce_user_logged_out'						 => 'nonce_user_logged_out',
						'salt'										 => 'salt',
						'check_password'							 => 'check_password',
						'random_password'							 => 'random_password',
						'pre_get_avatar'							 => 'pre_get_avatar',
						'style_loader_tag'							 => 'style_loader_tag',
						'print_styles_array'						 => 'print_styles_array',
						'style_loader_src'							 => 'style_loader_src',
						'graceful_fail'								 => 'graceful_fail',
						'wp_is_mobile'								 => 'wp_is_mobile',
						'wp_kses_allowed_html'						 => 'wp_kses_allowed_html',
						'pre_kses'									 => 'pre_kses',
						'wp_editor_settings'						 => 'wp_editor_settings',
						'the_editor_content'						 => 'the_editor_content',
						'quicktags_settings'						 => 'quicktags_settings',
						'teeny_mce_plugins'							 => 'teeny_mce_plugins',
						'mce_external_plugins'						 => 'mce_external_plugins',
						'tiny_mce_plugins'							 => 'tiny_mce_plugins',
						'mce_external_languages'					 => 'mce_external_languages',
						'mce_css'									 => 'mce_css',
						'teeny_mce_buttons'							 => 'teeny_mce_buttons',
						'mce_buttons'								 => 'mce_buttons',
						'mce_buttons_2'								 => 'mce_buttons_2',
						'mce_buttons_3'								 => 'mce_buttons_3',
						'mce_buttons_4'								 => 'mce_buttons_4',
						'teeny_mce_before_init'						 => 'teeny_mce_before_init',
						'tiny_mce_before_init'						 => 'tiny_mce_before_init',
						'wp_mce_translation'						 => 'wp_mce_translation',
						'wp_link_query_args'						 => 'wp_link_query_args',
						'wp_link_query'								 => 'wp_link_query',
						'use_curl_transport'						 => 'use_curl_transport',
						'old_slug_redirect_post_id'					 => 'old_slug_redirect_post_id',
						'old_slug_redirect_url'						 => 'old_slug_redirect_url',
						'pre_do_shortcode_tag'						 => 'pre_do_shortcode_tag',
						'do_shortcode_tag'							 => 'do_shortcode_tag',
						'strip_shortcodes_tagnames'					 => 'strip_shortcodes_tagnames',
						'wp_http_ixr_client_headers'				 => 'wp_http_ixr_client_headers',
						'session_token_manager'						 => 'session_token_manager',
						'attach_session_information'				 => 'attach_session_information',
						'get_attached_file'							 => 'get_attached_file',
						'update_attached_file'						 => 'update_attached_file',
						'_wp_relative_upload_path'					 => '_wp_relative_upload_path',
						'get_post_status'							 => 'get_post_status',
						'wp_count_attachments'						 => 'wp_count_attachments',
						'post_mime_types'							 => 'post_mime_types',
						'pre_delete_post'							 => 'pre_delete_post',
						'pre_trash_post'							 => 'pre_trash_post',
						'pre_untrash_post'							 => 'pre_untrash_post',
						'wp_insert_post_parent'						 => 'wp_insert_post_parent',
						'wp_insert_attachment_data'					 => 'wp_insert_attachment_data',
						'wp_insert_post_data'						 => 'wp_insert_post_data',
						'wp_unique_post_slug'						 => 'wp_unique_post_slug',
						'add_ping'									 => 'add_ping',
						'get_enclosed'								 => 'get_enclosed',
						'get_pung'									 => 'get_pung',
						'get_to_ping'								 => 'get_to_ping',
						'get_page_uri'								 => 'get_page_uri',
						'wp_get_attachment_metadata'				 => 'wp_get_attachment_metadata',
						'wp_get_attachment_url'						 => 'wp_get_attachment_url',
						'wp_get_attachment_caption'					 => 'wp_get_attachment_caption',
						'wp_get_attachment_thumb_file'				 => 'wp_get_attachment_thumb_file',
						'wp_get_attachment_thumb_url'				 => 'wp_get_attachment_thumb_url',
						'icon_dir'									 => 'icon_dir',
						'icon_dir_uri'								 => 'icon_dir_uri',
						'icon_dirs'									 => 'icon_dirs',
						'wp_mime_type_icon'							 => 'wp_mime_type_icon',
						'get_lastpostdate'							 => 'get_lastpostdate',
						'pre_get_lastpostmodified'					 => 'pre_get_lastpostmodified',
						'get_lastpostmodified'						 => 'get_lastpostmodified',
						'post_rewrite_rules'						 => 'post_rewrite_rules',
						'date_rewrite_rules'						 => 'date_rewrite_rules',
						'root_rewrite_rules'						 => 'root_rewrite_rules',
						'comments_rewrite_rules'					 => 'comments_rewrite_rules',
						'search_rewrite_rules'						 => 'search_rewrite_rules',
						'author_rewrite_rules'						 => 'author_rewrite_rules',
						'page_rewrite_rules'						 => 'page_rewrite_rules',
						'tag_rewrite_rules'							 => 'tag_rewrite_rules',
						'rewrite_rules_array'						 => 'rewrite_rules_array',
						'mod_rewrite_rules'							 => 'mod_rewrite_rules',
						'rewrite_rules'								 => 'rewrite_rules',
						'iis7_url_rewrite_rules'					 => 'iis7_url_rewrite_rules',
						'customize_section_active'					 => 'customize_section_active',
						'oembed_providers'							 => 'oembed_providers',
						'pre_oembed_result'							 => 'pre_oembed_result',
						'oembed_result'								 => 'oembed_result',
						'oembed_remote_get_args'					 => 'oembed_remote_get_args',
						'oembed_fetch_url'							 => 'oembed_fetch_url',
						'oembed_dataparse'							 => 'oembed_dataparse',
						'rest_url_prefix'							 => 'rest_url_prefix',
						'rest_url'									 => 'rest_url',
						'wp_rest_server_class'						 => 'wp_rest_server_class',
						'rest_avatar_sizes'							 => 'rest_avatar_sizes',
						'protected_title_format'					 => 'protected_title_format',
						'private_title_format'						 => 'private_title_format',
						'the_title'									 => 'the_title',
						'the_guid'									 => 'the_guid',
						'get_the_guid'								 => 'get_the_guid',
						'the_content'								 => 'the_content',
						'the_content_more_link'						 => 'the_content_more_link',
						'the_excerpt'								 => 'the_excerpt',
						'get_the_excerpt'							 => 'get_the_excerpt',
						'post_class'								 => 'post_class',
						'body_class'								 => 'body_class',
						'post_password_required'					 => 'post_password_required',
						'wp_link_pages_args'						 => 'wp_link_pages_args',
						'wp_link_pages_link'						 => 'wp_link_pages_link',
						'wp_link_pages'								 => 'wp_link_pages',
						'the_meta_key'								 => 'the_meta_key',
						'wp_dropdown_pages'							 => 'wp_dropdown_pages',
						'wp_list_pages_excludes'					 => 'wp_list_pages_excludes',
						'wp_list_pages'								 => 'wp_list_pages',
						'wp_page_menu_args'							 => 'wp_page_menu_args',
						'wp_page_menu'								 => 'wp_page_menu',
						'wp_get_attachment_link'					 => 'wp_get_attachment_link',
						'prepend_attachment'						 => 'prepend_attachment',
						'the_password_form'							 => 'the_password_form',
						'wp_post_revision_title_expanded'			 => 'wp_post_revision_title_expanded',
						'customize_loaded_components'				 => 'customize_loaded_components',
						'customize_changeset_branching'				 => 'customize_changeset_branching',
						'customize_save_response'					 => 'customize_save_response',
						'customize_changeset_save_data'				 => 'customize_changeset_save_data',
						'customize_dynamic_setting_args'			 => 'customize_dynamic_setting_args',
						'customize_dynamic_setting_class'			 => 'customize_dynamic_setting_class',
						'customize_allowed_urls'					 => 'customize_allowed_urls',
						'customize_refresh_nonces'					 => 'customize_refresh_nonces',
						'customize_previewable_devices'				 => 'customize_previewable_devices',
						'customize_load_themes'						 => 'customize_load_themes',
						'user_has_cap'								 => 'user_has_cap',
						'get_date_sql'								 => 'get_date_sql',
						'core_version_check_locale'					 => 'core_version_check_locale',
						'core_version_check_query_args'				 => 'core_version_check_query_args',
						'plugins_update_check_locales'				 => 'plugins_update_check_locales',
						'themes_update_check_locales'				 => 'themes_update_check_locales',
						'wp_get_update_data'						 => 'wp_get_update_data',
						'wp_list_bookmarks'							 => 'wp_list_bookmarks',
						'script_loader_src'							 => 'script_loader_src',
						'script_loader_tag'							 => 'script_loader_tag',
						'print_scripts_array'						 => 'print_scripts_array',
						'wp_admin_bar_class'						 => 'wp_admin_bar_class',
						'show_admin_bar'							 => 'show_admin_bar',
						'can_add_user_to_blog'						 => 'can_add_user_to_blog',
						'is_email_address_unsafe'					 => 'is_email_address_unsafe',
						'wpmu_validate_user_signup'					 => 'wpmu_validate_user_signup',
						'minimum_site_name_length'					 => 'minimum_site_name_length',
						'newblogname'								 => 'newblogname',
						'wpmu_validate_blog_signup'					 => 'wpmu_validate_blog_signup',
						'signup_site_meta'							 => 'signup_site_meta',
						'signup_user_meta'							 => 'signup_user_meta',
						'newblog_notify_siteadmin'					 => 'newblog_notify_siteadmin',
						'newuser_notify_siteadmin'					 => 'newuser_notify_siteadmin',
						'domain_exists'								 => 'domain_exists',
						'update_welcome_email'						 => 'update_welcome_email',
						'update_welcome_subject'					 => 'update_welcome_subject',
						'update_welcome_user_email'					 => 'update_welcome_user_email',
						'update_welcome_user_subject'				 => 'update_welcome_user_subject',
						'pre_get_space_used'						 => 'pre_get_space_used',
						'get_space_allowed'							 => 'get_space_allowed',
						'wp_is_large_network'						 => 'wp_is_large_network',
						'subdirectory_reserved_names'				 => 'subdirectory_reserved_names',
						'new_network_admin_email_content'			 => 'new_network_admin_email_content',
						'send_network_admin_email_change_email'		 => 'send_network_admin_email_change_email',
						'network_admin_email_change_email'			 => 'network_admin_email_change_email',
						'hook'										 => 'hook',
						'example_filter'							 => 'example_filter',
						'wpdocs_filter'								 => 'wpdocs_filter',
						'_deprecated wpdocs_filter'					 => '_deprecated wpdocs_filter',
						'oembed_default_width'						 => 'oembed_default_width',
						'oembed_request_post_id'					 => 'oembed_request_post_id',
						'rest_oembed_ttl'							 => 'rest_oembed_ttl',
						'wp_feed_cache_transient_lifetime'			 => 'wp_feed_cache_transient_lifetime',
						'get_bloginfo_rss'							 => 'get_bloginfo_rss',
						'bloginfo_rss'								 => 'bloginfo_rss',
						'default_feed'								 => 'default_feed',
						'get_wp_title_rss'							 => 'get_wp_title_rss',
						'wp_title_rss'								 => 'wp_title_rss',
						'the_title_rss'								 => 'the_title_rss',
						'the_content_feed'							 => 'the_content_feed',
						'the_excerpt_rss'							 => 'the_excerpt_rss',
						'the_permalink_rss'							 => 'the_permalink_rss',
						'comments_link_feed'						 => 'comments_link_feed',
						'comment_link'								 => 'comment_link',
						'comment_author_rss'						 => 'comment_author_rss',
						'comment_text_rss'							 => 'comment_text_rss',
						'the_category_rss'							 => 'the_category_rss',
						'rss_enclosure'								 => 'rss_enclosure',
						'atom_enclosure'							 => 'atom_enclosure',
						'self_link'									 => 'self_link',
						'feed_content_type'							 => 'feed_content_type',
						'wp_doing_ajax'								 => 'wp_doing_ajax',
						'wp_doing_cron'								 => 'wp_doing_cron',
						'file_mod_allowed'							 => 'file_mod_allowed',
						'the_sites'									 => 'the_sites',
						'site_search_columns'						 => 'site_search_columns',
						'sites_clauses'								 => 'sites_clauses',
						'found_sites_query'							 => 'found_sites_query',
						'the_permalink'								 => 'the_permalink',
						'user_trailingslashit'						 => 'user_trailingslashit',
						'pre_post_link'								 => 'pre_post_link',
						'post_link_category'						 => 'post_link_category',
						'post_link'									 => 'post_link',
						'post_type_link'							 => 'post_type_link',
						'page_link'									 => 'page_link',
						'_get_page_link'							 => '_get_page_link',
						'attachment_link'							 => 'attachment_link',
						'year_link'									 => 'year_link',
						'month_link'								 => 'month_link',
						'day_link'									 => 'day_link',
						'the_feed_link'								 => 'the_feed_link',
						'feed_link'									 => 'feed_link',
						'post_comments_feed_link'					 => 'post_comments_feed_link',
						'post_comments_feed_link_html'				 => 'post_comments_feed_link_html',
						'author_feed_link'							 => 'author_feed_link',
						'category_feed_link'						 => 'category_feed_link',
						'tag_feed_link'								 => 'tag_feed_link',
						'taxonomy_feed_link'						 => 'taxonomy_feed_link',
						'get_edit_tag_link'							 => 'get_edit_tag_link',
						'edit_tag_link'								 => 'edit_tag_link',
						'get_edit_term_link'						 => 'get_edit_term_link',
						'edit_term_link'							 => 'edit_term_link',
						'search_link'								 => 'search_link',
						'search_feed_link'							 => 'search_feed_link',
						'post_type_archive_feed_link'				 => 'post_type_archive_feed_link',
						'preview_post_link'							 => 'preview_post_link',
						'get_edit_post_link'						 => 'get_edit_post_link',
						'edit_post_link'							 => 'edit_post_link',
						'get_delete_post_link'						 => 'get_delete_post_link',
						'get_edit_comment_link'						 => 'get_edit_comment_link',
						'edit_comment_link'							 => 'edit_comment_link',
						'get_edit_bookmark_link'					 => 'get_edit_bookmark_link',
						'edit_bookmark_link'						 => 'edit_bookmark_link',
						'get_edit_user_link'						 => 'get_edit_user_link',
						'get_pagenum_link'							 => 'get_pagenum_link',
						'next_posts_link_attributes'				 => 'next_posts_link_attributes',
						'previous_posts_link_attributes'			 => 'previous_posts_link_attributes',
						'navigation_markup_template'				 => 'navigation_markup_template',
						'get_comments_pagenum_link'					 => 'get_comments_pagenum_link',
						'next_comments_link_attributes'				 => 'next_comments_link_attributes',
						'previous_comments_link_attributes'			 => 'previous_comments_link_attributes',
						'home_url'									 => 'home_url',
						'site_url'									 => 'site_url',
						'admin_url'									 => 'admin_url',
						'includes_url'								 => 'includes_url',
						'content_url'								 => 'content_url',
						'plugins_url'								 => 'plugins_url',
						'network_site_url'							 => 'network_site_url',
						'network_home_url'							 => 'network_home_url',
						'network_admin_url'							 => 'network_admin_url',
						'user_admin_url'							 => 'user_admin_url',
						'self_admin_url'							 => 'self_admin_url',
						'set_url_scheme'							 => 'set_url_scheme',
						'user_dashboard_url'						 => 'user_dashboard_url',
						'edit_profile_url'							 => 'edit_profile_url',
						'get_canonical_url'							 => 'get_canonical_url',
						'pre_get_shortlink'							 => 'pre_get_shortlink',
						'get_shortlink'								 => 'get_shortlink',
						'the_shortlink'								 => 'the_shortlink',
						'pre_get_avatar_data'						 => 'pre_get_avatar_data',
						'get_avatar_comment_types'					 => 'get_avatar_comment_types',
						'get_avatar_url'							 => 'get_avatar_url',
						'theme_file_uri'							 => 'theme_file_uri',
						'parent_theme_file_uri'						 => 'parent_theme_file_uri',
						'theme_file_path'							 => 'theme_file_path',
						'parent_theme_file_path'					 => 'parent_theme_file_path',
						'privacy_policy_url'						 => 'privacy_policy_url',
						'the_privacy_policy_link'					 => 'the_privacy_policy_link',
						'date_i18n'									 => 'date_i18n',
						'number_format_i18n'						 => 'number_format_i18n',
						'enclosure_links'							 => 'enclosure_links',
						'removable_query_args'						 => 'removable_query_args',
						'status_header'								 => 'status_header',
						'nocache_headers'							 => 'nocache_headers',
						'robots_txt'								 => 'robots_txt',
						'upload_dir'								 => 'upload_dir',
						'wp_unique_filename'						 => 'wp_unique_filename',
						'wp_upload_bits'							 => 'wp_upload_bits',
						'wp_check_filetype_and_ext'					 => 'wp_check_filetype_and_ext',
						'upload_mimes'								 => 'upload_mimes',
						'wp_die_ajax_handler'						 => 'wp_die_ajax_handler',
						'wp_die_xmlrpc_handler'						 => 'wp_die_xmlrpc_handler',
						'wp_die_handler'							 => 'wp_die_handler',
						'smilies'									 => 'smilies',
						'iis7_supports_permalinks'					 => 'iis7_supports_permalinks',
						'get_main_network_id'						 => 'get_main_network_id',
						'global_terms_enabled'						 => 'global_terms_enabled',
						'kses_allowed_protocols'					 => 'kses_allowed_protocols',
						'wp_checkdate'								 => 'wp_checkdate',
						'wp_auth_check_same_domain'					 => 'wp_auth_check_same_domain',
						'wp_delete_file'							 => 'wp_delete_file',
						'admin_memory_limit'						 => 'admin_memory_limit',
						'image_memory_limit'						 => 'image_memory_limit',
						'send_site_admin_email_change_email'		 => 'send_site_admin_email_change_email',
						'site_admin_email_change_email'				 => 'site_admin_email_change_email',
						'wp_privacy_anonymize_data'					 => 'wp_privacy_anonymize_data',
						'wp_privacy_exports_dir'					 => 'wp_privacy_exports_dir',
						'wp_privacy_exports_url'					 => 'wp_privacy_exports_url',
						'wp_privacy_export_expiration'				 => 'wp_privacy_export_expiration',
						'the_content_rss'							 => 'the_content_rss',
						'attachment_icon'							 => 'attachment_icon',
						'attachment_innerHTML'						 => 'attachment_innerHTML',
						'index_rel_link'							 => 'index_rel_link',
						'parent_post_rel_link'						 => 'parent_post_rel_link',
						'richedit_pre'								 => 'richedit_pre',
						'htmledit_pre'								 => 'htmledit_pre',
						'shortcut_link'								 => 'shortcut_link',
						'rest_authentication_errors'				 => 'rest_authentication_errors',
						'rest_send_nocache_headers'					 => 'rest_send_nocache_headers',
						'rest_jsonp_enabled'						 => 'rest_jsonp_enabled',
						'rest_post_dispatch'						 => 'rest_post_dispatch',
						'rest_pre_serve_request'					 => 'rest_pre_serve_request',
						'rest_pre_echo_response'					 => 'rest_pre_echo_response',
						'rest_envelope_response'					 => 'rest_envelope_response',
						'rest_endpoints'							 => 'rest_endpoints',
						'rest_pre_dispatch'							 => 'rest_pre_dispatch',
						'rest_request_before_callbacks'				 => 'rest_request_before_callbacks',
						'rest_dispatch_request'						 => 'rest_dispatch_request',
						'rest_request_after_callbacks'				 => 'rest_request_after_callbacks',
						'rest_index'								 => 'rest_index',
						'rest_namespace_index'						 => 'rest_namespace_index',
						'rest_endpoints_description'				 => 'rest_endpoints_description',
						'rest_route_data'							 => 'rest_route_data',
						'rest_request_parameter_order'				 => 'rest_request_parameter_order',
						'rest_request_from_url'						 => 'rest_request_from_url',
						'rest_comment_query'						 => 'rest_comment_query',
						'rest_allow_anonymous_comments'				 => 'rest_allow_anonymous_comments',
						'rest_pre_insert_comment'					 => 'rest_pre_insert_comment',
						'rest_comment_trashable'					 => 'rest_comment_trashable',
						'rest_prepare_comment'						 => 'rest_prepare_comment',
						'rest_preprocess_comment'					 => 'rest_preprocess_comment',
						'rest_comment_collection_params'			 => 'rest_comment_collection_params',
						'rest_prepare_attachment'					 => 'rest_prepare_attachment',
						'rest_prepare_revision'						 => 'rest_prepare_revision',
						'rest_user_query'							 => 'rest_user_query',
						'rest_prepare_user'							 => 'rest_prepare_user',
						'rest_pre_insert_user'						 => 'rest_pre_insert_user',
						'rest_user_collection_params'				 => 'rest_user_collection_params',
						'rest_pre_get_setting'						 => 'rest_pre_get_setting',
						'rest_pre_update_setting'					 => 'rest_pre_update_setting',
						'rest_prepare_status'						 => 'rest_prepare_status',
						'rest_prepare_taxonomy'						 => 'rest_prepare_taxonomy',
						'rest_prepare_post_type'					 => 'rest_prepare_post_type',
						'rest_response_link_curies'					 => 'rest_response_link_curies',
						'secure_signon_cookie'						 => 'secure_signon_cookie',
						'wp_authenticate_user'						 => 'wp_authenticate_user',
						'check_is_user_spammed'						 => 'check_is_user_spammed',
						'get_usernumposts'							 => 'get_usernumposts',
						'pre_get_blogs_of_user'						 => 'pre_get_blogs_of_user',
						'get_blogs_of_user'							 => 'get_blogs_of_user',
						'wp_dropdown_users_args'					 => 'wp_dropdown_users_args',
						'wp_dropdown_users'							 => 'wp_dropdown_users',
						'username_exists'							 => 'username_exists',
						'validate_username'							 => 'validate_username',
						'pre_user_login'							 => 'pre_user_login',
						'illegal_user_logins'						 => 'illegal_user_logins',
						'pre_user_nicename'							 => 'pre_user_nicename',
						'pre_user_url'								 => 'pre_user_url',
						'pre_user_email'							 => 'pre_user_email',
						'pre_user_nickname'							 => 'pre_user_nickname',
						'pre_user_first_name'						 => 'pre_user_first_name',
						'pre_user_last_name'						 => 'pre_user_last_name',
						'pre_user_display_name'						 => 'pre_user_display_name',
						'pre_user_description'						 => 'pre_user_description',
						'wp_pre_insert_user_data'					 => 'wp_pre_insert_user_data',
						'insert_user_meta'							 => 'insert_user_meta',
						'send_password_change_email'				 => 'send_password_change_email',
						'send_email_change_email'					 => 'send_email_change_email',
						'password_change_email'						 => 'password_change_email',
						'email_change_email'						 => 'email_change_email',
						'user_contactmethods'						 => 'user_contactmethods',
						'password_hint'								 => 'password_hint',
						'allow_password_reset'						 => 'allow_password_reset',
						'password_reset_expiration'					 => 'password_reset_expiration',
						'password_reset_key_expired'				 => 'password_reset_key_expired',
						'user_registration_email'					 => 'user_registration_email',
						'registration_errors'						 => 'registration_errors',
						'determine_current_user'					 => 'determine_current_user',
						'new_user_email_content'					 => 'new_user_email_content',
						'user_request_confirmed_email_to'			 => 'user_request_confirmed_email_to',
						'user_confirmed_action_email_content'		 => 'user_confirmed_action_email_content',
						'user_request_confirmed_email_subject'		 => 'user_request_confirmed_email_subject',
						'user_erasure_fulfillment_email_to'			 => 'user_erasure_fulfillment_email_to',
						'user_erasure_complete_email_subject'		 => 'user_erasure_complete_email_subject',
						'user_request_action_confirmed_message'		 => 'user_request_action_confirmed_message',
						'user_request_action_description'			 => 'user_request_action_description',
						'user_request_action_email_content'			 => 'user_request_action_email_content',
						'user_request_action_email_subject'			 => 'user_request_action_email_subject',
						'user_request_key_expiration'				 => 'user_request_key_expiration',
						'get_terms_defaults'						 => 'get_terms_defaults',
						'get_terms_args'							 => 'get_terms_args',
						'list_terms_exclusions'						 => 'list_terms_exclusions',
						'get_terms_fields'							 => 'get_terms_fields',
						'terms_clauses'								 => 'terms_clauses',
						'get_terms_orderby'							 => 'get_terms_orderby',
						'list_pages'								 => 'list_pages',
						'register_taxonomy_args'					 => 'register_taxonomy_args',
						'get_categories_taxonomy'					 => 'get_categories_taxonomy',
						'get_tags'									 => 'get_tags',
						'the_comments'								 => 'the_comments',
						'comments_clauses'							 => 'comments_clauses',
						'found_comments_query'						 => 'found_comments_query',
						'get_the_categories'						 => 'get_the_categories',
						'the_category_list'							 => 'the_category_list',
						'the_category'								 => 'the_category',
						'list_cats'									 => 'list_cats',
						'wp_dropdown_cats'							 => 'wp_dropdown_cats',
						'wp_list_categories'						 => 'wp_list_categories',
						'wp_tag_cloud'								 => 'wp_tag_cloud',
						'tag_cloud_sort'							 => 'tag_cloud_sort',
						'wp_generate_tag_cloud_data'				 => 'wp_generate_tag_cloud_data',
						'wp_generate_tag_cloud'						 => 'wp_generate_tag_cloud',
						'get_the_tags'								 => 'get_the_tags',
						'the_tags'									 => 'the_tags',
						'get_the_terms'								 => 'get_the_terms',
						'the_terms'									 => 'the_terms',
						'pre_get_main_site_id'						 => 'pre_get_main_site_id',
						'network_by_path_segments_count'			 => 'network_by_path_segments_count',
						'pre_get_network_by_path'					 => 'pre_get_network_by_path',
						'_deprecated blog_details'					 => '_deprecated blog_details',
						'get_site'									 => 'get_site',
						'get_network'								 => 'get_network',
						'pre_http_send_through_proxy'				 => 'pre_http_send_through_proxy',
						'customize_partial_render'					 => 'customize_partial_render',
						'customize_dynamic_partial_args'			 => 'customize_dynamic_partial_args',
						'customize_dynamic_partial_class'			 => 'customize_dynamic_partial_class',
						'customize_render_partials_response'		 => 'customize_render_partials_response',
						'wp_query_search_exclusion_prefix'			 => 'wp_query_search_exclusion_prefix',
						'wp_search_stopwords'						 => 'wp_search_stopwords',
						'posts_search'								 => 'posts_search',
						'posts_search_orderby'						 => 'posts_search_orderby',
						'posts_where'								 => 'posts_where',
						'posts_join'								 => 'posts_join',
						'comment_feed_join'							 => 'comment_feed_join',
						'comment_feed_where'						 => 'comment_feed_where',
						'comment_feed_groupby'						 => 'comment_feed_groupby',
						'comment_feed_orderby'						 => 'comment_feed_orderby',
						'comment_feed_limits'						 => 'comment_feed_limits',
						'posts_where_paged'							 => 'posts_where_paged',
						'posts_groupby'								 => 'posts_groupby',
						'posts_join_paged'							 => 'posts_join_paged',
						'posts_orderby'								 => 'posts_orderby',
						'posts_distinct'							 => 'posts_distinct',
						'post_limits'								 => 'post_limits',
						'posts_fields'								 => 'posts_fields',
						'posts_clauses'								 => 'posts_clauses',
						'posts_where_request'						 => 'posts_where_request',
						'posts_groupby_request'						 => 'posts_groupby_request',
						'posts_join_request'						 => 'posts_join_request',
						'posts_orderby_request'						 => 'posts_orderby_request',
						'posts_distinct_request'					 => 'posts_distinct_request',
						'posts_fields_request'						 => 'posts_fields_request',
						'post_limits_request'						 => 'post_limits_request',
						'posts_clauses_request'						 => 'posts_clauses_request',
						'posts_request'								 => 'posts_request',
						'posts_pre_query'							 => 'posts_pre_query',
						'split_the_query'							 => 'split_the_query',
						'posts_request_ids'							 => 'posts_request_ids',
						'posts_results'								 => 'posts_results',
						'the_preview'								 => 'the_preview',
						'the_posts'									 => 'the_posts',
						'found_posts_query'							 => 'found_posts_query',
						'found_posts'								 => 'found_posts',
						'content_pagination'						 => 'content_pagination',
						'embed_handler_html'						 => 'embed_handler_html',
						'oembed_ttl'								 => 'oembed_ttl',
						'embed_oembed_html'							 => 'embed_oembed_html',
						'embed_oembed_discover'						 => 'embed_oembed_discover',
						'embed_maybe_make_link'						 => 'embed_maybe_make_link',
						'is_protected_meta'							 => 'is_protected_meta',
						'register_meta_args'						 => 'register_meta_args',
						'customizer_widgets_section_args'			 => 'customizer_widgets_section_args',
						'is_wide_widget_in_customizer'				 => 'is_wide_widget_in_customizer',
						'widget_customizer_setting_args'			 => 'widget_customizer_setting_args',
						'search_form_format'						 => 'search_form_format',
						'get_search_form'							 => 'get_search_form',
						'loginout'									 => 'loginout',
						'logout_url'								 => 'logout_url',
						'login_url'									 => 'login_url',
						'register_url'								 => 'register_url',
						'login_form_defaults'						 => 'login_form_defaults',
						'login_form_top'							 => 'login_form_top',
						'login_form_middle'							 => 'login_form_middle',
						'login_form_bottom'							 => 'login_form_bottom',
						'lostpassword_url'							 => 'lostpassword_url',
						'register'									 => 'register',
						'bloginfo_url'								 => 'bloginfo_url',
						'bloginfo'									 => 'bloginfo',
						'get_site_icon_url'							 => 'get_site_icon_url',
						'get_custom_logo'							 => 'get_custom_logo',
						'pre_get_document_title'					 => 'pre_get_document_title',
						'document_title_separator'					 => 'document_title_separator',
						'document_title_parts'						 => 'document_title_parts',
						'wp_title_parts'							 => 'wp_title_parts',
						'wp_title'									 => 'wp_title',
						'single_post_title'							 => 'single_post_title',
						'post_type_archive_title'					 => 'post_type_archive_title',
						'single_cat_title'							 => 'single_cat_title',
						'single_tag_title'							 => 'single_tag_title',
						'single_term_title'							 => 'single_term_title',
						'get_the_archive_title'						 => 'get_the_archive_title',
						'get_the_archive_description'				 => 'get_the_archive_description',
						'get_the_post_type_description'				 => 'get_the_post_type_description',
						'get_archives_link'							 => 'get_archives_link',
						'getarchives_where'							 => 'getarchives_where',
						'getarchives_join'							 => 'getarchives_join',
						'get_calendar'								 => 'get_calendar',
						'the_date'									 => 'the_date',
						'get_the_date'								 => 'get_the_date',
						'the_modified_date'							 => 'the_modified_date',
						'get_the_modified_date'						 => 'get_the_modified_date',
						'the_time'									 => 'the_time',
						'get_the_time'								 => 'get_the_time',
						'get_post_time'								 => 'get_post_time',
						'the_modified_time'							 => 'the_modified_time',
						'get_the_modified_time'						 => 'get_the_modified_time',
						'get_post_modified_time'					 => 'get_post_modified_time',
						'the_weekday'								 => 'the_weekday',
						'the_weekday_date'							 => 'the_weekday_date',
						'site_icon_meta_tags'						 => 'site_icon_meta_tags',
						'wp_resource_hints'							 => 'wp_resource_hints',
						'user_can_richedit'							 => 'user_can_richedit',
						'wp_default_editor'							 => 'wp_default_editor',
						'wp_code_editor_settings'					 => 'wp_code_editor_settings',
						'get_search_query'							 => 'get_search_query',
						'the_search_query'							 => 'the_search_query',
						'language_attributes'						 => 'language_attributes',
						'paginate_links'							 => 'paginate_links',
						'wp_admin_css_uri'							 => 'wp_admin_css_uri',
						'wp_admin_css'								 => 'wp_admin_css',
						'wp_generator_type'							 => 'wp_generator_type',
						'the_generator'								 => 'the_generator',
						'redirect_canonical'						 => 'redirect_canonical',
						'role_has_cap'								 => 'role_has_cap',
						'theme_templates'							 => 'theme_templates',
						'theme_scandir_exclusions'					 => 'theme_scandir_exclusions',
						'network_allowed_themes'					 => 'network_allowed_themes',
						'allowed_themes'							 => 'allowed_themes',
						'site_allowed_themes'						 => 'site_allowed_themes',
						'wp_http_accept_encoding'					 => 'wp_http_accept_encoding',
						'incompatible_sql_modes'					 => 'incompatible_sql_modes',
						'query'										 => 'query',
						'pre_get_table_charset'						 => 'pre_get_table_charset',
						'pre_get_col_charset'						 => 'pre_get_col_charset',
						'stylesheet'								 => 'stylesheet',
						'stylesheet_directory'						 => 'stylesheet_directory',
						'stylesheet_directory_uri'					 => 'stylesheet_directory_uri',
						'stylesheet_uri'							 => 'stylesheet_uri',
						'locale_stylesheet_uri'						 => 'locale_stylesheet_uri',
						'template'									 => 'template',
						'template_directory'						 => 'template_directory',
						'template_directory_uri'					 => 'template_directory_uri',
						'theme_root'								 => 'theme_root',
						'theme_root_uri'							 => 'theme_root_uri',
						'get_header_image_tag'						 => 'get_header_image_tag',
						'get_header_video_url'						 => 'get_header_video_url',
						'header_video_settings'						 => 'header_video_settings',
						'is_header_video_active'					 => 'is_header_video_active',
						'wp_get_custom_css'							 => 'wp_get_custom_css',
						'update_custom_css_data'					 => 'update_custom_css_data',
						'editor_stylesheets'						 => 'editor_stylesheets',
						'get_theme_starter_content'					 => 'get_theme_starter_content',
						'rss_update_period'							 => 'rss_update_period',
						'rss_update_frequency'						 => 'rss_update_frequency',
						'pre_cache_alloptions'						 => 'pre_cache_alloptions',
						'alloptions'								 => 'alloptions',
						'pre_update_option'							 => 'pre_update_option',
						'register_setting_args'						 => 'register_setting_args',
						'post_thumbnail_size'						 => 'post_thumbnail_size',
						'post_thumbnail_html'						 => 'post_thumbnail_html',
						'the_post_thumbnail_caption'				 => 'the_post_thumbnail_caption',
						'category_description'						 => 'category_description',
						'category_css_class'						 => 'category_css_class',
						'map_meta_cap'								 => 'map_meta_cap',
						'editor_max_image_size'						 => 'editor_max_image_size',
						'get_image_tag_class'						 => 'get_image_tag_class',
						'get_image_tag'								 => 'get_image_tag',
						'wp_constrain_dimensions'					 => 'wp_constrain_dimensions',
						'image_resize_dimensions'					 => 'image_resize_dimensions',
						'image_get_intermediate_size'				 => 'image_get_intermediate_size',
						'intermediate_image_sizes'					 => 'intermediate_image_sizes',
						'wp_get_attachment_image_src'				 => 'wp_get_attachment_image_src',
						'wp_get_attachment_image_attributes'		 => 'wp_get_attachment_image_attributes',
						'wp_calculate_image_srcset_meta'			 => 'wp_calculate_image_srcset_meta',
						'max_srcset_image_width'					 => 'max_srcset_image_width',
						'wp_calculate_image_srcset'					 => 'wp_calculate_image_srcset',
						'wp_calculate_image_sizes'					 => 'wp_calculate_image_sizes',
						'img_caption_shortcode'						 => 'img_caption_shortcode',
						'img_caption_shortcode_width'				 => 'img_caption_shortcode_width',
						'post_gallery'								 => 'post_gallery',
						'gallery_style'								 => 'gallery_style',
						'post_playlist'								 => 'post_playlist',
						'wp_mediaelement_fallback'					 => 'wp_mediaelement_fallback',
						'wp_audio_extensions'						 => 'wp_audio_extensions',
						'wp_get_attachment_id3_keys'				 => 'wp_get_attachment_id3_keys',
						'wp_audio_shortcode_override'				 => 'wp_audio_shortcode_override',
						'wp_audio_shortcode_library'				 => 'wp_audio_shortcode_library',
						'wp_audio_shortcode_class'					 => 'wp_audio_shortcode_class',
						'wp_audio_shortcode'						 => 'wp_audio_shortcode',
						'wp_video_extensions'						 => 'wp_video_extensions',
						'wp_video_shortcode_override'				 => 'wp_video_shortcode_override',
						'wp_video_shortcode_library'				 => 'wp_video_shortcode_library',
						'wp_video_shortcode_class'					 => 'wp_video_shortcode_class',
						'wp_video_shortcode'						 => 'wp_video_shortcode',
						'upload_size_limit'							 => 'upload_size_limit',
						'wp_image_editors'							 => 'wp_image_editors',
						'plupload_default_settings'					 => 'plupload_default_settings',
						'plupload_default_params'					 => 'plupload_default_params',
						'wp_prepare_attachment_for_js'				 => 'wp_prepare_attachment_for_js',
						'media_library_show_audio_playlist'			 => 'media_library_show_audio_playlist',
						'media_library_show_video_playlist'			 => 'media_library_show_video_playlist',
						'media_library_months_with_files'			 => 'media_library_months_with_files',
						'media_view_settings'						 => 'media_view_settings',
						'media_view_strings'						 => 'media_view_strings',
						'get_attached_media_args'					 => 'get_attached_media_args',
						'get_attached_media'						 => 'get_attached_media',
						'media_embedded_in_content_allowed_types'	 => 'media_embedded_in_content_allowed_types',
						'get_post_galleries'						 => 'get_post_galleries',
						'get_post_gallery'							 => 'get_post_gallery',
						'attachment_url_to_postid'					 => 'attachment_url_to_postid',
						'site_details'								 => 'site_details',
						'page_css_class'							 => 'page_css_class',
						'page_menu_link_attributes'					 => 'page_menu_link_attributes',
						'xmlrpc_methods'							 => 'xmlrpc_methods',
						'pre_option_enable_xmlrpc'					 => 'pre_option_enable_xmlrpc',
						'option_enable_xmlrpc'						 => 'option_enable_xmlrpc',
						'xmlrpc_enabled'							 => 'xmlrpc_enabled',
						'xmlrpc_login_error'						 => 'xmlrpc_login_error',
						'xmlrpc_blog_options'						 => 'xmlrpc_blog_options',
						'xmlrpc_prepare_taxonomy'					 => 'xmlrpc_prepare_taxonomy',
						'xmlrpc_prepare_term'						 => 'xmlrpc_prepare_term',
						'xmlrpc_prepare_post'						 => 'xmlrpc_prepare_post',
						'xmlrpc_prepare_post_type'					 => 'xmlrpc_prepare_post_type',
						'xmlrpc_prepare_media_item'					 => 'xmlrpc_prepare_media_item',
						'xmlrpc_prepare_page'						 => 'xmlrpc_prepare_page',
						'xmlrpc_prepare_comment'					 => 'xmlrpc_prepare_comment',
						'xmlrpc_prepare_user'						 => 'xmlrpc_prepare_user',
						'xmlrpc_wp_insert_post_data'				 => 'xmlrpc_wp_insert_post_data',
						'xmlrpc_default_post_fields'				 => 'xmlrpc_default_post_fields',
						'xmlrpc_default_taxonomy_fields'			 => 'xmlrpc_default_taxonomy_fields',
						'xmlrpc_default_user_fields'				 => 'xmlrpc_default_user_fields',
						'xmlrpc_allow_anonymous_comments'			 => 'xmlrpc_allow_anonymous_comments',
						'xmlrpc_default_posttype_fields'			 => 'xmlrpc_default_posttype_fields',
						'xmlrpc_default_revision_fields'			 => 'xmlrpc_default_revision_fields',
						'xmlrpc_text_filters'						 => 'xmlrpc_text_filters',
						'pingback_ping_source_uri'					 => 'pingback_ping_source_uri',
						'pre_remote_source'							 => 'pre_remote_source',
						'xmlrpc_pingback_error'						 => 'xmlrpc_pingback_error',
						'url_to_postid'								 => 'url_to_postid',
						'wp_editor_set_quality'						 => 'wp_editor_set_quality',
						'jpeg_quality'								 => 'jpeg_quality',
						'image_editor_default_mime_type'			 => 'image_editor_default_mime_type',
						'post_format_rewrite_base'					 => 'post_format_rewrite_base',
						'get_term'									 => 'get_term',
						'get_terms'									 => 'get_terms',
						'pre_category_nicename'						 => 'pre_category_nicename',
						'wp_get_object_terms_args'					 => 'wp_get_object_terms_args',
						'get_object_terms'							 => 'get_object_terms',
						'wp_get_object_terms'						 => 'wp_get_object_terms',
						'pre_insert_term'							 => 'pre_insert_term',
						'wp_insert_term_data'						 => 'wp_insert_term_data',
						'term_id_filter'							 => 'term_id_filter',
						'wp_unique_term_slug'						 => 'wp_unique_term_slug',
						'wp_update_term_parent'						 => 'wp_update_term_parent',
						'wp_update_term_data'						 => 'wp_update_term_data',
						'pre_term_link'								 => 'pre_term_link',
						'tag_link'									 => 'tag_link',
						'category_link'								 => 'category_link',
						'term_link'									 => 'term_link',
						'https_local_ssl_verify'					 => 'https_local_ssl_verify',
						'https_ssl_verify'							 => 'https_ssl_verify',
						'use_streams_transport'						 => 'use_streams_transport',
						'embed_defaults'							 => 'embed_defaults',
						'wp_audio_embed_handler'					 => 'wp_audio_embed_handler',
						'wp_video_embed_handler'					 => 'wp_video_embed_handler',
						'wp_embed_handler_youtube'					 => 'wp_embed_handler_youtube',
						'wp_embed_handler_audio'					 => 'wp_embed_handler_audio',
						'wp_embed_handler_video'					 => 'wp_embed_handler_video',
						'oembed_discovery_links'					 => 'oembed_discovery_links',
						'post_embed_url'							 => 'post_embed_url',
						'oembed_endpoint_url'						 => 'oembed_endpoint_url',
						'embed_html'								 => 'embed_html',
						'oembed_response_data'						 => 'oembed_response_data',
						'the_excerpt_embed'							 => 'the_excerpt_embed',
						'embed_site_title_html'						 => 'embed_site_title_html',
						'xmlrpc_element_limit'						 => 'xmlrpc_element_limit',
						'xmlrpc_chunk_parsing_size'					 => 'xmlrpc_chunk_parsing_size',
						'embed_thumbnail_id'						 => 'embed_thumbnail_id',
						'embed_thumbnail_image_size'				 => 'embed_thumbnail_image_size',
						'embed_thumbnail_image_shape'				 => 'embed_thumbnail_image_shape',
						'http_headers_useragent'					 => 'http_headers_useragent',
						'http_request_args'							 => 'http_request_args',
						'pre_http_request'							 => 'pre_http_request',
						'http_response'								 => 'http_response',
						'http_api_transports'						 => 'http_api_transports',
						'block_local_requests'						 => 'block_local_requests',
						'schedule_event'							 => 'schedule_event',
						'cron_schedules'							 => 'cron_schedules',
						'run_wptexturize'							 => 'run_wptexturize',
						'no_texturize_tags'							 => 'no_texturize_tags',
						'no_texturize_shortcodes'					 => 'no_texturize_shortcodes',
						'sanitize_file_name_chars'					 => 'sanitize_file_name_chars',
						'sanitize_file_name'						 => 'sanitize_file_name',
						'sanitize_user'								 => 'sanitize_user',
						'sanitize_key'								 => 'sanitize_key',
						'sanitize_title'							 => 'sanitize_title',
						'sanitize_html_class'						 => 'sanitize_html_class',
						'format_to_edit'							 => 'format_to_edit',
						'smilies_src'								 => 'smilies_src',
						'is_email'									 => 'is_email',
						'sanitize_email'							 => 'sanitize_email',
						'human_time_diff'							 => 'human_time_diff',
						'excerpt_length'							 => 'excerpt_length',
						'excerpt_more'								 => 'excerpt_more',
						'wp_trim_excerpt'							 => 'wp_trim_excerpt',
						'wp_trim_words'								 => 'wp_trim_words',
						'pre_ent2ncr'								 => 'pre_ent2ncr',
						'format_for_editor'							 => 'format_for_editor',
						'clean_url'									 => 'clean_url',
						'js_escape'									 => 'js_escape',
						'esc_html'									 => 'esc_html',
						'attribute_escape'							 => 'attribute_escape',
						'esc_textarea'								 => 'esc_textarea',
						'tag_escape'								 => 'tag_escape',
						'wp_parse_str'								 => 'wp_parse_str',
						'wp_sprintf'								 => 'wp_sprintf',
						'sanitize_text_field'						 => 'sanitize_text_field',
						'sanitize_textarea_field'					 => 'sanitize_textarea_field',
						'sanitize_mime_type'						 => 'sanitize_mime_type',
						'sanitize_trackback_urls'					 => 'sanitize_trackback_urls',
						'wp_spaces_regexp'							 => 'wp_spaces_regexp',
						'process_text_diff_html'					 => 'process_text_diff_html',
						'user_search_columns'						 => 'user_search_columns',
						'found_users_query'							 => 'found_users_query',
						'wp_get_nav_menu_object'					 => 'wp_get_nav_menu_object',
						'has_nav_menu'								 => 'has_nav_menu',
						'wp_get_nav_menu_name'						 => 'wp_get_nav_menu_name',
						'wp_get_nav_menus'							 => 'wp_get_nav_menus',
						'wp_get_nav_menu_items'						 => 'wp_get_nav_menu_items',
						'nav_menu_attr_title'						 => 'nav_menu_attr_title',
						'nav_menu_description'						 => 'nav_menu_description',
						'wp_setup_nav_menu_item'					 => 'wp_setup_nav_menu_item',
						'_wp_post_revision_fields'					 => '_wp_post_revision_fields',
						'wp_save_post_revision_post_has_changed'	 => 'wp_save_post_revision_post_has_changed',
						'wp_revisions_to_keep'						 => 'wp_revisions_to_keep',
						'ms_site_check'								 => 'ms_site_check',
						'site_by_path_segments_count'				 => 'site_by_path_segments_count',
						'pre_get_site_by_path'						 => 'pre_get_site_by_path',
						'the_author'								 => 'the_author',
						'the_modified_author'						 => 'the_modified_author',
						'the_author_posts_link'						 => 'the_author_posts_link',
						'author_link'								 => 'author_link',
						'is_multi_author'							 => 'is_multi_author',
						'get_comment_author'						 => 'get_comment_author',
						'comment_author'							 => 'comment_author',
						'get_comment_author_email'					 => 'get_comment_author_email',
						'author_email'								 => 'author_email',
						'comment_email'								 => 'comment_email',
						'get_comment_author_link'					 => 'get_comment_author_link',
						'get_comment_author_IP'						 => 'get_comment_author_IP',
						'get_comment_author_url'					 => 'get_comment_author_url',
						'comment_url'								 => 'comment_url',
						'get_comment_author_url_link'				 => 'get_comment_author_url_link',
						'comment_class'								 => 'comment_class',
						'get_comment_date'							 => 'get_comment_date',
						'comment_excerpt_length'					 => 'comment_excerpt_length',
						'get_comment_excerpt'						 => 'get_comment_excerpt',
						'comment_excerpt'							 => 'comment_excerpt',
						'get_comment_ID'							 => 'get_comment_ID',
						'get_comment_link'							 => 'get_comment_link',
						'get_comments_link'							 => 'get_comments_link',
						'get_comments_number'						 => 'get_comments_number',
						'comments_number'							 => 'comments_number',
						'get_comment_text'							 => 'get_comment_text',
						'comment_text'								 => 'comment_text',
						'get_comment_time'							 => 'get_comment_time',
						'get_comment_type'							 => 'get_comment_type',
						'trackback_url'								 => 'trackback_url',
						'comments_open'								 => 'comments_open',
						'pings_open'								 => 'pings_open',
						'comments_template_query_args'				 => 'comments_template_query_args',
						'comments_array'							 => 'comments_array',
						'comments_template'							 => 'comments_template',
						'respond_link'								 => 'respond_link',
						'comments_popup_link_attributes'			 => 'comments_popup_link_attributes',
						'comment_reply_link_args'					 => 'comment_reply_link_args',
						'comment_reply_link'						 => 'comment_reply_link',
						'post_comments_link'						 => 'post_comments_link',
						'cancel_comment_reply_link'					 => 'cancel_comment_reply_link',
						'comment_id_fields'							 => 'comment_id_fields',
						'wp_list_comments_args'						 => 'wp_list_comments_args',
						'comment_form_default_fields'				 => 'comment_form_default_fields',
						'comment_form_defaults'						 => 'comment_form_defaults',
						'comment_form_logged_in'					 => 'comment_form_logged_in',
						'comment_form_fields'						 => 'comment_form_fields',
						'comment_form_field_comment'				 => 'comment_form_field_comment',
						'comment_form_submit_button'				 => 'comment_form_submit_button',
						'comment_form_submit_field'					 => 'comment_form_submit_field',
						'get_bookmarks'								 => 'get_bookmarks',
						'dynamic_sidebar_params'					 => 'dynamic_sidebar_params',
						'dynamic_sidebar_has_widgets'				 => 'dynamic_sidebar_has_widgets',
						'is_active_sidebar'							 => 'is_active_sidebar',
						'sidebars_widgets'							 => 'sidebars_widgets',
						'customize_control_active'					 => 'customize_control_active',
						'locale'									 => 'locale',
						'gettext'									 => 'gettext',
						'gettext_with_context'						 => 'gettext_with_context',
						'ngettext'									 => 'ngettext',
						'ngettext_with_context'						 => 'ngettext_with_context',
						'override_load_textdomain'					 => 'override_load_textdomain',
						'load_textdomain_mofile'					 => 'load_textdomain_mofile',
						'override_unload_textdomain'				 => 'override_unload_textdomain',
						'plugin_locale'								 => 'plugin_locale',
						'theme_locale'								 => 'theme_locale',
						'get_available_languages'					 => 'get_available_languages',
						'the_networks'								 => 'the_networks',
						'networks_clauses'							 => 'networks_clauses',
						'found_networks_query'						 => 'found_networks_query',
						'query_vars'								 => 'query_vars',
						'request'									 => 'request',
						'wp_headers'								 => 'wp_headers',
						'query_string'								 => 'query_string',
						'widget_categories_dropdown_args'			 => 'widget_categories_dropdown_args',
						'widget_categories_args'					 => 'widget_categories_args',
						'widget_title'								 => 'widget_title',
						'widget_links_args'							 => 'widget_links_args',
						'widget_nav_menu_args'						 => 'widget_nav_menu_args',
						'widget_text'								 => 'widget_text',
						'widget_text_content'						 => 'widget_text_content',
						'widget_custom_html_content'				 => 'widget_custom_html_content',
						'comment_max_links_url'						 => 'comment_max_links_url',
						'get_comment'								 => 'get_comment',
						'get_default_comment_status'				 => 'get_default_comment_status',
						'comment_cookie_lifetime'					 => 'comment_cookie_lifetime',
						'pre_comment_author_name'					 => 'pre_comment_author_name',
						'pre_comment_author_email'					 => 'pre_comment_author_email',
						'pre_comment_author_url'					 => 'pre_comment_author_url',
						'duplicate_comment_id'						 => 'duplicate_comment_id',
						'pre_comment_approved'						 => 'pre_comment_approved',
						'comment_flood_filter'						 => 'comment_flood_filter',
						'get_page_of_comment'						 => 'get_page_of_comment',
						'wp_get_comment_fields_max_lengths'			 => 'wp_get_comment_fields_max_lengths',
						'wp_count_comments'							 => 'wp_count_comments',
						'wp_get_current_commenter'					 => 'wp_get_current_commenter',
						'pre_user_id'								 => 'pre_user_id',
						'pre_comment_user_agent'					 => 'pre_comment_user_agent',
						'pre_comment_content'						 => 'pre_comment_content',
						'pre_comment_user_ip'						 => 'pre_comment_user_ip',
						'preprocess_comment'						 => 'preprocess_comment',
						'notify_post_author'						 => 'notify_post_author',
						'comment_save_pre'							 => 'comment_save_pre',
						'wp_update_comment_data'					 => 'wp_update_comment_data',
						'pre_wp_update_comment_count_now'			 => 'pre_wp_update_comment_count_now',
						'pingback_useragent'						 => 'pingback_useragent',
						'close_comments_for_post_types'				 => 'close_comments_for_post_types',
						'wp_anonymize_comment'						 => 'wp_anonymize_comment',
						'customize_nav_menu_available_items'		 => 'customize_nav_menu_available_items',
						'customize_nav_menu_searched_items'			 => 'customize_nav_menu_searched_items',
						'customize_nav_menu_available_item_types'	 => 'customize_nav_menu_available_item_types',
						'wp_nav_menu_args'							 => 'wp_nav_menu_args',
						'pre_wp_nav_menu'							 => 'pre_wp_nav_menu',
						'wp_nav_menu_container_allowedtags'			 => 'wp_nav_menu_container_allowedtags',
						'wp_nav_menu_objects'						 => 'wp_nav_menu_objects',
						'wp_nav_menu_items'							 => 'wp_nav_menu_items',
						'wp_nav_menu'								 => 'wp_nav_menu',
						'nav_menu_submenu_css_class'				 => 'nav_menu_submenu_css_class',
						'nav_menu_item_args'						 => 'nav_menu_item_args',
						'nav_menu_css_class'						 => 'nav_menu_css_class',
						'nav_menu_item_id'							 => 'nav_menu_item_id',
						'nav_menu_link_attributes'					 => 'nav_menu_link_attributes',
						'nav_menu_item_title'						 => 'nav_menu_item_title',
						'walker_nav_menu_start_el'					 => 'walker_nav_menu_start_el',
						'get_meta_sql'								 => 'get_meta_sql',
						'meta_query_find_compatible_table_alias'	 => 'meta_query_find_compatible_table_alias',
						'widget_display_callback'					 => 'widget_display_callback',
						'widget_update_callback'					 => 'widget_update_callback',
						'widget_form_callback'						 => 'widget_form_callback',
						'wp_xmlrpc_server_class'					 => 'wp_xmlrpc_server_class',
						'comment_post_redirect'						 => 'comment_post_redirect',
						'edit_comment_misc_actions'					 => 'edit_comment_misc_actions',
						'myblogs_options'							 => 'myblogs_options',
						'myblogs_blog_actions'						 => 'myblogs_blog_actions',
						'wp_nav_locations_listed_per_menu'			 => 'wp_nav_locations_listed_per_menu',
						'redirect_term_location'					 => 'redirect_term_location',
						'taxonomy_parent_dropdown_args'				 => 'taxonomy_parent_dropdown_args',
						'whitelist_options'							 => 'whitelist_options',
						'redirect_user_admin_request'				 => 'redirect_user_admin_request',
						'delete_site_email_content'					 => 'delete_site_email_content',
						'admin_title'								 => 'admin_title',
						'admin_body_class'							 => 'admin_body_class',
						'parent_file'								 => 'parent_file',
						'submenu_file'								 => 'submenu_file',
						'export_args'								 => 'export_args',
						'bulk_post_updated_messages'				 => 'bulk_post_updated_messages',
						'user_profile_picture_description'			 => 'user_profile_picture_description',
						'post_updated_messages'						 => 'post_updated_messages',
						'enter_title_here'							 => 'enter_title_here',
						'tables_to_repair'							 => 'tables_to_repair',
						'thread_comments_depth_max'					 => 'thread_comments_depth_max',
						'avatar_defaults'							 => 'avatar_defaults',
						'default_avatar_select'						 => 'default_avatar_select',
						'redirect_network_admin_request'			 => 'redirect_network_admin_request',
						'mu_menu_items'								 => 'mu_menu_items',
						'media_upload_default_type'					 => 'media_upload_default_type',
						'media_upload_default_tab'					 => 'media_upload_default_tab',
						'date_formats'								 => 'date_formats',
						'time_formats'								 => 'time_formats',
						'admin_footer_text'							 => 'admin_footer_text',
						'update_footer'								 => 'update_footer',
						'install_themes_tabs'						 => 'install_themes_tabs',
						'available_permalink_structure_tags'		 => 'available_permalink_structure_tags',
						'editable_slug'								 => 'editable_slug',
						'wp_header_image_attachment_metadata'		 => 'wp_header_image_attachment_metadata',
						'theme_action_links'						 => 'theme_action_links',
						'theme_row_meta'							 => 'theme_row_meta',
						'heartbeat_nopriv_received'					 => 'heartbeat_nopriv_received',
						'heartbeat_nopriv_send'						 => 'heartbeat_nopriv_send',
						'term_search_min_chars'						 => 'term_search_min_chars',
						'wp_check_post_lock_window'					 => 'wp_check_post_lock_window',
						'ajax_query_attachments_args'				 => 'ajax_query_attachments_args',
						'wp_refresh_nonces'							 => 'wp_refresh_nonces',
						'heartbeat_received'						 => 'heartbeat_received',
						'heartbeat_send'							 => 'heartbeat_send',
						'wp_ajax_cropped_attachment_metadata'		 => 'wp_ajax_cropped_attachment_metadata',
						'wp_ajax_cropped_attachment_id'				 => 'wp_ajax_cropped_attachment_id',
						'wp_privacy_personal_data_exporters'		 => 'wp_privacy_personal_data_exporters',
						'wp_privacy_personal_data_export_page'		 => 'wp_privacy_personal_data_export_page',
						'wp_privacy_personal_data_erasers'			 => 'wp_privacy_personal_data_erasers',
						'wp_privacy_personal_data_erasure_page'		 => 'wp_privacy_personal_data_erasure_page',
						'intermediate_image_sizes_advanced'			 => 'intermediate_image_sizes_advanced',
						'attachment_thumbnail_args'					 => 'attachment_thumbnail_args',
						'fallback_intermediate_image_sizes'			 => 'fallback_intermediate_image_sizes',
						'wp_generate_attachment_metadata'			 => 'wp_generate_attachment_metadata',
						'wp_read_image_metadata'					 => 'wp_read_image_metadata',
						'file_is_displayable_image'					 => 'file_is_displayable_image',
						'load_image_to_edit'						 => 'load_image_to_edit',
						'load_image_to_edit_filesystempath'			 => 'load_image_to_edit_filesystempath',
						'load_image_to_edit_attachmenturl'			 => 'load_image_to_edit_attachmenturl',
						'load_image_to_edit_path'					 => 'load_image_to_edit_path',
						'wpmu_users_columns'						 => 'wpmu_users_columns',
						'ms_user_list_site_actions'					 => 'ms_user_list_site_actions',
						'ms_user_row_actions'						 => 'ms_user_row_actions',
						'default_content'							 => 'default_content',
						'default_title'								 => 'default_title',
						'default_excerpt'							 => 'default_excerpt',
						'edit_posts_per_page'						 => 'edit_posts_per_page',
						'upload_per_page'							 => 'upload_per_page',
						'get_sample_permalink'						 => 'get_sample_permalink',
						'get_sample_permalink_html'					 => 'get_sample_permalink_html',
						'admin_post_thumbnail_size'					 => 'admin_post_thumbnail_size',
						'admin_post_thumbnail_html'					 => 'admin_post_thumbnail_html',
						'override_post_lock'						 => 'override_post_lock',
						'redirect_post_location'					 => 'redirect_post_location',
						'default_hidden_columns'					 => 'default_hidden_columns',
						'hidden_columns'							 => 'hidden_columns',
						'default_hidden_meta_boxes'					 => 'default_hidden_meta_boxes',
						'hidden_meta_boxes'							 => 'hidden_meta_boxes',
						'months_dropdown_results'					 => 'months_dropdown_results',
						'list_table_primary_column'					 => 'list_table_primary_column',
						'update_right_now_text'						 => 'update_right_now_text',
						'install_themes_nonmenu_tabs'				 => 'install_themes_nonmenu_tabs',
						'theme_install_actions'						 => 'theme_install_actions',
						'plugin_files_exclusions'					 => 'plugin_files_exclusions',
						'translations_api'							 => 'translations_api',
						'translations_api_result'					 => 'translations_api_result',
						'add_menu_classes'							 => 'add_menu_classes',
						'menu_order'								 => 'menu_order',
						'manage_pages_columns'						 => 'manage_pages_columns',
						'manage_posts_columns'						 => 'manage_posts_columns',
						'post_date_column_status'					 => 'post_date_column_status',
						'post_date_column_time'						 => 'post_date_column_time',
						'page_row_actions'							 => 'page_row_actions',
						'post_row_actions'							 => 'post_row_actions',
						'quick_edit_dropdown_pages_args'			 => 'quick_edit_dropdown_pages_args',
						'all_plugins'								 => 'all_plugins',
						'show_network_active_plugins'				 => 'show_network_active_plugins',
						'network_admin_plugin_action_links'			 => 'network_admin_plugin_action_links',
						'plugin_action_links'						 => 'plugin_action_links',
						'plugin_row_meta'							 => 'plugin_row_meta',
						'install_plugin_complete_actions'			 => 'install_plugin_complete_actions',
						'wp_terms_checklist_args'					 => 'wp_terms_checklist_args',
						'wp_comment_reply'							 => 'wp_comment_reply',
						'postmeta_form_keys'						 => 'postmeta_form_keys',
						'postmeta_form_limit'						 => 'postmeta_form_limit',
						'import_upload_size_limit'					 => 'import_upload_size_limit',
						'display_post_states'						 => 'display_post_states',
						'display_media_states'						 => 'display_media_states',
						'export_wp_filename'						 => 'export_wp_filename',
						'the_content_export'						 => 'the_content_export',
						'the_excerpt_export'						 => 'the_excerpt_export',
						'update_bulk_plugins_complete_actions'		 => 'update_bulk_plugins_complete_actions',
						'get_editable_authors'						 => 'get_editable_authors',
						'get_others_drafts'							 => 'get_others_drafts',
						'wp_create_thumbnail'						 => 'wp_create_thumbnail',
						'site_icon_attachment_metadata'				 => 'site_icon_attachment_metadata',
						'site_icon_image_sizes'						 => 'site_icon_image_sizes',
						'update_feedback'							 => 'update_feedback',
						'editable_roles'							 => 'editable_roles',
						'get_users_drafts'							 => 'get_users_drafts',
						'post_types_to_delete_with_user'			 => 'post_types_to_delete_with_user',
						'manage_taxonomies_for_attachment_columns'	 => 'manage_taxonomies_for_attachment_columns',
						'manage_media_columns'						 => 'manage_media_columns',
						'media_row_actions'							 => 'media_row_actions',
						'update_bulk_theme_complete_actions'		 => 'update_bulk_theme_complete_actions',
						'install_theme_complete_actions'			 => 'install_theme_complete_actions',
						'update_theme_complete_actions'				 => 'update_theme_complete_actions',
						'install_plugins_tabs'						 => 'install_plugins_tabs',
						'install_plugins_nonmenu_tabs'				 => 'install_plugins_nonmenu_tabs',
						'plugin_install_action_links'				 => 'plugin_install_action_links',
						'post_edit_category_parent_dropdown_args'	 => 'post_edit_category_parent_dropdown_args',
						'page_attributes_dropdown_pages_args'		 => 'page_attributes_dropdown_pages_args',
						'default_page_template_title'				 => 'default_page_template_title',
						'users_list_table_query_args'				 => 'users_list_table_query_args',
						'user_row_actions'							 => 'user_row_actions',
						'manage_users_custom_column'				 => 'manage_users_custom_column',
						'get_role_list'								 => 'get_role_list',
						'comments_per_page'							 => 'comments_per_page',
						'comment_status_links'						 => 'comment_status_links',
						'term_updated_messages'						 => 'term_updated_messages',
						'contextual_help_list'						 => 'contextual_help_list',
						'contextual_help'							 => 'contextual_help',
						'default_contextual_help'					 => 'default_contextual_help',
						'screen_layout_columns'						 => 'screen_layout_columns',
						'screen_settings'							 => 'screen_settings',
						'screen_options_show_screen'				 => 'screen_options_show_screen',
						'screen_options_show_submit'				 => 'screen_options_show_submit',
						'view_mode_post_types'						 => 'view_mode_post_types',
						'edit_tags_per_page'						 => 'edit_tags_per_page',
						'tagsperpage'								 => 'tagsperpage',
						'edit_categories_per_page'					 => 'edit_categories_per_page',
						'term_name'									 => 'term_name',
						'tag_row_actions'							 => 'tag_row_actions',
						'automatic_updater_disabled'				 => 'automatic_updater_disabled',
						'automatic_updates_is_vcs_checkout'			 => 'automatic_updates_is_vcs_checkout',
						'auto_core_update_email'					 => 'auto_core_update_email',
						'automatic_updates_debug_email'				 => 'automatic_updates_debug_email',
						'async_update_translation'					 => 'async_update_translation',
						'plugins_api_args'							 => 'plugins_api_args',
						'plugins_api'								 => 'plugins_api',
						'plugins_api_result'						 => 'plugins_api_result',
						'upgrader_pre_download'						 => 'upgrader_pre_download',
						'upgrader_pre_install'						 => 'upgrader_pre_install',
						'upgrader_source_selection'					 => 'upgrader_source_selection',
						'upgrader_clear_destination'				 => 'upgrader_clear_destination',
						'upgrader_post_install'						 => 'upgrader_post_install',
						'upgrader_package_options'					 => 'upgrader_package_options',
						'themes_api_args'							 => 'themes_api_args',
						'themes_api'								 => 'themes_api',
						'themes_api_result'							 => 'themes_api_result',
						'pre_prepare_themes_for_js'					 => 'pre_prepare_themes_for_js',
						'wp_prepare_themes_for_js'					 => 'wp_prepare_themes_for_js',
						'dbdelta_queries'							 => 'dbdelta_queries',
						'dbdelta_create_queries'					 => 'dbdelta_create_queries',
						'dbdelta_insert_queries'					 => 'dbdelta_insert_queries',
						'wp_should_upgrade_global_tables'			 => 'wp_should_upgrade_global_tables',
						'ms_sites_list_table_query_args'			 => 'ms_sites_list_table_query_args',
						'wpmu_blogs_columns'						 => 'wpmu_blogs_columns',
						'manage_sites_action_links'					 => 'manage_sites_action_links',
						'wp_network_dashboard_widgets'				 => 'wp_network_dashboard_widgets',
						'wp_user_dashboard_widgets'					 => 'wp_user_dashboard_widgets',
						'wp_dashboard_widgets'						 => 'wp_dashboard_widgets',
						'dashboard_glance_items'					 => 'dashboard_glance_items',
						'privacy_on_link_title'						 => 'privacy_on_link_title',
						'privacy_on_link_text'						 => 'privacy_on_link_text',
						'dashboard_recent_drafts_query_args'		 => 'dashboard_recent_drafts_query_args',
						'comment_row_actions'						 => 'comment_row_actions',
						'dashboard_recent_posts_query_args'			 => 'dashboard_recent_posts_query_args',
						'browse-happy-notice'						 => 'browse-happy-notice',
						'try_gutenberg_learn_more_link'				 => 'try_gutenberg_learn_more_link',
						'allow_minor_auto_core_updates'				 => 'allow_minor_auto_core_updates',
						'allow_major_auto_core_updates'				 => 'allow_major_auto_core_updates',
						'media_upload_tabs'							 => 'media_upload_tabs',
						'image_send_to_editor'						 => 'image_send_to_editor',
						'image_add_caption_text'					 => 'image_add_caption_text',
						'image_add_caption_shortcode'				 => 'image_add_caption_shortcode',
						'media_buttons_context'						 => 'media_buttons_context',
						'attachment_fields_to_save'					 => 'attachment_fields_to_save',
						'media_send_to_editor'						 => 'media_send_to_editor',
						'image_send_to_editor_url'					 => 'image_send_to_editor_url',
						'attachment_fields_to_edit'					 => 'attachment_fields_to_edit',
						'get_media_item_args'						 => 'get_media_item_args',
						'media_meta'								 => 'media_meta',
						'upload_post_params'						 => 'upload_post_params',
						'plupload_init'								 => 'plupload_init',
						'media_upload_form_url'						 => 'media_upload_form_url',
						'type_url_form_media'						 => 'type_url_form_media',
						'media_upload_mime_type_links'				 => 'media_upload_mime_type_links',
						'media_submitbox_misc_sections'				 => 'media_submitbox_misc_sections',
						'audio_submitbox_misc_sections'				 => 'audio_submitbox_misc_sections',
						'wp_read_video_metadata'					 => 'wp_read_video_metadata',
						'got_rewrite'								 => 'got_rewrite',
						'got_url_rewrite'							 => 'got_url_rewrite',
						'documentation_ignore_functions'			 => 'documentation_ignore_functions',
						'set-screen-option'							 => 'set-screen-option',
						'admin_referrer_policy'						 => 'admin_referrer_policy',
						'new_admin_email_content'					 => 'new_admin_email_content',
						'wp_get_default_privacy_policy_content'		 => 'wp_get_default_privacy_policy_content',
						'terms_to_edit'								 => 'terms_to_edit',
						'populate_network_meta'						 => 'populate_network_meta',
						'update_plugin_complete_actions'			 => 'update_plugin_complete_actions',
						'update_translations_complete_actions'		 => 'update_translations_complete_actions',
						'nav_menu_meta_box_object'					 => 'nav_menu_meta_box_object',
						'wp_edit_nav_menu_walker'					 => 'wp_edit_nav_menu_walker',
						'revision_text_diff_options'				 => 'revision_text_diff_options',
						'wp_get_revision_ui_diff'					 => 'wp_get_revision_ui_diff',
						'wp_prepare_revision_for_js'				 => 'wp_prepare_revision_for_js',
						'wpmu_drop_tables'							 => 'wpmu_drop_tables',
						'wpmu_delete_blog_upload_dir'				 => 'wpmu_delete_blog_upload_dir',
						'lang_codes'								 => 'lang_codes',
						'mu_dropdown_languages'						 => 'mu_dropdown_languages',
						'can_edit_network'							 => 'can_edit_network',
						'comment_edit_pre'							 => 'comment_edit_pre',
						'editable_extensions'						 => 'editable_extensions',
						'wp_theme_editor_filetypes'					 => 'wp_theme_editor_filetypes',
						'pre_move_uploaded_file'					 => 'pre_move_uploaded_file',
						'filesystem_method_file'					 => 'filesystem_method_file',
						'filesystem_method'							 => 'filesystem_method',
						'request_filesystem_credentials'			 => 'request_filesystem_credentials',
						'fs_ftp_connection_types'					 => 'fs_ftp_connection_types',
						'wp_privacy_personal_data_email_content'	 => 'wp_privacy_personal_data_email_content',
						'image_editor_save_pre'						 => 'image_editor_save_pre',
						'image_save_pre'							 => 'image_save_pre',
						'wp_save_image_editor_file'					 => 'wp_save_image_editor_file',
						'wp_save_image_file'						 => 'wp_save_image_file',
						'wp_image_editor_before_change'				 => 'wp_image_editor_before_change',
						'image_edit_before_change'					 => 'image_edit_before_change',
						'comment_edit_redirect'						 => 'comment_edit_redirect',
						'shake_error_codes'							 => 'shake_error_codes',
						'login_title'								 => 'login_title',
						'login_headerurl'							 => 'login_headerurl',
						'login_headertitle'							 => 'login_headertitle',
						'login_body_class'							 => 'login_body_class',
						'login_message'								 => 'login_message',
						'login_errors'								 => 'login_errors',
						'login_messages'							 => 'login_messages',
						'retrieve_password_title'					 => 'retrieve_password_title',
						'retrieve_password_message'					 => 'retrieve_password_message',
						'login_link_separator'						 => 'login_link_separator',
						'post_password_expires'						 => 'post_password_expires',
						'logout_redirect'							 => 'logout_redirect',
						'lostpassword_redirect'						 => 'lostpassword_redirect',
						'wp_signup_location'						 => 'wp_signup_location',
						'registration_redirect'						 => 'registration_redirect',
						'login_redirect'							 => 'login_redirect',
						'wp_login_errors'							 => 'wp_login_errors',
						'wp_mail_original_content'					 => 'wp_mail_original_content',
						'phone_content'								 => 'phone_content',
// </editor-fold>
					),
					'default'		 => 'the_title',
				),
				2			 =>
				array(
					'label'			 => 'Callback Function',
					'description'	 => 'The name of the function to be called.',
					'id'			 => 'function_name',
					'placeholder'	 => 'custom_hook',
					'type'			 => 'text',
					'default'		 => 'custom_hook',
				),
				3			 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'The order in which the function associated with this particular hook is executed.',
					'id'			 => 'priority',
					'placeholder'	 => 'Default: 10',
					'type'			 => 'number',
					'default'		 => '10',
				),
				4			 =>
				array(
					'label'			 => 'Accepted Arguments',
					'description'	 => 'The # of arguments the function accepts.',
					'id'			 => 'accepted_args',
					'placeholder'	 => '',
					'type'			 => 'number',
					'min'			 => 0,
					'default'		 => '1',
				),
				5			 =>
				array(
					'label'			 => 'Arguments List',
					'description'	 => 'The names of the arguments listed in the callback function.<br><span class="wpg_params_description"></span>',
					'id'			 => 'args_list',
					'placeholder'	 => '$arg1, $arg2 ...',
					'type'			 => 'text',
					'default'		 => '',
				),
				6			 =>
				array(
					'label'			 => 'Code',
					'description'	 => 'Custom code in the function.',
					'id'			 => 'hook_code',
					'placeholder'	 => 'some code',
					'type'			 => 'textarea',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Cron'] = array(
			'tab'		 => 'Cron',
			'tab_descr'	 => 'Schedule Cron Job Event',
			'title'		 => 'Use this tool to create custom code for WordPress Cron Jobs using <a href="https://developer.wordpress.org/reference/functions/wp_schedule_event/" target="_blank">wp_schedule_event()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Timestamp',
					'description'	 => 'The first time you want the event to occur.',
					'id'			 => 'timestamp',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'time()'						 => 'GMT Time',
						'current_time( \'timestamp\' )'	 => 'Local Time',
					),
					'default'		 => 'timestamp',
				),
				3	 =>
				array(
					'label'			 => 'Recurrence',
					'description'	 => 'How often the event should reoccur.Create custom intervals using the "cron_schedules" filter in wp_get_schedules().',
					'id'			 => 'recurrence',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'hourly'	 => 'Hourly',
						'twicedaily' => 'Twice Daily',
						'daily'		 => 'Daily',
						'custom'	 => 'Custom',
					),
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Custom Recurrence Name',
					'description'	 => '',
					'id'			 => 'recurrence_name',
					'placeholder'	 => 'Example: weekly',
					'type'			 => 'text',
					'data'			 => array(
						'parent'	 => 'recurrence',
						'parent-val' => 'custom',
					),
				),
				5	 =>
				array(
					'label'			 => 'Custom Recurrence Lable',
					'description'	 => '',
					'id'			 => 'recurrence_display',
					'placeholder'	 => 'Example: Once Weekly',
					'type'			 => 'text',
					'data'			 => array(
						'parent'	 => 'recurrence',
						'parent-val' => 'custom',
					),
				),
				6	 =>
				array(
					'label'			 => 'Custom Recurrence Interval',
					'description'	 => '',
					'id'			 => 'recurrence_interval',
					'placeholder'	 => 'Example: 604800',
					'type'			 => 'number',
					'min'			 => 0,
					'data'			 => array(
						'parent'	 => 'recurrence',
						'parent-val' => 'custom',
					),
				),
				7	 =>
				array(
					'label'			 => 'Hook Name',
					'description'	 => 'The name of an action hook to execute.',
					'id'			 => 'hook',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'hook_name',
				),
				8	 =>
				array(
					'label'			 => 'Hook Arguments',
					'description'	 => 'Comma separated list of arguments to pass to the hook function(s).',
					'id'			 => 'args',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Hook Code',
					'description'	 => 'Custom code to be executed.',
					'id'			 => 'code',
					'placeholder'	 => NULL,
					'type'			 => 'textarea',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Styles'] = array(
			'tab'		 => 'Styles',
			'tab_descr'	 => 'Register WordPress Styles',
			'title'		 => 'Use this tool to create custom code for Styles Registration with <a href="https://developer.wordpress.org/reference/functions/wp_register_style/" target="_blank">wp_register_style()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Hook',
					'description'	 => 'Where to enqueue? <a href="https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/" target="_blank">Front end</a>, <a href="https://developer.wordpress.org/reference/hooks/login_enqueue_scripts/" target="_blank">login</a>, <a href="https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/" target="_blank">admin</a> or <a href="https://developer.wordpress.org/reference/hooks/enqueue_embed_scripts/" target="_blank">embed</a>.',
					'id'			 => 'hook',
					'placeholder'	 => 'wp_enqueue_scripts',
					'type'			 => 'select',
					'options'		 =>
					array(
						'wp_enqueue_scripts'	 => 'wp_enqueue_scripts',
						'login_enqueue_scripts'	 => 'login_enqueue_scripts',
						'admin_enqueue_scripts'	 => 'admin_enqueue_scripts',
						'enqueue_embed_scripts'	 => 'enqueue_embed_scripts',
					),
					'default'		 => 'wp_enqueue_scripts',
				),
				2	 =>
				array(
					'label'			 => 'Style 1 Handle/Name',
					'description'	 => 'Name used in the code as a stylesheet handle.',
					'id'			 => 'handle1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Styles URL',
					'description'	 => 'URL to the style.',
					'id'			 => 'src1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Styles Dependencies',
					'description'	 => 'Comma separated list of stylesheets to load before this style.',
					'id'			 => 'deps1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'list'			 => true,
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Styles Version',
					'description'	 => 'Stylesheets version number.',
					'id'			 => 'ver1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Media',
					'description'	 => 'The stylesheet <a href="https://www.w3.org/TR/CSS2/media.html#media-types" target="_blank">media type</a>. i.e. \'all\', \'print\', \'tv\', \'projection\'.',
					'id'			 => 'media1',
					'placeholder'	 => 'Default: all',
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Deregister Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_style/" target="_blank">Deregister</a> the style first.',
					'id'			 => 'deregister1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				8	 =>
				array(
					'label'			 => 'Enqueue Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_style/" target="_blank">Enqueue</a> the style.',
					'id'			 => 'enqueue1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				9	 =>
				array(
					'label'			 => 'Style 2 Handle/Name',
					'description'	 => 'Name used in the code as a stylesheet handle.',
					'id'			 => 'handle2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Styles URL',
					'description'	 => 'URL to the style.',
					'id'			 => 'src2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Styles Dependencies',
					'description'	 => 'Comma separated list of stylesheets to load before this style.',
					'id'			 => 'deps2',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Styles Version',
					'description'	 => 'Stylesheets version number.',
					'id'			 => 'ver2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Media',
					'description'	 => 'The stylesheet <a href="https://www.w3.org/TR/CSS2/media.html#media-types" target="_blank">media type</a>. i.e. \'all\', \'print\', \'tv\', \'projection\'.',
					'id'			 => 'media2',
					'placeholder'	 => 'Default: all',
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Deregister Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_style/" target="_blank">Deregister</a> the style first.',
					'id'			 => 'deregister2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				15	 =>
				array(
					'label'			 => 'Enqueue Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_style/" target="_blank">Enqueue</a> the style.',
					'id'			 => 'enqueue2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				16	 =>
				array(
					'label'			 => 'Style 3 Handle/Name',
					'description'	 => 'Name used in the code as a stylesheet handle.',
					'id'			 => 'handle3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Styles URL',
					'description'	 => 'URL to the style.',
					'id'			 => 'src3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Styles Dependencies',
					'description'	 => 'Comma separated list of stylesheets to load before this style.',
					'id'			 => 'deps3',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Styles Version',
					'description'	 => 'Stylesheets version number.',
					'id'			 => 'ver3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Media',
					'description'	 => 'The stylesheet <a href="https://www.w3.org/TR/CSS2/media.html#media-types" target="_blank">media type</a>. i.e. \'all\', \'print\', \'tv\', \'projection\'.',
					'id'			 => 'media3',
					'placeholder'	 => 'Default: all',
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Deregister Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_style/" target="_blank">Deregister</a> the style first.',
					'id'			 => 'deregister3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				22	 =>
				array(
					'label'			 => 'Enqueue Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_style/" target="_blank">Enqueue</a> the style.',
					'id'			 => 'enqueue3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				23	 =>
				array(
					'label'			 => 'Style 4 Handle/Name',
					'description'	 => 'Name used in the code as a stylesheet handle.',
					'id'			 => 'handle4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Styles URL',
					'description'	 => 'URL to the style.',
					'id'			 => 'src4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Styles Dependencies',
					'description'	 => 'Comma separated list of stylesheets to load before this style.',
					'id'			 => 'deps4',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Styles Version',
					'description'	 => 'Stylesheets version number.',
					'id'			 => 'ver4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'Media',
					'description'	 => 'The stylesheet <a href="https://www.w3.org/TR/CSS2/media.html#media-types" target="_blank">media type</a>. i.e. \'all\', \'print\', \'tv\', \'projection\'.',
					'id'			 => 'media4',
					'placeholder'	 => 'Default: all',
					'type'			 => 'text',
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Deregister Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_style/" target="_blank">Deregister</a> the style first.',
					'id'			 => 'deregister4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				29	 =>
				array(
					'label'			 => 'Enqueue Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_style/" target="_blank">Enqueue</a> the style.',
					'id'			 => 'enqueue4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				30	 =>
				array(
					'label'			 => 'Style 5 Handle/Name',
					'description'	 => 'Name used in the code as a stylesheet handle.',
					'id'			 => 'handle5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Styles URL',
					'description'	 => 'URL to the style.',
					'id'			 => 'src5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Styles Dependencies',
					'description'	 => 'Comma separated list of stylesheets to load before this style.',
					'id'			 => 'deps5',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Styles Version',
					'description'	 => 'Stylesheets version number.',
					'id'			 => 'ver5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Media',
					'description'	 => 'The stylesheet <a href="https://www.w3.org/TR/CSS2/media.html#media-types" target="_blank">media type</a>. i.e. \'all\', \'print\', \'tv\', \'projection\'.',
					'id'			 => 'media5',
					'placeholder'	 => 'Default: all',
					'type'			 => 'text',
					'default'		 => '',
				),
				35	 =>
				array(
					'label'			 => 'Deregister Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_style/" target="_blank">Deregister</a> the style first.',
					'id'			 => 'deregister5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				36	 =>
				array(
					'label'			 => 'Enqueue Style',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_style/" target="_blank">Enqueue</a> the style.',
					'id'			 => 'enqueue5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Scripts'] = array(
			'tab'		 => 'Scripts',
			'tab_descr'	 => 'Register WordPress Scripts',
			'title'		 => 'Use this tool to create custom code for Script Registration with <a href="https://developer.wordpress.org/reference/functions/wp_register_script/" target="_blank">wp_register_script()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Hook',
					'description'	 => 'Where to enqueue? <a href="https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/" target="_blank">Front end</a>, <a href="https://developer.wordpress.org/reference/hooks/login_enqueue_scripts/" target="_blank">login</a>, <a href="https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/" target="_blank">admin</a> or <a href="https://developer.wordpress.org/reference/hooks/enqueue_embed_scripts/" target="_blank">embed</a>.',
					'id'			 => 'hook',
					'placeholder'	 => 'wp_enqueue_scripts',
					'type'			 => 'select',
					'options'		 =>
					array(
						'wp_enqueue_scripts'	 => 'wp_enqueue_scripts',
						'login_enqueue_scripts'	 => 'login_enqueue_scripts',
						'admin_enqueue_scripts'	 => 'admin_enqueue_scripts',
						'enqueue_embed_scripts'	 => 'enqueue_embed_scripts',
					),
					'default'		 => 'wp_enqueue_scripts',
				),
				2	 =>
				array(
					'label'			 => 'Script 1 Handle/Name',
					'description'	 => 'Name used in the code as a script handle.',
					'id'			 => 'handle1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Script URL',
					'description'	 => 'URL to the script.',
					'id'			 => 'src1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Script Dependencies',
					'description'	 => 'Comma separated list of scripts to load before this script.',
					'id'			 => 'deps1',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Script Version',
					'description'	 => 'Script version number.',
					'id'			 => 'ver1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Script Location',
					'description'	 => 'Load the script in the <a href="https://developer.wordpress.org/reference/hooks/wp_head/" target="_blank">header</a> or the <a href="https://developer.wordpress.org/reference/hooks/wp_footer/" target="_blank">footer</a>.',
					'id'			 => 'in_footer1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Header',
						'true'	 => 'Footer',
					),
					'default'		 => 'false',
				),
				7	 =>
				array(
					'label'			 => 'Deregister Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_script/" target="_blank">Deregister</a> the script first.',
					'id'			 => 'deregister1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				8	 =>
				array(
					'label'			 => 'Enqueue Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">Enqueue</a> the script.',
					'id'			 => 'enqueue1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				9	 =>
				array(
					'label'			 => 'Script 2 Handle/Name',
					'description'	 => 'Name used in the code as a script handle.',
					'id'			 => 'handle2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Script URL',
					'description'	 => 'URL to the script.',
					'id'			 => 'src2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Script Dependencies',
					'description'	 => 'Comma separated list of scripts to load before this script.',
					'id'			 => 'deps2',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Script Version',
					'description'	 => 'Script version number.',
					'id'			 => 'ver2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Script Location',
					'description'	 => 'Load the script in the <a href="https://developer.wordpress.org/reference/hooks/wp_head/" target="_blank">header</a> or the <a href="https://developer.wordpress.org/reference/hooks/wp_footer/" target="_blank">footer</a>.',
					'id'			 => 'in_footer2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Header',
						'true'	 => 'Footer',
					),
					'default'		 => 'false',
				),
				14	 =>
				array(
					'label'			 => 'Deregister Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_script/" target="_blank">Deregister</a> the script first.',
					'id'			 => 'deregister2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				15	 =>
				array(
					'label'			 => 'Enqueue Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">Enqueue</a> the script.',
					'id'			 => 'enqueue2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				16	 =>
				array(
					'label'			 => 'Script 3 Handle/Name',
					'description'	 => 'Name used in the code as a script handle.',
					'id'			 => 'handle3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Script URL',
					'description'	 => 'URL to the script.',
					'id'			 => 'src3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Script Dependencies',
					'description'	 => 'Comma separated list of scripts to load before this script.',
					'id'			 => 'deps3',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Script Version',
					'description'	 => 'Script version number.',
					'id'			 => 'ver3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Script Location',
					'description'	 => 'Load the script in the <a href="https://developer.wordpress.org/reference/hooks/wp_head/" target="_blank">header</a> or the <a href="https://developer.wordpress.org/reference/hooks/wp_footer/" target="_blank">footer</a>.',
					'id'			 => 'in_footer3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Header',
						'true'	 => 'Footer',
					),
					'default'		 => 'false',
				),
				21	 =>
				array(
					'label'			 => 'Deregister Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_script/" target="_blank">Deregister</a> the script first.',
					'id'			 => 'deregister3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				22	 =>
				array(
					'label'			 => 'Enqueue Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">Enqueue</a> the script.',
					'id'			 => 'enqueue3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				23	 =>
				array(
					'label'			 => 'Script 4 Handle/Name',
					'description'	 => 'Name used in the code as a script handle.',
					'id'			 => 'handle4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Script URL',
					'description'	 => 'URL to the script.',
					'id'			 => 'src4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Script Dependencies',
					'description'	 => 'Comma separated list of scripts to load before this script.',
					'id'			 => 'deps4',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Script Version',
					'description'	 => 'Script version number.',
					'id'			 => 'ver4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'Script Location',
					'description'	 => 'Load the script in the <a href="https://developer.wordpress.org/reference/hooks/wp_head/" target="_blank">header</a> or the <a href="https://developer.wordpress.org/reference/hooks/wp_footer/" target="_blank">footer</a>.',
					'id'			 => 'in_footer4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Header',
						'true'	 => 'Footer',
					),
					'default'		 => 'false',
				),
				28	 =>
				array(
					'label'			 => 'Deregister Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_script/" target="_blank">Deregister</a> the script first.',
					'id'			 => 'deregister4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				29	 =>
				array(
					'label'			 => 'Enqueue Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">Enqueue</a> the script.',
					'id'			 => 'enqueue4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				30	 =>
				array(
					'label'			 => 'Script 5 Handle/Name',
					'description'	 => 'Name used in the code as a script handle.',
					'id'			 => 'handle5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Script URL',
					'description'	 => 'URL to the script.',
					'id'			 => 'src5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Script Dependencies',
					'description'	 => 'Comma separated list of scripts to load before this script.',
					'id'			 => 'deps5',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Script Version',
					'description'	 => 'Script version number.',
					'id'			 => 'ver5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Script Location',
					'description'	 => 'Load the script in the <a href="https://developer.wordpress.org/reference/hooks/wp_head/" target="_blank">header</a> or the <a href="https://developer.wordpress.org/reference/hooks/wp_footer/" target="_blank">footer</a>.',
					'id'			 => 'in_footer5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Header',
						'true'	 => 'Footer',
					),
					'default'		 => 'false',
				),
				35	 =>
				array(
					'label'			 => 'Deregister Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_deregister_script/" target="_blank">Deregister</a> the script first.',
					'id'			 => 'deregister5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				36	 =>
				array(
					'label'			 => 'Enqueue Script',
					'description'	 => '
<a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">Enqueue</a> the script.',
					'id'			 => 'enqueue5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['config'] = array(
			'tab'		 => 'Config',
			'tab_descr'	 => 'wp-config.php Generator',
			'title'		 => 'Use this tool to create customs code for WordPress configuration settings on <a href="https://codex.wordpress.org/Editing_wp-config.php" target="_blank">wp-config.php</a> file.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Database Name',
					'description'	 => 'MySQL database name.',
					'id'			 => 'database_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				1	 =>
				array(
					'label'			 => 'Database Host',
					'description'	 => 'MySQL database Host.',
					'id'			 => 'database_hostname',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'localhost',
				),
				2	 =>
				array(
					'label'			 => 'Database User Name',
					'description'	 => 'MySQL database user name.',
					'id'			 => 'database_username',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Database Password',
					'description'	 => 'MySQL database password.',
					'id'			 => 'database_password',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Database Charset',
					'description'	 => 'MySQL database charset.',
					'id'			 => 'database_charset',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'utf8mb4',
				),
				5	 =>
				array(
					'label'			 => 'Database Collate',
					'description'	 => 'MySQL database collate type.<br>e.g. \'utf8_general_ci\'',
					'id'			 => 'database_collate',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Database Table Prefix',
					'description'	 => 'MySQL database table prefix.',
					'id'			 => 'table_prefix',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'wp_',
				),
				7	 =>
				array(
					'label'			 => 'Custom User Table',
					'description'	 => 'Change default \'wp_user\' table.',
					'id'			 => 'custom_user_table',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Custom User Meta Table',
					'description'	 => 'Change default \'wp_usermeta\' table.',
					'id'			 => 'custom_user_meta_table',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Authentication Keys & Salts',
					'description'	 => 'Unique security keys and salts. Insert manually or <a href="https://api.wordpress.org/secret-key/1.1/salt/" target="_blank">auto generated</a>.',
					'id'			 => 'security',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Auto Generate',
						'false'	 => 'Manually',
					),
					'default'		 => 'true',
				),
				10	 =>
				array(
					'label'			 => 'SSL Login',
					'description'	 => 'Force SSL Login.',
					'id'			 => 'ssl_login',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'SSL Admin',
					'description'	 => 'Force SSL Admin.',
					'id'			 => 'ssl_admin',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Site URL',
					'description'	 => 'Your Wordpress blog/site URI.<br>http://example.com/blog',
					'id'			 => 'site_url',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'WordPress URL',
					'description'	 => 'WordPress core files URI.<br>http://example.com/wordpress',
					'id'			 => 'home_url',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Content URL',
					'description'	 => 'Custom \'wp-content\' URI.<br>http://example.com/wp-content',
					'id'			 => 'content_url',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Uploads URL',
					'description'	 => 'Custom \'wp-content/uploads\' URI.<br>http://example.com/wp-content/uploads',
					'id'			 => 'uploads_url',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'Plugins URL',
					'description'	 => 'Custom \'wp-content/plugins\' URI.<br>http://example.com/wp-content/plugins',
					'id'			 => 'plugins_url',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Cookie Domain',
					'description'	 => 'Set <a href="http://www.askapache.com/htaccess/apache-speed-subdomains.html" target="_blank">different domain</a> for cookies.<br>subdomain.example.com',
					'id'			 => 'cookie_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'AutoSave',
					'description'	 => 'Auto-save interval (seconds).<br>Default: 60',
					'id'			 => 'autosave',
					'placeholder'	 => NULL,
					'type'			 => 'number',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Revisions',
					'description'	 => 'Enable/disable revisions.',
					'id'			 => 'revisions',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				20	 =>
				array(
					'label'			 => 'Limit Revisions Number',
					'description'	 => 'Set maximum number of revisions.<br>Default: No limit',
					'id'			 => 'revisions_num',
					'placeholder'	 => NULL,
					'type'			 => 'number',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'revisions',
						'parent-val' => 'true',
					),
				),
				21	 =>
				array(
					'label'			 => 'Media Trash',
					'description'	 => 'Enable trash for media.',
					'id'			 => 'media_trash',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Trash Days',
					'description'	 => 'Number of days before trash emptied.<br>Default: 30.',
					'id'			 => 'trash',
					'placeholder'	 => NULL,
					'type'			 => 'number',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'Enable Multisite',
					'description'	 => 'Enable Multisite / Network Ability.',
					'id'			 => 'multisite',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Debug',
					'description'	 => 'Display errors and warnings.',
					'id'			 => 'debug',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Debug Log',
					'description'	 => 'Log errors and warnings.',
					'id'			 => 'debug_log',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'Debug Display',
					'description'	 => 'Display errors and warnings.',
					'id'			 => 'debug_display',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Script Debug',
					'description'	 => 'JavaScript or CSS errors.',
					'id'			 => 'script_debug',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Save Queries',
					'description'	 => 'Save database queries in an array ($wpdb-&gt;queries) for analysis.',
					'id'			 => 'save_queries',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				29	 =>
				array(
					'label'			 => 'Memory Limit',
					'description'	 => 'PHP memory limit.<br>Default: 30M ; Multisite Default: 64M',
					'id'			 => 'memory_limit',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				30	 =>
				array(
					'label'			 => 'Max Memory Limit',
					'description'	 => 'Maximum memory limit.<br>Default: 256M',
					'id'			 => 'max_memory_limit',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Cache',
					'description'	 => 'Include \'wp-content/advanced-cache.php\' script, when executing \'wp-settings.php\'.',
					'id'			 => 'cache',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Compresses CSS',
					'description'	 => 'Compresses CSS.',
					'id'			 => 'compress_css',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Compresses Scripts',
					'description'	 => 'Compresses JavaScript.',
					'id'			 => 'compress_scripts',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Concatenate Scripts',
					'description'	 => 'Concatenates JavaScript and CSS files.',
					'id'			 => 'concatenate_scripts',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				35	 =>
				array(
					'label'			 => 'Forces gzip Compressoin',
					'description'	 => 'Forces gzip for compressoin of data sent to browsers.',
					'id'			 => 'enforce_gzip',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				36	 =>
				array(
					'label'			 => 'FTP User',
					'description'	 => 'FTP or SSH username.',
					'id'			 => 'ftp_user',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				37	 =>
				array(
					'label'			 => 'FTP Password',
					'description'	 => 'FTP or SSH password.',
					'id'			 => 'ftp_password',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				38	 =>
				array(
					'label'			 => 'FTP Host',
					'description'	 => 'FTP or SSH hostname.',
					'id'			 => 'ftp_host',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				39	 =>
				array(
					'label'			 => 'FTP SSL',
					'description'	 => 'Allow "Secure FTP" connection (not SSH SFTP).',
					'id'			 => 'ftp_ssl',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				40	 =>
				array(
					'label'			 => 'Disable Cron',
					'description'	 => 'Disable the WordPress cron entirely.',
					'id'			 => 'disable_wp_cron',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				41	 =>
				array(
					'label'			 => 'Alternate Cron',
					'description'	 => 'Set an <a href="https://wordpress.org/support/topic/scheduled-posts-still-not-working-in-282?replies=13#post-1175405" target="_blank">alternate</a> WordPress cron.',
					'id'			 => 'alternate_wp_cron',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				42	 =>
				array(
					'label'			 => 'Cron Lock Timeout',
					'description'	 => 'Set maximum cron process execution time (seconds).',
					'id'			 => 'wp_cron_lock_timeout',
					'placeholder'	 => '',
					'type'			 => 'number',
					'default'		 => '',
				),
				43	 =>
				array(
					'label'			 => 'File Modification',
					'description'	 => 'Enable or disable update and installation from the admin.',
					'id'			 => 'disallow_file_mods',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Disable File Modification',
						''		 => 'Enable File Modification - Default',
					),
					'default'		 => '',
				),
				44	 =>
				array(
					'label'			 => 'Core Auto-Updates',
					'description'	 => 'Enable or disable auto core updates and language packs.',
					'id'			 => 'wp_auto_update_core',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'Disable all core updates',
						'true'	 => 'Enable all core updates',
						''		 => 'Enable only core minor updates - Default',
					),
					'default'		 => '',
				),
				45	 =>
				array(
					'label'			 => 'Plugin/Theme Editor',
					'description'	 => 'Enable or disable the Plugin/Theme Editor.',
					'id'			 => 'disallow_file_edit',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Disable Editor',
						''		 => 'Enable Editor - Default',
					),
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Shortcode'] = array(
			'tab'		 => 'Shortcode',
			'tab_descr'	 => 'Shortcodes Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Shortcode_API" target="_blank">Shortcodes</a> with <a href="https://developer.wordpress.org/reference/functions/add_shortcode/" target="_blank">add_shortcode()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Tag Name',
					'description'	 => 'Shortcode tag in the content. <br> e.g. [tag]',
					'id'			 => 'tag',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				1	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				2	 =>
				array(
					'label'			 => 'Shortcode Type',
					'description'	 => 'Self-closing shortcode: [tag] <br> Enclosing shortcode: [tag]content[/tag]',
					'id'			 => 'type',
					'placeholder'	 => 'selfclosing',
					'type'			 => 'select',
					'options'		 =>
					array(
						'enclosing'		 => 'Enclosing',
						'selfclosing'	 => 'Self-closing',
					),
					'default'		 => 'selfclosing',
				),
				3	 =>
				array(
					'label'			 => 'Attributes',
					'description'	 => 'Enable attributes such as <br> [tag foo="123" bar="456"].',
					'id'			 => 'attributes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				4	 =>
				array(
					'label'			 => 'Add Attributes Filter',
					'description'	 => 'Use "shortcode_atts_{$shortcode}" filter, to allow shortcode attributes filtering.',
					'id'			 => 'attributes_filter',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'no'				 => 'No filter (Default)',
						'yes_tag_name'		 => 'Yes - Use tag name (Recomended)',
						'yes_custom_name'	 => 'Yes - Use custom name',
					),
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				5	 =>
				array(
					'label'			 => 'Custom Filter Name',
					'description'	 => 'Set custom filter name.',
					'id'			 => 'attributes_filter_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes_filter',
						'parent-val' => 'yes_custom_name',
					),
				),
				6	 =>
				array(
					'label'			 => '1st Attribute Name',
					'description'	 => 'Attribute name. Lowercase.',
					'id'			 => 'attr_1_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				7	 =>
				array(
					'label'			 => '1st Attribute Default Value',
					'description'	 => 'Default value. <br>e.g. [tag attr_name="default_value"]',
					'id'			 => 'attr_1_value',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				9	 =>
				array(
					'label'			 => '2nd Attribute Name',
					'description'	 => 'Attribute name. Lowercase.',
					'id'			 => 'attr_2_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				10	 =>
				array(
					'label'			 => '2nd Attribute Default Value',
					'description'	 => 'Default value.',
					'id'			 => 'attr_2_value',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				11	 =>
				array(
					'label'			 => '3rd Attribute Name',
					'description'	 => 'Attribute name. Lowercase.',
					'id'			 => 'attr_3_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				12	 =>
				array(
					'label'			 => '3rd Attribute Default Value',
					'description'	 => 'Default value.',
					'id'			 => 'attr_3_value',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'attributes',
						'parent-val' => 'true',
					),
				),
				13	 =>
				array(
					'label'			 => 'Code',
					'description'	 => 'Custom code to generate the output.<br>Should only "return" the text, never produce the output directly.',
					'id'			 => 'code',
					'placeholder'	 => NULL,
					'type'			 => 'textarea',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Post Status'] = array(
			'tab'		 => 'Post Status',
			'tab_descr'	 => 'Post Status Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Post_Status" target="_blank">Post Status</a> with <a href="https://developer.wordpress.org/reference/functions/register_post_status/" target="_blank">register_post_status()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'custom_post_status',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				2	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Post Status',
					'description'	 => 'Status name used in the code. Up to 32 characters, lowercase.',
					'id'			 => 'post_status',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Name (Singular)',
					'description'	 => 'Post Status singular name. e.g. Draft or Scheduled.',
					'id'			 => 'label_count_singular',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Name (Plural)',
					'description'	 => 'Post Status plural name. e.g. Drafts or Scheduled.',
					'id'			 => 'label_count_plural',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Public',
					'description'	 => 'Posts of this status should be shown in the site front end.',
					'id'			 => 'public',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes - Default',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				7	 =>
				array(
					'label'			 => 'Exclude from search results',
					'description'	 => 'Posts of this status should be excluded from search results.',
					'id'			 => 'exclude_from_search',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No - Default',
					),
					'default'		 => 'false',
				),
				8	 =>
				array(
					'label'			 => 'Show in admin all list',
					'description'	 => 'Show statuses in the edit listing of the post.',
					'id'			 => 'show_in_admin_all_list',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes - Default',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				9	 =>
				array(
					'label'			 => 'Show in admin status list',
					'description'	 => 'Show statuses list at the top of the edit listings.<br>e.g. All (12) Custom Status (2)',
					'id'			 => 'show_in_admin_status_list',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes - Default',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Post Type'] = array(
			'tab'		 => 'Post Type',
			'tab_descr'	 => 'Post Type Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Post_Types" target="_blank">Post Types</a> with <a href="https://developer.wordpress.org/reference/functions/register_post_type/" target="_blank">register_post_type()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				2	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Post Type Key',
					'description'	 => 'Key used in the code. Up to 20 characters, lowercase, no spaces.',
					'id'			 => 'post_type',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'post_type_key',
				),
				4	 =>
				array(
					'label'			 => 'Description',
					'description'	 => 'A short descriptive summary of the post type.',
					'id'			 => 'description',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Name (Singular)',
					'description'	 => 'Post type singular name. e.g. Product, Event or Movie.',
					'id'			 => 'singular_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Name (Plural)',
					'description'	 => 'Post type plural name. e.g. Products, Events or Movies.',
					'id'			 => 'plural_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Link To Taxonomies',
					'description'	 => 'Comma separated list of <a href="https://codex.wordpress.org/Taxonomies" target="_blank">Taxonomies</a>.',
					'id'			 => 'taxonomies',
					'list'			 => true,
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Hierarchical',
					'description'	 => 'Hierarchical post types allows descendants.',
					'id'			 => 'hierarchical',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes (like pages)',
						'false'	 => 'No (like posts)',
					),
					'default'		 => 'false',
				),
				9	 =>
				array(
					'label'			 => 'Menu Name',
					'description'	 => '',
					'id'			 => 'menu_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Admin Bar Name',
					'description'	 => '',
					'id'			 => 'name_admin_bar',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Archives',
					'description'	 => '',
					'id'			 => 'archives',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Attributes',
					'description'	 => '',
					'id'			 => 'attributes',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Parent Item',
					'description'	 => '',
					'id'			 => 'parent_item_colon',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'All Items',
					'description'	 => '',
					'id'			 => 'all_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Add New Item',
					'description'	 => '',
					'id'			 => 'add_new_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'Add New',
					'description'	 => '',
					'id'			 => 'add_new',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'New Item',
					'description'	 => '',
					'id'			 => 'new_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Edit Item',
					'description'	 => '',
					'id'			 => 'edit_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Update Item',
					'description'	 => '',
					'id'			 => 'update_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'View Item',
					'description'	 => '',
					'id'			 => 'view_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'View Items',
					'description'	 => '',
					'id'			 => 'view_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Search Item',
					'description'	 => '',
					'id'			 => 'search_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'Not Found',
					'description'	 => '',
					'id'			 => 'not_found',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Not Found in Trash',
					'description'	 => '',
					'id'			 => 'not_found_in_trash',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Featured Image',
					'description'	 => '',
					'id'			 => 'featured_image',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Set featured image',
					'description'	 => '',
					'id'			 => 'set_featured_image',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'Remove featured image',
					'description'	 => '',
					'id'			 => 'remove_featured_image',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Use as featured image',
					'description'	 => '',
					'id'			 => 'use_featured_image',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				29	 =>
				array(
					'label'			 => 'Insert into item',
					'description'	 => '',
					'id'			 => 'insert_into_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				30	 =>
				array(
					'label'			 => 'Uploaded to this item',
					'description'	 => '',
					'id'			 => 'uploaded_to_this_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Items list',
					'description'	 => '',
					'id'			 => 'items_list',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Items list navigation',
					'description'	 => '',
					'id'			 => 'items_list_navigation',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Filter items list',
					'description'	 => '',
					'id'			 => 'filter_items_list',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Supports',
					'description'	 => '',
					'list'			 => true,
					'type'			 => 'checkbox_multi',
					'options'		 => array(
						'title'				 => 'Title',
						'editor'			 => 'Content (editor)',
						'excerpt'			 => 'Excerpt',
						'author'			 => 'Author',
						'thumbnail'			 => 'Featured Image',
						'comments'			 => 'Comments',
						'trackbacks'		 => 'Trackbacks',
						'revisions'			 => 'Revisions',
						'custom-fields'		 => 'Custom Fields',
						'page-attributes'	 => 'Page Attributes',
						'post-formats'		 => 'Post Formats',
					),
					'id'			 => 'supports',
				),
				35	 =>
				array(
					'label'			 => 'Exclude From Search',
					'description'	 => 'Posts of this type should be excluded from search results.',
					'id'			 => 'exclude_from_search',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				36	 =>
				array(
					'label'			 => 'Enable Export',
					'description'	 => 'Enables post type export.',
					'id'			 => 'can_export',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				37	 =>
				array(
					'label'			 => 'Enable Archives',
					'description'	 => 'Enables post type archives. Post type key is used as defauly archive slug.',
					'id'			 => 'has_archive',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'No (prevent archive pages)',
						'true'	 => 'Yes (use default slug)',
						'custom' => 'Yes (set custom archive slug)',
					),
					'default'		 => 'true',
				),
				38	 =>
				array(
					'label'			 => 'Custom Archive Slug',
					'description'	 => 'Set custom archive slug.',
					'id'			 => 'custom_archive_slug',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'has_archive',
						'parent-val' => 'custom',
					),
				),
				39	 =>
				array(
					'label'			 => 'Public',
					'description'	 => 'Show post type in the admin UI.',
					'id'			 => 'public',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				40	 =>
				array(
					'label'			 => 'Show UI',
					'description'	 => 'Show post type UI in the admin.',
					'id'			 => 'show_ui',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				41	 =>
				array(
					'label'			 => 'Show in Admin Sidebar',
					'description'	 => 'Show post type in admin sidebar.',
					'id'			 => 'show_in_menu',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				141	 =>
				array(
					'label'			 => '',
					'description'	 => '',
					'id'			 => 'menu_position',
					'type'			 => 'select',
					'options'		 =>
					array(
						5	 => '5 - below Posts',
						10	 => '10 - below Media',
						15	 => '15 - below Links',
						20	 => '20 - below Pages',
						25	 => '25 - below Comments',
						60	 => '60 - below first Separator',
						65	 => '65 - below Plugins',
						70	 => '70 - below Users',
						75	 => '75 - below Tools',
						80	 => '80 - below Settings',
						100	 => '100 - below second Separator',
					),
					'data'			 => array(
						'parent'	 => 'show_in_menu',
						'parent-val' => 'true',
					),
				),
				42	 =>
				array(
					'label'			 => 'Admin Sidebar Icon',
					'description'	 => 'Post type icon. Use <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">dashicon</a> name or full icon URL (http://.../icon.png).',
					'id'			 => 'menu_icon',
					'placeholder'	 => 'i.e. dashicons-admin-post',
					'type'			 => 'text',
					'default'		 => '',
				),
				43	 =>
				array(
					'label'			 => 'Show in Admin Bar',
					'description'	 => 'Show post type in <a href="https://codex.wordpress.org/Toolbar" target="_blank">admin bar</a>.',
					'id'			 => 'show_in_admin_bar',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				44	 =>
				array(
					'label'			 => 'Show in Navigation Menus',
					'description'	 => 'Show post type in <a href="https://codex.wordpress.org/Navigation_Menus" target="_blank">Navigation Menus</a>.',
					'id'			 => 'show_in_nav_menus',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				45	 =>
				array(
					'label'			 => 'Query',
					'description'	 => 'Direct query variable used in <a href="https://developer.wordpress.org/reference/classes/wp_query/#post-type-parameters" target="_blank">WP_Query</a>. e.g. WP_Query( array( <strong>\'post_type\' =&gt; \'product\'</strong>, \'term\' =&gt; \'disk\' ) )',
					'id'			 => 'query_var',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						''		 => 'Default (post type key)',
						'true'	 => 'Custom query variable',
					),
					'default'		 => '',
				),
				47	 =>
				array(
					'label'			 => 'Custom Query',
					'description'	 => 'Custom query variable.',
					'id'			 => 'custom_query_variable',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'query_var',
						'parent-val' => 'true',
					),
				),
				46	 =>
				array(
					'label'			 => 'Publicly Queryable',
					'description'	 => 'Enable front end queries as part of parse_request().',
					'id'			 => 'publicly_queryable',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				48	 =>
				array(
					'label'			 => 'Permalink Rewrite',
					'description'	 => 'Use Default <a href="https://codex.wordpress.org/Using_Permalinks" target="_blank">Permalinks</a> (using post type key), prevent automatic URL rewriting (no pretty permalinks), or set custom permalinks.',
					'id'			 => 'rewrite',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'No permalink (prevent URL rewriting)',
						''		 => 'Default permalink (post type key)',
						'custom' => 'Custom permalink',
					),
					'default'		 => '',
				),
				49	 =>
				array(
					'label'			 => 'URL Slug',
					'description'	 => 'Pretty permalink base text. i.e.<br> www.example.com/product/',
					'id'			 => 'rewrite_slug',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'post_type',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				50	 =>
				array(
					'label'			 => 'Use URL Slug',
					'description'	 => 'Use Post Type slug as URL base.<br>Default: Yes',
					'id'			 => 'rewrite_with_front',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				51	 =>
				array(
					'label'			 => 'Pagination',
					'description'	 => 'Allow post-type pagination.<br>Default: Yes',
					'id'			 => 'rewrite_pages',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				52	 =>
				array(
					'label'			 => 'Feeds',
					'description'	 => 'Build feed permastruct.<br>Default: Yes',
					'id'			 => 'rewrite_feeds',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				53	 =>
				array(
					'label'			 => 'Capabilities',
					'description'	 => 'Set <a href="https://codex.wordpress.org/Roles_and_Capabilities" target="_blank">user capabilities</a> to manage post type.',
					'id'			 => 'capabilities',
					'placeholder'	 => 'base',
					'type'			 => 'select',
					'options'		 =>
					array(
						'base'	 => 'Base capabilities',
						'custom' => 'Custom capabilities',
					),
					'default'		 => 'base',
				),
				54	 =>
				array(
					'label'			 => 'Base Capability Type',
					'description'	 => 'Used as a base to construct capabilities.',
					'id'			 => 'capability_type',
					'placeholder'	 => 'page',
					'type'			 => 'select',
					'options'		 =>
					array(
						'post'	 => 'Posts',
						'page'	 => 'Pages',
					),
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'base',
					),
					'default'		 => 'page',
				),
				55	 =>
				array(
					'label'			 => 'Read Post',
					'description'	 => '',
					'id'			 => 'capabilities_read_post',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'read_post',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				56	 =>
				array(
					'label'			 => 'Read Private Posts',
					'description'	 => '',
					'id'			 => 'capabilities_read_private_posts',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'read_private_posts',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				57	 =>
				array(
					'label'			 => 'Publish Posts',
					'description'	 => '',
					'id'			 => 'capabilities_publish_posts',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'publish_posts',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				58	 =>
				array(
					'label'			 => 'Delete Post',
					'description'	 => '',
					'id'			 => 'capabilities_delete_post',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'delete_post',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				59	 =>
				array(
					'label'			 => 'Edit Post',
					'description'	 => '',
					'id'			 => 'capabilities_edit_post',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'edit_post',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				60	 =>
				array(
					'label'			 => 'Edit Posts',
					'description'	 => '',
					'id'			 => 'capabilities_edit_posts',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'edit_posts',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				61	 =>
				array(
					'label'			 => 'Edit Others Posts',
					'description'	 => '',
					'id'			 => 'capabilities_edit_others_posts',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'edit_others_posts',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'custom',
					),
				),
				62	 =>
				array(
					'label'			 => 'Show in Rest',
					'description'	 => 'Whether to add the post type route in the REST API \'wp/v2\' namespace.',
					'id'			 => 'show_in_rest',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				63	 =>
				array(
					'label'			 => 'Rest Base',
					'description'	 => 'To change the base url of REST API route. Default is the post type key.',
					'id'			 => 'rest_base',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				64	 =>
				array(
					'label'			 => 'Rest Controller Class',
					'description'	 => 'REST API Controller class name. Default is \'WP_REST_Posts_Controller\'.',
					'id'			 => 'rest_controller_class',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Taxonomy'] = array(
			'tab'		 => 'Taxonomy',
			'tab_descr'	 => 'Taxonomy Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Taxonomies" target="_blank">Taxonomies</a> with <a href="https://developer.wordpress.org/reference/functions/register_taxonomy/" target="_blank">register_taxonomy()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'custom_taxonomy',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				2	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Taxonomy Key',
					'description'	 => 'Key used in the code. Up to 32 characters, lowercase.',
					'id'			 => 'taxonomy',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'taxonomy_key',
				),
				4	 =>
				array(
					'label'			 => 'Name (Singular)',
					'description'	 => 'Taxonomy singular name.',
					'id'			 => 'singular_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'Taxonomy',
				),
				5	 =>
				array(
					'label'			 => 'Name (Plural)',
					'description'	 => 'Taxonomy plural name.',
					'id'			 => 'plural_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'Taxonomies',
				),
				6	 =>
				array(
					'label'			 => 'Link To Post Type(s)',
					'description'	 => 'Comma separated list of <a href="https://codex.wordpress.org/Post_Types" target="_blank">Post Types</a>.',
					'id'			 => 'object_type',
					'list'			 => true,
					'placeholder'	 => 'post,page',
					'type'			 => 'text',
					'default'		 => 'post,page',
				),
				7	 =>
				array(
					'label'			 => 'Hierarchical',
					'description'	 => 'Hierarchical taxonomy allows descendants.',
					'id'			 => 'hierarchical',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes (like categories)',
						'false'	 => 'No (like tags)',
					),
					'default'		 => 'false',
				),
				8	 =>
				array(
					'label'			 => 'Menu Name',
					'description'	 => '',
					'id'			 => 'menu_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'All Items',
					'description'	 => '',
					'id'			 => 'all_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Parent Item',
					'description'	 => '',
					'id'			 => 'parent_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Parent Item (colon)',
					'description'	 => '',
					'id'			 => 'parent_item_colon',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'New Item Name',
					'description'	 => '',
					'id'			 => 'new_item_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Add New Item',
					'description'	 => '',
					'id'			 => 'add_new_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Edit Item',
					'description'	 => '',
					'id'			 => 'edit_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Update Item',
					'description'	 => '',
					'id'			 => 'update_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'View Item',
					'description'	 => '',
					'id'			 => 'view_item',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Separate Items with commas',
					'description'	 => '',
					'id'			 => 'separate_items_with_commas',
					'placeholder'	 => NULL,
					'list'			 => true,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Add or Remove Items',
					'description'	 => '',
					'id'			 => 'add_or_remove_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Choose From Most Used',
					'description'	 => '',
					'id'			 => 'choose_from_most_used',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Popular Items',
					'description'	 => '',
					'id'			 => 'popular_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Search Items',
					'description'	 => '',
					'id'			 => 'search_items',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Not Found',
					'description'	 => '',
					'id'			 => 'not_found',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'No items',
					'description'	 => '',
					'id'			 => 'no_terms',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Items list',
					'description'	 => '',
					'id'			 => 'items_list',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Items list navigation',
					'description'	 => '',
					'id'			 => 'items_list_navigation',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Public',
					'description'	 => 'Show this taxonomy in the admin UI.',
					'id'			 => 'public',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				27	 =>
				array(
					'label'			 => 'Show UI',
					'description'	 => 'Show taxonomy managing UI in the admin.',
					'id'			 => 'show_ui',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				28	 =>
				array(
					'label'			 => 'Show Admin Column',
					'description'	 => 'Show taxonomy columns on associated post-types.',
					'id'			 => 'show_admin_column',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				29	 =>
				array(
					'label'			 => 'Show Tag Cloud',
					'description'	 => 'Show in tag cloud widget.',
					'id'			 => 'show_tagcloud',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				30	 =>
				array(
					'label'			 => 'Show in Navigation Menus',
					'description'	 => 'Taxonomy available for selection in <a href="https://codex.wordpress.org/Navigation_Menus" target="_blank">Navigation Menus</a>.',
					'id'			 => 'show_in_nav_menus',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
				),
				31	 =>
				array(
					'label'			 => 'Query',
					'description'	 => 'Direct query variable used in <a href="https://codex.wordpress.org/Class_Reference/WP_Query#Taxonomy_Parameters" target="_blank">WP_Query</a>. e.g. WP_Query( array( <strong>\'taxonomy\' =&gt; \'genre\'</strong>, \'term\' =&gt; \'comedy\' ) )',
					'id'			 => 'query_var',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						''		 => 'Default (taxonomy key)',
						'true'	 => 'Custom query variable',
					),
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Custom Query',
					'description'	 => 'Custom query variable.',
					'id'			 => 'query_var_slug',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'query_var',
						'parent-val' => 'true',
					),
				),
				33	 =>
				array(
					'label'			 => 'Permalink Rewrite',
					'description'	 => 'Use Default <a href="https://codex.wordpress.org/Using_Permalinks" target="_blank">Permalinks</a> (using taxonomy key), prevent automatic URL rewriting (no pretty permalinks), or set custom permalinks.',
					'id'			 => 'rewrite',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'false'	 => 'No permalink (prevent URL rewriting)',
						''		 => 'Default permalink (taxonomy key)',
						'custom' => 'Custom permalink',
					),
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'URL Slug',
					'description'	 => 'Pretty permalink base rewrite text. i.e. www.example.com/ganer/',
					'id'			 => 'rewrite_slug',
					'placeholder'	 => 'taxonomy',
					'type'			 => 'text',
					'default'		 => 'taxonomy',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				35	 =>
				array(
					'label'			 => 'Use URL Slug',
					'description'	 => 'Use taxonomy slug as URL base.<br>Default: Yes',
					'id'			 => 'rewrite_with_front',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				36	 =>
				array(
					'label'			 => 'Hierarchical URL Slug',
					'description'	 => 'Allow hierarchical URLs.<br>Default: No',
					'id'			 => 'rewrite_hierarchical',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
					'data'			 => array(
						'parent'	 => 'rewrite',
						'parent-val' => 'custom',
					),
				),
				37	 =>
				array(
					'label'			 => 'Capabilities',
					'description'	 => 'Set custom <a href="https://codex.wordpress.org/Roles_and_Capabilities" target="_blank">user capabilities</a> to manage taxonomy. Default: category capabilities',
					'id'			 => 'capabilities',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						''		 => 'Default',
						'true'	 => 'Custom capabilities',
					),
					'default'		 => '',
				),
				38	 =>
				array(
					'label'			 => 'Edit Terms',
					'description'	 => '',
					'id'			 => 'capabilities_edit_terms',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'edit_terms',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'true',
					),
				),
				39	 =>
				array(
					'label'			 => 'Delete Terms',
					'description'	 => '',
					'id'			 => 'capabilities_delete_terms',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'delete_terms',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'true',
					),
				),
				40	 =>
				array(
					'label'			 => 'Manage Terms',
					'description'	 => '',
					'id'			 => 'capabilities_manage_terms',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'manage_terms',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'true',
					),
				),
				41	 =>
				array(
					'label'			 => 'Assign Terms',
					'description'	 => '',
					'id'			 => 'capabilities_assign_terms',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'assign_terms',
					'data'			 => array(
						'parent'	 => 'capabilities',
						'parent-val' => 'true',
					),
				),
				42	 =>
				array(
					'label'			 => 'Show in Rest',
					'description'	 => 'Whether to include the taxonomy in the REST API.',
					'id'			 => 'show_in_rest',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
				),
				43	 =>
				array(
					'label'			 => 'Rest Base',
					'description'	 => 'To change the base url of REST API route. Default is the taxonomy key.',
					'id'			 => 'rest_base',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				44	 =>
				array(
					'label'			 => 'Rest Controller Class',
					'description'	 => 'REST API Controller class name. Default is \'WP_REST_Terms_Controller\'.',
					'id'			 => 'rest_controller_class',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				45	 =>
				array(
					'label'			 => 'Update Count Callback',
					'description'	 => 'A function name that will be called when the count of an associated Post Type is updated.',
					'id'			 => 'update_count_callback',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['oEmbed'] = array(
			'tab'		 => 'oEmbed',
			'tab_descr'	 => 'oEmbed Providers',
			'title'		 => 'Use this tool to create custom code to register <a href="http://oembed.com/" target="_blank">oEmbed</a> <a href="https://codex.wordpress.org/Embeds" target="_blank">providers</a> with <a href="https://developer.wordpress.org/reference/functions/wp_oembed_add_provider/" target="_blank">wp_oembed_add_provider()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Provider Format',
					'description'	 => 'The URL structure that this oEmbed provider supports.',
					'id'			 => 'format1',
					'placeholder'	 => 'https://www.example.com/*',
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Endpoint URL',
					'description'	 => 'The base URL to the oEmbed provider.',
					'id'			 => 'provider1',
					'placeholder'	 => 'https://www.example.com/oembed/',
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Format Type (is regex)',
					'description'	 => 'Whether the provider format parameter is a regex string or not.',
					'id'			 => 'regex1',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'True - Regex format',
						'false'	 => 'False - wildcard format',
					),
					'default'		 => 'false',
				),
				4	 =>
				array(
					'label'			 => 'Provider Format',
					'description'	 => 'The URL structure that this oEmbed provider supports.',
					'id'			 => 'format2',
					'placeholder'	 => 'https://www.example.com/*',
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Endpoint URL',
					'description'	 => 'The base URL to the oEmbed provider.',
					'id'			 => 'provider2',
					'placeholder'	 => 'https://www.example.com/oembed/',
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Format Type (is regex)',
					'description'	 => 'Whether the provider format parameter is a regex string or not.',
					'id'			 => 'regex2',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'True - Regex format',
						'false'	 => 'False - wildcard format',
					),
					'default'		 => 'false',
				),
				7	 =>
				array(
					'label'			 => 'Provider Format',
					'description'	 => 'The URL structure that this oEmbed provider supports.',
					'id'			 => 'format3',
					'placeholder'	 => 'https://www.example.com/*',
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Endpoint URL',
					'description'	 => 'The base URL to the oEmbed provider.',
					'id'			 => 'provider3',
					'placeholder'	 => 'https://www.example.com/oembed/',
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Format Type (is regex)',
					'description'	 => 'Whether the provider format parameter is a regex string or not.',
					'id'			 => 'regex3',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'True - Regex format',
						'false'	 => 'False - wildcard format',
					),
					'default'		 => 'false',
				),
				10	 =>
				array(
					'label'			 => 'Provider Format',
					'description'	 => 'The URL structure that this oEmbed provider supports.',
					'id'			 => 'format4',
					'placeholder'	 => 'https://www.example.com/*',
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Endpoint URL',
					'description'	 => 'The base URL to the oEmbed provider.',
					'id'			 => 'provider4',
					'placeholder'	 => 'https://www.example.com/oembed/',
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Format Type (is regex)',
					'description'	 => 'Whether the provider format parameter is a regex string or not.',
					'id'			 => 'regex4',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'True - Regex format',
						'false'	 => 'False - wildcard format',
					),
					'default'		 => 'false',
				),
				13	 =>
				array(
					'label'			 => 'Provider Format',
					'description'	 => 'The URL structure that this oEmbed provider supports.',
					'id'			 => 'format5',
					'placeholder'	 => 'https://www.example.com/*',
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Endpoint URL',
					'description'	 => 'The base URL to the oEmbed provider.',
					'id'			 => 'provider5',
					'placeholder'	 => 'https://www.example.com/oembed/',
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Format Type (is regex)',
					'description'	 => 'Whether the provider format parameter is a regex string or not.',
					'id'			 => 'regex5',
					'placeholder'	 => 'false',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'True - Regex format',
						'false'	 => 'False - wildcard format',
					),
					'default'		 => 'false',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Quicktag'] = array(
			'tab'		 => 'Quicktag',
			'tab_descr'	 => 'Quicktags Generator',
			'title'		 => 'Use this tool to create custom <a href="https://codex.wordpress.org/Quicktags_API" target="_blank">Quicktags</a> for the WordPress text editor.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Quicktag 1 ID',
					'description'	 => 'The html id for the button.',
					'id'			 => 'id1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Quicktag Display',
					'description'	 => 'The html value for the button.',
					'id'			 => 'display1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Starting tag',
					'description'	 => 'HTML starting tag or a callback function.',
					'id'			 => 'arg11',
					'placeholder'	 => 'i.e. <span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Ending tag',
					'description'	 => 'HTML ending tag.',
					'id'			 => 'arg21',
					'placeholder'	 => 'i.e. </span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Access Key',
					'description'	 => 'Shortcut access key for the button.',
					'id'			 => 'access_key1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'The html title value for the button.',
					'id'			 => 'title1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'Button position in the toolbar.',
					'id'			 => 'priority1',
					'placeholder'	 => '1-9 = first, 11-19 = second, 21-29 = third, etc.',
					'type'			 => 'number',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Instance',
					'description'	 => 'Limit the button to a specific instance of quicktags.',
					'id'			 => 'instance1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Quicktag 2 ID',
					'description'	 => 'The html id for the button.',
					'id'			 => 'id2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Quicktag Display',
					'description'	 => 'The html value for the button.',
					'id'			 => 'display2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Starting tag',
					'description'	 => 'HTML starting tag or a callback function.',
					'id'			 => 'arg12',
					'placeholder'	 => 'i.e. <span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Ending tag',
					'description'	 => 'HTML ending tag.',
					'id'			 => 'arg22',
					'placeholder'	 => 'i.e. </span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Access Key',
					'description'	 => 'Shortcut access key for the button.',
					'id'			 => 'access_key2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'The html title value for the button.',
					'id'			 => 'title2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'Button position in the toolbar.',
					'id'			 => 'priority2',
					'placeholder'	 => '1-9 = first, 11-19 = second, 21-29 = third, etc.',
					'type'			 => 'number',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'Instance',
					'description'	 => 'Limit the button to a specific instance of quicktags.',
					'id'			 => 'instance2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Quicktag 3 ID',
					'description'	 => 'The html id for the button.',
					'id'			 => 'id3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'Quicktag Display',
					'description'	 => 'The html value for the button.',
					'id'			 => 'display3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Starting tag',
					'description'	 => 'HTML starting tag or a callback function.',
					'id'			 => 'arg13',
					'placeholder'	 => 'i.e. <span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Ending tag',
					'description'	 => 'HTML ending tag.',
					'id'			 => 'arg23',
					'placeholder'	 => 'i.e. </span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Access Key',
					'description'	 => 'Shortcut access key for the button.',
					'id'			 => 'access_key3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'The html title value for the button.',
					'id'			 => 'title3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'Button position in the toolbar.',
					'id'			 => 'priority3',
					'placeholder'	 => '1-9 = first, 11-19 = second, 21-29 = third, etc.',
					'type'			 => 'number',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Instance',
					'description'	 => 'Limit the button to a specific instance of quicktags.',
					'id'			 => 'instance3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Quicktag 4 ID',
					'description'	 => 'The html id for the button.',
					'id'			 => 'id4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Quicktag Display',
					'description'	 => 'The html value for the button.',
					'id'			 => 'display4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'Starting tag',
					'description'	 => 'HTML starting tag or a callback function.',
					'id'			 => 'arg14',
					'placeholder'	 => 'i.e. <span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Ending tag',
					'description'	 => 'HTML ending tag.',
					'id'			 => 'arg24',
					'placeholder'	 => 'i.e. </span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				29	 =>
				array(
					'label'			 => 'Access Key',
					'description'	 => 'Shortcut access key for the button.',
					'id'			 => 'access_key4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				30	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'The html title value for the button.',
					'id'			 => 'title4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'Button position in the toolbar.',
					'id'			 => 'priority4',
					'placeholder'	 => '1-9 = first, 11-19 = second, 21-29 = third, etc.',
					'type'			 => 'number',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'Instance',
					'description'	 => 'Limit the button to a specific instance of quicktags.',
					'id'			 => 'instance4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Quicktag 5 ID',
					'description'	 => 'The html id for the button.',
					'id'			 => 'id5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Quicktag Display',
					'description'	 => 'The html value for the button.',
					'id'			 => 'display5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				35	 =>
				array(
					'label'			 => 'Starting tag',
					'description'	 => 'HTML starting tag or a callback function.',
					'id'			 => 'arg15',
					'placeholder'	 => 'i.e. <span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				36	 =>
				array(
					'label'			 => 'Ending tag',
					'description'	 => 'HTML ending tag.',
					'id'			 => 'arg25',
					'placeholder'	 => 'i.e. </span>',
					'type'			 => 'text',
					'default'		 => '',
				),
				37	 =>
				array(
					'label'			 => 'Access Key',
					'description'	 => 'Shortcut access key for the button.',
					'id'			 => 'access_key5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				38	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'The html title value for the button.',
					'id'			 => 'title5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				39	 =>
				array(
					'label'			 => 'Priority',
					'description'	 => 'Button position in the toolbar.',
					'id'			 => 'priority5',
					'placeholder'	 => '1-9 = first, 11-19 = second, 21-29 = third, etc.',
					'type'			 => 'number',
					'default'		 => '',
				),
				40	 =>
				array(
					'label'			 => 'Instance',
					'description'	 => 'Limit the button to a specific instance of quicktags.',
					'id'			 => 'instance5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['User Contact'] = array(
			'tab'		 => 'User Contact',
			'tab_descr'	 => 'User Contact Methods Generator',
			'title'		 => 'Use this tool to create custom contact-methods for WordPress user-profile.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Method 1 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'method1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Method 1 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'label1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Method 2 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'method2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Method 2 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'label2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Method 3 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'method3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'Method 3 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'label3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Method 4 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'method4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Method 4 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'label4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'Method 5 Name',
					'description'	 => 'Slug used in the code. Lowercase, with no spaces.',
					'id'			 => 'method5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Method 5 Description',
					'description'	 => 'A short descriptive summary of the menu.',
					'id'			 => 'label5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Toolbar'] = array(
			'tab'		 => 'Toolbar',
			'tab_descr'	 => 'Toolbar Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Toolbar" target="_blank">Toolbar</a> (previously known as Admin Bar) with <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/" target="_blank">WP_Admin_Bar</a> class.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
					'id'			 => 'text_domain',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Toolbar 1 ID',
					'description'	 => 'The ID of the menu.',
					'id'			 => 'id1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Parent ID',
					'description'	 => 'The ID of the parent menu.',
					'id'			 => 'parent1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				4	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'Text/HTML shown in the Toolbar.',
					'id'			 => 'title1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'href',
					'description'	 => 'The \'href\' attribute for the link. If none set the menu will be a text menu.',
					'id'			 => 'href1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Menu Group',
					'description'	 => 'Group menu items together into distinct sections using <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/add_group/" target="_blank">add_group()</a> method.',
					'id'			 => 'group1',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => '',
				),
				7	 =>
				array(
					'label'			 => 'HTML',
					'description'	 => 'The HTML used for the menu.',
					'id'			 => 'html1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Class Attribute',
					'description'	 => 'The class attribute for the list item containing the link or text.',
					'id'			 => 'class_attr1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				9	 =>
				array(
					'label'			 => 'Target Attribute',
					'description'	 => 'The target attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'target_attr1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				10	 =>
				array(
					'label'			 => 'onClick Attribute',
					'description'	 => 'The onclick attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'onclick_attr1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Title Attribute',
					'description'	 => 'The title attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'title_attr1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				12	 =>
				array(
					'label'			 => 'Tabindex Attribute',
					'description'	 => 'The tabindex attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'tabindex_attr1',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Toolbar 2 ID',
					'description'	 => 'The ID of the menu.',
					'id'			 => 'id2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				14	 =>
				array(
					'label'			 => 'Parent ID',
					'description'	 => 'The ID of the parent menu.',
					'id'			 => 'parent2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				15	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'Text/HTML shown in the Toolbar.',
					'id'			 => 'title2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				16	 =>
				array(
					'label'			 => 'href',
					'description'	 => 'The \'href\' attribute for the link. If none set the menu will be a text menu.',
					'id'			 => 'href2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				17	 =>
				array(
					'label'			 => 'Menu Group',
					'description'	 => 'Group menu items together into distinct sections using <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/add_group/" target="_blank">add_group()</a> method.',
					'id'			 => 'group2',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => '',
				),
				18	 =>
				array(
					'label'			 => 'HTML',
					'description'	 => 'The HTML used for the menu.',
					'id'			 => 'html2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				19	 =>
				array(
					'label'			 => 'Class Attribute',
					'description'	 => 'The class attribute for the list item containing the link or text.',
					'id'			 => 'class_attr2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				20	 =>
				array(
					'label'			 => 'Target Attribute',
					'description'	 => 'The target attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'target_attr2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'onClick Attribute',
					'description'	 => 'The onclick attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'onclick_attr2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				22	 =>
				array(
					'label'			 => 'Title Attribute',
					'description'	 => 'The title attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'title_attr2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				23	 =>
				array(
					'label'			 => 'Tabindex Attribute',
					'description'	 => 'The tabindex attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'tabindex_attr2',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				24	 =>
				array(
					'label'			 => 'Toolbar 3 ID',
					'description'	 => 'The ID of the menu.',
					'id'			 => 'id3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				25	 =>
				array(
					'label'			 => 'Parent ID',
					'description'	 => 'The ID of the parent menu.',
					'id'			 => 'parent3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				26	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'Text/HTML shown in the Toolbar.',
					'id'			 => 'title3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				27	 =>
				array(
					'label'			 => 'href',
					'description'	 => 'The \'href\' attribute for the link. If none set the menu will be a text menu.',
					'id'			 => 'href3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				28	 =>
				array(
					'label'			 => 'Menu Group',
					'description'	 => 'Group menu items together into distinct sections using <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/add_group/" target="_blank">add_group()</a> method.',
					'id'			 => 'group3',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => '',
				),
				29	 =>
				array(
					'label'			 => 'HTML',
					'description'	 => 'The HTML used for the menu.',
					'id'			 => 'html3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				30	 =>
				array(
					'label'			 => 'Class Attribute',
					'description'	 => 'The class attribute for the list item containing the link or text.',
					'id'			 => 'class_attr3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				31	 =>
				array(
					'label'			 => 'Target Attribute',
					'description'	 => 'The target attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'target_attr3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				32	 =>
				array(
					'label'			 => 'onClick Attribute',
					'description'	 => 'The onclick attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'onclick_attr3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				33	 =>
				array(
					'label'			 => 'Title Attribute',
					'description'	 => 'The title attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'title_attr3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Tabindex Attribute',
					'description'	 => 'The tabindex attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'tabindex_attr3',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				35	 =>
				array(
					'label'			 => 'Toolbar 4 ID',
					'description'	 => 'The ID of the menu.',
					'id'			 => 'id4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				36	 =>
				array(
					'label'			 => 'Parent ID',
					'description'	 => 'The ID of the parent menu.',
					'id'			 => 'parent4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				37	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'Text/HTML shown in the Toolbar.',
					'id'			 => 'title4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				38	 =>
				array(
					'label'			 => 'href',
					'description'	 => 'The \'href\' attribute for the link. If none set the menu will be a text menu.',
					'id'			 => 'href4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				39	 =>
				array(
					'label'			 => 'Menu Group',
					'description'	 => 'Group menu items together into distinct sections using <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/add_group/" target="_blank">add_group()</a> method.',
					'id'			 => 'group4',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => '',
				),
				40	 =>
				array(
					'label'			 => 'HTML',
					'description'	 => 'The HTML used for the menu.',
					'id'			 => 'html4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				41	 =>
				array(
					'label'			 => 'Class Attribute',
					'description'	 => 'The class attribute for the list item containing the link or text.',
					'id'			 => 'class_attr4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				42	 =>
				array(
					'label'			 => 'Target Attribute',
					'description'	 => 'The target attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'target_attr4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				43	 =>
				array(
					'label'			 => 'onClick Attribute',
					'description'	 => 'The onclick attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'onclick_attr4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				44	 =>
				array(
					'label'			 => 'Title Attribute',
					'description'	 => 'The title attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'title_attr4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				45	 =>
				array(
					'label'			 => 'Tabindex Attribute',
					'description'	 => 'The tabindex attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'tabindex_attr4',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				46	 =>
				array(
					'label'			 => 'Toolbar 5 ID',
					'description'	 => 'The ID of the menu.',
					'id'			 => 'id5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				47	 =>
				array(
					'label'			 => 'Parent ID',
					'description'	 => 'The ID of the parent menu.',
					'id'			 => 'parent5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				48	 =>
				array(
					'label'			 => 'Title',
					'description'	 => 'Text/HTML shown in the Toolbar.',
					'id'			 => 'title5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				49	 =>
				array(
					'label'			 => 'href',
					'description'	 => 'The \'href\' attribute for the link. If none set the menu will be a text menu.',
					'id'			 => 'href5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				50	 =>
				array(
					'label'			 => 'Menu Group',
					'description'	 => 'Group menu items together into distinct sections using <a href="https://developer.wordpress.org/reference/classes/wp_admin_bar/add_group/" target="_blank">add_group()</a> method.',
					'id'			 => 'group5',
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => '',
				),
				51	 =>
				array(
					'label'			 => 'HTML',
					'description'	 => 'The HTML used for the menu.',
					'id'			 => 'html5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				52	 =>
				array(
					'label'			 => 'Class Attribute',
					'description'	 => 'The class attribute for the list item containing the link or text.',
					'id'			 => 'class_attr5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				53	 =>
				array(
					'label'			 => 'Target Attribute',
					'description'	 => 'The target attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'target_attr5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				54	 =>
				array(
					'label'			 => 'onClick Attribute',
					'description'	 => 'The onclick attribute for the link. Will be set if \'href\' is present.',
					'id'			 => 'onclick_attr5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				55	 =>
				array(
					'label'			 => 'Title Attribute',
					'description'	 => 'The title attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'title_attr5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
				56	 =>
				array(
					'label'			 => 'Tabindex Attribute',
					'description'	 => 'The tabindex attribute. Will be set to the link or a div containing a text node.',
					'id'			 => 'tabindex_attr5',
					'placeholder'	 => NULL,
					'type'			 => 'text',
					'default'		 => '',
				),
			),
		);
// </editor-fold>
// <editor-fold>
		$settings['Theme Support'] = array(
			'tab'		 => 'Theme Support',
			'tab_descr'	 => 'Theme Support Generator',
			'title'		 => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Theme_Features" target="_blank">Theme Features</a> with <a href="https://developer.wordpress.org/reference/functions/add_theme_support/" target="_blank">add_theme_support()</a> function.',
			'fields'	 =>
			array(
				0	 =>
				array(
					'label'			 => 'Function Name',
					'description'	 => 'The function used in the code.',
					'id'			 => 'function_name',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => 'function_name',
				),
				1	 =>
				array(
					'label'			 => 'Child Themes',
					'description'	 => 'Add <a href="https://developer.wordpress.org/themes/advanced-topics/child-themes/" target="_blank">Child Themes</a> Support.',
					'id'			 => 'child_themes',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				2	 =>
				array(
					'label'			 => 'Content Width',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Content_Width" target="_blank">Content Width</a> definition. Maximum allowed width for content in the theme.',
					'id'			 => 'content-width',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				3	 =>
				array(
					'label'			 => 'Width',
					'description'	 => 'Set up the content width value (px) based on the theme\'s design.',
					'id'			 => 'content-width-pixels',
					'placeholder'	 => '',
					'type'			 => 'number',
					'default'		 => '600',
					'data'			 => array(
						'parent'	 => 'content-width',
						'parent-val' => 'true',
					),
				),
				4	 =>
				array(
					'label'			 => 'Automatic Feed Links',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Automatic_Feed_Links" target="_blank">Automatic RSS Feed Links</a> for post and comment in HTML &lt;head&gt;.',
					'id'			 => 'automatic-feed-links',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				5	 =>
				array(
					'label'			 => 'Formats',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Post_Formats" target="_blank">Post Formats</a> to customize the content presentation in the theme.',
					'id'			 => 'post-formats',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				6	 =>
				array(
					'label'			 => 'Supported Formats',
					'description'	 => '',
					'id'			 => 'formats_status',
					'list'			 => true,
					'type'			 => 'checkbox_multi',
					'default'		 => '',
					'options'		 => array(
						'status'	 => 'Status',
						'quote'		 => 'Quote',
						'gallery'	 => 'Gallery',
						'image'		 => 'Image',
						'video'		 => 'Video',
						'audio'		 => 'Audio',
						'link'		 => 'Link',
						'aside'		 => 'Aside',
						'chat'		 => 'Chat',
					),
					'data'			 => array(
						'parent'	 => 'post-formats',
						'parent-val' => 'true',
					),
				),
				7	 =>
				array(
					'label'			 => 'Image Thumbnails',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Post_Thumbnails" target="_blank">Featured Image</a> support.',
					'id'			 => 'post-thumbnails',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				8	 =>
				array(
					'label'			 => 'Post Types',
					'description'	 => 'Apply thumbnails for those post types',
					'id'			 => 'thumbnails-types',
					'data'			 => array(
						'parent'	 => 'post-thumbnails',
						'parent-val' => 'true',
					),
					'placeholder'	 => '',
					'type'			 => 'select',
					'options'		 =>
					array(
						'posts'	 => 'Posts',
						'custom' => 'Custom',
					),
					'default'		 => 'posts',
				),
				9	 =>
				array(
					'label'			 => 'Custom Types',
					'description'	 => 'Comma separated list of <a href="https://codex.wordpress.org/Post_Types" target="_blank">Post Types</a>.',
					'id'			 => 'thumbnails-custom-types',
					'list'			 => true,
					'placeholder'	 => 'post,page,movie',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'thumbnails-types',
						'parent-val' => 'custom',
					),
				),
				10	 =>
				array(
					'label'			 => 'Set Custom Dimensions',
					'description'	 => 'Set custom width and height for thumbnails.',
					'id'			 => 'set-thumbnails-dimensions',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'data'			 => array(
						'parent'	 => 'post-thumbnails',
						'parent-val' => 'true',
					),
					'default'		 => '',
				),
				11	 =>
				array(
					'label'			 => 'Thumbnail Dimensions',
					'description'	 => 'Custom image width and height.',
					'id'			 => 'thumbnails',
					'type'			 => 'number_double',
					'min'			 => 0,
					'options'		 => array(
						'width'	 => 0,
						'height' => 0,
					),
					'data'			 => array(
						'parent'	 => 'set-thumbnails-dimensions',
						'parent-val' => 'true',
					),
				),
				12	 =>
				array(
					'label'			 => 'Custom Background',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Custom_Backgrounds" target="_blank">Custom Background</a> support',
					'id'			 => 'custom-background',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				13	 =>
				array(
					'label'			 => 'Default Color',
					'description'	 => 'Set default background color.',
					'id'			 => 'background-default-color',
					'placeholder'	 => 'e.g. 000000, ffffff',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				14	 =>
				array(
					'label'			 => 'Default Image',
					'description'	 => 'Set default background image',
					'id'			 => 'background-default-image',
					'placeholder'	 => '../images/background.jpg',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				15	 =>
				array(
					'label'			 => 'Default Image repeat',
					'description'	 => 'Set default background image repeat.',
					'id'			 => 'background-default-repeat',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				16	 =>
				array(
					'label'			 => 'Default Image position-x',
					'description'	 => 'Set default background image position-x.',
					'id'			 => 'background-default-position-x',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				17	 =>
				array(
					'label'			 => 'Head Callback',
					'description'	 => 'WordPress head callback function.',
					'id'			 => 'background-wp-head-callback',
					'placeholder'	 => 'Default: _custom_background_cb',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				18	 =>
				array(
					'label'			 => 'Admin Head Callback',
					'description'	 => 'Admin head callback function.',
					'id'			 => 'background-admin-head-callback',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				19	 =>
				array(
					'label'			 => 'Admin Preview Callback',
					'description'	 => 'Admin preview callback function.',
					'id'			 => 'background-admin-preview-callback',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-background',
						'parent-val' => 'true',
					),
				),
				20	 =>
				array(
					'label'			 => 'Custom Header',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Custom_Headers" target="_blank">Custom Header</a> image support.',
					'id'			 => 'custom-header',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				21	 =>
				array(
					'label'			 => 'Default Image',
					'description'	 => 'Default header image. Full URL.',
					'id'			 => 'header-default-image',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				22	 =>
				array(
					'label'			 => 'Image Dimensions',
					'description'	 => 'Header image width &amp; height.',
					'id'			 => 'header',
					'type'			 => 'number_double',
					'min'			 => 0,
					'options'		 => array(
						'width'	 => 0,
						'height' => 0,
					),
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				23	 =>
				array(
					'label'			 => 'Flexible Dimensions',
					'description'	 => 'Allow flexible width &amp; height.',
					'id'			 => 'header-flex',
					'type'			 => 'select_double',
					'options'		 =>
					array(
						'false'	 => 'No',
						'true'	 => 'Yes',
					),
					'selects'		 => array(
						'width'	 => 'true',
						'height' => 'true',
					),
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				24	 =>
				array(
					'label'			 => 'Upload Other Images',
					'description'	 => 'Allow to upload other header images.',
					'id'			 => 'header-uploads',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				25	 =>
				array(
					'label'			 => 'Random Image Rotation',
					'description'	 => 'Allow random image rotation.',
					'id'			 => 'header-random-default',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				26	 =>
				array(
					'label'			 => 'Header Text',
					'description'	 => 'Display default header text.',
					'id'			 => 'header-header-text',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'false',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				27	 =>
				array(
					'label'			 => 'Header Text Color',
					'description'	 => 'Default header text color.',
					'id'			 => 'header-default-text-color',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'header-header-text',
						'parent-val' => 'true',
					),
				),
				28	 =>
				array(
					'label'			 => 'Head Callback',
					'description'	 => 'WordPress head callback function.',
					'id'			 => 'header-wp-head-callback',
					'placeholder'	 => 'Default: _custom_header_cb',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				29	 =>
				array(
					'label'			 => 'Admin Head Callback',
					'description'	 => 'Admin head callback function.',
					'id'			 => 'header-admin-head-callback',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				30	 =>
				array(
					'label'			 => 'Admin Preview Callback',
					'description'	 => 'Admin preview callback function.',
					'id'			 => 'header-admin-preview-callback',
					'placeholder'	 => '',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				31	 =>
				array(
					'label'			 => 'Video',
					'description'	 => 'Support custom videos as headers.',
					'id'			 => 'header-video',
					'placeholder'	 => 'true',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						'false'	 => 'No',
					),
					'default'		 => 'true',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				32	 =>
				array(
					'label'			 => 'Video Callback',
					'description'	 => 'Callback used to determine whether the video should be shown for the current request.',
					'id'			 => 'header-video-active-callback',
					'placeholder'	 => 'Dedault: is_front_page',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'custom-header',
						'parent-val' => 'true',
					),
				),
				33	 =>
				array(
					'label'			 => 'Semantic Markup',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Semantic_Markup" target="_blank">Semantic Markup</a> to improve theme HTML5 markup.',
					'id'			 => 'semantic-markup',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				34	 =>
				array(
					'label'			 => 'Markup For Search Form',
					'description'	 => '',
					'id'			 => 'markup_search',
					'placeholder'	 => '',
					'type'			 => 'checkbox_multi',
					'list'			 => true,
					'default'		 => '',
					'options'		 => array(
						'search-form'	 => 'Search Form',
						'comment-form'	 => 'Comment Form',
						'comment-list'	 => 'Comment List',
						'gallery'		 => 'Gallery',
						'caption'		 => 'Caption',
					),
					'data'			 => array(
						'parent'	 => 'semantic-markup',
						'parent-val' => 'true',
					),
				),
				35	 =>
				array(
					'label'			 => 'Title Tag',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Title_Tag" target="_blank">Title Tag</a> support in HTML <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">.',
					'id'			 => 'title-tag',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				36	 =>
				array(
					'label'			 => 'TinyMCE Editor Style',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/Editor_Style" target="_blank">TinyMCE Editor Style</a> to customize the content presentation in the visual editor.',
					'id'			 => 'editor-style',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				37	 =>
				array(
					'label'			 => 'Stylesheet File',
					'description'	 => 'Path to the stylesheet file, relative to the theme directory.',
					'id'			 => 'editor-style-file',
					'placeholder'	 => 'Default: editor-style.css',
					'type'			 => 'text',
					'default'		 => '',
					'data'			 => array(
						'parent'	 => 'editor-style',
						'parent-val' => 'true',
					),
				),
				38	 =>
				array(
					'label'			 => 'Set Theme Translation File',
					'description'	 => 'Enable <a href="https://codex.wordpress.org/I18n_for_WordPress_Developers" target="_blank">internationalization</a>.',
					'id'			 => 'theme-translation',
					'type'			 => 'select',
					'options'		 =>
					array(
						'true'	 => 'Yes',
						''		 => 'No',
					),
					'default'		 => '',
				),
				39	 =>
				array(
					'label'			 => 'Text Domain',
					'description'	 => 'Unique identifier for retrieving translated strings.',
					'id'			 => 'textdomain',
					'placeholder'	 => 'text_domain',
					'type'			 => 'text',
					'default'		 => 'text_domain',
					'data'			 => array(
						'parent'	 => 'theme-translation',
						'parent-val' => 'true',
					),
				),
				40	 =>
				array(
					'label'			 => 'Text Domain Path',
					'description'	 => 'The directory where the .mo file can be found.',
					'id'			 => 'textdomain-path',
					'placeholder'	 => '/language',
					'type'			 => 'text',
					'default'		 => '/language',
					'data'			 => array(
						'parent'	 => 'theme-translation',
						'parent-val' => 'true',
					),
				),
			),
		);
// </editor-fold>
// PREMIUM
		/*
		  // <editor-fold>
		  $settings['Widgets'] = array (
		  'tab' => 'Widgets',
		  'tab_descr' => 'Widgets Generator',
		  'title' => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Widgets_API" target="_blank">Widgets</a> with <a href="https://developer.wordpress.org/reference/classes/wp_widget/" target="_blank">WP_Widget</a> class.',
		  'fields' =>
		  array (
		  0 =>
		  array (
		  'label' => 'Class Name',
		  'description' => 'The class name used in the code.',
		  'id' => 'class_name',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class_name',
		  ),
		  1 =>
		  array (
		  'label' => 'Prefix',
		  'description' => 'Unique string placed in front of root elements.',
		  'id' => 'prefix',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'prefix',
		  ),
		  2 =>
		  array (
		  'label' => 'Text Domain',
		  'description' => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
		  'id' => 'text_domain',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => '',
		  ),
		  3 =>
		  array (
		  'label' => 'Widget ID',
		  'description' => 'Used in the code as HTML ID attribute.',
		  'id' => 'widget_id',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'widget_id',
		  ),
		  4 =>
		  array (
		  'label' => 'Title',
		  'description' => 'Widget title.',
		  'id' => 'widget_title',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'title',
		  ),
		  5 =>
		  array (
		  'label' => 'Description',
		  'description' => 'The text that describes the widget.',
		  'id' => 'widget_description',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  6 =>
		  array (
		  'label' => 'Class',
		  'description' => 'The widget class name.',
		  'id' => 'widget_classname',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class',
		  ),
		  7 =>
		  array (
		  'label' => 'Widget Code',
		  'description' => 'The widget output displayed in the front-end.',
		  'id' => 'widget_code',
		  'placeholder' => NULL,
		  'type' => 'textarea',
		  'default' => 'widget_code',
		  ),
		  8 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype1',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  9 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  10 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  11 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  12 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  13 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  14 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options1',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  15 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype2',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  16 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  17 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  18 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  19 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  20 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  21 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options2',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  22 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype3',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  23 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  24 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  25 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  26 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  27 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  28 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options3',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  29 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype4',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  30 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  31 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  32 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  33 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  34 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  35 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options4',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  36 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype5',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  37 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  38 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  39 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  40 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  41 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  42 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options5',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  43 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype6',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  44 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  45 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  46 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  47 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  48 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  49 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options6',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  50 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype7',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  51 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  52 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  53 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  54 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  55 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  56 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options7',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  57 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype8',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  58 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  59 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  60 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  61 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  62 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  63 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options8',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  64 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype9',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  65 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  66 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  67 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  68 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  69 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  70 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options9',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  ),
		  );
		  // </editor-fold>

		  // <editor-fold>
		  $settings['Term Meta'] = array (
		  'tab' => 'Term Meta',
		  'tab_descr' => 'Term Meta Generator',
		  'title' => 'Use this tool to create custom code for Taxonomy Meta Fields, commonly known as Term Meta.',
		  'fields' =>
		  array (
		  0 =>
		  array (
		  'label' => 'Class Name',
		  'description' => 'The class name used in the code.',
		  'id' => 'class_name',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class_name',
		  ),
		  1 =>
		  array (
		  'label' => 'Prefix',
		  'description' => 'Unique string placed in front of root elements.',
		  'id' => 'prefix',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'prefix',
		  ),
		  2 =>
		  array (
		  'label' => 'Text Domain',
		  'description' => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
		  'id' => 'text_domain',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => '',
		  ),
		  3 =>
		  array (
		  'label' => 'Taxonomy',
		  'description' => 'The taxomony in use.',
		  'id' => 'taxonomy',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'taxonomy',
		  ),
		  4 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype1',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  5 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  6 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  7 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  8 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  9 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  10 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options1',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  11 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype2',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  12 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  13 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  14 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  15 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  16 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  17 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options2',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  18 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype3',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  19 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  20 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  21 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  22 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  23 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  24 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options3',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  25 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype4',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  26 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  27 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  28 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  29 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  30 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  31 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options4',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  32 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype5',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  33 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  34 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  35 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  36 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  37 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  38 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options5',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  39 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype6',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  40 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  41 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  42 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  43 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  44 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  45 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options6',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  46 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype7',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  47 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  48 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  49 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  50 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  51 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  52 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options7',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  53 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype8',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  54 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  55 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  56 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  57 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  58 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  59 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options8',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  60 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype9',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'oembed' => 'oEmbed',
		  ),
		  'default' => 'type',
		  ),
		  61 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  62 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  63 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears after the field.',
		  'id' => 'description9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  64 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  65 =>
		  array (
		  'label' => 'Default value',
		  'description' => 'Default field value.',
		  'id' => 'default9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  66 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options9',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  ),
		  );
		  // </editor-fold>

		  // <editor-fold>
		  $settings['Meta Box'] = array (
		  'tab' => 'Meta Box',
		  'tab_descr' => 'Meta Box Generator',
		  'title' => 'Use this tool to create custom code for WordPress <a href="https://codex.wordpress.org/Custom_Fields" target="_blank">Meta Boxes</a> using <a href="https://developer.wordpress.org/reference/functions/add_meta_box/" target="_blank">add_meta_box()</a> function.',
		  'fields' =>
		  array (
		  0 =>
		  array (
		  'label' => 'Class Name',
		  'description' => 'The class name used in the code.',
		  'id' => 'class_name',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class_name',
		  ),
		  1 =>
		  array (
		  'label' => 'Prefix',
		  'description' => 'Unique string placed in front of root elements.',
		  'id' => 'prefix',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'prefix',
		  ),
		  2 =>
		  array (
		  'label' => 'Text Domain',
		  'description' => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
		  'id' => 'text_domain',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => '',
		  ),
		  3 =>
		  array (
		  'label' => '<span style="color:red">Security Checks
		  WP Nonce
		  </span>',
		  'description' => '',
		  'id' => '604d1098af9cb',
		  'placeholder' => 'SOMETHING NEW',
		  'type' => 'text',
		  'default' => 'SOMETHING NEW',
		  ),
		  4 =>
		  array (
		  'label' => 'Meta Box ID',
		  'description' => 'Used in the code as HTML ID attribute.',
		  'id' => 'id',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'meta_box_id',
		  ),
		  5 =>
		  array (
		  'label' => 'Title',
		  'description' => 'Meta box title.',
		  'id' => 'title',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'title',
		  ),
		  6 =>
		  array (
		  'label' => 'Callback Function',
		  'description' => 'The name of the callback function.',
		  'id' => 'callback_function',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'callback_function',
		  ),
		  7 =>
		  array (
		  'label' => 'Screen',
		  'description' => 'Comma separated list of screens or <a href="https://codex.wordpress.org/Post_Types" target="_blank">post types</a>.',
		  'id' => 'post_type',
		  'list' => true,
		  'placeholder' => 'post,page',
		  'type' => 'text',
		  'default' => 'post,page',
		  ),
		  8 =>
		  array (
		  'label' => 'Page Location',
		  'description' => 'In which page part to show the meta box.',
		  'id' => 'context',
		  'placeholder' => 'advanced',
		  'type' => 'select',
		  'options' =>
		  array (
		  'normal' => 'Normal',
		  'advanced' => 'Advanced',
		  'side' => 'Side',
		  ),
		  'default' => 'advanced',
		  ),
		  9 =>
		  array (
		  'label' => 'Priority',
		  'description' => 'Priority within the context to show the meta box.',
		  'id' => 'priority',
		  'placeholder' => 'default',
		  'type' => 'select',
		  'options' =>
		  array (
		  'high' => 'High',
		  'core' => 'Core',
		  'default' => 'Default',
		  'low' => 'Low',
		  ),
		  'default' => 'default',
		  ),
		  10 =>
		  array (
		  'label' => 'Callback Arguments',
		  'description' => 'Arguments array passed to the callback function.',
		  'id' => 'callback_args',
		  'placeholder' => 'array( \'1\' => \'foo\', \'2\' => \'bar\' )',
		  'type' => 'text',
		  'default' => 'array( \'1\' => \'foo\', \'2\' => \'bar\' )',
		  ),
		  11 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype1',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  12 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  13 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  14 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  15 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  16 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  17 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options1',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  18 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype2',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  19 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  20 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  21 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  22 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  23 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  24 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options2',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  25 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype3',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  26 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  27 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  28 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  29 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  30 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  31 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options3',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  32 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype4',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  33 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  34 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  35 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  36 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  37 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  38 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options4',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  39 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype5',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  40 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  41 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  42 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  43 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  44 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  45 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options5',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  46 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype6',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  47 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  48 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  49 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  50 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  51 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  52 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options6',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  53 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype7',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  54 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  55 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  56 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  57 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  58 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  59 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options7',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  60 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype8',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  61 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  62 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  63 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  64 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  65 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  66 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options8',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  67 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype9',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  'wysiwyg' => 'Editor',
		  'oembed' => 'oEmbed',
		  'pages' => 'Pages',
		  'categories' => 'Categories',
		  'users' => 'Users',
		  ),
		  'default' => 'type',
		  ),
		  68 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  69 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  70 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  71 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  72 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  73 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options9',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  ),
		  );
		  // </editor-fold>

		  // <editor-fold>
		  $settings['Settings Page'] = array (
		  'tab' => 'Settings Page',
		  'tab_descr' => 'Settings Page',
		  'title' => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Administration_Menus" target="_blank" rel="noopener">Settings Pages</a> with <a href="https://developer.wordpress.org/reference/functions/add_options_page/" target="_blank" rel="noopener">add_options_page</a> function.',
		  'fields' =>
		  array (
		  0 =>
		  array (
		  'label' => 'Class Name',
		  'description' => 'The class name used in the code.',
		  'id' => 'class_name',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class_name',
		  ),
		  1 =>
		  array (
		  'label' => 'Setting Group',
		  'description' => 'Name of the settings group used in <a href="https://developer.wordpress.org/reference/functions/register_setting/" target="_blank">register_setting</a>.',
		  'id' => 'settings_group',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'setting_group',
		  ),
		  2 =>
		  array (
		  'label' => 'Setting Name',
		  'description' => 'Name of the <a href="https://developer.wordpress.org/reference/functions/get_option/" target="_blank">options</a> saved in the database.',
		  'id' => 'settings',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'setting_name',
		  ),
		  3 =>
		  array (
		  'label' => 'Text Domain',
		  'description' => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
		  'id' => 'text_domain',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => '',
		  ),
		  4 =>
		  array (
		  'label' => 'Menu Type',
		  'description' => '.',
		  'id' => 'menu_type',
		  'placeholder' => 'add_options_page',
		  'type' => 'select',
		  'options' =>
		  array (
		  'add_menu_page' => 'New Menu',
		  'add_submenu_page' => 'New Submenu',
		  'add_dashboard_page' => 'Dashboard Submenu',
		  'add_posts_page' => 'Posts Submenu',
		  'add_media_page' => 'Media Submenu',
		  'add_pages_page' => 'Pages Submenu',
		  'add_comments_page' => 'Comments Submenu',
		  'add_theme_page' => 'Appearance Submenu',
		  'add_plugins_page' => 'Plugins Submenu',
		  'add_users_page' => 'Users Submenu',
		  'add_management_page' => 'Tools Submenu',
		  'add_options_page' => 'Settings Submenu',
		  ),
		  'default' => 'add_options_page',
		  ),
		  5 =>
		  array (
		  'label' => 'Parent Menu',
		  'description' => 'Slug of the parent menu.',
		  'id' => 'submenu',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'parent_menu',
		  ),
		  6 =>
		  array (
		  'label' => 'Page Title',
		  'description' => 'Settings page title.',
		  'id' => 'page-title',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'page_title',
		  ),
		  7 =>
		  array (
		  'label' => 'Menu Title',
		  'description' => 'Admin sidebar menu title.',
		  'id' => 'menu-title',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'menu_title',
		  ),
		  8 =>
		  array (
		  'label' => 'User Capability',
		  'description' => 'Access permision <a href="https://codex.wordpress.org/Roles_and_Capabilities#Capabilities" target="_blank">capability</a>.',
		  'id' => 'capability',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'user_capability',
		  ),
		  9 =>
		  array (
		  'label' => 'Slug',
		  'description' => 'Unique slug for the admin page.',
		  'id' => 'menu_slug',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'slug',
		  ),
		  10 =>
		  array (
		  'label' => 'Callback Function',
		  'description' => 'The name of the layout function.',
		  'id' => 'callback_function',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'callback_function',
		  ),
		  11 =>
		  array (
		  'label' => 'Sidebar Icon',
		  'description' => 'Use <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">dashicon</a> or full icon URL.',
		  'id' => 'menu_icon',
		  'placeholder' => 'i.e. dashicons-admin-tools',
		  'type' => 'text',
		  'default' => 'i.e. dashicons-admin-tools',
		  ),
		  12 =>
		  array (
		  'label' => 'Menu Position',
		  'description' => 'Sidebar menu position.',
		  'id' => 'menu_position',
		  'placeholder' => '99',
		  'type' => 'select',
		  'options' =>
		  array (
		  2 => '2 - below Dashboard',
		  4 => '4 - below Separator',
		  5 => '5 - below Posts',
		  10 => '10 - below Media',
		  15 => '15 - below Links',
		  20 => '20 - below Pages',
		  25 => '25 - below Comments',
		  59 => '59 - below Separator',
		  60 => '60 - below Appearance',
		  65 => '65 - below Plugins',
		  70 => '70 - below Users',
		  75 => '75 - below Tools',
		  80 => '80 - below Settings',
		  99 => '99 - below Separator',
		  ),
		  'default' => '99',
		  ),
		  13 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype1',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  14 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  15 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  16 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  17 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  18 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default1',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  19 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options1',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  20 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype2',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  21 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  22 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  23 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  24 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  25 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default2',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  26 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options2',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  27 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype3',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  28 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  29 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  30 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  31 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  32 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default3',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  33 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options3',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  34 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype4',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  35 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  36 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  37 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  38 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  39 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default4',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  40 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options4',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  41 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype5',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  42 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  43 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  44 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  45 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  46 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default5',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  47 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options5',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  48 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype6',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  49 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  50 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  51 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  52 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  53 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default6',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  54 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options6',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  55 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype7',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  56 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  57 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  58 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  59 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  60 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default7',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  61 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options7',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  62 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype8',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  63 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  64 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  65 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  66 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  67 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default8',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  68 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options8',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  69 =>
		  array (
		  'label' => 'Type',
		  'description' => 'Select field type.',
		  'id' => 'fieldtype9',
		  'placeholder' => '',
		  'type' => 'select',
		  'options' =>
		  array (
		  ' ' => '- Select -',
		  'text' => 'Text',
		  'number' => 'Number',
		  'email' => 'Email',
		  'url' => 'URL',
		  'password' => 'Password',
		  'textarea' => 'Text Area',
		  'checkbox' => 'True/False',
		  'checkboxes' => 'Checkboxes',
		  'radio' => 'Radio',
		  'select' => 'Select',
		  'date' => 'Date',
		  'time' => 'Time',
		  'color' => 'Color',
		  ),
		  'default' => 'type',
		  ),
		  70 =>
		  array (
		  'label' => 'ID',
		  'description' => 'Unique ID used in the code.',
		  'id' => 'id9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  71 =>
		  array (
		  'label' => 'Label',
		  'description' => 'Text appears before the field.',
		  'id' => 'label9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'label',
		  ),
		  72 =>
		  array (
		  'label' => 'Description',
		  'description' => 'Text appears below the field.',
		  'id' => 'description9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'description',
		  ),
		  73 =>
		  array (
		  'label' => 'Field Placeholder',
		  'description' => 'Text appears within the input.',
		  'id' => 'placeholder9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'field_placeholder',
		  ),
		  74 =>
		  array (
		  'label' => 'Default Value',
		  'description' => 'Default field value.',
		  'id' => 'default9',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'default_value',
		  ),
		  75 =>
		  array (
		  'label' => 'Multiple Options',
		  'description' => 'For select and radio fields. Set value|label, each fields in new line.',
		  'id' => 'options9',
		  'placeholder' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  'type' => 'textarea',
		  'default' => 'value1|Label 1
		  value2|Label 2
		  value3|Label 3',
		  ),
		  ),
		  );
		  // </editor-fold>

		  // <editor-fold>
		  $settings['Dashboard Widgets'] = array (
		  'tab' => 'Dashboard Widgets',
		  'tab_descr' => 'Dashboard Widgets Generator',
		  'title' => 'Use this tool to create custom code for <a href="https://codex.wordpress.org/Dashboard_Widgets_API" target="_blank">Dashboard Widgets</a> with <a href="https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/" target="_blank">wp_add_dashboard_widget()</a> function.',
		  'fields' =>
		  array (
		  0 =>
		  array (
		  'label' => 'Class Name',
		  'description' => 'The class name used in the code.',
		  'id' => 'class_name',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'class_name',
		  ),
		  1 =>
		  array (
		  'label' => 'Text Domain',
		  'description' => 'Translation file <a href="https://developer.wordpress.org/reference/functions/load_textdomain/" target="_blank">Text Domain</a>. Optional.',
		  'id' => 'text_domain',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => '',
		  ),
		  2 =>
		  array (
		  'label' => 'ID',
		  'description' => 'ID used in the code identifying the widget.',
		  'id' => 'id',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'id',
		  ),
		  3 =>
		  array (
		  'label' => 'Title',
		  'description' => 'The title that will be displayed in its heading.',
		  'id' => 'title',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'title',
		  ),
		  4 =>
		  array (
		  'label' => 'Render Function',
		  'description' => 'The function that displays the widget content.',
		  'id' => 'render_function',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'render_function',
		  ),
		  5 =>
		  array (
		  'label' => 'Submission Function',
		  'description' => 'The function that handles widget submission.',
		  'id' => 'submission_function',
		  'placeholder' => NULL,
		  'type' => 'text',
		  'default' => 'submission_function',
		  ),
		  6 =>
		  array (
		  'label' => 'Callback Arguments',
		  'description' => 'Arguments array passed to the callback function.',
		  'id' => 'callback_args',
		  'placeholder' => 'array( \'1\' => \'foo\', \'2\' => \'bar\' )',
		  'type' => 'text',
		  'default' => 'array( \'1\' => \'foo\', \'2\' => \'bar\' )',
		  ),
		  7 =>
		  array (
		  'label' => 'Render Code',
		  'description' => 'Custom code that displays the widget content.',
		  'id' => 'render_code',
		  'placeholder' => NULL,
		  'type' => 'textarea',
		  'default' => 'render_code',
		  ),
		  8 =>
		  array (
		  'label' => 'Submission Code',
		  'description' => 'Custom code that handles widget submission.',
		  'id' => 'submission_code',
		  'placeholder' => NULL,
		  'type' => 'textarea',
		  'default' => 'submission_code',
		  ),
		  ),
		  );
		  // </editor-fold>

		 */

		$settings = apply_filters( 'generatewp_field_settings', $settings );

		return $settings;
	}


}
