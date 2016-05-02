<?php
/**
 * The template for displaying Archive pages
 */
?>
<?php get_header(); ?>
	<section id="content" role="main">
		<div class="inner">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php
						if ( is_day() ) :
							printf( __( 'Archive for %s', 'jgtstork' ), '<strong>' . get_the_date() . '</strong>' );
						elseif ( is_month() ) :
							printf( __( 'Archive for %s', 'jgtstork' ), '<strong>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'jgtstork' ) ) . '</strong>' );
						elseif ( is_year() ) :
							printf( __( 'Archive for %s', 'jgtstork' ), '<strong>' . get_the_date( _x( 'Y', 'yearly archives date format', 'jgtstork' ) ) . '</strong>' );
						elseif ( is_category() ) :
							printf( __( 'All Posts in %s', 'jgtstork' ), '<strong>&#147;' . single_cat_title( '', false ) . '&#148;</strong>' );
						elseif ( is_tag() ) :
							printf( __( 'All Posts Tagged %s', 'jgtstork' ), '<strong>&#147;' . single_tag_title( '', false ) . '&#148;</strong>' );
						else :
							_e( 'Archives', 'jgtstork' );
						endif;
					?></h1>
				</header><!-- .archive-header -->
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>
				<?php endwhile; ?>
				<?php jgstork_loop_navigation(); ?>
			<?php else: ?>
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Nothing found', 'jgtstork' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive.', 'jgtstork' ); ?></p>
				</div><!-- .page-content -->
			<?php endif; ?>
		</div><!-- .inner -->
	</section><!-- #content -->
<?php get_footer(); ?>