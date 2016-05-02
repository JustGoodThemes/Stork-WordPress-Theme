<?php
/**
 * The template for displaying search results
 */
?>
<?php get_header(); ?>
	<section id="content" role="main">
		<div class="inner">
			<?php if ( have_posts() ) : ?>
				<?php $search_results = new WP_Query( array( 's' => $s, 'posts_per_page' => -1 ) ); $total = $search_results->post_count; ?>
				<header class="page-header">
					<h1 class="page-title"><?php printf( _n( 'Your search for %1$s returned %2$s result', 'Your search for %1$s returned %2$s results', $total, 'jgtstork' ), '<strong>&#147;' . get_search_query() . '&#148;</strong>', number_format_i18n( $total ) ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<?php get_search_form(); ?>
					<ul class="posts-list">
						<?php /* The loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<li>
								<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if (get_the_title()) the_title(); else the_ID(); ?></a><?php if ('post' == get_post_type()) { ?>, <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time><?php } ?>
								<?php the_excerpt(); ?>
							</li>
						<?php endwhile; ?>
					</ul>
					<?php jgstork_loop_navigation(); ?>
				</div><!-- .page-content -->
			<?php else : ?>
				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'No Search Results for %s', 'jgtstork' ), '<strong>&#147;' . get_search_query() . '&#148;</strong>' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p class="page-note"><?php _e( 'Sorry, but nothing matched your search criteria. Make sure all words are spelled correctly or try again with some different keywords.', 'jgtstork' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			<?php endif; ?>			
		</div><!-- .inner -->
	</section><!-- #content -->
<?php get_footer(); ?>