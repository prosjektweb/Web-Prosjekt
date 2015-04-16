<?php

if (!isLoggedIn()) {
    headerRedirect(makeLink("user", "login"));
}
if (!isAdmin()) {
    setSession("error", "Unauthorized.");
    return;
}

global $smarty;
$smarty->assign("body", "admin/body.tpl");
$smarty->assign("page", "admin/overview.tpl");

$smarty->assign("links", array(
    "admin_posts" => makeLink("admin", "posts"),
    "admin_users" => makeLink("admin", "users"),
    "admin_configuration" => makeLink("admin", "configuration")
));

