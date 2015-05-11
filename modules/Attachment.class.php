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
	function newAttachment($name, $data) {
		$image = new Image ();
		$image->name = $name;
		$image->data = $data;
		
		// Do them inserts
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO images (name, data) VALUES(:name, :data)" );
			$stmt->execute ( array (
					"name" => $name,
					"data" => $data 
			) );
			$comment->id = getDB ()->lastInsertId ();
			return $comment;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
}
