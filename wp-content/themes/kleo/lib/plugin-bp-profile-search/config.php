<?php

add_filter( 'bps_templates', 'kleo_bp_search_tpl' );

function kleo_bp_search_tpl( $templates ) {
    $templates = array ( 'members/bps-form-legacy', 'members/bps-form-inline', 'members/bps-form-with-labels' );

    return $templates;
}