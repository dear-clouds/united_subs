<?php

/**
 * Topic Tag Edit Content Part
 *
 * @package bbPress
 * @subpackage Boss
 */

?>

<div id="bbpress-forums">

    <div class="bbp-topic-details">
       
        <?php bbp_breadcrumb(); ?>

        <?php bbp_topic_tag_description(); ?>
   
    </div>

	<?php do_action( 'bbp_template_before_topic_tag_edit' ); ?>

	<?php bbp_get_template_part( 'form', 'topic-tag' ); ?>

	<?php do_action( 'bbp_template_after_topic_tag_edit' ); ?>

</div>
