<?php

namespace RSSAutopilot;

require_once(RSSAP_PLUGIN_DIR.'/classes/models/feed.php');
require_once(RSSAP_PLUGIN_DIR.'/classes/validate-form.php');
require_once(RSSAP_PLUGIN_DIR.'/classes/posts-grid.php');

/**
 * Feeds controller
 */
class Feeds {
    /**
     * Access to bootstrap object
     */
    private $bootstrap = null;

    public function __construct($bootstrap=null)
    {
        $this->bootstrap = $bootstrap;

        if ( is_admin() ) {
            $screen = get_current_screen();
            $screen->add_help_tab(array(
                'id' => 'rssap-feeds-help',
                'title' => __('Getting started', 'rss-autopilot'),
                'content' =>
                    '<p>' . __('This is a page you should start with. You can see a list of existing feeds on index page.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('For more details check <a href="' . rssap_plugin_url('RSSAutopilot-UserManual.pdf') . '">User Manual</a>', 'rss-autopilot') . '</p>'
            ));
            $screen->add_help_tab(array(
                'id' => 'rssap-feeds-general-help',
                'title' => __('General Options', 'rss-autopilot'),
                'content' =>
                    '<p>' . __('You can put any RSS or Atom URL into Feed URL input.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Author, status and categories are default settings for new posts.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Update frequency defines how often script will check feeds.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('You can download all images to your website using "Download images" option', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Add canonical URL option adds meta tag to your post page with link to original article.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('You can add "Read more" link using your specific template that will be appended to the end of content', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Web scrapper downloads pages by URLs from feed and tries to parse post content, it is useful when summary is too short', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Some feeds provide thumbnails. You can use "Thumbnails from feed" option in this case. If there are no thumbnails then you can try "Thumbnail from content". You can always preview feed before saving.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('For more details check <a href="' . rssap_plugin_url('RSSAutopilot-UserManual.pdf') . '">User Manual</a>', 'rss-autopilot') . '</p>'
            ));
            $screen->add_help_tab(array(
                'id' => 'rssap-feeds-filters-help',
                'title' => __('Filters', 'rss-autopilot'),
                'content' =>
                    '<p>' . __('You can filter feed posts by specific words you want or don\'t want to appear', 'rss-autopilot') . '</p>' .
                    '<p>' . __('In order to do this select "Enable content filters" and put and words separating them by commmas.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('Words may appear in title, article or feed summary.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('For more details check <a href="' . rssap_plugin_url('RSSAutopilot-UserManual.pdf') . '">User Manual</a>', 'rss-autopilot') . '</p>'
            ));
            $screen->add_help_tab(array(
                'id' => 'rssap-feeds-scrapper-help',
                'title' => __('Content Scrapper', 'rss-autopilot'),
                'content' =>
                    '<p>' . __('In cases when summary is too short you can enable Content Scrapper option. In most cases it works perfect, but, in some cases you may need to specify content box yourself.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('To select content on a web page click "Configure content extractor" button just below. You will see a dialog with first page from feed opened in it. Here you can select any box by clicking on it and it will become green. Close dialog and you will see text box below button updated with XPath necessary to get this article. Click "Preview" button to see sample results.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('You can also "remove" some blocks inside selected block by clicking on them. It is pretty simple: if block has green background - it\'s contents will be scraped except for those that are red.', 'rss-autopilot') . '</p>' .
                    '<p>' . __('For more details check <a href="' . rssap_plugin_url('RSSAutopilot-UserManual.pdf') . '">User Manual</a>', 'rss-autopilot') . '</p>'
            ));
        }
    }

    /**
     * List of feeds
     * @return array
     */
    public function index()
    {
        $grid = new \RSSAutopilot\PostsGrid('rssap-feed');

        return array(
            'grid' => $grid
        );
    }

    /**
     * Create new feed
     * @return array
     */
    function add()
    {
        $request = $this->bootstrap->getRequest();
        $data = $request->getPost();

        if (!empty($data) && $request->isAjaxRequest()) {
            check_admin_referer( 'rssap-save-rss-autopilot' );

            $form = $this->getFeedFormValidator($data);

            if (!$form->isValid()) {
                $this->sendAjaxRespone(false, $form->validate());
            } else {
                $dataSource = new \RSSAutopilot\FeedModel($data);
                $dataSource->save();

                $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
                $this->sendAjaxRespone(true, array(), array(), $redirectUrl);
            }
        }

        wp_enqueue_script(
            'rss-autopilots',
            rssap_plugin_url('admin/js/feeds.js'),
            array( 'jquery' ),
            RSSAP_VERSION,
            'all'
        );

        wp_enqueue_script(
            'base64encode',
            rssap_plugin_url('admin/js/base64.min.js'),
            array(),
            RSSAP_VERSION
        );

        wp_enqueue_script(
            'fancybox',
            rssap_plugin_url('admin/js/fancybox/jquery.fancybox.js'),
            array( 'jquery' ),
            RSSAP_VERSION
        );

        wp_enqueue_style(
            'fancybox-css',
            rssap_plugin_url( 'admin/js/fancybox/jquery.fancybox.css' ),
            array(),
            RSSAP_VERSION,
            'all'
        );

        // Tooltips
        wp_enqueue_script(
            'tooltipster',
            rssap_plugin_url('admin/js/jquery.tooltipster.min.js'),
            array( 'jquery' ),
            RSSAP_VERSION
        );

        wp_enqueue_style(
            'tooltipster-css',
            rssap_plugin_url( 'admin/css/tooltipster.css' ),
            array(),
            RSSAP_VERSION,
            'all'
        );

        return array(
            'statuses' => $this->_getStatuses(),
            'updateFrequences' => $this->_getUpdateFrequences(),
            'postTypes' => get_post_types( '', 'names' )
        );
    }

    /**
     * Edit feed
     * @return array
     */
    function edit()
    {
        $request = $this->bootstrap->getRequest();
        $data = $request->getPost();
        $post = $request->getRequest('post');

        if (!empty($data) && $request->isAjaxRequest()) {
            check_admin_referer( 'rssap-save-rss-autopilot' );

            $form = $this->getFeedFormValidator($data);

            if (!$form->isValid()) {
                $this->sendAjaxRespone(false, $form->validate());
            } else {
                $dataSource = new \RSSAutopilot\FeedModel($post);
                $dataSource->setValues($data);
                $dataSource->save();

                $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
                $this->sendAjaxRespone(true, array(), array(), $redirectUrl);
            }
        }

        wp_enqueue_script(
            'rss-autopilots',
            rssap_plugin_url('admin/js/feeds.js'),
            array( 'jquery' ),
            RSSAP_VERSION,
            'all'
        );

        wp_enqueue_script(
            'base64encode',
            rssap_plugin_url('admin/js/base64.min.js'),
            array(),
            RSSAP_VERSION
        );

        wp_enqueue_script(
            'fancybox',
            rssap_plugin_url('admin/js/fancybox/jquery.fancybox.js'),
            array( 'jquery' ),
            RSSAP_VERSION
        );

        wp_enqueue_style(
            'fancybox-css',
            rssap_plugin_url( 'admin/js/fancybox/jquery.fancybox.css' ),
            array(),
            RSSAP_VERSION,
            'all'
        );

        // Tooltips
        wp_enqueue_script(
            'tooltipster',
            rssap_plugin_url('admin/js/jquery.tooltipster.min.js'),
            array( 'jquery' ),
            RSSAP_VERSION
        );

        wp_enqueue_style(
            'tooltipster-css',
            rssap_plugin_url( 'admin/css/tooltipster.css' ),
            array(),
            RSSAP_VERSION,
            'all'
        );

        $feed = new \RSSAutopilot\FeedModel($post);

        return array(
            'feed' => $feed,
            'statuses' => $this->_getStatuses(),
            'updateFrequences' => $this->_getUpdateFrequences(),
            'postTypes' => get_post_types( '', 'names' )
        );
    }

    /**
     * Delete feed action
     */
    public function delete()
    {
        $request = $this->bootstrap->getRequest();
        $post = $request->getRequest('post');

        if ($post) {
            $posts = array();
            if (is_array($post)) {
                $posts = $post;
            } else {
                $posts = array($post);
            }

            foreach ($posts as $postId) {
                $feed = new \RSSAutopilot\FeedModel(array('id'=>$postId));
                $feed->delete();
            }

            $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
            wp_safe_redirect($redirectUrl);
            exit();
        } else {
            wp_die( __( 'Error deleting', 'rss-autopilot' ) );
        }
    }

    /**
     * Delete posts added by feed
     */
    public function removePosts()
    {
        $request = $this->bootstrap->getRequest();
        $post = $request->getRequest('post');

        if ($post) {
            $feed = new \RSSAutopilot\FeedModel($post);

            $posts = get_posts(array(
                'post_type'         => 'any',
                'posts_per_page'    => -1,
                'post_status'       => 'any',
                'post_parent'       => null,
                'meta_key'=>'_rss_feed_id',
                'meta_value'=>$post
            ));

            foreach ($posts as $item) {
                wp_delete_post( $item->ID, false );
            }

            $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
            wp_safe_redirect($redirectUrl);
            exit();
        } else {
            wp_die( __( 'Error deleting posts', 'rss-autopilot' ) );
        }
    }

    /**
     * Change feed status action
     */
    public function changeStatus()
    {
        $request = $this->bootstrap->getRequest();
        $post = $request->getRequest('post');
        $status = $request->getRequest('status');

        if ($post) {
            if ($status != 'started') {
                $status = 'stopped';
            }

            $feed = new \RSSAutopilot\FeedModel($post);
            $feed->campaign_status = $status;
            $feed->save();

            $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
            wp_safe_redirect($redirectUrl);
            exit();
        } else {
            wp_die( __( 'Error changing status', 'rss-autopilot' ) );
        }
    }

    /**
     * Run feed
     */
    public function run()
    {
        $request = $this->bootstrap->getRequest();
        $post = $request->getRequest('post');

        if ($post) {
            $feed = new \RSSAutopilot\FeedModel($post);

            $feed->last_update = time();
            $feed->save();
            $feed->updateNews();

            $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds');
            wp_safe_redirect($redirectUrl);
            exit();
        } else {
            wp_die( __( 'Error changing status', 'rss-autopilot' ) );
        }
    }

    /**
     * Preview feed
     * @return array
     */
    public function preview()
    {
        $request = $this->bootstrap->getRequest();
        $data = $request->getPost();

        $url = strtolower(trim($data['url']));
        if ((substr($url,0,4) == 'http') || (substr($url,0,4) == 'feed')) {
            $feed = new \RSSAutopilot\FeedModel($data);
            $list = $feed->getNews(5);
        } else {
            $list = array();
            $feed = null;
        }

        $this->bootstrap->loadTemplate(
            array(
                'list' => $list,
                'feed' => $feed
            )
        );

        exit;
    }

    /**
     * Preview sample article for extracting content
     */
    public function extract()
    {
        $request = $this->bootstrap->getRequest();
        $feedUrl = $request->getRequest('feedUrl');

        if ($feedUrl) {
            $feedUrl = base64_decode($feedUrl);
            $feed = new \RSSAutopilot\FeedModel(array('url'=>$feedUrl));
            $page = $feed->getFirstPage($this->bootstrap->menuUrl('rssap-feeds', 'downloader'));
        }

        $this->bootstrap->loadTemplate(
            array(
                'page' => $page
            )
        );
        exit;
    }

    public function downloader()
    {
        $request = $this->bootstrap->getRequest();
        $url = base64_decode($request->getRequest('url'));

        if (substr($url, 0, 2) == '//') {
            $url = 'http://'.substr($url,2);
        }

        echo file_get_contents($url);
    }


    /**
     * List of feeds
     * @return array
     */
    public function logs()
    {
        $file = RSSAP_PLUGIN_DIR .'/logs.txt';
        $content = '';
        if (file_exists($file)) {
            $content = file_get_contents($file);
        }

        return array(
            'content' => $content
        );
    }

    /**
     * Clear logs action
     */
    public function clearLogs()
    {
        $file = RSSAP_PLUGIN_DIR .'/logs.txt';

        if (file_exists($file)) {
            $fp = fopen($file, 'w');
            fclose($fp);
        }

        $redirectUrl = $this->bootstrap->menuUrl('rssap-feeds', 'logs');

        wp_safe_redirect($redirectUrl);
        exit();
    }

    /**
     * Returns feed form validator
     * @param $data
     * @return ValidateForm
     */
    private function getFeedFormValidator($data)
    {
        $form = new \RSSAutopilot\ValidateForm();
        $form->setData($data);
        $type = isset($data['type'])?$data['type']:'';

        $form->addField(
            'title',
            __('Title', 'rss-autopilot'),
            array('required')
        );

        $form->addField(
            'url',
            __('Feed URL', 'rss-autopilot'),
            array('required')
        );

        return $form;
    }

    /**
     * Send AJAX response of a specified format
     * @param $status
     * @param array $errors
     * @param string $redirectUrl
     */
    function sendAjaxRespone($status, $errors=array(), $data=array(), $redirectUrl = '')
    {
        $response = array (
            'status' => $status
        );

        if ($errors && count($errors)) {
            $response['errors'] = $errors;
        }

        if ($data && count($data)) {
            $response['data'] = $data;
        }

        if ($redirectUrl) {
            $response['redirect_url'] = $redirectUrl;
        }

        echo rssap_json_encode($response);

        exit;
    }

    private function _getStatuses()
    {
        return get_post_statuses();
    }

    private function _getUpdateFrequences()
    {
        return array(
            '600' => __('10 minutes', 'rss-autopilot'),
            '1200' => __('20 minutes', 'rss-autopilot'),
            '1800' => __('30 minutes', 'rss-autopilot'),
            '3600' => __('1 hour', 'rss-autopilot'),
            '7200' => __('2 hours', 'rss-autopilot'),
            '14400' => __('4 hours', 'rss-autopilot'),
            '28800' => __('8 hours', 'rss-autopilot'),
            '57600' => __('16 hours', 'rss-autopilot'),
            '86400' => __('1 day', 'rss-autopilot'),
        );
    }
}

?>