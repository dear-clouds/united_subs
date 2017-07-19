<?php
/**
 * The template for displaying evens listing page of Events Manager plugin
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 2.0.4
 */
get_header(); 
?>

<?php if ( is_active_sidebar('events') ) : ?>
    <div class="page-right-sidebar">
<?php else : ?>
    <div class="page-full-width">
<?php endif; ?>

        <div id="primary" class="site-content">
            
            <div id="content" role="main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php if(!get_option('dbem_display_calendar_in_events_page')): ?>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php 
                            $layout = 'list';
                            if ( !isset( $_COOKIE[ 'events_layout' ] ) ) {
                                if(get_option('dbem_bb_event_list_layout')) {
                                    $layout = 'list';
                                }
                                if(get_option('dbem_bb_event_grid_layout')) {
                                    $layout = 'grid';
                                }
                            } else {
                                $layout = $_COOKIE[ 'events_layout' ];         
                            }
                            ?>
                            <div id="events-switch-layout" class="btn-group">
                                <a href="#" id="list" class="btn <?php echo ( 'list' == $layout )?'active':''; ?>"><span class="fa fa-th-list"></span></a>
                                <a href="#" id="grid" class="btn <?php echo ( 'grid' == $layout )?'active':''; ?>"><span class="fa fa-th"></span></a>
                            </div>
                        </header>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss' ), 'after' => '</div>' ) ); ?>
                        </div><!-- .entry-content -->

                        <footer class="entry-meta">
                            <?php edit_post_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
                        </footer><!-- .entry-meta -->

                    </article><!-- #post -->
                    <?php comments_template( '', true ); ?>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->

    <?php if ( is_active_sidebar('events') ) : 
        get_sidebar('events'); 
    endif; ?>
    </div>
<?php get_footer(); ?>
