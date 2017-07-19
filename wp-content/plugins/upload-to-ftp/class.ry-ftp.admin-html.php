<?php
defined('RY_FTP_VERSION') OR exit('No direct script access allowed');

class RY_FTP_admin_html {
	public static function setting_page_header($tab) {
		?>
		<div class="wrap">
		<h1><?=__('Upload to FTP Options', RY_FTP::$textdomain); ?></h1>
		<h2 class="nav-tab-wrapper">
			<a href="options-general.php?page=upload-to-ftp&tab=ftp" class="nav-tab<?=(($tab == 'ftp') ? ' nav-tab-active' : '') ?>"><?=__('FTP Options', RY_FTP::$textdomain); ?></a>
			<a href="options-general.php?page=upload-to-ftp&tab=basic" class="nav-tab<?=(($tab == 'basic') ? ' nav-tab-active' : '') ?>"><?=__('Basic Options', RY_FTP::$textdomain); ?></a>
			<a href="options-general.php?page=upload-to-ftp&tab=advanced" class="nav-tab<?=(($tab == 'advanced') ? ' nav-tab-active' : '') ?>"><?=__('Advanced Options', RY_FTP::$textdomain); ?></a>
		</h2>
		<?php
	}

	public static function setting_page_footer() {
		?>
		</div>
		<?php
	}

	public static function setting_page_no_ftp_error() {
		?>
		<div id="message" class="error"><p>
			<p><?=__('Your server does not support FTP-related functions', RY_FTP::$textdomain); ?></p>
		</p></div>
		<?php
	}

	public static function show_ftp_setting_page() {
		?>
		<form method="post" action="" novalidate="novalidate">
			<table class="form-table">
				<tr>
					<th scope="row"><?=__('FTP Status', RY_FTP::$textdomain); ?></th>
					<td>
						<p><?=__('Upload Status:', RY_FTP::$textdomain); ?> <strong><?php RY_FTP::$options['ftp_uplode_ok'] ? _e('Can upload', RY_FTP::$textdomain) : _e('Can not upload', RY_FTP::$textdomain); ?></strong></p>
						<p><?=__('File Link Status:', RY_FTP::$textdomain); ?><strong><?php RY_FTP::$options['html_file_line_ok'] ? _e('HTML File Link is OK', RY_FTP::$textdomain) : _e('HTML File Link is Error', RY_FTP::$textdomain); ?></strong></p>
						<p><?=__('Delete Status:', RY_FTP::$textdomain); ?><strong><?php RY_FTP::$options['ftp_delete_ok'] ? _e('Can delete', RY_FTP::$textdomain) : _e('Can not delete', RY_FTP::$textdomain); ?></strong></p>
					</td>
				</tr>
				<?php self::input_text(__('FTP Host', RY_FTP::$textdomain), 'ry_ftp_host', esc_attr(RY_FTP::$options['ftp_host']), 30); ?>
				<?php self::input_text(__('FTP Port', RY_FTP::$textdomain), 'ry_ftp_port', esc_attr(RY_FTP::$options['ftp_port']), 6); ?>
				<?php self::input_text(__('FTP Timeout', RY_FTP::$textdomain), 'ry_ftp_timeout', esc_attr(RY_FTP::$options['ftp_timeout']), 4); ?>
				<?php self::input_text(__('FTP Username', RY_FTP::$textdomain), 'ry_ftp_username', esc_attr(RY_FTP::$options['ftp_username']), 30); ?>
				<?php self::input_text(__('FTP Password', RY_FTP::$textdomain), 'ry_ftp_password', '', 30, __('Only when you want to change your password, enter it.', RY_FTP::$textdomain)); ?>
				<tr>
					<th scope="row"><?=__('FTP Mode', RY_FTP::$textdomain); ?></th>
					<td><input type="radio" id="ry_ftp_mode" name="ry_ftp_mode" value="1" <?php checked('1', RY_FTP::$options['ftp_mode']); ?> /> <?=__('Passive', RY_FTP::$textdomain); ?> <input type="radio" id="ry_ftp_mode" name="ry_ftp_mode" value="0" <?php checked('0', RY_FTP::$options['ftp_mode']); ?> /> <?=__('Active', RY_FTP::$textdomain); ?></td>
				</tr>
				<?php self::input_text(__('FTP Directory', RY_FTP::$textdomain), 'ry_ftp_dir', esc_attr(RY_FTP::$options['ftp_dir']), 60); ?>
				<?php self::input_text(__('HTML link url', RY_FTP::$textdomain), 'ry_html_link_url', esc_url(RY_FTP::$options['html_link_url']), 60); ?>
			</table>
			<p class="submit"><input type="submit" name="ry_Update_ftpsetting" class="button-primary" value="<?=__('Save & Test Changes', RY_FTP::$textdomain); ?>" /></p>
		</form>
		<?php
	}

	public static function show_base_setting_page() {
		?>
		<form method="post" action="" novalidate="novalidate">
			<table class="form-table">
				<tr>
					<th scope="row"><?=__('Rename file', RY_FTP::$textdomain); ?></th>
					<td>
						<select name="ry_rename_file" size="1">
							<option value="0"<?php selected('0', RY_FTP::$options['rename_file']); ?>><?=__('disable', RY_FTP::$textdomain); ?></option>
							<option value="1"<?php selected('1', RY_FTP::$options['rename_file']); ?>><?=__('enable', RY_FTP::$textdomain); ?></option>
						</select>
						<br /><em><?=__('Proposal enabled! Because the file name to avoid some of the resulting error can not be expected', RY_FTP::$textdomain); ?></em>
					</td>
				</tr>
				<tr>
					<th scope="row"><?=__('Delete Auto build local file', RY_FTP::$textdomain); ?></th>
					<td>
						<select name="ry_delete_local_auto_build" size="1">
							<option value="0"<?php selected('0', RY_FTP::$options['delete_local_auto_build']); ?>><?=__('disable', RY_FTP::$textdomain); ?></option>
							<option value="1"<?php selected('1', RY_FTP::$options['delete_local_auto_build']); ?>><?=__('enable', RY_FTP::$textdomain); ?></option>
						</select>
						<br /><em><?=__('Only enable the when you local storage space have limited.', RY_FTP::$textdomain); ?></em>
					</td>
				</tr>
			</table>
			<p class="submit"><input type="submit" name="ry_Update_setting" class="button-primary" value="<?=__('Save Changes', RY_FTP::$textdomain); ?>" /></p>
		</form>
		<?php
	}

	public static function show_advanced_setting_page() {
		?>
		<form method="post" action="" novalidate="novalidate">
			<p>
				<?=__('This setting is ONLY set the mark of the media.', RY_FTP::$textdomain); ?><br>
				<?=__('You NEED move the file to you ftp by youself.', RY_FTP::$textdomain); ?><br>
				<?=__('And all the post you had will stile use the file from this webserver until you reimport the media to the post.', RY_FTP::$textdomain); ?>
			</p>
			<p class="submit"><input type="submit" name="ry_SetExistFile" class="button-primary" value="<?=__('Set Exists File In FTP', RY_FTP::$textdomain); ?>" /></p>
		</form>
		<?php
	}

	protected static function input_text($label, $input_name, $input_value, $input_size = 30, $note = '') {
		?>
		<tr>
			<th scope="row"><label for="<?=$input_name ?>"><?=$label ?></label></th>
			<td><input type="text" id="<?=$input_name ?>" name="<?=$input_name ?>" size="<?=$input_size ?>" value="<?=$input_value ?>" /><?=(empty($note) ? '' : ('<br>' . $note)) ?></td>
		</tr>
		<?php
	}
}
