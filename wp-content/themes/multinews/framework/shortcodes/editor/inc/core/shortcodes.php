<?php
class mom_su_Shortcodes {
	static $tabs = array();
	static $tab_count = 0;

	function __construct() {}

	// public static function heading( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'style'  => 'default',
	// 			'size'   => 13,
	// 			'align'  => 'center',
	// 			'margin' => '20',
	// 			'class'  => ''
	// 		), $atts, 'heading' );
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	do_action( 'mom_su/shortcode/heading', $atts );
	// 	return '<div class="mom-su-heading mom-su-heading-style-' . $atts['style'] . ' mom-su-heading-align-' . $atts['align'] . mom_su_ecssc( $atts ) . '" style="font-size:' . intval( $atts['size'] ) . 'px;margin-bottom:' . $atts['margin'] . 'px"><div class="mom-su-heading-inner">' . do_shortcode( $content ) . '</div></div>';
	// }

	// public static function tabs( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'active'   => 1,
	// 			'vertical' => 'no',
	// 			'style'    => 'default', // 3.x
	// 			'class'    => ''
	// 		), $atts, 'tabs' );
	// 	if ( $atts['style'] === '3' ) $atts['vertical'] = 'yes';
	// 	do_shortcode( $content );
	// 	$return = '';
	// 	$tabs = $panes = array();
	// 	if ( is_array( self::$tabs ) ) {
	// 		if ( self::$tab_count < $atts['active'] ) $atts['active'] = self::$tab_count;
	// 		foreach ( self::$tabs as $tab ) {
	// 			$tabs[] = '<span class="' . mom_su_ecssc( $tab ) . $tab['disabled'] . '"' . $tab['anchor'] . $tab['url'] . $tab['target'] . '>' . mom_su_scattr( $tab['title'] ) . '</span>';
	// 			$panes[] = '<div class="mom-su-tabs-pane mom-su-clearfix' . mom_su_ecssc( $tab ) . '">' . $tab['content'] . '</div>';
	// 		}
	// 		$atts['vertical'] = ( $atts['vertical'] === 'yes' ) ? ' mom-su-tabs-vertical' : '';
	// 		$return = '<div class="mom-su-tabs mom-su-tabs-style-' . $atts['style'] . $atts['vertical'] . mom_su_ecssc( $atts ) . '" data-active="' . (string) $atts['active'] . '"><div class="mom-su-tabs-nav">' . implode( '', $tabs ) . '</div><div class="mom-su-tabs-panes">' . implode( "\n", $panes ) . '</div></div>';
	// 	}
	// 	// Reset tabs
	// 	self::$tabs = array();
	// 	self::$tab_count = 0;
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	do_action( 'mom_su/shortcode/tabs', $atts );
	// 	return $return;
	// }

	// public static function tab( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'title'    => __( 'Tab title', 'theme' ),
	// 			'disabled' => 'no',
	// 			'anchor'   => '',
	// 			'url'      => '',
	// 			'target'   => 'blank',
	// 			'class'    => ''
	// 		), $atts, 'tab' );
	// 	$x = self::$tab_count;
	// 	self::$tabs[$x] = array(
	// 		'title'    => $atts['title'],
	// 		'content'  => do_shortcode( $content ),
	// 		'disabled' => ( $atts['disabled'] === 'yes' ) ? ' mom-su-tabs-disabled' : '',
	// 		'anchor'   => ( $atts['anchor'] ) ? ' data-anchor="' . str_replace( array( ' ', '#' ), '', sanitize_text_field( $atts['anchor'] ) ) . '"' : '',
	// 		'url'      => ' data-url="' . $atts['url'] . '"',
	// 		'target'   => ' data-target="' . $atts['target'] . '"',
	// 		'class'    => $atts['class']
	// 	);
	// 	self::$tab_count++;
	// 	do_action( 'mom_su/shortcode/tab', $atts );
	// }

	// public static function spoiler( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'title'  => __( 'Spoiler title', 'theme' ),
	// 			'open'   => 'no',
	// 			'style'  => 'default',
	// 			'icon'   => 'plus',
	// 			'anchor' => '',
	// 			'class'  => ''
	// 		), $atts, 'spoiler' );
	// 	$atts['style'] = str_replace( array( '1', '2' ), array( 'default', 'fancy' ), $atts['style'] );
	// 	$atts['anchor'] = ( $atts['anchor'] ) ? ' data-anchor="' . str_replace( array( ' ', '#' ), '', sanitize_text_field( $atts['anchor'] ) ) . '"' : '';
	// 	if ( $atts['open'] !== 'yes' ) $atts['class'] .= ' mom-su-spoiler-closed';
	// 	mom_su_query_asset( 'css', 'font-awesome' );
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	do_action( 'mom_su/shortcode/spoiler', $atts );
	// 	return '<div class="mom-su-spoiler mom-su-spoiler-style-' . $atts['style'] . ' mom-su-spoiler-icon-' . $atts['icon'] . mom_su_ecssc( $atts ) . '"' . $atts['anchor'] . '><div class="mom-su-spoiler-title"><span class="mom-su-spoiler-icon"></span>' . mom_su_scattr( $atts['title'] ) . '</div><div class="mom-su-spoiler-content mom-su-clearfix" style="display:none">' . mom_su_do_shortcode( $content, 's' ) . '</div></div>';
	// }

	// public static function accordion( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array( 'class' => '' ), $atts, 'accordion' );
	// 	do_action( 'mom_su/shortcode/accordion', $atts );
	// 	return '<div class="mom-su-accordion' . mom_su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
	// }

	// public static function divider( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'top'           => 'yes',
	// 			'text'          => __( 'Go to top', 'theme' ),
	// 			'style'         => 'default',
	// 			'divider_color' => '#999999',
	// 			'link_color'    => '#999999',
	// 			'size'          => '3',
	// 			'margin'        => '15',
	// 			'class'         => ''
	// 		), $atts, 'divider' );
	// 	// Prepare TOP link
	// 	$top = ( $atts['top'] === 'yes' ) ? '<a href="#" style="color:' . $atts['link_color'] . '">' . mom_su_scattr( $atts['text'] ) . '</a>' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<div class="mom-su-divider mom-su-divider-style-' . $atts['style'] . mom_su_ecssc( $atts ) . '" style="margin:' . $atts['margin'] . 'px 0;border-width:' . $atts['size'] . 'px;border-color:' . $atts['divider_color'] . '">' . $top . '</div>';
	// }

	// public static function spacer( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'size'  => '20',
	// 			'class' => ''
	// 		), $atts, 'spacer' );
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<div class="mom-su-spacer' . mom_su_ecssc( $atts ) . '" style="height:' . (string) $atts['size'] . 'px"></div>';
	// }

	// public static function highlight( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'background' => '#ddff99',
	// 			'bg'         => null, // 3.x
	// 			'color'      => '#000000',
	// 			'class'      => ''
	// 		), $atts, 'highlight' );
	// 	if ( $atts['bg'] !== null ) $atts['background'] = $atts['bg'];
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<span class="mom-su-highlight' . mom_su_ecssc( $atts ) . '" style="background:' . $atts['background'] . ';color:' . $atts['color'] . '">&nbsp;' . do_shortcode( $content ) . '&nbsp;</span>';
	// }

	// public static function label( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'type'  => 'default',
	// 			'style' => null, // 3.x
	// 			'class' => ''
	// 		), $atts, 'label' );
	// 	if ( $atts['style'] !== null ) $atts['type'] = $atts['style'];
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<span class="mom-su-label mom-su-label-type-' . $atts['type'] . mom_su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</span>';
	// }

	// public static function quote( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'style' => 'default',
	// 			'cite'  => false,
	// 			'url'   => false,
	// 			'class' => ''
	// 		), $atts, 'quote' );
	// 	$cite_link = ( $atts['url'] && $atts['cite'] ) ? '<a href="' . $atts['url'] . '" target="_blank">' . $atts['cite'] . '</a>'
	// 	: $atts['cite'];
	// 	$cite = ( $atts['cite'] ) ? '<span class="mom-su-quote-cite">' . $cite_link . '</span>' : '';
	// 	$cite_class = ( $atts['cite'] ) ? ' mom-su-quote-has-cite' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	do_action( 'mom_su/shortcode/quote', $atts );
	// 	return '<div class="mom-su-quote mom-su-quote-style-' . $atts['style'] . $cite_class . mom_su_ecssc( $atts ) . '"><div class="mom-su-quote-inner mom-su-clearfix">' . do_shortcode( $content ) . mom_su_scattr( $cite ) . '</div></div>';
	// }

	// public static function pullquote( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'align' => 'left',
	// 			'class' => ''
	// 		), $atts, 'pullquote' );
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	return '<div class="mom-su-pullquote mom-su-pullquote-align-' . $atts['align'] . mom_su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
	// }

	// public static function dropcap( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'style' => 'default',
	// 			'size'  => 3,
	// 			'class' => ''
	// 		), $atts, 'dropcap' );
	// 	$atts['style'] = str_replace( array( '1', '2', '3' ), array( 'default', 'light', 'default' ), $atts['style'] ); // 3.x
	// 	// Calculate font-size
	// 	$em = $atts['size'] * 0.5 . 'em';
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<span class="mom-su-dropcap mom-su-dropcap-style-' . $atts['style'] . mom_su_ecssc( $atts ) . '" style="font-size:' . $em . '">' . do_shortcode( $content ) . '</span>';
	// }

	// public static function frame( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'style' => 'default',
	// 			'align' => 'left',
	// 			'class' => ''
	// 		), $atts, 'frame' );
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return '<span class="mom-su-frame mom-su-frame-align-' . $atts['align'] . ' mom-su-frame-style-' . $atts['style'] . mom_su_ecssc( $atts ) . '"><span class="mom-su-frame-inner">' . do_shortcode( $content ) . '</span></span>';
	// }

	// public static function row( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array( 'class' => '' ), $atts );
	// 	return '<div class="mom-su-row' . mom_su_ecssc( $atts ) . '">' . mom_su_do_shortcode( $content, 'r' ) . '</div>';
	// }

	// public static function column( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'size'   => '1/2',
	// 			'center' => 'no',
	// 			'last'   => null,
	// 			'class'  => ''
	// 		), $atts, 'column' );
	// 	if ( $atts['last'] !== null && $atts['last'] == '1' ) $atts['class'] .= ' mom-su-column-last';
	// 	if ( $atts['center'] === 'yes' ) $atts['class'] .= ' mom-su-column-centered';
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	return '<div class="mom-su-column mom-su-column-size-' . str_replace( '/', '-', $atts['size'] ) . mom_su_ecssc( $atts ) . '"><div class="mom-su-column-inner mom-su-clearfix">' . mom_su_do_shortcode( $content, 'c' ) . '</div></div>';
	// }

	// public static function mom_su_list( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'icon' => 'icon: star',
	// 			'icon_color' => '#333',
	// 			'style' => null,
	// 			'class' => ''
	// 		), $atts, 'list' );
	// 	// Backward compatibility // 4.2.3+
	// 	if ( $atts['style'] !== null ) {
	// 		switch ( $atts['style'] ) {
	// 		case 'star':
	// 			$atts['icon'] = 'icon: star';
	// 			$atts['icon_color'] = '#ffd647';
	// 			break;
	// 		case 'arrow':
	// 			$atts['icon'] = 'icon: arrow-right';
	// 			$atts['icon_color'] = '#00d1ce';
	// 			break;
	// 		case 'check':
	// 			$atts['icon'] = 'icon: check';
	// 			$atts['icon_color'] = '#17bf20';
	// 			break;
	// 		case 'cross':
	// 			$atts['icon'] = 'icon: remove';
	// 			$atts['icon_color'] = '#ff142b';
	// 			break;
	// 		case 'thumbs':
	// 			$atts['icon'] = 'icon: thumbs-o-up';
	// 			$atts['icon_color'] = '#8a8a8a';
	// 			break;
	// 		case 'link':
	// 			$atts['icon'] = 'icon: external-link';
	// 			$atts['icon_color'] = '#5c5c5c';
	// 			break;
	// 		case 'gear':
	// 			$atts['icon'] = 'icon: cog';
	// 			$atts['icon_color'] = '#ccc';
	// 			break;
	// 		case 'time':
	// 			$atts['icon'] = 'icon: time';
	// 			$atts['icon_color'] = '#a8a8a8';
	// 			break;
	// 		case 'note':
	// 			$atts['icon'] = 'icon: edit';
	// 			$atts['icon_color'] = '#f7d02c';
	// 			break;
	// 		case 'plus':
	// 			$atts['icon'] = 'icon: plus-sign';
	// 			$atts['icon_color'] = '#61dc3c';
	// 			break;
	// 		case 'guard':
	// 			$atts['icon'] = 'icon: shield';
	// 			$atts['icon_color'] = '#1bbe08';
	// 			break;
	// 		case 'event':
	// 			$atts['icon'] = 'icon: bullhorn';
	// 			$atts['icon_color'] = '#ff4c42';
	// 			break;
	// 		case 'idea':
	// 			$atts['icon'] = 'icon: sun';
	// 			$atts['icon_color'] = '#ffd880';
	// 			break;
	// 		case 'settings':
	// 			$atts['icon'] = 'icon: cogs';
	// 			$atts['icon_color'] = '#8a8a8a';
	// 			break;
	// 		case 'twitter':
	// 			$atts['icon'] = 'icon: twitter-sign';
	// 			$atts['icon_color'] = '#00ced6';
	// 			break;
	// 		}
	// 	}
	// 	if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
	// 		$atts['icon'] = '<i class="fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="color:' . $atts['icon_color'] . '"></i>';
	// 		mom_su_query_asset( 'css', 'font-awesome' );
	// 	}
	// 	else $atts['icon'] = '<img src="' . $atts['icon'] . '" alt="" />';
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return '<div class="mom-su-list mom-su-list-style-' . $atts['style'] . mom_su_ecssc( $atts ) . '">' . str_replace( '<li>', '<li>' . $atts['icon'] . ' ', mom_su_do_shortcode( $content, 'l' ) ) . '</div>';
	// }

	// public static function button( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'         => get_option( 'home' ),
	// 			'link'        => null, // 3.x
	// 			'target'      => 'self',
	// 			'style'       => 'default',
	// 			'background'  => '#2D89EF',
	// 			'color'       => '#FFFFFF',
	// 			'dark'        => null, // 3.x
	// 			'size'        => 3,
	// 			'wide'        => 'no',
	// 			'center'      => 'no',
	// 			'radius'      => 'auto',
	// 			'icon'        => false,
	// 			'icon_color'  => '#FFFFFF',
	// 			'ts_color'    => null, // Dep. 4.3.2
	// 			'ts_pos'      => null, // Dep. 4.3.2
	// 			'text_shadow' => 'none',
	// 			'desc'        => '',
	// 			'onclick'     => '',
	// 			'rel'         => '',
	// 			'class'       => ''
	// 		), $atts, 'button' );

	// 	if ( $atts['link'] !== null ) $atts['url'] = $atts['link'];
	// 	if ( $atts['dark'] !== null ) {
	// 		$atts['background'] = $atts['color'];
	// 		$atts['color'] = ( $atts['dark'] ) ? '#000' : '#fff';
	// 	}
	// 	if ( is_numeric( $atts['style'] ) ) $atts['style'] = str_replace( array( '1', '2', '3', '4', '5' ), array( 'default', 'glass', 'bubbles', 'noise', 'stroked' ), $atts['style'] ); // 3.x
	// 	// Prepare vars
	// 	$a_css = array();
	// 	$span_css = array();
	// 	$img_css = array();
	// 	$small_css = array();
	// 	$radius = '0px';
	// 	$before = $after = '';
	// 	// Text shadow values
	// 	$shadows = array(
	// 		'none'         => '0 0',
	// 		'top'          => '0 -1px',
	// 		'right'        => '1px 0',
	// 		'bottom'       => '0 1px',
	// 		'left'         => '-1px 0',
	// 		'top-right'    => '1px -1px',
	// 		'top-left'     => '-1px -1px',
	// 		'bottom-right' => '1px 1px',
	// 		'bottom-left'  => '-1px 1px'
	// 	);
	// 	// Common styles for button
	// 	$styles = array(
	// 		'size'     => round( ( $atts['size'] + 7 ) * 1.3 ),
	// 		'ts_color' => ( $atts['ts_color'] === 'light' ) ? mom_su_hex_shift( $atts['background'], 'lighter', 50 ) : mom_su_hex_shift( $atts['background'], 'darker', 40 ),
	// 		'ts_pos'   => ( $atts['ts_pos'] !== null ) ? $shadows[$atts['ts_pos']] : $shadows['none']
	// 	);
	// 	// Calculate border-radius
	// 	if ( $atts['radius'] == 'auto' ) $radius = round( $atts['size'] + 2 ) . 'px';
	// 	elseif ( $atts['radius'] == 'round' ) $radius = round( ( ( $atts['size'] * 2 ) + 2 ) * 2 + $styles['size'] ) . 'px';
	// 	elseif ( is_numeric( $atts['radius'] ) ) $radius = intval( $atts['radius'] ) . 'px';
	// 	// CSS rules for <a> tag
	// 	$a_rules = array(
	// 		'color'                 => $atts['color'],
	// 		'background-color'      => $atts['background'],
	// 		'border-color'          => mom_su_hex_shift( $atts['background'], 'darker', 20 ),
	// 		'border-radius'         => $radius,
	// 		'-moz-border-radius'    => $radius,
	// 		'-webkit-border-radius' => $radius
	// 	);
	// 	// CSS rules for <span> tag
	// 	$span_rules = array(
	// 		'color'                 => $atts['color'],
	// 		'padding'               => ( $atts['icon'] ) ? round( ( $atts['size'] ) / 2 + 4 ) . 'px ' . round( $atts['size'] * 2 + 10 ) . 'px' : '0px ' . round( $atts['size'] * 2 + 10 ) . 'px',
	// 		'font-size'             => $styles['size'] . 'px',
	// 		'line-height'           => ( $atts['icon'] ) ? round( $styles['size'] * 1.5 ) . 'px' : round( $styles['size'] * 2 ) . 'px',
	// 		'border-color'          => mom_su_hex_shift( $atts['background'], 'lighter', 30 ),
	// 		'border-radius'         => $radius,
	// 		'-moz-border-radius'    => $radius,
	// 		'-webkit-border-radius' => $radius,
	// 		'text-shadow'           => $styles['ts_pos'] . ' 1px ' . $styles['ts_color'],
	// 		'-moz-text-shadow'      => $styles['ts_pos'] . ' 1px ' . $styles['ts_color'],
	// 		'-webkit-text-shadow'   => $styles['ts_pos'] . ' 1px ' . $styles['ts_color']
	// 	);
	// 	// Apply new text-shadow value
	// 	if ( $atts['ts_color'] === null && $atts['ts_pos'] === null ) {
	// 		$span_rules['text-shadow'] = $atts['text_shadow'];
	// 		$span_rules['-moz-text-shadow'] = $atts['text_shadow'];
	// 		$span_rules['-webkit-text-shadow'] = $atts['text_shadow'];
	// 	}
	// 	// CSS rules for <img> tag
	// 	$img_rules = array(
	// 		'width'     => round( $styles['size'] * 1.5 ) . 'px',
	// 		'height'    => round( $styles['size'] * 1.5 ) . 'px'
	// 	);
	// 	// CSS rules for <small> tag
	// 	$small_rules = array(
	// 		'padding-bottom' => round( ( $atts['size'] ) / 2 + 4 ) . 'px',
	// 		'color' => $atts['color']
	// 	);
	// 	// Create style attr value for <a> tag
	// 	foreach ( $a_rules as $a_rule => $a_value ) $a_css[] = $a_rule . ':' . $a_value;
	// 	// Create style attr value for <span> tag
	// 	foreach ( $span_rules as $span_rule => $span_value ) $span_css[] = $span_rule . ':' . $span_value;
	// 	// Create style attr value for <img> tag
	// 	foreach ( $img_rules as $img_rule => $img_value ) $img_css[] = $img_rule . ':' . $img_value;
	// 	// Create style attr value for <img> tag
	// 	foreach ( $small_rules as $small_rule => $small_value ) $small_css[] = $small_rule . ':' . $small_value;
	// 	// Prepare button classes
	// 	$classes = array( 'mom-su-button', 'mom-su-button-style-' . $atts['style'] );
	// 	// Additional classes
	// 	if ( $atts['class'] ) $classes[] = $atts['class'];
	// 	// Wide class
	// 	if ( $atts['wide'] === 'yes' ) $classes[] = 'mom-su-button-wide';
	// 	// Prepare icon
	// 	if ( $atts['icon'] ) {
	// 		if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
	// 			$icon = '<i class="fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="font-size:' . $styles['size'] . 'px;color:' . $atts['icon_color'] . '"></i>';
	// 			mom_su_query_asset( 'css', 'font-awesome' );
	// 		}
	// 		else $icon = '<img src="' . $atts['icon'] . '" alt="' . esc_attr( $content ) . '" style="' . implode( $img_css, ';' ) . '" />';
	// 	}
	// 	else $icon = '';
	// 	// Prepare <small> with description
	// 	$desc = ( $atts['desc'] ) ? '<small style="' . implode( $small_css, ';' ) . '">' . mom_su_scattr( $atts['desc'] ) . '</small>' : '';
	// 	// Wrap with div if button centered
	// 	if ( $atts['center'] === 'yes' ) {
	// 		$before .= '<div class="mom-su-button-center">';
	// 		$after .= '</div>';
	// 	}
	// 	// Replace icon marker in content,
	// 	// add float-icon class to rearrange margins
	// 	if ( strpos( $content, '%icon%' ) !== false ) {
	// 		$content = str_replace( '%icon%', $icon, $content );
	// 		$classes[] = 'mom-su-button-float-icon';
	// 	}
	// 	// Button text has no icon marker, append icon to begin of the text
	// 	else $content = $icon . ' ' . $content;
	// 	// Prepare onclick action
	// 	$atts['onclick'] = ( $atts['onclick'] ) ? ' onClick="' . $atts['onclick'] . '"' : '';
	// 	// Prepare rel attribute
	// 	$atts['rel'] = ( $atts['rel'] ) ? ' rel="' . $atts['rel'] . '"' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	return $before . '<a href="' . mom_su_scattr( $atts['url'] ) . '" class="' . implode( $classes, ' ' ) . '" style="' . implode( $a_css, ';' ) . '" target="_' . $atts['target'] . '"' . $atts['onclick'] . $atts['rel'] . '><span style="' . implode( $span_css, ';' ) . '">' . do_shortcode( $content ) . $desc . '</span></a>' . $after;
	// }

	// public static function service( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'title'       => __( 'Service title', 'theme' ),
	// 			'icon'        => plugins_url( 'assets/images/service.png', mom_su_PLUGIN_FILE ),
	// 			'icon_color'  => '#333',
	// 			'size'        => 32,
	// 			'class'       => ''
	// 		), $atts, 'service' );
	// 	// Built-in icon
	// 	if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
	// 		$atts['icon'] = '<i class="fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="font-size:' . $atts['size'] . 'px;color:' . $atts['icon_color'] . '"></i>';
	// 		mom_su_query_asset( 'css', 'font-awesome' );
	// 	}
	// 	// Uploaded icon
	// 	else {
	// 		$atts['icon'] = '<img src="' . $atts['icon'] . '" width="' . $atts['size'] . '" height="' . $atts['size'] . '" alt="' . $atts['title'] . '" />';
	// 	}
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	return '<div class="mom-su-service' . mom_su_ecssc( $atts ) . '"><div class="mom-su-service-title" style="padding-left:' . round( $atts['size'] + 14 ) . 'px;min-height:' . $atts['size'] . 'px;line-height:' . $atts['size'] . 'px">' . $atts['icon'] . ' ' . mom_su_scattr( $atts['title'] ) . '</div><div class="mom-su-service-content mom-su-clearfix" style="padding-left:' . round( $atts['size'] + 14 ) . 'px">' . do_shortcode( $content ) . '</div></div>';
	// }

	// public static function box( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'title'       => __( 'This is box title', 'theme' ),
	// 			'style'       => 'default',
	// 			'box_color'   => '#333333',
	// 			'title_color' => '#FFFFFF',
	// 			'color'       => null, // 3.x
	// 			'radius'      => '3',
	// 			'class'       => ''
	// 		), $atts, 'box' );
	// 	if ( $atts['color'] !== null ) $atts['box_color'] = $atts['color'];
	// 	// Prepare border-radius
	// 	$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
	// 	$title_radius = ( $atts['radius'] != '0' ) ? $atts['radius'] - 1 : '';
	// 	$title_radius = ( $title_radius ) ? '-webkit-border-top-left-radius:' . $title_radius . 'px;-webkit-border-top-right-radius:' . $title_radius . 'px;-moz-border-radius-topleft:' . $title_radius . 'px;-moz-border-radius-topright:' . $title_radius . 'px;border-top-left-radius:' . $title_radius . 'px;border-top-right-radius:' . $title_radius . 'px;' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	// Return result
	// 	return '<div class="mom-su-box mom-su-box-style-' . $atts['style'] . mom_su_ecssc( $atts ) . '" style="border-color:' . mom_su_hex_shift( $atts['box_color'], 'darker', 20 ) . ';' . $radius . '"><div class="mom-su-box-title" style="background-color:' . $atts['box_color'] . ';color:' . $atts['title_color'] . ';' . $title_radius . '">' . mom_su_scattr( $atts['title'] ) . '</div><div class="mom-su-box-content mom-su-clearfix">' . mom_su_do_shortcode( $content, 'b' ) . '</div></div>';
	// }

	// public static function note( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'note_color' => '#FFFF66',
	// 			'text_color' => '#333333',
	// 			'background' => null, // 3.x
	// 			'color'      => null, // 3.x
	// 			'radius'     => '3',
	// 			'class'      => ''
	// 		), $atts, 'note' );
	// 	if ( $atts['color'] !== null ) $atts['note_color'] = $atts['color'];
	// 	if ( $atts['background'] !== null ) $atts['note_color'] = $atts['background'];
	// 	// Prepare border-radius
	// 	$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	return '<div class="mom-su-note' . mom_su_ecssc( $atts ) . '" style="border-color:' . mom_su_hex_shift( $atts['note_color'], 'darker', 10 ) . ';' . $radius . '"><div class="mom-su-note-inner mom-su-clearfix" style="background-color:' . $atts['note_color'] . ';border-color:' . mom_su_hex_shift( $atts['note_color'], 'lighter', 80 ) . ';color:' . $atts['text_color'] . ';' . $radius . '">' . mom_su_do_shortcode( $content, 'n' ) . '</div></div>';
	// }

	// public static function expand( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'more_text'  => __( 'Show more', 'theme' ),
	// 			'less_text'  => __( 'Show less', 'theme' ),
	// 			'height'     => '100',
	// 			'hide_less'  => 'no',
	// 			'text_color' => '#333333',
	// 			'link_color' => '#0088FF',
	// 			'link_style' => 'default',
	// 			'link_align' => 'left',
	// 			'more_icon'  => '',
	// 			'less_icon'  => '',
	// 			'class'      => ''
	// 		), $atts, 'expand' );
	// 	// Prepare more icon
	// 	$more_icon = ( $atts['more_icon'] ) ? mom_su_Tools::icon( $atts['more_icon'] ) : '';
	// 	$less_icon = ( $atts['less_icon'] ) ? mom_su_Tools::icon( $atts['less_icon'] ) : '';
	// 	if ( $more_icon || $less_icon ) mom_su_query_asset( 'css', 'font-awesome' );
	// 	// Prepare less link
	// 	$less = ( $atts['hide_less'] !== 'yes' ) ? '<div class="mom-su-expand-link mom-su-expand-link-less" style="text-align:' . $atts['link_align'] . '"><a href="javascript:;" style="color:' . $atts['link_color'] . ';border-color:' . $atts['link_color'] . '">' . $less_icon . '<span style="border-color:' . $atts['link_color'] . '">' . $atts['less_text'] . '</span></a></div>' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return '<div class="mom-su-expand mom-su-expand-collapsed mom-su-expand-link-style-' . $atts['link_style'] . mom_su_ecssc( $atts ) . '" data-height="' . $atts['height'] . '"><div class="mom-su-expand-content" style="color:' . $atts['text_color'] . ';max-height:' . intval( $atts['height'] ) . 'px;overflow:hidden">' . do_shortcode( $content ) . '</div><div class="mom-su-expand-link mom-su-expand-link-more" style="text-align:' . $atts['link_align'] . '"><a href="javascript:;" style="color:' . $atts['link_color'] . ';border-color:' . $atts['link_color'] . '">' . $more_icon . '<span style="border-color:' . $atts['link_color'] . '">' . $atts['more_text'] . '</span></a></div>' . $less . '</div>';
	// }

	// public static function lightbox( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'src'   => false,
	// 			'type'  => 'iframe',
	// 			'class' => ''
	// 		), $atts, 'lightbox' );
	// 	if ( !$atts['src'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct source', 'theme' ) );
	// 	mom_su_query_asset( 'css', 'magnific-popup' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'magnific-popup' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return '<span class="mom-su-lightbox' . mom_su_ecssc( $atts ) . '" data-mfp-src="' . mom_su_scattr( $atts['src'] ) . '" data-mfp-type="' . $atts['type'] . '">' . do_shortcode( $content ) . '</span>';
	// }

	// public static function lightbox_content( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'id'         => '',
	// 			'width'      => '50%',
	// 			'margin'     => '40',
	// 			'padding'    => '40',
	// 			'text_align' => 'center',
	// 			'background' => '#FFFFFF',
	// 			'color'      => '#333333',
	// 			'shadow'     => '0px 0px 15px #333333',
	// 			'class'      => ''
	// 		), $atts, 'lightbox_content' );
	// 	mom_su_query_asset( 'css', 'mom-su-box-shortcodes' );
	// 	if ( !$atts['id'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct ID for this block. You should use same ID as in the Content source field (when inserting lightbox shortcode)', 'theme' ) );
	// 	$return = '<div class="mom-su-lightbox-content ' . mom_su_ecssc( $atts ) . '" id="' . trim( $atts['id'], '#' ) . '" style="display:none;width:' . $atts['width'] . ';margin-top:' . $atts['margin'] . 'px;margin-bottom:' . $atts['margin'] . 'px;padding:' . $atts['padding'] . 'px;background-color:' . $atts['background'] . ';color:' . $atts['color'] . ';box-shadow:' . $atts['shadow'] . ';text-align:' . $atts['text_align'] . '">' . do_shortcode( $content ) . '</div>';
	// 	if ( did_action( 'mom_su/generator/preview/before' ) ) return '<div class="mom-su-lightbox-content-preview">' . $return . '</div>';
	// 	else return $return;
	// }

	// public static function tooltip( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'style'        => 'yellow',
	// 			'position'     => 'north',
	// 			'shadow'       => 'no',
	// 			'rounded'      => 'no',
	// 			'size'         => 'default',
	// 			'title'        => '',
	// 			'content'      => __( 'Tooltip text', 'theme' ),
	// 			'behavior'     => 'hover',
	// 			'close'        => 'no',
	// 			'class'        => ''
	// 		), $atts, 'tooltip' );
	// 	// Prepare style
	// 	$atts['style'] = ( in_array( $atts['style'], array( 'light', 'dark', 'green', 'red', 'blue', 'youtube', 'tipsy', 'bootstrap', 'jtools', 'tipped', 'cluetip' ) ) ) ? $atts['style'] : 'plain';
	// 	// Position
	// 	$atts['position'] = str_replace( array( 'top', 'right', 'bottom', 'left' ), array( 'north', 'east', 'south', 'west' ), $atts['position'] );
	// 	$position = array(
	// 		'my' => str_replace( array( 'north', 'east', 'south', 'west' ), array( 'bottom center', 'center left', 'top center', 'center right' ), $atts['position'] ),
	// 		'at' => str_replace( array( 'north', 'east', 'south', 'west' ), array( 'top center', 'center right', 'bottom center', 'center left' ), $atts['position'] )
	// 	);
	// 	// Prepare classes
	// 	$classes = array( 'mom-su-qtip qtip-' . $atts['style'] );
	// 	$classes[] = 'mom-su-qtip-size-' . $atts['size'];
	// 	if ( $atts['shadow'] === 'yes' ) $classes[] = 'qtip-shadow';
	// 	if ( $atts['rounded'] === 'yes' ) $classes[] = 'qtip-rounded';
	// 	// Query assets
	// 	mom_su_query_asset( 'css', 'qtip' );
	// 	mom_su_query_asset( 'css', 'mom-su-other-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'qtip' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return '<span class="mom-su-tooltip' . mom_su_ecssc( $atts ) . '" data-close="' . $atts['close'] . '" data-behavior="' . $atts['behavior'] . '" data-my="' . $position['my'] . '" data-at="' . $position['at'] . '" data-classes="' . implode( ' ', $classes ) . '" data-title="' . $atts['title'] . '" title="' . esc_attr( $atts['content'] ) . '">' . do_shortcode( $content ) . '</span>';
	// }


	// public static function media( $atts = null, $content = null ) {
	// 	// Check YouTube video
	// 	if ( strpos( $atts['url'], 'youtu' ) !== false ) return mom_su_Shortcodes::youtube( $atts );
	// 	// Check Vimeo video
	// 	elseif ( strpos( $atts['url'], 'vimeo' ) !== false ) return mom_su_Shortcodes::vimeo( $atts );
	// 	// Image
	// 	else return '<img src="' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" style="max-width:100%" />';
	// }

	// public static function youtube( $atts = null, $content = null ) {
	// 	// Prepare data
	// 	$return = array();
	// 	$atts = shortcode_atts( array(
	// 			'url'        => false,
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'autoplay'   => 'no',
	// 			'responsive' => 'yes',
	// 			'class'      => ''
	// 		), $atts, 'youtube' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;
	// 	// Check that url is specified
	// 	if ( !$id ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Prepare autoplay
	// 	$autoplay = ( $atts['autoplay'] === 'yes' ) ? '?autoplay=1' : '';
	// 	// Create player
	// 	$return[] = '<div class="mom-su-youtube mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '">';
	// 	$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.youtube.com/embed/' . $id . $autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
	// 	$return[] = '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	// Return result
	// 	return implode( '', $return );
	// }

	// public static function youtube_advanced( $atts = null, $content = null ) {
	// 	// Prepare data
	// 	$return = array();
	// 	$params = array();
	// 	$atts = shortcode_atts( array(
	// 			'url'            => false,
	// 			'width'          => 600,
	// 			'height'         => 400,
	// 			'responsive'     => 'yes',
	// 			'autohide'       => 'alt',
	// 			'autoplay'       => 'no',
	// 			'controls'       => 'yes',
	// 			'fs'             => 'yes',
	// 			'loop'           => 'no',
	// 			'modestbranding' => 'no',
	// 			'playlist'       => '',
	// 			'rel'            => 'yes',
	// 			'showinfo'       => 'yes',
	// 			'theme'          => 'dark',
	// 			'https'          => 'no',
	// 			'wmode'          => '',
	// 			'class'          => ''
	// 		), $atts, 'youtube_advanced' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;
	// 	// Check that url is specified
	// 	if ( !$id ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Prepare params
	// 	foreach ( array( 'autohide', 'autoplay', 'controls', 'fs', 'loop', 'modestbranding', 'playlist', 'rel', 'showinfo', 'theme', 'wmode' ) as $param ) $params[$param] = str_replace( array( 'no', 'yes', 'alt' ), array( '0', '1', '2' ), $atts[$param] );
	// 	// Correct loop
	// 	if ( $params['loop'] === '1' && $params['playlist'] === '' ) $params['playlist'] = $id;
	// 	// Prepare protocol
	// 	$protocol = ( $atts['https'] === 'yes' ) ? 'https' : 'http';
	// 	// Prepare player parameters
	// 	$params = http_build_query( $params );
	// 	// Create player
	// 	$return[] = '<div class="mom-su-youtube mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '">';
	// 	$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="' . $protocol . '://www.youtube.com/embed/' . $id . '?' . $params . '" frameborder="0" allowfullscreen="true"></iframe>';
	// 	$return[] = '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	// Return result
	// 	return implode( '', $return );
	// }

	// public static function vimeo( $atts = null, $content = null ) {
	// 	// Prepare data
	// 	$return = array();
	// 	$atts = shortcode_atts( array(
	// 			'url'        => false,
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'autoplay'   => 'no',
	// 			'responsive' => 'yes',
	// 			'class'      => ''
	// 		), $atts, 'vimeo' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;
	// 	// Check that url is specified
	// 	if ( !$id ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Prepare autoplay
	// 	$autoplay = ( $atts['autoplay'] === 'yes' ) ? '&amp;autoplay=1' : '';
	// 	// Create player
	// 	$return[] = '<div class="mom-su-vimeo mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '">';
	// 	$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="//player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff' . $autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
	// 	$return[] = '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	// Return result
	// 	return implode( '', $return );
	// }

	// public static function screenr( $atts = null, $content = null ) {
	// 	// Prepare data
	// 	$return = array();
	// 	$atts = shortcode_atts( array(
	// 			'url'        => false,
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'responsive' => 'yes',
	// 			'class'      => ''
	// 		), $atts, 'screenr' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*screenr\.com(?:[\/\w]*\/videos?)?\/([a-zA-Z0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;
	// 	// Check that url is specified
	// 	if ( !$id ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Create player
	// 	$return[] = '<div class="mom-su-screenr mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '">';
	// 	$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://screenr.com/embed/' . $id . '" frameborder="0" allowfullscreen="true"></iframe>';
	// 	$return[] = '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	// Return result
	// 	return implode( '', $return );
	// }

	// public static function dailymotion( $atts = null, $content = null ) {
	// 	// Prepare data
	// 	$return = array();
	// 	$atts = shortcode_atts( array(
	// 			'url'        => false,
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'responsive' => 'yes',
	// 			'autoplay'   => 'no',
	// 			'background' => '#FFC300',
	// 			'foreground' => '#F7FFFD',
	// 			'highlight'  => '#171D1B',
	// 			'logo'       => 'yes',
	// 			'quality'    => '380',
	// 			'related'    => 'yes',
	// 			'info'       => 'yes',
	// 			'class'      => ''
	// 		), $atts, 'dailymotion' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	$id = strtok( basename( $atts['url'] ), '_' );
	// 	// Check that url is specified
	// 	if ( !$id ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Prepare params
	// 	$params = array();
	// 	foreach ( array( 'autoplay', 'background', 'foreground', 'highlight', 'logo', 'quality', 'related', 'info' ) as $param )
	// 		$params[] = $param . '=' . str_replace( array( 'yes', 'no', '#' ), array( '1', '0', '' ), $atts[$param] );
	// 	// Create player
	// 	$return[] = '<div class="mom-su-dailymotion mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '">';
	// 	$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.dailymotion.com/embed/video/' . $id . '?' . implode( '&', $params ) . '" frameborder="0" allowfullscreen="true"></iframe>';
	// 	$return[] = '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	// Return result
	// 	return implode( '', $return );
	// }

	// public static function audio( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'      => false,
	// 			'width'    => 'auto',
	// 			'title'    => '',
	// 			'autoplay' => 'no',
	// 			'loop'     => 'no',
	// 			'class'    => ''
	// 		), $atts, 'audio' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	// Generate unique ID
	// 	$id = uniqid( 'mom_su_audio_player_' );
	// 	// Prepare width
	// 	$width = ( $atts['width'] !== 'auto' ) ? 'max-width:' . $atts['width'] : '';
	// 	// Check that url is specified
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	mom_su_query_asset( 'css', 'mom-su-players-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'jplayer' );
	// 	mom_su_query_asset( 'js', 'mom-su-players-shortcodes' );
	// 	mom_su_query_asset( 'js', 'mom-su-players-shortcodes' );
	// 	// Create player
	// 	return '<div class="mom-su-audio' . mom_su_ecssc( $atts ) . '" data-id="' . $id . '" data-audio="' . $atts['url'] . '" data-swf="' . plugins_url( 'assets/other/Jplayer.swf', mom_su_PLUGIN_FILE ) . '" data-autoplay="' . $atts['autoplay'] . '" data-loop="' . $atts['loop'] . '" style="' . $width . '"><div id="' . $id . '" class="jp-jplayer"></div><div id="' . $id . '_container" class="jp-audio"><div class="jp-type-single"><div class="jp-gui jp-interface"><div class="jp-controls"><span class="jp-play"></span><span class="jp-pause"></span><span class="jp-stop"></span><span class="jp-mute"></span><span class="jp-unmute"></span><span class="jp-volume-max"></span></div><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div><div class="jp-current-time"></div><div class="jp-duration"></div></div><div class="jp-title">' . $atts['title'] . '</div></div></div></div>';
	// }

	// public static function video( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'      => false,
	// 			'poster'   => false,
	// 			'title'    => '',
	// 			'width'    => 600,
	// 			'height'   => 300,
	// 			'controls' => 'yes',
	// 			'autoplay' => 'no',
	// 			'loop'     => 'no',
	// 			'class'    => ''
	// 		), $atts, 'video' );
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	$atts['url'] = mom_su_scattr( $atts['url'] );
	// 	// Generate unique ID
	// 	$id = uniqid( 'mom_su_video_player_' );
	// 	// Check that url is specified
	// 	if ( !$atts['url'] ) return mom_su_Tools::error( __FUNCTION__, __( 'please specify correct url', 'theme' ) );
	// 	// Prepare title
	// 	$title = ( $atts['title'] ) ? '<div class="jp-title">' . $atts['title'] . '</div>' : '';
	// 	mom_su_query_asset( 'css', 'mom-su-players-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'jplayer' );
	// 	mom_su_query_asset( 'js', 'mom-su-players-shortcodes' );
	// 	// Create player
	// 	return '<div style="width:' . $atts['width'] . 'px"><div id="' . $id . '" class="mom-su-video jp-video mom-su-video-controls-' . $atts['controls'] . mom_su_ecssc( $atts ) . '" data-id="' . $id . '" data-video="' . $atts['url'] . '" data-swf="' . plugins_url( 'assets/other/Jplayer.swf', mom_su_PLUGIN_FILE ) . '" data-autoplay="' . $atts['autoplay'] . '" data-loop="' . $atts['loop'] . '" data-poster="' . $atts['poster'] . '"><div id="' . $id . '_player" class="jp-jplayer" style="width:' . $atts['width'] . 'px;height:' . $atts['height'] . 'px"></div>' . $title . '<div class="jp-start jp-play"></div><div class="jp-gui"><div class="jp-interface"><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-current-time"></div><div class="jp-duration"></div><div class="jp-controls-holder"><span class="jp-play"></span><span class="jp-pause"></span><span class="jp-mute"></span><span class="jp-unmute"></span><span class="jp-full-screen"></span><span class="jp-restore-screen"></span><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div></div></div></div></div>';
	// }

	// public static function table( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'   => false,
	// 			'class' => ''
	// 		), $atts, 'table' );
	// 	$return = '<div class="mom-su-table' . mom_su_ecssc( $atts ) . '">';
	// 	$return .= ( $atts['url'] ) ? mom_su_parse_csv( $atts['url'] ) : do_shortcode( $content );
	// 	$return .= '</div>';
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return $return;
	// }

	// public static function permalink( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'id' => 1,
	// 			'p' => null, // 3.x
	// 			'target' => 'self',
	// 			'class' => ''
	// 		), $atts, 'permalink' );
	// 	if ( $atts['p'] !== null ) $atts['id'] = $atts['p'];
	// 	$atts['id'] = mom_su_scattr( $atts['id'] );
	// 	// Prepare link text
	// 	$text = ( $content ) ? $content : get_the_title( $atts['id'] );
	// 	return '<a href="' . get_permalink( $atts['id'] ) . '" class="' . mom_su_ecssc( $atts ) . '" title="' . $text . '" target="_' . $atts['target'] . '">' . $text . '</a>';
	// }

	// public static function members( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'message'    => __( 'This content is for registered users only. Please %login%.', 'theme' ),
	// 			'color'      => '#ffcc00',
	// 			'style'      => null, // 3.x
	// 			'login_text' => __( 'login', 'theme' ),
	// 			'login_url'  => wp_login_url(),
	// 			'login'      => null, // 3.x
	// 			'class'      => ''
	// 		), $atts, 'members' );
	// 	if ( $atts['style'] !== null ) $atts['color'] = str_replace( array( '0', '1', '2' ), array( '#fff', '#FFFF29', '#1F9AFF' ), $atts['style'] );
	// 	// Check feed
	// 	if ( is_feed() ) return;
	// 	// Check authorization
	// 	if ( !is_user_logged_in() ) {
	// 		if ( $atts['login'] !== null && $atts['login'] == '0' ) return; // 3.x
	// 		// Prepare login link
	// 		$login = '<a href="' . esc_attr( $atts['login_url'] ) . '">' . $atts['login_text'] . '</a>';
	// 		mom_su_query_asset( 'css', 'mom-su-other-shortcodes' );
	// 		return '<div class="mom-su-members' . mom_su_ecssc( $atts ) . '" style="background-color:' . mom_su_hex_shift( $atts['color'], 'lighter', 50 ) . ';border-color:' .mom_su_hex_shift( $atts['color'], 'darker', 20 ) . ';color:' .mom_su_hex_shift( $atts['color'], 'darker', 60 ) . '">' . str_replace( '%login%', $login, mom_su_scattr( $atts['message'] ) ) . '</div>';
	// 	}
	// 	// Return original content
	// 	else return do_shortcode( $content );
	// }

	// public static function guests( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array( 'class' => '' ), $atts, 'guests' );
	// 	$return = '';
	// 	if ( !is_user_logged_in() && !is_null( $content ) ) {
	// 		mom_su_query_asset( 'css', 'mom-su-other-shortcodes' );
	// 		$return = '<div class="mom-su-guests' . mom_su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
	// 	}
	// 	return $return;
	// }

	// public static function feed( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'   => get_bloginfo_rss( 'rss2_url' ),
	// 			'limit' => 3,
	// 			'class' => ''
	// 		), $atts, 'feed' );
	// 	if ( !function_exists( 'wp_rss' ) ) include_once ABSPATH . WPINC . '/rss.php';
	// 	ob_start();
	// 	echo '<div class="mom-su-feed' . mom_su_ecssc( $atts ) . '">';
	// 	wp_rss( $atts['url'], $atts['limit'] );
	// 	echo '</div>';
	// 	$return = ob_get_contents();
	// 	ob_end_clean();
	// 	return $return;
	// }

	// public static function subpages( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'depth' => 1,
	// 			'p'     => false,
	// 			'class' => ''
	// 		), $atts, 'subpages' );
	// 	global $post;
	// 	$child_of = ( $atts['p'] ) ? $atts['p'] : get_the_ID();
	// 	$return = wp_list_pages( array(
	// 			'title_li' => '',
	// 			'echo' => 0,
	// 			'child_of' => $child_of,
	// 			'depth' => $atts['depth']
	// 		) );
	// 	return ( $return ) ? '<ul class="mom-su-subpages' . mom_su_ecssc( $atts ) . '">' . $return . '</ul>' : false;
	// }

	// public static function siblings( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array( 'depth' => 1, 'class' => '' ), $atts, 'siblings' );
	// 	global $post;
	// 	$return = wp_list_pages( array( 'title_li' => '',
	// 			'echo' => 0,
	// 			'child_of' => $post->post_parent,
	// 			'depth' => $atts['depth'],
	// 			'exclude' => $post->ID ) );
	// 	return ( $return ) ? '<ul class="mom-su-siblings' . mom_su_ecssc( $atts ) . '">' . $return . '</ul>' : false;
	// }

	// public static function menu( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'name' => false,
	// 			'class' => ''
	// 		), $atts, 'menu' );
	// 	$return = wp_nav_menu( array(
	// 			'echo'        => false,
	// 			'menu'        => $atts['name'],
	// 			'container'   => false,
	// 			'fallback_cb' => array( __CLASS__, 'menu_fb' ),
	// 			'items_wrap'  => '<ul id="%1$s" class="%2$s' . mom_su_ecssc( $atts ) . '">%3$s</ul>'
	// 		) );
	// 	return ( $atts['name'] ) ? $return : false;
	// }

	// public static function menu_fb() {
	// 	return __( 'This menu doesn\'t exists, or has no elements', 'theme' );
	// }

	// public static function document( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'url'        => '',
	// 			'file'       => null, // 3.x
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'responsive' => 'yes',
	// 			'class'      => ''
	// 		), $atts, 'document' );
	// 	if ( $atts['file'] !== null ) $atts['url'] = $atts['file'];
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	return '<div class="mom-su-document mom-su-responsive-media-' . $atts['responsive'] . '"><iframe src="http://docs.google.com/viewer?embedded=true&url=' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" class="mom-su-document' . mom_su_ecssc( $atts ) . '"></iframe></div>';
	// }

	// public static function gmap( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'width'      => 600,
	// 			'height'     => 400,
	// 			'responsive' => 'yes',
	// 			'address'    => 'New York',
	// 			'class'      => ''
	// 		), $atts, 'gmap' );
	// 	mom_su_query_asset( 'css', 'mom-su-media-shortcodes' );
	// 	return '<div class="mom-su-gmap mom-su-responsive-media-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '"><iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://maps.google.com/maps?q=' . urlencode( mom_su_scattr( $atts['address'] ) ) . '&amp;output=embed"></iframe></div>';
	// }

	// public static function slider( $atts = null, $content = null ) {
	// 	$return = '';
	// 	$atts = shortcode_atts( array(
	// 			'source'     => 'none',
	// 			'limit'      => 20,
	// 			'gallery'    => null, // Dep. 4.3.2
	// 			'link'       => 'none',
	// 			'target'     => 'self',
	// 			'width'      => 600,
	// 			'height'     => 300,
	// 			'responsive' => 'yes',
	// 			'title'      => 'yes',
	// 			'centered'   => 'yes',
	// 			'arrows'     => 'yes',
	// 			'pages'      => 'yes',
	// 			'mousewheel' => 'yes',
	// 			'autoplay'   => 3000,
	// 			'speed'      => 600,
	// 			'class'      => ''
	// 		), $atts, 'slider' );
	// 	// Get slides
	// 	$slides = (array) mom_su_Tools::get_slides( $atts );
	// 	// Loop slides
	// 	if ( count( $slides ) ) {
	// 		// Prepare unique ID
	// 		$id = uniqid( 'mom_su_slider_' );
	// 		// Links target
	// 		$target = ( $atts['target'] === 'yes' || $atts['target'] === 'blank' ) ? ' target="_blank"' : '';
	// 		// Centered class
	// 		$centered = ( $atts['centered'] === 'yes' ) ? ' mom-su-slider-centered' : '';
	// 		// Wheel control
	// 		$mousewheel = ( $atts['mousewheel'] === 'yes' ) ? 'true' : 'false';
	// 		// Prepare width and height
	// 		$size = ( $atts['responsive'] === 'yes' ) ? 'width:100%' : 'width:' . intval( $atts['width'] ) . 'px;height:' . intval( $atts['height'] ) . 'px';
	// 		// Add lightbox class
	// 		if ( $atts['link'] === 'lightbox' ) $atts['class'] .= ' mom-su-lightbox-gallery';
	// 		// Open slider
	// 		$return .= '<div id="' . $id . '" class="mom-su-slider' . $centered . ' mom-su-slider-pages-' . $atts['pages'] . ' mom-su-slider-responsive-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '" style="' . $size . '" data-autoplay="' . $atts['autoplay'] . '" data-speed="' . $atts['speed'] . '" data-mousewheel="' . $mousewheel . '"><div class="mom-su-slider-slides">';
	// 		// Create slides
	// 		foreach ( $slides as $slide ) {
	// 			// Crop the image
	// 			$image = mom_su_image_resize( $slide['image'], $atts['width'], $atts['height'] );
	// 			// Prepare slide title
	// 			$title = ( $atts['title'] === 'yes' && $slide['title'] ) ? '<span class="mom-su-slider-slide-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
	// 			// Open slide
	// 			$return .= '<div class="mom-su-slider-slide">';
	// 			// Slide content with link
	// 			if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
	// 			// Slide content without link
	// 			else $return .= '<a><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
	// 			// Close slide
	// 			$return .= '</div>';
	// 		}
	// 		// Close slides
	// 		$return .= '</div>';
	// 		// Open nav section
	// 		$return .= '<div class="mom-su-slider-nav">';
	// 		// Append direction nav
	// 		if ( $atts['arrows'] === 'yes' ) $return .= '<div class="mom-su-slider-direction"><span class="mom-su-slider-prev"></span><span class="mom-su-slider-next"></span></div>';
	// 		// Append pagination nav
	// 		$return .= '<div class="mom-su-slider-pagination"></div>';
	// 		// Close nav section
	// 		$return .= '</div>';
	// 		// Close slider
	// 		$return .= '</div>';
	// 		// Add lightbox assets
	// 		if ( $atts['link'] === 'lightbox' ) {
	// 			mom_su_query_asset( 'css', 'magnific-popup' );
	// 			mom_su_query_asset( 'js', 'magnific-popup' );
	// 		}
	// 		mom_su_query_asset( 'css', 'mom-su-galleries-shortcodes' );
	// 		mom_su_query_asset( 'js', 'jquery' );
	// 		mom_su_query_asset( 'js', 'swiper' );
	// 		mom_su_query_asset( 'js', 'mom-su-galleries-shortcodes' );
	// 	}
	// 	// Slides not found
	// 	else $return = mom_su_Tools::error( __FUNCTION__, __( 'images not found', 'theme' ) );
	// 	return $return;
	// }

	// public static function carousel( $atts = null, $content = null ) {
	// 	$return = '';
	// 	$atts = shortcode_atts( array(
	// 			'source'     => 'none',
	// 			'limit'      => 20,
	// 			'gallery'    => null, // Dep. 4.3.2
	// 			'link'       => 'none',
	// 			'target'     => 'self',
	// 			'width'      => 600,
	// 			'height'     => 100,
	// 			'responsive' => 'yes',
	// 			'items'      => 3,
	// 			'scroll'     => 1,
	// 			'title'      => 'yes',
	// 			'centered'   => 'yes',
	// 			'arrows'     => 'yes',
	// 			'pages'      => 'no',
	// 			'mousewheel' => 'yes',
	// 			'autoplay'   => 3000,
	// 			'speed'      => 600,
	// 			'class'      => ''
	// 		), $atts, 'carousel' );
	// 	// Get slides
	// 	$slides = (array) mom_su_Tools::get_slides( $atts );
	// 	// Loop slides
	// 	if ( count( $slides ) ) {
	// 		// Prepare unique ID
	// 		$id = uniqid( 'mom_su_carousel_' );
	// 		// Links target
	// 		$target = ( $atts['target'] === 'yes' || $atts['target'] === 'blank' ) ? ' target="_blank"' : '';
	// 		// Centered class
	// 		$centered = ( $atts['centered'] === 'yes' ) ? ' mom-su-carousel-centered' : '';
	// 		// Wheel control
	// 		$mousewheel = ( $atts['mousewheel'] === 'yes' ) ? 'true' : 'false';
	// 		// Prepare width and height
	// 		$size = ( $atts['responsive'] === 'yes' ) ? 'width:100%' : 'width:' . intval( $atts['width'] ) . 'px;height:' . intval( $atts['height'] ) . 'px';
	// 		// Add lightbox class
	// 		if ( $atts['link'] === 'lightbox' ) $atts['class'] .= ' mom-su-lightbox-gallery';
	// 		// Open slider
	// 		$return .= '<div id="' . $id . '" class="mom-su-carousel' . $centered . ' mom-su-carousel-pages-' . $atts['pages'] . ' mom-su-carousel-responsive-' . $atts['responsive'] . mom_su_ecssc( $atts ) . '" style="' . $size . '" data-autoplay="' . $atts['autoplay'] . '" data-speed="' . $atts['speed'] . '" data-mousewheel="' . $mousewheel . '" data-items="' . $atts['items'] . '" data-scroll="' . $atts['scroll'] . '"><div class="mom-su-carousel-slides">';
	// 		// Create slides
	// 		foreach ( (array) $slides as $slide ) {
	// 			// Crop the image
	// 			$image = mom_su_image_resize( $slide['image'], round( $atts['width'] / $atts['items'] ), $atts['height'] );
	// 			// Prepare slide title
	// 			$title = ( $atts['title'] === 'yes' && $slide['title'] ) ? '<span class="mom-su-carousel-slide-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
	// 			// Open slide
	// 			$return .= '<div class="mom-su-carousel-slide">';
	// 			// Slide content with link
	// 			if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
	// 			// Slide content without link
	// 			else $return .= '<a><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
	// 			// Close slide
	// 			$return .= '</div>';
	// 		}
	// 		// Close slides
	// 		$return .= '</div>';
	// 		// Open nav section
	// 		$return .= '<div class="mom-su-carousel-nav">';
	// 		// Append direction nav
	// 		if ( $atts['arrows'] === 'yes'
	// 		) $return .= '<div class="mom-su-carousel-direction"><span class="mom-su-carousel-prev"></span><span class="mom-su-carousel-next"></span></div>';
	// 		// Append pagination nav
	// 		$return .= '<div class="mom-su-carousel-pagination"></div>';
	// 		// Close nav section
	// 		$return .= '</div>';
	// 		// Close slider
	// 		$return .= '</div>';
	// 		// Add lightbox assets
	// 		if ( $atts['link'] === 'lightbox' ) {
	// 			mom_su_query_asset( 'css', 'magnific-popup' );
	// 			mom_su_query_asset( 'js', 'magnific-popup' );
	// 		}
	// 		mom_su_query_asset( 'css', 'mom-su-galleries-shortcodes' );
	// 		mom_su_query_asset( 'js', 'jquery' );
	// 		mom_su_query_asset( 'js', 'swiper' );
	// 		mom_su_query_asset( 'js', 'mom-su-galleries-shortcodes' );
	// 	}
	// 	// Slides not found
	// 	else $return = mom_su_Tools::error( __FUNCTION__, __( 'images not found', 'theme' ) );
	// 	return $return;
	// }

	// public static function custom_gallery( $atts = null, $content = null ) {
	// 	$return = '';
	// 	$atts = shortcode_atts( array(
	// 			'source'  => 'none',
	// 			'limit'   => 20,
	// 			'gallery' => null, // Dep. 4.4.0
	// 			'link'    => 'none',
	// 			'width'   => 90,
	// 			'height'  => 90,
	// 			'title'   => 'hover',
	// 			'target'  => 'self',
	// 			'class'   => ''
	// 		), $atts, 'custom_gallery' );
	// 	$slides = (array) mom_su_Tools::get_slides( $atts );
	// 	// Loop slides
	// 	if ( count( $slides ) ) {
	// 		// Prepare links target
	// 		$atts['target'] = ( $atts['target'] === 'yes' || $atts['target'] === 'blank' ) ? ' target="_blank"' : '';
	// 		// Add lightbox class
	// 		if ( $atts['link'] === 'lightbox' ) $atts['class'] .= ' mom-su-lightbox-gallery';
	// 		// Open gallery
	// 		$return = '<div class="mom-su-custom-gallery mom-su-custom-gallery-title-' . $atts['title'] . mom_su_ecssc( $atts ) . '">';
	// 		// Create slides
	// 		foreach ( $slides as $slide ) {
	// 			// Crop image
	// 			$image = mom_su_image_resize( $slide['image'], $atts['width'], $atts['height'] );
	// 			// Prepare slide title
	// 			$title = ( $slide['title'] ) ? '<span class="mom-su-custom-gallery-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
	// 			// Open slide
	// 			$return .= '<div class="mom-su-custom-gallery-slide">';
	// 			// Slide content with link
	// 			if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $atts['target'] . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';
	// 			// Slide content without link
	// 			else $return .= '<a><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';
	// 			// Close slide
	// 			$return .= '</div>';
	// 		}
	// 		// Clear floats
	// 		$return .= '<div class="mom-su-clear"></div>';
	// 		// Close gallery
	// 		$return .= '</div>';
	// 		// Add lightbox assets
	// 		if ( $atts['link'] === 'lightbox' ) {
	// 			mom_su_query_asset( 'css', 'magnific-popup' );
	// 			mom_su_query_asset( 'js', 'jquery' );
	// 			mom_su_query_asset( 'js', 'magnific-popup' );
	// 			mom_su_query_asset( 'js', 'mom-su-galleries-shortcodes' );
	// 		}
	// 		mom_su_query_asset( 'css', 'mom-su-galleries-shortcodes' );
	// 	}
	// 	// Slides not found
	// 	else $return = mom_su_Tools::error( __FUNCTION__, __( 'images not found', 'theme' ) );
	// 	return $return;
	// }

	// public static function posts( $atts = null, $content = null ) {
	// 	// Prepare error var
	// 	$error = null;
	// 	// Parse attributes
	// 	$atts = shortcode_atts( array(
	// 			'template'            => 'templates/default-loop.php',
	// 			'id'                  => false,
	// 			'posts_per_page'      => get_option( 'posts_per_page' ),
	// 			'post_type'           => 'post',
	// 			'taxonomy'            => 'category',
	// 			'tax_term'            => false,
	// 			'tax_operator'        => 'IN',
	// 			'author'              => '',
	// 			'tag'                 => '',
	// 			'meta_key'            => '',
	// 			'offset'              => 0,
	// 			'order'               => 'DESC',
	// 			'orderby'             => 'date',
	// 			'post_parent'         => false,
	// 			'post_status'         => 'publish',
	// 			'ignore_sticky_posts' => 'no'
	// 		), $atts, 'posts' );

	// 	$original_atts = $atts;

	// 	$author = sanitize_text_field( $atts['author'] );
	// 	$id = $atts['id']; // Sanitized later as an array of integers
	// 	$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
	// 	$meta_key = sanitize_text_field( $atts['meta_key'] );
	// 	$offset = intval( $atts['offset'] );
	// 	$order = sanitize_key( $atts['order'] );
	// 	$orderby = sanitize_key( $atts['orderby'] );
	// 	$post_parent = $atts['post_parent'];
	// 	$post_status = $atts['post_status'];
	// 	$post_type = sanitize_text_field( $atts['post_type'] );
	// 	$posts_per_page = intval( $atts['posts_per_page'] );
	// 	$tag = sanitize_text_field( $atts['tag'] );
	// 	$tax_operator = $atts['tax_operator'];
	// 	$tax_term = sanitize_text_field( $atts['tax_term'] );
	// 	$taxonomy = sanitize_key( $atts['taxonomy'] );
	// 	// Set up initial query for post
	// 	$args = array(
	// 		'category_name'  => '',
	// 		'order'          => $order,
	// 		'orderby'        => $orderby,
	// 		'post_type'      => explode( ',', $post_type ),
	// 		'posts_per_page' => $posts_per_page,
	// 		'tag'            => $tag
	// 	);
	// 	// Ignore Sticky Posts
	// 	if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;
	// 	// Meta key (for ordering)
	// 	if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;
	// 	// If Post IDs
	// 	if ( $id ) {
	// 		$posts_in = array_map( 'intval', explode( ',', $id ) );
	// 		$args['post__in'] = $posts_in;
	// 	}
	// 	// Post Author
	// 	if ( !empty( $author ) ) $args['author'] = $author;
	// 	// Offset
	// 	if ( !empty( $offset ) ) $args['offset'] = $offset;
	// 	// Post Status
	// 	$post_status = explode( ', ', $post_status );
	// 	$validated = array();
	// 	$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
	// 	foreach ( $post_status as $unvalidated ) {
	// 		if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
	// 	}
	// 	if ( !empty( $validated ) ) $args['post_status'] = $validated;
	// 	// If taxonomy attributes, create a taxonomy query
	// 	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	// 		// Term string to array
	// 		$tax_term = explode( ',', $tax_term );
	// 		// Validate operator
	// 		if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
	// 		$tax_args = array( 'tax_query' => array( array(
	// 					'taxonomy' => $taxonomy,
	// 					'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
	// 					'terms' => $tax_term,
	// 					'operator' => $tax_operator ) ) );
	// 		// Check for multiple taxonomy queries
	// 		$count = 2;
	// 		$more_tax_queries = false;
	// 		while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
	// 			isset( $original_atts['tax_' . $count . '_term'] ) &&
	// 			!empty( $original_atts['tax_' . $count . '_term'] ) ) {
	// 			// Sanitize values
	// 			$more_tax_queries = true;
	// 			$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
	// 			$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
	// 			$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
	// 			'tax_' . $count . '_operator'] : 'IN';
	// 			$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
	// 			$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
	// 				'field' => 'slug',
	// 				'terms' => $terms,
	// 				'operator' => $tax_operator );
	// 			$count++;
	// 		}
	// 		if ( $more_tax_queries ):
	// 			$tax_relation = 'AND';
	// 		if ( isset( $original_atts['tax_relation'] ) &&
	// 			in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
	// 		) $tax_relation = $original_atts['tax_relation'];
	// 		$args['tax_query']['relation'] = $tax_relation;
	// 		endif;
	// 		$args = array_merge( $args, $tax_args );
	// 	}

	// 	// If post parent attribute, set up parent
	// 	if ( $post_parent ) {
	// 		if ( 'current' == $post_parent ) {
	// 			global $post;
	// 			$post_parent = $post->ID;
	// 		}
	// 		$args['post_parent'] = intval( $post_parent );
	// 	}
	// 	// Save original posts
	// 	global $posts;
	// 	$original_posts = $posts;
	// 	// Query posts
	// 	$posts = new WP_Query( $args );
	// 	// Buffer output
	// 	ob_start();
	// 	// Search for template in stylesheet directory
	// 	if ( file_exists( STYLESHEETPATH . '/' . $atts['template'] ) ) load_template( STYLESHEETPATH . '/' . $atts['template'], false );
	// 	// Search for template in theme directory
	// 	elseif ( file_exists( TEMPLATEPATH . '/' . $atts['template'] ) ) load_template( TEMPLATEPATH . '/' . $atts['template'], false );
	// 	// Search for template in plugin directory
	// 	elseif ( path_join( dirname( mom_su_PLUGIN_FILE ), $atts['template'] ) ) load_template( path_join( dirname( mom_su_PLUGIN_FILE ), $atts['template'] ), false );
	// 	// Template not found
	// 	else echo mom_su_Tools::error( __FUNCTION__, __( 'template not found', 'theme' ) );
	// 	$output = ob_get_contents();
	// 	ob_end_clean();
	// 	// Return original posts
	// 	$posts = $original_posts;
	// 	// Reset the query
	// 	wp_reset_postdata();
	// 	mom_su_query_asset( 'css', 'mom-su-other-shortcodes' );
	// 	return $output;
	// }

	// public static function dummy_text( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'amount' => 1,
	// 			'what'   => 'paras',
	// 			'cache'  => 'yes',
	// 			'class'  => ''
	// 		), $atts, 'dummy_text' );
	// 	$transient = 'mom_su/cache/dummy_text/' . sanitize_text_field( $atts['what'] ) . '/' . intval( $atts['amount'] );
	// 	$return = get_transient( $transient );
	// 	if ( $return && $atts['cache'] === 'yes' && mom_su_ENABLE_CACHE ) return $return;
	// 	else {
	// 		$xml = simplexml_load_file( 'http://www.lipsum.com/feed/xml?amount=' . $atts['amount'] . '&what=' . $atts['what'] . '&start=0' );
	// 		$return = '<div class="mom-su-dummy-text' . mom_su_ecssc( $atts ) . '">' . wpautop( str_replace( "\n", "\n\n", $xml->lipsum ) ) . '</div>';
	// 		set_transient( $transient, $return, 60*60*24*30 );
	// 		return $return;
	// 	}
	// }

	// public static function dummy_image( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'width'  => 500,
	// 			'height' => 300,
	// 			'theme'  => 'any',
	// 			'class'  => ''
	// 		), $atts, 'dummy_image' );
	// 	$url = 'http://lorempixel.com/' . $atts['width'] . '/' . $atts['height'] . '/';
	// 	if ( $atts['theme'] !== 'any' ) $url .= $atts['theme'] . '/' . rand( 0, 10 ) . '/';
	// 	return '<img src="' . $url . '" alt="' . __( 'Dummy image', 'theme' ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" class="mom-su-dummy-image' . mom_su_ecssc( $atts ) . '" />';
	// }

	// public static function animate( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'type'      => 'bounceIn',
	// 			'duration'  => 1,
	// 			'delay'     => 0,
	// 			'inline'    => 'no',
	// 			'class'     => ''
	// 		), $atts, 'animate' );
	// 	$tag = ( $atts['inline'] === 'yes' ) ? 'span' : 'div';
	// 	$time = '-webkit-animation-duration:' . $atts['duration'] . 's;-webkit-animation-delay:' . $atts['delay'] . 's;animation-duration:' . $atts['duration'] . 's;animation-delay:' . $atts['delay'] . 's;';
	// 	$return = '<' . $tag . ' class="mom-su-animate' . mom_su_ecssc( $atts ) . '" style="visibility:hidden;' . $time . '" data-animation="' . $atts['type'] . '" data-duration="' . $atts['duration'] . '" data-delay="' . $atts['delay'] . '">' . do_shortcode( $content ) . '</' . $tag . '>';
	// 	mom_su_query_asset( 'css', 'animate' );
	// 	mom_su_query_asset( 'js', 'jquery' );
	// 	mom_su_query_asset( 'js', 'inview' );
	// 	mom_su_query_asset( 'js', 'mom-su-other-shortcodes' );
	// 	return $return;
	// }

	// public static function meta( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'key'     => '',
	// 			'default' => '',
	// 			'before'  => '',
	// 			'after'   => '',
	// 			'post_id' => '',
	// 			'filter'  => ''
	// 		), $atts, 'meta' );
	// 	// Define current post ID
	// 	if ( !$atts['post_id'] ) $atts['post_id'] = get_the_ID();
	// 	// Check post ID
	// 	if ( !is_numeric( $atts['post_id'] ) || $atts['post_id'] < 1 ) return sprintf( '<p class="mom-su-error">Meta: %s</p>', __( 'post ID is incorrect', 'theme' ) );
	// 	// Check key name
	// 	if ( !$atts['key'] ) return sprintf( '<p class="mom-su-error">Meta: %s</p>', __( 'please specify meta key name', 'theme' ) );
	// 	// Get the meta
	// 	$meta = get_post_meta( $atts['post_id'], $atts['key'], true );
	// 	// Set default value if meta is empty
	// 	if ( !$meta ) $meta = $atts['default'];
	// 	// Apply cutom filter
	// 	if ( $atts['filter'] && function_exists( $atts['filter'] ) ) $meta = call_user_func( $atts['filter'], $meta );
	// 	// Return result
	// 	return ( $meta ) ? $atts['before'] . $meta . $atts['after'] : '';
	// }

	// public static function user( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'field'   => 'display_name',
	// 			'default' => '',
	// 			'before'  => '',
	// 			'after'   => '',
	// 			'user_id' => '',
	// 			'filter'  => ''
	// 		), $atts, 'user' );
	// 	// Check for password requests
	// 	if ( $atts['field'] === 'user_pass' ) return sprintf( '<p class="mom-su-error">User: %s</p>', __( 'password field is not allowed', 'theme' ) );
	// 	// Define current user ID
	// 	if ( !$atts['user_id'] ) $atts['user_id'] = get_current_user_id();
	// 	// Check user ID
	// 	if ( !is_numeric( $atts['user_id'] ) || $atts['user_id'] < 1 ) return sprintf( '<p class="mom-su-error">User: %s</p>', __( 'user ID is incorrect', 'theme' ) );
	// 	// Get user data
	// 	$user = get_user_by( 'id', $atts['user_id'] );
	// 	// Get user data if user was found
	// 	$user = ( $user && isset( $user->data->$atts['field'] ) ) ? $user->data->$atts['field'] : $atts['default'];
	// 	// Apply cutom filter
	// 	if ( $atts['filter'] && function_exists( $atts['filter'] ) ) $user = call_user_func( $atts['filter'], $user );
	// 	// Return result
	// 	return ( $user ) ? $atts['before'] . $user . $atts['after'] : '';
	// }

	// public static function post( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'field'   => 'post_title',
	// 			'default' => '',
	// 			'before'  => '',
	// 			'after'   => '',
	// 			'post_id' => '',
	// 			'filter'  => ''
	// 		), $atts, 'post' );
	// 	// Define current post ID
	// 	if ( !$atts['post_id'] ) $atts['post_id'] = get_the_ID();
	// 	// Check post ID
	// 	if ( !is_numeric( $atts['post_id'] ) || $atts['post_id'] < 1 ) return sprintf( '<p class="mom-su-error">Post: %s</p>', __( 'post ID is incorrect', 'theme' ) );
	// 	// Get the post
	// 	$post = get_post( $atts['post_id'] );
	// 	// Set default value if meta is empty
	// 	$post = ( empty( $post ) || empty( $post->$atts['field'] ) ) ? $atts['default'] : $post->$atts['field'];
	// 	// Apply cutom filter
	// 	if ( $atts['filter'] && function_exists( $atts['filter'] ) ) $post = call_user_func( $atts['filter'], $post );
	// 	// Return result
	// 	return ( $post ) ? $atts['before'] . $post . $atts['after'] : '';
	// }

	// public static function post_terms( $atts = null, $content = null ) {
	//  $atts = shortcode_atts( array(
	//    'post_id'  => '',
	//    'taxonomy' => 'category',
	//    'limit'    => '5',
	//    'links'    => '',
	//    'format'   => ''
	//   ), $atts, 'post_terms' );
	//  // Define current post ID
	//  if ( !$atts['post_id'] ) $atts['post_id'] = get_the_ID();
	//  // Check post ID
	//  if ( !is_numeric( $atts['post_id'] ) || $atts['post_id'] < 1 ) return sprintf( '<p class="mom-su-error">Post terms: %s</p>', __( 'post ID is incorrect', 'theme' ) );
	// }

	// public static function template( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'name' => ''
	// 		), $atts, 'template' );
	// 	// Check template name
	// 	if ( !$atts['name'] ) return sprintf( '<p class="mom-su-error">Template: %s</p>', __( 'please specify template name', 'theme' ) );
	// 	// Get template output
	// 	ob_start();
	// 	get_template_part( str_replace( '.php', '', $atts['name'] ) );
	// 	$output = ob_get_contents();
	// 	ob_end_clean();
	// 	// Return result
	// 	return $output;
	// }

	// public static function qrcode( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'data' => '',
	// 			'title' => '',
	// 			'size' => 200,
	// 			'margin' => 0,
	// 			'align' => 'none',
	// 			'link' => '',
	// 			'target' => 'blank',
	// 			'color' => '#000000',
	// 			'background' => '#ffffff',
	// 			'class' => ''
	// 		), $atts, 'qrcode' );
	// 	// Check the data
	// 	if ( !$atts['data'] ) return 'QR code: ' . __( 'please specify the data', 'theme' );
	// 	// Prepare link
	// 	$href = ( $atts['link'] ) ? ' href="' . $atts['link'] . '"' : '';
	// 	// Prepare clickable class
	// 	if ( $atts['link'] ) $atts['class'] .= ' mom-su-qrcode-clickable';
	// 	// Prepare title
	// 	$atts['title'] = esc_attr( $atts['title'] );
	// 	// Query assets
	// 	mom_su_query_asset( 'css', 'mom-su-content-shortcodes' );
	// 	// Return result
	// 	return '<span class="mom-su-qrcode mom-su-qrcode-align-' . $atts['align'] . mom_su_ecssc( $atts ) . '"><a' . $href . ' target="_' . $atts['target'] . '" title="' . $atts['title'] . '"><img src="https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode( $atts['data'] ) . '&size=' . $atts['size'] . 'x' . $atts['size'] . '&format=png&margin=' . $atts['margin'] . '&color=' . mom_su_hex2rgb( $atts['color'] ) . '&bgcolor=' . mom_su_hex2rgb( $atts['background'] ) . '" alt="' . $atts['title'] . '" /></a></span>';
	// }

	// public static function scheduler( $atts = null, $content = null ) {
	// 	$atts = shortcode_atts( array(
	// 			'time'       => 'all',
	// 			'days_week'  => 'all',
	// 			'days_month' => 'all',
	// 			'months'     => 'all',
	// 			'years'      => 'all',
	// 			'alt'        => ''
	// 		), $atts, 'scheduler' );
	// 	// Check time
	// 	if ( $atts['time'] !== 'all' ) {
	// 		// Get current time
	// 		$now = current_time( 'timestamp', 0 );
	// 		// Sanitize
	// 		$atts['time'] = preg_replace( "/[^0-9-,:]/", '', $atts['time'] );
	// 		// Loop time ranges
	// 		foreach( explode( ',', $atts['time'] ) as $range ) {
	// 			// Check for range symbol
	// 			if ( strpos( $range, '-' ) === false ) return mom_su_Tools::error( __FUNCTION__, sprintf( __( 'Incorrect time range (%s). Please use - (minus) symbol to specify time range. Example: 14:00 - 18:00', 'theme' ), $range ) );
	// 			// Split begin/end time
	// 			$time = explode( '-', $range );
	// 			// Add minutes
	// 			if ( strpos( $time[0], ':' ) === false ) $time[0] .= ':00';
	// 			if ( strpos( $time[1], ':' ) === false ) $time[1] .= ':00';
	// 			// Parse begin/end time
	// 			$time[0] = strtotime( $time[0] );
	// 			$time[1] = strtotime( $time[1] );
	// 			// Check time
	// 			if ( $now < $time[0] || $now > $time[1] ) return $atts['alt'];
	// 		}
	// 	}
	// 	// Check day of the week
	// 	if ( $atts['days_week'] !== 'all' ) {
	// 		// Get current day of the week
	// 		$today = date( 'w', current_time( 'timestamp', 0 ) );
	// 		// Sanitize input
	// 		$atts['days_week'] = preg_replace( "/[^0-9-,]/", '', $atts['days_week'] );
	// 		// Parse days range
	// 		$days = mom_su_Tools::range( $atts['days_week'] );
	// 		// Check current day
	// 		if ( !in_array( $today, $days ) ) return $atts['alt'];
	// 	}
	// 	// Check day of the month
	// 	if ( $atts['days_month'] !== 'all' ) {
	// 		// Get current day of the month
	// 		$today = date( 'j', current_time( 'timestamp', 0 ) );
	// 		// Sanitize input
	// 		$atts['days_month'] = preg_replace( "/[^0-9-,]/", '', $atts['days_month'] );
	// 		// Parse days range
	// 		$days = mom_su_Tools::range( $atts['days_month'] );
	// 		// Check current day
	// 		if ( !in_array( $today, $days ) ) return $atts['alt'];
	// 	}
	// 	// Check month
	// 	if ( $atts['months'] !== 'all' ) {
	// 		// Get current month
	// 		$now = date( 'n', current_time( 'timestamp', 0 ) );
	// 		// Sanitize input
	// 		$atts['months'] = preg_replace( "/[^0-9-,]/", '', $atts['months'] );
	// 		// Parse months range
	// 		$months = mom_su_Tools::range( $atts['months'] );
	// 		// Check current month
	// 		if ( !in_array( $now, $months ) ) return $atts['alt'];
	// 	}
	// 	// Check year
	// 	if ( $atts['years'] !== 'all' ) {
	// 		// Get current year
	// 		$now = date( 'Y', current_time( 'timestamp', 0 ) );
	// 		// Sanitize input
	// 		$atts['years'] = preg_replace( "/[^0-9-,]/", '', $atts['years'] );
	// 		// Parse years range
	// 		$years = mom_su_Tools::range( $atts['years'] );
	// 		// Check current year
	// 		if ( !in_array( $now, $years ) ) return $atts['alt'];
	// 	}
	// 	// Return result (all check passed)
	// 	return do_shortcode( $content );
	// }

}

new mom_su_Shortcodes;

class mom_shortcodes_ultimate_Shortcodes extends mom_su_Shortcodes {
	function __construct() {
		parent::__construct();
	}
}
