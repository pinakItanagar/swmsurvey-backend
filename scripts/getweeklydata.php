<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');


 function getLastSevenDays() {
        $week = array(); 
       for ($i=1; $i<8; $i++) {
          $date =  date("Y-m-d", strtotime($i." days ago"));
          array_push($week,$date);
       }
       return $week; 
      
 }

$week = getLastSevenDays();
$couchdb =  new Couchdb("swmqrcode");
$table_name = "DAILY_DATA";

$payload = '["'.$table_name.'"]';
$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getDailyData?&descending=true&key=");


$total_rows = count($data->rows);

$daily_data = array();
$week_date = array();

for($i=0; $i<8; $i++) {
    
    array_push($daily_data, $data->rows[$i]->value->survey_total);
    array_push($week_date, $data->rows[$i]->value->survey_date);
    
}

$daily_data_rev = array_reverse($daily_data);
$week_date_rev = array_reverse($week_date);

$weekly_data_report = array( "week_date" =>  $week_date_rev, "daily_data" => $daily_data_rev);
$json_data = json_encode($weekly_data_report);

$cdate = date("Y-m-d");
$file_name = "weekly_data_".$cdate.".json";
$file_name_path = "/var/www/html/psc/download/".$file_name;

$myfile = fopen($file_name_path, "w") or die("Unable to open file!");
fwrite($myfile, $json_data);
fclose($myfile);
?>
