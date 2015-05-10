<?php

global $smarty;

//Destroy all session data
unsetSession("userId");
unsetSession("user");
unsetSession("username");
unsetSession("group_id");

$smarty->assign("page", "user/logout.tpl");
