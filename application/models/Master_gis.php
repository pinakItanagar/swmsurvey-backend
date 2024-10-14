<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_gis extends CI_Model {


    
    public function insertMissedPoints($data)  {
       $this->db->insert('ward_missed_points', $data);
    }
    
    
    function totalMissedPoints($ward_no) {
        $this->db->select('missed_point_id');
        $this->db->from('ward_missed_points');
        $this->db->where('ward_no', $ward_no);
        $this->db->where("status", "0");
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function getMissedPoints($ward_no) {
        
        $this->db->select('*');
        $this->db->from('ward_missed_points');
        $this->db->where("status", "0");
        $this->db->where('ward_no', $ward_no);
        $q = $this->db->get();
        return $q->result();
    }
    
    
    function deleteAllExistingMissedPoint($ward_no) {
        
        $this->db->where("ward_no", $ward_no);
        $this->db->where("status", "0");
        $this->db->delete('ward_missed_points'); 
        
    }

  
}
