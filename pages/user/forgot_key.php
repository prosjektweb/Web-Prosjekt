<?php
if (isLoggedIn ()) {
	headerRedirect ( $ROOT_DIR . "/index.php" );
	return;
}

global $smarty;
// Assign page to smarty
$smarty->assign ( "page", "user/forgot_key.tpl" );

// for status message
$error = array ();
$status = "";

// Check if any params is set.
if (hasPost ( "emailInput" )) {

    $email = postFilter ( "emailInput" );

    if (User::emailExist ( $email ) <= 1) {
		$error = "Email address does not exist";
	}
	
	// if there are errors, set status to error.
	if (sizeof ( $error ) > 0) {
		$status = "error";
	} else {
		// If no errors, send email with link for user to create new password
		
		// Create forgotten password key with rand_salt()
		$forgotkey = User::rand_salt ( 20 );
		// Get username from email
		$username = User::getUsernameByEmail ( $email );
		// Make link
		$link = makeLink ( "user", "new_password", array (
				$username,
				$email,
				$forgotkey 
		) );
		// Send mail
		User::forgotkey_mail ( $email, $username, $link );
		
		// Update forgotkey in database to match key sent to email.
		User::update_forgotkey ( $username, $forgotkey );
		
		$status = "success";
	}
}

// Assign status to smarty. So that status message will be shown on site.
$smarty->assign ( "status", $status );
$smarty->assign ( "errors", $error );
?>