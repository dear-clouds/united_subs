<?php

#-----------------------------------------------------------------
# Pagination function (<< 1 2 3 >>)
#-----------------------------------------------------------------

function get_pagination($query = false, $range = 4, $firstLink = false, $lastLink = false) {
     global $paged, $wp_query;

	// Set the query variable (default $wp_query)
	$q = ($query) ? $query : $wp_query;		

	// Links to show before "shifting" the numbers
	$showitems = ($range * 2)+1;  

	// The current page
	if (empty($paged)) $paged = 1;

	// Get the total page count
	$pages = $q->max_num_pages;;
	if (!$pages) {
		$pages = 1;
	}

	if ( $pages > 1 ) {

		echo '<div class="paginationWrap clearfix"><div class="pag-in-ation">';
		
		// Show the "First" link
		if($paged > 2 && $paged > $range+1 && $showitems < $pages && $firstLink) {
			echo '<a href="'.get_pagenum_link(1).'"><span class="prev-post"> &laquo;</span></a>'; 
		}
		// Show "Previous" link
		if ($paged > 1) {
			echo '<a href="'.get_pagenum_link($paged - 1).'"><span class="prev-post"> &lsaquo;</span></a>'; 
		}
		
		// List the numbers
		for ($i=1; $i <= $pages; $i++) {

			if (1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				
				// Set the class if this is the current link
				$current = ($paged == $i) ? 'current' : '';

				// Print the number link
				echo '<a href="'.get_pagenum_link($i).'" class="'. $current .'" >'.$i.'</a>';
			}

		}

		// Show "Next" link
		if ($paged < $pages) {
			echo '<a href="'.get_pagenum_link($paged + 1).'"><span class="next-post">&rsaquo; </span></a>'; 
		}
		// Show "Last" link
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages && $lastLink) {
			echo '<a href="'.get_pagenum_link($pages).'"><span class="next-post">&raquo; </span></a>';
        }

		echo '</div></div>';
	}
}


?>