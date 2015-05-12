<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Users</h1>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>E-Mail</th>
					<th>Options</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach $users as $user}
				<tr>
					<td>{$user.id}</td>
					<td>{$user.username|truncate}</td>
					<td>{$user.email}</td>
					<td><button type="button" onClick="wp_redirect('{makeLink("admin", "users", array("edit", "{$user.id}"))}');" class="btn btn-success">Edit</button></td>
					<td><button type="button"
							onClick="wp_do_confirm('Are you sure you want to delete this user?', '{makeLink("admin", "users", array("delete", {$user.id}))}');" class="btn btn-danger">Delete</button></td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>