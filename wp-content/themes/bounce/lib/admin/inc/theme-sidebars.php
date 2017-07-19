<?php

/*************************** Default Sidebars ***************************/
	
register_sidebar(array('name' => __('Standard Sidebar', 'gp_lang'), 'id'=> 'default',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));
   
register_sidebar(array('name' => __('Contact Page Sidebar', 'gp_lang'), 'id'=> 'contact-page',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));
	   
register_sidebar(array('name' => __('Footer 1', 'gp_lang'), 'id' => 'footer-1',
	'before_widget' => '<div id="%1$s" class="footer-widget-inner %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));        

register_sidebar(array('name' => __('Footer 2', 'gp_lang'), 'id' => 'footer-2',
	'before_widget' => '<div id="%1$s" class="footer-widget-inner %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
	
register_sidebar(array('name' => __('Footer 3', 'gp_lang'), 'id' => 'footer-3',
	'before_widget' => '<div id="%1$s" class="footer-widget-inner %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
	
register_sidebar(array('name' => __('Footer 4', 'gp_lang'), 'id' => 'footer-4',
	'before_widget' => '<div id="%1$s" class="footer-widget-inner %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
 
?>