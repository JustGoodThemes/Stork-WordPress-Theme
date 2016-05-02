<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header class="site-header" role="banner">
		<div class="inner">
			<h1 class="site-title">
				<?php
					if ( jgtstork_get_option( 'logo' ) != '' ) {
						$logo_width = jgtstork_get_option( 'logo_width' ) ? ' width="' . jgtstork_get_option( 'logo_width' ) . '"' : '';
						echo '<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home" class="logo-img"><img src="' . esc_url( jgtstork_get_option( 'logo' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"' . $logo_width . ' /></a>';
					} else {
						echo '<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="logo-text">' . get_bloginfo( 'name', 'display' ) . '</a>';
					}
				?>
			</h1>
			<?php if ( jgtstork_get_option( 'show_tagline' ) ) { ?>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<?php } ?>
		</div> <!-- .inner -->
	</header><!-- .site-header -->
	<nav class="site-navigation<?php if ( jgtstork_get_option( 'animated_nav' ) ) echo ' animated-navigation'; ?>" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Menu', 'jgtstork' ); ?></h3>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-wrap', 'depth' => 1 ) ); ?>
		<a href="#" id="menu-toggle" title="<?php _e( 'Show Menu', 'jgtstork' ); ?>"><i aria-hidden="true" class="icon-plus"></i></a>
	</nav><!-- .site-navigation -->