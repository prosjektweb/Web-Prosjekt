<?php

if (!isLoggedIn()) {
    headerRedirect(makeLink("user", "login"));
}
if (!isAdmin()) {
    setSession("error", "Unauthorized.");
    return;
}

//Assign body
global $smarty;
$smarty->assign("body", "admin/body.tpl");

//Links
addLink("admin_posts", "admin", "posts");
addLink("admin_users", "admin", "users");
addLink("admin_configuration", "admin", "configuration");
addLink("admin_overview", "admin", "overview");

//Assign sidebars
for ($i = 0; $i < 4; $i++) {
    $smarty->assign("sidebar" . $i, "none");
}