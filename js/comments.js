function deleteComment(link, id) {
	if(!confirm("Are you sure you want to delete this comment?")) {
		return;
	}
	var commentDiv = $("#comment-" + id);
	$.ajax(link).done(function(data){
		if(data == "true") {
			commentDiv.fadeOut();
		} else {
			alert("Unable to delete comment. :(\r\n" + data);
		}
	});
	
}

/**
 * Submit a comment
 * 
 * @param link
 * @param id
 */
function submitComment(link, id) {
	var commentArea = $("#post-" + id + "-comments");
	var commentForm = $("#comment-" + id + "-form");
	var commentText = $("#comment-" + id + "-text");
	var errorBox = $("#comment-" + id + "-form-error");
	if (commentText.val().length == 0) {
		errorBox.html("* Please enter some text before you submit!");
		errorBox.css("visibility", "visible");
		return;
	}

	$
			.post(link, commentForm.serialize())
			.done(function(data) {
				loadComments(data, id);
			})
			.fail(
					function() {
						commentArea
								.html("<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> We were unable to post your comment :'(</div>");
					});
}

/**
 * Load the comments
 * 
 * @param link
 * @param id
 */
function loadComments(link, id) {
	var commentArea = $("#post-" + id + "-comments");
	var jqxhr = $
			.ajax(link)
			.done(function(data) {
				commentArea.html(data);
			})
			.fail(
					function() {
						commentArea
								.html("<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> We were unable to fetch the comments :'(</div>");
					});
}

/**
 * Thank you stackoverflow, husker ikke hvor jeg fikk den, men var bare for
 * debugging n'eways.
 * 
 * @param arr
 * @param level
 * @returns {String}
 */
function print_r(arr, level) {
	var dumped_text = "";
	if (!level)
		level = 0;

	// The padding given at the beginning of the line.
	var level_padding = "";
	for (var j = 0; j < level + 1; j++)
		level_padding += "    ";

	if (typeof (arr) == 'object') { // Array/Hashes/Objects
		for ( var item in arr) {
			var value = arr[item];

			if (typeof (value) == 'object') { // If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += print_r(value, level + 1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value
						+ "\"\n";
			}
		}
	} else { // Stings/Chars/Numbers etc.
		dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
	}
	return dumped_text;
}