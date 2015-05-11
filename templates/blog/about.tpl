<div class="container">

    <script src="{$root}/js/holder.js" type="text/javascript"></script>

    <div class="blog-header">
        <h1 class="blog-title">{$webpage.title}</h1>
        <p class="lead blog-description">ITE1805 Databaser og
            webapplikasjoner vår 2015 - Prosjekt Oppgave</p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title">
                    <a href='{makeLink("user", "view", array())}'>Bjarte Gjerstad</a>
                </h2>
                <img data-src="holder.js/128x128" class="img-thumbnail" alt="128x128" style="width: 128px; height: 128px;">
                Bjarte har gjort ting.
            </div>  
            <div class="blog-post">
                <h2 class="blog-post-title">
                    <a href='{makeLink("user", "view", array())}'>Andreas Mosvoll</a>
                </h2>
                <img data-src="holder.js/128x128" class="img-thumbnail" alt="128x128" style="width: 128px; height: 128px;">
                Andreas har gjort ting.
            </div>  
            <div class="blog-post">
                <h2 class="blog-post-title">
                    <a href='{makeLink("user", "view", array())}'>Steffen Evensen</a>
                </h2>
                <img data-src="holder.js/128x128" class="img-thumbnail" alt="128x128" style="width: 128px; height: 128px;">
                Steffen har gjort ting.<br />
            </div>
        </div>

        <!-- /.blog-main -->

        {include file='sidebar.tpl'}

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->