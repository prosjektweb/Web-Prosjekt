<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    
    <h1 class="page-header">New Post</h1>
    {strip}
        {foreach $post_error as $err}
            <font color="red">{$err}</font><br />
        {/foreach}
    {/strip}

    {if $post_success eq "true"}
        <div class="alert alert-success" role="alert">
            <strong>Post complete!</strong>
        </div>
    {else}
        <script type="text/javascript" src="{$root}/js/admin.js"></script>
        <script type="text/javascript" src="{$root}/js/jquery.upload.js"></script>
        <form action="{makeLink("admin", "posts", array( "new", "submit" ))}" method="POST">
            <h4>Title:</h4>
            <input type="text" name="post_title" placeholder="Enter Title" value="{$post.title}"/>
            <br />
            <br />
            {include file="../../textarea.tpl"}
            <input type="hidden" name="post_content" id="post_content" value="">
            <div style="width: 80%; min-height: 250px; border: 1px solid #269abc;" id="editor">
                {$post.content}
            </div>
            <br />
            <button type="button" onClick="postSubmit()" class="btn btn-success">New Post</button>
        </form>
        <div id="uploadlog">
        </div>
    {/if}
    
    <div id="output"></div>
</div>