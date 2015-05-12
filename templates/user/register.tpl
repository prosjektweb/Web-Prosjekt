<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Oblig 3</p>
    </div>

    <div class="row">
        <div class="col-sm-8 blog-main">

            {if $status eq "success"}
                <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> Your account has been created. You will receive a email shortly to activate your account.
                </div>
            {else}
            <div class="well">
                <h2 class="form-signin-heading">Register user </h2>
                {if $status eq "error" }
                    {foreach $errors as $error}
                        <font color="red"><p>* {$error}</p></font>
                    {/foreach}
                {/if}
                <form class="form-signin" style="margin-right: 40%;" action="{$links.user_register}" method="POST">

                    <input type="text" id="usernameInput" name="usernameInput" class="form-control" placeholder="Username" value="{postFilter("usernameInput")}" required autofocus>
                    <br />
                    <input type="email" id="emailInput" name="emailInput" class="form-control"  placeholder="Email address" value="{postFilter("emailInput")}" required>
                    <br />
                    <input type="email" id="emailRetype" name="emailRetype" class="form-control" placeholder="Re-type email address" value="{postFilter("emailRetype")}" required >
                    <br />
                    <input type="password" id="passwordInput" name="passwordInput" class="form-control" placeholder="Password" required>
                    <br />
                    <input type="password" id="passwordRetype" name="passwordRetype" class="form-control" placeholder="Re-type password" required>
                    <br />
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Create new account</button>
                </form>
            </div>

            {/if}

        </div>
        {include file='../sidebar.tpl'}
    </div><!-- /.row -->
</div>