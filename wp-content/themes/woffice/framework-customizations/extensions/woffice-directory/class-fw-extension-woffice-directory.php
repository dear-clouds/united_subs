<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Directory extends FW_Extension {
	/**
	 * @internal
	 */
	public function _init() {
	
		add_action( 'init', array( $this, '_action_register_post_type' ) );
		add_action( 'init', array( $this, '_action_register_taxonomy' ) );
		add_action('fw_extensions_after_activation', array($this, 'woffice_directory_flush'));
	
	}
	
	/**
	 * @internal
	 */
	public function _action_register_post_type() {
		
		// Get the name from the settings 
		$custom_post_name = fw_get_db_ext_settings_option( 'woffice-directory', 'custom_post_name' );
		$custom_post_name_ready = (!empty($custom_post_name)) ? $custom_post_name : 'item'; 
		// Plural
		$plural_form = "s";
		$custom_post_name_plural = $custom_post_name_ready.$plural_form;
		// Slug
		$custom_post_name_slug = sanitize_title($custom_post_name_ready);

		// sprintf( __( 'New %s', 'fw' ), $post_names['singular'] ),
		$labels = array(
			'name'               => $custom_post_name_slug,
			'singular_name'      => $custom_post_name_ready,
			'menu_name'          => $custom_post_name_plural,
			'name_admin_bar'     => __( 'Item', 'woffice' ),
			'add_new'            => __( 'Add New', 'woffice' ),
			'new_item'           => $custom_post_name_ready,
			'edit_item'          => __( 'Edit Item', 'woffice' ),
			'view_item'          => sprintf( __( 'View %s', 'woffice' ), $custom_post_name_ready),
			'all_items'          => sprintf( __( 'All %s', 'woffice' ), $custom_post_name_plural),
			'search_items'       => sprintf( __( 'Search %s', 'woffice' ), $custom_post_name_plural),
			'not_found'          => sprintf( __( 'No %s found', 'woffice' ), $custom_post_name_ready),
			'not_found_in_trash' => sprintf( __( 'No %s found in the trash', 'woffice' ), $custom_post_name_ready),
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon' => 'dashicons-editor-ul',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $custom_post_name_slug ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title', 'excerpt','thumbnail', 'revisions', 'author', 'comments' )
		);
	
		register_post_type( 'directory', $args );
		
	}
	
	/**
	 * @internal
	 */
	public function woffice_directory_flush($extensions) {
	
		if (!isset($extensions['woffice-directory'])) {
	        return;
	    }
	    
	    flush_rewrite_rules();
		
	}

	/**
	 * @internal
	 */
	public function _action_register_taxonomy() {

		$labels = array(
			'name'              => __( 'Directory Categories', 'woffice' ),
			'singular_name'     => __( 'Directory Category', 'woffice' ),
			'search_items'      => __( 'Search Directory Categories', 'woffice' ),
			'all_items'         => __( 'All Directory Categories', 'woffice' ),
			'edit_item'         => __( 'Edit Directory', 'woffice' ),
			'update_item'       => __( 'Update Directory Category', 'woffice' ),
			'add_new_item'      => __( 'Add New Directory Category', 'woffice' ),
			'new_item_name'     => __( 'New Directory Category', 'woffice' ),
			'menu_name'         => __( 'Categories', 'woffice' ),
		);
	
		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'directory-category' ),
		);
	
		register_taxonomy( 'directory-category', array( 'directory' ), $args );
		
	}
	
	/**
	 * ARRAY OF LOCATIONS FOR THE MAP
	 */
	public function woffice_directory_map_array() {
	
		$map_array = array();
		
		/*For each posts*/
		$directory_query = new WP_Query('post_type=directory&showposts=-1'); 
		if ( $directory_query->have_posts() ) :
							
			while($directory_query->have_posts()) : $directory_query->the_post();
			
				$title = get_the_title();
				$description = woffice_directory_get_excerpt();
				/*Location*/
				$item_location = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'item_location') : '';
				if (!empty($item_location)){
					$lat = $item_location['coordinates']['lat'];
					$lng = $item_location['coordinates']['lng'];
					$city = (!empty($item_location['city'])) ? $item_location['city'] : '';
					$country = (!empty($item_location['country'])) ? $item_location['country'] : '';
				} else {
					$lat = 0;
					$lng = 0;
					$city = 'no city';
					$country = 'International';
				}
				

				$map_array[] = array(
					'title' => $title,
					'description' => $description,
					'lat' => $lat,
					'lng' => $lng,
					'city' => $city,
					'country' => $country,
				);
			
			endwhile;
			
		endif;
		
		wp_reset_postdata();
		
		return $map_array;
			
	}
	
	/**
	 * GENERATE MAP JS for the main page
	 */
	public function woffice_directory_map_js_main() {
		
		$map_array = $this->woffice_directory_map_array();
		
		/*SETTINGS FROM THE OPTIONS*/
		$map_zoom = fw_get_db_ext_settings_option('woffice-directory', 'map_zoom');
		$map_center = fw_get_db_ext_settings_option('woffice-directory', 'map_center');
		
		
		$html = '<script type="text/javascript">
		jQuery(function () {';
				
			if (!empty($map_array)) {
				
				$html .= 'var c = new google.maps.LatLng('.$map_center['coordinates']['lat'].','.$map_center['coordinates']['lng'].');
				 
				var map = new google.maps.Map(document.getElementById("map-directory"), {
				  zoom: '.$map_zoom.',
				  center: c,
				  mapTypeId: google.maps.MapTypeId.ROADMAP,
				  scrollwheel: false,
				});
			
				var infowindow = new google.maps.InfoWindow();
			
				var marker;';
				$count = 0;
				foreach($map_array as $item) {
					$bottom = (!empty($item['city'])) ? '<i class=\"fa fa-map-marker\"></i>'.sanitize_text_field($item['city']).', '.sanitize_text_field($item['country']) : '';
					$theinfoboxcontent = '<div class=\"directory-map-box\"><h3>'.sanitize_text_field($item['title']).'</h3><p>'.sanitize_text_field($item['description']).'</p>'.$bottom.'</div>';
				
					if (!empty($item['lat']) && !empty($item['lng'])){
					    $html .= 'marker = new google.maps.Marker({
					    	position: new google.maps.LatLng('.esc_html($item['lat']).', '.esc_html($item['lng']).'),
							map: map
						});';
						
						$html .= 'google.maps.event.addListener(marker, "click", (function(marker) {
					    	return function() {
								infowindow.setContent("'.$theinfoboxcontent.'");
								infowindow.open(map, marker);
							}
						})(marker));';
					}
					
					$count++;
				} 
				
			}
			
			/* For the search form */
			$html .= 'jQuery("#directory-show-search").on("click", function () {
				jQuery("#directory-search").slideToggle(300);
				
				var theIcons = jQuery("a#directory-show-search > i");
				if(theIcons.hasClass("fa-search")){
					jQuery(theIcons).removeClass("fa-search");
					jQuery(theIcons).addClass("fa-times");
				}
				else{
					jQuery(theIcons).removeClass("fa-times");
					jQuery(theIcons).addClass("fa-search");
				}
				
	        });';
			
		$html .= '});';
		$html .= '</script>';
		
		return $html;
	}
	
	/**
	 * GENERATE MAP JS for the single page
	 */
	public function woffice_directory_map_js_single() {
		
		global $post;
		$post_id = $post->ID;
		
		$item_location = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'item_location') : '';
	
		if (!empty($item_location)){
			
			$html = '<script type="text/javascript">
			jQuery(function () {
				
				var c = new google.maps.LatLng('.$item_location['coordinates']['lat'].','.$item_location['coordinates']['lng'].');
				 
				var map = new google.maps.Map(document.getElementById("map-directory-single"), {
				  zoom: 6,
				  center: c,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				
				var marker = new google.maps.Marker({
					position: {lat: '.$item_location['coordinates']['lat'].', lng: '.$item_location['coordinates']['lng'].'},
					map: map,
					title: "'.get_the_title().'"
				});';
				
				
			
			$html .= '});';
			$html .= '</script>';
		}
		
		return $html;
	}
	
		
}
