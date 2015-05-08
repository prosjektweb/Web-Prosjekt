<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <div class="sidebar-module sidebar-module-inset">
        <h4>About</h4>
        <p>The blog is developed with the use of <a href='http://php.net/'>PHP</a>, <a href='https://www.mysql.com/'>MySQL</a>, <a href='http://www.smarty.net/'>Smarty</a> and <a href='http://getbootstrap.com/'>Bootstrap</a>.
    </div>
    <div class="sidebar-module">

        {if isset($archivedposts)}
            <h4>Archives</h4>
            <ol class="list-unstyled">
                {foreach $years as $year}
                    {$yearval = array_search($year, $years)}
                    {foreach $year as $month}

                        <li><a href="{makeLink("", "", array($month, $yearval) )}">{Archive::monthNumberToString($month)} {$yearval}</a></li>

                    {/foreach}
                {/foreach}

            </ol>
        {/if}
    </div>
    <div class="sidebar-module">
        <h4>Links about me</h4>
        <ol class="list-unstyled">
            <li><a href="http://www.github.com/meanz/">GitHub</a></li>
            <li><a href="http://www.facebook.com/steffen.evensen">Facebook</a></li>
        </ol>
    </div>
</div><!-- /.blog-sidebar -->