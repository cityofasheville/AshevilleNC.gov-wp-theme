jQuery(document).ready(function() {
  twttr.events.bind(
  	'rendered',
  	function (event) {
  		var target = jQuery('#'+ event.target.id)
  		// Hide the rendered twitter box and style it to match other social media icons
  		target.attr('tabindex', '-1');
  		target.css('border', '');
  		target.addClass('rounded');
  		target.css('height', '');
  		target.css('min-height', '');
  	}
  );
});
