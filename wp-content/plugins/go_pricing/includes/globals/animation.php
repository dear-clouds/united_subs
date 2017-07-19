<?php
/**
 * Register Globals - Column Animations
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


/**
 * Column Transitions
 */	

$go_pricing['column-transition'] = array (
	array(
		'name' => __( 'None', 'go_pricing_textdomain' ),
		'value' => ''
	),
	
	// Fade In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Fade', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Fade In', 'go_pricing_textdomain' ),
				'value' => 'fade_in', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' => __( 'Fade Zoom In', 'go_pricing_textdomain' ), 
				'value' => 'fade_zoom_in', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"40","scaleY":"40"}'
			),
			array(
				'name' => __( 'Fade Zoom Out', 'go_pricing_textdomain' ),
				'value' => 'fade_zoom_out', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"140","scaleY":"140"}'
			),			
		
		)
	),
	
	// Slide In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Slide In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Slide in Left', 'go_pricing_textdomain' ),
				'value' => 'slide_in_left', 
				'data' => '{"transformOrigin":"right center","x":"200","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),					
			array(
				'name' =>  __( 'Slide In Right', 'go_pricing_textdomain' ),
				'value' => 'slide_in_right', 
				'data' => '{"transformOrigin":"right center","x":"-200","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Slide In Up', 'go_pricing_textdomain' ),
				'value' => 'slide_in_up', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"200","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Slide In Down', 'go_pricing_textdomain' ),
				'value' => 'slide_in_down', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"-200","opacity":"0","rotation":"0","rotationX":"0","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),				
		)
	),
	
	// Slide Skew In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Slide Skew In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Slide Skew In Left', 'go_pricing_textdomain' ),
				'value' => 'slide_skew_in_left', 
				'data' => '{"transformOrigin":"center center","x":"500","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"5","skewX":"-5","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Slide Skew In Right', 'go_pricing_textdomain' ),
				'value' => 'slide_skew_in_right', 
				'data' => '{"transformOrigin":"center center","x":"-500","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"5","skewX":"-5","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Slide Skew In Down', 'go_pricing_textdomain' ),
				'value' => 'slide_skew_in_down', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"-200","opacity":"0","rotation":"0","rotationX":"5","rotationY":"0","skewX":"0","skewY":"-5","scaleX":"100","scaleY":"100"}'
			),		
			
			array(
				'name' =>  __( 'Slide Skew In Up', 'go_pricing_textdomain' ),
				'value' => 'slide_skew_in_up', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"200","opacity":"0","rotation":"0","rotationX":"5","rotationY":"0","skewX":"0","skewY":"-5","scaleX":"100","scaleY":"100"}'
			),					
		)
	),			
	
	// Flip In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Flip In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Flip In Left', 'go_pricing_textdomain' ),
				'value' => 'flip_in_left', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Flip In Right', 'go_pricing_textdomain' ),
				'value' => 'flip_in_right', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Flip In Left Up', 'go_pricing_textdomain' ),
				'value' => 'flip_in_left_up', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"100","opacity":"0","rotation":"0","rotationX":"0","rotationY":"180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Flip In Right Up', 'go_pricing_textdomain' ),
				'value' => 'flip_in_right_up', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"100","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),			
			array(
				'name' =>  __( 'Flip In Left Down', 'go_pricing_textdomain' ),
				'value' => 'flip_in_left_down', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"-100","opacity":"0","rotation":"0","rotationX":"0","rotationY":"180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Flip In Right Down', 'go_pricing_textdomain' ),
				'value' => 'flip_in_right_down', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"-100","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-180","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),			
		
		)
	),
	
	// Rotate In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Rotate In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Rotate In Left Top', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_left_top', 
				'data' => '{"transformOrigin":"center -200%","x":"0","y":"0","opacity":"0","rotation":"20","rotationX":"0","rotationY":"-45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Rotate In Right Top', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_right_top', 
				'data' => '{"transformOrigin":"center -200%","x":"0","y":"0","opacity":"0","rotation":"-20","rotationX":"0","rotationY":"45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),		
			array(
				'name' =>  __( 'Rotate In Left Bottom', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_left_bottom', 
				'data' => '{"transformOrigin":"center 200%","x":"0","y":"0","opacity":"0","rotation":"20","rotationX":"0","rotationY":"-45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Rotate In Right Bottom', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_right_bottom', 
				'data' => '{"transformOrigin":"center 200%","x":"0","y":"0","opacity":"0","rotation":"-20","rotationX":"0","rotationY":"45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Rotate In Left Top Big', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_left_top_big', 
				'data' => '{"transformOrigin":"center -200%","x":"0","y":"0","opacity":"0","rotation":"90","rotationX":"0","rotationY":"-45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),	
			array(
				'name' =>  __( 'Rotate In Right Top Big', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_right_top_big', 
				'data' => '{"transformOrigin":"center -200%","x":"0","y":"0","opacity":"0","rotation":"-90","rotationX":"0","rotationY":"45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Rotate In Left Bottom Big', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_left_bottom_big', 
				'data' => '{"transformOrigin":"center 200%","x":"0","y":"0","opacity":"0","rotation":"90","rotationX":"0","rotationY":"-45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),			
			array(
				'name' =>  __( 'Rotate In Right Bottom Big', 'go_pricing_textdomain' ),
				'value' => 'rotate_in_right_bottom_big', 
				'data' => '{"transformOrigin":"center 200%","x":"0","y":"0","opacity":"0","rotation":"-90","rotationX":"0","rotationY":"45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),								
		)
	),	

	// Tilt In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Tilt In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Tilt In Up', 'go_pricing_textdomain' ),
				'value' => 'tilt_in_up', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"200","opacity":"0","rotation":"0","rotationX":"-45","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Tilt In Down', 'go_pricing_textdomain' ),
				'value' => 'tilt_in_down', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"-200","opacity":"0","rotation":"0","rotationX":"45","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Tilt In Right', 'go_pricing_textdomain' ),
				'value' => 'tilt_in_right', 
				'data' => '{"transformOrigin":"center center","x":"-200","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Tilt In Left', 'go_pricing_textdomain' ),
				'value' => 'tilt_in_left', 
				'data' => '{"transformOrigin":"center center","x":"200","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"45","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),		
		)
	),
	
	// Turn In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Turn In', 'go_pricing_textdomain' ) ),
		'group_data' => array(
			array(
				'name' =>  __( 'Turn in Bottom', 'go_pricing_textdomain' ),
				'value' => 'turn_in_bottom', 
				'data' => '{"transformOrigin":"center bottom","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"90","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),	
		
			array(
				'name' =>  __( 'Turn in Top', 'go_pricing_textdomain' ),
				'value' => 'turn_in_top', 
				'data' => '{"transformOrigin":"center top","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"-90","rotationY":"0","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),	
			
			array(
				'name' =>  __( 'Turn in Left', 'go_pricing_textdomain' ),
				'value' => 'turn_in_left', 
				'data' => '{"transformOrigin":"left top","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"90","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			
			array(
				'name' =>  __( 'Turn in Left Out', 'go_pricing_textdomain' ),
				'value' => 'turn_in_left_out', 
				'data' => '{"transformOrigin":"left top","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-90","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),	
			
			array(
				'name' =>  __( 'Turn in Right', 'go_pricing_textdomain' ),
				'value' => 'turn_in_right', 
				'data' => '{"transformOrigin":"right top","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"-90","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),	
			
			array(
				'name' =>  __( 'Turn in Right Out', 'go_pricing_textdomain' ),
				'value' => 'turn_in_right_out', 
				'data' => '{"transformOrigin":"right top","x":"0","y":"0","opacity":"0","rotation":"0","rotationX":"0","rotationY":"90","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			)	
		)
		
	),	
	
	// Billboard In
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Billboard In', 'go_pricing_textdomain' ) ),		
		'group_data' => array(
			array(
				'name' =>  __( 'Billboard In Left', 'go_pricing_textdomain' ),
				'value' => 'billboard_in_left', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"-15","rotationX":"15","rotationY":"75","skewX":"0","skewY":"10","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Billboard In Right', 'go_pricing_textdomain' ),
				'value' => 'billboard_in_right', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"0","rotation":"15","rotationX":"15","rotationY":"-75","skewX":"0","skewY":"-10","scaleX":"100","scaleY":"100"}'
			),
		)
	),
		
	// Spin
	
	array(
		'group_name' => sprintf( '-- %s --', __( 'Spin', 'go_pricing_textdomain' ) ),		
		'group_data' => array(
			array(
				'name' =>  __( 'Spin Left', 'go_pricing_textdomain' ),
				'value' => 'spin_left', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"100","rotation":"0","rotationX":"0","rotationY":"360","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),
			array(
				'name' =>  __( 'Spin Right', 'go_pricing_textdomain' ),
				'value' => 'spin_right', 
				'data' => '{"transformOrigin":"center center","x":"0","y":"0","opacity":"100","rotation":"0","rotationX":"0","rotationY":"-360","skewX":"0","skewY":"0","scaleX":"100","scaleY":"100"}'
			),				
		
		)
	)

);


// Global Column Animation Filter
$go_pricing['column-transition'] = apply_filters( 'go_pricing_column_transition', $go_pricing['column-transition'] );


/**
 * Easings
 */	


$go_pricing['easing'] = array (
	array(
		'name' => __( 'Power0 linear', 'go_pricing_textdomain' ),
		'value' => 'easeNoneLinear'
	),
	array(
		'name' => __( 'Power1 easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInQuad'
	),
	array(
		'name' => __( 'Power1 easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutQuad'
	),
	array(
		'name' => __( 'Power1 easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutQuad'
	),
	array(
		'name' => __( 'Power2 easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInCubic'
	),
	array(
		'name' => __( 'Power2 easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutCubic'
	),
	array(
		'name' => __( 'Power2 easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutCubic'
	),
	array(
		'name' => __( 'Power3 easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInQuart'
	),
	array(
		'name' => __( 'Power3 easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutQuart'
	),
	array(
		'name' => __( 'Power3 easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutQuart'
	),
	array(
		'name' => __( 'Power4 easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInQuint'
	),
	array(
		'name' => __( 'Power4 easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutQuint'
	),
	array(
		'name' => __( 'Power4 easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutQuint'
	),
	array(
		'name' => __( 'Sine easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInSine'
	),
	array(
		'name' => __( 'Sine easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutSine'
	),
	array(
		'name' => __( 'Sine easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutSine'
	),
	array(
		'name' => __( 'Expo easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInExpo'
	),
	array(
		'name' => __( 'Expo easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutExpo'
	),
	array(
		'name' => __( 'Expo easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutExpo'
	),
	array(
		'name' => __( 'Circ easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInCirc'
	),
	array(
		'name' => __( 'Circ easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutCirc'
	),
	array(
		'name' => __( 'Circ easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutCirc'
	),
	array(
		'name' => __( 'Elastic easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInElastic'
	),
	array(
		'name' => __( 'Elastic easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutElastic'
	),
	array(
		'name' => __( 'Elastic easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutElastic'
	),
	array(
		'name' => __( 'Back easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInBack'
	),
	array(
		'name' => __( 'Back easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutBack'
	),
	array(
		'name' => __( 'Back easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutBack'
	),
	array(
		'name' => __( 'Bounce easeIn', 'go_pricing_textdomain' ),
		'value' => 'easeInBounce'
	),
	array(
		'name' => __( 'Bounce easeOut', 'go_pricing_textdomain' ),
		'value' => 'easeOutBounce'
	),
	array(
		'name' => __( 'Bounce easeInOut', 'go_pricing_textdomain' ),
		'value' => 'easeInOutBounce'
	)
);

// Global Column Animation Easing Filter
$go_pricing['easing'] = apply_filters( 'go_pricing_easing', $go_pricing['easing'] );
?>