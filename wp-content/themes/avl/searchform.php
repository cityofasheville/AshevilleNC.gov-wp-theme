<form id="site-search" class="search-form" role="combobox" aria-haspopup="listbox" method="get" action="<?= home_url( '/' ); ?>">
	<input type="search" class="form-control form-control-lg search-field"  role="searchbox" name="s" value="<?= get_search_query(); ?>" placeholder="Search" aria-label="Site search">
	<button class="btn search-button" type="submit"><span class="icomoon icomoon-search"></span></button>
</form>
