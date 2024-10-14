<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');




$couchdb =  new Couchdb("swmqrcode");
$table_name = "HOUSEHOLD_DATA";

$payload = '["'.$table_name.'", "1" ]';
$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getTotalSurveyByCircleID?&descending=true&key=");
echo "<pre>";
print_r($data);

$total_rows = count($data->rows);
echo $total_rows;

?>
