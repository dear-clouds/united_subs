<?php

// Admin Settings Page /////////////////////////////////////////////////////////////////////////////

// Load all settings sections
global $katracker_settings_sections;
$katracker_settings_sections = glob( plugin_dir_path( __FILE__ ) . 'section-[0-9]-*.php' );
foreach ( $katracker_settings_sections as $settings_section ) include_once $settings_section;

// Create Katracker Settings Page
add_action( 'admin_menu', function () {
	add_options_page( __( 'KaTracker Settings', 'katracker' ), __( 'KaTracker', 'katracker' ), 'manage_options', 'katracker',
		function () {
			?>
			<div class="wrap">
				<h1 title="<?php _e( 'KaTracker Settings', 'katracker' ); ?>"><span style="height:38px;width:140px;background:url('<?php echo plugin_dir_url( __FILE__ ) . 'SettingsLogo.png'; ?>') no-repeat;background-size:140px 38px;display:inline-block;" ></span></h1>
				<h2 class="nav-tab-wrapper">
				<?php
				global $katracker_section;
				$current_section = current( $katracker_section );
				$_GET['tab'] = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : $current_section['slug'];

				global $katracker_settings_sections;
				foreach ( $katracker_settings_sections as $settings_section ) {
					global $katracker_section;
					if ( !isset( $katracker_section[basename( $settings_section )] ) ) {
						continue;
					}

					if ( $_GET['tab'] == $katracker_section[basename( $settings_section )]['slug'] ) {
						$current_section = $katracker_section[basename( $settings_section )];
					}

					echo '<a href="?page=katracker&tab=' . $katracker_section[basename( $settings_section )]['slug'] . '"' .
					     'class="nav-tab'.( $_GET['tab'] == $katracker_section[basename( $settings_section )]['slug'] ? ' nav-tab-active' : '' ) . '">' .
					     	__( $katracker_section[basename( $settings_section )]['title'], 'katracker' ) .
					     '</a>';
				}
				?>
				</h2>

				<form action="<?php echo $current_section['action']; ?>" method="post">
					<?php
						settings_fields( $current_section['name'] );
						do_settings_sections( $current_section['name'] );
						if ( $current_section['submit'] ) submit_button();
					?>
				</form>
			</div>
			<?php
			unset( $katracker_section, $katracker_settings_sections );
		} );

} );

?>
