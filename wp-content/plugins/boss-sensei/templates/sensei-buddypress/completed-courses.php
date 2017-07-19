<?php
/**
 * @package WordPress
 * @subpackage BuddyPress for Sensei
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


global $woothemes_sensei, $post, $current_user, $wp_query, $boss_sensei;
$courses_html = $boss_sensei->boss_edu_sensei_get_completed_courses_html();

do_action( 'sensei_frontend_messages' );
do_action( 'sensei_before_user_course_content', $current_user );
do_action( 'sensei_before_user_courses' );
?>

<div id="my-courses">

    <?php do_action( 'sensei_before_completed_user_courses' ); ?>

    <div id="completed-courses">

        <?php if ( '' != $courses_html['complete_html'] ) {
            echo $courses_html['complete_html'];
        } else { ?>
            <div id="message" class="info"><p><?php echo $courses_html['no_complete_message']; ?></p></div>
        <?php } // End If Statement ?>

    </div>

    <?php do_action( 'sensei_after_completed_user_courses' ); ?>

</div>

<?php
do_action( 'sensei_after_user_courses' );
do_action( 'sensei_after_user_course_content', $current_user );
