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



if(!function_exists('totalItemInStock')){
 function totalItemInStock($key, $value) {
    $ci = &get_instance();
    $ci->load->model('Master_product');
    return $ci->Master_product->totalItemInStock($key, $value);  
 } 
}


if(!function_exists('convert2Decimal')){
 function convert2Decimal($number) {
    return  number_format((float)$number, 2, '.', '');
 } 
}




/* End of file excise_helper.php */
/* Location: ./application/helpers/excise_helper.php */
?>