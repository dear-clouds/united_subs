<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Boss
 */

?>

<div id="bbpress-forums">

    <div class="subheader"> 
        <div class="row">
            <div class="col-6">
            <?php bbp_breadcrumb(); ?>
            </div>
            <div class="col-6">
            <?php if ( bbp_allow_search() ) : ?>

                <div class="bbp-search-form">

                    <?php bbp_get_template_part( 'form', 'search' ); ?>

                </div>

            <?php endif; ?>
            </div>
        </div>
	</div> 

	<?php bbp_forum_subscription_link(); ?>

	<?php do_action( 'bbp_template_before_forums_index' ); ?>

	<?php if ( bbp_has_forums() ) : ?>

		<?php bbp_get_template_part( 'loop',     'forums'    ); ?>

	<?php else : ?>

		<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_forums_index' ); ?>

</div>
