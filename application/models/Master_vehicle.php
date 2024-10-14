<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_vehicle extends CI_Model {
    
    
    function getCircleMappedID($circle_name) {
        $this->db->select('*');
        $this->db->from('master_circle');
        $this->db->where('circle_name', $circle_name);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->circle_id;
    }
    
    
    function insertVehicle($data) {
       $this->db->insert('master_vehicle', $data);
    }
    
   
    
    function getAllCircleAJV() {
        $this->db->select('*');
        $this->db->from('ajeeve_circle_master');
        $q = $this->db->get();
        return $q->result();
    }
    
    
    function getAllVehicle() {
        $this->db->select('*');
        $this->db->from('master_vehicle');
        $q = $this->db->get();
        return $q->result();
    }
    
    
     function getOwnerType() {
        $this->db->select('*');
        $this->db->from('ajeeve_owner_type');
        $q = $this->db->get();
        return $q->result();
    }
    
    
     
    function getWardDetails($ward_no) {
        $this->db->select('*');
        $this->db->from('ajeeve_ward_master');
        $this->db->where('wardNo', $ward_no);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs;
    }
    
    
    function getWardSurveyDetails($ward_no) {
        $this->db->select('qr_code, owner_name, flatName, isflat, ward_no, mobile_no, houseno, address_street, area_landmark,  	longitude, latitude, pid, occupancy_status, building_type  ');
        $this->db->where('ward_no', $ward_no);
        $this->db->where('is_sync', "0");
        $this->db->from('property_master_update');
        $q = $this->db->get();
        return $q->result();
    }
    
    
    
    function updateSync($qr_code, $status, $message, $dateTime, $ward_no, $payload) {
        
        $data = array(
            'is_sync' => $status,
            'sync_date_time' => $dateTime
        );
        $this->db->where('qr_code', $qr_code);
        $this->db->update('property_master_update', $data);
        
        
         $data1 = array(
            'ward_no' => $ward_no,
            'qr_code' => $qr_code,
            'sync_status' => $status,
            'sync_message' => $message,
            'log_datetime' => $dateTime, 
            'pay_load_info' => $payload
        );
         $this->db->insert('ajeeve_household_synclog', $data1);
        
        
    }
    
    
    
    

}
