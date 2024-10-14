<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_user extends CI_Model {

 


    public function verifyUser($user_id, $pass_code) {

        $rs = null;
	$this->db->select(" 
                            master_admin.admin_id,
                            master_admin.first_name,
                            master_admin.last_name,
                            master_admin.user_id,
                            master_admin.user_role_id,
                            master_admin_role.role_name
                         ");
        $this->db->from('master_admin');
        $this->db->where("master_admin.user_id", trim($user_id)); 
        $this->db->where("master_admin.user_password", md5(trim($pass_code))); 
        $this->db->join('master_admin_role', 'master_admin.user_role_id = master_admin_role.role_id');
        $q = $this->db->get();
        if($q != null) {
            $rs = $q->row(0);
        } else {
            $rs = null;
        }
        return $rs;
	}


    public function verifyDuplicate($user_email) {

        $this->db->select('user_id');
        $this->db->from('mcb_app_user');
        $this->db->where("user_email", trim($user_email)); 
        $q = $this->db->get();
         $iflag = 0;
        if($q->row()) {
            $iflag = 1;
        } else {
           $iflag = 0;
        }
        return $iflag;
    }


    public function insertERPUSER($dbdata) {
       $this->db->insert('mcb_app_user', $dbdata);
    }


     public function updateERPUSER($dbdata, $user_email) {
       $this->db->where('user_email', $user_email);
       $this->db->update('mcb_app_user', $dbdata);
    }


    public function getUserList() {
       
        $this->db->select('*');
        $this->db->from('app_registered_user');
        $this->db->order_by("app_user_id", "ASC"); 
        $q = $this->db->get();
  
        return $q->result();

    }


     public function getUserDetails($user_id) {

        $this->db->select('*');
        $this->db->from('mcb_app_user');
        $this->db->where("user_id", trim($user_id)); 
        $q = $this->db->get();
        $user_details = $q->row();
        return $user_details;
    }
    
    public function getallvillages(){
        $this->db->order_by('village_name', 'asc');
        $res = $this->db->get('master_village');
        return $res->result();
    }
    
    public function getallmonths(){
        $res = $this->db->get('months');
        return $res->result();
    }
    
    public function savematernalpatients($formdata){
        $this->db->insert('maternal_patients', $formdata);
        return true;
    }


}
