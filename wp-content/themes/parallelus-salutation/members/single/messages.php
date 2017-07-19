<div class="item-list-tabs no-ajax" id="subnav">
	<ul class="sub-tabs">
		<?php bp_get_options_nav() ?>
	</ul>
</div>
	<?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>

		<div class="message-search"><?php bp_message_search_form(); ?></div>

	<?php endif; ?>
	
<?php if ( 'compose' == bp_current_action() ) : ?>
	<?php locate_template( array( 'members/single/messages/compose.php' ), true ) ?>

<?php elseif ( 'view' == bp_current_action() ) : ?>
	<?php locate_template( array( 'members/single/messages/single.php' ), true ) ?>

<?php else : ?>

	<?php do_action( 'bp_before_member_messages_content' ) ?>

	<div class="messages">
		<?php if ( 'notices' == bp_current_action() ) : ?>
			<?php locate_template( array( 'members/single/messages/notices-loop.php' ), true ) ?>

		<?php else : ?>
			<?php locate_template( array( 'members/single/messages/messages-loop.php' ), true ) ?>

		<?php endif; ?>
	</div>

	<?php do_action( 'bp_after_member_messages_content' ) ?>

<?php endif; ?>
