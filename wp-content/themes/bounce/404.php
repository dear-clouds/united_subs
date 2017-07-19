<?php get_header(); ?>


<!-- BEGIN CONTENT -->

<div id="content">


	<h4><?php _e('Oops, it looks like this page does not exist. If you are lost try using the search box.', 'gp_lang'); ?></h4>
	
	
	<div class="sc-divider"></div>
	
	
	<h4><?php _e('Search The Site', 'gp_lang'); ?></h4>
	<?php get_search_form(); ?>
	

</div>

<!-- END CONTENT -->


<?php get_sidebar(); ?>


<?php get_footer(); ?>