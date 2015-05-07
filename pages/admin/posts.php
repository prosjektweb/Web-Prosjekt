<?php

if (!isLoggedIn()) {
    headerRedirect($ROOT_DIR . "/user/login");
    return;
}
if (!isAdmin()) {
    setSession("error", "Unauthorized.");
    return;
}

global $smarty;
$smarty->assign("body", "admin/body.tpl");

/*$smarty->assign("links", array(
    "admin_posts" => makeLink("admin", "posts"),
    "admin_users" => makeLink("admin", "users"),
    "admin_configuration" => makeLink("admin", "configuration"),
    "admin_posts_new" => makeLink("admin", "posts", array("new")),
    "admin_post_new_submit" => makeLink("admin", "posts", array("new", "submit")),
    "admin_posts_edit" => makeLink("admin", "posts", array("edit", "", "")),
    "admin_posts_edit_submit" => makeLink("admin", "posts", array("edit", "submit", "")),
    "admin_posts_delete" => makeLink("admin", "posts", array("delete", ""))
));*/

addLink("admin_posts", "admin", "posts");
addLink("admin_users", "admin", "users");
addLink("admin_configuration", "admin", "configuration");
addLink("admin_posts_new", "admin", "posts", array("new"));
addLink("admin_post_new_submit", "admin", "posts",  array("new", "submit"));
addLink("admin_posts_edit", "admin", "posts", array("edit", "", ""));
addLink("admin_posts_delete", "admin", "posts", array("delete"));

if (getArg(0) == "new") {
    $smarty->assign("page", "admin/posts/new.tpl");

    $smarty->assign("post", array(
        "title" => "",
        "content" => ""
    ));

    $smarty->assign("post_error", array());
    $smarty->assign("post_success", "false");


    // print_r($_SESSION);
    if (getArg(1) == "submit") {
        //Do form validation
        $title = postFilter("post_title");
        $content = postFilter("post_content");

        $error = array();
        if ($title == "") {
            $error[] = "* Title can not be empty";
        }
        if ($content == "") {
            $error[] = "* Content can not be empty";
        }
        if (strlen($title) > 50) {
            $error[] = "* Title must be 1-50 characters in length. Current length: (" . strlen($title) . ")";
        }
        if (strlen($content) > 1000) {
            $error[] = "* Content must be between 1-1000 characters in length. Current length: (" . strlen($content) . ")";
        }

        if (sizeof($error) > 0) {
            //Error happened
            $smarty->assign("post_error", $error);
        } else {
            //Start processing
            $post = new Post();
            $post->setValues($title, $content, session("userId"));
            $post->insert();
            //Pdo insert
            $smarty->assign("post_success", "true");
        }
    }
} else
    if (getArg(0) == "edit") {
        $smarty->assign("post", array(
            "id" => "",
            "title" =>"",
            "content" => ""
        ));

        $smarty->assign("page", "admin/posts/edit.tpl");

        $error = array();

        if(getArg(2) != ""){
            $id = htmlspecialchars(getArg(2));
        }
        else{
            $error[] = "Invalid ID";
        }

        if(Post::get($id) != null){
            $post = Post::get($id);
        }
        else{
            $error[] = "Invalid Post";
        }

        if (sizeof($error) > 0) {
            //Error happened
            $smarty->assign("post_success", "false");
            $smarty->assign("post_error", $error);
        } else {

            $smarty->assign("post_success", "true");


            addLink("admin_posts_edit_submit", "admin", "posts", array("edit", "submit", ""));

            $smarty->assign("post", array(
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "content" => $post->getContent()
            ));

            $smarty->assign("post_error", array());
            $smarty->assign("post_success", "false");

            if (getArg(1) == "submit") {
                //Do form validation
                $title = postFilter("post_title");
                $content = postFilter("post_content");

                $error = array();
                if ($title == "") {
                    $error[] = "* Title can not be empty";
                }
                if ($content == "") {
                    $error[] = "* Content can not be empty";
                }
                if (strlen($title) > 50) {
                    $error[] = "* Title must be 1-50 characters in length. Current length: (" . strlen($title) . ")";
                }
                if (strlen($content) > 1000) {
                    $error[] = "* Content must be between 1-1000 characters in length. Current length: (" . strlen($content) . ")";
                }

                if (sizeof($error) > 0) {
                    //Error happened
                    $smarty->assign("post_error", $error);
                } else {
                    //Start processing
                    Post::edit($id, $title, $content);
                    //Pdo insert
                    $smarty->assign("post_success", "true");
                }
            }
        }
    } else {

        if (getArg(0) == "delete") {
            $id = htmlspecialchars(getArg(1));
            echo "is delete";
            if (is_numeric($id)) {
                //Attempt to delete
                Post::delete($id);
            }
        }
        //Get all posts
        $posts = Post::getPosts();
        $smartyPosts = array();
        for ($i = 0; $i < sizeof($posts); $i++) {
            $post = $posts[$i];
            $smartyPosts[] = array(
                "id" => $post->getId(),
                "poster" => User::getUsernameById($post->getPoster()),
                "postdate" => $post->getPostDate(),
                "title" => $post->getTitle(),
                "content" => $post->getContent()
            );
        }
        $smarty->assign("posts", $smartyPosts);

        $smarty->assign("page", "admin/posts.tpl");
    }
