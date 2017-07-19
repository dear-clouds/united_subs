<?php
/**
 * Boss user options/settings
 *
 * @package Boss
 */
/**
 * This is the file that contains all settings custom fields & options functions for users/members
 */

/**
 * Return the array of all social fields supported.
 * @since Boss 1.0.0
 * @return array list of social sites.
 * */
function buddyboss_get_user_social_array() {

	$social_profiles = boss_get_option( 'profile_social_media_links' );

	$socials = array();

    if ( ! is_array( $social_profiles ) || empty( $social_profiles ) )
        return apply_filters( 'buddyboss_get_user_social_array', $socials );

	foreach ( $social_profiles as $key => $label ) {

        //Boss v2.1.1
		if ( ! empty( $label['title'] ) ) {
			$key             = sanitize_title( $label['title'] );
			$socials[ $key ] = $label['title'];
		}
        //Boss v2.1.0
//		} else {
//            $socials[ $key ] = ucwords( $key );
//        }
	}

	return (array) @apply_filters( "buddyboss_get_user_social_array", $socials );
}

/*
 * Remove disabled from socials.
 *
 * */

function buddyboss_user_social_remove_disabled( $socials ) {

	$social_profiles = boss_get_option( 'profile_social_media_links' );

	if ( ! empty( $social_profiles ) ) {

		foreach ( $social_profiles as $key => $value ) {

			if ( $value == '0' ) {
				unset( $socials[ $key ] ); // unset fields from $socials array.
			}
		}
	}

	if ( !boss_get_option( 'profile_social_media_links_switch' ) ) {
		unset( $socials );
	}

	return $socials;
}

/**
 * Check if array has any non-empty value
 * @since 1.0
 * */
function buddyboss_array_not_all_empty( $array ) {
	foreach ( $array as $value ) {
		if ( !empty( $value ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Output the fields inputs on user screen
 * @since 1.0
 * */
function buddyboss_user_social_fields( $user_id = false ) {
	if ( !$user_id )
		$user_id = bp_displayed_user_id();

	/* field will only shown on base.
	 * so if in case we are on somewhere else then skip it !
	 *
	 * It's safe enough to assume that 'base' profile group will always be there and its id will be 1,
	 * since there's no apparent way of deleting this field group.
	 */
	if ( !function_exists( 'bp_get_the_profile_group_id' ) || (function_exists( 'bp_get_the_profile_group_id' ) && bp_get_the_profile_group_id() != 1 ) ) {
		return;
	}

	$socials = (array) get_user_meta( $user_id, "user_social_links", true );

	add_filter( "buddyboss_get_user_social_array", "buddyboss_user_social_remove_disabled" ); //remove disabled.

	if ( 'edit' == bp_current_action() ) {
		?>
		<div class="buddyboss-user-social">

			<input type="hidden" name="buddyboss_user_social" value="1">

			<?php foreach ( buddyboss_get_user_social_array() as $social => $name ):
				?>

				<div class="bp-profile-field editfield field_type_textbox field_<?php echo $social; ?>">
					<label for="buddyboss_<?php echo $social; ?>"><?php echo $name; ?></label>
					<input id="buddyboss_<?php echo $social; ?>" name="buddyboss_<?php echo $social; ?>" type="text" value="<?php echo esc_attr( @$socials[ $social ] ); ?>" />
				</div>

			<?php endforeach; ?>
		</div>
		<?php
	} else {
		$val = buddyboss_get_user_social_array();
		if ( buddyboss_array_not_all_empty( $socials ) AND ! empty( $val ) ) {
			?>
			<div class="bp-widget social">
				<h4><?php _e( 'Social', 'boss' ); ?></h4>
				<table class="profile-fields">
					<tbody>

						<?php foreach ( buddyboss_get_user_social_array() as $social => $name ): ?>

							<?php
							$field_value = @$socials[ $social ];
							if ( empty( $field_value ) )
								continue;

							$field_value = make_clickable( $field_value );
							?>
							<tr class="field_type_textbox field_<?php echo $social; ?>">
								<td class="label"><?php echo $name; ?></td>
								<td class="data"><?php echo $field_value; ?></td>
							</tr>

						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
}

//add_action("bp_custom_profile_edit_fields","buddyboss_user_social_fields");
add_action( "bp_after_profile_field_content", "buddyboss_user_social_fields" );

/**
 * Output the fields inputs on user screen
 * @since Boss 1.0.0
 * */
function buddyboss_user_social_fields_admin( $user_id = 0, $screen_id = '', $stats_metabox = null ) {
	// Set the screen ID if none was passed
	if ( empty( $screen_id ) ) {
		$screen_id = buddypress()->members->admin->user_page;
	}

	add_meta_box(
	'bp_xprofile_user_admin_fields_social', __( 'Social', 'boss' ), 'buddyboss_user_social_fields_metabox', $screen_id, 'normal', 'core', array( 'user_id' => $user_id )
	);
}

// Register the metabox in Member's community admin profile
//add_action( 'bp_members_admin_xprofile_metabox', 'buddyboss_user_social_fields_admin', 11, 3 );
add_action( 'bp_members_admin_xprofile_metabox', 'buddyboss_user_social_fields_admin', 11 );

function buddyboss_user_social_fields_metabox( $user, $param ) {
	$user_id = isset( $param[ 'args' ] ) && isset( $param[ 'args' ][ 'user_id' ] ) ? $param[ 'args' ][ 'user_id' ] : false;
	buddyboss_user_social_fields( $user_id );
}

/**
 * Save the user social fields data
 * @since Boss 1.0.0
 * */
function buddyboss_user_social_fields_save( $user_id, $posted_field_ids, $errors ) {

	if ( empty( $user_id ) ) { // no user ah! skip it then.
		return;
	}

	$socials = get_user_meta( $user_id, "user_social_links", true );

	if ( !is_array( $socials ) ) {
		$socials = array();
	}

	if ( isset( $_POST[ "buddyboss_user_social" ] ) && $_POST[ "buddyboss_user_social" ] == "1" ) {

		foreach ( buddyboss_get_user_social_array() as $social => $name ) {

//			//check if its enable by admin
//			if ( get_option( "boss_show_profile_link_" . $social, "1" ) != "1" ) {
//				continue;
//			}

			$url = $_POST[ "buddyboss_" . $social ];

			//check if its valid URL
			if ( filter_var( $url, FILTER_VALIDATE_URL ) || empty( $url ) ) {
				$socials[ $social ] = $url;
				update_user_meta( $user_id, $social, $url ); //update it
			}
		}

		update_user_meta( $user_id, "user_social_links", $socials ); //update it
	}
}

add_action( "xprofile_updated_profile", "buddyboss_user_social_fields_save", 1, 3 );

/**
 * Return the user social data
 * @since 1.0
 * @param (int) $user_id
 * @param (int) $social  //social site slug
 * return (string) //URL format.
 * */
function buddyboss_get_user_social( $user_id, $social ) {
	$socials = (array) get_user_meta( $user_id, "user_social_links", true );
	return (@$socials[ $social ]);
}
