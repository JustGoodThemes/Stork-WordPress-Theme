<?php
/**
 * The template for displaying pages
 */
?>
<?php get_header(); ?>
	<div id="content" role="main">
		<div class="inner">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="featured-img">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; // has_post_thumbnail() ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php if ( get_edit_post_link() ) { ?>
							<div class="entry-meta">
								<?php edit_post_link( __( 'Edit', 'jgtstork' ), '<span class="edit-link">', '</span>' ); ?>
							</div>
						<?php } ?>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'jgtstork' ), 'after' => '</p>', 'link_before' => '<span class="page-link">', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div><!-- .inner -->
	</div><!-- #content -->
<?php get_footer(); ?>