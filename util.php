<?php


/**
 * 
 * @param type $index
 * @return type
 */
function getArg($index)
{
    return session("arg" . $index);
}

/**
 * 
 * @param type $url
 */
function headerRedirect($url) {
    header("Location: $url");
    die();
}

/**
 * Check if we are logged in
 * @return boolean
 */
function isLoggedIn() {
    if (hasSession("userId")) {
        return true;
    } else {
        return false;
    }
}

/**
 * Whether we are an admin or not
 * @return type
 */
function isAdmin() {
    return isLoggedIn();
}

/**
 * Get a localized string
 * @param type $name
 * @return type
 */
function getString($name) {
    //Check strings
    include("./assets/no.loc");
    //Do null check
    return $strings[$name];
}

/**
 * Get a link to a path, this can be handy if we want to implement mod_rewrite or something
 * @param type $path
 */
function getLink($path) {

    $splits = split("/", $path);

    $cat = $splits[0];
    $page = $splits[1];

    return "?category=$cat&page=$page";
}

/**
 * Unset a session var
 * @param type $sessName
 */
function unsetSession($sessName) {
    unset($_SESSION[$sessName]);
}

/**
 * Set a session var 
 * @param type $sessName
 * @param type $sessValue
 */
function setSession($sessName, $sessValue) {
    $_SESSION[$sessName] = $sessValue;
}

/**
 * Get a session var
 * @param type $sessName
 * @return string
 */
function session($sessName) {
    if (hasSession($sessName)) {
        return $_SESSION[$sessName];
    } else {
        return "";
    }
}

/**
 * Check if the given array index exists
 * @param type $sessName
 * @return type
 */
function hasSession($sessName) {
    return array_key_exists($sessName, $_SESSION);
}

/**
 * 
 * @param type $var
 */
function hasGet($var) {
    if (array_key_exists($var, $_GET)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 * @param type $var
 */
function hasPost($var) {
    if (array_key_exists($var, $_POST)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Simple html special chars filter for the $_GET input
 * @param type $var
 * @return type
 */
function getFilter($var) {
    if (hasGet($var)) {
        return htmlspecialchars($_GET[$var]);
    } else {
        return "";
    }
}

/**
 * 
 * @param type $var
 * @return string
 */
function postFilter($var) {
    if (hasPost($var)) {
        return htmlspecialchars($_POST[$var]);
    } else {
        return "";
    }
}
