<?php
// Include main
require ('../ajax.php');
//
$post_id = getFilter ( "post_id" );

echo $post_id . "\r\n";

// We want to list the comments
$comments = Comment::loadComment ( $post_id );

echo sizeof($comments) . "\r\n";

// Send the comments in a json array!
echo json_encode ( $comments );