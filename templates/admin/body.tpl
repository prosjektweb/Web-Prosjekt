{include file="admin/header.tpl"}
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{$root}/">Oblig 3</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="{$root}">Overview</a></li>
                    <li><a href="{$links.admin_posts}">Posts</a></li>
                    <li><a href="{$links.admin_users}">User Administration</a></li>
                    <li><a href="{$links.admin_configuration}">Configuration</a></li>
                </ul>
                <ul class="nav nav-sidebar">
                </ul>
                <ul class="nav nav-sidebar">
                </ul>
            </div>

        </div>
    </div>
    {include file="{$page}"}

</body>