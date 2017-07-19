<?php
/**
 * Created by PhpStorm.
 * User: lusinda
 * Date: 8/27/15
 * Time: 7:05 PM
 */
if ( ! defined( 'ABSPATH' ) ) exit;



function ecwd_admin_notices( $notices ) {

	$two_week_review_ignore = add_query_arg( array( 'ecwd_admin_notice_ignore' => 'two_week_review' ) );
	$two_week_review_temp = add_query_arg( array( 'ecwd_admin_notice_temp_ignore' => 'two_week_review', 'int' => 14 ) );
	$one_week_support = add_query_arg( array( 'ecwd_admin_notice_ignore' => 'one_week_support' ) );
	$promo_close = add_query_arg( array( 'ecwd_admin_notice_ignore' => 'ecwd_new_year_promo' ) );
	$notices['ecwd_new_year_promo'] = array(
		'title' => __( 'Hey! How\'s It Going?', 'ecwd' ),
		'msg' => '<div class="ecwd_hny"><a href="https://web-dorado.com/products/wordpress-event-calendar-wd.html?source=promo" target="_blank"></a></div>',
		'link' => '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $promo_close . '">' . __( 'Never show again' ,'ecwd' ) . '</a></li>',
		'start' => '2015-12-31',
		'end' => '2016-01-01',
		'int' => 0
	);

	$notices['two_week_review'] = array(
		'title' => __( 'Leave A Review?', 'ecwd' ),
		'msg' => __( 'We hope you\'ve enjoyed using Event Calendar WD! Would you consider leaving us a review on WordPress.org?', 'ecwd' ),
		'link' => '<li><span class="dashicons dashicons-external"></span><a href="http://wordpress.org/support/view/plugin-reviews/event-calendar-wd?filter=5" target="_blank">' . __( 'Sure! I\'d love to!', 'ecwd' ) . '</a></li>
					<li> <span class="dashicons dashicons-smiley"></span><a href="' . $two_week_review_ignore . '"> ' . __( 'I\'ve already left a review', 'ecwd' ) . '</a></li>
                    <li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $two_week_review_temp . '">' . __( 'Maybe Later' ,'ecwd' ) . '</a></li>
                     <li><span class="dashicons dashicons-dismiss"></span><a href="' . $two_week_review_ignore . '">' . __( 'Never show again' ,'ecwd' ) . '</a></li>',

		'later_link'=>$two_week_review_temp,
		'int' => 14
	);


	$notices['one_week_support'] = array(
		'title' => __( 'Hey! How\'s It Going?', 'ecwd' ),
		'msg' => __( 'Thank you for using Events Calendar WD! We hope that you\'ve found everything you need, but if you have any questions:', 'ecwd' ),
		'link' => '<li><span class="dashicons dashicons-media-text"></span><a target="_blank" href="https://web-dorado.com/wordpress-event-calendar-wd/installing.html">' . __( 'Check out User Guide', 'ecwd' ) . '</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a target="_blank" href="https://web-dorado.com/forum/wordpress-event-calendar-wd.html">' . __( 'Get Some Help' ,'ecwd' ) . '</a></li>
                    <li><span class="dashicons dashicons-dismiss"></span><a href="' . $one_week_support . '">' . __( 'Never show again' ,'ecwd' ) . '</a></li>',
		'int' => 7
	);



	return $notices;
}

add_filter( 'ecwd_admin_notices', 'ecwd_admin_notices' );

