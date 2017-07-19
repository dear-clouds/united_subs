<?php
/**
 * The Template for displaying all single events.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 2.0.4
 */

//include plugin.php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Check whether the Events Manager plugin is active and
 * load The single event template
 */
if ( ! is_plugin_active( 'events-manager/events-manager.php' ) ) :

    locate_template( 'single.php', true );

else :

get_header(); ?>

<?php if ( is_active_sidebar('events') ) : ?>
    <div class="page-right-sidebar">
<?php else : ?>
    <div class="page-full-width">
<?php endif; ?>

        <div id="primary" class="site-content">

            <div id="content" role="main">

                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php
                            $html = ''; 
                            $event = em_get_event(get_the_ID());
                            $location = em_get_location($event->location_id);
                            $date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format'):get_option('date_format');
                            if( $event->event_start_date != $event->event_end_date){
                                $html .= date_i18n($date_format, $event->start). get_option('dbem_dates_separator') . date_i18n($date_format, $event->end);
                            }else{
                                $html .= date_i18n($date_format, $event->start);
                            }
                            $html .= '<span>'.__(' @ ', 'boss').'</span>';
                            if( !$event->event_all_day ){
                                $time_format = ( get_option('dbem_time_format') ) ? get_option('dbem_time_format'):get_option('time_format');
                                if($event->event_start_time != $event->event_end_time ){
                                    $html .= date_i18n($time_format, $event->start). get_option('dbem_times_separator') . date_i18n($time_format, $event->end);
                                }else{
                                    $html .= date_i18n($time_format, $event->start);
                                }
                            }else{
                                $html .= get_option('dbem_event_all_day_message');
                            }
                            ?>
                            <p class="event-time"><?php echo $html; ?></p>
                            <?php
                            $properties = array('name', 'address', 'town', 'state');
                            $location_values = array();
                            foreach( $properties as $property ){
                                $value = $location->{'location_'.$property};
                                if($value) {
                                    array_push($location_values, $value);
                                }
                            }
                            ?>
                            <p class="event-location"><?php echo implode(", ", $location_values); ?></p>
                        </header><!-- .entry-header -->
                        <div class="entry-content">
                        <?php the_content(); ?>
                        </div>
                        
                        <footer class="entry-footer">
                            <?php edit_post_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
                        </footer>
                    </article>
                    <?php comments_template( '', true ); ?>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->

    <?php if ( is_active_sidebar('events') ) : 
        get_sidebar('events'); 
    endif; ?>
    </div>
    
<?php get_footer(); ?>

<?php endif; ?>