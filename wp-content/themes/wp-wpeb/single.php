<?php get_header(); ?>
  <section class="container" role="main" itemscope itemprop="mainContentOfPage">
    <div class="grid">

      <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        <header class="post-header col-12">
          <h1 class="post-title">
            <?php the_title(); ?>
          </h1>
        </header><!-- /.post-header -->

        <article id="post-<?php the_ID(); ?>" <?php post_class('post-article col-9'); ?>>

          <?php if ( has_post_thumbnail()) :?>
            <a class="single-thumb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php the_post_thumbnail(); // Filesize image for the single post ?>
            </a>
          <?php endif; ?>

          <div class="post-date">
            <?php the_time('d F Y'); ?> <?php the_time('H:i'); ?>
          </div><!-- /.post-date -->

          <div class="post-author">
            <?php _e( 'Published by', 'wpeb' ); ?> <?php the_author_posts_link(); ?>
          </div><!-- /.post-author -->

          <div class="post-comments">
            <?php comments_popup_link( __( 'Leave your thoughts', 'wpeb' ), __( '1 Comment', 'wpeb' ), __( '% Comments', 'wpeb' )); ?>
          </div><!-- /.post-comments -->

          <?php the_content(); ?>

          <?php the_tags( __( 'Tags: ', 'wpeb' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

          <p><?php _e( 'Categorized in: ', 'wpeb' ); the_category(', '); // Separated by commas ?></p>

          <p><?php _e( 'This post was written by ', 'wpeb' ); the_author(); ?></p>

          <?php edit_post_link(); ?>

          <?php comments_template(); ?>

        </article><!-- /.post-article -->
      <?php endwhile; endif; ?>

      <?php get_sidebar(); ?>

    </div><!-- /.grid -->
  </section><!-- /section .container -->
<?php get_footer(); ?>
