<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>"> 
	<label class="screen-reader-text"><?php _e( 'Search for:', 'jgtstork' ); ?></label>
	<input type="text" name="s" class="search-field" placeholder="<?php esc_attr_e( 'Search...', 'jgtstork' ); ?>" />
	<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Go', 'jgtstork' ); ?>" />
</form>