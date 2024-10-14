<?php
class Couchdb {
 
  public $database_name;
  public $user_id;
  public $password;
  public $url ;
  public $couchdb_url ;
  public $couchdb_user_password ;


  public function __construct() {
    $this->url = "http://127.0.0.1:5984/";
    $this->database_name = "swmqrcode";
    $this->user_id = "admin";
    $this->password = "dev@2020";
    $this->couchdb_url = $this->url.$this->database_name."/";
    $this->couchdb_user_password =  $this->user_id.":".$this->password;
  }




  
  public function getCouchDbDocById($document_id) {
        $myurl = $this->couchdb_url.$document_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $myurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/json',
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $this->couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        return $data;
    }


    public function getCouchDbAllDocs($payload, $sub_url ) {
     
        $ch = curl_init();
        $location = curl_escape($ch, $payload);
        $myurl = $this->couchdb_url.$sub_url.$location;
       
        curl_setopt($ch, CURLOPT_URL, $myurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/json',
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $this->couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        return $data;
    }


     public function createCouchDbDoc($doc_obj, $doc_id, $content_type){
        $ch = curl_init();
        $payload = json_encode($doc_obj);
        curl_setopt($ch, CURLOPT_URL, $this->couchdb_url.$doc_id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: {$content_type}",
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $this->couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } 


    public function updateCouchDbDoc($doc_obj, $doc_id, $content_type){
        $ch = curl_init();
        $payload = json_encode($doc_obj);
        curl_setopt($ch, CURLOPT_URL, $this->couchdb_url.$doc_id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: {$content_type}",
                'Accept: */*'
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $this->couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } 


    public function deleteCouchDbDoc($revision, $doc_id, $content_type) {
        $ch = curl_init();
       
        curl_setopt($ch, CURLOPT_URL, $this->couchdb_url.$doc_id."?rev=".$revision);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); /* DELETE */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: {$content_type}",
                'Accept: */*'
        ));
        curl_setopt($ch, CURLOPT_USERPWD, $this->couchdb_user_password);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
    
   
    
    


  
}
   
?>