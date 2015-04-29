<?php

if (isLoggedIn()) {
    headerRedirect($ROOT_DIR . "/index.php");
    return;
}

global $smarty;

$smarty->assign("page", "user/register.tpl");




$params = array(
    "usernameInput" => postFilter("usernameInput"),
    "emailInput" => postFilter("emailInput"),
    "emailRetype" => postFilter("emailRetype"),
    "password" => postFilter("password"),
    "passwordRetype" => postFilter("passwordRetype")
);


$error = array();
$status = "";

if(hasPost("usernameInput") || hasPost("emailInput") || hasPost("emailRetype") ||
    hasPost("password") || hasPost("passwordRetype"))
{

    if ($params['usernameInput'] == "") {
        $error[] = "Username can't be empty.";
    }
    if ($params['emailInput'] == "") {
        $error[] = "Please type in email address.";
    }
    if ($params['emailRetype'] == "") {
        $error[] = "Please re-type email address.";
    }
    if ($params['password'] == "") {
        $error[] = "Please type in password.";
    }
    if ($params['passwordRetype'] == "") {
        $error[] = "Please re-type password.";
    }
    if ($params['emailInput'] != $params['emailRetype']) {
        $error[] = "Email addresses do not match.";
    }
    if ($params['password'] != $params['passwordRetype']){
        $errors[] = "Passwords do not match.";
    }
    $status = "error";

    if (sizeof($error) > 0){
        $status = "error";
    }else{

    }

}

$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);

?>