<?php
require_once 'google-api/vendor/autoload.php';

$gClient = new Google_Client();
$gClient->setClientId("346437363894-6j1fp4hn4svkf4iobfov0l0df7pn1s8v.apps.googleusercontent.com");
$gClient->setClientSecret("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");
$gClient->setApplicationName("thebox lab Login ");
$gClient->setRedirectUri("http://localhost/Authentication/google/controller.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

// login URL
$login_url = $gClient->createAuthUrl();
?>