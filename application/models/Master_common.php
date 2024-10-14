<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_common extends CI_Model {
   

    public function getFBdetails($key, $value) {
         $this->db->select('*');
        $this->db->from('fb_config');
        $this->db->where($key, $value);
        $q = $this->db->get();
        $fb_details = $q->row(0);
        return $fb_details;
    }


    
 


   



}
