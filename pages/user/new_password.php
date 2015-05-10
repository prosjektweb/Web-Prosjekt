<?php

global $smarty;

$smarty->assign("page", "user/verify_user.tpl");

$error = array();
$status = "";



$activationKey = getArg(1);

$serverActivationKey = User::getActivationKeyByUsername($username);

$params = array(
    "username" => getArg(0),
    "email" => getArg(1),
    "emailRetype" => $_POST["emailRetype"],
    "passwordInput" => $_POST["passwordInput"],
    "passwordRetype" => $_POST["passwordRetype"]
);

if($activationKey == $serverActivationKey){

    User::activate_account($username);

    $status = "activated";

}else{
    $error = "Could not activate account. Activation code invalid.";
    $status = "error";
}




$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);