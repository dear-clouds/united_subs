<?php
/**
 * Plugin bootstrap class
 */

namespace RSSAutopilot;

require_once RSSAP_PLUGIN_DIR . '/classes/request.php';

class Bootstrap {

    private $prefix = 'rssap-';
    private $namespace = '\RSSAutopilot';
    private $routes = array();
    private $templateVariables = array();

    /**
     * @var string
     */
    public $currentPage = '';

    /**
     * @var string
     */
    public $currentAction = '';

    private $request = null;

    /**
     *
     */
    public function __construct()
    {
        $this->request = \RSSAutopilot\Request::getInstance();
        add_action( 'init', array($this, 'init') );
    }

    /**
     * Register admin menu
     * @return void
     */
    public function registerMenu()
    {
        // Main menu block
        add_menu_page( __( 'RSS Autopilot', 'rss-autopilot' ),
            __( 'RSS Autopilot', 'rss-autopilot' ),
            'activate_plugins', 'rssap-feeds',
            array($this, 'loadTemplate'), 'dashicons-rss-autopilot', '10.89042381278' );

        $manageFeeds = $this->addSubMenu(
            'rssap-feeds',
            __( 'All Feeds', 'rss-autopilot' ),
            'activate_plugins',
            'feeds'
        );

        // Add feed
        $addFeed = $this->addSubMenu(
            'rssap-feeds',
            __( 'Add Feed', 'rss-autopilot' ),
            'activate_plugins',
            'feeds',
            'add'
        );

        // Show logs
        $showLogs = $this->addSubMenu(
            'rssap-feeds',
            __( 'Logs', 'rss-autopilot' ),
            'activate_plugins',
            'feeds',
            'logs'
        );
    }

    /**
     * Add admin submenu
     * @param $parent
     * @param $title
     * @param $permission
     * @param $controller
     * @param string $action
     * @return false|string
     */
    private function addSubMenu($parent, $title, $permission, $controller, $action='')
    {
        $path = $this->prefix.$controller.($action?'&action='.$action:'');

        $name = add_submenu_page(
            $parent,
            $title, $title,
            $permission, $path,
            array($this, 'loadTemplate')
        );

        $this->routes[$name] = array(
            'controller' => $controller,
            'action' => $action?$action:'index'
        );

        add_action( 'load-' . $name, array($this, 'route') );

        return $name;
    }

    /**
     * Load admin panel specific hooks
     */
    public function loadAdmin()
    {
        // Register menu
        add_action( 'admin_menu', array($this, 'registerMenu'));
    }

    /**
     *
     */
    public function updateFeeds()
    {
        require_once(RSSAP_PLUGIN_DIR.'/classes/models/feed.php');

        @ini_set('safe_mode','Off');
        @ini_set('ignore_user_abort','Off');
        @ignore_user_abort(true);

        // Get all feeds from DB
        $feeds = get_posts(array(
            'post_type'         => 'rssap-feed',
            'posts_per_page'    => -1,
            'post_status'       => 'any',
            'post_parent'       => null
        ));
        logRSSAutoPilot('Feeds selected: '.count($feeds));

        // Temporary remove post filters to allow adding iframes and objects as post content
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');

        // Execute updateNews on each feed that requires it
        foreach ($feeds as $item)
        {
            logRSSAutoPilot('Checking: '.$item->post_title);
            $feed = new \RSSAutopilot\FeedModel($item->ID);

            if ($feed->campaign_status != 'started') {
                logRSSAutoPilot('Ignoring inactive campaign: '.$item->post_title);
                continue;
            }
            if (!$feed->last_update) {
                $feed->last_update = 0;
            }

            if (time() > ((int)$feed->last_update + (int)$feed->update_frequency)) {
                logRSSAutoPilot('Loading: '.$feed->title);
                $feed->last_update = time();
                $feed->save();
                $feed->updateNews();
                $feed->save();
            } else {
                logRSSAutoPilot('Update not needed for '.$feed->title);
            }
        }

        // Add post filters back
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');
    }

    /**
     * Router
     */
    public function route()
    {
        $page = isset($_GET['page'])?$_GET['page']:null;
        $action = (isset($_GET['action']) && (!empty($_GET['action'])))?$_GET['action']:'index';
        if (!$page) return;

        $page = substr($page, strlen($this->prefix));

        $this->currentPage = $page;
        $this->currentAction = $action;

        $className = $this->namespace.'\\'.ucfirst($page);
        $path = RSSAP_PLUGIN_DIR.'/controllers/'.$page.'.php';

        if (file_exists($path)) {
            require_once($path);
            if (class_exists($className)) {
                $controller = new $className($this);
                $this->templateVariables = $controller->$action();
            }
        }
        return;
    }

    /**
     * Render template
     * @param array $vars
     * @param null $page
     * @param null $template
     */
    public function loadTemplate($vars = array(), $page=null, $template=null)
    {
        if (!$page) {
            $page = isset($_GET['page'])?$_GET['page']:null;
        }

        if (!$template) {
            $template = (isset($_GET['action']) && !empty($_GET['action']))?$_GET['action']:'index';
        }

        if (!$page) return;

        $controller = substr($page, strlen($this->prefix));

        if (!$vars || !count($vars)) {
            $vars = $this->templateVariables;
        }
        if (isset($vars)) {
            extract($vars);
        }
        include(RSSAP_PLUGIN_DIR.'/templates/'.$controller.'/'.$template.'.phtml');
    }

    /**
     * Get menu URL
     * @param $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    public function menuUrl($controller, $action='', $params=array())
    {
        $url = menu_page_url( $controller, false );

        if ($action) {
            $url = add_query_arg(array( 'action' => $action ), $url);
        }

        if (count($params)) {
            $url = add_query_arg($params, $url);
        }

        return $url;
    }

    /**
     * Init data source, register post types
     */
    public function init()
    {
        register_post_type( 'rssap-feed', array(
            'labels' => array(
                'name' => __( 'News Feed', 'rss-autopilot' ),
                'singular_name' => __( 'News Feed', 'rss-autopilot' ) ),
            'rewrite' => false,
            'query_var' => false )
        );
    }

    /**
     * Returns request object
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }
}

?>