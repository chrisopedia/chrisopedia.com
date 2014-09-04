<form class="Search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<label class="label assistive-text" for="search">Search</label>
	<input id="search" class="text" type="search" name="s" value="<?php the_search_query(); ?>" placeholder="Search" />
	<input class="Icon solo submit" type="submit" value="&#x1F50E;" />
</form>
