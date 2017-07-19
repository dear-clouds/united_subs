<?php
/**
 * @author Stergatu Eleni 
 * @version 3 22/10/2013 replace locate_template with bp_locate_template
* v2, 5/9/2013, fix typo blank spaces
 * v1, 28/8/2013
 *  Adds tab in groups for external blog RSS feeds that attach future posts from rss's  to group activity. Requires External Group Blogs plugin (http://wordpress.org/extend/plugins/external-group-blogs/) to by installed.
 */
if (class_exists('BP_Group_Extension')) : // Recommended, to prevent problems during upgrade or when Groups are disabled

    class BP_extgr_rss_tab_tab_Extension extends BP_Group_Extension {

        var $visibility = 'private';
        var $format_notification_function;
        var $enable_edit_item = false;
        var $enable_create_step = false;
        var $admin_metabox_context = 'side'; // The context of your admin metabox. See add_meta_box()
        var $admin_metabox_priority = 'default'; // The priority of your admin metabox. See add_meta_box()

        function __construct() {
            global $bp;
            if (bp_has_activities('action=exb')) {
                global $activities_template;
            }


            $nav_page_name = __('Sorties & News', 'bp-groups-externalblogs');

            $this->name = !empty($nav_page_name) ? $nav_page_name : __('Sorties & News', 'bp-groups-externalblogs');
            $this->slug = 'external-feeds';

            /* For internal identification */
            $this->id = 'group_external-feeds';


            if ($bp->groups->current_group) {
                $num = !empty($activities_template->activity_count) ? $activities_template->activity_count : '0';
                $this->nav_item_name = $this->name . ' <span>' . $num . '</span>';
                $this->nav_item_position = 55;
            }

            $this->admin_name = !empty($nav_page_name) ? $nav_page_name : __('Sorties & News', 'bp-groups-externalblogs');

            $this->admin_slug = 'external-feeds';
        }

        function display() {
            ?>
                        <div class="info-group">
                <h4><?php echo esc_attr($this->name) ?></h4>
                <?php do_action('bp_before_activity_loop'); ?>
                <?php if (bp_has_activities('action=exb')) :
                    ?>

                                <?php /* Show pagination if JS is not enabled, since the "Load More" link will do nothing */ ?>
                                <noscript>
                                <div class="pagination">
                                    <div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
                                    <div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
                                </div>
                                </noscript>

                                    <?php if (empty($_POST['page'])) : ?>

                    <ul id="activity-stream" class="activity-list item-list">
                                            <?php
                                        endif;
                                        while (bp_activities()) : bp_the_activity();
                                            bp_locate_template(array('activity/entry.php'), true, false);
                                        endwhile;
                                        if (bp_activity_has_more_items()) :
                                            ?>
                                            <li class="load-more">
                                                <a href="#more"><?php _e('Load More', 'buddypress'); ?></a>
                                            </li>
                                            <?php
                                        endif;
                                        if (empty($_POST['page'])) :
                                            ?>
                                        </ul>
                                        <?php
                                    endif;
                                else :
                                    ?>
                                    <div id="message" class="info">
                                        <p><?php _e('Sorry, there was no activity found. Please try a different filter.', 'buddypress'); ?></p>
                                    </div>
                                <?php
                                endif;

                                do_action('bp_after_activity_loop');
                                ?>
                                <form action="" name="activity-loop-form" id="activity-loop-form" method="post">
                                    <?php wp_nonce_field('activity_filter', '_wpnonce_activity_filter'); ?>
                                </form>
                        </div>
                        <?php
                    }

    }

    bp_register_group_extension('BP_extgr_rss_tab_tab_Extension');

    /**
     *  * This function will enqueue the components css and javascript files
     * only when the front group  page is displayed
     */
    function extgr_rss_tab_front_cssjs() {
        global $bp;
        //if we're on a group page
        if ($bp->current_component == $bp->groups->slug) {
            wp_register_style('extgr_rss_tab', EXTGR_RSS_TAB_PLUGIN_URL . '/css/style.css');
            wp_enqueue_style('extgr_rss_tab');
        }
    }

    add_action('wp_enqueue_scripts', 'extgr_rss_tab_front_cssjs');
endif;

