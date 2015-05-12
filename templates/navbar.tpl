<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item {if $navbar_page eq "1"}active{/if}" href="{$root}/">Home</a>
            <a class="blog-nav-item {if $navbar_page eq "2"}active{/if}" href="{makeLink("blog","about")}">About</a>

            {if $user.isSignedIn eq "false"}
                <form class="navbar-form navbar-right" action="{makeLink("user", "login")}" method="POST">
                    <div class="form-group">
                        <input type="text" placeholder="Username" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                    <a type="button" class="btn btn-success" href="{makeLink("user", "register")}" >Register</a>
                </form>

            {else}
                {if $user.isAdmin eq "true"}
                    <a class="blog-nav-item" href="{makeLink("admin", "overview")}">Admin</a>
                {/if}
                <form class="navbar-form navbar-right" action="{makeLink("user", "logout")}" method="POST">
                    <button type="submit" class="btn btn-success">Sign Out</button>
                </form>
                <div class="blog-nav-item navbar-right">
                    Hello {$user.username|capitalize}. 
                </div>
            {/if}

            <form  class="navbar-form navbar-right" action="" method="POST">
                <input type="text" class="form-control" placeholder="Søk..." name="search">
            </form>
        </nav>
    </div>
</div>