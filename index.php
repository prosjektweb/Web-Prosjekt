<?php
// Smarty module
require (dirname ( __FILE__ ) . "/" . '/modules/Init.common.php');

// Set default body
$smarty->assign("body", "body.tpl");

// Add links
addLink("user_login", "user", "login");
addLink("user_logout", "user", "logout");
addLink("admin_overview", "admin", "overview");
addLink("post_view", "blog", "view");
addLink("view_archive", "", "");
addLink("user_register", "user", "register");
addLink("verify_user", "user", "verify");
addLink("forgot_key", "user", "forgot_key");

$page = "";
$file = "";
$args = array();

/**
 * Parse page parameters
 */
if ($_SETTINGS ['mod_rewrite']) {
    if (array_key_exists("REDIRECT_URL", $_SERVER)) {
        $args = explode('/', $_SERVER ['REDIRECT_URL']); // REDIRECT_URL is provided by Apache when a URL has been rewritten
        array_shift($args);
        $data = array();
        for ($i = 0; $i < count($args); $i ++) {
            $data [] = $args [$i];
        }
        // Hardcoded 1 /oblig3/....
        $page = $args [1];
        $file = $args [2];

        // The next arguments are parameters
        // A little hacky way to do things
        // But we centralize it using a function to get these parameters
        // So that we can change the system later without compromising all the code
        for ($i = 3; $i < sizeof($args); $i ++) {
            setSession("arg" . ($i - 3), $args [$i]);
        }
    }
} else {
    $page = getFilter("page");
    $file = getFilter("file");

    // args
    $i = 0;
    $args = array();
    while (array_key_exists("arg" . $i, $_GET)) {
        $args [$i] = getFilter("arg" . $i);
        setSession("arg" . $i, $args [$i]);
        $i ++;
    }
}

// Safety filter for $page and $file
// Good luck doing any malicious stuff now hackers!
 $page = str_filter_only_alpha($page);
 $file = str_filter_only_alpha($file);

// Assign path values for smarty
$smarty->assign("path", array(
    "page" => $page,
    "file" => $file
));

// Attempt to navigate to the specified URL
$didInclude = false;
if (file_exists("./pages/$page")) {
    if (file_exists("./pages/$page/$file.php")) {
        include ("./pages/$page/$page.php");
        if (!hasSession("error")) {
            include ("./pages/$page/$file.php");
        }
        $didInclude = true;
    }
}

// Check if 404, otherise redirect to home!
if (!$didInclude) {
    // Main page
    if ($page == "" || $file == "") {
        $page = "blog";
        $file = "home";
        include ("./pages/$page/$page.php");
        if (!hasSession("error")) {
            include ("./pages/$page/$file.php");
        }
    } else {
        // 404
        $smarty->assign("page", "404.tpl");
    }
}
// Allt annet
//running hit counter
Hitcount::doHitcount($page, $file, getArg(0));
$hits = Hitcount::getHitcount($page, $file, getArg(0));
$smarty->assign("hits", $hits);

/**
 * Assign links
 */
global $links;
$smarty->assign("links", $links);

// If we have an error unset it
if (hasSession("error")) {
    // Display error page
    $smarty->assign("page", "error.tpl");
    $smarty->assign("errorMsg", session("error"));
    $smarty->display($smarty->getTemplateVars("body"));
    // Unset error
    unsetSession("error");
} else {
    $smarty->display($smarty->getTemplateVars("body"));
}
// The next arguments are parameters
// A little hacky way to do things
// But we centralize it using a function to get these parameters
// So that we can change the system later without compromising all the code
if (sizeof($args) > 0) {
    if ($_SETTINGS ['mod_rewrite']) {
        for ($i = 3; $i < sizeof($args); $i ++) {
            unsetSession("arg" . ($i - 3));
        }
    } else {
        for ($i = 0; $i < sizeof($args); $i ++) {
            unsetSession("arg" . ($i));
        }
    }
}
