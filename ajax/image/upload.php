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
if ((($_FILES ["file"] ["type"] == "image/gif") || ($_FILES ["file"] ["type"] == "image/jpeg") || ($_FILES ["file"] ["type"] == "image/jpg") || ($_FILES ["file"] ["type"] == "image/pjpeg") || ($_FILES ["file"] ["type"] == "image/x-png") || ($_FILES ["file"] ["type"] == "image/png")) && ($_FILES ["file"] ["size"] < 200000) && in_array ( $extension, $allowedExts )) {
	if ($_FILES ["file"] ["error"] > 0) {
		echo "Return Code: " . $_FILES ["file"] ["error"] . "<br>";
	} else {
		$filename = $label . $_FILES ["file"] ["name"];
		echo "Upload: " . $_FILES ["file"] ["name"] . "<br>";
		echo "Type: " . $_FILES ["file"] ["type"] . "<br>";
		echo "Size: " . ($_FILES ["file"] ["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES ["file"] ["tmp_name"] . "<br>";
		$data = file_get_contents ( $filename );
		echo "aa";
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode ( $data );
		try {
			$imgId = Attachment::newImage ( "this is image", $base64 );
		} catch ( Exception $ex ) {
			echo $ex;
		}
		echo "Uploaded image something something: " . $imgId;
	}
} else {
	echo "Invalid file";
}