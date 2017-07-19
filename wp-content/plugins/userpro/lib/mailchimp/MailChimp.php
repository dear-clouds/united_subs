<?php
class UserProMailChimp
{
	private $api_key;
	private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0/';
	private $verify_ssl   = false;

	function __construct($api_key)
	{
		$this->api_key = $api_key;
		list(, $datacentre) = explode('-', $this->api_key);
		$this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
	}

	public function call($method, $args=array())
	{
		return $this->_raw_request($method, $args);
	}

	private function _raw_request($method, $args=array())
	{      
		$args['apikey'] = $this->api_key;

		$url = $this->api_endpoint.'/'.$method.'.json';

		if (function_exists('curl_init') && function_exists('curl_setopt')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
			$result = curl_exec($ch);
			curl_close($ch);
		}else{
			$json_data = json_encode($args);
			$result = file_get_contents($url, null, stream_context_create(array(
			    'http' => array(
			        'protocol_version' => 1.1,
			        'user_agent'       => 'PHP-MCAPI/2.0',
			        'method'           => 'POST',
			        'header'           => "Content-type: application/json\r\n".
			                              "Connection: close\r\n" .
			                              "Content-length: " . strlen($json_data) . "\r\n",
			        'content'          => $json_data,
			    ),
			)));
		}

		return $result ? json_decode($result, true) : false;
	}

}