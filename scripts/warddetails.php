<?php

ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');

$db = new databaseConnection;
$db->setConnection();

$couchdb = new Couchdb("swmqrcode");



$sqlWard = "SELECT master_ward.*, master_circle.circle_name, master_vendor.vendor_name, ward_vendor.vendor_code FROM master_ward, master_vendor, ward_vendor, "
        . " master_circle WHERE"
        . " master_ward.ward_no = ward_vendor.ward_no AND ward_vendor.vendor_code =  master_vendor.vendor_code AND   master_ward.circle_id = master_circle.circle_id";

$result = $db->runQuery($sqlWard);


for ($i = 0; $i < count($result); $i++) {


    $ward_no = trim($result[$i]['ward_no']);
    $circle_id = trim($result[$i]['circle_id']);
    $circle_name = trim($result[$i]['circle_name']);
    $vendor_name = trim($result[$i]['vendor_name']);
    $vendor_code = trim($result[$i]['vendor_code']);
    $ward_color = trim($result[$i]['ward_color']);
    $total_footprints = trim($result[$i]['total_footprints']);
    $ward_boundary_file = trim($result[$i]['ward_boundary_file']);
    $doc_id = "W" . $ward_no;
    $table_name = "WARD_MASTER";



    $doc_obj = array(
        'table_name' => $table_name,
        'doc_id' => $doc_id,
        'ward_no' => $ward_no,
        'circle_id' => $circle_id,
        'circle_name' => $circle_name,
        'vendor_name' => $vendor_name,
        'vendor_code' => $vendor_code,
        'ward_color' => $ward_color,
        'total_footprints' => $total_footprints,
        'ward_boundary_file' => $ward_boundary_file
    );


    $couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
    print_r($doc_obj);

    //$payload = '["'.$table_name.'", "'.$doc_id.'"]';
    //$data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getNoImgSurveyDataByDOCID?&assending=true&key=");
}
?>
