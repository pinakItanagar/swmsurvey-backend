<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_dashboard extends CI_Model {
    
   /* 
     public function allSurveyWardMap() {
         $current_date = date("Y-m-d");
        $this->db->select('master_ward.*, master_vendor.vendor_name, foot_print_report.total_qrcode_installed, '
                . ' foot_print_report.total_qrcode_installed_today, foot_print_report.total_footprint');
        $this->db->from('master_ward');
        $this->db->join('foot_print_report', 'master_ward.ward_no = foot_print_report.ward_no');
        $this->db->join('ward_vendor', 'master_ward.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $this->db->where('foot_print_report.report_date', $current_date);
        $q = $this->db->get();
        return $q->result();
    }*/
    
    
    public function allSurveyWardMap() {
       
        $this->db->select('master_ward.*, master_vendor.vendor_name');
        $this->db->from('master_ward');
        $this->db->join('ward_vendor', 'master_ward.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $q = $this->db->get();
        return $q->result();
    }
    
    
    public function allSurveyWardMapByWardno($ward_no) {
       
        $this->db->select('master_vendor.vendor_name, master_ward.*');
        $this->db->from('master_ward');
        $this->db->join('ward_vendor', 'master_ward.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $this->db->where('master_ward.ward_no', $ward_no);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs;
    }
    
    
    public function totalSurveyDone($ward_no) {
        
        $this->db->select('count(p_record_id) as total_survey');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total_survey;
        
    }
    
    
     public function totalSurveyDoneToday($ward_no) {
        //$date = "2021-03-08";
        $date = date("Y-m-d");
        $this->db->select('count(p_record_id) as total_survey_today');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no);
        $this->db->like('property_master_update.date_updated', $date, 'both', false);  
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total_survey_today;
        
    }
    
    
    public function allactiveSurveyward() {
        
         $this->db->select('master_ward.*');
        $this->db->from('master_ward');
        $this->db->join('ward_vendor', 'master_ward.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $q = $this->db->get();
        return $q->result();
       
    }
   public function propertyanalysis($ward_no) {       

        $this->db->select('date_updated, pid, owner_name, houseno, address_street, area_landmark, latitude , longitude, qr_code, ward_no, mobile_no, count(*) as NumDuplicates');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no);
        $this->db->where("owner_name<>''");
        $this->db->group_by('qr_code, pid');
        $this->db->having('NumDuplicates>1');
        //$this->db->limit(5);
        $q = $this->db->get();
        return $q->result();
       
    }
    function propertiesCount() {
        /*
        $this->db->select('record_id');
        $this->db->from('property_master');
        $total = $this->db->get()->num_rows();
        return  $total;*/
        
        $this->db->select('count(record_id) as total');
        $this->db->from('property_master');
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total;
    }

    function pendingPropertiesCount() {
        /*
        $this->db->select('record_id');
        $this->db->from('property_master');
        $this->db->where('property_master.isUpdate', '0');
        $total = $this->db->get()->num_rows();
        return  $total;*/
        
        $this->db->select('count(record_id) as total');
        $this->db->from('property_master');
        $this->db->where('property_master.isUpdate', '0');
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total;
    }

    function finishedPropertiesCount() {
        $this->db->select('record_id');
        $this->db->from('property_master');
        $this->db->where('property_master.isUpdate', '1');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    function newPropertiesCount() {
        $this->db->select('*');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.isNew', '1');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function totalSurveyToday($date) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->like('date_updated', $date, 'both', false);
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function newPropertySurveyedToday($date) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->like('date_updated', $date, 'both', false);
        $this->db->where('isnew', '1');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function oldPropertySurveyToday($date) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->like('date_updated', $date, 'both', false);
        $this->db->where('isnew', '0');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function totalSurveyDoneAllCircle($circle_id) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('circle_id', $circle_id);
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function totalSurveyDoneTodayCircle($circle_id, $date) {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->like('date_updated', $date, 'both', false);
        $this->db->where('circle_id', $circle_id);
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
     function totalExistingPropertyCircle($circle_id) {
        $this->db->select('record_id');
        $this->db->from('property_master');
        $this->db->join('master_ward', 'master_ward.ward_no = property_master.ward_no');
        $this->db->where('master_ward.circle_id', $circle_id);
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    public function getCircles()  {
        
        $query_str = $this->db->select('master_circle.*, (SELECT COUNT(ward_id) FROM master_ward WHERE master_ward.circle_id = master_circle.circle_id) AS ttlward');
        $this->db->from('master_circle');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    
    /*public function getWardByCircleID($circle_id)  {
        
        $this->db->select('*');
        $this->db->from('master_ward');
        $this->db->where('circle_id', $circle_id);
        $this->db->order_by("circle_id", "ASC"); 
        $q = $this->db->get();
        return $q->result();
    }*/
    
    /*public function getWardByCircleID($circle_id)  {
        
       
            $query_str = $this->db->select('master_ward.*,
            (SELECT COUNT(record_id) FROM property_master 
            WHERE property_master.ward_no = master_ward.ward_no and isUpdate = 0) AS pendingSurvey, 
            (SELECT COUNT(p_record_id) FROM property_master_update 
            WHERE property_master_update.ward_no = master_ward.ward_no and property_master_update.isnew = 0 ) AS finishedSurvey, 
            (SELECT COUNT(p_record_id) FROM property_master_update 
            WHERE property_master_update.ward_no = master_ward.ward_no and property_master_update.isnew = 1) AS newProperty
            ');
        $this->db->from('master_ward');
        $this->db->where('circle_id', $circle_id);
        $q = $this->db->get();
        return $q->result();
    }*/

    public function getWardByCircleID($circle_id)  {
        
       
            $query_str = $this->db->select('master_ward.*,
            (SELECT COUNT(record_id) FROM property_master 
            WHERE property_master.ward_no = master_ward.ward_no and isUpdate = 0) AS pendingSurvey, 
            (SELECT COUNT(record_id) FROM property_master 
            WHERE property_master.ward_no = master_ward.ward_no and isUpdate = 1) AS totalExistingProperty, 
            (SELECT COUNT(record_id) FROM property_master 
            WHERE property_master.ward_no = master_ward.ward_no) AS totalProperty, 
            (SELECT COUNT(p_record_id) FROM property_master_update 
            WHERE property_master_update.ward_no = master_ward.ward_no and property_master_update.isnew = 0 ) AS finishedSurvey, 
            (SELECT COUNT(p_record_id) FROM property_master_update 
            WHERE property_master_update.ward_no = master_ward.ward_no and property_master_update.isnew = 1) AS newProperty
            ');
        $this->db->from('master_ward');
        $this->db->where('circle_id', $circle_id);
        $q = $this->db->get();
        return $q->result();
    }

    function getCircleName($circle_id) {
        $this->db->select('circle_name');
        $this->db->from('master_circle');
        $this->db->where('circle_id', $circle_id);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->circle_name;
    }

    public function allFinishedSurvey($ward_no) {
        $this->db->select('*');
        $this->db->from('property_master');
        $this->db->where('property_master.ward_no', $ward_no); 
        $this->db->where('property_master.isUpdate', '1');
        $q = $this->db->get();
        return $q->result();
    }

    public function allPendingSurvey($ward_no) {
        $this->db->select('*');
        $this->db->from('property_master');
        $this->db->where('property_master.ward_no', $ward_no); 
        $this->db->where('property_master.isUpdate', '0');
        $q = $this->db->get();
        return $q->result();
    }
    
    
     public function allNewProperty($ward_no) {
        $this->db->select('property_master_update.p_record_id, 
                           property_master_update.isnew, 
                           property_master_update.isflat, 
                           property_master_update.flatName, 
                           property_master_update.owner_name, 
                           property_master_update.mobile_no, 
                           property_master_update.pid, 
                           property_master_update.qr_code,
                           property_master_update.date_updated');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.ward_no', $ward_no); 
        $this->db->where('property_master_update.isnew', '1');
         $this->db->order_by('property_master_update.p_record_id', 'DESC');
        $q = $this->db->get();
        return $q->result();
    }

    public function allWardWisePropertyData($ward_no, $date="") {
        
        if($date == "") {
            $date = date('Y-m-d',strtotime("-1 days"));
            
            $dateTimeStamp = $date." "."23:59:59";
            $this->db->select('latitude, longitude, qr_code, pid, date_updated, flatname, owner_name, isflat, address_street, gpsaccuracy');
            $this->db->from('property_master_update');
            $this->db->where('property_master_update.ward_no', $ward_no); 
            $this->db->where('property_master_update.date_updated < ', $dateTimeStamp);
            //$this->db->where(' CONVERT (property_master_update.gpsaccuracy, UNSIGNED INTEGER) < ', '10'); 
            $this->db->order_by('property_master_update.p_record_id', 'DESC');
            $q = $this->db->get();
            //echo $this->db->last_query();
        } else {
            $this->db->select('latitude, longitude, qr_code, pid, date_updated, flatname, owner_name, isflat, address_street, gpsaccuracy');
            $this->db->from('property_master_update');
            $this->db->where('property_master_update.ward_no', $ward_no); 
            $this->db->like('property_master_update.date_updated', $date, 'both', false);
            //$this->db->where(' CONVERT (property_master_update.gpsaccuracy, UNSIGNED INTEGER) < ', '10'); 
            $this->db->order_by('property_master_update.p_record_id', 'DESC');
            $q = $this->db->get();
            // echo $this->db->last_query();
        }
      // die();
        return $q->result();
    }
    
    
     public function allWardSurveyedPropertyData($ward_no) {
        
      
            $this->db->select('latitude, longitude, qr_code, pid, date_updated, flatname, owner_name, isflat, address_street, gpsaccuracy');
            $this->db->from('property_master_update');
            $this->db->where('property_master_update.ward_no', $ward_no); 
            $this->db->order_by('property_master_update.p_record_id', 'DESC');
            $q = $this->db->get();
      
            return $q->result();
    }
    
    
     /*public function getSurveyedPropertyByDate($ward_no, $date_from, $date_to ) {
        $this->db->select('property_master_update.p_record_id, property_master_update.latitude, 
                           property_master_update.longitude, property_master_update.qr_code, 
                           property_master_update.pid, property_master_update.mobile_no, 
                           property_master_update.date_updated, property_master_update.flatname, 
                           property_master_update.owner_name, property_master_update.isflat, 
                           property_master_update.address_street, property_master_update.gpsaccuracy, 
                           property_master_update.ward_no, property_master_update.audit_remark, 
                           property_master_update.isreject, tbl_audit_status.call_status, 
                           tbl_audit_status.address_verification_remark, tbl_audit_status.call_date');
        $this->db->from('property_master_update');
        $this->db->join('tbl_audit_status', 'property_master_update.p_record_id = tbl_audit_status.p_record_id', 'left');
        $this->db->where('ward_no', $ward_no); 
        //$this->db->like('date_updated', $date, 'both', false);
         $this->db->where('DATE(property_master_update.date_updated) >=', date('Y-m-d',strtotime($date_from)));
        $this->db->where('DATE(property_master_update.date_updated) <=', date('Y-m-d',strtotime($date_to)));        
        $q = $this->db->get();
        return $q->result();
    }*/

    public function getSurveyedPropertyByDate($ward_no,$date ) {
        $this->db->select('property_master_update.p_record_id, property_master_update.latitude,
                           property_master_update.property_pic, property_master_update.property_qrcode_pic,  
			   property_master_update.houseno, property_master_update.area_landmark, 
                           property_master_update.longitude, property_master_update.qr_code, 
                           property_master_update.pid, property_master_update.mobile_no, 
                           property_master_update.date_updated, property_master_update.flatname, 
                           property_master_update.owner_name, property_master_update.isflat, 
                           property_master_update.address_street, property_master_update.gpsaccuracy, 
                           property_master_update.ward_no, property_master_update.audit_remark, 
                           property_master_update.isreject, tbl_audit_status.call_status,
                           tbl_audit_status.owner_apt_name, tbl_audit_status.updated_address,  
                           tbl_audit_status.address_verification_remark, tbl_audit_status.call_date, 
                           master_surveyor.first_name, master_surveyor.last_name, master_surveyor.mobile');
        $this->db->from('property_master_update');
        $this->db->join('tbl_audit_status', 'property_master_update.p_record_id = tbl_audit_status.p_record_id', 'left');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId', 'left');
        $this->db->where('ward_no', $ward_no); 
        $this->db->like('date_updated', $date, 'both', false);
        $q = $this->db->get();
        return $q->result();
    }

    function checkAuditByWarddate($userid,$date_from,$date_to,$ward_no) {
        $this->db->select('property_master_update.p_record_id ');
        $this->db->from('property_master_update');
        //$this->db->where('property_master_update.audited_by', $userid);
        $this->db->where('property_master_update.ward_no', $ward_no);
        $this->db->where('DATE(property_master_update.date_updated) >=', date('Y-m-d',strtotime($date_from)));
        $this->db->where('DATE(property_master_update.date_updated) <=', date('Y-m-d',strtotime($date_to)));        
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs;
    }

    public function getAuditByWardDate($userId, $date_from, $date_to, $ward_no)  {
        
        $this->db->select('property_master_update.p_record_id, property_master_update.latitude,
                           property_master_update.qr_code, property_master_update.longitude, 
                           property_master_update.pid, property_master_update.mobile_no, 
                           property_master_update.date_updated, property_master_update.flatname, 
                           property_master_update.owner_name, property_master_update.isflat, 
                           property_master_update.address_street, property_master_update.gpsaccuracy, 
                           property_master_update.ward_no, property_master_update.audit_remark, 
                           property_master_update.isreject, tbl_audit_status.call_status, 
                           tbl_audit_status.address_verification_remark, tbl_audit_status.call_date, 
                           master_surveyor.first_name, master_surveyor.last_name, 
                           master_surveyor.mobile, master_surveyor.vendor_id, master_vendor.vendor_name, 
                           master_ward.ward_no, master_circle.circle_name, master_admin.first_name AS fname, 
                           master_admin.last_name AS lname, tbl_audit_status.owner_apt_name, tbl_audit_status.updated_address');
        $this->db->from('property_master_update');
        $this->db->join('tbl_audit_status', 'property_master_update.p_record_id = tbl_audit_status.p_record_id', 'left');
        $this->db->join('master_ward', 'property_master_update.ward_no = master_ward.ward_no', 'left');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id', 'left');
        $this->db->join('master_admin', 'property_master_update.audited_by = master_admin.admin_id', 'left');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId', 'left');
        $this->db->join('master_vendor', 'master_surveyor.vendor_id = master_vendor.vendor_id', 'left');
        //$this->db->where('property_master_update.audited_by', $userId); 
        $this->db->where('property_master_update.ward_no', $ward_no); 
        //$this->db->like('property_master_update.date_updated', $date, 'both', false);
        $this->db->where('DATE(property_master_update.date_updated) >=', date('Y-m-d',strtotime($date_from)));
        $this->db->where('DATE(property_master_update.date_updated) <=', date('Y-m-d',strtotime($date_to)));
        $q = $this->db->get();
        return $q->result();  
    }    

    function checkCallRemarkPid($pid) {
        $this->db->select('tbl_audit_status.p_record_id');
        $this->db->from('tbl_audit_status');
        $this->db->where('tbl_audit_status.p_record_id', $pid);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs;
    }

    function updateCallRemark($p_record_id, $dbdata2) {
       $key = 'p_record_id';
       $value = $p_record_id;
       $this->db->where($key, $value);
       $this->db->update('tbl_audit_status', $dbdata2); 
    }

    function insertCallRemark($dbdata1) {
       $this->db->insert('tbl_audit_status', $dbdata1);
    }
    
    function updatePropertyRemark($p_record_id, $dbdata) {
       $key = 'p_record_id';
       $value = $p_record_id;
       $this->db->where($key, $value);
       $this->db->update('property_master_update', $dbdata); 
    }
    
     public function getWardBoundary($ward_no) {
        $this->db->select('*');
        $this->db->from('master_ward');
        $this->db->where('ward_no', $ward_no); 
        $q = $this->db->get();
        return $q->row(0);
    }
    
     public function allExistingProperty($ward_no) {
        $this->db->select('property_master_update.p_record_id, 
                           property_master_update.owner_name, 
                           property_master_update.mobile_no, 
                           property_master_update.isflat, 
                           property_master_update.pid, 
                           property_master_update.date_added, 
                           property_master_update.date_updated, 
                           property_master_update.updated_by_user, 
                           property_master_update.qr_code,
                           master_surveyor.first_name, 
                           master_surveyor.last_name');        
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId', 'left');
        $this->db->where('property_master_update.ward_no', $ward_no); 
        $this->db->where('property_master_update.isnew', '0');
        $this->db->order_by('property_master_update.p_record_id', 'DESC');
        $q = $this->db->get();
        return $q->result();
    }
    
    function getWardNumber($pid) {
        $this->db->select('ward_no');
        $this->db->from('property_master');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->ward_no;
    }
    

    function deleteExistingProperty($pid) {
        
        $this->db->where("pid", $pid);
        $this->db->delete('property_master_update'); 
        
    }
    function updateExistingProperty($pid) {
        $data = array(
          'isUpdate' => 0, 
          'updated_by_user' => 0
        );
        $this->db->where('pid', $pid);
        $this->db->update('property_master', $data);
    }

    function getCircleID($ward_no) {
        $this->db->select('circle_id');
        $this->db->from('master_ward');
        $this->db->where('ward_no', $ward_no);
        $query = $this->db->get()->result_array();
        return $query;
    }
    
     function getCircleDetailsByWardID($ward_no) {
        $this->db->select('master_circle.*');
        $this->db->from('master_ward');
        $this->db->where('master_ward.ward_no', $ward_no);
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id');
        $query = $this->db->get();
        $rs = $query->row(0);  
        return $rs;
    }

    public function allNewPropertyData($propertyId, $image_type) {
        if($image_type == 0 ) {
         $this->db->select('property_master_update.p_record_id, property_master_update.pid , 
                           property_master_update.survey_status, property_master_update.gpsaccuracy ,
                           property_master_update.date_updated, property_master_update.qr_code ,
                           property_master_update.latitude, property_master_update.longitude ,
                           property_master_update.sector, property_master_update.area_landmark , 
                           property_master_update.address_street, property_master_update.houseno , 
                           property_master_update.flatName, property_master_update.property_type , 
                           property_master_update.occupancy_status, property_master_update.no_of_properties , 
                           property_master_update.building_type, property_master_update.mobile_no ,
                           property_master_update.guardian_name, property_master_update.owner_name ,
                           property_master_update.ward_no , property_master_update.circle_id ,
                           property_master_update.isflat  , 
                           master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $propertyId);

        } else {

        $this->db->select('property_master_update.*, 
                           master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $propertyId);
       }
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }

    public function getallbuildingType() {
        $this->db->select('*');
        $this->db->from('master_building_type');
        $this->db->order_by("type_id", "ASC");
        $q = $this->db->get();
        return $q->result();
    }
 
 
    public function surveyDoneExistingProperty($ward_no , $date="") {
        if($date == "") {
         $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."' AND isnew = '0' ");
        } else {
         $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."' AND isnew = '0' AND date_updated like '%".$date."%'");    
        }
        return intval($query->num_rows());
    }
    
    public function surveyDoneNewProperty($ward_no, $date="") {
        if($date == "") {
            $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."' AND isnew = '1' ");
        } else {
            $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."' AND isnew = '1' AND date_updated like '%".$date."%'"); 
        }
        return intval($query->num_rows());
    }
    
    
    public function totalPropertySurveyed($ward_no, $date="") {
        if($date == "") {
            $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."'  ");
        } else {
            $query = $this->db->query("SELECT p_record_id FROM property_master_update WHERE ward_no = '".$ward_no."' AND date_updated like '%".$date."%'"); 
        }
        return intval($query->num_rows());
    }
    
    
    
    public function individualSurveyReport($ward_no , $date) {
        
        $sql = " SELECT master_surveyor.first_name, master_surveyor.last_name ,count(*) as total_done " ;
        $sql .= " FROM property_master_update , master_surveyor WHERE property_master_update.date_updated ";
        $sql .= " like '%".$date."%' AND property_master_update.ward_no = '".$ward_no."' AND   master_surveyor.userId = property_master_update.updated_by_user " ;
        $sql .= " GROUP BY property_master_update.updated_by_user " ;
        $query = $this->db->query($sql);
        $result = $query->result();
        /*
        $this->db->select('property_master_update.*, master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $propertyId);
        $q = $this->db->get();
        $details = $q->row(0);*/
        return $result;
    }
    
    
    function totalSurveyDoneAllWards() {
        /*
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $total = $this->db->get()->num_rows();
        return  $total;*/
        
        $this->db->select('count(p_record_id) as total');
        $this->db->from('property_master_update');
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total;
    }
    
    
     function newPropertiesSurveyedAllWards() {
        /* 
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.isNew', '1');
        $total = $this->db->get()->num_rows();
        return  $total;*/
        
        
         
        $this->db->select('count(p_record_id) as total');
        $this->db->from('property_master_update');
        $this->db->where('isNew', '1');
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total;
    }
    
    
    function oldPropertiesSurveyedAllWards() {
        /*
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.isNew', '0');
        $total = $this->db->get()->num_rows();
        return  $total;*/
        
        $this->db->select('count(p_record_id) as total');
        $this->db->from('property_master_update');
        $this->db->where('isNew', '0');
        $query = $this->db->get();
        $rs = $query->row(0);
        return $rs->total;
    }
    
    function getApartmentDetails($pid) {
        $this->db->select('property_master_update.*, master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $pid);
        $this->db->where('isflat', '1');
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }
    
    
    function getIndividualDetails($pid) {
        $this->db->select('property_master_update.*, master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $pid);
        $this->db->where('isflat', '0');
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }
    
     public function getWardCircle()  {
        
        $this->db->select('master_ward.ward_no, 
                           master_circle.circle_name');
        $this->db->from('master_ward');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id');
         $this->db->order_by("ward_no", "ASC");
        $q = $this->db->get();
        return $q->result();  
    }
    
    public function getWardWiseAllCircles()  {
        
        $query_str = $this->db->select('master_ward.*, (SELECT circle_name FROM master_circle WHERE master_circle.circle_id = master_ward.circle_id) AS circle');
        $this->db->from('master_ward');
        $this->db->order_by('circle_id', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getTodaySurWiseQRInstalled()  {
        
        $date = date('Y-m-d');
        $this->db->select('property_master_update.ward_no, 
                           master_circle.circle_name,  
                           master_vendor.vendor_name,  
                           property_master_update.updated_by_user, 
                           COUNT(property_master_update.updated_by_user) AS Survey_Done, 
                           property_master_update.date_updated, 
                           master_surveyor.first_name, master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->join('master_ward', 'property_master_update.ward_no = master_ward.ward_no');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id');
        $this->db->join('ward_vendor', 'property_master_update.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $this->db->group_by('date(date_updated),updated_by_user');
        $this->db->like('property_master_update.date_updated', $date, 'both', false);
        //$this->db->where('ward_no', $ward_no);
        $q = $this->db->get();
        return $q->result();   
    }
    function getAllVendors() {
        $this->db->select('*');
        $this->db->from('master_vendor');
        $q = $this->db->get();
        return $q->result();
    }
    public function getSurWiseQRInstalled($date_from, $date_to, $vendor_id, $ward_no)  {
        
        
        $this->db->select('property_master_update.ward_no, 
                           master_circle.circle_name,  
                           master_vendor.vendor_name,  
                           property_master_update.updated_by_user, 
                           COUNT(property_master_update.updated_by_user) AS Survey_Done, 
                           property_master_update.date_updated, 
                           master_surveyor.first_name, master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->join('master_ward', 'property_master_update.ward_no = master_ward.ward_no');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id');
        $this->db->join('ward_vendor', 'property_master_update.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $this->db->group_by('date(date_updated),updated_by_user');
        $this->db->where('property_master_update.date_updated BETWEEN "'.$date_from.'" AND "'.$date_to.'"'); 
        if($ward_no!='')
        {
            $this->db->where('property_master_update.ward_no', $ward_no);
        }        $this->db->where('master_vendor.vendor_code', $vendor_id);
        $q = $this->db->get();
        return $q->result();    
    }
    public function getDateWiseQRInstalled($date_from, $date_to, $vendor_id, $ward_no)  {
        
        
        $this->db->select('property_master_update.ward_no, 
                           master_circle.circle_name, master_vendor.vendor_name, 
                           COUNT(property_master_update.p_record_id) AS Survey_Done, 
                           property_master_update.date_updated');
        $this->db->from('property_master_update');
        //$this->db->join('master_ward', 'property_master_update.ward_no = master_ward.ward_no');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        //$this->db->join('ward_vendor', 'property_master_update.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'property_master_update.vendor_code = master_vendor.vendor_code');
        $this->db->group_by('date(date_updated),ward_no');
        $this->db->where('property_master_update.date_updated BETWEEN "'.$date_from.'" AND "'.$date_to.'"'); 
        if($ward_no!='')
        {
            $this->db->where('property_master_update.ward_no', $ward_no);
        }
        $this->db->where('property_master_update.vendor_code', $vendor_id); 
        $q = $this->db->get();
        return $q->result();   
    }
    /*public function getTodayQRInstalled()  {
        
        $date = date('Y-m-d');
        $this->db->select('property_master_update.ward_no, 
                           master_circle.circle_name, master_vendor.vendor_name, 
                           COUNT(property_master_update.p_record_id) AS Survey_Done, 
                           property_master_update.date_updated');
        $this->db->from('property_master_update');
        $this->db->join('master_ward', 'property_master_update.ward_no = master_ward.ward_no');
        $this->db->join('master_circle', 'master_ward.circle_id = master_circle.circle_id');
        $this->db->join('ward_vendor', 'property_master_update.ward_no = ward_vendor.ward_no');
        $this->db->join('master_vendor', 'ward_vendor.vendor_code = master_vendor.vendor_code');
        $this->db->group_by('date(date_updated),ward_no');
        $this->db->like('property_master_update.date_updated', $date, 'both', false);  
        $q = $this->db->get();
        return $q->result();   
    }*/
    public function getTodayQRInstalled()  {
        
        $date = date('Y-m-d');
        $this->db->select('property_master_update.ward_no, 
                           master_circle.circle_name, master_vendor.vendor_name, 
                           COUNT(property_master_update.p_record_id) AS Survey_Done, 
                           property_master_update.date_updated');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_vendor', 'property_master_update.vendor_code = master_vendor.vendor_code');
        $this->db->group_by('date(date_updated),ward_no');
        $this->db->like('property_master_update.date_updated', $date, 'both', false);  
        $q = $this->db->get();
        return $q->result();   
    }
    public function getWardWiseSurveyorSurveyed($ward_no)  {
        
        
        $this->db->select('property_master_update.ward_no, 
                           property_master_update.updated_by_user, 
                           COUNT(property_master_update.updated_by_user) AS Survey_Done, 
                           property_master_update.date_updated, 
                           master_surveyor.first_name, master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->group_by('date(date_updated),updated_by_user');
        $this->db->where('ward_no', $ward_no);
        $query = $this->db->get()->result_array();
        return $query;    
    }

    public function createExcelWardWise($ward_no)  {
        
        
        $this->db->select('property_master_update.ward_no, 
                           property_master_update.updated_by_user, 
                           COUNT(property_master_update.updated_by_user) AS Survey_Done, 
                           property_master_update.date_updated, 
                           master_surveyor.first_name, master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->group_by('date(date_updated),updated_by_user');
        $this->db->where('ward_no', $ward_no);
        $q = $this->db->get();
        return $q->result(); 
    }
    
    public function getWardWiseTodaySurveyed($reportdate, $ward_no)  {
        
        $date = date('Y-m-d');
	$this->db->select('property_master_update.ward_no, 
                           property_master_update.updated_by_user, 
                           COUNT(property_master_update.updated_by_user) AS Survey_Done, 
                           property_master_update.date_updated, 
                           master_surveyor.first_name, master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->group_by('date(date_updated),updated_by_user');
        $this->db->where('ward_no', $ward_no);
        $this->db->like('date_updated', $reportdate, 'both', false);          
        $q = $this->db->get();
        return $q->result();  
    }
    function getWeekData() {
        $sql = "select count(p_record_id) as 'total', DATE(date_updated) as date from property_master_update where date_updated between (CURDATE() - INTERVAL 8 DAY) and (CURDATE() - INTERVAL 0 DAY) group by DATE(date_updated)";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

  

   // SELECT `updated_by_user` ,count(*) as total_done FROM `property_master_update` WHERE `date_updated` like '%2020-12-20%' GROUP BY `updated_by_user` 



}
