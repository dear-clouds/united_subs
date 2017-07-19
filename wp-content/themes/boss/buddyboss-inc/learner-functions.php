<?php
/**
* Social Leraner specific functions
*/

add_filter( 'boss_default_color_sheme', 'boss_edu_default_color_scheme' );

/**
 * Default color sheme
 */
if ( ! function_exists('boss_edu_default_color_scheme') ) {
    function boss_edu_default_color_scheme( $default ) {
        return 'education';
    }
}

/**
 * Output badges on profile
 *
 */
if ( ! function_exists('boss_edu_profile_achievements') ) {
    function boss_edu_profile_achievements() {
        global $user_ID;

        //user must be logged in to view earned badges and points

        if ( is_user_logged_in() && function_exists( 'badgeos_get_user_achievements' ) ) {

            $achievements = badgeos_get_user_achievements( array( 'user_id' => bp_displayed_user_id() ) );

            if ( is_array( $achievements ) && !empty( $achievements ) ) {

                $number_to_show = 5;
                $thecount = 0;

                wp_enqueue_script( 'badgeos-achievements' );
                wp_enqueue_style( 'badgeos-widget' );

                //load widget setting for achievement types to display
                $set_achievements = ( isset( $instance['set_achievements'] ) ) ? $instance['set_achievements'] : '';

                //show most recently earned achievement first
                $achievements = array_reverse( $achievements );

                echo '<ul class="profile-achievements-listing">';

                foreach ( $achievements as $achievement ) {

                    //verify achievement type is set to display in the widget settings
                    //if $set_achievements is not an array it means nothing is set so show all achievements
                    if ( !is_array( $set_achievements ) || in_array( $achievement->post_type, $set_achievements ) ) {

                        //exclude step CPT entries from displaying in the widget
                        if ( get_post_type( $achievement->ID ) != 'step' ) {

                            $permalink = get_permalink( $achievement->ID );
                            $title = get_the_title( $achievement->ID );
                            $img = badgeos_get_achievement_post_thumbnail( $achievement->ID, array(
                                50,
                                50
                            ), 'wp-post-image' );
                            $thumb = $img ? '<a style="margin-top: -25px;" class="badgeos-item-thumb" href="' . esc_url( $permalink ) . '">' . $img . '</a>' : '';
                            $class = 'widget-badgeos-item-title';
                            $item_class = $thumb ? ' has-thumb' : '';

                            // Setup credly data if giveable
                            $giveable = credly_is_achievement_giveable( $achievement->ID, $user_ID );
                            $item_class .= $giveable ? ' share-credly addCredly' : '';
                            $credly_ID = $giveable ? 'data-credlyid="' . absint( $achievement->ID ) . '"' : '';

                            echo '<li id="widget-achievements-listing-item-' . absint( $achievement->ID ) . '" ' . $credly_ID . ' class="widget-achievements-listing-item' . esc_attr( $item_class ) . '">';
                            echo $thumb;
                            echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a>';
                            echo '</li>';

                            $thecount ++;

                            if ( $thecount == $number_to_show && $number_to_show != 0 ) {
                                echo '<li id="widget-achievements-listing-item-more" class="widget-achievements-listing-item">';
                                echo '<a class="badgeos-item-thumb" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/"><span class="fa fa-ellipsis-h"></span></a>';
                                echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/">' . __( 'See All', 'boss' ) . '</a>';
                                echo '</li>';
                                break;
                            }
                        }
                    }
                }

                echo '</ul><!-- widget-achievements-listing -->';
            }
        }
    }
}
/**
 * Filter cover sizes
 *
 * */
add_filter( 'boss_profile_cover_sizes', 'boss_edu_profile_cover_sizes' );

if ( ! function_exists( 'boss_edu_profile_cover_sizes') ) {
    function boss_edu_profile_cover_sizes() {
        if ( !empty($GLOBALS[ 'badgeos' ]) ) {
            return array( '322' => 'Big', 'none' => 'No photo' );
        }
        return array( '322' => 'Big', '200' => 'Small', 'none' => 'No photo' );
    }
}

