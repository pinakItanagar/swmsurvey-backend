<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Interserverapi extends CI_Controller {

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
   
    public function login() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        /*
        echo "<pre>";
        print_r($row);
        die();*/
      
        
         if($row) { 
            $user_data = array(
               'app_user_id' => $row->userId,
               'app_user_fname' => ucwords(strtolower($row->first_name)),
               'app_user_lname' => ucwords(strtolower($row->last_name)),
               'app_user_mobile' => $row->mobile,
               'app_user_ward_id' => $row->wardId,
               'app_user_ward_no' => $row->ward_no,
               'app_user_circle_id' => $row->circle_id,
               'app_user_circle_name' => $row->circle_name             
             );   
            $response = json_encode($user_data);
         } else {
            
            $response = "";        
        }
        
        echo $response;
    }

   public function propertylist() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $property = $query->result();
      
       
     
        
         if($property) { 
            $properties = array();  
            foreach($property as $row)  {
                
                if($row->pid ==  "" ) {
                    $pid = "W".trim($row->ward_no)."000".$row->record_id."R".date("YmdHis");
                } else {
                    $pid = $row->pid;  
                }
                    
                
                $property =  array(
                    "record_id" => $row->record_id ,
                    "pid" => $pid ,
                    "owner_name" => $row->owner_name ,
                    "guardian_name" => $row->guardian_name ,
                    "building_type" => $row->building_type ,
                    "building_type_name" => $row->building_type_name ,
                    "address" => $row->address ,
                    "mobile_no" => $row->mobile_no ,
                    "ward_no" => $row->ward_no ,
                    "no_of_properties" => $row->no_of_properties ,
                    "occupancy_status" => $row->occupancy_status ,
                    "property_type" => $row->property_type
                );
                
                array_push($properties, $property) ;      
            }
           
            $response = json_encode($properties);
         } else {
            
            $response = "";        
        }
        
        echo $response;
    }
    
    
    public function totalAssigned() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        
         if($row) { 
             $data = array(
               'total_assigned' => $row->total_assigned         
             );   
             $response = json_encode($data);
         } else {
            
            $response = "";        
        }
        
        echo $response;
    }
    
    
     public function totalPending() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        
         if($row) { 
             $data = array(
               'total_pending' => $row->total_pending         
             );   
             $response = json_encode($data);
         } else {
            
            $response = "";        
        }
        
        echo $response;
    }
    
    
    public function totalDone() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        
         if($row) { 
             $data = array(
               'total_done' => $row->total_done         
             );   
             $response = json_encode($data);
         } else {
            
            $response = "";        
        }
        
        echo $response;
    }
    
    
    public function isDuplicate() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        
         if($row) { 
             $data = array(
               'pid' => $row->pid         
             );   
             $response = json_encode($data);
         } else {
            
            $data = array(
               'pid' => "0"         
             );   
             $response = json_encode($data);    
        }
        
        echo $response;
    }
    
    
    public function insertNewAppartment() {
       $sql = $_POST['sql']; 
       $rs = $this->db->query($sql); 
       $response = json_encode($rs);    
       echo $response;
    }
    
    
    public function verifyInsert() {
        $sql = $_POST['sql']; 
        $query = $this->db->query($sql);
        $row = $query->row(0);
        
         if($row) { 
             
             if($row->property_pic ==  "") {
                $property_pic = "0"; 
             } else {
                $property_pic = "1";   
             }
             
             if($row->property_qrcode_pic ==  "") {
                $property_qrcode_pic = "0"; 
             } else {
                $property_qrcode_pic = "1";   
             }
             
             $data = array(
               'pid' => $row->pid,
               'longitude' =>  $row->longitude,
               'latitude' =>  $row->latitude,
               'gpsaccuracy' =>  $row->gpsaccuracy,  
               'qr_code' =>  $row->qr_code,  
               'property_pic' =>  $property_pic,
               'property_qrcode_pic' =>  $property_qrcode_pic  
             );   
             $response = json_encode($data);
         } else {
            
              $data = array(
               'pid' => "0",
               'longitude' =>  "",
               'latitude' =>  "",
               'gpsaccuracy' =>  "", 
               'qr_code' =>  "",
               'property_pic' =>  "",
               'property_qrcode_pic' =>  ""
             );   
             $response = json_encode($data);   
        }
        
        echo $response;
    }
    
    
    public function saveimage() {
        $ward_no = $_POST['ward_no']; 
        $pid = $_POST['pid']; 
        $property_pic = $_POST['property_pic'];
        $property_qrcode_pic = $_POST['property_qrcode_pic'];
        
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
        
        $propertyPic = base64_decode($property_pic);
        $qrcode_pic = base64_decode($property_qrcode_pic);
        
        $file_name_property = $dir_property."/pic_property_".$pid;
        $size = getImageSizeFromString($propertyPic);
        $ext = substr($size['mime'], 6);
        $img_file_property = $file_name_property.".{$ext}";
        file_put_contents($img_file_property, $propertyPic);


        /* Image generation code for qr_code */

        $file_name_qrcode = $dir_qrcode."/pic_qrcode_".$pid;
        $size = getImageSizeFromString($qrcode_pic);
        $ext = substr($size['mime'], 6);
        $img_file_qrcode = $file_name_qrcode.".{$ext}";
        file_put_contents($img_file_qrcode, $qrcode_pic);


      
    }

    public function saveDenialCaseImage() {
        $ward_no = $_POST['ward_no']; 
        $reference_no = $_POST['reference_no']; 
        $property_pic = $_POST['property_pic'];
       
        
        $ward_directory = "w".$ward_no ;
        $directory = "/var/www/html/psc/download/".$ward_directory."/";
        $dir_ward = "/var/www/html/psc/download/".$ward_directory;
      
        
        if (!file_exists($directory)) {
           mkdir($dir_ward, 0777);  
        } 
        
        $propertyPic = base64_decode($property_pic);
       
        
        $file_name_property =  $dir_ward."/denial_case_pic_".$reference_no;
        $size = getImageSizeFromString($propertyPic);
        $ext = substr($size['mime'], 6);
        $img_file_property = $file_name_property.".{$ext}";
        file_put_contents($img_file_property, $propertyPic);


       
    }

}
