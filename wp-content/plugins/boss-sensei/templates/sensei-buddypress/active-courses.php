<?php
/**
 * @package WordPress
 * @subpackage BuddyPress for Sensei
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


global $woothemes_sensei, $post, $current_user, $wp_query, $boss_sensei;
if ( is_user_logged_in() ) {
    // Handle completion of a course
    do_action( 'sensei_complete_course' );
}

$courses_html = $boss_sensei->boss_edu_sensei_get_active_courses_html();

do_action( 'sensei_frontend_messages' );
do_action( 'sensei_before_user_course_content', $current_user );
do_action( 'sensei_before_user_courses' );
?>

<div id="my-courses">

    <?php do_action( 'sensei_before_active_user_courses' ); ?>

    <?php $course_page_id = intval( $woothemes_sensei->settings->settings[ 'course_page' ] );
    if ( 0 < $course_page_id ) {
        $course_page_url = get_permalink( $course_page_id );
    } elseif ( 0 == $course_page_id ) {
        $course_page_url = get_post_type_archive_link( 'course' );
    } ?>

    <div id="active-courses">

        <?php if ( '' != $courses_html['active_html'] ) {
            echo $courses_html['active_html'];
        } else { ?>
            <div id="message" class="info"><p><?php echo $courses_html['no_active_message']; ?> <a href="<?php echo $course_page_url; ?>"><?php apply_filters( 'sensei_start_a_course_text', _e( 'Take a Course!', 'boss-sensei' ) ); ?></a></p></div>
        <?php } // End If Statement ?>

    </div>

    <?php do_action( 'sensei_after_active_user_courses' ); ?>

</div>

<?php
do_action( 'sensei_after_user_courses' );
do_action( 'sensei_after_user_course_content', $current_user );
