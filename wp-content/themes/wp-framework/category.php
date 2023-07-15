<?php get_header(); ?>
  <article>

    <h1 class="cat-title inner-title"><?php the_category(', '); ?></h1>
    <?php get_template_part( 'template-parts/loop' ); ?>
    <?php get_template_part('template-parts/pagination'); ?>

  </article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
