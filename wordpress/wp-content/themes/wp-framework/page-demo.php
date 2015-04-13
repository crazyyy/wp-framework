<?php /* Template Name: Demo Page Template */ get_header(); ?>
<div class="container inner">

	<!-- section -->
	<section role="main">
		<h1 class="title"><?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2 class="title"><?php _e( 'Sorry, nothing to display.', 'wpeasy' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

	</section>
	<!-- /section -->

	<?php get_sidebar(); ?>
</div>
<!-- /.container -->
<?php get_footer(); ?>
