<?php

session_start();
// Smarty module
require (dirname(__FILE__) . "/" . 'smarty/libs/Smarty.class.php');
// Utilities
require (dirname(__FILE__) . "/" . "../util.php");
// Blog module
require (dirname(__FILE__) . "/" . "Blog.php");
// Configuration
require (dirname(__FILE__) . "/" . '../config.php');
// Load SQL
require (dirname(__FILE__) . "/" . 'sql.php');

//Start up smarty
global $smarty;
$smarty = new Smarty ();

// Options
$smarty->debugging = true;
$smarty->caching = false;

// Set some path urls because of mod rewrite
$smarty->assign("root", $ROOT_DIR);

// Set some global vars
$smarty->assign("webpage", array(
    "title" => $_SETTINGS ['title']
));

smarty_set_user_session();