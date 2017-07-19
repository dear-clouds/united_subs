<?php
/*
	===============================================================================

	Copyright 2012  Richard Ashby  (email : wordpress@mediacreek.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/** Registers custom post type*/
function cookielawinfo_register_custom_post_type() {
	$labels = array(
		'name'					=> _x('Cookie Law Info', 'post type general name'),
		'singular_name'			=> _x('Cookie', 'post type singular name'),
		'add_new'				=> _x('Add New', 'cookie type'),
		'add_new_item'			=> __('Add New Cookie Type'),
		'edit_item'				=> __('Edit Cookie Type'),
		'new_item'				=> __('New Cookie Type'),
		'view_item'				=> __('View Cookie Type'),
		'search_items'			=> __('Search Cookies'),
		'not_found'				=> __('Nothing found'),
		'not_found_in_trash'	=> __('Nothing found in Trash'),
		'parent_item_colon'		=> ''
	);
	$args = array(
		'labels'				=> $labels,
		'public'				=> true,
		'publicly_queryable'	=> false,
		'exclude_from_search'	=> true,
		'show_ui'				=> true,
		'query_var'				=> true,
		'rewrite'				=> true,
		
		/** 27/05/2013 Editing out:
		'capability_type'		=> 'post',
		*/
		
		/** 27/05/2013 Adding in: */
		'capabilities' => array(
			'publish_posts' => 'manage_options',
			'edit_posts' => 'manage_options',
			'edit_others_posts' => 'manage_options',
			'delete_posts' => 'manage_options',
			'delete_others_posts' => 'manage_options',
			'read_private_posts' => 'manage_options',
			'edit_post' => 'manage_options',
			'delete_post' => 'manage_options',
			'read_post' => 'manage_options',
		),
		/** done editing */
		
		'hierarchical'			=> false,
		'menu_position'			=> null,
		'supports'				=> array( 'title','editor' )
	); 
	register_post_type( 'cookielawinfo' , $args );
}


/**
 Add custom meta boxes to Cookie Audit custom post type.
 	- Cookie Type (e.g. session, permanent)
 	- Cookie Duration (e.g. 2 hours, days, years, etc)
 */
function cookielawinfo_custom_posts_admin_init() {
	add_meta_box("_cli_cookie_type", "Cookie Type", "cookielawinfo_cookie_type", "cookielawinfo", "side", "default");
	add_meta_box("_cli_cookie_duration", "Cookie Duration", "cookielawinfo_cookie_duration", "cookielawinfo", "side", "default");
}


/** Display the custom meta box for cookie_type */
function cookielawinfo_cookie_type() {
	global $post;
	$custom = get_post_custom( $post->ID );
	$cookie_type = ( isset ( $custom["_cli_cookie_type"][0] ) ) ? $custom["_cli_cookie_type"][0] : '';
	?>
	<label>Cookie Type:</label>
	<input name="_cli_cookie_type" value="<?php echo sanitize_text_field( $cookie_type ); ?>" style="width:95%;" />
	<?php
}


/** Display the custom meta box for cookie_duration */
function cookielawinfo_cookie_duration() {
	global $post;
	$custom = get_post_custom( $post->ID );
	$cookie_duration = ( isset ( $custom["_cli_cookie_duration"][0] ) ) ? $custom["_cli_cookie_duration"][0] : '';
	?>
	<label>Cookie Duration:</label>
	<input name="_cli_cookie_duration" value="<?php echo sanitize_text_field( $cookie_duration ); ?>" style="width:95%;" />
	<?php
}


/** Saves all form data from custom post meta boxes, including saitisation of input */
function cookielawinfo_save_custom_metaboxes() {
	global $post;
	
	if ( isset ( $_POST["_cli_cookie_type"] ) ) {
		update_post_meta( $post->ID, "_cli_cookie_type", sanitize_text_field( $_POST["_cli_cookie_type"] ) );
    }
    if ( isset ( $_POST["_cli_cookie_type"] ) ) {
		update_post_meta( $post->ID, "_cli_cookie_duration", sanitize_text_field( $_POST["_cli_cookie_duration"] ) );
	}
}


/** Apply column names to the custom post type table */
function cookielawinfo_edit_columns( $columns ) {
	$columns = array(
		"cb" 			=> "<input type=\"checkbox\" />",
		"title"			=> "Cookie Name",
		"type"			=> "Type",
		"duration"		=> "Duration",
		"description"	=> "Description"
	);
	return $columns;
}


/** Add column data to custom post type table columns */
function cookielawinfo_custom_columns( $column ) {
	global $post;
	
	switch ( $column ) {
	case "description":
		the_excerpt();
		break;
	case "type":
		$custom = get_post_custom();
		if ( isset ( $custom["_cli_cookie_type"][0] ) ) {
			echo $custom["_cli_cookie_type"][0];
		}
		break;
	case "duration":
		$custom = get_post_custom();
		if ( isset ( $custom["_cli_cookie_duration"][0] ) ) {
			echo $custom["_cli_cookie_duration"][0];
		}
		break;
	}
}

?>