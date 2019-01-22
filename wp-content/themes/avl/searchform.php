<form
	id="site-search"
	class="search-form"
	role="search"
	aria-expanded="false"
	aria-haspopup="listbox"
	method="get"
	action="<?= home_url( '/' ); ?>"
>
<!-- TODO: ARIA-OWNS ID IS BAD AND INCONSISTENT -->
	<input
		id="site-search-input"
		type="search"
		class="form-control form-control-lg search-field"
		role="combobox"
		aria-autocomplete="list"
		aria-haspopup="true"
		aria-owns="#algolia-autocomplete-listbox-0"
		name="s"
		value="<?= get_search_query(); ?>"
		placeholder="Search"
		aria-label="Site search"
	>
	<label for="site-search-input" class="visually-hidden">
		Search
	</label>
	<button
		class="btn search-button"
		type="submit"
	>
		<span class="visually-hidden">
			Search
		</span>
		<span class="icomoon icomoon-search"></span>
	</button>
</form>
