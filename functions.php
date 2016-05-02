<?php

/**
 * Set the content width based on the theme's design and stylesheet
 */
if ( ! isset( $content_width ) )
	$content_width = 780;

if ( ! function_exists( 'jgtstork_setup' ) ) :
/**
 * Run jgtstork_setup() when the after_setup_theme hook is run
 */
function jgtstork_setup() {

	// Make theme available for translation
	load_theme_textdomain( 'jgtstork', get_template_directory() . '/languages' );

	// Style the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', jgtstork_font_url() ) );

	// Add RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );

	// Register a menu location
	register_nav_menu( 'primary', __( 'Navigation Menu', 'jgtstork' ) );

	// Add support for featured images
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1560, 9999 );

	// This theme uses its own gallery styles
	add_filter( 'use_default_gallery_style', '__return_false' );

}
endif;
add_action( 'after_setup_theme', 'jgtstork_setup' );

/**
 * Register four widget areas in the footer
 */
function jgtstork_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 1', 'jgtstork' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears in the footer section of the site', 'jgtstork' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 2', 'jgtstork' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears in the footer section of the site', 'jgtstork' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 3', 'jgtstork' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears in the footer section of the site', 'jgtstork' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 4', 'jgtstork' ),
		'id' => 'sidebar-4',
		'description' => __( 'Appears in the footer section of the site', 'jgtstork' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
}
add_action( 'widgets_init', 'jgtstork_widgets_init' );

/**
 * Register Source Sans Pro Google font
 */
function jgtstork_font_url() {
	$font_url = add_query_arg( 'family', urlencode( 'Source Sans Pro:400,400italic,700,700italic' ), "http://fonts.googleapis.com/css" );
	return $font_url;
}

/**
 * Enqueue scripts and styles
 */
function jgtstork_scripts_styles() {
	
	// Add Source Sans Pro font, used in the main stylesheet
	wp_enqueue_style( 'jgtstork-fonts', jgtstork_font_url(), array(), null );

	// Load the main stylesheet
	wp_enqueue_style( 'jgtstork-style', get_stylesheet_uri() );

	// Load the IE specific stylesheet
	wp_enqueue_style( 'jgtstork-ie', get_template_directory_uri() . '/css/ie.css', array( 'jgtstork-style' ), '1.0' );
	wp_style_add_data( 'jgtstork-ie', 'conditional', 'lt IE 9' );

	// Add JS to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	// Add custom scripts
	wp_enqueue_script( 'jgtstork-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'jgtstork_scripts_styles' );

/**
 * Create a nicely formatted and more specific title element
 */
function jgtstork_wp_title( $title, $sep ) {
	if ( is_feed() )
		return $title;

	global $paged, $page;

	// Add the site name
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'jgtstork' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'jgtstork_wp_title', 10, 2 );

/**
 * Change wp_nav_menu() fallback, wp_page_menu(), container class and depth
 */
function jgtstork_page_menu_args( $args ) {
	$args['depth'] = 1;
	$args['menu_class'] = 'menu-wrap';
	return $args;
}
add_filter( 'wp_page_menu_args', 'jgtstork_page_menu_args' );

/**
 * Add custom classes to the array of body classes
 */
function jgtstork_body_class( $classes ) {
	// For use in JavaScript and CSS files
	$classes[] = 'no-js';

	// Check if it is a single author blog
	if ( ! is_multi_author() )
		$classes[] = 'single-author';
	
	return $classes;
}
add_filter( 'body_class', 'jgtstork_body_class' );

if ( !function_exists( 'jgstork_loop_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable
 */
function jgstork_loop_navigation() {
	// Don't print anything if there's only one page
	if ( $GLOBALS['wp_query']->max_num_pages < 2 )
		return;

	$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args = array();
	$url_parts = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) )
		wp_parse_str( $url_parts[1], $query_args );
	
	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'jgtstork' ),
		'next_text' => __( 'Next &rarr;', 'jgtstork' ),
	) );

	if ( $links ) :
	?>
	<nav class="paginated-nav" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Posts navigation', 'jgtstork' ); ?></h3>
		<?php echo $links; ?>
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

/**
 * Change the number of posts in author archives and search results
 */
function jgtstork_posts_number( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
        return;
	
	if ( is_author() || is_search() ) {
		$query->set( 'posts_per_page', 9 );
		return;
    }
}
add_filter( 'pre_get_posts', 'jgtstork_posts_number' );

/**
 * Customize tag cloud widget
 */
function jgtstork_custom_tag_cloud_widget( $args ) {
	$args['number'] = 0;
	$args['largest'] = 14;
	$args['smallest'] = 14;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'jgtstork_custom_tag_cloud_widget' );

/**
 * Wrap "Read more" link
 */
function jgtstork_wrap_more_link( $more ) {
    return '<div class="read-more">' . $more . '</div>';
}
add_filter( 'the_content_more_link','jgtstork_wrap_more_link' ); 

/**
 * Wrap [embed] shortcode output in a container for scaling
 */
function jgtstork_wrap_embed( $html, $url, $attr ) {
	$before = '';
	$after = '';
	$accepted_sites = array(
		'youtu.be',
		'youtube',
		'vimeo',
		'slideshare',
		'dailymotion',
		'viddler.com',
		'hulu.com',
		'blip.tv',
		'revision3.com',
		'funnyordie.com',
		'wordpress.tv',
		'scribd.com'
	);
	foreach ( $accepted_sites as $site ) {
		if ( strstr( $url, $site ) ) {
			$before = '<div class="embed-container">';
			$after = '</div>';
			break;
		}
	}
	return $before . $html . $after;
}
add_filter( 'embed_oembed_html', 'jgtstork_wrap_embed', 10, 3 );

if ( ! function_exists( 'jgtstork_comment' ) ) :
/**
 * Template for comments and pingbacks, used as a callback by wp_list_comments()
 */
function jgtstork_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :	
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'jgtstork' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'jgtstork' ), ' <span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
	default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta comment-author vcard">
				<?php
				echo get_avatar( $comment, 78 );
				printf( '<cite class="fn">%1$s %2$s</cite>',
					get_comment_author_link(),
					( $comment->user_id === $post->post_author ) ? '<span class="post-author"> ' . __( 'Post author', 'jgtstork' ) . '</span>' : ''
				);
				printf( '<a href="%1$s" class="comment-date"><time datetime="%2$s">%3$s</time></a>',
					esc_url( get_comment_link( $comment->comment_ID ) ),
					get_comment_time( 'c' ),
					sprintf( __( '%1$s at %2$s', 'jgtstork' ), get_comment_date(), get_comment_time() )
				);
			?>
			</div><!-- .comment-meta -->
			<?php if ( '0' == $comment->comment_approved ) { ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'jgtstork' ); ?></p>
			<?php } ?>
			<div class="comment-content">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'jgtstork' ), '<div class="edit-link">', '</div>' ); ?>
			</div><!-- .comment-content -->
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply &darr;', 'jgtstork' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**
 * Add theme options
 */
require get_template_directory() . '/includes/theme-options.php';

/**
 * Output custom colors CSS into <head>
 */
function jgtstork_custom_colors() {

	// Get custom colors
	$primary_color = jgtstork_get_option( 'primary_color' );
	$secondary_color = jgtstork_get_option( 'secondary_color' );

	// If it is the default colors, return 
	if ( '#3366c8' == $primary_color && '#ff5148' == $secondary_color )
		return;

	// Get the cached style, output the style if it is available and return
	$style = wp_cache_get( 'custom_colors' );
	if ( !empty( $style ) ) { 
		echo $style;
		return;
	}

	// Put the final style output together
	$style = "\n" . '<style type="text/css" id="custom-colors-css">a,.entry-meta,.social-title{color:' . $primary_color . ';}a:hover,.site-navigation a:hover,.author-box a:hover,a.comment-date:hover,.comment-meta a.url:hover,.nextprev-nav a:hover,.paginated-nav a:hover,.paginated-nav .current,.copyright a:hover,.supplementary a:hover,a#back-to-top:hover{color:' . $secondary_color . ';}input[type="text"]:focus,input[type="email"]:focus,input[type="password"]:focus,input[type="search"]:focus,textarea:focus{border-color:' . $secondary_color . ';}button,input[type="submit"],input[type="button"],input[type="reset"]{background:' . $primary_color . ';border-color:' . $primary_color . ';}button:hover,input[type="submit"]:hover,input[type="button"]:hover,input[type="reset"]:hover,.site-title a.logo-text:hover,#wp-calendar tbody a:hover,.supplementary .tagcloud a:hover{background:' . $secondary_color . ';border-color:' . $secondary_color . ';}.site-header,.site-navigation .menu-wrap,#menu-toggle,.read-more .more-link,.author-box,.post-edit-link,.comment-edit-link,.comment-meta .post-author,#cancel-comment-reply-link,.site-footer{background:' . $primary_color . ';}.read-more a.more-link:hover,.tag-links a:hover,a.post-edit-link:hover,a.comment-edit-link:hover,#cancel-comment-reply-link:hover{background:' . $secondary_color . ';}</style>' . "\n";

	// Cache the style, so we don't have to process this on each page load
	wp_cache_set( 'custom_colors', $style );

	// Output the custom style
	echo $style;
}
add_action( 'wp_head', 'jgtstork_custom_colors' );
?>