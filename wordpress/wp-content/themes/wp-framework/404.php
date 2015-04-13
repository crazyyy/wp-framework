<?php get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="title"><?php _e( 'Page not found', 'wpeasy' ); ?></h1>
			<h2><a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'wpeasy' ); ?></a></h2>
		</article>
		<!-- /article -->
	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
