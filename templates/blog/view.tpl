<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og
            webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>

    <div class="row">


        <div class="col-sm-8 blog-main">
            {if isset($post)}
                {strip}
                    <div class="blog-post">
                        <h2 class="blog-post-title">
                            {$post.title}
                        </h2>
                        <p class="blog-post-meta">
                            {$post.postdate} by <a href="/user/{$post.poster}">{$post.poster|capitalize}</a>
                        </p>
                        {$post.content}
                    </div>
                    <p id="post-{$post.id}-comments" class="blog-post-meta"></p>	
                    {literal}
                        <script type="text/javascript">
                            $(document).ready(function () {
                                loadComments("{/literal}{$root}{literal}/ajax/comment/list.php?post_id={/literal}{$post.id}{literal}", "{/literal}{$post.id}{literal}");
                            });
                        </script>
                    {/literal}
                {/strip}
            {else}
                <div class="alert alert-warning" role="alert">
                    <strong>Warning!</strong> No post was found.
                </div>
            {/if}
        </div>

        <!-- /.blog-main -->

        {include file='sidebar.tpl'}

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->