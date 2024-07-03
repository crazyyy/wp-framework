<aside class="widget-area sidebar col-3" role="complementary">
  <?php if ( is_active_sidebar('widget-area-1') ) : ?>
    <?php dynamic_sidebar( 'widget-area-1' ); ?>
  <?php else : ?>
    <!-- If you want display static widget content - write code here -->
  <?php endif; ?>
</aside><!-- /.widget-area .sidebar -->
