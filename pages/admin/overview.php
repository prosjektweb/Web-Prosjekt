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

//Links
addLink("admin_posts", "admin", "posts");
addLink("admin_users", "admin", "users");
addLink("admin_configuration", "admin", "configuration");
