<?php
if (isset ( $_GET ['arg0'] )) {
	$posts = Post::getPosts ();
	$smartyArchivedPosts = array ();

	for($i = 1; $i < sizeof ( $posts ); $i ++) {
		$post = $posts [$i];
		$smartyArchivedPosts [] = array (
				"id" => $post->getId (),
				"poster" => User::getUsernameById ( $post->getPoster () ),
				"postdate" => $post->getPostDate (),
				"title" => $post->getTitle (),
				"content" => $post->getContent (),
				"numcomments" => $post->getCommentCount () 
		);
	}
	Archive::setMonths ( $smartyArchivedPosts );
	
	$array = Archive::getMonthArray ( $smartyArchivedPosts, $_GET ['arg0'] );
	$smarty->assign ( "month", $array );
} else {
	
	// Display posts
	$posts = Post::getPosts ();
	$smartyPosts = array ();
	$smartyArchivedPosts = array ();
	
	$postCount;
	$archivePosts = false;

    if(hasPost("search")){
        $posts = search($posts);
    }

	if (sizeof ( $posts ) > 5) {
		$postCount = 5;
		$archivePosts = true;
	} elseif (sizeof ( $posts ) == 5) {
		$postCount = 5;
	} else {
		$postCount = sizeof ( $posts );
	}


	for($i = 0; $i < $postCount; $i ++) {
		$post = $posts [$i];
		$smartyPosts [] = array (
				"id" => $post->getId (),
				"poster" => User::getUsernameById ( $post->getPoster () ),
				"postdate" => $post->getPostDate (),
				"title" => $post->getTitle (),
				"content" => $post->getContent (),
				"numcomments" => $post->getCommentCount () 
		);
	}
	
	if ($archivePosts) {
		
		for($i = 0; $i < sizeof ( $posts ); $i ++) {
			$post = $posts [$i];
			$smartyArchivedPosts [] = array (
					"id" => $post->getId (),
					"poster" => User::getUsernameById ( $post->getPoster () ),
					"postdate" => $post->getPostDate (),
					"title" => $post->getTitle (),
					"content" => $post->getContent (),
					"numcomments" => $post->getCommentCount () 
			);
		}
		
		Archive::setMonths ( $smartyArchivedPosts );
	}
	
	$smarty->assign ( "posts", $smartyPosts );
}
$smarty->assign ( "archivedposts", $smartyArchivedPosts );
$smarty->assign ( "page", "blog/blog_home.tpl" );