<?php
/**
 * DEBUG Functions
 *
 * @since Boss 1.0.0
 */

/**
 * Get the current template
 * @param  boolean $echo  Print the current template
 * @return string         Current template
 */
function get_current_template( $echo = false )
{
  if ( !isset( $GLOBALS['current_theme_template'] ) )
    return false;

  if ( $echo )
  {
    echo $GLOBALS['current_theme_template'];
  }
  else {
    return $GLOBALS['current_theme_template'];
  }
}

/**
 * Store the template file that will be called
 */
function var_template_include( $t )
{
  $GLOBALS['current_theme_template'] = basename( $t );

  return $t;
}
add_filter( 'template_include', 'var_template_include', 1000 );

/**
 * Lists all hooked functions
 * @param  string $tag Will list only functions specific to this tag
 */
function list_hooked_functions( $tag = false )
{
  global $wp_filter;

  if ( $tag )
  {
    $hook[$tag] = $wp_filter[$tag];

    if ( ! is_array( $hook[$tag] ) )
    {
      trigger_error( "Nothing found for '$tag' hook", E_USER_WARNING );

      return;
    }
  }
  else {
    $hook = $wp_filter;
    ksort( $hook );
  }

  echo '<pre>';

  foreach ( $hook as $tag => $priority )
  {
    echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";

    ksort( $priority );

    foreach ( $priority as $priority => $function )
    {
      echo $priority;

      foreach ( $function as $name => $properties )
      {
        echo "\t$name<br />";
      }
    }
  }

  echo '</pre>';

  return;
}

/**
 * Add to debug log
 */
function buddyboss_log( $msg )
{
  if ( ! BUDDYBOSS_DEBUG )
    return false;

  global $buddyboss_debug_log;

  $buddyboss_debug_log .= " <li> <pre>" . print_r( $msg, true ) . "</pre> </li>";
}

/**
 * Prints the debug log
 */
function buddyboss_dump_log()
{
  if ( ! BUDDYBOSS_DEBUG )
    return false;

  return;

  global $buddyboss_debug_log;

  ?>
  <style type="text/css">
  .buddyboss_debug {
    clear: both;
    font: 16px Consolas, monospace;
    padding: 20px;
    background: #101011;
    color: #f9f9ff;
  }
  .buddyboss_debug ul {
    list-style: none;
  }
  .buddyboss_debug li {
    margin: 6px 0;
  }
  </style>
  <div class="clearfix buddyboss_debug">
    <h2>DEBUG LOG</h2>
    <pre><code>
      <ul><?php echo $buddyboss_debug_log; ?></ul>
    </code></pre>
  </div>
  <?php
}

/**
 * Determine if we're on a local host or live/production
 * @return boolean
 */
function buddyboss_is_dev()
{
  return (bool)stristr( home_url(), 'buddyboss.comd' );
}

/**
 * Force all user meta last activity to be updated
 */
function buddyboss_update_all_user_meta()
{
  global $wpdb;

  // Get all users
  $user_sql = "SELECT ID from wp_users WHERE user_status = 0";

  $users = $wpdb->get_results( $user_sql, ARRAY_A );

  foreach( $users as $user )
  {
    // Get current time
    $current_time = bp_core_current_time();

    // bp_update_user_meta( $user['ID'], 'last_activity', $current_time );
  }
}
?>
