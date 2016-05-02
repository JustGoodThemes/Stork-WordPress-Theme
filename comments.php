<?php
/**
 * The template for displaying Comments
 */
?>
<?php if ( post_password_required() )
	return;
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php printf( _n( '1 Comment', '%s Comments', get_comments_number(), 'jgtstork' ), number_format_i18n( get_comments_number() ) ); ?> / <a href="#respond"><?php _e( 'Add your own comment below', 'jgtstork' ); ?></a>
		</h3>
		<ol class="commentlist">
			<?php 
				wp_list_comments( array( 
					'style' => 'ol',
					'callback' => 'jgtstork_comment'
				) ); 
			?>
		</ol><!-- .commentlist -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="nextprev-nav" role="navigation">
			<h3 class="screen-reader-text"><?php _e( 'Comment navigation', 'jgtstork' ); ?></h3>
			<span class="nav-prev"><?php previous_comments_link( __( '&larr; Older Comments', 'jgtstork' ) ); ?></span>
			<span class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jgtstork' ) ); ?></span>
		</nav><!-- .nextprev-nav -->
		<?php endif; // check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="comments-closed"><?php _e( 'Comments are closed.' , 'jgtstork' ); ?></p>
		<?php endif; ?>
	<?php endif; // have_comments() ?>
	<?php comment_form( array( 'comment_notes_after' => '' ) ); ?>
</div><!-- #comments -->