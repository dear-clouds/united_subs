<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if('rhc_post_info_shortcode'==get_class($this)):
		if(false===$columns){
			$columns = $s->columns;
			$columns = $columns<0?$columns=1:$columns;		
		}
		
		$data = $s->data;	
		
		$out='';
		if(false==$frontend || is_array($data) && count($data)>0){
			//back compat fill in the blanks.
			foreach($data as $i => $cell){
				$arr=(array)$cell;
				if(!property_exists($cell,'column') || ''==$cell->column ){
					$j = $i;			
					$cell->column 	= fmod($j,$columns);
					$cell->span 	= 12;
					$cell->offset 	= 0;		
					$data[$i]=$cell;
				}
			}			
			
			$style = "";
			//$style = $width=='0'?'width:100%;':"width:{$width}px;";
			
			$have_image=false;
			$attachment_holder_class = '';
			$thumbnail = rhc_post_info_shortcode::get_attachment($post_ID,$frontend,$s,$have_image,$attachment_holder_class);	

			$container_span = $have_image?$container_span:'12';
			
			$out .= "<div class=\"rhc fe-extrainfo-container $class fe-have-image-".( $have_image?'1':'0' )."\" style=\"$style\">";
			$out .= "<div class=\"fe-extrainfo-container2 row-fluid\">";
			$out .= "<div class=\"fe-extrainfo-holder fe-extrainfo-col{$columns} span$container_span\">";
			
			$columnas_arr = array();
			for($a=0;$a<$columns;$a++){
				$columnas_arr[$a]=array();
				foreach($data as $index => $cell){
					if($cell->column!=$a)continue;
					$cell->index = $index;
					$columnas_arr[$a][]=$cell;				
				}
			}
			
			if(!$frontend){
				//fill in empty
				for($a=0;$a<$columns;$a++){
					if(!isset($columnas_arr[$a]) || empty($columnas_arr[$a])){
						$columnas_arr[$a]=array();
						$columnas_arr[$a][]=(object)array(
							'type'	=> 'empty'
						);
					}
				}
			}
			
			$out .= "<div class=\"row-fluid\">";
			$span = 12 / count($columnas_arr);
			foreach($columnas_arr as $i => $cells){
				$out .= sprintf("<div class=\"span%s fe-maincol fe-maincol-%s\" data-column_index=\"%s\">",$span,$i,$i);	
				if(!empty($cells)){
					//--
					$pending_close=false;
					$cols = 0;
					foreach($cells as $cell){					
						$c= new rhc_post_info_field( (array)$cell );
						
						if($cols==0){
							$out .= "<div class=\"row-fluid fe-sortable\">";	
							$pending_close=true;
						}
						
						$out .= sprintf("<div class=\"%s%s\">%s</div>",
							($c->span>0?'span'.$c->span:''),
							($c->offset>0?'offset'.$c->offset:''),
							$c->render($frontend)
						);	
						
						$cols = $cols + $c->span + $c->offset;
						if($cols>=12){
							$out .= "</div>";
							$cols=0;	
							$pending_close=false;
						}						
					}
					
					if($pending_close){
						$out .= "</div>";//this closes an open div on the previous foreach.
					}
					//--				
				}
				$out .= "</div>";
			}
			$out .= "</div>";
		

			$out .= "</div>";
			//-----
			if($have_image){
				$out .= sprintf("<div class=\"%s span%s\">", $attachment_holder_class, abs(12-$container_span) );
				$out .= $thumbnail;
				$out .= "</div>";
			}
			//-----
			$out .= "</div>";
			$out .= "</div>";
			
		}
endif;
?>