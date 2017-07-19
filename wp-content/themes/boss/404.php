<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

get_header(); ?>

	<div id="primary" class="site-content page-full-width">
		<div id="content" role="main">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title">
                        <span><?php _e( '404', 'boss' ); ?></span><span><?php _e( 'error', 'boss' ); ?></span>    
                    </h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Go Back or Maybe try a search?', 'boss' ); ?></p>
                    <a href="#" class="back-btn btn"><i class="fa fa-angle-left"></i></a>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
