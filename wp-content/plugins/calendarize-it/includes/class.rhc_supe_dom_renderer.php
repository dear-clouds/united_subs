<?php

class rhc_supe_dom_renderer {
	var $uid=0;
	var $date_options=false;
	function __construct(){

	}

	function render_events( $events, $atts, $content, $do_shortcode=true, $uid, $render_images_ids ){
	
		if( isset( $atts['separator'] ) && 'eap'==$atts['separator'] ){
			$atts['showimage']="1";
		}
	
		extract(shortcode_atts(array(
			'date_format' 		=> 'MMM d, yyyy',
			'time_format' 		=> 'h:mmtt',
			'showimage'			=> '0',
			'microdata'			=> '1',
			'gmt_offset'		=> get_option('gmt_offset'),
			'parse_postmeta'	=> '',
			'parse_taxonomy'	=> '1',
			'template'			=> 'widget_upcoming_events.php',
			'separator'			=> '',
			'words'				=> '',
			'last_event_info'	=> '1'
		), $atts));		
	
		$render_images_ids = explode(',',$render_images_ids);
	
		$gmt_offset = empty($gmt_offset) ? '' : $gmt_offset;
		$tz_suffix = $this->convert_hours_to_hours_and_minutes( $gmt_offset );		
		$microdata = '1'==$microdata ? true : false;
		$parse_taxonomy = '1'==$parse_taxonomy ? true : false;
		
		$tools = new calendar_ajax;
		$out='';
		if( is_array($events) && count($events) > 0 ){
			$done_dates = array();
			$start_tss = array();
			$end_tss = array();
			foreach($events as $event_index => $e){	
				$replacements = array();
				//---
				$start 	= strtotime($e->event_start);
				$end 	= strtotime($e->event_end);

				$start_tss[] = $start;
				$end_tss[] = $end;
/*
echo "LINE:".__LINE__."<br>";
echo "<pre>";
print_r( $e );
echo "</pre>";
*/
				
				$dom = new DomDocument();
				
				//--
				$tpl = apply_filters('supe_get_template_content', 
					$this->get_template_content( $template, $content, $e, $do_shortcode ), 
					$uid,
					$template, 
					$content, 
					$e, 
					$do_shortcode, 
					$atts
				);	
				
				if(empty($tpl) || false===$tpl) continue;		
				//$dom->loadHTML( htmlentities( $tpl ) );
				
				@$dom->loadHTML( mb_convert_encoding( $tpl, 'HTML-ENTITIES', 'UTF-8') );				
//				@$dom->loadHTML( $tpl);

				//--
				if( $microdata ){
					$this->dom_class_set_attribute( $dom, 'rhc-widget-upcoming-item', 'itemscope', '' );
					$this->dom_class_set_attribute( $dom, 'rhc-widget-upcoming-item', 'itemtype', 'http://schema.org/Event' );
					//--
					$microdata_date_format = intval($e->allday) ? 'Y-m-d' : 'Y-m-d\TH:i:s' ; 
					$this->dom_node_append_microdata_itemprop( $dom, 'rhc-widget-upcoming-item', 'startDate', (date($microdata_date_format,$start).$tz_suffix), $microdata );
					$this->dom_node_append_microdata_itemprop( $dom, 'rhc-widget-upcoming-item', 'endDate', (date($microdata_date_format,$end).$tz_suffix), $microdata );						
					
				}
//ID			//------------------
				$this->dom_class_set_attribute( $dom, 'rhc-widget-upcoming-item', 'data-post_id', $e->ID );	
				
//TITLE			//------------------
				$replacements[] = (object)array('replace'=>'[RHCTITLE]','with'=> $e->post_title );
				$this->dom_title( $dom, '[RHCTITLE]', $atts, $microdata );
//DESC			//------------------
				$this->dom_description( $dom, $e, $atts, $microdata );
//URL			//------------------				
				$url = $this->get_event_url( $e );
				if($e->number>0 && !empty($url) ){
					$url = $this->addURLParameter($url, 'event_rdate', date('YmdHis',$start).','.date('YmdHis',$end) );
				}
				//$this->dom_class_set_attribute( $dom, 'rhc-title-link', 'href', $url );
				if( property_exists( $e, 'meta' ) && isset( $e->meta['fc_click_link'] ) && 'none' == $e->meta['fc_click_link'] ){
					$this->dom_url( $dom, '', $microdata );
				}else{
					$this->dom_url( $dom, $url, $microdata );
				}
				//--
//IMAGE				
				if( '1'==$showimage ){
					$attachment_id = get_post_meta($e->ID,'rhc_tooltip_image',true);
					$size = $tools->get_image_size();
					$image = $tools->get_tooltip_image($e->ID, $attachment_id, $size);
					if(is_array($image)&&isset($image[0])){					
						$this->dom_class_set_image( $dom, 'rhc-widget-upcoming-featured-image', $image[0], $url );
						$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', 'featured-1' );
						//--
						$this->dom_class_set_image_no_link( $dom, 'fc-event-featured-image', $image[0] );						
					}else{
						//$this->dom_class_remove( $dom, 'rhc-widget-upcoming-featured-image' );
						$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', 'featured-1' );
					}				
				}else{
					$this->dom_class_remove( $dom, 'rhc-widget-upcoming-featured-image' );
					$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', 'featured-0' );
				}
//OTHER IMAGES
				$this->handle_event_images( $dom, $e, $url, $tools, $render_images_ids );
//-- dates below the title
//this take into consideration the passed formats
				$this->dom_class_set_date( $dom, 'rhc-widget-date', $start, $date_format );
				$this->dom_class_add_class( $dom, 'rhc-widget-date', 'fc-date-format' );
				$this->dom_class_set_date( $dom, 'rhc-widget-time', $start, $time_format );
				$this->dom_class_add_class( $dom, 'rhc-widget-time', 'fc-date-format' );

				$this->dom_class_set_date( $dom, 'rhc-widget-end-date', $end, $date_format );
				$this->dom_class_add_class( $dom, 'rhc-widget-end-date', 'fc-date-format' );				
				$this->dom_class_set_date( $dom, 'rhc-widget-end-time', $end, $time_format );
				$this->dom_class_add_class( $dom, 'rhc-widget-end-time', 'fc-date-format' );
//--- fc_color or other styles saved in post_meta as strings
				$this->dom_post_meta_styles( $dom, $e );
//--- convert some post_meta into element attr for javascript processing.				
				$this->dom_post_meta_to_attr( $dom, $e );
//--- different date: flag elements that only show on different dates / or remove them ( .if-different-date .if-different-date-r			
				if( date('Ymd',$start)==date('Ymd',$end) ){
					$this->dom_class_add_class( $dom, 'if-different-date', 'is-same-date' );
					$this->dom_class_remove( $dom, 'if-different-date-r');
				}
//--- different month:				
				if( date('Ym',$start)==date('Ym',$end) ){
					$this->dom_class_add_class( $dom, 'if-different-month', 'is-same-month' );
					$this->dom_class_remove( $dom, 'if-different-month-r');
				}	
//--- different year:				
				if( date('Y',$start)==date('Y',$end) ){
					$this->dom_class_add_class( $dom, 'if-different-year', 'is-same-year' );
					$this->dom_class_remove( $dom, 'if-different-year-r');
				}				
//--- date range
				$diff = floor( ( $end - $start ) / 86400 );						
				if( $diff > 0 ){
					$this->dom_class_set_date_range( $dom, 'rhc-widget-date-range', $start, $end, $date_format );
					$this->dom_class_remove( $dom, 'rhc-day_diff0' );
				}else{
					$this->dom_class_set_date( $dom, 'rhc-widget-date-range', $start, $date_format );
					$this->dom_class_add_class( $dom, 'rhc-widget-date-range', 'fc-date-format' );
					$this->dom_class_remove( $dom, 'rhc-day_diff1' );
				}
				//-- dates in post info detail boxes
				$this->dom_class_set_post_info_dates( $dom, 'rhc_date', $start, $end );
				$this->dom_class_add_class( $dom, 'rhc_date', 'fc-date-format' );
				//-- dates in the left boxes
				$this->dom_class_set_date_with_format( $dom, 'rhc-date-start', $start );
				$this->dom_class_add_class( $dom, 'rhc-date-start', 'fc-date-format' );
				//--
				$current_date = date('Ymd',$start);
				if( in_array( $current_date, $done_dates) ){			
					$this->dom_class_add_class( $dom, 'hide-repeat-date', 'repeated-date' );
				}else{
					$done_dates[] = $current_date;
				}
				//--
				if( intval($e->allday) ){
					$this->dom_class_add_class( $dom, 'rhc-allday-hidden', 'fc-is-allday' );
					$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', 'fc-is-allday' );
					$this->dom_class_remove( $dom, 'rhc-widget-time' );
					$this->dom_class_remove( $dom, 'rhc-widget-end-time' );
					//$this->dom_class_remove( $dom, 'rhc-widget-date-time' );
				}	
				//handle render post meta
				$this->dom_post_meta( $dom, $e );
				
				$this->handle_render_taxonomy( $dom, $e, $parse_taxonomy, $atts, $replacements );
				//rnoe: remove node on empty
				$this->handle_rnoe( $dom );
				//cleanup
				$this->handle_cleanup( $dom );
				
				# remove <!DOCTYPE 
				$dom->removeChild($dom->doctype);           
				# remove <html><body></body></html> 
				$dom->replaceChild($dom->firstChild->firstChild->firstChild, $dom->firstChild);	
				$tmp = $dom->saveHTML();
				
				foreach( $replacements as $r ){
					$tmp = str_replace($r->replace,$r->with,$tmp);
				}
				
				$next_index = $event_index+1;
				if(isset($events[$next_index])){
					if('eap'==$separator && defined('EAP_DIVIDER')){
						$separator = EAP_DIVIDER;
					}
					$tmp .= apply_filters('rhc_supe_render_separator', $separator, $atts);
				}
				
				/*
				$bodyNode = $dom->getElementsByTagName('body')->item(0);
				foreach ($bodyNode->childNodes as $childNode) {
				  $tmp .= $dom->saveHTML($childNode);
				}
				*/
				if( isset($_REQUEST['rhc_debug']) ){
					$out.="<!-- MARK START -->\n".$tmp."\n<!-- MARK END -->\n";
				}else{
					$out.=$tmp."\n";
				}
			}
			//-- last event $e
			if( '1' == $last_event_info ){
				$max_start_ts = array_keys($start_tss, max($start_tss));
				if( isset($max_start_ts[0]) ){
					$j= $max_start_ts[0];
					$out.= sprintf("<script class=\"rhc-supe-last\" data-last_date_start=\"%s\" data-last_date_end=\"%s\"></script>",
						date( 'Y-m-d\TH:i:s', $start_tss[$j] ),
						date( 'Y-m-d\TH:i:s', $end_tss[$j] )
					);
				}
			}
			//$out.="<div><pre>".print_r($start_tss,true)."</pre> ".."</div>";
			//
		}

		return $out;	
	}
	
	function handle_event_images( $dom, $e, $url, $tools, $render_images ){
		$images = apply_filters( 'rhc_images', array('rhc_top_image','rhc_dbox_image','rhc_tooltip_image','rhc_month_image') );
		foreach( $images as $meta_key ){
			$size = 'full';
			if( property_exists( $e, 'images' ) && is_array( $e->images ) ){
				$image = isset( $e->images[$meta_key] ) && !empty( $e->images[$meta_key] ) ? $e->images[$meta_key] : false;
			}else{
				$image = false;
			}			
			
			if( false===$image ){
				$this->dom_class_remove( $dom, $meta_key.'-img-link' );
				$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', $meta_key.'-imgset-0' );
				$this->dom_class_remove( $dom, $meta_key.'-img-src' );
			}else{
				$url = $this->get_event_url( $e );
				$this->dom_class_set_image( $dom, $meta_key.'-img-link', $image, $url );
				$this->dom_class_add_class( $dom, 'rhc-widget-upcoming-item', $meta_key.'-imgset-1' );
				//--
				$this->dom_class_set_image_no_link( $dom, $meta_key.'-img', $image );						
				//--
				$this->dom_class_set_image_src( $dom, $meta_key.'-img-src', $image );
			} 
		}

	}
	
	function get_event_description( $e, $words='' ){
		if($words>0 && !empty($e->post_excerpt) ){
			$str = strip_tags($e->post_excerpt);
			$arr = explode(' ',$str);
			$arr = array_slice($arr,0,$words);
			$description = implode(' ',$arr);
			$description.="<a class='upcoming-excerpt-more' href=\"".$e->the_permalink."\">...</a>";
		}else if( (string)$words=='' ){
			$description = $e->post_excerpt;
		}else{
			$description = '';
		}
		
		return apply_filters('upcoming_events_description', $description, $e->post_excerpt, $words, $e);
	}
	
	function get_event_url( $e ){
		if( property_exists( $e, 'the_permalink') ){
			return $e->the_permalink;
		}
		return get_the_permalink( $e->ID );
	}

	function handle_rnoe( $dom ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query('//*[@data-rnoe="rnoe"]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				if( '1'== $node->getAttribute('data-is_empty') ){
					$node->parentNode->removeChild( $node );
				}
				//-- remove empty node
				
			}
		}	
		
		foreach( $finder->query('//*[@data-rnoe="rnoe"][not(*)][not(normalize-space())]') as $node ) {	
			$node->parentNode->removeChild($node);
		}	
		//handle 1 level nested empty rnoe
		foreach( $finder->query('//*[@data-rnoe="rnoe"][not(*)][not(normalize-space())]') as $node ) {	
			$node->parentNode->removeChild($node);
		}			
	}
	
	function handle_cleanup( $dom ){
		$finder = new DomXPath($dom);
		//tterm_loop
		$nodes = $finder->query('//*[@data-tterm_loop]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$node->removeAttribute('data-rnoe');
				$node->removeAttribute('data-tterm_loop');
				$node->removeAttribute('data-term_index');
			}
		}		
		//tterm
		$nodes = $finder->query('//*[@data-tterm]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$node->removeAttribute('data-tterm');
				$node->removeAttribute('data-fields');
				$node->removeAttribute('data-format');
				$node->removeAttribute('data-term_index');
				$node->removeAttribute('data-empty_fields');
				$node->removeAttribute('data-empty_format');
			}
		}			
		//tterm_meta
		$nodes = $finder->query('//*[@data-tterm_meta]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$node->removeAttribute('data-tterm_meta');
				$node->removeAttribute('data-fields');
				$node->removeAttribute('data-format');
				$node->removeAttribute('data-term_index');
			}
		}	
		//--- data-post_meta_styles  post_meta_attr
		$remove_attributes = array(
			'@data-rnoe',
			'@data-post_meta_styles',
			'@data-post_meta_format',
			'@data-post_meta_attr',
			'@data-rnoe',
			'@data-postmeta_fields',
			'@data-postmeta_format'
		);
		
		$nodes = $finder->query( sprintf( '//*[%s]', implode(' or ', $remove_attributes ) ) );
		if( $nodes->length > 0 ){	
			foreach( $nodes as $node ){
				foreach( $remove_attributes as $attr ){	
					$node->removeAttribute( substr( $attr, 1 ) );
				}
			}
		}	
			
	}
	
	function handle_render_taxonomy( $dom, $e, $parse_taxonomy, $atts, &$replacements ){
		//return;
		return $this->_handle_render_taxonomy( $dom, $e, $parse_taxonomy, $atts, $replacements );
	}
	
	function _handle_render_taxonomy( $dom, $e, $parse_taxonomy, $atts, &$replacements ){
		if(!$parse_taxonomy)return false;
		
		$event_taxonomies = (property_exists($e,'taxonomies') && is_array($e->taxonomies) && count($e->taxonomies)>0) ? $e->taxonomies : array()  ;
		$event_taxs = array();
		if( !empty( $event_taxonomies ) ){
			foreach( $event_taxonomies as $tax ){
				$event_taxs[] = $tax->name;
			}
		}
		
		$finder = new DomXPath($dom);
		//--- taxonomy_holder
		$nodes = $finder->query('//*[@data-taxonomy_holder]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$taxonomy = $node->getAttribute('data-taxonomy_holder');	
				//taxonomy is set on event?
				if( !in_array( $taxonomy, $event_taxs ) ){
					$node->setAttribute('data-is_empty','1');
				}			
			}
		}		
		//--- taxonomy
		$nodes = $finder->query('//*[@data-taxonomy]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
			
				$taxonomy = $node->getAttribute('data-taxonomy');

				if( empty($taxonomy) || empty( $event_taxonomies ) ){
					$node->setAttribute('data-is_empty','1');
				}else{
					foreach( $event_taxonomies as $event_taxonomy ){
						if( $taxonomy == $event_taxonomy->name ){
							$field = $node->getAttribute('data-field');
							$field = empty( $field ) ? 'label' : $field;	

							$is_empty = true;
							switch($field){
								case 'label':
									$value = $event_taxonomy->labels->name;
									$is_empty = empty($value) ;
									break;
								case 'singular_name':
									$value = $event_taxonomy->labels->singular_name;
									$is_empty = empty($value) ;
									break;
								/* the tag needs to be uniq	
								case 'description':
									$value = '[RHCTAXDESC]';
									$is_empty = empty($event_taxonomy->description);
									$replacements[] = (object)array('replace'=>'[RHCTAXDESC]','with'=> $event_taxonomy->description );
									break;
								*/
								default:
									$value = '';
							}	
						
							if( $is_empty  ){							
								$node->setAttribute('data-is_empty','1');								
							}
							
							$node->nodeValue = $value;																			
						}

					}
				}
			}
		}	
		
		//--- term loop
		$nodes = $finder->query('//*[@data-tterm_loop]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$taxonomy = $node->getAttribute('data-tterm_loop');
				if( !in_array( $taxonomy, $event_taxs ) ){
					$node->setAttribute('data-is_empty','1');
					continue;
				}	
				
				if( empty($taxonomy) || empty( $event_taxonomies ) ){
					$node->setAttribute('data-is_empty','1');
				}else{
					foreach( $event_taxonomies as $event_taxonomy ){
						if( $taxonomy == $event_taxonomy->name ){			
							if( property_exists( $event_taxonomy, 'terms' ) && count( $event_taxonomy->terms ) > 1 ){			
								foreach( $event_taxonomy->terms as $index => $term ){
									//clone node assign index
									if( $index > 0 ){
										$clone = $node->cloneNode( true );
										try {
											$node = $node->parentNode->insertBefore( $clone, $node->nextSibling);
										} catch(\Exception $e){
											$node = $node->parentNode->appendChild( $clone );
										}
									}

									$node->setAttribute( 'data-term_index', $index );
									//--tterm and tterm_meta nodes.
									$tterm_nodes = $finder->query('.// *[(@data-tterm)or(@data-tterm_meta)or(@data-single_marker="1")]', $node);	
									if( $tterm_nodes->length > 0 ){
										foreach( $tterm_nodes as $tterm_node ){	
											$tterm_node->setAttribute( 'data-term_index', $index );
										}
									}																
								}
							}
						}
					}
				}				
			}
		}			
		
		//--- single tterm
		$nodes = $finder->query('//*[@data-tterm]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$taxonomy = $node->getAttribute('data-tterm');

				if( empty($taxonomy) || empty( $event_taxonomies ) ){
					$node->setAttribute('data-is_empty','1');
				}else{
					foreach( $event_taxonomies as $event_taxonomy ){
						if( $taxonomy == $event_taxonomy->name ){
							if( property_exists( $event_taxonomy, 'terms' ) && isset( $event_taxonomy->terms[0] ) ){
								$fields = $node->getAttribute('data-fields');
								$fields = empty( $fields ) ? 'name' : $fields;	

								$fields_arr = explode( ',', $fields );

								$format = $node->getAttribute('data-format');
								$format = empty( $format ) ? '%s' : $format;

								//---
								$term_index = $node->getAttribute('data-term_index');
								$term_index = empty( $term_index ) ? 0 : intval($term_index) ;				
								$tterm = $event_taxonomy->terms[ $term_index ];						
								//-- fields to test if empty, so that an alternate format is used.
								$empty_format = $node->getAttribute('data-empty_format');						
								if( !empty( $empty_format ) ){							
									$empty_fields = $node->getAttribute('data-empty_fields');
									if( !empty( $empty_fields ) ){							
										$tmp_arr = explode(',', $empty_fields);
										foreach( $tmp_arr as $tmp ){
											if( !property_exists( $tterm, $tmp ) || empty( $tterm->$tmp ) ){
												//trigger empty format.
												$format = $empty_format;
											}
										}
									}								
								}
								//---
								$args = array();
								foreach($fields_arr as $field){
									$args[] = property_exists( $tterm, $field ) ? $tterm->$field : '';
								}
		
								$node->nodeValue = '';

								$value = vsprintf( $format, $args );
								$value = $this->sanitize_dom_fragment_value( $value );

								$f = $dom->createDocumentFragment();
								$f->appendXML( $value );
								$node->appendChild($f);	
							}else{
								$node->setAttribute('data-is_empty','1');
							}
						}
					}
				}
			}
		}
		
		//--- single tterm_meta	
		$nodes = $finder->query('//*[@data-tterm_meta]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$taxonomy = $node->getAttribute('data-tterm_meta');

				if( empty($taxonomy) || empty( $event_taxonomies ) ){
					$node->setAttribute('data-is_empty','1');
				}else{
					foreach( $event_taxonomies as $event_taxonomy ){
						if( $taxonomy == $event_taxonomy->name ){							
							if( property_exists( $event_taxonomy, 'terms' ) && is_array( $event_taxonomy->terms ) && isset( $event_taxonomy->terms[0] ) ){
								$term_index = $node->getAttribute('data-term_index');
								$term_index = empty( $term_index ) ? 0 : intval($term_index) ;
								$tterm = $event_taxonomy->terms[ $term_index ];									
									
								if( property_exists( $tterm, 'meta' ) && is_array( $tterm->meta ) && count( $tterm->meta ) > 0  ){
								
									
									$fields_str = $node->getAttribute('data-fields');
									$fields = explode(',', $fields_str);
									
									$format = $node->getAttribute('data-format');
									$format = empty( $format ) ? '%s' : $format;
									
									$node->nodeValue = '';
				
									$incomplete = false;
									$args = array();
									foreach( $fields as $field ){

										if( isset( $tterm->meta[$field] ) ){
											$args[]=$tterm->meta[$field];
										}else{

											$incomplete = true;
										}
									}
									
									if( !$incomplete ){								
										$value = vsprintf( $format, $args );
										$value = $this->sanitize_dom_fragment_value( $value );
										$f = $dom->createDocumentFragment();
										$f->appendXML( $value );
										$node->appendChild($f);									
									}else{
										$node->setAttribute('data-is_empty','1');
									}
									//---
								}else{
									$node->setAttribute('data-is_empty','1');
								}

							}else{
								$node->setAttribute('data-is_empty','1');
							}
						}
					}
				}
			}
		}		
		
		
		//--- multi term
			
		//--- google map
		$classname = 'rhc-gmap';
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				if( intval( $node->getAttribute('data-single_marker') ) ){
					$single_tterm_index = intval( $node->getAttribute('data-term_index') );
				}else{
					$single_tterm_index = false ;
				}
				$taxonomy = $node->getAttribute('data-gmap_taxonomy');
				if( empty($taxonomy) || !in_array( $taxonomy, $event_taxs ) ) {
					$node->setAttribute('data-is_empty','1');
					continue;
				}
				//-- fetch markers	
				$markers = array();
				foreach( $event_taxonomies as $event_taxonomy ){
					if( property_exists( $event_taxonomy, 'terms' ) && is_array( $event_taxonomy->terms ) && count( $event_taxonomy->terms ) > 0 ){
						foreach( $event_taxonomy->terms as $tterm_index => $tterm ){
							if( false!==$single_tterm_index && $single_tterm_index!=$tterm_index ) continue;
							if( property_exists( $tterm, 'meta' ) && is_array( $tterm->meta ) && count( $tterm->meta ) > 0 ){
								$m =& $tterm->meta;
								
								try {
									$marker = new rhc_supe_gmap_marker( $tterm->name, $tterm->meta );
									$markers[] = $marker;								
								}catch( Exception $e ){
								
								}
							}
						}
					}
			
				}
				//-- create gmap
				$gmap = new rhc_supe_gmap( $dom, $node, $markers );


				
			}
		}
	}
	
	function dom_node_append_microdata_itemprop( $dom, $classname, $itemprop, $content, $microdata ){
		if(!$microdata)return false;
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$meta_node = $dom->createElement('meta');
				$meta_node->setAttribute('itemprop',$itemprop);
				$meta_node->setAttribute('content',$content);
				$node->appendChild( $meta_node );		
				break;//not needed more than once.
			}
		}			
	}

	function dom_title( $dom, $value, $atts, $microdata=true  ){
		$title_classes = array('rhc-title-link','rhc-title');
		foreach($title_classes as $classname){
			$this->dom_class_node_value( $dom, $classname, $value );
			if( $microdata ){
				$this->dom_class_set_attribute( $dom, $classname, 'itemprop', 'name' );
			}		
		}
	}
	
	function dom_description( $dom, $e, $atts, $microdata=true ){
		$words = isset( $atts['words'] ) ? $atts['words'] : '' ;
		$description = $this->get_event_description($e,$words);		
		if( empty($description) ){
			$this->dom_class_node_value( $dom, 'rhc-description', '' );
			$this->dom_class_add_class( $dom, 'rhc-description-empty', 'rhc-description-empty-1' );
		}else{
			$this->dom_class_node_fragment( $dom, 'rhc-description', $description);	
			if( $microdata ){
				$this->dom_class_set_attribute( $dom, 'rhc-description', 'itemprop', 'description' );
			}					
		}   
	}
	
	function dom_url( $dom, $url, $microdata ){
		$title_classes = array('rhc-title-link','rhc-event-link');
		foreach($title_classes as $classname){
			if(!empty($url)){
				$this->dom_class_set_attribute( $dom, $classname, 'href', $url );
				//$this->dom_class_set_attribute( $dom, $classname, 'itemprop', 'url' );
			}else{
				$this->dom_remove_link( $dom, $classname );
			}
		}
	}
	
	function dom_remove_link( $dom, $classname ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$div = $dom->createElement("span", $node->nodeValue);		
				$div->setAttribute('class',$classname);
				$node->parentNode->replaceChild($div, $node);
			}
		}		
	}
	
	function dom_node_add_class( $node, $newclass ){
		$class = $node->getAttribute('class');
		$arr = explode(' ',$class);
		if(!in_array($newclass,$arr)){
			$arr[]=$newclass;
			$node->setAttribute('class',implode(' ',$arr));
		}	
	}
	
	function dom_post_meta_to_attr( $dom, $e ){
		if( !property_exists( $e, 'meta' ) || empty( $e->meta ) ) return true;
		$finder = new DomXPath($dom);
		$nodes = $finder->query('//*[@data-post_meta_attr]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				//pairs of post_meta, attr name to set. ie.  meta1,attr1|meta2,attr2| ... metaN,attrN
				$arr = explode( '|', $node->getAttribute('data-post_meta_attr') );
				foreach( $arr as $pair ){
					$brr = explode(',', $pair);
					$node->setAttribute( $brr[1], ( isset( $e->meta[ $brr[0] ] ) ? $e->meta[ $brr[0] ] : '' ) ); 
				}
			}
		}
	}
	
	function dom_post_meta( $dom, $e ){
		if( !property_exists( $e, 'meta' ) || empty( $e->meta ) ) return true;
		$finder = new DomXPath($dom);
		$nodes = $finder->query('//*[@data-postmeta_fields]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){
				$fields = $node->getAttribute('data-postmeta_fields');
				$fields_arr = array_filter( explode( ',', $fields ) );
				if( !empty( $fields_arr ) ){
					$incomplete = false;
					$args = array();
					foreach( $fields_arr as $meta_field ){
						if( !isset( $e->meta[$meta_field] ) || empty( $e->meta[$meta_field] ) ){
							$incomplete=true;
						}
						$args[]= isset($e->meta[$meta_field]) ? $e->meta[$meta_field] : '' ;
					}
					$format = $node->getAttribute('data-postmeta_format');
					$format = empty( $format ) ? '%s' : $format;		
					
					$value = vsprintf( $format, $args );
					
					$node->nodeValue = '';
					
					$f = $dom->createDocumentFragment();
					$value = $this->sanitize_dom_fragment_value( $value );
					$f->appendXML( $value );
					$node->appendChild($f);						
					if( $incomplete ){
						$node->setAttribute( 'data-is_empty', '1' );
					}
				}
			}
		}
	}
	
	function dom_post_meta_styles( $dom, $e ){
		if( !property_exists( $e, 'meta' ) || empty( $e->meta ) ) return true;
		$finder = new DomXPath($dom);
		$nodes = $finder->query('//*[@data-post_meta_styles]');
		if( $nodes->length > 0 ){
			foreach( $nodes as $node ){

				if( ($style_fields = $node->getAttribute('data-post_meta_styles')) && ( $format = $node->getAttribute('data-post_meta_format') ) ){					
					if( !($current_style = $node->getAttribute('style')) ){
					 	$current_style='';
					 }
						
					$style_fields_arr = explode(',',$style_fields);
					$args = array();
					$incomplete = false;
					foreach( $style_fields_arr as $meta_field ){
						if( !isset( $e->meta[$meta_field] ) || empty( $e->meta[$meta_field] ) ){
							$incomplete=true;
						}
						$args[]= isset($e->meta[$meta_field]) ? $e->meta[$meta_field] : '' ;
						
					}
					
					if( !$incomplete ){
						$v = vsprintf( $format, $args );
						if( !empty( $current_style ) && ';' != substr( $current_style, -1 ) ){
							$current_style.=";";
						}
						$current_style.=$v;							
					}

					$node->setAttribute( 'style', $current_style );
				}
			}
		}	
		return true;
	}
	
	function render_js( $atts ){
		global $rhc_plugin;
		
		foreach(array(
			'monthnames' 		=> __('January,February,March,April,May,June,July,August,September,October,November,December','rhc'),
			'monthnamesshort'	=> __('Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec','rhc'),
			'daynames'			=> __('Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','rhc'),
			'daynamesshort'		=> __('Sun,Mon,Tue,Wed,Thu,Fri,Sat','rhc')
			) as $field => $default ){
			$option_name = 'cal_'.$field;
			$$field = $rhc_plugin->get_option( $option_name, $default, true);
		
			if(empty($$field)){
				$$field = $default;
			}
		}

		extract(shortcode_atts(array(
			'monthnames' 		=> $monthnames,
			'monthnamesshort' 	=> $monthnamesshort,
			'daynames'			=> $daynames,
			'daynamesshort'		=> $daynamesshort
		), $atts));	

		$settings = (object)array(
			'monthNames' 		=> explode(',',$monthnames),
			'monthNamesShort' 	=> explode(',',$monthnamesshort),
			'dayNames' 			=> explode(',',$daynames),
			'dayNamesShort' 	=> explode(',',$daynamesshort)
		);
	
		ob_start();
?>
<script type="text/javascript">
if( typeof rhc_fc_date_format != 'function' ){
	function rhc_fc_date_format(){
	jQuery(document).ready(function($){
		if( $.fullCalendar ){
			$('.xfc-date-format').each(function(i,el){
				if( $(el).data('fc-date-formatted') ) return;
				$(el).data('fc-date-formatted',true);
				date = $.fullCalendar.parseDate( $(el).data('date') );		
				format = $(el).data('format')||'';		
				$(el).html( $.fullCalendar.formatDate(  date, format, <?php echo json_encode($settings)?> ) );
			});	
		}
	});
	}
}

jQuery(document).ready(function($){
	rhc_fc_date_format();
});
</script>
<?php
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
	
	function dom_class_set_date_range( $dom, $classname, $start, $end, $date_format, $separator=' &#8211; ' ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){

				//----------------
				$dom_date1 = $dom->createElement('span');
				//$dom_date1->setAttribute('data-date', date( 'Y-m-d\TH:i:s', $start ) );
				//$dom_date1->setAttribute('data-format', $date_format );
				//$dom_date1->setAttribute('class', 'fc-date-format' );
				$dom_date1->nodeValue = '';

				
				$f = $dom->createDocumentFragment();
				$value = fc_date_format( $start, $date_format, $this->get_date_options() );	
				$value = $this->sanitize_dom_fragment_value( $value );
				if( false===$f ){
				
				}else{
					$f->appendXML( $value );
					$dom_date1->appendChild($f);							
				}	
	
		
		//$this->dom_class_node_fragment( $dom_date1, $classname, $value, true );
				
				$node->appendChild( $dom_date1 );			
				
				//----------------
				$custom_separator = $node->getAttribute('data-separator');
				$separator = !empty($custom_separator) ? $custom_separator : $separator;
				
				$sep = $dom->createElement('span');
				$sep->nodeValue = $separator;
				$node->appendChild( $sep );			
		
				//----------------
				$dom_date2 = $dom->createElement('span');
				//$dom_date2->setAttribute('data-date', date( 'Y-m-d\TH:i:s', $end ) );
				//$dom_date2->setAttribute('data-format', $date_format );
				//$dom_date2->setAttribute('class', 'fc-date-format' );
				$dom_date2->nodeValue = '';

				$f2 = $dom->createDocumentFragment();
				$value = fc_date_format( $end, $date_format, $this->get_date_options() );	
				$value = $this->sanitize_dom_fragment_value( $value );
				if( false===$f2 ){
				
				}else{
					$f2->appendXML( $value );
					$dom_date2->appendChild($f2);							
				}	
				
				$node->appendChild( $dom_date2 );				
		
			}
		}	
	}
	
	function dom_class_set_date( $dom, $classname, $date, $format ){
		$value = fc_date_format( $date, $format, $this->get_date_options() );	
		$this->dom_class_node_fragment( $dom, $classname, $value, true );			
		return;
		/*
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				//-- client side render 
				//$node->setAttribute('data-date', date('Y-m-d\TH:i:s',$date) );
				//$node->setAttribute('data-format',$format);
				//$node->nodeValue = '';
				//-- server side render:
				$node->nodeValue = fc_date_format( $date, $format, $this->get_date_options() );		
			}
		}	
		*/
	}
	
	function dom_class_set_date_with_format( $dom, $classname, $date ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				/*
				$node->setAttribute('data-date', date('Y-m-d\TH:i:s',$date) );
				$node->setAttribute('data-format', $node->nodeValue );
				*/
				$format = $node->nodeValue;
				$node->nodeValue = '';
				$value = fc_date_format( $date, $format, $this->get_date_options() );
				if( !empty( $value ) ){
					$f = $dom->createDocumentFragment();
					$value = $this->sanitize_dom_fragment_value( $value );
					$f->appendXML( $value );
					$node->appendChild($f);	
				}	
			}
		}	
	}

	function dom_class_set_post_info_dates( $dom, $classname, $start, $end ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				if( $node->hasAttribute('data-fc_field') ){
					if( 'start'==$node->getAttribute('data-fc_field') ){
						$date = $start;						
					}else if( 'end'==$node->getAttribute('data-fc_field') ){
						$date = $end;
					}else{
						$date = false;
					}
					
					if(false!==$date){
						$node->setAttribute('data-date', date('Y-m-d\TH:i:s', $date ) );
						$node->setAttribute('data-format', $node->getAttribute('data-fc_date_format') );
						$node->nodeValue = '';							
					}					
				}
			}
		}	
	}
	
	function dom_class_add_class( $dom, $classname, $newclass ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$class = $node->getAttribute('class');
				$arr = explode(' ',$class);
				if(!in_array($newclass,$arr)){
					$arr[]=$newclass;
					$node->setAttribute('class',implode(' ',$arr));
				}				
			}
		}	
	}
	
	function dom_class_remove( $dom, $classname ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$node->parentNode->removeChild($node);				
			}
		}	
	}
	
	function dom_class_set_image( $dom, $classname, $image, $url ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$dom_image = $dom->createElement('img');
				$dom_image->setAttribute('src', $image );
				
				$dom_a = $dom->createElement('a');
				$dom_a->appendChild($dom_image);
				$dom_a->setAttribute('class','rhc-image-link');
				$dom_a->setAttribute('href', $url);
				
				$node->appendChild( $dom_a );			
			}
		}
	}
	
	function dom_class_set_image_src( $dom, $classname, $image ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$node->setAttribute('src', $image );
			}
		}
	}

	function dom_class_set_image_no_link( $dom, $classname, $image ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$dom_image = $dom->createElement('img');
				$dom_image->setAttribute('src', $image );

				$node->appendChild( $dom_image );			
			}
		}
	}
	
	function dom_class_set_attribute( $dom, $classname, $attr, $value ){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$node->setAttribute($attr,$value);				
			}
		}
	}
	
	function dom_class_node_value( $dom, $classname, $value){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$node->nodeValue = $value;				
			}
		}
	}	
	
	function dom_class_node_fragment( $dom, $classname, $value, $clear_node=true){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				if( $clear_node ){
					$node->nodeValue = '';
				}
				$value = trim($value);
			
				if( !empty( $value ) ){
					$f = $dom->createDocumentFragment();
					$value = $this->sanitize_dom_fragment_value( $value );
					if( false===$f ){
					
					}else{
						$f->appendXML( $value );
						$node->appendChild($f);							
					}				
				}			
			}
		}
	}
			
	function dom_class_js( $dom, $classname, $value){
		$finder = new DomXPath($dom);
		$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
		if( $nodes->length > 0 ){
			foreach($nodes as $node){
				$dom_script = $dom->createElement('script');
				$dom_script->nodeValue=$value;				
				
				$node->appendChild( $dom_script );
			}
		}
	}
	
	//helpers
	
	function get_template_content( $template, $content, $post=null, $do_shortcode=true ){
		if(trim($content)!='')return trim($content);
		$file = $this->get_template( $template );
		//----
		$out='';
		if(file_exists($file)){
			ob_start();
			include $file;
			$out = ob_get_contents();
			ob_end_clean();
		}
		
		$out = trim($out);
		
		if( $do_shortcode ){
			$out = do_shortcode($out);
		}
		
		return $out;
	}
	
	function get_template( $file='widget_upcoming_events.php' ){
		global $rhc_plugin;
		return $rhc_plugin->get_template_path($file);
	}
	
	static function addURLParameter($url, $paramName, $paramValue) {
	     $url_data = parse_url($url);
	     if(!isset($url_data["query"])){
		 	$url_data["query"]="";
		 }
	     $params = array();
	     parse_str($url_data['query'], $params);
	     $params[$paramName] = $paramValue;

	     $url_data['query'] = http_build_query($params);
	     return rhc_supe_dom_renderer::build_url($url_data);
	}

	static function build_url($url_data) {
	    $url="";
	    if(isset($url_data['host']))
	    {
	        $url .= $url_data['scheme'] . '://';
	        if (isset($url_data['user'])) {
	            $url .= $url_data['user'];
	                if (isset($url_data['pass'])) {
	                    $url .= ':' . $url_data['pass'];
	                }
	            $url .= '@';
	        }
	        $url .= $url_data['host'];
	        if (isset($url_data['port'])) {
	            $url .= ':' . $url_data['port'];
	        }
	    }
	    $url .= $url_data['path'];
	    if (isset($url_data['query'])) {
	        $url .= '?' . $url_data['query'];
	    }
	    if (isset($url_data['fragment'])) {
	        $url .= '#' . $url_data['fragment'];
	    }
	    return $url;
	}	
	
	function convert_hours_to_hours_and_minutes($source_hours, $format = '%s%s:%s') {
		if(!is_numeric($source_hours)) return $source_hours;
		$time = $source_hours * 60;//convert to minutes
	    $sign = '+';
		if ($time < 0) {
	        $sign = '-';
			$time = abs($time);
	    }
		
	    $hours = floor($time / 60);	
	    $minutes = ($time % 60);
	    return sprintf(	$format, 
			$sign, 
			str_pad($hours,2,'0',STR_PAD_LEFT), 
			str_pad($minutes,2,'0',STR_PAD_LEFT)
		);
	}	
	
	function get_date_options(){
		if( false===$this->date_options ){
			$this->date_options = fc_get_date_options( false, true ); //functions.template.php
		}
		return $this->date_options;
	}
	
	function sanitize_dom_fragment_value( $value ){
		$value=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $value);
		return $value;
	}	
}

class rhc_supe_gmap {
	var $type;
	var $size;
	var $zoom;
	var $maptype;
	var $ratio;
	var $sensor;
	var $markers = array();
	function rhc_supe_gmap( $dom, $node, $markers ){
		$defaults = array(
			'size' 		=> '300x150',
			'zoom' 		=> '',
			'maptype' 	=> 'roadmap',
			'ratio' 	=> '4:3',
			'sensor'	=> 'false',
			'type' 		=> 'static'
		);
		foreach( $defaults as $field => $default ){
			$attr_name = 'data-'.$field;
			$v = $node->getAttribute( $attr_name );
			$v = empty( $v ) ? $default : $v ;
			$this->$field = $v ;
		}
		
		$this->markers = $markers;
		
		$this->set_map( $dom, $node );
	}
	
	function set_map( $dom, $node ){
		if( 'interactive'==$this->type ){
			$this->set_interactive_map( $dom, $node );
		}else{
			$this->set_static_map( $dom, $node );
		}
	}
	
	function set_interactive_map( $dom, $node ){
		$node->nodeValue =  '';
		if( !empty( $this->markers ) ){
			foreach($this->markers as $marker){
				$marker->append_rhc_marker( $dom, $node );
			}		
		}
	}
	
	function set_static_map( $dom, $node ){
		$image_src = $this->get_static_map_url();
		$dom_image = $dom->createElement('img');
		$dom_image->setAttribute('src', $image_src );	
	
		$node->appendChild( $dom_image );
	}
	
	function get_static_map_url(){
		$url = 	'http://maps.googleapis.com/maps/api/staticmap?size=' . $this->size ;
		$arr = array();
		foreach( array('zoom','maptype') as $field ){
			if( !empty( $this->$field ) ){
				$arr[] = sprintf('%s=%s', $field, $this->$field );
			}
		}

		$arr = array_merge( $arr, $this->get_static_markers() );
		
		$url = empty( $arr ) ? $url : $url.'&'.implode('&',$arr);
//$url = str_replace( 'wp422.localhost.com', 'calendarize.it', $url );		
		return $url;
	}
	
	function get_static_markers(){
		$arr = array();
		if( !empty( $this->markers ) ){
			foreach($this->markers as $marker){
				$arr[] = 'markers=' . $marker->get_static_marker();
			}		
		}

		return $arr;
	}
}

class rhc_supe_gmap_marker {
	var $name;
	var $glon;
	var $glat;
	var $ginfo;
	var $gaddress;
	var $marker_active;
	var $marker_inactive;
	var $marker_size;
	
	function __construct( $name, $m ) {
		foreach( array(
			'glon' => '',
			'glat' => '',
			'ginfo'=> '',
			'gaddress' => '',
			'marker_active' => '',
			'marker_inactive' => '',
			'marker_size' => ''
		) as $field => $default ){
			$this->$field = isset( $m[$field ] ) ? $m[$field] : $default ;
		}
		
		$this->name = $name;
		
		if( empty($this->glon) && empty($this->glat) && empty($this->gaddress) ){
			throw new Exception('Coord or Address most be set.');
		}
	}
	
	function get_static_marker(){
		$icon = empty( $this->marker_inactive ) ? '' : 'icon:'.urlencode($this->marker_inactive);
		$loc = empty( $this->glon ) || empty( $this->glat ) ? $this->gaddress  : $this->glat.','.$this->glon;
		
		return $icon.'%7C'.$loc; 
	}
	
	function append_rhc_marker( $dom, $node ){
		$marker = $dom->createElement('div');
		$marker->setAttribute('style','display:none;');
			
		$atts = array();
		foreach( array('glon','glat','ginfo','gaddress','marker_active','marker_inactive','marker_size') as $field ){
			if( !empty( $this->$field ) ){
				$attr_name = sprintf( 'data-%s', $field );
				$marker->setAttribute( $attr_name, $this->$field );
				$marker->nodeValue = $this->name;
			}
		}
		$node->appendChild( $marker );
	}
}
/*
rhc-description  the excerpt
rhc-title the title only
rhc-title-link   the title and the url
rhc-widget-upcoming-featured-image   image html
rhc-widget-date fc-date-format  the date
rhc-widget-time fc-date-format  the time
rhc-widget-end-time  fc-date-format the end time  
*/
?>