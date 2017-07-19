<?php
/**
 * Pricing table item
 * [kleo_pricing_table_item title="Package 1" price="$10" popular="yes|no" features="Feature one, Feature 2", button_label="Select" link="url:http://mysite.com|target:_blank"]Description[/kleo_pricing_table_item]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = $icon = $icon_size = $icon_position = $class = '';
extract( shortcode_atts( array(
    'title' => '',
    'price' => '',
    'popular' => '',
    'features' => '',
    'button_label' => 'Select',
    'link' => '',
    'class' => ''
), $atts ) );

$base_classes = 'panel text-center panel-info';

$class = ( $class != '' ) ? $base_classes . ' ' . esc_attr( $class ) : $base_classes;

if ( $popular != '' ) {
    $class .= ' popular';
}

//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = kleo_parse_multi_attribute( $link, array( 'url' => '', 'title' => '', 'target' => '' ) );

$a_href = '#';
$a_title = '';
$a_target = '_self';
if ( strlen( $link['url'] ) > 0 ) {
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}


$output .= '<div class="' . $class . '">';

$output .= '<div class="panel-heading"><h3>' . $title . '</h3></div>';
$output .= '<div class="panel-body">' .
                '<div class="pmpro-price">' .
                    '<p class="lead">' . $price . '</p>' .
                '</div>' .
            '</div>';

if ( $content != '' ) {
    $output .= '<div class="extra-description">' . do_shortcode( $content ) . '</div>';
}

//Features list section
$all_features = explode( ',', $features );

if ( ! empty( $all_features ) && $all_features[0] != '' ) {

    $output .= '<ul class="list-group list-group-flush">';

    foreach ($all_features as $feature) {
        $output .= '<li class="list-group-item " > ' . $feature . ' </li >';
    }

    $output .= '</ul>';
}

//footer & button section
if ( $button_label != '' ) {
    $output .= '<div class="panel-footer">' .
        '<a href="' . esc_url( $a_href ) .'" ' .
        'class="btn btn-default" ' .
        'target="' . trim( esc_attr( $a_target ) ) . '" ' .
        'title="' . trim( esc_attr( $a_title ) ) . '">' .
        $button_label .
        '</a>' .
    '</div>';
}

$output .= '</div>';

