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
	 * @return null
     *
     * Function to register user.
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
	 *
	 * @param
	 *        	$length
	 * @return null|string
     * Generate random salt value for password protection / activation key / forgotten password key
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
	 *        	php mail() function.
	 */
	static function user_activation($email, $username, $link) {
		$to = $email;
		$subject = 'Verification of user';
		$message = '
        Thank you for signing up! ' . $username . '
        Your account has been created.

        To log in you need to activate your account by clicking the following link:
        http://kark.hin.no/~501669/prosjekt/web/' . $link . '


        ';
		mail ( $to, $subject, $message );
	}

    /**
     * @param $username
     * @return null
     * Get activation key from username
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
     * @param $username
     * Activate users account
     * Set activationKey field in table to null.
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
}

;
