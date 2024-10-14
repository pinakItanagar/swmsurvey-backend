<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
class Manageroute extends CI_Controller {

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
       $this->load->model('Master_user', 'tblUser');
       $this->load->model('Master_route', 'tblRoute');
      
    }


  public function listing() {
		$pagename = "route/all_routes";
		$title = "All Routes";
		$result = $this->tblRoute->allRoutes();
		$data['allRoutes'] = $result;
		$data['page_code'] = "DATA_TABLE";
		$this->page($pagename, $title, $data);
	}


  public function waypoints($route_id) {
    $pagename = "route/all_waypoints";
    $link = "<a href='".base_url("manageroute/listing")."'>Route Listing</a>"."&nbsp;/&nbsp;" ;
    $title = $link." All Way points of the route";
    $route = $this->tblRoute->allRouteDetails("route_id", $route_id);
    $result = $this->tblRoute->allWayPointsByrouteID($route_id);
    $data['allRouteWaypoints'] = $result;
    $data['route'] = $route;
    $data['page_code'] = "DATA_TABLE";
    $this->page($pagename, $title, $data);
  }


  public function addroute() {
    $pagename = "route/add_route";
    $link = "<a href='".base_url("manageroute/listing")."'>Route Listing</a>"."&nbsp;/&nbsp;" ;
    $title = $link."Add Route";
    $data = "";
    $this->page($pagename, $title, $data);
  }


  
  
	public function addstart($route_id) {
		$pagename = "route/add_route_start";
    $link = "<a href='".base_url("manageroute/listing")."'>Route Listing</a>"."&nbsp;/&nbsp;" ;
		$title = $link." Add Start Point";
    $route = $this->tblRoute->allRouteDetails("route_id", $route_id);
    if($this->tblRoute->isRoutePointExist("END", $route_id ) == true) {

       $endPoint = $this->tblRoute->getEndPointByID($route_id); 
       $data['endPoint'] = true;
       $data['endPointData'] = $endPoint;
    }
    
		$data['isDateField'] = true;
    $data['maps'] = "MAP";
    $data['route'] = $route;
		$this->page($pagename, $title, $data);
	}


  public function addend($route_id) {
    $pagename = "route/add_route_end";
    $link = "<a href='".base_url("manageroute/listing")."'>Route Listing</a>"."&nbsp;/&nbsp;" ;
    $title = $link." Add End Point";
    $route = $this->tblRoute->allRouteDetails("route_id", $route_id);
    $startPoint = $this->tblRoute->getStartPointByID($route_id);

    if($this->tblRoute->isRoutePointExist("START", $route_id ) == true) {
      
       $startPoint = $this->tblRoute->getStartPointByID($route_id); 
       $data['startPoint'] = true;
       $data['startPointData'] = $startPoint;
    }




    $data['isDateField'] = true;
    $data['maps'] = "MAP";
    $data['route'] = $route;
    $data['startPoint'] = $startPoint;
    $this->page($pagename, $title, $data);
  }



  public function addwaypoint($route_id) {
    $pagename = "route/add_way_point";
    $link = "<a href='".base_url("manageroute/listing")."'>Route Listing</a>&nbsp;/&nbsp;<a href='".base_url("manageroute/waypoints/").$route_id."'>Way Point List</a>&nbsp;/&nbsp;" ;
    $title = $link." Add Way Point";
    $route = $this->tblRoute->allRouteDetails("route_id", $route_id);
    $startPoint = $this->tblRoute->getStartPointByID($route_id);

    if($this->tblRoute->isRoutePointExist("START", $route_id ) == true) {
      
       $startPoint = $this->tblRoute->getStartPointByID($route_id); 
       $data['startPoint'] = true;
       $data['startPointData'] = $startPoint;
    }


    if($this->tblRoute->isRoutePointExist("END", $route_id ) == true) {

       $endPoint = $this->tblRoute->getEndPointByID($route_id); 
       $data['endPoint'] = true;
       $data['endPointData'] = $endPoint;
    }


    if($this->tblRoute->isRoutePointExist("WAYPOINT", $route_id ) == true) {
      
       $waypoints = $this->tblRoute->allWayPointsByrouteID($route_id);
       $data['wayPoint'] = true;
       $data['waypoints'] = json_encode($waypoints);
    } else {
       $data['wayPoint'] = false;
    }

    
    
    $data['isDateField'] = true;
    $data['maps'] = "MAP";
    $data['route'] = $route;
   
    $this->page($pagename, $title, $data);
  }

  


	public function edit($product_id) {
     $link = "<a href='".base_url("manageproduct/listing")."'>Product Listing</a>"."&nbsp;/&nbsp;" ;
	   $product = $this->tblProduct->getProductDetails("product_id", $product_id);
     $pagename = "product/edit_product";
	   $title = $link."Product Details" ;
	   $data['product'] = $product;
     $data['isDateField'] = true;
	   $this->page($pagename, $title, $data);
	}


	public function view($product_id) {

	   if($this->tblProduct->isProductExist("product_id", $product_id) == true) {	
       $link = "<a href='".base_url("manageproduct/listing")."'>Product Listing</a>"."&nbsp;/&nbsp;" ;
		   $product = $this->tblProduct->getProductDetails("product_id", $product_id);
	     $product_items = $this->tblProduct->getProductItemList("product_part_no", $product->product_part_no);
	     $pagename = "product/product_details";
		   $title = $link."Product Details" ;
		   $data['product_items'] = $product_items;
		   $data['product'] = $product;
		   $data['page_code'] = "DATA_TABLE";
	       $this->page($pagename, $title, $data);
       } else {
       	   redirect('manageproduct/listing/'); 
       }
	}


	public function save() {

        if(!$this->session->userdata('USER_ID')){
          redirect('home/logout');
        } 

        $route_name = strtoupper(trim($this->security->xss_clean($_POST['route_name'])));    
    


        $dbdata = array(
          'route_name' => $route_name,
        );
        $this->tblRoute->insertRoute($dbdata);
    

     $this->session->set_flashdata('APPMSG', ' Route name added successfully ! ');
     redirect('manageroute/listing/'); 

   }

   
   
    public function savestart() {

        if(!$this->session->userdata('USER_ID')){
          redirect('home/logout');
        } 

        $latitude = trim($this->security->xss_clean($_POST['latitude'])); 
        $longitude = trim($this->security->xss_clean($_POST['longitude']));   
        $route_id = trim($this->security->xss_clean($_POST['route_id']));   
    


        $dbdata = array(
          'route_id' => $route_id,
          'latitude' => $latitude,
          'longitude' => $longitude,
          'point_type' => "START"
        );
        $this->tblRoute->insertRoutePoint($dbdata);


        $dbdata = array(
          'is_start_point' => '1'
        );
        $this->tblRoute->updateRoute($dbdata , "route_id" , $route_id);
    

     $this->session->set_flashdata('APPMSG', ' Route start point added successfully ! ');
     redirect('manageroute/listing/'); 

   }



   public function saveend() {

        if(!$this->session->userdata('USER_ID')){
          redirect('home/logout');
        } 

        $latitude = trim($this->security->xss_clean($_POST['latitude'])); 
        $longitude = trim($this->security->xss_clean($_POST['longitude']));   
        $route_id = trim($this->security->xss_clean($_POST['route_id']));   
    


        $dbdata = array(
          'route_id' => $route_id,
          'latitude' => $latitude,
          'longitude' => $longitude,
          'point_type' => "END"
        );
        $this->tblRoute->insertRoutePoint($dbdata);


        $dbdata = array(
          'is_end_point' => '1'
        );
        $this->tblRoute->updateRoute($dbdata , "route_id" , $route_id);
    

     $this->session->set_flashdata('APPMSG', ' Route end point added successfully ! ');
     redirect('manageroute/listing/'); 

   }



   public function savewaypoint() {

        if(!$this->session->userdata('USER_ID')){
          redirect('home/logout');
        } 

        $latitude = trim($this->security->xss_clean($_POST['latitude'])); 
        $longitude = trim($this->security->xss_clean($_POST['longitude']));   
        $route_id = trim($this->security->xss_clean($_POST['route_id']));   
        $landmark_name = strtoupper(trim($this->security->xss_clean($_POST['landmark_name']))); 
        $way_point_category = trim($this->security->xss_clean($_POST['way_point_category']));


    


        $dbdata = array(
          'route_id' => $route_id,
          'latitude' => $latitude,
          'longitude' => $longitude,
          'point_type' => "WAYPOINT",
          'landmark_name' => $landmark_name,
          'way_point_category' => $way_point_category,
        );
        $this->tblRoute->insertRoutePoint($dbdata);

        /*
        $dbdata = array(
          'is_start_point' => '1'
        );
        $this->tblRoute->updateRoute($dbdata , "route_id" , $route_id);
        */
    

     $this->session->set_flashdata('APPMSG', ' Route way point added successfully ! ');
     redirect('manageroute/addwaypoint/'.$route_id); 

   }
  
  


	function remove($product_id) {
      $product = $this->tblProduct->getProductDetails("product_id", $product_id);
      $product_part_no = $product->product_part_no;
      $this->tblProduct->removeProductItem("product_part_no", $product->product_part_no);
      $this->tblProduct->removeProduct("product_id", $product_id) ; 
      $this->session->set_flashdata('APPMSG', ' Product details removed successfully!');
      redirect('manageproduct/listing/'); 
  }



  function initials($str) {
    $ret = '';
    foreach (explode(' ', $str) as $word)
        $ret .= strtoupper($word[0]);
    return $ret;
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
