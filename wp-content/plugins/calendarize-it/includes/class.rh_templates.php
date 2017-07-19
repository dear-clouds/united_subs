<?php

/**
 * 
 *
 * based on class-wp-theme.php, would have used that but it is specific to the theme directory.
 **/

class rh_templates {
	var $template_directory;
	function __construct($args){
		//------------
		$defaults = array(
			'template_directory'=> __FILE__
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
	}
	
	function get_template_files($type=''){
		$page_templates = array();
		$files = $this->get_files('php',1);
		foreach ( $files as $file => $full_path ) {
			if ( ! preg_match( '|Template Name:(.*)$|mi', file_get_contents( $full_path ), $header ) )
				continue;
			
			if( ''!=$type){
				if ( ! preg_match( '|Template Type:(.*)$|mi', file_get_contents( $full_path ), $header2 ) )
					continue;			
				if($type!=_cleanup_header_comment( $header2[1] ))
					continue;	
			}
			
			$page_templates[ $file ] = _cleanup_header_comment( $header[1] );
		}	
		return $page_templates;
	}
	
	function get_template_directory(){
		return $this->template_directory;
	}
	
	public function get_files( $type = null, $depth = 0 ) {
		$files = (array) self::scandir( $this->get_template_directory(), $type, $depth );
		return $files;
	}
	
	/**
	 * Scans a directory for files of a certain extension.
	 *
	 * @since 3.4.0
	 * @access private
	 *
	 * @param string $path Absolute path to search.
	 * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
	 * @param int $depth How deep to search for files. Optional, defaults to a flat scan (0 depth). -1 depth is infinite.
	 * @param string $relative_path The basename of the absolute path. Used to control the returned path
	 * 	for the found files, particularly when this function recurses to lower depths.
	 */
	private static function scandir( $path, $extensions = null, $depth = 0, $relative_path = '' ) {

		if ( ! is_dir( $path ) )
			return false;

		if ( $extensions ) {
			$extensions = (array) $extensions;
			$_extensions = implode( '|', $extensions );
		}

		$relative_path = trailingslashit( $relative_path );
		if ( '/' == $relative_path )
			$relative_path = '';

		$results = scandir( $path );
		$files = array();

		foreach ( $results as $result ) {
			if ( '.' == $result[0] )
				continue;
			if ( is_dir( $path . '/' . $result ) ) {
				if ( ! $depth || 'CVS' == $result )
					continue;
				$found = self::scandir( $path . '/' . $result, $extensions, $depth - 1 , $relative_path . $result );
				$files = array_merge_recursive( $files, $found );
			} elseif ( ! $extensions || preg_match( '~\.(' . $_extensions . ')$~', $result ) ) {
				$files[ $relative_path . $result ] = $path . '/' . $result;
			}
		}

		return $files;
	}
}
?>