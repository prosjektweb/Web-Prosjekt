<?php
if ($_GET ["action"] == "submit") {
	$fin = "config_template.php";
	$fout = "config.php";
	
	// Read template file
	$fhandle = fopen ( $fin, "r" ) or die ( "Unable to open config file, chmod this folder to 777." );
	$fdata = fread ( $fhandle, filesize ( $fin ) );
	fclose ( $fhandle );
	
	// Open output file
	$fhandle = fopen ( $fout, "w" ) or die ( "Unable to write config file, chmod this folder to 777" );
	
	$sql_server = $_POST ["sql_server"];
	$sql_username = $_POST ["sql_username"];
	$sql_password = $_POST ["sql_password"];
	$sql_database = $_POST ["sql_database"];
	$root = $_POST ["root"];
	
	// Replace variables
	$fdata = str_replace ( "#sql_server#", $sql_server, $fdata );
	$fdata = str_replace ( "#sql_username#", $sql_username, $fdata );
	$fdata = str_replace ( "#sql_password#", $sql_password, $fdata );
	$fdata = str_replace ( "#sql_database#", $sql_database, $fdata );
	$fdata = str_replace ( "#root#", $root, $fdata );
	
	// Write our data
	if (fwrite ( $fhandle, $fdata ) > 0) {
		echo "Installation complete.";
		return;
	}
	fclose ( $fhandle );
}

?>

<b>Notice!</b>
<br />
<pre>There is no field validation on this installation script. We assume you know what you're doing.</pre>

<form action="install.php?action=submit" method="POST">

	SQL Server: <br /> <input name="sql_server" type="text"
		value="<?php $_POST["sql_server"]; ?>" /><br /> SQL Username: <br /> <input
		name="sql_username" type="text"
		value="<?php $_POST["sql_username"]; ?>" /><br /> SQL Password: <br />
	<input name="sql_password" type="text"
		value="<?php $_POST["sql_password"]; ?>" /><br /> SQL Database: <br />
	<input name="sql_database" type="text"
		value="<?php $_POST["sql_database"]; ?>" /><br /> <br /> Root
	Directory of the application. <br /> Eg:
	http://kark.hin.no/~501669/prosjekt/web<br /> <b>Notice!</b> it is not
	recommended to use a trailing slash / as this will cause <br /> the
	generated URL's to have two of them Eg:
	http://localhost/web-prosjekt//file.php<br /> <input name="root"
		type="text" value="<?php $_POST["root"]; ?>"><br />
	<br /> <input type="submit" value="Install!" />
</form>