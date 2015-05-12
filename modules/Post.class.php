<?php
class Post {
	
	/**
	 * The id of this post
	 *
	 * @var type
	 */
	var $id;
	
	/**
	 * The title of this post
	 *
	 * @var type
	 */
	var $title;
	
	/**
	 * The contents of this post
	 *
	 * @var type
	 */
	var $content;
	
	/**
	 * The date this post was created
	 *
	 * @var type
	 */
	var $post_date;
	
	/**
	 * The last date this post was modified
	 *
	 * @var type
	 */
	var $edit_date;
	
	/**
	 * The user that posted this post
	 *
	 * @var User
	 */
	var $poster;
	
	/**
	 * The comment count of this post
	 *
	 * @var unknown
	 */
	var $comment_count = null;
	
	/**
	 * Constructor
	 */
	function __construct() {
	}
	
	/**
	 */
	function getCommentCount() {
		if ($this->comment_count == null) {
			// Fetch comment count
			$this->comment_count = Comment::countComments ( $this->id );
		}
		return $this->comment_count;
	}
	
	/**
	 * Creates an array with the information smarty want's from our post!
	 */
	function getSmartyArray() {
		return array (
				"id" => $this->id,
				"poster" => User::getUsernameById ( $this->poster ),
				"postdate" => $this->post_date,
				"title" => $this->title,
				"content" => $this->content,
				"numcomments" => $this->getCommentCount () 
		);
	}
	
	/**
	 *
	 * @param type $title        	
	 * @param type $content        	
	 * @param type $poster        	
	 */
	function setValues($title, $content, $poster) {
		$this->id = 0;
		$this->title = $title;
		$this->content = $content;
		$this->poster = $poster;
	}
	
	/**
	 *
	 * @param
	 *        	$which
	 * @return array
	 */
	static function get($which) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM posts WHERE id= ?" );
			$stmt->bindParam ( 1, $which );
			$stmt->execute ();
			
			$post = $stmt->fetchObject ( "Post" );
			if ($post) {
				return $post;
			} else {
				return null;
			}
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return null; // Return null in case of exception. Good night website
	}
	
	/**
	 * Get the number of posts in the datbase
	 *
	 * @return multitype:mixed
	 */
	static function getPostCount() {
		$stmt = getDB ()->query ( "SELECT COUNT(*) FROM posts" );
		return $stmt->fetch ()["COUNT(*)"];
	}
	
	/**
	 *
	 * @param type $where        	
	 */
	static function getPosts($where = null) {
		$resultat = getDB ()->query ( "SELECT * FROM posts ORDER BY post_date desc " . ($where != null ? $where : "") . ";" );
		$posts = array ();
		while ( $post = $resultat->fetchObject ( 'Post' ) ) {
			$posts [] = $post;
		}
		return $posts;
	}
	
	/**
	 *
	 * @return type
	 */
	function insert() {
		try {
			$stmt = getDB ()->prepare ( "INSERT INTO posts (id, title, content, post_date, edit_date, poster) VALUES(:id, :title, :content, NOW(), NOW(), :poster)" );
			$stmt->execute ( array (
					"id" => $this->id,
					"title" => $this->title,
					"content" => $this->content,
					"poster" => $this->poster 
			) );
			$this->id = getDB ()->lastInsertId ();
			Log::post ( "INSERT", "POST(<a href='" . makeLink("blog", "view", array("$this->id")) . "'>" . $this->title . "</a>) was created.", session("userId") );
			return $this->id;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return - 1;
	}
	
	/**
	 * Deletes the post with the given id
	 *
	 * @param unknown $id        	
	 * @return boolean
	 */
	static function delete($id) {
		try {
			$stmt = getDB ()->prepare ( "DELETE FROM posts WHERE id = :id" );
			$stmt->execute ( array (
					"id" => $id 
			) );
			Log::post ( "DELETE", "POST(" . $id . ") was deleted.", session ( "userId" ) );
			return true;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return false;
	}
	
	/**
	 * Updates the post with the given id
	 *
	 * @param unknown $id        	
	 * @param unknown $title        	
	 * @param unknown $content        	
	 * @return number
	 */
	static function edit($id, $title, $content) {
		try {
			$stmt = getDB ()->prepare ( "UPDATE posts SET title='$title', content='$content', edit_date=Now() WHERE ID=$id" );
			$stmt->execute ();
			Log::post ( "UPDATE", "POST(<a href='" . makeLink("blog", "view", array("$id")) . "'>" . $title . "</a>) was updated.", session("userId") );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return - 1;
	}
	
	/**
	 *
	 * @return type
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @return type
	 */
	function getTitle() {
		return $this->title;
	}
	
	/**
	 *
	 * @return type
	 */
	function getContent() {
		return $this->content;
	}
	
	/**
	 *
	 * @return type
	 */
	function getPostDate() {
		return $this->post_date;
	}
	
	/**
	 *
	 * @return type
	 */
	function getEditDate() {
		return $this->edit_date;
	}
	
	/**
	 *
	 * @return type
	 */
	function getPoster() {
		return $this->poster;
	}
}
