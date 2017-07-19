<?php
/**
 * Register Globals - Fonts
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


/**
 * Fonts
 */	


// Standard fonts
$go_pricing['fonts'] = array (
	array(
		'name' => __( 'Default / Inherit', 'go_pricing_textdomain' ),
		'value' => ''
	),	
	array(
		'group_name' => __( 'Standard Fonts', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => 'Arial, Helvetica, sans-serif',
				'value' => 'Arial, Helvetica, sans-serif'
			),
			array(
				'name' => 'Arial Black, Gadget, sans-serif',
				'value' => '\'Arial Black\', Gadget, sans-serif'
			),
			array(
				'name' => 'Comic Sans MS, cursive, sans-serif',
				'value' => '\'Comic Sans MS\', cursive, sans-serif'
			),
			array(
				'name' => 'Courier New, Courier, monospace',
				'value' => '\'Courier New\', Courier, monospace'
			),
			array(
				'name' => 'Impact, Charcoal, sans-serif',
				'value' => 'Impact, Charcoal, sans-serif'
			),
			array(
				'name' => 'Georgia, serif',
				'value' => 'Georgia, serif'
			),
			array(
				'name' => 'Lucida Console, Monaco, monospace',	
				'value' => '\'Lucida Console\', Monaco, monospace'
			),
			array(
				'name' => 'Lucida Sans Unicode, Lucida Grande, sans-serif',
				'value' => 'Arial, Helvetica, sans-serif'
			),
			array(
				'name' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
				'value' => '\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif'
			),
			array(
				'name' => 'Times New Roman, Times, serif',
				'value' => '\'Times New Roman\', Times, serif'
			),
			array(
				'name' => 'Trebuchet MS, Helvetica, sans-serif',
				'value' => '\'Trebuchet MS\', Helvetica, sans-serif'
			),
			array(
				'name' => 'Verdana, Geneva, sans-serif',
				'value' => 'Verdana, Geneva, sans-serif'
			)																						
		)												
	)
												
);


// Google fonts
$google_fonts_filecontent = @file_get_contents( $this->plugin_path . 'assets/data/google_fonts.json' );
$google_fonts_json = $google_fonts_filecontent !== false ? json_decode( $google_fonts_filecontent ) : null;

if ( !empty( $google_fonts_json->items ) ) {
	foreach ( (array)$google_fonts_json->items as $google_font) {
		if ( !empty( $google_font->category ) && !empty( $google_font->family ) ) {

			switch( $google_font->category ) {
				case 'display' :
				case 'handwriting' :
					$google_font->category = 'cursive';
					break;
			}
		
			$go_pricing['google-fonts'][] = array (
				'name' => $google_font->family,
				'value' => sprintf( '%1$s, %2$s', $google_font->family, $google_font->category),
				'url' => sprintf( '//fonts.googleapis.com/css?family=%s', preg_replace('/\s/', '+', $google_font->family) )
			);
		
		}
	}
}

// Google font filter
$go_pricing['google-fonts'] = apply_filters( 'go_pricing_google_fonts', $go_pricing['google-fonts'] );

if ( !empty( $go_pricing['google-fonts'] ) ) {
	$go_pricing['fonts'][] =	array(
		'group_name' => __( 'Google Fonts', 'go_pricing_textdomain' ),
		'group_data' => $go_pricing['google-fonts']
	);
}


// Global font filter
$go_pricing['fonts'] = apply_filters( 'go_pricing_fonts', $go_pricing['fonts'] );

?>