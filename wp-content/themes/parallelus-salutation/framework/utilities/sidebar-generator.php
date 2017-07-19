<?php
/*
Plugin Name: Sidebar Generator
Plugin URI: http://www.getson.info
Description: This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish.
Version: 1.0.1
Author: Kyle Getson
Author URI: http://www.kylegetson.com
Copyright (C) 2009 Clickcom, Inc.
*/

/*
Copyright (C) 2009 Kyle Robert Getson, kylegetson.com and getson.info

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class sidebar_generator {
	
	function sidebar_generator() {
		add_action('init',array('sidebar_generator','init'));		
	}
	
	static function init(){

		// Register each sidebar
	    $sidebars = sidebar_generator::get_sidebars();
	    

	    if(is_array($sidebars)){
			global $shortname;
			
			$sidebarName = get_option( $shortname. 'sidebarSettings'); // get name values
			
			foreach($sidebars as $key => $value){
				$id = $key;
				$name = $value['name'];
				$alias = $value['alias'];
				
				//$sidebar_class = sidebar_generator::name_to_class($name.$id);
				$sidebar_class = sidebar_generator::name_to_class($alias);
				
				register_sidebar(array(
			    	'name'=>$name,
					'id'=> "generated_sidebar-$id",
			    	'before_widget' => '<div id="%1$s" class="widget scg_widget '.$sidebar_class.' %2$s">',
		   			'after_widget' => '</div>',
		   			'before_title' => '<h4 class="widgetTitle">',
					'after_title' => '</h4>',
		    	));	
			}
		}
	}
	
	// Called by the action get_sidebar. this is what places this into the theme
	//...............................................
	static function get_sidebar($index){
		wp_reset_query();
		global $wp_query;
		$post = $wp_query->get_queried_object();
		$selected_sidebar = get_post_meta($post->ID, 'customSidebar', true);
		if($selected_sidebar != '' && $selected_sidebar != "0"){
			echo "\n\n<!-- begin generated sidebar [$selected_sidebar] -->\n";
			//echo "<!-- selected: $selected_sidebar -->";
			dynamic_sidebar($selected_sidebar);
			echo "\n<!-- end generated sidebar -->\n\n";			
		}else{
			//dynamic_sidebar($index);
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($index) ) :
			endif;
		}
	}
	
	// Gets the generated sidebars
	//...............................................
	static function get_sidebars(){
		//global $shortname;
		$sidebars = array_merge( 
			(array) get_theme_var('sidebars'), 
			(array) get_theme_var('sidebar-tabs')
		);
		//$sidebars = get_theme_var('sidebars');
		//$sidebars = get_option( $shortname. 'sidebarSettings');
		$sidebar_list = array();
		foreach ((array) $sidebars as $item) {
			$name =(array_key_exists('bg_color', $item)) ? $item['label'] . ' (tab)' : $item['label'];	// only tabs have the 'bg_color' attribute
			$sidebar_list[$item['key']] = array('name' => $name, 'alias' => $item['alias']);
		}

		return $sidebar_list;
	}
	static function name_to_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}
}
$sbg = new sidebar_generator;

function generated_dynamic_sidebars($index){
	sidebar_generator::get_sidebar($index);	
	return true;
}
?>