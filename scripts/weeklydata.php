<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');
$db = new databaseConnection;
$db->setConnection();

$couchdb =  new Couchdb("swmqrcode");

$date = date("Y-m-d");
$sql = "select count(p_record_id) as 'total' , DATE(date_updated) as 'survey_date' from property_master_update WHERE DATE(date_updated) = '".$date."' ";
$result = $db->runQuery($sql);

$table_name = "DAILY_DATA" ;
$doc_id = "DAILY_DATA_".$date;
$total = $result[0]['total'];
$survey_date = $result[0]['survey_date'];
$survey_total = $result[0]['total'];
$doc_obj = array(
    'table_name' => $table_name,
    'doc_id' => $doc_id,
    'survey_date' => trim($survey_date),
    'survey_total' => trim($survey_total)
);
$couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
?>
