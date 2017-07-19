<?php
/**
 * Dashboard template: Dashboard overview
 *
 * This template is used for the main overview, when the user clicks on the
 * main-menu item or the Dashboard sub-menu.
 *
 * Following variables are passed into the template:
 *   $data (membership data)
 *   $member (user profile data)
 *   $urls (urls of all dashboard menu items)
 *   $type [full|single|free]
 *   $my_project (only needed for type == single)
 *   $projects (keys: free|paid; list of projects, only for type free/single)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$profile = $member['profile'];
$points = $member['points'];
$history = $points['history'];
$level = $points['rep_level'];


if ( ! is_array( $history ) ) { $history = array(); }

// URL for the edit my profile functin.
$url_profile = $urls->remote_site . 'hub/profile/';

// Upgrade membership URL.
$url_upgrade = $urls->remote_site . '#pricing';

// Details on "Earn points".
$url_points = $urls->remote_site . 'earn-your-wpmudev-membership/';

// URLs for the Quick-link section.
$quick_1 = $urls->plugins_url;
$quick_2 = $urls->remote_site . 'manuals/';
$quick_3 = $urls->remote_site . 'forums/#question';
$quick_4 = $urls->remote_site . 'forums/';

// Find the 5 most popular plugins, that are not installed yet.
$popular = array();
foreach ( $data['projects'] as $item ) {
	// Skip themes.
	if ( 'plugin' != $item['type'] ) { continue; }

	$plugin = WPMUDEV_Dashboard::$site->get_project_infos( $item['id'] );

	// Skip plugin if it's already installed.
	if ( $plugin->is_installed ) { continue; }

	// Skip plugins that are not compatible with current site.
	if ( ! $plugin->is_compatible ) { continue; }

	// Skip hidden/deprecated projects.
	if ( $plugin->is_hidden ) { continue; }

	$rating = intval( $plugin->popularity );
	while ( isset( $popular[ $rating ] ) ) { $rating += 1; }

	$popular[ $rating ] = $item;
}
krsort( $popular );
$popular = array_slice( $popular, 0, 5 );

// Render the page header section.
$page_title = sprintf( __( 'Welcome, %s', 'wpmudev' ), $profile['name'] );
$this->render_header( $page_title );

?>
<section id="subheader" class="row">
	<div class="col-two-third">
		<div class="photo-wrap">
			<figure class="photo">
				<?php if ( ! empty( $profile['avatar'] ) ) : ?>
				<img src="<?php echo esc_url( $profile['avatar'] ); ?>" />
				<?php endif; ?>
			</figure>
		</div>

		<div class="overview-score">
			<span class="dev-level-name">
				<i class="dev-icon dev-icon-badge"></i>
				<?php echo esc_html( $level['name'] ); ?>
			</span>
			<span class="dev-level-num">
				&bull;
				<?php echo esc_html( $points['rep_points'] ); ?>
			</span>
		</div>
		<div class="overview-edit">
			<a href="<?php echo esc_url( $url_profile ); ?>" target="_blank">
				<?php esc_html_e( 'Edit Profile', 'wpmudev' ); ?>
			</a>
		</div>
	</div>
	<div class="col-third tr">
		<input
			type="search"
			placeholder="<?php esc_html_e( 'Search plugins', 'wpmudev' ); ?>"
			id="project-search"
			class="project-search"
			data-hash="<?php echo esc_attr( wp_create_nonce( 'projectsearch' ) ); ?>"
			data-empty-msg="<?php esc_html_e( 'We did not find a plugin/theme with this name...', 'wpmudev' ); ?>" />
	</div>
</section>

<div class="row">

<div class="col-half">
<section class="box-activity dev-box">
	<div class="box-title">
		<span class="buttons">
			<a href="<?php echo esc_url( $url_points ); ?>" target="_blank" class="button button-small">
				<?php esc_html_e( 'Earn points', 'wpmudev' ); ?>
			</a>
		</span>
		<h3><?php esc_html_e( 'Activity', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<?php if ( count( $history ) ) : ?>
		<ul class="dev-list top">
			<li class="list-header">
			<div>
				<span class="list-label">
					<?php esc_html_e( 'Action', 'wpmudev' ); ?>
				</span>
				<span class="list-detail">
					<?php esc_html_e( 'Points awarded', 'wpmudev' ); ?>
				</span>
			</div>
			</li>
			<?php foreach ( $history as $item ) : ?>
			<li>
			<div>
				<span class="list-label">
					<?php echo wp_kses_post( $item['reason'] ); ?>
				</span>
				<span class="list-detail">
					<strong><?php echo esc_html( $item['points'] ); ?></strong>
				</span>
			</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<p class="tc">
		<?php esc_html_e( 'Get involved in the community and earn Hero Points, which you can redeem for real stuff, like discounted memberships and t-shirts.', 'wpmudev' ); ?>
		</p>
	</div>
</section>
</div>

<div class="col-half">
<?php if ( 'full' != $type ) : ?>
<div class="group">
	<a href="<?php echo esc_url( $url_upgrade ); ?>" class="button button-cta block" target="_blank">
		<?php esc_html_e( 'Upgrade membership', 'wpmudev' ); ?>
	</a>
</div>
<?php if ( $my_project ) : ?>
<section class="box-popular dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Purchased', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<ul class="dev-list standalone">
			<li>
			<div>
				<span class="list-label">
					<?php
					$base_url = WPMUDEV_Dashboard::$ui->page_urls->plugins_url;
					$info_url = $base_url . '#pid=' . $my_project->pid;
					$update_url = $base_url . '#update=' . $my_project->pid;
					?>
					<a href="<?php echo esc_url( $info_url ); ?>">
						<?php echo esc_html( $my_project->name ); ?>
					</a>
				</span>
				<span class="list-detail" data-project="<?php echo esc_attr( $my_project->pid ); ?>">
				<?php if ( $my_project->is_installed ) : /* INSTALLED */ ?>
					<?php if ( $my_project->has_update ) { ?>
						<a
							href="<?php echo esc_url( $update_url ); ?>"
							class="button button-yellow button-small one-click" >
							<?php esc_html_e( 'Update', 'wpmudev' ); ?>
						</a>
					<?php } elseif ( $my_project->is_active && $my_project->url->config ) { ?>
						<a
							href="<?php echo esc_url( $my_project->url->config ); ?>"
							class="button button-light button-small one-click" >
							<?php esc_html_e( 'Configure', 'wpmudev' ); ?>
						</a>
					<?php } elseif ( ! $my_project->is_active && $my_project->can_activate ) { ?>
						<a
							href="<?php echo esc_url( $my_project->url->activate ); ?>"
							class="button button-small one-click"
							data-action="project-activate"
							data-hash="<?php echo esc_attr( wp_create_nonce( 'project-activate' ) ); ?>" >
							<?php esc_html_e( 'Activate', 'wpmudev' ); ?>
						</a>
					<?php } else { ?>
						<a
							href="<?php echo esc_url( $my_project->url->instructions ); ?>"
							rel="dialog"
							class="button button-small button-secondary"
							data-class="small no-margin"
							data-title="<?php printf(
								esc_html__( '%s Instructions', 'wpmudev' ), esc_attr( $my_project->name )
							); ?>"
							data-height="600"
							>
							<?php esc_html_e( 'Instructions', 'wpmudev' ); ?>
						</a>
					<?php } ?>
				<?php else : /* NOT INSTALLED */ ?>
					<?php if ( $my_project->is_compatible && $my_project->url->install ) { ?>
					<a
						href="<?php echo esc_url( $my_project->url->install ); ?>"
						class="button button-green button-cta button-small one-click"
						data-action="project-install"
						data-hash="<?php echo esc_attr( wp_create_nonce( 'project-install' ) ); ?>" >
						<?php esc_html_e( 'Install', 'wpmudev' ); ?>
					</a>
					<?php } elseif ( $my_project->is_compatible ) { ?>
					<a
						href="<?php echo esc_url( $my_project->url->download ); ?>"
						class="button button-secondary button-small"
						target="_blank" >
						<?php esc_html_e( 'Download', 'wpmudev' ); ?>
					</a>
					<?php } else { ?>
					<a
						href="#"
						class="button disabled button-small" >
						<?php echo esc_html( $my_project->incompatible_reason ); ?>
					</a>
					<?php } ?>
				<?php endif; ?>
				</span>
			</div>
			</li>
		</ul>
	</div>
</section>
<?php endif; ?>
<?php endif; ?>

<section class="box-popular dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Popular plugins', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<ul class="dev-list">
			<?php foreach ( $popular as $item ) : ?>
			<li>
			<div>
				<span class="list-label">
					<?php
					$url = WPMUDEV_Dashboard::$ui->page_urls->plugins_url;
					$url .= '#pid=' . $item['id'];
					?>
					<a href="<?php echo esc_url( $url ); ?>">
						<?php echo esc_html( $item['name'] ); ?>
					</a>
				</span>
				<span class="list-detail">
					<?php if ( 'full' == $type ) : ?>
						<?php
						$res = WPMUDEV_Dashboard::$site->get_project_infos( $item['id'] );

						if ( $res->is_compatible && $res->url->install ) { ?>
						<a
							href="<?php echo esc_url( $res->url->install ); ?>"
							class="button button-green button-cta button-small one-click"
							data-action="project-install"
							data-hash="<?php echo esc_attr( wp_create_nonce( 'project-install' ) ); ?>" >
							<?php esc_html_e( 'Install', 'wpmudev' ); ?>
						</a>
						<?php } elseif ( $res->is_compatible ) { ?>
						<a
							href="<?php echo esc_url( $item['url'] ); ?>"
							class="button button-secondary button-small"
							target="_blank" >
							<?php esc_html_e( 'Download', 'wpmudev' ); ?>
						</a>
						<?php } ?>
					<?php else : ?>
						<a
							href="<?php echo esc_url( $url_upgrade ); ?>"
							class="button button-secondary button-small"
							target="_blank">
							<?php esc_html_e( 'Upgrade', 'wpmudev' ); ?>
						</a>
					<?php endif; ?>
				</span>
			</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<a href="<?php echo esc_url( $urls->plugins_url ); ?>" class="button button-light block">
			<?php esc_html_e( 'View all plugins', 'wpmudev' ); ?>
		</a>
	</div>
</section>

<section class="box-links dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Quick links', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<ul class="quick-links">
			<li><div>
				<span class="icon"><i class="dev-icon dev-icon-rocket_alt"></i></span>
				<?php
				printf(
					esc_html__( '%sInstall%s new plugins & themes', 'wpmudev' ),
					'<a href="' . esc_url( $quick_1 ) . '">',
					'</a>'
				);
				?>
			</div></li>
			<li><div>
				<span class="icon"><i class="dev-icon dev-icon-book"></i></span>
				<?php
				printf(
					esc_html__( '%sLearn%s how to master WordPress', 'wpmudev' ),
					'<a href="' . esc_url( $quick_2 ) . '" target="_blank">',
					'</a>'
				);
				?>
			</div></li>
			<li><div>
				<span class="icon"><i class="dev-icon dev-icon-support"></i></span>
				<?php
				printf(
					esc_html__( '%sOpen%s a support ticket', 'wpmudev' ),
					'<a href="' . esc_url( $quick_3 ) . '" target="_blank">',
					'</a>'
				);
				?>
			</div></li>
			<li><div>
				<span class="icon"><i class="dev-icon dev-icon-speach"></i></span>
				<?php
				printf(
					esc_html__( '%sBrowse%s the WPMU DEV Community', 'wpmudev' ),
					'<a href="' . esc_url( $quick_4 ) . '" target="_blank">',
					'</a>'
				);
				?>
			</div></li>
		</ul>
	</div>
</section>
</div>

</div>
