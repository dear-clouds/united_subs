<?php
/**
 * Register Globals - Styles
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


/**
 * Styles
 */	

$go_pricing['styles'] = array ( 
	array( 
		'name' => __( 'Clean (new)', 'go_pricing_textdomain' ),
		'id' => 'clean'
	),
	array( 
		'name' => __( 'Classic', 'go_pricing_textdomain' ),
		'id' => 'classic'
	)					
);

// Style filter
$go_pricing['styles'] = apply_filters( 'go_pricing_styles', $go_pricing['styles'] );


/**
 * Colum style types
 */	

// Classic styles (Blue, Green, Red, Puple, Yellow & Earth)
$go_pricing['style_types']['classic'] = array (						
	array(
		'group_name' => __( 'Blue', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	

			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'blue7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'blue8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'blue9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'blue10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'blue12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'blue13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'blue14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Blue', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'blue15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_blue_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-blue',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_blue.css'
				)					
			),																																																
		)												
	),
	array(
		'group_name' => __( 'Green', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'green7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'green8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'green9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'green10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'green12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'green13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'green14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Green', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'green15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_green_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-green',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_green.css'
				)	
			),																																																
		)												
	),
	array(
		'group_name' => __( 'Red', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'

				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'red7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'red8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'red9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'red10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'red12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'red13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'red14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Red', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'red15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_red_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-red',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_red.css'
				)	
			),																																																
		)												
	),
	array(
		'group_name' => __( 'Purple', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'purple7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'purple8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'purple9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'purple10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'purple12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'purple13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'purple14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Purple', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'purple15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_purple_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-purple',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_purple.css'
				)	
			),																																																
		)												
	),
	array(
		'group_name' => __( 'Yellow', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(

				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Yellow', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'yellow15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_yellow_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-yellow',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_yellow.css'
				)	
			),																																																
		)												
	),
	array(
		'group_name' => __( 'Earth', 'go_pricing_textdomain' ),
		'group_data' => array(
			array(
				'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth1', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_01.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth2', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_02.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3a (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth3a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3b (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth3b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3c (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth3c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 3d (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth3d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_03.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4a (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth4a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4b (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth4b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4c (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth4c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 4d (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth4d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_04.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth5', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_05.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth6', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_06.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'earth7', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_07.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'earth8', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_08.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'earth9', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_09.jpg',
				'type' => 'pricing2',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
				'value' => 'earth10', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_10.jpg',
				'type' => 'pricing3',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11a (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth11a', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11b (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth11b', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11c (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth11c', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 11d (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth11d', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_11.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),																																																																										
			array(
				'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
				'value' => 'earth12', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_12.jpg',
				'type' => 'team',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)					
			),
			array(
				'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
				'value' => 'earth13', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_13.jpg',
				'type' => 'product',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)				
			),
			array(
				'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
				'value' => 'earth14', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_14.jpg',
				'type' => 'pricing',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),
			array(
				'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Earth', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
				'value' => 'earth15', 
				'data' => $this->plugin_url . 'assets/admin/images/thumbnails/classic/classic_earth_15.jpg',
				'type' => 'html',
				'css' => array(
					'handle' => 'skin-earth',
					'url' => $this->plugin_url . 'assets/css/go_pricing_skin_earth.css'
				)	
			),																																																
		)												
	)																																					
);

// Clean styles
$go_pricing['style_types']['clean'] = array (						
	array(
		'name' => sprintf( __( '%1$s 1 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style1', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_01.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 2 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style2', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_02.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 3 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style3', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_03.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 4 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style4', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_04.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 5 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style5', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_05.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 6 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style6', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_06.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 7 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style7', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_07.png',
		'type' => 'chtml'
	),
	array(
		'name' => sprintf( __( '%1$s 8 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style8', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_08.png',
		'type' => 'chtml'
	),
	array(
		'name' => sprintf( __( '%1$s 9 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing & HTML header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style9', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_09.png',
		'type' => 'cpricing2'
	),
	array(
		'name' => sprintf( __( '%1$s 10 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing & image header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style10', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_10.png',
		'type' => 'cpricing3'
	),																																																																				
	array(
		'name' => sprintf( __( '%1$s 12 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'team header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style12', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_12.png',
		'type' => 'cteam'
	),
	array(
		'name' => sprintf( __( '%1$s 13 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'product header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style13', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_13.png',
		'type' => 'cproduct'
	),
	array(
		'name' => sprintf( __( '%1$s 14 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'pricing header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style14', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_14.png',
		'type' => 'cpricing'
	),
	array(
		'name' => sprintf( __( '%1$s 15 (%2$s)', 'go_pricing_textdomain' ),  __( 'Style', 'go_pricing_textdomain' ),  __( 'HTML header', 'go_pricing_textdomain' ) ),
		'value' => 'clean-style15', 
		'data' => $this->plugin_url . 'assets/admin/images/thumbnails/clean/clean_15.png',
		'type' => 'chtml'
	)																																																																			
);			

// Global filter
$go_pricing['style_types'] = apply_filters( 'go_pricing_style_types', $go_pricing['style_types'] );

// Column style types filter
foreach ( (array)$go_pricing['style_types'] as $style_type => $style_data ) {
	$go_pricing['style_types'][$style_type] = apply_filters( "go_pricing_style_type_{$style_type}", $style_data );
}


?>