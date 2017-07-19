<?php global $s;

/*  
	Search Page Content
	------------------
	The search page content will retrieve the results and apply them using the blog template file.
	
	Search Page Layout
	-----------------
	The search page layout can be set in the "Appearance > Layouts" area. The content source can be 
	set from "Settings > Theme Settings".
	
*/ 

// Search term entered
if (is_search()) {
	?>
	<!-- Title / Page Headline -->
	<header class="entry-header">
		<h2 class="entry-title" title="<?php _e('Search Results',THEME_NAME ) ?>"><?php _e('Search results for: ',THEME_NAME ) ?> <em><?php echo esc_html($s); ?></em></h2>
	</header>
	
	<div class="clear">&nbsp;</div>
	<?php
}

// Get the template to display results
get_template_part( 'template', 'blog' );
?>