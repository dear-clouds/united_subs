<?php

/*
 * Post types creation class
 *
 */


abstract class Post_types {

    protected $labels;

    public function __construct() {
        $this->labels = array();

    }


    /**
     * Create the labels to be used in post type creation
     * @since  1.0
     * @param  string $token    The post type for which to setup labels
     * @param  string $singular Label for singular post type
     * @param  string $plural   Label for plural post type
     * @param  string $menu     Menu item label
     * @return array            Labels array
     */
    protected function get_labels ( $token, $singular, $plural, $menu ) {
        $labels = array(
            'name' => sprintf( _x( '%s', 'post type general name', 'kleo_framework' ), $plural ),
            'singular_name' => sprintf( _x( '%s', 'post type singular name', 'kleo_framework' ), $singular ),
            'add_new' => sprintf( _x( 'Add New %s', $token, 'kleo_framework' ), $singular ),
            'add_new_item' => sprintf( __( 'Add New %s', 'kleo_framework' ), $singular ),
            'edit_item' => sprintf( __( 'Edit %s', 'kleo_framework' ), $singular ),
            'new_item' => sprintf( __( 'New %s', 'kleo_framework' ), $singular ),
            'all_items' => sprintf( __( 'All %s', 'kleo_framework' ), $plural ),
            'view_item' => sprintf( __( 'View %s', 'kleo_framework' ), $singular ),
            'search_items' => sprintf( __( 'Search %s', 'kleo_framework' ), $plural ),
            'not_found' =>  sprintf( __( 'No %s found', 'kleo_framework' ), strtolower( $plural ) ),
            'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'kleo_framework' ), strtolower( $plural ) ),
            'parent_item_colon' => '',
            'menu_name' => sprintf( __( '%s', 'kleo_framework' ), $menu )
          );

        return $labels;
    } // End get_labels()

}

/**
 * Show other post types in tag archive page
 *
 * @param object $query
 * @return object
 */
if (! function_exists( 'kleo_archive_add_custom_types' ) ) {
    function kleo_archive_add_custom_types( $query )
    {
        if (is_tag() && empty($query->query_vars['suppress_filters']) && $query->is_main_query()) {
            $query->set( 'post_type', array('post', 'portfolio', 'product', 'page'));
            return $query;
        }
    }
}
add_filter( 'pre_get_posts', 'kleo_archive_add_custom_types' );