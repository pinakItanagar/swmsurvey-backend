<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class managesurveyor extends CI_Controller {

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
        $this->load->model('Master_user', 'tblUser');
        $this->load->model('Master_surveyor', 'tblSurveyor');
        $this->load->model('Master_wardwisesurveyor', 'tblSurveyors');
        $this->load->model('Master_circle', 'tblCircle');
    }

    public function wardwisesurveyor() {
        $pagename = "surveyor/add_wardwisesurveyor";
        $title = "Assign Ward to Surveyor";
        $surveyors = $this->tblSurveyors->getSurveyors();
        $data = [];
        $data['surveyors'] = $surveyors;

        $circles = $this->tblCircle->getCircles();
        $data['circles'] = $circles;
        $this->page($pagename, $title, $data);
    }

    public function getWards() {
        $circle_id = $this->input->post('circle_id');
        $wards = $this->tblCircle->getWardsOfACircle($circle_id);
        $data = [];
        $data['wards'] = $wards;
        $statesString = $this->load->view('surveyor/wards-select', $data, true);

        $response['wards'] = $statesString;
        echo json_encode($response);
    }

    public function listing() {
        $pagename = "surveyor/all_surveyors";
        $title = "All Surveyors";
        $result = $this->tblSurveyor->allSurveyors();
        $data['allSurveyors'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function wardlisting() {
        $pagename = "surveyor/all_wardwisesurveyors";
        $title = "Assigned Ward to Surveyor";
        $result = $this->tblSurveyor->wardWiseSurveyorDetails();
        $data['allAssignsurveyors'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function addsurveyor() {
        $pagename = "surveyor/add_surveyor";
        $link = "<a href='" . base_url("managesurveyor/listing") . "'>Surveyor Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Add Surveyor";
        $vendors = $this->tblSurveyor->getAllVendors();
        $data['vendors'] = $vendors;
        $this->page($pagename, $title, $data);
    }

    public function assignsurveyor() {



        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $surveyor_id = $_POST['surveyor_name'];
        $ward_id = $_POST['ward'];


        $dbdata = array(
            'wardId' => $ward_id,
            'status' => 1
        );
        $this->tblSurveyor->updateWardsurveyor($surveyor_id, $dbdata);
        //$pagename = "managesurveyor/wardwisesurveyor/";

        $this->session->set_flashdata('APPMSG', ' Surveyor assign successfully ! ');

        redirect('managesurveyor/wardlisting');
        //redirect('managesurveyor/wardwisesurveyor/'.$surveyor_id); 
    }

    public function issueregister() {
        $pagename = "surveyor/issue_register";
        $title = "Surveyor-Wise Total QR Code Issued";
        $result = $this->tblSurveyor->allIssues();
        $data['allIssues'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function issueregistervendor() {
        $pagename = "surveyor/issue_register_vendorwise";
        $title = "Vendor--Wise Total QR Code Issued";
        $result = $this->tblSurveyor->allIssuesVendorWise();
        $data['allIssues'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function issueregistervendordate() {
        $pagename = "surveyor/issue_register_datewise";
        $title = "Date-Wise Total QR Code Issued";
        $result = $this->tblSurveyor->allIssuesDateWise();
        $data['allIssues'] = $result;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function exportQrDateWise() {
        $data['allIssues'] = $this->tblSurveyor->allIssuesDateWise();
        ;
        @$this->load->view("surveyor/exportTotalQR_datewise", $data);
    }

    public function exportQrSurveyorWise() {
        $data['allIssues'] = $this->tblSurveyor->allIssues();
        ;
        @$this->load->view("surveyor/exportTotalQR_surveyorwise", $data);
    }

    public function addissue($userId = NULL) {
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "surveyor/add_issue";
        $link = "<a href='" . base_url("managesurveyor/issueregister") . "'>All Surveyor Issue Register Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Issue Register";
        $data['surveyors'] = $this->tblSurveyor->getSurveyorInfo($userId);
        $data['issues'] = $this->tblSurveyor->getIssueInfo($userId);
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function editIssue($issueId = NULL) {

        $surveyor = $this->tblSurveyor->getIssueSurveyorId($issueId);

        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "surveyor/edit_issue";
        $data['issues'] = $this->tblSurveyor->getIssueIdInfo($issueId);
        $link = "<a href='" . base_url("managesurveyor/issueregister") . "'>All Surveyor Issue Register Listing</a>" . "&nbsp;/&nbsp;";
        $link .= "<a href='" . base_url("managesurveyor/addissue/" . $surveyor) . "'>Add Issue Register Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Issue Register-Update";
        $this->page($pagename, $title, $data);
    }

    public function saveissue() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $surveyor = trim($this->security->xss_clean($_POST['surveyor']));
        $start_qr_serial_no = trim($this->security->xss_clean($_POST['start_qr_serial_no']));
        $end_qr_serial_no = trim($this->security->xss_clean($_POST['end_qr_serial_no']));
        $total_qr_code = trim($this->security->xss_clean($_POST['total_qr_code']));
        $issue_date = trim($this->security->xss_clean($_POST['issue_date']));
        $vendor_id = trim($this->security->xss_clean($_POST['vendor_id']));
        $screw = trim($this->security->xss_clean($_POST['screw']));
        $anchor_wall = trim($this->security->xss_clean($_POST['anchor_wall']));


        $dbdata = array(
            'vendor_id' => $vendor_id,
            'surveyor_id' => $surveyor,
            'start_qr_serial_no' => $start_qr_serial_no,
            'end_qr_serial_no' => $end_qr_serial_no,
            'total_qr_code' => $total_qr_code,
            'issue_date' => $issue_date,
            'screw' => $screw,
            'anchor_wall' => $anchor_wall
        );
        $this->tblSurveyor->insertIssue($dbdata);


        $this->session->set_flashdata('APPMSG', ' Issue details added successfully ! ');
        redirect('managesurveyor/issueregister/');
    }

    public function updateIssue($issueId = NULL) {


        if ($issueId == null) {
            redirect('managesurveyor/issueregister/');
        }


        $start_qr_serial_no = trim($this->security->xss_clean($_POST['start_qr_serial_no']));
        $end_qr_serial_no = trim($this->security->xss_clean($_POST['end_qr_serial_no']));
        $total_qr_code = trim($this->security->xss_clean($_POST['total_qr_code']));
        $total_damage = trim($this->security->xss_clean($_POST['total_damage']));
        $total_qrcode_issued = trim($this->security->xss_clean($_POST['total_qrcode_issued']));
        $issue_date = trim($this->security->xss_clean($_POST['issue_date']));
        $vendor_id = trim($this->security->xss_clean($_POST['vendor_id']));
        $screw = trim($this->security->xss_clean($_POST['screw']));
        $anchor_wall = trim($this->security->xss_clean($_POST['anchor_wall']));



        $dbdata = array(
            'start_qr_serial_no' => $start_qr_serial_no,
            'end_qr_serial_no' => $end_qr_serial_no,
            'total_qr_code' => $total_qr_code,
            'total_damage' => $total_damage,
            'total_qrcode_issued' => $total_qrcode_issued,
            'issue_date' => $issue_date,
            'screw' => $screw,
            'anchor_wall' => $anchor_wall
        );
        $this->tblSurveyor->updateIssue($issueId, $dbdata);


        $this->session->set_flashdata('APPMSG', ' Issue details updated successfully ! ');
        redirect('managesurveyor/issueregister/');
    }

    public function deleteIssue($issueId) {
        $this->tblSurveyor->removeIssue($issueId);
        $this->session->set_flashdata('APPMSG', ' Issue details deleted successfully ! ');
        redirect('managesurveyor/issueregister/');
    }

    public function save() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $first_name = strtoupper(trim($this->security->xss_clean($_POST['first_name'])));
        $last_name = strtoupper(trim($this->security->xss_clean($_POST['last_name'])));
        $mobile = strtoupper(trim($this->security->xss_clean($_POST['mobile'])));
        $address = strtoupper(trim($this->security->xss_clean($_POST['address'])));
        $surveyor_password = trim($this->security->xss_clean($_POST['surveyor_password']));
        $vendor_id = trim($this->security->xss_clean($_POST['vendor_id']));


        $dbdata = array(
            'surveyor_password' => $surveyor_password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile' => $mobile,
            'address' => $address,
            'vendor_id' => $vendor_id
        );
        $this->tblSurveyor->insertSurveyor($dbdata);


        $this->session->set_flashdata('APPMSG', ' Surveyor added successfully ! ');
        redirect('managesurveyor/listing/');
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
