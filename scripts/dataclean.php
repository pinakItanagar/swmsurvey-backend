<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');

$db = new databaseConnection;
$db->setConnection();

$couchdb = new Couchdb("swmqrcode");
$table_name = "HOUSEHOLD_DATA";
$payload = '["'.$table_name.'"]';
$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getAllSurveyData?&assending=true&key=");

$pid_data = array();
$duplicate_data = array();
$global_pid = "";
$x =  1;
$j = 0;
//$myfile = fopen("record.txt", "w") or die("Unable to open file!");
for($i=0 ; $i<count($data->rows); $i++) {
     $pid = $data->rows[$i]->value->pid ;
    
     if (!in_array($pid, $pid_data)) {
         array_push($pid_data, $pid);
     } else {
         $record = $pid."#".$data->rows[$i]->value->doc_id."#".$data->rows[$i]->value->_rev;
         array_push($duplicate_data, $record);
     }
    
}
//fclose($myfile);
echo "<pre>";
print_r($duplicate_data);

for($i=0 ; $i<count($duplicate_data); $i++) {
  $record_array =  explode('#', $duplicate_data[$i] );
  $doc_id = $record_array[1];
  $revision = $record_array[2];
  $response = $couchdb->deleteCouchDbDoc($revision, $doc_id, 'text/plain');
  print $response."\n";
}
?>
