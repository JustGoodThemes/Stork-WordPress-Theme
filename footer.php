<?php 
$socnet = array(
	'twitter' => __( 'Twitter', 'jgtstork' ),
	'facebook' => __( 'Facebook', 'jgtstork' ),	
	'googleplus' => __( 'Google+', 'jgtstork' ),
	'pinterest' => __( 'Pinterest', 'jgtstork' ),	
	'tumblr' => __( 'Tumblr', 'jgtstork' ),
	'instagram' => __( 'Instagram', 'jgtstork' ),
	'flickr' => __( 'Flickr', 'jgtstork' ),
	'linkedin' => __( 'LinkedIn', 'jgtstork' ),
	'dribbble' => __( 'Dribbble', 'jgtstork' ),
	'github' => __( 'GitHub', 'jgtstork' ),
	'vimeo' => __( 'Vimeo', 'jgtstork' ),
	'youtube' => __( 'YouTube', 'jgtstork' ),	
	'rss' => __( 'RSS', 'jgtstork' )
);
$socnet_links = '';
foreach ( $socnet as $key => $val ) {
	if ( jgtstork_get_option( $key ) != '' )
		$socnet_links .= '<a href="' . esc_url( jgtstork_get_option( $key ) ) . '" class="socnet-link" title="' . $val . '"><i aria-hidden="true" class="icon-' . $key . '"></i><span class="screen-reader-text">' . $val . '</span></a>';
}
if ( $socnet_links != '' ) { ?>
<section class="social-links">	
	<div class="inner">		
		<?php 
		if ( jgtstork_get_option( 'social_title' ) != '' )
			echo '<h3 class="social-title">' . jgtstork_get_option( 'social_title' ) . '</h3>';
		echo $socnet_links; 
		?>
	</div><!-- .inner -->
</section><!-- .social links -->
<?php
} ?>
<footer class="site-footer" role="contentinfo">
	<div class="inner">
		<?php get_sidebar(); ?>	
		<div class="site-info">
			<p class="copyright">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'jgtstork' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'jgtstork' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( '%1$s theme by %2$s.', 'jgtstork' ), 'Stork', sprintf( '<a href="%s" rel="designer">justgoodthemes.com</a>', esc_url( 'http://justgoodthemes.com/' ) ) ); ?>
		  	</p>
			<a href="#" id="back-to-top" title="<?php _e( 'Back To Top', 'jgtstork' ); ?>"><i aria-hidden="true" class="icon-chevron-up"></i></a>
		</div><!-- .site-info -->
	</div><!-- .inner -->
</footer><!-- .site-footer -->
<?php wp_footer(); ?>
</body>
</html>