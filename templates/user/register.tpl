<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Oblig 3</p>
    </div>

    <div class="row">
        <div class="col-sm-8 blog-main">
            <form class="form-signin" style="margin-left: 10%;margin-right: 60%;" action="{$links.user_register}" method="POST">
                <h2 class="form-signin-heading">Register: </h2>
                <!--<span class="glyphicon-class">glyphicon glyphicon-envelop</span> -->
                {if $loginStatus eq "success"}
                <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> Your account has been created. You will receive a email shortly to activate your account.
                </div>
                {else}
                <label for="usernameInput" class="sr-only">Username</label>
                <input type="text" id="usernameInput" name="usernameInput" class="form-control" placeholder="Username" required autofocus>
                <label for="emailInput" class="sr-only">Email address</label>
                <input type="email" id="emailInput" name="emailInput" class="form-control" placeholder="Email address" >
                <label for="emailRetype" class="sr-only">Re-type email address</label>
                <input type="email" id="emailRetype" name="emailRetype" class="form-control" placeholder="Re-type email address" >
                <label for="passwordInput" class="sr-only">Password</label>
                <input type="password" id="passwordInput" name="passwordInput" class="form-control" placeholder="Password" >
                <label for="passwordRetype"  class="sr-only">Re-type password</label>
                <input type="password" id="passwordRetype" name="passwordRetype" class="form-control" placeholder="Re-type password" >
                <button class="btn btn-lg btn-primary btn-block" type="submit">Create new account</button>
                {if $loginStatus eq "error" }
                    {foreach $errors as $error}
                        <font color="red"><p>* {$error}</p></font>
                    {/foreach}
                {/if}
                {/if}
            </form>
        </div>
        {include file='../sidebar.tpl'}
    </div><!-- /.row -->
</div>