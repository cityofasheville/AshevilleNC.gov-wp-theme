<form
	id="site-search"
	class="search-form well well-sm rounded mx-auto col-lg-10"
	aria-haspopup="listbox"
	method="get"
	action="<?= home_url( '/' ); ?>"
>
	<div role="search">
		<label for="site-search-input" class="search-label">
			Search for city services, news, or department information
		</label>

		<div
			role="combobox"
			class="input-group"
		>
			<input
				id="site-search-input"
				type="text"
				class="form-control form-control-lg search-field"
				aria-autocomplete="list"
				name="s"
				value="<?= get_search_query(); ?>"
				aria-label="Site search"
			>
			<div class="input-group-append">
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
	</div>
</form>
