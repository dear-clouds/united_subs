<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	
	<div class="input-group">
		<input name="s" id="s" autocomplete="off" type="text" class="ajax_s form-control input-sm" value="<?php echo get_search_query(); ?>">
		<span class="input-group-btn">
            <input type="submit" value="<?php _e("Search");?>" id="searchsubmit" class="button">
		</span>
	</div>

</form>