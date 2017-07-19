<?php
$output = $title = $tab_id = $icon = '';

$default_atts = $this->predefined_atts;
$default_atts['icon'] = '';
$default_atts['icon_type'] = 'fontello';
extract(shortcode_atts($default_atts, $atts));

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'tab-pane', $this->settings['base'], $atts);

$tab_id = ( empty( $tab_id ) || $tab_id == __( "Tab", "js_composer" ) ) ? esc_attr(str_replace("%", "",sanitize_title_with_dashes( $title ))) : $tab_id;
global $kleo_tab_active;
if ( $tab_id == $kleo_tab_active ) {
	$css_class .= ' active';
}

// Enqueue needed font for icon element
if ( function_exists('vc_icon_element_fonts_enqueue') && 'pixelicons' !== $icon_type && 'fontello' != $icon_type ) {
	vc_icon_element_fonts_enqueue( $icon_type );
}

$output .= "\n\t\t\t" . '<div id="tab-' . $tab_id . '" class="' . $css_class . '">';
$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.tab-pane');

echo $output;