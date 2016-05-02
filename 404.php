<?php
/**
 * The template for displaying 404 pages
 */
?>
<?php get_header(); ?>
	<section id="content" role="main">
		<div class="inner">
			<header class="page-header">
				<h1 class="page-title"><span><?php _e( '404 - Page Not Found!', 'jgtstork' ); ?></span></h1>
			</header><!-- .page-header -->
			<div class="page-content">
				<p class="page-note"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'jgtstork' ); ?></p>
				<?php get_search_form(); ?>
				<h2 class="posts-list-title"><?php _e( 'Latest Posts', 'jgtstork' ); ?></h2>
				<ul class="posts-list"><?php wp_get_archives( array( 'type' => 'postbypost', 'limit' => 15 ) ); ?></ul>	
			</div><!-- .page-content -->
		</div><!-- .inner -->
	</section><!-- #content -->
<?php get_footer(); ?>