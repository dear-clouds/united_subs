<?php
/**
 * The template for displaying search forms in Boss
 *
 * @package Boss
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-wrapper">
        <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'boss' ); ?></label>
        <input type="text" value="" name="s" id="s">
        <button type="submit" id="searchsubmit" title="<?php _e( 'Search', 'boss' ); ?>"><i class="fa fa-search"></i></button>
        <button id="search-close"><i class="fa fa-close"></i></button>
    </div>
</form>			

