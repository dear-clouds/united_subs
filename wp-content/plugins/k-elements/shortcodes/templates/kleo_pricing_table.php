<?php
/**
 * Pricing table Shortcode
 * [kleo_pricing_table columns=3 style=1|2 heading_bg="#689F38" price_bg="#8BC34A" text_color="#ffffff"] add here kleo_pricing_table_item elements [/kleo_pricing_table]
 *
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 3.0
 */


extract( shortcode_atts( array(
    'columns' => '2',
    'style' => '',
    'heading_bg' => '',
    'price_bg' => '',
    'text_color' => '',
    'el_class' => '',
), $atts ) );


$class = ( $el_class != '' ) ? ' row pricing-table ' . esc_attr( $el_class ) : 'row pricing-table';

if ( $style != '' ) {
    $class .= ' style-' . $style;
}

$col = floor( 12 / $columns );

//Find items
$innersh = '';
//$sh = preg_match_all( '~\[kleo_pricing_table_item(.*?)?\](?:(.+?)?\[\/kleo_pricing_table_item\])~s', $content, $childs );
$sh = preg_match_all( '~\[kleo_pricing_table_item(.*?)?\](?:(.*?)?\[\/kleo_pricing_table_item\])~s', $content, $childs );


if( $sh && isset( $childs[0] ) && ! empty( $childs[0] )) {

    foreach ( $childs[0] as $child ) {

        $innersh .= '<div class="col-xs-12 ' . ( $columns > 1 ? "col-sm-6 " : " " ) . 'col-md-' . $col . '">';
        $innersh .= do_shortcode( $child );
        $innersh .= '</div>';
    }
}

if ( $heading_bg != '' || $price_bg != '' || $text_color != '' ) {

    $class .= ' color-headings';

    $output .= '<style>';
    if ( $heading_bg != '' ) {
        $output .= '.pricing-table.color-headings .panel-info > .panel-heading,
            .pricing-table.color-headings .panel-info.popular > .panel-heading,
            .pricing-table.color-headings .panel-info.popular .btn-highlight {
                background: ' . $heading_bg . ';
            }
            .pricing-table.color-headings .panel-info.popular .btn-highlight {
                border-color: ' . $heading_bg . ';
            }';
    }
    if ( $text_color != '' ) {
        $output .= '.pricing-table.color-headings .panel-body,
        .pricing-table.color-headings .pmpro-price .lead,
        .pricing-table.color-headings .extra-description,
        .pricing-table.color-headings .panel-heading h3,
        .pricing-table.style-2 .panel-info.popular .btn-highlight:hover {
            color: ' . $text_color . ' !important;
        }';
    }
    if ( $price_bg != '' ) {
        $output .= '.pricing-table.color-headings .panel-body,
        .pricing-table.color-headings .pmpro-price .lead,
        .pricing-table.color-headings .extra-description,
        .pricing-table.style-2 .panel-info.popular .btn-highlight:hover {
            background: ' . $price_bg . ' !important;
        }';
    }
    $output .= '</style>';
}

$output .= "<div class=\"{$class}\">";

$output .= $innersh;

$output .= "</div>";
