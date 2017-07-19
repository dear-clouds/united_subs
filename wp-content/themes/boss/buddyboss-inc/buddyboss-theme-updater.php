<?php
/*
 * BuddyBoss Updater for Theme
 * Version : 1.0
*/

if( !class_exists('buddyboss_updater_theme') ) {
    class buddyboss_updater_theme {
    
        var $api_url;
        var $theme_id = '';
        var $theme_slug;
        var $license;
    
        function __construct( $api_url, $theme_slug, $theme_id ,$license = '' ) {
           
            $this->api_url = $api_url;
            $this->theme_slug = $theme_slug;
            $this->theme_id = $theme_id;
            
            add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'update_plugin') );
            
        }
        
        function update_plugin( $transient ) {
            if (empty($transient->checked)) { return $transient; }
            
            $request_data = array(
                'id' => $this->theme_id,
                'slug' => $this->theme_slug,
                'version' => $transient->checked[$this->theme_slug]
            );
            
            if ($this->license) { $request_data['license'] = $this->license; }
            
            $request_string = $this->request_call( 'theme_update', $request_data );
            $raw_response = wp_remote_post( $this->api_url, $request_string );
            
            $response = null;
            if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ){
                $response = unserialize($raw_response['body']);
            }
            
            //Feed the candy !
            if( !empty($response) ) {
                $transient->response[$this->theme_slug] = $response;
            }
            
            return $transient;
        }
        
        function request_call( $action, $args ) {
            global $wp_version;
            
            return array(
                'body' => array(
                    'action' => $action, 
                    'request' => serialize($args),
                    'api-key' => md5(home_url())
                ),
                'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
            );  
        }

    }
}

?>