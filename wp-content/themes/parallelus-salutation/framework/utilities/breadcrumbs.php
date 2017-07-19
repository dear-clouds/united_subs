<?php
/*

------------------------------------------------------------------

Based on Yoast Breadcrumbs by Joost de Valk

------------------------------------------------------------------

Copyright (C) 2008-2010, Joost de Valk
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Joost de Valk or Yoast nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

------------------------------------------------------------------

Function Attributes:

show_breadcrumb( $prefix, $suffix, $display, $atts )

	$prefix		(string)		HTML before e.g. <div class="breadcrumbs">
	$suffix		(string)		HTML after e.g. </div>
	$display	(true/false)	echo or return value
	$atts		(array)			Optional settings for breadcrumb display and attributes (overrids defaults
		
			'home' => 'Home',					// The home title
			'blog' => 'Blog',					// The blog title
			'sep' => '&raquo;',					// Divider text
			'blogpageid' => 0,				// ID of blog page to show in path
			'prefix' => '',						// Text before breadcrumbs "You are here: "
			'archiveprefix' => 'Archives:',		// Archives page prefix
			'searchprefix' => 'Search for:',	// Search results prfix
			'boldlast' => 1,					// Last item bold (current page)
			'nofollowhome' => 0,				// no follow home
			'catinpostpath' => 1				// Show category in single post path

------------------------------------------------------------------

Sample Usage:

	show_breadcrumb( '<div class="breadcrumbs">, '</div>');

	show_breadcrumb( '<div class="breadcrumbs">, '</div>', true, array('sep' => '/', 'blogpageid' => 123, 'boldlast' => 0) );

	<div class="breadcrumbs"><?php echo show_breadcrumb( '', '', false ) ?></div>


*/


#-----------------------------------------------------------------
# Breadcrumbs function ( Home > Page > Sub-Page )
#-----------------------------------------------------------------

if ( ! function_exists( 'show_breadcrumb' ) ) :
	function show_breadcrumb($prefix = '', $suffix = '', $display = true, $atts = array()) {
		global $wp_query, $post;
	
		// Defaults
		
		$defaults = array( 
			'home' => __('Home', THEME_NAME),					// The 
			'blog' => __('Blog', THEME_NAME),
			'sep' => '&nbsp;/&nbsp;', //'&raquo;',
			'blogpageid' => 0,	// id of blog page to show in path
			'prefix' => '',
			'archiveprefix' => __('Archives:', THEME_NAME),
			'searchprefix' => __('Search for: ', THEME_NAME),
			'boldlast' => 0,
			'nofollowhome' => 0,
			'catinpostpath' => 1
		);
		
		$savedOptions = array(); //get_option("yoast_breadcrumbs");
		
		$opt = array_merge($defaults, $savedOptions, (array)$atts);
		
		$bold = $opt['boldlast'];
	
		if (!function_exists('bold_or_not')) {
			function bold_or_not($input, $bold) {
				if ($bold) {
					return '<strong>'.$input.'</strong>';
				} else {
					return $input;
				}
			}		
		}
	
		if (!function_exists('yoast_get_category_parents')) {
			// Copied and adapted from WP source
			function yoast_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
				$chain = '';
				$parent = &get_category($id);
				if ( is_wp_error( $parent ) )
				   return $parent;
	
				if ( $nicename )
				   $name = $parent->slug;
				else
				   $name = $parent->cat_name;
	
				if ( $parent->parent && ($parent->parent != $parent->term_id) )
				   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);
	
				$chain .= bold_or_not($name, $bold);
				return $chain;
			}
		}
		
		$nofollow = ' ';
		if ($opt['nofollowhome']) {
			$nofollow = ' rel="nofollow" ';
		}
		
		$on_front = get_option('show_on_front');
		
		if ($on_front == "page") {
			$homelink = '<a'.$nofollow.'href="'.get_permalink(get_option('page_on_front')).'">'.$opt['home'].'</a>';
			$bloglink = $homelink.' '.$opt['sep'].' <a href="'.get_permalink(get_option('page_for_posts')).'">'.$opt['blog'].'</a>';
		} else {
			$homelink = '<a'.$nofollow.'href="'.get_bloginfo('url').'">'.$opt['home'].'</a>';
			$bloglink = $homelink;
		}
			
		if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) {
			$output = bold_or_not($opt['home'], $bold);
		} elseif ( $on_front == "page" && is_home() ) {
			$output = $homelink.' '.$opt['sep'].' '.bold_or_not($opt['blog'], $bold);
		} elseif ( !is_page() ) {
			$output = $bloglink.' '.$opt['sep'].' ';
			if ( ( is_single() || is_category() || is_tag() || is_date() || is_author() ) && $opt['blogpageid'] != false) {
				// $output .= '<a href="'.get_permalink($opt['blogpageid']).'">'.get_the_title($opt['blogpageid']).'</a> '.$opt['sep'].' ';
				$output .= '<a href="'.get_permalink($opt['blogpageid']).'">'.$opt['blog'].'</a> '.$opt['sep'].' ';
			} 
			if (is_single() && $opt['catinpostpath']) {
				$cats = get_the_category();
				$cat = $cats[0];
				if ( is_object($cat) ) {
					if ($cat->parent != 0) {
						$output .= get_category_parents($cat->term_id, true, " ".$opt['sep']." ");
					} else {
						$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a> '.$opt['sep'].' '; 
					}
				}
			}
			if ( is_category() ) {
				$cat = intval( get_query_var('cat') );
				$output .= yoast_get_category_parents($cat, false, " ".$opt['sep']." ");
			} elseif ( is_tag() ) {
				$output .= bold_or_not($opt['archiveprefix']." ".single_cat_title('',false), $bold);
			} elseif ( is_date() ) { 
				$output .= bold_or_not($opt['archiveprefix']." ".single_month_title(' ',false), $bold);
			} elseif ( is_author() ) { 
				$user = get_userdatabylogin($wp_query->query_vars['author_name']);
				$output .= bold_or_not($opt['archiveprefix']." ".$user->display_name, $bold);
			} elseif ( is_search() ) {
				$output .= bold_or_not($opt['searchprefix'].' "'.stripslashes(strip_tags(get_search_query())).'"', $bold);
			} else if ( is_tax() ) {
				$taxonomy 	= get_taxonomy ( get_query_var('taxonomy') );
				$term 		= get_query_var('term');
				$output .= $taxonomy->label .': '.bold_or_not( $term, $bold );
			} else {
				$output .= bold_or_not(get_the_title(), $bold);
			}
		} else {
			$post = $wp_query->get_queried_object();
	
			// If this is a top level Page, it's simple to output the breadcrumb
			if ( 0 == $post->post_parent ) {
				$output = $homelink." ".$opt['sep']." ".bold_or_not(get_the_title(), $bold);
			} else {
				if (isset($post->ancestors)) {
					if (is_array($post->ancestors))
						$ancestors = array_values($post->ancestors);
					else 
						$ancestors = array($post->ancestors);				
				} else {
					$ancestors = array($post->post_parent);
				}
	
				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse($ancestors);
	
				// Add the current Page to the ancestors list (as we need it's title too)
				$ancestors[] = $post->ID;
	
				$links = array();			
				foreach ( $ancestors as $ancestor ) {
					$tmp  = array();
					$tmp['title'] 	= strip_tags( get_the_title( $ancestor ) );
					$tmp['url'] 	= get_permalink($ancestor);
					$tmp['cur'] = false;
					if ($ancestor == $post->ID) {
						$tmp['cur'] = true;
					}
					$links[] = $tmp;
				}
	
				$output = $homelink;
				foreach ( $links as $link ) {
					$output .= ' '.$opt['sep'].' ';
					if (!$link['cur']) {
						$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
					} else {
						$output .= bold_or_not($link['title'], $bold);
					}
				}
			}
		}
		if ($opt['prefix'] != "") {
			$output = $opt['prefix']." ".$output;
		}
		if ($display) {
			echo $prefix.$output.$suffix;
		} else {
			return $prefix.$output.$suffix;
		}
	}
endif;
