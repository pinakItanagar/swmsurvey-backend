<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_search extends CI_Model {
    
    
    function searchData($search_type, $search_value) {
        
        if($search_type == "OWNER") {
            $total = 0;
            $this->db->select('record_id');
            $this->db->from('property_master');
            $this->db->like('owner_name', $search_value, 'both', false);
            $total = $this->db->get()->num_rows();
            
            if(intval($total) > 0) {
                $this->db->select(" property_master.owner_name as p_ownerName, property_master.ward_no, master_circle.circle_name, property_master.mobile_no as owner_mobile, "
                                 . "property_master.pid, property_master.address, property_master.isUpdate, "
                                 . "master_surveyor.first_name, master_surveyor.last_name, "
                                 . "master_surveyor.mobile as smobile, property_master_update.qr_code, "
                                 . "property_master_update.gpsaccuracy");
                $this->db->from('property_master');
                $this->db->join('master_ward' , 'master_ward.ward_no = property_master.ward_no');
                $this->db->join('master_circle' , 'master_circle.circle_id = master_ward.circle_id');
                $this->db->join('master_surveyor' , 'master_surveyor.userId = property_master.updated_by_user', 'left');
                $this->db->join('property_master_update' , 'property_master_update.pid  = property_master.pid', 'left');
                $this->db->like('property_master.owner_name', $search_value, 'both', false);
                $query = $this->db->get();
                $rs =  $query->result();
               
            } else {
                
            }
                
        }
        
    }
    
    
    function searchByOwner( $search_value ) {
        
        
                   $this->db->select(" property_master.owner_name as p_ownerName, property_master.ward_no, master_circle.circle_name, property_master.mobile_no as owner_mobile, "
                                     . "property_master.pid, property_master.address, property_master.isUpdate ");
                    $this->db->from('property_master');
                    $this->db->join('master_ward' , 'master_ward.ward_no = property_master.ward_no');
                    $this->db->join('master_circle' , 'master_circle.circle_id = master_ward.circle_id');
                    $this->db->like('property_master.owner_name', $search_value, 'both', false);
                    $query = $this->db->get();
                    $rs =  $query->result();
                    
                    $property = array();
                    if($query->result() == null) {
                        
                        foreach ($rs as $row) {
                            $temp = array(
                                'owner_name' => $row->p_ownerName,
                                'ward_no' => $row->ward_no,
                                'circle_name' => $row->circle_name,
                                'owner_mobile' => $row->owner_mobile,
                                'pid' => $row->pid,
                                'address' => $row->address,
                                'isUpdate' => $row->isUpdate,
                                'isflat' => '0',  
                                'flatname' => '',
                                'qr_code' => ''
                                
                            );
                            array_push($property,$temp);
                        }
                        
                        
                    }
                    
                    
                    $this->db->select(" property_master_update.owner_name as p_ownerName, property_master_update.ward_no, master_circle.circle_name, "
                                     . "property_master_update.mobile_no as owner_mobile, "
                                     . "property_master_update.pid, property_master_update.mobile_no, property_master_update.houseno, "
                                     . "property_master_update.address_street, property_master_update.area_landmark , "
                                     . " property_master_update.qr_code  ");
                    $this->db->from('property_master_update');
                    $this->db->join('master_ward' , 'master_ward.ward_no = property_master.ward_no');
                    $this->db->join('master_circle' , 'master_circle.circle_id = property_master_update.circle_id');
                    $this->db->like('property_master_update.owner_name', $search_value, 'both', false);
                    $query = $this->db->get();
                    $rs =  $query->result();
                     
                    
                  
        
       
           /*
            $this->db->select('record_id, isUpdate');
            $this->db->from('property_master');
            $this->db->like('owner_name', $search_value, 'both', false);
            $query = $this->db->get();
            $rs = $query->row(0);
          
            
            if(isset($rs)) {
                if($rs->isUpdate ==  '0') {
                    $this->db->select(" property_master.owner_name as p_ownerName, property_master.ward_no, master_circle.circle_name, property_master.mobile_no as owner_mobile, "
                                     . "property_master.pid, property_master.address, property_master.isUpdate ");
                    $this->db->from('property_master');
                    $this->db->join('master_ward' , 'master_ward.ward_no = property_master.ward_no');
                    $this->db->join('master_circle' , 'master_circle.circle_id = master_ward.circle_id');
                    $this->db->like('property_master.owner_name', $search_value, 'both', false);
                    $query = $this->db->get();
                    $rs =  $query->result();
                    
                    
                } else {
                    $this->db->select(" property_master.owner_name as p_ownerName, property_master_update.flatName, property_master.ward_no, master_circle.circle_name, property_master.mobile_no as owner_mobile, "
                                     . "property_master.pid, property_master.address, property_master.isUpdate, "
                                     . "master_surveyor.first_name, master_surveyor.last_name, "
                                     . "master_surveyor.mobile as smobile, property_master_update.qr_code, "
                                     . "property_master_update.gpsaccuracy");
                    $this->db->from('property_master');
                    $this->db->join('master_ward' , 'master_ward.ward_no = property_master.ward_no');
                    $this->db->join('master_circle' , 'master_circle.circle_id = master_ward.circle_id');
                    $this->db->join('master_surveyor' , 'master_surveyor.userId = property_master.updated_by_user', 'left');
                    $this->db->join('property_master_update' , 'property_master_update.pid  = property_master.pid', 'left');
                    $this->db->like('property_master.owner_name', $search_value, 'both', false);
                    $this->db->or_like('property_master_update.flatName', $search_value, 'both', false);
                    $query = $this->db->get();
                    $rs =  $query->result();
                }
            } else {
                
                
           
                
                $this->db->select(" property_master_update.owner_name as p_ownerName, property_master_update.flatName, property_master_update.ward_no, master_circle.circle_name, property_master_update.mobile_no as owner_mobile, "
                                 . "property_master_update.pid, property_master_update.address_street, property_master_update.houseno, "
                                 . "master_surveyor.first_name, master_surveyor.last_name, "
                                 . "master_surveyor.mobile as smobile, property_master_update.qr_code, "
                                 . "property_master_update.gpsaccuracy");
                $this->db->from('property_master_update');
                $this->db->join('master_ward' , 'master_ward.ward_no = property_master_update.ward_no');
                $this->db->join('master_circle' , 'master_circle.circle_id = master_ward.circle_id');
                $this->db->join('master_surveyor' , 'master_surveyor.userId = property_master_update.updated_by_user ', 'left');
                $this->db->like('property_master_update.owner_name', $search_value, 'both', false);
                $this->db->or_like('property_master_update.flatName', $search_value, 'both', false);
                $query = $this->db->get();
                $rs =  $query->result(); 
            }
            
           
         
            
             echo  $this->db->last_query();
             */ 
              
             echo "<pre>";
             print_r($rs);
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
