<form id="site-search" class="search-form" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group input-group-lg">
		<input type="search" class="form-control search-field" name="s" value="<?php echo get_search_query(); ?>" placeholder="Search The City of Asheville" aria-label="Search The City of Asheville" aria-describedby="search-button">
		<div class="input-group-append">
			<button class="btn btn-info bg-avl-blue-75" type="submit" id="search-button"><i class="icon icon-search"></i></button>
		</div>
	</div>
</form>