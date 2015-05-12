<?php

/**
 * SQL Credentials
 */
$SQL_SERVER = "127.0.0.1";
$SQL_USERNAME = "evensen";
$SQL_PASSWORD = "evensen";
$SQL_DATABASE = "stud_v15_evensen";

/**
 * Root URL to the website
 * Eg: http://localhost/web-prosjekt
 * It is not recommended to use a trailing slash / as this will cause 
 * the generated URL's to have two of them Eg: http://localhost/web-prosjekt//file.php
 */
$ROOT_DIR = "http://kark.hin.no/~501669/prosjekt/web";

/**
 * Some global settings for the system
 */
$_SETTINGS = array(
    "title" => "Prosjekt Webutvikling", //The title of the webpage, can be reached through smarty by $webpage.title
    "mod_rewrite" => false, //Whether or not the webpage is using mod_rewrite or not
    "MAX_POST_SIZE" => 5000, //The maximum number of characters a post can contain
    "MAX_TITLE_SIZE" => 50, //The maximum number of characters a post title can contain
    "MAX_FILE_SIZE" => 25600000, //The maximum number of bytes an attached image can contain, default: 25mb
);