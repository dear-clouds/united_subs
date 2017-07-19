<?php
/* BuddyBoss Updater for Plugin
 * Version : 1.0
 **/
if( !class_exists('buddyboss_updater_plugin') ) {
    class buddyboss_updater_plugin {
    
    var $license;
        var $api_url;
        var $plugin_id = 0;
        var $plugin_path;
        var $plugin_slug;
        
    
        function __construct( $api_url, $plugin_path, $plugin_id, $license = '' ) {
            $this->api_url = $api_url;
            $this->plugin_path = $plugin_path;
            $this->license = $license;
            $this->plugin_id = $plugin_id;
            
        if(strstr($plugin_path, '/')) list ($part1, $part2) = explode('/', $plugin_path); 
            else $part2 = $plugin_path;
        
            $this->plugin_slug = str_replace('.php', '', $part2);
    
            add_filter( 'pre_set_site_transient_update_plugins', array(&$this, 'update_plugin') );
            add_filter( 'plugins_api', array(&$this, 'plugins_api'), 10, 3 );
        }
    
        function update_plugin( $transient ) {
        
            if(empty($transient->checked)) { return $transient; }
            
            $request_data = array(
                'id' => $this->plugin_id,
                'slug' => $this->plugin_slug,
                'version' => $transient->checked[$this->plugin_path]
            );
        
            if ($this->license) $request_data['license'] = $this->license;
            
            $request_string = $this->request_call( 'update_check', $request_data );
            $raw_response = wp_remote_post( $this->api_url, $request_string );
            
            $response = null;
            if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ){
            $response = unserialize($raw_response['body']);
            }
            
        //Feed the candy
            if( is_object($response) && !empty($response) ) {
                $transient->response[$this->plugin_path] = $response;
            return $transient;
        }
 
        // If there is any same plugin from wordpress.org repository then unset it.
        if ( isset( $transient->response[$this->plugin_path] ) ) {
            if ( strpos( $transient->response[$this->plugin_path]->package, 'wordpress.org' ) !== false  ) {
            unset($transient->response[$this->plugin_path]);
            }
        }

            return $transient;
        }
    
        function plugins_api( $def, $action, $args ) {
        
            if( !isset($args->slug) || $args->slug != $this->plugin_slug ) return $def;
            
            $plugin_info = get_site_transient('update_plugins');
        
            $request_data = array(
                'id' => $this->plugin_id,
                'slug' => $this->plugin_slug,
                'version' => (isset($plugin_info->checked)) ? $plugin_info->checked[$this->plugin_path] : 0 // Current version
            );
        
        if ($this->license) { $request_data['license'] = $this->license; }
            
            $request_string = $this->request_call( $action, $request_data );
            $raw_response = wp_remote_post( $this->api_url, $request_string );
                    
            if( is_wp_error($raw_response) ){
                $res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 'buddyboss-media'), $raw_response->get_error_message());
            } else {
                $res = unserialize($raw_response['body']);
                if ($res === false)
                    $res = new WP_Error('plugins_api_failed', __('An unknown error occurred', 'buddyboss-media'), $raw_response['body']);
            }
            
            return $res;
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