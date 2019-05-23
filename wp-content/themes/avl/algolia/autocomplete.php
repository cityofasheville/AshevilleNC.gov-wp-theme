<!-- <script type="text/html" id="tmpl-autocomplete-header">
	<div class="autocomplete-header">
		<div class="autocomplete-header-title">{{{ data.label }}}</div>
	</div>
</script> -->

<script type="text/html" id="tmpl-autocomplete-post-suggestion">
	<a class="suggestion-link" href="{{ data.domainlessPermalink }}" title="{{ data.post_title }}">
		<# if ( data.images.thumbnail ) { #>
			<img class="suggestion-post-thumbnail" src="{{ data.images.thumbnail.url }}" alt="{{ data._highlightResult.post_title.value }}">
		<# } #>
		<div class="suggestion-post-attributes mt-2 mb-2">
			<span class="text-capitalize badge suggestion-post-title" style="color: {{data.color}}">{{{ data.domainlessPermalink.split('/').slice(1, -1).join(' | ').split('-').join(' ') }}} | {{{ data._highlightResult.post_title.value }}}</span>
			<# if ( data._snippetResult['content'] ) { #>
				<span class="suggestion-post-content">{{{ data._snippetResult['content'].value }}}</span>
			<# } #>
		</div>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-term-suggestion">
	<a class="suggestion-link" href="{{ data.permalink }}" title="{{ data.name }}">
		<span class="badge badge-primary">{{{ data._highlightResult.name.value }}}</span>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-empty">
	<div class="autocomplete-empty">
		<?php esc_html_e( 'No results matched your query ', 'algolia' ); ?>
		&quot;<span class="empty-query">{{ data.query }}</span>&quot;
	</div>
</script>
