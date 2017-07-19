<?php
/**
 * The template for displaying BuddyPress content.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
get_header();

/**
 * Nodes Class as Per Requirements
 **/
$class = array();
if(bp_is_user()) { //profile network
	$class[] = "network-profile";
}
if(bp_displayed_user_id() == get_current_user_id()) { //profile personal
	$class[] = "my-profile";
}
if(bp_is_group()) { //single group
	$class[] = "group-single";
}

$class = implode(" ",$class);

?>

<?php
if(bp_is_group() && !bp_is_current_action( 'create' )) {
    if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); 
    $group_status = groups_get_groupmeta( bp_get_group_id(), 'bp_course_attached', true );
    endwhile; endif;
    // Boxed layout cover
    if ( boss_get_option( 'boss_layout_style' ) == 'boxed' && boss_get_option('boss_cover_group') ) {
        $id = bp_get_current_group_id();
        if(empty($group_status)) {
            echo buddyboss_cover_photo( "group",  $id );
        }
    } else {
        if(empty($group_status)) {
            echo '<div class="bb-cover-photo no-photo"></div>';
        }
    }
    do_action('boss_get_group_template');
    //get_template_part( 'buddypress', 'group-single' );
} else {
    if(is_post_type_archive('bp_doc') || (is_single() && get_post_type() == 'bp_doc')){
        $id = boss_get_docs_group_id();
        if ( boss_get_option('boss_cover_group') ) {
            echo buddyboss_cover_photo( "group",  $id );
        }
    }
    get_template_part( 'buddypress', 'sidewide' );
}
?>

<?php get_footer(); ?>
