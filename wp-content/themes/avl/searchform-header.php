<form
	id="header-site-search"
	class="search-form ml-2 mr-3"
	aria-haspopup="listbox"
	method="get"
	action="<?= home_url( '/' ); ?>"
>
	<div
		role="search"
	>
		<label for="header-site-search-input" class="visually-hidden">
			Search
		</label>

		<div
			role="combobox"
			class="input-group"
		>
			<input
				id="header-site-search-input"
				type="text"
				class="form-control search-field rounded"
				aria-autocomplete="list"
				name="s"
				value="<?= get_search_query(); ?>"
				placeholder="Search"
				aria-label="Site search"
			>
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
	</div>
</form>
