<?php
/**
 * Custom meta fields | Fields
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/* 
 * Fields
 * 
 * Get Fields for Sections and Items 
 */

if( ! function_exists( 'mfn_get_fields_section' ) )
{
	/**
	 * GET Fields | Section
	 *
	 * @return array
	 */
	function mfn_get_fields_section(){

		$fields = array(

			array(
				'id' 		=> 'title',
				'type' 		=> 'text',
				'title' 	=> __('Title', 'mfn-opts'),
				'desc' 		=> __('This field is used as an Section Label in admin panel only', 'mfn-opts'),
			),
				
			array(
				'id' 		=> 'info_background',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Background', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
				
			array(
				'id' 		=> 'bg_color',
				'type' 		=> 'text',
				'title' 	=> __('Background | Color', 'mfn-opts'),
				'desc' 		=> __('Use color name ( gray ) or hex ( #808080 ). Leave this field blank if you want to use transparent background', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
	
			array(
				'id'		=> 'bg_image',
				'type'		=> 'upload',
				'title'		=> __('Background | Image', 'mfn-opts'),
				'desc'		=> __('Recommended size: 1920x1200', 'mfn-opts'),
			),
	
			array(
				'id' 		=> 'bg_position',
				'type' 		=> 'select',
				'title' 	=> __('Background | Position', 'mfn-opts'),
				'desc' 		=> __('This option can be used only with your custom image selected above', 'mfn-opts'),
				'options' 	=> mfna_bg_position(),
				'std' 		=> 'center top no-repeat',
			),
	
			array(
				'id'		=> 'bg_video_mp4',
				'type'		=> 'upload',
				'title'		=> __('Background | Video HTML5', 'mfn-opts'),
				'sub_desc'	=> __('m4v [.mp4]', 'mfn-opts'),
				'desc'		=> __('Please add both mp4 and ogv for cross-browser compatibility. Background Image will be used as video placeholder before video loads and on mobile devices', 'mfn-opts'),
				'class'		=> __('video', 'mfn-opts'),
			),
				
			array(
				'id'		=> 'bg_video_ogv',
				'type'		=> 'upload',
				'title'		=> __('Background | Video HTML5', 'mfn-opts'),
				'sub_desc'	=> __('ogg [.ogv]', 'mfn-opts'),
				'class'		=> __('video', 'mfn-opts'),
			),
				
			array(
				'id' 		=> 'info_layout',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Layout', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
	
			array(
				'id' 		=> 'padding_top',
				'type'		=> 'text',
				'title' 	=> __('Padding | Top', 'mfn-opts'),
				'sub_desc'	=> __('Section Padding Top', 'mfn-opts'),
				'desc' 		=> __('px', 'mfn-opts'),
				'class' 	=> 'small-text',
				'std' 		=> '0',
			),
	
			array(
				'id' 		=> 'padding_bottom',
				'type'		=> 'text',
				'title' 	=> __('Padding | Bottom', 'mfn-opts'),
				'sub_desc'	=> __('Section Padding Bottom', 'mfn-opts'),
				'desc' 		=> __('px', 'mfn-opts'),
				'class' 	=> 'small-text',
				'std' 		=> '0',
			),
				
			array(
				'id' 		=> 'info_options',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Options', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
	
			array(
				'id' 		=> 'divider',
				'type' 		=> 'select',
				'title' 	=> __('Separator', 'mfn-opts'),
				'sub_desc'	=> __('Section Separator', 'mfn-opts'),
				'desc' 		=> __('Works only with <b>background color</b> selected above. Do <b>not</b> work with parallax and some section\'s styles', 'mfn-opts'),
				'options' 	=> array(
					'' 						=> 'None',
					'circle up' 			=> 'Circle Up',
					'circle down' 			=> 'Circle Down',
					'square up' 			=> 'Square Up',
					'square down' 			=> 'Square Down',
					'triangle up' 			=> 'Triangle Up',
					'triangle down' 		=> 'Triangle Down',
					'triple-triangle up' 	=> 'Triple Triangle Up',
					'triple-triangle down' 	=> 'Triple Triangle Down',
				),
			),
	
			array(
				'id' 		=> 'navigation',
				'type' 		=> 'select',
				'title' 	=> __('Navigation', 'mfn-opts'),
				'options' 	=> array(
					'' 				=> 'None',
					'arrows' 		=> 'Arrows',
				),
			),
				
			array(
				'id' 		=> 'info_advanced',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Advanced', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
				
			array(
				'id' 		=> 'style',
				'type' 		=> 'select',
				'title' 	=> __('Style', 'mfn-opts'),
				'sub_desc'	=> __('Predefined styles for section', 'mfn-opts'),
				'desc' 		=> __('For more advanced styles please use Custom CSS field below', 'mfn-opts'),
				'options' 	=> array(
					'' 										=> '-- Default --',
					'no-margin-h'							=> 'Columns without Horizontal margins | no-margin-h',
					'no-margin'	 							=> 'Columns without Vertical margin | no-margin-v',
					'no-margin-h no-margin-v'				=> 'Columns without Any margins | no-margin-h no-margin-v',
					'dark' 									=> 'Dark | dark',
					'equal-height'							=> 'Equal Height of Items in wrap | equal-height',
					'equal-height-wrap'						=> 'Equal Height of Wraps | equal-height-wrap',
					'full-screen'	 						=> 'Full Screen | full-screen',
					'full-width'	 						=> 'Full Width | full-width',
					'full-width no-margin-h no-margin-v'	=> 'Full Width without margins | full-width no-margin-h no-margin-v',
					'full-width-ex-mobile'					=> 'Full Width except mobile | full-width-ex-mobile',
					'highlight-left' 						=> 'Highlight Left (use two 1/2 wraps) | highlight-left',
					'highlight-right' 						=> 'Highlight Right (use two 1/2 wraps) | highlight-right',
				),
			),
				
			array(
				'id' 		=> 'class',
				'type' 		=> 'text',
				'title' 	=> __('Custom | Classes', 'mfn-opts'),
				'desc'		=> __('Multiple classes should be separated with SPACE. For sections with centered text you can use class: <strong>center</strong>', 'mfn-opts'),
			),
				
			array(
				'id' 		=> 'section_id',
				'type' 		=> 'text',
				'title' 	=> __('Custom | ID', 'mfn-opts'),
				'desc'		=> __('Use this option to create One Page sites.<br />Example: Your <b>Custom ID</b> is <strong>offer</strong> and you want to open this section, please use link: <strong>your-url/#offer</strong>', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
				
			array(
				'id' 		=> 'visibility',
				'type' 		=> 'select',
				'title' 	=> __('Responsive Visibility', 'mfn-opts'),
				'options' 	=> array(
					'' 							=> '-- Default --',
					'hide-desktop' 				=> 'Hide on Desktop | 960px +',			// 960 +
					'hide-tablet' 				=> 'Hide on Tablet | 768px - 959px',	// 768 - 959
					'hide-mobile' 				=> 'Hide on Mobile | - 768px',			// - 768
					'hide-desktop hide-tablet' 	=> 'Hide on Desktop & Tablet',
					'hide-desktop hide-mobile' 	=> 'Hide on Desktop & Mobile',
					'hide-tablet hide-mobile'	=> 'Hide on Tablet & Mobile',
				),
			),
				
			array(
				'id' 		=> 'hide',
				'type' 		=> 'text',
				'title' 	=> __('Hide', 'mfn-opts'),
				'class' 	=> 'hidden',
			),
			
		);
		
		return $fields;
		
	}
}


if( ! function_exists( 'mfn_get_fields_wrap' ) )
{
	/**
	 * GET Fields | Wrap
	 *
	 * @return array
	 */
	function mfn_get_fields_wrap(){

		$fields = array(
				
			array(
				'id' 		=> 'bg_color',
				'type' 		=> 'text',
				'title' 	=> __('Background | Color', 'mfn-opts'),
				'desc' 		=> __('Use color name ( gray ) or hex ( #808080 ). Leave this field blank if you want to use transparent background', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
	
			array(
				'id'		=> 'bg_image',
				'type'		=> 'upload',
				'title'		=> __('Background | Image', 'mfn-opts'),
			),
	
			array(
				'id' 		=> 'bg_position',
				'type' 		=> 'select',
				'title' 	=> __('Background | Position', 'mfn-opts'),
				'desc' 		=> __('This option can be used only with your custom image selected above', 'mfn-opts'),
				'options' 	=> mfna_bg_position(),
				'std' 		=> 'center top no-repeat',
			),
				
			// options
			array(
				'id' 		=> 'info_options',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Options', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
			
			array(
				'id' 		=> 'move_up',
				'type' 		=> 'text',
				'title' 	=> __('Move Up', 'mfn-opts'),
				'desc' 		=> __('px<br />Move this wrap to overflow on previous section. Do <b>not</b> work with <b>parallax</b>', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
				
			array(
				'id' 		=> 'padding',
				'type' 		=> 'text',
				'title' 	=> __('Padding', 'mfn-opts'),
				'desc' 		=> __('Use value with <b>px</b> or <b>%</b>. Example: <b>20px</b> or <b>20px 10px 20px 10px</b> or <b>20px 1%</b>', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
				
			// items
			array(
				'id' 		=> 'info_items',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Items <span>Options for inner items</span>', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),

			array(
				'id' 		=> 'column_margin',
				'type' 		=> 'select',
				'title' 	=> __('Margin Bottom', 'mfn-opts'),
				'options' 	=> array(
					''			=> '-- Default --',
					'0px'		=> '0px',
					'10px'		=> '10px',
					'20px'		=> '20px',
					'30px'		=> '30px',
					'40px'		=> '40px',
					'50px'		=> '50px',
				),
			),
				
			array(
				'id' 		=> 'vertical_align',
				'type' 		=> 'select',
				'title' 	=> __('Vertical Align', 'mfn-opts'),
				'desc' 		=> __('Use with Section Style: <b>Equal Height of Wraps</b>', 'mfn-opts'),
				'options' 	=> array(
					'top' 		=> 'Top',
					'middle'	=> 'Middle',
					'bottom'	=> 'Bottom',
				),
			),
	
			// advanced
			array(
				'id' 		=> 'info_advanced',
				'type' 		=> 'info',
				'title' 	=> '',
				'desc' 		=> __('Advanced', 'mfn-opts'),
				'class' 	=> 'mfn-info',
			),
				
			array(
				'id' 		=> 'class',
				'type' 		=> 'text',
				'title' 	=> __('Custom | Classes', 'mfn-opts'),
				'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
			),
			
		);
		
		return $fields;
		
	}
}


if( ! function_exists( 'mfn_get_fields_item' ) )
{
	/**
	 * GET Fields | Item
	 * 
	 * If param $item is empty return items list
	 *
	 * @param string $item Item name
	 * @return array
	 */
	function mfn_get_fields_item( $item = false ){
		
		$items = array(
		
			// Placeholder ----------------------------------------------------
				
			'placeholder' => array(
				'type' 		=> 'placeholder',
				'title' 	=> __('- Placeholder', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'other',
				'fields'	=> array(

					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This is Muffin Builder Placeholder.', 'nhp-opts'),
					),
							
				),
			),
		
			// Accordion  -----------------------------------------------------
				
			'accordion' => array(
				'type' 		=> 'accordion',
				'title' 	=> __('Accordion', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'blocks',
				'fields'	=> array(
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('Accordion', 'mfn-opts'),
						'sub_desc' 	=> __('You can use Drag & Drop to set the order', 'mfn-opts'),
						'desc' 		=> __('<b>JavaScript</b> content like Google Maps and some plugins shortcodes do <b>not work</b> in tabs', 'mfn-opts'),
					),

					array(
						'id' 		=> 'open1st',
						'type' 		=> 'select',
						'title' 	=> __('Open First', 'mfn-opts'),
						'desc' 		=> __('Open first tab at start.', 'mfn-opts'),
						'options'	=> array( 0 => 'No', 1 => 'Yes' ),
					),

					array(
						'id' 		=> 'openAll',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open All', 'mfn-opts'),
						'desc' 		=> __('Open all tabs at start', 'mfn-opts'),
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options'	=> array(
							'accordion'	=> 'Accordion',
							'toggle'	=> 'Toggle'
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
		
			// Article box  ---------------------------------------------------
				
			'article_box' => array(
				'type'		=> 'article_box',
				'title'		=> __('Article box', 'mfn-opts'),
				'size'		=> '1/3',
				'cat' 		=> 'boxes',
				'fields'	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
						'sub_desc' 	=> __('Featured Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					// link
						
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Before After  ---------------------------------------------------
				
			'before_after' => array(
				'type'		=> 'before_after',
				'title'		=> __('Before After', 'mfn-opts'),
				'size'		=> '1/3',
				'cat' 		=> 'boxes',
				'fields'	=> array(

					array(
						'id' 		=> 'image_before',
						'type' 		=> 'upload',
						'title' 	=> __('Image | Before', 'mfn-opts'),
						'desc' 		=> __('Image width should be no less than the width of a column. Minimum 700px', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'image_after',
						'type' 		=> 'upload',
						'title' 	=> __('Image | After', 'mfn-opts'),
						'desc' 		=> __('Both images <b>must have the same size</b>', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
					
			// Blockquote -----------------------------------------------------
				
			'blockquote' => array(
				'type' 		=> 'blockquote',
				'title' 	=> __('Blockquote', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'typography',
				'fields'	=> array(
							
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'sub_desc' 	=> __('Blockquote content.', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts')
					),
						
					array(
						'id' 		=> 'author',
						'type' 		=> 'text',
						'title' 	=> __('Author', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'sub_desc' 	=> __('Link to company page.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Blog -----------------------------------------------------------
				
			'blog' => array(
				'type' 		=> 'blog',
				'title' 	=> __('Blog', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields'	=> array(
							
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'std' 		=> '2',
						'class' 	=> 'small-text',
					),
						
					array(
						'id'		=> 'style',
						'type'		=> 'select',
						'title'		=> 'Style',
						'options'	=> array(
							'classic'		=> 'Classic',
							'grid'			=> 'Grid',
							'masonry'		=> 'Masonry Blog Style',
							'masonry tiles'	=> 'Masonry Tiles',
							'photo'			=> 'Photo (Horizontal Images)',
							'timeline'		=> 'Timeline',
						),
						'std'		=> 'classic',
					),
					
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in styles: <b>Grid, Masonry</b>', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 3,
					),
						
					array(
						'id' 		=> 'info_options',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Options', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories <b>slugs</b>', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <b>coma</b> ( , )', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'exclude_id',
						'type'		=> 'text',
						'title'		=> __('Exclude Posts', 'mfn-opts'),
						'sub_desc'	=> __('Posts <b>IDs</b>', 'mfn-opts'),
						'desc'		=> __('IDs should be separated with <b>coma</b> ( , )', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'more',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Read More link', 'mfn-opts'),
						'std'		=> 1,
					),
						
					array(
						'id' 		=> 'filters',
						'type' 		=> 'select',
						'title' 	=> __('Filters', 'mfn-opts'),
						'desc' 		=> __('This option works in <b>Category: All</b> and <b>Style: Masonry</b>', 'mfn-opts'),
						'options' 	=> array(
							'0' 				=> 'Hide',
							'1' 				=> 'Show',
							'only-categories' 	=> 'Show only Categories',
							'only-tags' 		=> 'Show only Tags',
							'only-authors' 		=> 'Show only Authors',
						),
						'std' 		=> '0'
					),

					array(
						'id' 		=> 'pagination',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Pagination', 'mfn-opts'),
						'desc' 		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'load_more',
						'type' 		=> 'select',
						'title' 	=> __('Load More button', 'mfn-opts'),
						'desc' 		=> __('This will replace all sliders on list with featured images. Please also <b>show Pagination</b>', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Blog News ------------------------------------------------------
				
			'blog_news' => array(
				'type' 		=> 'blog_news',
				'title' 	=> __('Blog News', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),
						
					// options		
					array(
						'id' 		=> 'info_options',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Options', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
						
					// advanced
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'excerpt',
						'type' 		=> 'select',
						'title' 	=> __('Excerpt', 'mfn-opts'),
						'options' 	=> array(
							0 => __('Hide', 'mfn-opts'),
							1 => __('Show', 'mfn-opts'),
						),
					),

					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Button Link', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'link_title',
						'type' 		=> 'text',
						'title' 	=> __('Button Title', 'mfn-opts'),
						'class'		=> 'small-text',
					),

					// custom
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Blog Slider ----------------------------------------------------
				
			'blog_slider' => array(
				'type'		=> 'blog_slider',
				'title' 	=> __('Blog Slider', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'more',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show Read More button', 'mfn-opts'),
						'std'		=> 1,
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options'	=> array(
							''			=> 'Default',
							'flat'		=> 'Flat'
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Button ----------------------------------------------------
				
			'button' => array(
				'type'		=> 'button',
				'title' 	=> __('Button', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'typography',
				'fields'	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					array(
						'id' 		=> 'align',
						'type' 		=> 'select',
						'title' 	=> __('Align', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'Left',
							'center'	=> 'Center',
							'right'		=> 'Right',
						),
					),

					array(
						'id' 		=> 'info_icon',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Icon', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
	
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'icon_position',
						'type' 		=> 'select',
						'title' 	=> __('Position', 'mfn-opts'),
						'options'	=> array(
							'left'		=> 'Left',
							'right'		=> 'Right',
						),
					),
						
					array(
						'id' 		=> 'info_color',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Color', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'color',
						'type' 		=> 'text',
						'title' 	=> __('Background', 'mfn-opts'),
						'desc' 		=> __('Use color name ( gray ) or hex ( #808080 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'font_color',
						'type' 		=> 'text',
						'title' 	=> __('Font', 'mfn-opts'),
						'desc' 		=> __('Use color name ( black ) or hex ( #000000 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
		
					array(
						'id' 		=> 'info_style',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Style', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'size',
						'type' 		=> 'select',
						'title' 	=> __('Size', 'mfn-opts'),
						'options'	=> array(
							1 => 'Small',
							2 => 'Default',
							3 => 'Large',
							4 => 'Very Large',
						),
					),
						
					array(
						'id' 		=> 'full_width',
						'type' 		=> 'select',
						'title' 	=> __('Full Width', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>scroll</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'download',
						'type' 		=> 'text',
						'title' 	=> __('Download', 'mfn-opts'),
						'sub_desc'	=> __('Download file when clicking on the link', 'mfn-opts'),
						'desc'		=> __('Enter the new filename for the downloaded file', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'onclick',
						'type' 		=> 'text',
						'title' 	=> __('OnClick', 'mfn-opts'),
						'desc' 		=> __('Adds an onclick="..." attribute to the link', 'mfn-opts'),
					),
												
				),
			),
					
			// Call to Action -------------------------------------------------
				
			'call_to_action' => array(
				'type' 		=> 'call_to_action',
				'title' 	=> __('Call to Action', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields'	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id'		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'button_title',
						'type' 		=> 'text',
						'title' 	=> __('Button Title', 'mfn-opts'),
						'desc' 		=> __('Leave this field blank if you want Call to Action with Big Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					// link
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					// advanced
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>scroll</b>', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Chart  ---------------------------------------------------------
				
			'chart' => array(
				'type' 		=> 'chart',
				'title' 	=> __('Chart', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields'	=> array(
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					// chart	
						
					array(
						'id' 		=> 'info_chart',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Chart', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'percent',
						'type' 		=> 'text',
						'title' 	=> __('Percent', 'mfn-opts'),
						'desc' 		=> __('Number between 0-100', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Label', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id'		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					// options
					
					array(
						'id' 		=> 'info_options',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Options', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'line_width',
						'type' 		=> 'text',
						'title' 	=> __('Line Width', 'mfn-opts'),
						'sub_desc' 	=> __('optional', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					// custom
					
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Clients  -------------------------------------------------------
				
			'clients' => array(
				'type' 		=> 'clients',
				'title' 	=> __('Clients', 'mfn-opts'),
				'size'		=> '1/1',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id' 		=> 'in_row',
						'type' 		=> 'text',
						'title' 	=> __('Items in Row', 'mfn-opts'),
						'sub_desc' 	=> __('Number of items in row', 'mfn-opts'),
						'desc' 		=> __('Recommended number: 3-6', 'mfn-opts'),
						'std' 		=> 6,
						'class' 	=> 'small-text',
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'client-types' ),
						'sub_desc'	=> __('Select the client post category.', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'menu_order'
					),
						
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'ASC'
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'Default',
							'tiles' 	=> 'Tiles',
						),
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
					
			// Clients Slider -------------------------------------------------
				
			'clients_slider' => array(
				'type' 		=> 'clients_slider',
				'title' 	=> __('Clients Slider', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'client-types' ),
						'sub_desc'	=> __('Select the client post category.', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'menu_order'
					),
						
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'ASC'
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
					
			// Code  ----------------------------------------------------------
				
			'code' => array(
				'type' 		=> 'code',
				'title' 	=> __('Code', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'other',
				'fields'	=> array(
							
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'class' 	=> 'full-width',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
					
			// Column  --------------------------------------------------------
				
			'column' => array(
				'type' 		=> 'column',
				'title' 	=> __('Column', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'typography',
				'fields'	=> array(
							
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'desc' 		=> __('This field is used as an Item Label in admin panel only', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Shortcodes and HTML tags allowed. Some plugin\'s shortcodes work only in WordPress editor', 'mfn-opts'),
						'class' 	=> 'full-width sc',
						'validate' 	=> 'html',
					),
						
					array(
						'id' 		=> 'align',
						'type' 		=> 'select',
						'title' 	=> __('Text Align', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'None',
							'left'		=> 'Left',
							'right'		=> 'Right',
							'center'	=> 'Center',
							'justify'	=> 'Justify',
						),
					),
						
					array(
						'id' 		=> 'info_background',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Background', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'column_bg',
						'type' 		=> 'text',
						'title' 	=> __('Color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( gray ) or hex ( #808080 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id'		=> 'bg_image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'bg_position',
						'type' 		=> 'select',
						'title' 	=> __('Position', 'mfn-opts'),
						'desc' 		=> __('This option can be used only with your custom image selected above', 'mfn-opts'),
						'options' 	=> mfna_bg_position( 'column' ),
						'std' 		=> 'center top no-repeat',
					),
						
					array(
						'id' 		=> 'info_layout',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Layout', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'margin_bottom',
						'type' 		=> 'select',
						'title' 	=> __('Margin | Bottom', 'mfn-opts'),
						'desc'		=> __('<b>Overrides</b> section settings', 'mfn-opts'),
						'options' 	=> array(
							''			=> '-- Default --',
							'0px'		=> '0px',
							'10px'		=> '10px',
							'20px'		=> '20px',
							'30px'		=> '30px',
							'40px'		=> '40px',
							'50px'		=> '50px',
						),
					),
					
					array(
						'id' 		=> 'padding',
						'type' 		=> 'text',
						'title' 	=> __('Padding', 'mfn-opts'),
						'desc' 		=> __('Use value with <b>px</b> or <b>%</b>. Example: <b>20px</b> or <b>20px 10px 20px 10px</b> or <b>20px 1%</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Styles', 'mfn-opts'),
						'sub_desc'	=> __('Custom inline CSS Styles', 'mfn-opts'),
						'desc'		=> __('Example: <b>border: 1px solid #999;</b>', 'mfn-opts'),
					),

				),
			),
					
			// Contact box ----------------------------------------------------
				
			'contact_box' => array(
				'type' 		=> 'contact_box',
				'title' 	=> __('Contact Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'address',
						'type' 		=> 'textarea',
						'title' 	=> __('Address', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'telephone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
						'desc' 		=> __('Phone number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'telephone_2',
						'type' 		=> 'text',
						'title' 	=> __('Phone 2nd', 'mfn-opts'),
						'desc' 		=> __('Additional Phone number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'fax',
						'type' 		=> 'text',
						'title' 	=> __('Fax', 'mfn-opts'),
						'desc' 		=> __('Fax number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('Email', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'www',
						'type' 		=> 'text',
						'title' 	=> __('WWW', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Content  -------------------------------------------------------
				
			'content' => array(
				'type' 		=> 'content',
				'title' 	=> __('Content WP', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'typography',
				'fields'	 => array(
							
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('Adding this Item will show Content from WordPress Editor above Page Options. You can use it only once per page. Please also remember to turn on "Hide The Content" option.', 'nhp-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Countdown  -----------------------------------------------------
				
			'countdown' => array(
				'type' 		=> 'countdown',
				'title' 	=> __('Countdown', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'boxes',
				'fields'	=> array(
							
					array(
						'id' 		=> 'date',
						'type' 		=> 'text',
						'title' 	=> __('Lunch Date', 'mfn-opts'),
						'desc' 		=> __('Format: 12/30/2014 12:00:00 month/day/year hour:minute:second', 'mfn-opts'),
						'std' 		=> '12/30/2016 12:00:00',
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'timezone',
						'type' 		=> 'select',
						'title' 	=> __('UTC Timezone', 'mfn-opts'),
						'options' 	=> mfna_utc(),
						'std' 		=> '0',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Counter  -------------------------------------------------------
				
			'counter' => array(
				'type' 		=> 'counter',
				'title' 	=> __('Counter', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'color',
						'type' 		=> 'text',
						'title' 	=> __('Icon Color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
						'desc' 		=> __('If you upload an image, icon will not show', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title' 	=> __('Number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'prefix',
						'type' 		=> 'text',
						'title' 	=> __('Prefix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Postfix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'	=> 'Horizontal',
							'vertical' 		=> 'Vertical',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Vertical style works only for column widths: 1/4, 1/3 & 1/2', 'mfn-opts'),
						'std'		=> 'vertical',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
	
			// Divider  -------------------------------------------------------
				
			'divider' => array(
				'type' 		=> 'divider',
				'title' 	=> __('Divider', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'other',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Divider height', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							'default'	=> 'Default',
							'dots'		=> 'Dots',
							'zigzag'	=> 'ZigZag',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'line',
						'type' 		=> 'select',
						'options' 	=> array(
							'default'	=> 'Default',
							'narrow'	=> 'Narrow',
							'wide'		=> 'Wide',
							''			=> 'No Line',
						),
						'title' 	=> __('Line', 'mfn-opts'),
						'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'themecolor',
						'type' 		=> 'select',
						'options' 	=> array(
							0			=> 'No',
							1			=> 'Yes',
						),
						'title' 	=> __('Theme Color', 'mfn-opts'),
						'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Fancy Divider  -------------------------------------------------
				
			'fancy_divider' => array(
				'type' 		=> 'fancy_divider',
				'title' 	=> __('Fancy Divider', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used on pages <strong>Without Sidebar</strong>', 'nhp-opts'),
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							'circle up'		=> 'Circle Up',
							'circle down'	=> 'Circle Down',
							'curve up'		=> 'Curve Up',
							'curve down'	=> 'Curve Down',
							'stamp'			=> 'Stamp',
							'triangle up'	=> 'Triangle Up',
							'triangle down'	=> 'Triangle Down',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'color_top',
						'type' 		=> 'text',
						'title' 	=> __('Color Top', 'mfn-opts'),
						'desc' 		=> __('Use color name ( red ) or hex ( #ff0000 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'color_bottom',
						'type' 		=> 'text',
						'title' 	=> __('Color Bottom', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
						
				),
			),
				
			// Fancy Heading --------------------------------------------------
				
			'fancy_heading' => array(
				'type' 		=> 'fancy_heading',
				'title' 	=> __('Fancy Heading', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'h1',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Use H1 tag', 'mfn-opts'),
						'desc' 		=> __('Wrap title into H1 instead of H2', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'sub_desc' 	=> __('Icon Style only', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
						'sub_desc' 	=> __('Line Style only', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class' 	=> 'full-width sc',
						'validate' 	=> 'html',
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							'icon'		=> 'Icon',
							'line'		=> 'Line',
							'arrows' 	=> 'Arrows',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Some fields above work on selected styles.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
	
			// FAQ  -----------------------------------------------------------
				
			'faq' => array(
				'type' 		=> 'faq',
				'title' 	=> __('FAQ', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'blocks',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('FAQ', 'mfn-opts'),
						'sub_desc' 	=> __('You can use Drag & Drop to set the order', 'mfn-opts'),
						'desc' 		=> __('<b>JavaScript</b> content like Google Maps and some plugins shortcodes do <b>not work</b> in tabs', 'mfn-opts'),
					),

					array(
						'id' 		=> 'open1st',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open First', 'mfn-opts'),
						'desc' 		=> __('Open first tab at start', 'mfn-opts'),
					),

					array(
						'id' 		=> 'openAll',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open All', 'mfn-opts'),
						'desc' 		=> __('Open all tabs at start', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Feature Box -------------------------------------------------------
			
			'feature_box' => array(
				'type' 		=> 'feature_box',
				'title' 	=> __('Feature Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(
	
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'validate'	=> 'html',
					),
						
					array(
						'id' 		=> 'background',
						'type' 		=> 'text',
						'title' 	=> __('Background color', 'mfn-opts'),
						'desc' 		=> __('Use color name or hex. Example: <b>grey</b> or <b>#cccccc</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
	
					// link
	
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
	
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'sub_desc' 	=> __('Image Link', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
	
					// advanced
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
	
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
	
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
				
			// Feature List ---------------------------------------------------
				
			'feature_list' => array(
				'type' 		=> 'feature_list',
				'title' 	=> __('Feature List', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 	=> 'title',
						'type' 	=> 'text',
						'title' => __('Title', 'mfn-opts'),
						'desc' 	=> __('This field is used as an Item Label in admin panel only', 'mfn-opts'),
					),

					array(
						'id' 	=> 'content',
						'type' 	=> 'textarea',
						'title' => __('Content', 'mfn-opts'),
						'desc' 	=> __('Please use <strong>[item icon="" title="" link="" target=""]</strong> shortcodes.', 'mfn-opts'),
						'std' 	=> '[item icon="icon-lamp" title="" link="" target="" animate=""]',
					),
						
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 4. Recommended: 2-4. Too large value may crash the layout.', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 4,
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Flat Box -------------------------------------------------------
				
			'flat_box' => array(
				'type' 		=> 'flat_box',
				'title' 	=> __('Flat Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(
	
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'background',
						'type' 		=> 'text',
						'title' 	=> __('Icon background', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 ). Leave this field blank to use Theme Background', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
						
					// link

					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
				
			// Helper -------------------------------------------------------
				
			'helper' => array(
				'type' 		=> 'helper',
				'title' 	=> __('Helper', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'blocks',
				'fields' 	=> array(
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title_tag',
						'type' 		=> 'select',
						'title' 	=> __('Title | Tag', 'mfn-opts'),
						'options' 	=> array(
							'h1' => 'H1',
							'h2' => 'H2',
							'h3' => 'H3',
							'h4' => 'H4',
							'h5' => 'H5',
							'h6' => 'H6',
						),
						'std'		=> 'h4'
					),
	
					array(
						'id' 		=> 'info_item1',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Item 1', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'title1',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content1',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
						
					array(
						'id' 		=> 'link1',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'desc' 		=> __('Use this field if you want to link to another page instead of showing the content', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target1',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Link | Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link', 'mfn-opts'),
					),

					array(
						'id' 		=> 'class1',
						'type' 		=> 'text',
						'title' 	=> __('Link | Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>prettyphoto</b> or <b>scroll</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'info_item2',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Item 2', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'title2',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content2',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
						
					array(
						'id' 		=> 'link2',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'desc' 		=> __('Use this field if you want to link to another page instead of showing the content', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target2',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Link | Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link', 'mfn-opts'),
					),

					array(
						'id' 		=> 'class2',
						'type' 		=> 'text',
						'title' 	=> __('Link | Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>prettyphoto</b> or <b>scroll</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
				
			// Hover Box ------------------------------------------------------
				
			'hover_box' => array(
				'type' 		=> 'hover_box',
				'title' 	=> __('Hover Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields'	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'image_hover',
						'type' 		=> 'upload',
						'title' 	=> __('Image | Hover', 'mfn-opts'),
						'desc' 		=> __('Both images <b>must have the same size</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array( 
							0 			=> 'Default | _self', 
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)', 
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Hover Color ----------------------------------------------------
				
			'hover_color' => array(
				'type' 		=> 'hover_color',
				'title' 	=> __('Hover Color', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id'		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
						
					array(
						'id' 		=> 'background',
						'type' 		=> 'text',
						'title' 	=> __('Background color', 'mfn-opts'),
						'desc' 		=> __('Use color name or hex. Example: <b>blue</b> or <b>#2991D6</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#2991D6',
					),
						
					array(
						'id' 		=> 'background_hover',
						'type' 		=> 'text',
						'title' 	=> __('Background color | Hover', 'mfn-opts'),
						'desc' 		=> __('Use color name or hex. Example: <b>navy</b> or <b>#236A9C</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#2991D6',
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'text',
						'title' 	=> __('Border color', 'mfn-opts'),
						'sub_desc' 	=> __('optional', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'border_hover',
						'type' 		=> 'text',
						'title' 	=> __('Border color | Hover', 'mfn-opts'),
						'sub_desc' 	=> __('optional', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'padding',
						'type' 		=> 'text',
						'title' 	=> __('Padding', 'mfn-opts'),
						'sub_desc' 	=> __('default: 40px 30px', 'mfn-opts'),
						'desc' 		=> __('Use value with <b>px</b> or <b>%</b>. Example: <b>20px</b> or <b>20px 10px 20px 10px</b> or <b>20px 1%</b>', 'mfn-opts'),	
						'class' 	=> 'small-text',
						'std' 		=> '40px 30px',
					),
						
					// link
					
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Link | Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>scroll</b>', 'mfn-opts'),
					),
						
					// custom
					
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Styles', 'mfn-opts'),
						'sub_desc'	=> __('Custom inline CSS Styles', 'mfn-opts'),
						'desc'		=> __('Example: <b>border: 1px solid #999;</b>', 'mfn-opts'),
					),
					
								
				),
			),
				
			// How It Works ---------------------------------------------------
				
			'how_it_works' => array(
				'type' 		=> 'how_it_works',
				'title' 	=> __('How It Works', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
						'desc' 		=> __('Recommended: Square Image with transparent background.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title' 	=> __('Number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Line', 'mfn-opts'),
						'sub_desc' 	=> __('Show right connecting line', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),

					// link
						
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					// advanced
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Icon Box  ------------------------------------------------------
				
			'icon_box' => array(
				'type' 		=> 'icon_box',
				'title' 	=> __('Icon Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
						
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'icon_position',
						'type' 		=> 'select',
						'options'	=> array(
							'left'	=> 'Left',
							'top'	=> 'Top',
						),
						'title' 	=> __('Icon Position', 'mfn-opts'),
						'desc' 		=> __('Left position works only for column widths: 1/4, 1/3 & 1/2', 'mfn-opts'),
						'std'		=> 'top',
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show right border', 'mfn-opts'),
						'options' 	=> array(
							0 	=> 'No',
							1 	=> 'Yes'
						),
					),

					// link
					
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Link | Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use <b>scroll</b>', 'mfn-opts'),
					),
						
					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					// custom
					
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
	
			// Image  ---------------------------------------------------------
				
			'image' => array(
				'type' 		=> 'image',
				'title' 	=> __('Image', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'typography',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'src',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'width',
						'type' 		=> 'text',
						'title' 	=> __('Image | Width', 'mfn-opts'),
						'sub_desc' 	=> __('optional', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Image | Height', 'mfn-opts'),
						'sub_desc' 	=> __('optional', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					// options	
						
					array(
						'id' 		=> 'info_options',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Options', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'align',
						'type' 		=> 'select',
						'title' 	=> __('Align', 'mfn-opts'),
						'desc' 		=> __('If you want image to be <b>resized</b> to column width use <b>align none</b>', 'mfn-opts'),
						'options' 	=> array(
							'' 			=> 'None',
							'left' 		=> 'Left',
							'right' 	=> 'Right',
							'center' 	=> 'Center',
						),
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show Image Border', 'mfn-opts'),
					),

					array(
						'id' 		=> 'margin',
						'type' 		=> 'text',
						'title' 	=> __('Margin | Top', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'margin_bottom',
						'type' 		=> 'text',
						'title' 	=> __('Margin | Bottom', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
							
					// link
					
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					), 
						
					array(
						'id' 		=> 'link_image',
						'type' 		=> 'upload',
						'title' 	=> __('Zoomed image', 'mfn-opts'),
						'desc' 		=> __('This image or embed video will be opened in lightbox.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'desc' 		=> __('This link will work only if you leave the above "Zoomed image" field empty.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'hover',
						'type' 		=> 'select',
						'title' 	=> __('Hover Effect', 'mfn-opts'),
						'options' 	=> array( 
							'' 			=> __('- Default -', 'mfn-opts'),
							'disable' 	=> __('Disable', 'mfn-opts'),
						),
					),
						
					// description
						
					array(
						'id' 		=> 'info_description',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Description', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'alt',
						'type' 		=> 'text',
						'title' 	=> __('Alternate Text', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'caption',
						'type' 		=> 'text',
						'title' 	=> __('Caption', 'mfn-opts'),
					),
						
					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'desc'		=> 'Works only for images with link',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Info box -------------------------------------------------------
				
			'info_box' => array(
				'type' 		=> 'info_box',
				'title' 	=> __('Info Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li>list item 1</li><li>list item 2</li></ul>',
					),

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// List -----------------------------------------------------------
				
			'list' => array(
				'type' 		=> 'list',
				'title'		=> __('List', 'mfn-opts'),
				'size'		=> '1/4',
				'cat' 		=> 'blocks',
				'fields'	=> array(

					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
					),

					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Only <strong>Vertical Style</strong> works for column widths 1/5 & 1/6', 'mfn-opts'),
						'options' 	=> array(
							1 => 'With background',
							2 => 'Transparent',
							3 => 'Vertical',
							4 => 'Ordered list',
						),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Map ------------------------------------------------------------
				
			'map' => array(
				'type'		=> 'map',
				'title'		=> __('Map', 'mfn-opts'),
				'size'		=> '1/4',
				'cat' 		=> 'elements',
				'fields'	=> array(

					array(
						'id' 		=> 'lat',
						'type' 		=> 'text',
						'title' 	=> __('Google Maps Lat', 'mfn-opts'),
						'class' 	=> 'small-text',
						'desc' 		=> __('The map will appear only if this field is filled correctly.<br />Example: <b>-33.87</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'lng',
						'type' 		=> 'text',
						'title' 	=> __('Google Maps Lng', 'mfn-opts'),
						'class' 	=> 'small-text',
						'desc' 		=> __('The map will appear only if this field is filled correctly.<br />Example: <b>151.21</b>', 'mfn-opts'),
					),

					array(
						'id' 		=> 'zoom',
						'type' 		=> 'text',
						'title' 	=> __('Zoom', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 13,
					),
						
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Height', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 200,
					),
						
					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'title' 	=> __('Type', 'mfn-opts'),
						'options' 	=> array(
							'ROADMAP' 	=> __('Map', 'mfn-opts'),
							'SATELLITE' => __('Satellite', 'mfn-opts'),
							'HYBRID' 	=> __('Satellite + Map', 'mfn-opts'),
							'TERRAIN' 	=> __('Terrain', 'mfn-opts'),
						),
					),

					array(
						'id' 		=> 'controls',
						'type' 		=> 'select',
						'title' 	=> __('Controls', 'mfn-opts'),
						'options' 	=> array(
							'' 							=> __('Zoom', 'mfn-opts'),
							'mapType' 					=> __('Map Type', 'mfn-opts'),
							'streetView'				=> __('Street View', 'mfn-opts'),
							'zoom mapType' 				=> __('Zoom & Map Type', 'mfn-opts'),
							'zoom streetView' 			=> __('Zoom & Street View', 'mfn-opts'),
							'mapType streetView' 		=> __('Map Type & Street View', 'mfn-opts'),
							'zoom mapType streetView'	=> __('Zoom, Map Type & Street View', 'mfn-opts'),
							'hide'						=> __('Hide All', 'mfn-opts'),
						),
					),

					array(
						'id' 		=> 'draggable',
						'type' 		=> 'select',
						'title' 	=> __('Draggable', 'mfn-opts'),
						'options' 	=> array(
							'' 					=> __('Enable', 'mfn-opts'),
							'disable' 			=> __('Disable', 'mfn-opts'),
							'disable-mobile'	=> __('Disable on Mobile', 'mfn-opts'),
						),
					),

					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show map border', 'mfn-opts'),
						'options' 	=> array(
							0 => __('No', 'mfn-opts'),
							1 => __('Yes', 'mfn-opts'),
						),
					),
						
					array(
						'id' 		=> 'icon',
						'type' 		=> 'upload',
						'title' 	=> __('Marker Icon', 'mfn-opts'),
						'desc' 		=> __('.png', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'styles',
						'type' 		=> 'textarea',
						'title' 	=> __('Styles', 'mfn-opts'),
						'sub_desc' 	=> __('Google Maps API styles array', 'mfn-opts'),
						'desc' 		=> __('You can get predefined styles from <a target="_blank" href="http://snazzymaps.com/">snazzymaps.com</a> or generate your own <a target="_blank" href="http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html">here</a>', 'mfn-opts'),
					),

					array(
						'id' 		=> 'latlng',
						'type' 		=> 'textarea',
						'title' 	=> __('Additional Markers | Lat,Lng,IconURL', 'mfn-opts'),
						'desc' 		=> __('Separate Lat,Lang,IconURL[optional] with <b>coma</b> [ , ]<br />Separate multiple Markers with <b>semicolon</b> [ ; ]<br />Example: <b>-33.88,151.21,ICON_URL;-33.89,151.22</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('<strong>Contact Box</strong> | Works only in Full Width', 'nhp-opts'),
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Box | Title', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Box | Address', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'telephone',
						'type' 		=> 'text',
						'title' 	=> __('Box | Telephone', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('Box | Email', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'www',
						'type' 		=> 'text',
						'title' 	=> __('Box | WWW', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Offer Slider Full ----------------------------------------------
				
			'offer' => array(
				'type' 		=> 'offer',
				'title' 	=> __('Offer Slider Full', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields' 	=> array(

					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used on pages <strong>Without Sidebar</strong>.<br />Please also set Section Style to <strong>Full Width</strong> and use one Item in one Section.', 'nhp-opts'),
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'offer-types' ),
						'sub_desc'	=> __('Select the offer post category.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Offer Slider Thumb ---------------------------------------------
				
			'offer_thumb' => array(
				'type' 		=> 'offer_thumb',
				'title' 	=> __('Offer Slider Thumb', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields' 	=> array(

					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used <strong>once per page</strong>.', 'nhp-opts'),
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'offer-types' ),
						'sub_desc'	=> __('Select the offer post category.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options'	=> array(
							''			=> 'Thumbnails on the left',
							'bottom'	=> 'Thumbnails at the bottom',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Opening Hours --------------------------------------------------
				
			'opening_hours' => array(
				'type' 		=> 'opening_hours',
				'title' 	=> __('Opening Hours', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li><label>Monday - Saturday</label><span>8am - 4pm</span></li></ul>',
					),

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Our team -------------------------------------------------------
				
			'our_team' => array(
				'type' 		=> 'our_team',
				'title' 	=> __('Our Team', 'mfn-opts'),
				'size'		=> '1/4',
				'cat' 		=> 'elements',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'heading',
						'type' 		=> 'text',
						'title' 	=> __('Heading', 'mfn-opts'),
					),

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Photo', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'subtitle',
						'type' 		=> 'text',
						'title' 	=> __('Subtitle', 'mfn-opts'),
					),
						
					// description
					
					array(
						'id' 		=> 'info_description',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Description', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'phone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),

					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('E-mail', 'mfn-opts'),
					),
						
					// social
					
					array(
						'id' 		=> 'info_social',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Social', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'facebook',
						'type' 		=> 'text',
						'title' 	=> __('Facebook', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'twitter',
						'type' 		=> 'text',
						'title' 	=> __('Twitter', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'linkedin',
						'type' 		=> 'text',
						'title' 	=> __('LinkedIn', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'vcard',
						'type' 		=> 'text',
						'title' 	=> __('vCard', 'mfn-opts'),
					),
						
					// other
					
					array(
						'id' 		=> 'info_other',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Other', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'blockquote',
						'type' 		=> 'textarea',
						'title' 	=> __('Blockquote', 'mfn-opts'),
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options'	=> array(
							'circle'		=> 'Circle',
							'vertical'		=> 'Vertical',
							'horizontal'	=> 'Horizontal 	[only: 1/2]',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'std'		=> 'vertical',
					),
						
					// link
					
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),
						
					// custom
					
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Our team list --------------------------------------------------
				
			'our_team_list' => array(
				'type' 		=> 'our_team_list',
				'title' 	=> __('Our Team List', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Photo', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'subtitle',
						'type' 		=> 'text',
						'title' 	=> __('Subtitle', 'mfn-opts'),
					),
						
					// description
						
					array(
						'id' 		=> 'info_description',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Description', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'phone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
						
					array(
						'id'		=> 'blockquote',
						'type'		=> 'textarea',
						'title'		=> __('Blockquote', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('E-mail', 'mfn-opts'),
					),
						
					// social
						
					array(
						'id' 		=> 'info_social',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Social', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'facebook',
						'type' 		=> 'text',
						'title' 	=> __('Facebook', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'twitter',
						'type' 		=> 'text',
						'title' 	=> __('Twitter', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'linkedin',
						'type' 		=> 'text',
						'title' 	=> __('LinkedIn', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'vcard',
						'type' 		=> 'text',
						'title' 	=> __('vCard', 'mfn-opts'),
					),
						
					// link
						
					array(
						'id' 		=> 'info_link',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Link', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Photo Box ------------------------------------------------------
				
			'photo_box' => array(
				'type' 		=> 'photo_box',
				'title' 	=> __('Photo Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id'		=> 'title',
						'type'		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
						
					array(
						'id'		=> 'align',
						'type'		=> 'select',
						'title'		=> 'Text Align',
						'options' 	=> array(
							''		=> 'Center',
							'left'	=> 'Left',
							'right'	=> 'Right',
						),
					),
						
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'desc'		=> 'Works only for images with link',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Portfolio ------------------------------------------------------
				
			'portfolio' => array(
				'type'		=> 'portfolio',
				'title'		=> __('Portfolio', 'mfn-opts'),
				'size'		=> '1/1',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'class'		=> 'small-text',
						'std'		=> 3,
					),

					array(
						'id'		=> 'style',
						'type'		=> 'select',
						'title'		=> 'Style',
						'options' 	=> array(
							'flat'				=> 'Flat',
							'grid'				=> 'Grid',
							'masonry'			=> 'Masonry Blog Style',
							'masonry-hover'		=> 'Masonry Hover Description',
							'masonry-minimal'	=> 'Masonry Minimal',
							'masonry-flat'		=> 'Masonry Flat',
							'list'				=> 'List',
							'exposure'			=> 'Exposure',
						),
						'std' 		=> 'grid'
					),
						
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in styles: <b>Flat, Grid, Masonry Blog Style, Masonry Hover Details</b>', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 3,
					),
						
					array(
						'id' 		=> 'info_options',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Options', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'wpml'		=> 'portfolio-types',
					),

					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories <b>slugs</b>', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <b>coma</b> ( , )', 'mfn-opts'),
					),

					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'date'
					),
						
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'DESC'
					),
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'exclude_id',
						'type'		=> 'text',
						'title'		=> __('Exclude Posts', 'mfn-opts'),
						'sub_desc'	=> __('Posts <b>IDs</b>', 'mfn-opts'),
						'desc'		=> __('IDs should be separated with <b>coma</b> ( , )', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'related',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Use as Related Projects', 'mfn-opts'),
						'sub_desc' 	=> __('use on Single Project page', 'mfn-opts'),
						'desc' 		=> __('Exclude current Project. This option will override Exclude Posts option above', 'mfn-opts'),
					),

					array(
						'id' 		=> 'filters',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Filters', 'mfn-opts'),
						'desc' 		=> __('Works only with <b>Category: All</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'pagination',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Pagination', 'mfn-opts'),
						'desc'		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'load_more',
						'type' 		=> 'select',
						'title' 	=> __('Load More button', 'mfn-opts'),
						'desc' 		=> __('This will replace all sliders on list with featured images. Please also <b>show Pagination</b>', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Portfolio Grid -------------------------------------------------
				
			'portfolio_grid' => array(
				'type'		=> 'portfolio_grid',
				'title'		=> __('Portfolio Grid', 'mfn-opts'),
				'size'		=> '1/4',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'std'		=> '4',
						'class'		=> 'small-text',
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
						'wpml'		=> 'portfolio-types',
					),
						
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'date'
					),
						
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'DESC'
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Portfolio Photo ------------------------------------------------
				
			'portfolio_photo' => array(
				'type'		=> 'portfolio_photo',
				'title'		=> __('Portfolio Photo', 'mfn-opts'),
				'size'		=> '1/1',
				'cat' 		=> 'loops',
				'fields'	=> array(
							
					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'std'		=> '5',
						'class'		=> 'small-text',
					),

					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
						'wpml'		=> 'portfolio-types',
					),

					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),

					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options'	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std'		=> 'date'
					),

					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std'		=> 'DESC'
					),

					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
				
			// Portfolio Slider -----------------------------------------------
				
			'portfolio_slider' => array(
				'type'		=> 'portfolio_slider',
				'title'		=> __('Portfolio Slider', 'mfn-opts'),
				'size'		=> '1/1',
				'cat' 		=> 'loops',
				'fields'	=> array(

					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std'		=> '6',
						'class'		=> 'small-text',
					),
						
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
						'wpml'		=> 'portfolio-types',
					),
						
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options'	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std'		=> 'date'
					),

					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std'		=> 'DESC'
					),

					array(
						'id'		=> 'arrows',
						'type'		=> 'select',
						'title'		=> __('Navigation Arrows', 'mfn-opts'),
						'sub_desc'	=> __('Show Navigation Arrows', 'mfn-opts'),
						'options'	=> array(
							''			=> 'None',
							'hover' 	=> 'Show on hover',
							'always' 	=> 'Always show',
						),
						'std'		=> 'DESC'
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Pricing item ---------------------------------------------------
				
			'pricing_item' => array(
				'type' 		=> 'pricing_item',
				'title' 	=> __('Pricing Item', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'blocks',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'sub_desc' 	=> __('Pricing item title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'price',
						'type' 		=> 'text',
						'title' 	=> __('Price', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'currency',
						'type'		=> 'text',
						'title' 	=> __('Currency', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'currency_pos',
						'type'		=> 'select',
						'title' 	=> __('Currency | Position', 'mfn-opts'),
						'options' 	=> array(
							'' 			=> 'Left',
							'right'		=> 'Right'
						),
					),

					array(
						'id' 		=> 'period',
						'type' 		=> 'text',
						'title' 	=> __('Period', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					// description
					
					array(
						'id' 		=> 'info_description',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Description', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id'		=> 'subtitle',
						'type'		=> 'text',
						'title'		=> __('Subtitle', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li><strong>List</strong> item</li></ul>',
					),
						
					// button
					
					array(
						'id' 		=> 'info_button',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Button', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'link_title',
						'type' 		=> 'text',
						'title' 	=> __('Button | Title', 'mfn-opts'),
						'desc' 		=> __('Button will appear only if this field will be filled.', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Button | Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Button | Link', 'mfn-opts'),
						'desc' 		=> __('Button will appear only if this field will be filled.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Button | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					// advanced
					
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'featured',
						'type' 		=> 'select',
						'title' 	=> __('Featured', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options' 	=> array(
							'box'	=> 'Box',
							'label'	=> 'Table Label',
							'table'	=> 'Table',
						),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					// custom
					
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
					
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Progress Bars  -------------------------------------------------
				
			'progress_bars' => array(
				'type' 		=> 'progress_bars',
				'title' 	=> __('Progress Bars', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Please use <strong>[bar title="Title" value="50" size="20"]</strong> shortcodes here.', 'mfn-opts'),
						'std' 		=> '[bar title="Bar1" value="50"]'."\n".'[bar title="Bar2" value="60" size="20"]',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Promo Box ------------------------------------------------------
				
			'promo_box' => array(
				'type'		=> 'promo_box',
				'title'		=> __('Promo Box', 'mfn-opts'),
				'size'		=> '1/2',
				'cat' 		=> 'boxes',
				'fields'	=> array(

					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'title',
						'type'		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
						
					// button
						
					array(
						'id' 		=> 'info_button',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Button', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'btn_text',
						'type' 		=> 'text',
						'title' 	=> __('Button | Text', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					array(
						'id' 		=> 'btn_link',
						'type' 		=> 'text',
						'title' 	=> __('Button | Link', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Button | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					// advanced
						
					array(
						'id' 		=> 'info_advanced',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Advanced', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'position',
						'type' 		=> 'select',
						'title' 	=> __('Image position', 'mfn-opts'),
						'options' 	=> array(
							'left' 	=> 'Left',
							'right' => 'Right'
						),
						'std'		=> 'left',
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show right border', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'std'		=> 'no_border',
					),

					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					// custom
						
					array(
						'id' 		=> 'info_custom',
						'type' 		=> 'info',
						'title' 	=> '',
						'desc' 		=> __('Custom', 'mfn-opts'),
						'class' 	=> 'mfn-info',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Quick Fact -----------------------------------------------------
				
			'quick_fact' => array(
				'type' 		=> 'quick_fact',
				'title' 	=> __('Quick Fact', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id' 		=> 'heading',
						'type' 		=> 'text',
						'title' 	=> __('Heading', 'mfn-opts'),
					),

					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title'		=> __('Number', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'prefix',
						'type' 		=> 'text',
						'title' 	=> __('Prefix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Postfix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate' 	=> 'html',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Shop Slider ----------------------------------------------------
				
			'shop_slider' => array(
				'type' 		=> 'shop_slider',
				'title' 	=> __('Shop Slider', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'loops',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'show',
						'type' 		=> 'select',
						'title'		=> __('Show', 'mfn-opts'),
						'options'	=> array(
							''				=> 'All (or category selected below)',
							'featured'		=> 'Featured',
							'onsale'		=> 'Onsale',
							'best-selling'	=> 'Best Selling (Order by: Sales)',
						),
					),

					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'product_cat' ),
						'sub_desc'	=> __('Select the products category', 'mfn-opts'),
					),

					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
						),
						'std' 		=> 'date'
					),

					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Sidebar Widget -------------------------------------------------
				
			'sidebar_widget' => array(
				'type' 		=> 'sidebar_widget',
				'title' 	=> __('Sidebar Widget', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'other',
				'fields' 	=> array(
							
					array(
						'id'		=> 'sidebar',
						'type' 		=> 'select',
						'title' 	=> __('Select Sidebar', 'mfn-opts'),
						'desc' 		=> __('1. Create Sidebar in Theme Options > Getting Started > Sidebars.<br />2. Add Widget.<br />3. Select your sidebar.', 'mfn-opts'),
						'options' 	=> mfn_opts_get( 'sidebars' ),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Slider ---------------------------------------------------------
				
			'slider' => array(
				'type' 		=> 'slider',
				'title' 	=> __('Slider', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'blocks',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							''				=> 'Default',
							'description'	=> 'Description',
							'flat' 			=> 'Flat',
							'carousel' 		=> 'Carousel',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),

					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'slide-types' ),
						'sub_desc'	=> __('Select the slides category', 'mfn-opts'),
					),

					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),

					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Slider Plugin --------------------------------------------------
				
			'slider_plugin' => array(
				'type' 		=> 'slider_plugin',
				'title' 	=> __('Slider Plugin', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'other',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'rev',
						'type' 		=> 'select',
						'title' 	=> __('Slider | Revolution Slider', 'mfn-opts'),
						'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=revslider">Revolution Sliders</a>', 'mfn-opts'),
						'options' 	=> mfn_get_sliders(),
					),
						
					array(
						'id' 		=> 'layer',
						'type' 		=> 'select',
						'title' 	=> __('Slider | Layer Slider', 'mfn-opts'),
						'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=layerslider">Layer Sliders</a>', 'mfn-opts'),
						'options' 	=> mfn_get_sliders_layer(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Sliding Box ----------------------------------------------------
				
			'sliding_box' => array(
				'type' 		=> 'sliding_box',
				'title' 	=> __('Sliding Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
	
			// Story Box ------------------------------------------------------
				
			'story_box' => array(
				'type' 		=> 'story_box',
				'title' 	=> __('Story Box', 'mfn-opts'),
				'size' 		=> '1/2',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							''			=> 'Horizontal Image',
							'vertical' 	=> 'Vertical Image',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate' 	=> 'html',
					),
						
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Tabs -----------------------------------------------------------
				
			'tabs' => array(
				'type' 		=> 'tabs',
				'title' 	=> __('Tabs', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'blocks',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('Tabs', 'mfn-opts'),
						'sub_desc' 	=> __('To add an <strong>icon</strong> in Title field, please use the following code:<br/><br/>&lt;i class=" icon-lamp"&gt;&lt;/i&gt; Tab Title', 'mfn-opts'),
						'desc' 		=> __('<b>JavaScript</b> content like Google Maps and some plugins shortcodes do <b>not work</b> in tabs. You can use Drag & Drop to set the order', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'	=> 'Horizontal',
							'centered'		=> 'Horizontal (centered tab)',
							'vertical' 		=> 'Vertical', 
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Vertical tabs works only for column widths: 1/2, 3/4 & 1/1', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'uid',
						'type'		=> 'text',
						'title'		=> __('Unique ID [optional]', 'mfn-opts'),
						'sub_desc'	=> __('Allowed characters: "a-z" "-" "_"', 'mfn-opts'),
						'desc'		=> __('Use this option if you want to open specified tab from link.<br />For example: Your Unique ID is <strong>offer</strong> and you want to open 2nd tab, please use link: <strong>your-url/#offer-2</strong>', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
	
			// Testimonials ---------------------------------------------------
				
			'testimonials' => array(
				'type' 		=> 'testimonials',
				'title' 	=> __('Testimonials', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'testimonial-types' ),
						'sub_desc'	=> __('Select the testimonial post category.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),
						
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title'		=> __('Style', 'mfn-opts'),
						'options' 	=> array(
							'' 				=> __('Default','mfn-opts'),
							'single-photo' 	=> __('Single Photo','mfn-opts'),
						),
					),
						
					array(
						'id' 		=> 'hide_photos',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Hide Photos', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Testimonials List ----------------------------------------------
				
			'testimonials_list' => array(
				'type' 		=> 'testimonials_list',
				'title' 	=> __('Testimonials List', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'loops',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'testimonial-types' ),
						'sub_desc'	=> __('Select the testimonial post category.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),
						
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title'		=> __('Style', 'mfn-opts'),
						'options' 	=> array(
							'' 			=> __('Default','mfn-opts'),
							'quote' 	=> __('Quote above the author','mfn-opts'),
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Timeline -------------------------------------------------------
				
			'timeline' => array(
				'type' 		=> 'timeline',
				'title' 	=> __('Timeline', 'mfn-opts'),
				'size' 		=> '1/1',
				'cat' 		=> 'elements',
				'fields' 	=> array(
							
					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('Timeline', 'mfn-opts'),
						'sub_desc' 	=> __('Please add <strong>date</strong> wrapped into <strong>span</strong> tag in Title field.<br/><br/>&lt;span&gt;2013&lt;/span&gt;Event Title', 'mfn-opts'),
						'desc' 		=> __('You can use Drag & Drop to set the order.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
							
				),
			),
				
			// Trailer Box ----------------------------------------------------
				
			'trailer_box' => array(
				'type' 		=> 'trailer_box',
				'title' 	=> __('Trailer Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields' 	=> array(

					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),

					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),

					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array(
							0 			=> 'Default | _self',
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)',
						),
					),

					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'desc' 		=> __('<b>Notice:</b> In some versions of Safari browser Hover works only if you select: <b>Not Animated</b> or <b>Fade In</b>', 'mfn-opts'),	
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> mfn_get_animations(),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
				
			// Video  --------------------------------------------
			'video' => array(
				'type' 		=> 'video',
				'title' 	=> __('Video', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'cat' 		=> 'elements',	
				'fields' 	=> array(
			
					array(
						'id' 		=> 'video',
						'type' 		=> 'text',
						'title' 	=> __('YouTube or Vimeo | Video ID', 'mfn-opts'),
						'sub_desc' 	=> __('YouTube or Vimeo', 'mfn-opts'),
						'desc' 		=> __('It`s placed in every YouTube & Vimeo video, for example:<br /><b>YouTube:</b> http://www.youtube.com/watch?v=<u>WoJhnRczeNg</u><br /><b>Vimeo:</b> http://vimeo.com/<u>62954028</u>', 'mfn-opts'),
						'class' 	=> 'small-text'
					),
						
					array(
						'id' 		=> 'parameters',
						'type' 		=> 'text',
						'title' 	=> __('YouTube or Vimeo | Parameters', 'mfn-opts'),
						'sub_desc' 	=> __('YouTube or Vimeo', 'mfn-opts'),
						'desc' 		=> __('Multiple parameters should be connected with "&"<br />For example: <b>autoplay=1&loop=1</b>', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'mp4',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | MP4 video', 'mfn-opts'),
						'sub_desc'	=> __('m4v [.mp4]', 'mfn-opts'),
						'desc'		=> __('Please add both mp4 and ogv for cross-browser compatibility.', 'mfn-opts'),
						'class'		=> __('video', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'ogv',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | OGV video', 'mfn-opts'),
						'sub_desc'	=> __('ogg [.ogv]', 'mfn-opts'),
						'class'		=> __('video', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'placeholder',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | Placeholder image', 'mfn-opts'),
						'desc'		=> __('Placeholder Image will be used as video placeholder before video loads and on mobile devices.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'html5_parameters',
						'type'		=> 'select',
						'title'		=> __('HTML5 | Parameters', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'autoplay controls loop muted',
							'a;c;l;'	=> 'autoplay controls loop',
							'a;c;;m'	=> 'autoplay controls muted',
							'a;;l;m'	=> 'autoplay loop muted',
							'a;c;;'		=> 'autoplay controls',
							'a;;l;'		=> 'autoplay loop',
							'a;;;m'		=> 'autoplay muted',
							'a;;;'		=> 'autoplay',
							';c;l;m'	=> 'controls loop muted',
							';c;l;'		=> 'controls loop',
							';c;;m'		=> 'controls muted',
							';c;;'		=> 'controls',
						),
					),
					
					array(
						'id' 		=> 'width',
						'type' 		=> 'text',
						'title' 	=> __('Width', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 700,
					),
					
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Height', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 400,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),	
			),
				
			// Visual Editor  -------------------------------------------------
				
			'visual' => array(
				'type' 		=> 'visual',
				'title' 	=> __('Visual Editor', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'other',
				'fields' 	=> array(

					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'desc' 		=> __('This field is used as an Item Label in admin panel only', 'mfn-opts'),
					),

					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Visual Editor', 'mfn-opts'),
						'param' 	=> 'editor',
						'validate' 	=> 'html',
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
	
			// Zoom Box -------------------------------------------------------
				
			'zoom_box' => array(
				'type' 		=> 'zoom_box',
				'title' 	=> __('Zoom Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'cat' 		=> 'boxes',
				'fields'	=> array(

					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),

					array(
						'id' 		=> 'bg_color',
						'type' 		=> 'text',
						'title' 	=> __('Overlay background', 'mfn-opts'),
						'desc' 		=> __('Use color HEX (ie. "#000000").', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#000000',
					),

					array(
						'id'		=> 'content_image',
						'type'		=> 'upload',
						'title'		=> __('Content Image', 'mfn-opts'),
					),

					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width',
					),

					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),

					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array( 
							0 			=> 'Default | _self', 
							1 			=> 'New Tab or Window | _blank' ,
							'lightbox' 	=> 'Lightbox (image or embed video)', 
						),
					),

					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),

				),
			),
					
		);
		
		if( $item ){
			return $items[ $item ];
		}
		
		return $items;
		
	}
}
