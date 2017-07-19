<?php
defined('RY_FTP_VERSION') OR exit('No direct script access allowed');

class RY_FTP_admin {
	private static $initiated = false;
	
	public static function init() {
		if( !self::$initiated ) {
			self::$initiated = true;

			add_action('admin_init', array(__CLASS__, 'admin_init'));

			require_once(RY_FTP_PLUGIN_DIR . 'class.ry-ftp.admin-html.php');

			add_filter('plugin_action_links', array(__CLASS__, 'plugin_action_links'), 10, 2);
			add_action('admin_menu', array(__CLASS__, 'admin_menu'));

			add_filter('manage_media_columns', array(__CLASS__, 'manage_media_columns'));
			add_action('manage_media_custom_column', array(__CLASS__, 'manage_media_custom_column'), 10, 2);
		}
	}

	public static function admin_init() {
		load_plugin_textdomain(RY_FTP::$textdomain, false, dirname(RY_FTP_PLUGIN_BASENAME) . '/languages');
	}

	public static function plugin_action_links($links, $file) {
		if( $file == RY_FTP_PLUGIN_BASENAME ) {
			$links[] = '<a href="options-general.php?page=upload-to-ftp&tab=ftp">' . __('Settings', RY_FTP::$textdomain) . '</a>';
		}
		return $links;
	}

	public static function admin_menu() {
		add_submenu_page('options-general.php', 'Upload to FTP', __('Upload to FTP', RY_FTP::$textdomain), 'manage_options', 'upload-to-ftp', array(__CLASS__, 'setting_page'));
	}

	public static function setting_page() {
		$tab = 'ftp';
		if( isset($_GET['tab']) ) {
			$tab = $_GET['tab'];
		}
		if( !in_array($tab, array('ftp', 'basic', 'advanced')) ) {
			$tab = 'ftp';
		}

		RY_FTP_admin_html::setting_page_header($tab);
		if( self::check_ftp_support() ) {
			switch( $tab ) {
				case 'basic':
					if( !empty($_POST['ry_Update_setting']) ) {
						self::save_setting();
					}
					RY_FTP_admin_html::show_base_setting_page();
					break;
				case 'advanced':
					if( !empty($_POST['ry_SetExistFile']) ) {
						self::set_exists_file_in_ftp();
					}
					RY_FTP_admin_html::show_advanced_setting_page();
					break;
				case 'ftp':
				default:
					if( !empty($_POST['ry_Update_ftpsetting']) ) {
						self::save_ftp_setting();
					}
					RY_FTP_admin_html::show_ftp_setting_page();
					break;
			}
		} else {
			RY_FTP_admin_html::setting_page_no_ftp_error();
		}
		RY_FTP_admin_html::setting_page_footer();
	}
	
	

	public static function manage_media_columns($attr) {
		$attr['toftp'] = __('to FTP', RY_FTP::$textdomain);
		return $attr;
	}

	public static function manage_media_custom_column($name, $post_ID) {
		global $post;
		if( $name == 'toftp' ) {
			$metadate = get_post_meta($post_ID, 'file_to_ftp', true);
			if( isset($metadate['up_time']) ) {
				if( $metadate['up_time'] == 1 ) {
					$metadate['up_time'] = strtotime($post->post_date);
					update_post_meta($post_ID, 'file_to_ftp', $metadate);
				}
				if( $metadate['up_time'] ) {
					echo(date('Y/m/d G:i', $metadate['up_time']));
				}
			} else {
				_e('un-upload', RY_FTP::$textdomain);
			}
		}
	}

	protected static function check_ftp_support() {
		return defined('FTP_BINARY');
	}

	protected static function save_ftp_setting() {
		$ftp_host = trim($_POST['ry_ftp_host']);
		$ftp_port = intval($_POST['ry_ftp_port']);
		$ftp_timeout = intval($_POST['ry_ftp_timeout']);
		$ftp_username = trim($_POST['ry_ftp_username']);
		$ftp_password = trim($_POST['ry_ftp_password']);
		if( empty($ftp_password) ) {
			$ftp_password = RY_FTP::$options['ftp_password'];
		}
		$ftp_mode = (intval($_POST['ry_ftp_mode']) == 1) ? 1 : 0;
		$ftp_dir = trim($_POST['ry_ftp_dir']);
		$html_link_url = trim($_POST['ry_html_link_url']);
		$ftp_uplode_ok = false;
		$ftp_delete_ok = false;
		$html_file_line_ok = false;
		
		preg_match('/ftp[s]?:\/\//i', $ftp_host, $temp);
		if( isset($temp[0]) ) {
			$ftp_host = substr($ftp_host, strlen($temp[0]));
		}
		if( substr($ftp_host, -1) == '/' ) {
			$ftp_host = substr($ftp_host, 0, -1);
		}
		if( $ftp_port <= 0 || $ftp_port > 65535 ) {
			$ftp_port = 21;
		}
		if( $ftp_timeout <= 0 || $ftp_timeout > 61 ) {
			$ftp_timeout = 15;
		}
		$ftp_dir = '/' . trim($ftp_dir, '/') . '/';
		$ftp_dir = str_replace('//', '/', $ftp_dir);

		preg_match('/http[s]?:\/\//i', $html_link_url , $temp);
		if( !isset($temp[0]) ) {
			$html_link_url = 'http://' . $html_link_url;
		}
		$html_link_url = rtrim($html_link_url, '/') . '/';

		$info = '';
		$ftp_resource = @ftp_connect($ftp_host, $ftp_port, $ftp_timeout);
		if( !$ftp_resource ) {
			$info .= '<p>' . __('FTP connect error', RY_FTP::$textdomain) . ' <strong>' . $ftp_host . '</strong> : <strong>' . $ftp_port . '</strong></p>';
		} else {
			if( @!ftp_login($ftp_resource , $ftp_username, $ftp_password) ) {
				$info .= '<p>' . __('FTP login error with username', RY_FTP::$textdomain) . ' <strong>' . $ftp_username . '</strong></p>';
			} else {
				ftp_pasv($ftp_resource, (bool) $ftp_mode);
				if( @!ftp_chdir($ftp_resource, $ftp_dir) ) {
					$info .= '<p>' . __('FTP open directory failure', RY_FTP::$textdomain) . ' <strong>' . $ftp_dir . '</strong></p>';
				} else {
					$test_file_name = 'test-file.txt';
					$test_file_path = RY_FTP_PLUGIN_DIR . '/' . $test_file_name;
					if( @!ftp_put($ftp_resource, $ftp_dir . $test_file_name, $test_file_path, FTP_BINARY) ) {
						$info .= '<p>' . __('FTP is not writable', RY_FTP::$textdomain) . ' <strong>' . $ftp_dir . '</strong></p>';
					} else {
						$ftp_uplode_ok = true;
						$response = wp_remote_get($html_link_url . $test_file_name, array(
							'httpversion' => '1.1'
						));
						$body = wp_remote_retrieve_body($response);
						if( $body != 'abcdefghijklmnopqrstuvwxyz' ) {
							$info .= '<p>' . __('HTML link url don\'t match FTP dir', RY_FTP::$textdomain) . '</p>';
							$info .= '<br><a href="' . $html_link_url . $test_file_name. '">' . $html_link_url . $test_file_name . '</a>';
						} else {
							$html_file_line_ok = true;
						}
						if( $html_file_line_ok ) {
							if( @ftp_delete($ftp_resource, $ftp_dir . $test_file_name) ) {
								$ftp_delete_ok = true;
							}
						}
					}
				}
			}
			ftp_close($ftp_resource);
		}

		RY_FTP::$options['ftp_host'] = $ftp_host;
		RY_FTP::$options['ftp_port'] = $ftp_port;
		RY_FTP::$options['ftp_timeout'] = $ftp_timeout;
		RY_FTP::$options['ftp_username'] = $ftp_username;
		RY_FTP::$options['ftp_password'] = $ftp_password;
		RY_FTP::$options['ftp_mode'] = $ftp_mode;
		RY_FTP::$options['ftp_dir'] = $ftp_dir;
		RY_FTP::$options['ftp_uplode_ok'] = $ftp_uplode_ok;
		RY_FTP::$options['html_link_url'] = $html_link_url;
		RY_FTP::$options['html_file_line_ok'] = $html_file_line_ok;
		RY_FTP::$options['ftp_delete_ok'] = $ftp_delete_ok;

		if( empty($info) ) {
			$info = '<div id="message" class="updated"><p>' . __('Updated FTP Options Success', RY_FTP::$textdomain) . '</p></div>';
			RY_FTP::update_option('options', RY_FTP::$options);
		} else {
			$info = '<div id="message" class="error">' . $info . '</div>';
		}
		echo $info;
	}

	protected static function save_setting() {
		RY_FTP::$options['rename_file'] = intval($_POST['ry_rename_file']) ? 1 : 0;
		RY_FTP::$options['delete_local_auto_build'] = intval($_POST['ry_delete_local_auto_build']) ? 1 : 0;
		RY_FTP::update_option('options', RY_FTP::$options);
		$info = '<div id="message" class="updated"><p>' . __('Updated Basic Options Success', RY_FTP::$textdomain) . '</p></div>';
		echo $info;
	}

	protected static function set_exists_file_in_ftp() {
		$att_query = new WP_Query(array(
			'post_type' => 'attachment',
			'post_status' => 'inherit,private',
			'posts_per_page' => -1
		));
		global $post;
		while( $att_query->have_posts() ) {
			$att_query->the_post();
			$meta_date = get_post_meta($post->ID, 'file_to_ftp', true);
			if( !isset($meta_date['up_time']) || $meta_date['up_time'] < 1 ) {
				$file_path = get_post_meta($post->ID, '_wp_attached_file', true);
				if( strpos($file_path, '/') === FALSE ) {
					$up_dir = '';
				} else {
					$up_dir = substr($file_path, 0, strrpos($file_path, '/'));
				}
				$up_dir = trim($up_dir, '/');
				if( $up_dir != '' ) {
					$up_dir .= '/';
				}$metadate = array(
					'up_time' => current_time('timestamp'),
					'up_dir' => $up_dir
				);
				add_post_meta($post->ID, 'file_to_ftp', $metadate, true);
			}
		}
	}
}
