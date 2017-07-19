<?php
/**
 * Shortcode class
 * 
 * @package   	Go Pricing
 * @author    	Granth
 * @author URI: http://granthweb.com
 * @copyright 	2015 Granth
 */


/* Prevent direct call */
if ( ! defined( 'WPINC' ) ) { die; }

class GW_GoPricing_Shortcodes {
	
	private static $instance = null;
	
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;
	
	
	/**
	 * Initialize the class
	 */
	
	private function __construct( $globals ) {
		
		self::$plugin_version = $globals['plugin_version'];
		self::$db_version = $globals['db_version'];		
		self::$plugin_prefix = $globals['plugin_prefix'];
		self::$plugin_slug = $globals['plugin_slug'];
		$this->plugin_file = $globals['plugin_file'];		
		$this->plugin_base = $globals['plugin_base'];
		$this->plugin_dir = $globals['plugin_dir'];
		$this->plugin_path = $globals['plugin_path'];
		$this->plugin_url =	$globals['plugin_url'];
		$this->globals = $globals;
				
		/* Main shortcode */				
		add_shortcode( 'go_pricing', array( $this, 'pricing_table_sc' ) );
		
		/* Video shortcodes */
		add_shortcode( 'go_pricing_html5_video', array( $this, 'video_sc' ) );
		add_shortcode( 'go_pricing_youtube', array( $this, 'youtube_sc' ) );
		add_shortcode( 'go_pricing_vimeo', array( $this, 'vimeo_sc' ) );
		add_shortcode( 'go_pricing_screenr', array( $this, 'screenr_sc' ) );
		add_shortcode( 'go_pricing_dailymotion', array( $this, 'dailymotion_sc' ) );
		add_shortcode( 'go_pricing_metacafe', array( $this, 'metacafe_sc' ) );		

		/* Audio shortcodes */
		add_shortcode( 'go_pricing_audio', array( $this, 'audio_sc' ) );
		add_shortcode( 'go_pricing_soundcloud', array( $this, 'soundcloud_sc' ) );
		add_shortcode( 'go_pricing_mixcloud', array( $this, 'mixcloud_sc' ) );
		add_shortcode( 'go_pricing_beatport', array( $this, 'beatport_sc' ) );
		
		/* Mixed */
		add_shortcode( 'go_pricing_map', array( $this, 'goole_map_sc' ) );
		add_shortcode( 'go_pricing_iframe', array( $this, 'iframe_sc' ) );
		
	}

	
	/**
	 * Return an instance of this class
	 *
	 * @return object
	 */
	 
	public static function instance( $globals ) {
		
		if ( self::$instance == null ) {
			self::$instance = new self( $globals );
		}
		
		return self::$instance;
		
	}	


	/**
	 * Pricing table shortcode [go_pricing]
	 *
	 * @return string Returns HTML code.
	 */		
		
	public function pricing_table_sc( $atts, $content = null ) {
		
		extract( shortcode_atts( array( 
			'id' 	=> null,
			'postid' => null,
			'margin_bottom' => '20px',
			'preview' => false
		), $atts ) );
		
		global $go_pricing;

		$id_table = true;
		
		if ( empty( $id ) && empty( $postid ) ) return '<p>' . __( 'You must set a Table ID or Post ID.', 'go_pricing_textdomain' ) . '</p>';

		
		if ( !empty( $postid ) ) {
			
			$id_table = false;
			
			$postid = (int)$postid;
			$pricing_table = GW_GoPricing_Data::get_table( $postid );

		} else {
			
			$id = sanitize_key( $id );
			
			$pricing_table = GW_GoPricing_Data::get_table( $id, true, 'id' );
					
			$postid = isset( $pricing_table['postid'] ) ? $pricing_table['postid'] : 0;
			
		}
		
		if ( empty( $pricing_table ) ) return '<p>' . sprintf( __( 'Pricing table with an %1$s of "%2$s" is not defined.', 'go_pricing_textdomain' ), ($id_table) ? 'Table ID' :'Post ID', !empty( $id ) ? $id : $postid ) . '</p>';
		
		if ( empty( $pricing_table['col-data'] ) && $preview  == 'true' ) return '<div id="go-pricing-forbidden"><i class="icon-exclamation-triangle"></i>'. __( 'There is nothing to see here, yet. Please, first create columns!', 'go_pricing_textdomain' ) . '</div>';

		// Enqueue plugin main javascript
		wp_enqueue_script( self::$plugin_slug . '-scripts' );
		
		$colnum = !empty( $pricing_table['col-data'] ) && is_array( $pricing_table['col-data'] ) ? count( $pricing_table['col-data'] ) : 0;
		$body_rownum = !empty( $pricing_table['col-data'][0]['body-row'] ) && is_array( $pricing_table['col-data'][0]['body-row'] ) ? count( $pricing_table['col-data'][0]['body-row'] ) : 0;		
		$footer_rownum = !empty( $pricing_table['col-data'][0]['footer-row'] ) && is_array( $pricing_table['col-data'][0]['footer-row'] ) ? count( $pricing_table['col-data'][0]['footer-row'] ) : 0;
		

		/**
		 * Build main classes & styles
		 */
		
		// Reset		
		$google_fonts = array();
		$custom_inline_styles = array();		
		$default_font = isset( $pricing_table['default-font'] ) ? $pricing_table['default-font'] : '';
		
		$google_font = '';

		if ( isset( $default_font ) && $default_font != '' ) {
			foreach( (array)$go_pricing['fonts'] as $fonts ) {
				
				if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
					foreach( (array)$fonts['group_data'] as $font ) {
						if ( !empty( $font['value'] ) && $font['value'] == $default_font ) {
							if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
							
								$font_url_params = array();

								/* Google Font */
								if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
									$font_url_params[] = '400';
									$font['url'] .= ':400,b,i';
								}
							}
							
							if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
								$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
								if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
							}

							if ( !empty( $font['value'] ) ) $custom_inline_styles[] = '.gw-go { ' . sprintf( 'font-family:%s !important' , $font['value'] ) . ' }'; 
						}

					}
				}
				
			}
		}		
		

		$main_classes = array();
		$main_styles = array();
		$main_head_html = '';
		
		// Build classes & styles
		$main_classes[] = 'gw-go';
		$main_classes[] = 'gw-go-clearfix';
		if ( !empty( $pricing_table['enlarge-current'] ) ) $main_classes[] = 'gw-go-enlarge-current';
		if ( !empty( $pricing_table['hide-footer'] ) ) $main_classes[] = 'gw-go-no-footer';
		if ( empty( $pricing_table['col-box-shadow'] ) ) $main_classes[] = 'gw-go-disable-box-shadow';		
		if ( !empty( $margin_bottom ) ) $main_styles[] = sprintf( 'margin-bottom:%spx', (int)$margin_bottom );

		switch ( $colnum ) {
			case 1: 
				$main_classes[] = 'gw-go-1col';
				break;
			case 2: 
				$main_classes[] = 'gw-go-2cols'; 
				break;
			case 3: 
				$main_classes[] = 'gw-go-3cols';
				break;
			case 4: 
				$main_classes[] = 'gw-go-4cols';
				break;
			case 5: 
				$main_classes[] = 'gw-go-5cols';
				break;
			case 6: 
				$main_classes[] = 'gw-go-6cols';
				break;
			case 7: 
				$main_classes[] = 'gw-go-7cols';
				break;
			case 8: 
				$main_classes[] = 'gw-go-8cols';
				break;
			case 9: 
				$main_classes[] = 'gw-go-9cols';
				break;	
			case 10: 
				$main_classes[] = 'gw-go-10cols';
				break;																				
		}
		
		// Filter classes & styles
		$main_classes = apply_filters( 'go_pricing_front_main_classes', $main_classes, $pricing_table );
		$main_styles = apply_filters( 'go_pricing_front_man_styles', $main_styles, $pricing_table );				
		
		// Build html
		$main_head_html = sprintf( 
			'<div id="go-pricing-table-%1$d"%2$s>', 
			$postid, 
			!empty( $main_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$main_styles )  ) .  ';"' : ''
		);
		
		$main_head_html .= sprintf( 
			'<div%1$s data-id="%2$d" data-colnum="%3$d" data-equalize="%4$s"%5$s%6$s%7$s>', 
			!empty( $main_classes) ? ' class="' . esc_attr( implode( ' ', (array)$main_classes )  ) .  '"' : '', 
			!empty( $pricing_table['postid'] ) ? (int)$pricing_table['postid'] : '',
			$colnum,
			!empty( $pricing_table['equalize'] ) ? esc_attr( json_encode( $pricing_table['equalize'] ) ) : '',
			!empty( $pricing_table['responsivity']['enabled'] ) && !empty( $pricing_table['responsivity']['views'] ) ? ' data-views="' . esc_attr( json_encode( $pricing_table['responsivity']['views'] ) ) . '"' : '',
			!empty( $pricing_table['col-animation'] ) && isset( $pricing_table['col-anim-offset'] ) ? ' data-scroll-offset="' . esc_attr( (int)$pricing_table['col-anim-offset'] ) . '"' : '',
			!empty( $pricing_table['col-animation'] ) && !empty( $pricing_table['col-anim-once'] ) ? ' data-anim-repeat="1"' : ''
		);
		
		// Filter html
		$main_head_html = apply_filters( 'go_pricing_front_main_head_html', 
			$main_head_html, 
			array(
				'pricing_table' => $pricing_table,
				'main_classes' => $main_classes,
				'main_styles' => $main_styles,
				'margin_bottom' => $margin_bottom
			)
		);
		
		$html = $main_head_html;

		
		/**
		 * Build columns
		 */
			
		/* Global table styles */
		
		if ( !empty( $pricing_table['col-space'] ) ) {
			$custom_inline_styles[] = '.gw-go { ' . sprintf( 'margin-left:-%spx;', (int)$pricing_table['col-space'] ) . ' }';
			$custom_inline_styles[] = '.gw-go-col { ' . sprintf( 'margin-left:%spx;', (int)$pricing_table['col-space'] ) . ' }';
		}
		
		if ( !empty( $pricing_table['col-width']['min'] ) && (int)$pricing_table['col-width']['min'] > 0 ) {
			$custom_inline_styles[] = '.gw-go-col-wrap { ' . sprintf( 'min-width:%spx;', (int)$pricing_table['col-width']['min'] ) . ' }';
		}
		
		if ( !empty( $pricing_table['col-width']['max'] ) && (int)$pricing_table['col-width']['max'] > 0 ) {
			$custom_inline_styles[] = '.gw-go-col-wrap { ' . sprintf( 'max-width:%spx;', (int)$pricing_table['col-width']['max'] ) . ' }';
		}		

		if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' ) {
		
			if ( !empty( $pricing_table['col-border-radius'] ) ) {
				foreach ( $pricing_table['col-border-radius'] as $key => $radius ) {
					if ( (int)$radius != 0 ) { $pricing_table['col-border-radius'][$key] = $pricing_table['col-border-radius'][$key].'px'; }
				}
				
				$custom_inline_styles[] = '.gw-go-col-inner { ' . sprintf( 'border-radius:%s;', implode( ' ', $pricing_table['col-border-radius'] ) ) . ' }';	
			}
			
			if ( empty( $pricing_table['col-border'] ) ) {
				$custom_inline_styles[] = '.gw-go-col-inner { border:none; }';
				$custom_inline_styles[] = '.gw-go-col-wrap { margin-left:0; }';	

			}
			
			if ( empty( $pricing_table['col-row-border'] ) ) {
				$custom_inline_styles[] = 'ul.gw-go-body, ul.gw-go-body li { border:none !important; padding-top:1px; }';
				$custom_inline_styles[] = 'ul.gw-go-body li .gw-go-body-cell { padding-top:1px; }';
				$custom_inline_styles[] = 'ul.gw-go-body { padding-bottom:1px; }';
			}
			
			$tooltip_style = sprintf( '%1$s%2$s%3$s',
				isset( $pricing_table['tooltip']['bg-color'] ) ? sprintf( 'background-color:%s;', $pricing_table['tooltip']['bg-color'] ) : '',
				isset( $pricing_table['tooltip']['text-color'] ) ? sprintf( 'color:%s;', $pricing_table['tooltip']['text-color'] ) : '', 
				isset( $pricing_table['tooltip']['width'] ) ? sprintf( 'max-width:%spx;', $pricing_table['tooltip']['width'] ) : ''
			);
			
			if ( !empty( $tooltip_style ) ) $custom_inline_styles[] = sprintf( '.gw-go-tooltip-content { %s }' ,$tooltip_style );
			
			if ( isset( $pricing_table['tooltip']['bg-color'] ) ) $custom_inline_styles[] = '.gw-go-tooltip:before { ' . sprintf( 'border-top-color:%s;', $pricing_table['tooltip']['bg-color'] ) . ' }';
		
		}
		
		if ( !isset( $pricing_table['col-data'] ) ) return;
		
		foreach ( (array)$pricing_table['col-data'] as $col_index => $col_data ) {
			
			/**
			 * Parse data
			 */
			 
			/* Layout & Style */
			if ( isset( $col_data['layout-style'] ) && is_string( $col_data['layout-style'] ) ) $col_data['layout-style'] = GW_GoPricing_Helper::parse_data( $col_data['layout-style'] );				 
			
			/* Backward compatibility */
			if ( !empty( $col_data['col-highlight'] ) ) $col_data['layout-style']['highlight'] = $col_data['col-highlight'];
			if ( !empty( $col_data['col-disable-hover'] ) ) $col_data['layout-style']['disable-hover'] = $col_data['col-disable-hover'];
			if ( !empty( $col_data['col-disable-enlarge'] ) ) $col_data['layout-style']['disable-enlarge'] = $col_data['col-disable-enlarge'];
			if ( !empty( $col_data['main-color'] ) ) $col_data['layout-style']['main-color'] = $col_data['main-color'];			
			 
			/* Decoration */
			if ( isset( $col_data['decoration'] ) && is_string( $col_data['decoration'] ) ) $col_data['decoration'] = GW_GoPricing_Helper::parse_data( $col_data['decoration'] );			

			/* Header Style */
			if ( isset( $col_data['header']['style'] ) && is_string( $col_data['header']['style'] ) ) $col_data['header']['style'] = GW_GoPricing_Helper::parse_data( $col_data['header']['style'] );
			
			/* Header General */
			if ( isset( $col_data['header']['general'] ) && is_string( $col_data['header']['general'] ) ) $col_data['header']['general'] = GW_GoPricing_Helper::parse_data( $col_data['header']['general'] );

			/* Title */
			if ( isset( $col_data['title'] ) && is_string( $col_data['title'] ) ) $col_data['title'] = GW_GoPricing_Helper::parse_data( $col_data['title'] );

			/* Body row */
			if ( isset( $col_data['body-row'] ) && is_string( $col_data['body-row'] ) ) $col_data['body-row'] = GW_GoPricing_Helper::parse_data( $col_data['body-row'] );
		
				
			/**
			 * Load css skin files for old classic skins
			 * and custom styles with static css files
			 */				

			$column_style = null;
			$column_style_data = null;

			if ( !empty( $pricing_table['style'] ) && !empty( $col_data['col-style-type'] ) ) {

				$column_style = $col_data['col-style-type'];
				
				/* Get registered styles */
				$registered_styles = $go_pricing['style_types'][$pricing_table['style']];

				foreach ( (array)$registered_styles as $registered_style ) {
					if ( !empty( $registered_style['group_name'] ) && !empty( $registered_style['group_data'] ) ) {
						foreach ( $registered_style as $key => $value) {
							if ($key == 'group_data') {
								foreach ( (array)$value as $style_data ) {
									if ( !empty( $style_data['value'] ) && !empty( $style_data['data'] ) && $style_data['value'] == $column_style ) $column_style_data = $style_data;
								}
							}
						
						}
					} else {
						foreach ( (array)$registered_styles as $style_data ) {	
							if ( !empty( $style_data['value'] ) && !empty( $style_data['data'] ) && $style_data['value'] == $column_style ) $column_style_data = $style_data;
						}
					}
					
				}
			}


			if ( !empty( $column_style_data['css']['handle'] ) && !empty( $column_style_data['css']['url'] ) ) {

				wp_enqueue_style( sprintf( '%1$s-%2$s', self::$plugin_slug, $column_style_data['css']['handle'] ), $column_style_data['css']['url'], array(), self::$plugin_version );

			}

			/**
			 * Generate inline styles for clean styles
			 */				
			
			if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' && !empty( $col_data['layout-style']['main-color'] ) ) {
				
				switch( $column_style ) {
					
					case 'clean-style1' : 
						ob_start();
						?>
						<style>

						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-header-top { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-price-wrap span,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }						
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style2' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-footer-row .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }											
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style3' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style4' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li .gw-go-body-cell:before,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }							
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style5' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header,
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-header-bottom,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li .gw-go-body-cell:before,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-price-wrap span,	
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }	
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style6' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-col-inner,										
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn {  <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }						
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header h3,	
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-price-wrap,
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-coinf div,	
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-coinb div  { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-btn { <?php printf( 'color:%s !important;', $col_data['layout-style']['main-color'] ); ?> }								
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb	{ <?php printf( 'border:solid 2px %s !important;', $col_data['layout-style']['main-color'] ); ?> }
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style7' : 
						ob_start();
						?>
						<style>		
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li.gw-go-even .gw-go-body-cell:before, 
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li .gw-go-body-cell:before,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }			
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style8' : 
						ob_start();
						?>
						<style>		
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-col-inner,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn {  <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }		
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-coinf div,
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-btn { <?php printf( 'color:%s !important;', $col_data['layout-style']['main-color'] ); ?> }						
						</style>						
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style9' : 
						ob_start();
						?>
						<style>	
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-col-inner,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-body li.gw-go-even .gw-go-body-cell:before, 
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-body li .gw-go-body-cell:before {  <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-coinf, 
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-coinb,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-body li { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style9 .gw-go-btn {  <?php printf( 'color:%s !important;', $col_data['layout-style']['main-color'] ); ?> }
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style10' : 
						ob_start();
						?>
						<style>	
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style10 .gw-go-coinf, 
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style10 .gw-go-coinb { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style10 .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }	
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style12' :				 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style12 .gw-go-header h3 { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }			
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-col.gw-go-clean-style12 .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style13' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-col-inner,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn {  <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-header h1 { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-btn { <?php printf( 'color:%s !important;', $col_data['layout-style']['main-color'] ); ?> }			
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style14' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-header h3,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-price-wrap span,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinf div, 
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-coinb div { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?>.gw-go-hover .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }		
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;
						
					case 'clean-style15' : 
						ob_start();
						?>
						<style>
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li { <?php printf( 'color:%s;', $col_data['layout-style']['main-color'] ); ?> }
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-body li.gw-go-even .gw-go-body-cell:before,
						.gw-go-col-wrap-<?php echo $col_index; ?> .gw-go-btn { <?php printf( 'background-color:%s;', $col_data['layout-style']['main-color'] ); ?> }		
						</style>
						<?php
						$custom_inline_styles[] = ob_get_clean();
						break;																																																																														
						
				}

			}
			
			// More custom inline styles	
			$title_styles = array();
			$price_styles = array();
			$payment_styles = array();
			
			if ( !empty( $column_style_data['type'] ) ) {
			
				if ( $column_style_data['type'] != 'html' && $column_style_data['type'] != 'chtml' ) {
				
					// Title 
					if ( !empty( $col_data['title']['title']['font-size'] ) && (int)$col_data['title']['title']['font-size'] != 18 ) $title_styles[] = sprintf( 'font-size:%spx !important' , (int)$col_data['title']['title']['font-size'] );
					if ( !empty( $col_data['title']['title']['line-height'] ) && (int)$col_data['title']['title']['line-height'] != 16 ) $title_styles[] = sprintf( 'line-height:%spx !important' , (int)$col_data['title']['title']['line-height'] );
					
					if ( !empty( $col_data['title']['title']['font-style']['bold'] ) ) $title_styles[] = 'font-weight:bold !important';
					if ( !empty( $col_data['title']['title']['font-style']['italic'] ) ) $title_styles[] = 'font-style:italic !important';
					if ( !empty( $col_data['title']['title']['font-style']['strikethrough'] ) ) $title_styles[] = 'text-decoration:line-through !important';
					
					$google_font = '';

					if ( !empty( $col_data['title']['title']['font-family'] ) && $col_data['title']['title']['font-family'] != $default_font ) {
						foreach( (array)$go_pricing['fonts'] as $fonts ) {
							
							if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
								foreach( (array)$fonts['group_data'] as $font ) {
									if ( !empty( $font['value'] ) && $font['value'] == $col_data['title']['title']['font-family'] ) {
										if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
										
											$font_url_params = array();
	
											/* Google Font */
											if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
												$font_url_params[] = '400';
												if ( !empty( $col_data['title']['title']['font-style']['bold'] ) ) $font_url_params[] = 'b';
												if ( !empty( $col_data['title']['title']['font-style']['italic'] ) ) $font_url_params[] = 'i';
												$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
											}
										}
										
										if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
											$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
											if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
										}

										if ( !empty( $font['value'] ) ) $title_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
									}

								}
							}
							
						}
					}
					
					if ( !empty( $title_styles ) )  {
						$custom_inline_styles[] = sprintf( 
							'.gw-go-col-wrap-%1$s .gw-go-header h3 { %2$s; }',
							$col_index,
							implode( '; ', (array)$title_styles ) 
						);
					}
					
					$title_styles = array();
					
					// Subtitle 
					if ( !empty( $col_data['title']['subtitle']['font-size'] ) && (int)$col_data['title']['subtitle']['font-size'] != 12 ) $title_styles[] = sprintf( 'font-size:%spx !important' , (int)$col_data['title']['subtitle']['font-size'] );
					if ( !empty( $col_data['title']['subtitle']['line-height'] ) && (int)$col_data['title']['subtitle']['line-height'] != 16 ) $title_styles[] = sprintf( 'line-height:%spx !important' , (int)$col_data['title']['subtitle']['line-height'] );
					
					if ( !empty( $col_data['title']['subtitle']['font-style']['bold'] ) ) $title_styles[] = 'font-weight:bold !important';
					if ( !empty( $col_data['title']['subtitle']['font-style']['italic'] ) ) $title_styles[] = 'font-style:italic !important';
					if ( !empty( $col_data['title']['subtitle']['font-style']['strikethrough'] ) ) $title_styles[] = 'text-decoration:line-through !important';
					
					$google_font = '';

					if ( !empty( $col_data['title']['subtitle']['font-family'] ) && $col_data['title']['subtitle']['font-family'] != $default_font ) {
						foreach( (array)$go_pricing['fonts'] as $fonts ) {
							
							if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
								foreach( (array)$fonts['group_data'] as $font ) {
									if ( !empty( $font['value'] ) && $font['value'] == $col_data['title']['subtitle']['font-family'] ) {
										if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
										
											$font_url_params = array();
	
											/* Google Font */
											if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
												$font_url_params[] = '400';
												if ( !empty( $col_data['title']['subtitle']['font-style']['bold'] ) ) $font_url_params[] = 'b';
												if ( !empty( $col_data['title']['subtitle']['font-style']['italic'] ) ) $font_url_params[] = 'i';
												$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
											}
										}
										
										if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
											$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
											if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
										}

										if ( !empty( $font['value'] ) ) $title_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
									}

								}
							}
							
						}
					}
					
					if ( !empty( $title_styles ) )  {
						$custom_inline_styles[] = sprintf( 
							'.gw-go-col-wrap-%1$s .gw-go-header h3 small { %2$s; }',
							$col_index,
							implode( '; ', (array)$title_styles ) 
						);
					}										
			
					if ( $column_style_data['type'] != 'team' && $column_style_data['type'] != 'cteam' ) {
						
						if ( isset( $col_data['price'] ) && is_string( $col_data['price'] ) ) $col_data['price'] = GW_GoPricing_Helper::parse_data( $col_data['price'] );
						
						// Price 
						if ( !empty( $col_data['price']['price-style']['font-size'] ) && (int)$col_data['price']['price-style']['font-size'] != 32 ) $price_styles[] = sprintf( 'font-size:%spx !important' , (int)$col_data['price']['price-style']['font-size'] );
						if ( !empty( $col_data['price']['price-style']['line-height'] ) && (int)$col_data['price']['price-style']['line-height'] != 16 ) $price_styles[] = sprintf( 'line-height:%spx !important' , (int)$col_data['price']['price-style']['line-height'] );			

						if ( !empty( $col_data['price']['price-style']['font-style']['bold'] ) ) $price_styles[] = 'font-weight:bold !important';
						if ( !empty( $col_data['price']['price-style']['font-style']['italic'] ) ) $price_styles[] = 'font-style:italic !important';
						if ( !empty( $col_data['price']['price-style']['font-style']['strikethrough'] ) ) $price_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $col_data['price']['price-style']['font-family'] ) && $col_data['price']['price-style']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $col_data['price']['price-style']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $col_data['price']['price-style']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $col_data['price']['price-style']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}
										
											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}

											if ( !empty( $font['value'] ) ) $price_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}

						if ( !empty( $price_styles ) )  {

							if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' && !empty( $col_data['header']['style']['type'] ) && $col_data['header']['style']['type'] == 'standard' && ( $column_style_data['type'] = 'cpricing' ) ) {
							
								$custom_inline_styles[] = sprintf( 
									'.gw-go-col-wrap-%1$s .gw-go-price-wrap > span{ %2$s; }',
									$col_index,
									implode( '; ', (array)$price_styles ) 
								);							
																
							} else {

								switch( $column_style_data['type'] ) {
									
									case 'product' :
									case 'cproduct' : 

										$custom_inline_styles[] = sprintf( 
											'.gw-go-col-wrap-%1$s .gw-go-header h1 span { %2$s; }',
											$col_index,
											implode( '; ', (array)$price_styles ) 
										);								
										break;
										
									default : 
										$custom_inline_styles[] = sprintf( 
											'.gw-go-col-wrap-%1$s .gw-go-coinb div > span, .gw-go-col-wrap-%1$s .gw-go-coinf div > span { %2$s; }',
											$col_index,
											implode( '; ', (array)$price_styles ) 
										);																		

								}

							}
							
						}
						
						
						// Payment
						if ( !empty( $col_data['price']['payment']['font-size'] ) && (int)$col_data['price']['payment']['font-size'] != 12 ) $payment_styles[] = sprintf( 'font-size:%spx !important' , (int)$col_data['price']['payment']['font-size'] );
						if ( !empty( $col_data['price']['payment']['line-height'] ) && (int)$col_data['price']['payment']['line-height'] != 16 ) $payment_styles[] = sprintf( 'line-height:%spx !important' , (int)$col_data['price']['payment']['line-height'] );			

						if ( !empty( $col_data['price']['payment']['font-style']['bold'] ) ) $payment_styles[] = 'font-weight:bold !important';
						if ( !empty( $col_data['price']['payment']['font-style']['italic'] ) ) $payment_styles[] = 'font-style:italic !important';
						if ( !empty( $col_data['price']['payment']['font-style']['strikethrough'] ) ) $payment_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $col_data['price']['payment']['font-family'] ) && $col_data['price']['payment']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $col_data['price']['payment']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $col_data['price']['payment']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $col_data['price']['payment']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}

											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}

											if ( !empty( $font['value'] ) ) $payment_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}
												
						if ( !empty( $payment_styles ) )  {

							if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' && !empty( $col_data['header']['style']['type'] ) && $col_data['header']['style']['type'] == 'standard' ) {

								$custom_inline_styles[] = sprintf( 
									'.gw-go-col-wrap-%1$s .gw-go-price-wrap small { %2$s; }',
									$col_index,
									implode( '; ', (array)$payment_styles ) 
								);															
							
							
							} else {

								switch( $column_style_data['type'] ) {
									
									case 'product' :
									case 'cproduct' : 

										$custom_inline_styles[] = sprintf( 
											'.gw-go-col-wrap-%1$s .gw-go-header > small { %2$s; }',
											$col_index,
											implode( '; ', (array)$payment_styles ) 
										);								
										break;
										
									default : 
										$custom_inline_styles[] = sprintf( 
											'.gw-go-col-wrap-%1$s .gw-go-coinb div small, .gw-go-col-wrap-%1$s .gw-go-coinf div small { %2$s; }',
											$col_index,
											implode( '; ', (array)$payment_styles ) 
										);																		

								}


							}
							
						}						
						
						
					}				
			
				}
			
			}
																												
				
			/**
			 * Column wrappers
			 */
			
			// Column wrap - Reset
			$col_wrap_classes = array();
			$col_wrap_atts = array();
			$col_wrap_attributes = array();
			$col_wrap_header_html = '';
			
			// Column wrap - Build classes & atts
			$col_wrap_classes[] = 'gw-go-col-wrap';
			$col_wrap_classes[] = 'gw-go-col-wrap-' . $col_index;
			if ( !empty( $col_data['layout-style']['highlight'] ) ) $col_wrap_classes[] = 'gw-go-hover';
			if ( !empty( $col_data['layout-style']['highlight'] ) ) $col_wrap_atts[] = array( 'data-current', true );	
			if ( !empty( $col_data['layout-style']['disable-enlarge'] ) ) $col_wrap_classes[] = 'gw-go-disable-enlarge';
			if ( !empty( $col_data['layout-style']['disable-hover'] ) ) $col_wrap_classes[] = 'gw-go-disable-hover';
			$col_wrap_atts[] = array( 'data-col-index', $col_index );
			
			// Column wrap - Filter classes & atts
			$col_wrap_classes = apply_filters( 'go_pricing_front_colwrap_classes', 
				$col_wrap_classes, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,					
					'col_wrap_classes' => $col_wrap_classes
				)
			);
			
			$col_wrap_atts = apply_filters( 'go_pricing_front_colwrap_atts', 
				$col_wrap_atts, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,					
					'col_wrap_atts' => $col_wrap_atts
				)
			);						
				
			foreach ( (array)$col_wrap_atts as $col_wrap_att ) {
				if ( count( (array)$col_wrap_att ) == 2 ) $col_wrap_attributes[] = sprintf( '%1$s="%2$s"', $col_wrap_att[0], esc_attr( $col_wrap_att[1] ) );
			}	
			
			// Column wrap - Build html
			
			// Animation
			$col_anim = array();
			$col_anim_data = array();
			$col_anim_data_json = '';
			
			if ( isset( $go_pricing['column-transition'] ) && !empty( $pricing_table['col-animation'] ) ) {
					
				if ( !empty( $col_data['animation'] ) && is_string( $col_data['animation'] ) ) $col_anim = GW_GoPricing_Helper::parse_data( $col_data['animation'] );
			
				// Transition
				if ( isset( $col_anim['transition'] ) && $col_anim['transition'] != '' && !empty( $col_anim['trans']['duration'] ) && isset( $col_anim['trans']['delay'] ) && isset( $col_anim['trans']['ease'] ) ) {
					$col_anim['trans']['duration'] = (int)$col_anim['trans']['duration'];
					$col_anim['trans']['delay'] = (int)$col_anim['trans']['delay'];
					
					$col_anim_data['trans'] = $col_anim['trans'];
					
					foreach ( $go_pricing['column-transition'] as $trans ) {
						
						if ( !empty( $trans['group_name'] )  && !empty( $trans['group_data'] ) ) {

							foreach ( $trans['group_data'] as $trans_child ) {
								if ( isset( $trans_child['value'] ) && $trans_child['value'] == $col_anim['transition'] ) {
									if ( isset( $trans_child['data'] ) ) $col_anim_data['css'] = json_decode( $trans_child['data'], true );
								}
							}

						} else {
							if ( isset( $trans['value'] ) && $trans['value'] == $col_anim['transition'] ) {
								if ( isset( $trans['data'] ) ) $col_anim_data['css'] = json_decode( $trans['data'], true );
							}
						}
					}					
				}
				// Counter Animation
				if ( !empty( $col_anim['counter'] ) && !empty( $col_anim['count']['duration'] ) && isset( $col_anim['count']['delay'] ) && isset( $col_anim['count']['from'] ) && isset( $col_anim['count']['ease'] ) ) {
					$col_anim['count']['duration'] = (int)$col_anim['count']['duration'];
					$col_anim['count']['delay'] = (int)$col_anim['count']['delay'];
					$col_anim_data['count'] = $col_anim['count'];
				}				
			}
			
			$col_wrap_header_html = sprintf( '<div%1$s%2$s%3$s>', 
				!empty( $col_wrap_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$col_wrap_classes )  ) .  '"' : '',
				!empty( $col_wrap_attributes ) ? ' ' . implode( ' ', (array)$col_wrap_attributes ) : '',
				!empty( $col_anim_data ) ? sprintf( ' data-col-anim="%s"', esc_attr( json_encode( $col_anim_data ) ) ) : ''
			);
			
			// Column wrap - Filter html
			$col_wrap_header_html = apply_filters( 'go_pricing_front_colwrap_head_html', 
				$col_wrap_header_html,
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,					
					'col_wrap_classes' => $col_wrap_classes,
					'col_wrap_atts' => $col_wrap_atts,
					'col_wrap_attributes' => $col_wrap_attributes
				)
			);
			
			$html .= $col_wrap_header_html;
	
	
			// Column - Reset
			$col_classes = array();
			$col_styles = array();
			$col_header_html = '';
			
			
			// Column - Build classes & styles
			$col_classes[] = 'gw-go-col';
			if ( !empty( $column_style ) ) {
				$col_classes[] = 'gw-go-' . $column_style;
			}
			
			if ( !empty( $col_data['decoration']['col-shadow'] ) ) $col_classes[] = 'gw-go-' . $col_data['decoration']['col-shadow'];
		
			
			// Column - Filter classes
			$col_classes = apply_filters( 'go_pricing_front_col_classes', 
				$col_classes, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,					
					'col_classes' => $col_classes
				)
			);	
			
			$col_styles = apply_filters( 'go_pricing_front_col_styles', 
				$col_styles, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_styles' => $col_styles
				)
			);						
			
			// Column - Build html
			$col_header_html = sprintf( 
				'<div%s><div class="gw-go-col-inner"><div class="gw-go-col-inner-layer"></div><div class="gw-go-col-inner-layer-over"></div>', 
				!empty( $col_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$col_classes )  ) .  '"' : '',
				!empty( $col_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$col_styles )  ) .  ';"' : ''
			);
								
			// Column wrap - Filter html
			$col_header_html = apply_filters( 'go_pricing_front_col_head_html', 
				$col_header_html,
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,					
					'col_classes' => $col_classes,
					'col_styles' => $col_styles
				)
			);
			
			$html .= $col_header_html;
			
			
			/**
			 * Signs
			 */
	
			// Reset
			$sign_classes = array();
			$sign_styles = array();
			$sign_link_atts = array();
			$sign_link_attributes = array();
			$sign_span_styles = array();
			$sign_html = '';
			$sign_inner_html = '';

			if ( !empty( $col_data['decoration']['col-sign'] ) && !empty( $col_data['decoration']['col-sign-type'] ) ) {			
				
				// Build classes & styles
				if ( $col_data['decoration']['col-sign-type'] == 'text' ) {
					
					$ribbon_data = $col_data['decoration']['col-sign']['text'];
					
					$sign_classes[] = 'gw-go-ribbon-text';
					if ( !empty( $ribbon_data['shadow'] ) ) $sign_classes[] = 'gw-go-ribbon-shadow';
					$sign_span_styles[] =  !empty( $ribbon_data['color'] ) ? sprintf( 'color:%s', $ribbon_data['color'] ) : '';

					if ( !empty( $ribbon_data['bg-grad'] ) ) {
						$sign_span_styles[] =  !empty( $ribbon_data['bg-color'] ) || !empty( $ribbon_data['bg-color2'] ) ? sprintf( 'background-image:linear-gradient(%1$s, %2$s, %3$s)', 
							!empty( $ribbon_data['bg-grad-angle'] ) ? sprintf( '%ddeg', (int)$ribbon_data['bg-grad-angle'] ) : '0deg',						
							!empty( $ribbon_data['bg-color'] ) ? $ribbon_data['bg-color']  : 'transparent',
							!empty( $ribbon_data['bg-color2'] ) ? $ribbon_data['bg-color2']  : 'transparent'
						) : '';
					}
					
					$sign_span_styles[] =  !empty( $ribbon_data['bg-color'] ) ? sprintf( 'background-color:%s', $ribbon_data['bg-color'] ) : '';
					
					if ( !empty( $ribbon_data['font-size'] ) && (int)$ribbon_data['font-size'] != 12 ) $sign_span_styles[] = sprintf( 'font-size:%spx !important' , (int)$ribbon_data['font-size'] );

					if ( !empty( $ribbon_data['font-style']['bold'] ) ) $sign_span_styles[] = 'font-weight:bold !important';
					if ( !empty( $ribbon_data['font-style']['italic'] ) ) $sign_span_styles[] = 'font-style:italic !important';
					if ( !empty( $ribbon_data['font-style']['strikethrough'] ) ) $sign_span_styles[] = 'text-decoration:line-through !important';
					
					
					$google_font = '';
	
					if ( !empty( $ribbon_data['font-family'] ) && $ribbon_data['font-family'] != $default_font ) { 
						foreach( (array)$go_pricing['fonts'] as $fonts ) {
							
							if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
								foreach( (array)$fonts['group_data'] as $font ) {
									if ( !empty( $font['value'] ) && $font['value'] == $ribbon_data['font-family'] ) {
										if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
										
											$font_url_params = array();
	
											/* Google Font */
											if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
												$font_url_params[] = '400';
												if ( !empty( $ribbon_data['font-style']['bold'] ) ) $font_url_params[] = 'b';
												if ( !empty( $ribbon_data['font-style']['italic'] ) ) $font_url_params[] = 'i';
												$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
											}
										}
	
										if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
											$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
											if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
										}
	
										if ( !empty( $font['value'] ) ) $sign_span_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
									}
	
								}
							}
							
						}
					}
					
					$sign_inner_html = sprintf(	'<span%1$s>%2$s</span>',
						!empty( $sign_span_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$sign_span_styles )  ) .  ';"' : '',
						GW_GoPricing_Helper::esc_sprint( isset ( $col_data['decoration']['col-sign']['text']['content'] ) ? $col_data['decoration']['col-sign']['text']['content'] : '' )
					 );
					
				} elseif ( $col_data['decoration']['col-sign-type'] == 'custom-img' ) {

					if ( !empty( $col_data['decoration']['col-sign'][$col_data['decoration']['col-sign-type']]['data'] ) ) $sign_inner_html = sprintf( '<img src="%s">', esc_attr( $col_data['decoration']['col-sign'][$col_data['decoration']['col-sign-type']]['data'] ) );

				} else {

					foreach ( (array)$go_pricing['signs'][$col_data['decoration']['col-sign-type']] as $sign ) {					
						if ( !empty( $sign['group_name'] ) && !empty( $sign['group_data'] ) ) {
							foreach ( (array)$sign['group_data'] as $sign_item ) {
								if ( isset( $sign_item['value'] ) && $sign_item['value'] == $col_data['decoration']['col-sign'][$col_data['decoration']['col-sign-type']] ) $sign_inner_html = sprintf( '<img src="%s">', esc_attr( $sign_item['data'] ) );
							}
						} else {
							if ( isset( $sign['value'] ) && $sign['value'] == $col_data['decoration']['col-sign'][$col_data['decoration']['col-sign-type']] ) $sign_inner_html = sprintf( '<img src="%s">', esc_attr( $sign['data'] ) );
						}
					}
				}
				 
				if ( !empty( $col_data['decoration']['col-sign-align'] ) ) $sign_classes[] = $col_data['decoration']['col-sign-align'] == 'left' ? 'gw-go-ribbon-left' : 'gw-go-ribbon-right';
				
				if ( !empty( $sign_inner_html ) && !empty( $col_data['decoration']['col-sign-link']['url'] ) ) {
				
					if ( !empty( $col_data['decoration']['col-sign-link']['target'] ) ) $sign_link_atts[] = array( 'target', '_blank' );
					if ( !empty( $col_data['decoration']['col-sign-link']['nofollow'] ) ) $sign_link_atts[] = array( 'rel', 'nofollow' );
					
					$sign_link_atts = apply_filters( 'go_pricing_ribbion_link_button_atts', 
						$sign_link_atts, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index
						)
					);										
			
					foreach ( (array)$sign_link_atts as $sign_link_att ) {
						if ( count( (array)$sign_link_att ) == 2 ) $sign_link_attributes[] = sprintf( '%1$s="%2$s"', $sign_link_att[0], esc_attr( $sign_link_att[1] ) );
					}					
					
					$sign_inner_html = sprintf(
						'<a href="%1$s"%2$s>%3$s</a>', 
						esc_attr( $col_data['decoration']['col-sign-link']['url'] ),
						!empty( $sign_link_attributes ) ? ' ' . implode( ' ', (array)$sign_link_attributes ) : '',
						$sign_inner_html
					);
					
				}
				
				// Filter classes & styles
				$sign_classes = apply_filters( 'go_pricing_front_sign_classes', 
					$sign_classes, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index
					)
				);
				
				if ( !empty( $col_data['decoration']['col-sign-position']['posx'] ) && !empty( $col_data['decoration']['col-sign-align'] ) ) 
					$sign_styles[] =  $col_data['decoration']['col-sign-align'] == 'left' ? sprintf( 'left:%dpx', (int)$col_data['decoration']['col-sign-position']['posx'] ) : sprintf( 'right:%dpx', (int)$col_data['decoration']['col-sign-position']['posx'] );

				if ( !empty( $col_data['decoration']['col-sign-position']['posy'] ) ) $sign_styles[] = sprintf( 'top:%dpx', (int)$col_data['decoration']['col-sign-position']['posy'] );
				
				$sign_styles = apply_filters( 'go_pricing_front_sign_styles', 
					$sign_styles, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index
					)
				);								
				
				// Build html	
				$sign_html = sprintf( 
					'<div%1$s%2$s>%3$s</div>', 
					!empty( $sign_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$sign_classes  )  ) .  '"' : '',
					!empty( $sign_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$sign_styles )  ) .  ';"' : '',
					!empty( $sign_inner_html ) ? $sign_inner_html : ''					
				);
				
				// Filter html
				$sign_html = apply_filters( 'go_pricing_front_sign_html',
					$sign_html, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'sign_classes' => $sign_classes,
						'sign_styles' => $sign_styles,
						'sign_inner_html' => $sign_inner_html
					)
				);
													
			} 
	
			/**
			 * Header
			 */		 
			 
			 
			// Reset
			$header_classes = array();
			$header_styles = array();
			$header_custom_styles = array();
			$price = '';
			$payment = '';
			$price_format = '';
			$header_html = '';
			$header_custom_html = '';
			$templates = array();
			 
			if ( !empty( $column_style_data['type'] ) ) {

				// Build classes, styles & price format
				$header_classes[] = 'gw-go-header';
				if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' ) {

					if ( !empty( $col_data['header']['style']['type'] ) && $col_data['header']['style']['type'] == 'standard' ) {
										
						$header_classes[] = 'gw-go-header-standard';
					} else {
						$header_styles[] = 'text-shadow:none !important'; 	
					}
					
					if ( !empty( $col_data['header']['style']['bg-img']['data'] ) && !empty( $column_style_data['type'] ) &&  $column_style_data['type'] == 'cpricing' ) {
						$header_classes[] = 'gw-go-header-img';
						$header_styles[] = sprintf( 'background-image:url(%s)', $col_data['header']['style']['bg-img']['data'] );
						
						$header_styles[] = sprintf( 'background-position:%1$s%% %2$s%%', 
							isset( $col_data['header']['style']['bg-img']['posx'] ) ? (int)$col_data['header']['style']['bg-img']['posx'] : 50, 
							isset( $col_data['header']['style']['bg-img']['posy'] ) ? (int)$col_data['header']['style']['bg-img']['posy'] : 50
						);
					}
					
					
					
				}
				
				$general_settings = get_option( self::$plugin_prefix . '_table_settings' ); 
							
				$price_format = !empty( $general_settings['currency'][0]['position'] ) && $general_settings['currency'][0]['position'] == 'left' ? '<span data-id="price" data-currency="%1$s" data-price="%4$s"><span data-id="currency">%2$s</span><span data-id="amount">%3$s</span></span>' : '<span data-id="price" data-currency="%1$s" data-price="%4$s"><span data-id="amount">%3$s</span><span data-id="currency">%2$s</span></span>';
				
				// Filter classes, styles & price format
				$header_classes = apply_filters( 'go_pricing_front_header_classes', 
					$header_classes, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type']
					)
				);
				
				$header_styles = apply_filters( 'go_pricing_front_header_styles', 
					$header_styles, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type']
					)
				);

				$price_format = apply_filters( 'go_pricing_front_price_format', 
					$price_format, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type']
					)
				);								

				// Build html
				if ( !empty( $col_data['header']['general']['replace'] ) ) $column_style_data['type'] = 'html';
	
				switch( $column_style_data['type'] ) {	
					
					case 'pricing' :
					case 'cpricing' :
						
						$price = '';
						$payment = '';
						$price_type = isset( $col_data['price']['type'] ) ? $col_data['price']['type'] : '';
						
						switch( $price_type ) {
							
							case 'price-html' :
								$price = sprintf( '<span>%s</span>', isset( $col_data['price']['price-html']['content'] ) ?  $col_data['price']['price-html']['content'] : ''  );
								$payment = isset( $col_data['price']['payment']['content'] ) ?  $col_data['price']['payment']['content'] : '';
								break;
							
							case 'price' :
								$decimals = isset( $general_settings['currency'][0]['decimal-no'] ) ? (int)$general_settings['currency'][0]['decimal-no'] : 2;
								$currency_symbol = '';
								foreach ( (array)$go_pricing['currency'] as $currency ) {
									if ( !empty( $currency['id'] ) && !empty( $currency['symbol'] ) && !empty( $general_settings['currency'][0]['currency'] ) && $currency['id'] == $general_settings['currency'][0]['currency'] ) $currency_symbol = $currency['symbol'];
								}
								
								if ( isset( $col_data['price']['price'][0]['amount'][0] ) && $col_data['price']['price'][0]['amount'][0] != '' ) {
	
									$dec = explode ( '.', (float)$col_data['price']['price'][0]['amount'][0] );
									if ( !empty( $dec[1] ) ) {
										if ( strlen( $dec[1] ) < $decimals ) $decimals = strlen( $dec[1] );
									} else {
										$decimals = 0;
									}
	
									$price = sprintf( $price_format, 
										isset( $general_settings['currency'][0] ) ? esc_attr( json_encode( $general_settings['currency'][0] ) ) : '',
										$currency_symbol,
										number_format( 
											(float)$col_data['price']['price'][0]['amount'][0], 
											$decimals, 
											isset( $general_settings['currency'][0]['decimal-sep'] ) ? $general_settings['currency'][0]['decimal-sep'] : '.',
											isset( $general_settings['currency'][0]['thousand-sep'] ) ? $general_settings['currency'][0]['thousand-sep'] : ',' 
										),
										isset( $col_data['price']['price'][0]['amount'][0] ) ? number_format( (float)$col_data['price']['price'][0]['amount'][0], $decimals, '.', '' ) : 0
										
									);
								}
								
								$payment = isset( $col_data['price']['price'][0]['name'] ) ?  $col_data['price']['price'][0]['name'] : '';
								break;
						}						

						if ( !empty( $pricing_table['style'] ) && $pricing_table['style'] == 'clean' && !empty( $col_data['header']['style']['type'] ) && $col_data['header']['style']['type'] == 'standard' ) {
							$header_template = '<div class="gw-go-header-top"><h3>%1$s</h3></div><div class="gw-go-header-bottom"><div class="gw-go-price-wrap">%2$s%3$s</div></div>';
						} else {
							$header_template = '<div class="gw-go-header-top"><h3>%1$s</h3><div class="gw-go-coin-wrap"><div class="gw-go-coinf"><div>%2$s%3$s</div></div><div class="gw-go-coinb"><div>%2$s%3$s</div></div></div></div><div class="gw-go-header-bottom"></div>';
						}

						$header_custom_html = sprintf( 
							$header_template, 
							isset( $col_data['title']['title']['content'] ) ? $col_data['title']['title']['content'] : '',
							isset( $price ) ? $price : '',
							isset( $payment ) ? '<small>' . $payment . '</small>' : ''
						);						
						break;
					
					case 'pricing2' :
					case 'cpricing2' :
												
						$price = '';
						$payment = '';
						$price_type = isset( $col_data['price']['type'] ) ? $col_data['price']['type'] : '';
						
						switch( $price_type ) {
							
							case 'price-html' :
								$price = sprintf( '<span>%s</span>', isset( $col_data['price']['price-html']['content'] ) ?  $col_data['price']['price-html']['content'] : ''  );
								$payment = isset( $col_data['price']['payment']['content'] ) ?  $col_data['price']['payment']['content'] : '';
								break;
							
							case 'price' :
								$decimals = isset( $general_settings['currency'][0]['decimal-no'] ) ? (int)$general_settings['currency'][0]['decimal-no'] : 2;
								$currency_symbol = '';
								foreach ( (array)$go_pricing['currency'] as $currency ) {
									if ( !empty( $currency['id'] ) && !empty( $currency['symbol'] ) && !empty( $general_settings['currency'][0]['currency'] ) && $currency['id'] == $general_settings['currency'][0]['currency'] ) $currency_symbol = $currency['symbol'];
								}
								
								if ( isset( $col_data['price']['price'][0]['amount'][0] ) && $col_data['price']['price'][0]['amount'][0] != '' ) {
	
									$dec = explode ( '.', (float)$col_data['price']['price'][0]['amount'][0] );
									if ( !empty( $dec[1] ) ) {
										if ( strlen( $dec[1] ) < $decimals ) $decimals = strlen( $dec[1] );
									} else {
										$decimals = 0;
									}
	
									$price = sprintf( $price_format, 
										isset( $general_settings['currency'][0] ) ? esc_attr( json_encode( $general_settings['currency'][0] ) ) : '',
										$currency_symbol,
										number_format( 
											(float)$col_data['price']['price'][0]['amount'][0], 
											$decimals, 
											isset( $general_settings['currency'][0]['decimal-sep'] ) ? $general_settings['currency'][0]['decimal-sep'] : '.',
											isset( $general_settings['currency'][0]['thousand-sep'] ) ? $general_settings['currency'][0]['thousand-sep'] : ',' 
										),
										isset( $col_data['price']['price'][0]['amount'][0] ) ? number_format( (float)$col_data['price']['price'][0]['amount'][0], $decimals, '.', '' ) : 0
									);
								}
								
								$payment = isset( $col_data['price']['price'][0]['name'] ) ?  $col_data['price']['price'][0]['name'] : '';
								break;
						}
						
						$header_custom_styles = !empty( $col_data['header']['general']['custom']['css'] ) ? explode( ';', preg_replace("/[\n\r]/","", trim( $col_data['header']['general']['custom']['css'], ' ;' ) ) ) : '';
						
						foreach( (array)$header_custom_styles as $key => $header_custom_style ) {
							if( !empty( $header_custom_styles[$key] ) ) $header_custom_styles[$key] = trim( $header_custom_style );			
						}
											
						$header_custom_html = sprintf( 
							'<div class="gw-go-header-top"><h3>%1$s</h3><div class="gw-go-coin-wrap"><div class="gw-go-coinf"><div>%2$s%3$s</div></div><div class="gw-go-coinb"><div>%2$s%3$s</div></div></div></div><div class="gw-go-header-bottom"%5$s>%4$s</div>', 
							isset( $col_data['title']['title']['content'] ) ? $col_data['title']['title']['content'] : '',
							isset( $price ) ? $price : '',
							isset( $payment ) ? '<small>' . $payment . '</small>' : '',
							isset( $col_data['header']['general']['custom']['html'] ) ? $col_data['header']['general']['custom']['html'] : '',
							!empty( $header_custom_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$header_custom_styles )  ) .  ';"' : ''
						);						
						break;									
					
					case 'pricing3' :
					case 'cpricing3' :

						$price = '';
						$payment = '';
						$price_type = isset( $col_data['price']['type'] ) ? $col_data['price']['type'] : '';
						
						switch( $price_type ) {
							
							case 'price-html' :
								$price = sprintf( '<span>%s</span>', isset( $col_data['price']['price-html']['content'] ) ?  $col_data['price']['price-html']['content'] : ''  );
								$payment = isset( $col_data['price']['payment']['content'] ) ?  $col_data['price']['payment']['content'] : '';
								break;
							
							case 'price' :
								$decimals = isset( $general_settings['currency'][0]['decimal-no'] ) ? (int)$general_settings['currency'][0]['decimal-no'] : 2;
								$currency_symbol = '';
								foreach ( (array)$go_pricing['currency'] as $currency ) {
									if ( !empty( $currency['id'] ) && !empty( $currency['symbol'] ) && !empty( $general_settings['currency'][0]['currency'] ) && $currency['id'] == $general_settings['currency'][0]['currency'] ) $currency_symbol = $currency['symbol'];
								}
								
								if ( isset( $col_data['price']['price'][0]['amount'][0] ) && $col_data['price']['price'][0]['amount'][0] != '' ) {
	
									$dec = explode ( '.', (float)$col_data['price']['price'][0]['amount'][0] );
									if ( !empty( $dec[1] ) ) {
										if ( strlen( $dec[1] ) < $decimals ) $decimals = strlen( $dec[1] );
									} else {
										$decimals = 0;
									}
	
									$price = sprintf( $price_format, 
										isset( $general_settings['currency'][0] ) ? esc_attr( json_encode( $general_settings['currency'][0] ) ) : '',
										$currency_symbol,
										number_format( 
											(float)$col_data['price']['price'][0]['amount'][0], 
											$decimals, 
											isset( $general_settings['currency'][0]['decimal-sep'] ) ? $general_settings['currency'][0]['decimal-sep'] : '.',
											isset( $general_settings['currency'][0]['thousand-sep'] ) ? $general_settings['currency'][0]['thousand-sep'] : ',' 
										),
										isset( $col_data['price']['price'][0]['amount'][0] ) ? number_format( (float)$col_data['price']['price'][0]['amount'][0], $decimals, '.', '' ) : 0
									);
								}
								
								$payment = isset( $col_data['price']['price'][0]['name'] ) ?  $col_data['price']['price'][0]['name'] : '';
								break;
						}	
						
						$header_custom_styles = !empty( $col_data['header']['general']['custom']['css'] ) ? explode( ';', preg_replace("/[\n\r]/","", trim( $col_data['header']['general']['custom']['css'], ' ;' ) ) ) : '';
						
						foreach( (array)$header_custom_styles as $key => $header_custom_style ) {
							if( !empty( $header_custom_styles[$key] ) ) $header_custom_styles[$key] = trim( $header_custom_style );
						}										

						$header_custom_html = sprintf( 
							'<h3>%1$s</h3><div class="gw-go-coin-wrap"><div class="gw-go-coinf"><div>%2$s%3$s</div></div><div class="gw-go-coinb"><div>%2$s%3$s</div></div></div><div class="gw-go-header-bottom"%5$s>%4$s</div>', 
							isset( $col_data['title']['title']['content'] ) ? $col_data['title']['title']['content'] : '',
							isset( $price ) ? $price : '',
							isset( $payment ) ? '<small>' . $payment . '</small>' : '',
							!empty( $col_data['header']['general']['custom']['img']['data'] ) ? 
								sprintf( 
									'<img src="%1$s"%2$s%3$s%4$s%5$s>', 
									$col_data['header']['general']['custom']['img']['data'], 
									isset( $col_data['header']['general']['custom']['img']['responsive'] ) ? ' class="gw-go-responsive-img"' : '',
									isset( $col_data['header']['general']['custom']['img']['alt'] ) ? ' alt="' . esc_attr( $col_data['header']['general']['custom']['img']['alt'] ) . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['width'] ) ? ' width="' . (int)$col_data['header']['general']['custom']['img']['width'] . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['height'] ) ? ' height="' . (int)$col_data['header']['general']['custom']['img']['height'] . '"' : ''
								) 
							: '',
							!empty( $header_custom_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$header_custom_styles )  ) .  ';"' : ''
						);						
						break;
						
					case 'product' :
					case 'cproduct' :
					
						$price = '';
						$payment = '';
						$price_type = isset( $col_data['price']['type'] ) ? $col_data['price']['type'] : '';
						
						switch( $price_type ) {
							
							case 'price-html' :
								$price = sprintf( '<span>%s</span>', isset( $col_data['price']['price-html']['content'] ) ?  $col_data['price']['price-html']['content'] : ''  );
								$payment = isset( $col_data['price']['payment']['content'] ) ?  $col_data['price']['payment']['content'] : '';
								break;
							
							case 'price' :
								$decimals = isset( $general_settings['currency'][0]['decimal-no'] ) ? (int)$general_settings['currency'][0]['decimal-no'] : 2;
								$currency_symbol = '';
								foreach ( (array)$go_pricing['currency'] as $currency ) {
									if ( !empty( $currency['id'] ) && !empty( $currency['symbol'] ) && !empty( $general_settings['currency'][0]['currency'] ) && $currency['id'] == $general_settings['currency'][0]['currency'] ) $currency_symbol = $currency['symbol'];
								}
								
								if ( isset( $col_data['price']['price'][0]['amount'][0] ) && $col_data['price']['price'][0]['amount'][0] != '' ) {
	
									$dec = explode ( '.', (float)$col_data['price']['price'][0]['amount'][0] );
									if ( !empty( $dec[1] ) ) {
										if ( strlen( $dec[1] ) < $decimals ) $decimals = strlen( $dec[1] );
									} else {
										$decimals = 0;
									}
	
									$price = sprintf( $price_format, 
										isset( $general_settings['currency'][0] ) ? esc_attr( json_encode( $general_settings['currency'][0] ) ) : '',
										$currency_symbol,
										number_format( 
											(float)$col_data['price']['price'][0]['amount'][0], 
											$decimals, 
											isset( $general_settings['currency'][0]['decimal-sep'] ) ? $general_settings['currency'][0]['decimal-sep'] : '.',
											isset( $general_settings['currency'][0]['thousand-sep'] ) ? $general_settings['currency'][0]['thousand-sep'] : ',' 
										),
										isset( $col_data['price']['price'][0]['amount'][0] ) ? number_format( (float)$col_data['price']['price'][0]['amount'][0], $decimals, '.', '' ) : 0
									);
								}
								
								$payment = isset( $col_data['price']['price'][0]['name'] ) ?  $col_data['price']['price'][0]['name'] : '';
								break;
						}				
					
						$header_custom_styles = !empty( $col_data['header']['general']['custom']['css'] ) ? explode( ';', preg_replace("/[\n\r]/","", trim( $col_data['header']['general']['custom']['css'], ' ;' ) ) ) : '';
									
						$header_custom_html = sprintf( 
							'<h3>%1$s</h3><div class="gw-go-header-bottom">%2$s</div>%3$s%4$s', 
							isset( $col_data['title']['title']['content'] ) ? $col_data['title']['title']['content'] : '',
							!empty( $col_data['header']['general']['custom']['img']['data'] ) ? 
								sprintf( 
									'<img src="%1$s"%2$s%3$s%4$s%5$s>', 
									$col_data['header']['general']['custom']['img']['data'], 
									isset( $col_data['header']['general']['custom']['img']['responsive'] ) ? ' class="gw-go-responsive-img"' : '',
									isset( $col_data['header']['general']['custom']['img']['alt'] ) ? ' alt="' . esc_attr( $col_data['header']['general']['custom']['img']['alt'] ) . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['width'] ) ? ' width="' . (int)$col_data['header']['general']['custom']['img']['width'] . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['height'] ) ? ' height="' . (int)$col_data['header']['general']['custom']['img']['height'] . '"' : ''
								) 
							: '',
							isset( $payment ) ? '<small>' . $payment . '</small>' : '',
							isset( $price ) ? '<h1>' . $price . '</h1>' : ''
						);						
						break;
						
					case 'team' :
					case 'cteam' :
					
						$header_custom_styles = !empty( $col_data['header']['general']['custom']['css'] ) ? explode( ';', preg_replace("/[\n\r]/","", trim( $col_data['header']['general']['custom']['css'], ' ;' ) ) ) : '';
						$header_custom_html = sprintf( 
							'<h3>%1$s%2$s</h3><div class="gw-go-header-bottom">%3$s</div>', 
							isset( $col_data['title']['title']['content'] ) ? $col_data['title']['title']['content'] : '',
							isset( $col_data['title']['subtitle']['content'] ) ? sprintf( '<small>%s</small>', $col_data['title']['subtitle']['content'] ) : '',
							!empty( $col_data['header']['general']['custom']['img']['data'] ) ? 
								sprintf( 
									'<img src="%1$s"%2$s%3$s%4$s%5$s>', 
									$col_data['header']['general']['custom']['img']['data'], 
									isset( $col_data['header']['general']['custom']['img']['responsive'] ) ? ' class="gw-go-responsive-img"' : '',
									isset( $col_data['header']['general']['custom']['img']['alt'] ) ? ' alt="' . esc_attr( $col_data['header']['general']['custom']['img']['alt'] ) . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['width'] ) ? ' width="' . (int)$col_data['header']['general']['custom']['img']['width'] . '"' : '',
									!empty( $col_data['header']['general']['custom']['img']['height'] ) ? ' height="' . (int)$col_data['header']['general']['custom']['img']['height'] . '"' : ''
								) 
							: ''
						);						
						break;
					
					case 'html' :
					case 'chtml' :

						$header_styles = !empty( $col_data['header']['general']['css'] ) ? explode( ';', preg_replace("/[\n\r]/","", trim( $col_data['header']['general']['css'], ' ;' ) ) ) : '';
						
						foreach( (array)$header_styles as $key => $header_style ) {
							if( !empty($header_styles[$key] ) ) $header_styles[$key] = trim( $header_style );
						}
						
						$header_custom_html = isset( $col_data['header']['general']['html'] ) ? $col_data['header']['general']['html'] : '';
						break;	
			
				}
			
			}
				
			$header_html = sprintf( 
				$sign_html . '<div%1$s%2$s>%3$s</div>', 
				!empty( $header_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$header_classes  )  ) .  '"' : '',
				!empty( $header_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$header_styles )  ) .  ';"' : '',
				$header_custom_html
			);
				
			// Filter html 
			$header_html = apply_filters( 'go_pricing_front_header_html',
				$header_html, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type'],
					'header_classes' => $header_classes,
					'header_styles' => $header_styles,
					'header_custom_styles' => $header_custom_styles,
					'header_custom_html' => $header_custom_html,
					'price_format' => $price_format,
					'price' => $price
				)
			);
			
			$header_data = apply_filters( 
				"go_pricing_front_header_html_{$pricing_table['style']}", 
				$header_html, 
				array( 
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type'],
					'col_data' => $col_data,
					'sign_html'	=> $sign_html,
					'default_font' => $default_font
				) 
			);
			
			$header_html = is_array( $header_data ) && !empty( $header_data['html'] ) ? $header_data['html'] : $header_html;
			if ( is_array( $header_data ) && !empty( $header_data['css'] ) ) $custom_inline_styles = array_merge( $custom_inline_styles, $header_data['css'] );			
			$html .= $header_html;	

			 
			/**
			 * Body
			 */
			
			// Reset
			$body_classes = array();
			$body_styles = array();			
			$body_html = '';
			$body_rows_html = '';
			
			if ( isset( $pricing_table['col-data'][$col_index]['body-row'] ) ) {
			foreach ( (array)$pricing_table['col-data'][$col_index]['body-row'] as $body_row_index => $body_row_data ) {

						
				if ( is_string( $body_row_data ) ) $body_row_data = GW_GoPricing_Helper::parse_data( $body_row_data );
				
				// Tooltip
			
				// Reset
				$tooltip_classes = array();
				$tooltip_styles = array();
				$tooltip_html = '';

				// Build classes & styles
				
				$tooltip_classes[] = "gw-go-tooltip-content";
				if ( isset( $pricing_table['tooltip']['width'] ) ) $tooltip_styles[] = sprintf( 'width:%dpx', (int)$pricing_table['tooltip']['width'] );
				if ( !empty( $pricing_table['tooltip']['text-color'] ) ) $tooltip_styles[] = 'color:' . $pricing_table['tooltip']['text-color'];
				if ( !empty( $pricing_table['tooltip']['bg-color'] ) ) $tooltip_styles[] = 'background-color:' . $pricing_table['tooltip']['bg-color'];
				if ( !empty( $pricing_table['tooltip']['bg-color'] ) ) $tooltip_styles[] = 'border-color:' . $pricing_table['tooltip']['bg-color'];
				
				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-size'] ) && (int)$body_row_data[$body_row_data['type']]['tooltip']['font-size'] != 12 ) $tooltip_styles[] = sprintf( 'font-size:%spx !important' , (int)$body_row_data[$body_row_data['type']]['tooltip']['font-size'] );
				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['line-height'] ) && (int)$body_row_data[$body_row_data['type']]['tooltip']['line-height'] != 16 ) $tooltip_styles[] = sprintf( 'line-height:%spx !important' , (int)$body_row_data[$body_row_data['type']]['tooltip']['line-height'] );
				
				
				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-style']['bold'] ) ) $tooltip_styles[] = 'font-weight:bold !important';
				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-style']['italic'] ) ) $tooltip_styles[] = 'font-style:italic !important';
				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-style']['strikethrough'] ) ) $tooltip_styles[] = 'text-decoration:line-through !important';
				
				$google_font = '';

				if ( isset( $body_row_data['type'] ) && !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-family'] ) ) {
					foreach( (array)$go_pricing['fonts'] as $fonts ) {
						
						if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
							foreach( (array)$fonts['group_data'] as $font ) {
								if ( !empty( $font['value'] ) && $font['value'] == $body_row_data[$body_row_data['type']]['tooltip']['font-family'] ) {
									if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
									
										$font_url_params = array();

										/* Google Font */
										if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
											$font_url_params[] = '400';
											if ( !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-style']['bold'] ) ) $font_url_params[] = 'b';
											if ( !empty( $body_row_data[$body_row_data['type']]['tooltip']['font-style']['italic'] ) ) $font_url_params[] = 'i';
											$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
										}
									}

									if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
										$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
										if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
									}

									if ( !empty( $font['value'] ) ) $tooltip_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
								}

							}
						}
						
					}
				}				
				
				// Filter classes & styles
				$tooltip_classes = apply_filters( 'go_pricing_front_row_tooltip_classes', 
					$tooltip_classes, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $body_row_index,
					)
				);
				
				$tooltip_styles = apply_filters( 'go_pricing_front_row_tooltip_styles', 
					$tooltip_styles, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $body_row_index,
					)
				);								
				
				// Build html	
				$tooltip_html = isset( $body_row_data['type'] ) && isset( $body_row_data[$body_row_data['type']]['tooltip']['content'] ) && $body_row_data[$body_row_data['type']]['tooltip']['content'] != '' ?
					sprintf( 
						'<div%1$s%2$s>%3$s</div>', 
						!empty( $tooltip_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$tooltip_classes  )  ) .  '"' : '',
						!empty( $tooltip_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$tooltip_styles )  ) .  ';"' : '',
						$body_row_data[$body_row_data['type']]['tooltip']['content']
					) : '';
				
				// Filter html 
				$tooltip_html = apply_filters( 'go_pricing_front_row_tooltip_html',
					$tooltip_html, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $body_row_index,
						'tooltip_classes' => $tooltip_classes,
						'tooltip_styles' => $tooltip_styles,
					)
				);
							
				if ( !isset( $body_row_data['type'] ) ) { $body_row_data['type'] = 'html'; }
				
				if ( !empty( $body_row_data['type'] ) ) {
					
					// Row
					
					// Reset
					$body_row_classes = array();
					$body_row_styles = array();
					$body_row_inline_styles = array();
					$body_row_html = '';				
					
					// Build styles & classes
					if ( $body_row_index % 2 == 1 ) { $body_row_classes[] = 'gw-go-even'; }
					if ( !empty( $body_row_data['row-align'] ) ) {
						if ( $body_row_data['type'] == 'button' ) $body_row_data['row-align'] = 'center';
						$body_row_styles[] = 'text-align:' . $body_row_data['row-align'];
					}
					
					// Row inline styles
					if ( $body_row_data['type'] == 'html' ) {
						if ( !empty( $body_row_data['html']['font-size'] ) && (int)$body_row_data['html']['font-size'] != 12 ) $body_row_inline_styles[] = sprintf( 'font-size:%spx !important' , (int)$body_row_data['html']['font-size'] );
						if ( !empty( $body_row_data['html']['line-height'] ) && (int)$body_row_data['html']['line-height'] != 16 ) $body_row_inline_styles[] = sprintf( 'line-height:%spx !important' , (int)$body_row_data['html']['line-height'] );
						if ( !empty( $body_row_data['html']['text-align'] ) ) $body_row_inline_styles[] = sprintf( 'text-align:%s !important' , $body_row_data['html']['text-align'] );						
						
						if ( !empty( $body_row_data['html']['font-style']['bold'] ) ) $body_row_inline_styles[] = 'font-weight:bold !important';
						if ( !empty( $body_row_data['html']['font-style']['italic'] ) ) $body_row_inline_styles[] = 'font-style:italic !important';
						if ( !empty( $body_row_data['html']['font-style']['strikethrough'] ) ) $body_row_inline_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $body_row_data['html']['font-family'] ) && $body_row_data['html']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $body_row_data['html']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $body_row_data['html']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $body_row_data['html']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}
										
											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}
											
											if ( !empty( $font['value'] ) ) $body_row_inline_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}						
						
					}
					
					if ( $body_row_data['type'] == 'button' ) {
						
						if ( !empty( $body_row_data['button']['font-size'] ) && (int)$body_row_data['button']['font-size'] != 12 ) $body_row_inline_styles[] = sprintf( 'font-size:%spx !important' , (int)$body_row_data['button']['font-size'] );
						if ( !empty( $body_row_data['button']['line-height'] ) && (int)$body_row_data['button']['line-height'] != 16 ) $body_row_inline_styles[] = sprintf( 'line-height:%spx !important' , (int)$body_row_data['button']['line-height'] );
						
						if ( !empty( $body_row_data['button']['font-style']['bold'] ) ) $body_row_inline_styles[] = 'font-weight:bold !important';
						if ( !empty( $body_row_data['button']['font-style']['italic'] ) ) $body_row_inline_styles[] = 'font-style:italic !important';
						if ( !empty( $body_row_data['button']['font-style']['strikethrough'] ) ) $body_row_inline_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $body_row_data['button']['font-family'] ) && $body_row_data['button']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $body_row_data['button']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $body_row_data['button']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $body_row_data['button']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}
										
											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}
											
											if ( !empty( $font['value'] ) ) $body_row_inline_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}
						
					}
					
					if ( !empty( $body_row_inline_styles ) )  {
						$custom_inline_styles[] = sprintf( 
							'.gw-go-col-wrap-%1$s .gw-go-body li[data-row-index="%2$s"] %4$s{ %3$s; }',
							$col_index,
							$body_row_index,
							implode( '; ', (array)$body_row_inline_styles ),
							isset( $body_row_data['type'] ) && $body_row_data['type'] == 'button' ? '.gw-go-btn ' : ''
						);
					}
					
					// Filter classes & styles
					$body_row_classes = apply_filters( 'go_pricing_front_row_classes', 
						$body_row_classes, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type'],
							'row_index' => $body_row_index,
						)
					);
					
					$body_row_styles = apply_filters( 'go_pricing_front_row_styles', 
						$body_row_styles, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type'],
							'row_index' => $body_row_index,
						)
					);
					
					$body_row_inline_styles = apply_filters( 
						"go_pricing_front_body_row_styles_{$pricing_table['style']}",
						array(),
						array( 
							'col_index' => $col_index,
							'row_index' => $body_row_index,
							'row_data' => $body_row_data
						) 
					);													
					
					if ( !empty( $body_row_inline_styles ) && is_array( $body_row_inline_styles ) ) $custom_inline_styles = array_merge( $custom_inline_styles, $body_row_inline_styles );	

					// Build html
					
					// Row content
					
					$body_row_inner_content = '';
					
					switch( $body_row_data['type'] ) {
						
						case 'html' : 
							$body_row_inner_content = isset( $body_row_data[$body_row_data['type']]['content'] ) ? $body_row_data[$body_row_data['type']]['content'] . $tooltip_html : '';
							break;
							
						case 'button' : 

							$button_wrap_classes = array();
							$button_classes = array();
							$button_atts = array();
							$button_attributes = array();
							
							$button_wrap_classes[] = 'gw-go-btn-wrap';
							$button_classes[] = 'gw-go-btn';
							if ( !empty( $body_row_data[$body_row_data['type']]['size'] ) ) $button_classes[] = 'gw-go-btn-' . $body_row_data[$body_row_data['type']]['size'];
							if ( !empty( $body_row_data[$body_row_data['type']]['target'] ) ) $button_atts[] = array( 'target', '_blank' );
							if ( !empty( $body_row_data[$body_row_data['type']]['nofollow'] ) ) $button_atts[] = array( 'rel', 'nofollow' );					
							
							// Filter classes & atts
							$button_classes = apply_filters( "go_pricing_front_body_button_classes_{$pricing_table['style']}", 
								$button_classes, 
								array( 
									'col_index' => $col_index,
									'row_index' => $body_row_index,
									'row_data' => $body_row_data
								) 
							);								
							
							$button_atts = apply_filters( 'go_pricing_front_body_button_atts', 
								$button_atts, 
								array(
									'pricing_table' => $pricing_table,
									'col_index' => $col_index,
									'col_style_type' => $column_style_data['type']
								)
							);										
					
							foreach ( (array)$button_atts as $button_att ) {
								if ( count( (array)$button_att ) == 2 ) $button_attributes[] = sprintf( '%1$s="%2$s"', $button_att[0], esc_attr( $button_att[1] ) );
							}
									
							// Build button html
							if ( !empty( $body_row_data[$body_row_data['type']]['type'] ) ) {
								
								switch( $body_row_data[$body_row_data['type']]['type'] ) {
									case 'button' :
										$button_html = isset( $body_row_data[$body_row_data['type']]['code'] ) && $body_row_data[$body_row_data['type']]['code'] != '' && isset( $body_row_data[$body_row_data['type']]['content'] ) && $body_row_data[$body_row_data['type']]['content'] != ''  ? 
											sprintf(
												'<a href="%1$s"%2$s%3$s>%4$s</a>', 
												esc_attr( $body_row_data[$body_row_data['type']]['code'] ),
												!empty( $button_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$button_classes )  ) .  '"' : '',
												!empty( $button_attributes ) ? ' ' . implode( ' ', (array)$button_attributes ) : '',
												$body_row_data[$body_row_data['type']]['content']
											) : '';
										break;
										
										
									case 'submit' :
										$button_html = isset( $body_row_data[$body_row_data['type']]['code'] ) && $body_row_data[$body_row_data['type']]['code'] != '' && isset( $body_row_data[$body_row_data['type']]['content'] ) && $body_row_data[$body_row_data['type']]['content'] != ''  ?
											sprintf(
												'<span%1$s>%2$s%3$s</span>', 
												!empty( $button_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$button_classes )  ) .  '"' : '',
												$body_row_data[$body_row_data['type']]['content'],
												$body_row_data[$body_row_data['type']]['code']
											) : '';
										break;
										
									case 'custom' :
										$button_html = isset( $body_row_data[$body_row_data['type']]['code'] ) ? $body_row_data[$body_row_data['type']]['code'] : '';
										break;
										
								}
									
							}
						
							// Filter footer html
							$button_html = apply_filters( 'go_pricing_front_body_button_html', 
								$button_html, 
								array(
									'pricing_table' => $pricing_table,
									'col_index' => $col_index,
									'col_style_type' => $column_style_data['type'],
									'row_index' => $body_row_index,
									'button_classes' => $button_classes,
									'button_atts' => $button_atts,
									'button_attributes' => $button_attributes	
								)
							);								
							
							$body_row_inner_content = $button_html;
							
					}
					
					$body_row_html = isset( $body_row_data ) ? 
						sprintf(
							'<li%1$s%2$s data-row-index="'.$body_row_index . '"><div class="gw-go-body-cell">%3$s</div></li>', 
							!empty( $body_row_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$body_row_classes  )  ) .  '"' : '',
							!empty( $body_row_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$body_row_styles )  ) .  ';"' : '',
							$body_row_inner_content
						) : '';										
					
					// Filter html 
					$body_row_html = apply_filters( 'go_pricing_front_body_row_html',
						$body_row_html, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type'],
							'row_index' => $body_row_index,
							'row_classes' => $body_row_classes,
							'row_styles' => $body_row_styles,
						)
					);				
					
					$body_rows_html .= $body_row_html;					
					
				}
			

			}	 
			}
			
			// Body
			
			// Build classes & styles
			$body_classes[] = "gw-go-body";
			
			// Filter classes & styles
			$body_classes = apply_filters( 'go_pricing_front_body_classes', 
				$body_classes, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type']
				)
			);
			
			$body_styles = apply_filters( 'go_pricing_front_body_styles', 
				$body_styles, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type']
				)
			);							
			
			// Build html
			$body_html = !empty( $body_rows_html ) ? 
				sprintf(
					'<ul%1$s%2$s>%3$s</ul>', 
					!empty( $body_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$body_classes  )  ) .  '"' : '',
					!empty( $body_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$body_styles )  ) .  ';"' : '',
					$body_rows_html
				) : '';		 
			
			
			// Filter html
			$body_html = apply_filters( 'go_pricing_front_body_html',
				$body_html, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type'],
					'body_rows_html' => $body_rows_html,
					'body_classes' => $body_classes,
					'body_styles' => $body_styles
				)
			);			
			
			$html .= $body_html;
			
			
			/**
			 * footer
			 */
			
			// Reset
			$footer_classes = array();
			$footer_styles = array();			
			$footer_html = '';
			$footer_rows_html = '';
			
			if ( empty( $pricing_table['hide-footer'] ) && !empty( $pricing_table['col-data'][$col_index]['footer-row'] ) ) {
			
			foreach ( (array)$pricing_table['col-data'][$col_index]['footer-row'] as $footer_row_index => $footer_row_data ) {
			
				if ( is_string( $footer_row_data ) ) $footer_row_data = GW_GoPricing_Helper::parse_data( $footer_row_data );
				
				// Tooltip
			
				// Reset
				$tooltip_classes = array();
				$tooltip_styles = array();
				$tooltip_html = '';

				// Build classes & styles
				$tooltip_classes[] = "gw-go-tooltip";
				if ( isset( $pricing_table['tooltip-width'] ) ) $tooltip_styles[] = 'width:' . $pricing_table['tooltip-width'];
				if ( !empty( $pricing_table['tooltip-text-color'] ) ) $tooltip_styles[] = 'color:' . $pricing_table['tooltip-text-color'];
				if ( !empty( $pricing_table['tooltip-bg-color'] ) ) $tooltip_styles[] = 'background-color:' . $pricing_table['tooltip-bg-color'];
				if ( !empty( $pricing_table['tooltip-bg-color'] ) ) $tooltip_styles[] = 'border-color:' . $pricing_table['tooltip-bg-color'];
				
				// Filter classes & styles
				$tooltip_classes = apply_filters( 'go_pricing_front_row_tooltip_classes', 
					$tooltip_classes, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $footer_row_index,
					)
				);
				
				$tooltip_styles = apply_filters( 'go_pricing_front_row_tooltip_styles', 
					$tooltip_styles, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $footer_row_index,
					)
				);								
				
				// Build html			
				$tooltip_html = isset( $footer_row_data['row-tooltip'] ) && $footer_row_data['row-tooltip'] != '' ?
					sprintf( 
						'<div%1$s%2$s>%3$s</div>', 
						!empty( $tooltip_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$tooltip_classes  )  ) .  '"' : '',
						!empty( $tooltip_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$tooltip_styles )  ) .  ';"' : '',
						$footer_row_data['row-tooltip']
					) : '';
					
				// Filter html 
				$tooltip_html = apply_filters( 'go_pricing_front_row_tooltip_html',
					$tooltip_html, 
					array(
						'pricing_table' => $pricing_table,
						'col_index' => $col_index,
						'col_style_type' => $column_style_data['type'],
						'row_index' => $footer_row_index,
						'tooltip_classes' => $tooltip_classes,
						'tooltip_styles' => $tooltip_styles,
					)
				);
				
				if ( !isset( $footer_row_data['type'] ) ) { $footer_row_data['type'] = 'button'; }				
							
				if ( !empty( $footer_row_data['type'] ) ) {
					
					// Row
					
					// Reset
					$footer_row_classes = array();
					$footer_row_styles = array();
					$footer_row_inline_styles = array();
					$footer_row_html = '';				
					
					// Build styles & classes
					$footer_row_classes[] = 'gw-go-footer-row'; 
					if ( $footer_row_index % 2 == 1 ) { $footer_row_classes[] = 'gw-go-even'; }
					if ( !empty( $footer_row_data['row-align'] ) ) {
						if ( $footer_row_data['type'] == 'button' ) $footer_row_data['row-align'] = 'center';
						$footer_row_styles[] = 'text-align:' . $footer_row_data['row-align'];
					}
					
					// Row inline styles
					if ( $footer_row_data['type'] == 'html' ) {
						if ( !empty( $footer_row_data['html']['font-size'] ) && (int)$footer_row_data['html']['font-size'] != 12 ) $footer_row_inline_styles[] = sprintf( 'font-size:%spx !important' , (int)$footer_row_data['html']['font-size'] );
						if ( !empty( $footer_row_data['html']['line-height'] ) && (int)$footer_row_data['html']['line-height'] != 16 ) $footer_row_inline_styles[] = sprintf( 'line-height:%spx !important' , (int)$footer_row_data['html']['line-height'] );
						if ( !empty( $footer_row_data['html']['text-align'] ) ) $footer_row_inline_styles[] = sprintf( 'text-align:%s !important' , $footer_row_data['html']['text-align'] );						
						
						if ( !empty( $footer_row_data['html']['font-style']['bold'] ) ) $footer_row_inline_styles[] = 'font-weight:bold !important';
						if ( !empty( $footer_row_data['html']['font-style']['italic'] ) ) $footer_row_inline_styles[] = 'font-style:italic !important';
						if ( !empty( $footer_row_data['html']['font-style']['strikethrough'] ) ) $footer_row_inline_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $footer_row_data['html']['font-family'] ) && $footer_row_data['html']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $footer_row_data['html']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $footer_row_data['html']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $footer_row_data['html']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}

											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}
																						
											if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											if ( !empty( $font['value'] ) ) $footer_row_inline_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}						
						
					}
					
					if ( $footer_row_data['type'] == 'button' ) {
						
						if ( !empty( $footer_row_data['button']['font-size'] ) && (int)$footer_row_data['button']['font-size'] != 12 ) $footer_row_inline_styles[] = sprintf( 'font-size:%spx !important' , (int)$footer_row_data['button']['font-size'] );
						if ( !empty( $footer_row_data['button']['line-height'] ) && (int)$footer_row_data['button']['line-height'] != 16 ) $footer_row_inline_styles[] = sprintf( 'line-height:%spx !important' , (int)$footer_row_data['button']['line-height'] );
						
						if ( !empty( $footer_row_data['button']['font-style']['bold'] ) ) $footer_row_inline_styles[] = 'font-weight:bold !important';
						if ( !empty( $footer_row_data['button']['font-style']['italic'] ) ) $footer_row_inline_styles[] = 'font-style:italic !important';
						if ( !empty( $footer_row_data['button']['font-style']['strikethrough'] ) ) $footer_row_inline_styles[] = 'text-decoration:line-through !important';
						
						$google_font = '';
	
						if ( !empty( $footer_row_data['button']['font-family'] ) && $footer_row_data['button']['font-family'] != $default_font ) { 
							foreach( (array)$go_pricing['fonts'] as $fonts ) {
								
								if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
									foreach( (array)$fonts['group_data'] as $font ) {
										if ( !empty( $font['value'] ) && $font['value'] == $footer_row_data['button']['font-family'] ) {
											if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {
											
												$font_url_params = array();
		
												/* Google Font */
												if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
													$font_url_params[] = '400';
													if ( !empty( $footer_row_data['button']['font-style']['bold'] ) ) $font_url_params[] = 'b';
													if ( !empty( $footer_row_data['button']['font-style']['italic'] ) ) $font_url_params[] = 'i';
													$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
												}
											}
										
											if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
												$google_font = sprintf( '@import url(%s)', $font['url'], $font_url_params );
												if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
											}
											
											if ( !empty( $font['value'] ) ) $footer_row_inline_styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
										}
	
									}
								}
								
							}
						}
						
					}
					
					if ( !empty( $footer_row_inline_styles ) )  {
						$custom_inline_styles[] = sprintf( 
							'.gw-go-col-wrap-%1$s .gw-go-footer-row[data-row-index="%2$s"]  %4$s{ %3$s; }',
							$col_index,
							$footer_row_index,
							implode( '; ', (array)$footer_row_inline_styles ),
							isset( $footer_row_data['type'] ) && $footer_row_data['type'] == 'button' ? '.gw-go-btn ' : ''						
						);
					}				
					
					// Filter classes & styles
					$footer_row_classes = apply_filters( 'go_pricing_front_row_classes', 
						$footer_row_classes, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type']
						)
					);
					
					$footer_row_styles = apply_filters( 'go_pricing_front_row_styles', 
						$footer_row_styles, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type']
						)
					);
					
					$footer_row_inline_styles = apply_filters( 
						"go_pricing_front_footer_row_styles_{$pricing_table['style']}",
						array(),
						array( 
							'col_index' => $col_index,
							'row_index' => $footer_row_index,
							'row_data' => $footer_row_data
						), 
						true
						 
					);													
					
					if ( !empty( $footer_row_inline_styles ) ) $custom_inline_styles = array_merge( $custom_inline_styles, $footer_row_inline_styles );															
					
					// Build html
					
					// Row content
					
					$footer_row_inner_content = '';
					
					switch( $footer_row_data['type'] ) {
						
						case 'html' : 
							$footer_row_inner_content = isset( $footer_row_data[$footer_row_data['type']]['content'] ) ? $footer_row_data[$footer_row_data['type']]['content'] . $tooltip_html : '';
							break;
							
						case 'button' : 

							$button_wrap_classes = array();
							$button_classes = array();
							$button_atts = array();
							$button_attributes = array();
							$button_html = '';
							
							$button_wrap_classes[] = 'gw-go-btn-wrap';
							$button_classes[] = 'gw-go-btn';
							if ( !empty( $footer_row_data[$footer_row_data['type']]['size'] ) ) $button_classes[] = 'gw-go-btn-' . $footer_row_data[$footer_row_data['type']]['size'];
							if ( !empty( $footer_row_data[$footer_row_data['type']]['target'] ) ) $button_atts[] = array( 'target', '_blank' );
							if ( !empty( $footer_row_data[$footer_row_data['type']]['nofollow'] ) ) $button_atts[] = array( 'rel', 'nofollow' );					
							
							// Filter classes & atts
							$button_classes = apply_filters( "go_pricing_front_footer_button_classes_{$pricing_table['style']}", 
								$button_classes, 
								array( 
									'col_index' => $col_index,
									'row_index' => $footer_row_index,
									'row_data' => $footer_row_data
								) 
							);								
							
							$button_atts = apply_filters( 'go_pricing_front_footer_button_atts', 
								$button_atts, 
								array(
									'pricing_table' => $pricing_table,
									'col_index' => $col_index,
									'col_style_type' => $column_style_data['type']
								)
							);										
					
							foreach ( (array)$button_atts as $button_att ) {
								if ( count( (array)$button_att ) == 2 ) $button_attributes[] = sprintf( '%1$s="%2$s"', $button_att[0], esc_attr( $button_att[1] ) );
							}
									
							// Build button html
							if ( !empty( $footer_row_data[$footer_row_data['type']]['type'] ) ) {
								
								switch( $footer_row_data[$footer_row_data['type']]['type'] ) {
									case 'button' :
										$button_html = isset( $footer_row_data[$footer_row_data['type']]['code'] ) && $footer_row_data[$footer_row_data['type']]['code'] != '' && isset( $footer_row_data[$footer_row_data['type']]['content'] ) && $footer_row_data[$footer_row_data['type']]['content'] != ''  ? 
											sprintf(
												'<a href="%1$s"%2$s%3$s>%4$s</a>', 
												esc_attr( $footer_row_data[$footer_row_data['type']]['code'] ),
												!empty( $button_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$button_classes )  ) .  '"' : '',
												!empty( $button_attributes ) ? ' ' . implode( ' ', (array)$button_attributes ) : '',
												$footer_row_data[$footer_row_data['type']]['content']
											) : '';
										break;
										
										
									case 'submit' :
										$button_html = isset( $footer_row_data[$footer_row_data['type']]['code'] ) && $footer_row_data[$footer_row_data['type']]['code'] != '' && isset( $footer_row_data[$footer_row_data['type']]['content'] ) && $footer_row_data[$footer_row_data['type']]['content'] != ''  ?
											sprintf(
												'<span%1$s>%2$s%3$s</span>', 
												!empty( $button_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$button_classes )  ) .  '"' : '',
												$footer_row_data[$footer_row_data['type']]['content'],
												$footer_row_data[$footer_row_data['type']]['code']
											) : '';
										break;
										
									case 'custom' :
										$button_html = isset( $footer_row_data[$footer_row_data['type']]['code'] ) ? $footer_row_data[$footer_row_data['type']]['code'] : '';
										break;
										
								}
									
							}
						
							// Filter footer html
							$button_html = apply_filters( 'go_pricing_front_footer_button_html', 
								$button_html, 
								array(
									'pricing_table' => $pricing_table,
									'col_index' => $col_index,
									'col_style_type' => $column_style_data['type'],
									'row_index' => $footer_row_index,
									'button_classes' => $button_classes,
									'button_atts' => $button_atts,
									'button_attributes' => $button_attributes	
								)
							);								
							
							$footer_row_inner_content = $button_html;
							
					}
					
					
					$footer_row_html = !empty( $footer_row_data ) ? 
						sprintf(
							'<div%1$s%2$s data-row-index="'.$footer_row_index . '"><div class="gw-go-footer-row-inner">%3$s</div></div>', 
							!empty( $footer_row_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$footer_row_classes  )  ) .  '"' : '',
							!empty( $footer_row_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$footer_row_styles )  ) .  ';"' : '',
							$footer_row_inner_content
						) : '';						
					
					// Filter html 
					$footer_row_html = apply_filters( 'go_pricing_front_footer_row_html',
						$footer_row_html, 
						array(
							'pricing_table' => $pricing_table,
							'col_index' => $col_index,
							'col_style_type' => $column_style_data['type'],
							'row_index' => $footer_row_index,
							'row_classes' => $footer_row_classes,
							'row_styles' => $footer_row_styles,
						)
					);				
						
					$footer_rows_html .= $footer_row_html;					
					
				}

			}	
			
			}
			
			
			// Footer
			
			// Build classes & styles
			$footer_classes[] = "gw-go-footer";
			
			// Filter classes & styles
			$footer_classes = apply_filters( 'go_pricing_front_footer_classes', 
				$footer_classes, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type']
				)
			);
			
			$footer_styles = apply_filters( 'go_pricing_front_footer_styles', 
				$footer_styles, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type']
				)
			);							
			
			// Build html
			$footer_html = !empty( $footer_rows_html ) ? 
				sprintf(
					'<div class="gw-go-footer-wrap"><div class="gw-go-footer-spacer"></div><div%1$s%2$s><div class="gw-go-footer-rows">%3$s</div></div></div>', 
					!empty( $footer_classes ) ? ' class="' . esc_attr( implode( ' ', (array)$footer_classes  )  ) .  '"' : '',
					!empty( $footer_styles ) ? ' style="' . esc_attr( implode( '; ', (array)$footer_styles )  ) .  ';"' : '',
					$footer_rows_html
				) : '';		 
			
			
			// Filter html
			$footer_html = apply_filters( 'go_pricing_front_footer_html',
				$footer_html, 
				array(
					'pricing_table' => $pricing_table,
					'col_index' => $col_index,
					'col_style_type' => $column_style_data['type'],
					'footer_rows_html' => $footer_rows_html,
					'footer_classes' => $footer_classes,
					'footer_styles' => $footer_styles
				)
			);			
			
			$html .= $footer_html;						
			 
			/**
			 * /Column wrappers
			 */
			 
			$html .='</div></div>';
			$html .='</div>';

			$html = preg_replace( '/(\{\{)\s?(price+\s?)(\}\})/', $price, $html );
			$html = preg_replace( '/(\{\{)\s?(payment+\s?)(\}\})/', $payment, $html );

		}
		

		
		
		/**
		 * /Build columns
		 */
		 
		$html .='</div>';
		$html .='</div>';	 

		$html = do_shortcode( $html );
		$html = apply_filters( 'go_pricing_front_html', $html, $pricing_table );

		$inline_css = '';
		$font_css = '';
		$go_pricing['_frontend']['fonts'] = array();
		
		foreach( (array)$google_fonts as $font ) {
			if ( !in_array( $font, (array)$go_pricing['_frontend']['fonts'] ) ) {			
				$font_css .= ' ' . $font . ';';
				$go_pricing['_frontend']['fonts'][] = $font;
			}
		}
			
		$custom_inline_styles[] = '.gw-go { visibility:inherit; }';
		
		$custom_inline_styles = apply_filters ( 'go_pricing_css', $custom_inline_styles );
		
		if ( !empty( $custom_inline_styles ) ) {
			foreach( (array)$custom_inline_styles as $custom_inline_style ) {
				$inline_css .= $custom_inline_style."\n";
			}
		}
		
		/* Import icon fonts */
		if ( preg_match( '/<i[^<>]*class=(\"|\')(.*)?fa(?:(<\/i>).*)?(\2)/', $html ) && empty( $general_settings['disable-font']['fa'] ) ) $font_css .= sprintf( '@import url(%s);', $this->plugin_url . 'assets/lib/font_awesome/css/font-awesome.min.css' );
		if ( preg_match( '/<i[^<>]*class=(\"|\')(.*)?linecon-(?:(<\/i>).*)?(\2)/', $html ) && empty( $general_settings['disable-font']['linecon'] ) ) $font_css .= sprintf( '@import url(%s);', $this->plugin_url . 'assets/lib/linecon/linecon.min.css' );
		if ( preg_match( '/<i[^<>]*class=(\"|\')(.*)?icomoon-(?:(<\/i>).*)?(\2)/', $html ) && empty( $general_settings['disable-font']['icomoon'] ) ) $font_css .= sprintf( '@import url(%s);', $this->plugin_url . 'assets/lib/icomoon/icomoon.min.css' );
		if ( preg_match( '/<i[^<>]*class=(\"|\')(.*)?material-(?:(<\/i>).*)?(\2)/', $html ) && empty( $general_settings['disable-font']['material'] ) ) $font_css .= sprintf( '@import url(%s);', $this->plugin_url . 'assets/lib/material/material.min.css' );		
		
		/* Responsivity */
		$mq_css = '';
		
		if ( isset( $pricing_table['responsivity']['enabled'] ) && $colnum > 0 ) {
			
			if ( isset( $pricing_table['responsivity']['views'] ) ) {
				
				foreach ( $pricing_table['responsivity']['views'] as $view ) {
					
					$mq = array();
					
					$view['cols'] = isset( $view['cols'] ) && (int)$view['cols'] > 0 && (int)$view['cols'] < $colnum ? (int)$view['cols'] : $colnum;
					
					if ( $view['cols'] == $colnum ) continue;
						
					if ( isset( $view['min'] ) && $view['min'] != '') $mq[] = sprintf( '(min-width: %dpx)', (int)$view['min'] );
					if ( isset( $view['max'] ) && $view['max'] != '') $mq[] = sprintf( '(max-width: %dpx)', (int)$view['max'] );						
					
					$width = 100;
					
					switch( $view['cols'] ) {
						
						case 2 : $width = 50; break;
						case 3 : $width = 33.33; break;
						case 4 : $width = 25; break;
						case 5 : $width = 20; break;
						case 6 : $width = 16.66; break;
						case 7 : $width = 14.285; break;
						case 8 : $width = 12.5; break;
						case 9 : $width = 11.11; break;
						case 10 : $width = 10; break;
						
					}		
												
					if ( !empty( $mq ) ) {						
						$mq_css .= sprintf( 
							'<style>@media only screen and %1$s { %2$s }</style>',
							implode ( ' and ', $mq),
							sprintf( '#go-pricing-table-%1$s .gw-go-col-wrap { width:%2$d%%; }', $postid, $width )
						);
					}
					
				}
				
			}

		}		
		
		if ( !empty( $inline_css ) ) {
			
			$inline_css = strip_tags( $inline_css );
			$custom_css = !empty( $pricing_table['custom-css'] ) ? $pricing_table['custom-css'] : '';
			$custom_css = apply_filters( 'go_pricing_front_custom_css', $custom_css, array( 'id' => $pricing_table['id'], 'postid' => $pricing_table['postid'] ) );
			$custom_css = strip_tags( $custom_css );
			
			$inline_css .= preg_replace( '/(@media[^{]+\{)([\s\S]+?})([^{}]*})/', '', $custom_css );
			preg_match_all( '/(@media[^{]+\{)([\s\S]+?})([^{}]*})/', $custom_css, $custom_css_mqs, PREG_SET_ORDER );
			
			$custom_css_mq_css = '';
			
			if ( !empty( $custom_css_mqs ) ) {
			
				foreach( $custom_css_mqs as $custom_css_mq ) {
					
					if ( !empty( $custom_css_mq[2] ) )  {
						$custom_css_mq[2] = preg_replace( '/([a-z\.#\[\]][a-z0-9\-\_\[\]\"\=\:\(\)\*\$\^\|\~\+\>\*\.\s]+|\*)(?=\s?,(?=[^}]*{)|\s*{)/', "" .' #go-pricing-table-' . $postid . ' $0', $custom_css_mq[2] );
						unset( $custom_css_mq[0] );
						$custom_css_mq_css .=  '<style>' . implode( ' ', $custom_css_mq ) . '</style>';
					}
					
				}
				
			}
			
			$inline_css = preg_replace( '/(\/\*[\s\S]*?\*\/|[\t]|[\r]|[\n]|[\r\n])/', '', $inline_css );
			$inline_css = preg_replace( '/([a-z\.#\[\]][a-z0-9\-\_\[\]\"\=\:\(\)\*\$\^\|\~\+\>\*\.\s]+|\*)(?=\s?,(?=[^}]*{)|\s*{)/', "" .' #go-pricing-table-' . $postid . ' $0', $inline_css );
			$inline_css = '<style>' . trim( $font_css . $inline_css ) . '</style>';
			$mq_css = trim( $mq_css ) . trim( $custom_css_mq_css );
			if ( $mq_css != '') $inline_css .= $mq_css;
			

		}

		return $inline_css . $html;

	}


	/**
	 * Video shortcodes
	 */


	/**
	 * HTML5 video shortcode [go_pricing_html5_video]
	 *
	 * @return string Returns HTML code.
	 */	

	public function video_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'mp4_src' => '',
			'webm_src' => '',
			'ogg_src' => '',
			'poster_src' => '',
			'autoplay' => 'no',
			'loop' => 'no',	
		 ), $atts ) );	
	
		$autoplay = $autoplay == 'yes' ? ' autoplay="true"' : '';
		$loop = $loop == 'yes' ? ' loop="true"' : '';
		$mp4_src = $mp4_src != '' ? '<source src="' . $mp4_src . '" type="video/mp4">' : '';
		$webm_src = $webm_src != '' ? '<source src="' . $webm_src . '" type="video/webm">' : '';
		$ogg_src = $ogg_src != '' ? '<source src="' . $ogg_src . '" type="video/ogg">' : '';
		$poster_src = $poster_src != '' ? $poster_src : plugin_dir_url( __FILE__ ) . 'assets/images/blank.png';

		return '<video controls="controls"' . ( $autoplay != '' ? $autoplay : '' ) . ( $loop != '' ? $loop : '' ) . ( $poster_src != '' ? ' poster="' . $poster_src . '"' : '' ) .'>' . $mp4_src . $webm_src . $ogg_src . '<object type="application/x-shockwave-flash" data="' . plugin_dir_url( __FILE__ ) . 'assets/plugins/js/mediaelementjs/flashmediaelement.swf">
		  <param name="movie" value="' . plugin_dir_url( __FILE__ ) . 'assets/plugins/js/mediaelementjs/flashmediaelement.swf" />
		  <param name="flashvars" value="controls=true&poster=' . $poster_src . '&file=' . $mp4_src . '" />
		  <img src="' . $poster_src . '" title="No video playback capabilities" />
	  </object></video>';
	  
	}

	
	/**
	 * Youtube video shortcode [go_pricing_youtube]
	 *
	 * @return string Returns HTML code.
	 */		
		
	public function youtube_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'autoplay' => 'no',
			'https' => 'yes',	
			'video_id' => '',
			'height' => 'auto',
		 ), $atts ) );	
	
		$autoplay = $autoplay == 'yes' ? '1' : '';
		$https = $https == 'yes' ? 's' : '';
		$width = '1000';
		$style = $height != 'auto' ? 'height:'.$height.'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="https://www.youtube.com/embed/' . esc_attr( $video_id ) . '?wmode=opaque&amp;controls=1&amp;showinfo=1&amp;autohide=1&amp;rel=0&amp;autoplay=' . $autoplay . '" width="' . $width . '" height="' . $height . '" marginheight="0" marginwidth="0" frameborder="0"></iframe></div>';
		
	}


	/**
	 * Vimeo video shortcode [go_pricing_vimeo]
	 *
	 * @return string Returns HTML code.
	 */

	public function vimeo_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'autoplay' => 'no',
			'color' => '',
			'https' => 'yes',	
			'video_id' => '',
			'height' => 'auto',
		 ), $atts ) );	
	
		$autoplay = $autoplay == 'yes' ? '1' : '';
		$width = '1000';
		$style = $height != 'auto' ? 'height:'.$height.'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="https://player.vimeo.com/video/' . esc_attr( $video_id ) . '?title=0&amp;byline=0&amp;portrait=0&amp;autohide=1&amp;color=' . $color . '&amp;autoplay=' . $autoplay . '" width="' . $width . '" height="' . $height . '" marginheight="0" marginwidth="0" frameborder="0"></iframe></div>';
		
	}


	/**
	 * Screenr video shortcode [go_pricing_screenr]
	 *
	 * @return string Returns HTML code.
	 */

	public function screenr_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'video_id' => '',
			'height' => 'auto',
		 ), $atts ) );	

		$width = '1000';
		$style = $height != 'auto' ? 'height:'.$height.'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="http://www.screenr.com/embed/' . esc_attr( $video_id ) . '" width="' . $width . '" height="' . $height . '" marginheight="0" marginwidth="0" frameborder="0"></iframe></div>';
		
	}

	
	/**
	 * Dailymotion video shortcode [go_pricing_dailymotion]
	 *
	 * @return string Returns HTML code.
	 */	
		
	public function dailymotion_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'video_id' => '',
			'height' => 'auto',
			'autoplay' => 'no',
		 ), $atts ) );	

		$autoplay = $autoplay == 'yes' ? '1' : '0';
		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="//www.dailymotion.com/embed/video/' . esc_attr( $video_id ) . '?wmode=opaque&amp;autoPlay=' . $autoplay . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';

	}
	
	
	/**
	 * Metacafe video shortcode [go_pricing_metacafe]
	 *
	 * @return string Returns HTML code.
	 */	
	 		
	public function metacafe_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'video_id' => '',
			'height' => 'auto',
			'autoplay' => 'no',
		 ), $atts ) );	

		$autoplay = $autoplay == 'yes' ? '1' : '0';
		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="http://www.metacafe.com/embed/' . esc_attr( $video_id ) . '?wmode=opaque&amp;ap=' . $autoplay . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
		
	}			


	/**
	 * Audio shortcodes
	 */


	/**
	 * HTML5 audio shortcode [go_pricing_audio]
	 *
	 * @return string Returns HTML code.
	 */

	public function audio_sc( $atts, $content = null ) {
		
		extract( shortcode_atts( array( 
			'mp3_src' => '',
			'ogg_src' => '',
			'wav_src' => '',
			'autoplay' => 'no',
			'loop' => 'no',	
		 ), $atts ) );	
	
		$autoplay = $autoplay == 'yes' ? ' autoplay="true"' : '';
		$loop = $loop == 'yes' ? ' loop="true"' : '';
		$mp3_src = $mp3_src != '' ? '<source src="' . $mp3_src . '" type="audio/mpeg">' : '';
		$ogg_src = $ogg_src != '' ? '<source src="' . $ogg_src . '" type="audio/ogg">' : '';
		$wav_src = $wav_src != '' ? '<source src="' . $wav_src . '" type="audio/wav">' : '';						

		return '<audio controls="controls"' . ( $autoplay != '' ? $autoplay : '' ) . ( $loop != '' ? $loop : '' ) . '>' . $mp3_src . $ogg_src . $wav_src . '</audio>';

	}
	
	
	/**
	 * Soundcloud audio shortcode [go_pricing_soundcloud]
	 *
	 * @return string Returns HTML code.
	 */	

	public function soundcloud_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'track_id' => '',
			'height' => 'auto',
			'autoplay' => 'no',
		 ), $atts ) );	

		$autoplay = $autoplay == 'yes' ? 'true' : 'false';
		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="//w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F' . esc_attr( $track_id ) . '?wmode=opaque&amp;auto_play=' . $autoplay . '&amp;show_artwork=true" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
		
	}
		

	/**
	 * Mixcloud audio shortcode [go_pricing_mixcloud]
	 *
	 * @return string Returns HTML code.
	 */	
	 
	public function mixcloud_sc( $atts, $content = null ) {
		
		extract( shortcode_atts( array( 
			'track_url' => '',
			'height' => 'auto'
		 ), $atts ) );	

		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="//www.mixcloud.com/widget/iframe/?feed=' . esc_attr( urlencode( trim( $track_id, '/' ) ) ) . '%2F&amp;show_tracklist=&amp;wmode=opaque" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
		
	}	
	
	
	/**
	 * Beatport audio shortcode [go_pricing_beatport]
	 *
	 * @return string Returns HTML code.
	 */		
		
	public function beatport_sc( $atts, $content = null ) {
		
		extract( shortcode_atts( array( 
			'track_id' => '',
			'height' => 'auto',
			'autoplay' => 'no',
		 ), $atts ) );	

		$autoplay = $autoplay == 'yes' ? '&amp;auto=' . $autoplay : '';
		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="http://embed.beatport.com/player?id=' . esc_attr( $track_id ) . '?wmode=opaque&amp;type=track' . $autoplay . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
		
	}
	

	/**
	 * Mixed shortcodes
	 */


	/**
	 * Google map shortcode [go_pricing_map]
	 *
	 * @return string Returns HTML code.
	 */	
	
	public function goole_map_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
				'address' => '',
				'title' => '',
				'icon' =>'',
				'content' => null,
				'popup' => 'no',
				'zoom' => 14,
				'maptype' => 'ROADMAP',
				'width' => '100%',
				'height' => '300',
				'class' => ''
			 ), $atts ) );
		$height = preg_match( '{^[0-9]*$}', $height ) ? $height : '300';
		$class = $class != '' ? ' ' . esc_attr( trim( preg_replace( '/\s\s+/', ' ', $class ) ) ) : '';
		$popup = $popup == 'yes' ? true : false;
		
		$mapdata['markers'][] = array ( 
			'address' => $address,
			'title' => $title,
			'icon' => !empty( $icon ) ? array( 'image' => $icon ) : null,
			'html' => isset( $content ) ? array( 
				'content' => $content,
				'popup' => $popup
			 ) : null,
		 );
		$mapdata['zoom'] = intval($zoom);
		$mapdata['maptype'] = $maptype;
		$mapdata['mapTypeControl'] = false;
	
		wp_enqueue_script( self::$plugin_slug . '-map' );
		wp_enqueue_script( self::$plugin_slug . '-gomap' );	
	
		return '<div class="gw-go-gmap' . $class . '" style="width:100%; height:' . $height . 'px;" data-map="' . esc_attr( json_encode( $mapdata ) ) . '"></div>';
		
	}
	
	
	/**
	 * IFRAME shortcode [go_pricing_custom_iframe]
	 *
	 * @return string Returns HTML code.
	 */	
	 
	public function iframe_sc( $atts, $content = null ) {

		extract( shortcode_atts( array( 
			'url' => '',
			'height' => 'auto'
		 ), $atts ) );	

		$style = $height != 'auto' ? 'height:' . $height . 'px !important; padding:0 !important;' : '';
		return '<div class="gw-go-video-wrapper"' . ( $style != '' ? ' style="' . $style . '"' : '' ) .'><iframe src="' . esc_attr( $url ) . '?wmode=opaque" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
		
	}
	
}
 
?>