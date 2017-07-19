<?php
defined('RY_FTP_VERSION') OR exit('No direct script access allowed');

class RY_FTP_update {
	public static function update() {
		$now_version = RY_FTP::get_option('version');

		if( $now_version === false ) {
			$now_version = '0.0.0';
		}
		if( $now_version == RY_FTP_VERSION ) {
			return;
		}

		if( version_compare($now_version, '1.0.0', '<' ) ) {
			$old_option = get_option('U2FTP_options');
			if( $old_option !== false ) {
				$old_option['delete_local_auto_build'] = $old_option['auto_delete_local'];
				unset($old_option['save_original_file']);
				unset($old_option['auto_delete_local']);
				RY_FTP::update_option('options', $old_option);
				delete_option('U2FTP_options');
			}
			$old_version = get_option('U2FTP_version');
			if( $old_version !== false ) {
				RY_FTP::update_option('version', $old_version);
				delete_option('U2FTP_version');
			}

			RY_FTP::update_option('version', '1.0.0');
		}

		if( version_compare($now_version, '1.0.1', '<' ) ) {
			RY_FTP::update_option('version', '1.0.1');
		}

		if( version_compare($now_version, '1.0.2', '<' ) ) {
			RY_FTP::update_option('version', '1.0.2');
		}

		if( version_compare($now_version, '1.0.3', '<' ) ) {
			RY_FTP::update_option('version', '1.0.3');
		}

		if( version_compare($now_version, '1.0.4', '<' ) ) {
			RY_FTP::update_option('version', '1.0.4');
		}
	}
}
