<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');
$db = new databaseConnection;
$db->setConnection();

$couchdb =  new Couchdb("swmqrcode");
// 23 = 1, 29 = 2, 22
$ward_no = 22;
$sql = "select pid, ward_no, property_pic, property_qrcode_pic from property_master_update WHERE property_qrcode_pic != '' AND ward_no =  '".$ward_no."' AND flatno = '0' order by p_record_id asc LIMIT 500";
$result = $db->runQuery($sql);
$total = count($result);

//print date("Y-m-d H:i:s")."\n";

$ward_directory = "w".$ward_no ;
$directory = "/var/www/html/psc/download/".$ward_directory."/";
$dir_ward = "/var/www/html/psc/download/".$ward_directory;
$dir_property = "/var/www/html/psc/download/".$ward_directory."/property_pic";
$dir_qrcode = "/var/www/html/psc/download/".$ward_directory."/qrcode_pic";
if (!file_exists($directory)) {
   mkdir($dir_ward, 0777);  
   mkdir($dir_property, 0777); 
   mkdir($dir_qrcode, 0777); 
} 

$table_name = "HOUSEHOLD_DATA" ;
//$myfile = fopen("/var/www/html/psc/download/storequery1.sql", "w") or die("Unable to open file!");


for($i=0; $i<$total; $i++) {
    $pid = trim($result[$i]['pid']);
    $ward_no = trim($result[$i]['ward_no']);
    $payload = '["'.$table_name.'", "'.$pid.'", "'.$ward_no.'"]';
    $data = $couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getWPImageByPID?&descending=true&key=");
    
    
    $property_pic = base64_decode($data->rows[0]->value->property_pic);
    $qrcode_pic = base64_decode($data->rows[0]->value->property_qrcode_pic);
     
    
    //$property_pic = base64_decode(trim($result[$i]['property_pic']));
    //$qrcode_pic = base64_decode(trim($result[$i]['property_qrcode_pic']));
    
    //if($result[$i]['property_pic'] != "" ) {
   if($data->rows[0]->value->property_pic != "" ) {
      /* Image generation code for property with  qrcode*/
        $file_name_property = $dir_property."/pic_property_".$result[$i]['pid'];
        $size = getImageSizeFromString($property_pic);
        $ext = substr($size['mime'], 6);
        $img_file_property = $file_name_property.".{$ext}";
        file_put_contents($img_file_property, $property_pic);


        /* Image generation code for qr_code */

        $file_name_qrcode = $dir_qrcode."/pic_qrcode_".$result[$i]['pid'];
        $size = getImageSizeFromString($qrcode_pic);
        $ext = substr($size['mime'], 6);
        $img_file_qrcode = $file_name_qrcode.".{$ext}";
        file_put_contents($img_file_qrcode, $qrcode_pic);

        
        $sqlUpdate = "UPDATE property_master_update SET property_pic = NULL, property_qrcode_pic = NULL,  flatno = '1' WHERE pid = '".$pid."'";
        //fwrite($myfile, $sqlUpdate.";\n");
        $db->UpdateQuery($sqlUpdate);
        
        print $pid."\n";
   }
   
   
}
$db->close();
//fclose($myfile);
//print date("Y-m-d H:i:s")."\n";
?>
