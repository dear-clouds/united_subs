<?php
/**
 * Template Name: Right Sidebar Sensei
 *
 * Description: Use this page template for a page with a right sidebar.
 *
 * @package WordPress
 * @subpackage Boss for Sensei
 * @since Boss for Sensei 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $boss_sensei;

get_header(); ?>

<?php if ( is_active_sidebar('sensei-courses') ) : ?>
    <div class="page-right-sidebar">
<?php else : ?>
    <div class="page-full-width">
<?php endif; ?>

        <div id="primary" class="site-content">

            <div id="content" role="main">

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', 'page' ); ?>
                    <?php comments_template( '', true ); ?>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->

    <?php if ( is_active_sidebar('sensei-courses') ) : 
        $boss_sensei->boss_edu_load_template('sidebar-sensei-courses');
    endif; ?>
    </div>
<?php get_footer(); ?>