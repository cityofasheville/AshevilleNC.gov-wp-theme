<form id="site-search" class="search-form" role="combobox" aria-expanded="false" aria-haspopup="listbox" method="get" action="<?= home_url( '/' ); ?>">
	<label for="site-search"><span class="visually-hidden">Search</span></label>
	<input id="site-search" type="search" class="form-control form-control-lg search-field"  role="textbox" name="s" value="<?= get_search_query(); ?>" placeholder="Search" aria-label="Site search">
	<button class="btn search-button" type="submit"><span class="visually-hidden">Search</span><span class="icomoon icomoon-search"></span></button>
</form>
