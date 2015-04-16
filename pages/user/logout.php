<?php

global $smarty;

//Destroy all session data
unsetSession("userId");

$smarty->assign("page", "user/logout.tpl");
