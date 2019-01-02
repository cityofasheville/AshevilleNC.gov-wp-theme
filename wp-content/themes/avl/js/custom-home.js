twttr.events.bind(
	'rendered',
	function (event) {
		jQuery('#'+ event.target.id).attr('tabindex', '-1');
	}
);