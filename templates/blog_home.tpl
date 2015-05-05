<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">Steffen's (501669) Blog</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Oblig 3</p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">

            {strip}
                {foreach $posts as $post}
                    <div class="blog-post">
                        <h2 class="blog-post-title"><a href='{$links.post_view}{$post.id}'>{$post.title}</a></h2>
                        <p class="blog-post-meta">{$post.postdate} by <a href="/user/{$post.poster}">{$post.poster|capitalize}</a></p> 
                        {$post.content}
                    </div>
                {/foreach}
            {/strip}
        </div><!-- /.blog-main -->

        {include file='sidebar.tpl'}

    </div><!-- /.row -->

</div><!-- /.container -->