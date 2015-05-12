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
			
			if (hasArg ( 2 ) && getArg ( 2 ) == "submit") {
				$user->forgotkey = postFilter ( "user_forgotkey" );
				$user->activationkey = postFilter ( "user_activationkey" );
				$user->username = postFilter ( "user_username" );
				$user->email = postFilter ( "user_email" );
				
				$newpass1 = postFilter ( "user_newpassword" );
				$newpass2 = postFilter ( "user_newpassword_retype" );
				
				if ($newpass1 != "") {
					if ($newpass1 != $newpass2) {
						$error [] = "Passwords does not match.";
					} else {
						if (strlen ( $newpass1 ) > 2) {
							// Create salt for password protection
							$salt = User::rand_salt ( 16 );
							// Encrypt password with sha1.
							$password = sha1 ( $newpass1 . $salt );
							$user->password = $password;
							$user->salt = $salt;
						} else {
							$error [] = "Password must have a length greater than 2 characters.";
						}
					}
				}
				
				if ($user->username == "") {
					$error [] = "Username can't be empty.";
				}
				
				if (! validate_email ( $user->email )) {
					$error [] = "Invalid E-Mail";
				}
				
				if (sizeof ( $error ) == 0) {
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
	
	if (getArg ( 0 ) == "delete") {
		$id = htmlspecialchars ( getArg ( 1 ) );
		if (is_numeric ( $id )) {
			// Attempt to delete
			User::delete ( $id );
		}
	}
	
	$logEntriesPerPage = 10;
	$offset = hasArg ( 0 ) && is_numeric ( getArg ( 0 ) ) ? (getArg ( 0 ) - 1) * $logEntriesPerPage : "0";
	
	// Load all users
	$users = User::loadUsers ( "LIMIT $logEntriesPerPage OFFSET $offset" );
	
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
	$smarty->assign ( "pagination", (User::getUserCount () / $logEntriesPerPage) );
	$smarty->assign ( "users", $smartyUsers );
}