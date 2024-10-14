<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
class Managepropertygis extends CI_Controller {

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
       $this->load->model('Master_gis', 'tblGIS');
    }



    public function listing() {
       
        $data['wards'] = $this->tblDashboard->getWardCircle();
        $pagename = "gis/circlewiseward";
        $title = "Ward wise map";
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);

    }
    
    public function wardmapview($ward_no) {
        
      $pagename = "gis/wardmapview";
     
      
      $circle = $this->tblDashboard->getCircleDetailsByWardID($ward_no);
      
      $bread_crum[0] = "<a href='".base_url('dashboard')."'>Dashboard</a>&nbsp;/&nbsp;" ;
      $bread_crum[1] = "<a href='".base_url('dashboard/viewward/'.$circle->circle_id)."'>".ucwords(strtolower($circle->circle_name))."</a>&nbsp;/&nbsp;" ;
      $bread_crum[2] = "Survey report ward No. ".$ward_no;
      
      $title = $bread_crum[0].$bread_crum[1].$bread_crum[2];
      
      $property_last = $this->tblDashboard->allWardSurveyedPropertyData($ward_no);
      
      $ward_details = $this->tblDashboard->getWardBoundary($ward_no);
      
      $total_missed_points = intval($this->tblGIS->totalMissedPoints($ward_no));
    
      if($ward_details->ward_boundary_file != "") {
          $data['isWardBoundary'] = "1";
          $data['ward_boundary'] = file_get_contents(base_url('upload/wardboundary/'.$ward_details->ward_boundary_file));
          $data['building'] = file_get_contents(base_url('upload/wardboundary/w_23_Building.geojson'));
      } else {
          $data['isWardBoundary'] = "0";
      }
      
      $data['circle'] = $circle;
      $data['ward_no'] = $ward_no;
      
     
      
      if($total_missed_points > 0 ) {
       $data['missed_point_exist'] = "1";  
       $data['all_missed_points']  = json_encode($this->tblGIS->getMissedPoints($ward_no));
      } else {
         $data['missed_point_exist'] = "0";     
      }
   
      $data['maps'] = "MAP";
      $data['property_last'] = json_encode($property_last);
      
      
      $this->page($pagename, $title, $data);
        
    }
    
    
    public function savemisspoints() {
        $ward_no = $_POST['ward_no'];   
        $ward_misspoints = json_decode($_POST['ward_misspoints']);   
        
        $this->tblGIS->deleteAllExistingMissedPoint($ward_no);
        
        for($i=0; $i<count($ward_misspoints); $i++) {
            if($ward_misspoints[$i][2] == "1") {
              $dbdata = array(
                'ward_no' => $ward_no, 
                'missed_lat' => $ward_misspoints[$i][0], 
                'missed_lng' => $ward_misspoints[$i][1]
              );
             $this->tblGIS->insertMissedPoints($dbdata);
            }
        }
        
        echo "Missed points added in geospatial database successfully !";
    }
    
    
    public function patna() {
      $title = "Boundary layer Patna City";   
      $pagename = "gis/patna";
      $geojson = base_url("upload/wardboundary/allWard.geojson");
      $data['patna'] = file_get_contents($geojson);
      $data['maps'] = "MAP";
      $this->page($pagename, $title, $data);
    }
    
    
    public function patna2() {
      $title = "Boundary layer Patna City";   
      $pagename = "gis/patna2";
      
      $geojson = base_url("upload/wardboundary/allWard.geojson");
      $data['patna'] = file_get_contents($geojson);
      
      $w23 = base_url("upload/wardboundary/ward23.geojson");
      $data['w23'] = file_get_contents($w23);
      
      $w22 = base_url("upload/wardboundary/ward22.geojson");
      $data['w22'] = file_get_contents($w22);
      
      $w21 = base_url("upload/wardboundary/ward21.geojson");
      $data['w21'] = file_get_contents($w21);
      
      $w36 = base_url("upload/wardboundary/ward36.geojson");
      $data['w36'] = file_get_contents($w36);
      
      $data['maps'] = "MAP";
      $this->page($pagename, $title, $data);
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
