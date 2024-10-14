<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");



class Geocode extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     * Formula: 
     * GST Amount = GST Inclusive Price * GST Rate /(100 + GST Rate Percentage) 
     * Original Cost = GST Inclusive Price * 100/(100 + GST Rate Percentage)
     */
    public function __construct() {
        parent::__construct();
      
    }

    public function area() {
        $data = "";
        $geojson = base_url("upload/wardboundary/allWard.geojson");
        $data['patna'] = file_get_contents($geojson);
        $pagename = "geocode/area";
        $title = "Find area name";
        $data['maps'] = "MAP";
        $this->page($pagename, $title, $data);
    }

    public function getReport() {
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "armsensor/reportform";
        $title = "Vehicle activity report";
        $this->page($pagename, $title, $data);
    }

    public function deleteAllJcbData() {
        $payload = '["JCB_SENSOR_DATA" , "JCB1234"]';
        $jcbdata = $this->couchdb->getCouchDbAllDocs($payload, "_design/survey/_view/getAllJCBData?&ascending=true&key=");
        
    }

    public function showAllJcbData($date) {
        $general_report = array();
        $payload = '["JCB_SENSOR_DATA" , "JCB1234", "'.$date.'"]';
        $cdb = $this->couchdb->getCouchDbAllDocs($payload, "_design/survey/_view/getAllJCBData?&descending=true&key=");
        $total_rows = $cdb->total_rows;
        $jcbdata = $cdb->rows;
        //echo "<pre>";
        //print_r($jcbdata);
        //die();
        
        for($i=0; $i<$total_rows; $i++) {
            if(isset($cdb->rows[$i]->value->time) && isset($cdb->rows[$i]->value->date) && isset($cdb->rows[$i]->value->jcb_data->x) && isset($cdb->rows[$i]->value->jcb_data->y) && isset($cdb->rows[$i]->value->jcb_data->z) )  {  
                $date =  $cdb->rows[$i]->value->date;
                $time =  $cdb->rows[$i]->value->time;
                $x =  $cdb->rows[$i]->value->jcb_data->x;
                $y =  $cdb->rows[$i]->value->jcb_data->y;
                $z =  $cdb->rows[$i]->value->jcb_data->z;
                $j = $i + 1;
                if($j<$total_rows) {
                  if(isset($cdb->rows[$j]->value->time) && isset($cdb->rows[$j]->value->date) && isset($cdb->rows[$j]->value->jcb_data->x) && isset($cdb->rows[$j]->value->jcb_data->y) && isset($cdb->rows[$j]->value->jcb_data->z) )  {  
                    $report =  $this->analyzedata($date, $time, $x, $y, $z, $cdb->rows[$j]);
                    array_push($general_report, $report);
                  }

                }
            }
        }
        
        
        
        $data['date'] = $date;
        $data['reports'] = $general_report;
        $this->load->vars($data);
        $this->load->view('armsensor/ajax_reportarmsensor');     
        
        /*
        $pagename = "armsensor/reportdata";
        $title = "Vehicle activity report";
        $data['jcbdata'] = $jcbdata;
        $this->page($pagename, $title, $data);*/
    }
    
    
     public function reportAllJcbData($date) {
        $general_report = array();
        $payload = '["JCB_SENSOR_DATA" , "JCB1234", "'.$date.'"]';
        $cdb = $this->couchdb->getCouchDbAllDocs($payload, "_design/survey/_view/getAllJCBData?&descending=true&key=");
        $total_rows = $cdb->total_rows;
        $jcbdata = $cdb->rows;
        //echo "<pre>";
        //print_r($jcbdata);
        //die();
        
        for($i=0; $i<$total_rows; $i++) {
            if(isset($cdb->rows[$i]->value->time) && isset($cdb->rows[$i]->value->date) && isset($cdb->rows[$i]->value->jcb_data->x) && isset($cdb->rows[$i]->value->jcb_data->y) && isset($cdb->rows[$i]->value->jcb_data->z) )  {  
                $date =  $cdb->rows[$i]->value->date;
                $time =  $cdb->rows[$i]->value->time;
                $x =  $cdb->rows[$i]->value->jcb_data->x;
                $y =  $cdb->rows[$i]->value->jcb_data->y;
                $z =  $cdb->rows[$i]->value->jcb_data->z;
                $j = $i + 1;
                if($j<$total_rows) {
                  if(isset($cdb->rows[$j]->value->time) && isset($cdb->rows[$j]->value->date) && isset($cdb->rows[$j]->value->jcb_data->x) && isset($cdb->rows[$j]->value->jcb_data->y) && isset($cdb->rows[$j]->value->jcb_data->z) )  {  
                    $report =  $this->analyzedata($date, $time, $x, $y, $z, $cdb->rows[$j]);
                    array_push($general_report, $report);
                  }

                }
            }
        }
        
        
       return $general_report;
    }
    
    
    public function analyzedata($date, $time, $x, $y, $z , $next) {
        
        $report = "";
        
       
        
        if($x > $next->value->jcb_data->x ) {
            $diff_x = $x - $next->value->jcb_data->x ;
        } else {
            $diff_x =  $next->value->jcb_data->x - $x;
        }
        
         if($y > $next->value->jcb_data->y ) {
            $diff_y = $y - $next->value->jcb_data->y ;
         } else {
            $diff_y =  $next->value->jcb_data->y - $y;
         }
         
         
         if($z > $next->value->jcb_data->z ) {
            $diff_z = $z - $next->value->jcb_data->z ;
         } else {
            $diff_z =  $next->value->jcb_data->z - $z;
         }
     
        if($diff_x > 20) {
           $report = array( 
                            "start_time" => $time , 
                            "end_time" => $next->value->time , 
                            "arm_movement" => "YES", 
                            "x" =>  $next->value->jcb_data->x,
                            "y" =>  $next->value->jcb_data->y,
                            "z" =>  $next->value->jcb_data->z,
                            ) ;
        } elseif($diff_y > 20) { 
            $report = array( 
                "start_time" => $time , 
                "end_time" => $next->value->time , 
                "arm_movement" => "YES", 
                "x" =>  $next->value->jcb_data->x,
                "y" =>  $next->value->jcb_data->y,
                "z" =>  $next->value->jcb_data->z,
            ) ;  
         } elseif($diff_z > 20) { 
             
              $report = array( 
                            "start_time" => $time , 
                            "end_time" => $next->value->time , 
                            "arm_movement" => "YES", 
                            "x" =>  $next->value->jcb_data->x,
                            "y" =>  $next->value->jcb_data->y,
                            "z" =>  $next->value->jcb_data->z,
                            ) ;
             
         } else {
             
              $report = array( 
                            "start_time" => $time , 
                            "end_time" => $next->value->time , 
                            "arm_movement" => "NO", 
                            "x" =>  $next->value->jcb_data->x,
                            "y" =>  $next->value->jcb_data->y,
                            "z" =>  $next->value->jcb_data->z,
                            ) ;
             
             
         }
         
            
                       
        
       
        
        return $report;
        
        
    }
    
    
    public function downloadxls($report_date) {
        
        $reports = $this->reportAllJcbData($report_date);
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'borders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
        $styleArray3 = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        
        
      
    
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('JCB ARM Movement Report');
       // Set the value of cell A1 
      
        $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "Report Date : ".$report_date."  Vehicle No : BR001"); 
        
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "#SLNO"); 
        
   
        
        
         $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(22);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', "Start Time");
        
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(22);
        $sheet->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('C3', "End Time");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->setCellValue('D3', "X-Axis"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('E3', "Y-Axis"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $sheet->getStyle('F3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', "Z-Axis"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $sheet->getStyle('G3')->getFont()->setBold(true);
        $sheet->setCellValue('G3', "Arm Movement Detected"); 
        
        
        $rowNo =  4;
        $cellNo = "";
        $slno = 1;
        for($i=0; $i<count($reports); $i++) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
          $cellF = "F".$rowNo  ;
          $cellG = "G".$rowNo  ;
          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, $reports[$i]['end_time']);
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $reports[$i]['start_time']);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3);
          $sheet->getStyle($cellC)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellD, $reports[$i]['x']);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE,  $reports[$i]['y']);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellF,  $reports[$i]['z']);
          $sheet->getStyle($cellF)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellG,  $reports[$i]['arm_movement']);
          $sheet->getStyle($cellG)->applyFromArray($styleArray3);
          
         
          $rowNo++;
          $slno++;   
        }
       
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'arm_movement_report_'.date("YmdHis").'.xlsx' ;
        $reportFile = 'xlsreport/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);
        
    }
    
    
     public function page($pagename, $title, $data) {

        if (!$this->session->userdata('USER_ID')) {
            redirect('home/logout');
        }

        $staticdata['header_script'] = 'template/include/header_scripts';
        $staticdata['app_header'] = 'template/include/app_header';
        $staticdata['app_sidemenu'] = 'template/include/app_sidemenu';
        $staticdata['app_breadcrum'] = 'template/include/app_breadcrum';
        $staticdata['page_title'] = $title;
        $staticdata['app_maincontent'] = $pagename;
        $staticdata['footer_copyright'] = 'template/include/footer_copyright';
        $staticdata['footer_script'] = 'template/include/footer_scripts';
        $this->load->vars($staticdata);
        $this->load->vars($data);
        $this->load->view('template/admin_tpl');
    }

  

}


?>