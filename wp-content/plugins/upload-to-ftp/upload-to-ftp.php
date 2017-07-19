<?php
/*
Plugin Name: Upload to FTP
Plugin URI: https://richer.tw/upload-to-ftp
Description: let you can upload file to and download host 
Version: 1.0.4
Author: Richer Yang
Author URI: https://richer.tw/
Text Domain: upload-to-ftp
Domain Path: /languages
License: MIT License
License URI: http://opensource.org/licenses/MIT
*/

function_exists('plugin_dir_url') OR exit('No direct script access allowed');

define('RY_FTP_VERSION', '1.0.4');
define('RY_FTP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RY_FTP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RY_FTP_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once(RY_FTP_PLUGIN_DIR . 'class.ry-ftp.php');

register_activation_hook(__FILE__, array('RY_FTP', 'plugin_activation'));
register_deactivation_hook(__FILE__, array('RY_FTP', 'plugin_deactivation'));

add_action('init', array('RY_FTP', 'init'));
