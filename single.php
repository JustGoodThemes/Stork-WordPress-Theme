<?php
/**
 * The template for displaying single posts
 */
?>
<?php get_header(); ?>
	<div id="content" role="main">
		<div class="inner">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content' ); ?>
				<nav class="nextprev-nav">
					<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'jgtstork' ); ?></h3>
					<span class="nav-prev"><?php previous_post_link('%link', '&larr; %title'); ?></span>
					<span class="nav-next"><?php next_post_link('%link', '%title &rarr;'); ?></span>
				</nav><!-- .nav-single -->
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div><!-- .inner -->
	</div><!-- #content -->
<?php get_footer(); ?>