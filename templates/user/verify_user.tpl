<div class="container">

	<div class="blog-header">
		<h1 class="blog-title">{$webpage.title}</h1>
		<p class="lead blog-description">ITE1805 Databaser og
			webapplikasjoner vår 2015 - Oblig 3</p>
	</div>

	<div class="row">
		<div class="col-sm-8 blog-main">
			{if $loginStatus eq "activated"}
			<div class="alert alert-success" role="alert">
				<strong>Success!</strong> You have activated your account. You may
				now proceed to login.
			</div>
			{else} {if $loginStatus eq "error" } {foreach $errors as $error} <font
				color="red"><p>* {$error}</p></font> {/foreach} {/if} {/if}
		</div>
		{include file='../sidebar.tpl'}
	</div>
	<!-- /.row -->
</div>