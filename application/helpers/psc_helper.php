<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter/Excise Application
 *
 * Special helper functions excise application
 *
 * @package		Work Shop Application
 * @author		Pinak Pani Nath
 * @copyright	Copyright (c) 2020 - 2021, Itanagar
 
 * @filesource
 */

// ------------------------------------------------------------------------



if(!function_exists('totalSurveyDoneAllCircle')){
 function totalSurveyDoneAllCircle($circle_id) {
    $ci = &get_instance();
    $ci->load->model('Master_dashboard');
    return $ci->Master_dashboard->totalSurveyDoneAllCircle($circle_id);  
 } 
}


if(!function_exists('totalSurveyDoneTodayCircle')){
 function totalSurveyDoneTodayCircle($circle_id, $date) {
    $ci = &get_instance();
    $ci->load->model('Master_dashboard');
    return $ci->Master_dashboard->totalSurveyDoneTodayCircle($circle_id, $date);  
 } 
}


if(!function_exists('totalExistingPropertyCircle')){
 function totalExistingPropertyCircle($circle_id) {
    $ci = &get_instance();
    $ci->load->model('Master_dashboard');
    return $ci->Master_dashboard->totalExistingPropertyCircle($circle_id);  
 } 
}




/* End of file excise_helper.php */
/* Location: ./application/helpers/excise_helper.php */
?>