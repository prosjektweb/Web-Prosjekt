<?php
setPage ( "admin/log.tpl" );

$smarty->assign ( "sidebar3", "active" );

$logEntriesPerPage = 20;
$offset = hasArg ( 0 ) && is_numeric ( getArg ( 0 ) ) ? (getArg ( 0 ) - 1) * $logEntriesPerPage : "0";

// Load all users
$entries = Log::loadEntries ( "ORDER BY date DESC LIMIT $logEntriesPerPage OFFSET $offset" );

// Assign all users to smarty
$smartyEntries = array ();
foreach ( $entries as $entry ) {
	$smartyEntries [] = array (
			"id" => $entry->id,
			"action" => $entry->action,
			"message" => $entry->message,
			"user" => User::getUsernameById ( $entry->user ),
			"date" => $entry->date
	);
}
$smarty->assign ( "pagination", (Log::getLogCount () / $logEntriesPerPage) );
$smarty->assign ( "entries", $smartyEntries );