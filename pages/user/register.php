<?php

if (isLoggedIn()) {
    headerRedirect($ROOT_DIR . "/index.php");
    return;
}

global $smarty;

$smarty->assign("page", "user/register.tpl");



$params = array(
    "usernameInput" => $_POST["usernameInput"],
    "emailInput" => $_POST["emailInput"],
    "emailRetype" => $_POST["emailRetype"],
    "passwordInput" => $_POST["passwordInput"],
    "passwordRetype" => $_POST["passwordRetype"]
);


$error = array();
$status = "";

if(isset($params['usernameInput']) || isset($params['emailInput']) || isset($params['emailRetype']) ||
    isset($params['passwordInput']) || isset($params['passwordRetype']))
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
    if ($params['passwordInput'] == "") {
        $error[] = "Please type in password.";
    }
    if ($params['passwordRetype'] == "") {
        $error[] = "Please re-type password.";
    }
    if ($params['emailInput'] != $params['emailRetype']) {
        $error[] = "Email addresses do not match.";
    }
    if ($params['passwordInput'] != $params['passwordRetype']){
        $errors[] = "Passwords do not match.";
    }
    $status = "error";

    if (sizeof($error) > 0){
        $status = "error";
    }else{
        $user = User::registerUser($params['usernameInput'], $params['emailInput'], $params['passwordInput']);
        $status = "success";
    }

}

$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);
?>