<form
	id="site-search"
	class="search-form"
	role="search"
	aria-haspopup="listbox"
	method="get"
	action="<?= home_url( '/' ); ?>"
>
	<div
		role="combobox"
		aria-expanded="false"
	>
		<input
			id="site-search-input"
			type="text"
			class="form-control form-control-lg search-field"
			aria-autocomplete="list"
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
	</div>
</form>
