<?php

require_once 'Mailchimp/Folders.php';
require_once 'Mailchimp/Templates.php';
require_once 'Mailchimp/Users.php';
require_once 'Mailchimp/Helper.php';
require_once 'Mailchimp/Mobile.php';
require_once 'Mailchimp/Ecomm.php';
require_once 'Mailchimp/Neapolitan.php';
require_once 'Mailchimp/Lists.php';
require_once 'Mailchimp/Campaigns.php';
require_once 'Mailchimp/Vip.php';
require_once 'Mailchimp/Reports.php';
require_once 'Mailchimp/Gallery.php';
require_once 'Mailchimp/Exceptions.php';

class Mom_Mailchimp {

    /**
     * Placeholder attribute for Mailchimp_Folders class
     *
     * @var Mailchimp_Folders
     * @access public
     */
    var $folders;
    /**
     * Placeholder attribute for Mailchimp_Templates class
     *
     * @var Mailchimp_Templates
     * @access public
     */
    var $templates;
    /**
     * Placeholder attribute for Mailchimp_Users class
     *
     * @var Mailchimp_Users
     * @access public
     */
    var $users;
    /**
     * Placeholder attribute for Mailchimp_Helper class
     *
     * @var Mailchimp_Helper
     * @access public
     */
    var $helper;
    /**
     * Placeholder attribute for Mailchimp_Mobile class
     *
     * @var Mailchimp_Mobile
     * @access public
     */
    var $mobile;
    /**
     * Placeholder attribute for Mailchimp_Ecomm class
     *
     * @var Mailchimp_Ecomm
     * @access public
     */
    var $ecomm;
    /**
     * Placeholder attribute for Mailchimp_Neapolitan class
     *
     * @var Mailchimp_Neapolitan
     * @access public
     */
    var $neapolitan;
    /**
     * Placeholder attribute for Mailchimp_Lists class
     *
     * @var Mailchimp_Lists
     * @access public
     */
    var $lists;
    /**
     * Placeholder attribute for Mailchimp_Campaigns class
     *
     * @var Mailchimp_Campaigns
     * @access public
     */
    var $campaigns;
    /**
     * Placeholder attribute for Mailchimp_Vip class
     *
     * @var Mailchimp_Vip
     * @access public
     */
    var $vip;
    /**
     * Placeholder attribute for Mailchimp_Reports class
     *
     * @var Mailchimp_Reports
     * @access public
     */
    var $reports;
    /**
     * Placeholder attribute for Mailchimp_Gallery class
     *
     * @var Mailchimp_Gallery
     * @access public
     */
    var $gallery;

    /**
     * CURLOPT_SSL_VERIFYPEER setting
     * @var  bool
     */
    public $ssl_verifypeer = true;
    /**
     * CURLOPT_SSL_VERIFYHOST setting
     * @var  bool
     */
    public $ssl_verifyhost = 2;
    /**
     * CURLOPT_CAINFO
     * @var  string
     */
    public $ssl_cainfo = null;

    /**
     * the api key in use
     * @var  string
     */
    public $apikey;
    public $ch;
    public $root = 'https://api.mailchimp.com/2.0';
    /**
     * whether debug mode is enabled
     * @var  bool
     */
    public $debug = false;

    public static $error_map = array(
        "ValidationError" => "Mom_Mailchimp_ValidationError",
        "ServerError_MethodUnknown" => "Mom_Mailchimp_ServerError_MethodUnknown",
        "ServerError_InvalidParameters" => "Mom_Mailchimp_ServerError_InvalidParameters",
        "Unknown_Exception" => "Mom_Mailchimp_Unknown_Exception",
        "Request_TimedOut" => "Mom_Mailchimp_Request_TimedOut",
        "Zend_Uri_Exception" => "Mom_Mailchimp_Zend_Uri_Exception",
        "PDOException" => "Mom_Mailchimp_PDOException",
        "Avesta_Db_Exception" => "Mom_Mailchimp_Avesta_Db_Exception",
        "XML_RPC2_Exception" => "Mom_Mailchimp_XML_RPC2_Exception",
        "XML_RPC2_FaultException" => "Mom_Mailchimp_XML_RPC2_FaultException",
        "Too_Many_Connections" => "Mom_Mailchimp_Too_Many_Connections",
        "Parse_Exception" => "Mom_Mailchimp_Parse_Exception",
        "User_Unknown" => "Mom_Mailchimp_User_Unknown",
        "User_Disabled" => "Mom_Mailchimp_User_Disabled",
        "User_DoesNotExist" => "Mom_Mailchimp_User_DoesNotExist",
        "User_NotApproved" => "Mom_Mailchimp_User_NotApproved",
        "Invalid_ApiKey" => "Mom_Mailchimp_Invalid_ApiKey",
        "User_UnderMaintenance" => "Mom_Mailchimp_User_UnderMaintenance",
        "Invalid_AppKey" => "Mom_Mailchimp_Invalid_AppKey",
        "Invalid_IP" => "Mom_Mailchimp_Invalid_IP",
        "User_DoesExist" => "Mom_Mailchimp_User_DoesExist",
        "User_InvalidRole" => "Mom_Mailchimp_User_InvalidRole",
        "User_InvalidAction" => "Mom_Mailchimp_User_InvalidAction",
        "User_MissingEmail" => "Mom_Mailchimp_User_MissingEmail",
        "User_CannotSendCampaign" => "Mom_Mailchimp_User_CannotSendCampaign",
        "User_MissingModuleOutbox" => "Mom_Mailchimp_User_MissingModuleOutbox",
        "User_ModuleAlreadyPurchased" => "Mom_Mailchimp_User_ModuleAlreadyPurchased",
        "User_ModuleNotPurchased" => "Mom_Mailchimp_User_ModuleNotPurchased",
        "User_NotEnoughCredit" => "Mom_Mailchimp_User_NotEnoughCredit",
        "MC_InvalidPayment" => "Mom_Mailchimp_MC_InvalidPayment",
        "List_DoesNotExist" => "Mom_Mailchimp_List_DoesNotExist",
        "List_InvalidInterestFieldType" => "Mom_Mailchimp_List_InvalidInterestFieldType",
        "List_InvalidOption" => "Mom_Mailchimp_List_InvalidOption",
        "List_InvalidUnsubMember" => "Mom_Mailchimp_List_InvalidUnsubMember",
        "List_InvalidBounceMember" => "Mom_Mailchimp_List_InvalidBounceMember",
        "List_AlreadySubscribed" => "Mom_Mailchimp_List_AlreadySubscribed",
        "List_NotSubscribed" => "Mom_Mailchimp_List_NotSubscribed",
        "List_InvalidImport" => "Mom_Mailchimp_List_InvalidImport",
        "MC_PastedList_Duplicate" => "Mom_Mailchimp_MC_PastedList_Duplicate",
        "MC_PastedList_InvalidImport" => "Mom_Mailchimp_MC_PastedList_InvalidImport",
        "Email_AlreadySubscribed" => "Mom_Mailchimp_Email_AlreadySubscribed",
        "Email_AlreadyUnsubscribed" => "Mom_Mailchimp_Email_AlreadyUnsubscribed",
        "Email_NotExists" => "Mom_Mailchimp_Email_NotExists",
        "Email_NotSubscribed" => "Mom_Mailchimp_Email_NotSubscribed",
        "List_MergeFieldRequired" => "Mom_Mailchimp_List_MergeFieldRequired",
        "List_CannotRemoveEmailMerge" => "Mom_Mailchimp_List_CannotRemoveEmailMerge",
        "List_Merge_InvalidMergeID" => "Mom_Mailchimp_List_Merge_InvalidMergeID",
        "List_TooManyMergeFields" => "Mom_Mailchimp_List_TooManyMergeFields",
        "List_InvalidMergeField" => "Mom_Mailchimp_List_InvalidMergeField",
        "List_InvalidInterestGroup" => "Mom_Mailchimp_List_InvalidInterestGroup",
        "List_TooManyInterestGroups" => "Mom_Mailchimp_List_TooManyInterestGroups",
        "Campaign_DoesNotExist" => "Mom_Mailchimp_Campaign_DoesNotExist",
        "Campaign_StatsNotAvailable" => "Mom_Mailchimp_Campaign_StatsNotAvailable",
        "Campaign_InvalidAbsplit" => "Mom_Mailchimp_Campaign_InvalidAbsplit",
        "Campaign_InvalidContent" => "Mom_Mailchimp_Campaign_InvalidContent",
        "Campaign_InvalidOption" => "Mom_Mailchimp_Campaign_InvalidOption",
        "Campaign_InvalidStatus" => "Mom_Mailchimp_Campaign_InvalidStatus",
        "Campaign_NotSaved" => "Mom_Mailchimp_Campaign_NotSaved",
        "Campaign_InvalidSegment" => "Mom_Mailchimp_Campaign_InvalidSegment",
        "Campaign_InvalidRss" => "Mom_Mailchimp_Campaign_InvalidRss",
        "Campaign_InvalidAuto" => "Mom_Mailchimp_Campaign_InvalidAuto",
        "MC_ContentImport_InvalidArchive" => "Mom_Mailchimp_MC_ContentImport_InvalidArchive",
        "Campaign_BounceMissing" => "Mom_Mailchimp_Campaign_BounceMissing",
        "Campaign_InvalidTemplate" => "Mom_Mailchimp_Campaign_InvalidTemplate",
        "Invalid_EcommOrder" => "Mom_Mailchimp_Invalid_EcommOrder",
        "Absplit_UnknownError" => "Mom_Mailchimp_Absplit_UnknownError",
        "Absplit_UnknownSplitTest" => "Mom_Mailchimp_Absplit_UnknownSplitTest",
        "Absplit_UnknownTestType" => "Mom_Mailchimp_Absplit_UnknownTestType",
        "Absplit_UnknownWaitUnit" => "Mom_Mailchimp_Absplit_UnknownWaitUnit",
        "Absplit_UnknownWinnerType" => "Mom_Mailchimp_Absplit_UnknownWinnerType",
        "Absplit_WinnerNotSelected" => "Mom_Mailchimp_Absplit_WinnerNotSelected",
        "Invalid_Analytics" => "Mom_Mailchimp_Invalid_Analytics",
        "Invalid_DateTime" => "Mom_Mailchimp_Invalid_DateTime",
        "Invalid_Email" => "Mom_Mailchimp_Invalid_Email",
        "Invalid_SendType" => "Mom_Mailchimp_Invalid_SendType",
        "Invalid_Template" => "Mom_Mailchimp_Invalid_Template",
        "Invalid_TrackingOptions" => "Mom_Mailchimp_Invalid_TrackingOptions",
        "Invalid_Options" => "Mom_Mailchimp_Invalid_Options",
        "Invalid_Folder" => "Mom_Mailchimp_Invalid_Folder",
        "Invalid_URL" => "Mom_Mailchimp_Invalid_URL",
        "Module_Unknown" => "Mom_Mailchimp_Module_Unknown",
        "MonthlyPlan_Unknown" => "Mom_Mailchimp_MonthlyPlan_Unknown",
        "Order_TypeUnknown" => "Mom_Mailchimp_Order_TypeUnknown",
        "Invalid_PagingLimit" => "Mom_Mailchimp_Invalid_PagingLimit",
        "Invalid_PagingStart" => "Mom_Mailchimp_Invalid_PagingStart",
        "Max_Size_Reached" => "Mom_Mailchimp_Max_Size_Reached",
        "MC_SearchException" => "Mom_Mailchimp_MC_SearchException"
    );

    public function __construct($apikey=null, $opts=array()) {
        if(!$apikey) $apikey = getenv('MAILCHIMP_APIKEY');
        if(!$apikey) $apikey = $this->readConfigs();
        if(!$apikey) throw new Mom_Mailchimp_Error('You must provide a MailChimp API key');
        $this->apikey = $apikey;
        $dc = "us1";
        if (strstr($this->apikey,"-")){
            list($key, $dc) = explode("-",$this->apikey,2);
            if (!$dc) $dc = "us1";
        }
        $this->root = str_replace('https://api', 'https://'.$dc.'.api', $this->root);
        $this->root = rtrim($this->root, '/') . '/';

        if (!isset($opts['timeout']) || !is_int($opts['timeout'])){
            $opts['timeout']=600;
        }
        if (isset($opts['debug'])){
            $this->debug = true;
        }
        if (isset($opts['ssl_verifypeer'])){
            $this->ssl_verifypeer = $opts['ssl_verifypeer'];
        }
        if (isset($opts['ssl_verifyhost'])){
            $this->ssl_verifyhost = $opts['ssl_verifyhost'];
        }
        if (isset($opts['ssl_cainfo'])){
            $this->ssl_cainfo = $opts['ssl_cainfo'];
        }


        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'MailChimp-PHP/2.0.4');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $opts['timeout']);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->folders = new Mom_Mailchimp_Folders($this);
        $this->templates = new Mom_Mailchimp_Templates($this);
        $this->users = new Mom_Mailchimp_Users($this);
        $this->helper = new Mom_Mailchimp_Helper($this);
        $this->mobile = new Mom_Mailchimp_Mobile($this);
        $this->ecomm = new Mom_Mailchimp_Ecomm($this);
        $this->neapolitan = new Mom_Mailchimp_Neapolitan($this);
        $this->lists = new Mom_Mailchimp_Lists($this);
        $this->campaigns = new Mom_Mailchimp_Campaigns($this);
        $this->vip = new Mom_Mailchimp_Vip($this);
        $this->reports = new Mom_Mailchimp_Reports($this);
        $this->gallery = new Mom_Mailchimp_Gallery($this);
    }

    public function __destruct() {
        curl_close($this->ch);
    }

    public function call($url, $params) {
        $params['apikey'] = $this->apikey;
        $params = json_encode($params);
        $ch = $this->ch;

        curl_setopt($ch, CURLOPT_URL, $this->root . $url . '.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        // SSL Options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->ssl_verifyhost);
        if ($this->ssl_cainfo) curl_setopt($ch, CURLOPT_CAINFO, $this->ssl_cainfo);

        $start = microtime(true);
        $this->log('Call to ' . $this->root . $url . '.json: ' . $params);
        if($this->debug) {
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $curl_buffer);
        }

        $response_body = curl_exec($ch);
        $info = curl_getinfo($ch);
        $time = microtime(true) - $start;
        if($this->debug) {
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($ch)) {
            throw new Mom_Mailchimp_HttpError("API call to $url failed: " . curl_error($ch));
        }
        $result = json_decode($response_body, true);
        
        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result);
        }

        return $result;
    }

    public function readConfigs() {
        $paths = array('~/.mailchimp.key', '/etc/mailchimp.key');
        foreach($paths as $path) {
            if(file_exists($path)) {
                $apikey = trim(file_get_contents($path));
                if($apikey) return $apikey;
            }
        }
        return false;
    }

    public function castError($result) {
        if($result['status'] !== 'error' || !$result['name']) throw new Mom_Mailchimp_Error('We received an unexpected error: ' . json_encode($result));

        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Mailchimp_Error';
        return new $class($result['error'], $result['code']);
    }

    public function log($msg) {
        if($this->debug) error_log($msg);
    }
}


