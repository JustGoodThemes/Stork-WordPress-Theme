<?php
/**
 * The main template file
 */
?>
<?php get_header(); ?>
	<div id="content" role="main">
		<div class="inner">
			<?php if ( have_posts() ) : ?>
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>
				<?php endwhile; ?>
				<?php jgstork_loop_navigation(); ?>
			<?php else: ?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing found', 'jgtstork' ); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive.', 'jgtstork' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
		</div><!-- .inner -->
	</div><!-- #content -->
<?php get_footer(); ?>