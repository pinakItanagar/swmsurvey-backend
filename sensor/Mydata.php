<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mydata extends CI_Controller {

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


   
    
    
    public function postinfo(){
       
         //$json = json_encode(array("api_key" => "1", "userMobile" => "8974094939", "userPassword" => "123"));
         $json = file_get_contents('php://input');

        $myfile = fopen("upload/sensordata.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $json);
        fclose($myfile);
    
    }
    
    
    
    
  
}
