<?php

class ui_themes_for_calendarize_it {
	var $plugin_url;
	var $plugin_path;
	var $theme_dir;
	function __construct($plugin_path,$plugin_url,$theme_dir='themes'){
		$this->plugin_path 	= $plugin_path;
		$this->plugin_url	= $plugin_url;
		$this->theme_dir	= $theme_dir;
		//-- add options to calendarize-it options
		add_filter('rhc-ui-theme',array(&$this,'ui_theme_options'),11,1);
		//-- add path info 
		add_filter('rhc_ui_theme_url',array(&$this,'ui_theme_url'),11,2);
	}
	
	function ui_theme_options($options){
		$provided_themes = $this->get_ui_stylesheets();
		if(count($provided_themes)>0){
			foreach($provided_themes as $t){
				$options[$t->name]=$t->name;
			}
		}
		return $options;
	}
	
	function ui_theme_url($url,$theme){
		$provided_themes = $this->get_ui_stylesheets();
//		die(isset($provided_themes[$theme])?$this->plugin_url."themes/$theme/".$provided_themes[$theme]->path:$url);
		return isset($provided_themes[$theme])?$this->plugin_url.$this->theme_dir."/$theme/".$provided_themes[$theme]->path:$url;
		
	}
	
	function get_ui_stylesheets(){
		$res = array();
		$theme_path = $this->plugin_path.$this->theme_dir;
		$theme_dirs = $this->get_dirs($theme_path);
		if(count($theme_dirs)>0){
			foreach($theme_dirs as $dir){
				$css_files = $this->get_css_files($theme_path.'/'.$dir);
				$res[$dir]=(object)array(
					'name'=> $dir,
					'path'=> $css_files[0]//more than one file is unexpected.
				);
			}
		}
		return $res;
	}
	
	function get_dirs($path){
		$dirs = array();
		if ($handle = @opendir( $path )) {
		    while (false !== ($file = readdir($handle))) {
			    if(!in_array($file,array('.','..'))){
					$dirs[]=$file;
				}
		    }
		    @closedir($handle);
		}	
		return $dirs;
	}
	
	function get_css_files($path){
		$files = array();
		if ($handle = @opendir( $path )) {
		    while (false !== ($file = @readdir($handle))) {
				$path_parts = @pathinfo($file);
				if('css'==$path_parts['extension']){
					$files[]=$file;
				}
		    }
		    @closedir($handle);
		}	
		return $files;
	}	
}
?>