<?php get_header(); ?>

	<?php if ( have_posts() ) { ?>
    <header class="page-header">
      <h1 class="page-title">
        <?php
        printf( esc_html__( 'Results for "%s"', 'wpeb' ),
          '<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
        );
        ?>
      </h1>
    </header><!-- .page-header -->

    <div class="search-result-count default-max-width">
      <?php
      printf(
        esc_html(
          _n(
            'We found %d result for your search.',
            'We found %d results for your search.',
            (int) $wp_query->found_posts,
            'wpeb'
          )
        ),
        (int) $wp_query->found_posts
      );
      ?>
    </div><!-- .search-result-count -->

    <?php get_template_part( 'template-parts/loop' ); ?>
    <?php get_template_part( 'template-parts/pagination' ); ?>

    <?php } else { ?>

      <header class="page-header">
        <h1 class="page-title"><?php __( 'Nothing Found', 'wpeb' ); ?></h1>
      </header><!-- .page-header -->

    <?php } ?>

  <?php get_sidebar(); ?>

<?php get_footer(); ?>
