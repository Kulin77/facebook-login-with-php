<?php
session_start();
if (!function_exists('sol_uniqid')) {
    function sol_uniqid() {
        if (isset($_COOKIE['sol_uniqid'])) {
            if (get_site_transient('n_' . $_COOKIE['sol_uniqid']) !== false) {
                return $_COOKIE['sol_uniqid'];
            }
        }
        $_COOKIE['sol_uniqid'] = uniqid('sap', true);
        setcookie('sol_uniqid', $_COOKIE['sol_uniqid'], time() + 3600, '/', '', false, true);
        set_site_transient('n_' . $_COOKIE['sol_uniqid'], 1, 3600);

        return $_COOKIE['sol_uniqid'];
    }
}
require_once( 'lib/Facebook/autoload.php' );

$fb = new Facebook\Facebook([
    'app_id' => 'write_your_app_id_here',
    'app_secret' => 'write_your_app_secret_here',
        ]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error  

    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues  

    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
if (!isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}
if (!$accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }
}
try {
    // Get the Facebook\GraphNodes\GraphUser object for the current user.
    // If you provided a 'default_access_token', the '{access-token}' is optional.
    $response = $fb->get('/me?fields=id,name,email,first_name,last_name,picture', $accessToken->getValue());
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'ERROR in: Graph ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'ERROR: validation fails ' . $e->getMessage();
    exit;
}
$me = $response->getGraphUser();
//print_r($me);
echo "Full Name: " . $me->getField('name') . "<br>";
echo "First Name: " . $me->getField('first_name') . "<br>";
echo "Last Name: " . $me->getField('last_name') . "<br>";
if( $me->getField('email') == NULL ){
    echo "Email :" . $me->getField('id').'@facebook.com';
} else {
    echo "Email :" . $me->getField('email');
}    
echo "Facebook ID: <a href='https://www.facebook.com/" . $me->getField('id') . "' target='_blank'>" . $me->getField('id') . "</a><br>";
echo $me->getPicture()->getUrl(). "<br>";
?>
<img src="<?php echo $me->getPicture()->getUrl(); ?>"/>