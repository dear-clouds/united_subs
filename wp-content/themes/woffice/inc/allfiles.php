<?php
/**
 * All Files Shortcode
 *
 * @package WordPress
 * @subpackage Multiverso - Advanced File Sharing Plugin v2.0
 *
 */
 ?>
 
<?php $html = get_option('mv_before_tpl'); // BEFORE TPL CODE ?>

<?php 
		
		
		// Categories Query
		$args = array(
		'type'                     => 'multiverso',
		'parent'                   => 0,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'taxonomy'                 => 'multiverso-categories',
		'pad_counts'               => false );
		
		$categories = get_categories($args);
		
		
?>

<?php $html .= '<div class="mv-wrapper">'; ?>

	<?php $html .= '<div class="mv-content">'; ?>
    	
		<?php foreach ($categories as $category) { // LOOP ALL CATEGORIES 
		
		$category_link = add_query_arg( 'catid', $category->term_id, get_permalink( get_option('mv_category_page') ) );		 
		
		?>
        
			<?php 
			// EXCLUDE PRJECTS CATEGORY	
			$projects_array = get_posts(array( 'post_type' => 'project', 'posts_per_page' => -1) );
			$is_project_category = false;
			foreach ($projects_array as $project) {
				$is_project_category = ($project->post_title == $category->name) ? true : false;
				if($is_project_category == true):
					break; 
				endif;
			}
			if ($is_project_category == false) {
				// Category Heading            
	            $html .= '
	            <div class="cat-title" id="category'.$category->term_id.'">
	                <a href="'.$category_link.'">'.$category->name.'</a>
	                <i class="mvico-zoomin openlist mv-button-show" data-filelist="filelist'.$category->term_id.'"></i>
	                <i class="mvico-zoomout closelist mv-button-hide" data-filelist="filelist'.$category->term_id.'"></i> 
	            </div>
				'; 
	            
	            if (!empty($category->description)) { 
				
					$html .= '<div class="cat-desc entry-content">'.$category->description.'</div>'; 
				}
				
				
				// Subcategories & Files
				$html .= '<div class="cat-files mv-hide" id="filelist'.$category->term_id.'">';
					
					// Subcategories
					$html .= mv_display_subcategories($category->term_id);
					
					// Files
					$html .= mv_display_catfiles($category->slug, $category->name);
					
				$html .= '</div>';
            
            }
            ?>
        
        <?php } // END CATEGORY LOOP ?>
        
    <?php $html .= '</div> <!-- /mv-content -->'; ?>

  <?php $html .= '<div class="mv-clear"></div>'; ?>
  
  <?php $html .= '</div> <!-- /mv-wrapper -->'; ?>

<?php $html .= get_option('mv_after_tpl'); // AFTER TPL CODE

// Return HTML
return $html;

