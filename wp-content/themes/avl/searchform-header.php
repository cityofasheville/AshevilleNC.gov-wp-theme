<form id="site-search" class="search-form ml-auto" role="search" method="get" action="<?= home_url( '/' ); ?>">
	<input type="search" class="form-control search-field" name="s" value="<?= get_search_query(); ?>" placeholder="Search">
	<button class="btn" type="submit" id="search-button"><i class="icomoon icomoon-search"></i></button>
</form>