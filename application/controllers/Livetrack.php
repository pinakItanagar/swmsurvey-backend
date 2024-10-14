<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class livetrack extends CI_Controller {

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
        $this->load->model('Master_dashboard', 'tblDashboard');
    }

    public function index() {
        $pagename = "mytrack/livetrack";
        $title = "Live Track";
        $post = [
            'Imei' => '818049081211'
        ];

        $ch = curl_init('http://65.0.84.113:6001/THome/GetLivefeedByVehicle');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);

        curl_close($ch);


        $livedata = json_decode($response);
        $data = [];
        $data['maps'] = "MAP";
        $data['livedata'] = $livedata;
        $this->page($pagename, $title, $data);
    }
    
    
    public function getsimplydata() {
        
          $post = [
            'Username' => 'patna',
            'Password' => 'patna#2020'
          ];
          
          $ch = curl_init('http://psclapi.ecosmartdc.com/api/Transport/PushGpsData');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          $response = curl_exec($ch);

          curl_close($ch);
          
          echo $response;
    }
    

    public function replay() {
        $pagename = "mytrack/vehiclehistory3";
        $title = "Live Track - 818049081211";
       // $file_name = base_url("upload/vehicledata.txt");
       // $response = file_get_contents($file_name);
       
        /*
          $post = [
          'ImeiNo' => '818049081211',
          'FromDate' => '2020-12-31 09:00',
          'ToDate'   => '2020-12-31 14:40'
          ];
         * */
           $post = [
          'Imei' => '818049081211'
          ];

          $ch = curl_init('http://65.0.84.113:6001/TReport/ExportVehicleHistoryData');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          $response = curl_exec($ch);

          curl_close($ch);
          
        

        $newresponse = json_decode($response);
        $historydata = json_decode($newresponse);
       
        echo "<pre>";
         print_r($historydata);
          die();

        $data = [];
        $data['maps'] = "MAP";
        $data['livedata'] = $newresponse;
        $data['lat'] = $historydata[0]->Lat;
        $data['lng'] = $historydata[0]->Lng;
        $data['isDateField'] = true;

        $this->page($pagename, $title, $data);
    }

    public function getGPSData() {
        $file_name = base_url("upload/vehicledata.txt");
        $response = file_get_contents($file_name);
        $historydata = json_decode($response);
        $x = 0;
        
        /*
         * 
         * (
            [GpsTId] => 39090980
            [VehicleNo] => HR-55  TMP/17303
            [Speed] => 0.00
            [Lat] => 25.594722
            [Lng] => 85.115356
            [Odo] => 0
            [Ignition] => ON
            [IPower] => Internal Battery
            [Temp_Detect] => 0
            [Fuel_Detect] => No
            [Vib_Alarm] => No
            [Over_Speed_Alarm] => No
            [DatedOn] => 28-12-2020 12:00:20 AM
            [SyncOn] => 28-12-2020 12:02:12 AM
            [Distance] => 0
        )
         */
        echo "<pre>";
        print_r($historydata);
        die();
     
       
   //     for($i=0; $i<2; $i++) {
            $lat1 = $historydata[0]->Lat;
            $lng1 = $historydata[0]->Lng;
            echo $lat1." ".$lng1;
            
            $lat2 = $historydata[1]->Lat;
            $lng2 = $historydata[1]->Lng;
            $file = base_url('api/getmidpoints.php?')."lat1=".$lat1."&lng1=".$lng1."&lat2=".$lat2."&lng2=".$lng2 ;
            $coordinates =  file_get_contents($file);
            echo "<pre>";
             print_r($coordinates);
      //  }
        
         
        die();

        echo $response;
    }

    public function updateNewPropertyFlat($pid) {

        $pagename = "property/updateNewPropertyFlat";
        $title = "View Property Details";
        $property = $this->tblProperty->allSurveyedPropertyData($pid);
        $buildingType = $this->tblProperty->getallbuildingType();
        $data['isDateField'] = true;
        $data['maps'] = "MAP";
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
    }

    public function updateNewPropertyIndividual($pid) {

        $property = $this->tblProperty->allSurveyedPropertyData($pid);
        $circle_name = $this->tblDashboard->getCircleName($property->circle_id);
        $bread_crum[0] = "<a href='" . base_url('dashboard') . "'>Dashboard</a>&nbsp;/&nbsp;";
        $bread_crum[1] = "<a href='" . base_url('dashboard/viewward/' . $property->circle_id) . "'>$circle_name</a>&nbsp;/&nbsp;";
        $bread_crum[2] = "<a href='" . base_url('dashboard/newproperty/' . $property->ward_no) . "'>Ward No " . $property->ward_no . "</a>&nbsp;/&nbsp;";
        $bread_crum[3] = "View New Individual Property Details";

        $pagename = "property/updateNewPropertyIndividual";
        $title = $bread_crum[0] . $bread_crum[1] . $bread_crum[2] . $bread_crum[3];

        $buildingType = $this->tblProperty->getallbuildingType();
        $data['isDateField'] = true;
        $data['maps'] = "MAP";
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
    }

    public function viewsurveyedproperty($pid) {

        $pagename = "property/viewSurveyedProperty";
        $title = "View Property Details";
        $property = $this->tblProperty->allSurveyedPropertyData($pid);


        $buildingType = $this->tblProperty->getallbuildingType();
        $data['isDateField'] = true;
        $data['maps'] = "MAP";
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
    }

    public function viewproperty($record_id) {
        $pagename = "property/viewProperty";
        $title = "View Property Details";
        $property = $this->tblProperty->allPropertyData($record_id);
        $buildingType = $this->tblProperty->getallbuildingType();

        $data = [];
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
    }

    public function saveIndividualProperty() {
        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $pid = $_POST['pid'];
        $owner_name = strtoupper($_POST['owner_name']);
        $guardian_name = strtoupper($_POST['guardian_name']);
        $mobile_no = $_POST['mobile_no'];
        $building_type = $_POST['building_type'];
        $no_of_properties = $_POST['no_of_properties'];
        $occupancy_status = $_POST['occupancy_status'];
        $property_type = $_POST['property_type'];
        $address = addslashes(strtoupper($_POST['address']));
        $sector = $_POST['sector'];
        $area_landmark = addslashes(strtoupper($_POST['area_landmark']));
        $p_record_id = $_POST['p_record_id'];
        $ward_no = $_POST['ward_no'];

        $property_image_data = "";
        $property_qrimage_data = "";

        $file_name = "property_img_" . date("YmdHis");
        $file_element_name = 'property_image';
        $config['file_name'] = $file_name;
        $config['upload_path'] = 'upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '8000';
        $config['remove_spaces'] = true;
        $this->load->library('upload', $config);
        $this->load->library('image_lib');

        if ($this->upload->do_upload($file_element_name)) {

            $image_data = $this->upload->data();
            $db_fileName = $image_data['orig_name'];
            $ext = $image_data['file_ext'];
            $db_filenamepath = 'upload/' . $db_fileName;


            $property_image_data = base64_encode(file_get_contents(base_url($db_filenamepath)));
        }

        $file_name = "property_qrimg_" . date("YmdHis");
        $file_element_name = 'property_image_qr';
        $config['file_name'] = $file_name;
        $config['upload_path'] = 'upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '8000';
        $config['remove_spaces'] = true;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_element_name)) {

            $image_data = $this->upload->data();
            $db_fileName = $image_data['orig_name'];
            $ext = $image_data['file_ext'];
            $db_filenamepath = 'upload/' . $db_fileName;


            $property_qrimage_data = base64_encode(file_get_contents(base_url($db_filenamepath)));
        }


        if (($property_image_data != "") && ($property_qrimage_data != "")) {
            $dbdata = array(
                'owner_name' => $owner_name,
                'guardian_name' => $guardian_name,
                'mobile_no' => $mobile_no,
                'building_type' => $building_type,
                'no_of_properties' => $no_of_properties,
                'occupancy_status' => $occupancy_status,
                'property_type' => $property_type,
                'address_street' => $address,
                'sector' => $sector,
                'property_pic' => $property_image_data,
                'property_qrcode_pic' => $property_qrimage_data,
                'area_landmark' => $area_landmark
            );
        } elseif (($property_image_data != "") && ($property_qrimage_data == "")) {
            $dbdata = array(
                'owner_name' => $owner_name,
                'guardian_name' => $guardian_name,
                'mobile_no' => $mobile_no,
                'building_type' => $building_type,
                'no_of_properties' => $no_of_properties,
                'occupancy_status' => $occupancy_status,
                'property_type' => $property_type,
                'address_street' => $address,
                'sector' => $sector,
                'property_pic' => $property_image_data,
                'area_landmark' => $area_landmark
            );
        } elseif (($property_image_data == "") && ($property_qrimage_data != "")) {
            $dbdata = array(
                'owner_name' => $owner_name,
                'guardian_name' => $guardian_name,
                'mobile_no' => $mobile_no,
                'building_type' => $building_type,
                'no_of_properties' => $no_of_properties,
                'occupancy_status' => $occupancy_status,
                'property_type' => $property_type,
                'address_street' => $address,
                'sector' => $sector,
                'property_qrcode_pic' => $property_qrimage_data,
                'area_landmark' => $area_landmark
            );
        } elseif (($property_image_data == "") && ($property_qrimage_data == "")) {
            $dbdata = array(
                'owner_name' => $owner_name,
                'guardian_name' => $guardian_name,
                'mobile_no' => $mobile_no,
                'building_type' => $building_type,
                'no_of_properties' => $no_of_properties,
                'occupancy_status' => $occupancy_status,
                'property_type' => $property_type,
                'address_street' => $address,
                'sector' => $sector,
                'area_landmark' => $area_landmark
            );
        }
        $this->tblProperty->updateSurveyedProperty("p_record_id", $p_record_id, $dbdata);
        $this->session->set_flashdata('APPMSG', ' Property updated successfully ! ');
        redirect('dashboard/newproperty/' . $ward_no);
    }

    public function updateproperty() {



        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }
        $propertyId = $_POST['propertyId'];
        $owner_name = $_POST['owner_name'];
        $guardian_name = $_POST['guardian_name'];
        $mobile_no = $_POST['mobile_no'];
        $building_type = $_POST['building_type'];
        $no_of_properties = $_POST['no_of_properties'];
        $occupancy_status = $_POST['occupancy_status'];
        $property_type = $_POST['property_type'];
        $address = $_POST['address'];
        $dbdata = array(
            'ward_no' => $ward_no,
            'owner_name' => $owner_name,
            'guardian_name' => $guardian_name,
            'mobile_no' => $mobile_no,
            'building_type' => $building_type,
            'no_of_properties' => $no_of_properties,
            'occupancy_status' => $occupancy_status,
            'property_type' => $property_type,
            'address' => $address
        );
        $this->tblProperty->updateProperty($propertyId, $dbdata);
        $this->session->set_flashdata('APPMSG', ' Property updated successfully ! ');
        redirect('manageproperty/propertylisting');
        //echo $propertyId;
    }

    public function propertylisting() {
        $pagename = "property/all_properties";
        $title = "All Existing Household";
        $result = $this->tblProperty->allProperties();
        $data['allProperties'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function addproperty() {
        $pagename = "property/add_property";
        $link = "<a href='" . base_url("manageproperty/propertylisting") . "'>Property Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Add Property";
        //$data = "";
        $data = [];
        $circles = $this->tblCircle->getCircles();
        $data['circles'] = $circles;
        $this->page($pagename, $title, $data);
    }

    public function getWards() {
        $circle_id = $this->input->post('circle_id');
        $wards = $this->tblCircle->getWardsOfACircle($circle_id);
        $data = [];
        $data['wards'] = $wards;
        $statesString = $this->load->view('property/wards-select', $data, true);

        $response['wards'] = $statesString;
        echo json_encode($response);
    }

    public function saveproperty() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }
        $ward_no = strtoupper(trim($this->security->xss_clean($_POST['ward'])));
        $pid = strtoupper(trim($this->security->xss_clean($_POST['pid'])));
        $application_no = strtoupper(trim($this->security->xss_clean($_POST['application_no'])));
        $owner_name = strtoupper(trim($this->security->xss_clean($_POST['owner_name'])));
        $guardian_name = strtoupper(trim($this->security->xss_clean($_POST['guardian_name'])));
        $mobile_no = strtoupper(trim($this->security->xss_clean($_POST['mobile_no'])));
        $building_type = strtoupper(trim($this->security->xss_clean($_POST['building_type'])));
        $no_of_properties = strtoupper(trim($this->security->xss_clean($_POST['no_of_properties'])));
        $occupancy_status = strtoupper(trim($this->security->xss_clean($_POST['occupancy_status'])));
        $property_type = strtoupper(trim($this->security->xss_clean($_POST['property_type'])));
        $address = strtoupper(trim($this->security->xss_clean($_POST['address'])));
        $longitude = strtoupper(trim($this->security->xss_clean($_POST['longitude'])));
        $latitude = strtoupper(trim($this->security->xss_clean($_POST['latitude'])));


        $dbdata = array(
            'ward_no' => $ward_no,
            'pid' => $pid,
            'application_no' => $application_no,
            'owner_name' => $owner_name,
            'guardian_name' => $guardian_name,
            'mobile_no' => $mobile_no,
            'building_type' => $building_type,
            'no_of_properties' => $no_of_properties,
            'occupancy_status' => $occupancy_status,
            'property_type' => $property_type,
            'address' => $address,
            'longitude' => $longitude,
            'latitude' => $latitude
        );
        $this->tblProperty->insertProperty($dbdata);

        $this->session->set_flashdata('APPMSG', ' Household added successfully ! ');
        redirect('manageproperty/propertylisting/');
    }

    public function deleteApartment($pid) {
        $property = $this->tblProperty->allSurveyedPropertyData($pid);
        $ward_no = $property->ward_no;
        $this->tblProperty->removeNewApartment($pid);
        $this->session->set_flashdata('APPMSG', ' Property details deleted successfully ! ');
        redirect('dashboard/newproperty/' . $ward_no);
    }

    public function deleteIndividual($pid) {
        $property = $this->tblProperty->allSurveyedPropertyData($pid);
        $ward_no = $property->ward_no;
        $this->tblProperty->removeNewIndividual($pid);
        $this->session->set_flashdata('APPMSG', ' Property details deleted successfully ! ');
        redirect('dashboard/newproperty/' . $ward_no);
    }

    public function viewapartment($pid) {

        $pagename = "property/viewApartment";

        $property = $this->tblDashboard->getApartmentDetails($pid);
        $buildingType = $this->tblDashboard->getallbuildingType();

        //$circle_id = $property->circle_id;
        $ward_no = $property->ward_no;
        //$circle_name = $this->tblDashboard->getCircleName($circle_id);


        $bread_crum[0] = "<a href='" . base_url('dashboard') . "'>Dashboard</a>&nbsp;/&nbsp;";
        $bread_crum[1] = "<a href='" . base_url('dashboard/overallwardinfo/' . $ward_no) . "'>Ward No." . $ward_no . "</a>&nbsp;/&nbsp;";
        $bread_crum[2] = "View Aparment Details";
        $title = $bread_crum[0] . $bread_crum[1] . $bread_crum[2];



        $data['isDateField'] = true;
        $data['maps'] = "MAP";
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
    }

    public function viewindividualproperty($pid) {

        $pagename = "property/viewIndividualProperty";

        $property = $this->tblDashboard->getIndividualDetails($pid);
        $buildingType = $this->tblDashboard->getallbuildingType();

        $circle_id = $property->circle_id;
        $ward_no = $property->ward_no;
        // $circle_name = $this->tblDashboard->getCircleName($circle_id);

        $bread_crum[0] = "<a href='" . base_url('dashboard') . "'>Dashboard</a>&nbsp;/&nbsp;";
        $bread_crum[1] = "<a href='" . base_url('dashboard/overallwardinfo/' . $ward_no) . "'>Ward No." . $ward_no . "</a>&nbsp;/&nbsp;";
        $bread_crum[2] = "View Aparment Details";
        $title = $bread_crum[0] . $bread_crum[1] . $bread_crum[2];

        $data['isDateField'] = true;
        $data['maps'] = "MAP";
        $data['property'] = $property;
        $data['buildingType'] = $buildingType;
        $this->page($pagename, $title, $data);
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
    
    
    function getAllintermediatePoint($lat1,$lng1,$lat2,$lng2){
         #point interval in meters
      $interval = 20;
  
      $azimuth = $this->calculateBearing($lat1,$lng1,$lat2,$lng2);
      //print $azimuth;
      $coords = $this->cmain($interval,$azimuth,$lat1,$lng1,$lat2,$lng2);
      
      echo json_encode($coords);
        
    }

    /*
      #point interval in meters
      $interval = 10;
      #direction of line in degrees
      #start point
      $lat1 = 43.97076;
      $lng1 = 12.72543;
      #end point
      $lat2 = 43.969730;
      $lng2 = 12.728294;
      $azimuth = calculateBearing($lat1,$lng1,$lat2,$lng2);
      //print $azimuth;
      $coords = main($interval,$azimuth,$lat1,$lng1,$lat2,$lng2);
      print_r($coords);

     */

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
