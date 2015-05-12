<?php

/**
 * Handles logging
 * @author Steffen Evensen, Bjarte Gjerstad, Andreas Mosvoll
 */
class Log {
	
	/**
	 * The id of the log entry
	 *
	 * @var int
	 */
	var $id;
	
	/**
	 * The action that was performed INSERT, UPDATE, DELETE
	 *
	 * @var string
	 */
	var $action;
	
	/**
	 * What was affected ( users, posts, comments )
	 *
	 * @var string
	 */
	var $message;
	
	/**
	 * The id of the user that made this action happen
	 *
	 * @var int
	 */
	var $user;
	
	/**
	 * Log's something to the database
	 *
	 * @param string $action        	
	 * @param string $message        	
	 * @param int $user        	
	 */
	static function log($action, $message, $user) {
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO log (action, message, user) VALUES(?, ?, ?)" );
			bindParams ( $stmt, array (
					$action,
					$message,
					$user 
			) );
			$stmt->execute ();
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
	
	/**
	 * Load all log entries using the given where parameter, or if not set load all
	 *
	 * @param string $where        	
	 */
	static function loadEntries($where = "") {
		try {
			$stmt = getDB ()->query ( "SELECT * FROM log " . $where );
			$entries = array ();
			while ( ($entry = $stmt->fetchObject ( "Log" )) ) {
				$entries [] = $entry;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
}