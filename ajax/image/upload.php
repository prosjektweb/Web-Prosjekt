<?php
// Include main
require ('../ajax.php');

$allowedExts = array (
		"gif",
		"jpeg",
		"jpg",
		"png" 
);
$temp = explode ( ".", $_FILES ["file"] ["name"] );
$extension = end ( $temp );
if (
		(($_FILES ["file"] ["type"] == "image/gif") || 
				($_FILES ["file"] ["type"] == "image/jpeg") || 
				($_FILES ["file"] ["type"] == "image/jpg") || 
				($_FILES ["file"] ["type"] == "image/pjpeg") || 
				($_FILES ["file"] ["type"] == "image/x-png") || 
				($_FILES ["file"] ["type"] == "image/png"))
		 && ($_FILES ["file"] ["size"] < $_SETTINGS["MAX_ATTACHMENT_SIZE"]) 
		 && in_array ( $extension, $allowedExts )) {
		 	
	if ($_FILES ["file"] ["error"] > 0) {
		echo "Return Code: " . $_FILES ["file"] ["error"] . "<br>";
	} else {
		$filename = $_FILES ["file"] ["name"];
		// echo "Upload: " . $_FILES ["file"] ["name"] . "<br>";
		// echo "Type: " . $_FILES ["file"] ["type"] . "<br>";
		// echo "Size: " . ($_FILES ["file"] ["size"] / 1024) . " kB<br>";
		// echo "Temp file: " . $_FILES ["file"] ["tmp_name"] . "<br>";
		$data = file_get_contents ( $_FILES ["file"] ["tmp_name"] );
		$imgId = Attachment::newAttachment ( "this is image", $_FILES ["file"] ["type"], ($data) );
		echo $ROOT_DIR . "/ajax/image/view.php?id=" . $imgId->id;
	}
} else {
	echo "Invalid file";
}