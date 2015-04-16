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
} else {
    
    if(getArg(0) == "delete")
    {
        $id = htmlspecialchars(getArg(1));
        echo "is delete";
        if(is_numeric($id))
        {
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
