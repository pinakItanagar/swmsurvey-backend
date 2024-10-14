<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_footprintreport extends CI_Model {


    function insertReport($data) {
       $this->db->insert('foot_print_report', $data);
    }
   
    
    function updateReport($data, $key, $value) {
       $this->db->where($key, $value);
       $this->db->update('foot_print_report', $data); 
    }
    
    
    function getReport($report_date) {
        $this->db->select('*');
         $this->db->where("report_date", $report_date);
        $this->db->from('foot_print_report');
        $q = $this->db->get();
        return $q->result();
    }
    
    
     public function getVendorName( $vendor_code) {
     
        $this->db->select('vendor_name');
        $this->db->from('master_vendor');
        $this->db->where('vendor_code', $vendor_code);
        $query = $this->db->get();
        $rs = $query->row(0);
       
        return $rs->vendor_name;
    }
    
    
    function getAllWardByVendor() {
        $this->db->select('master_ward.ward_no, master_ward.total_footprints, ward_vendor.vendor_code');
        $this->db->from('ward_vendor');
        $this->db->join('master_ward', 'ward_vendor.ward_no = master_ward.ward_no');
        $q = $this->db->get();
        return $q->result();
    }
    
    function totalQRCodeInstalled($date, $ward_no) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no);
        $this->db->like('date_updated', $date, 'both', false);
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
     function totalQRCodeInstalledAsOnDate($ward_no) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no);
        $total = $this->db->get()->num_rows();
        return  $total;
    }

   
   
    public function isReportExistByWard( $report_date, $ward_no) {
        $isExist =  false;
        $this->db->select('report_row_id');
        $this->db->from('foot_print_report');
        $this->db->where('ward_no', $ward_no);
         $this->db->where('report_date', $report_date);
        $query = $this->db->get();
        
        if($query->row(0)!= null) {
         $isExist =  true;
        } else {
         $isExist = false;   
        }
        
        return $isExist;
    }
    
    
    public function isReportExist( $report_date) {
        $isExist =  false;
        $this->db->select('report_row_id');
        $this->db->from('foot_print_report');
         $this->db->where('report_date', $report_date);
        $query = $this->db->get();
        
        if($query->row(0)!= null) {
         $isExist =  true;
        } else {
         $isExist = false;   
        }
        
        return $isExist;
    }
    
    function removeReport($report_date) {
        
        $this->db->where("report_date", $report_date);
        $this->db->delete('foot_print_report'); 
        
    }
    
    
    function getAllVendorWards() {
        $this->db->select('ward_vendor.*, master_ward.total_footprints');
        $this->db->from('ward_vendor');
        $this->db->join('master_ward', 'ward_vendor.ward_no = master_ward.ward_no');
        $q = $this->db->get();
        return $q->result();  
    }
    
    
    
     function getWardSurveyRepord($ward_no) {
        $this->db->select('isnew, isflat, ward_no, pid, owner_name , mobile_no, '
                . 'building_type, no_of_properties, occupancy_status, property_type, flatName, houseno, address_street, sector, '
                . 'latitude, longitude, qr_code, gpsaccuracy, connecting_road_type, connecting_road_width, total_floors, total_tenant_owners, '
                . 'total_flats, total_blocks, date_updated ');
        $this->db->from('property_master_update');
        $this->db->where("ward_no", $ward_no);
        $q = $this->db->get();
        return $q->result();  
    }

   
}
