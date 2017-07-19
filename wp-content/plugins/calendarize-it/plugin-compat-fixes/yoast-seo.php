<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class yoast_seo_rhc_fixes {
	var $template_page_id=false;
	function __construct(){
		add_filter('rhc_term_permalink', array(&$this,'rhc_term_permalink'), 10, 3);
		add_action('rhc_taxonomy_template_page_id_set', array(&$this, 'rhc_taxonomy_template_page_id_set'), 10, 2);
	}
	/*
	* The RHC taxonomy page is loaded as a page, but it really is a taxonomy.  This was done so that the taxonomy could
	* benefit of theme template features.
	*/
	function rhc_term_permalink( $term_permalink, $url, $o ){
		$canonical = WPSEO_Taxonomy_Meta::get_term_meta( $o->term, $o->term->taxonomy, 'canonical' );
		if(!empty($canonical)){
			return $canonical;
		}	
		return $term_permlink;
	}
	
	function rhc_taxonomy_template_page_id_set( $template_page_id, $term ){
		$this->template_page_id = $template_page_id;
		$this->term = $term;
		add_filter('wpseo_metadesc', array(&$this,'wpseo_metadesc'), 10, 1);
	}	
	/* this filter is only set when it is an rhc taxonomy using version 2 template */
	function wpseo_metadesc( $metadesc ){
		if( empty($metadesc) ){
			$tax_metadesc = WPSEO_Taxonomy_Meta::get_term_meta( $this->term, $this->term->taxonomy, 'desc' );
			if(!empty($tax_metadesc)){
				return $tax_metadesc;
			}		
		}
		
		return $metadesc;
	}
}

new yoast_seo_rhc_fixes();
?>