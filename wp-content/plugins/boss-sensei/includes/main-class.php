<?php
/**
 * @package WordPress
 * @subpackage Boss for Sensei
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Boss_Sensei_Plugin' ) ):
/**
 *
 * Boss for Sensei Plugin Main Controller
 * **************************************
 *
 *
 */
class Boss_Sensei_Plugin
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
    public $sensei_dir = '';
    public $assets_dir = '';
    public $assets_url = '';
    private $data;


	/* Singleton
	 * ===================================================================
	 */

	/**
	 * Main Boss for Sensei Instance.
	 *
	 * Boss for Sensei is great
	 * Please load it only one time
	 * For this, we thank you
	 *
	 * Insures that only one instance of Boss for Sensei exists in memory at any
	 * one time. Also prevents needing to define globals all over the place.
	 *
	 * @since Boss for Sensei (1.0.0)
	 *
	 * @static object $instance
	 * @uses Boss_Sensei_Plugin::setup_globals() Setup the globals needed.
	 * @uses Boss_Sensei_Plugin::setup_actions() Setup the hooks and actions.
	 * @uses Boss_Sensei_Plugin::setup_textdomain() Setup the plugin's language file.
	 * @see buddyboss_sensei()
	 *
	 * @return Boss for Sensei The one true BuddyBoss.
	 */
	public static function instance()
	{
		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been run previously
		if ( null === $instance )
		{
			$instance = new Boss_Sensei_Plugin;
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
	 * A dummy constructor to prevent Boss for Sensei from being loaded more than once.
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @see Boss_Sensei_Plugin::instance()
	 * @see buddypress()
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * A dummy magic method to prevent Boss for Sensei from being cloned.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'boss-sensei' ), '1.0.0' ); }

	/**
	 * A dummy magic method to prevent Boss for Sensei from being unserialized.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'boss-sensei' ), '1.0.0' ); }

	/**
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __isset( $key ) { return isset( $this->data[$key] ); }

	/**
	 * Magic method for getting Boss for Sensei varibles.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __get( $key ) { return isset( $this->data[$key] ) ? $this->data[$key] : null; }

	/**
	 * Magic method for setting Boss for Sensei varibles.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __set( $key, $value ) { $this->data[$key] = $value; }

	/**
	 * Magic method for unsetting Boss for Sensei variables.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __unset( $key ) { if ( isset( $this->data[$key] ) ) unset( $this->data[$key] ); }

	/**
	 * Magic method to prevent notices and errors from invalid method calls.
	 *
	 * @since Boss for Sensei (1.0.0)
	 */
	public function __call( $name = '', $args = array() ) { unset( $name, $args ); return null; }


	/* Plugin Specific, Setup Globals, Actions, Includes
	 * ===================================================================
	 */
    
    /**
     * Setup Boss for Sensei plugin global variables.
     *
     * @since 1.0.0
     * @access private
     *
     * @uses plugin_dir_path() To generate Boss for Sensei plugin path.
     * @uses plugin_dir_url() To generate Boss for Sensei plugin url.
     * @uses apply_filters() Calls various filters.
     */
    private function setup_globals() {
        
        /** Versions ************************************************* */
        $this->version = BOSS_SENSEI_PLUGIN_VERSION;

        /** Paths***************************************************** */
        // Boss for Sensei root directory
        $this->file          = BOSS_SENSEI_PLUGIN_FILE;
        $this->basename      = plugin_basename( $this->file );
        $this->plugin_dir    = BOSS_SENSEI_PLUGIN_DIR;
        $this->plugin_url    = BOSS_SENSEI_PLUGIN_URL;

        // Languages
        $this->lang_dir      = dirname( $this->basename ) . '/languages/';

        // Includes
        $this->includes_dir = $this->plugin_dir . 'includes';
        $this->includes_url = $this->plugin_url . 'includes';

        // Templates
		$this->templates_dir = $this->plugin_dir . 'templates';
		$this->templates_url = $this->plugin_url . 'templates';
        
        // Sensei
        $this->sensei_dir = $this->templates_dir . '/sensei/';
            
        // Assets
        $this->assets_dir = $this->plugin_dir . 'assets';
        $this->assets_url = $this->plugin_url . 'assets';
    }
    
    /**
	 * Set up the default hooks and actions.
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @access private
	 *
	 * @uses add_action() To add various actions.
	 * @uses add_fileter() To add various filters.
	 */
    private function setup_actions() {

        if ( ! is_admin() && ! is_network_admin() )
        {
            // Css and Js 
            add_action( 'wp_enqueue_scripts', array( $this, 'boss_edu_enqueue_scripts' ), 1000 );

        }

        // Register Sidebar
        add_action( 'widgets_init', array( $this, 'boss_edu_sidebar'), 11 );    
        
        add_action( 'bp_init', array( $this, 'boss_edu_content_wrappers') );            

        // Sensei
        add_filter( 'sensei_locate_template', array( $this, 'boss_edu_sensei_locate_template'), 10, 3);

        global $woothemes_sensei;
        if($woothemes_sensei){

            // Modules templates
            add_action( 'bp_init',array($this, 'boss_edu_change_modules') );

            // Disable group template of Boss theme
            add_action( 'bp_init',array($this, 'boss_edu_disable_theme_template') );

            // Change Sensei - BuddyPress output
            add_action( 'bp_init',array($this, 'boss_edu_remove_bp_sensei_hooks') );

             // Sensei single templates action
            remove_action( 'sensei_single_main_content', array( $woothemes_sensei->frontend, 'sensei_single_main_content' ));
            add_action( 'sensei_single_main_content', array( $this, 'boss_edu_sensei_single_main_content' ), 10 ); 

            // Image size for course archive
            add_image_size( 'course-archive-thumb', 360, 250, true );
            add_image_size( 'course-single-thumb', 472, 355, true );

            // Widgets
            add_action( 'widgets_init', array( $this, 'boss_edu_register_widgets' ) );

            // Add message links to courses & lessons
            $get_sensei_class_object = $woothemes_sensei->post_types->messages;
            // Single Course - Move Contact Form 
            remove_action( 'sensei_course_single_meta', array( $get_sensei_class_object, 'send_message_link' ), 14 );
            add_action( 'boss_edu_course_single_contact', array( $get_sensei_class_object, 'send_message_link'), 100);
            // Single Course - Remove Progress
            remove_action( 'sensei_course_single_meta' , array( $woothemes_sensei->course_results, 'the_progress_statement' ), 15 );
            remove_action( 'sensei_course_single_meta' , array( $woothemes_sensei->course_results, 'the_progress_meter' ), 16 );

            // Change start course button
            add_filter( 'sensei_start_course_text', array( $this, 'boss_edu_filter_start_button' ) );

            // Change lesson quiz meta
            remove_action( 'sensei_lesson_quiz_meta', array( $woothemes_sensei->frontend, 'sensei_lesson_quiz_meta' ), 10, 2 );
            add_action( 'sensei_lesson_quiz_meta', array( $this, 'boss_edu_sensei_lesson_quiz_meta' ), 10, 2 );

            // Move quiz message
            add_action( 'sensei_quiz_single_title', array( $this, 'boss_edu_quiz_message' ), 9 );

            // Change quiz and lesson title
            remove_action( 'sensei_lesson_single_title', array( $woothemes_sensei->frontend, 'sensei_single_title' ), 10 );
            remove_action( 'sensei_quiz_single_title', array( $woothemes_sensei->frontend, 'sensei_single_title' ), 10 );
            add_action( 'sensei_lesson_single_title', array( $this, 'boss_edu_sensei_single_title' ), 10 );
            add_action( 'sensei_quiz_single_title', array( $this, 'boss_edu_sensei_single_title' ), 10 );

            //Override sensei-buddypress path
            add_filter( 'bp_sensei_templates_dir_filter', array( $this, 'boss_edu_sensei_buddypress_path' ) );

            // Extensions 
            // Sensei Course Participants
            if ( function_exists('Sensei_Course_Participants') ) {
                remove_action( 'sensei_course_meta', array( Sensei_Course_Participants(), 'display_course_participant_count' ), 5 );
                add_action( 'boss_edu_participants', array( Sensei_Course_Participants(), 'display_course_participant_count' ) );
            }
            
            // Course Group template
            add_action( 'bp_init',array($this, 'boss_edu_disable_theme_template') );
            
            // My courses tabs courses count
            add_filter( 'sensei_active_courses_text', array( $this, 'boss_edu_sensei_active_courses_text' ));
            add_filter( 'sensei_completed_courses_text', array( $this, 'boss_edu_sensei_completed_courses_text' )  );

            // Course Category
            remove_action( 'sensei_course_category_main_content', array( $woothemes_sensei->frontend, 'sensei_course_category_main_content' ), 10 );
            add_action( 'sensei_course_category_main_content', array( $this, 'boss_edu_sensei_course_category_main_content'), 10 );
            
            //Register new group extension
            add_action( 'init', array( $this, 'boss_edu_overide_courses_html'),5 );
            
            // Page Template
            add_action( 'template_redirect', array( $this, 'boss_edu_overide_sensei_courses_template') );
            
            // Load course results
            remove_action( 'sensei_course_results_info', array( $woothemes_sensei->course_results, 'course_info' ), 10 );
            add_action( 'sensei_course_results_info', array( $this, 'boss_edu_course_info' ), 10 );
            // Woocommerce message
            remove_action( 'sensei_woocommerce_in_cart_message', array( $woothemes_sensei->frontend, 'sensei_woocommerce_in_cart_message' ), 10 );
            add_action( 'boss_edu_sensei_woocommerce_in_cart_message', array( $woothemes_sensei->frontend, 'sensei_woocommerce_in_cart_message' ), 10 );
            
            // Profile avatar
            add_filter( 'sensei_learner_profile_info_avatar', array( $this, 'boss_edu_profile_avatar' ), 10, 2 );
			
			add_action( 'wp_ajax_boss_edu_contact_teacher_ajax', array( $this, 'boss_edu_contact_teacher_ajax' ) );
			add_action( 'wp_ajax_nopriv_boss_edu_contact_teacher_ajax', array( $this, 'boss_edu_contact_teacher_ajax' ) );

        }
        
        // BadgeOs
        if($GLOBALS['badgeos']) {
            add_filter( 'badgeos_render_achievement', array( $this, 'boss_edu_badgeos_render_achievement'), 10, 2 );
            remove_filter( 'the_content', 'badgeos_reformat_entries', 9 );
            add_filter( 'the_content', array( $this, 'boss_edu_badgeos_reformat_entries'), 9 );
        }
        
        add_action( 'bp_loaded', array( $this, 'gtype_completion_group_tab_init') );

        // activity
		add_filter( 'bp_get_activity_action',array($this, 'boss_edu_filter_course_activity') );

    }
    
    /**
    * Filter My Profile avatar size
    *
    **/
    public function boss_edu_profile_avatar($html, $user_id) {
        $html = '';
        $html = get_avatar( $user_id, 140 );
        return $html;
    }
    
    /**
     * Filter badge content to add our removed content back
     *
     * @since  1.0.0
     * @param  string $content The page content
     * @return string          The page content after reformat
     */
    function boss_edu_badgeos_reformat_entries( $content ) {

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
    * Page Template
    */
    public function boss_edu_course_info() {
   		global $course, $current_user;

		do_action( 'sensei_course_results_top', $course->ID );

		//do_action( 'sensei_course_image', $course->ID );

		?>
		<header><h1><?php echo $course->post_title; ?></h1></header>
		<?php

		$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $course->ID, $current_user->ID );
		echo '<div class="sensei-message ' . $course_status['box_class'] . '">' . $course_status['message'] . '</div>';

		do_action( 'sensei_course_results_lessons', $course );

		do_action( 'sensei_course_results_bottom', $course->ID );     
    }
    
    /**
    * Page Template
    */
    public function boss_edu_overide_sensei_courses_template() {
        $WooThemes_Sensei = WooThemes_Sensei::instance();
        $token = $WooThemes_Sensei->token;
        global $post;
        if ( $post->ID == get_option("{$token}_courses_page_id") || $post->ID == get_option("{$token}_user_dashboard_page_id") ) {
            include ($this->templates_dir . '/sensei-buddypress/page-template.php');
            exit;
        }
    }

    
    /**
    * Register new group extension
    */
    function boss_edu_overide_courses_html() {
        if ( function_exists( 'buddypress_sensei' ) && bp_is_active('groups')) {
            remove_action( 'bp_init', array( buddypress_sensei(), 'bp_sensei_add_group_course_extension'), 10 );
            add_action( 'bp_init', array( $this, 'boss_edu_bp_sensei_add_group_course_extension'), 10 );
        }
	}
    
    /**
    * Load Group Course extension 
    */
    public function boss_edu_bp_sensei_add_group_course_extension() {
        if ( class_exists( 'BP_Group_Extension' ) ){
            include_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'group-extension.php';
        }
        bp_register_group_extension( 'GType_Course_Group' );
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

			$is_course_act = bp_activity_get_meta( $act_id, 'bp_sensei_group_activity_markup', true );

            //Check for action 
            if ( $is_course_act ) {
                $course_attached = bp_activity_get_meta($act_id,'bp_sensei_group_activity_markup_courseid',true );
                $post = get_post($course_attached);
                if ( strpos( $action, 'started taking the course' ) != false ) {
                    $html = '<div class="bp-sensei-activity table course-activity">';
                        $html .= '<div class="table-cell edu-activity-image">';
                            $html .= '<p class="edu-activity-type">' . __('Course', 'boss-sensei') . '</p>';
                            if ( has_post_thumbnail( $post->ID ) ) {
                                // Get Featured Image
                                $html .= get_the_post_thumbnail( $post->ID, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                            } else {
                                $html .= '<img src="http://placehold.it/360x250&text=Course">';
                            }
                        $html .= '</div>';
                        $html .= '<div class="table-cell edu-activity-content">';
                            $user_course_status = WooThemes_Sensei_Utils::user_course_status( $post->ID, $user_id );
                            $completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );

                            $status_class = 'fa-spinner';
                            if ( $completed_course ) {
                                $status_class = 'fa-check-circle';
                            }
                            $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                            $author_url = bp_core_get_user_domain( $post->post_author );
                            $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                            $category_output = get_the_term_list( $post->ID, 'course-category', '', ', ', '' );
                            $html .= '<div class="edu-activity-meta">';
                                $html .= '<span>' . __('by ', 'boss-sensei') . $author . '</span>';
                                if ( '' != $category_output ) {
                                    $html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-sensei' ), $category_output ) . '</span>';
                                }
                            $html .= '</div>';
                            if($post->post_excerpt) {
                                $html .= '<p class="edu-activity-excerpt">' . $post->post_excerpt . '</p>';
                            }
                        $html .= '</div>';
                    $html .= '</div>';
                    
                    $action .= $html;

                } elseif( strpos( $action, 'has passed the' ) != false ) {
                    $html = '<div class="bp-sensei-activity table quiz-activity">';
                        $html .= '<div class="table-cell edu-activity-image">';
                            $html .= '<img src="' . $this->assets_url . '/images/quiz.png">';
                        $html .= '</div>';
                        $html .= '<div class="table-cell edu-activity-content">';
                            $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                            $author_url = bp_core_get_user_domain( $post->post_author );
                            $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                            $category_output = get_the_term_list( $post->ID, 'course-category', '', ', ', '' );
                            $html .= '<div class="edu-activity-meta">';
                                $html .= '<span>' . __('by ', 'boss-sensei') . $author . '</span>';
                                if ( '' != $category_output ) {
                                    $html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-sensei' ), $category_output ) . '</span>';
                                }
                            $html .= '</div>';
                            if($post->post_excerpt) {
                                $html .= '<p class="edu-activity-excerpt">' . $post->post_excerpt . '</p>';
                            }
                        $html .= '</div>';
                    $html .= '</div>';
                    $action .= $html;
                } elseif( strpos( $action, 'completed the lesson' ) != false ) {
                    $html = '<div class="bp-sensei-activity table course-activity">';
                        $html .= '<div class="table-cell edu-activity-image">';
                            $html .= '<p class="edu-activity-type">' . __('Lesson', 'boss-sensei') . '</p>';
                            if ( has_post_thumbnail( $post->ID ) ) {
                                // Get Featured Image
                                $html .= get_the_post_thumbnail( $post->ID, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                            } else {
                                $html .= '<img src="http://placehold.it/360x250&text=Lesson">';
                            }
                        $html .= '</div>';
                        $html .= '<div class="table-cell edu-activity-content">';
                            $user_lesson_status = WooThemes_Sensei_Utils::user_completed_lesson( $post->ID, $user_id );
                            $status_class = 'fa-spinner';
                            if ( $user_lesson_status ) {
                                $status_class = 'fa-check-circle';
                            }
                            $html .= '<h4><span>' . $post->post_title . '<i  class="fa '.$status_class.'"></i></span></h4>';

                            $author_url = bp_core_get_user_domain( $post->post_author );
                            $author = '<a href="' . $author_url . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                            $lesson_course_id = get_post_meta( $post->ID , '_lesson_course', true);
                            $lesson_course = get_post($lesson_course_id);
                            $html .= '<div class="edu-activity-meta">';
                                $html .= '<span>' . __('by ', 'boss-sensei') . $author . '</span>';
                                if ( '' != $lesson_course->post_title ) {
                                    $html .= '<span class="course-category">' . sprintf( __( 'in <a href="%1s">%2s</a>', 'boss-sensei' ), get_permalink($lesson_course->ID), $lesson_course->post_title ) . '</span>';
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
     * Override Course Category
     *
     * @since 1.0.0
     * @return void
     */
	public function boss_edu_sensei_course_category_main_content() {
		global $post, $woothemes_sensei;
		if ( have_posts() ) { ?>
			<section id="main-course" class="course-container">
	    	    <?php do_action( 'sensei_course_archive_header' ); ?>
	    	    <?php while ( have_posts() ) { the_post(); 
                    // Meta data
                    $post_id = absint( $post->ID );
                    $post_title = $post->post_title;
                    $user_info = get_userdata( absint( $post->post_author ) );
                    $author_link = get_author_posts_url( absint( $post->post_author ) );
                    $author_avatar = get_avatar( $post->post_author, 75 );
                    $author_display_name = $user_info->display_name;
                    $author_id = $post->post_author;
                    $category_output = get_the_term_list( $post_id, 'course-category', '', ', ', '' );
                    $preview_lesson_count = intval( $woothemes_sensei->post_types->course->course_lesson_preview_count( $post_id ) );
                ?>
				<article class="<?php echo join( ' ', get_post_class( array( 'course', 'post' ), get_the_ID() ) ); ?>">
                    <div class="course-inner">
                        <div class="course-image">
                            <div class="course-mask"></div>
                            <div class="course-overlay">
                                <a href="<?php echo $author_link; ?>" title="<?php echo esc_attr( $author_display_name ); ?>">
                                <?php echo $author_avatar; ?>
                                </a>
                                <a href="<?php echo get_permalink( $post_id ); ?>" title="<?php echo esc_attr( $post_title ); ?>" class="play">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                            <?php
                            if ( has_post_thumbnail( $post_id ) ) {
                                // Get Featured Image
                                $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );

                            } else {
                                $img = '<img src="http://placehold.it/360x250&text=Course">';
                            }
                            echo '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
                            ?>
                        </div>
                        
                        <section class="entry">
                            <div class="course-flexible-area">
                                <?php do_action( 'sensei_course_archive_course_title', $post ); ?>

                                <p class="sensei-course-meta">
                                    <?php if ( 0 < $preview_lesson_count && !$is_user_taking_course ) {
                                        $preview_lessons = sprintf( __( '(%d preview lessons)', 'boss-sensei' ), $preview_lesson_count ); ?>
                                        <span class="sensei-free-lessons"><a href="<?php echo get_permalink( $post_id ); ?>"><?php _e( 'Preview this course', 'boss-sensei' ) ?></a> - <?php echo $preview_lessons; ?></span>
                                    <?php } ?>
                                    <?php if ( isset( $woothemes_sensei->settings->settings[ 'course_author' ] ) && ( $woothemes_sensei->settings->settings[ 'course_author' ] ) ) { ?>
                                    <span class="course-author"><?php _e( 'by ', 'boss-sensei' ); ?>
                                        <a href="<?php echo $author_link; ?>" title="<?php echo esc_attr( $author_display_name ); ?>">
                                            <?php echo $author_display_name; ?>
                                        </a>
                                   </span>
                                    <?php } ?>
                                </p>
                            </div>

                            <p class="sensei-course-meta">
                                <span class="course-lesson-count"><?php echo $woothemes_sensei->post_types->course->course_lesson_count( $post_id ) . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ); ?></span>
                                <?php if ( '' != $category_output ) { ?>
                                <span class="course-category"><?php echo sprintf( __( 'in %s', 'boss-sensei' ), $category_output ); ?></span>
                                <?php } // End If Statement ?>
                                <?php sensei_simple_course_price( $post_id ); ?>
                            </p>
                            <!-- Modification -->
                            <!-- <p class="course-excerpt"><?php // echo apply_filters( 'get_the_excerpt', $post->post_excerpt ); ?></p>-->
                        </section> 
                    </div>
	    			<?php //do_action( 'sensei_course_image', get_the_ID() ); ?>
	    			<?php //do_action( 'sensei_course_archive_course_title', $post ); ?>
	    			<?php //do_action( 'sensei_course_archive_meta' ); ?>
	    		</article>
	    		<?php } // End While Loop ?>
	    	</section>
		<?php } else { ?>
			<p><?php _e( 'No courses found that match your selection.', 'boss-sensei' ); ?></p>
		<?php } // End If Statement
	} // End sensei_course_category_main_content()  
    
    
    
    // My courses tabs courses count
    public function boss_edu_sensei_active_courses_text(){
        global $woothemes_sensei;
        // Logic for Active and Completed Courses
        $per_page = 20;
        if ( isset( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) && ( 0 < absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) ) ) {
            $per_page = absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] );
        }

        $course_statuses = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'user_id' => get_current_user_id(), 'type' => 'sensei_course_status' ), true );
        // User may only be on 1 Course
        if ( !is_array($course_statuses) ) {
            $course_statuses = array( $course_statuses );
        }
        $completed_ids = $active_ids = array();
        foreach( $course_statuses as $course_status ) {
            if ( WooThemes_Sensei_Utils::user_completed_course( $course_status, $user->ID ) ) {
                $completed_ids[] = $course_status->comment_post_ID;
            } else {
                $active_ids[] = $course_status->comment_post_ID;
            }
        }
        $active_count = count( $active_ids );
        printf('%1s<span class="tab-course-count">%2s</span>', __( 'Active Courses', 'boss-sensei' ), $active_count);
    }
    public function boss_edu_sensei_completed_courses_text(){
        global $woothemes_sensei;
        // Logic for Active and Completed Courses
        $per_page = 20;
        if ( isset( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) && ( 0 < absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) ) ) {
            $per_page = absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] );
        }

        $course_statuses = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'user_id' => get_current_user_id(), 'type' => 'sensei_course_status' ), true );
        // User may only be on 1 Course
        if ( !is_array($course_statuses) ) {
            $course_statuses = array( $course_statuses );
        }
        $completed_ids = $active_ids = array();
        foreach( $course_statuses as $course_status ) {
            if ( WooThemes_Sensei_Utils::user_completed_course( $course_status, $user->ID ) ) {
                $completed_ids[] = $course_status->comment_post_ID;
            } else {
                $active_ids[] = $course_status->comment_post_ID;
            }
        }
        $completed_count = count( $completed_ids );
        printf('%1s<span class="tab-course-count">%2s</span>', __( 'Completed Courses', 'boss-sensei' ), $completed_count);
    }
    
    /*
    * Remove group template from Boss and add another one from this plugin
    */
    public function boss_edu_disable_theme_template() {
        remove_action('boss_get_group_template', 'boss_get_group_template');
        add_action('boss_get_group_template', array( $this, 'boss_edu_get_group_template' ));
    }
    
    public function boss_edu_get_group_template() {
        load_template( apply_filters( 'boss_edu_course_group_template_path' , $this->templates_dir ) . '/sensei-buddypress/buddypress-group-single.php' );
    }
    
    
    /**
	 * override sensei function sensei_single_title / output for single page title
	 * @since  1.1.0
	 * @return void
	 */
	function boss_edu_sensei_single_title() {
		global $post;
        ?>
        <header>
            <?php
            if( is_singular('quiz') ){
                echo '<span>' . __('Quiz', 'boss-sensei') . '</span>';
            }elseif( is_singular('lesson') ){
                echo '<span>' . __('Lesson', 'boss-sensei') . '</span>';
            }
            echo '<h1>';
            the_title();
            echo '</h1>';
            ?>
        </header>
    <?php
	} // End sensei_single_title()
    
    
    /**
     * Display the single course modules content
     *
     * @since 1.8.0
     * @return void
     */
    public function boss_edu_course_module_content(){

        global $post, $woothemes_sensei;
        $course_id = $post->ID;
        $modules = $woothemes_sensei->modules->get_course_modules( $course_id  );
        
        // Display each module
        foreach ($modules as $module) {

            echo '<article class="post module">';

            // module title link
            $module_url = esc_url(add_query_arg('course_id', $course_id, get_term_link($module, $woothemes_sensei->modules->taxonomy)));
            echo '<header><h2><a href="' . esc_url($module_url) . '">' . $module->name . '</a></h2></header>';

            echo '<section class="entry">';

            $module_progress = false;
            if (is_user_logged_in()) {
                global $current_user;
                wp_get_current_user();
                $module_progress = $woothemes_sensei->modules->get_user_module_progress($module->term_id, $course_id, $current_user->ID);
            }

            if ($module_progress && $module_progress > 0) {
                $status = __('Completed', 'boss-sensei');
                $class = 'completed';
                if ($module_progress < 100) {
                    $status = __('In progress', 'boss-sensei');
                    $class = 'in-progress';
                }
                echo '<p class="status module-status ' . esc_attr($class) . '">' . $status . '</p>';
            }

            if ('' != $module->description) {
                echo '<p class="module-description">' . $module->description . '</p>';
            }

            $lessons = $woothemes_sensei->modules->get_lessons( $course_id ,$module->term_id );

            if (count($lessons) > 0) {

                $lessons_list = '';
                foreach ($lessons as $lesson) {
                    $status = '';
                    $lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson->ID, get_current_user_id() );
                    $lesson_length = get_post_meta( $lesson->ID, '_lesson_length', true );
                    $title = esc_attr(get_the_title(intval($lesson->ID)));

                    if ($lesson_completed) {
                        $status = 'completed';
                    }
                    
                    $meta = '';

                    if ( '' != $lesson_length ) { $meta .= '<span class="lesson-length">' . $lesson_length . __( ' minutes', 'boss-sensei' ) . '</span>'; }

                    $lessons_list .= '<li class="' . $status . '"><a href="' . esc_url(get_permalink(intval($lesson->ID))) . '" title="' . esc_attr(get_the_title(intval($lesson->ID))) . '">' . apply_filters('sensei_module_lesson_list_title', $title, $lesson->ID) . $meta . '</a></li>';

                    // Build array of displayed lesson for exclusion later
                    $displayed_lessons[] = $lesson->ID;
                }
                ?>
                <section class="module-lessons">
                    <header>
                        <h3><?php _e('Lessons', 'boss-sensei') ?></h3>
                    </header>
                    <ul>
                        <?php echo $lessons_list; ?>
                    </ul>
                </section>

            <?php }//end count lessons  ?>
                </section>
            </article>
        <?php

        } // end each module

    } // end boss_edu_course_module_content
    
	/**
	 * Override sensei's load_user_courses_content 
	 * @since  1.4.0
	 * @param  object  $user   Queried user object
	 * @param  boolean $manage Whether the user has permission to manage the courses
	 * @return string          HTML displayng course data
	 */
	public function boss_edu_load_user_courses_content( $user = false, $manage = false ) {
		global $woothemes_sensei, $post, $wp_query, $course, $my_courses_page, $my_courses_section;

		// Build Output HTML
		$complete_html = $active_html = '';

		if( $user ) {

			$my_courses_page = true;

			// Allow action to be run before My Courses content has loaded
			do_action( 'sensei_before_my_courses', $user->ID );

			// Logic for Active and Completed Courses
			$per_page = 20;
			if ( isset( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) && ( 0 < absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) ) ) {
				$per_page = absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] );
			}

			$course_statuses = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'user_id' => $user->ID, 'type' => 'sensei_course_status' ), true );
			// User may only be on 1 Course
			if ( !is_array($course_statuses) ) {
				$course_statuses = array( $course_statuses );
			}
			$completed_ids = $active_ids = array();
			foreach( $course_statuses as $course_status ) {
				if ( WooThemes_Sensei_Utils::user_completed_course( $course_status, $user->ID ) ) {
					$completed_ids[] = $course_status->comment_post_ID;
				} else {
					$active_ids[] = $course_status->comment_post_ID;
				}
			}

			$active_count = $completed_count = 0;

			$active_courses = array();
			if ( 0 < intval( count( $active_ids ) ) ) {
				$my_courses_section = 'active';
				$active_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $active_ids );
				$active_count = count( $active_ids );
			} // End If Statement

			$completed_courses = array();
			if ( 0 < intval( count( $completed_ids ) ) ) {
				$my_courses_section = 'completed';
				$completed_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $completed_ids );
				$completed_count = count( $completed_ids );
			} // End If Statement
			$lesson_count = 1;

			$active_page = 1;
			if( isset( $_GET['active_page'] ) && 0 < intval( $_GET['active_page'] ) ) {
				$active_page = $_GET['active_page'];
			}

			$completed_page = 1;
			if( isset( $_GET['completed_page'] ) && 0 < intval( $_GET['completed_page'] ) ) {
				$completed_page = $_GET['completed_page'];
			}
			foreach ( $active_courses as $course_item ) {

				$course_lessons = $woothemes_sensei->post_types->course->course_lessons( $course_item->ID );
				$lessons_completed = 0;
				foreach ( $course_lessons as $lesson ) {
					if ( WooThemes_Sensei_Utils::user_completed_lesson( $lesson->ID, $user->ID ) ) {
						++$lessons_completed;
					}
				}

			    // Get Course Categories
			    $category_output = get_the_term_list( $course_item->ID, 'course-category', '', ', ', '' );

		    	$active_html .= '<article class="' . esc_attr( join( ' ', get_post_class( array( 'course', 'post' ), $course_item->ID ) ) ) . '">';
                
                $active_html .= '<div class="course-inner">';
                
                $post_id = $course_item->ID;
                $post_title = $course_item->post_title;
                $user_info = get_userdata( absint( $course_item->post_author ) );
    			$author_link = get_author_posts_url( absint( $course_item->post_author ) );
                $author_avatar = get_avatar( $course_item->post_author, 75 );
    			$author_display_name = $user_info->display_name;
    			$author_id = $course_item->post_author;
                
                $active_html .= '<div class="course-image">
                                    <div class="course-mask"></div>
                                    <div class="course-border"><div class="course-border-inner"></div></div>
                                    <div class="course-overlay">
                                        <a href="'. $author_link . '" title="' . esc_attr( $author_display_name ) .'">' . $author_avatar . '</a>
                                        <a href="'. get_permalink( $post_id ) .'" title="' . esc_attr( $post_title ) . '" class="play">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>';
                                    if ( has_post_thumbnail( $post_id ) ) {
                                        // Get Featured Image
                                        $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                                    } else {
                                        $img = '<img src="http://placehold.it/360x250&text=Course">';
                                    }
                                    $active_html .= '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
                $active_html .= '</div>';

		    		$active_html .= '<section class="entry">';

                        $active_html .= '<div class="course-flexible-area">';
                
                            // Title
                            $active_html .= '<header>';

                                $active_html .= '<h2><a href="' . esc_url( get_permalink( absint( $course_item->ID ) ) ) . '" title="' . esc_attr( $course_item->post_title ) . '">' . esc_html( $course_item->post_title ) . '</a></h2>';

                            $active_html .= '</header>';

                            $active_html .= '<p class="sensei-course-meta">';

                                // Author
                                $user_info = get_userdata( absint( $course_item->post_author ) );
                                if ( isset( $woothemes_sensei->settings->settings[ 'course_author' ] ) && ( $woothemes_sensei->settings->settings[ 'course_author' ] ) ) {
                                    $active_html .= '<span class="course-author">' . __( 'by ', 'boss-sensei' ) . '<a href="' . esc_url( get_author_posts_url( absint( $course_item->post_author ) ) ) . '" title="' . esc_attr( $user_info->display_name ) . '">' . esc_html( $user_info->display_name ) . '</a></span>';
                                } // End If Statement
                
                            $active_html .= '</p>';
                        
                        $active_html .= '</div>';   
                            
                        $active_html .= '<p class="sensei-course-meta">';
                            // Lesson count for this author
                            $lesson_count = $woothemes_sensei->post_types->course->course_lesson_count( absint( $course_item->ID ) );
                            // Handle Division by Zero
                            if ( 0 == $lesson_count ) {
                                $lesson_count = 1;
                            } // End If Statement
                            $active_html .= '<span class="course-lesson-count">' . $lesson_count . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ) . '</span>';
                            // Course Categories
//                            if ( '' != $category_output ) {
//                                $active_html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-sensei' ), $category_output ) . '</span>';
//                            } // End If Statement
                            $active_html .= '<span class="course-lesson-progress">' . sprintf( __( '%1$d of %2$d lessons completed', 'boss-sensei' ) , $lessons_completed, $lesson_count  ) . '</span>';

                        $active_html .= '</p>';

                        $progress_percentage = abs( round( ( doubleval( $lessons_completed ) * 100 ) / ( $lesson_count ), 0 ) );

                        if ( 50 < $progress_percentage ) { $class = ' green'; } elseif ( 25 <= $progress_percentage && 50 >= $progress_percentage ) { $class = ' orange'; } else { $class = ' red'; }

                        /* if ( 0 == $progress_percentage ) { $progress_percentage = 5; } */

                        $active_html .= '<div class="meter' . esc_attr( $class ) . '"><span style="width: ' . $progress_percentage . '%"></span></div>';

                        $active_html .= '<div class="meter-bottom"><span style="width: ' . $progress_percentage . '%"><span>' . $progress_percentage . '%</span></span></div>';
                

		    		$active_html .= '</section>';

		    		if( $manage ) {

			    		$active_html .= '<section class="entry-actions">';

                        $active_html .= '<form method="POST" action="' . esc_url( remove_query_arg( array( 'active_page', 'completed_page' ) ) ) . '">';

			    				$active_html .= '<input type="hidden" name="' . esc_attr( 'woothemes_sensei_complete_course_noonce' ) . '" id="' . esc_attr( 'woothemes_sensei_complete_course_noonce' ) . '" value="' . esc_attr( wp_create_nonce( 'woothemes_sensei_complete_course_noonce' ) ) . '" />';

			    				$active_html .= '<input type="hidden" name="course_complete_id" id="course-complete-id" value="' . esc_attr( absint( $course_item->ID ) ) . '" />';

			    				if ( 0 < absint( count( $course_lessons ) ) && $woothemes_sensei->settings->settings['course_completion'] == 'complete' ) {
			    					$active_html .= '<span><button name="course_complete" type="submit" class="course-complete" value="' . apply_filters( 'sensei_mark_as_complete_text', __( 'Mark as Complete', 'boss-sensei' ) ) . '">' .  __( 'Mark as Complete', 'boss-sensei' ) . '</button></span>';
			    				} // End If Statement

			    				$course_purchased = false;
			    				if ( WooThemes_Sensei_Utils::sensei_is_woocommerce_activated() ) {
			    					// Get the product ID
			    					$wc_post_id = get_post_meta( absint( $course_item->ID ), '_course_woocommerce_product', true );
			    					if ( 0 < $wc_post_id ) {
			    						$course_purchased = WooThemes_Sensei_Utils::sensei_customer_bought_product( $user->user_email, $user->ID, $wc_post_id );
			    					} // End If Statement
			    				} // End If Statement

			    				if ( ! $course_purchased ) {
			    					$active_html .= '<span><button name="course_complete" type="submit" class="course-delete" value="' . apply_filters( 'sensei_delete_course_text', __( 'Delete Course', 'boss-sensei' ) ) . '"/><i class="fa fa-trash"></i>' . __( 'Delete Course', 'boss-sensei' ) . '</button></span>';
			    				} // End If Statement

			    			$active_html .= '</form>';

			    		$active_html .= '</section>';
			    	}

		    	$active_html .= '</div>';
                
		    	$active_html .= '</article>';
			}

			// Active pagination
			if( $active_count > $per_page ) {

				$current_page = 1;
				if( isset( $_GET['active_page'] ) && 0 < intval( $_GET['active_page'] ) ) {
					$current_page = $_GET['active_page'];
				}

				$active_html .= '<nav class="pagination woo-pagination">';
				$total_pages = ceil( $active_count / $per_page );

				$link = '';

				if( $current_page > 1 ) {
					$prev_link = add_query_arg( 'active_page', $current_page - 1 );
					$active_html .= '<a class="prev page-numbers" href="' . esc_url( $prev_link ) . '">' . __( 'Previous' , 'boss-sensei' ) . '</a> ';
				}

				for ( $i = 1; $i <= $total_pages; $i++ ) {
					$link = add_query_arg( 'active_page', $i );

					if( $i == $current_page ) {
						$active_html .= '<span class="page-numbers current">' . $i . '</span> ';
					} else {
						$active_html .= '<a class="page-numbers" href="' . esc_url( $link ). '">' . $i . '</a> ';
					}
				}

				if( $current_page < $total_pages ) {
					$next_link = add_query_arg( 'active_page', $current_page + 1 );
					$active_html .= '<a class="next page-numbers" href="' . esc_url( $next_link ) . '">' . __( 'Next' , 'boss-sensei' ) . '</a> ';
				}

				$active_html .= '</nav>';
			}

			foreach ( $completed_courses as $course_item ) {
				$course = $course_item;

			    // Get Course Categories
			    $category_output = get_the_term_list( $course_item->ID, 'course-category', '', ', ', '' );

		    	$complete_html .= '<article class="' . join( ' ', get_post_class( array( 'course', 'post' ), $course_item->ID ) ) . '">';

                $complete_html .= '<div class="course-inner">';

                    $post_id = $course_item->ID;
                    $post_title = $course_item->post_title;
                    $user_info = get_userdata( absint( $course_item->post_author ) );
                    $author_link = get_author_posts_url( absint( $course_item->post_author ) );
                    $author_avatar = get_avatar( $course_item->post_author, 75 );
                    $author_display_name = $user_info->display_name;
                    $author_id = $course_item->post_author;

                    $complete_html .= '<div class="course-image">
                                        <div class="course-mask"></div>
                                        <div class="course-border"><div class="course-border-inner"></div></div>
                                        <div class="course-overlay">
                                            <a href="'. $author_link . '" title="' . esc_attr( $author_display_name ) .'">' . $author_avatar . '</a>
                                            <a href="'. get_permalink( $post_id ) .'" title="' . esc_attr( $post_title ) . '" class="play">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>';
                                        if ( has_post_thumbnail( $post_id ) ) {
                                            // Get Featured Image
                                            $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                                        } else {
                                            $img = '<img src="http://placehold.it/360x250&text=Course">';
                                        }
                                        $complete_html .= '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
                    $complete_html .= '</div>';

		    		$complete_html .= '<section class="entry">';
                            
                            
                        $complete_html .= '<div class="course-flexible-area">';
                        
                            // Title
                            $complete_html .= '<header>';

                                $complete_html .= '<h2><a href="' . esc_url( get_permalink( absint( $course_item->ID ) ) ) . '" title="' . esc_attr( $course_item->post_title ) . '">' . esc_html( $course_item->post_title ) . '</a></h2>';

                            $complete_html .= '</header>';

                            $complete_html .= '<p class="sensei-course-meta">';

                                // Author
                                $user_info = get_userdata( absint( $course_item->post_author ) );
                                if ( isset( $woothemes_sensei->settings->settings[ 'course_author' ] ) && ( $woothemes_sensei->settings->settings[ 'course_author' ] ) ) {
                                    $complete_html .= '<span class="course-author">' . __( 'by ', 'boss-sensei' ) . '<a href="' . esc_url( get_author_posts_url( absint( $course_item->post_author ) ) ) . '" title="' . esc_attr( $user_info->display_name ) . '">' . esc_html( $user_info->display_name ) . '</a></span>';
                                } // End If Statement
                                
                            $complete_html .= '</p>';
                            
                        $complete_html .= '</div>';
                                
                        $complete_html .= '<p class="sensei-course-meta">';
		    		    	// Lesson count for this author
		    		    	$complete_html .= '<span class="course-lesson-count">' . $woothemes_sensei->post_types->course->course_lesson_count( absint( $course_item->ID ) ) . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ) . '</span>';
		    		    	// Course Categories
//		    		    	if ( '' != $category_output ) {
//		    		    		$complete_html .= '<span class="course-category">' . sprintf( __( 'in %s', 'boss-sensei' ), $category_output ) . '</span>';
//		    		    	} // End If Statement

						$complete_html .= '</p>';

                        $complete_html .= $this->get_progress_meter( 100 );

						if( $manage ) {
							$has_quizzes = $woothemes_sensei->post_types->course->course_quizzes( $course_item->ID, true );
							// Output only if there is content to display
							if ( has_filter( 'sensei_results_links' ) || $has_quizzes ) {
								$complete_html .= '<p class="sensei-results-links">';
								$results_link = '';
								if( $has_quizzes ) {
									$results_link = '<a class="button view-results" href="' . $woothemes_sensei->course_results->get_permalink( $course_item->ID ) . '">' . apply_filters( 'sensei_view_results_text', __( 'View results', 'boss-sensei' ) ) . '</a>';
								}
								$complete_html .= apply_filters( 'sensei_results_links', $results_link );
								$complete_html .= '</p>';
							}
						}

		    		$complete_html .= '</section>';

		    	$complete_html .= '</article>';
			}

			// Active pagination
			if( $completed_count > $per_page ) {

				$current_page = 1;
				if( isset( $_GET['completed_page'] ) && 0 < intval( $_GET['completed_page'] ) ) {
					$current_page = $_GET['completed_page'];
				}

				$complete_html .= '<nav class="pagination woo-pagination">';
				$total_pages = ceil( $completed_count / $per_page );

				$link = '';

				if( $current_page > 1 ) {
					$prev_link = add_query_arg( 'completed_page', $current_page - 1 );
					$complete_html .= '<a class="prev page-numbers" href="' . esc_url( $prev_link ) . '">' . __( 'Previous' , 'boss-sensei' ) . '</a> ';
				}

				for ( $i = 1; $i <= $total_pages; $i++ ) {
					$link = add_query_arg( 'completed_page', $i );

					if( $i == $current_page ) {
						$complete_html .= '<span class="page-numbers current">' . $i . '</span> ';
					} else {
						$complete_html .= '<a class="page-numbers" href="' . esc_url( $link ) . '">' . $i . '</a> ';
					}
				}

				if( $current_page < $total_pages ) {
					$next_link = add_query_arg( 'completed_page', $current_page + 1 );
					$complete_html .= '<a class="next page-numbers" href="' . esc_url( $next_link ) . '">' . __( 'Next' , 'boss-sensei' ) . '</a> ';
				}

				$complete_html .= '</nav>';
			}

		} // End If Statement

		if( $manage ) {
			$no_active_message = apply_filters( 'sensei_no_active_courses_user_text', __( 'You have no active courses.', 'boss-sensei' ) );
			$no_complete_message = apply_filters( 'sensei_no_complete_courses_user_text', __( 'You have not completed any courses yet.', 'boss-sensei' ) );
		} else {
			$no_active_message = apply_filters( 'sensei_no_active_courses_learner_text', __( 'This learner has no active courses.', 'boss-sensei' ) );
			$no_complete_message = apply_filters( 'sensei_no_complete_courses_learner_text', __( 'This learner has not completed any courses yet.', 'boss-sensei' ) );
		}

		ob_start();
		?>

		<?php do_action( 'sensei_before_user_courses' ); ?>

		<?php
		if( $manage && ( ! isset( $woothemes_sensei->settings->settings['messages_disable'] ) || ! $woothemes_sensei->settings->settings['messages_disable'] ) ) {
			?>
			<p class="my-messages-link-container"><a class="my-messages-link" href="<?php echo get_post_type_archive_link( 'sensei_message' ); ?>" title="<?php _e( 'View & reply to private messages sent to your course & lesson teachers.', 'boss-sensei' ); ?>"><?php _e( 'My Messages', 'boss-sensei' ); ?></a></p>
			<?php
		}
		?>
		<div id="my-courses">

		    <ul>
		    	<li><a href="#active-courses"><?php echo apply_filters( 'sensei_active_courses_text', __( 'Active Courses', 'boss-sensei' ) ); ?></a></li>
		    	<li><a href="#completed-courses"><?php echo apply_filters( 'sensei_completed_courses_text', __( 'Completed Courses', 'boss-sensei' ) ); ?></a></li>
		    </ul>

		    <?php do_action( 'sensei_before_active_user_courses' ); ?>

		    <?php $course_page_id = intval( $woothemes_sensei->settings->settings[ 'course_page' ] );
		    	if ( 0 < $course_page_id ) {
		    		$course_page_url = get_permalink( $course_page_id );
		    	} elseif ( 0 == $course_page_id ) {
		    		$course_page_url = get_post_type_archive_link( 'course' );
		    	} ?>

		    <div id="active-courses">

		    	<?php if ( '' != $active_html ) {
		    		echo $active_html;
		    	} else { ?>
		    		<div class="sensei-message info"><?php echo $no_active_message; ?> <a href="<?php echo $course_page_url; ?>"><?php apply_filters( 'sensei_start_a_course_text', _e( 'Start a Course!', 'boss-sensei' ) ); ?></a></div>
		    	<?php } // End If Statement ?>

		    </div>

		    <?php do_action( 'sensei_after_active_user_courses' ); ?>

		    <?php do_action( 'sensei_before_completed_user_courses' ); ?>

		    <div id="completed-courses">

		    	<?php if ( '' != $complete_html ) {
		    		echo $complete_html;
		    	} else { ?>
		    		<div class="sensei-message info"><?php echo $no_complete_message; ?></div>
		    	<?php } // End If Statement ?>

		    </div>

		    <?php do_action( 'sensei_after_completed_user_courses' ); ?>

		</div>

		<?php do_action( 'sensei_after_user_courses' ); ?>

		<?php
		return ob_get_clean();
	}
    

    /**
     * get active courses html
     * @return array
     */
    public function boss_edu_sensei_get_active_courses_html() {

        $user = get_userdata( bp_displayed_user_id() );
        $manage = bp_displayed_user_id() == bp_loggedin_user_id() ? true : false;
        global $woothemes_sensei, $post, $wp_query, $course, $my_courses_page, $my_courses_section;

    // Build Output HTML
        $complete_html = $active_html = '';

        if( $user ) {

            $my_courses_page = true;

            // Allow action to be run before My Courses content has loaded
            do_action( 'sensei_before_my_courses', $user->ID );

            // Logic for Active and Completed Courses
            $per_page = 20;
            if ( isset( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) && ( 0 < absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) ) ) {
                $per_page = absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] );
            }

            $course_statuses = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'user_id' => $user->ID, 'type' => 'sensei_course_status' ), true );
            // User may only be on 1 Course
            if ( !is_array($course_statuses) ) {
                $course_statuses = array( $course_statuses );
            }

            $completed_ids = $active_ids = array();
            foreach( $course_statuses as $course_status ) {
                if ( WooThemes_Sensei_Utils::user_completed_course( $course_status, $user->ID ) ) {
                    $completed_ids[] = $course_status->comment_post_ID;
                } else {
                    $active_ids[] = $course_status->comment_post_ID;
                }
            }

            $active_count = $completed_count = 0;

            $active_courses = array();
            if ( 0 < intval( count( $active_ids ) ) ) {
                $my_courses_section = 'active';
                $active_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $active_ids );
                $active_count = count( $active_ids );
            } // End If Statement

            $completed_courses = array();
            if ( 0 < intval( count( $completed_ids ) ) ) {
                $my_courses_section = 'completed';
                $completed_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $completed_ids );
                $completed_count = count( $completed_ids );
            } // End If Statement
            $lesson_count = 1;

            $active_page = 1;
            if( isset( $_GET['active_page'] ) && 0 < intval( $_GET['active_page'] ) ) {
                $active_page = $_GET['active_page'];
            }

            $completed_page = 1;
            if( isset( $_GET['completed_page'] ) && 0 < intval( $_GET['completed_page'] ) ) {
                $completed_page = $_GET['completed_page'];
            }
            foreach ( $active_courses as $course_item ) {
                $course = $course_item;

                $course_lessons = $woothemes_sensei->post_types->course->course_lessons( $course_item->ID );
                $lessons_completed = 0;
                foreach ( $course_lessons as $lesson ) {
                    if ( WooThemes_Sensei_Utils::user_completed_lesson( $lesson->ID, $user->ID ) ) {
                        ++$lessons_completed;
                    }
                }

                // Get Course Categories
                $category_output = get_the_term_list( $course_item->ID, 'course-category', '', ', ', '' );

                $active_html .= '<article class="' . esc_attr( join( ' ', get_post_class( array( 'course', 'post' ), $course_item->ID ) ) ) . '">';
                
                $active_html .= '<div class="course-inner">';
                
                $post_id = $course_item->ID;
                $post_title = $course_item->post_title;
                $user_info = get_userdata( absint( $course_item->post_author ) );
    			$author_link = get_author_posts_url( absint( $course_item->post_author ) );
                $author_avatar = get_avatar( $course_item->post_author, 75 );
    			$author_display_name = $user_info->display_name;
    			$author_id = $course_item->post_author;
                
                $active_html .= '<div class="course-image">
                                    <div class="course-mask"></div>
                                    <div class="course-border"><div class="course-border-inner"></div></div>
                                    <div class="course-overlay">
                                        <a href="'. $author_link . '" title="' . esc_attr( $author_display_name ) .'">' . $author_avatar . '</a>
                                        <a href="'. get_permalink( $post_id ) .'" title="' . esc_attr( $post_title ) . '" class="play">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>';
                                    if ( has_post_thumbnail( $post_id ) ) {
                                        // Get Featured Image
                                        $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                                    } else {
                                        $img = '<img src="http://placehold.it/360x250&text=Course">';
                                    }
                                    $active_html .= '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
                $active_html .= '</div>';

                $active_html .= '<section class="entry">';
                
                // Title
                $active_html .= '<header>';

                $active_html .= '<h2><a href="' . esc_url( get_permalink( absint( $course_item->ID ) ) ) . '" title="' . esc_attr( $course_item->post_title ) . '">' . esc_html( $course_item->post_title ) . '</a></h2>';

                $active_html .= '</header>';
                
                $active_html .= '<p class="sensei-course-meta">';

                // Author
                $user_info = get_userdata( absint( $course_item->post_author ) );
                if ( isset( $woothemes_sensei->settings->settings[ 'course_author' ] ) && ( $woothemes_sensei->settings->settings[ 'course_author' ] ) ) {
                    $active_html .= '<span class="course-author"><a href="' . esc_url( get_author_posts_url( absint( $course_item->post_author ) ) ) . '" title="' . esc_attr( $user_info->display_name ) . '">' . __( 'by ', 'boss-sensei' ) . esc_html( $user_info->display_name ) . '</a></span>';
                } // End If Statement
                // Lesson count for this author
                $lesson_count = $woothemes_sensei->post_types->course->course_lesson_count( absint( $course_item->ID ) );
                // Handle Division by Zero
                if ( 0 == $lesson_count ) {
                    $lesson_count = 1;
                } // End If Statement
                $active_html .= '<span class="course-lesson-count">' . $lesson_count . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ) . '</span>';
                $active_html .= '<span class="course-lesson-progress">' . sprintf( __( '%1$d of %2$d lessons completed', 'boss-sensei' ) , $lessons_completed, $lesson_count  ) . '</span>';

                $active_html .= '</p>';

                $progress_percentage = abs( round( ( doubleval( $lessons_completed ) * 100 ) / ( $lesson_count ), 0 ) );

                if ( 50 < $progress_percentage ) { $class = ' green'; } elseif ( 25 <= $progress_percentage && 50 >= $progress_percentage ) { $class = ' orange'; } else { $class = ' red'; }

                /* if ( 0 == $progress_percentage ) { $progress_percentage = 5; } */

                $active_html .= '<div class="meter' . esc_attr( $class ) . '"><span style="width: ' . $progress_percentage . '%"></span></div>';
                
                $active_html .= '<div class="meter-bottom"><span style="width: ' . $progress_percentage . '%"><span>' . $progress_percentage . '%</span></span></div>';
                
                $active_html .= '</section>';

                if( $manage ) {

                    $active_html .= '<section class="entry-actions">';

                    $active_html .= '<form method="POST" action="' . esc_url_raw(remove_query_arg( array( 'active_page', 'completed_page' ) )) . '">';

                    $active_html .= '<input type="hidden" name="' . esc_attr( 'woothemes_sensei_complete_course_noonce' ) . '" id="' . esc_attr( 'woothemes_sensei_complete_course_noonce' ) . '" value="' . esc_attr( wp_create_nonce( 'woothemes_sensei_complete_course_noonce' ) ) . '" />';

                    $active_html .= '<input type="hidden" name="course_complete_id" id="course-complete-id" value="' . esc_attr( absint( $course_item->ID ) ) . '" />';

                    if ( 0 < absint( count( $course_lessons ) ) && $woothemes_sensei->settings->settings['course_completion'] == 'complete' ) {
                        $active_html .= '<span><button name="course_complete" type="submit" class="course-complete" value="' . apply_filters( 'sensei_mark_as_complete_text', __( 'Mark as Complete', 'boss-sensei' ) ) . '">' . __( 'Mark as Complete', 'boss-sensei' ) . '</button></span>';
                    } // End If Statement

                    $course_purchased = false;
                    if ( WooThemes_Sensei_Utils::sensei_is_woocommerce_activated() ) {
                        // Get the product ID
                        $wc_post_id = get_post_meta( absint( $course_item->ID ), '_course_woocommerce_product', true );
                        if ( 0 < $wc_post_id ) {
                            $course_purchased = WooThemes_Sensei_Utils::sensei_customer_bought_product( $user->user_email, $user->ID, $wc_post_id );
                        } // End If Statement
                    } // End If Statement

                    if ( !$course_purchased ) {
                        $active_html .= '<span><button name="course_complete" type="submit" class="course-delete" value="' . apply_filters( 'sensei_delete_course_text', __( 'Delete Course', 'boss-sensei' ) ) . '"><i class="fa fa-trash"></i>' . __( 'Delete Course', 'boss-sensei' ) . '</button></span>';
                    } // End If Statement

                    $active_html .= '</form>';

                    $active_html .= '</section>';
                }

                $active_html .= '</div>';
                $active_html .= '</article>';
            }

            // Active pagination
            if( $active_count > $per_page ) {

                $current_page = 1;
                if( isset( $_GET['active_page'] ) && 0 < intval( $_GET['active_page'] ) ) {
                    $current_page = $_GET['active_page'];
                }

                $active_html .= '<nav class="pagination woo-pagination">';
                $total_pages = ceil( $active_count / $per_page );

                $link = '';

                if( $current_page > 0 ) {
                    $prev_link = esc_url(add_query_arg( 'active_page', $current_page - 1 ));
                    $active_html .= '<a class="prev page-numbers" href="' . $prev_link . '">' . __( 'Previous' , 'boss-sensei' ) . '</a> ';
                }

                for ( $i = 1; $i <= $total_pages; $i++ ) {
                    $link = esc_url(add_query_arg( 'active_page', $i ));

                    if( $i == $current_page ) {
                        $active_html .= '<span class="page-numbers current">' . $i . '</span> ';
                    } else {
                        $active_html .= '<a class="page-numbers" href="' . $link . '">' . $i . '</a> ';
                    }
                }

                if( $current_page < $total_pages ) {
                    $next_link = esc_url(add_query_arg( 'active_page', $current_page + 1 ));
                    $active_html .= '<a class="next page-numbers" href="' . $next_link . '">' . __( 'Next' , 'boss-sensei' ) . '</a> ';
                }

                $active_html .= '</nav>';
            }


        } // End If Statement

        if( $manage ) {
            $no_active_message = apply_filters( 'sensei_no_active_courses_user_text', __( 'You have no active courses.', 'boss-sensei' ) );
        } else {
            $no_active_message = apply_filters( 'sensei_no_active_courses_learner_text', __( 'This learner has no active courses.', 'boss-sensei' ) );
        }

        $return_data = array(
            'active_html' => $active_html,
            'no_active_message' => $no_active_message
        );
        return $return_data;
    }

    /**
     * get completed courses html
     * @return array
     */
    public function boss_edu_sensei_get_completed_courses_html() {
        $user = get_userdata( bp_displayed_user_id() );
        $manage = bp_displayed_user_id() == bp_loggedin_user_id() ? true : false;
        global $woothemes_sensei, $post, $wp_query, $course, $my_courses_page, $my_courses_section;

    // Build Output HTML
        $complete_html = $active_html = '';

        if( $user ) {

            $my_courses_page = true;

            // Allow action to be run before My Courses content has loaded
            do_action( 'sensei_before_my_courses', $user->ID );

            // Logic for Active and Completed Courses
            $per_page = 20;
            if ( isset( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) && ( 0 < absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] ) ) ) {
                $per_page = absint( $woothemes_sensei->settings->settings[ 'my_course_amount' ] );
            }

            $course_statuses = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'user_id' => $user->ID, 'type' => 'sensei_course_status' ), true );
            // User may only be on 1 Course
            if ( !is_array($course_statuses) ) {
                $course_statuses = array( $course_statuses );
            }

            $completed_ids = $active_ids = array();
            foreach( $course_statuses as $course_status ) {
                if ( WooThemes_Sensei_Utils::user_completed_course( $course_status, $user->ID ) ) {
                    $completed_ids[] = $course_status->comment_post_ID;
                } else {
                    $active_ids[] = $course_status->comment_post_ID;
                }
            }

            $active_count = $completed_count = 0;

            $active_courses = array();
            if ( 0 < intval( count( $active_ids ) ) ) {
                $my_courses_section = 'active';
                $active_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $active_ids );
                $active_count = count( $active_ids );
            } // End If Statement

            $completed_courses = array();
            if ( 0 < intval( count( $completed_ids ) ) ) {
                $my_courses_section = 'completed';
                $completed_courses = $woothemes_sensei->post_types->course->course_query( $per_page, 'usercourses', $completed_ids );
                $completed_count = count( $completed_ids );
            } // End If Statement
            $lesson_count = 1;

            $active_page = 1;
            if( isset( $_GET['active_page'] ) && 0 < intval( $_GET['active_page'] ) ) {
                $active_page = $_GET['active_page'];
            }

            $completed_page = 1;
            if( isset( $_GET['completed_page'] ) && 0 < intval( $_GET['completed_page'] ) ) {
                $completed_page = $_GET['completed_page'];
            }

            foreach ( $completed_courses as $course_item ) {
                $course = $course_item;

                // Get Course Categories
                $category_output = get_the_term_list( $course_item->ID, 'course-category', '', ', ', '' );

                $complete_html .= '<article class="' . join( ' ', get_post_class( array( 'course', 'post' ), $course_item->ID ) ) . '">';
                
                $complete_html .= '<div class="course-inner">';

                $post_id = $course_item->ID;
                $user_info = get_userdata( absint( $course_item->post_author ) );
    			$author_link = get_author_posts_url( absint( $course_item->post_author ) );
                $author_avatar = get_avatar( $course_item->post_author, 75 );
    			$author_display_name = $user_info->display_name;
    			$author_id = $course_item->post_author;
                
                $complete_html .= '<div class="course-image">
                                    <div class="course-mask"></div>
                                    <div class="course-border"><div class="course-border-inner"></div></div>
                                    <div class="course-overlay">
                                        <a href="'. $author_link . '" title="' . esc_attr( $author_display_name ) .'">' . $author_avatar . '</a>
                                        <a href="'. get_permalink( $post_id ) .'" title="' . esc_attr( $post_title ) . '" class="play">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>';
                                    if ( has_post_thumbnail( $post_id ) ) {
                                        // Get Featured Image
                                        $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );
                                    } else {
                                        $img = '<img src="http://placehold.it/360x250&text=Course">';
                                    }
                                    $complete_html .= '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
                $complete_html .= '</div>';

                $complete_html .= '<section class="entry">';
                
                 // Title
                $complete_html .= '<header>';

                $complete_html .= '<h2><a href="' . esc_url( get_permalink( absint( $course_item->ID ) ) ) . '" title="' . esc_attr( $course_item->post_title ) . '">' . esc_html( $course_item->post_title ) . '</a></h2>';

                $complete_html .= '</header>';

                $complete_html .= '<p class="sensei-course-meta">';

                // Author
                $user_info = get_userdata( absint( $course_item->post_author ) );
                if ( isset( $woothemes_sensei->settings->settings[ 'course_author' ] ) && ( $woothemes_sensei->settings->settings[ 'course_author' ] ) ) {
                    $complete_html .= '<span class="course-author">' . __( 'by ', 'boss-sensei' ) . '<a href="' . esc_url( get_author_posts_url( absint( $course_item->post_author ) ) ) . '" title="' . esc_attr( $user_info->display_name ) . '">' . esc_html( $user_info->display_name ) . '</a></span>';
                } // End If Statement

                // Lesson count for this author
                $complete_html .= '<span class="course-lesson-count">' . $woothemes_sensei->post_types->course->course_lesson_count( absint( $course_item->ID ) ) . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ) . '</span>';

                $complete_html .= '</p>';

                $complete_html .= '<div class="meter green"><span style="width: 100%"></span></div>';
                
                $complete_html .= '<div class="meter-bottom"><span style="width: 100%"><span>100%</span></span></div>';

                if( $manage ) {
                    $has_quizzes = count( $woothemes_sensei->post_types->course->course_quizzes( $course_item->ID ) ) > 0 ? true : false;
                    // Output only if there is content to display
                    if ( has_filter( 'sensei_results_links' ) || false != $has_quizzes ) {
                        $complete_html .= '<p class="sensei-results-links">';
                        $results_link = '';
                        if( false != $has_quizzes ) {
                            $results_link = '<a class="button view-results" href="' . $woothemes_sensei->course_results->get_permalink( $course_item->ID ) . '">' . apply_filters( 'sensei_view_results_text', __( 'View results', 'boss-sensei' ) ) . '</a>';
                        }
                        $complete_html .= apply_filters( 'sensei_results_links', $results_link );
                        $complete_html .= '</p>';
                    }
                }

                $complete_html .= '</section>';

                $complete_html .= '</div>';
                
                $complete_html .= '</article>';
            }

            // Active pagination
            if( $completed_count > $per_page ) {

                $current_page = 1;
                if( isset( $_GET['completed_page'] ) && 0 < intval( $_GET['completed_page'] ) ) {
                    $current_page = $_GET['completed_page'];
                }

                $complete_html .= '<nav class="pagination woo-pagination">';
                $total_pages = ceil( $completed_count / $per_page );

                $link = '';

                if( $current_page > 0 ) {
                    $prev_link = esc_url(add_query_arg( 'completed_page', $current_page - 1 ));
                    $complete_html .= '<a class="prev page-numbers" href="' . $prev_link . '">' . __( 'Previous' , 'boss-sensei' ) . '</a> ';
                }

                for ( $i = 1; $i <= $total_pages; $i++ ) {
                    $link = esc_url(add_query_arg( 'completed_page', $i ));

                    if( $i == $current_page ) {
                        $complete_html .= '<span class="page-numbers current">' . $i . '</span> ';
                    } else {
                        $complete_html .= '<a class="page-numbers" href="' . $link . '">' . $i . '</a> ';
                    }
                }

                if( $current_page < $total_pages ) {
                    $next_link = esc_url(add_query_arg( 'completed_page', $current_page + 1 ));
                    $complete_html .= '<a class="next page-numbers" href="' . $next_link . '">' . __( 'Next' , 'boss-sensei' ) . '</a> ';
                }

                $complete_html .= '</nav>';
            }

        } // End If Statement

        if( $manage ) {
            $no_complete_message = apply_filters( 'sensei_no_complete_courses_user_text', __( 'You have not completed any courses yet.', 'boss-sensei' ) );
        } else {
            $no_complete_message = apply_filters( 'sensei_no_complete_courses_learner_text', __( 'This learner has not completed any courses yet.', 'boss-sensei' ) );
        }

        $return_data = array(
            'complete_html' => $complete_html,
            'no_complete_message' => $no_complete_message
        );
        return $return_data;
    }
    

    /**
	 * Override sensei-buddypress path
     *  
	 */
    public function boss_edu_sensei_buddypress_path() {
        return $this->templates_dir . '/sensei-buddypress/';
    }
    
    /**
	 * Move quiz message
     *  
	 */
    public function boss_edu_quiz_message() {
        global $post, $woothemes_sensei, $current_user;

        // Handle Quiz Completion
        do_action( 'sensei_complete_quiz' );
        
        // Get User Meta
        get_currentuserinfo();
			
		if( empty( $quiz_id ) || ! intval( $quiz_id ) > 0 ){
			global $post;
			if( 'quiz' == get_post_type( $post ) ){
				$quiz_id = $post->ID;
			}else{
				return false;
			}

		}

		$quiz = get_post( $quiz_id );
		$lesson_id = $quiz->post_parent;
  
        // Display user's quiz status
        $status = WooThemes_Sensei_Utils::sensei_user_quiz_status_message( $lesson_id, $current_user->ID );
        echo '<div class="lesson-meta"><div class="sensei-message ' . $status['box_class'] . '">' . $status['message'] . '</div></div>';
    }
    
    /**
	 * Changing Module page
     *  
	 */
    public function boss_edu_change_modules() {
        global $woothemes_sensei;
        
        remove_action('sensei_single_course_modules_content', array( $woothemes_sensei->modules, 'course_module_content' ), 20);
        add_action('sensei_single_course_modules_content', array( $this, 'boss_edu_course_module_content' ), 20);
        
        remove_action( 'sensei_pagination', array( $woothemes_sensei->modules, 'module_navigation_links' ), 11 );
        add_action( 'sensei_lesson_archive_header', array( $woothemes_sensei->modules, 'module_navigation_links' ), 9 );

        remove_filter( 'sensei_lessons_archive_text', array( $woothemes_sensei->modules, 'module_archive_title' ) );
        add_filter( 'sensei_lessons_archive_text', array( $this, 'boss_edu_module_archive_title' ) );

        add_action( 'sensei_lesson_archive_header', array( $this, 'boss_edu_module_table_title' ), 12 );
    }
    
    /**
	 * Change Sensei-BuddyPress output
     *  
	 */
    public function boss_edu_remove_bp_sensei_hooks() {

        if ( function_exists( 'buddypress_sensei' ) ) {
            remove_action('sensei_course_single_meta', array( buddypress_sensei()->bp_sensei_loader,'bp_sensei_send_message_link' ),110) ; 
            remove_action('sensei_course_single_meta', array( buddypress_sensei()->bp_sensei_groups,'bp_sensei_group_discussion_button' ),110);
        } 

    }
    
    /**
    *  Adding icon to refresh button 
    *  
    */
    public function boss_edu_sensei_lesson_quiz_meta( $post_id = 0, $user_id = 0 ) {
		global $woothemes_sensei;
		// Get the prerequisite lesson
		$lesson_prerequisite = (int) get_post_meta( $post_id, '_lesson_prerequisite', true );
		$lesson_course_id = (int) get_post_meta( $post_id, '_lesson_course', true );

		// Lesson Quiz Meta
		$quiz_id = $woothemes_sensei->post_types->lesson->lesson_quizzes( $post_id );
		$has_user_completed_lesson = WooThemes_Sensei_Utils::user_completed_lesson( intval( $post_id ), $user_id );
		$show_actions = is_user_logged_in() ? true : false;

		if( intval( $lesson_prerequisite ) > 0 ) {

			// If the user hasn't completed the prereq then hide the current actions
			$show_actions = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_prerequisite, $user_id );
		}
		?><header><?php
		if ( $quiz_id && is_user_logged_in() && WooThemes_Sensei_Utils::user_started_course( $lesson_course_id, $user_id ) ) { ?>
            <?php $no_quiz_count = 0; ?>
        	<?php
        		$has_quiz_questions = get_post_meta( $post_id, '_quiz_has_questions', true );
	        	// Display lesson quiz status message
	        	if ( $has_user_completed_lesson || $has_quiz_questions ) {
	        		$status = WooThemes_Sensei_Utils::sensei_user_quiz_status_message( $post_id, $user_id, true );
	        		//echo '<div class="sensei-message ' . $status['box_class'] . '">' . $status['message'] . '</div>';
	    			if( $has_quiz_questions ) {
	        			echo $status['extra'];
    				} // End If Statement
    			} // End If Statement
        	?>
        <?php } elseif( $show_actions && $quiz_id && $woothemes_sensei->access_settings() ) { ?>
    		<?php
        		$has_quiz_questions = get_post_meta( $post_id, '_quiz_has_questions', true );
        		if( $has_quiz_questions ) { ?>
        			<p><a class="button" href="<?php echo esc_url( get_permalink( $quiz_id ) ); ?>" title="<?php echo esc_attr( apply_filters( 'sensei_view_lesson_quiz_text', __( 'View the Lesson Quiz', 'boss-sensei' ) ) ); ?>"><?php echo apply_filters( 'sensei_view_lesson_quiz_text', __( 'View the Lesson Quiz', 'boss-sensei' ) ); ?></a></p>
        		<?php } ?>
        <?php } // End If Statement
        if ( $show_actions && ! $has_user_completed_lesson ) {
        	sensei_complete_lesson_button();
        } elseif( $show_actions ) {
        	$this->boss_edu_sensei_reset_lesson_button();
        } // End If Statement
        ?></header><?php
	} // End sensei_lesson_quiz_meta()
    
	public function boss_edu_sensei_reset_lesson_button() {
		global $woothemes_sensei, $post;

		$quiz_id = 0;

		// Lesson quizzes
		$quiz_id = $woothemes_sensei->post_types->lesson->lesson_quizzes( $post->ID );
		$reset_allowed = true;
		if( $quiz_id ) {
			// Get quiz pass setting
			$reset_allowed = get_post_meta( $quiz_id, '_enable_quiz_reset', true );
		}
		if ( ! $quiz_id || !empty($reset_allowed) ) {
		?>
		<form method="POST" action="<?php echo esc_url( get_permalink() ); ?>">
            <input type="hidden" name="<?php echo esc_attr( 'woothemes_sensei_complete_lesson_noonce' ); ?>" id="<?php echo esc_attr( 'woothemes_sensei_complete_lesson_noonce' ); ?>" value="<?php echo esc_attr( wp_create_nonce( 'woothemes_sensei_complete_lesson_noonce' ) ); ?>" />
            <span><button type="submit" name="quiz_complete" class="quiz-submit reset" value="<?php echo apply_filters( 'sensei_reset_lesson_text', __( 'Reset Lesson', 'boss-sensei' ) ); ?>"><i class="fa fa-refresh"></i><?php _e( 'Reset Lesson', 'boss-sensei' ) ; ?></button></span>
        </form>
		<?php
		} // End If Statement
	} // End sensei_reset_lesson_button()

    

    /**
	 * Add title to module lessons table
     *
	 * @return string   
	 */
	public function boss_edu_module_table_title() {
        $count = $GLOBALS['wp_query']->post_count;
        $count_string = sprintf( _n( '%s Lesson', '%s Lessons', $count ), $count );
		echo '<div id="module_stats"><h3>' . __('Module Lessons', 'boss-sensei') . '</h3><span>' . $count_string . '</span></div>';
	}
    
    /**
	 * Modify archive page title
	 * @param  string $title Default title
	 * @return string        Modified title
	 */
	public function boss_edu_module_archive_title( $title ) {
        global $woothemes_sensei;
		if( is_tax( $woothemes_sensei->modules->taxonomy ) ) {
			$title = apply_filters( 'sensei_module_archive_title', get_queried_object()->name );
		}
		return '<span>Module</span> '.$title;
	}
    
    /**
	 * Change Button text
	 */
    public function boss_edu_filter_start_button() {
        return __( 'Start Course', 'boss-sensei' );
    }
    
    /**
	 * Sensei sidebar
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @access public
	 *
	 * @uses register_sidebar()
	 */
    public function boss_edu_sidebar() {
        
        global $woothemes_sensei;
        if($woothemes_sensei) {
            
            register_sidebar( array(
                'name' 			=> 'Sensei &rarr; Default',
                'id'	 		=> 'sensei-default',
                'description' 	=> 'Only display on Sensei Quiz pages',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' 	=> '</aside>',
                'before_title' 	=> '<h4 class="widgettitle">',
                'after_title' 	=> '</h4>',
            ) ); 
            register_sidebar( array(
                'name' 			=> 'Sensei &rarr; Courses',
                'id'	 		=> 'sensei-courses',
                'description' 	=> 'Only display on Sensei Course pages',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' 	=> '</aside>',
                'before_title' 	=> '<h4 class="widgettitle">',
                'after_title' 	=> '</h4>',
            ) );
            register_sidebar( array(
                'name' 			=> 'Sensei &rarr; Course',
                'id'	 		=> 'sensei-course',
                'description' 	=> 'Only display on Sensei Course pages',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' 	=> '</aside>',
                'before_title' 	=> '<h4 class="widgettitle">',
                'after_title' 	=> '</h4>',
            ) ); 
            register_sidebar( array(
                'name' 			=> 'Sensei &rarr; Lesson',
                'id'	 		=> 'sensei-lesson',
                'description' 	=> 'Display on Sensei Lesson and Module pages',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' 	=> '</aside>',
                'before_title' 	=> '<h4 class="widgettitle">',
                'after_title' 	=> '</h4>',
            ) ); 
            register_sidebar( array(
                'name' 			=> 'Sensei &rarr; Quiz',
                'id'	 		=> 'sensei-quiz',
                'description' 	=> 'Only display on Sensei Quiz pages',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' 	=> '</aside>',
                'before_title' 	=> '<h4 class="widgettitle">',
                'after_title' 	=> '</h4>',
            ) ); 
        }
    }
    
    /**
    * Sensei plugin wrappers
    *
    */    

    public function boss_edu_content_wrappers() {
        global $woothemes_sensei;

        remove_action('sensei_before_main_content', 'boss_education_wrapper_start', 10);
        add_action('sensei_before_main_content', array( $this, 'boss_edu_wrapper_start'), 10);

        remove_action('sensei_after_main_content', 'boss_education_wrapper_end', 10);
        add_action('sensei_after_main_content', array( $this, 'boss_edu_wrapper_end'), 10);
    }
    
    /**
    * Start wrapper
    *
    */   
    public function boss_edu_wrapper_start() {
        if ( ( is_active_sidebar('sensei-lesson') && ( is_singular('lesson') || is_tax($woothemes_sensei->modules->taxonomy ) ) )
            || ( is_active_sidebar('sensei-quiz') && is_singular('quiz') )
            || is_singular( 'course' ) 
            || is_active_sidebar('sensei-default') ) :
            echo '<div class="page-right-sidebar">';
        else : 
            echo '<div class="page-full-width">';
        endif;
        echo '<div id="primary" class="site-content"><div id="content" role="main" class="sensei-content">';
    }

    /**
    * End wrapper
    *
    */ 
    public function boss_edu_wrapper_end() {
        echo '</div><!-- #content -->
        </div><!-- #primary -->';
        if ( is_active_sidebar('sensei-lesson') && ( is_singular('lesson') || ( is_tax($woothemes_sensei->modules->taxonomy ) && !is_tax('course-category') ) ) ) { $this->boss_edu_load_template('sidebar-sensei-lesson'); }
        elseif ( is_active_sidebar('sensei-quiz') && is_singular('quiz') ) { $this->boss_edu_load_template('sidebar-sensei-quiz'); }
        elseif ( is_singular( 'course' ) ) { $this->boss_edu_load_template('sidebar-sensei-course'); }
        elseif ( is_active_sidebar('sensei-courses') && is_tax('course-category') ) { $this->boss_edu_load_template('sidebar-sensei-courses'); }
        elseif ( is_active_sidebar('sensei-default') ) { $this->boss_edu_load_template('sidebar-sensei-default'); }

        echo '</div><!-- .page-right-sidebar -->';
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
				register_widget( 'Boss_Edu_' . $value . '_Widget' );
			}
		} // End For Loop
	} // End register_widgets()
    
    /**
	 * Enqueue styles and scripts for various plugins.
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @access public
	 *
	 */
    public function boss_edu_enqueue_scripts() 
    {
        // Woo Sensei scripts
        global $woothemes_sensei;
        if($woothemes_sensei) {

            // Styles
            // wp_enqueue_style( 'sensei', $this->assets_url . '/css/sensei.css', array(), '1.0.1', 'all' );
            wp_enqueue_style( 'sensei', $this->assets_url . '/css/sensei.min.css', array(), '1.0.1', 'all' );
            
            // Javascript
            //wp_enqueue_script( 'sensei', $this->assets_url . '/js/sensei.js', array('jquery'), '1.0.1', true );
            wp_enqueue_script( 'sensei', $this->assets_url . '/js/sensei.min.js', array('jquery'), '1.0.1', true );
        }
    }
    
    /**
	 * Check for sensei templates in plugin
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @access public
	 *
	 */
    public function boss_edu_sensei_locate_template( $template, $template_name, $template_path ) {

      global $woothemes_sensei;

      $_template = $template;
      if ( ! $template_path ) $template_path = $woothemes_sensei->template_url;
      $plugin_path  = $this->templates_dir . '/sensei/';


      // Look within passed path within the theme - this is priority
      $template = locate_template(
        array(
          $template_path . $template_name,
          $template_name
        )
      );

      // Modification: Get the template from this plugin, if it exists
      if ( ! $template && file_exists( $plugin_path . $template_name ) )
        $template = $plugin_path . $template_name;


      // Use default template
      if ( ! $template )
        $template = $_template;
        
      // Return what we found
      return $template;

    }   
    
    /**
	 * Check for sidebar templates
	 *
	 * @since Boss for Sensei (1.0.0)
	 * @access public
	 *
	 */
    public function boss_edu_load_template( $template ) {
        $template .= '.php';
        if( file_exists( STYLESHEETPATH.'/boss-sensei/'.$template ) )
            include_once( STYLESHEETPATH.'/boss-sensei/'.$template );
        else if( file_exists( TEMPLATEPATH.'boss-sensei/'.$template ) )
            include_once( TEMPLATEPATH.'/boss-sensei/'.$template );
        else{
            $template_dir = apply_filters( 'boss_edu_templates_dir_filter', $this->templates_dir );
            include_once trailingslashit( $template_dir ) . $template;
        }
    }
    
	/**
	 * boss_edu_sensei_get_template_part function.
	 *
	 * @access public
	 * @param mixed $slug
	 * @param string $name (default: '')
	 * @return void
	 */
	public function boss_edu_sensei_get_template_part( $slug, $name = '' ) {

		global $woothemes_sensei;
		$template = '';
        $plugin_path  = $this->templates_dir . '/sensei/';

		// Look in yourtheme/slug-name.php and yourtheme/sensei/slug-name.php
		if ( $name )
			$template = locate_template( array ( "{$slug}-{$name}.php", "{$woothemes_sensei->template_url}{$slug}-{$name}.php" ) );
        
        // Modification: Get the template from this plugin, if it exists
        if ( ! $template && file_exists( $plugin_path . "{$slug}-{$name}.php" ) )
            $template = $plugin_path . "{$slug}-{$name}.php";

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( $woothemes_sensei->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
			$template = $woothemes_sensei->plugin_path() . "/templates/{$slug}-{$name}.php";

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/sensei/slug.php
		if ( !$template )
			$template = locate_template( array ( "{$slug}.php", "{$woothemes_sensei->template_url}{$slug}.php" ) );

		if ( $template )
			load_template( $template, false );
	} // End boss_edu_sensei_get_template_part()

    
	public function boss_edu_sensei_single_main_content() {
		while ( have_posts() ) {
			the_post();
			if ( is_singular( 'course' ) ) {
				$this->boss_edu_sensei_get_template_part( 'content', 'single-course' );
			} elseif( is_singular( 'lesson' ) ) {
				$this->boss_edu_sensei_get_template_part( 'content', 'single-lesson' );
				do_action( 'sensei_comments' );
			} elseif( is_singular( 'quiz' ) ) {
				$this->boss_edu_sensei_get_template_part( 'content', 'single-quiz' );
			} elseif( is_singular( 'sensei_message' ) ) {
				$this->boss_edu_sensei_get_template_part( 'content', 'single-message' );
				do_action( 'sensei_comments' );
			} // End If Statement
		} // End While Loop
	} // End sensei_single_main_content()
    
    /**
	 * Load plugin text domain
	 *
	 * @since Boss for Sensei (1.0.0)
	 *
	 * @uses sprintf() Format .mo file
	 * @uses get_locale() Get language
	 * @uses file_exists() Check for language file
	 * @uses load_textdomain() Load language file
	 */
	public function setup_textdomain()
	{
		$domain = 'boss-sensei';
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		//first try to load from wp-content/languages/plugins/ directory
		load_textdomain($domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo');

		//if not found, then load from boss-sensei/languages/ directory
		load_plugin_textdomain( 'boss-sensei', false, $this->lang_dir );
	}
	
	/**
	 * Teacher contact form markup
	 * 
	 * @since Boss for Sensei (1.0.0)
	 * 
	 * @global type $current_user
	 * @param type $post
	 * @return string
	 */
	public function boss_edu_teacher_contact_form( $post ) {

		if( ! is_user_logged_in() ) return;

		global $current_user;
		wp_get_current_user();

		$html = '';

		if( ! isset( $post->ID ) ) return $html;

		$html .= '<h3 id="private_message">' . __( 'Send Private Message', 'woothemes-sensei' ) . '</h3>';
        $html .= '<p>';
        $html .=  $confirmation;
        $html .= '</p>';
		$html .= '<form name="contact-teacher" action="" method="post" class="contact-teacher">';
			$html .= '<p class="form-row form-row-wide">';
				$html .= '<textarea class="boss-edu-teacher-message" name="contact_message" placeholder="' . __( 'Enter your private message.', 'woothemes-sensei' ) . '"></textarea>';
			$html .= '</p>';
			$html .= '<p class="form-row">';
				$html .= '<input type="hidden" class="boss-edu-msg-course-id" name="post_id" value="' . $post->ID . '" />';
				$html .= '<input type="hidden" class="boss-edu-msg-sender-id" name="sender_id" value="' . $current_user->ID . '" />';
				$html .= '<input type="hidden" class="boss-edu-msg-receiver-id" name="receiver_id" value="' . $post->post_author . '" />';
				$html .= wp_nonce_field( 'message_teacher', 'boss_edu_sensei_message_teacher_nonce', true, false );
				$html .= '<input type="submit" class="boss-edu-send-message-widget" value="' . __( 'Send Message', 'woothemes-sensei' ) . '" />';
			$html .= '</p>';
			$html .= '<div class="fix"></div>';
		$html .= '</form>';

		return $html;
	}
	
	/**
	 * Ajax handling for contact a teacher button
	 */
	public function boss_edu_contact_teacher_ajax() {
		$msg_content = $_POST['content'];
		if ( empty( $msg_content ) ) {
			echo 'Failed';
			die();
		}
		$sender_id = $_POST['sender_id'];
		$reciever_id = $_POST['reciever_id'];
		$course_id = $_POST['course_id'];
		$subject = 'Regarding' .get_the_title($course_id);
		
		$args = array( 'recipients' => array($reciever_id), 'sender_id' => $sender_id, 'subject' => $subject, 'content' => $msg_content );
		$msg_id = messages_new_message( $args );
		
		echo $msg_id;
		
		die();
	}
    
}

endif;

?>