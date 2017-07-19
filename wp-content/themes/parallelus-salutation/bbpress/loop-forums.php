<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_forums_loop' ); ?>
	<div class="forum-list-container item-container">
		<table class="bbp-forums">
	
			<thead>
				<tr>
					<th class="bbp-forum-info"><?php _e( 'Forum', 'bbpress' ); ?></th>
					<?php /*?><th class="bbp-forum-topic-count"><?php _e( 'Topics', 'bbpress' ); ?></th><?php */?>
					<?php /*?><th class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></th><?php */?>
					<?php /*?><th class="bbp-forum-freshness"><?php _e( 'Freshness', 'bbpress' ); ?></th><?php */?>
				</tr>
			</thead>
	
			<?php /*?><tfoot>
				<tr><td colspan="4">&nbsp;</td></tr>
			</tfoot><?php */?>
	
			<tbody>
	
				<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
	
					<?php bbp_get_template_part( 'bbpress/loop', 'single-forum' ); ?>
	
				<?php endwhile; ?>
	
			</tbody>
	
		</table>
	</div>

	<?php do_action( 'bbp_template_after_forums_loop' ); ?>
