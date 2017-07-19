<?php
/**
 * Dashboard popup template: Ask for FTP credentials before updating/installing.
 *
 * This is only loaded if direct FS access is not possible.
 *
 * Following variables are passed into the template:
 *   -
 *
 * @since  4.1.0
 * @package WPMUDEV_Dashboard
 */

$ftp_host = preg_replace(
	'/www\./',
	'',
	parse_url( admin_url(), PHP_URL_HOST )
);

$credentials = get_option( 'ftp_credentials', array( 'hostname' => '', 'username' => '' ) );
$credentials['hostname'] = defined( 'FTP_HOST' ) ? FTP_HOST : $credentials['hostname'];
$credentials['username'] = defined( 'FTP_USER' ) ? FTP_USER : $credentials['username'];
$hostname = isset( $credentials['hostname'] ) ? $credentials['hostname'] : '';
$username = isset( $credentials['username'] ) ? $credentials['username'] : '';
?>

<dialog id="ftp-credentials" class="" title="<?php esc_html_e( 'We need your help, boss!', 'wpmudev' ); ?>">
<div class="dialog-ftp">
	<p class="intro">
		<?php _e( 'Hang on a minute... It looks like your WordPress site isn\'t configured to allow one-click installations of plugins and themes. But don\'t worry! You can still install this plugin by entering your server\'s FTP credentials here:', 'wpmudev' ); ?>
	</p>
	<form action="#" method="post" class="form ftp-form">
		<div class="col col-1">
		<label for="ftp_user"><?php _e( 'FTP Username', 'wpmudev' ); ?></label>
		<input
			type="text"
			id="ftp_user"
			<?php if ( defined( 'FTP_USER' ) ) : ?>
			readonly="readonly"
			value="<?php echo esc_attr( FTP_USER ); ?>"
			<?php else : ?>
			value="<?php echo esc_attr( $username ); ?>"
			<?php endif; ?>
			placeholder="username..." />
		</div>

		<div class="col col-2">
		<label for="ftp_pass"><?php _e( 'FTP Password', 'wpmudev' ); ?></label>
		<input
			type="password"
			id="ftp_pass"
			<?php if ( defined( 'FTP_PASS' ) ) : ?>
			readonly="readonly"
			value="<stored>"
			<?php else : ?>
			value=""
			<?php endif; ?>
			placeholder="*****" />
		</div>

		<div class="col col-3">
		<label for="ftp_host"><?php _e( 'FTP Host', 'wpmudev' ); ?></label>
		<input
			type="text"
			id="ftp_host"
			<?php if ( defined( 'FTP_HOST' ) ) : ?>
			readonly="readonly"
			value="<?php echo esc_attr( FTP_HOST ); ?>"
			<?php else : ?>
			value="<?php echo esc_attr( $hostname );?>"
			<?php endif; ?>
			placeholder="e.g. <?php echo esc_attr( $ftp_host ); ?>" />
		</div>

		<div class="col-buttons">
			<a href="#close" class="close button button-grey"><?php _e( 'Cancel', 'wpmudev' ); ?></a>
			<button><?php _e( 'Okay, continue!', 'wpmudev' ); ?></button>
			<br><br><small><?php _e( 'We will remember these details for 15 minutes in case you want to install or, update something else.', 'wpmudev' ); ?></small>
		</div>
	</form>
	<p>
		<?php
		printf(
			__( 'Or you can %senable one-click installations%s on this site by adding the following details to <code>wp-config.php</code>:', 'wpmudev' ),
			'<a href="http://premium.wpmudev.org/wpmu-dev/update-notifications-plugin-information/configuring-automatic-updates/" target="_blank">',
			'</a>'
		);
		?>
	</p>
	<p>
	<code>
	define( 'FTP_USER', '<em>your FTP username</em>' );<br />
	define( 'FTP_PASS', '<em>your FTP password</em>' );<br />
	define( 'FTP_HOST', '<?php echo esc_html( $ftp_host ); ?>' );
	</code>
	</p>
</div>
</dialog>

<style>
.ftp-form .col {
	float: left;
	box-sizing: border-box;
	width: 33.33%;
	margin: 0;
	padding: 0 10px;
}
.ftp-form .col-buttons {
	clear: both;
	text-align: right;
}
.ftp-form {
	margin: 10px 0 25px;
	border-bottom: 1px solid #E5E5E5;
	padding: 0 0 10px;
}
.ftp-form:after {
	content: '';
	display: table;
	clear: both;
}
</style>
<script>
jQuery(function() {
	var backRef = {},
		isHandled = false;
	jQuery(document).on('wpmu:before-update', checkCredentials);

	// Display the "Enter FTP Credentials" popup.
	function checkCredentials(ev, res) {
		if (isHandled) { return true; }

		backRef = res;
		WDP.showOverlay("#ftp-credentials");

		jQuery(document).on("submit", ".ftp-form", storeCredentialsAndContinue);
		res.cancel = true;
	}

	// Store the credentials as httponly cookies (via ajax request)
	function storeCredentialsAndContinue(ev) {
		var data = {},
			popup = jQuery(this).closest(".box");

		ev.preventDefault();
		popup.loading(true);

		data.action = "wdp-credentials";
		data.hash = "<?php echo wp_create_nonce( 'credentials' ); ?>";
		data.ftp_user = popup.find("#ftp_user").val();
		data.ftp_pass = popup.find("#ftp_pass").val();
		data.ftp_host = popup.find("#ftp_host").val();

		// For security we remove the password from the DOM again.
		jQuery("#ftp_pass").val("");

		jQuery.post(
			window.ajaxurl,
			data,
			function(response) {
				if (response && response.success) {
					// This is the "...and continue" part:
					isHandled = true;

					// Call the original function again.
					backRef.func.call(backRef.scope, backRef.param);
				} else {
					WDP.showError('message', "<?php esc_attr_e( 'Unexpected response from WordPress.', 'wpmudev' ); ?>")
					WDP.showError();
					popup.loading(false);
				}
			}
		).fail(function() {
			WDP.showError('message', "<?php esc_attr_e( 'Unknown server error.', 'wpmudev' ); ?>")
			WDP.showError();
			popup.loading(false);
		});

		return false;
	}
});
</script>
