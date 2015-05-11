<?php

$smarty->assign("page", "blog/view.tpl");
if (hasArg(0)) {
    $id = getArg(0);
    if (is_numeric($id)) {
        $post = Post::get($id);
        if ($post) {
            $smarty->assign("post", $post->getSmartyArray());
        }
    }
}