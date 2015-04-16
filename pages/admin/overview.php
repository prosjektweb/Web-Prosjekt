<?php

if (!isLoggedIn()) {
    headerRedirect($ROOT_DIR . "/user/login");
}
if (!isAdmin()) {
    setSession("error", "Unauthorized.");
    return;
}

global $smarty;
$smarty->assign("body", "admin/body.tpl");
$smarty->assign("page", "admin/overview.tpl");
