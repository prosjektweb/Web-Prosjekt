<?php
global $smarty;

setPage ( "admin/users.tpl" );

$smarty->assign ( "sidebar2", "active" );
$smarty->assign ( "form_ok", "false" );

if (hasArg ( 0 ) && getArg ( 0 ) == "edit") {
	
	setPage ( "admin/users/edit.tpl" );
	
	$error = array ();
	
	if (hasArg ( 1 )) {
		$user_id = getArg ( 1 );
		if (is_numeric ( $user_id )) {
			
			$user = User::load ( $user_id );
			
			if (hasPost ( "user_forgotkey" )) {
				$user->forgotkey = getPost ( "user_forgotkey" );
			}
			if (hasPost ( "user_actionvationkey" )) {
				$user->activationkey = getPost ( "user_activationkey" );
			}
			if (hasPost ( "user_username" )) {
				$user->username = getPost ( "user_username" );
			}
			if (hasPost ( "user_email" )) {
				$user->email = getPost ( "user_email" );
				if (! validate_email ( $user->email )) {
					$error [] = "Invalid E-Mail";
				}
			}
			if (sizeof ( $error ) == 0) {
				if (hasArg ( 2 ) && getArg ( 2 ) == "submit") {
					$user->update ();
					$smarty->assign ( "form_ok", "true" );
				}
			}
			
			$smarty->assign ( "edituser", array (
					"id" => $user->id,
					"username" => $user->username,
					"email" => $user->email,
					"group_id" => $user->group_id,
					"forgotkey" => $user->forgotkey,
					"activationkey" => $user->activationkey 
			) );
		} else {
			// Print error
			$error [] = "Invalid User Id";
		}
	} else {
		$error [] = "No User Id specified";
	}
	$smarty->assign ( "form_error", $error );
} else {
	// Load all users
	$users = User::loadUsers ();
	
	// Assign all users to smarty
	$smartyUsers = array ();
	foreach ( $users as $user ) {
		$smartyUsers [] = array (
				"id" => $user->id,
				"username" => $user->username,
				"email" => $user->email,
				"group_id" => $user->group_id,
				"forgotkey" => $user->forgotkey,
				"activationkey" => $user->activationkey 
		);
	}
	$smarty->assign ( "users", $smartyUsers );
}