<?php
session_start ();
// Smarty module
require (dirname ( __FILE__ ) . "/" . '../modules/smarty/libs/Smarty.class.php');
// Utilities
require (dirname ( __FILE__ ) . "/" . "../util.php");
// Blog module
require (dirname ( __FILE__ ) . "/" . "../modules/Blog.php");
// Configuration
require (dirname ( __FILE__ ) . "/" . '../config.php');
// Load SQL
require (dirname ( __FILE__ ) . "/" . '../modules/sql.php');

global $smarty;

$smarty = new Smarty ();

// Options
$smarty->debugging = false;
$smarty->caching = false;

// Set templates dir
// chaining of method calls
$smarty->setTemplateDir ( dirname ( __FILE__ ) . "/" )->setCompileDir ( dirname ( __FILE__ ) . "/" . "../templates_c/" );

// Set some path urls because of mod rewrite
$smarty->assign ( "root", $ROOT_DIR );

// Assign user values last so that any session edits will be noticed
$smarty->assign ( "user", array (
		"isAdmin" => "false"
));

?>