<?php
/**
 * Load js on appropriate pages only
 */
function bpge_load_js() {
	if ( bp_is_group() && bp_current_action() == 'admin' && bp_action_variable( 0 ) == 'extras' ) {
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'bpge-main', BPGE_URL . '/extra-scripts.js', array( 'jquery' ), BPGE_VERSION );
		// localize js string
		wp_localize_script( 'bpge-main', 'bpge', bpge_get_localized_data() );
	}
}

add_action( 'wp_enqueue_scripts', 'bpge_load_js' );


/**
 * JS translatable strings
 */
function bpge_get_localized_data() {
	return apply_filters( 'bpge_load_js_localized', array(
		'enter_options'     => __( 'Please enter options for this Field', 'buddypress-groups-extras' ),
		'option_text'       => __( 'Option', 'buddypress-groups-extras' ),
		'remove_it'         => __( 'Remove It', 'buddypress-groups-extras' ),
		'apply_set'         => __( 'Do you want to apply this set of fields to all groups on your site?', 'buddypress-groups-extras' ),
		'applied'           => __( 'Applied', 'buddypress-groups-extras' ),
		'close'             => __( 'Close', 'buddypress-groups-extras' ),
		'yes'               => __( 'Yes', 'buddypress-groups-extras' ),
		'no'                => __( 'No', 'buddypress-groups-extras' ),
		'success'           => __( 'Success', 'buddypress-groups-extras' ),
		'success_apply_set' => __( 'This set of fields was successfully applied to all groups on this site.', 'buddypress-groups-extras' ),
		'error'             => __( 'Error', 'buddypress-groups-extras' ),
		'error_apply_set'   => __( 'Unfortunately, there was an error while applying this set of fields. Please try again a bit later or recreate the set from scratch. Be aware, that re-applying this set will double fields for those groups that were successful.', 'buddypress-groups-extras' ),
	) );
}

/**
 * Load css on appropriate pages only
 */
function bpge_load_css() {

	if ( bp_is_group() ) {
		global $bpge;

		if (
			( is_array( $bpge['groups'] ) && in_array( bp_get_current_group_id(), $bpge['groups'] ) ) ||
			( is_string( $bpge['groups'] ) && $bpge['groups'] == 'all' )
		) {
			wp_enqueue_style( 'bpge-main', BPGE_URL . '/extra-styles.css', false, BPGE_VERSION );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'bpge_load_css' );
