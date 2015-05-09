<?php


global $smarty;
// Assign page to smarty
$smarty->assign("page", "user/verify_user.tpl");

// for status message
$error = array();
$status = "";

 // Set parameters from url.
$username = getArg(0);
$activationKey = getArg(1);

// Get activation key from database using username
$serverActivationKey = User::getActivationKeyByUsername($username);

// Check if activation key from link matches activation key from database
if($activationKey == $serverActivationKey){

    // Run activate accout function
    User::activate_account($username);
    // Set status.
    $status = "activated";

}else{
    // Error if activation keys does not match
    $error = "Could not activate account. Activation code invalid.";
    $status = "error";
}

// Assign status to smarty. So that status message will be shown on site.
$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);