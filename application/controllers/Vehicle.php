<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Vehicle extends CI_Controller {

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
    public function __construct() {
        parent::__construct();
        $this->load->model('Master_property', 'tblProperty');
        $this->load->model('Master_circle', 'tblCircle');
        $this->load->model('Master_vehicle', 'tblVehicle');
        $this->load->library('couchdb'); 
    }
    
    
    public function report() {
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "report/vehiclereportform";
        $title = "Date wise vehicle report";
        $this->page($pagename, $title, $data);
    }
    
    
    public function datatransfer() {
        $report_date =  trim($_POST['report_date']);
        $fromDate = $report_date." "."05:00" ;
        $toDate = $report_date." "."17:00" ;
        $vehicles =  $this->tblVehicle->getAllVehicle();
        $url = "http://65.0.84.113:6001/TReport/GetVehicleHistory";
        $table_name = "GPSLOGDATA";
        $x = 0;
        foreach ($vehicles as $vehicle) {
            
            
            
            $post = [
                'ImeiNo' => trim($vehicle->imei_no),
                'FromDate' => $fromDate,
                'ToDate'   => $toDate
            ];
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            curl_close($ch);

           $report = json_decode($response);
           $vehicle_data = json_decode($report);
           
           
                for($i = 0; $i<count($vehicle_data); $i++) {

                   $doc_id = "GPSLOG".date("YmdHis").$i ;

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
                   $this->couchdb->createCouchDbDoc($doc_obj, $doc_id,'application/json');

                 }

          
           
        }
        
        
    }


    public function uploadVehicle() {
  
    	$file = fopen("upload/allvehicle.txt","r");

    	while(! feof($file))   {
		  $line = fgets($file);
		  echo $line."<br>";
		  $vehicle_array  =  explode("#", $line);
		  $data = array(
            "imei_no" => trim($vehicle_array[0]),
            "registration_no" => trim($vehicle_array[1])
		  );
		 // $this->tblVehicle->insertVehicle($data);
		}
		
		fclose($file);

    }


    public function getVehicleHistory() {

    	$url = "http://65.0.84.113:6001/TReport/GetVehicleHistory";

        $post = [
          'ImeiNo' => '818049161328',
          'FromDate' => '2021-02-01 06:00',
          'ToDate'   => '2021-02-01 14:40'
        ];

        $imei = '818049161328';
        $fromDate = '2021-02-01 06:00';
        $toDate = '2021-02-01 14:40';

        $fields = array(
			'ImeiNo' => urlencode($imei),
			'FromDate' => urlencode($fromDate),
			'ToDate' => urlencode($toDate)
		);

		$fields_string  = "";

		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        
        rtrim($fields_string, '&');

      
 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		//curl_setopt($ch,CURLOPT_POST, count($fields));
		//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		$response = curl_exec($ch);
        curl_close($ch);

        $report = json_decode($response);
        $vehicle_data = json_decode($report);

        $table_name = "GPSLOGDATA";


        for($i = 0; $i<count($vehicle_data); $i++) {
              
              $doc_id = "GPSLOG".date("YmdHis").$i ;
        	 
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
                'sequence' => $i


              );

              echo "<pre>";
              print_r($doc_obj);
             // $this->couchdb->createCouchDbDoc($doc_obj, $doc_id,'application/json');

        }

        /*

          (
            [GpsTId] => 113674799
            [VehicleNo] => HR-55  TMP/17362
            [Speed] => 0.00
            [Lat] => 25.5946111
            [Lng] => 85.1152
            [Odo] => 0
            [Ignition] => Off
            [IPower] => On
            [Temp_Detect] => 0
            [Fuel_Detect] => No
            [Vib_Alarm] => No
            [Over_Speed_Alarm] => No
            [DatedOn] => 01-02-2021 06:04:32 AM
            [SyncOn] => 01-02-2021 06:04:44 AM
            [Distance] => 0
            [CircleName] => PATLIPUTRA
            [WardNo] => 1
          )
        */  


          
           
          // $this->couchdb->createCouchDbDoc($doc_obj, $doc_id,'application/json');
        
        //echo  $response ; 
      

    }


     public function fetchVehicleData() {

     }




   
    
    

   

  
    function parseFloat($ptString) {
        if (strlen($ptString) == 0) {
            return false;
        }

        $pString = str_replace(" ", "", $ptString);

        if (substr_count($pString, ",") > 1)
            $pString = str_replace(",", "", $pString);

        if (substr_count($pString, ".") > 1)
            $pString = str_replace(".", "", $pString);

        $pregResult = array();

        $commaset = strpos($pString, ',');
        if ($commaset === false) {
            $commaset = -1;
        }

        $pointset = strpos($pString, '.');
        if ($pointset === false) {
            $pointset = -1;
        }

        $pregResultA = array();
        $pregResultB = array();

        if ($pointset < $commaset) {
            preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA);
        }
        preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB);
        if ((isset($pregResultA[0]) && (!isset($pregResultB[0]) || strstr($preResultA[0], $pregResultB[0]) == 0 || !$pointset))) {
            $numberString = $pregResultA[0];
            $numberString = str_replace('.', '', $numberString);
            $numberString = str_replace(',', '.', $numberString);
        } elseif (isset($pregResultB[0]) && (!isset($pregResultA[0]) || strstr($pregResultB[0], $preResultA[0]) == 0 || !$commaset)) {
            $numberString = $pregResultB[0];
            $numberString = str_replace(',', '', $numberString);
        } else {
            return false;
        }
        $result = (float) $numberString;
        return $result;
    }

    function xrange($start, $limit, $step = 1) {
        if ($start < $limit) {
            if ($step <= 0) {
              //  throw new LogicException('Step must be +ve');
            }

            for ($i = $start; $i <= $limit; $i += $step) {
                yield $i;
            }
        } else {
            if ($step >= 0) {
              //  throw new LogicException('Step must be -ve');
            }

            for ($i = $start; $i >= $limit; $i += $step) {
                yield $i;
            }
        }
    }

    function modf($x) {
        $m = fmod($x, 1);
        return [$m, $x - $m];
    }

   

    function getDestinationLatLong($lat, $lng, $azimuth, $distance) {

        $R = 6378.1; //#Radius of the Earth in km
        $brng = deg2rad($azimuth); #Bearing is degrees converted to radians.
        $d = $distance / 1000; #Distance m converted to km
        $lat1 = deg2rad($lat); #Current dd lat point converted to radians
        $lon1 = deg2rad($lng); #Current dd long point converted to radians
        $lat2 = asin(sin($lat1) * cos($d / $R) + cos($lat1) * sin($d / $R) * cos($brng));
        $lon2 = $lon1 + atan2(sin($brng) * sin($d / $R) * cos($lat1), cos($d / $R) - sin($lat1) * sin($lat2));
        #convert back to degrees
        $lat2 = rad2deg($lat2);
        $lon2 = rad2deg($lon2);

        return [$lat2, $lon2];
    }

    function calculateBearing($lat1, $lng1, $lat2, $lng2) {
        // '''calculates the azimuth in degrees from start point to end point'''
        $startLat = deg2rad($lat1);
        $startLong = deg2rad($lng1);
        $endLat = deg2rad($lat2);
        $endLong = deg2rad($lng2);
        $dLong = $endLong - $startLong;
        $dPhi = log(tan($endLat / 2 + pi() / 4) / tan($startLat / 2 + pi() / 4));
        if (abs($dLong) > pi()) {
            if ($dLong > 0) {
                $dLong = -(2 * pi() - $dLong);
            } else {
                $dLong = 2 * pi() + $dLong;
            }
        }
        $bearing = (rad2deg(atan2($dLong, $dPhi)) + 360) % 360;
        return $bearing;
    }

    function cmain($interval, $azimuth, $lat1, $lng1, $lat2, $lng2) {
        $d = $this->getPathLength($lat1, $lng1, $lat2, $lng2);
        $rapydUnpack = $this->modf($d / $interval);
        $remainder = $rapydUnpack[0];
        $dist = $rapydUnpack[1];
        $counter = $this->parseFloat($interval);
        $coords = [];
        array_push($coords, [$lat1, $lng1]);

        $xRange = $this->xrange(0, intval($dist));

        foreach ($xRange as $rapydIndex => $value) {
            //print $value;
            $distance = $value;
            $coord = $this->getDestinationLatLong($lat1, $lng1, $azimuth, $counter);
            $counter = $counter + $this->parseFloat($interval);
            array_push($coords, $coord);
        }
        array_push($coords, [$lat2, $lng2]);

        return $coords;
    }
    
     function getPathLength($lat1, $lng1, $lat2, $lng2) {
        $R = '6371000'; //# radius of earth in m
        $lat1rads = deg2rad($lat1);
        $lat2rads = deg2rad($lat2);
        $deltaLat = deg2rad(($lat2 - $lat1));
        $deltaLng = deg2rad(($lng2 - $lng1));
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1rads) * cos($lat2rads) * sin($deltaLng / 2) * sin($deltaLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c;
        return $d;
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
