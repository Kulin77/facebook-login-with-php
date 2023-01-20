<?php

// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
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
$permissions = ['email']; // Optional permissions for more permission you need to send your application for review
$loginUrl = $helper->getLoginUrl('http://localhost/facebook-login/callback.php', $permissions);
header("location: ".$loginUrl);exit;
?>
