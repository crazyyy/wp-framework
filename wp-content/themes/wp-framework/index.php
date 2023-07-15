<?php get_header(); ?>

    <header class="page-header">
      <?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
        <h1 class="page-title"><?php single_post_title(); ?></h1>
      <?php else: ?>
        <h1 class="page-title"><?php _e( 'Latest Posts', 'wpeb' ); ?></h1>
      <?php endif; ?>
    </header><!-- .page-header -->

    <?php get_template_part( 'template-parts/loop' ); ?>
    <?php get_template_part('template-parts/pagination'); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
