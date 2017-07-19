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
	var $alt_temp = false;
	var $plugin_codes = array();
	function __construct($args=array()){
		if(count($args)==0)return;
		$defaults = array(
			'id'					=> 'downloadable_content',
			'plugin_id'				=> 'downloadable_content',
			'resources_path'		=> 'downloadable_content',
			'other_resources_path'	=> false,
			'parent_id'				=> 'rh-plugins',
			'page_title'			=> 'Downloadable content',
			'menu_text'				=> 'Downloads',
			'capability'			=> 'manage_options',
			'api_url'				=> 'http://plugins.righthere.com/',
			//'api_url'				=> 'http://plugins.albertolau.com/',
			'license_keys'			=> array(),
			'plugin_code'			=> '',
			'plugin_codes'			=> array(),
			'module_url'			=> plugin_dir_url(__FILE__),
			'product_name'			=> 'your plugin or theme',
			'tdom'					=> 'downloads',
			'options_varname'		=> 'pop_options',
			'bundle_id'				=> 'downloadable_content',
			'bundle_type'			=> 'plugin',
			'alt_temp'				=> false, //if set to true, will use uploads as temp path instead of systems tmp (iis problem)
			'theme'					=> false,
			'custom_filter'			=> false,
			'multisite'				=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	
		
		add_action('admin_menu',array(&$this,'admin_menu'));
		
		add_action('wp_ajax_rh_get_bundles_'.$this->id, array(&$this,'get_bundles'));
		add_action('wp_ajax_rh_download_bundle_'.$this->id, array(&$this,'download_bundle'));
		add_action('wp_ajax_dlc_activate_addon_'.$this->id, array(&$this,'handle_activate_addon'));
		add_action('wp_ajax_handle_stripe_token_'.$this->id, array(&$this,'handle_stripe_token'));
		add_action('wp_ajax_apply_coupon_'.$this->id, array(&$this,'handle_apply_coupon'));
		add_action('wp_ajax_handle_gc_'.$this->id, array(&$this,'handle_gc'));
		
		add_action('init',array(&$this,'init'));
	}
	
	function init(){
		wp_register_script('pop-notices', 	$this->module_url.'js/notices.js', array(), '2.4.4.1');
		wp_register_script('rh-dc', 	$this->module_url.'js/dc.js', array('pop-notices'), '2.4.4.2');
		wp_register_style('rh-popspinners', 		$this->module_url.'css/spinners.css', array(), '2.4.3');
		wp_register_style('pop-notices', 		$this->module_url.'css/notices.css', array(), '2.4.3');
		wp_register_style('rh-dc', 		$this->module_url.'css/dc.css', array('rh-popspinners','pop-notices'), '2.4.3');
		
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
	
	function get_license_item_ids(){
		$arr_of_keys=array();
		if(count($this->license_keys)>0){	
			foreach($this->license_keys as $k){
				$arr_of_keys[]=is_object($k)?$k->item_id:$k;	
				if( is_object($k) && property_exists($k,'other_item_id') ){
					$other_arr = explode(',', $k->other_item_id);
					if( is_array( $other_arr ) && count( $other_arr ) > 0 ){
						foreach( $other_arr as $other_item_id ){
							if( ''==trim($other_item_id) ) continue;
							$arr_of_keys[] = $other_item_id;			
						}
					}
				}		
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
	
	function get_paymethods(){
		if(count($this->license_keys)==0){
			return false;
		}
			
		if ( false === ( $paymethods = get_transient( 'rh_paymethods' ) ) ) {
			$url = sprintf('%s?content_service=get_paymethods&site_url=%s',
				$this->api_url,
				urlencode(site_url('/'))
			);

			foreach($this->get_license_keys() as $key){
				$url.=sprintf("&license_key=%s",urlencode($key));
				break;
			}	

			if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
			$rh = new righthere_service();
			$response = $rh->rh_service($url);
	
			if( 'OK' == $response->R ){
				set_transient( 'rh_paymethods', $response, 3600 );
				return $response;
			}

			return false;		  
		}	
		return $paymethods;	
	}
	
	function get_bundles(){
		//-- allow listing dlc without a license.
		return $this->get_bundles_from_plugin_code();
		//-- 
		if(count($this->license_keys)==0){
			$this->send_error( sprintf( __('There is no downloadable content at this time.  You must register %s before you can actually see available downloadable content. For more information on how to register %s, please go the Options menu and the License tab.','pop'),$this->product_name,$this->product_name));
		}

		$url = sprintf('%s?content_service=get_bundles&site_url=%s&bundle_type=%s',
			$this->api_url,
			urlencode(site_url('/')),
			$this->bundle_type
		);
		
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
	
	function get_plugin_codes( $arr=array() ){
		$arr = is_array($arr) ? $arr : array() ;
		if( is_array( $this->plugin_codes ) && count($this->plugin_codes) > 0 ){
			foreach( $this->plugin_codes as $c ){

				if( !in_array($c->plugin_code, $arr) ){
					$arr[] = $c->plugin_code;
				}
			}
		}	
		return $arr;
	}
	
	function get_bundles_from_plugin_code(){
		$plugin_codes_arr = $this->get_plugin_codes( array( $this->plugin_code ) );
		
		$plugin_codes = apply_filters('dlc_plugin_code', $plugin_codes_arr );
		if(!is_array($plugin_codes) || empty($plugin_codes)){
			return $this->send_error( sprintf( __('Plugin settings error.  Missing plugin code.','pop'),$this->product_name,$this->product_name));
		}
	
		$url = sprintf('%s?content_service=get_bundles_from_codes&site_url=%s',$this->api_url,urlencode(site_url('/')));
		foreach($plugin_codes as $code){
			$url.=sprintf("&code[]=%s",urlencode($code));
		}	
//error_log($url."\n",3,ABSPATH.'theme.log');
		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
	
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			if($response->R=='OK'){
				if(property_exists($response,'BUNDLES') && is_array($response->BUNDLES) && count($response->BUNDLES)>0){
					foreach($response->BUNDLES as $i => $bundle){
						$currency = property_exists($bundle,'currency') ? $bundle->currency : 'USD';
						//This is only for information purpose. it is not considered on payment procedures. Just like prices.
						$response->BUNDLES[$i]->currency = $currency;
						
						if($bundle->price==0){
							$response->BUNDLES[$i]->price_str = __('Free','pop');
						}else{
							$response->BUNDLES[$i]->price_str = sprintf('%s %s', $bundle->price, $currency);
						}
					}				
				}
			}
			return $this->send_response($response);
		}		
		die();	
	}
	
	function download_bundle(){
		if( !is_super_admin() && current_user_can('rh_demo') ){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
			
		if(count($this->license_keys)==0){
			$this->send_error( __('Please register the product before downloading content.','pop') );
		}
		
		$url = sprintf('%s?content_service=get_bundle&id=%s&site_url=%s',$this->api_url,intval($_REQUEST['id']),urlencode(site_url('/')));
		foreach($this->get_license_keys() as $key){
			$url.=sprintf("&key[]=%s", trim($key) );
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

					$plugin_id 			= $this->plugin_id;
					$options_varname	= $this->options_varname;
					$resources_path 	= $this->resources_path;	
									
					if( isset($_REQUEST['plugin_code']) && !empty($_REQUEST['plugin_code']) ){			
						foreach( $this->plugin_codes as $c => $t ){
							if( $t->plugin_code == $_REQUEST['plugin_code'] ){
								$plugin_id 		 = $t->plugin_id;
								$options_varname = $t->options_varname;
								$resources_path  = $t->resources_path;
								break;
							}
						}
					}
					
					$e = new pop_importer(array(
						'plugin_id'			=> $plugin_id,
						'options_varname'	=> $options_varname,
						'resources_path'	=> $resources_path,
						'tdom'				=> 'pop',
						'alt_temp'			=> $this->alt_temp,
						'multisite'			=> $this->multisite
					));
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

	function handle_activate_addon(){
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}

		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}
		$plugins = $this->get_plugins();	
		$valid_plugins = array_keys($plugins);
		$plugin = isset($_REQUEST['plugin']) && array_key_exists($_REQUEST['plugin'], $plugins) ? $_REQUEST['plugin'] : false;
		$plugin_code = isset($_REQUEST['plugin_code']) ? $_REQUEST['plugin_code'] : $this->plugin_code;
		
		$options_varname 	= $this->options_varname;
		$resources_path 	= $this->resources_path;	
		if( is_array( $this->plugin_codes ) && count($this->plugin_codes) > 0 ){
			//handle other plugins
			foreach( $this->plugin_codes as $i => $c ){
				if( $plugin_code == $c->plugin_code ){
					$options_varname 	= $c->options_varname;
					$resources_path 	= $c->resources_path;	
				}
			}
		}	
		
		if(false===$plugin){
			die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin is no longer available.','pop') )));
		}
		$redirect_url='';
		$current = $this->get_option( $options_varname, array());
		$current = is_array($current) ? $current : array();
		$current['addons'] = is_array($current['addons']) ? $current['addons'] : array() ;	
		$activate = isset($_REQUEST['activate']) && 1==intval($_REQUEST['activate']) ? true : false;
		if($activate){
			if(!in_array($plugin,$current['addons'])){
				$upload_dir = $this->wp_upload_dir();
				$addons_path = $upload_dir['basedir'].'/'.$resources_path.'/';				
				try {
					$addon = $plugin;
					@include_once $addons_path.$plugin;
					//----
					//$current['addons'][] = $plugin;
					array_unshift($current['addons'],$plugin);
					$current['addons'] = array_intersect($current['addons'],$valid_plugins);
					$this->update_option( $options_varname, $current);
					
					do_action('activate_'.$plugin,$addons_path,$plugin);
					$redirect_url = apply_filters('activate_url_'.$plugin,$redirect_url);
				}catch(Exception $e){	
					die(json_encode(array('R'=>'ERR','MSG'=> $e->getMessage() )));			
				}			
			}
		}else{
			if(in_array($plugin,$current['addons'])){
				$current['addons'] = array_diff($current['addons'], array($plugin))  ;
				$current['addons'] = array_intersect($valid_plugins,$current['addons']);
				$this->update_option( $options_varname, $current);			
			}
		}

		die(json_encode(array('R'=>'OK','MSG'=>'','URL'=>$redirect_url)));
	}
	
	function add_downloaded_id($dc_id){
		$rh_bundles = $this->get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
		//--
		if($dc_id>0 && !in_array($dc_id,$rh_downloaded_bundles)){
			$rh_downloaded_bundles[]=$dc_id;
		}
		//--
		$rh_bundles->downloaded = $rh_downloaded_bundles;
		$this->update_option('rh_bundles',$rh_bundles);	
	}

	function admin_menu(){
		$page_id = add_submenu_page( $this->parent_id,$this->page_title ,$this->menu_text,$this->capability,$this->id,array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );
	}
	
	function get_active_addons(){
		//main addons
		$addons = $this->_get_active_addons( $this->options_varname );
		//other addons
		if( is_array( $this->plugin_codes ) && count($this->plugin_codes) > 0 ){
			foreach( $this->plugin_codes as $c ){
				$more_addons = $this->_get_active_addons( $c->options_varname );
				if( is_array($more_addons) && count($more_addons) > 0 ){
					$addons = array_merge( $addons, $more_addons );
				}
			}
		}	
		return $addons;
	}
	
	function _get_active_addons( $options_varname='rh_options' ){
		$current = $this->get_option( $options_varname, array());
		$current = is_array($current) ? $current : array();
		$addons = isset($current['addons']) && is_array($current['addons']) ? $current['addons'] : array() ;		
		if(count($addons)>0){
			$tmp = array();
			foreach($addons as $a){
				$tmp[]=$a;
			}
			$addons=$tmp;
		}
		return $addons;
	}
	
	function head(){
		wp_register_style('rhpop-bootstrap', 	$this->module_url.'bootstrap/css/bootstrap.namespaced.rhpop.css', array(), '2.3.1');
		wp_print_styles('rhpop-bootstrap');
		
		rh_enqueue_script( 'bootstrap', 		$this->module_url.'bootstrap/js/bootstrap.js', array(),'2.3.1');
		rh_enqueue_script( 'jquery-isotope', 	$this->module_url.'js/jquery.isotope.min.js', array(),'1.5.14');
		wp_print_scripts('bootstrap');
		wp_print_scripts('jquery-isotope');
		
		wp_print_styles('rh-dc');
		wp_print_scripts('rh-dc');
		$rh_bundles = $this->get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
		/*
		$current = $this->get_option($this->options_varname, array());
		$current = is_array($current) ? $current : array();
		$addons = isset($current['addons']) && is_array($current['addons']) ? $current['addons'] : array() ;		
		if(count($addons)>0){
			$tmp = array();
			foreach($addons as $a){
				$tmp[]=$a;
			}
			$addons=$tmp;
		}
		*/
		$addons = $this->get_active_addons();
		
	
		$arr = $this->get_plugins();
		$installed_addons = array_keys($arr);
		$installed_addons = is_array($installed_addons)?$installed_addons:array();		
		$arr = is_array($arr)?$arr:array();
		if( count($arr)>0 ){
			foreach($arr as $i => $a){
				$brr = explode(' ',$a['Version']);
				$arr[$i]['Version'] = $brr[0];	
			}
		}
		
		$paymethods = $this->get_paymethods();
		$alipay = false;
		$bitcoin = false;
		if( false!==$paymethods ){
			$alipay 	= '1'==@$paymethods->ALIPAY?true:false;
			$bitcoin	= '1'==@$paymethods->BITCOIN?true:false;
		}
/*		
echo "<pre>";
print_r($installed_addons);
print_r($arr);
echo "</pre>";		
*/		
?>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script>
var rh_download_panel_id = '<?php echo $this->id?>';
var apiurl = '<?php echo $this->api_url?>';
var rh_license_keys = <?php echo json_encode( $this->license_keys )?>;
var rh_item_ids = <?php echo json_encode($this->get_license_item_ids())?>;
var rh_downloaded = <?PHP echo json_encode($rh_downloaded_bundles)?>;
var rh_filter = '';
var rh_bundles = [];
var rh_active_addons = <?php echo json_encode((array)$addons)?>;
var rh_installed_addons = <?php echo json_encode((array)$installed_addons)?>;
var stripe_public_key = '';
var stripe_item_id = '';
var stripe_coupon = '';
var rh_addon_details = <?php echo json_encode($arr)?>;
var rh_theme = <?php echo $this->theme ? 'true' : 'false' ;?>;
var rh_custom_filter = <?php echo $this->custom_filter ? 'true' : 'false' ;?>;
var dc_updates_available = "<?php _e('You have %s update(s) available for download','pop')?>";
var rh_alipay  = <?php echo $alipay ? 'true' : 'false' ?>;
var rh_bitcoin = <?php echo $bitcoin ? 'true' : 'false' ?>;
jQuery('document').ready(function($){
	get_bundles();
	
	$('#bundles').isotope({
		itemSelector : '.pop-dlc-item',
  		layoutMode : 'fitRows'
		/*,filter : '.letter-a'*/
	});
	
	$('.isotope-filter').on('click',function(e){
		$('.isotope-filter').removeClass('current-cat');
		$(this).addClass('current-cat');
		var filter = $(this).attr('rel');
		$('#bundles').isotope({filter:filter});
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
		$license_keys = $this->get_license_keys();

		if(!is_array($license_keys) || count($license_keys)==0){
			$message = __('Please enter your License Key in the Options Panel to get access to the free add-ons and premium paid add-ons.','pop');
			$message_class='updated';
		}else{
			$message = '';
			$message_class='';		
			
			if( $this->multisite ){
				$message = __('Add-ons will be activated for all sites.','pop');
				$message_class='updated';
			}
		}
		
?>
<div class="wrap">
	<div class="icon32" id="icon-plugins"><br /></div>
	<h2><?php echo $this->page_title?></h2>
	<div id="messages" class="<?php echo $message_class?>"><?php echo $message?></div>
	
	<div id="installing">
		<div id="install-image" class="dc-loading"></div>
		<div id="install-message" class="install-message"></div>
		<div class="clear"></div>
	</div>
	<div class="dc-content">
		<ul class="subsubsub">
			<li><a class="isotope-filter" rel="" href="javascript:void(0);"><?php _e("Downloads",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-recent" href="javascript:void(0);"><?php _e("New",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-update" href="javascript:void(0);"><?php _e("Available Updates",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-installed" href="javascript:void(0);"><?php _e("Installed",'pop')?></a>|</li>
			<li style="display:none;"><a class="isotope-filter" rel=".dlc-not-installed" href="javascript:void(0);"><?php _e("Not installed",'pop')?></a>|</li>
			<li><a class="isotope-filter filter-dlc-addon" rel=".dlc-addon" href="javascript:void(0);"><?php _e("Add-ons",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-downloaded" href="javascript:void(0);"><?php _e("Downloaded",'pop')?></a></li>
		</ul>
		<div class="clear"></div>
			
		<div id="bundles" class="rhpop"></div>		

		<div class="clear"></div>	
	</div>
</div>

<div style="display:none;" id="pop-dlc-item-template">
	<div class="pop-dlc-item show-coupon">
		<h4 class="pop-dlc-name">{name}</h4>
		
		<div class="pop-dlc-details">
			<a class="pop-dlc-image" target="_blank"><img width="135"></a>
			<div class="pop-version-cont">
				<div class="pop-dlc-version-label"><?php _e('Version','pop') ?></div>
				<div class="pop-dlc-version">{version}</div>
			</div>

			<div class="pop-iversion-cont">
				<div class="pop-dlc-iversion-label"><?php _e('Installed','pop') ?></div>
				<div class="pop-dlc-iversion">{version}</div>
			</div>
			
			<div class="pop-filesize-cont">
				<div class="pop-dlc-filesize-label"><?php _e('Size','pop') ?></div>
				<div class="pop-dlc-filesize">{filesize}</div>
			</div>
			
			<div class="pop-price-cont">
				<div class="pop-dlc-price-label"><?php _e('Price','pop') ?></div>
				<div class="pop-dlc-price">{price}</div>
			</div>



			<div class="alert alert-error main-license-message" style="display:none;">
				<?php _e('Enter your license key before you can purchase add-ons or download free add-ons.','pop')?>
			</div>
			<div class="alert alert-error addon-license-message" style="display:none;">
				
			</div>
		</div>		
		
		<div class="pop-dlc-description">{description}</div>
		<div class="pop-clear"></div>
		<div class="dlc-controls">				
			<div class="dlc-row">
				<div class="pop-discount-code">
					<input type="text" class="pop-discount-code-inp" value="" xplaceholder="<?php _e('Discount Code','pop')?>">
					<button type="button" class="btn btn-pop-discount-code">
						<span class="btn-pop-inner">
							<span class="popspinner-holder">
								<span class="popspinner popicon-spinner-10"></span>
							</span>
							<label><?php _e('Apply Coupon','pop')?></label>
						</span>		
					</button>    
				</div>
			</div>
			<div class="dlc-row">
				<div class="pop-purchase-cont">
					<button class="btn btn-success btn-purchased disabled" style="display:none;"><?php _e('Purchased','pop')?></button>
					<button class="btn btn-success btn-buynow coupon-shown" data-panel_label="<?php _e('Checkout','pop')?>" style="display:none;">
						<span class="btn-pop-inner">
							<span class="popspinner-holder">
								<span class="popspinner popicon-spinner-10"></span>
							</span>
							<label><?php _e('Buy now','pop')?></label>
						</span>						
					</button>
				</div>
			</div>
			<div class="dlc-row">
				<a class="btn btn-visit-site" href="#" target="_BLANK"><?php _e('Visit site','pop')?></a>	
				<div class="btn-group dlc-addon-control" data-toggle="buttons-radio">
				  <button type="button" data-toggle="button" class="btn enable-addon"><?php _e('On','pop')?></button>
				  <button type="button" data-toggle="button" class="btn disable-addon"><?php _e('Off','pop')?></button>
				</div>	
				<button class="btn btn-primary btn-download">
					<span class="btn-pop-inner">
						<span class="popspinner-holder">
							<span class="popspinner popicon-spinner-10"></span>
						</span>
						<label data-update="<?php _e('Update','pop')?>"><?php _e('Download','pop')?></label>
					</span>					
				</button>				
			</div>
		</div>
	</div>		
</div>	
<?php	
		/*
		echo "debug<br>";
		$arr = $this->get_plugins();
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		*/
	}	
	
	function get_plugins() {
		$wp_plugins = $this->_get_plugins( $this->resources_path ); //main plugin
		if( is_array( $this->plugin_codes ) && count( $this->plugin_codes ) > 0 ){
			foreach( $this->plugin_codes as $c ){
				$other_plugins = $this->_get_plugins( $c->resources_path );
				if(!empty($other_plugins)){
					$wp_plugins = array_merge( $wp_plugins, $other_plugins );
				}
			}
		}	
		return $wp_plugins;
	}
	
	function _get_plugins( $resources_path ) {
		$upload_dir = $this->wp_upload_dir();
		$plugin_root = $upload_dir['basedir'].'/'.$resources_path;	
		// rewritten version of the one in plugin.php core wordpress 
		$wp_plugins = array ();		
		// Files in wp-content/plugins directory
		$plugins_dir = @ opendir( $plugin_root);
		$plugin_files = array();
		if ( $plugins_dir ) {
			while (($file = readdir( $plugins_dir ) ) !== false ) {
				if ( substr($file, 0, 1) == '.' )
					continue;
				if ( is_dir( $plugin_root.'/'.$file ) ) {
					$plugins_subdir = @ opendir( $plugin_root.'/'.$file );
					if ( $plugins_subdir ) {
						while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
							if ( substr($subfile, 0, 1) == '.' )
								continue;
							if ( substr($subfile, -4) == '.php' )
								$plugin_files[] = "$file/$subfile";
						}
						closedir( $plugins_subdir );
					}
				} else {
					if ( substr($file, -4) == '.php' )
						$plugin_files[] = $file;
				}
			}
			closedir( $plugins_dir );
		}
	
		if ( empty($plugin_files) )
			return $wp_plugins;
	
		foreach ( $plugin_files as $plugin_file ) {
			if ( !is_readable( "$plugin_root/$plugin_file" ) )
				continue;
	
			$plugin_data = get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.
			
			if ( empty ( $plugin_data['Name'] ) )
				continue;
	
			$plugin_data['rh_resources_path'] = $resources_path;
			$wp_plugins[plugin_basename( $plugin_file )] = $plugin_data;
		}
	
		uasort( $wp_plugins, '_sort_uname_callback' );
		
		return $wp_plugins;
	}	
	
	function handle_stripe_token(){
		global $userdata;
		
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
				
		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}

		foreach(array('token','item_id','coupon') as $field){
			$$field = isset($_REQUEST[$field])?$_REQUEST[$field]:false;
			if(false===$$field){
				die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin error.  Missing argument.','pop')."($field)")));
			}
		}		
	
		$license_keys = $this->get_license_keys();
				
		//-------------------------
		$key = array();
		foreach($this->get_license_keys() as $k){
			$key[]=$k;
		}	

		$site = site_url('/');
		$parts = parse_url($site);
		$host = isset($parts['host'])?$parts['host']:$site;
		
		$args = array(
			'timeout'	=> 60,
			'body'		=> array(
				'content_service'	=> 'stripe_checkout',
				'token'				=> $token,
				'item_id'			=> $item_id,
				'coupon'			=> $coupon,
				'site_url'			=> site_url('/'),
				'email'				=> $userdata->user_email,
				'buyer'				=> sprintf('%s@%s',$userdata->user_login, $host ),
				'key'				=> $key
			)
		);

		$request = wp_remote_post( $this->api_url , $args );
		if ( is_wp_error($request) ){
			$message = sprintf( __('There was a communication error with the RightHere server. Contact support at support.righthere.com about payment %s.  Error message: %s','pop'),
				$token,
				$request->get_error_message()	
			);
			$this->send_error( $message );
		}else{
			$response = json_decode($request['body']);			
			if(is_object($response)&&property_exists($response,'R')){
				if($response->R=='OK'){
					$options = $this->get_option($this->options_varname);
					$options['license_keys'] = isset($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'] = is_array($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'][]=$response->LICENSE;
					$this->update_option($this->options_varname,$options);
				}
			
				return $this->send_response($response);
			}else{
				$message = sprintf( __('There was a communication error with the RightHere server. Contact support at support.righthere.com about payment %s.  Error message: %s','pop'),
					$token,
					__('API Server returned an unrecognized format.','pop')
				);
				$this->send_error( $message );
			}		
		}
		//-------------------------
		$this->send_error( __('Service is unavailable, please try again later.','pop') );	
		die();	
	}	
	
	function handle_apply_coupon(){
		global $userdata;
		
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
				
		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}

		foreach(array('coupon','item_id') as $field){
			$$field = isset($_REQUEST[$field])?$_REQUEST[$field]:false;
			if(false===$$field){
				die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin error.  Missing argument.','pop')."($field)")));
			}
		}		
	
		$license_keys = $this->get_license_keys();
				
		//-------------------------
		$key = array();
		foreach($this->get_license_keys() as $k){
			$key[]=$k;
		}	
		
		
		$site = site_url('/');
		$parts = parse_url($site);
		$host = isset($parts['host'])?$parts['host']:$site;
		
		$args = array(
			'timeout'	=> 60,
			'body'		=> array(
				'content_service'	=> 'validate_coupon',
				'coupon'			=> $coupon,
				'item_id'			=> $item_id,
				'site_url'			=> site_url('/'),
				'email'				=> $userdata->user_email,
				'buyer'				=> sprintf('%s@%s',$userdata->user_login, $host ),
				'key'				=> $key
			)
		);		
		
		$request = wp_remote_post( $this->api_url , $args );
		if ( is_wp_error($request) ){
			$message = sprintf( __('There was a communication error with the RightHere server. Coupon %s.  Error message: %s','pop'),
				$coupon,
				$request->get_error_message()	
			);
			$this->send_error( $message );
		}else{
			$response = json_decode($request['body']);
			if(is_object($response)&&property_exists($response,'R')){	
				if( $response->R=='OK' ){
					if( (!property_exists($response,'MSG') || empty($response->MSG) ) && property_exists($response,'PRICE') ){
						if( property_exists( $response, 'COUPON') && property_exists( $response->COUPON, 'expired' ) && 1 == intval( $response->COUPON->expired ) ){
							$this->send_error( __('This code has expired.','pop') );
						}
						
						if( intval($response->PRICE)==0 ){
							$response->MSG = __('Gift certificate applied.  Click Buy Now to continue.','pop');
						}else if( $response->PRICE > 0 ){
							$response->MSG = __('Discount applied.  Click Buy Now to continue.','pop');
						}
					}
				}		
				return $this->send_response($response);
			}else{
				$message = sprintf( __('There was a communication error with the RightHere server. Coupon %s.  Error message: %s','pop'),
					$coupon,
					__('API Server returned an unrecognized format.','pop')
				);
				$this->send_error( $message );
			}		
		}
		//-------------------------
		$this->send_error( __('Service is unavailable, please try again later.','pop') );	
		die();			
	}
	
	function handle_gc(){
		global $userdata;
		
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
				
		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}

		foreach(array('coupon','item_id') as $field){
			$$field = isset($_REQUEST[$field])?$_REQUEST[$field]:false;
			if(false===$$field){
				die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin error.  Missing argument.','pop')."($field)")));
			}
		}		
	
		$license_keys = $this->get_license_keys();
				
		//-------------------------
		$key = array();
		foreach($this->get_license_keys() as $k){
			$key[]=$k;
		}	
		
		
		$site = site_url('/');
		$parts = parse_url($site);
		$host = isset($parts['host'])?$parts['host']:$site;
		
		$args = array(
			'timeout'	=> 60,
			'body'		=> array(
				'content_service'	=> 'gc_checkout',
				'coupon'			=> $coupon,
				'item_id'			=> $item_id,
				'site_url'			=> site_url('/'),
				'email'				=> $userdata->user_email,
				'buyer'				=> sprintf('%s@%s',$userdata->user_login, $host ),
				'key'				=> $key
			)
		);		
		
		$request = wp_remote_post( $this->api_url , $args );
		if ( is_wp_error($request) ){
			$message = sprintf( __('There was a communication error with the RightHere server. Coupon %s.  Error message: %s','pop'),
				$coupon,
				$request->get_error_message()	
			);
			$this->send_error( $message );
		}else{
			$response = json_decode($request['body']);
			if(is_object($response)&&property_exists($response,'R')){	
			
				if($response->R=='OK'){
					$options = $this->get_option($this->options_varname);
					$options['license_keys'] = isset($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'] = is_array($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'][]=$response->LICENSE;
					$this->update_option($this->options_varname,$options);
				}			
					
				return $this->send_response($response);
			}else{
				$message = sprintf( __('There was a communication error with the RightHere server. Coupon %s.  Error message: %s','pop'),
					$coupon,
					__('API Server returned an unrecognized format.','pop')
				);
				$this->send_error( $message );
			}		
		}
		//-------------------------
		$this->send_error( __('Service is unavailable, please try again later.','pop') );	
		die();			
	}	
	
	function get_option( $options_varname, $default='' ){
		if( $this->multisite ){
			return get_site_option( $options_varname, $default );
		}else{
			return get_option( $options_varname, $default );
		}
	}
	
	function update_option( $options_varname, $options ){
		//Note: even though update_site_option fallbacks to update_option on non-multisite, we only want to use update_site_option if attr multisie true.
		if( $this->multisite ){
			update_site_option( $options_varname, $options );
		}else{
			update_option( $options_varname, $options );
		}
	}
	
	function wp_upload_dir( ){
		if( $this->multisite ){
			// return WP_CONTENT_DIR.'/uploads'
			return array(
				'path'		=> WP_CONTENT_DIR.'/uploads',
				'url'		=> WP_CONTENT_URL.'/uploads',
				'subdir'	=> '/',
				'basedir'	=> WP_CONTENT_DIR.'/uploads',
				'baseurl'	=> WP_CONTENT_URL.'/uploads',
				'error'		=> ''
			);
		}else{
			return wp_upload_dir();
		}
	}	
}

endif;
?>