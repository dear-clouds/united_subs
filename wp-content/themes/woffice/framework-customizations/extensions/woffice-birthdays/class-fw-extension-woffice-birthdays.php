<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Birthdays extends FW_Extension {

	/**
	 * @internal
	 */
	public function _init() {
		add_action('fw_extensions_before_deactivation', array($this, 'woffice_birthdays_delete_field'));
		add_action('init', array($this, 'woffice_birthdays_add_field'));
	}
	
	/**
	 * This function returns an array of the members birthdays :
     * Only today and upcoming birthdays sortedin ascending order
     *
	 * array(
	 * 	  id_member => array('datetime' => DateTime Object);
	 * )
	 */
	public function woffice_birthdays_get_array() {
	
	 	/* We get all the users ID */
		$woffice_wp_users = get_users(array('fields' => array('ID')));
		/*Array returned*/
		$members_birthdays = array();	

		/* We check if the member has a birthday set */
		foreach($woffice_wp_users as $woffice_wp_user) {
		
			/* Fetch the value from the database */
			$field_name = $this->woffice_birthdays_field_name();

			$field_id = xprofile_get_field_id_from_name( $field_name );
            $woffice_birthday = maybe_unserialize( BP_XProfile_ProfileData::get_value_byid( $field_id, $woffice_wp_user->ID ) );

			if(!empty($woffice_birthday)){
				
				/*We transform the string in a date*/
				$date_created = DateTime::createFromFormat('Y-m-d H:i:s', $woffice_birthday);
   				if ($date_created != false && date('md', $date_created->getTimestamp()) >= date('md')){

					/* We add it to the array */
					$members_birthdays[$woffice_wp_user->ID] = array(
                        'datetime' => $date_created
					);
				}
			}
			
		}

        uasort($members_birthdays, array($this, "date_comparison"));

		return $members_birthdays;
	}		 

	
	/**
	 * Custom function to search in our array in the function below (from http://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array)
	 */		
	public function woffice_in_multiarray($value, $array) {
		if(in_array($value, $array)) {
		  return true;
		}
		foreach($array as $item) {
		  if(is_array($item) && $this->woffice_in_multiarray($value, $item))
		       return true;
		}
		return false;
	}	

	/**
	 * It will generate the title for the front view
	 */
	public function woffice_birthdays_title($all_bithdays) { 
		
		if (!empty($all_bithdays)){

			/*Is there a birthday today ?*/
            $todaybirthdays = 0;
            foreach($all_bithdays as $birthday) {
                if(date('md', $birthday["datetime"]->getTimestamp()) == date('md')){
                    $todaybirthdays++;
                } else
                    break;
            }

            if ($todaybirthdays != null) {
				/* Is there on or several birthadays ? */
				if ( $todaybirthdays > 1 ) {
					$message = __('Happy Birthdays!','woffice');
				} 
				else {
					$message = __('Happy Birthday!','woffice');
				}

				return '<h3>'. $message . '</h3>';
			}
			else {
				return '<h3>'. __('Upcoming Birthdays','woffice') .'</h3>'; 
			}
			
		}
		else {
			return '<h3>'. __('Sorry no birthdays set...','woffice') .'</h3>';	
		}
		
	}
	
	/**
	 * It will generate the content for the front viw
	 */
	public function woffice_birthdays_content($all_bithdays) { 
		
		if (!empty($all_bithdays)){
			
            $max_items = $this->woffice_birthdays_to_display();
            $c = 0;

            foreach($all_bithdays as $user_id => $birthday) {
                if($c == $max_items)
                    break;

                $activation_key = get_user_meta($user_id, 'activation_key');
                if(empty($activation_key)) {
                    //if(date('m', $birthday["datetime"]->getTimestamp()) == $current_month && date('d', $birthday["datetime"]->getTimestamp()) > date('d') ) {
                    //if(date('md', $birthday["datetime"]->getTimestamp()) >= date('md') ) {
                    $name_to_display = woffice_get_name_to_display($user_id);

					$age = (int)date("Y") - (int)date("Y", $birthday["datetime"]->getTimestamp());
					// We don't display negative ages
					if($age > 1) {
						echo '<li class="clearfix">';
						if (function_exists('bp_is_active')):
							echo '<a href="' . bp_core_get_user_domain($user_id) . '">';
							echo get_avatar($user_id);
							echo '</a>';
						else :
							echo get_avatar($user_id);
						endif;
						echo '<span class="birthday-item-content">';
						echo '<strong>' . $name_to_display . '</strong>';
						if ($this->woffice_birthdays_display_age() != 'nope') {
							echo ' <i>(' . $age . ')</i>';
						}
						echo ' ', _x('on', 'happy birthday ON 25-06', 'woffice');
						$date_format = $this->woffice_birthdays_date_format();
						$date_format = (!empty($date_format)) ? $date_format : 'F d';
						echo ' <span class="label">' . date_i18n($date_format, $birthday["datetime"]->getTimestamp()) . '</span>';
						echo '</span>';
						echo '</li>';

                        $c++;
					}
                }


            }
			
		}
	}
	
	/**
	 *  CREATE FUNCTIONS TO ADD THE BIRTHDAY FIELD TO XPROFILE
	 */
	public function woffice_birthdays_add_field() {

		// We get the field's name :
		$field_name = $this->woffice_birthdays_field_name();
	
		if ( function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
			global $bp;
			global $wpdb;
			$table_name = woffice_get_xprofile_table('fields');
			$sqlStr = "SELECT `id` FROM $table_name WHERE `name` = '$field_name'";
		    $field = $wpdb->get_results($sqlStr);
		    if(count($field) > 0)
		    {
		        return;
		    }
			$insert_field = xprofile_insert_field(
		        array (
		        	'field_group_id'  => 1,
					//'can_delete' => true,
					'type' => 'datebox',
					//'description' => __('We will only use it for the Birthday widget, so we can celebrate everyone\s birthday.','woffice'),
					'name' => $field_name,
					//'field_order'     => 1,
					//'is_required'     => false,
		        )
		    );
		    //fw_print($insert_field);
		}
		 
	}
	
	/**
	 * DELETE THE BIRTHDAY FIELD IN XPROFILE
	 */
	public function woffice_birthdays_delete_field($extensions) {
		/* ONLY IF IT's the BIRTHDAY extension */
		if (!isset($extensions['woffice-birthdays'])) {
	        return;
	    }
		global $bp;

		$field_name = $this->woffice_birthdays_field_name();

		$id = xprofile_get_field_id_from_name($field_name);
		xprofile_delete_field($id);
	}
	
	/**
	 * CREATE FUNCTIONS TO GET THE OPTION FROM THE SETTINGS
	 * @return yes or nope
	 */
	public function woffice_birthdays_display_age() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'display_age' );
	}

	/**
	 * Get date format of birthday set in Birthday extension options
	 * @return string
	 */
	public function woffice_birthdays_date_format() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'birthday_date_format' );
	}

    /**
     * Get the field's name
     * @return string
     */
    public function woffice_birthdays_field_name() {
        return fw_get_db_ext_settings_option( $this->get_name(), 'birthday_field_name' );
    }

    /**
     * Get the max number of the item to display
     * @return string
     */
    public function woffice_birthdays_to_display() {
        return fw_get_db_ext_settings_option( $this->get_name(), 'birthdays_to_display' );
    }

    /**
     * Used for order array of object, containing dates
     */
    private function date_comparison($a, $b) {
        return (date('md', $a['datetime']->getTimestamp()) > date('md', $b['datetime']->getTimestamp()));
    }
}