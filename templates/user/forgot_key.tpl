<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>

    <div class="row">
        <div class="col-sm-8 blog-main">

            {if $status eq "success"}
                <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> You will receive a email shorty so you can create a new password.
                </div>
            {else}
                <div class="well">
                    <form class="form-signin" style="margin-left: 10%;margin-right: 60%;" action="{$links.forgot_key}" method="POST">
                        <h2 class="form-signin-heading">Forgotten password: </h2>
                        {if $status eq "error" }
                            {foreach $errors as $error}
                                <font color="red"><p>* {$error}</p></font>
                            {/foreach}
                        {/if}

                        <input type="email" id="emailInput" name="emailInput" class="form-control" style="margin-bottom: 15px;" placeholder="Email address" required autofocus>
                        <br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                    </form>
                </div>

            {/if}

        </div>
        {include file='../sidebar.tpl'}
    </div><!-- /.row -->
</div>