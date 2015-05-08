<?php


global $smarty;

$smarty->assign("page", "user/verify_user.tpl");

$error = array();
$status = "";


$username = getArg(0);
$activationKey = getArg(1);

$serverActivationKey = User::getActivationKeyByUsername($username);

if($activationKey == $serverActivationKey){

    User::activate_account($username);

    $status = "activated";

}else{
    $error = "Could not activate account. Activation code invalid.";
    $status = "error";
}




$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);