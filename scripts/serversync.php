<?php
include_once ('dbconnect.inc.php');
$db = new databaseConnection;
$db->setConnection();

$ward_no = "22";
$sql_ward_details =  "SELECT *  FROM ajeeve_ward_master WHERE wardNo = '".$ward_no."'";
$rsWard = $db->runQuery($sql_ward_details);
$circle_id = $rsWard[0]['cirlceId'] ; 

$sqlSurvey = "SELECT qr_code, owner_name, flatName, isflat, ward_no, mobile_no, houseno, ";
$sqlSurvey .=  " address_street, area_landmark, longitude, latitude, pid, occupancy_status, building_type " ;
$sqlSurvey .=  " FROM  " ;

$sqlGet = "SELECT  pid, property_pic, property_qrcode_pic FROM property_master_update WHERE date_updated LIKE '%".$audit_date."%' AND ward_no='".$ward."' ";
$result = $db->runQuery($sqlGet);
$total_records = @count($result); 
if(!empty($result))
{
	$dirname = "download/".$audit_date."/WardNo-".$ward;
	
	//if( is_dir($dirname) === false )
	//{
	    
	    
	    mkdir($dirname."/property_pic", 0777, true);
	    mkdir($dirname."/qrcode_pic", 0777, true);
	    for($i=0; $i<$total_records; $i++) {
	        
	        $file_name = $dirname."/property_pic/pic_".$result[$i]['pid'];
	        $property_pic = base64_decode($result[$i]['property_pic']);
		    $size = getImageSizeFromString($property_pic);
		    $ext = substr($size['mime'], 6);
		    $img_file = $file_name.".{$ext}";
		    file_put_contents($img_file, $property_pic);

		    $qrfile_name = $dirname."/qrcode_pic/qrcodepic_".$result[$i]['pid'];
	        $property_qrcode_pic = base64_decode($result[$i]['property_qrcode_pic']);
		    $qrsize = getImageSizeFromString($property_qrcode_pic);
		    $qrext = substr($qrsize['mime'], 6);
		    $qrimg_file = $qrfile_name.".{$qrext}";
		    file_put_contents($qrimg_file, $property_qrcode_pic);
		}
		echo "All Properties Picture has been saved successfully\n";
	//}
	//else
	//{
		//echo "Directory already exists!";
	//}


}
else
{
	echo "No Records Found!";
}
?>
