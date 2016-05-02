(function($) {
	$(document).ready(function() {

		function jgtstork_add_file(event, selector) {
			var frame,
				$el = $(this);

			event.preventDefault();

			// If the media frame already exists, reopen it
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame
			frame = wp.media({
				// Set the title of the modal
				title: $el.data('choose'),

				// Customize the submit button
				button: {
					// Set the text of the button
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're going to refresh the page when the image is selected
					close: false
				}
			});

			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first();
				frame.close();
				selector.find('.jgtstork-upload').val(attachment.attributes.url);
				if ( attachment.attributes.type == 'image' ) {
					selector.find('.jgtstork-preview').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="jgtstork-remove">' + jgtstork_l10n.remove + '</a>').slideDown('fast');
				}
				selector.find('.jgtstork-upload-btn').unbind().addClass('jgtstork-remove-btn').removeClass('jgtstork-upload-btn').val(jgtstork_l10n.remove);
				jgtstork_file_bindings();
			});

			// Finally, open the modal.
			frame.open();
		}
        
		function jgtstork_remove_file(selector) {
			selector.find('.jgtstork-remove').hide();
			selector.find('.jgtstork-upload').val('');
			selector.find('.jgtstork-preview').slideUp();
			selector.find('.jgtstork-remove-btn').unbind().addClass('jgtstork-upload-btn').removeClass('jgtstork-remove-btn').val(jgtstork_l10n.upload);
			// Do not display the upload button if .upload-notice is present (the user doesn't have the WP 3.5 Media Library Support)
			if ( $('.section-upload .upload-notice').length > 0 ) {
				$('.jgtstork-upload-btn').remove();
			}
			jgtstork_file_bindings();
			
		}
		
		function jgtstork_file_bindings() {
			$('.jgtstork-remove, .jgtstork-remove-btn').on('click', function() {
				jgtstork_remove_file( $(this).parents('td') );
	        });
	        
	        $('.jgtstork-upload-btn').click( function( event ) {
	        	jgtstork_add_file(event, $(this).parents('td'));
	        });
        }
        
        jgtstork_file_bindings();

	});
})(jQuery);