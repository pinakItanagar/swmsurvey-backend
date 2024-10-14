<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');




$couchdb =  new Couchdb("swmqrcode");
$table_name = "HOUSEHOLD_DATA";

$payload = '["'.$table_name.'"]';
$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getTotalSurvey?&descending=true&key=");


$total_rows = count($data->rows);
echo $total_rows;

?>
