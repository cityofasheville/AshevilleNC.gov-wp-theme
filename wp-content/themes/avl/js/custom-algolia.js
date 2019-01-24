jQuery(function () {
	/* init Algolia client */
	var client = algoliasearch(algolia.application_id, algolia.search_api_key);
	// This is the admin API key, which should be kept secret

	/* setup default sources */
	var sources = [];
	jQuery.each(algolia.autocomplete.sources, function (i, config) {
		var suggestion_template = wp.template(config['tmpl_suggestion']);
		// Pulls post suggestion or term suggestion as appropriate
		sources.push({
			source: algoliaAutocomplete.sources.hits(
				client.initIndex(config['index_name']),
				{
					hitsPerPage: config['max_suggestions'],
					attributesToSnippet: [
					'content:10'
					],
					highlightPreTag: '__ais-highlight__',
					highlightPostTag: '__/ais-highlight__',
					advancedSyntax: true,
					removeWordsIfNoResults: 'lastWords',
				}
			),
			templates: {
				header: function () {
					return wp.template('autocomplete-header')({
						label: _.escape(config['label'])
					});
				},
				suggestion: function (hit) {
					if(hit.escaped === true) {
						return suggestion_template(hit);
					}
					hit.escaped = true;

					for (var key in hit._highlightResult) {
						/* We do not deal with arrays. */
						if (typeof hit._highlightResult[key].value !== 'string') {
							continue;
						}
						hit._highlightResult[key].value = _.escape(hit._highlightResult[key].value);
						hit._highlightResult[key].value = hit._highlightResult[key].value.replace(/__ais-highlight__/g, '<em>').replace(/__\/ais-highlight__/g, '</em>');
					}

					for (var key in hit._snippetResult) {
						/* We do not deal with arrays. */
						if (typeof hit._snippetResult[key].value !== 'string') {
							continue;
						}

						hit._snippetResult[key].value = _.escape(hit._snippetResult[key].value);
						hit._snippetResult[key].value = hit._snippetResult[key].value.replace(/__ais-highlight__/g, '<em>').replace(/__\/ais-highlight__/g, '</em>');
					}

					return suggestion_template(hit);
				}
			}
		});
	});

	// For adding aria-controls to the right input boxes
	var inputsAndSelectors = [
		// {
		// 	searchInputEl:
		// 	ariaControlsSelector:
		// }
	]

	/* Setup dropdown menus */
	jQuery(algolia.autocomplete.input_selector).each(function (i) {
		var $searchInput = jQuery(this);
		/*
		If you press enter on a search and go to the search results page, there are
		two search boxes.  Each of them should be associated with their own search
		results via aria-controls.

		See top of footer.php for the location of the two divs to which these
		respective search results are appended.

		See tink.uk's blog for aria-controls: https://tink.uk/using-the-aria-controls-attribute/

		-MM
		*/
		const searchResultsId = '#search-results-' + i;

		inputsAndSelectors.push({
			searchInputEl: this,
			ariaControlsSelector: searchResultsId + ' .aa-dropdown-menu'
		})

		var config = {
			// debug: algolia.debug,
			debug: false,
			hint: false,
			openOnFocus: true,
			minLength: 3,
			appendTo: searchResultsId,
			templates: {
				empty: wp.template('autocomplete-empty')
			},
		};

		// if (algolia.powered_by_enabled) {
		// 	config.templates.footer = wp.template('autocomplete-footer');
		// }

		/* Instantiate autocomplete.js */
		var autocomplete = algoliaAutocomplete($searchInput[0], config, sources)
			.on('autocomplete:selected', function (e, suggestion) {
				/* Redirect the user when we detect a suggestion selection. */
				window.location.href = suggestion.permalink;
			});

		/* Force the dropdown to be re-drawn on scroll to handle fixed containers. */
		jQuery(window).scroll(function() {
			if(autocomplete.autocomplete.getWrapper().style.display === "block") {
				autocomplete.autocomplete.close();
				autocomplete.autocomplete.open();
			}
		});
	});

	inputsAndSelectors.forEach(function(item) {
		var controlledListbox = jQuery(item.ariaControlsSelector);
		controlledListbox.attr('title', 'Search results');
		item.searchInputEl.setAttribute('aria-controls', controlledListbox.attr('id'))
	})
});
