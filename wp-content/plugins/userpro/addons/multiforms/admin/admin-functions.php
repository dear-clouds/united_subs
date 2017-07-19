<?php

	/* Create a multi form / seperate fields */
	add_action('wp_ajax_nopriv_userpro_mu_create', 'userpro_mu_create');
	add_action('wp_ajax_userpro_mu_create', 'userpro_mu_create');
	function userpro_mu_create(){
		if (!current_user_can('manage_options'))
			die(); // admin priv
			
		if (!isset($_POST['name']) || !isset($_POST['userpro_mu_fields'])) die();
		
		global $userpro;
		$output = '';
		
		$name = $_POST['name'];
		$fields = $_POST['userpro_mu_fields'];
		
		$multi_forms= userpro_mu_get_option('multi_forms');
		$multi_forms[$name] = $fields;
		userpro_mu_set_option('multi_forms',$multi_forms);
		
		$output['result'] = sprintf(__('Done. You can use this seperate registration form by adding this to your register shortcode: <code>type=%1$s</code> Example: <strong>[userpro template=register type=%1$s]</strong>','userpro'), $name);
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}

	/* Get register fields as checkboxes */
	add_action('wp_ajax_nopriv_userpro_mu_getfields', 'userpro_mu_getfields');
	add_action('wp_ajax_userpro_mu_getfields', 'userpro_mu_getfields');
	function userpro_mu_getfields(){
		if (!current_user_can('manage_options'))
			die(); // admin priv
			
		global $userpro;
		$output = '';
		
		$res = '';
		$res .= '<p>'.__('Now check all fields that you want to make available for this registration form. (Choose only these that apply)','userpro').'</p>';
		$res .= '<form action="" method="post" class="userpro_mu_form">';
		foreach( userpro_fields_group_by_template( 'register', 'default') as $key => $array ) {
			if ( $userpro->field_label($key) || isset($array['heading']) && $array['heading'] != ''){
			$res .= '<p><label class="userpro-checkbox">
					<input type="checkbox" value="'.$key.'" name="userpro_mu_fields[]" />&nbsp;&nbsp;';
			if ( $userpro->field_label($key) ) {
			$res .= $userpro->field_label($key);
			} elseif ($array['heading'] != '') {
			$res .= '<strong>'.$array['heading'].'</strong>';
			}
			$res .= '</label></p>';
			}
		}
		$res .= '</form>';
		
		$output['res'] = $res;
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
