<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if(!class_exists('pop_bundles')):
class pop_bundles {
	var $plugin_id;
	var $plugin_code;
	var $label;
	var $right_label;
	var $page_title;
	var $tdom;
	var $options_varname;
	var $panel_priority=100;
	function __construct($args=array()){
		$defaults = array(
			'plugin_id'				=> '',
			'plugin_code'			=> 'POP',
			'tdom'					=> 'righthere',
			'options_varname'		=> 'pop_options',
			'capability'			=> 'manage_options',
			'panel_priority'		=> 9,
			'open'					=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}		
		add_filter( "pop-options_{$this->plugin_id}",array(&$this,'options'),$this->panel_priority,1);
		add_action("pop_admin_head_{$this->plugin_id}",array(&$this,'pop_admin_head'),$this->panel_priority);
		
		add_action('wp_ajax_restore-bundle-'.$this->plugin_id, array(&$this,'ajax_restore_bundle'));
		
	}
	
	function options($t){
		$i = count($t);
		//--Default backgrounds -----------------------		
		$i++;
		$t[$i]->id 			= 'bundles'; 
		$t[$i]->label 		= __('Bundles','pop');
		$t[$i]->right_label	= __('Plugin bundled content','pop');
		$t[$i]->page_title	= __('Bundles','pop');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->open = $this->open;
		$t[$i]->options = array(
			(object)array(
				'type'=>'description',
				'description'=>__('Bundles can be added by plugin add-ons or updates.  If you restore a bundle, depending on the bundle content, it can overwrite part of the current settings or all of them.  Make a backup of your settings before proceding.','pop')
			),
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Bundles','pop')
			),
			(object)array(
				'id'		=> 'bundles_callback',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'restore_bundle')	
			),
			(object)array('type'=>'clear')			
		);
		return $t;
	}
	
	function pop_admin_head(){
?>
<script type='text/javascript'>
jQuery(document).ready(function($){
	$("#btn_restore_bundle").click(function(){restore_bundle( $('#bundle_dropdown').val() );});
});
 function restore_bundle(bundle){
 	 jQuery(document).ready(function($){ 
	 	$('#restore_status').addClass('left-loading').html('');
		var args = {
			action: 'restore-bundle-<?PHP echo $this->plugin_id?>',
			bundle: bundle
		}
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				$('#restore_status').html('<?php _e('Operation completed','pop')?>');
			}else if(data.R=='ERR'){
				$('#restore_status').html(data.MSG);
			}else{
				$('#restore_status').html('<?php _e('Unknown error while processing. Please reload and try again.','pop')?>');
			}
			$('#restore_status').removeClass('left-loading');
		},'json');
	 });	 
 }
</script>
<?php	
	}
	
	function restore_bundle(){
	?>
			<div class="pt-option">
				<label for="restore-bundle"><?php _e('Restore bundle:','pop')?></label>
				<?php echo $this->bundles_dropdown();?>		
			</div>
			<div class="pt-option">
				<p><input type="button" id="btn_restore_bundle" class="button-secondary" value="<?php _e('Click to restore bundle','pop')?>" /></p>
				<p><div id="restore_status"></div></p>
			</div>		
	<?php
		//echo sprintf("<br />(%s)",$this->plugin_id);
	}
	
	function bundles_dropdown($id='bundle_dropdown',$name='bundle_dropdown',$extra='',$value=''){
		$bundles = apply_filters(sprintf("%s_%s",$this->plugin_id,'bundles'),array());
		$str = sprintf("<select id=\"%s\" name=\"%s\" %s>",$id,$name,$extra);
		if(is_array($bundles)&&count($bundles)>0){
			foreach($bundles as $id => $b ){
				$str.=sprintf("<option %s value=\"%s\">%s</option>", ($b[0]==$value?'selected':''),$b[0],$b[1]);
			}
		}
		$str.="</select>";
		return $str;
	}		
	
	function ajax_restore_bundle(){
		die(json_encode(array('R'=>'ERR','MSG'=>'TODO')));
	}
}
endif;


?>