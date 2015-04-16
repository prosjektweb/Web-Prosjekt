 <?php
$myfile = fopen("/var/log/apache2/error.log", "r") or die("Unable to open file!");
echo fread($myfile,filesize("/var/log/apache2/error.log"));
fclose($myfile);
?> 