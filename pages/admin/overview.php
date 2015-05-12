<?php
global $smarty;
$smarty->assign ( "page", "admin/overview.tpl" );

$smarty->assign ( "sidebar0", "active" );

$smartyData = array ();

try {
	$stmt = getDB ()->prepare ( "SELECT * FROM Pages ORDER BY hit_count DESC LIMIT 5" );
	$stmt->execute ();
	
	while ( ($row = $stmt->fetch ()) != false ) {
		
		$smartyData [] = array (
				"label" => $row ["page"] . "_" . $row ["file"],
				"value" => $row ["hit_count"] 
		);
	}
} catch ( Exception $ex ) {
	setSession ( "error", $ex->getMessage () );
}

 $smarty->assign("data", $smartyData);