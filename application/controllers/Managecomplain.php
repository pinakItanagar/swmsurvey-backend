<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class managecomplain extends CI_Controller {

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
        $this->load->model('Master_complain', 'tblComplain');
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

    public function vendorlisting() {
        $pagename = "surveyor/all_vendors";
        $title = "All Vendors";
        $vendors = $this->tblSurveyor->getWardVendors();
        $data['allVendors'] = $vendors;
        $data['page_code'] = "DATA_TABLE";
        $this->page($pagename, $title, $data);
    }

    public function assignvendor($vendor_id) {
        $pagename = "surveyor/assign_vendor";
        $link = "<a href='" . base_url("managesurveyor/vendorlisting") . "'>Vendor Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Assign Vendor";
        $vendors = $this->tblSurveyor->getParticularVendor($vendor_id);
        $data['vendors'] = $vendors;
        $this->page($pagename, $title, $data);
    }

    public function assignvendorward() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $ward_no = trim($this->security->xss_clean($_POST['new_ward']));
        $vendor_code = trim($this->security->xss_clean($_POST['vendor_code']));
        $result = $this->tblSurveyor->checkWardNo($ward_no);
        if($result)
        {
            $this->session->set_flashdata('APPMSG', ' Ward No. '.$ward_no.' already assigned for vendor--( ' . $result.' )');
            redirect('managesurveyor/assignvendor/'.$vendor_code);
        }
        else
        {
            $dbdata = array(
                'ward_no' => $ward_no,
                'vendor_code' =>  $vendor_code
            );
            $this->tblSurveyor->addNewWardVendor($dbdata);
            $this->session->set_flashdata('APPMSG', 'Ward No. : '.$ward_no.' is assigned successfully ! ');
            redirect('managesurveyor/vendorlisting');
        }
    }

    public function listing() {
        $pagename = "swachhata_complain/all_complains";
        $title = "All Complains";
        $result = $this->tblComplain->allComplains();
        $data['allComplains'] = $result;
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

    public function addcomplain() {
        $pagename = "swachhata_complain/add_complain";
        $link = "<a href='" . base_url("managecomplain/listing") . "'>Complain Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Add Complain";
        $circles = $this->tblCircle->getCircles();
        $data['circles'] = $circles;
        $complain_sub_type = $this->tblComplain->getAllSubComplainType();
        $data['complain_sub_type'] = $complain_sub_type;
        $this->page($pagename, $title, $data);
    }
    
    public function editsurveyor($surveyor_id) {
        $pagename = "surveyor/edit_surveyor";
        $link = "<a href='" . base_url("managesurveyor/listing") . "'>Surveyor Listing</a>" . "&nbsp;/&nbsp;";
        $title = $link . "Edit Surveyor";
        $data['surveyors'] = $this->tblSurveyor->getSurveyorInfo($surveyor_id);
        $vendors = $this->tblSurveyor->getAllVendors();
        $data['vendors'] = $vendors;
        $this->page($pagename, $title, $data);
    }

    public function updatesurveyor() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $first_name = trim($this->security->xss_clean($_POST['first_name']));
        $last_name = trim($this->security->xss_clean($_POST['last_name']));
        $mobile = trim($this->security->xss_clean($_POST['mobile']));
        $surveyor_password = trim($this->security->xss_clean($_POST['surveyor_password']));
        $address = trim($this->security->xss_clean($_POST['address']));
        $vendor_id = trim($this->security->xss_clean($_POST['vendor_id']));
        $active_surveyor = trim($this->security->xss_clean($_POST['active_surveyor']));
        $surveyor_id = trim($this->security->xss_clean($_POST['surveyor_id']));


        $dbdata = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile' => $mobile,
            'surveyor_password' => $surveyor_password,
            'address' => $address,
            'vendor_id' => $vendor_id,
            'isActive' => $active_surveyor
        );
        $dbdata1 = array(
            'userId' => $surveyor_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile' => $mobile,
            'surveyor_password' => $surveyor_password,
            'address' => $address,
            'vendor_id' => $vendor_id,
            'isActive' => $active_surveyor
        );
        $result = $this->tblSurveyor->updateSurveyor($dbdata, 'userId', $surveyor_id);

        if($result)
        {
            $postdata = json_encode($dbdata1);
            $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postdata)
            ]
        ];
        $handler = curl_init("http://evergreenmazbat.org/cloud_data/updateSurveyor.php");
        curl_setopt_array($handler, $options);
        $resp = curl_exec($handler);
        curl_close($handler);

        	$this->session->set_flashdata('APPMSG', ' Surveyor details updated successfully ! ');
        	redirect('managesurveyor/listing/');
        }
        else
        {
            $this->session->set_flashdata('APPMSG', ' Surveyor details not updated ! ');
        	redirect('managesurveyor/listing/');
        }

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
	$dbdata1 = array(
            'userId' => $surveyor_id,
	    'wardId' => $ward_id,
	    'status' => 1
        );
        
        $result = $this->tblSurveyor->updateWardsurveyor($surveyor_id, $dbdata);

        if($result)
        {
            $postdata = json_encode($dbdata1);
            $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postdata)
            ]
        ];
        $handler = curl_init("http://evergreenmazbat.org/cloud_data/assignSurveyor.php");
        curl_setopt_array($handler, $options);
        $resp = curl_exec($handler);
        curl_close($handler);

        $this->session->set_flashdata('APPMSG', ' Ward assign successfully ! ');
            redirect('managesurveyor/wardlisting/');
        }
        else
        {
            $this->session->set_flashdata('APPMSG', ' Ward does not assign! ');
            redirect('managesurveyor/wardlisting/');
        }
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

    public function qrInstalledVsIssued() {
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $data['page_code'] = "DATA_TABLE";
        $data['issued'] = $this->tblSurveyor->getQRIssued();
        $data['installed'] = $this->tblSurveyor->getQRInstalled();
        $pagename = "surveyor/qr_installed_issued";
        $title = "QR Code Issued Versus Installed Lists";
        $this->page($pagename, $title, $data);
    }

    public function saveVendorRemark()
    {
        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $vendor_code = trim($this->security->xss_clean($_POST['vendor_code']));
        $vendor_remark = trim($this->security->xss_clean($_POST['vendor_remark']));
        

        $dbdata = array( 'vendor_remark' => $vendor_remark );
        $this->tblSurveyor->updateVendorRemark($vendor_code, $dbdata);
        echo "Successfully updated";

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
        $data['vendors'] = $this->tblSurveyor->getAllVendors();
        //$data['page_code'] = "DATA_TABLE";
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

        $vendor_code = trim($this->security->xss_clean($_POST['vendor_id']));
        $issue_to = trim($this->security->xss_clean($_POST['issue_to']));
        $nils = trim($this->security->xss_clean($_POST['screw']));
        $glass = trim($this->security->xss_clean($_POST['glass']));
        $gulli_anchor = trim($this->security->xss_clean($_POST['anchor_wall']));
        $issue_date = trim($this->security->xss_clean($_POST['issue_date']));
        

        for ($i=1; $i < 21; $i++) { 
            $sr_start = trim($this->security->xss_clean((int)$_POST['sr_start_'.$i]));
            $sr_end = trim($this->security->xss_clean((int)$_POST['sr_end_'.$i]));
            $total_qrcode = trim($this->security->xss_clean((int)$_POST['total_qr_'.$i]));
            if($total_qrcode>0)
            {
                $dbdata = array(
                    'issue_date' => $issue_date,
                    'vendor_code' => $vendor_code,
                    'sr_start' => $sr_start,
                    'sr_end' => $sr_end,
                    'gulli_anchor' => $gulli_anchor,
                    'nils' => $nils,
                    'glass' => $glass,
                    'total_qrcode' => $total_qrcode,
                    'received_by' => $issue_to
                );
                $this->tblSurveyor->insertIssue($dbdata);
                $nils = 0;
                $glass = 0;
                $gulli_anchor = 0;
            }
        }


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

    /*public function save() {

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
    }*/
    public function save() {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $mode_id = strtoupper(trim($this->security->xss_clean($_POST['mode_id'])));
        $circle_id = strtoupper(trim($this->security->xss_clean($_POST['circle_id'])));
        $ward = strtoupper(trim($this->security->xss_clean($_POST['ward'])));
        $sector = strtoupper(trim($this->security->xss_clean($_POST['sector'])));
        $category_id = strtoupper(trim($this->security->xss_clean($_POST['category_id'])));
        $sub_category_id = trim($this->security->xss_clean($_POST['sub_category_id']));
        $complain_location = trim($this->security->xss_clean($_POST['complain_location']));
        $complain_latitude = strtoupper(trim($this->security->xss_clean($_POST['complain_latitude'])));
        $complain_longitude = strtoupper(trim($this->security->xss_clean($_POST['complain_longitude'])));
        $complain_landmak = strtoupper(trim($this->security->xss_clean($_POST['complain_landmak'])));
        $complain_description = trim($this->security->xss_clean($_POST['complain_description']));
        $complain_file = trim($this->security->xss_clean($_POST['complain_file']));
        $shousehold_name = strtoupper(trim($this->security->xss_clean($_POST['shousehold_name'])));
        $shousehold_mobile = trim($this->security->xss_clean($_POST['shousehold_mobile']));
        $shousehold_email = trim($this->security->xss_clean($_POST['shousehold_email']));

        $checkMobileNo = $this->tblComplain->checkMobileNo($shousehold_mobile);
        if(!$checkMobileNo)
        {
            $dbdata = array(
            'shousehold_name' => $shousehold_name,
            'shousehold_mobile' => $shousehold_mobile,
            'shousehold_email' => $shousehold_email
            );
            $checkMobileNo = $this->tblComplain->insertHousehold($dbdata);
        }
        $fetchMaxComplaint = $this->tblComplain->fetchMaxComplaint();

        $next_coupon = $mode_id==1 ? 'SM-PMC0000000'.$fetchMaxComplaint+1 : 'SM-PMC0000000'.'1';

        //Check whether user upload picture
        if(!empty($_FILES['complain_file']['name'])){
            $config['upload_path'] = 'complaintImage/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG|jpeg|JPEG|jfif|JFIF';
            $config['file_name'] = $_FILES['complain_file']['name'];
            
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('complain_file')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            }else{
                $picture = '';
            }
        }else{
            $picture = '';
        }   
                   
           
        $dbdata1 = array(
            'complain_no' => $next_coupon,  
            'household_id' => $checkMobileNo,  
            'circle_id' => $circle_id,  
            'ward_no' => $ward,  
            'sector' => $sector,  
            'mode_id' => $mode_id,  
            'category_id' => $category_id,  
            'sub_category_id' => $sub_category_id,  
            'subject' => '',  
            'complain_description' => $complain_description,  
            'complain_location' => $complain_location, 
            'complain_latitude' => $complain_latitude, 
            'complain_longitude' => $complain_longitude, 
            'complain_file' => $picture, 
            'complain_landmak' => $complain_landmak
        );
        $result1 = $this->tblComplain->insertComplain($dbdata1);
        if($result1)
        
        {

            
            
  //       if($result)
  //       {
  //       	$postdata = json_encode($dbdata);
  //       	$options = [
		//     CURLOPT_POST => true,
		//     CURLOPT_POSTFIELDS => $postdata,
		//     CURLOPT_HTTPHEADER => [
		//         'Content-Type: application/json',
		//         'Content-Length: ' . strlen($postdata)
		//     ]
		// ];
		// $handler = curl_init("http://evergreenmazbat.org/cloud_data/insertNewSurveyor.php");
		// curl_setopt_array($handler, $options);
		// $resp = curl_exec($handler);
		// curl_close($handler);

		$this->session->set_flashdata('APPMSG', ' Complain registered successfully ! ');
        	redirect('managecomplain/listing/');

		
        }
    
        else
        {
        	$this->session->set_flashdata('APPMSG', ' Complain does not registered! ');
        	redirect('managecomplain/listing/');
        }
    }


    public function postSBMComplain() {

    	  $mobile_number = "8974094931"; 
    	  $categoryId = 1;
    	  $latitude = "25.60423271";
    	  $longitude = "85.134943" ;
    	  $complaintLocation = "Patliputra West";
    	  $complaintLandmark = "Near PMC office";
    	  $fullName = "Ashok Kumar";
    	  $image_url = "http://164.52.207.234/psc/complaintImage/property_img_20201217233211.jpg" ;


    	  $pay_load = "vendor_name=Patna&access_key=bkm2zvjf&mobileNumber=".$mobile_number."&categoryId=".$categoryId."&complaintLatitude=".$latitude."&complaintLongitude=".$longitude."&complaintLocation=".$complaintLocation."&complaintLandmark=".$complaintLandmark."&fullName=".$fullName."&deviceOs=external&file=".$image_url ; 

    	

          $ch = curl_init();
       		  curl_setopt($ch, CURLOPT_URL,"http://api.swachh.city/sbm/v1/post-complaint?");
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $pay_load);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $server_output = curl_exec($ch);
              curl_close ($ch);
              echo "<pre>"; 
              print_r($server_output);

    }

    public function registerSBM() {
    
    /*
    http://api.swachh.city/sbm/v1/user?"vendor_name==Bengalore&acc 
ess_key=jkhdjS&mobileNumber=9976996755&macAddress=&d 
eviceToken=&deviceOs=external&apiKey=af4e61d75d2782a3 
3eac7641e42bba6f&lang=en&latitude=15.4961348&longitude=73.8341955&loc 
ation=Test*/
        
        $pay_load = "vendor_name=Patna&access_key=bkm2zvjf&mobileNumber=8974094939&macAddress=&deviceToken=&deviceOs=external&apiKey=af4e61d75d2782a3&lang=en&latitude=15.4961348&longitude=73.8341955&loc 
ation=Patliputra" ; 

      $url = "http://api.swachh.city/sbm/v1/user?".$pay_load;
      echo $url;
      die();

    	$ch = curl_init();
       		  curl_setopt($ch, CURLOPT_URL,"http://api.swachh.city/sbm/v1/user?");
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $pay_load);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $server_output = curl_exec($ch);
              curl_close ($ch);

              echo $server_output;
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
