<?php
class Attachment {
	
	/**
	 *
	 * @var unknown
	 */
	var $id;
	
	/**
	 *
	 * @var unknown
	 */
	var $name;
	
	/**
	 * 
	 * @var unknown
	 */
	var $type;
	
	/**
	 *
	 * @var unknown
	 */
	var $data;
	
	/**
	 */
	function __construct() {
	}
	
	/**
	 *
	 * @param unknown $id        	
	 * @return NULL|mixed
	 */
	static function load($id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM attachments WHERE id= :id" );
			if (! $stmt->execute ( array (
					"id" => $id 
			) )) {
				return null;
			}
			$attachment = $stmt->fetchObject ( "Attachment" );
			
			if ($attachment) {
				return $attachment;
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
	 * @param unknown $name        	
	 * @param unknown $data        	
	 * @return unknown|NULL
	 */
	static function newAttachment($name, $type, $data) {
		$attachment = new Attachment ();
		$attachment->name = $name;
		$attachment->data = $data;
		
		// Do them inserts
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO attachments (name, type, data) VALUES(:name, :type, :data)" );
			$stmt->execute ( array (
					"name" => $name,
					"data" => $data,
					"type" => $type
			) );
			$attachment->id = getDB ()->lastInsertId ();
			return $attachment;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
}
