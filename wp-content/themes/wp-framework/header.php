<?php
/**
 * Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package axio
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <title><?php wp_title( '' ); ?><?php if ( wp_title( '', false ) ) { echo ' :'; } ?> <?php bloginfo( 'name' ); ?>
    </title>

    <link href="//www.google-analytics.com/" rel="dns-prefetch">
    <link href="//fonts.googleapis.com" rel="dns-prefetch">
    <link href="//cdnjs.cloudflare.com" rel="dns-prefetch">

    <!-- icons -->
    <link href="<?php echo get_template_directory_uri(); ?>/favicon.ico" rel="shortcut icon">

    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- css + javascript -->
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
    <?php wp_body_open(); ?>
    <!-- wrapper -->
    <div class="wrapper">
      <header role="banner">
        <div class="inner">

          <div class="logo">
            <?php if (!is_front_page() && !is_home()) : ?>
            <a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
              <?php endif; ?>

              <?php if (function_exists('the_custom_logo')) : ?>
              <?php the_custom_logo(); ?>
              <?php endif; ?>

              <?php if (!is_front_page() && !is_home()) : ?>
            </a>
            <?php endif; ?>
          </div><!-- /logo -->

          <nav class="nav" role="navigation">
            <?php wpeb_header_navigation(); ?>
          </nav><!-- /nav -->

        </div><!-- /.inner -->
      </header><!-- /header -->

      <section role="main" itemscope itemprop="mainContentOfPage">
        <div class="inner">
