<?php

/**
 * Description of ecwd_pointers
 *
 * @author mher96
 */
class Ecwd_pointers {

    private $prefix = 'ecwd';
    private $page_url = '';
    private $pointers = array();
    private $page_pointers = array();
    private $pointer_script = array();
    private $meta_key = 'ecwd_calendar_tour';
    private $pointer_text = array();
    
    public function __construct() {
 

        $user_meta = get_user_meta(get_current_user_id(), $this->meta_key);
        if (is_array($user_meta) && empty($user_meta)) {
            $this->set_urls();
            $this->set_pointer_text();
            $this->set_pointers();
            $this->get_page_pointers();
            add_action('wp_ajax_ecwd_wd_tour', array($this, 'dismiss_pointer'));
            add_action('admin_enqueue_scripts', array($this, 'show_pointer'));
        }
    }

    public function dismiss_pointer() {
        update_user_meta(get_current_user_id(), $this->meta_key, '1');        
    }

    private function set_urls() {
        $path_info = pathinfo($_SERVER['REQUEST_URI']);
        $file_name = $path_info['filename'];
        if ($file_name === 'plugins') {
            $this->page_url = 'plugins.php';
        } else {
            $this->page_url = basename($_SERVER['REQUEST_URI']);
        }
    }

    private function get_page_pointers() {
        $post_type = false;
        if (isset($_REQUEST['post']) && intval($_REQUEST['post']) !== 0 && isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') {
            $post_type = get_post_type($_REQUEST['post']);
        }
        foreach ($this->pointers as $id => $options) {
            $t = false;
            if (!isset($options['post_type']) || (isset($options['post_type']) && $post_type === $options['post_type'])) {
                $t = true;
            }
            
            if ($options['page'] === $this->page_url && $t) {               
                $this->page_pointers[$id] = $this->set_pointer_options($id, $options);
            }
        }        
    }

    private function set_pointer_options($pointer_id, $options) {
        $container_id = $this->get_conteiner_id($pointer_id);
        $this->pointer_buttons($container_id, $options);

        $html = '<h3>' . $options['title'] . '</h3>';
        $content = (isset($this->pointer_text [$pointer_id])) ? $this->pointer_text [$pointer_id]: 'No text';
        $html .= '<div style="padding:5px 10px" id="' . $container_id . '">' . $this->pointer_text [$pointer_id] . '</div>';
        return array(
            'selector' => $options['selector'],
            'content' => $html,
            'edge' => $options['edge'],
            'align' => $options['align']
        );
    }

    private function pointer_buttons($container_id, $options) {
        if (isset($options['buttons']) && is_array($options['buttons']) && !empty($options['buttons'])) {
            foreach ($options['buttons'] as $button_class => $button_options) {
                $button = $button_class . '_button';
                $button_class = $this->prefix . '_pointer_' . $button_class;
                $this->add_button_script($button_class, $button_options, $container_id);
                $this->$button($button_class, $button_options, $container_id);
            }

            if (isset($options['display']) && $options['display'] === false) {
                $this->pointer_script[] = '$("#' . $container_id . '").closest(".wp-pointer").hide();';
            }

            if (isset($options['scroll'])) {
                $this->pointer_script[] = 'setTimeout(function(){window.scrollTo(0, $("' . $options['scroll'] . '").offset().top)},1000);';
            }
        }
    }

    //buttons        

    private function next_page_button($button_class, $options, $container_id) {
        $this->pointer_script[] = '$(".' . $button_class . '").on("click",function(){'
                . 'window.location.href="' . $options['url'] . '"'
                . '});';
    }

    private function next_pointer_button($button_class, $options, $container_id) {
        $pointer_conteiner_id = $this->get_conteiner_id($options['pointer_id']);
        $scroll_srcpt = "";
        if (isset($options['scroll'])) {
            $scroll_srcpt = '$(document).scrollTop($("' . $options['scroll'] . '").offset().top);';
        }
        $this->pointer_script[] = '$("#' . $container_id . '").closest(".wp-pointer").find(".' . $button_class . '").on("click",function(){'
                . '$("#' . $pointer_conteiner_id . '") . closest(".wp-pointer") . show();'
                . '$(this).closest(".wp-pointer").hide();'
                . $scroll_srcpt
                . '});';
    }

    private function add_button_script($button_class, $options, $container_id) {
        $button_class = 'class="button-secondary ' . $button_class . '"';
        $element = '$("#' . $container_id . '").closest(".wp-pointer-content").find(".wp-pointer-buttons")';
        $script = "$('<button " . $button_class . ">" . $options['title'] . "</button>').appendTo(" . $element . ");";
        $this->pointer_script[] = $script;
    }

    //show pointers
    public function show_pointer() {
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
        add_action('admin_print_footer_scripts', array($this, 'print_pointer_script'));
    }

    public function print_pointer_script() {        
        ?>
        <script type="text/javascript">
            (function ($) {
                var action = 'ecwd_wd_tour';
        <?php
        foreach ($this->page_pointers as $id => $options) {
            ?>
                    $('<?php echo $options['selector']; ?>').pointer({
                        content: '<?php echo $options['content']; ?>',
                        position: {
                            edge: '<?php echo $options['edge']; ?>',
                            align: '<?php echo $options['align']; ?>'
                        },
                        close: function () {
                            jQuery.post(
                                    ajaxurl, {'action': action},
                            function (response) {

                            });
                        }
                    }).pointer('open');
            <?php
        }
        foreach ($this->pointer_script as $id => $script) {
            echo $script;
        }
        ?>

            })(jQuery);

        </script>
        <?php
    }

    private function get_conteiner_id($pointer_id) {
        return $this->prefix . '_' . $pointer_id;
    }
    
    public function set_pointer_text(){
        $this->pointer_text = array(
            'plugins1' => 'Press Start Tour to learn how to create your first Event Calendar.',
            'plugins2' => 'As a first step go to Calendar section.',
            'calendar' => 'Press Add New Calendar button to start working on your first calendar.',
            'publish_clendar' => 'Provide a title and description(optional) for your calendar. And press Publish button.',
            'organizer2' => 'Go to Organizers section.',
            'organizer' => 'Go to Organizers section.',
            'add_organizer' => 'Press Add New button to add organizer/event planner.',
            'publish_organizer' => 'Provide a title and description(optional) for your organizer. And press Publish button.',
            'venue' => 'Go to Venues section',
            'venue2' => 'Go to Venues section',
            'add_venue' => 'Press Add New button to add event venue/location.',
            'publish_venue' => 'Provide a title and description(optional) for your venue. And press Publish button.',
            'event2' => 'Go to Events section.',
            'event' => 'Go to Events section.',
            'event3' => 'Press Add New button to add an event.',
            'ecwd-display-options-wrap' => 'Provide event start and end dates(From and To).',
            'event_calendar' => 'Assign event to a calendar. Additionaly select event venue and organizer(optional).',
            'publish_event' => 'Provide a title and description(optional) for your event. And press Publish button.',
            'menu-pages' => 'Go to Pages section.',
            'menu-pages2' => 'Go to Pages section.',
            'add-page' => 'Press Add New button to add a Page.',
            'add-shortcode' => 'Click on a calendar icon in visual editor to insert ECWD shortcode to page. Use the tabs to set up your calendar and press Publish button.',
            'view_calendar' => 'Press view page to view your first calendar.'
        );
    }

    public function set_pointers() {
        $this->pointers = array(
            'plugins1' => array(
                'page' => 'plugins.php',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Start',
                        'pointer_id' => 'plugins2'
                    )
                ),
                'title' => 'Click to Start Tour',
                //'content' => 'description',
                'selector' => '#menu-posts-ecwd_event',
                'edge' => 'left',
                'align' => 'center'
            ),
            'plugins2' => array(
                'page' => 'plugins.php',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_calendar'
                    )
                ),
                'title' => 'Create a Calendar',                
                'selector' => '#menu-posts-ecwd_calendar',
                'edge' => 'left',
                'align' => 'center',
                'display'=>false
            ),
            'calendar' => array(
                'page' => 'edit.php?post_type=ecwd_calendar',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'post-new.php?post_type=ecwd_calendar'
                    )
                ),
                'title' => 'Add new calendar',
                //'content' => '',
                'selector' => '.page-title-action',
                'edge' => 'top',
                'align' => 'left',
            ),
            'publish_clendar' => array(
                'page' => 'post-new.php?post_type=ecwd_calendar',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Next',
                        'pointer_id' => 'organizer'
                    )
                ),
                'title' => 'Publish Calendar',
                //'content' => 'description',
                'selector' => '#publishing-action',
                'edge' => 'right',
                'align' => 'left',
            ),
            'organizer2' => array(
                'page' => $this->page_url,
                'post_type' => 'ecwd_calendar',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_organizer'
                    )
                ),
                'title' => 'Create an Organizer',
                //'content' => 'description',
                'selector' => '#menu-posts-ecwd_organizer',
                'edge' => 'left',
                'align' => 'left'
            ),
            'organizer' => array(
                'page' => 'post-new.php?post_type=ecwd_calendar',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_organizer'
                    )
                ),
                'title' => 'Create an Organizer',
                //'content' => 'description',
                'selector' => '#menu-posts-ecwd_organizer',
                'edge' => 'left',
                'align' => 'left',
                'display' => false
            ),
            'add_organizer' => array(
                'page' => 'edit.php?post_type=ecwd_organizer',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'post-new.php?post_type=ecwd_organizer'
                    )
                ),
                'title' => 'Add new organizer',
                //'content' => 'description',
                'selector' => '.page-title-action',
                'edge' => 'top',
                'align' => 'left',
            ),
            'publish_organizer' => array(
                'page' => 'post-new.php?post_type=ecwd_organizer',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Next',
                        'pointer_id' => 'venue'
                    )
                ),
                'title' => 'Publish Organizer',
                //'content' => 'description',
                'selector' => '#publishing-action',
                'edge' => 'right',
                'align' => 'left',
            ),
            'venue' => array(
                'page' => 'post-new.php?post_type=ecwd_organizer',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_venue'
                    )
                ),
                'title' => 'Create a Venue',
                'content' => 'description',
                'selector' => '#menu-posts-ecwd_venue',
                'edge' => 'left',
                'align' => 'left',
                'display' => false
            ),
            'venue2' => array(
                'page' => $this->page_url,
                'post_type' => 'ecwd_organizer',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_venue'
                    )
                ),
                'title' => 'Create a Venue',
                'content' => 'description',
                'selector' => '#menu-posts-ecwd_venue',
                'edge' => 'left',
                'align' => 'left',
            ),
            'add_venue' => array(
                'page' => 'edit.php?post_type=ecwd_venue',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'post-new.php?post_type=ecwd_venue'
                    )
                ),
                'title' => 'Add new venue',
                'content' => 'description',
                'selector' => '.page-title-action',
                'edge' => 'top',
                'align' => 'left'
            ),
            'publish_venue' => array(
                'page' => 'post-new.php?post_type=ecwd_venue',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Next',
                        'pointer_id' => 'event'
                    )
                ),
                'title' => 'Publish Venue',
                'content' => 'description',
                'selector' => '#publishing-action',
                'edge' => 'right',
                'align' => 'left'
            ),
            'event2' => array(
                'page' => $this->page_url,
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_event'
                    )
                ),
                'title' => 'Create an Event',
                'content' => 'description',
                'selector' => '#menu-posts-ecwd_event',
                'edge' => 'left',
                'align' => 'left',
                'post_type' => 'ecwd_venue'
            ),
            'event' => array(
                'page' => 'post-new.php?post_type=ecwd_venue',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=ecwd_event'
                    )
                ),
                'title' => 'Create an Event',
                'content' => 'description',
                'selector' => '#menu-posts-ecwd_event',
                'edge' => 'left',
                'align' => 'left',
                'display' => false
            ),
            'event3' => array(
                'page' => 'edit.php?post_type=ecwd_event',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'post-new.php?post_type=ecwd_event'
                    )
                ),
                'title' => 'Add new Event',
                'selector' => '.page-title-action',
                'edge' => 'left',
                'align' => 'left'
            ),
            'ecwd-display-options-wrap' => array(
               'page' => 'post-new.php?post_type=ecwd_event',
               'buttons' => array(
                   'next_pointer' => array(
                       'title' => 'Next',
                       'pointer_id' => 'event_calendar',
                       'scroll' => '#tagsdiv-ecwd_event_tag'
                   )
               ),
               'title' => 'Pick a Date',
               'selector' => '.ecwd_all_day_event_description',
               'edge' => 'bottom',
               'align' => 'center',
               'scroll' => '#wp-word-count'
           ),
            'event_calendar' => array(
                'page' => 'post-new.php?post_type=ecwd_event',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Next',
                        'pointer_id' => 'publish_event',
                        'scroll' => '#submitdiv'
                    )
                ),
                'title' => 'Assign to Calendar',
                'selector' => '#ecwd_event_calendars_meta',
                'edge' => 'right',
                'align' => 'left',
                'display' => false
            ),
            'publish_event' => array(
                'page' => 'post-new.php?post_type=ecwd_event',
                'buttons' => array(
                    'next_pointer' => array(
                        'title' => 'Next',
                        'pointer_id' => 'menu-pages',
                        'scroll' => '#wpcontent'
                    )
                ),
                'title' => 'Publish Event',
                'selector' => '#publishing-action',
                'edge' => 'right',
                'align' => 'left',
                'display' => false
            ),
            'menu-pages' => array(
                'page' => 'post-new.php?post_type=ecwd_event',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=page'
                    )
                ),
                'title' => 'Create a Page',
                'selector' => '#menu-pages',
                'edge' => 'left',
                'align' => 'left',
                'display' => false
            ),
            'menu-pages2' => array(
                'page' => $this->page_url,
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'edit.php?post_type=page'
                    )
                ),
                'title' => 'Create a Page',
                'selector' => '#menu-pages',
                'edge' => 'left',
                'align' => 'left',
                'post_type' => 'ecwd_event'
            ),
            'add-page' => array(
                'page' => 'edit.php?post_type=page',
                'buttons' => array(
                    'next_page' => array(
                        'title' => 'Next',
                        'url' => 'post-new.php?post_type=page'
                    )
                ),
                'title' => 'Add New',
                'selector' => '.page-title-action',
                'edge' => 'top',
                'align' => 'left',
            ),
            'add-shortcode' => array(
                'page' => 'post-new.php?post_type=page',
                'title' => 'Add shortcode',
                'selector' => '#publishing-action',
                'edge' => 'right',
                'align' => 'left',
            ),
            'view_calendar' => array(
                'page' => $this->page_url,
                'post_type' => 'page',
                'title' => 'View Page',
                'selector' => '#wp-admin-bar-view',
                'edge' => 'top',
                'align' => 'left',
            ),
        );
    }

}
