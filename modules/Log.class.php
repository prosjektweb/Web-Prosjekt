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
	 * The date of which the entry was posted
	 * @var timestamp
	 */
	var $date;
	
	/**
	 * Get the number of log entries in the datbase
	 *
	 * @return multitype:mixed
	 */
	static function getLogCount() {
		try {
			$stmt = getDB ()->query ( "SELECT COUNT(*) FROM log" );
			return $stmt->fetch ()["COUNT(*)"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return 0;
	}
	
	/**
	 * Log's something to the database
	 *
	 * @param string $action        	
	 * @param string $message        	
	 * @param int $user        	
	 */
	static function post($action, $message, $user) {
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO log (action, message, user, date) VALUES(?, ?, ?, NOW())" );
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
			return $entries;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return array ();
	}
}