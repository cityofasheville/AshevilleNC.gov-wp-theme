<form id="header-site-search" class="search-form ml-2 mr-3" role="search" method="get" action="<?= home_url( '/' ); ?>">
	<input type="search" class="form-control search-field" name="s" value="<?= get_search_query(); ?>" placeholder="Search" aria-label="Search">
	<button class="btn search-button" type="submit"><span class="icomoon icomoon-search"></span></button>
</form>
