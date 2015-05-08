<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item active" href="{$root}/">Home</a>
            <a class="blog-nav-item" href="#">About</a>
            {if $user.isSignedIn eq "false"}
                <form class="navbar-form navbar-right" action="{$links.user_login}" method="POST">
                    <div class="form-group">
                        <input type="text" placeholder="Username" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                    <a type="button" class="btn btn-success" href="{$links.user_register}" >Register</a>
                </form>

            {else}
                {if $user.isAdmin eq "true"}
                    <a class="blog-nav-item" href="{$links.admin_overview}">Admin</a>
                {/if}
                <form class="navbar-form navbar-right" action="{$links.user_logout}" method="POST">
                    <button type="submit" class="btn btn-success">Sign Out</button>
                </form>
                <div class="blog-nav-item navbar-right">
                    Hello {$user.displayName|capitalize}. 
                </div>
            {/if}
        </nav>
    </div>
</div>