<?php get_header(); ?>

  <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <h1 class="single-title inner-title"><?php the_title(); ?></h1>
      <?php if ( has_post_thumbnail()) :?>
        <a class="single-thumb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
          <?php the_post_thumbnail(); // Filesize image for the single post ?>
        </a>
      <?php endif; ?><!-- /post thumbnail -->

      <span class="date"><?php the_time('d F Y'); ?> <?php the_time('H:i'); ?></span>
      <span class="author"><?php _e( 'Published by', 'wpeb' ); ?> <?php the_author_posts_link(); ?></span>
      <span class="comments"><?php comments_popup_link( __( 'Leave your thoughts', 'wpeb' ), __( '1 Comment', 'wpeb' ), __( '% Comments', 'wpeb' )); ?></span><!-- /post details -->

      <?php the_content(); ?>

      <?php the_tags( __( 'Tags: ', 'wpeb' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

      <p><?php _e( 'Categorized in: ', 'wpeb' ); the_category(', '); // Separated by commas ?></p>

      <p><?php _e( 'This post was written by ', 'wpeb' ); the_author(); ?></p>

      <?php edit_post_link(); ?>

      <?php comments_template(); ?>

    </article>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

<?php get_footer(); ?>
