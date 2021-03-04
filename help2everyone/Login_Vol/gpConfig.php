<?php
session_start();

//Include Google client library
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '23866020752-vo7e7dfp7a8e2jn9if22c5t2eca18jdo.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'YGkwI8Imu0BR7dguwWNb2eQN'; //Google client secret
$redirectURL = 'http://127.0.0.1/help2everyone/help2everyone/Login_Vol/index2.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
