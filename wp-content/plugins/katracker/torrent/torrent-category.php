<?php

// Torrent Categories Registration /////////////////////////////////////////////////////////////////

// Register custom categories for torrents
add_action( 'init', 'register_torrent_category' );

add_action( KATRACKER_CATEGORY . '_add_form_fields', function () {
	?>
	<div class="form-field">
			<label for="term_meta[second_name]"><?php _e( 'Name in another language', 'katracker' ); ?></label>
			<input type="text" name="term_meta[second_name]" id="term_meta[second_name]" class="regular-text" style="width:60%;"><br/>
			<span class="description"><?php _e( 'Category name in another language', 'katracker' ); ?></span>
	</div>
	<?php
} );

add_action( KATRACKER_CATEGORY . '_edit_form_fields', function ($tag) {
	$term_meta = get_option( 'taxonomy_' . $tag->term_id );
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="second_name"><?php _e( 'Name in another language', 'katracker' ); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[second_name]" id="term_meta[second_name]" class="regular-text" style="width:60%;" value="<?php echo $term_meta['second_name'] ? $term_meta['second_name'] : ''; ?>"><br/>
			<span class="description"><?php _e( 'Category name in another language', 'katracker' ); ?></span>
		</td>
	</tr>
	<?php
} );

add_action( 'edited_' . KATRACKER_CATEGORY, 'save_torrent_category_meta' );
add_action( 'create_' . KATRACKER_CATEGORY, 'save_torrent_category_meta' );

/**
 * Helper function to save the given category metadata
 *
 * @param int $term_id the given category id
 */
function save_torrent_category_meta( $term_id ) {
	$new_term_meta = $_POST['term_meta'];
	
	if ( isset( $new_term_meta ) ) {
		$term_meta = get_option( 'taxonomy_' . $term_id );
		
		foreach ( $new_term_meta as $key => $value ) {
			$term_meta[$key] = sanitize_meta( $key, $value, 'category' );
		}

		update_option( 'taxonomy_' . $term_id, $term_meta );
	}
}

?>
