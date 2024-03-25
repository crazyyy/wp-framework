<?php
  /**
   * Displays the site header.
   * @package WordPress
   * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
   */

  $wrapper_classes  = 'container site-header';
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

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <!-- icons -->
  <link href="<?php echo get_template_directory_uri(); ?>/img/favicon/icon.png" rel="shortcut icon">

  <!--[if lt IE 9]>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
  <?php wp_body_open(); ?>
  <!-- wrapper -->
  <div class="wrapper">

    <header id="masthead" class="<?php echo esc_attr($wrapper_classes); ?>" role="banner">
      <div class="grid">

        <div class="header__logo col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <?php
          $logo_id = get_theme_mod( 'dark_logo_setting' );
          if ( $logo_id ) {
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
            echo '<img src="' . esc_url( $logo_url ) . '" alt="' . get_bloginfo( 'name' ) . '">';
          } elseif (function_exists('the_custom_logo')) {
            the_custom_logo();
          }
          ?>
        </div><!-- /.header__logo -->

        <nav class="header__nav col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6" role="navigation">
          <?php wp_nav_menu(array('theme_location' => 'header-menu')); ?>
        </nav><!-- /.header__nav -->

      </div><!-- /.grid -->
    </header><!-- /header .container-->

    <section class="container" role="main" itemscope itemprop="mainContentOfPage">
      <div class="grid">
