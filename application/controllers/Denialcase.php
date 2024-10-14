<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Denialcase extends CI_Controller {

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
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Master_user', 'tblUser');
        $this->load->model('Master_denialcase', 'tblDenialcase');
        $this->load->model('Master_circle', 'tblCircle');  
    }

    
    
    public function viewinfo() {
      $title = "Denial Case Info";  
      $pagename = "denialcase/viewinfo";
      $geojson = base_url("upload/wardboundary/allWard.geojson");
      $data['patna'] = file_get_contents($geojson);
      $date = date("Y-m-d");
      $data['circles'] = $this->tblCircle->getCircles();
      $data['isDateField'] = true;
      $data['maps'] = "MAP";
      $this->page($pagename, $title, $data);
        
    }
    
    
    public function showData() {
        
        if(isset($_POST['report_date'])) {
            $report_date = $_POST['report_date'];
            $ward_no = $_POST['ward_no'];
            $result = $this->tblDenialcase->getDenialCaseByDate($report_date, $ward_no );
        }
        echo json_encode($result);
    }
    
    
    public function findVehicle() {
        // $distance, $slat, $slng
        // Search Mirsikar tola, Dargah Rd, Patna, Bihar
        // Actual vehicle Data 25.613546,85.193832   ( Near Jama Masjid )
        
        // 25.625591, 85.117141 Patliputra Colony, Patna, Bihar
        $vehicleList = array();
        $vinfo = array();
        $vehicle_data = $this->tblVdata->getAllVehicleData();
        $total = count($vehicle_data);
        $min_distance =  1000;
        $lat1 = "25.629172949999997";
        $lon1 = "85.10959292391054";
        $unit = "K" ;
        $distKM = 0;
        $mtrs = 0;
        for($i=0; $i<$total; $i++) {
            $record_id = $vehicle_data[$i]->id;
            $vehicle_no = $vehicle_data[$i]->vehicle_no;
            $speed =  $vehicle_data[$i]->speed ;
            $ignition =  $vehicle_data[$i]->ignition ;
            $power =  $vehicle_data[$i]->power ;
            $ward_no =  $vehicle_data[$i]->ward_no ;
            $device_date_time =  trim($vehicle_data[$i]->device_date_time) ;
            $dt = preg_replace('/\s+/', '#', $device_date_time);
            
            $vlat = $vehicle_data[$i]->latitude;
            $vlng = $vehicle_data[$i]->longitude;
            $distKM = $this->distance($lat1, $lon1, $vlat, $vlng, $unit);
            
            $mtrs = $distKM * 1000;
            if(intval($mtrs) <  $min_distance) {
              echo "Vehicle No : ".$vehicle_no."  ".$vlat.", ".$vlng."  IN KM : ".$distKM." Difference : ".intval($mtrs)."<br>";
              $vehicleinfo = trim($record_id)."#".trim($vehicle_no)."#".trim($vlat)."#".trim($vlng)."#".trim($speed)."#".trim($ignition)."#".trim($power)."#".trim($ward_no)."#".trim($dt);
              if (!in_array($vehicleinfo, $vehicleList)) {
                 array_push($vehicleList, $vehicleinfo); 
              }
              
              if (!in_array($vehicle_no, $vinfo)) {
                 array_push($vinfo, $vehicle_no); 
              } 
            }
            
        }
        
        $finalvehiclelist = $this->removeDuplicate($vehicleList, $vinfo);
        
        $vdata = json_encode($finalvehiclelist);
        echo $vdata;
    }
    
    
     public function findVehicletest($lat1, $lon1, $min_distance) {
        // $distance, $slat, $slng
        // Search Mirsikar tola, Dargah Rd, Patna, Bihar
        // Actual vehicle Data 25.613546,85.193832   ( Near Jama Masjid )
        
        // 25.625591, 85.117141 Patliputra Colony, Patna, Bihar
        $vehicleList = array();
        $vinfo = array();
        $vehicle_data = $this->tblVdata->getAllVehicleData();
        $total = count($vehicle_data);
        //$min_distance =  400;
        //$lat1 = "25.629172949999997";
        //$lon1 = "85.10959292391054";
        $unit = "K" ;
        $distKM = 0;
        $mtrs = 0;
        for($i=0; $i<$total; $i++) {
            $record_id = $vehicle_data[$i]->id;
            $vehicle_no = $vehicle_data[$i]->vehicle_no;
            $speed =  $vehicle_data[$i]->speed ;
            $ignition =  $vehicle_data[$i]->ignition ;
            $power =  $vehicle_data[$i]->power ;
            $ward_no =  $vehicle_data[$i]->ward_no ;
            $device_date_time =  trim($vehicle_data[$i]->device_date_time) ;
            $dt = preg_replace('/\s+/', '#', $device_date_time);
            
            $vlat = $vehicle_data[$i]->latitude;
            $vlng = $vehicle_data[$i]->longitude;
            $distKM = $this->distance($lat1, $lon1, $vlat, $vlng, $unit);
            
            $mtrs = $distKM * 1000;
            if(intval($mtrs) <  $min_distance) {
             // echo "Vehicle No : ".$vehicle_no."  ".$vlat.", ".$vlng."  IN KM : ".$distKM." Difference : ".intval($mtrs)."<br>";
              $vehicleinfo = trim($record_id)."#".trim($vehicle_no)."#".trim($vlat)."#".trim($vlng)."#".trim($speed)."#".trim($ignition)."#".trim($power)."#".trim($ward_no)."#".trim($dt);
              if (!in_array($vehicleinfo, $vehicleList)) {
                 array_push($vehicleList, $vehicleinfo); 
              }
              
              if (!in_array($vehicle_no, $vinfo)) {
                 array_push($vinfo, $vehicle_no); 
              } 
            }
            
        }
        
        $finalvehiclelist = $this->removeDuplicate($vehicleList, $vinfo);
        
        $vdata = json_encode($finalvehiclelist);
        echo $vdata;
    }


    public function removeDuplicate($vehicleinfo, $vinfo) {
        
        $finalVehicleData = array();
       
        for($i=0; $i<count($vinfo); $i++) {
            $vehicle_no = $vinfo[$i];
            $vstring =  $this->getVehicleData($vehicleinfo ,$vehicle_no );
            array_push($finalVehicleData, $vstring);
           // array_push($finalVehicleData, $vstring);
        }
        
        return $finalVehicleData;
    }
    
    
    
    public function getVehicleData($vehicleinfo ,$vehicle_no ) {
          
            $record = "";
            for($x=0; $x<count($vehicleinfo); $x++) {
                
                $vstring = $vehicleinfo[$x];
                $vdata = explode("#",$vstring);
                $vdataVehicleNO = $vdata[1];
                
                if($vdataVehicleNO == $vehicle_no) {
                  $record = $vstring;
                   break;
                  
                }
            }
            
            return $record;
    }



    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);

          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
    }
    
    
    
    
    
  
    
    public function page($pagename, $title, $data) {


        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $staticdata['header_script'] = 'template/include/header_scripts';
        $staticdata['app_header'] = 'template/include/app_header';
        $staticdata['app_sidemenu'] = 'template/include/app_sidemenu';
        $staticdata['app_breadcrum'] = 'template/include/app_breadcrum';
        $staticdata['page_title'] = $title;
        $staticdata['app_maincontent'] = $pagename;
        $staticdata['footer_copyright'] = 'template/include/footer_copyright';
        $staticdata['footer_script'] = 'template/include/footer_scripts';
        $this->load->vars($staticdata);
        $this->load->vars($data);
        $this->load->view('template/admin_tpl');
    }

}
