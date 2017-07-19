<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Wiki extends FW_Extension {
	/**
	 * @internal
	 */
	public function _init() {
	
		add_action( 'init', array( $this, '_action_register_post_type' ) );
		add_action( 'init', array( $this, '_action_register_taxonomy' ) );
		add_action('fw_extensions_after_activation', array($this, 'woffice_wiki_flush'));
	
	}
	
	/**
	 * @internal
	 */
	public function _action_register_post_type() {

		$labels = array(
			'name'               => __( 'Wiki', 'woffice' ),
			'singular_name'      => __( 'Article', 'woffice' ),
			'menu_name'          => __( 'Wiki', 'woffice' ),
			'name_admin_bar'     => __( 'Article', 'woffice' ),
			'add_new'            => __( 'Add New', 'woffice' ),
			'new_item'           => __( 'Article', 'woffice' ),
			'edit_item'          => __( 'Edit Article', 'woffice' ),
			'view_item'          => __( 'View Article', 'woffice' ),
			'all_items'          => __( 'All Articles', 'woffice' ),
			'search_items'       => __( 'Search Article', 'woffice' ),
			'not_found'          => __( 'No Article found.', 'woffice' ),
			'not_found_in_trash' => __( 'No Article found in Trash.', 'woffice' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon' => 'dashicons-archive',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'wiki' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor','thumbnail', 'revisions', 'author', 'comments' )
		);
	
		register_post_type( 'wiki', $args );

	}
	
	/**
	 * @internal
	 */
	public function woffice_wiki_flush($extensions) {
	
		if (!isset($extensions['woffice-wiki'])) {
	        return;
	    }
	    
	    flush_rewrite_rules();
		
	}

	/**
	 * @internal
	 */
	public function _action_register_taxonomy() {

		$labels = array(
			'name'              => __( 'Wiki Categories', 'woffice' ),
			'singular_name'     => __( 'Article Category', 'woffice' ),
			'search_items'      => __( 'Search Wiki Categories', 'woffice' ),
			'all_items'         => __( 'All Wiki Categories', 'woffice' ),
			'edit_item'         => __( 'Edit Category', 'woffice' ),
			'update_item'       => __( 'Update Wiki Category', 'woffice' ),
			'add_new_item'      => __( 'Add New Wiki Category', 'woffice' ),
			'new_item_name'     => __( 'New Wiki Category', 'woffice' ),
			'menu_name'         => __( 'Categories', 'woffice' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'wiki-category' ),
		);
	
		register_taxonomy( 'wiki-category', array( 'wiki' ), $args );
		
	}
	
	/**
	 * Function to return if the user has already voted
	 */
	public function woffice_user_has_already_voted($post_ID) {

		$timebeforerevote = 240; // = 4 hours
		
		// Retrieve post votes IPs
	    $meta_IP = get_post_meta($post_ID, "voted_IP");
	    if (empty($meta_IP)) {
		    return false;
	    }
	    $voted_IP = $meta_IP[0];
	     
	    if(!is_array($voted_IP))
	        $voted_IP = array();
	         
	    // Retrieve current user IP
	    $ip = $_SERVER['REMOTE_ADDR'];
	     
	    // If user has already voted
	    if(in_array($ip, array_keys($voted_IP)))
	    {
	        $time = $voted_IP[$ip];
	        $now = time();
	         
	        // Compare between current time and vote time
	        if(round(($now - $time) / 60) > $timebeforerevote)
	            return false;
	             
	        return true;
	    }
	     
	    return false;
		
	}
		
}