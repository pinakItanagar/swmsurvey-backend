<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_route extends CI_Model {


    function insertRoute($data) {
       $this->db->insert('master_route', $data);
    }   


    

     function allRouteDetails($key, $value) {
        $this->db->select('*');
        $this->db->from('master_route');
        $this->db->where($key, $value);
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }


    function insertRoutePoint($data) {
       $this->db->insert('route_point', $data);
    } 


    function updateRoute($data, $key, $value) {
       $this->db->where($key, $value);
       $this->db->update('master_route', $data); 
    }
   

    public function allRoutes() {
        $this->db->select('*');
        $this->db->from('master_route');
        $this->db->order_by("route_id", "DESC"); 
        $q = $this->db->get();
        return $q->result();
    }


    public function allWayPointsByrouteID($routeID) {
        $this->db->select('*');
        $this->db->from('route_point');
        $this->db->where('route_id', $routeID);
        $this->db->where('point_type', "WAYPOINT");
        $this->db->order_by("route_point_id", "ASC"); 
        $q = $this->db->get();
        return $q->result();
    }


    public function getStartPointByID($routeID) {
        $this->db->select('*');
        $this->db->from('route_point');
        $this->db->where('route_id', $routeID);
        $this->db->where('point_type', "START");
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }


    public function getEndPointByID($routeID) {
        $this->db->select('*');
        $this->db->from('route_point');
        $this->db->where('route_id', $routeID);
        $this->db->where('point_type', "END");
        $q = $this->db->get();
        $details = $q->row(0);
        return $details;
    }


    public function isRoutePointExist($point_type, $route_id) {
        $rows = 0;
        $query = $this->db->query("SELECT * FROM route_point WHERE point_type = '".$point_type."' AND route_id = '".$route_id."'");
        $rows = intval($query->num_rows());
        if($rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function totalItem() {
        $query = $this->db->query('SELECT * FROM product_item');
        return intval($query->num_rows());
    }




 


   


    function getProductItemList($key, $value) {
         $this->db->select('*');
        $this->db->from('product_item');
        $this->db->where($key, $value);
        $this->db->order_by("product_item_id", "ASC"); 
        $q = $this->db->get();
        return $q->result();
    }


    public function totalItemInStock($key, $value) {
        $query = $this->db->query("SELECT * FROM product_item WHERE ".$key." = '".$value."' AND item_status = '1' ");
        return intval($query->num_rows());
    }



    function removeProduct($key, $value) {
       $this->db->where($key, $value);
       $this->db->delete('master_product'); 
      
    }


    function removeProductItem($key, $value) {
       $this->db->where($key, $value);
       $this->db->delete('product_item'); 
      
    }  


}
