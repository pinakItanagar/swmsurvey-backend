<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Surveysyncapi extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     * Formula: 
     * GST Amount = GST Inclusive Price * GST Rate /(100 + GST Rate Percentage) 
     * Original Cost = GST Inclusive Price * 100/(100 + GST Rate Percentage)
     */
    
    public function getCircle() {
        $this->load->model('Master_ajevee', 'tblAjeeve'); 
        $host = 'http://65.0.84.113:6002/api/SWMMaster/GetAllCircle';
        $username='patna';
        $password='patna#2020';
        $data = '{ "CCode" : "ORG/00001", "IsAll" : "YES" }';
      
        $ch = curl_init($host);
        $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode("$username:$password")
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        $json = preg_replace('!\\r?\\n!', "", $resp);
        $circleInfo =   json_decode($json);
        /*
        for($i=0;  $i<count($circleInfo); $i++ ) {
            $circle_name = $circleInfo[$i]->CircleName;
            $circle_id = $circleInfo[$i]->CircleId;
            $isActive = $circleInfo[$i]->IsActive;
            $mapped_circle_id = $this->tblAjeeve->getCircleMappedID($circle_name);
            
            $data = array(
                "circleId" => $circle_id,
                "circleName" => $circle_name,
                "isActive" => $isActive,
                "qrapp_circle_id" => $mapped_circle_id,
            );
            $this->tblAjeeve->insertCircleDetails($data);
           
        }*/
        
         echo "<pre>";
         print_r($circleInfo);
      
    }
   
    public function getWardCircle() {
        $this->load->model('Master_ajevee', 'tblAjeeve'); 
        $host = 'http://65.0.84.113:6002/api/SWMMaster/GetWardByCircle';
        $username='patna';
        $password='patna#2020';
        
        $circles = $this->tblAjeeve->getAllCircleAJV();
        
       // foreach ($circles as $circle) {
           $data = '{ "CircleId" : "1", "IsAll" : "YES" }';
            
          

            $ch = curl_init($host);
            $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '. base64_encode("$username:$password")
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close($ch);

            $json = preg_replace('!\\r?\\n!', "", $resp);
            $wardInfo =   json_decode($json);
      //  }
           
              echo "<pre>";
             print_r($wardInfo);
    }

  public function getAllOwner() {
        $this->load->model('Master_ajevee', 'tblAjeeve'); 
        $host = 'http://65.0.84.113:6002/api/SWMMaster/GetAllOwnerType';
        $username='patna';
        $password='patna#2020';
        
      
        
       // foreach ($circles as $circle) {
           $data = '{ "CCode" : "ORG/00001" }';
            
          

            $ch = curl_init($host);
            $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '. base64_encode("$username:$password")
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close($ch);

            $json = preg_replace('!\\r?\\n!', "", $resp);
            $ownerInfo =   json_decode($json);
      //  }
           
              echo "<pre>";
             print_r($ownerInfo);
    }
    
    
    
    public function getAllPropertyType() {
        $this->load->model('Master_ajevee', 'tblAjeeve'); 
        $host = 'http://65.0.84.113:6002/api/SWMMaster/GetAllPropertyType';
        $username='patna';
        $password='patna#2020';
        
      
        
       // foreach ($circles as $circle) {
           $data = '{ "CCode" : "ORG/00001" }';
            
          

            $ch = curl_init($host);
            $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '. base64_encode("$username:$password")
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close($ch);

            $json = preg_replace('!\\r?\\n!', "", $resp);
            $ownerInfo =   json_decode($json);
      //  }
           
              echo "<pre>";
             print_r($ownerInfo);
    }
    
    public function sendHouseHold() {
          //  22B, 22C , 25, 22, 22A, 17, 18, 26, 29, 54, 24,13, 21, 1, 2, 3, 
         $ward_no = '14';
         $ward_id = '14' ;
         $this->load->model('Master_ajevee', 'tblAjeeve'); 
         $ward = $this->tblAjeeve->getWardDetails($ward_no);
         $circle_id = $ward->cirlceId ;
         $houseHoldList = $this->tblAjeeve->getWardSurveyDetails($ward_no);
         $host = 'http://65.0.84.113:6002/api/SWMMaster/AddHouseHold';
         $username='patna';
         $password='patna#2020';
         $ccode = "ORG/00001";
         $i = 0;
         $myslno = 1;
         //$myfile = fopen("/var/www/html/psc/download/sync1.log", "w") or die("Unable to open file!");

         //echo "<pre>";
         //print_r($houseHoldList);
         //die();
         $file_name = "/var/www/html/psc/download/failed_transmission_w".$ward_no.".log" ;
         $myfile = fopen($file_name, "w") or die("Unable to open file!");

         foreach ($houseHoldList as $row) {
             
          
           
             
                if($row->isflat == "1") {
                     $owner_name = trim($row->flatName);
                     $isflat = "1";
                 } else {
                      $owner_name = trim($row->owner_name); 
                      $isflat = "0";
                 }
                 
                 $temp_street_address = trim($row->address_street);
                 $temp_houseno = trim($row->houseno);
                 if(preg_match("/^\d{6}/", $temp_street_address) ==  "1") {
                      $pin = $temp_street_address;
                      $address = trim($row->houseno)." ".trim($row->area_landmark);
                 } elseif(preg_match("/^\d{6}/", $temp_houseno) ==  "1") {
                      $pin = $temp_houseno;
                      $address = trim($row->address_street)." ".trim($row->area_landmark);
                 } else {
                       $pin = "N/A";
                       $address = trim($row->houseno)." ".trim($row->address_street)." ".trim($row->area_landmark);
                 }
                 
                 
                 if($row->occupancy_status == "Self") {
                     $ownerType = "1" ;
                 } elseif ($row->occupancy_status == "Self-Tenants") {
                     $ownerType = "2" ;
                 } elseif ($row->occupancy_status == "Tenants") {
                     $ownerType = "3" ;
                 } else {
                     $ownerType = "0" ;
                 }
                 
                 
                 
                 if($row->building_type == "BT01") {
                     $propertyTypeId = "2" ;
                 } elseif($row->building_type == "BT02") {
                     $propertyTypeId = "4" ;
                 } elseif($row->building_type == "BT03") {
                     $propertyTypeId = "3" ;
                 } elseif($row->building_type == "BT04") {
                     $propertyTypeId = "1" ;
                 } elseif($row->building_type == "BT06") {
                     $propertyTypeId = "6" ;
                 } else {
                    $propertyTypeId = "0" ; 
                 }
                 
                 $identityNo = "N/A";
                 $circleID = trim($circle_id);
                 $pid = trim($row->pid);
                 $isActive = 1;
                 $houseID = 0;
                 $sectorID = 0;
                 
                 if($row->mobile_no != "") {
                     $mobile_no = trim($row->mobile_no);
                 }  else {
                     $mobile_no = "N/A";
                 }
                 
                 $data = '[{ "HouseId" : '.$houseID.', "UHouseId" : "'.trim($row->qr_code).'", "OwnerName" : "'.$owner_name.'", "Address" : "'.trim($address).'", '
                         . '"WardNo" : "'.trim($ward_id).'", "ContactNo" : "'.trim($mobile_no).'", "PinCode" : "'.$pin.'", '
                         . '"Lat" : "'.trim($row->latitude).'" , "Lng" : "'.trim($row->longitude).'", "IsActive" : '.$isActive.', '
                         . '"UserId" : "'.$isflat.'", "OwnerType" : "'.$ownerType.'", "PropertyTypeId" : "'.$propertyTypeId.'", '
                         . '"CircleId" : "'.$circleID.'",  "CCode" : "'.$ccode.'",  "IdentityNo" : "'.$identityNo.'" ,  "IdentityTypeId" : "0", '
                         . ' "CollectionType" : "1",  "SectorId" : '.$sectorID.',  "PropertyId" : "'.$pid.'" }]';
                 
                    $ch = curl_init($host);
                    $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Basic '. base64_encode("$username:$password")
                    );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $resp = curl_exec($ch);
                    curl_close($ch);
                    print $resp."\n";
                    $responseData =  json_decode($resp);
                  //  echo $responseData->Result;
                    $dateTime = date("Y-m-d H:i:s");
                    if(isset($responseData->Result)) {
                         if($responseData->Result == '3') {
                            $qr_code = trim($row->qr_code);
                            $status = 1;
                            $dbdata = array(
                                 'is_sync' => $status,
                                 'sync_date_time' => $dateTime
                             );

                            echo $myslno." - ". $pid. "</br>";
                           
                            // $this->db->where('pid', $pid);
                            // $this->db->update('property_master_update', $dbdata);  
                            $myslno++;
                        }
                    } else {
                           $qr_code = trim($row->qr_code);
                            $status = 0;
                            $dbdata = array(
                                 'is_sync' => $status,
                                 'sync_date_time' => $dateTime
                             );

                             echo "<h2>".$row->qr_code."</h2><br>";
                             fwrite($myfile,$row->qr_code."\n");
                            // $this->db->where('qr_code', $qr_code);
                            // $this->db->update('property_master_update', $dbdata);  
                    }
                  
                  
                 
         }
         
         fclose($myfile);
    }
    
    
    
    public function sendHouseHold2() {
          //  22B, 22C , 25, 22, 22A, 17, 18, 26, 29, 54, 24,13, 21, 1, 2, 3, 
         $ward_no = '7';
         $ward_id = '7' ;
         $this->load->model('Master_ajevee', 'tblAjeeve'); 
         $ward = $this->tblAjeeve->getWardDetails($ward_no);
         $circle_id = $ward->cirlceId ;
         $houseHoldList = $this->tblAjeeve->getWardSurveyDetails($ward_no);
         $host = 'http://65.0.84.113:6002/api/SWMMaster/AddHouseHold';
         $username='patna';
         $password='patna#2020';
         $ccode = "ORG/00001";
         $i = 0;
         $myslno = 1;
         //$myfile = fopen("/var/www/html/psc/download/sync1.log", "w") or die("Unable to open file!");

         //echo "<pre>";
         //print_r($houseHoldList);
         //die();
         $file_name = "/var/www/html/psc/download/failed_transmission_w".$ward_no.".log" ;
         $myfile = fopen($file_name, "w") or die("Unable to open file!");
         $i = 0;
         foreach ($houseHoldList as $row) {
             
          
               if($i < 10 ) {
             
                if($row->isflat == "1") {
                     $owner_name = trim($row->flatName);
                     $isflat = "1";
                 } else {
                      $owner_name = trim($row->owner_name); 
                      $isflat = "0";
                 }
                 
                 $temp_street_address = trim($row->address_street);
                 $temp_houseno = trim($row->houseno);
                 if(preg_match("/^\d{6}/", $temp_street_address) ==  "1") {
                      $pin = $temp_street_address;
                      $address = trim($row->houseno)." ".trim($row->area_landmark);
                 } elseif(preg_match("/^\d{6}/", $temp_houseno) ==  "1") {
                      $pin = $temp_houseno;
                      $address = trim($row->address_street)." ".trim($row->area_landmark);
                 } else {
                       $pin = "N/A";
                       $address = trim($row->houseno)." ".trim($row->address_street)." ".trim($row->area_landmark);
                 }
                 
                 
                 if($row->occupancy_status == "Self") {
                     $ownerType = "1" ;
                 } elseif ($row->occupancy_status == "Self-Tenants") {
                     $ownerType = "2" ;
                 } elseif ($row->occupancy_status == "Tenants") {
                     $ownerType = "3" ;
                 } else {
                     $ownerType = "0" ;
                 }
                 
                 
                 
                 if($row->building_type == "BT01") {
                     $propertyTypeId = "2" ;
                 } elseif($row->building_type == "BT02") {
                     $propertyTypeId = "4" ;
                 } elseif($row->building_type == "BT03") {
                     $propertyTypeId = "3" ;
                 } elseif($row->building_type == "BT04") {
                     $propertyTypeId = "1" ;
                 } elseif($row->building_type == "BT06") {
                     $propertyTypeId = "6" ;
                 } else {
                    $propertyTypeId = "0" ; 
                 }
                 
                 $identityNo = "N/A";
                 $circleID = trim($circle_id);
                 $pid = trim($row->pid);
                 $isActive = 1;
                 $houseID = 0;
                 $sectorID = 0;
                 
                 if($row->mobile_no != "") {
                     $mobile_no = trim($row->mobile_no);
                 }  else {
                     $mobile_no = "N/A";
                 }
                 
                 $data = '{ "HouseId" : '.$houseID.', "UHouseId" : "'.trim($row->qr_code).'", "OwnerName" : "'.$owner_name.'", "Address" : "'.trim($address).'", '
                         . '"WardNo" : "'.trim($ward_id).'", "ContactNo" : "'.trim($mobile_no).'", "PinCode" : "'.$pin.'", '
                         . '"Lat" : "'.trim($row->latitude).'" , "Lng" : "'.trim($row->longitude).'", "IsActive" : '.$isActive.', '
                         . '"UserId" : "'.$isflat.'", "OwnerType" : "'.$ownerType.'", "PropertyTypeId" : "'.$propertyTypeId.'", '
                         . '"CircleId" : "'.$circleID.'",  "CCode" : "'.$ccode.'",  "IdentityNo" : "'.$identityNo.'" ,  "IdentityTypeId" : "0", '
                         . ' "CollectionType" : "1",  "SectorId" : '.$sectorID.',  "PropertyId" : "'.$pid.'" }';
                 
                    $ch = curl_init($host);
                    $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Basic '. base64_encode("$username:$password")
                    );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $resp = curl_exec($ch);
                    curl_close($ch);
                    print $resp."\n";
                    $responseData =  json_decode($resp);
                  //  echo $responseData->Result;
                    $dateTime = date("Y-m-d H:i:s");
                    if(isset($responseData->Result)) {
                         if($responseData->Result == '3') {
                            $qr_code = trim($row->qr_code);
                            $status = 1;
                            $dbdata = array(
                                 'is_sync' => $status,
                                 'sync_date_time' => $dateTime
                             );

                            echo $myslno." - ". $pid. "</br>";
                           
                            // $this->db->where('pid', $pid);
                            // $this->db->update('property_master_update', $dbdata);  
                            $myslno++;
                        }
                    } else {
                           $qr_code = trim($row->qr_code);
                            $status = 0;
                            $dbdata = array(
                                 'is_sync' => $status,
                                 'sync_date_time' => $dateTime
                             );

                             echo "<h2>".$row->qr_code."</h2><br>";
                             fwrite($myfile,$row->qr_code."\n");
                            // $this->db->where('qr_code', $qr_code);
                            // $this->db->update('property_master_update', $dbdata);  
                    }
                  
               }  else {
                   break;
               }   
               $i++;  
         }
         
         fclose($myfile);
    }
    
    
     public function insertWardInfo() {
         // 1, 2, 3, 5, 6 7, 8, 10 , 11, 12, 13, 14, 15, 17, 18, 19,  20,  21, 22, 22A, 22B, 22C , 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34 36, 38, 43, 48, 54, 59, 67, 35

         // Retry : 3, 1
         // 44, 45,55, 52, 56, 46, 47, 51, 45, 68, 58, 16, 66, 50, 71, 53, 42, 45, 58, 64, 57, 59, 65, 39, 72, 62, 37
         // 60, 61 , 40, 41, 9, 69, 70
     	 // SELECT COUNT(p_record_id) FROM `property_master_update` WHERE ward_no = '21' 

     	 //23,22, 34, 35,33

         $ward_no = '26';
         $ward_id = '29' ;
         $this->load->model('Master_ajevee', 'tblAjeeve'); 
         $ward = $this->tblAjeeve->getWardDetails($ward_no);
         
         $circle_id = $ward->cirlceId ;
         //$ward_id = $ward->wardId ;
         //$survey = $this->tblAjeeve->getWardSurveyDetails23();
         $survey = $this->tblAjeeve->getWardSurveyDetails($ward_no);
         $host = 'http://65.0.84.113:6002/api/TMaster/InsertBulkHouseInfo';
         $username='patna';
         $password='patna#2020';
         $ccode = "ORG/00001";
         $payload = "";
         $i = 50;
         
    
      
        foreach ($survey as $row) {
            
           
             
          
                    
                 if($row->isflat == "1") {
                     $owner_name = trim($row->flatName);
                     $isflat = "1";
                 } else {
                      $owner_name = trim($row->owner_name); 
                      $isflat = "0";
                 }

                 if(($row->flatName == "") && ($row->owner_name == "")) {
                    $owner_name = "N/A" ;
                 }
                 
                 $temp_street_address = trim($row->address_street);
                 $temp_houseno = trim($row->houseno);
                 if(preg_match("/^\d{6}/", $temp_street_address) ==  "1") {
                      $pin = $temp_street_address;
                      if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                         $address = trim($row->area_landmark);
                      } else {
                          $address = trim($row->houseno)." ".trim($row->area_landmark); 
                      }
                 } elseif(preg_match("/^\d{6}/", $temp_houseno) ==  "1") {
                      $pin = $temp_houseno;
                      
                      if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                         $new_house = "";
                      } else {
                         $new_house =  $row->houseno;
                      }
                      $address = trim($row->address_street)." ".trim($new_house);
                 } else {
                       $pin = "N/A";
                       $address = trim($row->houseno)." ".trim($row->address_street)." ".trim($row->area_landmark);
                 }
                 
                 
                 if($row->occupancy_status == "Self") {
                     $ownerType = "1" ;
                 } elseif ($row->occupancy_status == "Self-Tenants") {
                     $ownerType = "2" ;
                 } elseif ($row->occupancy_status == "Tenants") {
                     $ownerType = "3" ;
                 } else {
                     $ownerType = "0" ;
                 }
                 
                 
                 
                 if($row->building_type == "BT01") {
                     $propertyTypeId = "2" ;
                 } elseif($row->building_type == "BT02") {
                     $propertyTypeId = "4" ;
                 } elseif($row->building_type == "BT03") {
                     $propertyTypeId = "3" ;
                 } elseif($row->building_type == "BT04") {
                     $propertyTypeId = "1" ;
                 } elseif($row->building_type == "BT06") {
                     $propertyTypeId = "6" ;
                 } else {
                    $propertyTypeId = "0" ; 
                 }
                 
                 $identityNo = "N/A";
                 $circleID = trim($circle_id);
                 $pid = trim($row->pid);
                 $isActive = 1;
                 $houseID = 0;
                 $sectorID = 0;
                 
                 if($row->mobile_no != "") {
                     $mobile_no = trim($row->mobile_no);
                 }  else {
                     $mobile_no = "N/A";
                 }
                 
                 if ((preg_match("/PID-/i", $pin)) || (preg_match("/P/i", $pin)) || (preg_match("/\D/i", $pin))){
                     
                     
                     
                     $arr_pin = str_split($pin);
                     //echo "<pre>";
                     //print_r($arr_pin);
                     if(count($arr_pin)> 6) {
                        $newpin = $arr_pin[0].$arr_pin[1].$arr_pin[2].$arr_pin[3].$arr_pin[4].$arr_pin[5];
                        $pin = $newpin;
                        //echo $row->qr_code." -  OLD PIN ".$pin." -  NEW PIN ".$newpin."<br>";
                        
                     }
                 
                   
                }
                
               
                 
                 $data = '{ "HouseId" : '.$houseID.', "UHouseId" : "'.trim($row->qr_code).'", "OwnerName" : "'.$owner_name.'", "Address" : "'.trim($address).'", '
                         . '"WardNo" : "'.trim($ward_id).'", "ContactNo" : "'.trim($mobile_no).'", "PinCode" : "'.$pin.'", '
                         . '"Lat" : "'.trim($row->latitude).'" , "Lng" : "'.trim($row->longitude).'", "IsActive" : '.$isActive.', '
                         . '"UserId" : "'.$isflat.'", "OwnerType" : "'.$ownerType.'", "PropertyTypeId" : "'.$propertyTypeId.'", '
                         . '"CircleId" : "'.$circleID.'",  "CCode" : "'.$ccode.'",  "IdentityNo" : "'.$identityNo.'" ,  "IdentityTypeId" : "0", '
                         . ' "CollectionType" : "1",  "SectorId" : '.$sectorID.',  "PropertyId" : "'.$pid.'" }';
                  
                  $payload = $payload.$data.", ";
                  
               
                 
                   $qr_code = trim($row->qr_code);
                   $status = 1;
                   
         
             
        }
        
       
     // die();
       $new_payload = substr($payload, 0, -2);
       $px =  "[".$new_payload."]";
        
     
       echo $px;
       die();
     
        $ch = curl_init($host);
        $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode("$username:$password")
        );
        
       // echo "<pre>";
        //print_r($headers);
        //die();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $px);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close($ch);
        //echo $resp;
        
         
     }
     
     
     
     function cleanJsonData() {
         
         $filename = base_url("download/myjsondata.txt");
         $data = file_get_contents($filename);
         
         $dataArray =  json_decode($data);
         
         for($i=0; $i<count($dataArray); $i++) {
             
            if (preg_match("/PID-/i", $dataArray[$i]->PinCode)) {
                //echo $dataArray[$i]->UHouseId." - ".$dataArray[$i]->PinCode."<br>";
                $pincode_array =  explode(" ", $dataArray[$i]->PinCode);
                $pincode = trim($pincode_array[0]);
                $old_pid = trim($pincode_array[1]);
                $address = $dataArray[$i]->Address." ".$old_pid;
                $dataArray[$i]->PinCode = $pincode;
                $dataArray[$i]->Address = $address;
            }
         }
         
         //echo "<pre>";
        // print_r($dataArray);
         
         echo json_encode($dataArray);
         
     }


     public function insertWardInfoFromTextFile() {
        // 1, 2, 3, 5, 6 7, 8, 10 , 11, 12, 13, 14, 15, 17, 18, 19,  20,  21, 22, 22A, 22B, 22C , 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34 36, 38, 43, 48, 54, 59, 67, 35
        $ward_no = '23';
        $ward_id = '26' ;
        $this->load->model('Master_ajevee', 'tblAjeeve'); 
        $ward = $this->tblAjeeve->getWardDetails($ward_no);
        $ccode = "ORG/00001";
        $payload = "";
        $circle_id = $ward->cirlceId ;
        //$ward_id = $ward->wardId ;
        //$survey = $this->tblAjeeve->getWardSurveyDetails($ward_no);
        //$survey = $this->tblAjeeve->getWardSurveyDetails($ward_no);

        $handle = fopen("upload/qrcode_list.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $qrcode = $line;
                $row =  $this->tblAjeeve->getIndividualSurveyDetails($qrcode, $ward_no);

                
                

                if($row->isflat == "1") {
                    $owner_name = trim($row->flatName);
                    $isflat = "1";
                } else {
                     $owner_name = trim($row->owner_name); 
                     $isflat = "0";
                }
                
                $temp_street_address = trim($row->address_street);
                $temp_houseno = trim($row->houseno);
                if(preg_match("/^\d{6}/", $temp_street_address) ==  "1") {
                     $pin = $temp_street_address;
                     if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                        $address = trim($row->area_landmark);
                     } else {
                         $address = trim($row->houseno)." ".trim($row->area_landmark); 
                     }
                } elseif(preg_match("/^\d{6}/", $temp_houseno) ==  "1") {
                     $pin = $temp_houseno;
                     
                     if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                        $new_house = "";
                     } else {
                        $new_house =  $row->houseno;
                     }
                     $address = trim($row->address_street)." ".trim($new_house);
                } else {
                      $pin = "N/A";
                      $address = trim($row->houseno)." ".trim($row->address_street)." ".trim($row->area_landmark);
                }
                
                
                if($row->occupancy_status == "Self") {
                    $ownerType = "1" ;
                } elseif ($row->occupancy_status == "Self-Tenants") {
                    $ownerType = "2" ;
                } elseif ($row->occupancy_status == "Tenants") {
                    $ownerType = "3" ;
                } else {
                    $ownerType = "0" ;
                }
                
                
                
                if($row->building_type == "BT01") {
                    $propertyTypeId = "2" ;
                } elseif($row->building_type == "BT02") {
                    $propertyTypeId = "4" ;
                } elseif($row->building_type == "BT03") {
                    $propertyTypeId = "3" ;
                } elseif($row->building_type == "BT04") {
                    $propertyTypeId = "1" ;
                } elseif($row->building_type == "BT06") {
                    $propertyTypeId = "6" ;
                } else {
                   $propertyTypeId = "0" ; 
                }
                
                $identityNo = "N/A";
                $circleID = trim($circle_id);
                $pid = trim($row->pid);
                $isActive = 1;
                $houseID = 0;
                $sectorID = 0;
                
                if($row->mobile_no != "") {
                    $mobile_no = trim($row->mobile_no);
                }  else {
                    $mobile_no = "N/A";
                }
                
                if ((preg_match("/PID-/i", $pin)) || (preg_match("/P/i", $pin)) || (preg_match("/\D/i", $pin))){
                    
                    
                    
                    $arr_pin = str_split($pin);
                  
                    if(count($arr_pin)> 6) {
                       $newpin = $arr_pin[0].$arr_pin[1].$arr_pin[2].$arr_pin[3].$arr_pin[4].$arr_pin[5];
                       $pin = $newpin;
                       //echo $row->qr_code." -  OLD PIN ".$pin." -  NEW PIN ".$newpin."<br>";
                       
                    }
                   
                
                  
               }
               
              
                
                $data = '{ "HouseId" : '.$houseID.', "UHouseId" : "'.trim($row->qr_code).'", "OwnerName" : "'.$owner_name.'", "Address" : "'.trim($address).'", '
                        . '"WardNo" : "'.trim($ward_id).'", "ContactNo" : "'.trim($mobile_no).'", "PinCode" : "'.$pin.'", '
                        . '"Lat" : "'.trim($row->latitude).'" , "Lng" : "'.trim($row->longitude).'", "IsActive" : '.$isActive.', '
                        . '"UserId" : "'.$isflat.'", "OwnerType" : "'.$ownerType.'", "PropertyTypeId" : "'.$propertyTypeId.'", '
                        . '"CircleId" : "'.$circleID.'",  "CCode" : "'.$ccode.'",  "IdentityNo" : "'.$identityNo.'" ,  "IdentityTypeId" : "0", '
                        . ' "CollectionType" : "1",  "SectorId" : '.$sectorID.',  "PropertyId" : "'.$pid.'" }';
                 
                 $payload = $payload.$data.", ";
                 
                // echo $data."<br>";
                // $payload .= $payload;
                
                  $qr_code = trim($row->qr_code);
                  $status = 1;
                 // die();
             
            }

            fclose($handle);
        } 
        $new_payload = substr($payload, 0, -2);
        $px =  "[".$new_payload."]";

        echo $px;
        die();
       
        
    }



    public function insertWardInfoByDate() {
         // 1, 2, 3, 5, 6 7, 8, 10 , 11, 12, 13, 14, 15, 17, 18, 19,  20,  21, 22, 22A, 22B, 22C , 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34 36, 38, 43, 48, 54, 59, 67, 35

         // Retry : 3, 1
         // 44, 45,55, 52, 56, 46, 47, 51, 45, 68, 58, 16, 66, 50, 71, 53, 42, 45, 58, 64, 57, 59, 65, 39, 72, 62, 37
         // 60, 61 , 40, 41, 9, 69, 70

         //http://164.52.207.234/psc/surveysyncapi/insertWardInfoByDate

         $ward_no = '40';
         $ward_id = '43' ;
         $this->load->model('Master_ajevee', 'tblAjeeve'); 
         $ward = $this->tblAjeeve->getWardDetails($ward_no);
         
         $circle_id = $ward->cirlceId ;
        
         $survey = $this->tblAjeeve->getWardSurveyDetailsByDate($ward_no, "2021-01-01 00:00:00");
         $host = 'http://65.0.84.113:6002/api/TMaster/InsertBulkHouseInfo';
         $username='patna';
         $password='patna#2020';
         $ccode = "ORG/00001";
         $payload = "";
         $i = 50;
         
    
      
        foreach ($survey as $row) {
            
           
             
          
                    
                 if($row->isflat == "1") {
                     $owner_name = trim($row->flatName);
                     $isflat = "1";
                 } else {
                      $owner_name = trim($row->owner_name); 
                      $isflat = "0";
                 }

                 if(($row->flatName == "") && ($row->owner_name == "")) {
                    $owner_name = "N/A" ;
                 }
                 
                 $temp_street_address = trim($row->address_street);
                 $temp_houseno = trim($row->houseno);
                 if(preg_match("/^\d{6}/", $temp_street_address) ==  "1") {
                      $pin = $temp_street_address;
                      if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                         $address = trim($row->area_landmark);
                      } else {
                          $address = trim($row->houseno)." ".trim($row->area_landmark); 
                      }
                 } elseif(preg_match("/^\d{6}/", $temp_houseno) ==  "1") {
                      $pin = $temp_houseno;
                      
                      if( ((strtoupper($row->houseno) == "NA")) || (strtoupper($row->houseno) == "N/A")) { 
                         $new_house = "";
                      } else {
                         $new_house =  $row->houseno;
                      }
                      $address = trim($row->address_street)." ".trim($new_house);
                 } else {
                       $pin = "N/A";
                       $address = trim($row->houseno)." ".trim($row->address_street)." ".trim($row->area_landmark);
                 }
                 
                 
                 if($row->occupancy_status == "Self") {
                     $ownerType = "1" ;
                 } elseif ($row->occupancy_status == "Self-Tenants") {
                     $ownerType = "2" ;
                 } elseif ($row->occupancy_status == "Tenants") {
                     $ownerType = "3" ;
                 } else {
                     $ownerType = "0" ;
                 }
                 
                 
                 
                 if($row->building_type == "BT01") {
                     $propertyTypeId = "2" ;
                 } elseif($row->building_type == "BT02") {
                     $propertyTypeId = "4" ;
                 } elseif($row->building_type == "BT03") {
                     $propertyTypeId = "3" ;
                 } elseif($row->building_type == "BT04") {
                     $propertyTypeId = "1" ;
                 } elseif($row->building_type == "BT06") {
                     $propertyTypeId = "6" ;
                 } else {
                    $propertyTypeId = "0" ; 
                 }
                 
                 $identityNo = "N/A";
                 $circleID = trim($circle_id);
                 $pid = trim($row->pid);
                 $isActive = 1;
                 $houseID = 0;
                 $sectorID = 0;
                 
                 if($row->mobile_no != "") {
                     $mobile_no = trim($row->mobile_no);
                 }  else {
                     $mobile_no = "N/A";
                 }
                 
                 if ((preg_match("/PID-/i", $pin)) || (preg_match("/P/i", $pin)) || (preg_match("/\D/i", $pin))){
                     
                     
                     
                     $arr_pin = str_split($pin);
                     //echo "<pre>";
                     //print_r($arr_pin);
                     if(count($arr_pin)> 6) {
                        $newpin = $arr_pin[0].$arr_pin[1].$arr_pin[2].$arr_pin[3].$arr_pin[4].$arr_pin[5];
                        $pin = $newpin;
                        //echo $row->qr_code." -  OLD PIN ".$pin." -  NEW PIN ".$newpin."<br>";
                        
                     }
                 
                   
                }
                
               
                 
                 $data = '{ "HouseId" : '.$houseID.', "UHouseId" : "'.trim($row->qr_code).'", "OwnerName" : "'.$owner_name.'", "Address" : "'.trim($address).'", '
                         . '"WardNo" : "'.trim($ward_id).'", "ContactNo" : "'.trim($mobile_no).'", "PinCode" : "'.$pin.'", '
                         . '"Lat" : "'.trim($row->latitude).'" , "Lng" : "'.trim($row->longitude).'", "IsActive" : '.$isActive.', '
                         . '"UserId" : "'.$isflat.'", "OwnerType" : "'.$ownerType.'", "PropertyTypeId" : "'.$propertyTypeId.'", '
                         . '"CircleId" : "'.$circleID.'",  "CCode" : "'.$ccode.'",  "IdentityNo" : "'.$identityNo.'" ,  "IdentityTypeId" : "0", '
                         . ' "CollectionType" : "1",  "SectorId" : '.$sectorID.',  "PropertyId" : "'.$pid.'" }';
                  
                  $payload = $payload.$data.", ";
                  
               
                 
                   $qr_code = trim($row->qr_code);
                   $status = 1;
                   
         
             
        }
        
       
     // die();
       $new_payload = substr($payload, 0, -2);
       $px =  "[".$new_payload."]";
        
     
       echo $px;
       die();
     
      
         
     }
     
     
   

}
