<?php
global $username_cache;
$username_cache = array ();

/**
 * Utility function for setting smarty user values
 *
 * @global type $smarty
 */
function smarty_set_user_session() {
	global $smarty;
	// Assign user values last so that any session edits will be noticed
	$smarty->assign ( "user", array (
			"isAdmin" => isAdmin () ? "true" : "false",
			"isSignedIn" => isLoggedIn () ? "true" : "false",
			"username" => isLoggedIn () ? session ( "username" ) : "" 
	) );
}

/**
 *
 * @author 501669
 *        
 */
class User {
	
	/**
	 * The id of the user
	 *
	 * @var number
	 */
	var $id;
	
	/**
	 * The email of the user
	 *
	 * @var string
	 */
	var $email;
	
	/**
	 * The username of the user
	 *
	 * @var string
	 */
	var $username;
	
	/**
	 * The hashed password of the user
	 *
	 * @var string
	 */
	var $password;
	
	/**
	 * The group id of the user
	 *
	 * @var number
	 */
	var $group_id;
	
	/**
	 * The activation key of the user
	 *
	 * @var string
	 */
	var $activationkey;
	
	/**
	 * The forgot key of the user
	 *
	 * @var string
	 */
	var $forgotkey;
	
	/**
	 * The salt of the user
	 *
	 * @var string
	 */
	var $salt;
	
	/**
	 * Empty ctor
	 */
	function __construct() {
	}
	
	/**
	 * Get the id of this user
	 *
	 * @return number
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * Get the username of this user
	 *
	 * @return string
	 */
	function getUsername() {
		return $this->username;
	}
	
	/**
	 * Get the group id of this users
	 *
	 * @return number
	 */
	function getGroupId() {
		return $this->group_id;
	}
	
	/**
	 * Performs a SQL update on this User
	 */
	function update() {
		try {
			$stmt = getDB ()->prepare ( "UPDATE users SET username=:username, email=:email, password=:password, group_id=:group_id, activationkey=:activationkey, forgotkey=:forgotkey, salt=:salt WHERE id=:id" );
			$stmt->execute ( array (
					"username" => $this->username,
					"password" => $this->password,
					"group_id" => $this->group_id,
					"activationkey" => $this->activationkey,
					"forgotkey" => $this->forgotkey,
					"email" => $this->email,
					"salt" => $this->salt,
					"id" => $this->id 
			) );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
	
	/**
	 * Deletes the user with the given id
	 *
	 * @param unknown $id        	
	 * @return boolean
	 */
	static function delete($id) {
		try {
			$stmt = getDB ()->prepare ( "DELETE FROM users WHERE id = :id" );
			$stmt->execute ( array (
					"id" => $id 
			) );
			return true;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return false;
	}
	
	/**
	 * Get the number of users in the datbase
	 *
	 * @return multitype:mixed
	 */
	static function getUserCount() {
		try {
			$stmt = getDB ()->query ( "SELECT COUNT(*) FROM users" );
			return $stmt->fetch ()["COUNT(*)"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return 0;
	}
	
	/**
	 * Get the username of the user with the given $id
	 *
	 * @param unknown $id        	
	 * @return unknown|NULL
	 */
	static function getUsernameById($id) {
		if (! is_numeric ( $id )) {
			setSession ( "error", "Argument must be numeric" );
		}
		global $username_cache;
		if (array_key_exists ( $id, $username_cache )) {
			return $username_cache [$id];
		}
		try {
			$stmt = getDB ()->prepare ( "SELECT username FROM users WHERE id = ?" );
			$stmt->bindParam ( 1, $id );
			$stmt->execute ();
			$fetch = $stmt->fetch ();
			return $fetch ["username"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 *
	 * @param type $id        	
	 * @return null
	 */
	static function login($username, $password) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM users WHERE username= ?" );
			$stmt->bindParam ( 1, $username );
			$stmt->execute ();
			$user = $stmt->fetchObject ( "User" );
			
			if ($user) {
				if ($user->password == sha1 ( $password . $user->salt )) {
					return $user;
				} else {
					return null;
				}
			} else {
				return null;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 *
	 * @param type $id        	
	 * @return null
	 */
	static function load($id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM users WHERE id= ?" );
			$stmt->bindParam ( 1, $id );
			$stmt->execute ();
			if ($user = $stmt->fetchObject ( 'User' )) {
				return $user;
			} else {
				return null;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 * Load all users matching the given where conditions
	 * or all users if no where condition was specified
	 *
	 * @param string $where        	
	 * @return multitype:mixed |multitype:
	 */
	static function loadUsers($where = null) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM users " . ($where != null ? $where : "") );
			$stmt->bindParam ( 1, $where );
			$stmt->execute ();
			$users = array ();
			while ( ($user = $stmt->fetchObject ( "User" )) ) {
				$users [] = $user;
			}
			return $users;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return array ();
	}
	
	/**
	 *
	 * @param
	 *        	$username
	 * @param
	 *        	$email
	 * @param
	 *        	$password
	 * @return null Function to register user.
	 */
	static function registerUser($username, $email, $password) {
		try {
			// Make activation key with rand_salt function
			$activationKey = User::rand_salt ( 20 );
			// Create a link for the user to press.
			$link = makeLink ( "user", "verify_user", array (
					$username,
					$activationKey 
			) );
			// Create salt for password protection
			$salt = User::rand_salt ( 16 );
			// Set default group_id. User
			$group_id = "2";
			// Encrypt password with sha1.
			$password = sha1 ( $password . $salt );
			$stmt = getDB ()->prepare ( "INSERT INTO users (username, email, password, group_id, activationKey, salt) VALUES(:username, :email, :password, :group_id, :activationKey, :salt)" );
			$stmt->execute ( array (
					"username" => $username,
					"email" => $email,
					"password" => $password,
					"group_id" => $group_id,
					"activationKey" => $activationKey,
					"salt" => $salt 
			) );
			
			// Send activation email
			User::user_activation ( $email, $username, $link );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 * Source: http://stackoverflow.com/questions/2235434/how-to-generate-a-random-long-salt-for-use-in-hashing
	 *
	 * @param
	 *        	$length
	 * @return null|string Generate random salt value for password protection / activation key / forgotten password key
	 */
	static function rand_salt($length) {
		$salt = null;
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen ( $chars );
		for($i = 0; $i < $length; $i ++) {
			$salt .= $chars [rand ( 0, $size - 1 )];
		}
		return $salt;
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @param $username Use
	 *        	Send mail for user to activate their account.
	 */
	static function user_activation($email, $username, $link) {
		$to = $email;
		$subject = 'Verification of user';
		$message = '
        Thank you for signing up, ' . $username . '!
        Your account has been created.

        To log in you need to activate your account by clicking the following link:
        ' . $link . '


        ';
		mail ( $to, $subject, $message );
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @param
	 *        	$username
	 * @param $link Send
	 *        	mail for user to change their password.
	 */
	static function forgotkey_mail($email, $username, $link) {
		$to = $email;
		$subject = 'Change password.';
		$message = '
        You have asked to be able create a new password! ' . $username . '
        If you did not request this, you may disregard this email.

        You may create a new password by clicking the following link:
        ' . $link . '


        ';
		mail ( $to, $subject, $message );
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @param $username Send
	 *        	confirmation mail for changed password.
	 */
	static function confirm_password_change($email, $username) {
		$to = $email;
		$subject = 'Password changed.';
		$message = '

        Hey, ' . $username . '!
        Your password has been updated.

        You may now proceed to log in.



        ';
		mail ( $to, $subject, $message );
	}
	
	/**
	 *
	 * @param
	 *        	$username
	 * @return null Get activation key from username
	 */
	static function getActivationKeyByUsername($username) {
		try {
			$stmt = getDB ()->prepare ( "SELECT activationKey FROM users WHERE username = ?" );
			$stmt->bindParam ( 1, $username );
			$stmt->execute ();
			$fetch = $stmt->fetch ();
			return $fetch ["activationKey"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 *
	 * @param $username Activate
	 *        	users account
	 *        	Set activationKey field in table to null.
	 */
	static function activate_account($username) {
		try {
			
			$stmt = getDB ()->prepare ( "UPDATE users SET activationKey = NULL WHERE username = ?" );
			$stmt->bindParam ( 1, $username );
			$stmt->execute ();
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @return mixed|null Return number of users in the database with this email address.
	 *         Email in use error check.
	 */
	static function emailExist($email) {
		try {
			
			$stmt = getDB ()->prepare ( "SELECT email FROM users WHERE email = ?" );
			$stmt->bindParam ( 1, $email );
			$stmt->execute ();
			
			if ($stmt->rowCount () > 0) {
				return true;
			} else {
				return false;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
	
	/**
	 *
	 * @param
	 *        	$username
	 * @return mixed|null Return number of users in the database with this username.
	 *         Username in use error check.
	 */
	static function userExist($username) {
		try {
			
			$stmt = getDB ()->prepare ( "SELECT username FROM users WHERE username = ?" );
			$stmt->bindParam ( 1, $username );
			$stmt->execute ();
			
			if ($stmt->rowCount () > 0) {
				
				return true;
			} else {
				
				return false;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @return null Get forgotkey from database by email
	 */
	static function getForgotkeyByEmail($email) {
		try {
			$stmt = getDB ()->prepare ( "SELECT forgotkey FROM users WHERE email = ?" );
			$stmt->bindParam ( 1, $email );
			$stmt->execute ();
			$fetch = $stmt->fetch ();
			return $fetch ["forgotkey"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 *
	 * @param
	 *        	$email
	 * @return null Get username from database by using email address.
	 */
	static function getUsernameByEmail($email) {
		try {
			$stmt = getDB ()->prepare ( "SELECT username FROM users WHERE email = ?" );
			$stmt->bindParam ( 1, $email );
			$stmt->execute ();
			$fetch = $stmt->fetch ();
			return $fetch ["username"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 *
	 * @param string $username        	
	 *
	 * @param string $forgotkey
	 *        	Update forgotkey on user.
	 */
	static function update_forgotkey($username, $forgotkey) {
		try {
			
			$stmt = getDB ()->prepare ( "UPDATE users SET forgotkey = :forgotkey WHERE username = :username" );
			$stmt->execute ( array (
					"forgotkey" => $forgotkey,
					"username" => $username 
			) );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
	
	/**
	 *
	 * @param string $username        	
	 * @param string $password
	 *        	Update password for user.
	 */
	static function update_password($username, $password) {
		try {
			
			// Create salt for password protection
			$salt = User::rand_salt ( 16 );
			
			// Encrypt password with sha1.
			$password = sha1 ( $password . $salt );
			$stmt = getDB ()->prepare ( "UPDATE users SET password = :password, salt = :salt WHERE username = :username" );
			$stmt->execute ( array (
					"password" => $password,
					"salt" => $salt,
					"username" => $username 
			) );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
}

;
