<?php 
/**
 * Momizat sidebars generator
 *
 * @author		Momizat
 * @copyright	Copyright ( c ) Momizat team
 * @link		http://momizat.com
 */

if(basename( $_SERVER['PHP_SELF']) == "widgets.php" ) {
    add_action('admin_head', 'mom_sidebar_generator');
}

function mom_sidebar_generator() {
		wp_enqueue_style( 'mom-sidebar-generator', get_template_directory_uri() . '/framework/sidebars/sidebars.css');
		wp_enqueue_script( 'mom-sidebar-generator', get_template_directory_uri() . '/framework/sidebars/sidebar-generator.js');
		wp_localize_script( 'mom-sidebar-generator', 'mom_admin_ajax', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' ),
		'delete' => __('Delete sidebar', 'theme'),
		'confirm_delete' => __('Do you really want to delete this widget area?', 'theme'),
	)
	);
}
add_action( 'wp_ajax_mom_add_custom_sidebar', 'mom_add_custom_sidebar' );

function mom_add_custom_sidebar() {
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
			$sidebars = get_option('mom_custom_sidebars');
			$rndn = rand(101, 999);
			$sidebars[strtolower(str_replace(' ', '_', $_POST['sidebar_name'])).'_'.$rndn] = $_POST['sidebar_name'];
			update_option('mom_custom_sidebars', $sidebars);

			echo 'success';
			exit();
}

add_action('init', 'mom_display_custom_sidebars' );
function mom_display_custom_sidebars () {
	$sidebars = get_option('mom_custom_sidebars');
	if ($sidebars != false ) {
            $args = array(
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
				'after_widget'  => '</div>', 
				'before_title' => '<div class="widget-title"><h4>',
				'after_title' => '</h4></div>'
				);

	foreach ($sidebars as $key => $sidebar) {
		$args['class'] = 'momizat-custom';
		$args['name'] = $sidebar;
		$args['id'] = $key;
		register_sidebar($args);
	}
	}
}
add_action( 'wp_ajax_mom_delete_custom_sidebar', 'mom_delete_custom_sidebar' );

function mom_delete_custom_sidebar() {
				$nonce = $_POST['nonce'];
				$key = $_POST['key'];
			if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
			$sidebars = get_option('mom_custom_sidebars');
					unset($sidebars[$key]);

			update_option('mom_custom_sidebars', $sidebars);
			exit();


}
