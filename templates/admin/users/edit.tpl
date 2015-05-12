<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <h1 class="page-header">Edit User</h1>

    {if $form_ok eq "true"}
        <div class="alert alert-success" role="alert">
            <strong>User updated!</strong>
        </div>
    {/if}
    {foreach $form_error as $err}
		<font color="red">* {$err}</font><br />
    {/foreach}
        <script type="text/javascript" src="{$root}/js/admin.js"></script>
        <script type="text/javascript" src="{$root}/js/jquery.upload.js"></script>
        <form action="{makeLink("admin", "users", array( "edit", "{$edituser.id}", "submit"))}" method="POST">
            <h4>Username:</h4>
            <input type="text" name="user_username" placeholder="Enter Username" value="{$edituser.username}"/>
            <h4>E-Mail:</h4>
            <input type="text" name="user_email" placeholder="Enter E-Mail" value="{$edituser.email}"/>
            <h4>Forgot Key:</h4>
            <input type="text" name="user_forgotkey" placeholder="Enter forgot-key" value="{$edituser.forgotkey}"/>
            <h4>Activation Key:</h4>
            <input type="text" name="user_activationkey" placeholder="Enter activation-key" value="{$edituser.activationkey}"/>
            <h4>New Password:</h4>
            <input type="password" name="user_newpassword" placeholder="Enter password" value=""/>
            <h4>New Password (Re-Type):</h4>
            <input type="password" name="user_newpassword_retype" placeholder="Re-type password" value=""/>
            <br />
            <br />
            <input type="submit" value="Update" />
        </form>
        <div id="uploadlog">
        </div>

</div>