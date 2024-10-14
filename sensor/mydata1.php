<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
$json = file_get_contents('php://input');

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $json);
fclose($myfile);
?>