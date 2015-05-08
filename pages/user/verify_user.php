<?php


global $smarty;


$error = array();
$status = "";

if(getArg(0) == "" || getArg(1) == ""){
    headerRedirect($ROOT_DIR . "/index.php");
    return;
}else{

    $username = getArg(0);
    $activationKey = getArg(1);

    $serverActivationKey = User::getActivationKeyByUsername($username);

    if($activationKey == $activationKey){

        User::activate_account($username);

        $status = "activated";
    }else{
        $error = "Could not activate account. Activation code invalid.";
        $status = "error";
    }


}

$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);