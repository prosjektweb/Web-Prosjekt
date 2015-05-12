{include file="admin/header.tpl"}
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{$root}/">{$webpage.title}</a>
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
					{strip}
					<li class="{$sidebar0}"><a href="{makeLink("admin", "overview")}">Overview</a></li>
					<li class="{$sidebar1}"><a href="{makeLink("admin", "posts")}">Posts</a></li>
					<li class="{$sidebar2}"><a href="{makeLink("admin", "users")}">Users</a></li>
					<li class="{$sidebar3}"><a href="{makeLink("admin", "log")}">Logs</a></li>
					<li class="{$sidebar4}"><a href="{makeLink("admin", "configuration")}">Configuration</a></li>
					{/strip}
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