<?php
/*
 * Functions used by K-elements only
 */


function find_shortcode_template($shortcode) {
	if (file_exists(trailingslashit( get_stylesheet_directory() ) . 'k_elements/' . $shortcode . '.php')) {
		return trailingslashit( get_stylesheet_directory() ) . 'k_elements/' . $shortcode . '.php';
	}
	elseif ( file_exists( trailingslashit( get_template_directory() ) . 'k_elements/' . $shortcode . '.php' ) ) {
		return trailingslashit( get_template_directory() ) . 'k_elements/' . $shortcode . '.php';
	} else {
		return trailingslashit( K_ELEM_PLUGIN_DIR ) . 'shortcodes/templates/' . $shortcode . '.php';
	}
}

function kleo_shortcode_not_found() {
	return "!! Shortcode template not found !!";
}


/* Buddypress */
if (!function_exists('kleo_bp_member_stats')):
	function kleo_bp_member_stats($field=false,$value=false, $online=false)
	{
		global $wpdb;

		if (!$field || !$value) {
			return;
		}

		$where = " WHERE name = '".$field."' AND value = '".esc_sql($value)."'";
		$sql = "SELECT ".$wpdb->base_prefix."bp_xprofile_data.user_id FROM ".$wpdb->base_prefix."bp_xprofile_data
				JOIN ".$wpdb->base_prefix."bp_xprofile_fields ON ".$wpdb->base_prefix."bp_xprofile_data.field_id = ".$wpdb->base_prefix."bp_xprofile_fields.id
				$where";

		$match_ids = $wpdb->get_col($sql);
		if ( !$online ) {
			return count($match_ids);
		}

		if ( !$match_ids ) {
			$match_ids = array(0);
		}

		if( !empty($match_ids) )
		{
			$include_members = '&include='.join(",",$match_ids);
		}
		else
		{
			$include_members = '';
		}

		$i = 0;
		if ( bp_has_members( 'user_id=0&type=online&per_page=999999999&populate_extras=0'.$include_members ) ) :
			while ( bp_members() ) : bp_the_member();
				$i++;
			endwhile;
		endif;

		return apply_filters('kleo_bp_member_stats',$i, $value);
	}
endif;



if (!function_exists('get_profile_id_by_name')) :
	/**
	 * Return profile field ID by profile name
	 * @global object $wpdb
	 * @param string $name
	 * @return integer
	 */
	function get_profile_id_by_name($name)
	{
		global $wpdb;
		if (!isset($name))
				return false;

		$sql = "SELECT id FROM ".$wpdb->base_prefix."bp_xprofile_fields WHERE name = '".$name."'";
		return $wpdb->get_var($sql);
	}
endif;


if( ! function_exists('get_group_id_by_name') ) :
	function get_group_id_by_name($name)
	{
		global $wpdb;
		if (!isset($name))
				return false;

		$sql = "SELECT id FROM ".$wpdb->base_prefix."bp_xprofile_groups WHERE name = '".$name."'";
		return $wpdb->get_var($sql);
	}
endif;




/**
 * @param $content
 * @param bool $autop
 *
 * @since 4.2
 * @return string
 */
function kleo_remove_wpautop( $content, $autop = false ) {

    if ( $autop ) {
        $content = preg_replace( '/<\/?p\>/', "", $content );
    }

    return do_shortcode( shortcode_unautop( $content ) );
}