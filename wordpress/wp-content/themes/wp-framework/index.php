<?php get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<h1 class="ctitle"><?php _e( 'Latest Posts', 'wpeasy' ); ?></h1>
		<?php get_template_part('loop'); ?>
		<?php get_template_part('pagination'); ?>
	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
