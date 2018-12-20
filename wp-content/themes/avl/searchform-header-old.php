<form id="site-search" class="search-form ml-auto" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group">
		<input type="search" class="form-control search-field" name="s" value="<?php echo get_search_query(); ?>" placeholder="Search" aria-label="Search" aria-describedby="search-button">
		<div class="input-group-append">
			<button class="btn btn-outline-success" type="submit" id="search-button"><i class="icon icon-search"></i></button>
		</div>
	</div>
</form>