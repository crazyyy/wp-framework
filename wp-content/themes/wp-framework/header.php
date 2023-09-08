<?php
  /**
   * Displays the site header.
   * @package WordPress
   * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
   */

  $wrapper_classes  = 'site-header';
  $wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <title>
    <?php wp_title(''); ?><?php if (wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?>
  </title>

  <link href="//www.google-analytics.com/" rel="dns-prefetch">
  <link href="//fonts.googleapis.com" rel="dns-prefetch">
  <link href="//cdnjs.cloudflare.com" rel="dns-prefetch">
  <link href="//cdn.jsdelivr.net" rel="dns-prefetch">

  <!-- icons -->
  <link href="<?php echo get_template_directory_uri(); ?>/img/favicon/icon.png" rel="shortcut icon">

  <!--[if lt IE 9]>
      <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
  <?php wp_body_open(); ?>
  <!-- wrapper -->
  <div class="wrapper">
    <header id="masthead" class="<?php echo esc_attr($wrapper_classes); ?>" role="banner">
      <div class="inner">

        <div class="site-logo">
          <?php if (!is_front_page() && !is_home()) : ?>
            <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
            <?php endif; ?>

            <?php if (function_exists('the_custom_logo')) {
              the_custom_logo();
            } ?>

            <?php if (!is_front_page() && !is_home()) : ?>
            </a>
          <?php endif; ?>
        </div><!-- /site-logo -->

        <nav class="nav" role="navigation">
          <?php /* wp_nav_menu(array('theme_location' => 'header-menu')); */ ?>
        </nav><!-- /nav -->

      </div><!-- /.inner -->
    </header><!-- #masthead -->

    <section role="main" itemscope itemprop="mainContentOfPage">
      <div class="inner">
