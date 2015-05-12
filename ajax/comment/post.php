<?php
// Include main
require ('../ajax.php');
//check if we are allowed here!
if(!isLoggedIn()) {
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
Comment::newComment($post_id, $comment, session("userId"));

//Echo a link
echo "$ROOT_DIR/ajax/comment/list.php?post_id=$post_id";