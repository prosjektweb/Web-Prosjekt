<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Log</h1>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Action</th>
					<th>Message</th>
					<th>When</th>
					<th>User</th>
				</tr>
			</thead>
			<tbody>
				{foreach $entries as $entry}
				<tr>
					<td>{$entry.id}</td>
					<td>{$entry.action}</td>
					<td>{$entry.message}</td>
					<td>{$entry.date}</td>
					<td>{$entry.user|capitalize}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
	<ul class="pagination">
		{for $i=1 to $pagination}
			<li {if getArg(0) eq $i}class="active"{/if}><a href="{makeLink("admin", "log", array("$i"))}">{$i}</a></li>
		{/for}
	</ul>
</div>