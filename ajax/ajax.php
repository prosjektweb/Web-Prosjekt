<?php
header ( "Content-Type:application/json" );
session_start ();
// Utilities
require (dirname ( __FILE__ ) . "/" . "../util.php");
// Blog module
require (dirname ( __FILE__ ) . "/" . "../modules/Blog.php");
// Configuration
require (dirname ( __FILE__ ) . "/" . '../config.php');
// Load SQL
require (dirname ( __FILE__ ) . "/" . '../modules/sql.php');