<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function sc_admin_notices( $notices ) {
	$two_week_review_ignore = add_query_arg( array( 'sc_admin_notice_ignore' => 'two_week_review' ) );
	$two_week_review_temp = add_query_arg( array( 'sc_admin_notice_temp_ignore' => 'two_week_review', 'int' => 14 ) );
	$notices['two_week_review'] = array(
		'title' => __( 'Leave A Review?', 'sc_admin_notice' ),
		'msg' => __( 'We hope you\'ve enjoyed using WordPress Spider Calendar! Would you consider leaving us a review on WordPress.org?', 'sc_admin_notice' ),
		'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://wordpress.org/support/view/plugin-reviews/spider-event-calendar" target="_blank">' . __( 'Sure! I\'d love to!', 'sc_admin_notice' ) . '</a></li>
					<li> <span class="dashicons dashicons-smiley"></span><a href="' . $two_week_review_ignore . '"> ' . __( 'I\'ve already left a review', 'sc_admin_notice' ) . '</a></li>
                    <li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $two_week_review_temp . '">' . __( 'Maybe Later' ,'sc_admin_notice' ) . '</a></li>
                     <li><span class="dashicons dashicons-dismiss"></span><a href="' . $two_week_review_ignore . '">' . __( 'Never show again' ,'sc_admin_notice' ) . '</a></li>',
		'later_link' => $two_week_review_temp,
		'int' => 14
	);
	
	$one_week_support = add_query_arg( array( 'sc_admin_notice_ignore' => 'one_week_support' ) );
	$notices['one_week_support'] = array(
		'title' => __( 'Hey! How\'s It Going?', 'spider-event-calendar' ),
		'msg' => __( 'Thank you for using WordPress Spider Calendar! We hope that you\'ve found everything you need, but if you have any questions:', 'spider-event-calendar' ),
		'link' => '<li><span class="dashicons dashicons-media-text"></span><a target="_blank" href="https://web-dorado.com/wordpress-spider-calendar/installing.html">' . __( 'Check out User Guide', 'spider-event-calendar' ) . '</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a target="_blank" href="https://web-dorado.com/forum/spider-calendar-wordpress.html">' . __( 'Get Some Help' ,'spider-event-calendar' ) . '</a></li>
                    <li><span class="dashicons dashicons-dismiss"></span><a href="' . $one_week_support . '">' . __( 'Never show again' ,'spider-event-calendar' ) . '</a></li>',
		'int' => 7
	);

	return $notices;
}

add_filter( 'sc_admin_notices', 'sc_admin_notices' );

