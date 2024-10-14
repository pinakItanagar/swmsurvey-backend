<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_vehicledata extends CI_Model {
    
    
    function getCircleMappedID($circle_name) {
        $this->db->select('*');
        $this->db->from('master_circle');
        $this->db->where('circle_name', $circle_name);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->circle_id;
    }
    
    
    
   
    
    function getAllVehicleData() {
        $this->db->select('*');
        $this->db->from('gis_data_temp');
        $this->db->order_by('id', 'desc');
        $q = $this->db->get();
        return $q->result();
    }
    
    
  
    
    
    
    

}
