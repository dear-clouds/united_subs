<?php
/**
 * Search
 *
 * @package bbPress
 * @subpackage Boss
 */
?>

<form role="search" method="get" id="bbp-search-index-form" action="<?php bbp_search_url(); ?>">
	<label class="bbp-search-label" for="bbp_search">
		<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="<?php _e( 'Search Forums...', 'boss' ); ?>" />
	</label>

	<input tabindex="<?php bbp_tab_index(); ?>" class="button" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'boss' ); ?>" />
</form>