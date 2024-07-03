<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
  <label>
    <input class="search-field"
      type="search"
      name="s"
      placeholder="<?php _e( 'To search, type and hit enter.', 'wpeb' ); ?>"
      value="<?php echo get_search_query(); ?>" >
  </label>
  <button class="search-submit" type="submit" role="button">
    <i class="fa fa-search" aria-hidden="true"></i>
  </button>
</form><!-- /.search-form -->
