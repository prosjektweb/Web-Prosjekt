<?php
// Include main
require ('../ajax.php');
//check if we are allowed here!
if(!isLoggedIn() || !isAdmin()) {
	$smarty->display("/comment/login.tpl");
	return;
}

//DO DELETE STUFF HERE
$comment_id = getFilter("comment_id");

if($comment_id != "" && is_numeric($comment_id)) {
	Comment::delete($comment_id);
	echo "true";
} else {
	echo "false";
}