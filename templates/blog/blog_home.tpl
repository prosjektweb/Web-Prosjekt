<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">

            {strip}
                {if hasArg(0)}
                    <h2 class="blog-post-title">Arkiverte poster for {Archive::monthNumberToString(getArg(0))} {getArg(1)}</h2><hr>
                    {foreach $month as $post}
                        <div class="blog-post">
                            <h2 class="blog-post-title"><a href='{makeLink("blog", "view", array( $post.id ))}'>{$post.title}</a></h2>
                            <p class="blog-post-meta">{$post.postdate} by <a href="/user/{$post.poster}">{$post.poster|capitalize}</a></p>
                            {$post.content}
                        </div>
                    {/foreach}
                {else}
                    {foreach $posts as $post}
                        <div class="blog-post">
                            <h2 class="blog-post-title"><a href='{makeLink("blog", "view", array( $post.id ))}'>{$post.title}</a></h2>
                            <p class="blog-post-meta">{$post.postdate} by <a href="{makeLink("user", "view", array("{$post.poster}"))}">{$post.poster|capitalize}</a></p>
                            {$post.content}
                        </div>
                        
                        <p id="post-{$post.id}-comments" class="blog-post-meta">
							- <a href="javascript:loadComments('{$root}/ajax/comment/list.php?post_id={$post.id}', {$post.id})">{$post.numcomments} comments</a>
						</p>		
                    {/foreach}
                {/if}
            {/strip}
        </div><!-- /.blog-main -->

        {include file='sidebar.tpl'}

    </div><!-- /.row -->

</div><!-- /.container -->