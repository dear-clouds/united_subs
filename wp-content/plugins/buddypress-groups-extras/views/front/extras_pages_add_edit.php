<div class="box_page">
	<p>
		<label><?php _e( 'Page Title', 'buddypress-groups-extras' ); ?></label>
		<input type="text" value="<?php echo esc_attr( $page->post_title ); ?>" name="extra-page-title">
	</p>

	<?php if ( $is_edit ) : ?>
		<p>
			<label><?php _e( 'Page Slug', 'buddypress-groups-extras' ); ?></label>
			<input type="text" value="<?php echo $page->post_name; ?>" name="extra-page-slug">
		</p>
	<?php endif; ?>

	<p style="margin:0;">
		<label><?php _e( 'Page Content', 'buddypress-groups-extras' ); ?></label>
		<?php
		if ( function_exists( 'wp_editor' ) && $enabled_re ) :
			wp_editor(
				$page->post_content, // initial content
				'post_content', // ID attribute value for the textarea
				array(
					'media_buttons' => false,
					'textarea_name' => 'extra-page-content',
				)
			);
		else : ?>
			<textarea name="extra-page-content" id="post_content"><?php echo esc_textarea( $page->post_content ); ?></textarea>
		<?php endif; ?>
	</p>

	<?php do_action( 'bpge_template_extras_page_manage_after_content', $page, $is_edit ); ?>

	<p>
		<label for="extra-page-display"><?php _e( 'Should this page be displayed for public in group navigation?', 'buddypress-groups-extras' ); ?></label>
		<label>
			<input type="radio" value="publish" <?php echo checked( $page->post_status, 'publish' ); ?> name="extra-page-status"/>&nbsp;
			<?php _e( 'Display it', 'buddypress-groups-extras' ); ?>
		</label>
		<label>
			<input type="radio" value="draft" <?php echo checked( $page->post_status, 'draft' ); ?> name="extra-page-status"/>&nbsp;
			<?php _e( 'Do NOT display it', 'buddypress-groups-extras' ); ?>
		</label>
	</p>

	<?php do_action( 'bpge_page_manage', $page, $is_edit ); ?>

	<div class="clear"></div>

	<?php if ( ! $is_edit ) : ?>
		<p>
			<input type="submit" name="save_pages_add" id="save" value="<?php _e( 'Create New', 'buddypress-groups-extras' ); ?>"/>
		</p>
	<?php else: ?>
		<input type="hidden" name="extra-page-id" value="<?php echo (int) $page->ID; ?>"/>
		<p>
			<input type="submit" name="save_pages_edit" id="save" value="<?php echo __( 'Save Changes', 'buddypress-groups-extras' ); ?>"/>
		</p>
	<?php endif; ?>

</div>
