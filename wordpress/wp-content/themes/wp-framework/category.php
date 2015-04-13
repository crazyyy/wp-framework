<?php get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<h1 class="cat-title inner-title"><?php _e( 'Categories for', 'wpeasy' ); the_category(', '); ?></h1>
		<?php get_template_part('loop'); ?>
		<?php get_template_part('pagination'); ?>
	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
