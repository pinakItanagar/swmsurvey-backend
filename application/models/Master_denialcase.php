<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_denialcase extends CI_Model {
    
    
    function getDenialCaseByDate($report_date, $ward_no) {
        $this->db->select('*');
        $this->db->from('denial_case');
        $this->db->where('DATE(entry_date_time)', $report_date);
        $this->db->where('ward_no', $ward_no);
        $this->db->order_by('denial_case_id', 'desc');
        $q = $this->db->get();
        return $q->result();
    }
    
    
    
   
    
    function getAllVehicleData() {
        $this->db->select('*');
        $this->db->from('gis_data_temp');
        $this->db->order_by('id', 'desc');
        $q = $this->db->get();
        return $q->result();
    }
    
    
  
    
    
    
    

}
