<?php if (!defined('FW')) die('Forbidden');

/**
 * @internal
 */
function woffice_filter_custom_portfolio_tax_slug($slug) {
    return 'works';
}
add_filter('fw_ext_portfolio_taxonomy_slug', 'woffice_filter_custom_portfolio_tax_slug');