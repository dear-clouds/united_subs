<?php
/**
 * Data manager class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class	
class GW_GoPricing_Data {
	
	protected static $instance = null;
	protected static $globals;

	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
			
	protected static $cpt_name = 'Go Pricing Tables';
	protected static $cpt_slug = 'go_pricing_tables';

	
	/**
	 * Initialize the class
	 */
	
	private function __construct() {
		
		self::$globals = GW_GoPricing::instance();
		self::$plugin_version = self::$globals['plugin_version'];
		self::$db_version = self::$globals['db_version'];		
		self::$plugin_prefix = self::$globals['plugin_prefix'];
		self::$plugin_slug = self::$globals['plugin_slug'];	
		
		// Register custom post types
		add_action( 'init',  array( $this, 'register_custom_post_type' ) );
		
	}

	
	/**
	 * Return an instance of this class
	 *
	 * @return object
	 */
	 
	public static function instance() {
		
		if ( self::$instance == null ) self::$instance = new self;
		return self::$instance;
		
	}	
	
	
	/**
	 * Register custom post type
	 *
	 * @return void
	 */
	 
	public function register_custom_post_type() {
	
		if ( function_exists( 'register_post_type' ) ) { 
			
			$cpt_args = array(
				'labels' => array ( 'name' => self::$cpt_name ),
				'public' => false,
				'has_archive' => false,
				'can_export' => false,
				'supports' => array( 'title', 'custom-fields', 'excerpt' )
			);
			
			register_post_type( self::$cpt_slug, $cpt_args );
			
		}			
	
	}
	
	
	/**
	 * Update table (new or edit)
	 *
	 * @return int|bool Returns post id or false on error.
	 */
	 
	public static function update_table( $table_data ) {
		
		if ( empty( $table_data ) ) return false;
		
		$post_data = array(); 
		$post_meta = array();
		
		foreach ( (array)$table_data as $data_key => $data_value ) {
			
			$post_data['post_status'] = 'publish';
			$post_data['post_type'] = self::$cpt_slug;
						
			if ( $data_key == 'postid' ) {
				$post_data['ID'] = $data_value;
			} elseif ( $data_key == 'name' ) {				
				$post_data['post_title'] = $data_value;
			} elseif ( $data_key == 'id' ) {
				$post_data['post_excerpt'] = $data_value;
			} else {
				$post_meta[$data_key] = $data_value;
			}
			
		}
		
		if ( empty( $post_data ) ) return false;
		
		$post_id = wp_insert_post( $post_data );

		if ( empty( $post_id ) ) return false;

		$old_post_meta = self::get_table_postmeta( $post_id );
		
		/* Update or add meta */
		foreach ( (array)$post_meta as $meta_key => $meta_value ) {
			if ( $old_post_meta !== false && !empty( $old_post_meta[$meta_key] ) && $old_post_meta[$meta_key] != $meta_value ) { 
				update_post_meta( $post_id, $meta_key, $meta_value );
				unset( $old_post_meta[$meta_key] );
			} elseif ( $old_post_meta !== false && !empty( $old_post_meta[$meta_key] ) ) {
				unset( $old_post_meta[$meta_key] );
			} else {
				update_post_meta( $post_id, $meta_key, $meta_value );
				unset( $old_post_meta[$meta_key] );				
			}
		}

		/* Delete old meta */
		foreach ( (array)$old_post_meta as $meta_key => $meta_value ) {
			delete_post_meta( $post_id, $meta_key );
		}

		return $post_id;

	}
	
	
	/**
	 * Delete table
	 *
	 * @return bool Returns true on success or false on error.
	 */
	 
	public static function delete_table( $post_id ) {
		
		if ( empty( $post_id ) ) return false;
		
		$post_type = get_post_type( $post_id );
		
		if ( $post_type === false || $post_type != self::$cpt_slug ) return false;
		
		$post = wp_delete_post( $post_id, true );
		
		if ( empty( $post ) ) return false;
		
		return true;

	}

	
	/**
	 * Get table post
	 *
	 * @return object|bool Returns post object or false on error.
	 */
	 
	public static function get_table_post( $args ) {
				
		if ( empty( $args ) ) return false;
		
		if ( !empty( $args['post_excerpt'] ) ) {

			global $wpdb;
			$id = $wpdb->get_var("SELECT {$wpdb->prefix}posts.ID FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.post_excerpt = '" . $args['post_excerpt']."'");
			if ( !empty( $id ) ) $args['p'] = $id;
		}
	
		if ( empty( $args['p'] ) ) return false;
		
		$posts_query = new WP_Query( $args );
				
		if ( empty( $posts_query->posts ) ) return false;
		
		wp_reset_query();

		$post = $posts_query->posts[0];
		
		if ( empty( $post ) ) return false;
		
		return $post;

	}
	
	
	/**
	 * Get table postmeta
	 *
	 * @return array|bool Returns post object or false on error.
	 */
	 
	public static function get_table_postmeta( $post_id ) {
		
		if ( empty( $post_id ) ) return false;
		
		$meta = get_post_meta( $post_id );
		
		if ( empty( $meta ) ) return false;

		foreach ( $meta as $meta_key => $meta_value ) {
			$meta_val = @unserialize ( $meta_value[0] );
			if ( $meta_val === false ) {
				$meta[$meta_key] = $meta_value[0];
			} else {
				$meta[$meta_key] = $meta_val;
			}
		}		
			
		return $meta;

	}	
	

	/**
	 * Get table
	 *
	 * @return array|bool Returns table array or false on error.
	 */
	 
	public static function get_table( $param, $with_meta = true, $by = 'postid' ) {
		
		$table_data = array();
		
		if ( empty( $param ) ) return false;
		
		if ( !empty( $by ) ) {
			switch( $by ) {
				case 'id' :
					$args = array(
						'post_type' => self::$cpt_slug,
						'post_excerpt' => $param
					);
					break;
				default :
					$args = array(
						'p' => $param,
						'post_type' => self::$cpt_slug
					);
			}
			
		}
		
		$post = self::get_table_post( $args );
		
		if ( $post === false ) return false;
		
		$table_data['postid'] = $post->ID;
		$table_data['name'] = $post->post_title;
		$table_data['id'] = $post->post_excerpt;
		
		if ( empty( $table_data ) ) return false;
		
		if ( $with_meta === true ) {
		
			$meta = self::get_table_postmeta( (int)$table_data['postid'] );
	
			foreach ( (array)$meta as $meta_key => $meta_value ) {
				$table_data[$meta_key] = $meta_value;
			}

		}
		
		return $table_data;

	}

	
	/**
	 * Get table posts
	 *
	 * @return object|bool Returns cpt posts data obj or false on error.
	 */
	 
	public static function get_table_posts( $post_ids = '', $orderby = 'ID', $order = 'ASC', $posts_per_page = -1, $offset = 0, $meta_key = '', $meta_value = '' ) {
		
		if ( !empty( $post_ids ) && !is_array( $post_ids ) ) { $post_ids = array( $post_ids ); }
		
		$args = array(
			'post_type' => self::$cpt_slug,		
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $posts_per_page,
			'offset' => $offset,
			'meta_key' => $meta_key,
			'meta_value' => $meta_value,
			'post__in' => $post_ids
		);	
		
		$posts_query = new WP_Query( $args );
		
		if ( empty( $posts_query->posts ) ) return false;
		
		wp_reset_query();

		return $posts_query->posts;

	}


	/**
	 * Get tables
	 *
	 * @return object|bool Returns table main data array or false on error.
	 */
	 
	public static function get_tables( $post_ids = array(), $with_meta = false, $orderby = 'ID', $order = 'ASC', $posts_per_page = -1, $offset = 0, $meta_key = '', $meta_value = '' ) {

		$tables_data = array();
				
		$posts = self::get_table_posts( $post_ids, $orderby, $order, $posts_per_page, $offset, $meta_key, $meta_value );
		
		if ( $posts === false ) return false;
		
		foreach ( (array)$posts as $post ) {
			
			if ( $with_meta == false ) {
				$tables_data[$post->ID] = array(
					'postid' => $post->ID,
					'name' => $post->post_title, 
					'id' => $post->post_excerpt
				);
			} else {
				$tables_data[$post->ID] = self::get_table( $post->ID, $with_meta );
			}
		}
		
		return $tables_data;
		
	}
	
	
	/**
	 * Export
	 *
	 * @return string|bool Returns serialized db data.
	 */
	 
	public static function export( $post_ids = array() ) {

		$tables_data = self::get_tables( $post_ids, true );		
		if ( $tables_data === false ) return false;
		
		foreach ( (array)$tables_data as $table_key => $table_data ) {
			if ( !empty( $tables_data[$table_key]['postid'] ) ) unset( $tables_data[$table_key]['postid'] );
		}

		$tables_data = apply_filters( 'go_pricing_export_data', $tables_data );

		$tables_data['_info'] = array (
			'plugin_version' => self::$plugin_version,
			'db_version' => self::$db_version
		);

		if ( !empty( $tables_data ) ) $export_data = base64_encode( serialize( $tables_data ) );
		
		return $export_data;
		
	}
	

	/**
	 * Import
	 *
	 * @return bool|int Imports table data.
	 */
	 
	public static function import( $import_data = null, $override = false, $ids = array() ) {
		
		$import_cnt = 0; 

		if ( $import_data === null ) return false;

		$import_tables_data = @unserialize( base64_decode( $import_data ) );
		
		if ( $import_tables_data === false ) return false;
		
		$tables_data = self::get_tables();

		foreach ( (array)$tables_data as $tables_key => $table_data ) {				
			if ( !empty( $table_data['id'] ) ) $table_ids[$table_data['id']] = $tables_key;
		}
		
		global $wpdb;

		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );		
		
		$wpdb->query( 'SET autocommit = 0;' );
		
		foreach ( (array)$import_tables_data as $import_tables_key => $import_table_data ) {
			
			if ( $import_tables_key == '_info' ) continue;

			if ( !empty( $ids ) && !in_array( $import_tables_key, (array)$ids ) ) continue;
			
			$import_cnt++;
			
			if ( !empty( $table_ids ) && isset( $import_table_data['id'] ) && $import_table_data['id'] != '' && array_key_exists( $import_table_data['id'], (array)$table_ids ) ) {
				
				if ( $override === true ) {
					$import_table_data['postid'] = $table_ids[$import_table_data['id']];
				} else {
					$import_table_data['name'] .= ' (' . __( 'copy', 'go_pricing_textdomain' ) . ')';	
					$import_table_data['id'] = substr( $import_table_data['id'], 0 ,10 ) . '_' . uniqid();
				}			

			}
			
			$result = self::update_table( $import_table_data );
			if ( $result === false ) return false;				
			
		}
		
		$wpdb->query( 'COMMIT;' );
		$wpdb->query( 'SET autocommit = 1;' );

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );		
		
		return $import_cnt;
		
	}
	
	
	/**
	 * Database updater to to v2.0
	 *
	 * @return bool Returns bool.
	 */				

	public static function db_update() {
				
		$tables_data = array();
		
		$old_tables_data = get_option( 'go_pricing_tables' );		
		$general_settings = get_option( 'go_pricing_table_settings' );

		$tables_count = 0;

		if ( $old_tables_data === false ) return false;

		
		foreach ( (array)$old_tables_data as $old_tables_key => $old_table_data ) {

			if ( isset( $old_table_data['table-name'] ) ) $tables_data[$old_tables_key]['name'] = $old_table_data['table-name'];
			if ( isset( $old_table_data['table-id'] ) ) $tables_data[$old_tables_key]['id'] = $old_table_data['table-id'];

			/* Layout */
			if ( isset( $old_table_data['colspace'] ) && $old_table_data['colspace'] != '' ) $tables_data[$old_tables_key]['col-space'] = 10;
			
			if ( isset( $general_settings['colw-min'] )  ) {
				if ( $general_settings['colw-min'] != '' ) $tables_data[$old_tables_key]['col-width']['min'] = (int)$general_settings['colw-min'];
			} else {
				$tables_data[$old_tables_key]['col-width']['min'] = 130;
			}
			
			if ( isset( $general_settings['colw-max'] )  ) {
				if ( $general_settings['colw-max'] != '' ) $tables_data[$old_tables_key]['col-width']['max'] = (int)$general_settings['colw-max'];
			} else {
				$tables_data[$old_tables_key]['col-width']['max'] = '';
			}			
			
			if ( isset( $old_table_data['hide-footer-chk'] ) ) $tables_data[$old_tables_key]['hide-footer'] = 1;
			if ( isset( $old_table_data['enlarge-current-chk'] ) ) $tables_data[$old_tables_key]['enlarge-current'] = 1;

			/* Force to enable equalize */
			$tables_data[$old_tables_key]['equalize']['column'] = 1;
			$tables_data[$old_tables_key]['equalize']['body'] = 1;
			$tables_data[$old_tables_key]['equalize']['footer'] = 1;				
			
			/* Global Style */
			$tables_data[$old_tables_key]['style'] = 'classic';			
			if ( isset( $old_table_data['tooltip-width'] ) ) $tables_data[$old_tables_key]['tooltip']['width'] = $old_table_data['tooltip-width'];
			if ( isset( $old_table_data['tooltip-bg-color'] ) ) $tables_data[$old_tables_key]['tooltip']['bg-color'] = $old_table_data['tooltip-bg-color'];
			if ( isset( $old_table_data['tooltip-text-color'] ) ) $tables_data[$old_tables_key]['tooltip']['text-color'] = $old_table_data['tooltip-text-color'];
			
			$tables_data[$old_tables_key]['col-border'] = 1;
			$tables_data[$old_tables_key]['col-border-radius'] = array(
				'top' => 0,
				'right' => 0,
				'bottom' => 0,
				'left' => 0
			);
			$tables_data[$old_tables_key]['col-row-border'] = 1;
			$tables_data[$old_tables_key]['col-box-shadow'] = 1;
			
			/* Responsivity */
			if ( !empty( $general_settings['responsivity'] ) ) {

				$tables_data[$old_tables_key]['responsivity']['enabled'] = 1;
				if ( isset( $general_settings['size1-min'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['tp']['min'] = $general_settings['size1-min'] != '' ? (int)$general_settings['size1-min'] : $general_settings['size1-min'];
				if ( isset( $general_settings['size1-max'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['tp']['max'] = $general_settings['size1-max'] != '' ? (int)$general_settings['size1-max'] : $general_settings['size1-max'];
				$tables_data[$old_tables_key]['responsivity']['views']['tp']['cols'] = '';

				if ( isset( $general_settings['size2-min'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['ml']['min'] = $general_settings['size2-min'] != '' ? (int)$general_settings['size2-min'] : $general_settings['size2-min'];
				if ( isset( $general_settings['size2-max'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['ml']['max'] = $general_settings['size2-max'] != '' ? (int)$general_settings['size2-max'] : $general_settings['size2-max'];
				$tables_data[$old_tables_key]['responsivity']['views']['ml']['cols'] = 2;

				if ( isset( $general_settings['size3-min'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['mp']['min'] = $general_settings['size3-min'] != '' ? (int)$general_settings['size3-min'] : $general_settings['size3-min'];
				if ( isset( $general_settings['size3-max'] ) ) $tables_data[$old_tables_key]['responsivity']['views']['mp']['max'] = $general_settings['size3-max'] != '' ? (int)$general_settings['size3-max'] : $general_settings['size3-max'];
				$tables_data[$old_tables_key]['responsivity']['views']['mp']['cols'] = 1;				
								
			} else {
			
				$tables_data[$old_tables_key]['responsivity']['views']['tp']['min'] = 768;
				$tables_data[$old_tables_key]['responsivity']['views']['tp']['max'] = 959;
				$tables_data[$old_tables_key]['responsivity']['views']['tp']['cols'] = '';

				$tables_data[$old_tables_key]['responsivity']['views']['ml']['min'] = 480;
				$tables_data[$old_tables_key]['responsivity']['views']['ml']['max'] = 767;
				$tables_data[$old_tables_key]['responsivity']['views']['ml']['cols'] = 2;

				$tables_data[$old_tables_key]['responsivity']['views']['mp']['min'] = '';
				$tables_data[$old_tables_key]['responsivity']['views']['mp']['max'] = 479;
				$tables_data[$old_tables_key]['responsivity']['views']['mp']['cols'] = 1;				

			}
			
			$col_count = !empty( $old_table_data['col-style'] ) ? count( $old_table_data['col-style'] ) : 0;
			$row_count = !empty( $old_table_data['col-detail'] ) && $col_count > 0 ? count( $old_table_data['col-detail'] ) / $col_count : 0;
			
			/* Colum Data */
			for ($x = 0; $x < $col_count; $x++) {
				
				/* Colum style */
				$column_style = explode( '_', $old_table_data['col-style'][$x] );
				
				/* General */
				if ( isset( $column_style[0] ) ) $tables_data[$old_tables_key]['col-data'][$x]['col-style-type'] = $column_style[0];
				if ( !empty( $old_table_data['col-highlight'][$x] ) ) $tables_data[$old_tables_key]['col-data'][$x]['col-highlight'] = 1;
				if ( !empty( $old_table_data['col-disable-enlarge'][$x] ) ) $tables_data[$old_tables_key]['col-data'][$x]['col-disable-enlarge'] = 1;
				if ( !empty( $old_table_data['col-disable-hover'][$x] ) ) $tables_data[$old_tables_key]['col-data'][$x]['col-disable-hover'] = 1;
				
				/* General - Decoration */
				$decoration = array();
				
				/* Shadow */
				if ( isset( $old_table_data['col-shadow'][$x] ) ) $decoration[] = sprintf( 'col-shadow=%s', $old_table_data['col-shadow'][$x] );
				
				/* Sign (Ribbon) */				
				if ( isset( $old_table_data['col-ribbon'][$x] ) && $old_table_data['col-ribbon'][$x] != '' ) {
					
					if ( $old_table_data['col-ribbon'][$x] == 'custom' ) {
						$decoration[] = 'col-sign-type=custom-img';
						$decoration[] = sprintf( 'col-sign%%5Bcustom-img%%5D%%5Bdata%%5D=%s', $old_table_data['col-custom-ribbon'][$x] );
						if ( isset( $old_table_data['col-custom-ribbon-align'][$x] ) ) $decoration[] = 'col-sign-align=' . $old_table_data['col-custom-ribbon-align'][$x];
					} else {
						$decoration[] = 'col-sign-type=classic-ribbon';
						$old_table_data['col-ribbon'][$x] = str_replace( 'percent', '', $old_table_data['col-ribbon'][$x] );
						$decoration[] = sprintf( 'col-sign%%5Bclassic-ribbon%%5D=%s', $old_table_data['col-ribbon'][$x] );
						if (preg_match("/left/", $old_table_data['col-ribbon'][$x] ) ) {
							$decoration[] = 'col-sign-align=left';
						} else {
							$decoration[] = 'col-sign-align=right';
						}						
					}
					
					$decoration[] = 'col-sign-position%5Bposx%5D=0';
					$decoration[] = 'col-sign-position%5Bposy%5D=0';					
					
				}
				
				if ( !empty( $decoration ) ) $tables_data[$old_tables_key]['col-data'][$x]['decoration'] = implode( '&', $decoration );
								
								
				/* Header */
				
				/* Title */
				$title_content = array();
				
				if ( isset( $old_table_data['col-title'][$x] ) ) {
					
					if ( isset( $column_style[1] ) && $column_style[1] == 'team' ) {
						preg_match( '/<small>.*<\/small>/', $old_table_data['col-title'][$x], $title );
						if ( isset( $title[0] ) && $title[0] != '' ) {
							$old_table_data['col-title'][$x] = str_replace( $title[0], '', $old_table_data['col-title'][$x] );
							$title_content[] = sprintf( 'subtitle%%5Bcontent%%5D=%s', urlencode( strip_tags( $title[0] ) ) );
						}
					}
					
					$title_content[] = sprintf( 'title%%5Bcontent%%5D=%s', urlencode( $old_table_data['col-title'][$x] ) );
				}

				if ( !empty( $title_content ) ) $tables_data[$old_tables_key]['col-data'][$x]['title'] = implode( '&', $title_content );
				
				
				/* Price */	
				$price = array();
				$price_content = array();
							
				if ( isset( $column_style[1] ) && $column_style[1] != '' && isset( $old_table_data['col-price'][$x] ) && $old_table_data['col-price'][$x] != '' ) {
					
					switch( $column_style[1] ) {	
						case 'pricing' :
						case 'pricing2' :
						case 'pricing3' :
						
							$price_content[] = 'type=price-html';
							preg_match( '/<small>.*<\/small>/', $old_table_data['col-price'][$x], $price );
							
							if ( isset( $price[0] ) && $price[0] != '' ) {
								$old_table_data['col-price'][$x] = str_replace( $price[0], '', $old_table_data['col-price'][$x] );
								$price_content[] = sprintf( 'payment%%5Bcontent%%5D=%s', urlencode( strip_tags( $price[0] ) ) );
							}
							$price_content[] = sprintf( 'price-html%%5Bcontent%%5D=%s', urlencode( strip_tags( $old_table_data['col-price'][$x] ) ) );

							break;
						
						case 'product' :
						
							$price_content[] = 'type=price-html';
							preg_match( '/<p>.*<\/p>/', $old_table_data['col-price'][$x], $price );
							
							if ( isset( $price[0] ) && $price[0] != '' ) {
								$old_table_data['col-price'][$x] = str_replace( $price[0], '', $old_table_data['col-price'][$x] );
								$price_content[] = sprintf( 'payment%%5Bcontent%%5D=%s', urlencode( strip_tags( $price[0] ) ) );
							}
							$price_content[] = sprintf( 'price-html%%5Bcontent%%5D=%s', urlencode( strip_tags( $old_table_data['col-price'][$x] ) ) );
							break;
												
					}
					
				}
				
				if ( !empty( $price_content ) ) $tables_data[$old_tables_key]['col-data'][$x]['price'] = implode( '&', $price_content );
				
				/* Header General */
				$header_general = array();
				
				if ( !empty( $old_table_data['col-replace'][$x] ) ) $header_general[] = 'replace=1';
				if ( isset( $old_table_data['col-html'][$x] ) ) {
		
					$header_general[] = sprintf( 'html=%s', urlencode( $old_table_data['col-html'][$x] ) );					
		
				}

				if ( isset( $old_table_data['col-css'][$x] ) ) $header_general[] = sprintf( 'css=%s', urlencode( $old_table_data['col-css'][$x] ) );
				
				if ( isset( $old_table_data['col-pricing-img'][$x] ) ) {

					$header_general[] = 'custom%5Bimg%5D%5Bresponsive%5D=1';
					$header_general[] = sprintf( 'custom%%5Bimg%%5D%%5Bdata%%5D=%s', urlencode( $old_table_data['col-pricing-img'][$x] ) );
				}
				if ( isset( $old_table_data['col-pricing-html'][$x] ) ) { 
					
					$header_general[] = sprintf( 'custom%%5Bhtml%%5D=%s', urlencode( $old_table_data['col-pricing-html'][$x] ) );

				}

				if ( isset( $old_table_data['col-pricing-css'][$x] ) ) $header_general[] = sprintf( 'custom%%5Bcss%%5D=%s', urlencode( $old_table_data['col-pricing-css'][$x] ) );					
				
				if ( !empty( $header_general ) ) $tables_data[$old_tables_key]['col-data'][$x]['header']['general'] = implode( '&', $header_general );
											
				
				/* Body */
				$body = array();
				
				for ($y = $x * $row_count; $y < $x * $row_count+$row_count; $y++) {
					if ( isset( $old_table_data['col-detail'][$y] ) ) {
						$body[] = 'type=html';
						$body[] = sprintf( 'html%%5Bcontent%%5D=%s', urlencode( $old_table_data['col-detail'][$y] ) );
					}
	
					if ( isset( $old_table_data['col-detail-tip'][$y] ) ) $body[] = sprintf( 'html%%5Btooltip%%5D%%5Bcontent%%5D=%s', urlencode( $old_table_data['col-detail-tip'][$y] ) );
					if ( isset( $old_table_data['col-align'][$y] ) ) $body[] = sprintf( 'html%%5Btext-align%%5D=%s', urlencode( $old_table_data['col-align'][$y] ) );
					if ( !empty( $body ) ) $tables_data[$old_tables_key]['col-data'][$x]['body-row'][$y-$x*$row_count] = implode( '&', $body );
				}
				
				
				/* Footer */
				$footer = array();
				
				if ( isset( $old_table_data['col-button-type'][$x] ) ) {
					$footer[] = 'type=button';
					$footer[] = sprintf( 'button%%5Btype%%5D=%s', urlencode( $old_table_data['col-button-type'][$x] ) );
				}
				
				if ( isset( $old_table_data['col-button-size'][$x] ) ) $footer[] = sprintf( 'button%%5Bsize%%5D=%s', urlencode( $old_table_data['col-button-size'][$x] ) );
				if ( isset( $old_table_data['col-button-text'][$x] ) ) $footer[] = sprintf( 'button%%5Bcontent%%5D=%s', urlencode( $old_table_data['col-button-text'][$x] ) );
				if ( isset( $old_table_data['col-button-link'][$x] ) ) $footer[] = sprintf( 'button%%5Bcode%%5D=%s', urlencode( $old_table_data['col-button-link'][$x] ) );
				if ( !empty( $old_table_data['col-button-target'][$x] ) ) $footer[] = 'button%5Btarget%5D=1';
				if ( !empty( $old_table_data['col-button-nofollow'][$x] ) ) $footer[] = 'button%5Bnofollow%5D=1';
				
				if ( !empty( $footer ) ) $tables_data[$old_tables_key]['col-data'][$x]['footer-row'][0] = implode( '&', $footer );				
				
			}
			
		}
				
		if ( !empty( $tables_data ) ) {
			$tables_data = base64_encode( serialize( $tables_data ) ); 		
			$tables_count = self::import( $tables_data );
		}		
		
		if ( $tables_count === false )  return false;

		return $tables_count;
				
	}
	
}
 
?>