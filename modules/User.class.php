<?php
class User {
	var $id;
	var $email;
	var $username;
	var $password;
	var $group;
	var $group_id;
	var $activationkey;
	var $forgotkey;
	function __construct() {
	}
	function getId() {
		return $this->id;
	}
	function getUsername() {
		return $this->username;
	}
	function getGroupId() {
		return $this->group_id;
	}
	static function getUsernameById($id) {
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
	static function getIdFromUsername($id) {
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
			$activationKey = User::rand_salt ( 20 );
			$link = makeLink ( "user", "verify.php", array (
					$username,
					$activationKey 
			) );
			$salt = User::rand_salt ( 16 );
			$group_id = "2";
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
	 *
	 * @param
	 *        	$length
	 * @return null|string Make random salt value for password protection
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
	 *        	php mail() function. Guidelines found at www.w3schools.com
	 */
	static function user_activation($email, $username, $link) {
		$to = $email;
		$subject = 'Verification of user';
		$message = '
        Thank you for signing up! ' . $username . '
        Your account has been created.

        To log in you need to activate your account by clicking the following link:
        ' . $link . '


        ';
		mail ( $to, $subject, $message );
	}
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
	static function activate_account($username) {
		try {
			
			$stmt = getDB ()->prepare ( "UPDATE users SET activationKey = NULL WHERE username = ?" );
			$stmt->bindParam ( 1, $username );
			$stmt->execute ();
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
}

;
