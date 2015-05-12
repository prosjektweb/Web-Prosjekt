<div class="container"> 

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>
    <div class="row">


        <div class="col-sm-8 blog-main">
            {if $loginStatus eq "success"}
				<div class="alert alert-success" role="alert">
        			<strong>Success!</strong> You are now logged in.
      			</div>
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
                            <input type="text" placeholder="Username" class="form-control" name="username" required autofocus>
                        </div>
                        <div class="form-group">
                            <p>Password:</p>
                            <input type="password" placeholder="Password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-block btn-success">Sign in</button>

                        <a type="button" class="btn btn-block btn-success" href="{makeLink("user", "forgot_key")}" >Forgotten password</a>

                    </form>
                    </p>
                </div>
            {/if}
        </div><!-- /.blog-main -->

        {include file='../sidebar.tpl'}

    </div><!-- /.row -->
</div>