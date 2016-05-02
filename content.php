<?php
/**
 * The default template for displaying content. Used for single, index, archive
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="featured-img">
			<?php if ( is_single() ) : ?>
				<?php the_post_thumbnail(); ?>
			<?php else : ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jgtstork' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a>
			<?php endif; // is_single() ?>
		</div>
		<?php endif; // has_post_thumbnail() ?>
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jgtstork' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php endif; // is_single() ?>
		<div class="entry-meta">
			<?php 
			// entry date
			printf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="published" datetime="%3$s">%4$s</time></a>',
				esc_url( get_permalink() ),
				esc_attr( sprintf( __( 'Permalink to %s', 'jgtstork' ), the_title_attribute( 'echo=0' ) ) ),
				esc_attr( get_the_date( 'c' ) ),
				get_the_date()
			);
			// entry author
			printf( '<span class="entry-author"> / <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'jgtstork' ), get_the_author() ) ),
				get_the_author()
			);
			// entry categories
			$categories_list = get_the_category_list( __( ', ', 'jgtstork' ) );
			if ( $categories_list )
				echo ' / ' . $categories_list;
			// entry comments link
			if (comments_open()) :
				echo ' / ';
				comments_popup_link( __( 'Leave a Reply', 'jgtstork' ), __( '1 Reply', 'jgtstork' ), __( '% Replies', 'jgtstork' ) );
			endif;
			// entry edit link
			edit_post_link( __( 'Edit', 'jgtstork' ), ' / <span class="edit-link">', '</span>' );
			?>
		</div>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content( __( 'Read More', 'jgtstork' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'jgtstork' ), 'after' => '</p>', 'link_before' => '<span class="page-link">', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php if ( is_single() ) : ?>
	<footer class="entry-meta">
		<?php if ( is_multi_author() && get_the_author_meta( 'description' ) ) { ?>
		<div class="author-box">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 120 ); ?>
			<h3 class="author-title"><?php printf( __( 'About %s', 'jgtstork' ), get_the_author() ); ?></h3>
			<p class="author-bio"><?php the_author_meta( 'description' ); ?><br /><a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( __( 'View all posts by %s &rarr;', 'jgtstork' ), get_the_author() ); ?></a></p>
		</div><!-- .author-box -->
		<?php } ?>
		<?php 
		$tag_list = get_the_tag_list( __( 'Tagged: ', 'jgtstork' ) );
		if ( $tag_list )
			echo '<div class="tag-links">' . $tag_list . '</div>';
		?> 
	</footer><!-- .entry-meta -->
	<?php endif; // is_single() ?>
</article><!-- #post -->