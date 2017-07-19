<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Poll extends FW_Extension {

	/**
	 * @internal
	 */
	public function _init() {
		/* ADD ACTIONS */
		add_action('fw_extensions_after_activation', array($this, 'woffice_poll_create_table'));
		add_action('fw_extensions_after_activation', array($this, 'woffice_poll_save_users'));
		add_action('fw_extensions_after_activation', array($this, 'woffice_poll_default_answer'));
		add_action('fw_extensions_before_deactivation', array($this, 'woffice_poll_delete_table'));
		add_action('fw_extensions_before_deactivation', array($this, 'woffice_poll_refresh_users'));
		add_action('fw_extension_settings_form_saved:woffice-poll', array($this, 'woffice_poll_add_answers'));
		add_action('fw_extension_settings_form_render:woffice-poll', array($this, 'woffice_poll_add_delete_button'));
		add_action('fw_extension_settings_form_render:woffice-poll', array($this, 'woffice_poll_export_button'));
		/* DEFINE CONSTANT */
		global $wpdb;
		// We check for multisite : 
	    if (is_multisite() && is_main_site()) {
		    $prefix = $wpdb->base_prefix;
	    } else {
	    	$prefix = $wpdb->prefix;
	    }
		define( 'WOFFICE_POLL_TABLE', $prefix . 'woffice_poll');
	}
	
	/**
	 * CREATE FUNCTIONS TO GET THE VALUES FROM THE EXTENSION'S SETTINGS
	 * @return string
	 */
	/* THE POLL QUESTION */
	public function woffice_get_poll_name() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'name' );
	}
	/* THE POLL TYPE -> CHECKBOX OR RADIO BUTTONS */
	public function woffice_get_poll_type() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'type' );
	}
	/* THE QUESTIONS */
	public function woffice_get_poll_answers() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'answers', array('Answer 1'));
	}
	
	/**
	 * CREATE NEW TABLE IN THE DATABASE
	 */	
	public function woffice_poll_create_table($extensions) {
	
		/* ONLY IF IT's the POLL extension */
		if (!isset($extensions['woffice-poll'])) {
	        return;
	    }
	    
		/* GET GLOBAL FOR DATABASE */
        global $wpdb;
        
		/* CHARSET */
		$charset_collate = $wpdb->get_charset_collate();
		
		/* SQL CODE */
		$table_name = WOFFICE_POLL_TABLE;
		$sql = "CREATE TABLE $table_name (
		  id MEDIUMINT NOT NULL AUTO_INCREMENT,
		  label VARCHAR(255) NOT NULL,
		  reps INT  NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		dbDelta( $sql );
		
	}
	
	/**
	 * DELETE TABLE IN THE DATABASE
	 */	
	public function woffice_poll_delete_table($extensions) {
	
	    /* ONLY IF IT's the POLL extension */
		if (!isset($extensions['woffice-poll'])) {
	        return;
	    }
	    
		/* GET GLOBAL FOR DATABASE */
        global $wpdb;
		
		/* SQL CODE */
		$table_name = WOFFICE_POLL_TABLE;
		$sql = "DROP TABLE IF EXISTS $table_name;";
		$wpdb->query($sql);
		
	}
	
	/**
	 * SAVE DEFAULT VALUE TO THE DATABASE
	 */
	public function woffice_poll_default_answer() {
	
		global $wpdb;
		
		/*IN THE POLL TABLE*/		
	    $wpdb->insert( 
			WOFFICE_POLL_TABLE, 
			array('label' => 'Answer 1'), 
			array('%s') 
		);
	}
	
	
	/**
	 * ADD DATA FROM THE SETTINGS TO THE DATABASE
	 */
	public function woffice_poll_add_answers() {
	
		global $wpdb;
		
		/* GET THE NEW DATA */
		$data_new = $this->woffice_get_poll_answers();
		
		/* GET ALL THE TABLE WHEN NEW OPTION LABEL IF NOT THERE DELETE! */
		$results = $wpdb->get_results("SELECT label FROM ".WOFFICE_POLL_TABLE);
		foreach($results as $label){
			$the_label = $label->label;
			$present = FALSE;
			foreach($data_new as $single_label){
				$present = ($single_label === $the_label) ? TRUE : FALSE;
				if($present === FALSE ){
					$wpdb->delete( WOFFICE_POLL_TABLE, array( 'label' => $the_label));
				}
			}
		}
		
		/* UPDATE DATA */
		foreach ($data_new as $single){
			/* IF THE DATA DOESN'T EXISTS */
			$exists = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM ".WOFFICE_POLL_TABLE." WHERE label = %s", $single ) );
			if ( ! $exists ) {
				/* THEN, LET SAVE IT */
			    $wpdb->insert( 
					WOFFICE_POLL_TABLE, 
					array('label' => $single), 
					array('%s') 
				);
			}
		}
	}
	
	/**
	 * GENERATE RESULTS FRONTENT
	 */
	public function woffice_poll_get_results() {
	
		global $wpdb;
		
		echo '<div id="woffice-poll-result">';
			$answers = $this->woffice_get_poll_answers();
			
			foreach ($answers as $answer) {
				echo '<div class="woffice-poll-result-answer">';
					// We check first that the table exists
					$check = $wpdb->get_results("SELECT 1 FROM ".WOFFICE_POLL_TABLE." LIMIT 1");
					if ($check != FALSE) {
						$reps = $wpdb->get_var( $wpdb->prepare( "SELECT reps FROM ".WOFFICE_POLL_TABLE." WHERE label = %s",$answer) );
						$all_reps = $wpdb->get_var( "SELECT SUM(reps) FROM ".WOFFICE_POLL_TABLE );
						$rep_percentage = ($all_reps!=0) ? round(($reps/$all_reps)*100,1) : 0;
						echo '<p>'.esc_html($answer).'</p>';
						echo '<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="'.esc_attr($rep_percentage).'" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width: '.esc_attr($rep_percentage).'%;">
								'.esc_html($rep_percentage).'%
							</div>
						</div>';
					}
				echo'</div>';
			}
		echo'</div>';
		
	}
	
	/**
	 * CREATE/UPDATE/DELET USER ID
	 */
	public function woffice_poll_save_users($extensions) {
		/* ONLY IF IT's the POLL extension */
		if (!isset($extensions['woffice-poll'])) {
	        return;
	    }
		$defaultvalue = array(0);
		add_option('woffice_poll_users', $defaultvalue);
	}
	public function woffice_poll_add_user($id) {
		// GET OPTION
		$the_saved_users = get_option('woffice_poll_users');
		// ADD NEW USER
		$newvalue = array_merge($the_saved_users,array($id));
		// UPDATE
		update_option('woffice_poll_users', $newvalue);
	}
	public function woffice_poll_refresh_users($extensions) {
		/* ONLY IF IT's the POLL extension */
		if (!isset($extensions['woffice-poll'])) {
	        return;
	    }
		delete_option( 'woffice_poll_users' );
	}
	
	/**
	 * GENERATE RESULTS BACKEND
	 */
	public function woffice_poll_get_results_backend() {
	
		global $wpdb;
	
		$answers = $this->woffice_get_poll_answers();
		
		$options_answers = array();
		
		if (empty($answers)){
			return array('information' => array('label' => __( 'No results :', 'woffice' ),'type'  => 'html','html'  => 'There is not any result yet.'));
		}
			
		foreach ($answers as $answer) {
		
			$reps = $wpdb->get_var( $wpdb->prepare( "SELECT reps FROM ".WOFFICE_POLL_TABLE." WHERE label = %s",$answer) );
			$all_reps = $wpdb->get_var( "SELECT SUM(reps) FROM ".WOFFICE_POLL_TABLE );
			$rep_percentage = ($all_reps!=0) ? round(($reps/$all_reps)*100,1) : 0;
			$slug_answer = sanitize_title($answer);
			
			$options_answers[$slug_answer] = array(
			    'type'  => 'html',
			    'label' => $answer,
				'value' => 'default hidden value',
			    'desc' => __('In percentage (%)','woffice'),
			    'html'  => $rep_percentage,
			);	
		}
		
		$option_total = array(
			'total' => array(
			    'type'  => 'html',
				'value' => 'default hidden value',
			    'label' => __('Total answers number :','woffice'),
			    'html'  => $all_reps,
			)	
		);
		
		$option_display = array_merge($options_answers, $option_total);
		
		return $option_display;
	}
	
	/**
	 * ADD A REFRESH BUTTON TO THE PAGE
	 */
	public function woffice_poll_add_delete_button() {
		
		echo fw_html_tag('a', array(
			'href'  => admin_url('admin.php?page=fw-extensions&sub-page=extension&extension=woffice-poll&delete_poll=yes'),
			'class' => 'button-secondary',
			'style' => 'margin-bottom: 20px;',
			'onclick' => 'return confirm("'.__('Are you sure you want to delete this poll ?', 'woffice').'");'
		), __('Delete Poll', 'woffice'));
		
	}
	
	/**
	 * ADD AN EXPORT BUTTON
	 */
	public function woffice_poll_export_button() {
		
		echo fw_html_tag('a', array(
			'href'  => admin_url('admin.php?page=fw-extensions&sub-page=extension&extension=woffice-poll&export_poll=yes'),
			'class' => 'button-secondary',
			'style' => 'margin-bottom: 20px;margin-left:10px;',
		), __('Export results', 'woffice'));
		
	}
	
}