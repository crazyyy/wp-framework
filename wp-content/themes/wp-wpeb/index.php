<?php get_header(); ?>
  <section class="container" role="main" itemscope itemprop="mainContentOfPage">
    <div class="grid">
      <header class="post-header col-12">
        <?php if (is_home() && ! is_front_page() && ! empty( single_post_title('',false))) : ?>
          <h1 class="post-title"><?php single_post_title(); ?></h1>
        <?php else: ?>
          <h1 class="post-title"><?php _e('Latest Posts', 'wpeb'); ?></h1>
        <?php endif; ?>
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

    </div><!-- /.grid -->
  </section><!-- /section .container -->
<?php get_footer(); ?>

