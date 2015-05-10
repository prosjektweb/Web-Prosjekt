<?php

if (isLoggedIn()) {
    headerRedirect($ROOT_DIR . "/index.php");
    return;
}

global $smarty;
    // Assign page to smarty
$smarty->assign("page", "user/register.tpl");


// Check if any form values are assigned
$params = array(
    "usernameInput" => postFilter("usernameInput"),
    "emailInput" => postFilter("emailInput"),
    "emailRetype" => postFilter("emailRetype"),
    "passwordInput" => postFilter("passwordInput"),
    "passwordRetype" => postFilter("passwordRetype")
);

// for status message
$error = array();
$status = "";

// Check if any params is set.
if(hasPost ( "username" ) || hasPost ( "emailInput" ) || hasPost ( "emailRetype" ) ||
    hasPost ( "passwordInput" ) || hasPost ( "passwordRetype" ))
{
    // Perform error check
    $params ['usernameInput'] = trim ( $params ['usernameInput'] );
    $params ['emailInput'] = trim ( $params ['emailInput'] );
    $params ['emailRetype'] = trim ( $params ['emailRetype'] );
    $params ['passwordInput'] = trim ( $params ['passwordInput'] );
    $params ['passwordRetype'] = trim ( $params ['passwordRetype'] );



    // check input for errors
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
        $error[] = "Passwords do not match.";
    }
    if (strlen($params['passwordInput']) < 8){
        $error[] = "Password too short.";
    }
    if (User::emailExist($params['emailInput']) >= 1){
        $error[] = "Email address already in use.";
    }
    $status = "error";

    // if there are errors, set status to error.
    if (sizeof($error) > 0){
        $status = "error";
    }else{
        // If no errors, register user and set status to success.
        $user = User::registerUser($params['usernameInput'], $params['emailInput'], $params['passwordInput']);
        $status = "success";
    }

}

// Assign status to smarty. So that status message will be shown on site.
$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);
?>