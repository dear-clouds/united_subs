<?php
/**
 * Buddypress Activity Stream
 *
 *
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */

$show = $filter_action = $post_form = $show_button = $button_label = $button_link = '';

extract( shortcode_atts(
	array(
		'show' => false,
		'filter_action' => '',
		'number' => 6,
		'show_button' => 'yes',
		'button_link' => '/activity',
		'button_label' => 'View All Activity',
		'post_form' => ''
	), $atts
) );



if ( function_exists('bp_is_active') && bp_is_active('activity') ) {

	$output = '';
	$params = array(
		'max' => $number,
		'object' => $show
	);
	if ($filter_action != '') {
		$params['action'] = $filter_action;
	}

	$output .= '<div class="wpb_wrapper">';
		$output .= '<div class="activity kleo-activity-streams">';

	if ( is_user_logged_in() && $post_form == 'yes' ) {
		ob_start();
		bp_get_template_part( 'activity/post-form' );

		$output .= ob_get_clean();
	}

	if ( bp_has_activities( $params ) ) {
		$output .= '<ul id="activity-stream" class="activity-list item-list">';
			while ( bp_activities() ) : bp_the_activity();

				$output .= '<li class="'. bp_get_activity_css_class() .'" id="activity-'. bp_get_activity_id() .'">';
					$output .= '<div class="activity-avatar rounded">';
						$output .= '<a class="kleo-activity-avatar" title="'.__( 'View Profile','kleo_framework' ).'" href="'. bp_get_activity_user_link() .'">';
							$output .=  bp_get_activity_avatar();
						$output .= '</a>';
					$output .= '</div>';
					// activity content
					$output .= '<div class="activity-content">';
						$output .= '<div class="activity-header">';
							$output .= bp_get_activity_action();
						$output .= '</div>';

						$output .= '<div class="activity-inner">';
							if( bp_activity_has_content() ){
								$output .= bp_get_activity_content_body();
							}
						$output .= '</div>';

						$output .= '<div class="activity-meta">';
							if ( bp_get_activity_type() == 'activity_comment' ){
								$output .= '<a href="'.bp_get_activity_thread_permalink(). '" class="view bp-secondary-action" title="'.__( 'View Conversation', 'buddypress' ). '">'.__( 'View Conversation', 'buddypress' ).'</a>';
							}

							if ( is_user_logged_in() ){

								if ( bp_activity_can_favorite() ){
									if ( !bp_get_activity_is_favorite() ){
										$output .= '<a href="'.bp_get_activity_favorite_link().'" class="fav bp-secondary-action" title="'.esc_attr( __('Mark as Favorite', 'buddypress') ).'"></a>';
									}else{
										$output .= '<a href="'.bp_get_activity_unfavorite_link().'" class="unfav bp-secondary-action" title="'.esc_attr( __('Remove Favorite', 'buddypress') ).'"></a>';
									}
								}

								if ( bp_activity_user_can_delete() ){
									$output .= bp_get_activity_delete_link();
								}

							}

                            ob_start();

                            do_action( 'bp_activity_entry_meta' );

                            $output .= ob_get_clean();

						$output .= '</div>';

						if ( bp_get_activity_type() == 'activity_comment' ){
							$output .= '<a href="'. bp_get_activity_thread_permalink() . '" class="view bp-secondary-action" title="'. __( 'View', 'buddypress' ) .'">'. __( 'View', 'buddypress' );
						} // end bp_get_activity_type()

					$output .= '</div>'; // end activity content

				$output .= '</li>';

			endwhile;
		$output .= '</ul>';
	}else{
		$output .= '<div class="alert alert-info">' . __("Right now there is no activity to show", "k-elements") .'</div>'  ;
	}

	if( $show_button =='yes' ){
		$output .= '<a href="'.$button_link.'" title="" class="pull-right btn btn-large btn-primary">'.$button_label.'</a>';
	}

	$output .= '</div>';
	$output .= '</div>';

}
else
{
	$output = __("This shortcode must have Buddypress installed and activity component activated.","k-elements");
}

