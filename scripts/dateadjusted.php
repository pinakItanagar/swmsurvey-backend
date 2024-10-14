<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
$db = new databaseConnection;
$db->setConnection();





$sql = "SELECT * FROM temp_survey WHERE is_adjusted  = '0' and install_date > '2021-07-04'  order by id ASC" ;
$rs = $dblocal->runQuery($sql);  
$total = count($rs);
//$total = 5;


function randomDate($start_date, $end_date)
{
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d', $val);
}

for($i=0; $i < $total; $i++) {
   //$sql_search = "SELECT id, qr_code FROM temp_survey WHERE qr_code =  '".$rs[$i]['qr_code']."'";
   //$result = $dbremote->runQuery($sql_search);  
   
   $adjusted_date = randomDate("2021-06-01", "2021-06-14" );
  


   //if( trim($result[0]['id']) == trim($rs[$i]['qr_code']) ) {
  /*
     $sqlInsert = "update  temp_survey SET " ;
     $sqlInsert .= " adjusted_date = '".trim($rs[$i]['circle'])."', " ;
     $sqlInsert .= " is_adjusted = '1' WHERE  id = '" .$result[0]['id']."'";
  
    // $dbremote->InsertQuery($sqlInsert);  
   */  


     $sqlupdate = " Update temp_survey SET " ;
     $sqlupdate .= " adjusted_date = '".trim($adjusted_date)."', is_adjusted = '1' WHERE qr_code = '".$rs[$i]['qr_code']."'" ;
     $dblocal->UpdateQuery($sqlupdate);  



     print $sqlupdate."\n";

  // }
}

$dblocal->close();

?>