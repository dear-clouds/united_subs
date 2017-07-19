<?php
/**
 * BuddyPress - User Header
 *
 * @package Boss
 */
?>

<?php do_action( 'bp_before_member_header' ); ?>

<?php
//output cover photo.
if(boss_get_option('boss_cover_profile')) {
    if ( boss_get_option( 'boss_layout_style' ) != 'boxed' ) { // show here for fluid if not Events Manager page or if it is My Profile of Events
        echo buddyboss_cover_photo( "user", bp_displayed_user_id() );
    }
} else {
	echo '<div class="bb-cover-photo no-photo"></div>';
}
?>

<div id="item-header-cover" class="table">

    <div class="table-cell">

        <div class="table cover-content">

            <div class="table-cell">
                <div id="item-header-avatar">

                    <?php if(bp_displayed_user_id()==bp_loggedin_user_id()){ ?>
                    <a href="<?php bp_displayed_user_link(); bp_profile_slug(); ?>/change-avatar/">
                    <?php } else { ?>
                    <a href="<?php bp_displayed_user_link(); ?>">
                    <?php } ?>
                    <?php bp_displayed_user_avatar( 'type=full' ); ?>
                    </a>

                </div><!-- #item-header-avatar -->

                <div id="item-header-content">
                    <div class="basic">
                        <h1><?php echo bp_get_displayed_user_fullname(); ?></h1><span class="sep"><?php _e( ', ', 'boss' ); ?></span>
                        <h2 class="user-nicename">@<?php bp_displayed_user_username(); ?></h2>
						<?php
						$show			 = boss_get_option( 'boss_cover_profile' );
						$address_field	 = boss_get_option( 'boss_misc_profile_field_address' );
						if ( $show && $address_field ) {
							$address = bp_get_profile_field_data( array( 'field' => $address_field ) );
							if ( $address ) {
								if ( is_array( $address ) ) {
									?>
									<span class="location"><?php echo join( ', ', $address ); ?></span>
									<?php
								} else {
									?>
									<span class="location"><?php echo stripslashes( $address ); ?></span>
									<?php
								}
							}
						}
						?>
                    </div>
                    <!-- Socials -->
                    <div class="btn-group social">

						<?php
						add_filter( "buddyboss_get_user_social_array", "buddyboss_user_social_remove_disabled" ); //remove disabled.

						//Allow users to display their social media links in their profiles.
						$profile_social_media_links_switch = boss_get_option( 'profile_social_media_links_switch' );
						if ( ! empty( $profile_social_media_links_switch ) ):
						$social_profiles = (array)boss_get_option( 'profile_social_media_links' );

						foreach ( $social_profiles as $key => $social  ):

                             //Boss v2.1.1
                            if ( isset( $social['title'] ) ) {
                                $social_key = sanitize_title( $social['title'] );
                                $social_title = $social['title'];

                                //Boss v2.1.0
                            } else {
                                $social_key = sanitize_title( $key );
                                $social_title = ucwords( $key );
                            }

                            $background_image_style = '';

                            if ( ! empty( $social['thumb'] ) ) {
                                $icon_url = $social['thumb'];
                            } else {
                                //Show default supported social site icon
                                $icon_path = TEMPLATEPATH."/images/social-icon-white/{$social_key}-white.png";
                                $icon_url = '';
                                if ( file_exists( $icon_path ) ) {
                                    $icon_url = get_template_directory_uri()."/images/social-icon-white/{$social_key}-white.png";
                                }
                            }

							$url  = buddyboss_get_user_social( bp_displayed_user_id(), $social_key ); //Get user social link

							//Set profile icon
                            $background_image_style = "background-image: url($icon_url);  background-size: cover;";

							?>
							<?php if ( !empty( $url ) ): ?>
								<a class="btn" href="<?php echo $url; ?>" title="<?php echo esc_attr( $social_title ); ?>" target="_blank"><i style="<?php echo $background_image_style ?>" class="alt-social-icon alt-<?php echo empty( $background_image_style ) ? $social_key : ''; ?>"></i> </a>
							<?php endif; ?>

						<?php endforeach;
						endif;
						?>

                    </div>

					<?php do_action( 'bp_before_member_header_meta' ); ?>

                </div><!-- #item-header-content -->
            </div>

            <div class="table-cell">

				<?php
				$showing = null;
//if bp-followers activated then show it.
				if ( function_exists( "bp_follow_add_follow_button" ) ) {
					$showing	 = "follows";
					$followers	 = bp_follow_total_follow_counts( array( "user_id" => bp_displayed_user_id() ) );
				} elseif ( function_exists( "bp_add_friend_button" ) ) {
					$showing = "friends";
				} elseif ( function_exists( "bp_send_private_message_button" ) ) {
					$showing = "private_message";
				}
				?>

                <div id="item-statistics">
                    <div class="numbers">

	                    <?php  if(!empty($GLOBALS['badgeos'])): ?>
		                    <span>
                                <p><?php $points = badgeos_get_users_points(bp_displayed_user_id()); echo number_format($points); ?></p>
                                <p><?php printf( _n( 'Point', 'Points', $points, 'boss' ) ); ?></p>
                            </span>
	                    <?php  endif; ?>

						<?php if ( $showing == "follows" ): ?>
							<span>
								<p><?php echo (int) $followers[ "following" ]; ?></p>
								<p><?php _e( "Following", "boss" ); ?></p>
							</span>
							<span>
								<p><?php echo (int) $followers[ "followers" ]; ?></p>
								<p><?php _e( "Followers", "boss" ); ?></p>
							</span>
						<?php endif; ?>

						<?php if ( $showing == "friends" ): ?>
							<span>
								<p><?php echo (int) friends_get_total_friend_count(); ?></p>
								<p><?php _e( "Friends", "boss" ); ?></p>
							</span>
						<?php endif; ?>

                    </div>

                    <div id="item-buttons" class="profile">

						<?php
						if ( $showing == "follows" ) {
							remove_action( 'bp_member_header_actions', 'bp_follow_add_profile_follow_button' );
						} elseif ( $showing == "friends" ) {
							if ( 'not_friends' == bp_is_friend( bp_displayed_user_id() ) ) {
								remove_action( 'bp_member_header_actions', 'bp_add_friend_button', 5 );
							} elseif ( bp_is_active( 'messages' ) ) {
								remove_action( 'bp_member_header_actions', 'bp_send_private_message_button', 20 );
							} else {
								remove_action( 'bp_member_header_actions', 'bp_send_public_message_button', 20 );
							}
						} elseif ( $showing == "private_message" ) {
							if ( bp_is_active( 'messages' ) ) {
								remove_action( 'bp_member_header_actions', 'bp_send_private_message_button', 20 );
							} else {
								remove_action( 'bp_member_header_actions', 'bp_send_public_message_button', 20 );
							}
						} else {
							remove_action( 'bp_member_header_actions', 'bp_send_public_message_button', 20 );
						}
						?>

						<?php
						ob_start();
						do_action( 'bp_member_header_actions' );
						$action_output = ob_get_contents();
						ob_end_clean();
						?>

                        <div id="main-button" class="<?php
						if ( !empty( $action_output ) ) {
							echo 'primary-btn';
						}
						?>">
								 <?php
								 if ( $showing == "follows" ) {
									 bp_follow_add_follow_button();
								 } elseif ( $showing == "friends" ) {
									 if ( 'not_friends' == bp_is_friend( bp_displayed_user_id() ) ) {
										 bp_add_friend_button();
									 } elseif ( bp_is_active( 'messages' ) ) {
										 bp_send_private_message_button();
									 }
                                                                         
								 } elseif ( $showing == "private_message" ) {
									 if ( bp_is_active( 'messages' ) ) {
										 bp_send_private_message_button();
                                                                         }
								 }
								 ?>
                        </div>

						<?php
						if ( !empty( $action_output ) ): //only show if output exists
							?>

							<!-- more items -->
							<span class="single-member-more-actions">
								<button class="more-items-btn btn"><i class="fa fa-ellipsis-h"></i></button>

								<!--popup-->
								<div class="pop">
									<div class="inner">
										<?php echo $action_output; ?>
									</div>
								</div>
							</span>

						<?php endif; ?>

                    </div><!-- #item-buttons -->

                </div><!-- #item-statistics -->

            </div>

        </div>

    </div>
	<?php
    if ( function_exists( 'boss_profile_achievements' ) ):
        boss_profile_achievements();
    endif;
    ?>

</div><!-- #item-header-cover -->

<?php
/* * *
 * If you'd like to show specific profile fields here use:
 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
 */
do_action( 'bp_profile_header_meta' );
?>

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>
