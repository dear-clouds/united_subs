<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */


$title_arr = array();

$title_arr['title'] = kleo_title();

if ( is_singular() && get_cfield( 'custom_title' ) && get_cfield( 'custom_title' ) != ''  ) {
    $title_arr['title'] = get_cfield( 'custom_title' );
}

//hide title?
$title_arr['show_title'] = true;
if( is_singular() && get_cfield( 'title_checkbox' ) == 1 ) {
	$title_arr['show_title'] = false;
}
//If we are displaying the title in the main area, not the breadcrumb area
if ( sq_option( 'title_location', 'breadcrumb' ) == 'main' ) {
	$title_arr['show_title'] = false;
}

//hide breadcrumb?
$title_arr['show_breadcrumb'] = true;
if( sq_option( 'breadcrumb_status', 1 ) == 0 ) {
	$title_arr['show_breadcrumb'] = false;
}
if ( is_singular() ) {
    if (get_cfield('hide_breadcrumb') == 1) {
        $title_arr['show_breadcrumb'] = false;
    } else if (get_cfield('hide_breadcrumb') === '0') {
        $title_arr['show_breadcrumb'] = true;
    }
}
//extra info
if ( ( is_singular() && get_cfield( 'hide_info' ) == 1 ) || sq_option( 'title_info', '' ) == '' ) {
    $title_arr['extra'] = '';
}
 
if ( ( isset( $title_arr['show_breadcrumb'] ) && $title_arr['show_breadcrumb'] ) || ! isset( $title_arr['extra'] ) || $title_arr['show_title'] ) {
	echo kleo_title_section( $title_arr );
}