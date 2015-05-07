<?php

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
