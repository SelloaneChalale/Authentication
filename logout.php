<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
session_destroy();


setcookie('id', '', 'time'() - 60*60*24*30, '/');
setcookie('sess', '', 'time'() - 60*60*24*30, '/');
header('Location: index.php');
exit();