(function($) {
	$(document).ready(function() {

		// Remove "no-js" CSS fallback class
		$('body').removeClass('no-js');
	 	
	 	// Navigation menu toggle
	 	$('#menu-toggle').click(function(){
			var menuIcon = $(this).find('i');
			if ( menuIcon.hasClass('icon-plus') )
				menuIcon.removeClass('icon-plus').addClass('icon-minus');
			else
				menuIcon.removeClass('icon-minus').addClass('icon-plus');
			$('.menu-wrap').slideToggle();
			return false;
		});

	 	$(window).bind('resize orientationchange', function() {
	 		if ( !$('.site-navigation').hasClass('animated-navigation') ) {
	 			if ( $('#menu-toggle').is(':hidden') ) {
					$('.site-navigation .menu-wrap').show();
				} else {
					$('#menu-toggle').find('i').removeClass('icon-minus').addClass('icon-plus');
					$('.site-navigation .menu-wrap').hide();
				}
	 		}	 		
	 	});

		// Placeholder	
		$("[placeholder]").focus(function() {
			var el = $(this);
			if (el.val() == el.attr("placeholder")) {
				el.val("");
			}
		}).blur(function() {
			var el = $(this);
			if (el.val() == "" || el.val() == el.attr("placeholder")) {
				el.val(el.attr("placeholder"));
			}
		}).blur();

	});

})(jQuery);