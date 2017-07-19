<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>

<div class="entry-buddypress-content">
    <?php the_content(); ?>
</div>

<footer class="entry-meta">
    <?php edit_post_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-meta -->

