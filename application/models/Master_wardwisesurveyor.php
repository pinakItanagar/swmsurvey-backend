<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_wardwisesurveyor extends CI_Model {


    
    public function getSurveyors()
    {
        $master_surveyor = $this->db->get('master_surveyor')->result_array();
        return $master_surveyor;
    }
}
