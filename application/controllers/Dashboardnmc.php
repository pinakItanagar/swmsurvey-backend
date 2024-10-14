<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Dashboardnmc extends CI_Controller {

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
    }

   
    
    public function index() {
        $today = date("Y-m-d");
        $pagename = "dashboard_nmc";
        $title = "Dashboard";
        $data['today'] = $today;
        $data['oxygenEmergencyCount'] = 3;
        $data['remdesivirEmergencyCount'] = 10;
        $data['bedCount'] = 200000;
        $this->page($pagename, $title, $data);
    }
    
   
    
    public function page($pagename, $title, $data) {


        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $staticdata['header_script'] = 'template/include/header_scripts';
        $staticdata['app_header'] = 'template/include/app_header';
        $staticdata['app_sidemenu'] = 'template/include/app_nmc_sidemenu';
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
