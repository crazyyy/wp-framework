<?php get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<h1 class="search-title inner-title"><?php echo sprintf( __( '%s Search Results for ', 'wpeasy' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
		<?php get_template_part('loop'); ?>
		<?php get_template_part('pagination'); ?>
	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
