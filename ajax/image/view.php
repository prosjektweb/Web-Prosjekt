<?php
// Include main
require ('../ajax.php');


$id = getFilter("id");
if(!is_numeric($id)) {
	die();
}


$attachment = Attachment::load($id);

header('Content-type:' . $attachment->type);

echo $attachment->data;

//$base64 = 'data:image/' . $_FILES ["file"] ["type"] . ';base64,' . base64_encode ( $data );