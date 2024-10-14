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
echo count($data->rows);

/*

$payload = '["'.$table_name.'"]';
$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getAllWard?&assending=true&key=");
$report_date = date("Y-m-d");
$table_name = "DAILY_QR_REPORT";

for($i=0 ; $i<count($data->rows); $i++) {
    $ward_no = $data->rows[$i]->value->ward_no ;
    $doc_id = date("Ymd")."W".$ward_no;
    
    $doc_obj = array(
        'table_name' => $table_name,
        'doc_id' => $doc_id,
        'report_date' => $report_date,
        'ward_no' => $ward_no,
        'total_footprint' => $circle_id,
        'vendor_code' => $circle_name,
        'vendor_name' => $vendor_name,
        'total_qrcode_installed_today' => $vendor_code,
        'total_qrcode_installed' => $ward_color,
        'pending_installation' => $total_footprints,
       
    );
}

echo "<pre>";
print_r($data->rows);
*/
?>
