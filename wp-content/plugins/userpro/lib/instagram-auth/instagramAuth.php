<?php
session_name('instagram');
session_start();
$api_key='';
$api_secret='';
$plugin_url='';
if(isset($_REQUEST['k'])){
	$_SESSION['inApiKey']=$api_key=$_REQUEST['k'];
	$_SESSION['inApiSecret']=$api_secret=$_REQUEST['s'];
	$_SESSION['plugin_url']=$plugin_url=$_REQUEST['plugin_url'].'userpro/lib/instagram-auth/instagramAuth.php';
}
else {
	$api_key=$_SESSION['inApiKey'];
	$api_secret=$_SESSION['inApiSecret'];
	$plugin_url=$_SESSION['plugin_url'];
	
}

define('API_KEY',     $api_key);
define('API_SECRET',  $api_secret);
define('REDIRECT_URI', ''.$plugin_url);
 
 
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // Instagram returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else {
	getAuthorizationCode();
}
 

 
function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
    				'state' => uniqid('', true),
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://api.instagram.com/oauth/authorize/?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
              );

    // Access Token request
    
    $url = 'https://api.instagram.com/oauth/access_token';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
    $token = json_decode($result);
    // Store access token
    $_SESSION['access_token'] = $token->access_token; // guard this!
    $_SESSION['user_id'] =$token->user->id;
    return true;
}
 
function fetch($method) {
    $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
    $url = 'https://api.instagram.com/v1/users/'.$_SESSION['user_id'].'/?access_token='.$_SESSION['access_token'];
    $context = stream_context_create(
                    array('http' =>
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
    $response = json_decode($response);
    $response = $response->data;
    return $response;
    
}

// Congratulations! You have a valid token. Now fetch your profile
$user = fetch('GET');

?>
<html>
	<head>
		<script>
			function assignData(){
		     	window.opener.wpin_UserName='<?php echo $user->full_name;?>';
				window.opener.wpin_DisplayName = '<?php echo $user->username?>'
		     	window.opener.wpin_UserId='<?php echo 'in_'.$user->id;?>';
				window.opener.wpin_ProfilePic='<?php echo $user->profile_picture;?>';
				window.opener.wpin_Bio = '<?php echo $user->bio;?>';
				window.opener.wpin_set_instagram_data();
				window.opener.wpin_instagram_auth_window.close();
			}
		</script>
	</head>
	<body onload="assignData();">
		
	</body>
</html>
