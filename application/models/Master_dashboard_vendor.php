<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_dashboard_vendor extends CI_Model {
    
    public function getVendorWards($vendor_code)  {
        $query_str = $this->db->select('*');
        $this->db->from('ward_vendor');
         $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId', 'left');
        $this->db->where('vendor_code', $vendor_code);
        $q = $this->db->get();
        return $q->result();
    }
    
    
   
    function propertiesCount() {
        $this->db->select('record_id');
        $this->db->from('property_master');
        //$this->db->where('property_master.isUpdate', '1');
        $total = $this->db->get()->num_rows();
        return  $total;
    }

    function pendingPropertiesCount() {
        $this->db->select('record_id');
        $this->db->from('property_master');
        $this->db->where('property_master.isUpdate', '0');
        $total = $this->db->get()->num_rows();
        return  $total;
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
    
    public function getWardByCircleID($circle_id)  {
        
       
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
    
    
     public function getSurveyedPropertyByDate($ward_no,$date ) {
        $this->db->select('latitude, longitude, qr_code, pid, date_updated, flatname, owner_name, isflat, address_street, gpsaccuracy, ward_no');
        $this->db->from('property_master_update');
        $this->db->where('ward_no', $ward_no); 
        $this->db->like('date_updated', $date, 'both', false);
        $q = $this->db->get();
        return $q->result();
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

    public function allNewPropertyData($propertyId) {
        $this->db->select('property_master_update.*, master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $propertyId);
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
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
     function newPropertiesSurveyedAllWards() {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.isNew', '1');
        $total = $this->db->get()->num_rows();
        return  $total;
    }
    
    
    function oldPropertiesSurveyedAllWards() {
        $this->db->select('p_record_id');
        $this->db->from('property_master_update');
        $this->db->where('property_master_update.isNew', '0');
        $total = $this->db->get()->num_rows();
        return  $total;
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
    

    function getWeekData() {
        $sql = "select count(p_record_id) as 'total', DATE(date_updated) as date from property_master_update where date_updated between (CURDATE() - INTERVAL 8 DAY) and (CURDATE() - INTERVAL 0 DAY) group by DATE(date_updated)";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

  

   // SELECT `updated_by_user` ,count(*) as total_done FROM `property_master_update` WHERE `date_updated` like '%2020-12-20%' GROUP BY `updated_by_user` 



}
