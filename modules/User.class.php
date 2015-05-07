<?php

class User {

    var $id;
    var $email;
    var $username;
    var $password;
    var $group;
    var $activationkey;
    var $forgotkey;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getGroupId() {
        return $this->group;
    }

    static function getUsernameById($id) {
        try {
            $stmt = getDB()->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $fetch = $stmt->fetch();
            return $fetch["username"];
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return null; //Return null in case of exception. Good night website
    }

    static function getIdFromUsername($id) {
        
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    static function login($username, $password) {
        try {
            $stmt = getDB()->prepare("SELECT * FROM users WHERE username= ?");
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $user = $stmt->fetchObject("User");

            if ($user) {
                if ($user->password == sha1($password . $user->salt)) {
                    return $user;
                } else {
                    return null;
                }
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
     * @param type $id
     * @return null
     */
    static function load($id) {
        try {
            $stmt = getDB()->prepare("SELECT * FROM users WHERE id= ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            if ($user = $stmt->fetchObject('User')) {
                return $user;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return null; //Return null in case of exception. Good night website
    }

    static function registerUser($username, $email, $password) {
        try {
            $salt = User::rand_salt(16);
            $group_id = "1";
            $password = sha1($password . $salt);
            $stmt = getDB()->prepare("INSERT INTO users (username, email, password, group_id, salt) VALUES(:username, :email, :password, :group_id, :salt)");
            $stmt->execute(array(
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "group_id" => $group_id,
                "salt" => $salt
            ));


        } catch (Exception $ex) {
            setSession("error", $ex->getMessage());
        }
        return null; //Return null in case of exception. Good night website

    }
    /*
     * Make random salt value
     */
    static function rand_salt($length){
        $salt = null;
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++){
            $salt .= $chars[rand(0, $size - 1)];
        }
        return $salt;
    }

    static function user_activation(){

    }
}

;
