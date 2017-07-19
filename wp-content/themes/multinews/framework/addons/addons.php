<?php
/**
 * Momizat Themes Addons.
 *
 * @package   mom_extensions_class
 * @version   1.0
 * @author    Momizat Team <momizat.com>
 * @copyright Copyright (c) 2015, Momizat Team
 * @license   Private
 * @link      https://momizat.com
 */

/*
    Copyright 2015 Momizat team (momizat.com)
    just for use in our custom themes
*/


/**
* @since 1.0
* require the necessary files
*/
require_once MOM_FW . '/addons/class-tgm-plugin-activation.php';
require_once MOM_FW . '/addons/plugins.php';

if (!class_exists('mom_extensions_class')) {
    /**
     * Automatic plugin installation and activation library.
     *
     * Creates a way to automatically install and activate plugins from within themes.
     * The plugins can be either pre-packaged, downloaded from the WordPress
     * Plugin Repository or downloaded from a private repository.
     *
     * @since 1.0.0
     *
     * @package mom_extensions_class
     * @author    Momizat Team <momizat.com>
     */
    class mom_extensions_class
    {
        
        public $page_slug = 'momizat-panel';
        public $plugin_page_slug = 'recommended_plugins';
       
        public function __construct()
        {
            add_action('admin_menu', array(&$this,'admin_menu'));
            if($this->is_addon_page() ) {
                add_action('admin_enqueue_scripts', array(&$this,'assets'));
            }

    }


        public function admin_menu()
        {
            if (!current_user_can('install_plugins'))
                return;
            add_menu_page(wp_get_theme(), wp_get_theme(), 'edit_theme_options', 'momizat-panel', array(&$this,'extensions_page'));
            add_submenu_page('momizat-panel', __('Addons', 'theme'), __('Addons', 'theme'), 'edit_theme_options', 'momizat-panel', array(&$this,'extensions_page'));
            add_submenu_page('momizat-panel', 'Plugins', 'Plugins', 'edit_theme_options', 'recommended_plugins', array(&$this,'plugins_page'));
        }
        public function assets() 
        {
            wp_enqueue_style( 'mom-addons-css', MOM_ADDON_URI . '/assets/css/addons.css' );
            wp_register_script( 'Momizat-addons-js', MOM_ADDON_URI . '/assets/js/addons.js', array('jquery'), '1.0', true );
            wp_localize_script( 'Momizat-addons-js', 'momAjaxAddon', array(
                'url' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'ajax-nonce' ),
                'activate_text' => __('Activate', 'theme'),
                'deactivate_text' => __('Dectivate', 'theme'),
                'updated_text' => __('Updated!', 'theme'),
                'update_text' => __('Update Now', 'theme'),
                'active_text' => __('active', 'theme'),
                'inactive_text' => __('inactive', 'theme'),

            ));
            wp_enqueue_script('Momizat-addons-js');
        }

        
        public function extensions_page()
        {
?>

  <div class="wrap mom-extensions">

    <header class="mom-addons-header">
      <h2><?php
            _e('Addons', 'theme');
?></h2>
    </header>
  <?php
            $this->plugins_grid();
?>
  </div>

<?php
        }
        
        public function plugins_page()
        {
?>

  <div class="wrap mom-extensions">

    <header class="mom-addons-header">
      <h2><?php
            _e('Recommended Plugins', 'theme');
?></h2>
    </header>

  <?php
            $this->plugins_grid('plugin');
?>
  </div>

<?php
        }
        
        public function is_plugin_exist($plugin_path)
        {
            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_path)) {
                return true;
            } else {
                return false;
            }
        }
        
        public function plugins_grid($type = 'addon')
        {
?>
          <ul class="mom-extensions-list" id="mom-extensions-list">

      <?php
            foreach (TGM_Plugin_Activation::$instance->plugins as $plugin):
?>

        <?php
                if (isset($plugin['type']) && $plugin['type'] == $type) {
                    if (!isset($plugin['logo']) || $plugin['logo'] == '') {
                        $plugin['logo'] = MOM_URI . '/framework/extensions/assets/images/momizat-logo.png';
                    }
                    $installed_plugins = get_plugins();
                    $do_update         = false;
                    if (isset($installed_plugins[$plugin['file_path']]) && isset($plugin['version'])) {
                        $do_update = version_compare($installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<');
                    }

                    if ($this->is_plugin_exist($plugin['file_path'])) {
                        if (is_plugin_active($plugin['file_path'])) {
                            $status         = __('active', 'theme');
                            $status_message = __('Active', 'theme');
                            $button         = '<span class="spinner"></span><a class="mom-addon-button button mom-addon-deactivate" data-plugin="' . $plugin['file_path'] . '" href="#">' . __('Dectivate', 'theme') . '</a>';
                        } else {
                            $status         = __('inactive', 'theme');
                            $status_message = __('Inactive', 'theme');
                            $button         = '<span class="spinner"></span><a class="mom-addon-button button mom-addon-activate" data-plugin="' . $plugin['file_path'] . '" href="#">' . __('Activate', 'theme') . '</a>';
                        }
                        if ($do_update) {
                            $button = '<a class="mom-addon-button button mom-addon-update"  data-plugin_source="' . $plugin['source'] . '" data-plugin="' . $plugin['slug'] . '" href="#"><i class="dashicons dashicons-update"></i>' . __('Update Now', 'theme') . '</a>';
                        }
                    } else {
                        $status         = __('not_installed', 'theme');
                        $status_message = __('Not Installed', 'theme');
                        $url            = esc_url(wp_nonce_url(add_query_arg(array(
                            'page' => TGM_Plugin_Activation::$instance->menu,
                            'plugin' => $plugin['slug'],
                            'plugin_name' => $plugin['name'],
                            'plugin_source' => isset($plugin['source']) ? $plugin['source']: 'repo' ,
                            'tgmpa-install' => 'install-plugin'
                        ), admin_url('themes.php')), 'tgmpa-install'));
                        
                        $button = '<a class="mom-addon-button button" href="' . $url . '">' . __('Install Plugin', 'theme') . '</a>';
                    }
?>

        <li class="plugin-card mom-addons-extension <?php
                    echo $status;
?>" id="<?php
                    echo $plugin['slug'];
?>">
      <div class="plugin-card-top">
            <div class="plugin-icon"><img src="<?php
                    echo $plugin['logo'];
?>" class="img"></div>
        <div class="name column-name">
              <h4 class="title"><?php
                    echo $plugin['name'];
?></h4>
        </div>
        <div class="action-links">
          <ul class="plugin-action-buttons">
            <li>        
                        <?php echo $button; ?>
            </li>
            <?php if(isset($plugin['required']) && $plugin['required'] == true) { ?>
            <li class="required">
                <?php echo '( '.__('REQUIRED', 'theme').' )'; ?>
            </li>
            <?php } ?>
          </ul>        
        </div>
        <div class="desc column-description">
          <p><?php
                    echo $plugin['desc'];
?></p>
          <p class="authors"> <cite><?php __('By','theme'); ?> <?php
                    echo $plugin['author'];
?></cite> <span class="status <?php
                    echo $status;
?> alignright"><?php
                    echo $status_message;
?></span></p>
        </div>
      </div>
        </li>

      <?php

                }
            endforeach;
?>

    </ul>

<?php  }
        
        /**
         * 
         * get list of all folders in the directory
         */
        public static function getFoldersList($path)
        {
            $dir      = scandir($path);
            $arrFiles = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $filepath = $path . "/" . $file;
                if (is_dir($filepath))
                    $arrFiles[] = $file;
            }
            return ($arrFiles);
        }
        
        public static function throwError($message, $code = null)
        {
            if (!empty($code))
                throw new Exception($message, $code);
            else
                throw new Exception($message);
        }
        

        protected function is_addon_page() {

            if ( isset( $_GET['page'] ) && ( $this->page_slug === $_GET['page'] || $this->plugin_page_slug === $_GET['page'])  ) {
                return true;
            }

            return false;

        }

    } //end class

    

} // end if 

function remove_installing_plugins_menu()
{
    
    remove_submenu_page('themes.php', 'install-required-plugins');
    
}
add_action('admin_menu', 'remove_installing_plugins_menu', 9999);

$ex = new mom_extensions_class;

add_action('wp_ajax_mom_addon_activate', 'mom_addon_activate');
add_action('wp_ajax_nopriv_mom_addon_activate', 'mom_addon_activate');

function mom_addon_activate()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');
    
    $plugin = $_POST['plugin'];
    
    activate_plugin($plugin);
}
add_action('wp_ajax_mom_addon_deactivate', 'mom_addon_deactivate');
add_action('wp_ajax_nopriv_mom_addon_deactivate', 'mom_addon_deactivate');

function mom_addon_deactivate()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');
    
    $plugin = $_POST['plugin'];
    
    deactivate_plugins($plugin);
}

add_action('wp_ajax_mom_addon_update', 'mom_addon_update');
add_action('wp_ajax_nopriv_mom_addon_update', 'mom_addon_update');

function mom_deleteDirectory($dirPath)
{
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    mom_deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        reset($objects);
        rmdir($dirPath);
    }
}

function mom_addon_update()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');
    $updatePath    = MOM_FW . '/plugins/';
    $plugin_source = $_POST['plugin_source'];
    $plugin_path   = WP_PLUGIN_DIR . '/' . $_POST['plugin'];
    WP_Filesystem();
    $unzipfile = unzip_file($plugin_source, $updatePath);
    
    //get extracted folder
    $arrFolders = mom_extensions_class::getFoldersList($updatePath);
    if (empty($arrFolders))
        mom_extensions_class::throwError("The update folder is not extracted");
    
    if (count($arrFolders) > 1)
        mom_extensions_class::throwError("Extracted folders are more then 1. Please check the update file.");
    
    //get product folder
    $pluginFolder = $arrFolders[0];
    
    copy_dir($updatePath . $pluginFolder, $plugin_path);
    mom_deleteDirectory($updatePath . $pluginFolder);
    
}
