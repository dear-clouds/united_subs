<?php

// Media Library Integrations //////////////////////////////////////////////////////////////////////

// Add custom fields to torrent media type
add_filter( "attachment_fields_to_edit", function ( $form_fields, $post ) {
	// if file is not torrent, do nothing
	if ( get_post_mime_type() != 'torrent/torrent' ) {
		return $form_fields;
	}

	// get the torrent metadata
	$torrent_metadata = get_torrent_meta( $post->ID );

	// check if torrent hash is valid, if not disable torrent metadata options
	if ( !katracker_valid_hash_info( $torrent_metadata['hash-info'] ) ) {
		$form_fields['track'] = array(
			'input'  => 'html',
			'html'   => '<span class="katracker-error">'.__( 'Error: Hash info contains null bytes! ', 'katracker' ).'</span>'
		);
		return $form_fields;
	}

	// add magnet link button
	$form_fields['magnet'] = array(
		'label'  => '<a href="' . katracker_magnet_url( $post->ID ) . '" class="button button-big">'.__( 'Magnet Link', 'katracker' ).'</a>',
		'input'  => 'html',
		'html'   => '<p></p>'
	);

	// add static shortcode field
	$form_fields['shortcode'] = array(
		'label'  => __( 'Shortcode', 'katracker' ),
		'input'  => 'html',
		'html'   => '<input readonly class="normal-text code" type="text" onClick="this.select();" value=\'' . generate_torrent_shortcode( $post->ID ) . '\'/>'
	);

	// tracking individual option
	$form_fields['track'] = array(
		'label'  => '<span class="'.( $torrent_metadata['track'] ? 'katracker-active' : 'katracker-inactvie' ).';">'.__( 'Enable tracking for this torrent', 'katracker' ).'</span>',
		'input'  => get_katracker_option( 'open-tracker' ) ? 'hidden' : 'html',
		'value'  => $torrent_metadata['track'],
		'html'   => '<input type="hidden" value="0" name="attachments[' . $post->ID . '][track]" />'.
		            '<input type="checkbox" value="1" name="attachments[' . $post->ID . '][track]" id="attachments[' . $post->ID . '][track]" '.checked( $torrent_metadata['track'], 1, false ).'/>'
	);

	// option to mark the torrent as "bonus" torrent
	$form_fields['bonus'] = array(
		'label'  => __( 'Bonus Torrent', 'katracker' ),
		'input'  => 'html',
		'html'   => '<input type="hidden" value="0" name="attachments[' . $post->ID . '][bonus]" />'.
		            '<input type="checkbox" value="1" name="attachments[' . $post->ID . '][bonus]" id="attachments[' . $post->ID . '][bonus]" '.( $torrent_metadata['bonus'] ? 'checked' : '' ).'/>'
	);

	// list torrent labels
	$katracker_labels = '<option value="Default">'.__( 'Default', 'katracker' ).'</option>';
	if ( !is_null( get_katracker_option( 'labels' ) ) ) {
		foreach( explode( ',', get_katracker_option( 'labels' ) ) as $katracker_label ) {
			$katracker_labels .= '<option value="'.$katracker_label.'" '.selected( $katracker_label, $torrent_metadata['label'], false ).'>'.$katracker_label.'</option>';
		}
	}
	
	// add labels dropdown
	$form_fields['labels'] = array(
		'label' => __( 'Label', 'katracker' ),
		'input' => 'html',
		'html' => '<select name="attachments[' . $post->ID . '][labels]" id="' . KATRACKER_META_PREFIX . 'types_select">' .
		          	$katracker_labels .
		          '</select>'
	);

	// get torrent thumbnail
	$katracker_thumb = wp_get_attachment_image( $torrent_metadata['thumbnail'], array( 100,100 ), false, array( 'class' => 'wp-post-image', 'style' => 'display:block;' ) );

	// add Choose Thumbnail and Edit Image buttons
	$form_fields['thumb'] = array(
		'label'  => __( 'Torrent Thumbnail', 'katracker' ),
		'input'  => 'html',
		'html'   => '<input type="number" name="attachments[' . $post->ID . '][thumb]" id="' . KATRACKER_PREFIX . 'thumb" style="display: none;" value="' . $torrent_metadata['thumbnail'] . '" />' .
		            '<button type="button" id="' . KATRACKER_PREFIX . 'thumb_button" class="button" style="width:120px;height:auto;padding:9px;display:block;" title="' . __( 'Choose Thumbnail', 'katracker' ).'">' .
		            '<span class="button button-link katracker-thumbnail-button ' . ( $katracker_thumb ? 'katracker-hidden' : '' ) . '">' . __( 'Add' ).'</span>' .
		            	( $katracker_thumb ? $katracker_thumb : '<img class="wp-post-image katracker-torrent-image" width=100 height=100>' ).
		            '</button>'.
		            '<a class="thickbox button" style="display:'. ( $katracker_thumb ? 'inline-block' : 'none' ) . ';width:60px;text-align:center;padding:0;" target="_blank" id="' . KATRACKER_PREFIX . 'edit_thumb" href="' . get_edit_post_link( $torrent_metadata['thumbnail'] ) . '">' .
		            	__( 'Edit' ) .
		            '</a>' .
		            '<a class="thickbox button" style="display:' . ( $katracker_thumb ? 'inline-block' : 'none' ) . ';width:60px;text-align:center;padding:0;" id="' . KATRACKER_PREFIX . 'remove_thumb" href="javascript:void( 0 )">' .
		            	__( 'Remove' ) .
		            '</a>'
	);

	// add torrent info meta box
	add_meta_box(
		KATRACKER_PREFIX . 'torrent_content',
		__( 'Torrent Information', 'katracker' ),
		'print_torrent_info',
		'attachment',
		'normal',
		'high'
	);

	return $form_fields;
} , 15, 2 );

// loads the image management javascript
add_action( 'admin_enqueue_scripts', function () {
	if ( get_post_mime_type( get_the_id()) != 'torrent/torrent' ) return;
	wp_enqueue_media();

	// registers and enqueues the required javascript.
	wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'thumbnail.min.js', array( 'jquery' ) );
	wp_localize_script( 'meta-box-image', 'meta_image', array(
			'title' => __( 'Choose or Upload an Image', 'katracker' ),
			'button' => __( 'Choose Image', 'katracker' ),
		) );
	wp_enqueue_script( 'meta-box-image' );
} );

// add on save actions for the torrent
add_filter( 'attachment_fields_to_save', function ( $post, $attachment ) {
	if ( get_post_mime_type( $post['ID'] ) != 'torrent/torrent' ) return $post;

	$torrent = new TorrentFile( get_attached_file( $post['ID'] ));
	if ( $attachment['category'] = get_term( end( $post['tax_input'][KATRACKER_CATEGORY] ), KATRACKER_CATEGORY ) ){
		update_torrent_meta( $post['ID'], 'category', $attachment['category'] );
	}
	update_torrent_meta( $post['ID'], 'label', $attachment['labels'] );
	update_torrent_meta( $post['ID'], 'bonus', $attachment['bonus'] );
	update_torrent_meta( $post['ID'], 'thumbnail', $attachment['thumb'] );
	update_torrent_meta( $post['ID'], 'announce', $attachment['announce'] );
	$torrent->announce( explode( PHP_EOL, $attachment['announce'] ) );
	update_torrent_meta( $post['ID'], 'comment', $attachment['comment'] );
	$torrent->comment( $attachment['comment'] );
	update_post_meta( $post['ID'], '_wp_attachment_image_alt', $attachment['thumb'] );

	$torrent->save( get_attached_file( $post['ID'] ));

	wp_update_post( array(
	                	'ID' => $post['ID'],
	                	'post_status' => 'publish'
	                ) );

	if ( !isset( $attachment['track'] ) ) $attachment['track'] = $attachment['track'];
	$attachment['track'] ? track_katracker_torrent( $post['ID'] ) : untrack_katracker_torrent( $post['ID'] );

	return $post;
}, 10, 2 );

// Load styles for for admin torrent management
add_action( 'admin_enqueue_scripts', function () {
	wp_register_style( 'katracker-torrent-edit-style', plugins_url( 'torrent-style.css', __FILE__ ) );
	wp_enqueue_style( 'katracker-torrent-edit-style' );
} );



/**
 * Helper funcion - prints a given torrent info
 * @param int $torent_id the given torrent id
 */
function print_torrent_info( $torrent_id ) {
	if ( is_object( $torrent_id ) ) $torrent_id = $torrent_id->ID;
	$torrent_data = array(
		array(
			__( 'Name' ),
			'name',
			'code',
			get_torrent_meta( $torrent_id, 'name' )
		),
		array(
			__( 'Hash Info', 'katracker' ),
			'hash-info',
			'code',
			get_torrent_meta( $torrent_id, 'hash-info' )
		),
		array(
			__( 'Leechers', 'katracker' ),
			'leechers',
			'code',
			get_torrent_meta( $torrent_id, 'leechers' )
		),
		array(
			__( 'Seeders', 'katracker' ),
			'seeders',
			'code',
			get_torrent_meta( $torrent_id, 'seeders' )
		),
		array(
			__( 'Hits', 'katracker' ),
			'hits',
			'code',
			get_torrent_meta( $torrent_id, 'hits' )
		),
		array(
			__( 'Piece Length', 'katracker' ),
			'piece-length',
			'code',
			TorrentFile::format( get_torrent_meta( $torrent_id, 'piece-length' ) )
		),
		array(
			__( 'Total Size', 'katracker' ),
			'size',
			'code',
			TorrentFile::format( get_torrent_meta( $torrent_id, 'size' ))
		),
		array(
			__( 'Announces', 'katracker' ),
			'announce',
			'urlfield code',
			get_torrent_meta( $torrent_id, 'announce' ),
			true,
		),
		array(
			__( 'Comment', 'katracker' ),
			'comment',
			'code',
			get_torrent_meta( $torrent_id, 'comment' ),
			true
		),
	);
	foreach( $torrent_data as $data ): ?>
		<label for="torrent_data_<?php echo $data[1]; ?>"><?php echo $data[0]; ?></label>
		<?php if ( isset( $data[4] ) ): ?>
			<textarea name="attachments[<?php echo $torrent_id; ?>][<?php echo $data[1]; ?>]" id="torrent_data_<?php echo $data[1]; ?>" class="widefat <?php echo $data[2]; ?>" type="text"><?php echo $data[3]; ?></textarea>
		<?php else: ?>
			<input readonly="readonly" name="torrent_data_<?php echo $data[1]; ?>" id="torrent_data_<?php echo $data[1]; ?>" class="widefat <?php echo $data[2]; ?>" onClick="this.select();" type="text" value="<?php echo $data[3]; ?>"></input>
		<?php endif;
	endforeach;
	// loop through the torrent files and generate info table ?>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e( 'File Name', 'katracker' ); ?></th>
				<th><?php _e( 'Size', 'katracker' ); ?></th>
				<th><?php _e( 'First Piece', 'katracker' ); ?></th>
			</tr>
		</thead>
		<tbody class="widefat list-table">
		<?php $size = 0;
		foreach ( get_torrent_meta( $torrent_id, 'files' ) as $path => $offset ): ?>
			<tr>
				<td><?php echo basename( $path ); ?></td>
				<td><?php echo TorrentFile::format( $offset['size'] - $size ); ?></td>
				<td><?php echo $offset['startpiece']; ?></td>
			</tr>
		<?php $size = $offset['size'];
		endforeach; ?>
		</tbody>
	</table>
	<?php
}

?>
