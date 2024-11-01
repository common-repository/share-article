(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 // Show new source style on settings page


	 $(function() {
	 	
	 	function getInput() {

		 	var readmore_text = $( "#readmore_text" ).val();
		 	var source_url = $( "#source_url_dropdown" ).val();
		 	var get_target = $( "#target_dropdown" ).val();
		 	var source_link = 'http://example.com/article/to/share/';
		 	var site_name = 'Example.com';
		 	
		 	switch ( source_url ) {

		 		case 'Domain':
		 			site_name = site_name;
		 			break;

		 		case 'Full':
		 			site_name = source_link;
		 			break;

		 		default:
		 			site_name = site_name;
		 	};

		 	var set_target;
		 	switch ( get_target) {
		 		case 'Same tab':
		 			set_target = target.sametab;
		 			break;
		 		case 'New tab':
		 			set_target = target.newtab;
		 			break;
		 		default:
		 			set_target = target.sametab;
		 	}

		 	

		 	var readmore_link = $( "#new_source_style").html(
		 		"<p>" + readmore_text + " " + "<a href='#'" + ">" + site_name + "</a> (" + set_target + ")</p>");

		 	return readmore_link;

	 	}

	 	
	 	$("#source_url_dropdown").change(function() {
	 		getInput();
  		});

	 	$("#target_dropdown").change(function() {
	 		getInput();
  		});
 	 	$("#readmore_text").keyup(function() {
			getInput();
  		});
  	});

})( jQuery );