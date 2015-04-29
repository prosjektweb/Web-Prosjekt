<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Oblig 3</p>
    </div>

    <div class="row">
        <div class="col-sm-8 blog-main">
            <form class="form-signin" style="margin-left: 10%;margin-right: 60%;" action="" method="POST">
                <h2 class="form-signin-heading">Register: </h2>
                <!--<span class="glyphicon-class">glyphicon glyphicon-envelop</span> -->
                {if $loginStatus eq "error" }
                    {foreach $errors as $error}
                        <font color="red"><p>* {$error}</p></font>
                    {/foreach}
                {/if}
                <label for="usernameInput" class="sr-only">Username</label>
                <input type="text" id="usernameInput" class="form-control" placeholder="Username" required autofocus>
                <label for="emailInput" class="sr-only">Email address</label>
                <input type="email" id="emailInput" class="form-control" placeholder="Email address" >
                <label for="emailRetype" class="sr-only">Re-type email address</label>
                <input type="email" id="emailRetype" class="form-control" placeholder="Re-type email address" >
                <label type="password" class="sr-only">Password</label>
                <input type="password" id="passwordInput" class="form-control" placeholder="Password" >
                <label type="passwordRetype" class="sr-only">Re-type password</label>
                <input type="password" id="passwordRetype" class="form-control" placeholder="Re-type password" >
                <button class="btn btn-lg btn-primary btn-block" type="submit">Create new account</button>

            </form>
        </div>
        {include file='../sidebar.tpl'}
    </div><!-- /.row -->
</div>