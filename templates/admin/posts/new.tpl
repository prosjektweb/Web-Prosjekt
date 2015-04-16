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
        <form action="{$root}/admin/posts/new/submit" method="POST">
            <h4>Title:</h4>
            <input type="text" name="post_title" placeholder="Enter Title" value="{$post.title}"/>
            <br />
            <br />
            <textarea cols="60" rows="10" placeholder="Enter Content" name="post_content">{$post.content}</textarea>
            <br />
            <br />
            <button type="submit" class="btn btn-success">New post</button>
        </form>         
    {/if}

</div>