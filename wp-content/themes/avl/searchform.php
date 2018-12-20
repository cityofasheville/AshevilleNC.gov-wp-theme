<form id="site-search" class="search-form" role="search" method="get" action="<?= home_url( '/' ); ?>">
	<input type="search" class="form-control form-control-lg search-field" name="s" value="<?= get_search_query(); ?>" placeholder="Search The City of Asheville" aria-label="Search The City of Asheville" aria-describedby="search-button">
	<button class="btn" type="submit" id="search-button"><i class="icomoon icomoon-search"></i></button>
</form>