<?php
// Include main
require ('../ajax.php');
//check if we are allowed here!
if(!isLoggedIn() || !isAdmin()) {
	$smarty->display("/comment/login.tpl");
	return;
}

//DO DELETE STUFF HERE
//NOW