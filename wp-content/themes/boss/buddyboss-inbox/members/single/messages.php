<?php
/**
 * BuddyPress - Users Messages
 *
 * @package Boss
 * @subpackage bp-legacy
 */
?>

<div class="messages-container">

	<div id="leftcolumn">

		<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
			<ul>
				<?php bp_get_options_nav(); ?>
			</ul>
		</div><!-- .item-list-tabs -->

		<?php
		$label_feature	 = buddyboss_messages()->option( 'label_feature' );
		$labels			 = BuddyBoss_Inbox_Labels::instance();

		if ( $label_feature ):

			$userlabels			 = bbm_get_user_labels();
			$message_inbox_link	 = bp_displayed_user_domain() . bp_get_messages_slug() . '/inbox/';
			?>

			<div class="bb-labels-wrap">

				<h4 class="bb-label-title"><?php _e( 'Labels', 'boss' ); ?></h4>

				<ul class="bb-label-container">
					<?php foreach ( $userlabels as $label ):
						?>
						<li>
							<a href="<?php echo $message_inbox_link; ?>?label_id=<?php echo $label->bbm_label_id; ?>">
								<span class="bbm-label <?php echo $label->label_class; ?>"></span>
								<span><?php echo $label->label_name; ?> <i class="count">(<?php echo $label->total; ?>)</i></span>
							</a>
						</li>
					<?php endforeach; ?>

					<li class="bb-add-label">
						<input type="text" name="bb-label-name" class="bb-label-name"/>
						<a href="#" class="bb-add-label-button"><i class="fa fa-spinner fa-spin" style="display:none"></i> <?php _e( 'Add Label', 'boss' ); ?></a>
					</li>
				</ul>
			</div>

		<?php endif; ?>

	</div>

	<div id="messages-layout">

		<?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>

			<div class="message-search"><?php bp_message_search_form(); ?></div>

		<?php endif; ?>

		<?php
		switch ( bp_current_action() ) :

			// Inbox/Sentbox
			case 'inbox' :
			case 'sentbox' :
				do_action( 'bp_before_member_messages_content' );
				?>

				<div class="messages" role="main">
					<?php bp_get_template_part( 'members/single/messages/messages-loop' ); ?>
				</div><!-- .messages -->

				<?php
				do_action( 'bp_after_member_messages_content' );
				break;

			// Single Message View
			case 'view' :
				bp_get_template_part( 'members/single/messages/single' );
				break;

			// Compose
			case 'compose' :
				bp_get_template_part( 'members/single/messages/compose' );
				break;

			// Sitewide Notices
			case 'notices' :
				do_action( 'bp_before_member_messages_content' );
				?>

				<div class="messages" role="main">
					<?php bp_get_template_part( 'members/single/messages/notices-loop' ); ?>
				</div><!-- .messages -->

				<?php
				do_action( 'bp_after_member_messages_content' );
				break;

			// Any other
			default :
				bp_get_template_part( 'members/single/plugins' );
				break;
		endswitch;
		?>

	</div>

</div>