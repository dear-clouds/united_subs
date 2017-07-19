<?php
/*
* @author Alberto Lau alau@albertolau.com 
*/
class pop_importer {
	var $plugin_id;
	var $options_varname;
	var $alt_temp = false;
	function __construct($args=array()){
		$defaults = array(
			'plugin_id'	=> 'pop-importer',
			'options_varname' => 'pop_importer',
			'resources_path'=> 'downloadable_content',
			'alt_temp'	=> false,
			'multisite'	=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	
		//-----------
	}
	
	function get_saved_options(){
		$var = $this->options_varname.'_saved';
		$options = get_option($var);
		return is_array($options)?$options:array();
	}	
	
	function import_option($new_options,$clear_saved_options=false){
		if(!is_array($new_options->options) || count($new_options->options)==0){
			return true;//nothing to import, maybe its only resources.
		}
		if($clear_saved_options){
			$saved_options = array();//this will empty saved options.
		}else{
			$saved_options = $this->get_saved_options();
		}
		$index = $this->get_saved_options_index($new_options,$saved_options);
		$saved_options[$index]=$new_options;
		$var = $this->options_varname.'_saved';
		update_option($var,$saved_options);
		return true;
	}
	
	function get_saved_options_index($new_options, $saved_options){
		if(count($saved_options)==0)return 0;
		if(property_exists($new_options,'bundle')&&''!=trim($new_options->bundle)){
			foreach($saved_options as $index => $s){
				if($s->id==$new_options->id && $s->bundle==$new_options->bundle && $s->version==$new_options->version){
					return $index;//replace if it is the same version.
				}
			}		
		}
		return count($saved_options);
	}
	
	function import_options_from_code($response){
		$code = base64_decode($response->DC->content);
		$data = @unserialize(base64_decode(trim($code)));
		if(false===$data || !property_exists($data,'id')||!property_exists($data,'name')||!property_exists($data,'options')){
			$this->last_error = __('Could not read the imported code, please verify and try again.','pop');
			return false;
		}
		if($data->id!=$this->plugin_id){
			$this->last_error = sprintf(__('The imported code does not belong to this plugin/theme.  Import code id: %s,%s','pop'),$data->id,$this->plugin_id);
			return false;
		}
	
		$data->name 		= @$response->DC->name;
		$data->version		= @$response->DC->version;
		$data->description	= @$response->DC->description;
		$data->url			= @$response->DC->url;
		$data->date			= date('Y-m-d H:i:s');
		$data->type			= @$response->DC->type;
		$data->dc			= true;
		$data->addon_path	= @$response->DC->addon_path;
		$data->image		= @$response->DC->image;
		//---
		$res = $this->import_resources($data);	
		if(false===$res){
			$this->last_error =  __("There was an error extracting the bundled resources.",'pop') . '<br />' . $this->last_error;
			return false;		
		}
		$data->resources = null;
		//---
		$res = $this->import_option($data);
		if( $res ){
			return true;
		}else{
			$this->last_error =  __("There was an error importing the content.",'pop');
			return false;
		}
	}
	
	function import_from_file($path){
		//usually a starter bundle.
		$code = @file_get_contents($path);
		if(false===$code){
			$this->last_error = __("Unable to read bundle file",'pop');
			return false;
		}
		$data = @unserialize(base64_decode(trim($code)));
		if(false===$data || !property_exists($data,'id')||!property_exists($data,'name')||!property_exists($data,'options')){
			$this->last_error = __('Could not read the imported code, please verify and try again.','pop');
			return false;
		}
		if($data->id!=$this->plugin_id){
			$this->last_error = sprintf(__('The imported code does not belong to this plugin/theme.  Import code id: %s,%s','pop'),$data->id,$this->plugin_id);
			return false;
		}	
		//---
		$res = $this->import_resources($data);	
		if(false===$res){
			$this->last_error =  __("There was an error extracting the bundled resources.",'pop') . '<br />' . $this->last_error;
			return false;		
		}
		$data->resources = null;
		//---	
		$res = $this->import_option($data);
		if( $res ){
			return true;
		}else{
			$this->last_error =  __("There was an error importing the content.",'pop');
			return false;
		}				
	}
	
	function import_resources($data){
		if(!property_exists($data,'resources'))return $data;
		if(is_array($data->resources)&&count($data->resources)>0){
			$upload_dir = $this->wp_upload_dir();
			
			$path = $upload_dir['basedir'].'/'.$this->resources_path;
			 //$upload_dir['basedir']
			foreach($data->resources as $content){
				if( $this->alt_temp ){
					//usually uploads is writable, so in the case the systems tmp is giving issues, use uploads. (iis bug).
					$filename = wp_tempnam('addon', trailingslashit( $upload_dir['basedir'] ) );
				}else{
					$filename = wp_tempnam();
				}
			
				if(file_exists($filename)){
					file_put_contents($filename, $content);
					//---
					if(class_exists('ZipArchive')){
					     $zip = new ZipArchive;
					     $res = $zip->open($filename);
					     if ($res === TRUE) {
					        $zip->extractTo($path);
					        $zip->close();
							@unlink($filename);
					     	return true;
						 } 						
					}else{
						$to = $path . '/';
						if(!is_dir($path)){
							mkdir($path);
						}
					
						require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
						$archive = new PclZip($filename);
						$files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING);
						
						foreach ( $files as $file ) {
							if ( '__MACOSX/' === substr($file['filename'], 0, 9) ) 
								continue;
						
							$needed_dirs[] = $to . untrailingslashit( $file['folder'] ? $file['filename'] : dirname($file['filename']) );
						}						

						$needed_dirs = array_unique($needed_dirs);
						foreach ( $needed_dirs as $dir ) {
							// Check the parent folders of the folders all exist within the creation array.
							if ( untrailingslashit($to) == $dir ) // Skip over the working directory, We know this exists (or will exist)
								continue;
							if ( strpos($dir, $to) === false ) // If the directory is not within the working directory, Skip it
								continue;
						
							$parent_folder = dirname($dir);
							while ( !empty($parent_folder) && untrailingslashit($to) != $parent_folder && !in_array($parent_folder, $needed_dirs) ) {
								$needed_dirs[] = $parent_folder;
								$parent_folder = dirname($parent_folder);
							}
						}
						asort($needed_dirs);
						
						foreach ( $needed_dirs as $_dir ) {
							if(is_dir($_dir))continue;
							if(!mkdir($_dir)){
								$this->last_error .= sprintf(__('Unable to create directory %s','pop'),$_dir);
								@unlink($filename);
								return false;
							}
						}
					
						$last_file = false;	
						foreach($files as $file){
							if ( $file['folder'] )
								continue;
					
							if ( '__MACOSX/' === substr($file['filename'], 0, 9) ) // Don't extract the OS X-created __MACOSX directory files
								continue;	
							
							$this->last_error .= $path . '/' .$file['filename']."<BR />";							
							
							$last_file = $path . '/' .$file['filename'];
							file_put_contents($path . '/' .$file['filename'], $file['content']);
						}
						
						@unlink($filename);
						return file_exists($last_file)?true:false;
					}
				}else{
					$this->last_error = __("Could not create temporary file",'pop');
				}
				
			}
		}
		return false;
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
?>