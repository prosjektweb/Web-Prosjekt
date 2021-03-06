<?php
global $smarty;
$smarty->assign ( "page", "admin/overview.tpl" );

$smarty->assign ( "sidebar0", "active" );

$smartyData = array ();

try {
	$stmt = getDB ()->prepare ( "SELECT * FROM Pages WHERE page='blog' AND file='view' ORDER BY hit_count DESC LIMIT 5" );
	$stmt->execute ();
	
	while ( ($row = $stmt->fetch ()) != false ) {
		
		$post = Post::get($row["arg_0"]);
		
		$smartyData [] = array (
				"label" => "<a style=\"color: #fff;\" href=\"" . makeLink("blog", "view", array($row["arg_0"])) . "\">" . ($post == null ? $row["arg_0"] : $post->title) . "</a>" ,
				"value" => $row ["hit_count"] 
		);
	}
} catch ( Exception $ex ) {
	setSession ( "error", $ex->getMessage () );
}

 $smarty->assign("data", $smartyData);