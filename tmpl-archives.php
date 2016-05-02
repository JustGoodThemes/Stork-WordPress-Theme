<?php
/**
 * Template Name: Archives
 * Description: displays a list of categories, tags and latest posts
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
						<div class="grid">
							<div class="one-half">
								<h2 class="archive-list-title"><?php _e( 'Latest 20 Posts', 'jgtstork' ); ?></h2>					
								<ul class="archive-list"><?php wp_get_archives( array( 'type' => 'postbypost', 'limit' => 20 ) ); ?></ul>					
								<h2 class="archive-list-title"><?php _e( 'By Subject', 'jgtstork' ); ?></h2>
								<ul class="archive-list"><?php wp_list_categories( array( 'show_count' => 1, 'title_li' => '' ) ); ?></ul>
							</div>
							<div class="one-half">
								<h2 class="archive-list-title"><?php _e( 'By Month', 'jgtstork' ); ?></h2>
								<ul class="archive-list"><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul>
								<h2 class="archive-list-title"><?php _e( 'By Year', 'jgtstork' ); ?></h2>
								<ul class="archive-list"><?php wp_get_archives( array( 'type' => 'yearly' ) ); ?></ul>
							</div>
						</div>
					</div><!-- .entry-content -->
				</article><!-- #post -->
			<?php endwhile; ?>
		</div><!-- .inner -->
	</div><!-- #content -->
<?php get_footer(); ?>