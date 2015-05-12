<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>

    <div class="row">
        <div class="col-sm-8 blog-main">
       		<h2 class="form-signin-heading">Change password</h2>
            <form class="form-signin" style="margin-right: 20%;" action="{makeLink("user", "new_password", array("{getArg(0)}", "{getArg(1)}", "{getArg(2)}"))}" method="POST">
                {if $status eq "invalid" }
					<div class="alert alert-danger" role="alert"><strong>Error!</strong> Link is used or invalid.</div>
                {else}
                {if $status eq "error" }
	                {foreach $errors as $error}
	                    <font color="red"><p>* {$error}</p></font>
	                {/foreach}
                {/if}
                {if $status eq "success"}
                    <div class="alert alert-success" role="alert">
                        <strong>Success!</strong> Your password has been changed.
                    </div>
                {else}
                	<p>Change password for user {getArg(0)}</p>
                    <label for="passwordInput" class="sr-only">Password</label>
                    <input type="password" id="passwordInput" name="passwordInput" class="form-control" placeholder="Password" required autofocus>
                    <br />
                    <label for="passwordRetype"  class="sr-only">Re-type password</label>
                    <input type="password" id="passwordRetype" name="passwordRetype" class="form-control" style="margin-bottom: 15px;" placeholder="Re-type password" >

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Create new account</button>
                    <br />
                {/if}
                {/if}

            </form>
        </div>
        {include file='../sidebar.tpl'}
    </div><!-- /.row -->
</div>