<?php /* Template Name: Home Page */ get_header(); ?>

  <section class="front-page" role="main" itemscope itemprop="mainContentOfPage">
    <div class="container">
      <div class="grid">

        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

          <header class="page-header col-12">
            <h1 class="page-title">
              <?php the_title(); ?>
            </h1>
          </header><!-- /.page-header col-12 -->

          <article id="post-<?php the_ID(); ?>" <?php post_class('col-9'); ?>>

            <?php the_content(); ?>

            <?php edit_post_link(); ?>

          </article><!-- /.<?php post_class(); ?>> -->

        <?php endwhile; endif; ?>

        <?php get_sidebar(); ?>

      </div><!-- /.grid -->
    </div><!-- /.container -->
  </section><!-- /front-page -->

<?php get_footer(); ?>
