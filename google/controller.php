<?php
session_start();

require_once 'core/controller.Class.php';
require_once 'config.php';
if(isset($_GET["code"])){
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
}else{
    header('Location:../home.php');
    exit();
}

if(isset($token["error"]) != "invalid grant"){

$oAuth = new Google\Service\Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

////////insert data
$Controller = new Controller;
echo $Controller ->insertData(array(
'email' => $userData['email'],
'familyName' => $userData['familyName'],
'givenName' => $userData['givenName']
));
$_SESSION['email'] = $data["email"];
$_SESSION['id'] = $data["id"];

}else{
    header('Location:home.php');
    exit();
}
?> 