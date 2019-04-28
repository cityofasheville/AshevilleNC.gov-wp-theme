<?php get_header(); ?>
  <!-- Copied from plugins/search-by-algolia.../templates/instantsearch -->
	<div id="ais-wrapper" class="container">
		<div class="row">
			<header class="page-header mb-3 col-sm-12">
				<h1 class="page-title">
					<?php
					printf( esc_html__( 'Search Results for: %s', 'avl' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>

			<aside id="ais-facets" class="col-md-2 col-sm-12">
				<section class="ais-facets" id="facet-post-types"></section>
				<!-- <section class="ais-facets" id="facet-categories"></section>
				<section class="ais-facets" id="facet-tags"></section> -->
			</aside>


			<section id="primary" class="content-area col-md-10 col-sm-12">

				<div id="ais-main" class="site-main">
					<div id="algolia-search-box">
						<div id="algolia-stats"></div>
						<svg class="search-icon" width="25" height="25" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M24.828 31.657a16.76 16.76 0 0 1-7.992 2.015C7.538 33.672 0 26.134 0 16.836 0 7.538 7.538 0 16.836 0c9.298 0 16.836 7.538 16.836 16.836 0 3.22-.905 6.23-2.475 8.79.288.18.56.395.81.645l5.985 5.986A4.54 4.54 0 0 1 38 38.673a4.535 4.535 0 0 1-6.417-.007l-5.986-5.986a4.545 4.545 0 0 1-.77-1.023zm-7.992-4.046c5.95 0 10.775-4.823 10.775-10.774 0-5.95-4.823-10.775-10.774-10.775-5.95 0-10.775 4.825-10.775 10.776 0 5.95 4.825 10.775 10.776 10.775z" fill-rule="evenodd"></path></svg>
					</div>
					<div id="algolia-hits" class="card-columns">
					</div>
					<div id="algolia-pagination"></div>
				</div>
			</section>


		</div>
	</div>

	<script type="text/html" id="tmpl-instantsearch-hit">
		<article id="post-{{ data.post_id }}" class="card h-100 format-standard has-thumbnail">
			<div class="ais-hits--content entry-header">
			</div>
			<# if ( data.images.medium ) { #>
				<a href="{{ data.permalink }}" title="{{ data.post_title }}" class="post-thumbnail flex-shrink-0">
					<img src="{{ data.images.medium.url }}" class="card-img-top h-auto wp-post-image" alt="{{ data.post_title }}" title="{{ data.post_title }}" itemprop="image" sizes="(max-width: 450px) 100vw, 450px" />
				</a>
			<# } else if ( data.images.thumbnail ) { #>
				<a href="{{ data.permalink }}" title="{{ data.post_title }}" class="post-thumbnail flex-shrink-0">
					<img src="{{ data.images.thumbnail.url }}" class="card-img-top h-auto wp-post-image" alt="{{ data.post_title }}" title="{{ data.post_title }}" itemprop="image" sizes="(max-width: 450px) 100vw, 450px" />
				</a>
			<# } #>
			<div class="card-body">
				<span class="card-title entry-title">
					<a
						href="{{ data.permalink }}"
						title="{{ data.post_title }}"
						itemprop="url"
					>
						{{{ data._highlightResult.post_title.value }}}
					</a>
  			<# if ( data.post_type === 'post' ) { #>
					<div class="card-subtitle m-2 accessible-text-muted small entry-meta">
						Posted on {{{ data.post_date_formatted }}}
					</div>
  			<# } #>
				</span>
				<div class="card-text entry-content">
					{{{ data._snippetResult.content.value }}}
				</div>

			</div>

			<!-- TODO: need tags -->
			<# if ( data.post_type !== 'avl_department_page' && data.post_type !== 'page' ) { #>
  			<footer class="card-footer entry-footer">
    			<# if ( data.post_type === 'post' ) { #>
            <a class="badge badge-primary bg-avl-blue" href="/news">News</a>
    			<# } else { #>
            <a class="badge badge-primary bg-avl-blue" href="/{{ data.post_type_label.toLowerCase() }}">{{{ data.post_type_label}}}</a>
    			<# } #>
  			</footer>
			<# } #>
		</article>
	</script>


	<script type="text/javascript">
		jQuery(function() {
			if(jQuery('#algolia-search-box').length > 0) {

				if (algolia.indices.searchable_posts === undefined && jQuery('.admin-bar').length > 0) {
					alert('It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.');
				}

				/* Instantiate instantsearch.js */
				var search = instantsearch({
					appId: algolia.application_id,
					apiKey: algolia.search_api_key,
					indexName: algolia.indices.searchable_posts.name,
					urlSync: {
						mapping: {'q': 's'},
						trackedParameters: ['query']
					},
					searchParameters: {
						facetingAfterDistinct: true,
						// highlightPreTag: '__ais-highlight__',
						// highlightPostTag: '__/ais-highlight__'
					}
				});

				/* Search box widget */
				search.addWidget(
					instantsearch.widgets.searchBox({
						container: '#algolia-search-box',
						placeholder: 'Search for...',
						wrapInput: false,
						poweredBy: algolia.powered_by_enabled
					})
				);

				/* Stats widget */
				search.addWidget(
					instantsearch.widgets.stats({
						container: '#algolia-stats'
					})
				);

				/* Hits widget */
				search.addWidget(
					instantsearch.widgets.hits({
						container: '#algolia-hits',
						hitsPerPage: 12,
						// transformData: {
						// 	item: function(hit) {
            //     console.log(hit);
						// 		return hit;
						// 	},
						// },
						templates: {
							empty: 'No results were found for "<strong>{{query}}</strong>".',
							item: wp.template('instantsearch-hit'),
						},
					})
				);

				/* Pagination widget */
				search.addWidget(
					instantsearch.widgets.pagination({
						container: '#algolia-pagination'
					})
				);

				/* Post types refinement widget */
				search.addWidget(
					instantsearch.widgets.menu({
						container: '#facet-post-types',
						attributeName: 'post_type_label',
						sortBy: ['count:desc', 'name:asc'],
						limit: 10,
						templates: {
							header: '<span class="widgettitle h4">Filter Results</span>',
              item: function(properties) {
                var checked = properties.isRefined ? 'checked' : '';
                var label = properties.name + ' (' + properties.count + ')';
                if (properties.name === 'Posts') {
                  var label = 'News (' + properties.count + ')';
                }
                return '<input class="mr-2 mt-2" type="radio" ' + checked + '/>' + label;
              }
						},
					})
				);

				/* Start */
				search.start();

				jQuery('#algolia-search-box input').attr('type', 'search').select();
			}
		});
	</script>

<?php get_footer(); ?>
