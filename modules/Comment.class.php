<?php
class Comment {
	
	/**
	 * The id of the comment
	 *
	 * @var unknown
	 */
	var $id;
	
	/**
	 * The id of the post this comment is attached to
	 *
	 * @var unknown
	 */
	var $post_id;
	
	/**
	 * The content of the comment
	 *
	 * @var unknown
	 */
	var $content;
	
	/**
	 * The post date of the comment
	 *
	 * @var unknown
	 */
	var $post_date;
	
	/**
	 * The poster of the comment
	 *
	 * @var unknown
	 */
	var $poster;
	
	/**
	 * This is a foreign key thing and should not be loaded by PDO thing
	 * Yes yes
	 *
	 * @var unknown
	 */
	var $attachments;
	
	/**
	 */
	function __construct() {
	}
	
	/**
	 * Count the comments of a post
	 *
	 * @param unknown $post_id        	
	 * @return string|number
	 */
	static function countComments($post_id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT COUNT(*) FROM comments WHERE post_id= ?" );
			$stmt->bindParam ( 1, $post_id );
			$stmt->execute ();
			$count = $stmt->fetchColumn ( 0 );
			return $count; // Fetch first column
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return - 1;
	}
	
	/**
	 * Removes the comment with the specified id
	 *
	 * @param unknown $id        	
	 * @return boolean
	 */
	static function removeComment($id) {
		try {
			$stmt = getDB ()->prepare ( "DELETE FROM comments WHERE id= ?" );
			$stmt->bindParam ( 1, $id );
			$stmt->execute ();
			return true;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return false;
	}
	
	/**
	 * Creates a new comment using the specified values
	 *
	 * @param unknown $post_id        	
	 * @param unknown $content        	
	 * @param unknown $poster        	
	 * @return Comment|NULL
	 */
	static function newComment($post_id, $title, $content, $poster) {
		$comment = new Comment ();
		$comment->post_id = $post_id;
		$comment->title = $title;
		$comment->content = $content;
		$comment->poster = $poster;
		
		// Do them inserts
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO comments (post_id, content, post_date, poster) VALUES(:post_id, :content, NOW(), :poster)" );
			$stmt->execute ( array (
					"id" => $post_id,
					"content" => $content,
					"poster" => $poster 
			) );
			$this->id = getDB ()->lastInsertId ();
			return $comment;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null;
	}
	
	/**
	 * Load the comments from the specified post
	 *
	 * @param unknown $post_id        	
	 * @return multitype:unknown
	 */
	static function loadComments($post_id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM comments WHERE post_id= :post_id" );
			if (! $stmt->execute ( array (
					"post_id" => $post_id 
			) )) {
				return array ();
			}
			$posts = array ();
			while ( $post = $stmt->fetchObject ( 'Comment' ) ) {
				$posts [] = $post;
			}
			return $posts;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return array ();
	}
	
	/**
	 * Load the comment witht the specified id
	 *
	 * @param unknown $id        	
	 * @return mixed|NULL
	 */
	static function loadComment($id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM comments WHERE id= :id" );
			if (! $stmt->execute ( array (
					"id" => $id 
			) )) {
				echo "cmt err";
				return null;
			}
			$comment = $stmt->fetchObject ( "Comment" );
			
			echo $stmt->rowCount();
			if ($comment) {
				return $comment;
			} else {
				return null;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
}