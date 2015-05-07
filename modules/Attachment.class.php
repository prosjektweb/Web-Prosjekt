<?php
class Attachment {
	
	/**
	 * The id of this attachment
	 *
	 * @var unknown
	 */
	var $id;
	
	/**
	 * The id of the comment this attachment is attached to, no pun intended
	 *
	 * @var unknown
	 */
	var $comment_id;
	
	/**
	 * Empty ctor
	 */
	function __construct() {
	}
	
	/**
	 * Creates a new attachment
	 */
	function newAttachment() {
	}
	
	/**
	 * Deletes the attachment with the specified id
	 * 
	 * @param unknown $id        	
	 */
	function removeAttachment($id) {
	}
	
	/**
	 * Loads the attachment with the specified id
	 * 
	 * @param unknown $id        	
	 */
	function loadAttachment($id) {
	}
	
	/**
	 * Loasd the attachments from the specified comment
	 * 
	 * @param unknown $comment_id        	
	 */
	function loadAttachments($comment_id) {
	}
}