<div class="comments">

  <?php if (post_password_required()) : ?>
    <p><?php _e( 'Post is password protected. Enter the password to view any comments.', 'wpeasy' ); ?></p>
  <?php return; endif; ?>

  <?php if (have_comments()) : ?>

    <h5><?php comments_number(); ?></h5>
    <ul>
      <?php wp_list_comments('type=comment&callback=html5blankcomments'); // Custom callback in functions.php ?>
    </ul>

  <?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

    <p><?php _e( 'Comments are closed here.', 'wpeasy' ); ?></p>

  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- comments -->
