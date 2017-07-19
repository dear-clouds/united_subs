<?php
if(class_exists('WPBakeryShortCodesContainer'))
{
	class WPBakeryShortCode_news_tabs extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_news_tab extends WPBakeryShortCode {
	}
}

if(function_exists('vc_map')){
function mom_title_type ($settings, $value) {
   $dependency = vc_generate_dependencies_attributes($settings);
   return '<div class="mom_custom_title"><h4>'.$value.'</h4></div>';
}
add_shortcode_param('title', 'mom_title_type');

$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_name] = $of_cat->cat_ID;} 

$ads = array();
$get_ads = get_posts('post_type=ads&posts_per_page=-1');
foreach ($get_ads as $ad ) {
    $ads[$ad->post_title] = $ad->ID;
}

$ani = array(
   'bounce'  => 'bounce',
   'flash' => 'flash',
   'pulse' => 'pulse',
   'rubberBand'  => 'rubberBand',
   'shake' => 'shake',
   'swing' => 'swing',
   'tada'  => 'tada',
   'wobble'  => 'wobble',
   'bounceIn'  => 'bounceIn',
   'bounceInDown'  => 'bounceInDown',
   'bounceInLeft'  => 'bounceInLeft',
   'bounceInRight' => 'bounceInRight',
   'bounceInUp'  => 'bounceInUp',
   'fadeIn'  => 'fadeIn',
   'fadeInDown'  => 'fadeInDown',
   'fadeInDownBig' => 'fadeInDownBig',
   'fadeInLeft'  => 'fadeInLeft',
   'fadeInLeftBig' => 'fadeInLeftBig',
   'fadeInRight' => 'fadeInRight',
   'fadeInRightBig'  => 'fadeInRightBig',
   'fadeInUp'  => 'fadeInUp',
   'fadeInUpBig' => 'fadeInUpBig',
   'flip'  => 'flip',
   'flipInX' => 'flipInX',
   'flipInY' => 'flipInY',
   'lightSpeedIn'  => 'lightSpeedIn',
   'rotateIn'  => 'rotateIn',
   'rotateInDownLeft'  => 'rotateInDownLeft',
   'rotateInDownRight' => 'rotateInDownRight',
   'rotateInUpLeft'  => 'rotateInUpLeft',
   'rotateInUpRight' => 'rotateInUpRight',
   'slideInDown' => 'slideInDown',
   'slideInLeft' => 'slideInLeft',
   'slideInRight'  => 'slideInRight',
   'rollIn'  => 'rollIn',  
);

$ani_out = array(
   'bounceOut'  => 'bounceOut',
   'bounceOutDown'  => 'bounceOutDown',
   'bounceOutLeft'  => 'bounceOutLeft',
   'bounceOutRight' => 'bounceOutRight',
   'bounceOutUp'  => 'bounceOutUp',
   'fadeOut'  => 'fadeOut',
   'fadeOutDown'  => 'fadeOutDown',
   'fadeOutDownBig' => 'fadeOutDownBig',
   'fadeOutLeft'  => 'fadeOutLeft',
   'fadeOutLeftBig' => 'fadeOutLeftBig',
   'fadeOutRight' => 'fadeOutRight',
   'fadeOutRightBig'  => 'fadeOutRightBig',
   'fadeOutUp'  => 'fadeOutUp',
   'fadeOutUpBig' => 'fadeOutUpBig',
   'flip'  => 'flip',
   'flipOutX' => 'flipOutX',
   'flipOutY' => 'flipOutY',
   'lightSpeedOut'  => 'lightSpeedOut',
   'rotateOut'  => 'rotateOut',
   'rotateOutDownLeft'  => 'rotateOutDownLeft',
   'rotateOutDownRight' => 'rotateOutDownRight',
   'rotateOutUpLeft'  => 'rotateOutUpLeft',
   'rotateOutUpRight' => 'rotateOutUpRight',
   'slideOutDown' => 'slideOutDown',
   'slideOutLeft' => 'slideOutLeft',
   'slideOutRight'  => 'slideOutRight',
   'rollOut'  => 'rollOut',  
);

vc_map( array(
    "name" => __("News Box", "framework"),
    "base" => "newsbox",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-wpb-ui-tab-content',
    "description" => __("insert news boxes.", 'framework'),	
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", 'framework'),
         "param_name" => "style",
	 "admin_label" => true,
         "value" => array(
			'Style 1' => 'nb1',
			'Style 2' => 'nb2',
			'Style 3' => 'nb3',
			'Style 4' => 'nb4',
			'Style 5' => 'nb5',
			'Style 6' => 'nb6',
			'News List' => 'list',
			),
      ),

	  array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Custom Box Title", 'framework'),
         "param_name" => "title",
	 "admin_label" => true,
         "value" => '',
         "description" => __("insert custom title for news box.", 'framework')
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
	 "admin_label" => true,
         "value" => array(
			'Latest Posts' => '' ,
			'Category' => 'category',
			'Tag' => 'tag'
			),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "cat",
	 "admin_label" => true,
         "dependency" => Array('element' => "display", 'value' => array('category')),
         "value" => array( "Select a Category" ) + $of_categories,
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
	 "admin_label" => true,
         "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" => '',
      ),
	  array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order By", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			'Recent' => 'latest' ,
			'Popular' => 'comment_count',
			'Random' => 'rand',
			),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "number_of_posts",
         "description" => __('number of post to show in the news box not work for all news boxes style', 'framework')
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt length", 'framework'),
         "param_name" => "nb_excerpt",
         "description" => __('post excerpt length in characters leave empty for default values', 'framework')
      ),
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Sub Categories", 'framework'),
         "param_name" => "sub_categories",
         "description" => __('enable sub categories as tabs on top of each news box', 'framework'),
         "value" => Array(__("Yes, please", "framework") => 'yes')
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Collapse subcategories after x category", 'framework'),
         "param_name" => "collapse_sc",
      ),

      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Show more Button", 'framework'),
         "param_name" => "show_more",
         "description" => __('Disable show more button as tabs on bottom of each news box', 'framework'),
         "value" => Array(__("Hide Now", "framework") => 'no')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("On click", 'framework'),
         "param_name" => "show_more_event",
         "value" => array(
			'Category/tag page' => '' ,
			'More posts with Ajax' => 'ajax'
		),
      ),
       array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Custom post type", 'framework'),
         "param_name" => "post_type",
         "description" => __('Advanced: you can use this option to get posts from custom post types, if you set this to anything the category and tags options not working', 'framework')
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Custom Class", 'framework'),
         "param_name" => "class",
      ),
   )
));

vc_map( array(
    "name" => __("Feature Slider", "framework"),
    "base" => "feature_slider",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-wpb-images-carousel',
    "description" => __("insert feature news slider.", 'framework'),	
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Slider", 'framework'),
         "param_name" => "type",
         "value" => array(
			'Simple (Default)' => 'def',
			'Grid Style' => 'slider2',
         'Category Slider' => 'cat',
			),
         'admin_label' => true
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cat',
			'Tags' => 'tag',
         'Specific Posts' => 'specific'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "cats",
         "dependency" => Array('element' => "display", 'value' => array('cat')),
         "value" => array( "Select a Category" ) + $of_categories,
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
         "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" =>'',
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Posts ids", 'framework'),
         "param_name" => "specific",
         "dependency" => Array('element' => "display", 'value' => array('specific')),
         "value" =>'',
         "description" => __('saperate each id with comma e.g. 155,165,1005', 'framework')
      ),
	  array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order By", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			'Recent' => 'latest' ,
			'Popular' => 'comment_count',
			'Random' => 'rand',
			),
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "number_of_posts",
         "dependency" => Array('element' => "type", 'value' => array('def', 'cat')),
         "description" => __('number of post to show in the slider', 'framework')
      ),
            
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation", 'framework'),
         "param_name" => "animation",
         "dependency" => Array('element' => "type", 'value' => array('def')),
         "description" => __('post excerpt length in characters leave empty for default values', 'framework'),
         "value" => array(
         			'Slide' => 'slide',
                  'Fade' => 'fade',
         			'Flip' => 'flip',
         			'Custom Animation' => 'custom',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation Out", 'framework'),
         "param_name" => "animationout",
         "dependency" => Array('element' => "animation", 'value' => array('custom')),
         "description" => __('slider item out animation', 'framework'),
         "value" => $ani_out
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation In", 'framework'),
         "param_name" => "animationin",
         "dependency" => Array('element' => "animation", 'value' => array('custom')),
         "description" => __('slider item in animation', 'framework'),
         "value" => $ani
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("AutoPlay", 'framework'),
         "param_name" => "autoplay",
         "dependency" => Array('element' => "type", 'value' => array('def')),
         "value" => array(
		'Yes' => 'yes',
		'No' => 'no'
	 )
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Timeout", 'framework'),
         "param_name" => "timeout",
         "description" => __('the time between each slide with ms, default : 4000', 'framework')
      ),
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Caption", 'framework'),
         "param_name" => "cap",
         "description" => __('Disable slider caption.', 'framework'),
         "dependency" => Array('element' => "type", 'value' => array('def','slider2')),
         "value" => Array(__("Hide Now", "framework") => 'no')
      ),

      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Numeric bullets", 'framework'),
         "param_name" => "num_bullets",
         "dependency" => Array('element' => "type", 'value' => array('def')),
         "value" => Array(__("Yes", "framework") => 'yes')
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt length", 'framework'),
         "param_name" => "exc",
         "description" => __('excerpt length leave it empty to disappear default: 150', 'framework')
      ),
      
   )
));

vc_map( array(
    "name" => __("Scroller", "framework"),
    "base" => "scroller",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-wpb-vc_carousel',
    "description" => __("insert news scroller.", 'framework'),	
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", "framework"),
         "param_name" => "style",
         "value" => array(
			'Style 1' => 'sc1',
			'Style 2' => 'sc2',
			),
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "description" => __('Scroller title', 'framework')
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Title size", 'framework'),
         "param_name" => "title_size",
         "value" => array(
			'Default ' => '17' ,
			'Big size' => '30',
			),
      ),

      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Scroller Sub title", 'framework'),
         "param_name" => "sub_title",
         "description" => __('Leave it blank if you want to hide', 'framework')
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cats',
			'Tag' => 'tags',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "cats",
         "dependency" => Array('element' => "display", 'value' => array('cats')),
         "value" => array( "Select a Category" ) + $of_categories,
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tags",
         "dependency" => Array('element' => "display", 'value' => array('tags')),
         "value" => '',
      ),
	  array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order By", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			'Recent' => 'latest' ,
			'Popular' => 'comment_count',
			'Random' => 'rand',
			),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "number_of_posts",
         "description" => __('number of post to show in the slider', 'framework')
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of Items", 'framework'),
         "param_name" => "items",
         "description" => __('number of items that display on each scroll default is 4', 'framework')
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Autoplay", 'framework'),
         "param_name" => "auto_play",
         "description" => __('Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds. false to display', 'framework')
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Speed", 'framework'),
         "param_name" => "speed",
         "description" => __('Slide speed in milliseconds Default : 300', 'framework')
      ),
      
   )
));

vc_map( array(
    "name" => __("News Picture", "framework"),
    "base" => "newspic",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-wpb-application-icon-large',
    "description" => __("insert news picture.", 'framework'),	
    "params" => array(
       array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "description" => __('News picture box title', 'framework')
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'category',
			'Tag' => 'tag',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "cat",
         "dependency" => Array('element' => "display", 'value' => array('category')),
         "value" => array( "Select a Category" ) + $of_categories,
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
         "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" => '',
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order By", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			'Recent' => 'latest' ,
			'Popular' => 'comment_count',
			'Random' => 'rand',
			),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of pictures", 'framework'),
         "param_name" => "count",
      ),       
   )
));


vc_map( array(
    "name" => __("Blog posts", "framework", 'framework'),
    "base" => "blog",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-wpb-wp',
    "description" => __("insert blog posts.", 'framework'),	
    "params" => array(
    	
    	array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", 'framework'),
         "param_name" => "style",
         "value" => array(
			'Default' => 'def',
         'Large' => 'large',
         'Category View' => 'grid',
			),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Grid columns", 'framework'),
         "param_name" => "cols",
         "dependency" => Array('element' => "style", 'value' => array('grid')),
         "value" => array(
         '2 columns' => 2,
         '3 columns' => 3,
         ),
      ),
            
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => '' ,
			'Category' => 'category',
			'Tag' => 'tag',
			'Specific Posts ids' => 'specific',
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
         "dependency" => Array('element' => "display", 'value' => array('category')),
         "value" => array( "Select a Category" ) + $of_categories,
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
         "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" => '',
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Specific Posts IDs", 'framework'),
         "param_name" => "specific",
         "dependency" => Array('element' => "display", 'value' => array('tag')),
      ), 
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Posts per page", 'framework'),
         "param_name" => "posts_per_page",
      ), 
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Offset", 'framework'),
         "param_name" => "offset",
         "description" => __('number of post to displace or pass over.', 'framework'),
      ), 
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt Length", 'framework'),
         "param_name" => "nexcerpt",
      ), 
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order By", 'framework'),
         "param_name" => "orderby",
         "value" => array(
         'Recent' => 'latest' ,
         'Popular' => 'comment_count',
         'Random' => 'rand',
         ),
         ),      
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Pagination", 'framework'),
         "param_name" => "pagination",
         "description" => __('Disable pagination.', 'framework'),
         "value" => Array(__("Hide Now", "framework") => 'no')
      ),    
// ads 
       array(
         "type" => "title",
         "class" => "",
         "value" => __("Ads", 'framework'),
         "param_name" => "hc_title",
        ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select Ad:", 'theme'),
         "param_name" => "ad_id",
         "value" => array('')+$ads,
      ),
      
   array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Display after x posts", 'theme'),
         "param_name" => "ad_count",
         "value" => 3,
         "description" => __('the number of posts to display ads after it. default is 3', 'theme')
      ),

      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Repeat ad", 'theme'),
         "param_name" => "ad_repeat",
         "description" => __('display the ad again after x posts', 'theme'),
         "value" => Array(__("Yes", "framework") => 'yes')
      ),       
   )
      )
);
		vc_map(
		array(
		   "name" => __("News Tabs","framework"),
		   "base" => "news_tabs",
		   "class" => "",
		   "icon" => "icon-wpb-ui-tab-content",
		   "category" => __("Multinews","framework"),
		   "as_parent" => array('only' => 'news_tab'),
		   "description" => __("news in tabs.","framework"),
		   "content_element" => true,
		   "show_settings_on_create" => false,
		   "params" => array(
			array(
			   "type" => "dropdown",
			   "class" => "",
			   "heading" => __("Style", 'framework'),
			   "param_name" => "style",
			   "value" => array(
					    __('Grid', 'framework') => 'grid',
					    __('List', 'framework') => 'list',
					),
			),
			array(
			   "type" => "dropdown",
			   "class" => "",
			   "heading" => __("Grid columns", 'framework'),
			   "param_name" => "columns",
			   "value" => array(
					    __('Two Columns', 'framework') => '2',
					    __('Three Columns', 'framework') => '3',
					    __('Four Columns', 'framework') => '4',
					    __('Five Columns', 'framework') => '5',
					),
			),			array(
			   "type" => "dropdown",
			   "class" => "",
			   "heading" => __("Switcher", 'framework'),
			   "param_name" => "switcher",
			   "value" => array(
					    __('Yes', 'framework') => 'yes',
					    __('No', 'framework') => 'no',
					),
			),
				    
				 ),
		    "js_view" => 'VcColumnView'
			));
		// Add list item
vc_map(
	array(
	   "name" => __("News Tab", 'framework'),
	   "base" => "news_tab",
	   "class" => "",
	   "icon" => "icon-wpb-ui-tab-content",
	   "category" => __("News Tab",'framework'),
	   "content_element" => true,
	   "as_child" => array('only' => 'news_tabs'),

	   "params" => array(

array(
   "type" => "textfield",
   "class" => "",
   "heading" => __("Title", 'framework'),
   "param_name" => "title",
   "value" => ''
),
array(
 "type" => "dropdown",
 "class" => "",
 "heading" => __("Display", 'framework'),
 "param_name" => "display",
 "value" => array(
	'Latest Posts' => '' ,
	'Category' => 'cat',
	'Tag' => 'tag'
	),
),
array(
 "type" => "dropdown",
 "class" => "",
 "heading" => __("Category", 'framework'),
 "param_name" => "cat",
 "dependency" => Array('element' => "display", 'value' => array('cat')),
 "value" => array( "Select a Category" ) + $of_categories,
),
array(
 "type" => "textfield",
 "class" => "",
 "heading" => __("Tag", 'framework'),
 "param_name" => "tag",
 "dependency" => Array('element' => "display", 'value' => array('tag')),
 "value" => '',
),
array(
 "type" => "textfield",
 "class" => "",
 "heading" => __("Exclude Categories", 'framework'),
 "param_name" => "cats",
 "dependency" => Array('element' => "display", 'value' => array('')),
 "description" => __('Exclude categories by id ex: 2,4', 'framework')
),
array(
 "type" => "textfield",
 "class" => "",
 "heading" => __("Number of posts", 'framework'),
 "param_name" => "count",
 "description" => __('number of post to show in the news tab', 'framework')
),
		
	array(
	   "type" => "dropdown",
	   "class" => "",
	   "heading" => __("Order by", 'framework'),
	   "param_name" => "orderby",
	   "value" => array(
			    __('Recent', 'framework') => '',
			    __('Popular', 'framework') => 'popular',
             __('Random', 'framework') => 'random',
			    __('Most viewed', 'framework') => 'views',
			),
	),
		    		
	   )
	) 
);
	
vc_map( array(
    "name" => __("Ad", "framework"),
    "base" => "ad",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-mom_blog_posts',
    "description" => __("insert ad.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select Ad:", 'framework'),
         "param_name" => "id",
         "value" => $ads,
      ),
      
   )
));

vc_map( array(
    "name" => __("Review", "framework"),
    "base" => "review",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-mom_review',
    "description" => __("insert review.", 'framework'),
    "params" => array(
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Review Post id:", 'framework'),
	"description" => __("leave empty for current post.", 'framework'),
         "param_name" => "id",
         "value" => '',
      ),
      
   )
));

vc_map( array(
    "name" => __("Animator", "framework"),
    "base" => "animate",
	"category" => __('Multinews', 'framework'),
    "icon" => 'icon-mom_animate',
    "description" => __("elements Animation.", 'framework'),
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "as_parent" => array('except' => ''),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation", 'framework'),
	"description" => __("tons of animations.", 'framework'),
         "param_name" => "animation",
         "value" => array(__('None', 'framework') => '') + $ani,
      ),
      
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Duration", 'framework'),
	"description" => __("animation duration in seconds.", 'framework'),
         "param_name" => "duration",
      ),
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Delay", 'framework'),
	"description" => __("animated element delay in seconds.", 'framework'),
         "param_name" => "delay",
      ),
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Iteration Count", 'framework'),
	"description" => __("number of animation times -1 for non stop animation.", 'framework'),
         "param_name" => "iteration",
      ),  	    
   )
));
} //end vc_map if
?>