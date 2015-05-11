<div class="well">
	<div id="comment-{$post_id}-container">
		<h3>Comments</h3>
		<hr>
		{strip} 
			{foreach $comments as $comment}
				<div class="well">
					<div style="float: left; padding: 6px; margin-right: 5px; background-color: #333;"><span style="font-size: 32px;" class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
					<div style="font-size: 16px;">
						<i>{$comment.poster|capitalize} - {$comment.timesince}</i>
						{if $user.isAdmin eq "true"}
							<div style="float: right; text-align: right;">
								<button type="button" class="btn btn-default" style="padding: 5px; padding-left: 10px; padding-right: 10px;">
									<span style="font-size: 12px; color: #f00;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
						{/if}
					</div>
					<div style="word-wrap: break-word; color: #333;">{$comment.content}</div>
					
					<div style='clear: both;'></div>
				</div>
			{/foreach} 
		{/strip}
		<br />
		<h4>Leave a comment:</h4>
		<form id='comment-{$post_id}-form' action='{$root}/ajax/comment/post.php' method="POST">
			<input type="hidden" name="post_id" value="{$post_id}" />
			<div id="comment-{$post_id}-form-error" style="visibility: hiiden; color: #a94442;"></div>
			<textarea id="comment-{$post_id}-text" name="comment" style='width: 100%; color: #333; font-size: 14px;'></textarea>
			<br />
			<input type='button' style='font-size: 14px; color: #333;' onClick='submitComment("{$root}/ajax/comment/post.php", {$post_id})' value='Comment'>
		</form>
	</div>
</div>