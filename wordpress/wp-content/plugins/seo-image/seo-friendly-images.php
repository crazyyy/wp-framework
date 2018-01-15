<?php
/*
Plugin Name: SEO Friendly Images
Plugin URI: http://www.prelovac.com/vladimir/wordpress-plugins/seo-friendly-images
Description: Automatically adds alt and title attributes to all your images. Improves traffic from search results and makes them W3C/xHTML valid as well.
Version: 3.0.5
Author: Vladimir Prelovac
Author URI: http://www.prelovac.com/vladimir

Copyright 2008-2011  Vladimir Prelovac  vprelovac@gmail.com

*/	

if ( isset( $seo_friendly_images_pro ) ) return false;
require_once( dirname( __FILE__ ) . '/seo-friendly-images.class.php' );
$seo_friendly_images_pro = new SEOFriendlyImages();

?>
