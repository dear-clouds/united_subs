<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
* Custom Excerpt function
*/
function woffice_directory_get_excerpt() {
	
	$limit = 20;
	
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).'...';
	} else {
	$excerpt = implode(" ",$excerpt);
	}	
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	
	return $excerpt;
	
}
/**
* Map on the single page
*/
function woffice_directory_single_map(){
	
	$item_location = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'item_location') : '';
	
	if (!empty($item_location)){
		
		echo '<div id="map-directory-single"></div>';
		if (!empty($item_location['city'])) {
			echo '<span class="bottom-map-location"><i class="fa fa-map-marker"></i>'.$item_location['city'].', '.$item_location['country'].'</span>';
		}
		
	} 

	
}
/**
* Fields
* type = page or single
*/
function woffice_directory_single_fields($type){
	
	$class = ($type == "single") ? "on-single" : "intern-box";
	
	// IF NO DEFAULT FIELDS 
	$default_fields = fw_get_db_ext_settings_option('woffice-directory', 'default_fields');
	if (empty($default_fields)) {
		
		$item_fields = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'item_fields') : '';
		if (!empty($item_fields)) {
			echo '<div class="directory-item-fields '.$class.'">';
				echo '<ul>';
				foreach ($item_fields as $field) {
					echo '<li class="directory-item-field">';
						echo (!empty($field['icon'])) ? '<i class="fa '.$field['icon'].'"></i>' : '';
						echo (!empty($field['title'])) ? $field['title'] : '';
					echo '</li>';
				} 
				echo '</ul>';
			echo '</div>';
		}
		
	} else {
		
		// IF DEFAULT FIELDS
		echo '<div class="directory-item-fields '.$class.'">';
			echo '<ul>';
				$counter = 1;
				foreach ($default_fields as $default_field) {
					echo '<li class="directory-item-field">';
						$content = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), $counter.'-content') : '';
						echo (!empty($default_field['icon'])) ? '<i class="fa '.$default_field['icon'].'"></i>' : '';
						echo (!empty($content)) ? $content : '';
					echo '</li>';
					$counter++;	
				}
			echo '</ul>';
		echo '</div>';
	}
	
}
/**
* Template for the search process
*/
/*
function woffice_directory_template_search($template){
	global $wp_query;
	$post_type = get_query_var('post_type');
	if( $wp_query->is_search && $post_type == 'directory' ){
		return locate_template('page-templates/page-directory.php');
	}
	return $template;
}
add_filter('template_include', 'woffice_directory_template_search');
*/