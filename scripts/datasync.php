<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');
include_once ('Couchdb2.php');
$db = new databaseConnection;
$db->setConnection();

$couchdb =  new Couchdb("swmqrcode");
$couchdb2 =  new Couchdb("swmqrcode2");


$sqlWard = "SELECT * FROM ward_vendor ";
$resultWardNo = $db->runQuery($sqlWard);

$myfile = fopen("/var/www/html/psc/download/cdb_datatransfer_new.log", "w") or die("Unable to open file!");
for($x = 0; $x < count($resultWardNo); $x++) {

    $sqlQR = "SELECT  property_master_update.*, master_building_type.building_type_name, master_circle.circle_name, master_surveyor.first_name, master_surveyor.last_name, "
            . " master_surveyor.mobile FROM  property_master_update, master_building_type, master_surveyor, master_circle WHERE "
            . "property_master_update.building_type = master_building_type.use_code  AND is_replicate = '0' AND ward_no = '".trim($resultWardNo[$x]['ward_no'])."' AND "
            . "master_circle.circle_id = property_master_update.circle_id AND property_master_update.updated_by_user = master_surveyor.userId  AND property_pic != '' ORDER BY p_record_id ASC LIMIT 20 ";

   
    $result = $db->runQuery($sqlQR);
    $table_name = "HOUSEHOLD_DATA" ;
    $ward_no = trim($resultWardNo[$x]['ward_no']);
    
    if($result[0]['p_record_id'] != "") {

        for ($i = 0; $i < count($result); $i++) {
        //for ($i = 0; $i < 1; $i++) {

                $p_record_id = $result[$i]['p_record_id'];
                $doc_id = "QRDATA-W".$ward_no."-". date("YmdHis").$p_record_id;
  

                $date_updated = trim($result[$i]['date_updated']);
                $arrayDate = explode(" ",$date_updated);
                $survey_date = trim($arrayDate[0]);
                $survey_time = trim($arrayDate[1]);

                $migration_date = date("Y-m-d");
                $migration_time = date("H:i:s");
                $remote_server_sync = "0";
                $remote_server_sync_datetime = "0";

                if(trim($result[$i]['isflat']) == "1") {
                    $entity_name = trim($result[$i]['flatName']);
                } else {
                    $entity_name = trim($result[$i]['owner_name']); 
                }

                $pid =  trim($result[$i]['pid']);
                $qr_code = trim($result[$i]['qr_code']);

                $doc_obj = array(
                    'table_name' => $table_name,
                    'doc_id' => $doc_id,
                    'p_record_id' => trim($p_record_id),
                    'isnew' => trim($result[$i]['isnew']),
                    'isflat' => trim($result[$i]['isflat']),
                    'circle_id' => trim($result[$i]['circle_id']),
                    'circle_name' => trim($result[$i]['circle_name']),
                    'ward_no' => trim($result[$i]['ward_no']),
                    'pid' => trim($result[$i]['pid']),
                    'entity_name' => trim($entity_name),
                    'owner_name' => trim($result[$i]['owner_name']),
                    'guardian_name' => trim($result[$i]['guardian_name']),
                    'mobile_no' => trim($result[$i]['mobile_no']),
                    'building_type' => trim($result[$i]['building_type']),
                    'building_type_name' => trim($result[$i]['building_type_name']),
                    'no_of_properties' => trim($result[$i]['no_of_properties']),
                    'occupancy_status' => trim($result[$i]['occupancy_status']),
                    'property_type' => trim($result[$i]['property_type']),
                    'flatName' => trim($result[$i]['flatName']),
                    'houseno' => trim($result[$i]['houseno']),
                    'address_street' => trim($result[$i]['address_street']),
                    'area_landmark' => trim($result[$i]['area_landmark']),
                    'sector' => trim($result[$i]['sector']),
                    'longitude' => trim($result[$i]['longitude']),
                    'latitude' => trim($result[$i]['latitude']),
                    'gpsaccuracy' => trim($result[$i]['gpsaccuracy']),
                    'qr_code' => trim($result[$i]['qr_code']),
                    'property_pic' => trim($result[$i]['property_pic']),
                    'property_qrcode_pic' => trim($result[$i]['property_qrcode_pic']),
                    'date_updated' => trim($result[$i]['date_updated']),
                    'surveyor_id' => trim($result[$i]['updated_by_user']),
                    'surveyor_fname' => trim($result[$i]['first_name']),
                    'surveyor_lname' => trim($result[$i]['last_name']),
                    'surveyor_mobile' => trim($result[$i]['mobile']),
                    'survey_status' => trim($result[$i]['survey_status']),
                    'connecting_road_type' => trim($result[$i]['connecting_road_type']),
                    'connecting_road_width' => trim($result[$i]['connecting_road_width']),
                    'total_floors' => trim($result[$i]['total_floors']),
                    'total_tenant_owners' => trim($result[$i]['total_tenant_owners']),
                    'total_flats' => trim($result[$i]['total_flats']),
                    'total_blocks' => trim($result[$i]['total_blocks']),
                    'isreject' => trim($result[$i]['isreject']),
                    'is_sync' => trim($result[$i]['is_sync']),
                    'survey_date' => trim($survey_date),
                    'survey_time' => trim($survey_time),
                    'migration_date' => $migration_date,
                    'migration_time' => $migration_time,
                    'remote_server_sync' => $remote_server_sync,
                    'remote_server_sync_datetime' => $remote_server_sync_datetime,
                    'sequence' => $i
                );


                $couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
                $sqlUpdate = "UPDATE property_master_update SET is_replicate = '1'  WHERE p_record_id = '".$p_record_id."'";
                 $db->UpdateQuery($sqlUpdate);
                 fwrite($myfile, $doc_id.";\n");

        }
        
    }   
        
}    
$db->close();
fclose($myfile);
?>
