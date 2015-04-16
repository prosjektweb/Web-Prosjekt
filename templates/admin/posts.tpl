<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Posts</h1>
    <form class="navbar-form" action="{$root}/admin/posts/new" method="POST">
        <button type="submit" class="btn btn-success">New post</button>
    </form>
    <script type="text/javascript">
        function redirect(uri)
        {
            window.location = uri;
        }

        function doEdit(id)
        {
            redirect("{$root}/admin/posts/edit/" + id);
        }

        function doDelete(id)
        {
            if (confirm("Are you sure you want to delete this post?"))
            {
                redirect("{$root}/admin/posts/delete/" + id);
            }
        }
    </script>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Post Date</th>
                    <th>Poster</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {strip}
                    {foreach $posts as $post}

                        <tr>
                            <td>{$post.id}</td>
                            <td>{$post.title|truncate:30}</td>
                            <td>{$post.postdate}</td>
                            <td>{$post.poster|capitalize}</td>
                            <td>
                                <button type="button" disabled="true" onClick="doEdit('{$post.id}')" class="btn btn-success">Edit</button>
                                <button type="button" onClick="doDelete('{$post.id}')" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    {/foreach}
                {/strip}

            </tbody>
        </table>
    </div>
</div>