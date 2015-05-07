<?php

session_start();
//Utilities
include("util.php");
//Blog module
include("modules/Blog.php");
//Archive.class
include("modules/Archive.class.php");
//Smarty module
require 'modules/smarty/libs/Smarty.class.php';

//Configuration
require 'config.php';

//Load SQL
require 'modules/sql.php';

//Create our Smarty object
global $smarty;

$smarty = new Smarty();

//Options
$smarty->debugging = false;
$smarty->caching = false;

//Set some path urls because of mod rewrite
$smarty->assign("root", $ROOT_DIR);

//Set some global vars
$smarty->assign("webpage", array("title" => $_SETTINGS['title']));

//Load user
if (hasSession("userId")) {
    setSession("user", User::load(session("userId")));
}

//Set default body
$smarty->assign("body", "body.tpl");

//Add links
addLink("user_login", "user", "login");
addLink("user_logout", "user", "logout");
addLink("admin_overview", "admin", "overview");
addLink("post_view", "blog", "view");
addLink("view_archive", "", "");

$page = "";
$file = "";
$args = array();

//Check page parameters
if ($_SETTINGS['mod_rewrite']) {
    if (array_key_exists("REDIRECT_URL", $_SERVER)) {
        $args = explode('/', $_SERVER['REDIRECT_URL']);  // REDIRECT_URL is provided by Apache when a URL has been rewritten
        array_shift($args);
        $data = array();
        for ($i = 0; $i < count($args); $i++) {
            $data[] = $args[$i];
        }
        //Hardcoded 1 /oblig3/....
        $page = $args[1];
        $file = $args[2];

        //The next arguments are parameters
        //A little hacky way to do things
        //But we centralize it using a function to get these parameters
        //So that we can change the system later without compromising all the code
        for ($i = 3; $i < sizeof($args); $i++) {
            setSession("arg" . ($i - 3), $args[$i]);
        }
    }
} else {
    $page = getFilter("page");
    $file = getFilter("file");
    //args
    $i = 0;
    $args = array();
    while (array_key_exists("arg" . $i, $_GET)) {
        $args[$i] = getFilter("arg" . $i);
        setSession("arg" . $i, $args[$i]);
        $i++;
    }
}

$didInclude = false;
if (file_exists("./pages/$page")) {
    if (file_exists("./pages/$page/$file.php")) {
        include("./pages/$page/$file.php");
        $didInclude = true;
    }
}

//Show home
if (!$didInclude) {

    //Main page
    if ($page == "" || $file == "") {



        if (isset($_GET['month'])) {
            $posts = Post::getPosts();
            $smartyArchivedPosts = array();

            for ($i = 5; $i < sizeof($posts); $i++) {
                $post = $posts[$i];
                $smartyArchivedPosts[] = array(
                    "id" => $post->getId(),
                    "poster" => User::getUsernameById($post->getPoster()),
                    "postdate" => $post->getPostDate(),
                    "title" => $post->getTitle(),
                    "content" => $post->getContent()
                );
            }
            Archive::setMonths($smartyArchivedPosts);

            $array = Archive::getMonthArray($smartyArchivedPosts, $_GET['month']);
            $smarty->assign("month", $array);
            $smarty->assign("archivedposts", $smartyArchivedPosts);
            $smarty->assign("page", "blog/blog_home.tpl");
        } else {


            //Display posts
            $posts = Post::getPosts();
            $smartyPosts = array();
            $smartyArchivedPosts = array();

            $postCount;
            $archivePosts = false;

            if (sizeof($posts) > 5) {
                $postCount = 5;
                $archivePosts = true;
            } elseif (sizeof($posts) == 5) {
                $postCount = 5;
            } else {
                $postCount = sizeof($posts);
            }

            for ($i = 0; $i < $postCount; $i++) {
                $post = $posts[$i];
                $smartyPosts[] = array(
                    "id" => $post->getId(),
                    "poster" => User::getUsernameById($post->getPoster()),
                    "postdate" => $post->getPostDate(),
                    "title" => $post->getTitle(),
                    "content" => $post->getContent()
                );
            }

            if ($archivePosts) {

                for ($i = 5; $i < sizeof($posts); $i++) {
                    $post = $posts[$i];
                    $smartyArchivedPosts[] = array(
                        "id" => $post->getId(),
                        "poster" => User::getUsernameById($post->getPoster()),
                        "postdate" => $post->getPostDate(),
                        "title" => $post->getTitle(),
                        "content" => $post->getContent()
                    );
                }

                Archive::setMonths($smartyArchivedPosts);
            }
            $smarty->assign("archivedposts", $smartyArchivedPosts);

            $smarty->assign("posts", $smartyPosts);
            $smarty->assign("page", "blog/blog_home.tpl");
        }
    } else {
        //404
        $smarty->assign("page", "404.tpl");
    }
}
//Allt annet
//Assign user values last so that any session edits will be noticed
$smarty->assign("user", array(
    "isAdmin" => "true",
    "isSignedIn" => hasSession("userId") ? "true" : "false",
    "displayName" => hasSession("userId") ? (session("user")->getUsername()) : ""
));

global $links;
$smarty->assign("links", $links);

//If we have an error unset it
if (hasSession("error")) {
    //Display error page
    $smarty->assign("page", "error.tpl");
    $smarty->assign("errorMsg", session("error"));
    $smarty->display($smarty->getTemplateVars("body"));
    //Unset error
    unsetSession("error");
} else {
    $smarty->display($smarty->getTemplateVars("body"));
}
//The next arguments are parameters
//A little hacky way to do things
//But we centralize it using a function to get these parameters
//So that we can change the system later without compromising all the code
if (sizeof($args) > 0) {
    if ($_SETTINGS['mod_rewrite']) {
        for ($i = 3; $i < sizeof($args); $i++) {
            unsetSession("arg" . ($i - 3));
        }
    } else {
        for ($i = 0; $i < sizeof($args); $i++) {
            unsetSession("arg" . ($i));
        }
    }
}