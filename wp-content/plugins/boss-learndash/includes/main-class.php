<?php
/**
 * @package WordPress
 * @subpackage Boss for LearnDash
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Boss_Learndash_Plugin' ) ):
/**
 *
 * Boss for LearnDash Plugin Main Controller
 * **************************************
 *
 *
 */
class Boss_Learndash_Plugin
{
    /* Version
     * ===================================================================
     */

    /**
     * Plugin codebase version
     * @var string
     */
    public $version = '1.0.0';

    /* Paths
     * ===================================================================
     */

    public $plugin_dir = '';
    public $plugin_url = '';
    public $lang_dir = '';
    public $templates_dir = '';
    public $templates_url = '';
    public $assets_dir = '';
    public $assets_url = '';
    private $data;
    protected $page_templates;


	/* Singleton
	 * ===================================================================
	 */

	/**
	 * Main Boss for LearnDash Instance.
	 *
	 * Boss for LearnDash is great
	 * Please load it only one time
	 * For this, we thank you
	 *
	 * Insures that only one instance of Boss for LearnDash exists in memory at any
	 * one time. Also prevents needing to define globals all over the place.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 *
	 * @static object $instance
	 * @uses Boss_Learndash_Plugin::setup_globals() Setup the globals needed.
	 * @uses Boss_Learndash_Plugin::setup_actions() Setup the hooks and actions.
	 * @uses Boss_Learndash_Plugin::setup_textdomain() Setup the plugin's language file.
	 * @see buddyboss_education()
	 *
	 * @return Boss for LearnDash The one true BuddyBoss.
	 */
	public static function instance()
	{
		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been run previously
		if ( null === $instance )
		{
			$instance = new Boss_Learndash_Plugin;
			$instance->setup_globals();
			$instance->setup_actions();
			$instance->setup_textdomain();
		}

		// Always return the instance
		return $instance;
	}

	/* Magic Methods
	 * ===================================================================
	 */

	/**
	 * A dummy constructor to prevent Boss for LearnDash from being loaded more than once.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @see Boss_Learndash_Plugin::instance()
	 * @see buddypress()
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * A dummy magic method to prevent Boss for LearnDash from being cloned.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'boss-learndash' ), '1.0.0' ); }

	/**
	 * A dummy magic method to prevent Boss for LearnDash from being unserialized.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'boss-learndash' ), '1.0.0' ); }

	/**
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __isset( $key ) { return isset( $this->data[$key] ); }

	/**
	 * Magic method for getting Boss for LearnDash varibles.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __get( $key ) { return isset( $this->data[$key] ) ? $this->data[$key] : null; }

	/**
	 * Magic method for setting Boss for LearnDash varibles.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __set( $key, $value ) { $this->data[$key] = $value; }

	/**
	 * Magic method for unsetting Boss for LearnDash variables.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __unset( $key ) { if ( isset( $this->data[$key] ) ) unset( $this->data[$key] ); }

	/**
	 * Magic method to prevent notices and errors from invalid method calls.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 */
	public function __call( $name = '', $args = array() ) { unset( $name, $args ); return null; }


	/* Plugin Specific, Setup Globals, Actions, Includes
	 * ===================================================================
	 */
    
    /**
     * Setup Boss for LearnDash plugin global variables.
     *
     * @since 1.0.0
     * @access private
     *
     * @uses plugin_dir_path() To generate Boss for LearnDash plugin path.
     * @uses plugin_dir_url() To generate Boss for LearnDash plugin url.
     * @uses apply_filters() Calls various filters.
     */
    private function setup_globals() {
        
        /** Versions ************************************************* */
        $this->version = BOSS_LEARNDASH_PLUGIN_VERSION;

        /** Paths***************************************************** */
        // Boss for LearnDash root directory
        $this->file          = BOSS_LEARNDASH_PLUGIN_FILE;
        $this->basename      = plugin_basename( $this->file );
        $this->plugin_dir    = BOSS_LEARNDASH_PLUGIN_DIR;
        $this->plugin_url    = BOSS_LEARNDASH_PLUGIN_URL;

        // Languages
        $this->lang_dir      = dirname( $this->basename ) . '/languages/';

        // Includes
        $this->includes_dir = $this->plugin_dir . 'includes';
        $this->includes_url = $this->plugin_url . 'includes';

        // Templates
		$this->templates_dir = $this->plugin_dir . 'templates';
		$this->templates_url = $this->plugin_url . 'templates';
        
        // Assets
        $this->assets_dir = $this->plugin_dir . 'assets';
        $this->assets_url = $this->plugin_url . 'assets';
    }

    /**
	 * Set up the default hooks and actions.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access private
	 *
	 * @uses add_action() To add various actions.
	 * @uses add_fileter() To add various filters.
	 */
    private function setup_actions() {
        
        
        $this->page_templates = array();


        // Add a filter to the attributes metabox to inject template into the cache.
        add_filter(
            'page_attributes_dropdown_pages_args',
             array( $this, 'register_project_templates' ) 
        );


        // Add a filter to the save post to inject out template into the page cache
        add_filter(
            'wp_insert_post_data', 
            array( $this, 'register_project_templates' ) 
        );


        // Add a filter to the template include to determine if the page has our 
        // template assigned and return it's path
        add_filter(
            'template_include', 
            array( $this, 'view_project_template') 
        );


        // Add your templates to this array.
        $this->page_templates = array(
                'learndash-template.php'     => 'Learndash Page Template',
        );
        
        
        if ( class_exists( 'SFWD_LMS' ) ) {
            if ( ! is_admin() && ! is_network_admin() )
            {
                // Css and Js 
                add_action( 'wp_enqueue_scripts', array( $this, 'boss_edu_enqueue_scripts' ), 11 );
                add_action( 'wp_footer', array( $this, 'boss_edu_deregister_theme_css_learndash' ), 11 );
            }
            
            // Widgets
            add_action( 'widgets_init', array( $this, 'boss_edu_register_widgets' ) );
            
            // Image size for course archive
            add_image_size( 'course-archive-thumb', 360, 250, true );
            add_image_size( 'course-single-thumb', 472, 355, true );
            
            // Filter templates path
            add_filter('learndash_template', array( $this, 'boss_edu_learndash_templates'), 10, 5);
        
            // Register Sidebar
            add_action( 'widgets_init', array( $this, 'boss_edu_sidebar'), 11 );            

            //Learndash & Wpcourseware
            add_filter('single_template', array( $this, 'boss_edu_load_singles_templates'));
            //add_filter('template_include', array( $this, 'boss_edu_load_archive_templates'));
            add_filter('boss_edu_course_author_meta', array( $this, 'boss_edu_post_author_meta'));
            
            // Wrap course list 
            add_filter("ld_course_list", array( $this, 'boss_edu_ld_course_list'), 10, 3);
            
            // Excerpt Course support 
            add_post_type_support( 'sfwd-courses', 'excerpt' );
            
            // Add Course video box 
            add_action( 'add_meta_boxes', array( $this, 'boss_edu_course_add_meta_box') );
            add_action( 'save_post', array( $this, 'boss_edu_course_save_meta_box_data') );
            
            //Register new group extension
            add_action( 'bp_init', array( $this, 'boss_edu_overide_courses_html'),5 );
            
            // Profile courses title
            add_filter( 'bp_learndash_courses_page_title', array($this, 'boss_edu_courses_page_title') );
            
            // Filter steps text
            add_filter( 'badgeos_steps_heading', array($this, 'boss_edu_change_steps_text'), 10, 2 );
            
            global $bp;
            if($bp) {
                add_action( 'bp_init', array($this, 'boss_edu_buddypress_learndash') );
                
                // Disable group template of Boss theme
                add_action( 'bp_init', array($this, 'boss_edu_disable_theme_template') );
            }
            
            // BadgeOs
            if( class_exists('BadgeOS') && $GLOBALS['badgeos']) {
                add_filter( 'badgeos_render_achievement', array( $this, 'boss_edu_badgeos_render_achievement'), 10, 2 );
                remove_filter( 'the_content', 'badgeos_reformat_entries', 9 );
                add_filter( 'the_content', array( $this, 'boss_edu_badgeos_reformat_entries'), 9 );
            }
            
            // activity
		    add_filter( 'bp_get_activity_action',array($this, 'boss_edu_filter_course_activity') );
            
        }
        
    }
    
    /**
     * Filter steps text
     *
     */
    public function boss_edu_change_steps_text($text, $steps){
        $count = count($steps);
        $post_type_object = get_post_type_object( $steps[0]->post_type );
        
        return sprintf( _n( '%1$d Required '.$post_type_object->labels->singular_name, '%1$d Required '.$post_type_object->labels->name, $count, 'boss-learndash' ), $count );
    }
    
    /**
     * Wrap course list
     *
     */
    public function boss_edu_courses_page_title($output) {
        return '<div class="learndash_profile_heading"><span class="title">'.$output.'</span><span class="ld_profile_status">'.__('Status', 'boss-learndash').'</span></div>';
    }
    
    /**
     * Wrap course list
     *
     */
    public function boss_edu_ld_course_list($output, $shortcode_atts, $filter) {
        return '<div id="course-list-wrap">'.$output.'</div>';
    }
    
    
    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     *
     */

    public function register_project_templates( $atts ) {

            // Create the key used for the themes cache
            $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

            // Retrieve the cache list. 
            // If it doesn't exist, or it's empty prepare an array
            $page_templates = wp_get_theme()->get_page_templates();
            if ( empty( $page_templates ) ) {
                    $page_templates = array();
            } 

            // New cache, therefore remove the old one
            wp_cache_delete( $cache_key , 'themes');

            // Now add our template to the list of templates by merging our templates
            // with the existing templates array from the cache.
            $page_templates = array_merge( $page_templates, $this->page_templates );

            // Add the modified cache to allow WordPress to pick it up for listing
            // available templates
            wp_cache_add( $cache_key, $page_templates, 'themes', 1800 );

            return $atts;

    } 

    /**
     * Checks if the template is assigned to the page
     */
    public function view_project_template( $template ) {

            global $post;

            if (!isset($this->page_templates[get_post_meta( 
                $post->ID, '_wp_page_template', true 
            )] ) ) {

                    return $template;

            } 

            $file = plugin_dir_path(__FILE__). get_post_meta( 
                $post->ID, '_wp_page_template', true 
            );

            // Just to be safe, we check if the file exist first
            if( file_exists( $file ) ) {
                    return $file;
            } 
            else { echo $file; }

            return $template;

    } 


    /**
     * Filter badge content to add our removed content back
     *
     * @since  1.0.0
     * @param  string $content The page content
     * @return string          The page content after reformat
     */
    public function boss_edu_badgeos_reformat_entries( $content ) {

        wp_enqueue_style( 'badgeos-front' );

        $badge_id = get_the_ID();

        // filter, but only on the main loop!
        if ( !badgeos_is_main_loop( $badge_id ) )
            return wpautop( $content );

        // now that we're where we want to be, tell the filters to stop removing
        $GLOBALS['badgeos_reformat_content'] = true;

        // do badge title markup
        // $title = '<h1 class="badge-title">'. get_the_title() .'</h1>';

        // check if user has earned this Achievement, and add an 'earned' class
        $class = badgeos_get_user_achievements( array( 'achievement_id' => absint( $badge_id ) ) ) ? ' earned' : '';

        // wrap our content, add the thumbnail and title and add wpautop back
        $newcontent = '<div class="achievement-wrap'. $class .'">';

        // Check if current user has earned this achievement
        $newcontent .= badgeos_render_earned_achievement_text( $badge_id, get_current_user_id() );

        $newcontent .= wpautop( $content );

        // Include output for our steps
        $newcontent .= badgeos_get_required_achievements_for_achievement_list( $badge_id );

        // Include achievement earners, if this achievement supports it
        if ( $show_earners = get_post_meta( $badge_id, '_badgeos_show_earners', true ) )
            $newcontent .= $this->boss_edu_badgeos_get_achievement_earners_list( $badge_id );

        $newcontent .= '</div><!-- .achievement-wrap -->';

        // Ok, we're done reformating
        $GLOBALS['badgeos_reformat_content'] = false;

        return $newcontent;
    }
    
    public function boss_edu_badgeos_get_achievement_earners_list( $achievement_id = 0 ) {

        // Grab our users
        $earners = badgeos_get_achievement_earners( $achievement_id );
        $output = '';

        // Only generate output if we have earners
        if ( ! empty( $earners ) )  {
            // Loop through each user and build our output
            $output .= '<h4>' . apply_filters( 'badgeos_earners_heading', __( 'People who have earned this:', 'boss-sensei' ) ) . '</h4>';
            $output .= '<ul class="badgeos-achievement-earners-list achievement-' . $achievement_id . '-earners-list">';
            foreach ( $earners as $user ) {
                $output .= '<li><a href="' . get_author_posts_url( $user->ID ) . '">' . get_avatar( $user->ID, 75 ) . '</a></li>';
            }
            $output .= '</ul>';
        }

        // Return our concatenated output
        return $output;
    }
    
    /**
    * Change 
    */
    public function boss_edu_badgeos_render_achievement($output, $achievement) {
        global $user_ID;
        
        // If we were given an ID, get the post
        if ( is_numeric( $achievement ) )
            $achievement = get_post( $achievement );

        // make sure our JS and CSS is enqueued
        wp_enqueue_script( 'badgeos-achievements' );
        wp_enqueue_style( 'badgeos-widget' );

        // check if user has earned this Achievement, and add an 'earned' class
        $earned_status = badgeos_get_user_achievements( array( 'user_id' => $user_ID, 'achievement_id' => absint( $achievement->ID ) ) ) ? 'user-has-earned' : 'user-has-not-earned';

        // Setup our credly classes
        $credly_class = '';
        $credly_ID = '';

        // If the achievement is earned and givable, override our credly classes
        if ( 'user-has-earned' == $earned_status && $giveable = credly_is_achievement_giveable( $achievement->ID, $user_ID ) ) {
            $credly_class = ' share-credly addCredly';
            $credly_ID = 'data-credlyid="'. absint( $achievement->ID ) .'"';
        }

        // Each Achievement
        $output = '';
        
        $output .= '<div id="badgeos-achievements-list-item-' . $achievement->ID . '" class="badgeos-achievements-list-item '. $earned_status . $credly_class .'"'. $credly_ID .'>';

            // Achievement Image
            $output .= '<div class="badgeos-item-image">';
            $output .= '<a href="' . get_permalink( $achievement->ID ) . '">' . badgeos_get_achievement_post_thumbnail( $achievement->ID ) . '</a>';
            $output .= '</div><!-- .badgeos-item-image -->';

            // Achievement Content
            $output .= '<div class="badgeos-item-description">';

                $output .= badgeos_achievement_points_markup( $achievement->ID );
        
                // Achievement Title
                $output .= '<h2 class="badgeos-item-title"><a href="' . get_permalink( $achievement->ID ) . '">' . get_the_title( $achievement->ID ) .'</a></h2>';

                // Achievement Short Description
//                $output .= '<div class="badgeos-item-excerpt">';
//                $excerpt = !empty( $achievement->post_excerpt ) ? $achievement->post_excerpt : $achievement->post_content;
//                $output .= wpautop( apply_filters( 'get_the_excerpt', $excerpt ) );
//                $output .= '</div><!-- .badgeos-item-excerpt -->';

                // Render our Steps
                if ( $steps = badgeos_get_required_achievements_for_achievement( $achievement->ID ) ) {
                    $output.='<div class="badgeos-item-attached">';
                        $output.='<div id="show-more-'.$achievement->ID.'" class="badgeos-open-close-switch"><a class="show-hide-open" data-badgeid="'. $achievement->ID .'" data-action="open" href="#">' . __( 'Show Details', 'boss-sensei' ) . '</a></div>';
                        $output.='<div id="badgeos_toggle_more_window_'.$achievement->ID.'" class="badgeos-extras-window">'. badgeos_get_required_achievements_for_achievement_list_markup( $steps, $achievement->ID ) .'</div><!-- .badgeos-extras-window -->';
                    $output.= '</div><!-- .badgeos-item-attached -->';
                }

            $output .= '</div><!-- .badgeos-item-description -->';

        $output .= '</div><!-- .badgeos-achievements-list-item -->';
        return $output;
    }
    
        
    /**
    * Activity markup
    */
	public function boss_edu_filter_course_activity( $action ) {

        global $activities_template;

        $curr_id = isset( $activities_template->current_activity ) ? $activities_template->current_activity : '';
        $act_id = isset( $activities_template->activities[ $curr_id ]->id ) ? ( int ) $activities_template->activities[ $curr_id ]->id : '';
        $user_id = isset( $activities_template->activities[ $curr_id ]->user_id ) ? ( int ) $activities_template->activities[ $curr_id ]->user_id : '';

        // Check for activity ID in $_POST if this is a single
        // activity request from a [read more] action
        if ( $act_id === 0 && ! empty( $_POST[ 'activity_id' ] ) ) {
            $activity_array = bp_activity_get_specific( array(
                'activity_ids' => $_POST[ 'activity_id' ],
                'display_comments' => 'stream'
            ) );

            $activity = ! empty( $activity_array[ 'activities' ][ 0 ] ) ? $activity_array[ 'activities' ][ 0 ] : false;
            $act_id = ( int ) $activity->id;
        }

        // This should never happen, but if it does, bail.
        if ( $act_id === 0 ) {
            return $action;
        }

        $is_course_act = bp_activity_get_meta( $act_id, 'bp_learndash_group_activity_markup', true );

        //Check for action 
        if ( $is_course_act ) {
            $course_attached = bp_activity_get_meta($act_id,'bp_learndash_group_activity_markup_courseid',true );
            $post = get_post($course_attached);
            if ( strpos( $action, 'started taking the course' ) != false ) {
                $html = '<div class="bp-learndash-activity table course-activity">';
                    $html .= '<div class="table-cell edu-activity-image">';
                        $html .= '<p class="edu-activity-type">' . __('Course', 'boss-learndash') . '</p>';
                        if ( has_post_thumbnail( $post->ID ) ) {
                            // Get Featured Image
                            $html .= get_the_post_thumbnail( $post->ID, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                        } else {
                            $html .= '<img src="http://placehold.it/360x250&text=Course">';
                        }
                    $html .= '</div>';
                    $html .= '<div class="table-cell edu-activity-content">';
                
                        $status_class = 'fa-spinner';
                
                        $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                        $author_url = bp_core_get_user_domain( $post->post_author );
                        $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                        $category_output = get_the_category_list( ', ', '', $post->ID );
                        $html .= '<div class="edu-activity-meta">';
                            $html .= '<span>' . __('by ', 'boss-learndash') . $author . '</span>';
                            if ( 'Uncategorized' != $category_output ) {
                                $html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-learndash' ), $category_output ) . '</span>';
                            }
                        $html .= '</div>';
                        if($post->post_excerpt) {
                            $html .= '<p class="edu-activity-excerpt">' . $post->post_excerpt . '</p>';
                        }
                    $html .= '</div>';
                $html .= '</div>';

                $action .= $html;

            } elseif( strpos( $action, 'has passed the' ) != false ) {
                $html = '<div class="bp-learndash-activity table quiz-activity">';
                    $html .= '<div class="table-cell edu-activity-image">';
                        $html .= '<img src="' . $this->assets_url . '/images/quiz.png">';
                    $html .= '</div>';
                    $status_class = 'fa-check-circle';
                    $html .= '<div class="table-cell edu-activity-content">';
                        $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                        $author_url = bp_core_get_user_domain( $post->post_author );
                        $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                        $html .= '<div class="edu-activity-meta">';
                            $html .= '<span>' . __('by ', 'boss-learndash') . $author . '</span>';
//                            if ( 'Uncategorized' != $category_output ) {
//                                $html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-learndash' ), $category_output ) . '</span>';
//                            }
                        $html .= '</div>';
                        if($post->post_excerpt) {
                            $html .= '<p class="edu-activity-excerpt">' . $post->post_excerpt . '</p>';
                        }
                    $html .= '</div>';
                $html .= '</div>';
                $action .= $html;
            } elseif( strpos( $action, 'completed the lesson' ) != false ) {
                $html = '<div class="bp-learndash-activity table course-activity">';
                    $html .= '<div class="table-cell edu-activity-image">';
                        $html .= '<p class="edu-activity-type">' . __('Lesson', 'boss-learndash') . '</p>';
                        if ( has_post_thumbnail( $post->ID ) ) {
                            // Get Featured Image
                            $html .= get_the_post_thumbnail( $post->ID, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                        } else {
                            $html .= '<img src="http://placehold.it/360x250&text=Lesson">';
                        }
                    $html .= '</div>';
                    $html .= '<div class="table-cell edu-activity-content">';
                        $status_class = 'fa-check-circle';
                        $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                        $author_url = bp_core_get_user_domain( $post->post_author );
                        $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                        $lesson_course_id = learndash_get_course_id($post->ID);
                        $lesson_course = get_post($lesson_course_id);
                        $html .= '<div class="edu-activity-meta">';
                            $html .= '<span>' . __('by ', 'boss-learndash') . $author . '</span>';
                            if ( '' != $lesson_course->post_title ) {
                                $html .= '<span class="course-category">' . sprintf( __( 'in <a href="%1s">%2s</a>', 'boss-learndash' ), get_permalink($lesson_course->ID), $lesson_course->post_title ) . '</span>';
                            }
                        $html .= '</div>';
                        if($post->post_excerpt) {
                            $html .= '<p class="edu-activity-excerpt">' . $post->post_excerpt . '</p>';
                        }
                    $html .= '</div>';
                $html .= '</div>';
                $action .= $html;
            }
        }
        return $action;
	}
    
    /**
    * Register new group extension
    */
    function boss_edu_overide_courses_html() {
        if ( function_exists( 'buddypress_learndash' ) && bp_is_active('groups')) {
            remove_action( 'bp_init', array( buddypress_learndash(), 'bp_learndash_add_group_course_extension'), 10 );
            add_action( 'bp_init', array( $this, 'boss_edu_bp_learndash_add_group_course_extension'), 10 );
        }
	}
    
    /**
    * Load Group Course extension 
    */
    public function boss_edu_bp_learndash_add_group_course_extension() {
        if ( class_exists( 'BP_Group_Extension' ) ){
            include_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'group-extension.php';
        }
        bp_register_group_extension( 'GType_Course_Group' );
    }
    
    /*
    * Remove group template from Boss and add another one from this plugin
    */
    public function boss_edu_disable_theme_template() {
        remove_action('boss_get_group_template', 'boss_get_group_template');
        add_action('boss_get_group_template', array( $this, 'boss_edu_get_group_template' ));
    }
    
    public function boss_edu_get_group_template() {
        load_template( apply_filters( 'boss_edu_course_group_template_path' , $this->templates_dir ) . '/learndash-buddypress/buddypress-group-single.php' );
    }
    
   	/**
	 * Modify buddypress-learndash
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */ 
    
    public function boss_edu_buddypress_learndash(){
        global $BUDDYPRESS_LEARNDASH;
        if($BUDDYPRESS_LEARNDASH) {
            //Move group discussion button
            remove_filter('the_content', array( $BUDDYPRESS_LEARNDASH->bp_learndash_groups, 'bp_learndash_group_discussion_button' ), 110 );
        }        
    }
    
	/**
	 * Register the widgets.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function boss_edu_register_widgets () {
		// Widget List (key => value is filename => widget class).
		$widget_list =  array( 	'course-progress' 	=> 'Course_Progress', 'course-teacher' 	=> 'Course_Teacher');
        
		foreach ( $widget_list as $key => $value ) {
            
			if ( file_exists( $this->plugin_dir . '/widgets/widget-boss-edu-' . esc_attr( $key ) . '.php' ) ) {
                
				require_once( $this->plugin_dir . '/widgets/widget-boss-edu-' . esc_attr( $key ) . '.php' );
				register_widget( 'Boss_LearnDash_' . $value . '_Widget' );
			}
		} // End For Loop
	} // End register_widgets()
    
    /**
	 * Filter templates path.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 */  
    
    public function boss_edu_learndash_templates($filepath, $name, $args, $echo, $return_file_path) {
        $path = apply_filters("boss_edu_template_path", $this->templates_dir . '/learndash/');
        if($name == 'course') {
            return $path . 'course.php';
        }
        if($name == 'lesson') {
            return $path . 'lesson.php';
        }
        if($name == 'course_progress_widget') {
            return $path . 'course_progress_widget.php';
        }
        if($name == 'course_list_template') {
            if($args["shortcode_atts"]["post_type"] == 'sfwd-lessons') {
                return $path . 'lesson_list_template.php';
            } elseif ($args["shortcode_atts"]["post_type"] == 'sfwd-quiz'){
                return $path . 'quiz_list_template.php';
            }
            return $path . 'course_list_template.php';
        }
        if($name == 'course_content_shortcode') {
            return $path . 'course_content_shortcode.php';
        }
        if($name == 'topic') {
            return $path . 'topic.php';
        }
        if($name == 'quiz') {
            return $path . 'quiz.php';
        }
        if($name == 'profile') {
            return $path . 'profile.php';
        }
        if($name == 'course_info_shortcode') {
            return $path . 'course_info_shortcode.php';
        }
        return $filepath;
    }


    /**
     * Adds a box to the main column on the Post and Page edit screens.
     */
    public function boss_edu_course_add_meta_box() {

        $screens = array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic' );

        foreach ( $screens as $screen ) {
            add_meta_box(
                'post_video',
                __( 'Video', 'boss-learndash' ),
                array( $this, 'boss_edu_course_meta_box_callback'),
                $screen,
                'advanced',
			    'high'
            );
        }
    }
    

    /**
     * Prints the box content.
     * 
     * @param WP_Post $post The object for the current post/page.
     */
    public function boss_edu_course_meta_box_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'boss_edu_course_meta_box', 'boss_edu_course_meta_box_nonce' );

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $value = get_post_meta( $post->ID, '_boss_edu_post_video', true );
        echo '<textarea id="boss_edu_post_video" name="boss_edu_post_video" rows="3" style="width:100%;">' . esc_attr( $value ) . '</textarea>';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function boss_edu_course_save_meta_box_data( $post_id ) {

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST['boss_edu_course_meta_box_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['boss_edu_course_meta_box_nonce'], 'boss_edu_course_meta_box' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if ( ! isset( $_POST['boss_edu_post_video'] ) ) {
            return;
        }

        // Sanitize user input.
        $data = sanitize_text_field( $_POST['boss_edu_post_video'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_boss_edu_post_video', $data );
    }    
    
    /**
	 * Register Learndash sidebars.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 * @uses wp_deregister_style() To deregister style.
	 */
    public function boss_edu_sidebar() {
        register_sidebar( array(
            'name' 			=> 'Learndash &rarr; Default',
            'id'	 		=> 'learndash-default',
            'description' 	=> 'Only display on Learndash Quiz pages',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 	=> '</aside>',
            'before_title' 	=> '<h4 class="widgettitle">',
            'after_title' 	=> '</h4>',
        ) ); 
        register_sidebar( array(
            'name' 			=> 'Learndash &rarr; Courses',
            'id'	 		=> 'learndash-courses',
            'description' 	=> 'Only display on Learndash Course pages',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 	=> '</aside>',
            'before_title' 	=> '<h4 class="widgettitle">',
            'after_title' 	=> '</h4>',
        ) );
        register_sidebar( array(
            'name' 			=> 'Learndash &rarr; Course',
            'id'	 		=> 'learndash-course',
            'description' 	=> 'Only display on Learndash Course pages',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 	=> '</aside>',
            'before_title' 	=> '<h4 class="widgettitle">',
            'after_title' 	=> '</h4>',
        ) ); 
        register_sidebar( array(
            'name' 			=> 'Learndash &rarr; Lesson/Topic',
            'id'	 		=> 'learndash-lesson',
            'description' 	=> 'Display on Learndash Lesson and Topic pages',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 	=> '</aside>',
            'before_title' 	=> '<h4 class="widgettitle">',
            'after_title' 	=> '</h4>',
        ) ); 
        register_sidebar( array(
            'name' 			=> 'Learndash &rarr; Quiz',
            'id'	 		=> 'learndash-quiz',
            'description' 	=> 'Only display on Learndash Quiz pages',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 	=> '</aside>',
            'before_title' 	=> '<h4 class="widgettitle">',
            'after_title' 	=> '</h4>',
        ) ); 
    }
    
    /**
	 * Check for sidebar templates
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 */
    public function boss_edu_load_template( $template ) {
        $template .= '.php';
        if( file_exists( STYLESHEETPATH.'/boss-learndash/'.$template ) )
            include_once( STYLESHEETPATH.'/boss-learndash/'.$template );
        else if( file_exists( TEMPLATEPATH.'boss-learndash/'.$template ) )
            include_once( TEMPLATEPATH.'/boss-learndash/'.$template );
        else{
            $template_dir = apply_filters( 'boss_edu_templates_dir_filter', $this->templates_dir );
            include_once trailingslashit( $template_dir ) . $template;
        }
    }
    
    /**
	 * Deregister Learndash css.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 * @uses wp_deregister_style() To deregister style.
	 */
    public function boss_edu_deregister_theme_css_learndash() 
    {
        // LearnDash css
        wp_deregister_style( 'sfwd_template_css' );
    }
    
    /**
	 * Enqueue styles and scripts for various plugins.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 */
    public function boss_edu_enqueue_scripts() 
    {

        // Styles
        wp_deregister_style( 'wpProQuiz_front_style' );
        //wp_enqueue_style( 'boss-learndash', $this->assets_url . '/css/learndash.css', array(), '1.0.1', 'all' );
        wp_enqueue_style( 'boss-learndash', $this->assets_url . '/css/learndash.min.css', array(), '1.0.1', 'all' );

        // Javascript
        //wp_enqueue_script( 'boss-learndash', $this->assets_url . '/js/learndash.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'boss-learndash', $this->assets_url . '/js/learndash.min.js', array('jquery'), '1.0.0', true );
    }
    
    /**
	 * Load single templates for custom posts from plugin.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 */
    /* Filter the single_template with our custom function */
    public function boss_edu_load_singles_templates($single) {
        global $wp_query, $post;
        /* Checks for single template by post type */
        /* Learndash */
        if ($post->post_type == "sfwd-quiz"){
            $theme_files = array('single-sfwd-quiz.php', 'learndash/single-sfwd-quiz.php');
            $exists_in_theme = locate_template($theme_files, false);

            if ( $exists_in_theme != '' ) {
              return $exists_in_theme;
            } else {
              return $this->templates_dir . '/learndash/single-sfwd-quiz.php';
            }
        }
        if ($post->post_type == "sfwd-topic"){
            $theme_files = array('single-sfwd-topic.php', 'learndash/single-sfwd-topic.php');
            $exists_in_theme = locate_template($theme_files, false);

            if ( $exists_in_theme != '' ) {
              return $exists_in_theme;
            } else {
              return $this->templates_dir . '/learndash/single-sfwd-topic.php';
            }
        }
        if ($post->post_type == "sfwd-lessons"){
            $theme_files = array('single-sfwd-lesson.php', 'learndash/single-sfwd-lesson.php');
            $exists_in_theme = locate_template($theme_files, false);

            if ( $exists_in_theme != '' ) {
              return $exists_in_theme;
            } else {
              return $this->templates_dir . '/learndash/single-sfwd-lesson.php';
            }
        }
        if ($post->post_type == "sfwd-courses"){
            $theme_files = array('single-sfwd-course.php', 'learndash/single-sfwd-course.php');
            $exists_in_theme = locate_template($theme_files, false);

            if ( $exists_in_theme != '' ) {
              return $exists_in_theme;
            } else {
              return $this->templates_dir . '/learndash/single-sfwd-course.php';
            }
        }
        return $single;
    }
    
    /**
	 * Load archive templates for custom posts from plugin.
	 *
	 * @since Boss for LearnDash (1.0.0)
	 * @access public
	 *
	 */
//    public function boss_edu_load_archive_templates( $template ) {
//          if ( is_tax('wpc_course_category') ) {
//            $theme_files = array('archive-wpc_course.php', 'wpcourseware/archive-wpc_course.php');
//            $exists_in_theme = locate_template($theme_files, false);
//
//            if ( $exists_in_theme != '' ) {
//              return $exists_in_theme;
//            } else {
//              return $this->templates_dir . '/courseware/archive-wpc_course.php';
//            }
//          }
//          return $template;
//    }
    
    public function boss_edu_post_author_meta() {
        $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a></span>',
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() )
        );

        $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'boss' ), get_the_author() ) ),
            get_the_author()
        );

        if (function_exists('get_avatar')) { 
            $avatar = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', 
                                esc_url( get_permalink() ),
                                get_avatar( get_the_author_meta('email'), 55 ) 
                            ); 
        }
        
        echo '<span class="post-author">';
            echo $avatar;
            echo $author;
        echo '</span>';
        echo $date;
    }

    /**
	 * Load plugin text domain
	 *
	 * @since Boss for LearnDash (1.0.0)
	 *
	 * @uses sprintf() Format .mo file
	 * @uses get_locale() Get language
	 * @uses file_exists() Check for language file
	 * @uses load_textdomain() Load language file
	 */
	public function setup_textdomain()
	{
		$domain = 'boss-learndash';
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		//first try to load from wp-content/languages/plugins/ directory
		load_textdomain($domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo');

		//if not found, then load from boss-learndash/languages/ directory
		load_plugin_textdomain( 'boss-learndash', false, $this->lang_dir );
	}
    
}

endif;

?>