/**
 * @Ref http://stackoverflow.com/questions/1495822/replacing-nbsp-from-javascript-dom-text-node
 * @param str
 * @returns
 */
function replaceNbsps(str) {
	var re = new RegExp(String.fromCharCode(160), "g");
	return str.replace(re, " ");
}

/**
 * 
 */
function postSubmit() {
	// Get the editor contents
	var editor = $("#editor");
	// Put that into our hidden post_content field
	var post_content = $("#post_content");
	post_content.val(editor.cleanHtml());

	// submit our closest form
	editor.closest("form").submit();
}

/**
 * 
 * @param uri
 */
function redirect(uri) {
	window.location = uri;
}

/**
 * 
 * @param uri
 */
function doDelete(uri) {
	if (confirm("Are you sure you want to delete this post?")) {
		redirect(uri);
	}
}


function requestUpload() {
	
}
