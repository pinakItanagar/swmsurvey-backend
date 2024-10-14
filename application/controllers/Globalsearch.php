<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");




class Globalsearch extends CI_Controller {

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
        $this->load->model('Master_search', 'tblSearch');
    }

    public function property() {
        $search = trim($_POST['search']) ;
        
       
       
        if(preg_match("/^([a-zA-Z' ]+)$/", $search) ==  "1") {
           $field_type = "OWNER" ;
        } elseif(preg_match("/^PMC\d{7}/", $search) ==  "1") {
           $field_type = "QRCODE" ; 
        } else {
           $field_type = "MOBILE" ; 
        }
        
        if($field_type == "OWNER") {
         $details = $this->tblSearch->searchByOwner($search );
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
