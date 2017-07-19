<?php
/**
 * Plugin Name: SP Favorite Groups
 * Plugin URI:  http://suiteplugins.com
 * Description: BuddyPress Addon for liking or favoriting groups. Filter activity by favorited groups.
 * Author:      SuitePlugins
 * Author URI:  http://suiteplugins.com
 * Version:     1.0.0
 * Text Domain: sp-favorite-groups
 * Domain Path: /languages/
 * License:     GPLv2 or later (license.txt)
 */

if(!class_exists('SP_Favorite_Groups')):

class SP_Favorite_Groups{
	
	public $meta_key = '_sp_favorite_groups';
	
	public function SP_Favorite_Groups(){
		add_action( 'plugins_loaded', array($this, 'plugin_load_textdomain'));
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions', array($this, 'sp_favorite_group_button'), 6 );
			
			add_action( 'wp_ajax_spfavortie_group', array($this, 'sp_set_favorite_group') );
			add_action('wp_footer', array($this, 'sp_add_footer_js'));
			add_shortcode('sp_favorite_groups', array($this, 'sp_favorite_groups_func'));
		}
		if( bp_is_active('groups')){
			add_filter('bp_get_activity_show_filters', array($this, 'sp_favorite_group_filter'), 12, 1 );
			add_filter('bp_ajax_querystring', array($this, 'sp_favorite_groups_activity_filter'), 12, 2 );
		}
		
	}
	
	
	public function plugin_load_textdomain(){
		load_plugin_textdomain( 'sp-favorite-groups', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}
	
	public function sp_favorite_group_button( $group = false ){
		echo $this->sp_get_favorite_group_button($group);
	}
	
	public function sp_get_favorite_group_button( $group = false ){
		global $groups_template;

		// Set group to current loop group if none passed
		if ( empty( $group ) ) {
			$group =& $groups_template->group;
		}

		// Don't show button if not logged in or previously banned
		if ( ! is_user_logged_in() || bp_group_is_user_banned( $group ) ) {
			return false;
		}

		// Group creation was not completed or status is unknown
		if ( empty( $group->status ) ) {
			return false;
		}

		// Already a member
		if ( ! empty( $group->is_member ) ||  $group->status=='public') {

			// Stop sole admins from abandoning their group
	 		$group_admins = groups_get_group_admins( $group->id );
		 	if ( ( 1 == count( $group_admins ) ) && ( bp_loggedin_user_id() === (int) $group_admins[0]->user_id ) ) {
				return false;
			}
			
			$user_favorite_groups = get_user_meta(bp_loggedin_user_id(), $this->meta_key, true);
			
			if(!empty($user_favorite_groups) && in_array($group->id, $user_favorite_groups)):
				// Setup button attributes
				$button = array(
					'id'                => 'favorite_group',
					'component'         => 'groups',
					'must_be_logged_in' => true,
					'block_self'        => false,
					'wrapper_class'     => 'group-button ' . $group->status,
					'wrapper_id'        => 'groupbutton-' . $group->id,
					'link_href'         => wp_nonce_url( bp_get_group_permalink( $group ) . 'unfavorite-group', 'groups_unfavorite_group' ),
					'link_text'         => __( 'Unfavorite Group', 'sp-favorite-groups' ),
					'link_title'        => __( 'Unfavorite Group', 'sp-favorite-groups' ),
					'link_class'        => 'group-button unfavorite-group',
				);
			else:
				// Setup button attributes
				$button = array(
					'id'                => 'favorite_group',
					'component'         => 'groups',
					'must_be_logged_in' => true,
					'block_self'        => false,
					'wrapper_class'     => 'group-button ' . $group->status,
					'wrapper_id'        => 'groupbutton-' . $group->id,
					'link_href'         => wp_nonce_url( bp_get_group_permalink( $group ) . 'favorite-group', 'groups_favorite_group' ),
					'link_text'         => __( 'Favorite', 'sp-favorite-groups' ),
					'link_title'        => __( 'Favorite', 'sp-favorite-groups' ),
					'link_class'        => 'group-button favorite-group',
				);

			endif;
		}else{
			return false;
		}
		/**
		 * Filters the HTML button for favoriting a group.
		 *
		 * @since SP Favorite Groups (1.0.0)
		 *
		 * @param string $button HTML button for favoriting a group.
		 */
		return bp_get_button( apply_filters( 'sp_get_group_favorite_button', $button ) );
	}
	
	public function sp_set_favorite_group(){
		$type = sanitize_text_field($_POST['type']);
		$group_id = (int)$_POST['gid'];
		if($type=='favorite'){
			$this->sp_groups_favorite_group($group_id);
		}else{
			$this->sp_groups_unfavorite_group($group_id);
		}
		exit;
	}
	
	public function sp_groups_favorite_group($group_id, $user_id = 0){
		if ( empty( $user_id ) )
		$user_id = bp_loggedin_user_id();
		
		$user_groups = $this->get_user_favorite_groups($user_id);
		$user_groups[] = $group_id;
		if(update_user_meta($user_id, $this->meta_key, $user_groups)){
			echo 1;
		}
	}
	
	public function sp_groups_unfavorite_group($group_id, $user_id = 0){
		if ( empty( $user_id ) )
		$user_id = bp_loggedin_user_id();
	
		$user_groups = $this->get_user_favorite_groups($user_id);
		unset($user_groups[$group_id]);
		if(update_user_meta($user_id, $this->meta_key, $user_groups)){
			echo 1;
		}
		
	}
	public function get_user_favorite_groups($user_id){
		$groups = get_user_meta($user_id, $this->meta_key, true);
		$groups = (!is_array($groups) ? array() : $groups);
		return $groups;
	}
	public function sp_add_footer_js(){
		?>
        <script type="text/javascript">
			jQuery(document).ready(function(jq) {
               jq('#buddypress').on('click', '.group-button a', function(event) {
					event.preventDefault();
					var gid   = jq(this).parent().attr('id'),
						nonce   = jq(this).attr('href'),
						thelink = jq(this);
			
					gid = gid.split('-');
					gid = gid[1];
			
					nonce = nonce.split('?_wpnonce=');
					nonce = nonce[1].split('&');
					nonce = nonce[0];
			
					// AJAX request
					if ( thelink.hasClass( 'favorite-group' ) || thelink.hasClass( 'unfavorite-group' ) ) {
						//return false;
						if(thelink.hasClass( 'favorite-group' )){
							var type = 'favorite';
						}else{
							var type = 'unfavorite';
						}
						jq.post( ajaxurl, {
							action: 'spfavortie_group',
							'gid': gid,
							'type':type,
							'_wpnonce': nonce
						},
						function(response)
						{
							if(type=='favorite'){
								thelink.text('<?php _e('Unfavorite Group', 'sp-favorite-groups'); ?>');
								thelink.addClass('unfavorite-group').removeClass('favorite-group');
							}else{
								thelink.text('<?php _e('Favorite Group', 'sp-favorite-groups'); ?>');
								thelink.addClass('favorite-group').removeClass('unfavorite-group');
							}
						});
					}
					return false;
				} );
            });
		</script>
        <?php
	}
	
	public function sp_favorite_groups_func($atts){
		if ( empty( $atts['user_id'] ) ){
			$user_id = bp_loggedin_user_id();
		}else{
			$user_id = $atts['user_id'];
		}
		$user_groups = $this->get_user_favorite_groups($user_id);
		if(empty($user_groups)){
			return '<div class="sp-fav-groups-none">'.__('No favorite groups found', 'sp-favorite-groups').'</div>';
		}
		$include = implode(',', $user_groups);
		ob_start();
		if ( bp_has_groups( bp_ajax_querystring( 'groups' ).'&include='.$include ) ) : 
		?>
        	<div id="buddypress">
			<ul id="groups-list" class="item-list">

	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li <?php bp_group_class(); ?>>
			<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
				<div class="item-avatar">
					<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
				</div>
			<?php endif; ?>

			<div class="item">
				<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
				<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'sp-favorite-groups' ), bp_get_group_last_active() ); ?></span></div>

				<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

				<?php

				/**
				 * Fires inside the listing of an individual group listing item.
				 *
				 * @since SP Favorite Groups (1.0.0)
				 */
				do_action( 'bp_directory_groups_item' ); ?>

			</div>

			<div class="action">

				<?php

				/**
				 * Fires inside the action section of an individual group listing item.
				 *
				 * @since SP Favorite Groups (1.0.0)
				 */
				do_action( 'bp_directory_groups_actions' ); ?>

				<div class="meta">

					<?php bp_group_type(); ?> / <?php bp_group_member_count(); ?>

				</div>

			</div>

			<div class="clear"></div>
		</li>
	<?php endwhile; ?>
	</ul>
    </div>
    <?php else: ?>
    <div class="sp-fav-groups-none"><?php _e('No favorite groups found', 'sp-favorite-groups'); ?></div>
    <?php
	endif;
	$output_string = ob_get_contents();
	ob_end_clean();
	return apply_filters('sp_favorite_groups_html', $output_string, $user_groups);
	}
	
	public function sp_favorite_group_filter($output){
		global $bp;
		if($bp->current_component=='activity'){
			$output .= '<option value="favorite_group">' . __( 'Favorite Groups', 'sp-favorite-groups' ) . '</option>' . "\n";
		}
		return $output;
	}
	public function sp_favorite_groups_activity_filter( $qs=false,$object=false ) {
	  if($object != 'activity'){
		return $qs;
	  }
	
	$args=wp_parse_args($qs);

	if(empty($args['type']) || $args['type'] != 'favorite_group'){
		return $qs;
	}
	
	$user_id = bp_loggedin_user_id();
	$user_groups = $this->get_user_favorite_groups($user_id);
	if(empty($user_groups)){
		return $qs;
	}
	$include = implode(',', $user_groups);
	if(!empty($user_groups)):
		$args['primary_id'] = $user_groups;
		$args['object'] = 'groups';
		unset($args['type']);
		unset($args['action']);
	endif;
	
	$qs = build_query($args);
	return $qs;
	}
}

endif;

add_action('bp_init','sp_favorie_groups_initiate');
function sp_favorie_groups_initiate(){
	$sp_favorite_group = new SP_Favorite_Groups();
}