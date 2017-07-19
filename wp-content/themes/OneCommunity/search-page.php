<?php
/*
Template Name: Search Page
*/
?>

<?php get_header(); ?>

	<div id="content">

	<div class="page-title"><?php the_title(); ?></div>

	<form action="<?php echo bp_search_form_action(); ?>" method="post" id="search-form">
		<span id="search-page-border">
		<label class="accessibly-hidden"><?php _e( 'Search for:', 'OneCommunity' ); ?></label>
		<input type="text" class="search-terms" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />
		<?php echo bp_search_form_type_select(); ?>
		</span>
		<input type="submit" name="search-submit" id="search-submit" value="<?php _e( 'Search', 'OneCommunity' ); ?>" />
		<?php wp_nonce_field( 'bp_search_form' ); ?>
	</form><!-- #search-form -->

	</div><!-- #content -->

<?php get_footer(); ?>
