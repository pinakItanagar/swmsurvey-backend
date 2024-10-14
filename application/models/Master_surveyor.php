<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_surveyor extends CI_Model {


    function insertSurveyor($data) {
       $this->db->insert('master_surveyor', $data);
    }
    
    
    function getAllVendors() {
        $this->db->select('*');
        $this->db->from('master_vendor');
        $q = $this->db->get();
        return $q->result();
    }

    function insertWardsurveyor($data) {
       $this->db->insert('master_surveyor', $data);
    }   

    function insertIssue($data) {
       $this->db->insert('register_master', $data);
    }
    

     function allSurveyorDetails($key, $value) {
        $this->db->select('*');
        $this->db->from('master_surveyor');
        $this->db->where($key, $value);
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }

    function wardWiseSurveyorDetails() {

        $this->db->select('*');
        //$this->db->where('sites.site_id', $site_id);
        $this->db->from('master_surveyor');
        $this->db->join('master_ward', 'master_surveyor.wardId = master_ward.ward_no', 'left');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id', 'left');
        $q = $this->db->get();
        return $q->result();


    }
    
    function updateSurveyor($data, $key, $value) {
       $this->db->where($key, $value);
       $this->db->update('master_surveyor', $data); 
    }

    function updateWardsurveyor($surveyor, $data) {
       $key = 'userId';
       $value = $surveyor;
       $this->db->where($key, $value);
       $this->db->update('master_surveyor', $data); 
    }

    /*public function updateWardsurveyor($surveyor, $ward) {
        $query = $this->db->query("UPDATE master_surveyor SET 'wardId' = '".$ward."' WHERE 'userId' = 1");

        return $query;
        //return $this->db->insert();
    }*/
   
    function updateIssue($issueId, $data) {
       $this->db->where('issue_id', $issueId);
       $this->db->update('register_master', $data); 
    }
    public function allIssues() {
        

        $query_str = $this->db->select('master_surveyor.*, 
                                       (SELECT SUM(total_qr_code) FROM register_master WHERE master_surveyor.userId = register_master.surveyor_id) AS ttlqrcode, 
                                       (SELECT SUM(screw) FROM register_master WHERE master_surveyor.userId = register_master.surveyor_id) AS ttlscrew, 
                                       (SELECT SUM(anchor_wall) FROM register_master WHERE master_surveyor.userId = register_master.surveyor_id) AS ttlanchor, 
                                       (SELECT SUM(total_damage) FROM register_master WHERE master_surveyor.userId = register_master.surveyor_id) AS ttldamage, 
                                       (SELECT SUM(total_qrcode_issued) FROM register_master WHERE master_surveyor.userId = register_master.surveyor_id) AS ttlinstall, 
                                       master_vendor.vendor_name, master_vendor.vendor_id' 
                                       );                                       
        
        
        $this->db->from('master_surveyor');
        $this->db->join('master_vendor', 'master_surveyor.vendor_id = master_vendor.vendor_id');
        $q = $this->db->get();
        return $q->result();
    }

    public function allIssuesVendorWise() {
        

        $query_str = $this->db->select('master_vendor.*, 
                                       (SELECT SUM(total_qr_code) FROM register_master WHERE master_vendor.vendor_id = register_master.vendor_id) AS ttlqrcode, 
                                       (SELECT SUM(screw) FROM register_master WHERE master_vendor.vendor_id = register_master.vendor_id) AS ttlscrew, 
                                       (SELECT SUM(anchor_wall) FROM register_master WHERE master_vendor.vendor_id = register_master.vendor_id) AS ttlanchor' 
                                       );                                       
        
        
        $this->db->from('master_vendor');
        $q = $this->db->get();
        return $q->result();
    }

    public function allIssuesDateWise() {
        
        $this->db->select('SUM(register_master.total_qr_code) AS ttlqrcode, 
                           SUM(register_master.screw) AS ttlscrew,
                           SUM(register_master.anchor_wall) AS ttlanchor,
                           register_master.issue_date,
                           master_surveyor.first_name, master_surveyor.last_name, 
                           master_surveyor.userId, master_vendor.vendor_name
                           ');
        $this->db->from('register_master');
        $this->db->join('master_vendor', 'register_master.vendor_id = master_vendor.vendor_id');
        $this->db->join('master_surveyor', 'register_master.surveyor_id = master_surveyor.userId');
        $this->db->group_by('date(issue_date),surveyor_id');
        $q = $this->db->get();
        return $q->result();
       
    }
    

    public function getIssueInfo($userId) {
        $query_str = $this->db->select('*');
        $this->db->from('register_master');
        $this->db->where('surveyor_id', $userId);
        $q = $this->db->get();
        return $q->result();
    }
    
    function removeIssue($issueId) {
        
        $this->db->where("issue_id", $issueId);
        $this->db->delete('register_master'); 
        
    }
    public function getIssueIdInfo($issueId) {
        $query_str = $this->db->select('*');
        $this->db->from('register_master');
        $this->db->where('issue_id', $issueId);
        $q = $this->db->get();
        return $q->result();
    }

    public function getIssueSurveyorId($issueId) {
        $this->db->select('surveyor_id');
        $this->db->from('register_master');
        $this->db->where('issue_id', $issueId);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->surveyor_id;
    }
    
    function getSurveyorInfo($userId)
    {
	$query_str = $this->db->select('master_surveyor.*, master_vendor.vendor_name, 
                                        master_vendor.vendor_id');

        $this->db->from('master_surveyor');
        $this->db->join('master_vendor', 'master_surveyor.vendor_id = master_vendor.vendor_id', 'left');
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }   
    public function allSurveyors() {
        $this->db->select('*');
        $this->db->from('master_surveyor');
        //$this->db->where('master_surveyor.status', 0); 
        $this->db->order_by("userId", "DESC"); 
        $q = $this->db->get();
        return $q->result();
    }
    
    

   
}
