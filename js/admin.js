
function postSubmit() {
    //Get the editor contents
    var editor = $("#editor");
    //Put that into our hidden post_content field
    var post_content = $("#post_content");
    post_content.val(editor.cleanHtml());
    //submit our closest form
    editor.closest("form").submit();
}