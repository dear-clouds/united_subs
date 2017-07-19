<?php

/*  
	Error Page Content
	------------------
	The error page content can be created using a page. To set the page as the source of your 404 error page 
	go to the "Settings > Theme Setting > Miscellaneous > Error Page (404)" option and choose the page from 
	the select box. If no page is selected the default content below will be displayed.
	
	Error Page Layout
	-----------------
	The error page layout can be set in the "Appearance > Design Settings > Default Design Settings" area.
	
*/ 

// Get page ID of error content
$errorPageID = get_theme_var('options,404_page');

if ($errorPageID) {
	
	// query the page selected as 404 error
	query_posts( array('page_id' => $errorPageID) );

	// load the template to display content
	get_template_part( 'page' );
	
} else {
	
	// A generic 404 error. Used if no page has been set as the content source
	
	?>
	<!-- Title / Page Headline -->
	<header class="entry-header">
		<h1 class="entry-title" title="<?php _e( 'Error 404', THEME_NAME ); ?>"><?php _e( 'Error 404', THEME_NAME ); ?></h1>
	</header>
	
	<div class="the-post-container">

		<!-- Page Text and Main Content -->
		<div class="entry-content">
			<?php  _e( 'The page you are looking for could not be found.', THEME_NAME ); ?>
		</div>

	</div>
	<?php

}

?>