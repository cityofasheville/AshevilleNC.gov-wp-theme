twttr.events.bind(
	'rendered',
	function (event) {
		var target = jQuery('#'+ event.target.id)
		target.attr('tabindex', '-1');
		target.css('border', '');
		target.addClass('rounded');
		target.css('height', '');
		target.css('min-height', '');
	}
);
