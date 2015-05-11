<?php
$smarty->assign ( "navbar_page", "1" );

if (hasArg(0)) {
	$posts = Post::getPosts ();
	$smartyArchivedPosts = array ();
	
	for($i = 0; $i < sizeof ( $posts ); $i ++) {
		$post = $posts [$i];
		$smartyArchivedPosts [] = $post->getSmartyArray ();
	}
	Archive::setMonths ( $smartyArchivedPosts );
	
	$array = Archive::getMonthArray ( $smartyArchivedPosts, getArg(0) );
	$smarty->assign ( "month", $array );
} else {
	
	// Display posts
	$posts = Post::getPosts ();
	$smartyPosts = array ();
	$smartyArchivedPosts = array ();
	$searchResult = array ();
	$search = false;
	
	$postCount;
	$archivePosts = false;
	
	if (hasPost ( "search" )) {
		$search = true;
		$searchResult = search ( $posts );
	}
	
	if (sizeof ( $posts ) > 5) {
		$postCount = 5;
		$archivePosts = true;
	} elseif (sizeof ( $posts ) == 5) {
		$postCount = 5;
	} else {
		$postCount = sizeof ( $posts );
	}
	
	if ($search) {
		
		for($i = 0; $i < sizeof ( $searchResult ); $i ++) {
			$post = $searchResult [$i];
			$smartyPosts [] = $post->getSmartyArray ();
		}
	} else {
		
		for($i = 0; $i < $postCount; $i ++) {
			$post = $posts [$i];
			$smartyPosts [] = $post->getSmartyArray ();
		}
	}
	
	if ($archivePosts) {
		
		for($i = 0; $i < sizeof ( $posts ); $i ++) {
			$post = $posts [$i];
			$smartyArchivedPosts [] = $post->getSmartyArray ();
		}
		
		Archive::setMonths ( $smartyArchivedPosts );
	}
	
	$smarty->assign ( "posts", $smartyPosts );
}
$smarty->assign ( "archivedposts", $smartyArchivedPosts );
$smarty->assign ( "page", "blog/blog_home.tpl" );