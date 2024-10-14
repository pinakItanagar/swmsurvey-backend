<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
require APPPATH .'third_party/Phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
class Mygis extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
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


    public function __construct() {
       parent::__construct();
       $this->load->model('Master_property', 'tblProperty');
       $this->load->model('Master_circle', 'tblCircle');      
       $this->load->model('Master_dashboard', 'tblDashboard');
       $this->load->library('couchdb');  
       
    }
    
    public function askrate() {
        $total_target = "226300";
        $totalSurveyDoneAllWards = $this->tblDashboard->totalSurveyDoneAllWards();
        
        echo "<br>";
        //echo $total_target." =  ".$totalSurveyDoneAllWards;
        $total_remaining = intval($total_target) -  intval($totalSurveyDoneAllWards);
       
        $div_total = $total_remaining / intval($total_target);
        $remaining_percentage = $div_total * 100;
        
        $date1 = date("Y-m-d");
        $date2 = "2021-04-07";
        
        $date1 = date_create("2021-03-04");
        $date2 = date_create("2021-04-07");
        $diff = date_diff($date1,$date2);
      
     
        $asking_rate = $remaining_percentage/$diff->days;
        $num = intval($total_target) * 2.5/100 ;
        echo $num;
    }
    
    public function totalSurveyDone(){
        $payload = '["HOUSEHOLD_DATA"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload,"_design/survey/_view/getAllSurveyData?&ascending=true&key="); 
        echo "<pre>";
        print_r($data);
        die();
       // $total = count($data->rows);
       // return $total;
    }
    
    
    public function plotpoints() {
              $pagename = "gps/plothistory";
              $this->db->select("*");
              $this->db->from('gis_data_temp');
              $this->db->order_by("device_date_time asc");
              $query = $this->db->get();
              $rs =  $query->result();
              
              $total_distance = 0;
              foreach ($rs as $row) {
                  //if (( trim($row->ignition) == "On") && ( trim(intval($row->speed)) > 1)) {
                  if ( trim($row->ignition) == "On")  {    
                      $total_distance =  $total_distance + intval(trim($row->distance));
                  }
              }
              
              $data['vehicle'] = json_encode($rs);
              $data['maps'] = "MAP";
              $data['total_distance'] = $total_distance;
              $title = "Vehicle History";
              $this->page($pagename, $title, $data);  
              
              
        
    }
    
    
    public function property() {
        $reader = new Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("download/azmiabad.xls"); 
        $worksheet = $spreadsheet->getSheet(0);
        $worksheet_data = $worksheet->toArray();
        echo "<pre>";
        print_r($worksheet_data[1]);
       
    }
    
    
    public function test(){
       
      
        $reader = new Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("download/VehicleHistory1677.xls");
        $worksheet = $spreadsheet->getSheetByName("1677");
        $worksheet_data = $worksheet->toArray();
        $total_xls_records = count($worksheet_data);
        //$total_xls_records = 2; 
       
        /*
         * 
         *  [0] => Sr No.
            [1] => Vehicle No 
            [2] => Speed
            [3] => Ignition
            [4] => Power
            [5] => Over Speed Alarm
            [6] => TDate
            [7] => Device Date & Time
            [8] => Latitude
            [9] => Longitude
            [10] => Distance(Km)
         * 
         * 
         * 
         *  function(doc) {
                if(doc.table_name && doc.date && doc.vehicle_no ) {
                    emit( doc.table_name, doc.date, doc.vehicle_no , doc.latitude , doc.longitude  );
                }
            }
         */
        
        for($i = 1; $i<$total_xls_records; $i++) {
            $vehicle_no = $worksheet_data[$i][1];
            $speed = $worksheet_data[$i][2];
            $ignation = $worksheet_data[$i][3];
            $power = $worksheet_data[$i][4];
            $transmission_date_time = $worksheet_data[$i][6];
            $device_date_time = $worksheet_data[$i][7];
            $latitude = $worksheet_data[$i][8];
            $longitude = $worksheet_data[$i][9];
            $table_name = "device_data";
            $distance = $worksheet_data[$i][10];
                
            $dtArray =  explode(" ",$device_date_time);
            $date =  date("Y-m-d", strtotime($dtArray[0]));  
            $time =  $dtArray[1];    
            
            
            $slno = $i.date("YmdHis");
            $doc_id = hash('sha256', $slno);      

            $doc_obj = array(
                'table_name' => $table_name,
                'doc_id' => $doc_id,
                'vehicle_no' => $vehicle_no,
                'speed' => $speed,
                'ignation' => $ignation,
                'power' => $power,
                'transmission_date_time' => $transmission_date_time,
                'device_date_time' => $device_date_time,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'date' => $date,
                'time' => $time,
                'distance' => $distance
            );
           
           $this->couchdb->createCouchDbDoc($doc_obj, $doc_id,'application/json');
           echo "<pre>";
           print_r($doc_obj);
            


            
        }
    
    }
    
    
     public function xaddroute(){
       
      
        $reader = new Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("download/route23c.xls");
        $worksheet = $spreadsheet->getSheetByName("Construct1677");
        $worksheet_data = $worksheet->toArray();
        $total_xls_records = count($worksheet_data);
       
        
        for($i = 1; $i<$total_xls_records; $i++) {
        
            $latitude = $worksheet_data[$i][0];
            $longitude = $worksheet_data[$i][1];
            $table_name = "route_data";
            $route_name = "W23C";
                
           
            
            
            $slno = $i.date("YmdHis");
            $doc_id = hash('sha256', $slno);      

            $doc_obj = array(
                'table_name' => $table_name,
                'doc_id' => $doc_id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'route_name' => $route_name
            );
           
           $this->couchdb->createCouchDbDoc($doc_obj, $doc_id,'application/json');
           echo "<pre>";
           print_r($doc_obj);
            


            
        }
    
    }



    public function alert(){
       $pagename = "gis/yardmapview";
       $file_name = file_get_contents(base_url("upload/wardboundary/patliputra.geojson"));
       $data['start_lat'] = "25.621872676174227" ;
       $data['start_lng'] = "85.10754870636373" ;
       $data['yard'] = $file_name;
       $data['maps'] = "MAP";
       $title = "Patliputra Yard Layer";
       $this->page($pagename, $title, $data);    
    } 
    
    
    
    public function plot(){
       $route = $this->getRoutes();
       $total_route_points = count($route->rows);
     
       $points = $this->getAllRecords();
       $total_points = count($points->rows);
       
    
       
       $datapoint = array();
       $datapoint2 = array();
       
        for($i=0; $i<$total_points; $i++) {
            
            if($points->rows[$i]->value->distance != "0") {
                
                /*
                for($x=0; $i<$total_route_points; $x++) {
                  
                    $dis = 
                    
                }*/
                
                
                $temp = array("latitude" => $points->rows[$i]->value->latitude, "longitude" => $points->rows[$i]->value->longitude,  "device_date_time" => $points->rows[$i]->value->device_date_time , "isvalid" => "1");
                array_push($datapoint,$temp);
            }
            // echo $i." ".$points->rows[$i]->value->doc_id."  ".$points->rows[$i]->value->device_date_time."<br>";
           
        }
        
        $your_date_field_name = 'device_date_time';
        usort($datapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });
        
        $distance = array();
       // $total_points
        $adjusted_point = array();
        $min_distance = array();
        $ad_distance = array();
        $j = 0;
        for($i=0; $i<count($datapoint); $i++) {
            
            if($points->rows[$i]->value->distance != "0") {
                 for($x=0; $x<$total_route_points; $x++) {
                     
                    $dx =  $this->vincentyGreatCircleDistance( $route->rows[$x]->value->latitude , $route->rows[$x]->value->longitude, $datapoint[$i]['latitude'] , $datapoint[$i]['longitude'] );
                    
                    if($min_distance == null) {
                        $min_distance[0]['dt'] = $dx;
                        $min_distance[0]['lat'] = $route->rows[$x]->value->latitude;
                        $min_distance[0]['lng'] = $route->rows[$x]->value->longitude;
                        $min_distance[0]['latitude'] = $datapoint[$i]['latitude'];
                        $min_distance[0]['longitude'] = $datapoint[$i]['longitude'];
                        $min_distance[0]['pointer'] = $i;
                    } else {
                        
                        if( floatval($min_distance[0]['dt']) > floatval($dx) ) {
                            $min_distance[0]['dt'] = $dx;
                            $min_distance[0]['lat'] = $route->rows[$x]->value->latitude;
                            $min_distance[0]['lng'] = $route->rows[$x]->value->longitude;
                            $min_distance[0]['latitude'] = $datapoint[$i]['latitude'];
                            $min_distance[0]['longitude'] = $datapoint[$i]['longitude'];
                            $min_distance[0]['pointer'] = $i;
                            
                        }
                        
                    }
                  
                 }
                 $ad_distance[$j]['dt'] =   $min_distance[0]['dt'];
                 $ad_distance[$j]['lat'] = $min_distance[0]['lat'];
                 $ad_distance[$j]['lng'] = $min_distance[0]['lng'];
                 $ad_distance[$j]['latitude'] = $min_distance[0]['latitude'];
                 $ad_distance[$j]['longitude'] = $min_distance[0]['longitude'];
                 $ad_distance[$j]['device_date_time'] = $datapoint[$i]['device_date_time'];
                 $pointer = $min_distance[0]['pointer'];
                 $datapoint[$pointer]['isvalid'] = "0";
                 $min_distance = null;
                 $j++;
                 
                
                 
            }
            
           
        }
        
      
       
       $all_routes = json_encode($route->rows);
       $all_points = json_encode($datapoint);
       $adjusted_points = json_encode($ad_distance);
       
     
       
      
       $pagename = "gis/routemapview";
       $data['start_lat'] = $points->rows[0]->value->latitude ;
       $data['start_lng'] =  $points->rows[0]->value->longitude ;
       $data['all_points'] = $all_points;
       $data['all_routes'] = $all_routes;
       $data['adjusted_points'] = $adjusted_points;
       $data['maps'] = "MAP";
       $title = "Ward 23 - Vehicle No. 1677 ";
       $this->page($pagename, $title, $data); 
      
       
     //  print_r($points->rows[0]->value);
       
      /*  
       $pagename = "gis/yardmapview";
       $file_name = file_get_contents(base_url("upload/wardboundary/patliputra.geojson"));
       $data['start_lat'] = "25.621872676174227" ;
       $data['start_lng'] = "85.10754870636373" ;
       $data['yard'] = $file_name;
       $data['maps'] = "MAP";
       $title = "Patliputra Yard Layer";
       $this->page($pagename, $title, $data);    */
    } 
    
    
    public function replot() {
        $route = $this->getRoutes();
        $points = $this->getAllRecords();
        $total_points = count($points->rows);
        $datapoint = array();
        $errordatapoint = array();
        
        for($i=0; $i<$total_points; $i++) {
             if($points->rows[$i]->value->distance != "0") {
                $temp = array("latitude" => $points->rows[$i]->value->latitude, "longitude" => $points->rows[$i]->value->longitude,  "device_date_time" => $points->rows[$i]->value->device_date_time , "isvalid" => "1");
                array_push($datapoint,$temp);   
                array_push($errordatapoint,$temp);  
             }
       }
       
        $your_date_field_name = 'device_date_time';
        usort($datapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });
        
         $your_date_field_name = 'device_date_time';
        usort($errordatapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });
        
      
        
        
        
        
        
        for($i=0; $i<count($datapoint); $i++) {
            $adjusted_point = $this->checkdistance($datapoint[$i]['latitude'], $datapoint[$i]['longitude'], $i );
            if(!empty($adjusted_point)) {
                $adjusted_point_rev = array_reverse($adjusted_point);
                $adjusted_data_str =  $adjusted_point_rev[0];
                $adjusted_xplode = explode("#",$adjusted_data_str );
                $pointer =  $adjusted_xplode[2];
                $lat =  $adjusted_xplode[0];
                $lng =  $adjusted_xplode[1];
                $datapoint[$pointer]['latitude'] = $lat;
                $datapoint[$pointer]['longitude'] = $lng;
                $datapoint[$pointer]['isvalid'] = "0";
               // echo $pointer."<br>";
               
            }
        }
        
         $all_routes = json_encode($route->rows);
         $adjusted_point = json_encode($datapoint);
         $error_data_point = json_encode($errordatapoint);
         $pagename = "gis/routemapviewnew";
         $data['start_lat'] = $points->rows[0]->value->latitude ;
         $data['start_lng'] =  $points->rows[0]->value->longitude ;
         $data['all_points'] = $error_data_point;
         $data['all_routes'] = $all_routes;
         $data['adjusted_points'] = $adjusted_point;
         $data['maps'] = "MAP";
         $title = "Ward 23 - Vehicle No. 1677 ";
         $this->page($pagename, $title, $data); 
    }
    
    
    public function vincentyGreatCircleDistance( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $lonDelta = $lonTo - $lonFrom;
      $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
      $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

      $angle = atan2(sqrt($a), $b);
      return $angle * $earthRadius;
    }
    
    
    public function checkdistance($lat,$lng, $pointer ) {
       
        $route = $this->getRoutes();
        $total_route_points = count($route->rows);
        $mindis = 0;
        $mindata = array();
        for($x=0; $x<$total_route_points; $x++) {
            $dx =  $this->vincentyGreatCircleDistance( $route->rows[$x]->value->latitude , $route->rows[$x]->value->longitude, $lat , $lng );
            if($mindis == 0) {
             
              
              if(floatval($dx) < 15) {
                $mindis = $dx;     
                //echo $route->rows[$x]->value->latitude." ".$route->rows[$x]->value->latitude."  DISTANCE ".$dx."<br>";
                $mindata[] = $route->rows[$x]->value->latitude."#". $route->rows[$x]->value->latitude."#".$pointer;
              }
            } else {
            
                if( floatval($mindis) > floatval( $dx) ) {
                  if(floatval($dx) < 15) {   
                   $mindis =  $dx;
                   //echo $route->rows[$x]->value->latitude." ".$route->rows[$x]->value->latitude."  DISTANCE ".$dx."<br>";
                   $mindata[] = $route->rows[$x]->value->latitude."#". $route->rows[$x]->value->latitude."#".$pointer;
                  }
                }   
            
            }
        }  
        
        return $mindata;
    }
    
    
    public function getAllRecords(){
        $payload = '["device_data", "2021-01-13", "BR01GJ-1677"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload,"_design/gps/_view/readgps?&ascending=true&key="); 
        //$data = $this->getCouchDbAllDocs($payload,"_design/view/_view/draftDocList?&descending=true&key="); 
        //$data = $this->couchdb->getCouchDbAllDocs($payload,"_design/view/_view/getpoints?&ascending=true&key=");
        //_design/view/_view/getpoints
        return $data;
    }

     public function getAllRecordsByVehicleReg($date, $vehicle_reg){
        $payload = '["device_data", "'.$date.'", "'.$vehicle_reg.'"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload,"_design/gps/_view/readgps?&ascending=true&key="); 
        return $data;
    }
    
    
     public function getRoutes(){
        $payload = '["route_data" , "W23C"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload,"_design/gps/_view/readRoute?&ascending=true&key="); 
        return $data;
    }
    
    
    public function deleteRecord() {
          $points = $this->getAllRecordsByVehicleReg("2021-01-13", "BR01GJ-1677");
          $total = count($points->rows);
          
          for($i=0; $i<$total; $i++) {
              echo $i." ".$points->rows[$i]->value->doc_id."  ".$points->rows[$i]->value->_rev."<br>";
              $this->couchdb->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
          }
        
          //$this->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
    }
    
    
    public function deletepoint() {
          $points = $this->getRoutes();
          $total = count($points->rows);
          
          for($i=0; $i<$total; $i++) {
              echo $i." ".$points->rows[$i]->value->doc_id."  ".$points->rows[$i]->value->_rev."<br>";
              $this->couchdb->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
          }
        
          //$this->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
    }








    public function page($pagename, $title, $data) {

       if(!$this->session->userdata('USER_ID')){
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
