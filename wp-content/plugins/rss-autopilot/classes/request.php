<?php

namespace RSSAutopilot;

/**
 * Class Request
 * @package RSSAutopilot
 */
class Request {

    /**
     * Returns the singleton instance
     * @return static
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Protected constructor to prevent creating a new instance
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * Returns $_POST data
     * @param string $var
     * @return mixed
     */
    public function getPost($var='')
    {
        if ($var) {
            return isset($_POST[$var])?$_POST[$var]:null;
        }

        $data = $_POST;
        unset($data['_wpnonce']);
        unset($data['_wp_http_referer']);

        return $data;
    }

    /**
     * Returns $_POST data
     * @param string $var
     * @return mixed
     */
    public function getRequest($var='')
    {
        if ($var) {
            return isset($_GET[$var])?$_GET[$var]:null;
        }
        return $_GET;
    }

    /**
     * Check if it is an ajax request
     * @return bool
     */
    public function isAjaxRequest()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
}