<?php
// Include main
require ('../ajax.php');
//
$post_id = getFilter ( "post_id" );

// We want to list the comments
$comments = Comment::loadComments ( $post_id );

// Send the comments in a json array!
global $smarty;


$data = array();
for($i=0; $i < sizeof($comments); $i++) {
	$data[] = array(
			
			"id" => $comments[$i]->id,
			"post_id" => $comments[$i]->post_id,
			"content" => $comments[$i]->content,
			"poster" => User::load($comments[$i]->poster)->username,
			"timesince" => get_time_ago(strtotime($comments[$i]->post_date))
			
	);
}

$smarty->assign("post_id", $post_id);
$smarty->assign("comments", $data);

//$smarty->assign("comments", $comments);
$smarty->display("comment/list.tpl");