<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
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
    
    public function postJCBinfo(){
       
        //$json = json_encode(array("api_key" => "1", "userMobile" => "8974094939", "userPassword" => "123"));
        $json = file_get_contents('php://input');
       /*
        $myfile = fopen("upload/jcbsensordata.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $json);
        fclose($myfile); 
        */
        $jcb_data = json_decode($json);
        
        
       
        $myfile = fopen("upload/jcbsensordata.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $json);
        fclose($myfile); 
        
         $doc_id = "JCB".date("YmdHis");
         $table_name = "JCB_SENSOR_DATA";
         $doc_obj = array(
                'table_name' => $table_name,
                'doc_id' => $doc_id,
                'deviceID' => $jcb_data->deviceID,
                'jcb_data' => $jcb_data,
                'date' => date("Y-m-d"),
                'time' => date("H:i:s")
            );
         
        $res = $this->createCouchDbDoc($doc_obj, $doc_id,'application/json') ;
        $myfile = fopen("upload/jcbsensordata.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $res);
        fclose($myfile);
    }
    
    
    public function createCouchDbDoc($doc_obj, $doc_id, $content_type){
        $couchdb_url = "http://127.0.0.1:5984/swmqrcode/" ;
        $couchdb_user_password = "admin:dev@2020";
        $ch = curl_init();
        $payload = json_encode($doc_obj);
        curl_setopt($ch, CURLOPT_URL, $couchdb_url.$doc_id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: {$content_type}",
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } 
    
    
     public function testCouchDbDoc($doc_obj, $doc_id, $content_type){
        $couchdb_url = "http://127.0.0.1:5984/swmqrcode/" ;
        $couchdb_user_password = "admin:dev@2020";
        $ch = curl_init();
        $payload = json_encode($doc_obj);
        curl_setopt($ch, CURLOPT_URL, $couchdb_url.$doc_id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: {$content_type}",
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } 
    
    
   
    
   
    
    
    
    
  
}
