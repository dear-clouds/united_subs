<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>


<div <?php bbp_reply_class(); ?> id="post-<?php bbp_reply_id(); ?>">

	<div class="bbp-reply-author">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php 
		if (class_exists('userpro_api')) {
		/* Integrating UserPro */
		global $userpro;
		$link = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $userpro->permalink( bbp_get_reply_author_id() ), 
		bbp_get_reply_author_link( array( 'sep' => '', 'show_role' => true, 'size' => 65 ) ) );
		echo $link . userpro_show_badges( bbp_get_reply_author_id() );
		} else {
		bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'avatar', 'size' => 65 ) ); 
		}
		?>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

<!--			<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>
-->
			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content">

		<div class="mom-bbp-reply-author mom-main-font">
			<span class="mom-main-color">
			<?php if (class_exists('userpro_api')) {
			/* Integrating UserPro */
			global $userpro;
			$link = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $userpro->permalink( bbp_get_reply_author_id() ), 
			bbp_get_reply_author_link(  array( 'sep' => '', 'size' => 0 ) ) );
			echo $link . userpro_show_badges( bbp_get_reply_author_id() );
			} else {
			bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'name' ) );
			} 
			?>
			</span> <?php _e('on:','framework'); ?> <?php bbp_reply_post_date(); ?>
			<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink alignright">#<?php bbp_reply_id(); ?></a>
		</div>
		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>
				<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		<?php bbp_reply_admin_links(); ?>

		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>


	</div><!-- .bbp-reply-content -->

</div><!-- .reply -->
