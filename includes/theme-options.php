<?php

/* Load styles and scripts */
function jgtstork_admin_enqueue_scripts( $hook ) {	
	
	if ( 'appearance_page_jgtstork-options' != $hook )
		return;

	$templateDir = get_template_directory_uri();

	// Load custom styles
	wp_enqueue_style( 'jgtstork-optionscss', $templateDir . '/includes/css/theme-options.css', false );

	// Load colorpicker styles
	if ( !wp_style_is( 'wp-color-picker', 'registered' ) )
		wp_register_style( 'wp-color-picker', $templateDir . '/includes/css/color-picker.min.css' );
	wp_enqueue_style( 'wp-color-picker' );

	// Load the WP 3.5 Media uploader scripts
	if ( function_exists( 'wp_enqueue_media' ) )
		wp_enqueue_media();
	wp_enqueue_script( 'jgtstork-uploader', $templateDir .'/includes/js/media-uploader.js', array( 'jquery' ) );
	wp_localize_script( 'jgtstork-uploader', 'jgtstork_l10n', array( 'upload' => __( 'Upload', 'jgtstork' ), 'remove' => __( 'Remove', 'jgtstork' ) ) );

	// Register colorpicker scripts for WP versions below 3.5 for compatibility
	if ( !wp_script_is( 'wp-color-picker', 'registered' ) ) {
		wp_register_script( 'iris', $templateDir . '/includes/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_register_script( 'wp-color-picker', $templateDir . '/includes/js/color-picker.min.js', array( 'jquery', 'iris' ) );
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array( 'clear' => __( 'Clear','jgtstork' ), 'defaultString' => __( 'Default', 'jgtstork' ), 'pick' => __( 'Select Color', 'jgtstork' ) ) );
	}

	// Load custom script
	wp_enqueue_script( 'jgtstork-optionsjs', $templateDir . '/includes/js/theme-options.js', array( 'jquery','wp-color-picker' ) );

}
add_action( 'admin_enqueue_scripts', 'jgtstork_admin_enqueue_scripts' );

/* Register the theme setting and its sanitization callback */
function jgtstork_theme_options_init() {
	// Register theme settings
	register_setting( 'jgtstork_theme_options', 'jgtstork_options', 'jgtstork_theme_options_validate' );

	// Add theme settings sections
	$sections = jgtstork_theme_settings_sections();
	foreach ( $sections as $section ){
		add_settings_section( 'jgtstork_' . $section['name'], $section['title'], '__return_false', 'jgtstork-options' );
	}

	// Register settings fields to a settings page and section
	$fields = jgtstork_theme_settings_fields();
	foreach ( $fields as $field ){
		add_settings_field( 'jgtstork_' . $field['name'], $field['title'], 'jgtstork_render_settings_fields', 'jgtstork-options', 'jgtstork_' . $field['section'], $field );
	}
}
add_action( 'admin_init', 'jgtstork_theme_options_init' );

/* Generate the options page fields */
function jgtstork_render_settings_fields( $field ) {
	$options = jgtstork_theme_options();
	switch ( $field['type'] ) {
		case 'text': 
			echo '<input type="text" name="jgtstork_options[' . $field['name'] . ']" value="' . esc_attr( $options[$field['name']] ) . '" class="regular-text code" /><p class="description">' . $field['description'] . '</p>';
			break;
		case 'select':
			echo '<select name="jgtstork_options[' . $field['name'] . ']" id="jgtstork_options_' . $field['name'] . '" style="margin-right: 10px;">';
			foreach ( $field['values'] as $key => $value ) {
				echo '<option ' . selected( $options[$field['name']], $key, false ) . ' value="' . esc_attr( $key ) . '">' . $value . '</option>';
			}
			echo '</select><p class="description">' . $field['description'] . '</p>';
			break;
		case 'checkbox':
			echo '<label><input type="checkbox" name="jgtstork_options[' . $field['name'] . ']" id="jgtstork_options_' . $field['name'] . '" ' . checked( $options[$field['name']], 1, false ) . ' /> ' . $field['description'] . '</label>';
			break;
		case 'upload':
			echo '<input type="text" name="jgtstork_options[' . $field['name'] . ']" id="jgtstork_options_' . $field['name'] . '" value="' . esc_url( $options[$field['name']] ) . '" class="jgtstork-upload regular-text code" placeholder="' . __( 'No file chosen', 'jgtstork' ) . '" />';

			if ( function_exists( 'wp_enqueue_media' ) ) {
				if ( $options[$field['name']] == '' )
					echo '<input type="button" value="' . __( 'Upload', 'jgtstork' ) . '" class="jgtstork-upload-btn button" />';
				else
					echo '<input type="button" value="' . __( 'Remove', 'jgtstork' ) . '" class="jgtstork-remove-btn button" />';
				echo '<p class="description">' . $field['description'] . '</p>';
			} else {
				echo '<p class="description">' . $field['description'] . '<br /><strong>' . __( 'Upgrade your version of WordPress for full media support.', 'jgtstork' ) . '</strong></p>';
			}
					
			$preview = '';
			if ( $options[$field['name']] != '' ) {
				$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $options[$field['name']] );
				if ( $image ) {
					$preview = '<img src="' . esc_url( $options[$field['name']] ) . '" alt="" /><a href="javascript:void(0)" class="jgtstork-remove">' . __( 'Remove', 'jgtstork' ) . '</a>';
				} else {
					$preview = '<a href="' . esc_url( $options[$field['name']] ) . '" target="_blank" rel="external">' . __( 'View File', 'jgtstork' ) . '</a><a href="javascript:void(0)" class="jgtstork-remove">' . __( 'Remove', 'jgtstork' ) . '</a>';
				}
			}
			echo '<div class="jgtstork-preview">' . $preview . '</div>';						
			break;
		case 'color':
			echo '<input type="text" name="jgtstork_options[' . $field['name'] . ']" value="' . esc_attr( $options[$field['name']] ) . '" class="jgtstork-color-field" data-default-color="' . $field['default'] . '" />';
			break;
	}
}

/* Add the theme options page to the admin menu */
function jgtstork_theme_options_add_page() {
	add_theme_page( __( 'Stork Theme Options', 'jgtstork' ), __( 'Stork Options', 'jgtstork' ), 'edit_theme_options', 'jgtstork-options', 'jgtstork_theme_options_render_page' );
}
add_action( 'admin_menu', 'jgtstork_theme_options_add_page' );

/* Define options page markup */
function jgtstork_theme_options_render_page() {	?>
	<?php settings_errors(); ?>
	<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e( 'Stork Theme Options', 'jgtstork' ); ?></h2>
		<div id="jgtstork_wrapper">
			<form method="post" action="options.php">
				<?php settings_fields( 'jgtstork_theme_options' ); ?>
				<?php do_settings_sections( 'jgtstork-options' ); ?>
				<p class="jgtstork-submit">
					<?php 
					submit_button( __( 'Save Settings', 'jgtstork' ), 'primary', 'jgtstork_options[submit]', false );
					submit_button( __( 'Reset Defaults', 'jgtstork' ), 'secondary', 'jgtstork_options[reset]', false ); ?>
				</p>
			</form>
		</div>
	</div>
	<?php
}

/* Sanitize and validate form input */
function jgtstork_theme_options_validate( $input ) {
	$fields = jgtstork_theme_settings_fields();
	$output = $defaults = jgtstork_default_theme_options();
		
	if ( isset( $input['reset'] ) )
		return $defaults;

	foreach ( $fields as $field ) {
		
		switch( $field['type'] ) {
			case 'text':
				if ( 'url' == $field['sanitize'] ) {
					$output[$field['name']] = esc_url_raw( $input[$field['name']] );
				} elseif ( 'number' == $field['sanitize'] ) {
					$output[$field['name']] = absint( $input[$field['name']] );
					if ( ! $output[$field['name']] )
						$output[$field['name']] = '';
				} else {
					$output[$field['name']] = wp_filter_nohtml_kses( $input[$field['name']] );
				}
				break;
			case 'select':
				if ( isset( $input[$field['name']] ) && array_key_exists( $input[$field['name']], $field['values'] ) )
					$output[$field['name']] = $input[$field['name']];
				break;
			case 'checkbox':
				$output[$field['name']] = ( isset( $input[$field['name']] ) && true == $input[$field['name']] ) ? true : false;
				break;
			case 'upload':
				$filetype = wp_check_filetype( esc_url_raw( $input[$field['name']] ) );
				$output[$field['name']] = ( $filetype["ext"] ) ? esc_url_raw( $input[$field['name']] ) : '';
				break;
			case 'color':
				if ( isset( $input[$field['name']] ) && preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', trim( $input[$field['name']] ) ) )
					$output[$field['name']] = trim ( $input[$field['name']] );
				break;
		}
	}
	return $output;
}

/* Define an array of theme settings sections that will be used to generate the settings page */
function jgtstork_theme_settings_sections() {
	$sections = array(
		array(
			'name' => 'general',
			'title' => __( 'General Settings', 'jgtstork' )
		),
		array(
			'name' => 'social',
			'title' => __( 'Social Networks Settings', 'jgtstork' )
		) 
	);
	return $sections;
}

/* Define an array of theme settings fields that will be used to generate the settings page */
function jgtstork_theme_settings_fields() {
	$fields = array(
		array(
			'name' => 'primary_color',
			'title' => __( 'Primary Color', 'jgtstork' ),
			'type' => 'color',
			'default' => '#3366c8',
			'section' => 'general'
		),
		array(
			'name' => 'secondary_color',
			'title' => __( 'Secondary Color', 'jgtstork' ),
			'type' => 'color',
			'default' => '#ff5148',
			'section' => 'general'
		),
		array(
			'name' => 'logo',
			'title' => __( 'Logo', 'jgtstork' ),
			'description' => __( 'Upload a logo image or enter the URL to an image if it\'s already uploaded.', 'jgtstork' ),
			'type' => 'upload',
			'default' => '',
			'section' => 'general'
		),
		array(
			'name' => 'logo_width',
			'title' => __( 'Logo Width', 'jgtstork' ),
			'description' => __( 'If you use Retina sized logo enter the width of your logo in px.', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'number',
			'default' => '',
			'section' => 'general'
		),
		array(
			'name' => 'show_tagline',
			'title' => __( 'Show Tagline', 'jgtstork' ),
			'description' => __( 'Show tagline below the logo image or site title (set up the tagline in <a href="' . home_url() . '/wp-admin/options-general.php">General Settings</a>.)', 'jgtstork' ),
			'type' => 'checkbox',
			'default' => true,
			'section' => 'general'
		),
		array(
			'name' => 'animated_nav',
			'title' => __( 'Enable Animated Menu', 'jgtstork' ),
			'description' => __( 'Enable animated navigation menu.', 'jgtstork' ),
			'type' => 'checkbox',
			'default' => true,
			'section' => 'general'
		),
		array(
			'name' => 'social_title',
			'title' => __( 'Social Networks Section Title', 'jgtstork' ),
			'description' => __( 'Enter the title for the social networks section.', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'default' => 'Say Hello',
			'section' => 'social'
		),
		array(
			'name' => 'twitter',
			'title' => __( 'Twitter URL', 'jgtstork' ),
			'description' => __( 'Enter your Twitter URL, e.g. http://www.twitter.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'facebook',
			'title' => __( 'Facebook URL', 'jgtstork' ),
			'description' => __( 'Enter your Facebook URL, e.g. http://www.facebook.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'googleplus',
			'title' => __( 'Google+ URL', 'jgtstork' ),
			'description' => __( 'Enter your Google+ URL, e.g. https://plus.google.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'pinterest',
			'title' => __( 'Pinterest URL', 'jgtstork' ),
			'description' => __( 'Enter your Pinterest URL, e.g. http://pinterest.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'tumblr',
			'title' => __( 'Tumblr URL', 'jgtstork' ),
			'description' => __( 'Enter your Tumblr URL, e.g. http://myprofile.tumblr.com/', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'instagram',
			'title' => __( 'Instagram URL', 'jgtstork' ),
			'description' => __( 'Enter your Instagram URL, e.g. http://instagram.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'flickr',
			'title' => __( 'Flickr URL', 'jgtstork' ),
			'description' => __( 'Enter your Flickr URL, e.g. http://www.flickr.com/photos/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'linkedin',
			'title' => __( 'LinkedIn URL', 'jgtstork' ),
			'description' => __( 'Enter your LinkedIn URL, e.g. http://www.linkedin.com/in/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'dribbble',
			'title' => __( 'Dribbble URL', 'jgtstork' ),
			'description' => __( 'Enter your Dribbble URL, e.g. http://dribbble.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'github',
			'title' => __( 'GitHub URL', 'jgtstork' ),
			'description' => __( 'Enter your GitHub URL, e.g. http://github.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'vimeo',
			'title' => __( 'Vimeo URL', 'jgtstork' ),
			'description' => __( 'Enter your Vimeo URL, e.g. http://vimeo.com/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),
		array(
			'name' => 'youtube',
			'title' => __( 'YouTube URL', 'jgtstork' ),
			'description' => __( 'Enter your YouTube URL, e.g. http://www.youtube.net/myprofile', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		),		
		array(
			'name' => 'rss',
			'title' => __( 'RSS URL', 'jgtstork' ),
			'description' => __( 'Enter your RSS feed URL, e.g. http://mysite.com/feed', 'jgtstork' ),
			'type' => 'text',
			'sanitize' => 'url',
			'default' => '',
			'section' => 'social'
		)
	);
	return $fields;
}

/* Return default theme options */
function jgtstork_default_theme_options() {
	$fields = jgtstork_theme_settings_fields();
	$defaults = array();
	foreach( $fields as $field ){
		$defaults[$field['name']] = $field['default'];
	}
	return $defaults;
}

/* Return theme options array */
function jgtstork_theme_options() {
	$defaults = jgtstork_default_theme_options();
	$options = get_option( 'jgtstork_options', $defaults );
	return $options;
}

/* Helper function to return the theme option value */
function jgtstork_get_option( $name ) {
	$options = jgtstork_theme_options();
	if ( array_key_exists( $name, $options ) )
		return $options[$name];
	return false;
}

?>