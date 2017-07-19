<?php

/*
 * Clients Post type creation class
 *
 */


class Clients_Post_Type extends Post_types {

	public function __construct() {
		$this->labels = array();
		$this->labels['clients'] = array( 'singular' => __( 'Client', 'kleo_framework' ), 'plural' => __( 'Clients', 'kleo_framework' ), 'menu' => __( 'Clients', 'kleo_framework' ) );

		add_action( 'init', array( &$this, 'setup_post_type' ), 7 );
	}

	/**
	 * Setup Clients post type
	 * @since  1.0
	 * @return void
	 */
	public function setup_post_type () {

		$args = array(
			'labels' => $this->get_labels( 'clients', $this->labels['clients']['singular'], $this->labels['clients']['plural'], $this->labels['clients']['menu'] ),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => TRUE,
			'menu_icon' => 'dashicons-businessman',
			'query_var' => true,
			'rewrite' => array( 'slug' => esc_attr( apply_filters( 'kleo_clients_slug', 'clients' ) )),
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 20, // Below "Pages"
			'supports' => array( 'title', 'thumbnail' )
		);

		register_post_type( 'kleo_clients', $args );

		$tag_args = array(
			"label" 						=> _x('Client Tags', 'tag label', "kleo_framework"),
			"singular_label" 				=> _x('Client Tag', 'tag singular label', "kleo_framework"),
			'public'                        => true,
			'hierarchical'                  => false,
			'show_ui'                       => true,
			'show_in_nav_menus'             => false,
			'args'                          => array( 'orderby' => 'term_order' ),
			'query_var' => true
		);

		register_taxonomy( 'clients-tag', 'kleo_clients', $tag_args );

	} // End setup_clients_post_type()

}


$kleo_clients = new Clients_Post_Type();
Kleo::set_module( 'clients', $kleo_clients );