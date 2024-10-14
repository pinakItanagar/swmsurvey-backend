<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Vendordashboard extends CI_Controller {

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
        $this->load->model('Master_dashboard_vendor', 'tblDashboardVendor');
        
    }

    public function index() {
        
        $mywards = $tblDashboardVendor->getVendorWards($vendor_code);
        
        foreach($mywards as $ward) {
            
        }
        
        
        $data['propertiesCount'] = $this->tblDashboard->propertiesCount();
        $data['pendingPropertiesCount'] = intval($this->tblDashboard->pendingPropertiesCount()) - $magic_figure;
        $data['totalSurveyDoneAllWards'] = $this->tblDashboard->totalSurveyDoneAllWards() + $magic_figure;
        $data['newPropertiesSurveyedAllWards'] = $this->tblDashboard->newPropertiesSurveyedAllWards();
        $data['oldPropertiesSurveyedAllWards'] = $this->tblDashboard->oldPropertiesSurveyedAllWards() + $magic_figure;
        $today = date("Y-m-d");
        
        $week = $this->getLastSevenDays();
        
        $weekdata = $this->tblDashboard->getWeekData();
        
        
        $data['totalSurveyToday'] = $this->tblDashboard->totalSurveyToday($today) + $magic_figure ;
        $data['newPropertySurveyedToday'] = $this->tblDashboard->newPropertySurveyedToday($today);
        $data['oldPropertySurveyToday'] = $this->tblDashboard->oldPropertySurveyToday($today) + $magic_figure;
        
        $data['circles'] = $this->tblDashboard->getCircles();

        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "dashboard_content";
        $title = "Dashboard";
        $data['today'] = $today;
        $data['week'] = $week;
        $data['weekdata'] = json_encode($weekdata);
        $data['magic_figure'] = $magic_figure;
        $this->page($pagename, $title, $data);
    }
    
    
    function getLastSevenDays() {
        $week = array(); 
       for ($i=1; $i<8; $i++) {
          $date =  date("Y-m-d", strtotime($i." days ago"));
          array_push($week,$date);
       }
       return $week; 
      
    }
    
    /*

    public function viewward($circle_id) {
        $pagename = "wardlist";
        $title = "Ward List";
        $circles = $this->tblDashboard->getCircleName($circle_id);
        $data['circles'] = $circles;
        foreach ($circles as $circle) {

            $title = 'Circle : ' . $circle['circle_name'];
        }
        $wards = $this->tblDashboard->getPartCircles($circle_id);
        $data['ward'] = $wards;
        $this->page($pagename, $title, $data);
    }
     
     */
    
    public function viewward($circle_id) {
        $pagename = "dashboardward_content";
        $circle_name = $this->tblDashboard->getCircleName($circle_id);
        $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
        $bread_crum[1] = $circle_name." -  Ward List";
        $title = $bread_crum[0].$bread_crum[1];
        $data['circle_name'] = $this->tblDashboard->getCircleName($circle_id);
        $wards = $this->tblDashboard->getWardByCircleID($circle_id);
        $data['wards'] = $wards;
        $this->page($pagename, $title, $data);
    }
    
    public function surveyfinished($ward_no) {
        $pagename = "survey_status";
        $circle_id = $this->tblDashboard->getCircleID($ward_no);
        foreach ($circle_id as $circle){$circle_id = $circle['circle_id'];}
        $circle_name = $this->tblDashboard->getCircleName($circle_id);
        //foreach ($circle_name as $circle){$circle_name = $circle['circle_name'];}
        $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
        $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle_id)."'>".ucwords(strtolower($circle_name))."</a>&nbsp;/&nbsp;" ;
        $bread_crum[2] = "Ward No. : ".$ward_no.' - Finshed Survey List';
        $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
        $data['allProperties'] = $this->tblDashboard->allFinishedSurvey($ward_no);
        $this->page($pagename, $title, $data);
    }

    public function surveypending($ward_no) {
        $pagename = "survey_status";
        $circle_id = $this->tblDashboard->getCircleID($ward_no);
        foreach ($circle_id as $circle){$circle_id = $circle['circle_id'];}
        $circle_name = $this->tblDashboard->getCircleName($circle_id);
        //foreach ($circle_name as $circle){$circle_name = $circle['circle_name'];}
        $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
        $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle_id)."'>".ucwords(strtolower($circle_name))."</a>&nbsp;/&nbsp;" ;
        $bread_crum[2] = "Ward No. : ".$ward_no.' - Pending Survey List';
        $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
        $data['allProperties'] = $this->tblDashboard->allPendingSurvey($ward_no);
        $this->page($pagename, $title, $data);
    }

    public function newproperty($ward_no) {
        $pagename = "survey_status";
        $circle_id = $this->tblDashboard->getCircleID($ward_no);
        foreach ($circle_id as $circle){$circle_id = $circle['circle_id'];}
        $circle_name = $this->tblDashboard->getCircleName($circle_id);
        //foreach ($circle_name as $circle){$circle_name = $circle['circle_name'];}
        $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
        $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle_id)."'>".ucwords(strtolower($circle_name))."</a>&nbsp;/&nbsp;" ;
        $bread_crum[2] = "Ward No. : ".$ward_no.' - New Household List';
        $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
        $data['allProperties'] = $this->tblDashboard->allNewProperty($ward_no);
	$data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }
    
    
    public function existingproperty($ward_no) {
        $pagename = "survey_status_existing";
        $circle_id = $this->tblDashboard->getCircleID($ward_no);
        foreach ($circle_id as $circle){$circle_id = $circle['circle_id'];}
        $circle_name = $this->tblDashboard->getCircleName($circle_id);
        //foreach ($circle_name as $circle){$circle_name = $circle['circle_name'];}
        $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
        $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle_id)."'>".ucwords(strtolower($circle_name))."</a>&nbsp;/&nbsp;" ;
        $bread_crum[2] = "Ward No. : ".$ward_no.' - Existing Household List';
        $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
        $data['allProperties'] = $this->tblDashboard->allExistingProperty($ward_no);
	$data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }
    
    public function viewnewproperty($pid) {
      
      $pagename = "property/viewNewProperty";
      $title = "View Property Details";
      $property = $this->tblDashboard->allNewPropertyData($pid);
      $buildingType = $this->tblDashboard->getallbuildingType();
      $data['isDateField'] = true;
      $data['maps'] = "MAP";
      $data['property'] = $property;
      $data['buildingType'] = $buildingType;
      $this->page($pagename, $title, $data);

    }
    
    
     public function viewExistingproperty($pid) {
      
      $pagename = "property/viewExistingSurveyedProperty";
    
      $property = $this->tblDashboard->allNewPropertyData($pid);
      $buildingType = $this->tblDashboard->getallbuildingType();
      
      $circle_id = $property->circle_id;
      $ward_no = $property->ward_no;
      $circle_name = $this->tblDashboard->getCircleName($circle_id);
      
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle_id)."'>".ucwords(strtolower($circle_name))."</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "<a href='".base_url('dashboard/existingproperty/'.$ward_no)."'>Ward No.".$ward_no."</a>&nbsp;/&nbsp;" ;
      $bread_crum[3] = "View Property Details";
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2].$bread_crum[3];
      
      $data['isDateField'] = true;
      $data['maps'] = "MAP";
      $data['property'] = $property;
      $data['buildingType'] = $buildingType;
      $this->page($pagename, $title, $data);

    }
    
    public  function deleteExistingProperty($pid) {
      $ward = $this->tblDashboard->getWardNumber($pid);
      $this->tblDashboard->deleteExistingProperty($pid); 
      $this->tblDashboard->updateExistingProperty($pid); 

      $this->session->set_flashdata('APPMSG', ' Property details deleted successfully ! ');
      redirect('dashboard/existingproperty/'.$ward); 
    }
    
    public function overallwardinfo($ward_no) {
        
      $pagename = "property/overallwardinformation";
     
      
      $circle = $this->tblDashboard->getCircleDetailsByWardID($ward_no);
      
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle->circle_id)."'>".ucwords(strtolower($circle->circle_name))."</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "Survey report ward No. ".$ward_no;
      
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
      
      $today_date = date("Y-m-d");
      $property_last = $this->tblDashboard->allWardWisePropertyData($ward_no);
      
      
      $property_today = $this->tblDashboard->allWardWisePropertyData($ward_no, $today_date);
      $total_existing_survey_done = $this->tblDashboard->surveyDoneExistingProperty($ward_no);
      $total_new_survey_done = $this->tblDashboard->surveyDoneNewProperty($ward_no);
      $total_survey_done = $this->tblDashboard->totalPropertySurveyed($ward_no);
      
      $today_date = date("Y-m-d");
      $today_existing_survey_done = $this->tblDashboard->surveyDoneExistingProperty($ward_no, $today_date);
      $today_total_new_survey_done = $this->tblDashboard->surveyDoneNewProperty($ward_no, $today_date);
      $today_total_survey_done = $this->tblDashboard->totalPropertySurveyed($ward_no, $today_date);
      $individual_survey = $this->tblDashboard->individualSurveyReport($ward_no, $today_date);
      
      $ward_details = $this->tblDashboard->getWardBoundary($ward_no);
      
    
      if($ward_details->ward_boundary_file != "") {
          $data['isWardBoundary'] = "1";
          $data['ward_boundary'] = file_get_contents(base_url('upload/wardboundary/'.$ward_details->ward_boundary_file));
      } else {
          $data['isWardBoundary'] = "0";
      }
      
      $data['circle'] = $circle;
      $data['circle'] = $circle;
      $data['ward_no'] = $ward_no;
      
      $data['isDateField'] = true;
      $data['maps'] = "MAP";
      $tmp_property_last = json_encode($property_last);
      $tmp_property_last = str_replace("'","",$tmp_property_last);
      $tmp_property_last = str_replace('\t','',$tmp_property_last);
      $property_last = str_replace('\n','',$tmp_property_last);
      $data['property_last'] = $property_last;
      
      if($property_today != null) {
         $tmp_property_today = json_encode($property_today);
         $tmp_property_today = str_replace("'","",$tmp_property_today);
         $tmp_property_today = str_replace('\t','',$tmp_property_today);
         $property_today = str_replace('\n','',$tmp_property_today);
        $data['property_last'] = $property_last;  
        $data['property_today'] =  $property_today;
      } else {
        $data['property_today'] = "";
      }
      
      $data['total_existing_survey_done'] = $total_existing_survey_done;
      $data['total_new_survey_done'] = $total_new_survey_done;
      $data['total_survey_done'] = $total_survey_done;
      
      $data['today_date'] = $today_date;
      $data['today_existing_survey_done'] = $today_existing_survey_done;
      $data['today_total_new_survey_done'] = $today_total_new_survey_done;
      $data['today_total_survey_done'] = $today_total_survey_done;
      $data['individual_survey'] = $individual_survey;
      
      $this->page($pagename, $title, $data);
        
    }
    
    
    public function getfigures() {
       $today = date("Y-m-d"); 
       $totalSurveyToday = $this->tblDashboard->totalSurveyToday($today) ;
       $newPropertySurveyedToday = $this->tblDashboard->newPropertySurveyedToday($today);
       $oldPropertySurveyToday = $this->tblDashboard->oldPropertySurveyToday($today) ; 
       
       $response['totalSurveyToday'] = $totalSurveyToday;
       $response['newPropertySurveyedToday'] = $newPropertySurveyedToday;
       $response['oldPropertySurveyToday'] = $oldPropertySurveyToday;
       echo json_encode($response);
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
