<?php
/*
* @Alberto Lau alberto@righthere.com alau@albertolau.com
*/
if(!defined('pop_downloadable_content')):

define('pop_downloadable_content','1.0.0');

class pop_downloadable_content {
	var $id;
	var $parent_id;
	var $page_title;
	var $menu_text;
	var $capability;
	var $api_url;
	var $license_keys;
	var $module_url;
	function __construct($args=array()){
		if(count($args)==0)return;
		$defaults = array(
			'id'					=> 'downloadable_content',
			'plugin_id'				=> 'downloadable_content',
			'resources_path'		=> 'downloadable_content',
			'parent_id'				=> 'rh-plugins',
			'page_title'			=> 'Downloadable content',
			'menu_text'				=> 'Downloads',
			'capability'			=> 'manage_options',
			'api_url'				=> 'http://plugins.righthere.com/',
			//'api_url'				=> 'http://plugins.albertolau.com/',
			'license_keys'			=> array(),
			'module_url'			=> plugin_dir_url(__FILE__),
			'product_name'			=> 'your plugin or theme',
			'tdom'					=> 'downloads',
			'options_varname'		=> 'pop_options',
			'bundle_id'				=> 'downloadable_content'
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	

		add_action('admin_menu',array(&$this,'admin_menu'));
		
		add_action('wp_ajax_rh_get_bundles_'.$this->id,array(&$this,'get_bundles'));
		add_action('wp_ajax_rh_download_bundle_'.$this->id,array(&$this,'download_bundle'));
	
		add_action('init',array(&$this,'init'));
	}
	
	function init(){
		wp_register_script('rh-dc', 	$this->module_url.'js/dc.js', array(), '1.0.0');
		wp_register_style('rh-dc', 		$this->module_url.'css/dc.css', array(), '1.0.0');
	}
	
	function get_license_keys(){
		$arr_of_keys=array();
		if(count($this->license_keys)>0){	
			foreach($this->license_keys as $k){
				$arr_of_keys[]=is_object($k)?$k->license_key:$k;
			}
		}	
		return $arr_of_keys;
	}
	
	function send_error($msg,$error_code='MSG'){
		$this->send_response(array("R"=>"ERR","MSG"=>$msg,"ERRCODE"=>$error_code));
	}
	
	function send_response($response){
		die(json_encode($response));
	}
	
	function get_bundles(){
		if(count($this->license_keys)==0){
			$this->send_error( sprintf( __('There is no downloadable content at this time.  You must register %s before you can actually see available downloadable content. For more information on how to register %s, please go the Options menu and the License tab.','pop'),$this->product_name,$this->product_name));
		}

		$url = sprintf('%s?content_service=get_bundles&site_url=%s',$this->api_url,urlencode(site_url('/')));
		foreach($this->get_license_keys() as $key){
			$url.=sprintf("&key[]=%s",urlencode($key));
		}	

		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
		
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			return $this->send_response($response);
		}		
		die();	
	}
	
	function download_bundle(){
		if(count($this->license_keys)==0){
			$this->send_error( __('Please register the product before downloading content.','pop') );
		}
		
		$url = sprintf('%s?content_service=get_bundle&id=%s&site_url=%s',$this->api_url,intval($_REQUEST['id']),urlencode(site_url('/')));
		foreach($this->get_license_keys() as $key){
			$url.=sprintf("&key[]=%s",$key);
		}
		
		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			//handle import of content.
			if($response->R=='OK'){
				if($response->DC->type=='bundle'){
					global $userdata;
					
					require_once 'class.al_importer.php';
					$dc = base64_decode($response->DC->content);
					
					$e = new al_importer(array('post_author'=>$userdata->ID,'post_author_rewrite'=>true));
					$bundle = $e->decode_bundle($dc);
					
					$result = $e->import_bundle($bundle);
					if(false===$result){
						$this->send_error("Import error:".$e->last_error);
					}else{
						$this->add_downloaded_id(intval($_REQUEST['id']));			
						$r = (object)array(
							"R"=>"OK",
							"MSG"=> __("Content downloaded and installed.",'pop')
						);
						$this->send_response($r);
					}				
				}elseif($response->DC->type=='pop'){
					require_once 'class.pop_importer.php';
					$e = new pop_importer(array('plugin_id'=>$this->plugin_id,'options_varname'=>$this->options_varname,'resources_path'=>$this->resources_path,'tdom'=>'pop'));
					$result = $e->import_options_from_code($response);
					if(false===$result){
						$this->send_error("Import error:".$e->last_error);
					}else{
						$this->add_downloaded_id(intval($_REQUEST['id']));			
						$r = (object)array(
							"R"=>"OK",
							"MSG"=> __("Content downloaded and installed.",'pop')
						);
						$this->send_response($r);
					}	
				}else{
					$this->send_error( __('Unhandled content type, update plugin or theme to latest version.','pop') );
				}
			}else{
				$this->send_error($response->MSG,$response->ERRCODE);
			}
		}
	}
	
	function add_downloaded_id($dc_id){
		$rh_bundles = get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
		//--
		if($dc_id>0 && !in_array($dc_id,$rh_downloaded_bundles)){
			$rh_downloaded_bundles[]=$dc_id;
		}
		//--
		$rh_bundles->downloaded = $rh_downloaded_bundles;
		update_option('rh_bundles',$rh_bundles);	
	}

	function admin_menu(){
		$page_id = add_submenu_page( $this->parent_id,$this->page_title ,$this->menu_text,$this->capability,$this->id,array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );
	}
	
	function head(){
		wp_print_styles('rh-dc');
		wp_print_scripts('rh-dc');
		$rh_bundles = get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
?>
<script>
var rh_download_panel_id = '<?php echo $this->id?>';
var apiurl = '<?php echo $this->api_url?>';
var rh_license_keys = <?php echo json_encode($this->license_keys)?>;
var rh_downloaded = <?PHP echo json_encode($rh_downloaded_bundles)?>;
var rh_filter = '';
var rh_bundles;
jQuery('document').ready(function($){
	get_bundles();
	$('.main-cat').click(function(e){
		$('.main-cat').removeClass('current-cat');
		$(this).addClass('current-cat');
		rh_filter = $(this).attr('rel');
		get_bundles();
	});
});
</script>
<style>
.dc-col-name {
min-width:200px;
}
</style>
<?php	
	}
	
	function body(){
?>
<div class="wrap">
	<div class="icon32" id="icon-plugins"><br /></div>
	<h2><?php echo $this->page_title?></h2>
	<div id="messages"></div>
	<div id="installing">
		<div id="install-image" class="dc-loading"></div>
		<div id="install-message" class="install-message"></div>
		<div class="clear"></div>
	</div>
	<div class="dc-content">
		<ul class="subsubsub">
			<li><a class="main-cat" rel="" href="javascript:void(0);"><?php _e("Downloads",'pop')?></a>|</li>
			<li><a class="main-cat"  rel="new" href="javascript:void(0);"><?php _e("New",'pop')?></a>|</li>
			<li><a class="main-cat"  rel="downloaded" href="javascript:void(0);"><?php _e("Downloaded",'pop')?></a></li>
		</ul>
		<div class="clear"></div>
		<div id="downloadables" class="widefat">
			<table class="wp-list-table widefat">
				<thead>
					<tr>
						<th class="dc-col-name"><?php _e("Name",'pop')?></th>
						<th><?php _e("Version",'pop')?></th>
						<th><?php _e("Size",'pop')?></th>
						<th><?php _e("Description",'pop')?></th>
					</tr>
				</thead>
				<tbody id="bundles">
				
				</tbody>
				<tfoot>
					<tr>
						<th><?php _e("Name",'pop')?></th>
						<th><?php _e("Version",'pop')?></th>
						<th><?php _e("Size",'pop')?></th>
						<th><?php _e("Description",'pop')?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="clear"></div>	
	</div>
</div>
<?php	
	}	
}

endif;
?>