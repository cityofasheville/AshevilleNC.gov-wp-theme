function initGoogleTranslateElement() {
	new google.translate.TranslateElement(
		{
			pageLanguage: 'en',
			layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			// layout: google.translate.TranslateElement.InlineLayout.DROPDOWNONLY
			// CONSIDER USING DROPDOWNONLY ATTRIBUTE AND STYLING THE MENU ACCORDINGLY
		},
		'google-translate'
	);
}

PRC = {};

PRC.getUrlVars = function(){
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

PRC.calendarFunctionality = function(){
	if ( 'object' !== typeof tribe_ev ) return;

	// grab the filter params
	var existingSearch = tribe_ev.state.url_params;

	var islist = false;
	var issearch = false;

	// trigger when filters are set up
	jQuery( tribe_ev.events ).on( 'tribe_ev_collectParams', function() {
		
		// regex param to determine if search happened
		issearch = tribe_ev.state.url_params.match(/tribe\-bar\-search/g);

		// regex param to determine if already in list mode
		islist = tribe_ev.state.url_params.match(/tribe\_event\_display\=list/g);

		// console.log('tribe', tribe_ev);
		
		if ( issearch ) {
			// If not in list mode, switch, otherwise ignore
			if(!islist){
				window.location = '/events/?' + tribe_ev.state.url_params + '&eventDisplay=list';
			}
		}
	});

	// trigger when the ajax was successful
	jQuery( tribe_ev.events ).on( 'tribe_ev_ajaxSuccess', function() {

		if(!issearch){
			jQuery('.avl-search-indicator').removeClass('avl-search-indicator--active');
		}else{
			jQuery('.avl-search-indicator').addClass('avl-search-indicator--active');
		}

		// if you're in list mode, replace the values
		if(islist){
			// grab search title (can change depending on content)
			var search_title = jQuery('.tribe-events-page-title').html();
			
			// make lowercase
			search_title = search_title.replace('Events', 'events').replace('Upcoming', 'upcoming');

			// If no search value
			if(!jQuery('#tribe-bar-search').val()){
				jQuery('.avl-search-indicator .search-text').html('All events');
			}else{
				jQuery('.avl-search-indicator .search-text').html('Search results for <i>"' + PRC.getUrlVars()['tribe-bar-search'] + '"</i> in');
			}
			jQuery('.date-title').html(search_title);
		}
	});
}

