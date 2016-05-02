<?php
/**
 * The template for displaying image attachments
 */
?>
<?php get_header(); ?>
	<div id="content" role="main">
		<div class="inner">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<?php
							// Image date
							echo '<time class="published attachment-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . get_the_date() . '</time>';
							// Image dimensions
							$metadata = wp_get_attachment_metadata();
							printf( ' / <a href="%1$s" title="%2$s">%3$s &times; %4$s</a>', wp_get_attachment_url(), __( 'Link to full-size image', 'jgtstork' ), $metadata['width'], $metadata['height'] );
							// Post link
							$post_title = get_the_title( $post->post_parent );
							if ( ! empty( $post_title ) && 0 != $post->post_parent ) {
								echo ' / <span class="published-in">';
								printf( __( 'Published in %s', 'jgtstork' ), sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', esc_url( get_permalink( $post->post_parent ) ), sprintf( __( 'Return to %s', 'jgtstork' ), esc_attr( strip_tags( $post_title ) ) ), $post_title ) );
								echo '</span>';
							}
							// Post edit link
							edit_post_link( __( 'Edit', 'jgtstork' ), ' / <span class="edit-link">', '</span>' );
								?>
						</div>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<div class="attachment">
							<?php echo wp_get_attachment_image( get_the_ID(), 'full', false ); ?>
						</div>
						<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div><!-- .entry-caption -->
						<?php endif; ?>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'jgtstork' ), 'after' => '</p>', 'link_before' => '<span class="page-link">', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->
					<?php 
					if ( 0 != $post->post_parent ) :
						$gallery = gallery_shortcode( array( 'columns' => 4, 'id' => $post->post_parent, 'exclude' => get_the_ID() ) );
						if ( !empty( $gallery ) ) : 
					?>
					<footer class="attachment-meta">
						<h3><?php _e( 'Gallery', 'jgtstork' ); ?></h3>
						<?php echo $gallery; ?>
					</footer>
					<?php 
						endif;
					endif;
					?>
				</article><!-- #post -->
			<?php endwhile; ?>
			<?php comments_template(); ?>
		</div><!-- .inner -->
	</div><!-- #content -->
<?php get_footer(); ?>