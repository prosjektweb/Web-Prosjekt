<div class="container"> 

    <div class="blog-header">
        <h1 class="blog-title">Steffen's (501669) Blog</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Oblig 3</p>
    </div>
    <div class="row">


        <div class="col-sm-8 blog-main">
            {if $loginStatus eq "success"}

            {else}
                <div class="well">
                    <p>
                    <h2 class="blog-post-title">Login</h2>
                    {if $loginStatus eq "error" }
                        {foreach $errors as $error}
                            <font color="red"><p>* {$error}</p></font>                       
                        {/foreach}
                    {/if}
                    <form action="{$links.user_login}" method="POST">
                        <div class="form-group">
                            <p>Username:</p>
                            <input type="text" placeholder="Username" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <p>Password:</p>
                            <input type="password" placeholder="Password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-block btn-success">Sign in</button>
                    </form>
                    </p>
                </div>
            {/if}
        </div><!-- /.blog-main -->

        {include file='../sidebar.tpl'}

    </div><!-- /.row -->
</div>