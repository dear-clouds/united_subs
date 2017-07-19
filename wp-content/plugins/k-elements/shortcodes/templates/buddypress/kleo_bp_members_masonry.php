<?php
/**
 * Buddypress Members masonry
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */
 

$output = '';

extract(
	shortcode_atts( array(
		'type' => 'newest',
		'member_type' => 'all',
		'number' => 12,
		'class' => '',
		'rounded' => "rounded",
		'online' => 'show'
	), $atts ) 
);

$params = array(
	'type' => $type,
	'scope' => $member_type,
	'per_page' => $number
);
if ($rounded == 'rounded') {
	$rounded = 'rounded';
}
if ( function_exists('bp_is_active') ) {
	if ( bp_has_members( $params ) ){
		ob_start();
		echo '<div class="wpb_wrapper">';
		echo '<div id="members-dir-list" class="members dir-list">';
		echo '<ul id="members-list" class="item-list row kleo-isotope masonry '.$class.'">';
		
		while( bp_members() ) : bp_the_member();

		
			echo 	'<li class="kleo-masonry-item">'
					.'<div class="member-inner-list animated animate-when-almost-visible bottom-to-top">'
					 .'<div class="item-avatar '.$rounded.'">'
							.'<a href="'. bp_get_member_permalink().'">'. bp_get_member_avatar() . kleo_get_img_overlay() . '</a>';
							if ($online == 'show') {
								echo kleo_get_online_status(bp_get_member_user_id());
							}
						echo '</div>'

					.'<div class="item">
							<div class="item-title">'
								.'<a href="'. bp_get_member_permalink().'">'. bp_get_member_name() . '</a>
							</div>
					<div class="item-meta"><span class="activity">'.bp_get_member_last_active().'</span></div>';

					if ( bp_get_member_latest_update() ) {
						echo '<span class="update"> '. bp_get_member_latest_update().'</span>';
					}

					do_action( 'bp_directory_members_item' );

					echo '</div>';

					echo '<div class="action">';
						do_action( 'bp_directory_members_actions' );
					echo  '</div>';

					echo '</div><!--end member-inner-list-->
				</li>';
		endwhile;
		
		echo '</ul>';
		echo '</div>';
		echo '</div>';
		$output = ob_get_clean();
	}

}
else
{
	$output = __("This shortcode must have Buddypress installed to work.","k-elements");
} 
