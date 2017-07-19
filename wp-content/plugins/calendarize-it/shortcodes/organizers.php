<?php


class shortcode_organizers {
	function __construct($shortcode){
		add_shortcode($shortcode, array(&$this,'handle_shortcode'));//default $shortcode is venue, given by RCH_ORGANIZER
	}
	
	function handle_shortcode($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'class' 	=> ''
		), $atts));
		
		$template = trim($template)==''?$this->get_organizers_template_default():$template;
		$output = sprintf("[taxonomymeta taxonomy='%s'] %s[/taxonomymeta]",RHC_ORGANIZER,$template);
		return do_shortcode($output);
		//return apply_filters('the_content',$output);
	}	
	
	function get_organizers_template_default(){
		global $rhc_plugin; 
		$content = $rhc_plugin->get_option('rhc-organizer-layout','');
		if(trim($content)==''){
			ob_start();
			require_once RHC_PATH.'templates/shortcode_organizers_template_default.php';		
			$content = ob_get_contents();
			ob_end_clean();		
		}

		return $content;
	}
}




?>