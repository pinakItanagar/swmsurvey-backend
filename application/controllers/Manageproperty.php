<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
require APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
//use PhpOffice\PhpSpreadsheet\Reader\Xls;
class manageproperty extends CI_Controller {

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
    }



    public function editproperty($record_id) {
      $pagename = "property/editOldProperty";
      $title = "Manage Property";
      $property = $this->tblProperty->allPropertyData($record_id);
      $data = [];
      $data['property'] = $property;
      $this->page($pagename, $title, $data);

    }
    
    public function propertyanalysis() {
        
        $allWard =  $this->tblDashboard->allactiveSurveyward();
        $data['activeWards'] = $allWard;
        $data['circles'] = $this->tblDashboard->getCircles();
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "property/property_analysis";
        $title = "Property Analysis";
        $this->page($pagename, $title, $data);
    }

    public function propertyAnalysisDetails() {
        $ward_no = $_POST['ward_no']; 
        $propertydata =  $this->tblDashboard->propertyanalysis($ward_no);
        $data['propertyvalue'] = $propertydata;
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "property/property_analysis_details";
        $bread_crum = "<a href='".base_url('manageproperty/propertyanalysis')."'>Property Analysis</a>&nbsp;&nbsp;--Ward No.".$ward_no ;
     
        $title = $bread_crum. " / Property Analysis Details";
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function showpropertyanalysis($pid) {
        $propertydata =  $this->tblDashboard->showpropertyanalysis($pid);
        $data['propertyvalue'] = $propertydata;
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "property/show_analysis_details";
        $bread_crum = "<a href='".base_url('manageproperty/propertyanalysis')."'>Property Analysis</a>&nbsp;&nbsp;--PID.".$pid ;
     
        $title = $bread_crum. " / Property Analysis Details";
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
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
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$property->circle_id)."'>$circle_name</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "<a href='".base_url('dashboard/newproperty/'.$property->ward_no)."'>Ward No ".$property->ward_no."</a>&nbsp;/&nbsp;" ;
      $bread_crum[3] = "View New Individual Property Details" ;
         
      $pagename = "property/updateNewPropertyIndividual";
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2].$bread_crum[3];
      
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

    public function saveIndividualProperty(){
        if(!$this->session->userdata('USER_ID')){
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
        
        $file_name = "property_img_".date("YmdHis");
        $file_element_name = 'property_image';
        $config['file_name'] = $file_name;
        $config['upload_path'] = 'upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '8000';
        $config['remove_spaces']  = true;
        $this->load->library('upload', $config);
        $this->load->library('image_lib'); 
        
        if ($this->upload->do_upload($file_element_name)) {
            
            $image_data = $this->upload->data();
	    $db_fileName = $image_data['orig_name'];
	    $ext = $image_data['file_ext'];
	    $db_filenamepath = 'upload/'.$db_fileName;
            
            
           $property_image_data = base64_encode(file_get_contents(base_url($db_filenamepath)));
            
            
        }
        
        $file_name = "property_qrimg_".date("YmdHis");
        $file_element_name = 'property_image_qr';
        $config['file_name'] = $file_name;
        $config['upload_path'] = 'upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '8000';
        $config['remove_spaces']  = true;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_element_name)) {
            
            $image_data = $this->upload->data();
	    $db_fileName = $image_data['orig_name'];
	    $ext = $image_data['file_ext'];
	    $db_filenamepath = 'upload/'.$db_fileName;
          
            
           $property_qrimage_data = base64_encode(file_get_contents(base_url($db_filenamepath)));
            
            
        }
        
        
        if(($property_image_data != "") && ($property_qrimage_data != ""))   {
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
        } elseif(($property_image_data != "") && ($property_qrimage_data == ""))  {
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
        } elseif(($property_image_data == "") && ($property_qrimage_data != ""))  {
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
            
        } elseif(($property_image_data == "") && ($property_qrimage_data == ""))  {
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
        redirect('dashboard/newproperty/'.$ward_no); 
        
        
        
    }

    public function updateproperty() {



        if(!$this->session->userdata('USER_ID')){
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

    public function propertylisting()  {
      $pagename = "property/all_properties";
      $title = "All Existing Household";
      $result = $this->tblProperty->allProperties();
      $data['allProperties'] = $result;
      $data['page_code'] = "DATA_TABLE";
      $this->page($pagename, $title, $data);
    }



    public function addproperty() {
      $pagename = "property/add_property";
      $link = "<a href='".base_url("manageproperty/propertylisting")."'>Property Listing</a>"."&nbsp;/&nbsp;" ;
      $title = $link."Add Property";
      //$data = "";
      $data = [];
      $circles = $this->tblCircle->getCircles();
      $data['circles'] = $circles;
      $this->page($pagename, $title, $data);
    }

    public function getWards()
    {
      $circle_id = $this->input->post('circle_id');
      $wards = $this->tblCircle->getWardsOfACircle($circle_id);
      $data = [];
      $data['wards'] = $wards;
      $statesString = $this->load->view('property/wards-select',$data,true);

      $response['wards'] = $statesString;
      echo json_encode($response);

    }

    public function saveproperty() {

        if(!$this->session->userdata('USER_ID')){
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

    
     public  function deleteApartment($pid) {
      $property = $this->tblProperty->allSurveyedPropertyData($pid);  
      $ward_no = $property->ward_no;
      $this->tblProperty->removeNewApartment($pid); 
      $this->session->set_flashdata('APPMSG', ' Property details deleted successfully ! ');
      redirect('dashboard/newproperty/'.$ward_no); 
    }


    public  function deleteIndividual($pid) {
      $property = $this->tblProperty->allSurveyedPropertyData($pid);  
      $ward_no = $property->ward_no;
      $this->tblProperty->removeNewIndividual($pid); 
      $this->session->set_flashdata('APPMSG', ' Property details deleted successfully ! ');
      redirect('dashboard/newproperty/'.$ward_no); 
    }
    
    
    public function viewapartment($pid) {
      
      $pagename = "property/viewApartment";
    
      $property = $this->tblDashboard->getApartmentDetails($pid);
      $buildingType = $this->tblDashboard->getallbuildingType();
      
      //$circle_id = $property->circle_id;
      $ward_no = $property->ward_no;
      //$circle_name = $this->tblDashboard->getCircleName($circle_id);
      
      
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/overallwardinfo/'.$ward_no)."'>Ward No.".$ward_no."</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "View Aparment Details";
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];

      
     
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
      
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/overallwardinfo/'.$ward_no)."'>Ward No.".$ward_no."</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "View Aparment Details";
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
      
      $data['isDateField'] = true;
      $data['maps'] = "MAP";
      $data['property'] = $property;
      $data['buildingType'] = $buildingType;
      $this->page($pagename, $title, $data);

    }

    public function propertyaudit() {
    $date = date("Y-m-d");
    $data['isDateField'] = true;
    $pagename = "property/property_audit";
    $title = "Property Audit";
    $data['circles'] = $this->tblCircle->getCircles();
    $this->page($pagename, $title, $data);
  }

  public function downloadAuditReport() {
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];    
    $ward_no = $_POST['ward'];
    if($ward_no=='')
    {
      /*$auditExist = $this->tblDashboard->checkAuditBydate($this->session->userdata('USER_ID'),$date);
      if($auditExist)
      {
        echo 'Create Excel By Date';
      }
      else
      {
        echo 'Property Date Audit not exist on this date';
      }*/
      $this->session->set_flashdata('APPMSG', ' Please select ward number ');
      redirect('manageproperty/propertyaudit'); 
    }
    else
    {
      $auditWardExist = $this->tblDashboard->checkAuditByWarddate($this->session->userdata('USER_ID'),$date_from,$date_to,$ward_no);
      if($auditWardExist)
      {
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'borders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
        $styleArray3 = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
      
        $reports = $this->tblDashboard->getAuditByWardDate($this->session->userdata('USER_ID'),$date_from,$date_to,$ward_no);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Property Audit Report');
       // Set the value of cell A1 
      
              
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "#SLNO"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(28);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->setCellValue('B1', "Property ID");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->setCellValue('C1', "Apartment Name");

        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->setCellValue('D1', "Owner Contact");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->setCellValue('E1', "Address"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $sheet->getStyle('F1')->getFont()->setBold(true);
        $sheet->setCellValue('F1', "Accuracy"); 

        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $sheet->getStyle('G1')->getFont()->setBold(true);
        $sheet->setCellValue('G1', "Latitude");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $sheet->getStyle('H1')->getFont()->setBold(true);
        $sheet->setCellValue('H1', "Longitude"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
        $sheet->getStyle('I1')->getFont()->setBold(true);
        $sheet->setCellValue('I1', "Data Capture Date");

        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(28);
        $sheet->getStyle('J1')->getFont()->setBold(true);
        $sheet->setCellValue('J1', "System Remark");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(22);
        $sheet->getStyle('K1')->getFont()->setBold(true);
        $sheet->setCellValue('K1', "Circle");

        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(22);
        $sheet->getStyle('L1')->getFont()->setBold(true);
        $sheet->setCellValue('L1', "Ward"); 

        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(22);
        $sheet->getStyle('M1')->getFont()->setBold(true);
        $sheet->setCellValue('M1', "Surveyor");  

        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(16);
        $sheet->getStyle('N1')->getFont()->setBold(true);
        $sheet->setCellValue('N1', "Surveyor Mobile"); 

        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(28);
        $sheet->getStyle('O1')->getFont()->setBold(true);
        $sheet->setCellValue('O1', "Vendor");

        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(28);
        $sheet->getStyle('P1')->getFont()->setBold(true);
        $sheet->setCellValue('P1', "Auditor");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(24);
        $sheet->getStyle('Q1')->getFont()->setBold(true);
        $sheet->setCellValue('Q1', "Remark");

        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(28);
        $sheet->getStyle('R1')->getFont()->setBold(true);
        $sheet->setCellValue('R1', "Address Verification Remark");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $sheet->getStyle('S1')->getFont()->setBold(true);
        $sheet->setCellValue('S1', "Audit Status"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(15);
        $sheet->getStyle('T1')->getFont()->setBold(true);
        $sheet->setCellValue('T1', "Call Status"); 

        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $sheet->getStyle('U1')->getFont()->setBold(true);
        $sheet->setCellValue('U1', "Call Date");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(28);
        $sheet->getStyle('V1')->getFont()->setBold(true);
        $sheet->setCellValue('V1', "Owner/Apartment Name");

        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(28);
        $sheet->getStyle('W1')->getFont()->setBold(true);
        $sheet->setCellValue('W1', "Updated Address");
        
        
        $rowNo =  2;
        $cellNo = "";
        $slno = 1;
        $static_ward_no = '';
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
          $cellF = "F".$rowNo  ; 
          $cellG = "G".$rowNo  ; 
          $cellH = "H".$rowNo  ; 
          $cellI = "I".$rowNo  ; 
          $cellJ = "J".$rowNo  ;
          $cellK = "K".$rowNo  ; 
          $cellL = "L".$rowNo  ; 
          $cellM = "M".$rowNo  ; 
          $cellN = "N".$rowNo  ; 
          $cellO = "O".$rowNo  ;
          $cellP = "P".$rowNo  ; 
          $cellQ = "Q".$rowNo  ; 
          $cellR = "R".$rowNo  ; 
          $cellS = "S".$rowNo  ;
          $cellT = "T".$rowNo  ; 
          $cellU = "U".$rowNo  ; 
          $cellV = "V".$rowNo  ; 
          $cellW = "W".$rowNo  ; 

          $accuracyCount = round($row->gpsaccuracy);
          $accuracyMsg = $accuracyCount>10?'Revisit Required':'Accuracy is good';
          $isreject = $row->isreject==0?'Approved':'Reject';
          $call_status = $row->call_status==0?'Approved':'Reject';
         
          $static_ward_no = $row->ward_no; 

          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, $row->pid);
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellC, $row->flatname);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellD, $row->mobile_no);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellE, $row->address_street);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellF, $row->gpsaccuracy);
          $sheet->getStyle($cellF)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellG, $row->latitude);
          $sheet->getStyle($cellG)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellH, $row->longitude);
          $sheet->getStyle($cellH)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellI, date('d/m/Y H:i',strtotime($row->date_updated)));
          $sheet->getStyle($cellI)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellI)->getAlignment()->setHorizontal('left');

          $sheet->setCellValue($cellJ, $accuracyMsg);
          $sheet->getStyle($cellJ)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellK, $row->circle_name);
          $sheet->getStyle($cellK)->applyFromArray($styleArray3); 

          $sheet->setCellValue($cellL, $row->ward_no);
          $sheet->getStyle($cellL)->applyFromArray($styleArray3); 

          $sheet->setCellValue($cellM, $row->first_name.' '.$row->last_name);
          $sheet->getStyle($cellM)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellN, $row->mobile);
          $sheet->getStyle($cellN)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellO, $row->vendor_name);
          $sheet->getStyle($cellO)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellP, $row->fname.' '.$row->lname);
          $sheet->getStyle($cellP)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellQ, $row->audit_remark);
          $sheet->getStyle($cellQ)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellR, $row->address_verification_remark);
          $sheet->getStyle($cellR)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellS, $isreject);
          $sheet->getStyle($cellS)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellT, $row->call_status);
          $sheet->getStyle($cellT)->applyFromArray($styleArray3);           

          $sheet->setCellValue($cellU, date('d/m/Y H:i',strtotime($row->call_date)));
          $sheet->getStyle($cellU)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellU)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellV, $row->owner_apt_name);
          $sheet->getStyle($cellV)->applyFromArray($styleArray3);

          $sheet->setCellValue($cellW, $row->updated_address);
          $sheet->getStyle($cellW)->applyFromArray($styleArray3); 
         
          $rowNo++;
          $slno++;   
        }
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'auditreport_'.date("dmYHis").'.xlsx' ;
        $reportFile = 'auditReport/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);
        
      }
      else
      {
        $this->session->set_flashdata('APPMSG', ' There is no audit report on this date ');
        redirect('manageproperty/propertyaudit'); 
      } 
    }
     
  }
  
  
  public function getPropertyByDate() {
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];    
    $ward_no = $_POST['ward_no'];
    $properties = $this->tblDashboard->getSurveyedPropertyByDate($ward_no, $date_from, $date_to);
    $data['properties'] = $properties;
    $data['date'] = $date_from;
    $this->load->vars($data);
    $this->load->view('property/searchresult');
  }
  public function savePropertyRemark() {
    
    $audit_remark = $_POST['elementRemark'];
    $isreject = $_POST['elementReject'];
    $p_record_id = $_POST['elementRecordId'];
    $address_remark = $_POST['elementAddressRemark'];
    $call_status = $_POST['elementCallStatus'];
    $call_date = $_POST['elementCallDate'];
    $owner_apt_name = $_POST['elementNewOwner'];
    $updated_address = $_POST['elementNewAddress'];
    
    $dbdata = array(
          'audited_by' => $this->session->userdata('USER_ID'), 
          'audit_remark' => $audit_remark, 
          'isreject' => $isreject
        );
    $dbdata1 = array(
          'p_record_id' => $p_record_id, 
          'user_id' => $this->session->userdata('USER_ID'), 
          'owner_apt_name' => $owner_apt_name,
          'updated_address' => $updated_address,
          'call_status' => $call_status,
          'address_verification_remark' => $address_remark,
          'call_date' => $call_date
        );
    $dbdata2 = array(
          'user_id' => $this->session->userdata('USER_ID'), 
          'owner_apt_name' => $owner_apt_name,
          'updated_address' => $updated_address,
          'call_status' => $call_status,
          'address_verification_remark' => $address_remark,
          'call_date' => $call_date
        );
    $pidExist = $this->tblDashboard->checkCallRemarkPid($p_record_id);
    if($pidExist)
    {
      $propertyCallRemark = $this->tblDashboard->updateCallRemark($p_record_id, $dbdata2);
    }
    else
    {
      $propertyCallRemark = $this->tblDashboard->insertCallRemark($dbdata1);
    }

    $propertyRemark = $this->tblDashboard->updatePropertyRemark($p_record_id, $dbdata);
    $data['propertyRemark'] = $propertyRemark;
  }  
public function exportPropertyPdf($warddate) {

    $this->load->library('Pdf');
     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
     $this->pdf->SetCreator(PDF_CREATOR);
     $this->pdf->SetAuthor('Valcho Motors Works');
     $this->pdf->SetTitle('Invoice');
     $this->pdf->SetSubject('Invoice - Valcho Motors Works');
     $this->pdf->SetKeywords('Valcho Motors Works, Itanagar, Arunachal Pradesh');
      // remove default header/footer
     $this->pdf->setPrintHeader(false);
     $this->pdf->setPrintFooter(false);

     // set default monospaced font
     $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

     // set margins
     $this->pdf->SetMargins(2, 2, true);

     // set auto page breaks
     $this->pdf->SetAutoPageBreak(TRUE, 0);

     // set image scale factor

     $this->pdf->SetPrintHeader(false);
     $this->pdf->SetPrintFooter(false);

     $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
     $this->pdf->AddPage('P', 'A4');
     $this->pdf->SetXY(2, 2);
     $this->pdf->SetFont('times', '', 10);
     $invoice_countersales_template = base_url("assets/property_report.html");
     $passLayout =  file_get_contents($invoice_countersales_template);

     
     $table_row = "";
     $table_td = "";
     $slno =  0;
     $ward_no = substr(strrchr($warddate, '-'), 1 );
     $date = substr( $warddate, 0, 10 );
     $properties = $this->tblDashboard->getSurveyedPropertyByDate($ward_no, $date);
     foreach ($properties as $row) {

      $filename = "download/".$date."/WardNo-".$row->ward_no."/qrcode_pic/qrcodepic_".$row->pid.'.jpeg';    
      $qrimage = base_url($filename); 

      $filename = "download/".$date."/WardNo-".$row->ward_no."/property_pic/pic_".$row->pid.'.jpeg';    
      $qrimage_property = base_url($filename); 
         
         $table_row .= "<tr>";
            $table_row .= "<td><table cellpadding=\"1\" cellspacing=\"1\">";
              $table_row .= "<tr>";
                $table_row .= "<td>Owner Name : </td>";
                $table_row .= "<td>".$row->owner_name."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>PID : </td>";
                $table_row .= "<td>".$row->pid."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>Ward No : </td>";
                $table_row .= "<td>".$row->ward_no."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>Updated Date : </td>";
                $table_row .= "<td>".$row->date_updated."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>Latitude : </td>";
                $table_row .= "<td>".$row->latitude."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>Longitude : </td>";
                $table_row .= "<td>".$row->longitude."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>QR Code : </td>";
                $table_row .= "<td>".$row->qr_code."</td>";
              $table_row .= "</tr>";
              $table_row .= "<tr>";
                $table_row .= "<td>Accuracy : </td>";
                $table_row .= "<td>".$row->gpsaccuracy."</td>";
              $table_row .= "</tr>";
            $table_row .= "</table></td>";
            $table_row .= "<td><img src=\"$qrimage_property\" style=\"width:auto;height:auto\"></td>";
            $table_row .= "<td><img src=\"$qrimage\" style=\"width:auto;height:auto\"></td>";
          $table_row .= "</tr>";

          $slno++;
     } 

    
   

       $passLayout = str_replace("#TRROW#" , $table_row, $passLayout);

     

       @$this->pdf->writeHTML($passLayout, true, false, true, false, '');
       $slno = date("YmdHis");
       $fileName =  "p-report-ward-".$ward_no.'-'.$date.".pdf";
       $pdf_file_path = $fileName;       
       $this->pdf->Output($pdf_file_path, 'F');

       $this->load->helper('download');
       $data = file_get_contents($pdf_file_path); // Read the file's contents
       $name = $fileName;
       force_download($name, $data); 
}
public function surveyorWiseQRInstalled() {
        
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $data['page_code'] = "DATA_TABLE";
        $pagename = "property/qrcode_installed_bysurveyor";
        $title = "Surveyor QR Code Installed Lists";
        if(isset($_POST['getReport']))
        {
          $date_from = $_POST['date_from'];
          $date_to = $_POST['date_to'];
          $vendor_id = $_POST['vendor_id'];
          $ward_no = $_POST['ward_no'];
          $data['wards'] = $this->tblDashboard->getSurWiseQRInstalled($date_from, $date_to, $vendor_id, $ward_no);
        }
        else
        {
          $data['wards'] = $this->tblDashboard->getTodaySurWiseQRInstalled();
        }
        
        $data['vendors'] = $this->tblDashboard->getAllVendors();
        $this->page($pagename, $title, $data);
    }
 public function dateWiseQRInstalled() {
        
	$date = date("Y-m-d");
        $data['isDateField'] = true;
        $data['page_code'] = "DATA_TABLE";
        $pagename = "property/qrcode_installed_bydate";
        $title = "Datewise QR Code Installed Lists";
        if(isset($_POST['getReport']))
        {
          $date_from = $_POST['date_from'];
          $date_to = $_POST['date_to'];
          $vendor_id = $_POST['vendor_id'];
          $ward_no = $_POST['ward_no'];
          $data['wards'] = $this->tblDashboard->getDateWiseQRInstalled($date_from, $date_to, $vendor_id, $ward_no);
        }
        else
        {
          $data['wards'] = $this->tblDashboard->getTodayQRInstalled();
        }
        
        $data['vendors'] = $this->tblDashboard->getAllVendors();
        $this->page($pagename, $title, $data);

    }    
	
    public function dateWardWiseQRInstallReport($wardno_date) {
        
        $reportdate = substr($wardno_date, 0, 10);
        $ward_no = substr($wardno_date, 11);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'borders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
        $styleArray3 = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
      
        $reports = $this->tblDashboard->getWardWiseTodaySurveyed($reportdate, $ward_no);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Daily QR Code Installed report');
       // Set the value of cell A1 
      
              
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "#SLNO"); 
        
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->setCellValue('B1', "Date");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->setCellValue('C1', "Ward No.");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->setCellValue('D1', "Surveyor Name"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->setCellValue('E1', "Total Survey"); 
        
       
        
        
        $rowNo =  2;
        $cellNo = "";
        $slno = 1;
        $static_ward_no = '';
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
         
          $static_ward_no = $row->ward_no; 

          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, date('d/m/Y',strtotime($row->date_updated)));
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $row->ward_no);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellD, $row->first_name.' '.$row->last_name);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE, $row->Survey_Done);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          
          if(intval($row->Survey_Done) == 0) {
             $sheet->getStyle($cellA.":".$cellE)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000'); 
          }
          
          $rowNo++;
          $slno++;   
        }
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'ward_'.$ward_no.'_'.date("dmY",strtotime($reportdate)).'.xlsx' ;
        $reportFile = 'qrinstallxlsreport/wardwise_today/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);
    }

    public function wardwisesurveyorsurveyed() {
        
        $data['page_code'] = "DATA_TABLE";
        $data['wards'] = $this->tblDashboard->getWardWiseAllCircles();
        $pagename = "property/wardwisesurveyor_surveyed";
        $title = "Wardwise Surveyor Surveyed Lists";
        $this->page($pagename, $title, $data);
    }

    public function totalsurveyorsurveyed($ward_no) {
        
        $data['surveyors'] = $this->tblDashboard->getWardWiseSurveyorSurveyed($ward_no);
        $pagename = "property/totalsurveyor_surveyed";
        $title = "Wardwise Surveyor Surveyed Lists";
        $this->page($pagename, $title, $data);
    }
    
    public function createExcel($ward_no) {
        
     

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'borders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
        $styleArray3 = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
      
        //$report_date = date('Y-m-d');
        $reports = $this->tblDashboard->createExcelWardWise($ward_no);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Daily QR Code Installed report');
       // Set the value of cell A1 
      
        /*$spreadsheet->getActiveSheet()->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "Report Date : ".$report_date); */
        
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "#SLNO"); 
        
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->setCellValue('B1', "Date");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->setCellValue('C1', "Ward No.");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->setCellValue('D1', "Surveyor Name"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->setCellValue('E1', "Total Survey"); 
        
       
        
        
        $rowNo =  2;
        $cellNo = "";
        $slno = 1;
        $static_ward_no = '';
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
         
          $static_ward_no = $row->ward_no; 

          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, date('d/m/Y',strtotime($row->date_updated)));
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $row->ward_no);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellD, $row->first_name.' '.$row->last_name);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE, $row->Survey_Done);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          
          if(intval($row->Survey_Done) == 0) {
             $sheet->getStyle($cellA.":".$cellE)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000'); 
          }
          
          $rowNo++;
          $slno++;   
        }
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'ward_'.$static_ward_no.'_'.date("dmY").'.xlsx' ;
        $reportFile = 'qrinstallxlsreport/wardwise_all/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);

    }

    public function createTodayExcel($ward_no) {
        
        /*$data['surveyors'] = $this->tblDashboard->getWardWiseTodaySurveyed($ward_no);
        $pagename = "property/exportTotalSurveyor_surveyed";
        @$this->load->view("property/exportTotalToday_surveyed",$data);*/

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'borders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
        $styleArray3 = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
      
        $reports = $this->tblDashboard->getWardWiseTodaySurveyed($ward_no);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Daily QR Code Installed report');
       // Set the value of cell A1 
      
              
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "#SLNO"); 
        
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->setCellValue('B1', "Date");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->setCellValue('C1', "Ward No.");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->setCellValue('D1', "Surveyor Name"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->setCellValue('E1', "Total Survey"); 
        
       
        
        
        $rowNo =  2;
        $cellNo = "";
        $slno = 1;
        $static_ward_no = '';
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
         
          $static_ward_no = $row->ward_no; 

          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, date('d/m/Y',strtotime($row->date_updated)));
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $row->ward_no);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellD, $row->first_name.' '.$row->last_name);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE, $row->Survey_Done);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          
          if(intval($row->Survey_Done) == 0) {
             $sheet->getStyle($cellA.":".$cellE)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000'); 
          }
          
          $rowNo++;
          $slno++;   
        }
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'ward_'.$static_ward_no.'_'.date("dmY").'.xlsx' ;
        $reportFile = 'qrinstallxlsreport/wardwise_today/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);
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
