<?php

class Post {

    /**
     * The id of this post
     * @var type 
     */
    var $id;

    /**
     * The title of this post
     * @var type 
     */
    var $title;

    /**
     * The contents of this post
     * @var type 
     */
    var $content;

    /**
     * The date this post was created
     * @var type 
     */
    var $postDate;

    /**
     * The last date this post was modified
     * @var type 
     */
    var $editDate;

    /**
     * The user that posted this post
     * @var User
     */
    var $poster;

    /**
     * Constructor
     */
    function __construct() {
        
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
     * @param $which
     * @return array
     */
    static function get($which) {
        try {
            $stmt = getDB()->prepare("SELECT * FROM posts WHERE id= ?");
            $stmt->bindParam(1, $which);
            $stmt->execute();

            $post = $stmt->fetchObject("Post");
            if ($post) {
                return $post;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return null; //Return null in case of exception. Good night website
    }

    /**
     * 
     * @param type $where
     */
    static function getPosts($where = null) {
        $resultat = getDB()->query("SELECT * FROM posts " . ($where != null ? $where : ""));
        $posts = array();
        while ($post = $resultat->fetchObject('Post')) {
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * 
     * @return type
     */
    function insert() {
        try {
            $stmt = getDB()->prepare("INSERT INTO posts (id, title, content, postDate, editDate, poster) VALUES(:id, :title, :content, NOW(), NOW(), :poster)");
            $stmt->execute(array(
                "id" => $this->id,
                "title" => $this->title,
                "content" => $this->content,
                "poster" => $this->poster
            ));
            $this->id = getDB()->lastInsertId();
            return $this->id;
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return -1;
    }
    
    /**
     * 
     * @param type $id
     */
    static function delete($id)
    {
        try {
            $stmt = getDB()->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->execute(array(
                "id" => $id,
            ));
            return true;
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return false;
    }

    static function edit($id, $title, $content)
    {
        try {
            $stmt = getDB()->prepare("UPDATE posts SET title='$title', content='$content', editDate=Now() WHERE ID=$id");
            $stmt->execute();
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return -1;
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
        return $this->postDate;
    }

    /**
     * 
     * @return type
     */
    function getEditDate() {
        return $this->editDate;
    }

    /**
     * 
     * @return type
     */
    function getPoster() {
        return $this->poster;
    }

}
