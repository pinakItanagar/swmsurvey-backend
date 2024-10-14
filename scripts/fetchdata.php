<?php
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');
$db = new databaseConnection;
$db->setConnection();

$couchdb =  new Couchdb();


$report_date = date("Y-m-d");
$fromDate = $report_date . " " . "05:00";
$toDate = $report_date . " " . "17:00";

$url = "http://65.0.84.113:6001/TReport/GetVehicleHistory";
$table_name = "GPSLOGDATA";

$sqlGetVehicle = "SELECT  *  FROM  master_vehicle ";
$result = $db->runQuery($sqlGetVehicle);

for ($i = 0; $i < count($result); $i++) {

    $post = [
        'ImeiNo' => trim($result[$i]['imei_no']),
        'FromDate' => $fromDate,
        'ToDate' => $toDate
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);

    $report = json_decode($response);
    $vehicle_data = json_decode($report);


   // for ($i = 0; $i < count($vehicle_data); $i++) {
    for ($i = 0; $i < 1; $i++) {
        $doc_id = "GPSLOG" . date("YmdHis") . $i;

        $doc_obj = array(
            'table_name' => $table_name,
            'doc_id' => $doc_id,
            'GpsTId' => trim($vehicle_data[$i]->GpsTId),
            'VehicleNo' => trim($vehicle_data[$i]->VehicleNo),
            'Speed' => trim($vehicle_data[$i]->Speed),
            'Lat' => trim($vehicle_data[$i]->Lat),
            'Lng' => trim($vehicle_data[$i]->Lng),
            'Ignition' => trim($vehicle_data[$i]->Ignition),
            'IPower' => trim($vehicle_data[$i]->IPower),
            'DatedOn' => trim($vehicle_data[$i]->DatedOn),
            'SyncOn' => trim($vehicle_data[$i]->SyncOn),
            'Distance' => trim($vehicle_data[$i]->Distance),
            'CircleName' => trim($vehicle_data[$i]->CircleName),
            'WardNo' => trim($vehicle_data[$i]->WardNo),
            'report_date' => $report_date,
            'sequence' => $i
        );

        // echo "<pre>";
        // echo $vehicle_data[$i]->GpsTId."<br>";
        //print_r($doc_obj);
        $this->couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
    }
}

?>
