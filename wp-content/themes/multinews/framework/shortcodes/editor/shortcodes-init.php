<?php
/*=========================================================
*		Shortcodes
========================================================= */
add_filter( 'mom_su/data/shortcodes', 'mom_register_my_custom_shortcode' );
function mom_register_my_custom_shortcode( $shortcodes ) {
		$imgs = MOM_URI . '/framework/shortcodes/images/';
		/*=========================================================
		*		Ads
		========================================================= */
		$ads = get_posts('post_type=ads&posts_per_page=-1');
		$get_ads = array();
		foreach ($ads as $ad) {
		    $get_ads[$ad->ID] = esc_attr($ad->post_title);
		}
		/*=========================================================
		*		Animations
		========================================================= */
		$animation = array( '', 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' );
		/*=========================================================
		*		Shortcodes
		========================================================= */
		// accordion
		$shortcodes['accordions'] = array(
		'name' => __( 'Accordion Wrap', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'type' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Accordion', 'framework' ),
								'toggle' => __( 'Toggle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Type', 'framework' ),
				'desc' => __( 'accordion or toggle', 'framework' )
			),
			'handle' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'arrows' => __( 'Arrows', 'framework' ),
								'numbers' => __( 'Numbers', 'framework' ),
								'pm' => __( 'Plus & Minus', 'framework' )
							),
				'default' => '',
				'name' => __( 'Handle', 'framework' ),
				'desc' => __( 'the icon on the left', 'framework' )
			),
			'space' => array(
				'type' => 'bool',
				'default' => 'no',
				'name' => __( 'Space', 'framework' ),
				'desc' => __( 'small space between the accordions titles for nicer design', 'framework' )
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' )
			),
			'icon_current_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Current Icon Color', 'framework' )
			),
		),
		'content' => __( "[accordion title=\"Title 1\" icon=\"\" state=\"yes\"]Content 1[/accordion]\n[accordion title=\"Title 2\" icon=\"\" state=\"no\"]Content 2[/accordion]\n[accordion title=\"Title 3\" icon=\"\" state=\"no\"]Content 3[/accordion]", 'framework' ),
		'desc' => __( 'Accordion wrap add accordions inside this wrap', 'framework' ),
		'icon' => 'th-list'
	);
	$shortcodes['accordion'] = array(
		'name' => __( 'Accordion', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'title' => array(
				'type' => 'text',
				'default' => 'Title',
				'name' => __( 'Title', 'framework' )
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
			'state' => array(
				'type' => 'select',
				'values' => array(
								'close' => __( 'Close', 'framework' ),
								'open' => __( 'Open', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Accordion State', 'framework' ),
			),
		),
		'content' => __( "Accordion Content", 'framework' ),
		'desc' => __( 'Add accordion to accordion wrap', 'framework' ),
		'icon' => 'reorder'
	);
		// ads
		$shortcodes['ad'] = array(
		'name' => __( 'Ads', 'framework' ),
		'type' => 'single',
		'group' => 'content',
		'atts' => array(
			'id' => array(
				'type' => 'select',
				'values' => array('') +$get_ads,
				'default' => '',
				'name' => __( 'Select Ad', 'framework' ),
				'desc' => __( 'Choose Ad banner From ads system', 'framework' )
			),
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'Ad banner', 'framework' ),
		'icon' => 'eye'
	);
		// anchor
		$shortcodes['incor'] = array(
		'name' => __( 'Anchor', 'framework' ),
		'type' => 'single',
		'group' => 'content',
		'atts' => array(
			'name' => array(
				'default' => '',
				'name' => __( 'ID Name', 'framework' ),
				'desc' => __( 'Enter id name to add to it to story highlights', 'framework' )
			)
		),
		'desc' => __( 'Anchor shortcode to insert story highlights in posts', 'framework' ),
		'icon' => 'anchor'
	);
		// animation 
		$shortcodes['animate'] = array(
		'name' => __( 'Animation', 'framework' ),
		'type' => 'wrap',
		'group' => 'other',
		'atts' => array(
			'animation' => array(
				'type' => 'select',
				'values' => array_combine( $animation, $animation ),
				'default' => '',
				'name' => __( 'Animation', 'framework' ),
				'desc' => __( 'Select animation type', 'framework' )
			),
			'duration' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 0.5,
				'default' => 1,
				'name' => __( 'Duration', 'framework' ),
				'desc' => __( 'Animation duration (seconds)', 'framework' )
			),
			'delay' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 0.5,
				'default' => 0,
				'name' => __( 'Delay', 'framework' ),
				'desc' => __( 'Animation delay (seconds)', 'framework' )
			),
			'iteration' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Iteration Count', 'framework' ),
				'desc' => __( 'number of animation times -1 for non stop animation', 'framework' )
			),
		),
		'content' => "",
		'desc' => __( 'Animate shortcode', 'framework' ),
		'icon' => 'magic'
	);
		// Blog 
		$shortcodes['blog'] = array(
		'name' => __( 'Blog', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'style' => array(  //image field here \\\\\\\\\\\\
				'type' => 'select',
				'values' => array(
								'def' => __( 'Default style', 'framework' ),
								'larg' => __( 'Full width Style', 'framework' ),
								'grid' => __( 'Cetgory View', 'framework' )
							),
				'default' => '',
				'name' => __( 'Style', 'framework' ),
			),

			'cols' => array(  //image field here \\\\\\\\\\\\
				'type' => 'select',
				'values' => array(
								2 => __( '2 Columns', 'framework' ),
								3 => __( '3 Columns', 'framework' ),
							),
				'default' => '',
				'required'  => array('style', '=', 'grid'),
				'name' => __( 'Grid Columns', 'framework' ),
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Latest posts', 'framework' ),
								'category' => __( 'Category', 'framework' ),
								'tag' => __( 'Tag', 'framework' ),
								'specific' => __( 'Specific Posts ids', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'category' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'category')
			),
			'tag' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tag')
			),
			'specific' => array(
				'default' => '',
				'name' => __( 'Posts ids', 'framework' ),
				'desc' => __( 'multiple post id separated by comma', 'framework' ),
				'required'  => array('display', '=', 'specific')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'posts_per_page' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Posts Per Page', 'framework' ),
			),
			'offset' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'desc' => __( 'number of post to displace or pass over', 'framework' ),
				'name' => __( 'Offset posts', 'framework' ),
			),
			'nexcerpt' => array(
				'default' => '',
				'name' => __( 'excerpt length', 'framework' ),
				'desc' => __( 'post excerpt length in characters leave empty for default values', 'framework' ),
			),
			'pagination' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Pagination', 'framework' ),
			),

			'ad_id' => array(
				'type' => 'select',
				'values' => array('') +$get_ads,
				'default' => '',
				'name' => __( 'Select Ad', 'framework' ),
			),

			'ad_count' => array(
				'default' => '3',
				'name' => __("Display after x posts", 'theme'),
				'desc' => __('the number of posts to display ads after it. default is 3', 'theme')
			),

			'ad_repeat' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Repeat ad', 'framework' ),
			),			

			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'Add Blog List or blog posts', 'framework' ),
		'icon' => 'newspaper-o'
	);
		// Box 
		$shortcodes['box'] = array(
		'name' => __( 'Box', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'type' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Default', 'framework' ),
								'info' => __( 'Info', 'framework' ),
								'note' => __( 'Note', 'framework' ),
								'error' => __( 'Error', 'framework' ),
								'tip' => __( 'Tip', 'framework' ),
								'custom' => __( 'Custom', 'framework' )
							),
				'default' => '',
				'name' => __( 'Type', 'framework' ),
				'desc' => __( 'Select one or create your custom', 'framework' )
			),
			'bgimg' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Background Image', 'framework' ),
				'desc' => __( 'Upload Background image', 'framework' ),
				'required'  => array('type', '=', 'custom')
			),
			'bg' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' ),
				'required'  => array('type', '=', 'custom')
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' ),
				'required'  => array('type', '=', 'custom')
			),
			'border' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' ),
				'required'  => array('type', '=', 'custom')
			),
			'radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Radius', 'framework' ),
				'desc' => __( 'insert box border radius number eg. 10', 'framework' )
			),
			'fontsize' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Font Size', 'framework' ),
				'desc' => __( 'insert a font size as a number eg. 14', 'framework' )
			),
		),
		'content' => __( "Box Content", 'framework' ),
		'desc' => __( 'Box shortcode', 'framework' ),
		'icon' => 'list-alt'
	);
		// Button  
		$shortcodes['button'] = array(
		'name' => __( 'Button', 'framework' ),
		'type' => 'wrap',
		'group' => 'content',
		'atts' => array(
			'color' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Default', 'framework' ),
								'yellow' => __( 'Yellow', 'framework' ),
								'orange' => __( 'Orange', 'framework' ),
								'orange2' => __( 'Orange2', 'framework' ),
								'red' => __( 'Red', 'framework' ),
								'brown' => __( 'Brown', 'framework' ),
								'pink' => __( 'Pink', 'framework' ),
								'purple' => __( 'Purple', 'framework' ),
								'green2' => __( 'Dark Green', 'framework' ),
								'green' => __( 'Green', 'framework' ),
								'blue' => __( 'Blue', 'framework' ),
								'blue2' => __( 'Dark Blue', 'framework' ),
								'gray2' => __( 'Dark Gray', 'framework' ),
								'gray' => __( 'Gray', 'framework' ),
								'custom' => __( 'Custom', 'framework' )
							),
				'default' => '',
				'name' => __( 'Button color', 'framework' ),
				'desc' => __( 'Select one or make your own', 'framework' )
			),
			'bgcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'hoverbg' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Hover Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'textcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'texthcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Hover Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'bordercolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'hoverborder' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Hover Color', 'framework' ),
				'required'  => array('color', '=', 'custom')
			),
			'size' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Medium', 'framework' ),
								'big' => __( 'Big', 'framework' ),
								'bigger' => __( 'Bigger', 'framework' )
							),
				'default' => '',
				'name' => __( 'Size', 'framework' ),
				'desc' => __( 'select from medium or big', 'framework' )
			),
			'align' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Left', 'framework' ),
								'right' => __( 'Right', 'framework' ),
								'center' => __( 'Center', 'framework' )
							),
				'default' => '',
				'name' => __( 'Align', 'framework' ),
				'desc' => __( 'right,left and center', 'framework' )
			),
			'width' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Fit with content', 'framework' ),
								'full' => __( 'full width', 'framework' )
							),
				'default' => '',
				'name' => __( 'Width', 'framework' ),
				'desc' => __( 'it can be 100% width', 'framework' )
			),
			'link' => array(
				'default' => '',
				'name' => __( 'Link', 'framework' ),
				'desc' => __( 'the link of the button', 'framework' )
			),
			'target' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Open in same window/tab', 'framework' ),
								'_blank' => __( 'Open in new window/tab', 'framework' )
							),
				'default' => '',
				'name' => __( 'Link target', 'framework' ),
			),
			'font' => array(
				'type' => 'select',
				'values' => mom_google_fonts(),
				'default' => '',
				'name' => __( 'Font', 'framework' ),
			),
			'font_style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Normal', 'framework' ),
								'italic' => __( 'Italic', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Style', 'framework' ),
			),
			'font_weight' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Normal', 'framework' ),
								'bold' => __( 'Bold', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Weight', 'framework' ),
			),
			'radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Radius', 'framework' ),
				'desc' => __( 'insert box border radius number eg. 10', 'framework' )
			),
			'outer_border' => array(
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Outer Border', 'framework' ),
				'desc' => __( 'its make the button look awesome', 'framework' )
			),
			'outer_border_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Outer Border Color', 'framework' ),
				'required'  => array('outer_border', '=', 'true')
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' )
			),
		),
		'content' => __( "Click here", 'framework' ),
		'desc' => __( 'Button shortcode', 'framework' ),
		'icon' => 'square'
	);
		// Callout  
		$shortcodes['callout'] = array(
		'name' => __( 'Callout', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'bgimg' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Callout Background Image', 'framework' ),
				'desc' => __( 'Upload Background image', 'framework' ),
			),
			'bg' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' ),
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' ),
			),
			'border' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' ),
			),
			'radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Radius', 'framework' ),
				'desc' => __( 'insert box border radius number eg. 10', 'framework' )
			),
			'font' => array(
				'type' => 'select',
				'values' => mom_google_fonts(),
				'default' => '',
				'name' => __( 'Font', 'framework' ),
			),	
			'fontsize' => array(
				'default' => '',
				'name' => __( 'Font Size', 'framework' ),
				'desc' => __( 'insert a font size as a number eg. 14', 'framework' )
			),		
			'bt_pos' => array(
				'type' => 'select',
				'values' => array(
								'right' => __( 'right', 'framework' ),
								'bottomLeft' => __( 'bottom Left', 'framework' ),
								'bottomRight' => __( 'bottom Right', 'framework' ),
								'bottomCenter' => __( 'bottom Center', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Button Position', 'framework' ),
			),
			'bt_content' => array(
				'default' => '',
				'name' => __( 'Button Text', 'framework' ),
			),
			'bt_color' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Default', 'framework' ),
								'yellow' => __( 'Yellow', 'framework' ),
								'orange' => __( 'Orange', 'framework' ),
								'orange2' => __( 'Orange2', 'framework' ),
								'red' => __( 'Red', 'framework' ),
								'brown' => __( 'Brown', 'framework' ),
								'pink' => __( 'Pink', 'framework' ),
								'purple' => __( 'Purple', 'framework' ),
								'green2' => __( 'Dark Green', 'framework' ),
								'green' => __( 'Green', 'framework' ),
								'blue' => __( 'Blue', 'framework' ),
								'blue2' => __( 'Dark Blue', 'framework' ),
								'gray2' => __( 'Dark Gray', 'framework' ),
								'gray' => __( 'Gray', 'framework' ),
								'custom' => __( 'Custom', 'framework' )
							),
				'default' => '',
				'name' => __( 'Button color', 'framework' ),
				'desc' => __( 'Select one or make your own', 'framework' )
			),
			'bt_bgcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_hoverbg' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Hover Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_textcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_texthcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Hover Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_bordercolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_hoverborder' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Hover Color', 'framework' ),
				'required'  => array('bt_color', '=', 'custom')
			),
			'bt_size' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Medium', 'framework' ),
								'big' => __( 'Big', 'framework' ),
								'bigger' => __( 'Bigger', 'framework' )
							),
				'default' => '',
				'name' => __( 'Size', 'framework' ),
				'desc' => __( 'select from medium or big', 'framework' )
			),
			'bt_link' => array(
				'default' => '',
				'name' => __( 'Link', 'framework' ),
				'desc' => __( 'the link of the button', 'framework' )
			),
			'bt_target' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Open in same window/tab', 'framework' ),
								'_blank' => __( 'Open in new window/tab', 'framework' )
							),
				'default' => '',
				'name' => __( 'Link target', 'framework' ),
			),
			'bt_font' => array(
				'type' => 'select',
				'values' => mom_google_fonts(),
				'default' => '',
				'name' => __( 'Font', 'framework' ),
			),
			'bt_font_style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Normal', 'framework' ),
								'italic' => __( 'Italic', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Style', 'framework' ),
			),
			'bt_font_weight' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Normal', 'framework' ),
								'bold' => __( 'Bold', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Weight', 'framework' ),
			),
			'bt_radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Radius', 'framework' ),
				'desc' => __( 'insert box border radius number eg. 10', 'framework' )
			),
			'bt_outer_border' => array(
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Outer Border', 'framework' ),
				'desc' => __( 'its make the button look awesome', 'framework' )
			),
			'bt_outer_border_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Outer Border Color', 'framework' ),
				'required'  => array('outer_border', '=', 'true')
			),
			'bt_icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
			'bt_icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' )
			),
		),
		'content' => __( "Callout Content", 'framework' ),
		'desc' => __( 'Callout Shortcode', 'framework' ),
		'icon' => 'bullhorn'
	);
		// Clear
		$shortcodes['clear'] = array(
		'name' => __( 'Clear', 'framework' ),
		'type' => 'single',
		'group' => 'content',
		'atts' => array(),
		'desc' => __( 'Add Clear', 'framework' ),
		'icon' => 'square-o'
	);
		// divide
		$shortcodes['divide'] = array(
		'name' => __( 'Divide', 'framework' ),
		'type' => 'single',
		'group' => 'content',
		'atts' => array(
			'style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Line', 'framework' ),
								'dots' => __( 'Dots', 'framework' ),
								'dashs' => __( 'Dashes', 'framework' )
							),
				'default' => '',
				'name' => __( 'Style', 'framework' ),
				'desc' => __( '4 styles, default margin bottom 25px', 'framework' )
			),
			'icon' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'square' => __( 'Square', 'framework' ),
								'circle' => __( 'Circle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon', 'framework' ),
			),
			'icon_position' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Center', 'framework' ),
								'left' => __( 'left', 'framework' ),
								'right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon Position', 'framework' ),
			),
			'margin_top' => array(
				'default' => '',
				'name' => __( 'Margin Top', 'framework' ),
				'desc' => __( 'Space above it', 'framework' )
			),
			'margin_bottom' => array(
				'default' => '',
				'name' => __( 'Margin Bottom', 'framework' ),
				'desc' => __( 'Space under it', 'framework' )
			),
			'width' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Long', 'framework' ),
								'medium' => __( 'Medium', 'framework' ),
								'short' => __( 'Short', 'framework' )
							),
				'default' => '',
				'name' => __( 'Width', 'framework' ),
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Divider Color', 'framework' )
			),
		),
		'desc' => __( 'Add a Divider', 'framework' ),
		'icon' => 'ellipsis-h'
	);
		// Document
		$shortcodes['document'] = array(
			'name' => __( 'Document', 'framework' ),
			'type' => 'single',
			'group' => 'media',
			'atts' => array(
				'url' => array(
					'type' => 'upload',
					'default' => '',
					'name' => __( 'Url', 'framework' ),
					'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'framework' )
				),
				'width' => array(
					'type' => 'slider',
					'min' => 200,
					'max' => 1600,
					'step' => 20,
					'default' => 600,
					'name' => __( 'Width', 'framework' ),
					'desc' => __( 'Viewer width', 'framework' )
				),
				'height' => array(
					'type' => 'slider',
					'min' => 200,
					'max' => 1600,
					'step' => 20,
					'default' => 600,
					'name' => __( 'Height', 'framework' ),
					'desc' => __( 'Viewer height', 'framework' )
				),
				'class' => array(
					'default' => '',
					'name' => __( 'Class', 'framework' ),
					'desc' => __( 'Extra CSS class', 'framework' )
				)
			),
			'desc' => __( 'Document viewer by Google', 'framework' ),
			'icon' => 'file-text'
	);
		// Dropcap
		$shortcodes['dropcap'] = array(
		'name' => __( 'Dropcap', 'framework' ),
		'type' => 'wrap',
		'group' => 'content',
		'atts' => array(
			'style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'square' => __( 'Square', 'framework' ),
								'circle' => __( 'Circle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Style', 'framework' ),
				'desc' => __( 'Dropcap styles', 'framework' )
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Letter Color', 'framework' )
			),
			'bgcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' )
			),
			'sradius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Square Radius', 'framework' ),
				'required'  => array('style', '=', 'square')
			),
		),
		'content' => __('A', 'framework'),
		'desc' => __( 'Add a Dropcap', 'framework' ),
		'icon' => 'bold'
	);
		// Feature slider
		$shortcodes['feature_slider'] = array(
		'name' => __( 'Feature Slider', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'type' => array( 
				'type' => 'select',
				'values' => array(
								'def' => __( 'Simple ( Default )', 'framework' ),
								'slider2' => __( 'Grid Style', 'framework' ),
								'cat' => __( 'Category Slider ( Full width )', 'framework' )
							),
				'default' => 'def',
				'name' => __( 'Type', 'framework' ),
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'latest' => __( 'Latest posts', 'framework' ),
								'cat' => __( 'Category', 'framework' ),
								'tag' => __( 'Tag', 'framework' ),
								'specific' => __( 'Specific Posts', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'cats' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'cat')
			),
			'tag' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tag')
			),
			'specific' => array(
				'default' => '',
				'name' => __( 'Posts ids', 'framework' ),
				'desc' => __( 'multiple post id separated by comma', 'framework' ),
				'required'  => array('display', '=', 'specific')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'number_of_posts' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 100,
				'step' => 1,
				'default' => 4,
				'name' => __( 'Number Of posts', 'framework' ),
			),
			'animation' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'fade' => __( 'Fade', 'framework' ),
								'slid' => __( 'Slide', 'framework' ),
								'flip' => __( 'Flip', 'framework' ),
								'custom' => __( 'Custom Animation', 'framework' )
							),
				'default' => '',
				'name' => __( 'Animation', 'framework' ),
				'required'  => array('type', '=', 'def')
			),
			'animationout' => array( 
				'type' => 'select',
				'values' => array_combine( $animation, $animation ),
				'default' => '',
				'name' => __( 'Animation Out', 'framework' ),
				'required'  => array('animation', '=', 'custom')
			),
			'animationin' => array( 
				'type' => 'select',
				'values' => array_combine( $animation, $animation ),
				'default' => '',
				'name' => __( 'Animation In', 'framework' ),
				'required'  => array('animation', '=', 'custom')
			),
			'autoplay' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Autoplay', 'framework' ),
				'required'  => array('type', '=', 'def')
			),
			'timeout' => array(
				'type' => 'slider',
				'min' => 100,
				'max' => 100000,
				'step' => 100,
				'default' => 5000,
				'name' => __( 'TimeOut', 'framework' ),
				'required'  => array('type', '=', 'def')
			),
			'cap' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Caption', 'framework' ),
				'required'  => array('type', '=', 'def')
			),
			'num_bullets' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Numeric bullets', 'framework' ),
				'required'  => array('type', '=', 'def')
			),

			'exc' => array(
				'default' => '150',
				'name' => __( 'Excerpt', 'framework' ),
				'desc' => __( 'excerpt length leave it empty to disappear default: 150', 'framework' )
			),
			/*
			'bullets_event' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Click', 'framework' ),
								'hover' => __( 'Hover', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Bullets event', 'framework' ),
			),	
			*/		
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'Feature slider shortcode', 'framework' ),
		'icon' => 'photo'
	);
		//feed
		$shortcodes['feed'] = array(
		'name' => __( 'RSS Feed', 'framework' ),
		'type' => 'single',
		'group' => 'content other',
		'atts' => array(
			'url' => array(
				'values' => array( ),
				'default' => '',
				'name' => __( 'Url', 'framework' ),
				'desc' => __( 'Url to RSS-feed', 'framework' )
			),
			'limit' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 3,
				'name' => __( 'Limit', 'framework' ), 'desc' => __( 'Number of items to show', 'framework' )
			),
			'descs' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Enable Descritption', 'framework' ),
			),
			'date' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Enable Date', 'framework' ),
			),
		),
		'desc' => __( 'Feed grabber', 'framework' ),
		'icon' => 'rss'
	);
		// gap
		$shortcodes['gap'] = array(
		'name' => __( 'Gap', 'framework' ),
		'type' => 'single',
		'group' => 'other',
		'atts' => array(
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Height', 'framework' ),
			),
		),
		'desc' => __( 'Add a space', 'framework' ),
		'icon' => 'arrows-v'
	);
		// Google map
		$shortcodes['g_map'] = array(
		'name' => __( 'Google Map', 'framework' ),
		'type' => 'single',
		'group' => 'media',
		'atts' => array(
			'width' => array(
				'type' => 'select',
				'values' => array(
								'cwidth' => __( 'Container Width', 'framework' ),
								'full' => __( 'Full width', 'framework' )
							),
				'default' => '',
				'name' => __( 'Style', 'framework' ),
				'desc' => __( 'Dropcap styles', 'framework' )
			),
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Height', 'framework' ),
			),
			'lat' => array(
				'default' => '',
				'name' => __( 'Latitude', 'framework' )
			),
			'long' => array(
				'default' => '',
				'name' => __( 'Longitude', 'framework' )
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Color', 'framework' )
			),
			'zoom' => array(
				'default' => '',
				'name' => __( 'Zoom', 'framework' )
			),
			'pan' => array(
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'false' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Pan', 'framework' ),
			),
			'controls' => array(
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'false' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Controls', 'framework' ),
			),
			'marker_icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Marker icon', 'framework' )
			),
			'marker_title' => array(
				'default' => '',
				'name' => __( 'Marker Title', 'framework' )
			),
			'marker_animation' => array(
				'type' => 'select',
				'values' => array(
								'DROP' => __( 'DROP', 'framework' ),
								'BOUNCE' => __( 'BOUNCE', 'framework' )
							),
				'default' => '',
				'name' => __( 'Marker Animation', 'framework' ),
			),
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'Add Google map', 'framework' ),
		'icon' => 'map-marker'
	);
		// graph
		$shortcodes['graphs'] = array(
		'name' => __( 'Graph', 'framework' ),
		'type' => 'wrap',
		'group' => 'other',
		'atts' => array(
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Height', 'framework' ),
			),
			'strips' => array(
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Enable Strips', 'framework' ),
			),
		),
		'content' => __( "[graph title=\"Title\" score=\"0\" color=\"#000\" text_color=\"#fff\"]\n[graph title=\"Title\" score=\"0\" color=\"#000\" text_color=\"#fff\"]\n[graph title=\"Title\" score=\"0\" color=\"#000\" text_color=\"#fff\"]", 'framework' ),
		'desc' => __( 'Add graph', 'framework' ),
		'icon' => 'tasks'
	);
		// highlight
		$shortcodes['highlight'] = array(
		'name' => __( 'Highlight', 'framework' ),
		'type' => 'wrap',
		'group' => 'content',
		'atts' => array(
			'bgcolor' => array(
				'type' => 'color',
				'default' => '#DDFF99',
				'name' => __( 'Background Color', 'framework' )
			),
			'txtcolor' => array(
				'type' => 'color',
				'default' => '#000',
				'name' => __( 'Text Color', 'framework' )
			)
		),
		'content' => __( "Highlighted text", 'framework' ),
		'desc' => __( 'Highlight', 'framework' ),
		'icon' => 'pencil'
	);
		// Icon
		$shortcodes['icon'] = array(
		'name' => __( 'Icon', 'framework' ),
		'type' => 'single',
		'group' => 'other',
		'atts' => array(
			'align' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'left', 'framework' ),
								'center' => __( 'center', 'framework' ),
								'right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Align', 'framework' ),
			),
			'size' => array(
				'type' => 'select',
				'values' => array(
								'16' => __( '16px', 'framework' ),
								'24' => __( '24px', 'framework' ),
								'32' => __( '32px', 'framework' ),
								'48' => __( '48px', 'framework' ),
								'custom' => __( 'Custom Size', 'framework' )
							),
				'default' => '32',
				'name' => __( 'Icon Size', 'framework' ),
			),
			'custom_size' => array(
				'default' => '',
				'name' => __( 'Custom size', 'framework' ),
				'required'  => array('size', '=', 'custom')
			),
			'icon_bg' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'square' => __( 'Square', 'framework' ),
								'circle' => __( 'Circle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon background', 'framework' ),
				'desc' => __( 'select icon background type circle, square', 'framework' )
			),
			'icon_bg_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Background Color', 'framework' )
			),
			'icon_bg_colorh' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon background Hover Color', 'framework' )
			),
			'icon_bd_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border color', 'framework' )
			),
			'icon_bd_colorh' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Hover Color', 'framework' )
			),
			'icon_bd_width' => array(
				'default' => '',
				'name' => __( 'Border width', 'framework' )
			),
			'square_radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Square Radius', 'framework' ),
				'required'  => array('iconbg', '=', 'square')
			),
			'type' => array(
				'type' => 'select',
				'values' => array(
								'vector' => __( 'Vector Icon', 'framework' ),
								'custom' => __( 'Custom Icon', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon Type', 'framework' ),
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' ),
				'required'  => array('type', '=', 'vector')
			),
			'icon_color_hover' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Hover Color', 'framework' ),
				'required'  => array('type', '=', 'vector')
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
		),
		'desc' => __( 'Insert icon', 'framework' ),
		'icon' => 'exclamation-circle'
	);
		// Icon box
		$shortcodes['iconbox'] = array(
		'name' => __( 'Icon Box', 'framework' ),
		'type' => 'wrap',
		'group' => 'other',
		'atts' => array(
			'title' => array(
				'default' => '',
				'name' => __( 'Box Title', 'framework' ),
			),
			'title_align' => array(
				'type' => 'select',
				'values' => array(
								'left' => __( 'left', 'framework' ),
								'center' => __( 'center', 'framework' ),
								'right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Title Align', 'framework' ),
			),
			'title_link' => array(
				'default' => '',
				'name' => __( 'Title Link', 'framework' ),
			),
			'title_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Title Color', 'framework' )
			),
			'content_align' => array(
				'type' => 'select',
				'values' => array(
								'left' => __( 'left', 'framework' ),
								'center' => __( 'center', 'framework' ),
								'right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Content Align', 'framework' ),
			),
			'content_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Content Color', 'framework' )
			),
			'layout' => array(
				'type' => 'select',
				'values' => array(
								'plain' => __( 'Plain Box', 'framework' ),
								'boxed' => __( 'Boxed', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Layout', 'framework' ),
			),
			'bg' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' )
			),
			'border' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' )
			),
			'align' => array(
				'type' => 'select',
				'values' => array(
								'left' => __( 'left', 'framework' ),
								'center' => __( 'center', 'framework' ),
								'right' => __( 'right', 'framework' ),
								'middle_left' => __( 'right', 'framework' ),
								'middle_right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon Alignment', 'framework' ),
			),
			'icon_align_to' => array(
				'type' => 'select',
				'values' => array(
								'box' => __( 'Box', 'framework' ),
								'title' => __( 'Title', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Icon Align To', 'framework' ),
			),
			'size' => array(
				'type' => 'select',
				'values' => array(
								'16' => __( '16px', 'framework' ),
								'24' => __( '24px', 'framework' ),
								'32' => __( '32px', 'framework' ),
								'48' => __( '48px', 'framework' ),
								'custom' => __( 'Custom Size', 'framework' )
							),
				'default' => '32',
				'name' => __( 'Icon Size', 'framework' ),
			),
			'custom_size' => array(
				'default' => '',
				'name' => __( 'Custom size', 'framework' ),
				'required'  => array('size', '=', 'custom')
			),
			'icon_bg' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'square' => __( 'Square', 'framework' ),
								'circle' => __( 'Circle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon background', 'framework' ),
				'desc' => __( 'select icon background type circle, square', 'framework' )
			),
			'icon_bg_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Background Color', 'framework' )
			),
			'icon_bg_colorh' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon background Hover Color', 'framework' )
			),
			'icon_bd_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border color', 'framework' )
			),
			'icon_bd_colorh' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Hover Color', 'framework' )
			),
			'icon_bd_width' => array(
				'default' => '',
				'name' => __( 'Border width', 'framework' )
			),
			'icon_link' => array(
				'default' => '',
				'name' => __( 'Icon Link', 'framework' ),
			),
			'square_radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Square Radius', 'framework' ),
				'required'  => array('iconbg', '=', 'square')
			),
			'hover_animation' => array(
			 	'type' => 'select',
			 	'values' => array(
			 					'border_increase' => __( 'Border increase', 'framework' ),
			 					'border_decrease' => __( 'Border decrease', 'framework' ),
			 					'icon_move' => __( 'Icon move', 'framework' )
			 				),
			 	'default' => '',
			 	'name' => __( 'Hover Animation', 'framework' ),
			),
			'animation' => array(
				'type' => 'select',
				'values' => array_combine( $animation, $animation ),
				'default' => '',
				'name' => __( 'Icon Animation', 'framework' ),
				'desc' => __( 'Select animation type', 'framework' )
			),
			'icon_animation_duration' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 0.5,
				'default' => 1,
				'name' => __( 'Duration', 'framework' ),
				'desc' => __( 'Animation duration (seconds)', 'framework' )
			),
			'icon_animation_delay' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 0.5,
				'default' => 0,
				'name' => __( 'Delay', 'framework' ),
				'desc' => __( 'Animation delay (seconds)', 'framework' )
			),
			'icon_animation_iteration' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Iteration Count', 'framework' ),
				'desc' => __( 'number of animation times -1 for non stop animation', 'framework' )
			),		
			'type' => array(
				'type' => 'select',
				'values' => array(
								'vector' => __( 'Vector Icon', 'framework' ),
								'custom' => __( 'Custom Icon', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon Type', 'framework' ),
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' ),
				'required'  => array('type', '=', 'vector')
			),
			'icon_color_hover' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Hover Color', 'framework' ),
				'required'  => array('type', '=', 'vector')
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
		),
		'content' => __( "Content", 'framework' ),
		'desc' => __( 'Insert icon Box', 'framework' ),
		'icon' => 'check-square-o'
	);
		// Images grid
		$shortcodes['images_grid'] = array(
		'name' => __( 'Images Grid', 'framework' ),
		'type' => 'wrap',
		'group' => 'gallery',
		'atts' => array(
			'type' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Grid', 'framework' ),
								'carousel' => __( 'Carousel', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Type', 'framework' ),
			),
			'title' => array(
				'default' => '',
				'name' => __( 'Carousel Title', 'framework' ),
				'required'  => array('type', '=', 'carousel')
			),
			'carousel_effect' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'scroll', 'framework' ),
								'cover-fade' => __( 'cover-fade', 'framework' ),
								'fade' => __( 'fade', 'framework' ),
								'directscroll' => __( 'directscroll', 'framework' ),
								'crossfade' => __( 'crossfade', 'framework' ),
								'cover' => __( 'cover', 'framework' ),
								'uncover' => __( 'uncover', 'framework' ),
								'uncover-fade' => __( 'uncover-fade', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Carousel Effect', 'framework' ),
				'required'  => array('type', '=', 'carousel')
			),
			'auto_slide' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Auto Slideshow', 'framework' ),
				'required'  => array('type', '=', 'carousel')
			),
			'auto_duration' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 0.5,
				'default' => 1,
				'name' => __( 'Auto Slide Duration', 'framework' ),
				'required'  => array('type', '=', 'carousel')
			),
			'cols' => array(
				'type' => 'select',
				'values' => array(
								'three' => __( 'Three Columns', 'framework' ),
								'four' => __( 'Four Columns', 'framework' ),
								'five' => __( 'Five Columns', 'framework' ),
								'six' => __( 'Six Columns', 'framework' ),
							),
				'default' => '',
				'name' => __( 'Columns', 'framework' ),
			),
			'lightbox' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Enable lightbox', 'framework' ),
				'desc' => __( 'if you enable this the image link must be the big image url if you leave link empty the lightbox open the same image', 'framework' )
			),
			'source' => array(
				'type'    => 'image_source',
				'default' => 'none',
				'name'    => __( 'Source', 'su' ),
				'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
			),
		),
		'content' => __( "", 'framework' ),
		'desc' => __( 'Images Grid shortcode', 'framework' ),
		'icon' => 'th'
	);
		// Lightbox
		$shortcodes['lightbox'] = array(
		'name' => __( 'Lightbox', 'framework' ),
		'type' => 'single',
		'group' => 'gallery',
		'atts' => array(
			'thumb' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Lightbox Thumbnail', 'framework' ),
			),
			'type' => array(
				'type' => 'select',
				'values' => array(
								'img' => __( 'Image', 'framework' ),
								'video' => __( 'Video', 'framework' )
							),
				'default' => 'img',
				'name' => __( 'Type', 'framework' ),
				'desc' => __( 'Image or Video', 'framework' )
			),
			'link' => array(
				'default' => '',
				'name' => __( 'Link', 'framework' ),
				'desc' => __( 'It can be image link or video link (youtube&vimeo only), if leave empty it will be the thumbnail image link.', 'framework' )
			)
		),
		'desc' => __( 'Lightbox shortcode', 'framework' ),
		'icon' => 'external-link'
	);
		// Lists
		$shortcodes['list'] = array(
		'name' => __( 'List', 'framework' ),
		'type' => 'wrap',
		'group' => 'content',
		'atts' => array(
			'margin_top' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Space above it (optional)', 'framework' ),
			),
			'margin_bottom' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Space under it (optional)', 'framework' ),
			),
			'icon_bg' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'square' => __( 'Square', 'framework' ),
								'circle' => __( 'Circle', 'framework' )
							),
				'default' => '',
				'name' => __( 'Icon background', 'framework' ),
				'desc' => __( 'select icon background type circle, square', 'framework' )
			),
			'icon_bg_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Background Color', 'framework' )
			),
			'icon_bg_hover' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon background Hover Color', 'framework' )
			),
			'square_bg_radius' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Square Radius', 'framework' ),
				'required'  => array('iconbg', '=', 'square')
			),
			'icon_size' => array(
				'type' => 'select',
				'values' => array(
								'16' => __( '16px', 'framework' ),
								'24' => __( '24px', 'framework' ),
								'32' => __( '32px', 'framework' ),
								'48' => __( '48px', 'framework' ),
							),
				'default' => '32',
				'name' => __( 'Icon Size', 'framework' ),
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'framework' )
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Color', 'framework' )
			),
			'icon_color_hover' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Icon Hover Color', 'framework' )
			),
		),
		'content' => __( "Item 1,\nItem 2,\nItem 3", 'framework' ),
		'desc' => __( 'List shortcode', 'framework' ),
		'icon' => 'list-ul'
	);
		// members
		$shortcodes['members'] = array(
			'name' => __( 'Members', 'framework' ),
			'type' => 'wrap',
			'group' => 'other',
			'atts' => array(
				'message' => array(
					'default' => __( 'This content is for registered users only. Please %login%.', 'framework' ),
					'name' => __( 'Message', 'framework' ), 'desc' => __( 'Message for not logged users', 'framework' )
				),
				'color' => array(
					'type' => 'color',
					'default' => '#ffcc00',
					'name' => __( 'Box color', 'framework' ), 'desc' => __( 'This color will applied only to box for not logged users', 'framework' )
				),
				'login_text' => array(
					'default' => __( 'login', 'framework' ),
					'name' => __( 'Login link text', 'framework' ), 'desc' => __( 'Text for the login link', 'framework' )
				),
				'login_url' => array(
					'default' => wp_login_url(),
					'name' => __( 'Login link url', 'framework' ), 'desc' => __( 'Login link url', 'framework' )
				),
			),
			'content' => __( 'Content for logged members', 'framework' ),
			'desc' => __( 'Content for logged in members only', 'framework' ),
			'icon' => 'lock'
	);
		// News box
		$shortcodes['newsbox'] = array(
		'name' => __( 'News Box', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'style' => array(  
				'type' => 'radio_img',
				'values' => array(
								'nb1' => array($imgs.'nb1.png', __('News Box 1', 'framework') ),
								'nb2' => array($imgs.'nb2.png', __('News Box 2', 'framework') ),
								'nb3' => array($imgs.'nb3.png', __('News Box 3', 'framework') ),
								'nb4' => array($imgs.'nb4.png', __('News Box 4', 'framework') ),
								'nb5' => array($imgs.'nb5.png', __('News Box 5', 'framework') ),
								'nb6' => array($imgs.'nb6.png', __('News Box 6', 'framework') ),
								'list' => array($imgs.'list.png', __('News Box List', 'framework') ),
							),
				'default' => 'sc1',
				'name' => __( 'Style', 'framework' ),
			),
			'title' => array(
				'default' => '',
				'name' => __( 'Custom Newsbox title', 'framework' )
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Latest posts', 'framework' ),
								'category' => __( 'Category', 'framework' ),
								'tag' => __( 'Tag', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'cat' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'category')
			),
			'tag' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tag')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'number_of_posts' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 4,
				'name' => __( 'Number Of posts', 'framework' ),
			),
			'nb_excerpt' => array(
				'default' => '',
				'name' => __( 'excerpt length', 'framework' ),
				'desc' => __( 'post excerpt length in characters leave empty for default values', 'framework' ),
			),

			'sub_categories' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Sub Categories', 'framework' ),
				'desc' => __( 'enable sub categories as tabs on top of each news box', 'framework' ),
			),

			'collapse_sc' => array(
				'type' => 'text',
				'default' => '', 
				'name' => __( 'Collapse subcategories after x category', 'framework' ),
			),

			'show_more' => array(
				'type' => 'bool',
				'default' => 'no', 
				'name' => __( 'Show More Button', 'framework' ),
				'desc' => __( 'enable show more button as tabs on bottom of each news box', 'framework' ),
			),
			'show_more_event' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Category/tag page', 'framework' ),
								'ajax' => __( 'More posts with Ajax', 'framework' )
							),
				'default' => '',
				'name' => __( 'On Click', 'framework' ),
				'required'  => array('show_more', '=', 'yes')
			),
			'post_type' => array(
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_types(),
				'default' => 'post',
				'name' => __( 'Custom post type', 'framework' ),
				'desc' => __( 'Advanced: you can use this option to get posts from custom post types, if you set this to anything the category and tags options not working', 'framework' )
			),
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'News modules &amp; blocks', 'framework' ),
		'icon' => 'newspaper-o'
	);
		// News Tabs
		$shortcodes['news_tabs'] = array(
		'name' => __( 'News Tabs Wrap', 'framework' ),
		'type' => 'wrap',
		'group' => 'momizat',
		'atts' => array(
			'style' => array(  
				'type' => 'select',
				'values' => array(
								'grid' => __( 'Grid', 'framework' ),
								'list' => __( 'List', 'framework' )
							),
				'default' => 'grid',
				'name' => __( 'Style ( Grid or List )', 'framework' ),
			),
			'columns' => array( 
				'type' => 'select',
				'values' => array(
								'2' => __( 'Two columns', 'framework' ),
								'3' => __( 'Three columns', 'framework' ),
								'4' => __( 'Four columns', 'framework' ),
								'5' => __( 'Five columns', 'framework' )
							),
				'default' => '2',
				'name' => __( 'Columns', 'framework' ),
			),
			'switcher' => array(
				'type' => 'bool',
				'default' => 'yes', 
				'name' => __( 'Switcher', 'framework' ),
				'desc' => __( 'enable grid or list switcher', 'framework' ),
			),
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'content' => __('Insert news tabs here from news tabs shortcode', 'framework'),
		'desc' => __( 'News Tabs', 'framework' ),
		'icon' => 'list-alt'
	);
		// News tab
		$shortcodes['news_tab'] = array(
		'name' => __( 'News Tab', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'title' => array(
				'default' => '',
				'name' => __( 'Tab title', 'framework' )
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Latest posts', 'framework' ),
								'cat' => __( 'Category', 'framework' ),
								'tag' => __( 'Tag', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'cat' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'cat')
			),
			'tag' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tag')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' ),
								'views' => __( 'Most viewed', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'cats' => array(
				'default' => '',
				'name' => __( 'Exclude categories', 'framework' ),
				'required'  => array('display', '=', '')
			),
			'count' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Number Of posts', 'framework' ),
			),
			'exc' => array(
				'default' => '',
				'name' => __( 'Excerpt length', 'framework' )		
			)
		),
		'desc' => __( 'News Tab insert it inside news tabs wrap', 'framework' ),
		'icon' => 'list-alt'
	);
		// News Picture
		$shortcodes['newspic'] = array(
		'name' => __( 'News Picture', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'title' => array(
				'default' => '',
				'name' => __( 'Box title', 'framework' )
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Latest posts', 'framework' ),
								'category' => __( 'Category', 'framework' ),
								'tag' => __( 'Tag', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'cat' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'category')
			),
			'tag' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tag')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'count' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Number Of posts', 'framework' ),
			),
			'class' => array(
				'default' => '',
				'name' => __( 'Class', 'framework' ),
				'desc' => __( 'Extra CSS class', 'framework' )
			)
		),
		'desc' => __( 'News Picture', 'framework' ),
		'icon' => 'th-large'
	);
		// private
		$shortcodes['private'] = array(
			'name' => __( 'Private', 'framework' ),
			'type' => 'wrap',
			'group' => 'other',
			'atts' => array(
				'class' => array(
					'default' => '',
					'name' => __( 'Class', 'framework' ),
					'desc' => __( 'Extra CSS class', 'framework' )
				)
			),
			'content' => __( 'Private Content', 'framework' ),
			'desc' => __( 'Private content for post authors', 'framework' ),
			'icon' => 'lock'
	);
		// Pop-up
		$shortcodes['pop-up'] = array(
		'name' => __( 'Pop-up', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'popup_delay' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 10000,
				'step' => 50,
				'default' => 0,
				'name' => __( 'Delay', 'framework' ),
				'desc' => __( 'Appear after x seconds. Default is 0', 'framework' )
			),
			'popup_timeout' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 10000,
				'step' => 50,
				'default' => 0,
				'name' => __( 'TimeOut', 'framework' ),
				'desc' => __( 'Disable after x seconds. Default is 0', 'framework' )
			),
			'animationclass' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'None', 'framework' ),
								'afadein' => __( 'Fadein', 'framework' ),
								'apop' => __( 'Pop', 'framework' ),
								'azoom' => __( 'Zoom', 'framework' ),
								'asimple' => __( 'Simple', 'framework' ),
								'ajelly' => __( 'Jelly', 'framework' ),
								'atop' => __( 'From Top', 'framework' ),
								'aleft' => __( 'From Left', 'framework' ),
								'aricky' => __( 'Ricky', 'framework' )
							),
				'default' => '',
				'name' => __( 'Animation', 'framework' ),
			),
			'popup_width' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 1024,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Width', 'framework' ),
			),
			'popup_height' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 1024,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Height', 'framework' ),
			),
			'padding' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 50,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Padding', 'framework' ),
			),
			'background_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' )
			),
			'background_image' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Upload Background image', 'framework' )
			),
			'font_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' )
			),
			'close_button' => array( 
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'false' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Show close button', 'framework' ),
			),
			'close_inside' => array( 
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'false' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Close button inside pop-up box', 'framework' ),
			),
			'close_bg_click' => array( 
				'type' => 'select',
				'values' => array(
								'true' => __( 'True', 'framework' ),
								'false' => __( 'False', 'framework' )
							),
				'default' => '',
				'name' => __( 'Close On background click', 'framework' ),
			),
		),
		'content' => __('Content Here', 'framework'),
		'desc' => __( 'Pop-up shortcode', 'framework' ),
		'icon' => 'list-alt'
	);
		// quote
		$shortcodes['quote'] = array(
		'name' => __( 'Quote', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'font' => array(
				'type' => 'select',
				'values' => mom_google_fonts(),
				'default' => '',
				'name' => __( 'Font', 'framework' ),
			),
			'font_size' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Font Size', 'framework' ),
			),
			'font_style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Normal', 'framework' ),
								'italic' => __( 'Italic', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Style', 'framework' ),
			),
			'align' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'none', 'framework' ),
								'left' => __( 'left', 'framework' ),
								'right' => __( 'right', 'framework' )
							),
				'default' => '',
				'name' => __( 'Alignment', 'framework' ),
			),
			'bgcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' )
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' )
			),
			'bcolor' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Highlight color', 'framework' )
			),
			'arrow' => array(
				'type' => 'bool',
				'default' => 'no',
				'name' => __( 'Show Arrow', 'framework' ),
				'desc' => __( 'little arrow on highlight', 'framework' )
			),
		),
		'content' => __( "Content here", 'framework' ),
		'desc' => __( 'Quote Shortcode', 'framework' ),
		'icon' => 'quote-left'
	);
		// Review
		$shortcodes['review'] = array(
		'name' => __( 'Review', 'framework' ),
		'type' => 'single',
		'group' => 'content',
		'atts' => array(),
		'desc' => __( 'If you enable review in this post add it', 'framework' ),
		'icon' => 'tasks'
	);
		// Scroller
		$shortcodes['scroller'] = array(
		'name' => __( 'Scroller', 'framework' ),
		'type' => 'single',
		'group' => 'momizat',
		'atts' => array(
			'style' => array(  
				'type' => 'radio_img',
				'values' => array(
								'sc1' => array($imgs.'sc1.png', __('Image Style', 'framework') ),
								'sc2' => array($imgs.'sc2.png', __('Box Style', 'framework') ),
							),
				'default' => 'sc1',
				'name' => __( 'Style', 'framework' ),
			),
			'title' => array(
				'default' => '',
				'name' => __( 'Scroller box title', 'framework' )
			),
			'sub_title' => array(
				'default' => '',
				'name' => __( 'Scroller box Subtitle', 'framework' ),
				'desc' => __( 'Leave it blank if you want to hide', 'framework' ),
			),
			'title_size' => array( 
				'type' => 'select',
				'values' => array(
								'17' => __( 'Default', 'framework' ),
								'30' => __( 'Big size', 'framework' )
							),
				'default' => '17',
				'name' => __( 'Title Size', 'framework' ),
			),
			'display' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Latest posts', 'framework' ),
								'cats' => __( 'Category', 'framework' ),
								'tags' => __( 'Tag', 'framework' )
							),
				'default' => '',
				'name' => __( 'Display', 'framework' ),
			),
			'cats' => array( 
				'type' => 'select',
				'multiple' => true,
				'values' => mom_su_Tools::get_terms( 'category' ),
				'default' => '',
				'name' => __( 'Cateogry', 'framework' ),
				'required'  => array('display', '=', 'cats')
			),
			'tags' => array(
				'default' => '',
				'name' => __( 'Tags', 'framework' ),
				'desc' => __( 'multiple tags separated by comma', 'framework' ),
				'required'  => array('display', '=', 'tags')
			),
			'orderby' => array( 
				'type' => 'select',
				'values' => array(
								'' => __( 'Recent', 'framework' ),
								'comment_count' => __( 'Popular', 'framework' ),
								'rand' => __( 'Random', 'framework' )
							),
				'default' => '',
				'name' => __( 'Order by', 'framework' ),
			),
			'number_of_posts' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 8,
				'name' => __( 'Number Of posts', 'framework' ),
			),

			'number_of_posts' => array(
				'type' => 'slider',
				'min' => -1,
				'max' => 500,
				'step' => 1,
				'default' => 4,
				'name' => __( 'Number Of items', 'framework' ),
				'desc' => __('Number of items that display on each scroll default is 4', 'framework'),
			),
			'auto_play' => array(
				'default' => '',
				'name' => __( 'Autoplay', 'framework' ),
				'desc' => __( 'Change to any integrer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds. false to display', 'framework' ),
			),
			'speed' => array(
				'type' => 'slider',
				'min' => 50,
				'max' => 10000,
				'step' => 50,
				'default' => 300,
				'name' => __( 'Speed', 'framework' ),
				'desc' => __( 'Slide speed in milliseconds Default : 300', 'framework' ),
			)
		),
		'desc' => __( 'Scroller Posts Shortcode', 'framework' ),
		'icon' => 'arrows-h'
	);
		// soundcloud
		$shortcodes['soundcloud'] = array(
		'name' => __( 'Soundcloud', 'framework' ),
		'type' => 'single',
		'group' => 'media',
		'atts' => array(
			'id' => array(
				'default' => '',
				'name' => __( 'Soundcloud URL', 'framework' )
			),
			'width' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Width', 'framework' ),
			),
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Height', 'framework' ),
			)
		),
		'desc' => __( 'Soundcloud Shortcode', 'framework' ),
		'icon' => 'soundcloud'
	);
		// Tabs
		$shortcodes['tabs'] = array(
			'name' => __( 'Tabs Wrap', 'framework' ),
			'type' => 'wrap',
			'group' => 'box',
			'atts' => array(
				'style' => array( 
					'type' => 'select',
					'values' => array(
									'h1' => __( 'Horizontal Tabs', 'framework' ),
									'v1' => __( 'Vertical Tabs', 'framework' ),
									'v3' => __( 'Vertical Tabs Big', 'framework' )
								),
					'default' => '',
					'name' => __( 'Style', 'framework' ),
				),
				'icon_color' => array(
					'type' => 'color',
					'default' => '#',
					'name' => __( 'Icon Color', 'framework' )
				),
				'icon_current_color' => array(
					'type' => 'color',
					'default' => '#',
					'name' => __( 'Current Icon Color', 'framework' )
				)
			),
			'content' => __( "Insert tabs here from tab shortcode", 'framework' ),
			'desc' => __( 'Tabs wrap', 'framework' ),
			'icon' => 'list-alt'
	);
		// tab
		$shortcodes['tab'] = array(
			'name' => __( 'Tab', 'framework' ),
			'type' => 'wrap',
			'group' => 'box',
			'atts' => array(
				'title' => array(
					'default' => '',
					'name' => __( 'Tab Title', 'framework' ),
				),
				'icon' => array(
					'type' => 'icon',
					'default' => '',
					'name' => __( 'Icon', 'framework' )
				)
			),
			'content' => __( "Tab Content", 'framework' ),
			'desc' => __( 'Tab shotcode insert it inside tabs wrap shortcode each tab on a new line', 'framework' ),
			'icon' => 'list-alt'
	);
		// table
		$shortcodes['table'] = array(
			'name' => __( 'Table', 'framework' ),
			'type' => 'mixed',
			'group' => 'content',
			'atts' => array(
				'class' => array(
					'default' => '',
					'name' => __( 'Class', 'framework' ),
					'desc' => __( 'Extra CSS class', 'framework' )
				)
			),
			'content' => __( "<table>\n<thead>\n<tr>\n<th>Last Name</th>\n<th>First Name</th>\n<th>Email</th>\n<th>Due</th>\n<th>Web Site</th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td>Smith</td>\n<td>John</td>\n<td>jsmith@gmail.com</td>\n<td>$50.00</td>\n<td>http://www.jsmith.com</td>\n</tr>\n<tr>\n<td>Bach</td>\n<td>Frank</td>\n<td>fbach@yahoo.com</td>\n<td>$50.00</td>\n<td>http://www.frank.com</td>\n</tr>\n<tr>\n<td>Doe</td>\n<td>Jason</td>\n<td>jdoe@hotmail.com</td>\n<td>$100.00</td>\n<td>http://www.jdoe.com</td>\n</tr>\n<tr>\n<td>Conway</td>\n<td>Tim</td>\n<td>tconway@earthlink.net</td>\n<td>$50.00</td>\n<td>http://www.tway.com</td>\n</tr>\n</tbody></table>", 'framework' ),
			'desc' => __( 'Styled table from HTML', 'framework' ),
			'icon' => 'table'
	);
		// Testimonial Slider
		$shortcodes['testimonial_slider'] = array(
		'name' => __( 'Testimonial Slider', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'title' => array(
				'default' => 'What Clients Say',
				'name' => __( 'Title', 'framework' )
			),
			'effect' => array(
				'type' => 'select',
				'values' => array_combine( $animation, $animation ),
				'default' => '',
				'name' => __( 'Animation', 'framework' ),
				'desc' => __( 'Select animation type', 'framework' )
			),
			'auto_duration' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 10000,
				'step' => 0.5,
				'default' => 1000,
				'name' => __( 'Auto Slide Duration', 'framework' ),
			),
		),
		'content' => __( "Insert Testimonials Shortcodes here", 'framework' ),
		'desc' => __( 'Testimonials slider', 'framework' ),
		'icon' => 'comments'
	);
		// Testimonial
		$shortcodes['testimonial'] = array(
		'name' => __( 'Testimonial', 'framework' ),
		'type' => 'wrap',
		'group' => 'box',
		'atts' => array(
			'image' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Image', 'framework' ),
				'desc' => __( 'the person image 50px * 50px, leave it empty in you want', 'framework' )
			),
			'name' => array(
				'default' => 'John Doe',
				'name' => __( 'Person Name', 'framework' )
			),
			'title' => array(
				'default' => 'Designer',
				'name' => __( 'Person job title', 'framework' )
			),
			'font' => array(
				'type' => 'select',
				'values' => mom_google_fonts(),
				'default' => '',
				'name' => __( 'Font', 'framework' ),
			),
			'font_style' => array(
				'type' => 'select',
				'values' => array(
								'' => __( 'Italic', 'framework' ),
								'normal' => __( 'Normal', 'framework' )
							),
				'default' => '',
				'name' => __( 'Font Style', 'framework' ),
			),
			'font_size' => array(
				'default' => '',
				'name' => __( 'Font Size', 'framework' )
			),
			'background' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Background Color', 'framework' )
			),
			'color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Text Color', 'framework' )
			),
			'border' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Border Color', 'framework' )
			),	
			'img_border' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Image Border Color', 'framework' )
			),
			'name_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Name Color', 'framework' )
			),		
			'title_color' => array(
				'type' => 'color',
				'default' => '#',
				'name' => __( 'Title Color', 'framework' )
			),
		),
		'content' => __( "He promptly completed the task at hand and communicates really well till the project reaches the finishing line. I was pleased with his creative design and will definitely be hiring him again.", 'framework' ),
		'desc' => __( 'Testimonial', 'framework' ),
		'icon' => 'comment'
	);
		// Video
		$shortcodes['mom_video'] = array(
		'name' => __( 'Video', 'framework' ),
		'type' => 'single',
		'group' => 'media',
		'atts' => array(
			'type' => array(
				'type' => 'select',
				'values' => array(
								'youtube' => __( 'Youtube', 'framework' ),
								'vimeo' => __( 'Vimeo', 'framework' ),
								'dailymotion' =>  __( 'Dailymotion', 'framework' ),
								'screenr' => __('screenr', 'framework')
							),
				'default' => '',
				'name' => __( 'Video Type', 'framework' ),
			),
			'id' => array(
				'default' => '',
				'name' => __( 'Video ID', 'framework' ),
				'desc' => __( 'video id is the bold text in this links : http://www.youtube.com/watch?v=<strong>XSo4JQnm8Bw</strong>, http://vimeo.com/<strong>7449107</strong>', 'framework' ),
			),
			'width' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'framework' ),
			),
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Height', 'framework' ),
			)
		),
		'desc' => __( 'Add video', 'framework' ),
		'icon' => 'youtube-play'
	);
		// Weather charts
		$shortcodes['weather_chart'] = array(
		'name' => __( 'Weather Charts', 'framework' ),
		'type' => 'single',
		'group' => 'other',
		'atts' => array(
			'width' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'framework' ),
			),
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Height', 'framework' ),
			),
			'city' => array(
				'default' => '',
				'name' => __( 'City Name', 'framework' ),
			),
			'units' => array(
				'type' => 'select',
				'values' => array(
								'metric' => __( 'Metric', 'framework' ),
								'imperial' => __( 'Imperial', 'framework' )
							),
				'default' => '',
				'name' => __( 'Unit', 'framework' ),
			),
			'type' => array(
				'type' => 'select',
				'values' => array(
								'daily' => __( 'Daily', 'framework' ),
								'hourly' => __( 'Hourly', 'framework' )
							),
				'default' => '',
				'name' => __( 'Type', 'framework' ),
			),
		),
		'desc' => __( 'Add Weather Charts', 'framework' ),
		'icon' => 'bar-chart-o'
	);
		// Weather Map
		$shortcodes['weather_map'] = array(
		'name' => __( 'Weather Map', 'framework' ),
		'type' => 'single',
		'group' => 'other',
		'atts' => array(
			'width' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'framework' ),
			),
			'height' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1024,
				'step' => 1,
				'default' => '',
				'name' => __( 'Height', 'framework' ),
			),
			'city' => array(
				'default' => '',
				'name' => __( 'City Name', 'framework' ),
			),
			'zoom' => array(
				'default' => '',
				'name' => __( 'Zoom', 'framework' ),
			),
			'layer' => array(
				'type' => 'select',
				'values' => array(
								'rain' => __( 'rain', 'framework' ),
								'clouds' => __( 'clouds', 'framework' ),
								'precipitation' => __( 'precipitation', 'framework' ),
								'pressure' => __( 'pressure', 'framework' ),
								'wind' => __( 'wind', 'framework' ),
								'temp' => __( 'temp', 'framework' ),
								'snow' => __( 'snow', 'framework' )
							),
				'default' => '',
				'name' => __( 'Map Layer', 'framework' ),
			),
		),
		'desc' => __( 'Add Weglobeather Map', 'framework' ),
		'icon' => 'globe'
	);
	// Return modified data
	return $shortcodes;
}

/*=========================================================
*		Groups
========================================================= */

add_filter( 'mom_su/data/groups', 'mom_my_custom_groups' );

function mom_my_custom_groups ($groups) {
	unset( $groups['data']);
	$groups['momizat'] = __('News Blocks', 'framework');
	return $groups;

}
/*=========================================================
*		Icons
========================================================= */
add_filter( 'mom_su/data/icons', 'mom_my_custom_icons' );

function mom_my_custom_icons ($icons) {
	$icons = array('fa-icon-glass','fa-icon-music','fa-icon-search','fa-icon-envelope-o','fa-icon-heart','fa-icon-star','fa-icon-star-o','fa-icon-user','fa-icon-film','fa-icon-th-large','fa-icon-th','fa-icon-th-list','fa-icon-check','fa-icon-times','fa-icon-search-plus','fa-icon-search-minus','fa-icon-power-off','fa-icon-signal','fa-icon-cog','fa-icon-trash-o','fa-icon-home','fa-icon-file-o','fa-icon-clock-o','fa-icon-road','fa-icon-download','fa-icon-arrow-circle-o-down','fa-icon-arrow-circle-o-up','fa-icon-inbox','fa-icon-play-circle-o','fa-icon-repeat','fa-icon-refresh','fa-icon-list-alt','fa-icon-lock','fa-icon-flag','fa-icon-headphones','fa-icon-volume-off','fa-icon-volume-down','fa-icon-volume-up','fa-icon-qrcode','fa-icon-barcode','fa-icon-tag','fa-icon-tags','fa-icon-book','fa-icon-bookmark','fa-icon-print','fa-icon-camera','fa-icon-font','fa-icon-bold','fa-icon-italic','fa-icon-text-height','fa-icon-text-width','fa-icon-align-left','fa-icon-align-center','fa-icon-align-right','fa-icon-align-justify','fa-icon-list','fa-icon-outdent','fa-icon-indent','fa-icon-video-camera','fa-icon-picture-o','fa-icon-pencil','fa-icon-map-marker','fa-icon-adjust','fa-icon-tint','fa-icon-pencil-square-o','fa-icon-share-square-o','fa-icon-check-square-o','fa-icon-arrows','fa-icon-step-backward','fa-icon-fast-backward','fa-icon-backward','fa-icon-play','fa-icon-pause','fa-icon-stop','fa-icon-forward','fa-icon-fast-forward','fa-icon-step-forward','fa-icon-eject','fa-icon-chevron-left','fa-icon-chevron-right','fa-icon-plus-circle','fa-icon-minus-circle','fa-icon-times-circle','fa-icon-check-circle','fa-icon-question-circle','fa-icon-info-circle','fa-icon-crosshairs','fa-icon-times-circle-o','fa-icon-check-circle-o','fa-icon-ban','fa-icon-arrow-left','fa-icon-arrow-right','fa-icon-arrow-up','fa-icon-arrow-down','fa-icon-share','fa-icon-expand','fa-icon-compress','fa-icon-plus','fa-icon-minus','fa-icon-asterisk','fa-icon-exclamation-circle','fa-icon-gift','fa-icon-leaf','fa-icon-fire','fa-icon-eye','fa-icon-eye-slash','fa-icon-exclamation-triangle','fa-icon-plane','fa-icon-calendar','fa-icon-random','fa-icon-comment','fa-icon-magnet','fa-icon-chevron-up','fa-icon-chevron-down','fa-icon-retweet','fa-icon-shopping-cart','fa-icon-folder','fa-icon-folder-open','fa-icon-arrows-v','fa-icon-arrows-h','fa-icon-bar-chart','fa-icon-twitter-square','fa-icon-facebook-square','fa-icon-camera-retro','fa-icon-key','fa-icon-cogs','fa-icon-comments','fa-icon-thumbs-o-up','fa-icon-thumbs-o-down','fa-icon-star-half','fa-icon-heart-o','fa-icon-sign-out','fa-icon-linkedin-square','fa-icon-thumb-tack','fa-icon-external-link','fa-icon-sign-in','fa-icon-trophy','fa-icon-github-square','fa-icon-upload','fa-icon-lemon-o','fa-icon-phone','fa-icon-square-o','fa-icon-bookmark-o','fa-icon-phone-square','fa-icon-twitter','fa-icon-facebook','fa-icon-github','fa-icon-unlock','fa-icon-credit-card','fa-icon-rss','fa-icon-hdd-o','fa-icon-bullhorn','fa-icon-bell','fa-icon-certificate','fa-icon-hand-o-right','fa-icon-hand-o-left','fa-icon-hand-o-up','fa-icon-hand-o-down','fa-icon-arrow-circle-left','fa-icon-arrow-circle-right','fa-icon-arrow-circle-up','fa-icon-arrow-circle-down','fa-icon-globe','fa-icon-wrench','fa-icon-tasks','fa-icon-filter','fa-icon-briefcase','fa-icon-arrows-alt','fa-icon-users','fa-icon-link','fa-icon-cloud','fa-icon-flask','fa-icon-scissors','fa-icon-files-o','fa-icon-paperclip','fa-icon-floppy-o','fa-icon-square','fa-icon-bars','fa-icon-list-ul','fa-icon-list-ol','fa-icon-strikethrough','fa-icon-underline','fa-icon-table','fa-icon-magic','fa-icon-truck','fa-icon-pinterest','fa-icon-pinterest-square','fa-icon-google-plus-square','fa-icon-google-plus','fa-icon-money','fa-icon-caret-down','fa-icon-caret-up','fa-icon-caret-left','fa-icon-caret-right','fa-icon-columns','fa-icon-sort','fa-icon-sort-desc','fa-icon-sort-asc','fa-icon-envelope','fa-icon-linkedin','fa-icon-undo','fa-icon-gavel','fa-icon-tachometer','fa-icon-comment-o','fa-icon-comments-o','fa-icon-bolt','fa-icon-sitemap','fa-icon-umbrella','fa-icon-clipboard','fa-icon-lightbulb-o','fa-icon-exchange','fa-icon-cloud-download','fa-icon-cloud-upload','fa-icon-user-md','fa-icon-stethoscope','fa-icon-suitcase','fa-icon-bell-o','fa-icon-coffee','fa-icon-cutlery','fa-icon-file-text-o','fa-icon-building-o','fa-icon-hospital-o','fa-icon-ambulance','fa-icon-medkit','fa-icon-fighter-jet','fa-icon-beer','fa-icon-h-square','fa-icon-plus-square','fa-icon-angle-double-left','fa-icon-angle-double-right','fa-icon-angle-double-up','fa-icon-angle-double-down','fa-icon-angle-left','fa-icon-angle-right','fa-icon-angle-up','fa-icon-angle-down','fa-icon-desktop','fa-icon-laptop','fa-icon-tablet','fa-icon-mobile','fa-icon-circle-o','fa-icon-quote-left','fa-icon-quote-right','fa-icon-spinner','fa-icon-circle','fa-icon-reply','fa-icon-github-alt','fa-icon-folder-o','fa-icon-folder-open-o','fa-icon-smile-o','fa-icon-frown-o','fa-icon-meh-o','fa-icon-gamepad','fa-icon-keyboard-o','fa-icon-flag-o','fa-icon-flag-checkered','fa-icon-terminal','fa-icon-code','fa-icon-reply-all','fa-icon-star-half-o','fa-icon-location-arrow','fa-icon-crop','fa-icon-code-fork','fa-icon-chain-broken','fa-icon-question','fa-icon-info','fa-icon-exclamation','fa-icon-superscript','fa-icon-subscript','fa-icon-eraser','fa-icon-puzzle-piece','fa-icon-microphone','fa-icon-microphone-slash','fa-icon-shield','fa-icon-calendar-o','fa-icon-fire-extinguisher','fa-icon-rocket','fa-icon-maxcdn','fa-icon-chevron-circle-left','fa-icon-chevron-circle-right','fa-icon-chevron-circle-up','fa-icon-chevron-circle-down','fa-icon-html5','fa-icon-css3','fa-icon-anchor','fa-icon-unlock-alt','fa-icon-bullseye','fa-icon-ellipsis-h','fa-icon-ellipsis-v','fa-icon-rss-square','fa-icon-play-circle','fa-icon-ticket','fa-icon-minus-square','fa-icon-minus-square-o','fa-icon-level-up','fa-icon-level-down','fa-icon-check-square','fa-icon-pencil-square','fa-icon-external-link-square','fa-icon-share-square','fa-icon-compass','fa-icon-caret-square-o-down','fa-icon-caret-square-o-up','fa-icon-caret-square-o-right','fa-icon-eur','fa-icon-gbp','fa-icon-usd','fa-icon-inr','fa-icon-jpy','fa-icon-rub','fa-icon-krw','fa-icon-btc','fa-icon-file','fa-icon-file-text','fa-icon-sort-alpha-asc','fa-icon-sort-alpha-desc','fa-icon-sort-amount-asc','fa-icon-sort-amount-desc','fa-icon-sort-numeric-asc','fa-icon-sort-numeric-desc','fa-icon-thumbs-up','fa-icon-thumbs-down','fa-icon-youtube-square','fa-icon-youtube','fa-icon-xing','fa-icon-xing-square','fa-icon-youtube-play','fa-icon-dropbox','fa-icon-stack-overflow','fa-icon-instagram','fa-icon-flickr','fa-icon-adn','fa-icon-bitbucket','fa-icon-bitbucket-square','fa-icon-tumblr','fa-icon-tumblr-square','fa-icon-long-arrow-down','fa-icon-long-arrow-up','fa-icon-long-arrow-left','fa-icon-long-arrow-right','fa-icon-apple','fa-icon-windows','fa-icon-android','fa-icon-linux','fa-icon-dribbble','fa-icon-skype','fa-icon-foursquare','fa-icon-trello','fa-icon-female','fa-icon-male','fa-icon-gratipay','fa-icon-sun-o','fa-icon-moon-o','fa-icon-archive','fa-icon-bug','fa-icon-vk','fa-icon-weibo','fa-icon-renren','fa-icon-pagelines','fa-icon-stack-exchange','fa-icon-arrow-circle-o-right','fa-icon-arrow-circle-o-left','fa-icon-caret-square-o-left','fa-icon-dot-circle-o','fa-icon-wheelchair','fa-icon-vimeo-square','fa-icon-try','fa-icon-plus-square-o','fa-icon-space-shuttle','fa-icon-slack','fa-icon-envelope-square','fa-icon-wordpress','fa-icon-openid','fa-icon-university','fa-icon-graduation-cap','fa-icon-yahoo','fa-icon-google','fa-icon-reddit','fa-icon-reddit-square','fa-icon-stumbleupon-circle','fa-icon-stumbleupon','fa-icon-delicious','fa-icon-digg','fa-icon-pied-piper','fa-icon-pied-piper-alt','fa-icon-drupal','fa-icon-joomla','fa-icon-language','fa-icon-fax','fa-icon-building','fa-icon-child','fa-icon-paw','fa-icon-spoon','fa-icon-cube','fa-icon-cubes','fa-icon-behance','fa-icon-behance-square','fa-icon-steam','fa-icon-steam-square','fa-icon-recycle','fa-icon-car','fa-icon-taxi','fa-icon-tree','fa-icon-spotify','fa-icon-deviantart','fa-icon-soundcloud','fa-icon-database','fa-icon-file-pdf-o','fa-icon-file-word-o','fa-icon-file-excel-o','fa-icon-file-powerpoint-o','fa-icon-file-image-o','fa-icon-file-archive-o','fa-icon-file-audio-o','fa-icon-file-video-o','fa-icon-file-code-o','fa-icon-vine','fa-icon-codepen','fa-icon-jsfiddle','fa-icon-life-ring','fa-icon-circle-o-notch','fa-icon-rebel','fa-icon-empire','fa-icon-git-square','fa-icon-git','fa-icon-hacker-news','fa-icon-tencent-weibo','fa-icon-qq','fa-icon-weixin','fa-icon-paper-plane','fa-icon-paper-plane-o','fa-icon-history','fa-icon-circle-thin','fa-icon-header','fa-icon-paragraph','fa-icon-sliders','fa-icon-share-alt','fa-icon-share-alt-square','fa-icon-bomb','fa-icon-futbol-o','fa-icon-tty','fa-icon-binoculars','fa-icon-plug','fa-icon-slideshare','fa-icon-twitch','fa-icon-yelp','fa-icon-newspaper-o','fa-icon-wifi','fa-icon-calculator','fa-icon-paypal','fa-icon-google-wallet','fa-icon-cc-visa','fa-icon-cc-mastercard','fa-icon-cc-discover','fa-icon-cc-amex','fa-icon-cc-paypal','fa-icon-cc-stripe','fa-icon-bell-slash','fa-icon-bell-slash-o','fa-icon-trash','fa-icon-copyright','fa-icon-at','fa-icon-eyedropper','fa-icon-paint-brush','fa-icon-birthday-cake','fa-icon-area-chart','fa-icon-pie-chart','fa-icon-line-chart','fa-icon-lastfm','fa-icon-lastfm-square','fa-icon-toggle-off','fa-icon-toggle-on','fa-icon-bicycle','fa-icon-bus','fa-icon-ioxhost','fa-icon-angellist','fa-icon-cc','fa-icon-ils','fa-icon-meanpath','fa-icon-buysellads','fa-icon-connectdevelop','fa-icon-dashcube','fa-icon-forumbee','fa-icon-leanpub','fa-icon-sellsy','fa-icon-shirtsinbulk','fa-icon-simplybuilt','fa-icon-skyatlas','fa-icon-cart-plus','fa-icon-cart-arrow-down','fa-icon-diamond','fa-icon-ship','fa-icon-user-secret','fa-icon-motorcycle','fa-icon-street-view','fa-icon-heartbeat','fa-icon-venus','fa-icon-mars','fa-icon-mercury','fa-icon-transgender','fa-icon-transgender-alt','fa-icon-venus-double','fa-icon-mars-double','fa-icon-venus-mars','fa-icon-mars-stroke','fa-icon-mars-stroke-v','fa-icon-mars-stroke-h','fa-icon-neuter','fa-icon-genderless','fa-icon-facebook-official','fa-icon-pinterest-p','fa-icon-whatsapp','fa-icon-server','fa-icon-user-plus','fa-icon-user-times','fa-icon-bed','fa-icon-viacoin','fa-icon-train','fa-icon-subway','fa-icon-medium','fa-icon-y-combinator','fa-icon-optin-monster','fa-icon-opencart','fa-icon-expeditedssl','fa-icon-battery-full','fa-icon-battery-three-quarters','fa-icon-battery-half','fa-icon-battery-quarter','fa-icon-battery-empty','fa-icon-mouse-pointer','fa-icon-i-cursor','fa-icon-object-group','fa-icon-object-ungroup','fa-icon-sticky-note','fa-icon-sticky-note-o','fa-icon-cc-jcb','fa-icon-cc-diners-club','fa-icon-clone','fa-icon-balance-scale','fa-icon-hourglass-o','fa-icon-hourglass-start','fa-icon-hourglass-half','fa-icon-hourglass-end','fa-icon-hourglass','fa-icon-hand-rock-o','fa-icon-hand-paper-o','fa-icon-hand-scissors-o','fa-icon-hand-lizard-o','fa-icon-hand-spock-o','fa-icon-hand-pointer-o','fa-icon-hand-peace-o','fa-icon-trademark','fa-icon-registered','fa-icon-creative-commons','fa-icon-gg','fa-icon-gg-circle','fa-icon-tripadvisor','fa-icon-odnoklassniki','fa-icon-odnoklassniki-square','fa-icon-get-pocket','fa-icon-wikipedia-w','fa-icon-safari','fa-icon-chrome','fa-icon-firefox','fa-icon-opera','fa-icon-internet-explorer','fa-icon-television','fa-icon-contao','fa-icon-500px','fa-icon-amazon','fa-icon-calendar-plus-o','fa-icon-calendar-minus-o','fa-icon-calendar-times-o','fa-icon-calendar-check-o','fa-icon-industry','fa-icon-map-pin','fa-icon-map-signs','fa-icon-map-o','fa-icon-map','fa-icon-commenting','fa-icon-commenting-o','fa-icon-houzz','fa-icon-vimeo','fa-icon-black-tie','fa-icon-fonticons','fa-icon-reddit-alien','fa-icon-edge','fa-icon-credit-card-alt','fa-icon-codiepie','fa-icon-modx','fa-icon-fort-awesome','fa-icon-usb','fa-icon-product-hunt','fa-icon-mixcloud','fa-icon-scribd','fa-icon-pause-circle','fa-icon-pause-circle-o','fa-icon-stop-circle','fa-icon-stop-circle-o','fa-icon-shopping-bag','fa-icon-shopping-basket','fa-icon-hashtag','fa-icon-bluetooth','fa-icon-bluetooth-b','fa-icon-percent','momizat-icon-home','momizat-icon-home2','momizat-icon-home3','momizat-icon-office','momizat-icon-newspaper','momizat-icon-pencil','momizat-icon-pencil2','momizat-icon-quill','momizat-icon-pen','momizat-icon-blog','momizat-icon-droplet','momizat-icon-paint-format','momizat-icon-image','momizat-icon-image2','momizat-icon-images','momizat-icon-camera','momizat-icon-music','momizat-icon-headphones','momizat-icon-play','momizat-icon-film','momizat-icon-camera2','momizat-icon-dice','momizat-icon-pacman','momizat-icon-spades','momizat-icon-clubs','momizat-icon-diamonds','momizat-icon-pawn','momizat-icon-bullhorn','momizat-icon-connection','momizat-icon-podcast','momizat-icon-feed','momizat-icon-book','momizat-icon-books','momizat-icon-library','momizat-icon-file','momizat-icon-profile','momizat-icon-file2','momizat-icon-file3','momizat-icon-file4','momizat-icon-copy','momizat-icon-copy2','momizat-icon-copy3','momizat-icon-paste','momizat-icon-paste2','momizat-icon-paste3','momizat-icon-stack','momizat-icon-folder','momizat-icon-folder-open','momizat-icon-tag','momizat-icon-tags','momizat-icon-barcode','momizat-icon-qrcode','momizat-icon-ticket','momizat-icon-cart','momizat-icon-cart2','momizat-icon-cart3','momizat-icon-coin','momizat-icon-credit','momizat-icon-calculate','momizat-icon-support','momizat-icon-phone','momizat-icon-phone-hang-up','momizat-icon-address-book','momizat-icon-notebook','momizat-icon-envelope','momizat-icon-pushpin','momizat-icon-location','momizat-icon-location2','momizat-icon-compass','momizat-icon-map','momizat-icon-map2','momizat-icon-history','momizat-icon-clock','momizat-icon-clock2','momizat-icon-alarm','momizat-icon-alarm2','momizat-icon-bell','momizat-icon-stopwatch','momizat-icon-calendar','momizat-icon-calendar2','momizat-icon-print','momizat-icon-keyboard','momizat-icon-screen','momizat-icon-laptop','momizat-icon-mobile','momizat-icon-mobile2','momizat-icon-tablet','momizat-icon-tv','momizat-icon-cabinet','momizat-icon-drawer','momizat-icon-drawer2','momizat-icon-drawer3','momizat-icon-box-add','momizat-icon-box-remove','momizat-icon-download','momizat-icon-upload','momizat-icon-disk','momizat-icon-storage','momizat-icon-undo','momizat-icon-redo','momizat-icon-flip','momizat-icon-flip2','momizat-icon-undo2','momizat-icon-redo2','momizat-icon-forward','momizat-icon-reply','momizat-icon-bubble','momizat-icon-bubbles','momizat-icon-bubbles2','momizat-icon-bubble2','momizat-icon-bubbles3','momizat-icon-bubbles4','momizat-icon-user','momizat-icon-users','momizat-icon-user2','momizat-icon-users2','momizat-icon-user3','momizat-icon-user4','momizat-icon-quotes-left','momizat-icon-busy','momizat-icon-spinner','momizat-icon-spinner2','momizat-icon-spinner3','momizat-icon-spinner4','momizat-icon-spinner5','momizat-icon-spinner6','momizat-icon-binoculars','momizat-icon-search','momizat-icon-zoom-in','momizat-icon-zoom-out','momizat-icon-expand','momizat-icon-contract','momizat-icon-expand2','momizat-icon-contract2','momizat-icon-key','momizat-icon-key2','momizat-icon-lock','momizat-icon-lock2','momizat-icon-unlocked','momizat-icon-wrench','momizat-icon-settings','momizat-icon-equalizer','momizat-icon-cog','momizat-icon-cogs','momizat-icon-cog2','momizat-icon-hammer','momizat-icon-wand','momizat-icon-aid','momizat-icon-bug','momizat-icon-pie','momizat-icon-stats','momizat-icon-bars','momizat-icon-bars2','momizat-icon-gift','momizat-icon-trophy','momizat-icon-glass','momizat-icon-mug','momizat-icon-food','momizat-icon-leaf','momizat-icon-rocket','momizat-icon-meter','momizat-icon-meter2','momizat-icon-dashboard','momizat-icon-hammer2','momizat-icon-fire','momizat-icon-lab','momizat-icon-magnet','momizat-icon-remove','momizat-icon-remove2','momizat-icon-briefcase','momizat-icon-airplane','momizat-icon-truck','momizat-icon-road','momizat-icon-accessibility','momizat-icon-target','momizat-icon-shield','momizat-icon-lightning','momizat-icon-switch','momizat-icon-power-cord','momizat-icon-signup','momizat-icon-list','momizat-icon-list2','momizat-icon-numbered-list','momizat-icon-menu','momizat-icon-menu2','momizat-icon-tree','momizat-icon-cloud','momizat-icon-cloud-download','momizat-icon-cloud-upload','momizat-icon-download2','momizat-icon-upload2','momizat-icon-download3','momizat-icon-upload3','momizat-icon-globe','momizat-icon-earth','momizat-icon-link','momizat-icon-flag','momizat-icon-attachment','momizat-icon-eye','momizat-icon-eye-blocked','momizat-icon-eye2','momizat-icon-bookmark','momizat-icon-bookmarks','momizat-icon-brightness-medium','momizat-icon-brightness-contrast','momizat-icon-contrast','momizat-icon-star','momizat-icon-star2','momizat-icon-star3','momizat-icon-heart','momizat-icon-heart2','momizat-icon-heart-broken','momizat-icon-thumbs-up','momizat-icon-thumbs-up2','momizat-icon-happy','momizat-icon-happy2','momizat-icon-smiley','momizat-icon-smiley2','momizat-icon-tongue','momizat-icon-tongue2','momizat-icon-sad','momizat-icon-sad2','momizat-icon-wink','momizat-icon-wink2','momizat-icon-grin','momizat-icon-grin2','momizat-icon-cool','momizat-icon-cool2','momizat-icon-angry','momizat-icon-angry2','momizat-icon-evil','momizat-icon-evil2','momizat-icon-shocked','momizat-icon-shocked2','momizat-icon-confused','momizat-icon-confused2','momizat-icon-neutral','momizat-icon-neutral2','momizat-icon-wondering','momizat-icon-wondering2','momizat-icon-point-up','momizat-icon-point-right','momizat-icon-point-down','momizat-icon-point-left','momizat-icon-warning','momizat-icon-notification','momizat-icon-question','momizat-icon-info','momizat-icon-info2','momizat-icon-blocked','momizat-icon-cancel-circle','momizat-icon-checkmark-circle','momizat-icon-spam','momizat-icon-close','momizat-icon-checkmark','momizat-icon-checkmark2','momizat-icon-spell-check','momizat-icon-minus','momizat-icon-plus','momizat-icon-enter','momizat-icon-exit','momizat-icon-play2','momizat-icon-pause','momizat-icon-stop','momizat-icon-backward','momizat-icon-forward2','momizat-icon-play3','momizat-icon-pause2','momizat-icon-stop2','momizat-icon-backward2','momizat-icon-forward3','momizat-icon-first','momizat-icon-last','momizat-icon-previous','momizat-icon-next','momizat-icon-eject','momizat-icon-volume-high','momizat-icon-volume-medium','momizat-icon-volume-low','momizat-icon-volume-mute','momizat-icon-volume-mute2','momizat-icon-volume-increase','momizat-icon-volume-decrease','momizat-icon-loop','momizat-icon-loop2','momizat-icon-loop3','momizat-icon-shuffle','momizat-icon-arrow-up-left','momizat-icon-arrow-up','momizat-icon-arrow-up-right','momizat-icon-arrow-right','momizat-icon-arrow-down-right','momizat-icon-arrow-down','momizat-icon-arrow-down-left','momizat-icon-arrow-left','momizat-icon-arrow-up-left2','momizat-icon-arrow-up2','momizat-icon-arrow-up-right2','momizat-icon-arrow-right2','momizat-icon-arrow-down-right2','momizat-icon-arrow-down2','momizat-icon-arrow-down-left2','momizat-icon-arrow-left2','momizat-icon-arrow-up-left3','momizat-icon-arrow-up3','momizat-icon-arrow-up-right3','momizat-icon-arrow-right3','momizat-icon-arrow-down-right3','momizat-icon-arrow-down3','momizat-icon-arrow-down-left3','momizat-icon-arrow-left3','momizat-icon-tab','momizat-icon-checkbox-checked','momizat-icon-checkbox-uncheckedi','momizat-icon-checkbox-partial','momizat-icon-radio-checked','momizat-icon-radio-unchecked','momizat-icon-crop','momizat-icon-scissors','momizat-icon-filter','momizat-icon-filter2','momizat-icon-font','momizat-icon-text-height','momizat-icon-text-width','momizat-icon-bold','momizat-icon-underline','momizat-icon-italic','momizat-icon-strikethrough','momizat-icon-omega','momizat-icon-sigma','momizat-icon-table','momizat-icon-table2','momizat-icon-insert-template','momizat-icon-pilcrow','momizat-icon-left-toright','momizat-icon-right-toleft','momizat-icon-paragraph-left','momizat-icon-paragraph-center','momizat-icon-paragraph-right','momizat-icon-paragraph-justify','momizat-icon-paragraph-left2','momizat-icon-paragraph-center2','momizat-icon-paragraph-right2','momizat-icon-paragraph-justify2i','momizat-icon-indent-increase','momizat-icon-indent-decrease','momizat-icon-new-tab','momizat-icon-embed','momizat-icon-code','momizat-icon-console','momizat-icon-share','momizat-icon-mail','momizat-icon-mail2','momizat-icon-mail3','momizat-icon-mail4','momizat-icon-google','momizat-icon-google-plus','momizat-icon-google-plus2','momizat-icon-google-plus3','momizat-icon-google-plus4','momizat-icon-google-drive','momizat-icon-facebook','momizat-icon-facebook2','momizat-icon-facebook3','momizat-icon-instagram','momizat-icon-twitter','momizat-icon-twitter2','momizat-icon-twitter3','momizat-icon-feed2','momizat-icon-feed3','momizat-icon-feed4','momizat-icon-youtube','momizat-icon-youtube2','momizat-icon-vimeo','momizat-icon-vimeo2','momizat-icon-vimeo3','momizat-icon-lanyrd','momizat-icon-flickr','momizat-icon-flickr2','momizat-icon-flickr3','momizat-icon-flickr4','momizat-icon-picassa','momizat-icon-picassa2','momizat-icon-dribbble','momizat-icon-dribbble2','momizat-icon-dribbble3','momizat-icon-forrst','momizat-icon-forrst2','momizat-icon-deviantart','momizat-icon-deviantart2','momizat-icon-steam','momizat-icon-steam2','momizat-icon-github','momizat-icon-github2','momizat-icon-github3','momizat-icon-github4','momizat-icon-github5','momizat-icon-wordpress','momizat-icon-wordpress2','momizat-icon-joomla','momizat-icon-blogger','momizat-icon-blogger2','momizat-icon-tumblr','momizat-icon-tumblr2','momizat-icon-yahoo','momizat-icon-tux','momizat-icon-apple','momizat-icon-finder','momizat-icon-android','momizat-icon-windows','momizat-icon-windows8','momizat-icon-soundcloud','momizat-icon-soundcloud2','momizat-icon-skype','momizat-icon-reddit','momizat-icon-linkedin','momizat-icon-lastfm','momizat-icon-lastfm2','momizat-icon-delicious','momizat-icon-stumbleupon','momizat-icon-stumbleupon2','momizat-icon-stackoverflow','momizat-icon-pinterest','momizat-icon-pinterest2','momizat-icon-xing','momizat-icon-xing2','momizat-icon-flattr','momizat-icon-foursquare','momizat-icon-foursquare2','momizat-icon-paypal','momizat-icon-paypal2','momizat-icon-paypal3','momizat-icon-yelp','momizat-icon-libreoffice','momizat-icon-file-pdf','momizat-icon-file-openoffice','momizat-icon-file-word','momizat-icon-file-excel','momizat-icon-file-zip','momizat-icon-file-powerpoint','momizat-icon-file-xml','momizat-icon-file-css','momizat-icon-html5','momizat-icon-html52','momizat-icon-css3','momizat-icon-chrome','momizat-icon-firefox','momizat-icon-IE','momizat-icon-opera','momizat-icon-safari','brankic-icon-number','brankic-icon-number2','brankic-icon-number3','brankic-icon-number4','brankic-icon-number5','brankic-icon-number6','brankic-icon-number7','brankic-icon-number8','brankic-icon-number9','brankic-icon-number10','brankic-icon-number11','brankic-icon-number12','brankic-icon-number13','brankic-icon-number14','brankic-icon-number15','brankic-icon-number16','brankic-icon-number17','brankic-icon-number18','brankic-icon-number19','brankic-icon-number20','brankic-icon-quote','brankic-icon-quote2','brankic-icon-tag','brankic-icon-tag2','brankic-icon-link','brankic-icon-link2','brankic-icon-cabinet','brankic-icon-cabinet2','brankic-icon-calendar','brankic-icon-calendar2','brankic-icon-calendar3','brankic-icon-file','brankic-icon-file2','brankic-icon-file3','brankic-icon-files','brankic-icon-phone','brankic-icon-tablet','brankic-icon-window','brankic-icon-monitor','brankic-icon-ipod','brankic-icon-tv','brankic-icon-camera','brankic-icon-camera2','brankic-icon-camera3','brankic-icon-film','brankic-icon-film2','brankic-icon-film3','brankic-icon-microphone','brankic-icon-microphone2','brankic-icon-microphone3','brankic-icon-drink','brankic-icon-drink2','brankic-icon-drink3','brankic-icon-drink4','brankic-icon-coffee','brankic-icon-mug','brankic-icon-ice-cream','brankic-icon-cake','brankic-icon-inbox','brankic-icon-download','brankic-icon-upload','brankic-icon-inbox2','brankic-icon-checkmark','brankic-icon-checkmark2','brankic-icon-cancel','brankic-icon-cancel2','brankic-icon-plus','brankic-icon-plus2','brankic-icon-minus','brankic-icon-minus2','brankic-icon-notice','brankic-icon-notice2','brankic-icon-cog','brankic-icon-cogs','brankic-icon-cog2','brankic-icon-warning','brankic-icon-health','brankic-icon-suitcase','brankic-icon-suitcase2','brankic-icon-suitcase3','brankic-icon-picture','brankic-icon-pictures','brankic-icon-pictures2','brankic-icon-android','brankic-icon-marvin','brankic-icon-pacman','brankic-icon-cassette','brankic-icon-watch','brankic-icon-chronometer','brankic-icon-watch2','brankic-icon-alarm-clock','brankic-icon-time','brankic-icon-time2','brankic-icon-headphones','brankic-icon-wallet','brankic-icon-checkmark3','brankic-icon-cancel3','brankic-icon-eye','brankic-icon-position','brankic-icon-site-map','brankic-icon-site-map2','brankic-icon-cloud','brankic-icon-upload2','brankic-icon-chart','brankic-icon-chart2','brankic-icon-chart3','brankic-icon-chart4','brankic-icon-chart5','brankic-icon-chart6','brankic-icon-location','brankic-icon-download2','brankic-icon-basket','brankic-icon-folder','brankic-icon-gamepad','brankic-icon-alarm','brankic-icon-alarm-cancel','brankic-icon-phone2','brankic-icon-phone3','brankic-icon-image','brankic-icon-open','brankic-icon-sale','brankic-icon-direction','brankic-icon-map','brankic-icon-trashcan','brankic-icon-vote','brankic-icon-graduate','brankic-icon-lab','brankic-icon-tie','brankic-icon-football','brankic-icon-eight-ball','brankic-icon-bowling','brankic-icon-bowling-pin','brankic-icon-baseball','brankic-icon-soccer','brankic-icon-3d-glasses','brankic-icon-microwave','brankic-icon-refrigerator','brankic-icon-oven','brankic-icon-washing-machine"b','brankic-icon-mouse','brankic-icon-smiley','brankic-icon-sad','brankic-icon-mute','brankic-icon-hand','brankic-icon-radio','brankic-icon-satellite','brankic-icon-medal','brankic-icon-medal2','brankic-icon-switch','brankic-icon-key','brankic-icon-cord','brankic-icon-locked','brankic-icon-unlocked','brankic-icon-locked2','brankic-icon-unlocked2','brankic-icon-magnifier','brankic-icon-zoom-in','brankic-icon-zoom-out','brankic-icon-stack','brankic-icon-stack2','brankic-icon-stack3','brankic-icon-moon-andstar','brankic-icon-transformers','brankic-icon-batman','brankic-icon-space-invaders','brankic-icon-skeletor','brankic-icon-lamp','brankic-icon-lamp2','brankic-icon-umbrella','brankic-icon-street-light','brankic-icon-bomb','brankic-icon-archive','brankic-icon-battery','brankic-icon-battery2','brankic-icon-battery3','brankic-icon-battery4','brankic-icon-battery5','brankic-icon-megaphone','brankic-icon-megaphone2','brankic-icon-patch','brankic-icon-pil','brankic-icon-injection','brankic-icon-thermometer','brankic-icon-lamp3','brankic-icon-lamp4','brankic-icon-lamp5','brankic-icon-cube','brankic-icon-box','brankic-icon-box2','brankic-icon-diamond','brankic-icon-bag','brankic-icon-money-bag','brankic-icon-grid','brankic-icon-grid2','brankic-icon-list','brankic-icon-list2','brankic-icon-ruler','brankic-icon-ruler2','brankic-icon-layout','brankic-icon-layout2','brankic-icon-layout3','brankic-icon-layout4','brankic-icon-layout5','brankic-icon-layout6','brankic-icon-layout7','brankic-icon-layout8','brankic-icon-layout9','brankic-icon-layout10','brankic-icon-layout11','brankic-icon-layout12','brankic-icon-layout13','brankic-icon-layout14','brankic-icon-tools','brankic-icon-screwdriver','brankic-icon-paint','brankic-icon-hammer','brankic-icon-brush','brankic-icon-pen','brankic-icon-chat','brankic-icon-comments','brankic-icon-chat2','brankic-icon-chat3','brankic-icon-volume','brankic-icon-volume2','brankic-icon-volume3','brankic-icon-equalizer','brankic-icon-resize','brankic-icon-resize2','brankic-icon-stretch','brankic-icon-narrow','brankic-icon-resize3','brankic-icon-download3','brankic-icon-calculator','brankic-icon-library','brankic-icon-auction','brankic-icon-justice','brankic-icon-stats','brankic-icon-stats2','brankic-icon-attachment','brankic-icon-hourglass','brankic-icon-abacus','brankic-icon-pencil','brankic-icon-pen2','brankic-icon-pin','brankic-icon-pin2','brankic-icon-discout','brankic-icon-edit','brankic-icon-scissors','brankic-icon-profile','brankic-icon-profile2','brankic-icon-profile3','brankic-icon-rotate','brankic-icon-rotate2','brankic-icon-reply','brankic-icon-forward','brankic-icon-retweet','brankic-icon-shuffle','brankic-icon-loop','brankic-icon-crop','brankic-icon-square','brankic-icon-square2','brankic-icon-circle','brankic-icon-dollar','brankic-icon-dollar2','brankic-icon-coins','brankic-icon-pig','brankic-icon-bookmark','brankic-icon-bookmark2','brankic-icon-address-book','brankic-icon-address-book2','brankic-icon-safe','brankic-icon-envelope','brankic-icon-envelope2','brankic-icon-radio-active','brankic-icon-music','brankic-icon-presentation','brankic-icon-male','brankic-icon-female','brankic-icon-aids','brankic-icon-heart','brankic-icon-info','brankic-icon-info2','brankic-icon-piano','brankic-icon-rain','brankic-icon-snow','brankic-icon-lightning','brankic-icon-sun','brankic-icon-moon','brankic-icon-cloudy','brankic-icon-cloudy2','brankic-icon-car','brankic-icon-bike','brankic-icon-truck','brankic-icon-bus','brankic-icon-bike2','brankic-icon-plane','brankic-icon-paper-plane','brankic-icon-rocket','brankic-icon-book','brankic-icon-book2','brankic-icon-barcode','brankic-icon-barcode2','brankic-icon-expand','brankic-icon-collapse','brankic-icon-pop-out','brankic-icon-pop-in','brankic-icon-target','brankic-icon-badge','brankic-icon-badge2','brankic-icon-ticket','brankic-icon-ticket2','brankic-icon-ticket3','brankic-icon-microphone4','brankic-icon-cone','brankic-icon-blocked','brankic-icon-stop','brankic-icon-keyboard','brankic-icon-keyboard2','brankic-icon-radio2','brankic-icon-printer','brankic-icon-checked','brankic-icon-error','brankic-icon-add','brankic-icon-minus3','brankic-icon-alert','brankic-icon-pictures3','brankic-icon-atom','brankic-icon-eyedropper','brankic-icon-globe','brankic-icon-globe2','brankic-icon-shipping','brankic-icon-ying-yang','brankic-icon-compass','brankic-icon-zip','brankic-icon-zip2','brankic-icon-anchor','brankic-icon-locked-heart','brankic-icon-magnet','brankic-icon-navigation','brankic-icon-tags','brankic-icon-heart2','brankic-icon-heart3','brankic-icon-usb','brankic-icon-clipboard','brankic-icon-clipboard2','brankic-icon-clipboard3','brankic-icon-switch2','brankic-icon-ruler3','enotype-icon-phone','enotype-icon-mobile','enotype-icon-mouse','enotype-icon-directions','enotype-icon-mail','enotype-icon-paperplane','enotype-icon-pencil','enotype-icon-feather','enotype-icon-paperclip','enotype-icon-drawer','enotype-icon-reply','enotype-icon-reply-all','enotype-icon-forward','enotype-icon-user','enotype-icon-users','enotype-icon-user-add','enotype-icon-vcard','enotype-icon-export','enotype-icon-location','enotype-icon-map','enotype-icon-compass','enotype-icon-location2','enotype-icon-target','enotype-icon-share','enotype-icon-sharable','enotype-icon-heart','enotype-icon-heart2','enotype-icon-star','enotype-icon-star2','enotype-icon-thumbs-up','enotype-icon-thumbs-down','enotype-icon-chat','enotype-icon-comment','enotype-icon-quote','enotype-icon-house','enotype-icon-popup','enotype-icon-search','enotype-icon-flashlight','enotype-icon-printer','enotype-icon-bell','enotype-icon-link','enotype-icon-flag','enotype-icon-cog','enotype-icon-tools','enotype-icon-trophy','enotype-icon-tag','enotype-icon-camera','enotype-icon-megaphone','enotype-icon-moon','enotype-icon-palette','enotype-icon-leaf','enotype-icon-music','enotype-icon-music2','enotype-icon-new','enotype-icon-graduation','enotype-icon-book','enotype-icon-newspaper','enotype-icon-bag','enotype-icon-airplane','enotype-icon-lifebuoy','enotype-icon-eye','enotype-icon-clock','enotype-icon-microphone','enotype-icon-calendar','enotype-icon-bolt','enotype-icon-thunder','enotype-icon-droplet','enotype-icon-cd','enotype-icon-briefcase','enotype-icon-air','enotype-icon-hourglass','enotype-icon-gauge','enotype-icon-language','enotype-icon-network','enotype-icon-key','enotype-icon-battery','enotype-icon-bucket','enotype-icon-magnet','enotype-icon-drive','enotype-icon-cup','enotype-icon-rocket','enotype-icon-brush','enotype-icon-suitcase','enotype-icon-cone','enotype-icon-earth','enotype-icon-keyboard','enotype-icon-browser','enotype-icon-publish','enotype-icon-progress-3','enotype-icon-progress-2','enotype-icon-brogress-1','enotype-icon-progress-0','enotype-icon-sun','enotype-icon-sun2','enotype-icon-adjust','enotype-icon-code','enotype-icon-screen','enotype-icon-infinity','enotype-icon-light-bulb','enotype-icon-credit-card','enotype-icon-database','enotype-icon-voicemail','enotype-icon-clipboard','enotype-icon-cart','enotype-icon-box','enotype-icon-ticket','enotype-icon-rss','enotype-icon-signal','enotype-icon-thermometer','enotype-icon-droplets','enotype-icon-uniE66E','enotype-icon-statistics','enotype-icon-pie','enotype-icon-bars','enotype-icon-graph','enotype-icon-lock','enotype-icon-lock-open','enotype-icon-logout','enotype-icon-login','enotype-icon-checkmark','enotype-icon-cross','enotype-icon-minus','enotype-icon-plus','enotype-icon-cross2','enotype-icon-minus2','enotype-icon-plus2','enotype-icon-cross3','enotype-icon-minus3','enotype-icon-plus3','enotype-icon-erase','enotype-icon-blocked','enotype-icon-info','enotype-icon-info2','enotype-icon-question','enotype-icon-help','enotype-icon-warning','enotype-icon-cycle','enotype-icon-cw','enotype-icon-ccw','enotype-icon-shuffle','enotype-icon-arrow','enotype-icon-arrow2','enotype-icon-retweet','enotype-icon-loop','enotype-icon-history','enotype-icon-back','enotype-icon-switch','enotype-icon-list','enotype-icon-add-to-list','enotype-icon-layout','enotype-icon-list2','enotype-icon-text','enotype-icon-text2','enotype-icon-document','enotype-icon-docs','enotype-icon-landscape','enotype-icon-pictures','enotype-icon-video','enotype-icon-music3','enotype-icon-folder','enotype-icon-archive','enotype-icon-trash','enotype-icon-upload','enotype-icon-download','enotype-icon-disk','enotype-icon-install','enotype-icon-cloud','enotype-icon-upload2','enotype-icon-bookmark','enotype-icon-bookmarks','enotype-icon-book2','enotype-icon-play','enotype-icon-pause','enotype-icon-record','enotype-icon-stop','enotype-icon-next','enotype-icon-previous','enotype-icon-first','enotype-icon-last','enotype-icon-resize-enlarge','enotype-icon-resize-shrink','enotype-icon-volume','enotype-icon-sound','enotype-icon-mute','enotype-icon-flow-cascade','enotype-icon-flow-branch','enotype-icon-flow-tree','enotype-icon-flow-line','enotype-icon-flow-parallel','enotype-icon-arrow-left','enotype-icon-arrow-down','enotype-icon-arrow-up--upload"en','enotype-icon-arrow-right','enotype-icon-arrow-left2','enotype-icon-arrow-down2','enotype-icon-arrow-up','enotype-icon-arrow-right2','enotype-icon-arrow-left3','enotype-icon-arrow-down3','enotype-icon-arrow-up2','enotype-icon-arrow-right3','enotype-icon-arrow-left4','enotype-icon-arrow-down4','enotype-icon-arrow-up3','enotype-icon-arrow-right4','enotype-icon-arrow-left5','enotype-icon-arrow-down5','enotype-icon-arrow-up4','enotype-icon-arrow-right5','enotype-icon-arrow-left6','enotype-icon-arrow-down6','enotype-icon-arrow-up5','enotype-icon-arrow-right6','enotype-icon-arrow-left7','enotype-icon-arrow-down7','enotype-icon-arrow-up6','enotype-icon-uniE6D8','enotype-icon-arrow-left8','enotype-icon-arrow-down8','enotype-icon-arrow-up7','enotype-icon-arrow-right7','enotype-icon-menu','enotype-icon-ellipsis','enotype-icon-dots','enotype-icon-dot','enotype-icon-cc','enotype-icon-cc-by','enotype-icon-cc-nc','enotype-icon-cc-nc-eu','enotype-icon-cc-nc-jp','enotype-icon-cc-sa','enotype-icon-cc-nd','enotype-icon-cc-pd','enotype-icon-cc-zero','enotype-icon-cc-share','enotype-icon-cc-share2','enotype-icon-daniel-bruce','enotype-icon-daniel-bruce2','enotype-icon-github','enotype-icon-github2','enotype-icon-flickr','enotype-icon-flickr2','enotype-icon-vimeo','enotype-icon-vimeo2','enotype-icon-twitter','enotype-icon-twitter2','enotype-icon-facebook','enotype-icon-facebook2','enotype-icon-facebook3','enotype-icon-googleplus','enotype-icon-googleplus2','enotype-icon-pinterest','enotype-icon-pinterest2','enotype-icon-tumblr','enotype-icon-tumblr2','enotype-icon-linkedin','enotype-icon-linkedin2','enotype-icon-dribbble','enotype-icon-dribbble2','enotype-icon-stumbleupon','enotype-icon-stumbleupon2','enotype-icon-lastfm','enotype-icon-lastfm2','enotype-icon-rdio','enotype-icon-rdio2','enotype-icon-spotify','enotype-icon-spotify2','enotype-icon-qq','enotype-icon-instagram','enotype-icon-dropbox','enotype-icon-evernote','enotype-icon-flattr','enotype-icon-skype','enotype-icon-skype2','enotype-icon-renren','enotype-icon-sina-weibo','enotype-icon-paypal','enotype-icon-picasa','enotype-icon-soundcloud','enotype-icon-mixi','enotype-icon-behance','enotype-icon-circles','enotype-icon-vk','enotype-icon-smashing','linecon-icon-heart','linecon-icon-cloud','linecon-icon-star','linecon-icon-tv','linecon-icon-sound','linecon-icon-video','linecon-icon-trash','linecon-icon-user','linecon-icon-key','linecon-icon-search','linecon-icon-settings','linecon-icon-camera','linecon-icon-tag','linecon-icon-lock','linecon-icon-bulb','linecon-icon-pen','linecon-icon-diamond','linecon-icon-display','linecon-icon-location','linecon-icon-eye','linecon-icon-bubble','linecon-icon-stack','linecon-icon-cup','linecon-icon-phone','linecon-icon-news','linecon-icon-mail','linecon-icon-like','linecon-icon-photo','linecon-icon-note','linecon-icon-clock','linecon-icon-paperplane','linecon-icon-params','linecon-icon-banknote','linecon-icon-data','linecon-icon-music','linecon-icon-megaphone','linecon-icon-study','linecon-icon-lab','linecon-icon-food','linecon-icon-t-shirt','linecon-icon-fire','linecon-icon-clip','linecon-icon-shop','linecon-icon-calendar','linecon-icon-wallet','linecon-icon-vynil','linecon-icon-truck','linecon-icon-world"<ts Ic','steady-icon-type','steady-icon-box','steady-icon-archive','steady-icon-envelope','steady-icon-email','steady-icon-files','steady-icon-uniE606','steady-icon-file-settings','steady-icon-file-add','steady-icon-file','steady-icon-align-left','steady-icon-align-right','steady-icon-align-center','steady-icon-align-justify','steady-icon-file-broken','steady-icon-browser','steady-icon-windows','steady-icon-window','steady-icon-folder','steady-icon-folder-add','steady-icon-folder-settings','steady-icon-folder-check','steady-icon-wifi-low','steady-icon-wifi-mid','steady-icon-wifi-full','steady-icon-connection-empty','steady-icon-connection-25','steady-icon-connection-50','steady-icon-connection-75','steady-icon-connection-full','steady-icon-list','steady-icon-grid','steady-icon-uniE620','steady-icon-battery-charging','steady-icon-battery-empty','steady-icon-battery-25','steady-icon-battery-50','steady-icon-battery-75','steady-icon-battery-full','steady-icon-settings','steady-icon-arrow-left','steady-icon-arrow-up','steady-icon-arrow-down','steady-icon-arrow-right','steady-icon-reload','steady-icon-refresh','steady-icon-volume','steady-icon-volume-increase','steady-icon-volume-decrease','steady-icon-mute','steady-icon-microphone','steady-icon-microphone-off','steady-icon-book','steady-icon-checkmark','steady-icon-checkbox-checked','steady-icon-checkbox','steady-icon-paperclip','steady-icon-download','steady-icon-tag','steady-icon-trashcan','steady-icon-search','steady-icon-zoom-in','steady-icon-zoom-out','steady-icon-chat','steady-icon-chat-1','steady-icon-chat-2','steady-icon-chat-3','steady-icon-comment','steady-icon-calendar','steady-icon-bookmark','steady-icon-email2','steady-icon-heart','steady-icon-enter','steady-icon-cloud','steady-icon-book2','steady-icon-star','steady-icon-clock','steady-icon-printer','steady-icon-home','steady-icon-flag','steady-icon-meter','steady-icon-switch','steady-icon-forbidden','steady-icon-lock','steady-icon-unlocked','steady-icon-unlocked2','steady-icon-users','steady-icon-user','steady-icon-users2','steady-icon-user2','steady-icon-bullhorn','steady-icon-share','steady-icon-screen','steady-icon-phone','steady-icon-phone-portrait','steady-icon-phone-landscape','steady-icon-tablet','steady-icon-tablet-landscape','steady-icon-laptop','steady-icon-camera','steady-icon-microwave-oven','steady-icon-credit-cards','steady-icon-calculator','steady-icon-bag','steady-icon-diamond','steady-icon-drink','steady-icon-shorts','steady-icon-vcard','steady-icon-sun','steady-icon-bill','steady-icon-coffee','steady-icon-uniE66F','steady-icon-newspaper','steady-icon-stack','steady-icon-map-marker','steady-icon-map','steady-icon-support','steady-icon-uniE675','steady-icon-barbell','steady-icon-stopwatch','steady-icon-atom','steady-icon-syringe','steady-icon-health','steady-icon-bolt','steady-icon-pill','steady-icon-bones','steady-icon-lab','steady-icon-clipboard','steady-icon-mug','steady-icon-bucket','steady-icon-select','steady-icon-graph','steady-icon-crop','steady-icon-image','steady-icon-cube','steady-icon-bars','steady-icon-chart','steady-icon-pencil','steady-icon-measure','steady-icon-eyedropper');
	return $icons;

}