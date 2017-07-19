<?php

/**

 * The template for displaying 404 pages (Not Found).

 */


get_header(); ?>

<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content">

<div class="container">

    <div class="content-left-wrap col-md-12">

        <div id="primary" class="content-area">

            <main id="main" class="site-main" role="main">



            <article>

                <header class="entry-header">

                    <h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'zblackbeard' ); ?></h1>

                </header><!-- .entry-header -->



                <div class="entry-content">

                    <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'zblackbeard' ); ?></p>

                    <?php get_search_form(); ?>


                </div><!-- .entry-content -->

            </article><!-- #post-## -->



            </main><!-- #main -->

        </div><!-- #primary -->

    </div>


</div>

<?php get_footer(); ?>