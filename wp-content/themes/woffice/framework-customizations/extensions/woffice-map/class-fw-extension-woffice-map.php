<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Map extends FW_Extension {
	/**
	 * @internal
	 */
	public function _init() {
		add_action('fw_extensions_after_activation', array($this, 'woffice_map_on_activate'));
		add_action('fw_extension_settings_form_saved:woffice-map', array($this, 'woffice_map_on_activate'));
		add_action('fw_extension_settings_form_saved:woffice-map', array($this, 'woffice_map_save_api'));
		add_action('fw_extensions_before_deactivation', array($this, 'woffice_maps_delete_field'));
	}
	
	/**
	 * GET ALL USERS AND CHECK FOR LOCATION -> ADD TO AN ARRAY [ID] => 'ADDRESS'
	 */
	public function woffice_get_map_members_locations() {
		/*GET MEMBERS*/
		if (function_exists('bp_is_active')){
			if ( bp_is_active( 'xprofile' ) ){
				$woffice_wp_users = get_users(array('fields' => array('ID')));
				/*LOOP AND CREATE ARRAY*/
				$users_locations = array();
				foreach($woffice_wp_users as $woffice_wp_user) {
					$field_name = $this->woffice_map_field_name();
					$location = xprofile_get_field_data($field_name, $woffice_wp_user->ID);
					if(!empty($location)){
						/*FILL THE ARRAY*/
						$users_locations[$woffice_wp_user->ID] = $location;
					}
				}
				return $users_locations;
			}
		}
	}
	
	/**
	 * Save API KEY Value 
	 */
	public function woffice_map_save_api() {
 		$key_option = fw_get_db_ext_settings_option( $this->get_name(), 'map_api' );
 		update_option('woffice_fw_get_api_google_geocoding', $key_option);
	}
	
	/**
	 * GET JSON FROM GOOGLE MAP API AND OUR USERS ARRAY
	 */
	public function woffice_update_locations() {
	 	$the_users_locations = $this->woffice_get_map_members_locations();
	 	if (!empty($the_users_locations)){
	 		/* WE USE A NEW ARRAY WITH DATA FOR THE GOOGLE MAP*/
	 		$the_users_mapready = array();
	 		$count = 0;
	 			
 			/* GET GEOCODE FOR THIS LOCATION */
 			$key_option = fw_get_db_ext_settings_option( $this->get_name(), 'map_api' );
 			if (!empty($key_option)){
	 			$key = $key_option;
 			}
 			else {
	 			$key = "AIzaSyAyXqXI9qYLIWaD9gLErobDccodaCgHiGs";
 			}
	 			
	 		foreach($the_users_locations as $id => $the_user_location){
	 		
	 			$location = urlencode($the_user_location);
	 			
				$request = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . $location . "&sensor=false&key=" . $key);
				
				$json = json_decode($request, true);
				
				/*TRANSFORM RESULTS*/
				$check_status = $this->woffice_map_api_status();
				if(!empty($json) && $check_status == "OK"){
					$name = $json['results'][0]['formatted_address'];
					$latitude = $json['results'][0]['geometry']['location']['lat'];
					$longitude = $json['results'][0]['geometry']['location']['lng'];
					$the_users_mapready[$count] = array('name'=>$name,'lat'=>$latitude, 'long'=>$longitude, 'user_id'=>$id);
					$count++;
				}
				
	 		}
	 		
	 		$the_users_mapready_saved = json_encode($the_users_mapready);
	 		
	 		/* Save the data in the Database */
	 		update_option('woffice_map_locations',$the_users_mapready_saved);
	 	}
	}
	
	/**
	 * GET THE API CONNECTION STATUS
	 */
	public function woffice_map_api_status() {
	 			
		/* GET THE API KEY */
		$key_option = get_option('woffice_fw_get_api_google_geocoding','');
		if (!empty($key_option)){
			$key = $key_option;
		}
		else {
			$key = "AIzaSyAyXqXI9qYLIWaD9gLErobDccodaCgHiGs";
		}
		/* Default location from Google DOC */
	 	$location = "1600+Amphitheatre+Parkway,+Mountain+View,+CA";	
	 	/* The Request */	
		$request = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . $location . "&sensor=false&key=" . $key);	
		$php_result = json_decode($request, true);
		/* We get the status (https://developers.google.com/maps/documentation/geocoding/intro) */
		$status = $php_result['status'];
		
		return $status;
		
	}
	
	/**
	 * GENERATE MAP JS
	 * $type : members / widget
	 */
	public function woffice_users_map_js($type) {
		$the_data = get_option('woffice_map_locations');
		if(!empty($the_data)) {
			$from_option = get_option('woffice_map_locations');
		} else {
			$from_option = '[{"name":"No Data","lat":0,"long":0,"user_id":1}]';
		}
		$js_array = json_decode($from_option);
		$map_zoom = fw_get_db_ext_settings_option('woffice-map', 'map_zoom');
		$map_center = fw_get_db_ext_settings_option('woffice-map', 'map_center');
			
		$map_id = ($type == "members") ? "members-map" : "members-map-widget";

		if (!empty($js_array)) {
			
			$html = '<script type="text/javascript">
			jQuery(function () {
			
				var locations = '. json_encode($js_array) .';
				
				var c = new google.maps.LatLng('.$map_center['coordinates']['lat'].','.$map_center['coordinates']['lng'].');
				 
				var map = new google.maps.Map(document.getElementById("'.$map_id.'"), {
				  zoom: '.$map_zoom.',
				  center: c,
				  mapTypeId: google.maps.MapTypeId.ROADMAP,
				  scrollwheel: false,
				});
			
				var infowindow = new google.maps.InfoWindow();
			
				var marker;';
				$count = 0;
                $buddy_excluded_directory = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_excluded_directory') : '';
                $buddy_excluded_directory_ready = (!empty($buddy_excluded_directory)) ? $buddy_excluded_directory : array('zZzZzZzZzZ');
                foreach($js_array as $location) {
					if(is_object(get_userdata($location->user_id))){
						$user = get_userdata($location->user_id);
	                    if(count(array_intersect($buddy_excluded_directory_ready, $user->roles)) == 0) {
	                        $avatar_url = fw()->extensions->get( 'woffice-map' )->woffice_get_avatar_url(get_avatar($location->user_id,100));
	                        $echo_avatar = (!empty($avatar_url)) ? '<img src=\"'.esc_url($avatar_url).'\">': '';
	                        $theinfoboxcontent = '<div class=\"user-map-box\">'.$echo_avatar.'<h3>'.esc_html($user->user_login).'</h3><p>'.esc_html($location->name).'</p></div>';
	
	                        if (!empty($location->lat) && !empty($location->long)){
	                            $html .= 'marker = new google.maps.Marker({
									position: new google.maps.LatLng('.esc_html($location->lat).', '.esc_html($location->long).'),
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
				}
				
				if ($type == "members") {
					$html .= 'jQuery("#members-map-trigger").on("click", function () {
						jQuery("#members-map").slideToggle(300, function(){
						    google.maps.event.trigger(map, "resize"); // resize map
						    map.setCenter(c); // set the center
						});
						var theIcons = jQuery("a#members-map-trigger > i");
						if(theIcons.hasClass("fa-map-marker")){
							jQuery(theIcons).removeClass("fa-map-marker");
							jQuery(theIcons).addClass("fa-times");
						}
						else{
							jQuery(theIcons).removeClass("fa-times");
							jQuery(theIcons).addClass("fa-map-marker");
						}
						jQuery("#members-map-loader").fadeIn();
						function slideMap(){
							jQuery("#members-map-loader").fadeOut();
						}
						setTimeout(slideMap, 2000);
						
						jQuery("#buddypress").toggleClass("has-map");
			        });';
			    }
			
			$html .= '});
			</script>';
		}
		else {
			if ($type == "members") {
				// We display an empty map
				$html = '<script type="text/javascript">
					jQuery(function () {
						
						var c = new google.maps.LatLng('.$map_center['coordinates']['lat'].','.$map_center['coordinates']['lng'].');
						 
						var map = new google.maps.Map(document.getElementById("'.$map_id.'"), {
						  zoom: '.$map_zoom.',
						  center: c,
						  mapTypeId: google.maps.MapTypeId.ROADMAP
						});
						
						var infowindow = new google.maps.InfoWindow();
						
						jQuery("#members-map-trigger").on("click", function () {
							jQuery("#members-map").slideToggle(300, function(){
							    google.maps.event.trigger(map, "resize"); // resize map
							    map.setCenter(c); // set the center
							});
							var theIcons = jQuery("a#members-map-trigger > i");
							if(theIcons.hasClass("fa-map-marker")){
								jQuery(theIcons).removeClass("fa-map-marker");
								jQuery(theIcons).addClass("fa-times");
							}
							else{
								jQuery(theIcons).removeClass("fa-times");
								jQuery(theIcons).addClass("fa-map-marker");
							}
							jQuery("#members-map-loader").fadeIn();
							function slideMap(){
								jQuery("#members-map-loader").fadeOut();
							}
							setTimeout(slideMap, 2000);
							
							jQuery("#buddypress").toggleClass("has-map");
				        });
					});
					
				</script>';
			}
			else {
				$html = "";
			}
		}
		
		return $html;
	}
	
	/**
	 * LAUNCH IT ON EXTENSION ACTIVATED
	 */
	public function woffice_map_on_activate($extensions) {
		 /* ONLY IF IT's the MAP extension */
		if (!isset($extensions['woffice-map'])) {
	        return;
	    }
	    $this->woffice_update_locations();
	}
 
	
	/**
	 * RETURN VIEW HOOKED TO BUDDYORESS
	 */
	public function render() {
		return $this->render_view( 'view' );
	}
	
	/**
	 * GET AVATAR URL (USED IN THE MAP
	 */
	public function woffice_get_avatar_url($get_avatar){
	    preg_match('/src="(.*?)"/i', $get_avatar, $matches);
	    return $matches[1];
	}
	/**
	 * DELETE THE BIRTHDAY FIELD IN XPROFILE
	 */
	public function woffice_maps_delete_field($extensions) {
		/* ONLY IF IT's the BIRTHDAY extension */
		if (!isset($extensions['woffice-map'])) {
	        return;
	    }
	    
	    if ( bp_is_active( 'xprofile' ) ){
			global $bp;
			global $wpdb;
			$table_name = woffice_get_xprofile_table('fields');
			$field_name = $this->woffice_map_field_name();
		    $sqlStr = "SELECT `id` FROM $table_name WHERE `name` = '$field_name'";
		    $field = $wpdb->get_results($sqlStr);
		    if(count($field) > 0)
		    {
		        xprofile_delete_field($field[0]->id);
		    }
		}
		
	}

	/**
	 * Get the field's name
	 * @return string
	 */
	public function woffice_map_field_name() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'map_field_name' );
	}
}