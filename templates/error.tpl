<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>
    
	<div class="row">

		<div class="col-sm-8 blog-main">
			<div class="blog-post">
				<img src="http://www.cypressnorth.com/wp-content/uploads/2012/09/catchAllTheErrors-615x461.png" />
					<br /><br />
				<div class="alert alert-danger" role="alert">
					<strong>Oh snap!</strong> An error has occured, and this is bad.
				</div>
			</div>
			<strong>Details about the error can be found here</strong>
			<div class="well">
				<p>{$errorMsg}</p>
			</div>
		</div>
		<!-- /.blog-main -->

		{include file='sidebar.tpl'}

	</div>
	<!-- /.row -->
</div>