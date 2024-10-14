<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_property extends CI_Model {

    public function getallbuildingType() {
        $this->db->select('*');
        $this->db->from('master_building_type');
        $this->db->order_by("type_id", "ASC");
        $q = $this->db->get();
        return $q->result();
    }

    public function allProperties() {
        $this->db->select('*');
        $this->db->from('property_master');
        //$this->db->where('master_surveyor.status', 0); 
        $this->db->order_by("record_id", "ASC");
        $q = $this->db->get();
        return $q->result();
    }

    public function allPropertyData($propertyId) {
        $this->db->select('*');
        $this->db->from('property_master');
        $this->db->where('property_master.record_id', $propertyId);
        $q = $this->db->get();
        return $q->result();
    }

    public function allSurveyedPropertyData($propertyId) {
        $this->db->select('property_master_update.*, master_circle.circle_name, master_surveyor.first_name , master_surveyor.last_name');
        $this->db->from('property_master_update');
        $this->db->join('master_circle', 'property_master_update.circle_id = master_circle.circle_id');
        $this->db->join('master_surveyor', 'property_master_update.updated_by_user = master_surveyor.userId');
        $this->db->where('pid', $propertyId);
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }

    function updateProperty($property, $data) {
        $key = 'record_id';
        $value = $property;
        $this->db->where($key, $value);
        $this->db->update('property_master', $data);
    }
    
    
    function updateSurveyedProperty($key, $value, $data) {
        $this->db->where($key, $value);
        $this->db->update('property_master_update', $data);
    }

    function insertProperty($data) {
        $this->db->insert('property_master', $data);
    }

    function insertSurveyor($data) {
        $this->db->insert('master_surveyor', $data);
    }

    function insertWardsurveyor($data) {
        $this->db->insert('master_surveyor', $data);
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
        $this->db->join('master_ward', 'master_surveyor.wardId = master_ward.ward_id', 'left');
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
    
    
    function removeNewIndividual($pid) {
        
        $this->db->where("pid", $pid);
        $this->db->where("isflat", '0');
        $this->db->where("isnew", '1');
        $this->db->delete('property_master_update'); 
        
    }
    
    
     function removeNewApartment($pid) {
        
        $this->db->where("pid", $pid);
        $this->db->where("isflat", '1');
        $this->db->where("isnew", '1');
        $this->db->delete('property_master_update'); 
        
    }

    /* public function updateWardsurveyor($surveyor, $ward) {
      $query = $this->db->query("UPDATE master_surveyor SET 'wardId' = '".$ward."' WHERE 'userId' = 1");

      return $query;
      //return $this->db->insert();
      } */
}
