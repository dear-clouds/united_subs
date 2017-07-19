<?php
/**
 * Plugin Name: BuddyPress for LearnDash
 * Plugin URI:  http://buddyboss.com/product/buddypress-learndash/
 * Description: Integrate the LearnDash LMS plugin with BuddyPress, so you can add courses to your social network.
 * Author:      BuddyBoss
 * Author URI:  http://buddyboss.com
 * Version:     1.2.0
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
  exit;

/**
 * ========================================================================
 * CONSTANTS
 * ========================================================================
 */
// Codebase version
if (!defined( 'BUDDYPRESS_LEARNDASH_PLUGIN_VERSION' ) ) {
  define( 'BUDDYPRESS_LEARNDASH_PLUGIN_VERSION', '1.2.0' );
}

// Database version
if (!defined( 'BUDDYPRESS_LEARNDASH_PLUGIN_DB_VERSION' ) ) {
  define( 'BUDDYPRESS_LEARNDASH_PLUGIN_DB_VERSION', 1 );
}

// Directory
if (!defined( 'BUDDYPRESS_LEARNDASH_PLUGIN_DIR' ) ) {
  define( 'BUDDYPRESS_LEARNDASH_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Url
if (!defined( 'BUDDYPRESS_LEARNDASH_PLUGIN_URL' ) ) {
  $plugin_url = plugin_dir_url( __FILE__ );

  // If we're using https, update the protocol. Workaround for WP13941, WP15928, WP19037.
  if ( is_ssl() )
    $plugin_url = str_replace( 'http://', 'https://', $plugin_url );

  define( 'BUDDYPRESS_LEARNDASH_PLUGIN_URL', $plugin_url );
}

// File
if (!defined( 'BUDDYPRESS_LEARNDASH_PLUGIN_FILE' ) ) {
  define( 'BUDDYPRESS_LEARNDASH_PLUGIN_FILE', __FILE__ );
}

/**
 * ========================================================================
 * MAIN FUNCTIONS
 * ========================================================================
 */

/**
 * Check whether
 * it meets all requirements
 * @return void
 */
function buddypress_learndash_requirements()
{

    global $Plugin_Requirements_Check;

    $requirements_Check_include  = BUDDYPRESS_LEARNDASH_PLUGIN_DIR  . 'includes/requirements-class.php';

    try
    {
        if ( file_exists( $requirements_Check_include ) )
        {
            require( $requirements_Check_include );
        }
        else{
            $msg = sprintf( __( "Couldn't load Plugin_Requirements_Check class at:<br/>%s", 'buddypress-learndash' ), $requirements_Check_include );
            throw new Exception( $msg, 404 );
        }
    }
    catch( Exception $e )
    {
        $msg = sprintf( __( "<h1>Fatal error:</h1><hr/><pre>%s</pre>", 'buddypress-learndash' ), $e->getMessage() );
        echo $msg;
    }

    $Plugin_Requirements_Check = new Plugin_Requirements_Check();
    $Plugin_Requirements_Check->activation_check();

}
register_activation_hook( __FILE__, 'buddypress_learndash_requirements' );

/**
 * Main
 *
 * @return void
 */
function BUDDYPRESS_LEARNDASH_init()
{
  global $bp, $BUDDYPRESS_LEARNDASH;

    //Check Learndash Plugin install and active
    if (  ! class_exists( 'SFWD_LMS' ) || ! function_exists( 'bp_is_active' ) ) {
        add_action( 'admin_notices', 'buddypress_learndash_install_notice' );
        return;
    }

    if ( version_compare( LEARNDASH_VERSION , '2.1.8', '<' ) ) {
        add_action( 'admin_notices', 'buddypress_learndash_upgrade_notice' );
        return;
    }

  $main_include  = BUDDYPRESS_LEARNDASH_PLUGIN_DIR  . 'includes/main-class.php';

  try
  {
    if ( file_exists( $main_include ) )
    {
      require( $main_include );
    }
    else{
      $msg = sprintf( __( "Couldn't load main class at:<br/>%s", 'buddypress-learndash' ), $main_include );
      throw new Exception( $msg, 404 );
    }
  }
  catch( Exception $e )
  {
    $msg = sprintf( __( "<h1>Fatal error:</h1><hr/><pre>%s</pre>", 'buddypress-learndash' ), $e->getMessage() );
    echo $msg;
  }

  $BUDDYPRESS_LEARNDASH = BuddyPress_LearnDash_Plugin::instance();

}
add_action( 'plugins_loaded', 'BUDDYPRESS_LEARNDASH_init' );

/**
 * Must be called after hook 'plugins_loaded'
 * @return BuddyPress for LearnDash Plugin main controller object
 */
function buddypress_learndash()
{
  global $BUDDYPRESS_LEARNDASH, $bp;

    //Check Learndash Plugin install and active
    if (  ! class_exists( 'SFWD_LMS' ) || ! function_exists( 'bp_is_active' ) ) {
        return $BUDDYPRESS_LEARNDASH;
    }

    //Bail if learndash version < 2.1.8
    if ( version_compare( LEARNDASH_VERSION , '2.1.8', '<' ) ) {
        return $BUDDYPRESS_LEARNDASH;
    }

  if ( $bp ) {
	$BUDDYPRESS_LEARNDASH->bp_learndash_loader = BuddyPress_Learndash_Loader::instance();
  }
  
  if ( $bp && bp_is_active('groups') ) {
	 $BUDDYPRESS_LEARNDASH->bp_learndash_groups = BuddyPress_Learndash_Groups::instance();
  }

  return $BUDDYPRESS_LEARNDASH;
}

/**
 * Show the admin notice to install/activate Learndash first
 */
function buddypress_learndash_install_notice() {
    echo '<div id="message" class="error fade"><p style="line-height: 150%">';
    _e('<strong>BuddyPress for LearnDash</strong> requires the LearnDash and BuddyPress plugins to work. Please intall <a href="http://www.learndash.com/" target="_blank">LearnDash</a> and <a href="https://buddypress.org/" target="_blank">BuddyPress</a> first.', 'buddypress-learndash');
    echo '</p></div>';
}


/**
 * Show the admin notice to update learndash first
 */
function buddypress_learndash_upgrade_notice() {
    echo '<div id="message" class="error fade"><p style="line-height: 150%">';
    _e('<strong>BuddyPress for LearnDash</strong> requires LearnDash v2.1.8 or higher to work. Please <a href="http://www.learndash.com/">update LearnDash</a> first.', 'buddypress-learndash');
    echo '</p></div>';
}