<?php
// Include main
require ('../ajax.php');
//check if we are allowed here!
if(!isLoggedIn()) {
	$smarty->display("login.tpl");
	return;
}
//Parse args
$post_id = postFilter ( "post_id" );
$comment = postFilter ( "comment" );
//Do something!

//Check if post exists
if($post_id == "" || $comment == "") {
	die("false");
	return;
}

//TODO: add spam filter
Comment::newComment($post_id, $comment, "1");

//Echo a link
echo "$ROOT_DIR/ajax/comment/list.php?post_id=$post_id";