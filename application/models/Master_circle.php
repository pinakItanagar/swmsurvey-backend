<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_circle extends CI_Model {


    
    public function getCircles()
    {
        # code...
        $circles = $this->db->get('master_circle')->result_array();
        return $circles;
    }

    public function getWardsOfACircle($circle_id)
    {
        $this->db->where('circle_id',$circle_id);
        $wards = $this->db->get('master_ward')->result_array();
        return $wards;
    }
}
