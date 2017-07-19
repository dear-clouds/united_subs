
<?php
/**
 * The sidebar containing the Events widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 2.0.4
 */
?>

<!-- if there are widgets in the Events sidebar -->	
<?php if ( is_active_sidebar('events') ) : ?>

        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'events' ); ?>
        </div><!-- #secondary -->

<?php endif; ?>