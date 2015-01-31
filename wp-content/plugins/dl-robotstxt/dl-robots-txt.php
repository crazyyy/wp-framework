<?php
/*
Plugin Name: DL Robots.txt
Description: DL Robots.txt Позволяет редактировать содержимое вашего файла robots.txt и задавать оптимальные настройки для поисковых одним кликом мышки
Plugin URI: http://vcard.dd-l.name/wp-plugins/
Version: 1.2
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name
*/


add_action( 'admin_menu', 'dl_robotstxt_menu_page' );

function dl_robotstxt_menu_page(){ 
    add_menu_page( 
		'dl-robots',
		'DL Robots.txt',
		'administrator',
		'dl-robotstxt/options-page.php',
		'',
		'dashicons-format-aside'
		);

	//call register settings function
	add_action( 'admin_init', 'dl_robots_register_settings' );
}


// Добавляем допалнительную ссылку настроек на страницу всех плагинов
function dl_robotstxt_settings_link($links) {
  $settings_link = '<a href="admin.php?page=dl-robotstxt/options-page.php">Параметры</a>';
  array_unshift($links, $settings_link);
  return $links;
}
$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'dl_robotstxt_settings_link' );


// регистрируем настройки
function dl_robots_register_settings() {
	register_setting( 'dl-robots-settings', 'dl_robots_option' );
	register_setting( 'dl-robots-settings', 'blog_public' );
}

// Формируем страницу 
function dl_robots_menu_page() {

} 


add_filter( 'robots_txt' , 'dl_robots_change' , 10 , 2);

function dl_robots_change ( $source_text , $public ) {
	if ( '1' == $public ) {
		$source_text .= "\n# DL Robots.txt \n" . get_option('dl_robots_option') . "\n";
	}
	return $source_text;
}