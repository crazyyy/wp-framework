<?php get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<!-- article -->
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			<h1 class="page-title inner-title"><?php the_title(); ?></h1>

			<?php the_content(); ?>

			<?php comments_template( '', true ); ?>

			<?php edit_post_link(); ?>
		<?php endwhile; else: // If 404 page error ?>
			<h2 class="page-title inner-title"><?php _e( 'Sorry, nothing to display.', 'wpeasy' ); ?></h2>
		<?php endif; ?>
		</article>
		<!-- /article -->
	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
