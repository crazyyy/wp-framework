<?php get_header(); ?>

<header class="post-header col-12">
  <h1 class="post-title">
    <?php the_category(', '); ?>
  </h1>
</header><!-- .post-header -->

<div class="loop-container col-9">
  <div class="container">
    <div class="grid">

      <?php get_template_part('template-parts/loop'); ?>

      <?php get_template_part('template-parts/pagination'); ?>

    </div>
    <!-- /.grid -->
  </div>
  <!-- /.container -->
</div>
<!-- /.loop-container -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
