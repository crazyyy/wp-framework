<?php get_header(); ?>

  <?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <header class="page-header col-12">
      <h1 class="page-title">
        <?php the_title(); ?>
      </h1>
    </header><!-- /.page-header col-12 -->

    <article id="post-<?php the_ID(); ?>" <?php post_class('col-9'); ?>>

      <?php the_content(); ?>

      <?php edit_post_link(); ?>

    </article>

  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

<?php get_footer(); ?>
