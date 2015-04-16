<?php

global $smarty;
//Assign page to smarty
$smarty->assign("page", "user/login.tpl");

//Check if any form values are assigned
$params = array(
    "username" => postFilter("username"),
    "password" => postFilter("password")
);

$error = array();
$status = "";

if (hasPost("username") || hasPost("password")) {
    //Perform error check
    $params['username'] = trim($params['username']);
    $params['password'] = trim($params['password']);

    if ($params['username'] == "") {
        $error[] = "Username can't be empty.";
    }
    if ($params['password'] == "") {
        $error[] = "Username can't be blank.";
    }

    if (sizeof($error) > 0) {
        $status = "error";
    } else {
        //Attempt login
        if (($user = User::login($params['username'], $params['password']))) {
            setSession("userId", $user->getId());
            setSession("user", $user);
            $status = "success";
        } else {
            $error[] = "Invalid Username/Password.";
            $status = "error";
        }
    }
}

$smarty->assign("loginStatus", $status);
$smarty->assign("errors", $error);