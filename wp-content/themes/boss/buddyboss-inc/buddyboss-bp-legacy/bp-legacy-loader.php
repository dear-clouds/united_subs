<?php
/**
 * @package Boss
 */

/**
 * Wizardry.
 */
class BuddyBoss_BP_Legacy {

	/**
	 * @var int
	 */
	private $stage;

	/**
	 * @var boolean
	 */
	private $is_bp;

	/**
	 * @var boolean
	 */
	private $check_legacy;

	/**
	 * @var boolean
	 */
	private $is_legacy;

	/**
	 * @var boolean
	 */
	public static $ran = false;

	/**
	 * If we're on a third party component this will store the name
	 * @var string
	 */
	private $bp_plugin_name = '';

	/**
	 * Init
	 */
	public function __construct()
	{
// 		add_action( 'bp_init', array( $this, 'bp_init' ) );
// 		add_action( 'template_redirect', array( $this, 'bp_init' ) );
        add_filter( 'template_redirect', array( $this, 'check_legacy' ), 0, 2 );
	}

	/**
	 * Checks for BuddyPress
	 */
	public function bp_init()
	{
		$this->stage++;

		if ( $this->stage === 2 )
			return;

		$this->is_bp = true;
    }

	public function check_legacy( $tpl )
	{
		$status = function_exists( 'buddypress' );

		if ( ! $status )
		    return $tpl;

		$this->bp_plugin_name = bp_get_name_from_root_slug();

		// This check fails for some plugins
		// $status = $this->bp_plugin_name != false;

		if ( $status )
		{
			$bp_defaults = array( 'members', 'xprofile', 'activity', 'blogs', 'messages', 'friends', 'groups', 'forums', 'settings' );

			foreach( $bp_defaults as $bp_default )
			{
				if ( bp_is_current_component( $bp_default ) )
				{
					break;
				}
			}
		}


		if ( $status && bp_is_directory() )
		{
			$this->is_legacy = $status = false;
		}

		if ( $status && false === (bool) locate_template( array( 'members/single/item-header.php' ), false ) )
		{

			add_action( 'wp_footer', array( $this, 'item_header' ) );
		}

		if ( $status )
		{
			add_action( 'wp_footer', array( $this, 'page_title' ) );

			add_action( 'wp_footer', array( $this, 'echo_legacy_tpl' ) );
		}

		return $tpl;
	}

	public function page_title()
	{
		// $tpl = locate_template( array( 'buddyboss-inc/buddyboss-bp-legacy/templates/page-title.php' ), false );

		// $exists = file_exists( $tpl );

		// var_dump( $tpl, $exists );

		ob_start();

		echo '<div class="buddyboss-bp-legacy page-title">';
		require_once( locate_template( array( 'buddyboss-inc/buddyboss-bp-legacy/templates/page-title.php' ) ) );
		echo '</div>';

		$this->page_title = ob_get_contents();

		ob_end_clean();
	}

	public function item_header()
	{
		ob_start();

		echo '<div class="buddyboss-bp-legacy item-header">';
		require_once( locate_template( array( 'buddyboss-inc/buddyboss-bp-legacy/templates/item-header.php' ) ) );
		echo '</div>';

		$this->item_header = ob_get_contents();

		ob_end_clean();
	}

	public function echo_legacy_tpl()
	{
		if ( isset( $this->ran ) )
			return;

		if ( ! empty( $this->page_title ) )
		{
			echo $this->page_title;
		}

		if ( ! empty( $this->item_header ) )
		{
			echo $this->item_header;
		}

		// var_dump( $this );

		self::$ran = true;
	}

	public function get_legacy_title()
	{
		global $bp;

		$markup = false;

		if ( is_object( $bp ) && ! empty( $bp->displayed_user )
			   && isset($bp->displayed_user->id) 
			   && $bp->displayed_user->id > 0
			   && function_exists( 'bp_core_get_user_domain' ) )
		{
			$user_id = (int) $bp->displayed_user->id;

			$user_link = bp_core_get_user_domain( $user_id );

			$title = esc_html( $bp->displayed_user->fullname );

			$markup = "<a href='$user_link' title=''>$title</a>";
		}
		else {
			$markup = $this->bp_plugin_name;
		}

		if ( ! empty( $markup ) )
		{
			return $markup;
		}
	}
}

function buddyboss_bp_legacy_init()
{
	global $buddyboss;
	$buddyboss->bp_legacy = new BuddyBoss_BP_Legacy;
}
add_action( 'init', 'buddyboss_bp_legacy_init' );

function buddyboss_bp_legacy_title()
{
	echo get_buddyboss_bp_legacy_title();
}
function get_buddyboss_bp_legacy_title()
{
	return boss()->bp_legacy->get_legacy_title();
}
?>
