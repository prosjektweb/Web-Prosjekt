<?php
class Post {
	
	/**
	 * The id of this post
	 *
	 * @var number
	 */
	var $id;
	
	/**
	 * The title of this post
	 *
	 * @var string
	 */
	var $title;
	
	/**
	 * The contents of this post
	 *
	 * @var string
	 */
	var $content;
	
	/**
	 * The date this post was created
	 *
	 * @var string timestamp
	 */
	var $post_date;
	
	/**
	 * The last date this post was modified
	 *
	 * @var string timestamp
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
	 * @var number
	 */
	var $comment_count = null;
	
	/**
	 * Empty ctor
	 */
	function __construct() {
	}
	
	/**
	 * Get the amount of comments for this Post
	 *
	 * @return unknown
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
	 *
	 * @return array
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
	 * Set the values of this Post class
	 *
	 * @param string $title
	 *        	The title of the Post
	 * @param string $content
	 *        	The contents of the Post
	 * @param number $poster
	 *        	The id of the user that posted the Post
	 */
	function setValues($title, $content, $poster) {
		$this->id = 0;
		$this->title = $title;
		$this->content = $content;
		$this->poster = $poster;
	}
	
	/**
	 * Get the post with the given id or null if none was found
	 *
	 * @param
	 *        	$which
	 * @return Post
	 */
	static function get($id) {
		try {
			$stmt = getDB ()->prepare ( "SELECT * FROM posts WHERE id= ?" );
			$stmt->bindParam ( 1, $id );
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
	 * @return number
	 */
	static function getPostCount() {
		$stmt = getDB ()->query ( "SELECT COUNT(*) FROM posts" );
		return $stmt->fetch ()["COUNT(*)"];
	}
	
	/**
	 * Get all the posts that satisfies the given parameter, or all posts if none was specified
	 *
	 * @param string $where        	
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
	 * Inserts a new Post into the database
	 *
	 * @return number The id of the post that was inserted
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
			Log::post ( "INSERT", "POST(<a href='" . makeLink ( "blog", "view", array (
					"$this->id" 
			) ) . "'>" . $this->title . "</a>) was created.", session ( "userId" ) );
			return $this->id;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return - 1;
	}
	
	/**
	 * Deletes the post with the given id
	 *
	 * @param number $id        	
	 * @return boolean
	 */
	static function delete($id) {
		try {
			$stmt = getDB ()->prepare ( "DELETE FROM posts WHERE id = :id" );
			$stmt->execute ( array (
					"id" => $id 
			) );
			Log::post ( "DELETE", "POST(" . $id . ") was deleted.", session ( "userId" ) );
			
			$stmt = getDB ()->prepare ( "DELETE FROM Pages WHERE page='blog' AND file='view' AND arg_0 = :id" );
			$stmt->execute ( array (
					"id" => $id 
			) );
			
			return true;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return false;
	}
	
	/**
	 * Updates the post with the given id
	 *
	 * @param number $id        	
	 * @param string $title        	
	 * @param string $content        	
	 * @return number
	 */
	static function edit($id, $title, $content) {
		try {
			$stmt = getDB ()->prepare ( "UPDATE posts SET title='$title', content='$content', edit_date=Now() WHERE ID=$id" );
			$stmt->execute ();
			Log::post ( "UPDATE", "POST(<a href='" . makeLink ( "blog", "view", array (
					"$id" 
			) ) . "'>" . $title . "</a>) was updated.", session ( "userId" ) );
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return - 1;
	}
	
	/**
	 * Get the id of the post
	 *
	 * @return number
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * Get the title of the post
	 *
	 * @return string
	 */
	function getTitle() {
		return $this->title;
	}
	
	/**
	 * Get the content of the post
	 *
	 * @return string
	 */
	function getContent() {
		return $this->content;
	}
	
	/**
	 * Get the post date of the post
	 *
	 * @return string a string in sql timestamp format
	 */
	function getPostDate() {
		return $this->post_date;
	}
	
	/**
	 * Get the edit date of the post
	 *
	 * @return string a string in sql timestamp format
	 */
	function getEditDate() {
		return $this->edit_date;
	}
	
	/**
	 * Get the id of the user that posted this post
	 *
	 * @return number
	 */
	function getPoster() {
		return $this->poster;
	}
}
