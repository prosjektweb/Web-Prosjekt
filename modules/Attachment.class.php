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
	var $data;
	
	/**
	 */
	function __construct() {
	}
	
	/**
	 *
	 * @param unknown $name        	
	 * @param unknown $data        	
	 * @return unknown|NULL
	 */
	static function newAttachment($name, $data) {
		$attachment = new Attachment ();
		$attachment->name = $name;
		$attachment->data = $data;
		
		// Do them inserts
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO images (name, data) VALUES(:name, :data)" );
			$stmt->execute ( array (
					"name" => $name,
					"data" => $data 
			) );
			$attachment->id = getDB ()->lastInsertId ();
			return $attachment;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
}
