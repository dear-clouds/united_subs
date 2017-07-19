<?php

$output = $title = $interval = $el_class = $collapsible = $active_tab = '';
//
extract(shortcode_atts(array(
    'el_class' => '',
    'collapsible' => 'no',
    'active_tab' => '1',
    'icons_position' => 'to-left'
), $atts));

global $kleo_acc_id, $kleo_acc_active_tab, $kleo_acc_count;
$kleo_acc_id = kleo_vc_elem_increment();
$kleo_acc_active_tab = $active_tab;
$kleo_acc_count = 0;

$collapsible = $collapsible == 'yes' ? "" : ' id="accordion-' . $kleo_acc_id . '"';

$css_class = 'panel-group panel-kleo '.trim($el_class);

$css_class .= ' icons-' . $icons_position;

$output .= "\n\t".'<div class="'.$css_class.'"'.$collapsible.' data-active-tab="'.$active_tab.'">';
//$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_accordion_heading'));
$output .= "\n\t\t\t".wpb_js_remove_wpautop( $content );
$output .= "\n\t".'</div> '.$this->endBlockComment( '.panel-group' );

echo $output;