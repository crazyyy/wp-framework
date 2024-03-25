<?php get_header(); ?>

<header class="post-header col-12">
  <h1 class="post-title">
    <?php _e( 'Page not found', 'wpeb' ); ?>
  </h1>
</header><!-- .post-header -->

<article id="post-<?php the_ID(); ?>" <?php post_class('container-404 col-9'); ?>>

  <h2>
    <a href="<?php echo home_url(); ?>">
      <?php _e( 'Return home?', 'wpeb' ); ?>
    </a>
  </h2>

</article>
<!-- /.container-404 -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
