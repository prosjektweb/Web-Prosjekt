<?php
global $smarty;

$smarty->assign ( "page", "user/new_password.tpl" );

$error = array ();
$status = "";

$forgotkey = getArg ( 1 );

$params = array (
		"username" => getArg ( 0 ),
		"email" => getArg ( 1 ),
		"forgotkey" => getArg ( 2 ),
		"passwordInput" => postFilter ( "passwordInput" ),
		"passwordRetype" => postFilter ( "passwordRetype" ) 
);

$serverForgotkey = User::getForgotkeyByEmail ( $params ['email'] );

if ($params ['forgotkey'] == $serverForgotkey) {
	dbg("1");
	if (hasPost ( "passwordInput" ) || hasPost ( "passwordRetype" )) {
		dbg("2");
		$params ['passwordInput'] = trim ( $params ['passwordInput'] );
		$params ['passwordRetype'] = trim ( $params ['passwordRetype'] );
		if ($params ['passwordInput'] == "") {
			$error [] = "Please type in password.";
		}
		if ($params ['passwordRetype'] == "") {
			$error [] = "Please re-type password.";
		}
		if ($params ['passwordInput'] != $params ['passwordRetype']) {
			$error [] = "Passwords do not match.";
		}
		if (strlen ( $params ['passwordInput'] ) < 8) {
			$error [] = "Password too short.";
		}
		
		$status = "error";
		
		// if there are errors, set status to error.
		if (sizeof ( $error ) > 0) {
			$status = "error";
			dbg("4");
		} else {
			dbg("5");
			try {
				// If no errors, change password and set status to success.
				// Update password
				User::update_password ( $params ['username'], $params ['passwordInput'] );
				// Update forgotkey to null
				User::update_forgotkey ( $params ['username'], null );
				// Send confirmation mail.
				User::confirm_password_change ( $params ['email'], $params ['username'] );
			} catch ( Exception $ex ) {
				setSession ( "error", $ex->getMessage () );
			}
			
			$status = "success";
		}
	} else {
		dbg("3");
	}
} else {
	$error[] = "Link is used or invalid.";
	$status = "invalid";
}

$smarty->assign ( "status", $status );
$smarty->assign ( "errors", $error );