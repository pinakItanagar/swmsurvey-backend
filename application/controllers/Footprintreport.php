<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
require APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
//use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Footprintreport extends CI_Controller {

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
        $this->load->model('Master_property', 'tblProperty');
        $this->load->model('Master_circle', 'tblCircle');
        $this->load->model('Master_footprintreport', 'tblFootprintReport');
        $this->load->library('couchdb');
    }

    public function report() {
        $date = date("Y-m-d");
        $data['isDateField'] = true;
        $pagename = "report/footprintform";
        $title = "Building foot print vs QR  code installation report";
        $this->page($pagename, $title, $data);
    }
    
    public function preparereport() {
        $report_date =  $_POST['report_date'] ;
        $all_ward = $this->tblFootprintReport->getAllWardByVendor();
        $array_report_date = explode("-", $report_date);
        $report_id = $array_report_date[0].$array_report_date[1].$array_report_date[2]; 
        $current_date = date("Y-m-d") ;
        
        if ($this->tblFootprintReport->isReportExist($report_date) == false) {
              
            if($report_date == $current_date) {
                
                foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
                 
            } else {
                
                 foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
                
            }
            
        } else {
            
            if($report_date == $current_date) {
                 $this->tblFootprintReport->removeReport($report_date);
                 
                  foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
            }
        }
        
        
        $reports =  $this->tblFootprintReport->getReport($report_date);
        $data['date'] = $report_date;
        $data['reports'] = $reports;
        $this->load->vars($data);
        $this->load->view('report/ajax_footprintreport');
    }
    
    
    
     public function autopreparereport($report_date) {
        
        $all_ward = $this->tblFootprintReport->getAllWardByVendor();
        $array_report_date = explode("-", $report_date);
        $report_id = $array_report_date[0].$array_report_date[1].$array_report_date[2]; 
        $current_date = date("Y-m-d") ;
        
        if ($this->tblFootprintReport->isReportExist($report_date) == false) {
              
            if($report_date == $current_date) {
                
                foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
                 
            } else {
                
                 foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
                
            }
            
        } else {
            
            if($report_date == $current_date) {
                 $this->tblFootprintReport->removeReport($report_date);
                 
                  foreach ($all_ward as $ward) {

                    $total_footprint = $ward->total_footprints;
                    $ward_no = $ward->ward_no;
                    $vendor_code = $ward->vendor_code;
                    $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
                    $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
                    $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
                    if(intval($total_footprint) >  $total_qrcode_installed ) {
                      $pending_installation = intval($total_footprint) - $total_qrcode_installed;
                    } else {
                      $pending_installation = 0;  
                    }
                    $data = array(
                        "report_id" => $report_id,
                        "report_date" => $report_date,
                        "ward_no" => $ward_no,
                        "total_footprint" => $total_footprint,
                        "vendor_code" => $vendor_code,
                        "vendor_name" => $vendor_name,
                        "total_qrcode_installed_today" => $total_qrcode_installed_today,
                        "total_qrcode_installed" => $total_qrcode_installed,
                        "pending_installation" => $pending_installation
                    );

                    $this->tblFootprintReport->insertReport($data);
                }
            }
        }
     
    }
    
    public function downloadxls($report_date) {
        
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
        
        
      
        $this->autopreparereport($report_date);
        $reports = $this->tblFootprintReport->getReport($report_date);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Daily QR Code report');
       // Set the value of cell A1 
      
        $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "Report Date : ".$report_date); 
        
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "#SLNO"); 
        
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', "Ward No");
        
        
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $sheet->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('C3', "Vendor");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->setCellValue('D3', "Total Building Footprints"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('E3', "QR Code Installed Till Date"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $sheet->getStyle('F3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', "QR Code Installed Today"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $sheet->getStyle('G3')->getFont()->setBold(true);
        $sheet->setCellValue('G3', "Pending"); 
        
        
        $rowNo =  4;
        $cellNo = "";
        $slno = 1;
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
          $cellF = "F".$rowNo  ;
          $cellG = "G".$rowNo  ;
          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, $row->ward_no);
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $row->vendor_name);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellD, $row->total_footprint);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE, $row->total_qrcode_installed);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellF, $row->total_qrcode_installed_today);
          $sheet->getStyle($cellF)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellG, $row->pending_installation);
          $sheet->getStyle($cellG)->applyFromArray($styleArray3);
          
          if(intval($row->total_qrcode_installed_today) == 0) {
             $sheet->getStyle($cellA.":".$cellG)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000'); 
          }
          
          $rowNo++;
          $slno++;   
        }
        $lastwRow =  intval($rowNo)-1;
        $cellTotalA = "A".$rowNo;
        $cellTotalC = "C".$rowNo;
        $cellTotalD = "D".$rowNo;
        $cellTotalE = "E".$rowNo;
        $cellTotalF = "F".$rowNo;
        $cellTotalG = "G".$rowNo;
        
        $sheet->setCellValue($cellTotalD, '=SUM(D4:D'.$lastwRow.')');
        $sheet->setCellValue($cellTotalE, '=SUM(E4:E'.$lastwRow.')');
        $sheet->setCellValue($cellTotalF, '=SUM(F4:F'.$lastwRow.')');
        $sheet->setCellValue($cellTotalG, '=SUM(G4:G'.$lastwRow.')');
        $sheet->setCellValue($cellTotalC, 'Gross Total');
        $sheet->getStyle($cellTotalA.":".$cellTotalG)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF00'); 
        $spreadsheet->getActiveSheet()->getStyle($cellTotalA.":".$cellTotalG)->applyFromArray($styleArray);
        
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:G3')->getAlignment()->setVertical('center');
        $sheet = $sheet->getStyle('A3:G3')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray3);
        
   
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'QR_code_report_'.date("YmdHis").'.xlsx' ;
        $reportFile = 'xlsreport/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        $this->load->helper('download');
        $data = file_get_contents($reportFile);
        force_download($file_name, $data);
        
    }
    
    
    
    public function silentxls() {
        
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
        
        
        $report_date =  date("Y-m-d");
        $this->autopreparereport($report_date);
        
        $reports = $this->tblFootprintReport->getReport($report_date);
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Daily QR Code report');
       // Set the value of cell A1 
      
        $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "Report Date : ".$report_date); 
        
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d5dbdb');
        
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "#SLNO"); 
        
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', "Ward No");
        
        
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $sheet->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('C3', "Vendor");
        
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->setCellValue('D3', "Total Building Footprints"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('E3', "QR Code Installed Till Date"); 
        
        
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $sheet->getStyle('F3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', "QR Code Installed Today"); 
        
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $sheet->getStyle('G3')->getFont()->setBold(true);
        $sheet->setCellValue('G3', "Pending"); 
        
        
        $rowNo =  4;
        $cellNo = "";
        $slno = 1;
        foreach ($reports as $row) {
          $cellA = "A".$rowNo  ; 
          $cellB = "B".$rowNo  ; 
          $cellC = "C".$rowNo  ; 
          $cellD = "D".$rowNo  ; 
          $cellE = "E".$rowNo  ;
          $cellF = "F".$rowNo  ;
          $cellG = "G".$rowNo  ;
          $sheet->setCellValue($cellA, $slno);   
          $sheet->getStyle($cellA)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellB, $row->ward_no);
          $sheet->getStyle($cellB)->applyFromArray($styleArray3); 
          $sheet->getStyle($cellB)->getAlignment()->setHorizontal('left');
          
          $sheet->setCellValue($cellC, $row->vendor_name);
          $sheet->getStyle($cellC)->applyFromArray($styleArray3); 
          
          $sheet->setCellValue($cellD, $row->total_footprint);
          $sheet->getStyle($cellD)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellE, $row->total_qrcode_installed);
          $sheet->getStyle($cellE)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellF, $row->total_qrcode_installed_today);
          $sheet->getStyle($cellF)->applyFromArray($styleArray3);
          
          $sheet->setCellValue($cellG, $row->pending_installation);
          $sheet->getStyle($cellG)->applyFromArray($styleArray3);
          
          if(intval($row->total_qrcode_installed_today) == 0) {
             $sheet->getStyle($cellA.":".$cellG)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000'); 
          }
          
          $rowNo++;
          $slno++;   
        }
        $lastwRow =  intval($rowNo)-1;
        $cellTotalA = "A".$rowNo;
        $cellTotalC = "C".$rowNo;
        $cellTotalD = "D".$rowNo;
        $cellTotalE = "E".$rowNo;
        $cellTotalF = "F".$rowNo;
        $cellTotalG = "G".$rowNo;
        
        $sheet->setCellValue($cellTotalD, '=SUM(D4:D'.$lastwRow.')');
        $sheet->setCellValue($cellTotalE, '=SUM(E4:E'.$lastwRow.')');
        $sheet->setCellValue($cellTotalF, '=SUM(F4:F'.$lastwRow.')');
        $sheet->setCellValue($cellTotalG, '=SUM(G4:G'.$lastwRow.')');
        $sheet->setCellValue($cellTotalC, 'Gross Total');
        $sheet->getStyle($cellTotalA.":".$cellTotalG)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF00'); 
        $spreadsheet->getActiveSheet()->getStyle($cellTotalA.":".$cellTotalG)->applyFromArray($styleArray);
        
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:G3')->getAlignment()->setVertical('center');
        $sheet = $sheet->getStyle('A3:G3')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray3);
        
   
        
        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 
        
        $file_name  = 'QR_code_report_'.date("YmdHis").'.xlsx' ;
        $reportFile = 'xlsreport/'.$file_name ;
        // Save .xlsx file to the current directory 
        $writer->save($reportFile); 
        
    }


    public function makereport() {
        $all_ward = $this->tblFootprintReport->getAllWardByVendor();

        //$report_date = date("Y-m-d");
        //$report_id = "RD".date("Ymd"); 

        $report_date = "2021-01-30";
        $report_id = "RD20210130";

        if ($this->tblFootprintReport->isReportExist($report_date) == true) {
            $this->tblFootprintReport->removeReport($report_date);
            // echo "test";
            //die();
        }

        foreach ($all_ward as $ward) {

            $total_footprint = $ward->total_footprints;
            $ward_no = $ward->ward_no;
            $vendor_code = $ward->vendor_code;
            $vendor_name = $this->tblFootprintReport->getVendorName($ward->vendor_code);
            $total_qrcode_installed_today = intval($this->tblFootprintReport->totalQRCodeInstalled($report_date, $ward_no));
            $total_qrcode_installed = $this->tblFootprintReport->totalQRCodeInstalledAsOnDate($ward_no);
            $pending_installation = intval($total_footprint) - $total_qrcode_installed;
            $data = array(
                "report_id" => $report_id,
                "report_date" => $report_date,
                "ward_no" => $ward_no,
                "total_footprint" => $total_footprint,
                "vendor_code" => $vendor_code,
                "vendor_name" => $vendor_name,
                "total_qrcode_installed_today" => $total_qrcode_installed_today,
                "total_qrcode_installed" => $total_qrcode_installed,
                "pending_installation" => $pending_installation
            );

            $this->tblFootprintReport->insertReport($data);
        }
    }

    public function importdata() {

        /*  Not to be used at all

          $reader = new Xls();
          $reader->setReadDataOnly(true);
          $spreadsheet = $reader->load("download/building_footprint.xls");
          $worksheet = $spreadsheet->getActiveSheet();
          $worksheet_data = $worksheet->toArray();
          $total_xls_records = count($worksheet_data);


          for($i = 1; $i<$total_xls_records; $i++) {
          $ward  = $worksheet_data[$i][0];
          $foot_print_count = $worksheet_data[$i][1];
          $array_ward = explode("_", $ward);
          $ward_no = $array_ward[1];

          $dataTuple = array( "total_footprints" => trim($foot_print_count) );
          $this->db->where('ward_no', $ward_no);
          $this->db->update('master_ward', $dataTuple);

          }
         * 
         * */
    }

    public function xaddroute() {


        $reader = new Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("download/route23c.xls");
        $worksheet = $spreadsheet->getSheetByName("Construct1677");
        $worksheet_data = $worksheet->toArray();
        $total_xls_records = count($worksheet_data);


        for ($i = 1; $i < $total_xls_records; $i++) {

            $latitude = $worksheet_data[$i][0];
            $longitude = $worksheet_data[$i][1];
            $table_name = "route_data";
            $route_name = "W23C";




            $slno = $i . date("YmdHis");
            $doc_id = hash('sha256', $slno);

            $doc_obj = array(
                'table_name' => $table_name,
                'doc_id' => $doc_id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'route_name' => $route_name
            );

            $this->couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
            echo "<pre>";
            print_r($doc_obj);
        }
    }

    public function alert() {
        $pagename = "gis/yardmapview";
        $file_name = file_get_contents(base_url("upload/wardboundary/patliputra.geojson"));
        $data['start_lat'] = "25.621872676174227";
        $data['start_lng'] = "85.10754870636373";
        $data['yard'] = $file_name;
        $data['maps'] = "MAP";
        $title = "Patliputra Yard Layer";
        $this->page($pagename, $title, $data);
    }

    public function plot() {
        $route = $this->getRoutes();
        $total_route_points = count($route->rows);

        $points = $this->getAllRecords();
        $total_points = count($points->rows);



        $datapoint = array();
        $datapoint2 = array();

        for ($i = 0; $i < $total_points; $i++) {

            if ($points->rows[$i]->value->distance != "0") {

                /*
                  for($x=0; $i<$total_route_points; $x++) {

                  $dis =

                  } */


                $temp = array("latitude" => $points->rows[$i]->value->latitude, "longitude" => $points->rows[$i]->value->longitude, "device_date_time" => $points->rows[$i]->value->device_date_time, "isvalid" => "1");
                array_push($datapoint, $temp);
            }
            // echo $i." ".$points->rows[$i]->value->doc_id."  ".$points->rows[$i]->value->device_date_time."<br>";
        }

        $your_date_field_name = 'device_date_time';
        usort($datapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });

        $distance = array();
        // $total_points
        $adjusted_point = array();
        $min_distance = array();
        $ad_distance = array();
        $j = 0;
        for ($i = 0; $i < count($datapoint); $i++) {

            if ($points->rows[$i]->value->distance != "0") {
                for ($x = 0; $x < $total_route_points; $x++) {

                    $dx = $this->vincentyGreatCircleDistance($route->rows[$x]->value->latitude, $route->rows[$x]->value->longitude, $datapoint[$i]['latitude'], $datapoint[$i]['longitude']);

                    if ($min_distance == null) {
                        $min_distance[0]['dt'] = $dx;
                        $min_distance[0]['lat'] = $route->rows[$x]->value->latitude;
                        $min_distance[0]['lng'] = $route->rows[$x]->value->longitude;
                        $min_distance[0]['latitude'] = $datapoint[$i]['latitude'];
                        $min_distance[0]['longitude'] = $datapoint[$i]['longitude'];
                        $min_distance[0]['pointer'] = $i;
                    } else {

                        if (floatval($min_distance[0]['dt']) > floatval($dx)) {
                            $min_distance[0]['dt'] = $dx;
                            $min_distance[0]['lat'] = $route->rows[$x]->value->latitude;
                            $min_distance[0]['lng'] = $route->rows[$x]->value->longitude;
                            $min_distance[0]['latitude'] = $datapoint[$i]['latitude'];
                            $min_distance[0]['longitude'] = $datapoint[$i]['longitude'];
                            $min_distance[0]['pointer'] = $i;
                        }
                    }
                }
                $ad_distance[$j]['dt'] = $min_distance[0]['dt'];
                $ad_distance[$j]['lat'] = $min_distance[0]['lat'];
                $ad_distance[$j]['lng'] = $min_distance[0]['lng'];
                $ad_distance[$j]['latitude'] = $min_distance[0]['latitude'];
                $ad_distance[$j]['longitude'] = $min_distance[0]['longitude'];
                $ad_distance[$j]['device_date_time'] = $datapoint[$i]['device_date_time'];
                $pointer = $min_distance[0]['pointer'];
                $datapoint[$pointer]['isvalid'] = "0";
                $min_distance = null;
                $j++;
            }
        }



        $all_routes = json_encode($route->rows);
        $all_points = json_encode($datapoint);
        $adjusted_points = json_encode($ad_distance);




        $pagename = "gis/routemapview";
        $data['start_lat'] = $points->rows[0]->value->latitude;
        $data['start_lng'] = $points->rows[0]->value->longitude;
        $data['all_points'] = $all_points;
        $data['all_routes'] = $all_routes;
        $data['adjusted_points'] = $adjusted_points;
        $data['maps'] = "MAP";
        $title = "Ward 23 - Vehicle No. 1677 ";
        $this->page($pagename, $title, $data);


        //  print_r($points->rows[0]->value);

        /*
          $pagename = "gis/yardmapview";
          $file_name = file_get_contents(base_url("upload/wardboundary/patliputra.geojson"));
          $data['start_lat'] = "25.621872676174227" ;
          $data['start_lng'] = "85.10754870636373" ;
          $data['yard'] = $file_name;
          $data['maps'] = "MAP";
          $title = "Patliputra Yard Layer";
          $this->page($pagename, $title, $data); */
    }

    public function replot() {
        $route = $this->getRoutes();
        $points = $this->getAllRecords();
        $total_points = count($points->rows);
        $datapoint = array();
        $errordatapoint = array();

        for ($i = 0; $i < $total_points; $i++) {
            if ($points->rows[$i]->value->distance != "0") {
                $temp = array("latitude" => $points->rows[$i]->value->latitude, "longitude" => $points->rows[$i]->value->longitude, "device_date_time" => $points->rows[$i]->value->device_date_time, "isvalid" => "1");
                array_push($datapoint, $temp);
                array_push($errordatapoint, $temp);
            }
        }

        $your_date_field_name = 'device_date_time';
        usort($datapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });

        $your_date_field_name = 'device_date_time';
        usort($errordatapoint, function ($a, $b) use (&$your_date_field_name) {
            return strtotime($a[$your_date_field_name]) - strtotime($b[$your_date_field_name]);
        });







        for ($i = 0; $i < count($datapoint); $i++) {
            $adjusted_point = $this->checkdistance($datapoint[$i]['latitude'], $datapoint[$i]['longitude'], $i);
            if (!empty($adjusted_point)) {
                $adjusted_point_rev = array_reverse($adjusted_point);
                $adjusted_data_str = $adjusted_point_rev[0];
                $adjusted_xplode = explode("#", $adjusted_data_str);
                $pointer = $adjusted_xplode[2];
                $lat = $adjusted_xplode[0];
                $lng = $adjusted_xplode[1];
                $datapoint[$pointer]['latitude'] = $lat;
                $datapoint[$pointer]['longitude'] = $lng;
                $datapoint[$pointer]['isvalid'] = "0";
                // echo $pointer."<br>";
            }
        }

        $all_routes = json_encode($route->rows);
        $adjusted_point = json_encode($datapoint);
        $error_data_point = json_encode($errordatapoint);
        $pagename = "gis/routemapviewnew";
        $data['start_lat'] = $points->rows[0]->value->latitude;
        $data['start_lng'] = $points->rows[0]->value->longitude;
        $data['all_points'] = $error_data_point;
        $data['all_routes'] = $all_routes;
        $data['adjusted_points'] = $adjusted_point;
        $data['maps'] = "MAP";
        $title = "Ward 23 - Vehicle No. 1677 ";
        $this->page($pagename, $title, $data);
    }

    public function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
                pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    public function checkdistance($lat, $lng, $pointer) {

        $route = $this->getRoutes();
        $total_route_points = count($route->rows);
        $mindis = 0;
        $mindata = array();
        for ($x = 0; $x < $total_route_points; $x++) {
            $dx = $this->vincentyGreatCircleDistance($route->rows[$x]->value->latitude, $route->rows[$x]->value->longitude, $lat, $lng);
            if ($mindis == 0) {


                if (floatval($dx) < 15) {
                    $mindis = $dx;
                    //echo $route->rows[$x]->value->latitude." ".$route->rows[$x]->value->latitude."  DISTANCE ".$dx."<br>";
                    $mindata[] = $route->rows[$x]->value->latitude . "#" . $route->rows[$x]->value->latitude . "#" . $pointer;
                }
            } else {

                if (floatval($mindis) > floatval($dx)) {
                    if (floatval($dx) < 15) {
                        $mindis = $dx;
                        //echo $route->rows[$x]->value->latitude." ".$route->rows[$x]->value->latitude."  DISTANCE ".$dx."<br>";
                        $mindata[] = $route->rows[$x]->value->latitude . "#" . $route->rows[$x]->value->latitude . "#" . $pointer;
                    }
                }
            }
        }

        return $mindata;
    }

    public function getAllRecords() {
        $payload = '["device_data", "2021-01-13", "BR01GJ-1677"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload, "_design/gps/_view/readgps?&ascending=true&key=");
        //$data = $this->getCouchDbAllDocs($payload,"_design/view/_view/draftDocList?&descending=true&key="); 
        //$data = $this->couchdb->getCouchDbAllDocs($payload,"_design/view/_view/getpoints?&ascending=true&key=");
        //_design/view/_view/getpoints
        return $data;
    }

    public function getAllRecordsByVehicleReg($date, $vehicle_reg) {
        $payload = '["device_data", "' . $date . '", "' . $vehicle_reg . '"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload, "_design/gps/_view/readgps?&ascending=true&key=");
        return $data;
    }

    public function getRoutes() {
        $payload = '["route_data" , "W23C"]';
        $data = $this->couchdb->getCouchDbAllDocs($payload, "_design/gps/_view/readRoute?&ascending=true&key=");
        return $data;
    }

    public function deleteRecord() {
        $points = $this->getAllRecordsByVehicleReg("2021-01-13", "BR01GJ-1677");
        $total = count($points->rows);

        for ($i = 0; $i < $total; $i++) {
            echo $i . " " . $points->rows[$i]->value->doc_id . "  " . $points->rows[$i]->value->_rev . "<br>";
            $this->couchdb->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
        }

        //$this->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
    }

    public function deletepoint() {
        $points = $this->getRoutes();
        $total = count($points->rows);

        for ($i = 0; $i < $total; $i++) {
            echo $i . " " . $points->rows[$i]->value->doc_id . "  " . $points->rows[$i]->value->_rev . "<br>";
            $this->couchdb->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
        }

        //$this->deleteCouchDbDoc($points->rows[$i]->value->_rev, $points->rows[$i]->value->doc_id, 'text/plain');
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
