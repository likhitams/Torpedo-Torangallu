<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_Groupdata extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/pthome
     *    - or -  
     *         http://example.com/index.php/blueadmin/index
     *    - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/pthome
     <method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
     
  protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->load->model('reportsgroup_db');
        $this->data['detail'] = '';
        $this->data['session'] = "user";
        $this->data['session_pwd'] = "userpwd";
        $this->data['session_data'] = "user";
        $this->data['cookie'] = "jsw_user";
        $this->data['cookie_pwd'] = "jsw_userpwd";
    $cookie=get_cookie($this->data['cookie']);
    $cookie_pwd=get_cookie($this->data['cookie_pwd']);
        
        if(!$this->session->userdata($this->data['session']) && $cookie=="")
        {    
            redirect('userlogin','refresh');
        }
        else
        {
          $det = $this->home_db->checkSession($this->data['session'],$this->data['session_data'],$cookie, $cookie_pwd);
          //echo $this->db->last_query();exit;
         // print_r($det);
          if(count($det)>0){
              $this->data['detail']=$det;
              $this->session->set_userdata($this->data['session_data'], $det);
              $cookie = array(
                   'name'   => $this->data['session'],
                   'value'  => $det[0]->username,
                   'expire' => 3600*24*7,
                   'domain' => '.jsw',
                   'path'   => '/',
                   'prefix' => 'jsw_',
               );
        set_cookie($cookie); 
        
        $cookie = array(
                   'name'   => $this->data['session_pwd'],
                   'value'  => $det[0]->password,
                   'expire' => 3600*24*7,
                   'domain' => '.jsw',
                   'path'   => '/',
                   'prefix' => 'jsw_',
               );
        set_cookie($cookie); 
          }
          else{
            $this->home_db->clearSession($this->data['session'],$this->data['session_data'],$this->data['session_pwd']);
              redirect('userlogin','refresh');
          }   
        }   
    $this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
    $this->data['refCountList']=$this->load->view('refCountList', NULL , TRUE);
    $this->data['header']=$this->load->view('header', $this->data , TRUE);
    $this->data['left']=$this->load->view('left', NULL , TRUE);
    $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);   

    $this->load->library('Excel');
        //load our new PHPExcel library
        $this->load->library('excel');        
        
        $this->data['styleArray'] = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 12,
        )
        );
        
        $this->data['styleArrayBorder'] = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
    $this->excel->getDefaultStyle()->applyFromArray($this->data['styleArrayBorder']);
    }

   
  function getCycletimedata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
            
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      $result = $this->reportsgroup_db->gettable_cycletime($db);
      
      $ironzone = $steelzone = $total = 0;
          $j = 0;
          $final = array();
            foreach ($result as $dt){
              $remarksText = $diffText = "";
              $diff = 0;
              if($dt->ironzone > 500){
                $from = date_create($dt->FIRST_TARE_TIME);
          $from=date_format($from, 'Y-m-d H:i:s');
          
          $to = date_create($dt->GROSS_DATE);
          $to=date_format($to, 'Y-m-d H:i:s');
          
                $remarks = $this->master_db->runQuerySql("select lr.remarks, non_cycling_date, lc.id 
                                    from ladle_cyclingHistory lc
                                    LEFT JOIN ladle_remarks lr ON lr.id=lc.remarks 
                                    where non_cycling_date between '$from' and '$to' AND lc.ladle_id=".$dt->ladleid." and completeCycle=1 order by lc.id desc");
                
                
                if(count($remarks)){
                  
                  $remarkscycle = $this->master_db->runQuerySql("select cycling_date, lc.id 
                                    from ladle_cyclingHistory lc
                                    where cycling_date between '$from' and '$to' AND lc.ladle_id=".$dt->ladleid." and completeCycle=0 and lc.id>".$remarks[0]->id."  order by lc.id asc");
                  if(count($remarkscycle)){
                      $date1=strtotime($remarks[0]->non_cycling_date);
                $date2=strtotime($remarkscycle[0]->cycling_date); 
                $diff = abs($date1 - $date2);
                $diff = floor($diff/60);
                  //$diff = $this->dateDifference($dt->GROSS_DATE , $remarks[0]->non_cycling_date , '%i' );
                  if($diff > 0){
                    $diffText = " (".$diff." min)";
                  }
                  $remarksText = $remarks[0]->remarks.$diffText;
                  }
                }
              }
              $ironzonetime = $dt->ironzone-$diff;
              $final[] = (object)array(
                "CARNO"=>$dt->CARNO,
                "LADLENO"=>$dt->LADLENO,
                "GROSS_WEIGHT"=>$dt->GROSS_WEIGHT,
                "TARE_WEIGHT"=>$dt->TARE_WEIGHT,
                "NET_WEIGHT"=>$dt->NET_WEIGHT,
                "TARE_WT2"=>$dt->TARE_WT2,
                "leftover"=>$dt->leftover,
                "TAPNO"=>$dt->TAPNO,
                "TAPHOLE"=>$dt->TAPHOLE,
                "SOURCE"=>$dt->SOURCE,
                "TEMP"=>$dt->TEMP,
                "BDSTEMP"=>$dt->BDSTEMP,
                "DEST"=>$dt->DEST,
                "FIRST_TARE_TIME"=>$dt->FIRST_TARE_TIME,
                "BF_ENTRY"=>$dt->BF_ENTRY,  
                "BF_EXIT"=>$dt->BF_EXIT,  
                "SMS_ENTRY"=>$dt->SMS_ENTRY,
                                "SMS_TIME"=>$dt->SMS_TIME,
                  "GROSS_DATE"=>$dt->GROSS_DATE,
                "ironzone"=>$ironzonetime,//-$diff
                "TARE_DATE"=>$dt->TARE_DATE,
                "steelzone"=>$dt->steelzone,
                      "ironpsteel"=>$ironzonetime+$dt->steelzone,
                "tappingtime"=>$dt->tappingtime,
                "timebf"=>$dt->timebf,
                "timesms"=>$dt->timesms,  
                "locotime"=>$dt->locotime,  
                      "remarks"=>$remarksText         
              );
             $ironzone += $ironzonetime;
             $steelzone += $dt->steelzone;
             $total += ($ironzonetime+$dt->steelzone);             
            }
           
            $cnt = count($result);
            if($cnt){
              
              $final[] = (object)array(
                "CARNO"=>"",
                "LADLENO"=>"",
                "TAPNO"=>"",
                "SOURCE"=>"",
                "TEMP"=>"",
                "BDSTEMP"=>"",
                "DEST"=>"",
                "FIRST_TARE_TIME"=>"",  
                                "BF_ENTRY"=>"", 
                "BF_EXIT"=>"",  
                "SMS_ENTRY"=>"",  
                                "SMS_TIME"=>"",                 
                "GROSS_DATE"=>"Avg TAT:",
                "ironzone"=>number_format((float)$ironzone/$cnt, 2, '.', ''),
                "TARE_DATE"=>"Avg TAT:",
                "steelzone"=>number_format((float)$steelzone/$cnt, 2, '.', ''),
                      "ironpsteel"=>"Avg TAT/Day: ".number_format((float)$total/$cnt, 2, '.', ''),
                "tappingtime"=>"",
                "timebf"=>"",
                "timesms"=>"",
                "locotime"=>"",
                      "remarks"=>""     
              );
            
            $result = $final;
            }
    
    if($type == "json"){
    
        echo json_encode($result);  
    }
    else{
      $this->getCycleTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
    }
    }
   
     public function getCycleCountExcelreport($dataExport, $start_date, $end_date, $groupname){
    
        //activate worksheet number 1
        $excel = new PHPExcel();
       
        
        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');
        
        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray(
            array(
                array('ironzone', 'steelzone')
            )
            );
        
        $z = 1;
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'Q'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ironzone);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->steelzone);
        // $this->excel->getActiveSheet()->setCellValue('D' . $z, ($dt->ironzone+$dt->steelzone));
        $d = new DateTime();
        }
        $z++;
        
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$B$1'), //  Temperature
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$C$1'), //  Rainfall
        );
        $dataseriesLabels3 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$D$1'), //  Humidity
        );
        
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$A$2:$A$13'), //  Jan to Dec
        );
        
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$B$2:$B$13'),
        );
        
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1                              // plotValues
            );
        
        $series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);
        
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$C$2:$C$13'),
        );
        
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues2                              // plotValues
            );
        
        $dataSeriesValues3 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$D$2:$D$13'),
        );
        
        $series3 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels3, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues3                              // plotValues
            );
        
        
        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series1, $series2, $series3));
        //  Set the chart legend
        $legend = new\PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        
        $title = new PHPExcel_Chart_Title('Chart awesome');
        
        //  Create the chart
        $chart = new PHPExcel_Chart(
        'chart1', // name
        $title, // title
        $legend, // legend
        $plotarea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        NULL, // xAxisLabel
        NULL            // yAxisLabel
        );
        
        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');
        
        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);
        
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'CyclecountbargraphReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    
    }

    function getsummarydata(){

        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time;
        $end_datetime = $end_date." ".$end_time;
        
        $db=array(
            'group'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
        );
        $results = $this->reportsgroup_db->gettable_summary($db);
        
        
            $result = $results;
        
        
        if($type == "json"){
            
            echo json_encode($result);
        }
        else{
            $this->getSummaryExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
        }
    }

    public function getSummaryExcelreport($dataExport, $start_date, $end_date, $groupname){
            
           
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Summary Report');

            $headertext = "Summary Report";
            
            
        $sheet->mergeCells("B1:P1");
        
        $sheet->mergeCells("M2:P2");
        $sheet->mergeCells("Q2:S2");
        $sheet->mergeCells("B2:B3");
        $sheet->mergeCells("C2:C3");
        $sheet->mergeCells("D2:D3");
        $sheet->mergeCells("E2:E3");
        $sheet->mergeCells("F2:F3");
        $sheet->mergeCells("G2:G3");
        $sheet->mergeCells("H2:H3");
        $sheet->mergeCells("I2:I3");
      $sheet->mergeCells("J2:J3");
      $sheet->mergeCells("K2:K3");
      $sheet->mergeCells("L2:L3");
        $sheet->mergeCells("U2:U3");
      $sheet->mergeCells("V2:V3");
      $sheet->mergeCells("W2:W3");
      $sheet->mergeCells("X2:X3");
      $sheet->mergeCells("Y2:Y3");
      $sheet->mergeCells("Z2:Z3");
      $sheet->mergeCells("AA2:AA3");
        $sheet->mergeCells("AB2:AB3");
      
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB");
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(7);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(12);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(20);
      $sheet->getColumnDimension('Q')->setWidth(20);
      $sheet->getColumnDimension('R')->setWidth(20);
      $sheet->getColumnDimension('S')->setWidth(20);
      $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(25);
        $sheet->getColumnDimension('V')->setWidth(25);
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->getColumnDimension('X')->setWidth(20);
            $sheet->getColumnDimension('Y')->setWidth(20);
            $sheet->getColumnDimension('Z')->setWidth(20);
      $sheet->getColumnDimension('AA')->setWidth(25);
      $sheet->getColumnDimension('AB')->setWidth(20);
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 9,
                )
          );
 
            $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 10,
                )
          );
        
            
            $range = 'A'.$z.':'.'Q'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('B'.$z, "$groupname : Summary Report" );
            
            $sheet->getStyle('B2:M2')
            ->getAlignment()->setWrapText(true); 
            
        $sheet->getStyle('K3:R3')
            ->getAlignment()->setWrapText(true); 
            $z++; 
            /*$range = 'A'.$z.':'.'J'.$z;
            $sheet
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $sheet->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
            $z++;$z++;  */
            //change the font size
            $range = 'A'.$z.':'.'R'.$z;
            $sheet
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
          $sheet->setCellValue('A'.$z, '');             
          $sheet->setCellValue('B'.$z, 'S.No');                        
          $sheet->setCellValue('C'.$z, 'Torpedo No.');
          $sheet->setCellValue('D'.$z, 'Supplier');
      $sheet->setCellValue('E'.$z, 'Life(Heat)');
      $sheet->setCellValue('F'.$z, 'Life as on Date');
      $sheet->setCellValue('G'.$z, 'Cumulative Life');
      $sheet->setCellValue('H'.$z, 'Remarks'); 
            
          
          $z++;
          
      
          $ironzone = $steelzone = $total = 0;
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'T'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          
          $this->excel->getActiveSheet()->setCellValue('B' . $z, $j); 
              //$this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->CARNO);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->ladleid);
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->suppliername);
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->heat_count);
         $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->today_count);
              $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->cummulativecount); 
             
        $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->remarks);
        
       
            }
            $z++;
            /*$cnt = count($dataExport);
            if($cnt){
              $this->excel->getActiveSheet()->setCellValue('K' . $z, 'Avg TAT:'); 
              $this->excel->getActiveSheet()->setCellValue('L' . $z, number_format((float)$ironzone/$cnt, 2, '.', '')); 
              $this->excel->getActiveSheet()->setCellValue('N' . $z, 'Avg TAT:');
              $this->excel->getActiveSheet()->setCellValue('O' . $z, number_format((float)$steelzone/$cnt, 2, '.', ''));  
              $this->excel->getActiveSheet()->setCellValue('P' . $z, 'Avg TAT/Day:'.number_format((float)$total/$cnt, 2, '.', '')); 
             // $this->excel->getActiveSheet()->setCellValue('Q' . $z, );
            }*/
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'SummaryReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    function getChartData(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time;
        $end_datetime = $end_date." ".$end_time;
        
        $db=array(
            'group'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
        );
        $result = $this->reportsgroup_db->gettable_charttime($db);
        
        $ironzone = $steelzone = $total = 0;
        
        $ironzone = $steelzone = $total = 0;
        $j = 0;
        $final = array();
        foreach ($result as $dt){
            $remarksText = $diffText = "";
            $diff = 0;
            if($dt->ironzone > 500){
                $from = date_create($dt->FIRST_TARE_TIME);
                $from=date_format($from, 'Y-m-d H:i:s');
                
                $to = date_create($dt->GROSS_DATE);
                $to=date_format($to, 'Y-m-d H:i:s');
                
                $remarks = $this->master_db->runQuerySql("select lr.remarks, non_cycling_date, lc.id
                                    from ladle_cyclingHistory lc
                                    LEFT JOIN ladle_remarks lr ON lr.id=lc.remarks
                                    where non_cycling_date between '$from' and '$to' AND lc.ladle_id=".$dt->ladleid." and completeCycle=1 order by lc.id desc");
                
                
                if(count($remarks)){
                    
                    $remarkscycle = $this->master_db->runQuerySql("select cycling_date, lc.id
                                    from ladle_cyclingHistory lc
                                    where cycling_date between '$from' and '$to' AND lc.ladle_id=".$dt->ladleid." and completeCycle=0 and lc.id>".$remarks[0]->id."  order by lc.id asc");
                    if(count($remarkscycle)){
                        $date1=strtotime($remarks[0]->non_cycling_date);
                        $date2=strtotime($remarkscycle[0]->cycling_date);
                        $diff = abs($date1 - $date2);
                        $diff = floor($diff/60);
                        //$diff = $this->dateDifference($dt->GROSS_DATE , $remarks[0]->non_cycling_date , '%i' );
                        if($diff > 0){
                            $diffText = " (".$diff." min)";
                        }
                        $remarksText = $remarks[0]->remarks.$diffText;
                    }
                }
            }
            $ironzone = $dt->ironzone-$diff;
            $final[] = (object)array(
                "LADLENO"=>$dt->LADLENO,
                "ironzone"=>$ironzone,//-$diff
                "steelzone"=>$dt->steelzone,
                "ironpsteel"=>$ironzone+$dt->steelzone
            );
            $ironzone += $ironzone;
            $steelzone += $dt->steelzone;
            $total += ($ironzone+$dt->steelzone);
        }
        
        $cnt = count($result);
        if($cnt){
            
            $final[] = (object)array(
                "LADLENO"=>"",
                "ironzone"=>number_format((float)$ironzone/$cnt, 2, '.', ''),
                "steelzone"=>number_format((float)$steelzone/$cnt, 2, '.', ''),
                "ironpsteel"=>"Avg TAT/Day: ".number_format((float)$total/$cnt, 2, '.', '')      
            );
            
            $result = $final;
        }
        
        if($type == "json"){
            
            echo json_encode($result);
        }
        else{
            $this->getChartTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
        }
    }
         function getcyclecountbargraph(){

        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time;
        $end_datetime = $end_date." ".$end_time;
        
        $db=array(
            'group'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
        );
        $results = $this->reportsgroup_db->gettable_cyclecountbargraph($db);
        
        
            $result = $results;
        
        
        if($type == "json"){
            
            echo json_encode($result);
        }
        else{
            $this->getcyclecountbargraphreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
        }
    }

      public function getcyclecountbargraphreport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        $excel = new PHPExcel();
       
        
        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');
        
        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray(
            array(
                array('ironzone', 'steelzone', 'total')
            )
            );
        
        $z = 1;
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'Q'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ironzone);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->steelzone);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, ($dt->ironzone+$dt->steelzone));
        $d = new DateTime();
        }
        $z++;
        
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$B$1'), //  Temperature
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$C$1'), //  Rainfall
        );
        $dataseriesLabels3 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$D$1'), //  Humidity
        );
        
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$A$2:$A$13'), //  Jan to Dec
        );
        
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$B$2:$B$13'),
        );
        
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1                              // plotValues
            );
        
        $series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);
        
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$C$2:$C$13'),
        );
        
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues2                              // plotValues
            );
        
        $dataSeriesValues3 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$D$2:$D$13'),
        );
        
        $series3 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels3, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues3                              // plotValues
            );
        
        
        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series1, $series2, $series3));
        //  Set the chart legend
        $legend = new\PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        
        $title = new PHPExcel_Chart_Title('Chart awesome');
        
        //  Create the chart
        $chart = new PHPExcel_Chart(
        'chart1', // name
        $title, // title
        $legend, // legend
        $plotarea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        NULL, // xAxisLabel
        NULL            // yAxisLabel
        );
        
        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');
        
        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);
        
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'cyclecountbargraphreport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    
    }

      function getChartdelayData(){

        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time;
        $end_datetime = $end_date." ".$end_time;
        
        $db=array(
            'group'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
        );
        $results = $this->reportsgroup_db->gettable_delaycharttime($db);
        
        
            $result = $results;
        
        
        if($type == "json"){
            
            echo json_encode($result);
        }
        else{
            $this->getChartdelayDataExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
        }
    }

 public function getChartdelayDataExcelreport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        $excel = new PHPExcel();
       
        
        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');
        
        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray(
            array(
                array('locotime','LADLENO')
            )
            );
        
        $z = 1;
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'Q'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->LADLENO);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->locotime);
       
        $d = new DateTime();
        }
        $z++;
        
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$B$1'), //  Temperature
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$C$1'), //  Rainfall
        );
        $dataseriesLabels3 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$D$1'), //  Humidity
        );
        
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$A$2:$A$13'), //  Jan to Dec
        );
        
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$B$2:$B$13'),
        );
        
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1                              // plotValues
            );
        
        $series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);
        
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$C$2:$C$13'),
        );
        
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues2                              // plotValues
            );
        
        $dataSeriesValues3 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$D$2:$D$13'),
        );
        
        $series3 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels3, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues3                              // plotValues
            );
        
        
        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series1, $series2, $series3));
        //  Set the chart legend
        $legend = new\PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        
        $title = new PHPExcel_Chart_Title('Chart awesome');
        
        //  Create the chart
        $chart = new PHPExcel_Chart(
        'chart1', // name
        $title, // title
        $legend, // legend
        $plotarea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        NULL, // xAxisLabel
        NULL            // yAxisLabel
        );
        
        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');
        
        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);
        
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'delayDataReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    
    }
    



    public function getChartTimeExcelreport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        $excel = new PHPExcel();
       
        
        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');
        
        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray(
            array(
                array('ironzone', 'steelzone', 'total')
            )
            );
        
        $z = 1;
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'Q'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ironzone);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->steelzone);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, ($dt->ironzone+$dt->steelzone));
        $d = new DateTime();
        }
        $z++;
        
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$B$1'), //  Temperature
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$C$1'), //  Rainfall
        );
        $dataseriesLabels3 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$D$1'), //  Humidity
        );
        
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'Grafico!$A$2:$A$13'), //  Jan to Dec
        );
        
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$B$2:$B$13'),
        );
        
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1                              // plotValues
            );
        
        $series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);
        
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$C$2:$C$13'),
        );
        
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues2                              // plotValues
            );
        
        $dataSeriesValues3 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'Grafico!$D$2:$D$13'),
        );
        
        $series3 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels3, // plotLabel
            NULL, // plotCategory
            $dataSeriesValues3                              // plotValues
            );
        
        
        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series1, $series2, $series3));
        //  Set the chart legend
        $legend = new\PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        
        $title = new PHPExcel_Chart_Title('Chart awesome');
        
        //  Create the chart
        $chart = new PHPExcel_Chart(
        'chart1', // name
        $title, // title
        $legend, // legend
        $plotarea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        NULL, // xAxisLabel
        NULL            // yAxisLabel
        );
        
        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');
        
        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);
        
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'CycleTimeReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    
    }
    
  function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
  {
      $datetime1 = date_create($date_1);
      $datetime2 = date_create($date_2);
     
      $interval = date_diff($datetime1, $datetime2);
     
      return $interval->format($differenceFormat);
     
  }
    
  public function getCycleTimeExcelreport($dataExport, $start_date, $end_date, $groupname){
        
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Group Cycle Time Report');

            $headertext = "Group Cycle Time Report";
            
            
        $sheet->mergeCells("B1:P1");
        
        $sheet->mergeCells("M2:P2");
        $sheet->mergeCells("Q2:S2");
        $sheet->mergeCells("B2:B3");
        $sheet->mergeCells("C2:C3");
        $sheet->mergeCells("D2:D3");
        $sheet->mergeCells("E2:E3");
        $sheet->mergeCells("F2:F3");
        $sheet->mergeCells("G2:G3");
        $sheet->mergeCells("H2:H3");
        $sheet->mergeCells("I2:I3");
      $sheet->mergeCells("J2:J3");
      $sheet->mergeCells("K2:K3");
      $sheet->mergeCells("L2:L3");
        $sheet->mergeCells("U2:U3");
      $sheet->mergeCells("V2:V3");
      $sheet->mergeCells("W2:W3");
      $sheet->mergeCells("X2:X3");
      $sheet->mergeCells("Y2:Y3");
      $sheet->mergeCells("Z2:Z3");
      $sheet->mergeCells("AA2:AA3");
        $sheet->mergeCells("AB2:AB3");
      
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB");
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(7);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(12);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(20);
      $sheet->getColumnDimension('Q')->setWidth(20);
      $sheet->getColumnDimension('R')->setWidth(20);
      $sheet->getColumnDimension('S')->setWidth(20);
      $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(25);
        $sheet->getColumnDimension('V')->setWidth(25);
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->getColumnDimension('X')->setWidth(20);
            $sheet->getColumnDimension('Y')->setWidth(20);
            $sheet->getColumnDimension('Z')->setWidth(20);
      $sheet->getColumnDimension('AA')->setWidth(25);
      $sheet->getColumnDimension('AB')->setWidth(20);
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 9,
                )
          );
 
            $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 10,
                )
          );
        
            
            $range = 'A'.$z.':'.'Q'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('B'.$z, "$groupname : Iron Making - Hot Metal Ladle Turn around time Report " );
            
            $sheet->getStyle('B2:M2')
            ->getAlignment()->setWrapText(true); 
            
        $sheet->getStyle('K3:R3')
            ->getAlignment()->setWrapText(true); 
            $z++; 
            /*$range = 'A'.$z.':'.'J'.$z;
            $sheet
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $sheet->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
            $z++;$z++;  */
            //change the font size
            $range = 'A'.$z.':'.'R'.$z;
            $sheet
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
          $sheet->setCellValue('A'.$z, '');             
          $sheet->setCellValue('B'.$z, 'S.No');             
         // $sheet->setCellValue('C'.$z, 'Ladle Car No.');              
          $sheet->setCellValue('C'.$z, 'Ladle No.');
          $sheet->setCellValue('D'.$z, 'Cast. No');
      $sheet->setCellValue('E'.$z, 'Tap Hole');
      $sheet->setCellValue('F'.$z, 'GROSS WT');
      $sheet->setCellValue('G'.$z, 'TARE WT');
      $sheet->setCellValue('H'.$z, 'NET WT'); 
            $sheet->setCellValue('I'.$z, 'TARE WT2');
          $sheet->setCellValue('J'.$z, 'Left Over HM');           
          $sheet->setCellValue('K'.$z, 'Source');  
                
          //$sheet->setCellValue('G'.$z, 'Runner HM Temp Deg.C');
          //$sheet->setCellValue('H'.$z, 'BDS Temp Deg.C');             
          $sheet->setCellValue('L'.$z, 'Destination');              
          $sheet->setCellValue('M'.$z, 'Iron zone cycle');
          $sheet->setCellValue('Q'.$z, 'Steel zone cycle');
            $sheet->setCellValue('U'.$z, 'Iron Zone Time  (in min)'); 
          $sheet->setCellValue('V'.$z, 'Steel Zone Time (in min)'); 
          $sheet->setCellValue('W'.$z, 'TAT (in min)');
      $sheet->setCellValue('X'.$z, 'Tapping Time');
      $sheet->setCellValue('Y'.$z, 'Arrival at WB');
      $sheet->setCellValue('Z'.$z, 'Departure from WB');
      $sheet->setCellValue('AA'.$z, 'Waiting for Loco');
      $sheet->setCellValue('AB'.$z, 'Remarks');
          
          $z++;
          $sheet->setCellValue('M'.$z, 'Empty Tare1');   
      $sheet->setCellValue('N'.$z, 'BF Entry'); 
      $sheet->setCellValue('O'.$z, 'BF Exit');   
          $sheet->setCellValue('P'.$z, 'Gross Weight1');              
          $sheet->setCellValue('Q'.$z, 'Gross weight2');
      $sheet->setCellValue('R'.$z, 'SMS Entry');
      $sheet->setCellValue('S'.$z, 'SMS Exit');
          $sheet->setCellValue('T'.$z, 'Empty Tare2');  
      
          $ironzone = $steelzone = $total = 0;
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'T'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          
          $this->excel->getActiveSheet()->setCellValue('B' . $z, $j); 
              //$this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->CARNO);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->LADLENO);
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->TAPNO);
         $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->TAPHOLE);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->GROSS_WEIGHT); 
             // $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->TEMP);
             // $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->BDSTEMP);
        $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->TARE_WEIGHT);
        $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->NET_WEIGHT);
              $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->TARE_WT2);
              $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->leftover);
        $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->SOURCE);
              $this->excel->getActiveSheet()->setCellValue('L' . $z, $dt->DEST);
              $this->excel->getActiveSheet()->setCellValue('M' . $z, $dt->FIRST_TARE_TIME); 
        $this->excel->getActiveSheet()->setCellValue('N' . $z, $dt->BF_ENTRY); 
        $this->excel->getActiveSheet()->setCellValue('O' . $z, $dt->BF_EXIT); 
              $this->excel->getActiveSheet()->setCellValue('P' . $z, $dt->GROSS_DATE);
              $this->excel->getActiveSheet()->setCellValue('Q' . $z, $dt->GROSS_DATE);
        $this->excel->getActiveSheet()->setCellValue('R' . $z, $dt->SMS_ENTRY);
        $this->excel->getActiveSheet()->setCellValue('S' . $z, $dt->SMS_TIME);
              $this->excel->getActiveSheet()->setCellValue('T' . $z, $dt->TARE_DATE);
        $this->excel->getActiveSheet()->setCellValue('U' . $z, $dt->ironzone);$ironzone += $dt->ironzone;
              $this->excel->getActiveSheet()->setCellValue('V' . $z, $dt->steelzone);$steelzone += $dt->steelzone;
              $this->excel->getActiveSheet()->setCellValue('W' . $z, $dt->ironpsteel);
        $this->excel->getActiveSheet()->setCellValue('X' . $z, $dt->tappingtime);
        $this->excel->getActiveSheet()->setCellValue('Y' . $z, $dt->timebf);
        $this->excel->getActiveSheet()->setCellValue('Z' . $z, $dt->timesms);
                $this->excel->getActiveSheet()->setCellValue('AA' . $z, $dt->locotime);       
              $this->excel->getActiveSheet()->setCellValue('AB' . $z, $dt->remarks);             
            }
            $z++;
            /*$cnt = count($dataExport);
            if($cnt){
              $this->excel->getActiveSheet()->setCellValue('K' . $z, 'Avg TAT:'); 
              $this->excel->getActiveSheet()->setCellValue('L' . $z, number_format((float)$ironzone/$cnt, 2, '.', '')); 
              $this->excel->getActiveSheet()->setCellValue('N' . $z, 'Avg TAT:');
              $this->excel->getActiveSheet()->setCellValue('O' . $z, number_format((float)$steelzone/$cnt, 2, '.', ''));  
              $this->excel->getActiveSheet()->setCellValue('P' . $z, 'Avg TAT/Day:'.number_format((float)$total/$cnt, 2, '.', '')); 
             // $this->excel->getActiveSheet()->setCellValue('Q' . $z, );
            }*/
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'CycleTimeReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  function getMovementdata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail'],
          'checkGroup'=>$checkAuto,
        //'historyTable'=>$historyTableName." as h"           
        );
      $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $uarr = array();
      foreach ($unitnumbers as $u){
        $uarr[] = "'".$u->ladleno."'";
      }
      $imp = implode(", ", $uarr);
      
      $cnt = count($unitnumbers);
      $finalarr = array();
      if(count($unitnumbers)){
        $historyTableName = $this->home_db->getHistoryTableName($start_date, $end_date);
        
        $db=array(
            'unitnumber'=>$imp,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail'],
          'historyTable'=>$historyTableName           
          );
        $finalarr = $this->reportsgroup_db->gettable_movement($db);
        
      }
    
    if($type == "json"){
        echo json_encode($finalarr);  
    }
    else{
      $this->getMovementExcelreport($finalarr, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
    }
    }
    
  public function getMovementExcelreport($dataExport, $start_date, $end_date, $unitname){
        
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Movement Report');

            $headertext = "Movement Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(0);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$unitname );
            $z++; 
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
            $z++;$z++;  
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
          $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');             
          $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Ladle Car');   
          $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Report Time');              
          $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Status');                    
          $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Speed');              
          $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Location');
          
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          
          $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno); 
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->unitname);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->reporttime); 
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->status);
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->speed);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->location);             
            }
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'MovementReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    
    
    
    
    //Ladle Status Report
    
    function getLadleStatusData(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
    
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
    
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail'],
          'checkGroup'=>$checkAuto,
          //'historyTable'=>$historyTableName." as h"
      );
      $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $uarr = array();
      foreach ($unitnumbers as $u){
        $uarr[] = "'".$u->ladleno."'";
      }
      $imp = implode(", ", $uarr);
    
      $cnt = count($unitnumbers);
      $finalarr = array();
      if(count($unitnumbers)){
        $historyTableName = $this->home_db->getHistoryTableName($start_date, $end_date);
    
        $db=array(
            'unitnumber'=>$imp,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail'],
            'historyTable'=>$historyTableName
        );
        $finalarr = $this->reportsgroup_db->gettable_ladlestatus($db);
    
      }
    
      if($type == "json"){
        echo json_encode($finalarr);
      }
      else{
        $this->getLadleStatusExcelReport($finalarr, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
      }
    }
    
    public function getLadleStatusExcelReport($dataExport, $start_date, $end_date, $unitname){
    
      //activate worksheet number 1
      $this->excel->setActiveSheetIndex(0);
      //name the worksheet
      $this->excel->getActiveSheet()->setTitle('Ladle Status Report');
    
      $headertext = "Ladle Status Report";
    
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
      $z = 1;
    
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$unitname );
      $z++;
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
      $z++;$z++;
      //change the font size
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
    
      //set cell A1 content with some text
      $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
      $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Report Time');
      $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Load Status');
      $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Location');
    
      $j = 0;
      foreach ($dataExport as $dt){$z++;$j++;
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->getNumberFormat()
      ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
    
      $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
      $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->reporttime);
      $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->loadstatus);
      $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->location);
      }
    
      $d = new DateTime();
    
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'Ladle Status Report.xls"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
    }
    
    
  
      
    // EmergencySignal Report
    
    function getEmergencySignalReportdata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
       
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      
      $result = $this->reportsgroup_db->gettable_EmergencySignalReport($db);
    
      if($type == "json"){
        echo json_encode($result);
      }
      else{
        $this->getEmergencySignalReportExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
      }
    }
    
    
    
    public function getEmergencySignalReportExcelreport($dataExport, $start_date, $end_date, $groupname){
    
      //activate worksheet number 1
      $this->excel->setActiveSheetIndex(0);
      //name the worksheet
      $this->excel->getActiveSheet()->setTitle('EmergencySignal Report');
    
      $headertext = "EmergencySignal Report";
      
      
    
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
     
 
      $alpha = array("A","B","C","D","E","F","G","H");
      
       
      $z = 1;
    
      $range = 'A'.$z.':'.'D'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$groupname );
      $z++;
      $range = 'A'.$z.':'.'D'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
      $z++;$z++;
      //change the font size
      $range = 'A'.$z.':'.'D'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      
      $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
      
       
      //set cell A1 content with some text
      $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Torpedo Station No');
      $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Empty Notification Generated');
      $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Torpedo moved out from SMS');
      $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Difference (Mins)');
     
       
      $j = 0;
      foreach ($dataExport as $dt){$z++;$j++;
      $range = 'A'.$z.':'.'D'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->getNumberFormat()
      ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
      $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->tracid);
      $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->signaltime);
      $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->smstime);
      $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->difference);
     
      }
    
      $d = new DateTime();
        
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'SMSReport.xls"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
    }
    
  
  
  // SMSDelayReport Report
    
    function getSMSDelayReportdata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
       
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      
      $result = $this->reportsgroup_db->gettable_SMSDelayReport($db);
    
      if($type == "json"){
        echo json_encode($result);
      }
      else{
         $this->getSMSDelayReportExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
      }
    }
    
  
  
   public function getSMSDelayReportExcelreport($dataExport, $start_date, $end_date, $groupname){
    
      //activate worksheet number 1
      $this->excel->setActiveSheetIndex(0);
      //name the worksheet
      $this->excel->getActiveSheet()->setTitle('Torpedo Delay Report');
    
      $headertext = "Torpedo Delay Report";
      
      
    
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
    
 
      $alpha = array("A","B","C","D","E","F","G","H");
      
       
      $z = 1;
    
      $range = 'A'.$z.':'.'Q'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$groupname );
      $z++;
      $range = 'A'.$z.':'.'Q'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
      $z++;$z++;
      //change the font size
      $range = 'A'.$z.':'.'Q'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      
      $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("N")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("P")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("Q")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
       
       
      
       
      //set cell A1 content with some text
      $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Track No');
      $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Empty TLC No');
      $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Empty Notification');
      $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Plug Out');
      $this->excel->getActiveSheet()->setCellValue('E'.$z, 'SMS Exit');
      $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Empty Tare');
      $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Filled TLC No');
      $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Gross Date');
    $this->excel->getActiveSheet()->setCellValue('I'.$z, 'SMS Entry');
    $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Plug In');
    $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Plug Out to Plug In (in mins)');
    $this->excel->getActiveSheet()->setCellValue('L'.$z, 'Torpedo Out (in mins)');
    $this->excel->getActiveSheet()->setCellValue('M'.$z, 'Torpedo In (in mins)');
    $this->excel->getActiveSheet()->setCellValue('N'.$z, 'Torpedo (Out-In) at SMS (in mins)');
    $this->excel->getActiveSheet()->setCellValue('O'.$z, 'BF Delay');
    $this->excel->getActiveSheet()->setCellValue('P'.$z, 'WBDelay');
    $this->excel->getActiveSheet()->setCellValue('Q'.$z, 'SMS Plug out delay');
    
       
      $j = 0;
      foreach ($dataExport as $dt){$z++;$j++;
      $range = 'A'.$z.':'.'Q'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->getNumberFormat()
      ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
      $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->TrackNo);
      $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->EmptyTLCno);
      $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->EmptyNotificationGenerated);
      $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->Plugout);
      $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->SMSExit);
      $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->emptytare);
      $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->FilledTLCno);
      $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->GrossWeight);
    $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->SMSEntry);
    $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->plugin);
    $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->plugtoplugin);
    $this->excel->getActiveSheet()->setCellValue('L' . $z, $dt->Torpedoout);
    $this->excel->getActiveSheet()->setCellValue('M' . $z, $dt->torpedoin);
    $this->excel->getActiveSheet()->setCellValue('N' . $z, $dt->torpedosms);
    $this->excel->getActiveSheet()->setCellValue('O' . $z, $dt->BFdelay);
    $this->excel->getActiveSheet()->setCellValue('P' . $z, $dt->WBdelay);
    $this->excel->getActiveSheet()->setCellValue('Q' . $z, $dt->SMSdelay);
    
      }
    
      $d = new DateTime();
        
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'SMSReport.xls"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
    }
 
    
    
    // SMS Report
    
    function getSMSReportdata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
       
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      
      $result = $this->reportsgroup_db->gettable_SMSReport($db);
    
      if($type == "json"){
        echo json_encode($result);
      }
      else{
        $this->getSMSReportExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
      }
    }
    
    
    
    public function getSMSReportExcelreport($dataExport, $start_date, $end_date, $groupname){
    
      //activate worksheet number 1
      $this->excel->setActiveSheetIndex(0);
      //name the worksheet
      $this->excel->getActiveSheet()->setTitle('SMS Report');
    
      $headertext = "SMSReport Report";
      
      
    
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
      $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
 
      $alpha = array("A","B","C","D","E","F","G","H");
      
       
      $z = 1;
    
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$groupname );
      $z++;
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
      $z++;$z++;
      //change the font size
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      
      $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
      
       
      //set cell A1 content with some text
      $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
      $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Temperature');
      $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Chemistry(C)');
      $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Chemistry Time');
      $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Weighment Time');
      $this->excel->getActiveSheet()->setCellValue('F'.$z, 'SMS Exit Time');
      $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Empty Tare Time');
      $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Net Weight');
       
      $j = 0;
      foreach ($dataExport as $dt){$z++;$j++;
      $range = 'A'.$z.':'.'H'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->getNumberFormat()
      ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
      $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->LADLENO);
      $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->temp);
      $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->ch);
      $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->HSM_DATE);
      $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->GROSS_DATE);
      $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->SMS_TIME);
      $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->TARE_DATE);
      $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->NET_WEIGHT);
      }
    
      $d = new DateTime();
        
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'SMSReport.xls"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
    }
  
  
  
  
  // Weighment Report
    
    function getWeighmentReportdata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
       
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      
      $result = $this->reportsgroup_db->gettable_WeighmentReport($db);
    
      if($type == "json"){
        echo json_encode($result);
      }
      else{
        $this->getWeighmentReportExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname);
      }
    }
    
    
    
    public function getWeighmentReportExcelreport($dataExport, $start_date, $end_date, $groupname){
    
      //activate worksheet number 1
      $this->excel->setActiveSheetIndex(0);
      //name the worksheet
      $this->excel->getActiveSheet()->setTitle('Weighment Report');
    
      $headertext = "Weighment Report";
      
      
    
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(21);
      $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(21);
      $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
      $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
      $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
 
      $alpha = array("A","B","C","D","E","F","G","H","I","J","K");
      
       
      $z = 1;
    
      $range = 'A'.$z.':'.'K'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Group :".$groupname );
      $z++;
      $range = 'A'.$z.':'.'K'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
      $z++;$z++;
      //change the font size
      $range = 'A'.$z.':'.'K'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->applyFromArray($this->data['styleArray']);
      
      $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
      
       
      //set cell A1 content with some text
      $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Shift');
      $this->excel->getActiveSheet()->setCellValue('B'.$z, 'TLC No');
      $this->excel->getActiveSheet()->setCellValue('C'.$z, 'First Tare Date');
      $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Gross Date');
      $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Tare Date');
      $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Supply Area');
      $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Gross wt');
      $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Tare wt');
    $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Net wt');
    $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Second Tare wt');
    $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Leftover HM');
       
      $j = 0;
      foreach ($dataExport as $dt){$z++;$j++;
      $range = 'A'.$z.':'.'J'.$z;
      $this->excel->getActiveSheet()
      ->getStyle($range)
      ->getNumberFormat()
      ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
      $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->shift);
      $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->LADLENO);
      $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->FIRST_TARE_TIME);
      $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->GROSS_DATE);
      $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->TARE_DATE);
      $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->dest);
      $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->GROSS_WEIGHT);
      $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->TARE_WEIGHT);
    $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->NET_WEIGHT);
    $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->TARE_WT2);
    $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->hm);
      }
    
      $d = new DateTime();
        
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'WeighmentReport.xls"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
    }
    
    
    
    
    //Distance Run Report
    
    function getDistanceRun(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_distanceRun($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getDistanceRunExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getDistanceRunExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Distance Run Report');
        
        //name the worksheet
        $sheet->setTitle('Distance Run Report');
  
        $sheet->mergeCells("A1:D1");
       ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
         
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'D'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Distance Run Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'D'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Distance (KMS)');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Moving Hours');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Report Time');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        if($dt->cycleCompleted == 1){
            $this->excel->getActiveSheet()
            ->getStyle($range)
            ->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D6F5D6')
                    )
                )
                );
        }
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->distance);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->mhrs);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->reportdate);
        
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'DistanceRunReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    //Breakdown Report
    
    function getBreakdown(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_breakdown($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getBreakdownExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getBreakdownExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Breakdown Report');
        
        //name the worksheet
        $sheet->setTitle('Breakdown Report');
        
        $sheet->mergeCells("A1:E1");
        ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Breakdown Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'TLC No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Date');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Shift');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Description');
        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Duration');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->date);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->shift);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->description);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->duration);
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'BreakdownReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    //Logistic Issue Report
    
    function getLogisticIssue(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_issue($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getIssuesExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getIssuesExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Logistic Issues Report');
        
        //name the worksheet
        $sheet->setTitle('Logistic Issues Report');
        
        $sheet->mergeCells("A1:E1");
        ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Logistic Issue Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Loco No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Date');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Shift');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Delay Cause');
        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Duration');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->loconumber);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->date);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->shift);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->delaycause);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->duration);
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'LogisticIssuesReport.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    // Torpedo Status Report
    
    function getTorpedoStatus(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_status($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getStatusExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getStatusExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Torpedo Status Report');
        
        //name the worksheet
        $sheet->setTitle('Logistic Issues Report');
        
        $sheet->mergeCells("A1:G1");
        ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'G'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Torpdeo Status Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'G'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Torpedo Ladle Capacity(in tons)');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Supplier');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Guarantee Life');
        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Life(No.of Heats)');
        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Status');
        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Down Date');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->capacity);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->supplier);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->guarantee);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->beats);
        $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->status);
        $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->downdate);
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'TorpedoStatus Report.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    //Ladle Dump Report
    
    function getDumpDetails(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_dump($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getDumpExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getDumpExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Dump Details Report');
        
        //name the worksheet
        $sheet->setTitle('Ladle Dump Details Report');
        
        $sheet->mergeCells("A1:I1");
        ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'I'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Dumping Details Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'I'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'TLC No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Schedule Date');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Execution Date');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, '1st Tare Weight');
        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'After Dump Tare Weight');
        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Net Weight');
        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Flakes');
        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Metal');
        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Remarks');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->scheduledate);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->executiondate);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tarewt);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->dumptarewt);
        $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->netwt);
        $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->flakes);
        $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->metal);
        $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->remarks);
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'Dump Details Report.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    //Non Cycle Time Report
    
    function getNonCycleDetails(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'group'=>$unit,
            'circulation'=>$circulation,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
            
        );
        $result = $this->reportsgroup_db->gettable_noncycle($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getNonCycleExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $hidgroup);
        }
    }
    
    function getNonCycleExcelReport($dataExport, $start_date, $end_date, $groupname){
        
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Maintenance Time Report');
        
        //name the worksheet
        $sheet->setTitle('Maintenance Time Report');
        
        $sheet->mergeCells("A1:E1");
        ;
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z,  $groupname." Maintenance Time Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'E'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Non Circulation Time');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Circulation Time');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Maintenance Time');
        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Remarks');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'D'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->ladleno);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->non_cycling_date);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->cycling_date);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->report);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->remarks);
        }
        $z++;
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'Maintenance Time Report.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
  function getIdleTimedata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
    
      $db=array(
          'group'=>$unit,
          'circulation'=>$circulation,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      $result = $this->reportsgroup_db->gettable_idletime($db);
    
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getIdleTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unit);
    }
    }
    
    //Ladle Report
    
    function getLadleReport(){
        $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
        $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
        $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time;
        $end_datetime = $end_date." ".$end_time;
        
        $db=array(
            'group'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']
        );
        $result = $this->reportsgroup_db->gettable_ladlereport($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getLadleExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unit);
        }
    }
    
    
    public function getLadleExcelReport($dataExport, $start_date, $end_date, $unit){
        $name = "";
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $sheet->setTitle('BF Ladle Report');
        
        $headertext = "BF Ladle Report";
        
        
        $sheet->mergeCells("A1:K1");
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q");
        $k = 0;
        
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
        
        $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        
        $z = 1;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
            )
        );
        
        $this->data['styleArray'] = $style;
        $sheet->getDefaultStyle()->applyFromArray($style);
        
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
            )
        );
        
        
        $range = 'A'.$z.':'.'M'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        $sheet->setCellValue('A'.$z, $dataExport[0]->groupdesc."".$name."BF Ladle Report" );
        $z++;
        
        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
            )
        );
        //change the font size
        $range = 'A'.$z.':'.'M'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $sheet->setCellValue('A'.$z, 'Ladle No');
        $sheet->setCellValue('B'.$z, 'Cast No');
        $sheet->setCellValue('C'.$z, 'Tap Hole No');
        $sheet->setCellValue('D'.$z, 'Temperature');
        $sheet->setCellValue('E'.$z, 'Chemistry(C)');
        $sheet->setCellValue('F'.$z, 'BF Entry');
        $sheet->setCellValue('G'.$z, 'BF Exit');
        $sheet->setCellValue('H'.$z, 'Gross Date');
        $sheet->setCellValue('I'.$z, 'Net Weight');
        $sheet->setCellValue('J'.$z, 'SMS Entry');
        $sheet->setCellValue('K'.$z, 'SMS Exit');
        $sheet->setCellValue('L'.$z, 'Empty Tare');
        $sheet->setCellValue('M'.$z, 'TAT (in Min)');
        
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'P'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z,$dt->LADLENO);
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->castnumber);
        $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->tapno);
        $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->temp);
        $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->ch);
        $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->castentry);
        $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->castexit);
        $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->webmentdate);
        $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->netweight);
        $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->smsentry);
        $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->smstime);
        $this->excel->getActiveSheet()->setCellValue('L' . $z, $dt->taredate);
        $this->excel->getActiveSheet()->setCellValue('M' . $z, $dt->totalturn);
        
        }
        $z++;
        
        $d = new DateTime();
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'BF Ladle Report.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    
    
  public function getIdleTimeExcelreport($dataExport, $start_date, $end_date, $unit){
      $name = "";
        if(count($dataExport) && $unit == "2"){
          $name = "Circulation ";
        }
        else if(count($dataExport) && $unit == "3"){
          $name = "Non-Circulation";
        }
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Idle Time Report');

            $headertext = "Idle Time Report";
            
            
        $sheet->mergeCells("A1:G1");
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q");
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(0);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(18);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(20);
          
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => false,
                    'size'  => 12,
                )
          );
 
            $this->data['styleArray'] = $style;
    $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 14,
                )
          );
        
            
            $range = 'A'.$z.':'.'G'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('A'.$z, $dataExport[0]->groupdesc.":  Day ".$name."Idle time report" );
            $z++;
           
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                )
          );
            //change the font size
           $range = 'A'.$z.':'.'G'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
              
        //set cell A1 content with some text  
          $sheet->setCellValue('A'.$z, 'S.No');             
          $sheet->setCellValue('B'.$z, 'Car No.');              
          $sheet->setCellValue('C'.$z, 'Ladle No.');
          $sheet->setCellValue('D'.$z, 'Geo Fence area');             
          $sheet->setCellValue('E'.$z, 'From Time');              
          $sheet->setCellValue('F'.$z, 'To Time');
          $sheet->setCellValue('G'.$z, 'Total Idle Time (Mins)');             
            
         
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'P'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          
          $this->excel->getActiveSheet()->setCellValue('A' . $z, $j); 
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->unitname);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->lno);
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->yard);
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->starttime);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->endtime); 
              $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->idletime);
                         
            }
            $z++;
           
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'IdleTimeReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  function getLadleLifedata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      /*$orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;*/
    
      $db=array(
          'group'=>$unit,
          //'start_date'=>$start_datetime,
          //'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      $result = $this->reportsgroup_db->gettable_ladlelife($db);
    
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getLadleLifeExcelreport($result, $groupname);
    }
    }
    
  public function getLadleLifeExcelreport($dataExport, $unit){
      $name = "";
        
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Ladle Life Report');

            $headertext = "Ladle Life Report";
            
            
        $sheet->mergeCells("A1:C1");
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q");
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(30);
          
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => false,
                    'size'  => 12,
                )
          );
 
            $this->data['styleArray'] = $style;
    $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 14,
                )
          );
        
            
            $range = 'A'.$z.':'.'G'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('A'.$z, $dataExport[0]->groupdesc.": IM- Ladle Life report" );
            $z++;
           
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                )
          );
            //change the font size
           $range = 'A'.$z.':'.'G'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
              
        //set cell A1 content with some text
          $sheet->setCellValue('A'.$z, 'S.No');             
          $sheet->setCellValue('B'.$z, 'Ladle No.');              
          $sheet->setCellValue('C'.$z, 'Load Count');            
            
         
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'P'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          
          $this->excel->getActiveSheet()->setCellValue('A' . $z, $j); 
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ladleno);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->load);
                         
            }
            $z++;
           
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'LadleLifeReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  function getGeofencedata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
      
      $orgstart_date = $start_date;
      $orgend_date = $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $db=array(
          'group'=>$unit,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']         
        );
      $result = $this->reportsgroup_db->gettable_geofence($db);
    
    echo json_encode($result);  
    }
    
  function getGeoModifieddata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
      $geoid = trim(preg_replace('!\s+!', '',$this->input->get('geoid')));
      //print_r($_GET);
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $db=array(
          'group'=>$unit,
          'circulation'=>$circulation,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'geoidlist'=>$geoid,
          'detail'=>$this->data['detail']         
        );
      $result1 = $this->reportsgroup_db->gettable_geofenceModified($db);
      
    $geomodifiedReportList= $geomodifiedReportList1= $geogroupmodifiedReportList = array();
    //$geogroupmodifiedReportList = (object) $geogroupmodifiedReportList;
    $geomodifiedReportList1 = $result1;
    $geoentry=0;
    $count = count($geomodifiedReportList1);
    for($j=0;$j<$count;$j++)
    {
      $geomodifiedhtmlreportPojo = $geomodifiedReportList1[$j];
      if($geomodifiedhtmlreportPojo->entrystatus == "102" && $geoentry==0)
      {
        $geomodifiedReportList[]= $geomodifiedhtmlreportPojo;
        $geoentry=1;
      }else if($geomodifiedhtmlreportPojo->entrystatus == "103" && $geoentry==1)
      {
        $geomodifiedReportList[] = $geomodifiedhtmlreportPojo;
        $geoentry=0;
      }
    }
    $count = count($geomodifiedReportList);
    for($i=0;$i<$count;$i++)
    {
      if($geomodifiedReportList[$i]->entrystatus == "102")
      {
        $geomodifiedhtmlreportPojo=array(
                      "tGroupName"=>$geomodifiedReportList[$i]->tGroupName,
                      "tUnitName"=>$geomodifiedReportList[$i]->tUnitName,
                      "tGeoName"=>$geomodifiedReportList[$i]->tGeoName,
                      "tStartLat"=>$geomodifiedReportList[$i]->tStartLat,
                      "tStartLon"=>$geomodifiedReportList[$i]->tStartLon,
                      "tStartLoc"=>$geomodifiedReportList[$i]->tStartLoc,
                      "tStartTime"=>$geomodifiedReportList[$i]->entrytime,
                      "starttime"=>$geomodifiedReportList[$i]->starttime,
                      "endtime"=>$geomodifiedReportList[$i]->endtime,       
                      "tEndLat"=>"",
                      "tEndLon"=>"",
                      "tEndLoc"=>"",
                      "tEndTime"=>"",
                      "timespent"=>""       
                      );
        
        
        $unixtime = $geomodifiedReportList[$i]->timeunix;
        
        if($i<($count-1))
        {
          if($geomodifiedReportList[$i]->tUnitName == $geomodifiedReportList[$i+1]->tUnitName && 
              $geomodifiedReportList[$i+1]->entrystatus == "103")
          {
            $geomodifiedhtmlreportPojo["tEndLat"] = $geomodifiedReportList[$i+1]->tStartLat;
            $geomodifiedhtmlreportPojo["tEndLon"] = $geomodifiedReportList[$i+1]->tStartLat;
            $geomodifiedhtmlreportPojo["tEndLoc"] = $geomodifiedReportList[$i+1]->tStartLoc;
            $geomodifiedhtmlreportPojo["tEndTime"] = $geomodifiedReportList[$i+1]->entrytime;
            $geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i+1]->starttime;
            $geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i+1]->endtime;
            
            
            $timespent = $geomodifiedReportList[$i+1]->timeunix - $unixtime;
             if($timespent!=0 && $timespent >0 ){
                //$minutes = intval($timespent / 60);
                      //$timeHours = $minutes;
                $minutes = floor($timespent / 60);
                $seconds = $timespent % 60;
                $timeHours = "";
                if($minutes > 0){
                  if($seconds > 40){
                    $minutes = $minutes + 1;
                  }
                  $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
                  $timeHours = $disMinu;
                }               
                
                if($minutes == 0 && $seconds > 0 && $seconds < 55){
                  $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
                  $timeHours = $disSec."s";
                }
                else if($minutes == 0 && $seconds >= 55){
                  $disSec = "01" ;
                  $timeHours = $disSec;
                }
              }else{
                $timeHours= "00";
              }
             $geomodifiedhtmlreportPojo["timespent"] = $timeHours;
            $i++;
            
          }else
          {
            
            $geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
            $geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
            $geomodifiedhtmlreportPojo["timespent"] = "N/A";
            $geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i]->starttime;
            $geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i]->endtime;
          }
          if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
            ($geomodifiedhtmlreportPojo["timespent"] != "N/A") && $timespent>=600){
            $geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
          }
          
        }
        
        if(($i==$count-1) && $geomodifiedReportList[$i]->entrystatus == "102")
        {
           $geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
           $geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
           $geomodifiedhtmlreportPojo["timespent"] = "N/A";
          if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
            ($geomodifiedhtmlreportPojo["timespent"] != "N/A")){
            $geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
          }
           
        }
        
      }else if($geomodifiedReportList[$i]->entrystatus == "103")
      {
        
        $geomodifiedhtmlreportPojo=array(
                      "tGroupName"=>$geomodifiedReportList[$i]->tGroupName,
                      "tUnitName"=>$geomodifiedReportList[$i]->tUnitName,
                      "tGeoName"=>$geomodifiedReportList[$i]->tGeoName,
                      "tStartLat"=>"",
                      "tStartLon"=>"",
                      "tStartLoc"=>"N/A",
                      "tStartTime"=>"N/A",
                      "starttime"=>$geomodifiedReportList[$i]->starttime,
                      "endtime"=>$geomodifiedReportList[$i]->endtime,       
                      "tEndLat"=>"",
                      "tEndLon"=>"",
                      "tEndLoc"=>$geomodifiedReportList[$i]->tStartLoc,
                      "tEndTime"=>$geomodifiedReportList[$i]->entrytime,
                      "timespent"=>"N/A"        
                      );
        
        if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
          ($geomodifiedhtmlreportPojo["timespent"] != "N/A")){
          $geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
        }
      }
      
    
    }
      $result = $geogroupmodifiedReportList;
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getGeofenceExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $circulation);
    }
    }
    
  public function getGeofenceExcelreport($dataExport, $start_date, $end_date, $circulation){
      $name = "";
        if(count($dataExport) && $circulation == "1"){
          $name = "Circulation ";
        }
        else{
          $name = "Non-Circulation ";
        }
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Group Geofence Report');

            $headertext = "Group Geofence Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, $name."IM-Ladle Geo fence area delay Report" );
            $z++; $z++; 
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name" );
             $this->excel->getActiveSheet()->setCellValue('C'.$z, $dataExport[0]->tGroupName );
           
            $z++;$z++;  
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Sl No.');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Group Name');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Ladle No.');        
          //$this->excel->getActiveSheet()->setCellValue('D'.$z, 'Entry Location');             
          $this->excel->getActiveSheet()->setCellValue('D'.$z, 'From Time');              
          //$this->excel->getActiveSheet()->setCellValue('F'.$z, 'Exit Location');
          $this->excel->getActiveSheet()->setCellValue('E'.$z, 'To Time');    
          $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Geofence Area');                
          $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Time (min`s)');
          
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        $this->excel->getActiveSheet()->setCellValue('A' . $z, $j); 
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->tGroupName); 
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->tUnitName);
          
              //$this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tStartLoc);
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tStartTime);
              //$this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->tEndLoc);            
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->tEndTime);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->tGeoName); 
              $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->timespent);
            }
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'GeofenceListReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  function getMaintenancedata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
    
      $db=array(
          'group'=>$unit,
          'circulation'=>$circulation,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
      $result = $this->reportsgroup_db->gettable_maintenance($db);
    
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getMaintenanceExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time , $groupname);
    }
    }
    
  public function getMaintenanceExcelreport($dataExport, $start_date, $end_date, $groupname){
      $name = "";
        /*if(count($dataExport) && $circulation == "1"){
          $name = "Circulation ";
        }
        else{
          $name = "Non-Circulation ";
        }*/
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Maintenance Report');

            $headertext = "Maintenance Report";
            
            
        $sheet->mergeCells("A1:K1");
        
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q");
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(18);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(18);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(18);
            $sheet->getColumnDimension('J')->setWidth(18);
            $sheet->getColumnDimension('K')->setWidth(18);
          
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => false,
                    'size'  => 12,
                )
          );
 
            $this->data['styleArray'] = $style;
    $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 14,
                )
          );
        
            
            $range = 'A'.$z.':'.'K'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('A'.$z, $groupname.":  IM-Ladle Maintenance report" );
            $z++;
           
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 11,
                )
          );
            //change the font size
           $range = 'A'.$z.':'.'K'.$z;
      $sheet->getStyle($range)->applyFromArray($style);
              
        //set cell A1 content with some text
          $sheet->setCellValue('A'.$z, 'S.No');             
          $sheet->setCellValue('B'.$z, 'Ladle No');             
          $sheet->setCellValue('C'.$z, '2nd Tare Weight');
          $sheet->setCellValue('D'.$z, '2nd Tare Date');              
          $sheet->setCellValue('E'.$z, 'Type of Repair');             
          $sheet->setCellValue('F'.$z, 'SubType of Repair');   
          $sheet->setCellValue('G'.$z, 'Repair Completed Date');              
          $sheet->setCellValue('H'.$z, 'Maintenance Time');             
          $sheet->setCellValue('I'.$z, 'Heating Started Date');
          $sheet->setCellValue('J'.$z, 'Heating Stopped Date');
          $sheet->setCellValue('K'.$z, 'Under Heating Time');    

  
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'L'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
                
              if($dt->cycleCompleted == 1){
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray(
                      array(
                          'fill' => array(
                              'type' => PHPExcel_Style_Fill::FILL_SOLID,
                              'color' => array('rgb' => 'D6F5D6')
                          )
                      )
                  );;
              }
          
          $this->excel->getActiveSheet()->setCellValue('A' . $z, $j); 
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ladleno);
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->sndTarewt);
              $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->sndTaretime);
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->type);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->type_desc); 
              $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->repairComplete);
              $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->maintainenceTime);
              $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->heatingStarted);
              $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->heatingStopped); 
              $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->underHeating);
                         
            }
            $z++;
           
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'MaintenanceReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    function dateRangeedit(){
      $res = $this->home_db->dateRange("01-08-2017", "31-08-2017", $step = '+1 day', $format = 'Y-m-d');
      print_r($res);
    }
    
    
  function getLadleConditiondata(){
      $groupname = trim(preg_replace('!\s+!', '',$this->input->get('groupname')));
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidunit')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
    $remres = $remresname = array();
    $remarks = $this->master_db->getRecords("ladle_remarks", array(), "id, remarks");
    foreach ($remarks as $r){
            $remres[] = $r->id;
            $remresname[] = $r->remarks;
        }
      
      $result = array();
      $final = array();
      $res = $this->home_db->dateRange($start_date, $end_date, $step = '+1 day', $format = 'Y-m-d');
      $i = 0;
    foreach ($res as $r){$i++;
      
      if($i == 1){
        $start_datetime = $r." ".$start_time;
          $end_datetime = $r." 23:59:59";
      }
      else if($i == count($res)){
        $start_datetime = $r." 00:00:00";
          $end_datetime = $r." ".$end_time;
      }
      else{
        $start_datetime = $r." 00:00:00";
          $end_datetime = $r." 23:59:59";
      }
      
      $db=array(
          'group'=>$unit,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']           
        );
        $resul = $this->reportsgroup_db->gettable_ladlecondition($db);
        $arra = array("conditionDate"=>date("d-m-Y", strtotime($r)));
      foreach ($remres as $rem){
          $arra["w".$rem] = 0;
        }
        foreach ($resul as $re){
          $arra["w".$re->remarks] = $re->cnt;         
        }
        $final[] = (object)$arra;
    }
    
      $result = $final;
      
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getLadleConditionExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $groupname, $remarks);
    }
    }
    
  public function getLadleConditionExcelreport($dataExport, $start_date, $end_date, $unit, $remarks){
      $name = "";
        $remarkscnt = count($remarks);
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Ladle Condition Report');

            $headertext = "Ladle Condition Report";
            
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q","R","S","T","U","V");
        $sheet->mergeCells("A1:".$alpha[$remarkscnt+1]."1");
        
        
        $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $i = 2;
            foreach ($remarks as $r){
              $sheet->getColumnDimension($alpha[$i++])->setWidth(18);
            }
          
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i = 2;
            foreach ($remarks as $r){
            $this->excel->getActiveSheet()->getStyle($alpha[$i++])->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            
            $z = 1;
            
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => false,
                    'size'  => 12,
                )
          );
 
            $this->data['styleArray'] = $style;
    $sheet->getDefaultStyle()->applyFromArray($style);
           
    
      $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 14,
                )
          );
        
            
            $range = 'A'.$z.':'.$alpha[$remarkscnt+1].$z;
      $sheet->getStyle($range)->applyFromArray($style);
            $sheet->setCellValue('A'.$z, $unit.": IM-Ladle Day ".$name."Ladle Condition report" );
            $z++;
           
            $style = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                 'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                )
          );
            //change the font size
           $range = 'A'.$z.':'.$alpha[$remarkscnt+1].$z;
      $sheet->getStyle($range)->applyFromArray($style);
              
        //set cell A1 content with some text
          $sheet->setCellValue('A'.$z, 'S.No');             
          $sheet->setCellValue('B'.$z, 'Date');
      $i = 2;
            foreach ($remarks as $r){
            $sheet->setCellValue($alpha[$i++].$z, $r->remarks);
            }             
                     
            
         
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              //print_r($dt);
              $range = 'A'.$z.':'.$alpha[$remarkscnt+1].$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
          $i = 2;
          $this->excel->getActiveSheet()->setCellValue('A' . $z, $j); 
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->conditionDate);
              foreach ($remarks as $r){
                $var = "w".$r->id;
                $this->excel->getActiveSheet()->setCellValue($alpha[$i++] . $z, $dt->$var);
              } 
                         
            }
            $z++;
           
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'LadleConditionReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  
  function getGroupConsolidateTimedata(){
    
    $shiftwiseReportFinalList = array();
      
    $endtime = $enddatetime = $enddatetimee = $unitno = $vehtype = $contractor =$companyname ="";
    $unitName = $groupName = $unitnumbers = null;
    
      /*String str[]= fromdate.split(" "); 
      String fromdate1 = str[0];
      String fromtime = str[1];*/
    $totaldist =0.0;
    $totalworktime = $totaligntime= $dayworktime = 0;
    $daytotal = 0.0;
       
      
    $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $hidgroup = trim(preg_replace('!\s+!', ' ',$this->input->get('hidgroup')));
      
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      //$historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unit);
      $db=array(
          'group'=>$group,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail'],
          'checkGroup'=>$checkAuto,
        //'historyTable'=>$historyTableName." as h"           
        );
      $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $cnt = count($unitnumbers);
      
      $shift = explode(" ", $start_datetime); 
    $shiftto = explode(" ", $end_datetime); 
    $shift1 = explode(":", $shift[1]);
    $shiftto1 = explode(":", $shiftto[1]);
      
    $shifttime= $shift1[0].":".$shift1[1]." - ".$shiftto1[0].":".$shiftto1[1];
    $reportdate = $shift[0];
    $daychange = $shift1[0].":".$shift1[1];
      
    for($u=0;$u<=$cnt-1;$u++){
        $odoreportPojo = $unitnumbers[$u];
      $unitno = $odoreportPojo->unitno;
      $unitName = $odoreportPojo->unitname;
      $groupName = $odoreportPojo->groupname;
      $vehtype = $odoreportPojo->vehtype;
      $contractor = $odoreportPojo->contractor;
        $companyname = $odoreportPojo->companyname;
      $db["uid"] = $unitno;
      
      $dist = $f3 = $Pre_distance = $Cur_distance = $f1 = $f2 = 0.0;
      $ignOn = $workingtime = $reporttimeunix = $prereporttimeunix = $workinghours = $idlehours = $startunixtime = $endunixtime = $idletimeunix = 0;      
      $unit_distance = $idleHours2 = $TotalHours1 = $DayTotal =null;
      
      $shiftstarttime= $shiftendtime="NA";
          
      $temppojo = array();
      
      $historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unitno);
      
      $db["historyTable"] = $historyTableName." as h";
      $d1 = $start_datetime; $d2 = $end_datetime;
      //echo strtotime($d2)."-";
      //echo strtotime($d1)."-";
      $idle = (strtotime($d2) - strtotime($d1)); 
      
      $shiftwiseReportList = $this->reportsgroup_db->getshiftwisedistancereport($db);
        $shiftcount = count($shiftwiseReportList);
      if ($shiftwiseReportList != null && count($shiftwiseReportList) > 0) {
                
        for($unit=0;$unit<$shiftcount;$unit++){
            
          $con1pojo = $shiftwiseReportList[$unit]; 
          if($unit==0){
                    $Pre_distance = floatval($con1pojo->dist);
                  }
                
           if($con1pojo->statusid == "1")
               {
                     if($ignOn == 0){
                  $f1 = 0.0;
                  $Cur_distance = floatval($con1pojo->dist);
                            $reporttimeunix = intval($con1pojo->reporttime);
                            if($Pre_distance <= $Cur_distance){
                            $dist = floatval($dist) + floatval($Cur_distance-$Pre_distance);
                            $Pre_distance = $Cur_distance;
                            $prereporttimeunix = $reporttimeunix ;
                        }
                        else if($Pre_distance > $Cur_distance){
                                  // dist = dist + Cur_distance;
                            $Pre_distance = $Cur_distance ;
                            $prereporttimeunix = $reporttimeunix ;
                        }
                  $ignOn++;
                                    
                }
                else if($ignOn == 1){
                    $f1= 0.0;
                    $Cur_distance  = floatval($con1pojo->dist);
                  $reporttimeunix = intval($con1pojo->reporttime);
                            if($Pre_distance <= $Cur_distance)
                        {
                            $dist = floatval($dist) + floatval($Pre_distance-$Cur_distance);
                            $Pre_distance = $Cur_distance;
                            $prereporttimeunix = $reporttimeunix ;
                                 
                        }else if($Pre_distance > $Cur_distance){
                                  // dist = dist + Cur_distance;
                            $Pre_distance = $Cur_distance;
                            $prereporttimeunix = $reporttimeunix ;
                        }
                }
                
                   if($unit==0){
                       $shiftstarttime = $con1pojo->datetime;
                       $startunixtime = $con1pojo->unixtime;
                     }
                   else if($unit==($shiftcount-1)){
                     $shiftendtime = $con1pojo->datetime;
                     $endunixtime = $con1pojo->unixtime;
                   }
           }
                else if($unit!=0 && $con1pojo->statusid == "0") 
              {
                $unit_distance = $con1pojo->dist;
                $Cur_distance  = floatval($con1pojo->dist);
                $reporttimeunix = intval($con1pojo->reporttime);
            $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                        $workingtime = intval($workingtime + $workinghours);
                                  
                       if($Pre_distance <= $Cur_distance)
                             {
                               $dist = floatval($dist) + floatval($Cur_distance-$Pre_distance);
                               $Pre_distance = $Cur_distance;
                            $prereporttimeunix = $reporttimeunix ;
                             
                               
                              }else if($Pre_distance > $Cur_distance){
                              // dist = dist + Cur_distance;
                               $Pre_distance = $Cur_distance;
                              $prereporttimeunix = $reporttimeunix ;
                                 
                             }
                          
                           $ignOn = 0;
                               if($unit==0){
                           $shiftstarttime = $con1pojo->datetime;
                           $startunixtime = $con1pojo->unixtime;
                         }
                       else if($unit==($shiftcount-1)){
                         $shiftendtime = $con1pojo->datetime;
                         $endunixtime = $con1pojo->unixtime;
                       }
                                  
                      }  
                 else
                 { 
          
                    if($unit==0){
                      
                    $Pre_distance = floatval($con1pojo->dist);
                                $reporttimeunix = $reporttimeunix + intval($con1pojo->reporttime);
                                $prereporttimeunix = $reporttimeunix ;
                                $workinghours = intval($con1pojo->reporttime) - (int)(strtotime($d1)) ;
                    $workingtime = intval($workingtime + $workinghours);
                    $shiftstarttime = $con1pojo->datetime;
                      $startunixtime = $con1pojo->unixtime;
                      
                     }
                      else if($unit==($shiftcount-1)){
                       
                      $unit_distance  = $con1pojo->dist;
                      $Cur_distance  = floatval($con1pojo->dist);
                        $reporttimeunix =  intval($con1pojo->reporttime);
                        $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                        $workingtime = intval($workingtime + $workinghours);
                        $workinghours = (int)(strtotime($d2))  - intval($con1pojo->reporttime) ;
                        $workingtime = intval($workingtime + $workinghours);
                        $shiftendtime = $con1pojo->datetime;
                        $endunixtime = $con1pojo->unixtime;
                         if($Pre_distance <= $Cur_distance)
                                 {
                                   $dist = floatval($dist) + floatval($Cur_distance-$Pre_distance);
                                   $Pre_distance = $Cur_distance;
                                   $prereporttimeunix = $reporttimeunix ;
                                  
                                   
                                 }else if($Pre_distance > $Cur_distance){
                                 // dist = dist + Cur_distance;
                                   $Pre_distance = $Cur_distance ;
                                   $prereporttimeunix = $reporttimeunix ;
                                     
                                 }
                    
                
                               }else
                               {
                                 
                                  
                                          $Cur_distance  = floatval($con1pojo->dist);
                                          
                                        
                                          $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                          $workingtime = intval($workingtime + workinghours);
                           
                          $reporttimeunix = intval($con1pojo->reporttime);
                          
                                      
                                         
                                        // checking with Prevoius distance value if it is lessthan adding the total distance = (current distance - Prev distance); 
                                       
                                        if($Pre_distance <= $Cur_distance)
                                         {
                                           
                                             $dist = floatval($dist) + floatval($Cur_distance-$Pre_distance);
                                             $Pre_distance = $Cur_distance ;
                                          $prereporttimeunix = $reporttimeunix ;
                                            
                                           
                                         }else if(Pre_distance > Cur_distance){
                                             
                                            // dist = dist + Cur_distance;
                                             $Pre_distance = $Cur_distance ;
                                        $prereporttimeunix = $reporttimeunix ;
                                            
                                         }
                           
                               
                               
                               }
                    
                 }
                    
                 
               }
               
          if($workingtime >$idle)
            {
              if($startunixtime!=0 && $endunixtime!=0)
              {
                $workingtime = $endunixtime - $startunixtime;
              }else if($startunixtime!=0 && $endunixtime==0){
                  $workingtime = $idle;
              }
            }
            
          if($workingtime!=0 && $workingtime<=$idle && $workingtime>0){
            
            $hours = (int)($workingtime / 3600);
            $remainder = (int)($workingtime % 3600);
            $minutes = (int) ($remainder / 60);
            $seconds = (int) ($remainder % 60);
    
            $disHour = ($hours < 10 ? "0" : "") . $hours;
            $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
            $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
    
            $TotalHours1 = $disHour.":".$disMinu.":".$disSec;
            $idlehours = intval($idle - $workingtime) ;
             
          }else{
            $TotalHours1= "00:00:00";
            
          }
          
             if($idlehours!=0 && $idlehours>0){
               
              $hours = (int)($idlehours / 3600);
            $remainder = (int)($idlehours % 3600);
            $minutes = (int) ($remainder / 60);
            $seconds = (int) ($remainder % 60);
    
            $disHour = ($hours < 10 ? "0" : "") . $hours;
            $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
            $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
    
            $idleHours2 = $disHour.":".$disMinu.":".$disSec;
          }
             else{
                  $idleHours2 ="00:00:00";
             }
            $totaldist = $totaldist + $dist;
            $daytotal = floatval($daytotal+$dist);
            $dayworktime = $dayworktime+$workingtime;
            
            $totalworktime = $totalworktime+$workingtime;
            $totaligntime = $totaligntime+$idlehours;
            
            $temppojo["reportdate"] = $reportdate;
          $temppojo["shifttime"] = $shifttime;
          $temppojo["dist"] = number_format((float)$dist, 2, '.', '');
          $temppojo["TotalHours1"] = $TotalHours1;  
            $temppojo["idleHours2"] = $idleHours2;
            $temppojo["unitName"] = $unitName;
          $temppojo["groupName"] = $groupName;
          $temppojo["shiftstarttime"] = $shiftstarttime;
          $temppojo["shiftendtime"] = $shiftendtime;
          $temppojo["vehtype"] = $vehtype;
          $temppojo["contractor"] = $contractor;
           
            $shiftwiseReportFinalList[] = (object)$temppojo;
        
                }
                else{
                  
                  $idlehours = $idle ;
            
                  $hours = (int)($idlehours / 3600);
          $remainder = (int)($idlehours % 3600);
          $minutes = (int) ($remainder / 60);
          $seconds = (int) ($remainder % 60);
  
          $disHour = ($hours < 10 ? "0" : "") . $hours;
          $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
          $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
  
          $idleHours2 = $disHour.":".$disMinu.":".$disSec;
          
                 $totaldist = floatval($totaldist) + 0;
           $totalworktime = intval($totalworktime+0);
           $daytotal =$daytotal+$dist;
           $totaligntime = $totaligntime+$idlehours;
           
           $temppojo["reportdate"] = $reportdate;
           $temppojo["shifttime"] = $shifttime;
          $temppojo["dist"] = "0.0";
          $temppojo["TotalHours1"] = "00:00:00";  
            $temppojo["idleHours2"] = $idleHours2;
            $temppojo["unitName"] = $unitName;
          $temppojo["groupName"] = $groupName;
          $temppojo["shiftstarttime"] = $shiftstarttime;
          $temppojo["shiftendtime"] = $shiftendtime;
          $temppojo["vehtype"] = $vehtype;
          $temppojo["contractor"] = $contractor;
          
            $shiftwiseReportFinalList[] = (object)$temppojo;
                }
       }
      
      
      $result = $shiftwiseReportFinalList;
    
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getConsolidateTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time,$checkAuto);
    }
    
    }
    
  public function getConsolidateTimeExcelreport($dataExport, $start_date, $end_date,$checkAuto){
        
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Consoildate Time Report');

            $headertext = "Consoildate Time Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Consolidate Time Report (".$start_date." to ".$end_date.")" );
            $z++;$z++;  
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
        if($checkAuto == "1"){
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :ALL");
        }
        else{
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :".$dataExport[0]->groupName );
        }
            
            $z++;$z++;  
            
            
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
        
          $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Group Name');             
          $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Unit Name');  
          $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Date');             
          $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Start Time');             
          $this->excel->getActiveSheet()->setCellValue('F'.$z, 'End Time');             
          $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Distance(Kms)');
          $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Working Hours');              
          $this->excel->getActiveSheet()->setCellValue('I'.$z, 'IgnOff Hours');
          
          $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
              $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        if($j == 1){
          $groupname = $dt->groupName;
        } 
        else if($dt->groupName == $dataExport[$j - 1]->groupName){
          $groupname = "";
        }
        else{
          $groupname = $dt->groupName;
        }
        
              if($j == 1){
          $unitname = $dt->unitName;
        } 
        else if($dt->unitName == $dataExport[$j - 1]->unitName){
          $unitname = "";
        }
        else{
          $unitname = $dt->unitName;
        }
        
              if($j == 1){
                $reportdate = $dt->reportdate;
                $date = date_create($reportdate);
          $reportdate=date_format($date, 'd-m-Y');
          
        } 
        else if($dt->reportdate == $dataExport[$j - 1]->reportdate){
          $reportdate = "";
        }
        else{
          $reportdate = $dt->reportdate;
                $date = date_create($reportdate);
          $reportdate=date_format($date, 'd-m-Y');
        }
    
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $groupname); 
              $this->excel->getActiveSheet()->setCellValue('C' . $z, $unitname);
          $this->excel->getActiveSheet()->setCellValue('D' . $z, $reportdate); 
              $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->shiftstarttime);
              $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->shiftendtime);
              $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->dist);  
              $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->TotalHours1);
              $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->idleHours2);             
            }
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'GroupConsolidateTimeReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    
  function getGeofenceTransitdata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
      
      $orgstart_date = $start_date;
      $orgend_date = $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $db=array(
          'group'=>$group,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']         
        );
      $result = $this->reportsgroup_db->getGeoFenceGroupHtmlReport($db);
    
    echo json_encode($result);  
    }
    
  function getGeoTransitModifieddata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
      $geoid = trim(preg_replace('!\s+!', '',$this->input->get('geoid')));
      //print_r($_GET);
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $geomodifiedfinalhtmlreport = array();
      
      $db=array(
          'group'=>$group,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'geoidlist'=>$geoid,
          'detail'=>$this->data['detail']         
        );
        
    $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $cnt = count($unitnumbers);
      for($u=0;$u<=($cnt-1);$u++){
        $odoreportPojo = $unitnumbers[$u];
      $unitno = $odoreportPojo->unitno;
      $unitName = $odoreportPojo->unitname;
      $groupName = $odoreportPojo->groupname;
      $db['unitnum'] = $unitno;
        $geomodifiedhtmlreport = $this->reportsgroup_db->getGroupGeofenceTripReportExcel($db);
        //print_r($geomodifiedhtmlreport);
        $geocnt = count($geomodifiedhtmlreport);
        if($geomodifiedhtmlreport != null && $geocnt > 0){
            
            for($i=0;$i<$geocnt;$i++){
              
              $geoName = $geomodifiedhtmlreport[$i]->tGeoName;
              
              $geopojo = array();
              $geopojo["tUnitName"] = $unitName;
              $geopojo["groupname"] = $groupName;
              $geopojo["tGeoName"] = $geomodifiedhtmlreport[$i]->tGeoName;
              $geopojo["tStartTime"] = $geomodifiedhtmlreport[$i]->tStartTime;
              $geopojo["tEndTime"] = $geomodifiedhtmlreport[$i]->tEndTime;
              $geopojo["timespent"] = $geomodifiedhtmlreport[$i]->timespent;
              $i++;
              if($i<=($geocnt-1)){
                   if($geoName != $geomodifiedhtmlreport[$i]->tGeoName && $geomodifiedhtmlreport[$i]->tGeoName != "NA"){
                
                  $geopojo1 = array();
                  $geopojo1["tUnitName"] = $unitName;
                  $geopojo1["groupname"] = $groupName;
                  $geopojo1["tGeoName"] = $geomodifiedhtmlreport[$i]->tGeoName;
                  $geopojo1["tStartTime"] = $geomodifiedhtmlreport[$i]->tStartTime;
                  $geopojo1["tEndTime"] = $geomodifiedhtmlreport[$i]->tEndTime;
                  $geopojo1["timespent"] = $geomodifiedhtmlreport[$i]->timespent;
                  
                  $geomodifiedfinalhtmlreport[] = (object) $geopojo;
                    $geomodifiedfinalhtmlreport[] = (object) $geopojo1;
                }else
                {
                  $i = $i-1;
                }
              }
              
              
            }
          }
          //print_r($geomodifiedfinalhtmlreport);
         //exit;
      }
      
      $total_fill = $total_loss = 0;
    $date1= $date2= $date4 = $date5 = null;
    $date3= $date6="";
    
      $result = $geomodifiedfinalhtmlreport;
    if($type == "json"){
        echo json_encode($result);  
    }
    else{
      $this->getGeofenceTransitExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $checkAuto);
    }
    }
    
  public function getGeofenceTransitExcelreport($dataExport, $start_date, $end_date, $checkAuto){
        
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Geofence Group Transit Report');

            $headertext = "Geofence Group Transit Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            
         
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            
            
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("N")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $z = 1;
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Geofence Group Trip Report  From ".$start_date." to ".$end_date );
            $z++; $z++; 
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
      if($checkAuto == "1"){
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :ALL");
        }
        else{
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :".$dataExport[0]->groupname );
        }
           
            $z++;$z++;  
            //change the font size
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
              
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Unit Name');
          $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Geofence Name');              
          $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Entry Date');             
          $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Entry Time');             
          $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Exit Date');
          $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Exit Time');              
          $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Time Spent');
          $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Geofence Name');              
          $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Entry Date');             
          $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Entry Time');             
          $this->excel->getActiveSheet()->setCellValue('L'.$z, 'Exit Date');
          $this->excel->getActiveSheet()->setCellValue('M'.$z, 'Exit Time');              
          $this->excel->getActiveSheet()->setCellValue('N'.$z, 'Time Spent');
          $this->excel->getActiveSheet()->setCellValue('O'.$z, 'Transit Time');
          
          $j = 0;$i=0;
          $cnt = count($dataExport);
            for ($i=0; $i < $cnt;$i++){$z++; 
              $range = 'A'.$z.':'.'J'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        $vehName =  $dataExport[$i]->tUnitName;
        $geoName = $dataExport[$i]->tGeoName;
          //echo $j - 1;      
              if($i == 0){
          $tUnitName = $dataExport[$i]->tUnitName;
        } 
        else if($dataExport[$i]->tUnitName == $dataExport[$i - 1]->tUnitName){
          $tUnitName = "";
        }
        else{
          $tUnitName = $dataExport[$i]->tUnitName;
        }
          
              $this->excel->getActiveSheet()->setCellValue('B' . $z, $tUnitName);
          $this->excel->getActiveSheet()->setCellValue('C' . $z, $dataExport[$i]->tGeoName); 
              if($dataExport[$i]->tStartTime != "" && $dataExport[$i]->tStartTime !="NA"){
          $entry = explode(" ",$dataExport[$i]->tStartTime);
          $this->excel->getActiveSheet()->setCellValue('D' . $z, $entry[0]);
                $this->excel->getActiveSheet()->setCellValue('E' . $z, $entry[1]);
          }else{
            $this->excel->getActiveSheet()->setCellValue('D' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('E' . $z, "NA");
          }
          
              if($dataExport[$i]->tEndTime != "" && $dataExport[$i]->tEndTime !="NA"){
          $exitt = explode(" ",$dataExport[$i]->tEndTime);          
          $this->excel->getActiveSheet()->setCellValue('F' . $z, $exitt[0]);
                $this->excel->getActiveSheet()->setCellValue('G' . $z, $exitt[1]);
        }else
        {
          $this->excel->getActiveSheet()->setCellValue('F' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('G' . $z, "NA");
          
        }
          $this->excel->getActiveSheet()->setCellValue('H' . $z, $dataExport[$i]->timespent);
        
        if($dataExport[$i]->timespent != "NA"){
          $date1 = date("H:i:s", strtotime($dataExport[$i]->timespent));
          $date1 = date_create($date1);
          $date1=date_format($date1, 'H:i:s');
          
          $date4 = date_create($dataExport[$i]->tEndTime);
          $date4=date_format($date4, 'd-m-Y H:i:s');          
        }
        
        $i++;
        
              if($i<=($cnt-1)){
          
          if($dataExport[$i]->tUnitName == $vehName){ 
            
          $this->excel->getActiveSheet()->setCellValue('I' . $z, $dataExport[$i]->tGeoName);
        
          if($dataExport[$i]->tStartTime != "" && $dataExport[$i]->tStartTime !="NA"){
            $entry = explode(" ",$dataExport[$i]->tStartTime);
            $this->excel->getActiveSheet()->setCellValue('J' . $z, $entry[0]);
                  $this->excel->getActiveSheet()->setCellValue('K' . $z, $entry[1]);
            }else{
              $this->excel->getActiveSheet()->setCellValue('J' . $z, "NA");
                  $this->excel->getActiveSheet()->setCellValue('K' . $z, "NA");
            }
          
          
          if($dataExport[$i]->tEndTime != "" && $dataExport[$i]->tEndTime !="NA"){
            $exitt = explode(" ",$dataExport[$i]->tEndTime);          
            $this->excel->getActiveSheet()->setCellValue('L' . $z, $exitt[0]);
                  $this->excel->getActiveSheet()->setCellValue('M' . $z, $exitt[1]);
          }else
          {
            $this->excel->getActiveSheet()->setCellValue('L' . $z, "NA");
                  $this->excel->getActiveSheet()->setCellValue('M' . $z, "NA");
            
          }
  
          
          $this->excel->getActiveSheet()->setCellValue('N' . $z, $dataExport[$i]->timespent);
          
          if($dataExport[$i]->tStartTime != "NA"){
            $date5 = date_create($dataExport[$i]->tStartTime);
            $date5=date_format($date5, 'd-m-Y H:i:s');
            
             $transit = strtotime($date5) - strtotime($date4);
             $date6 = date('H:i:s',$transit);
             //$date6=date_format($date6, 'H:i:s');
          }else{
            $date6 ="NA";
          }
                    
          $this->excel->getActiveSheet()->setCellValue('O' . $z, $date6);
        
        
        }else
        {
        
                    $i = $i-1;
          
          $this->excel->getActiveSheet()->setCellValue('I' . $z, "NA");
            $this->excel->getActiveSheet()->setCellValue('J' . $z, "NA"); 
                $this->excel->getActiveSheet()->setCellValue('K' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('L' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('M' . $z, "NA");            
                $this->excel->getActiveSheet()->setCellValue('N' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('O' . $z, "NA");
          
        }
        
        }else
        {
          $this->excel->getActiveSheet()->setCellValue('I' . $z, "NA");
            $this->excel->getActiveSheet()->setCellValue('J' . $z, "NA"); 
                $this->excel->getActiveSheet()->setCellValue('K' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('L' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('M' . $z, "NA");            
                $this->excel->getActiveSheet()->setCellValue('N' . $z, "NA");
                $this->excel->getActiveSheet()->setCellValue('O' . $z, "NA");
          
          
        }
          
              //$j++;
            }
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'GroupGeofenceTransitReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    function get3Shiftwisedata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $groupname = trim(preg_replace('!\s+!', ' ',$this->input->get('groupname')));
      //print_r($_GET);
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $fromdate = $reportfrom = $start_datetime;
    $todate = $reportto = $end_datetime;
    $GroupName = $groupname;
      $fromdatee = $fromdate;
    $todatee = $todate;
    
    $shiftwiseReportFinalList = array();
    
    
    $shift1start ="06:00:00";
    $shift1end ="14:00:00";
    $shift2start ="14:00:01";
    $shift2end ="22:00:00";
    $shift3start ="22:00:01";
    $shift3end ="06:00:00";
    $shift4start ="00:00:00";
    $endtime = $enddatetime = $enddatetimee = $vehtype = $contractor = $companyname = "";
    $unitName =  $groupName = $unitnumbers = null;
    
    $str= explode(" ", $fromdate); 
    $fromdate1 = $str[0];
    $fromtime = $str[1];
    $totaldist = $daytotal = 0.0;
    $totalworktime = $totaligntime= $dayworktime = 0;   
    
    if(strtotime($fromtime) >= strtotime($shift1start) && strtotime($fromtime)<= strtotime($shift1end))
    {
      $endtime = $shift1end;
    }
    else if(strtotime($fromtime) >= strtotime($shift2start) && strtotime($fromtime) <= strtotime($shift2end))
    {
      $endtime = $shift2end;
    }else if(strtotime($fromtime) >= strtotime($shift3start) && strtotime($fromtime) <= strtotime($shift3end))
    {
      $endtime = $shift3end;
    }else if(strtotime($fromtime) >= strtotime($shift4start) && strtotime($fromtime) <= strtotime($shift3end))
    {
      $endtime = $shift3end;
    }
    
    $enddatetime = $fromdate1." ".$endtime;
    
    $enddatetimee = $enddatetime;
      
      $db=array(
          'group'=>$group,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']         
        );
        
    $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $cnt = count($unitnumbers);
      
      for($u=0;$u<=($cnt-1);$u++)
     {
        $odoreportPojo = $unitnumbers[$u];
        $unitno = $odoreportPojo->unitno;
      $unitName = $odoreportPojo->unitname;
      $groupName = $odoreportPojo->groupname;
      
      $vehtype = $odoreportPojo->vehtype;
      $contractor = $odoreportPojo->contractor;
        $companyname = $odoreportPojo->companyname;
      $db['uid'] = $unitno;
      //echo $fromdate."---".$todate."<br>";
        while(strtotime($fromdate) < strtotime($todate))
        {
          $ignOn = 0 ;
          $dist = 0.00;
          $f3= $Pre_distance = $Cur_distance = $f1=  $f2= 0.0;
          $workingtime =  $reporttimeunix =  $prereporttimeunix =  $workinghours =  $idletimeunix = $idlehours = $startunixtime =  $endunixtime = 0;
          $unit_distance = $idleHours2 = $TotalHours1 = $DayTotal =null;
          
          $shiftstarttime= $shiftendtime="";
          
          $temppojo = array();
          
          if(strtotime($todate) <= strtotime($enddatetime))
          {
            $enddatetime = $todate;
          }
          if(count($enddatetime) == 11)
          {
            $enddatetime = $todate; 
          }
          
          $db["start_date"] = $fromdate;
          $db["end_date"] = $enddatetime;
          $historyTableName = $this->home_db->getHistoryTable($fromdate, $enddatetime, $unitno);
          $db["historyTable"] = $historyTableName ." as h";
          
          $shift= explode(" ",$fromdate); 
          $shiftto= explode(" ",$enddatetime); 
          $shift1=explode(":",$shift[1]);
          $shiftto1=explode(":",$shiftto[1]);
          
          $shifttime=$shift1[0].":".$shift1[1]." - ".$shiftto1[0].":".$shiftto1[1];
          $reportdate = $shift[0];
          $daychange =$shift1[0].":".$shift1[1];
          
          $d1 = $d2 = null;
          
          $d1 = date_create($fromdate);
          $d1 = date_format($d1, "Y-m-d H:i:s");
          
          $d2 = date_create($enddatetime);
          $d2 = date_format($d2, "Y-m-d H:i:s");
           
            $idle = strtotime($d2) - strtotime($d1); 
          
            $shiftwiseReportList = $this->reportsgroup_db->getshiftwisedistancereport($db);
            //print_r($shiftwiseReportList);
                $shiftCnt = count($shiftwiseReportList);
          if ($shiftwiseReportList != null && $shiftCnt > 0) {
                      
               for($unit=0;$unit<$shiftCnt;$unit++){
                
                $con1pojo = $shiftwiseReportList[$unit]; 
                
                if($unit==0){
                            $Pre_distance = floatval($con1pojo->dist);
                         }
               if($con1pojo->statusid == "1")
                   {
                             
                         if($ignOn == 0){
                          $f1= 0.0;
                          $Cur_distance  = floatval($con1pojo->dist);
                                      $reporttimeunix =intval($con1pojo->reporttime);
                                      if($Pre_distance <= $Cur_distance)
                                 {
                                   $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                   $Pre_distance = $Cur_distance;
                                   $prereporttimeunix = $reporttimeunix ;
                                 
                                   
                                  }else if($Pre_distance > $Cur_distance){
                                  // dist = dist + $Cur_distance;
                                   $Pre_distance = $Cur_distance ;
                                   $prereporttimeunix = $reporttimeunix ;
                                     
                                 }
                       
                           $ignOn++;
                                      
                         }else if($ignOn == 1)
                         {
                            $f1= 0.0;
                            $Cur_distance  = floatval($con1pojo->dist);
                        
                                      $reporttimeunix =intval($con1pojo->reporttime);
                                      if($Pre_distance <= $Cur_distance)
                                   {
                                     $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                     $Pre_distance = $Cur_distance;
                                     $prereporttimeunix = $reporttimeunix ;
                                   
                                     
                                    }else if($Pre_distance > $Cur_distance){
                                    // dist = dist + $Cur_distance;
                                     $Pre_distance = $Cur_distance ;
                                     $prereporttimeunix = $reporttimeunix ;
                                       
                                   }
                         
                        
                                     
                                      
                                      
                                 }
                         if($unit==0){
                             $shiftstarttime = $con1pojo->datetime;
                             $startunixtime = $con1pojo->unixtime;
                           }
                         else if($unit==($shiftCnt-1)){
                           $shiftendtime = $con1pojo->datetime;
                           $endunixtime = $con1pojo->unixtime;
                         }
                         
                                  
                           }
                    else if($unit!=0 && $con1pojo->statusid == "0") 
                     {
                         $unit_distance  = $con1pojo->dist;
                         $Cur_distance  = floatval($con1pojo->dist);
                         $reporttimeunix =  intval($con1pojo->reporttime);
                   $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                                 $workingtime = $workingtime + $workinghours;
                                
                         if($Pre_distance <= $Cur_distance)
                               {
                                 $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                 $Pre_distance = $Cur_distance;
                                 $prereporttimeunix = $reporttimeunix ;
                               
                                 
                                }else if($Pre_distance > $Cur_distance){
                                // dist = dist + $Cur_distance;
                                 $Pre_distance = $Cur_distance ;
                                 $prereporttimeunix = $reporttimeunix ;
                                   
                               }
                        
                                
                                 $ignOn = 0;
                                 if($unit==0){
                             $shiftstarttime = $con1pojo->datetime;
                             $startunixtime = $con1pojo->unixtime;
                           }
                         else if($unit==($shiftCnt-1)){
                           $shiftendtime = $con1pojo->datetime;
                           $endunixtime = $con1pojo->unixtime;
                         }
                                
                                
                               
                           }  
                   else
                   { 
            
                      if($unit==0){
                        
                      $Pre_distance = floatval($con1pojo->dist);
                                  $reporttimeunix = $reporttimeunix +intval($con1pojo->reporttime);
                                  $prereporttimeunix = $reporttimeunix ;
                                  $workinghours = intval($con1pojo->reporttime) - (int)(strtotime($d1));
                      $workingtime = $workingtime + $workinghours;
                      $shiftstarttime = $con1pojo->datetime;
                        $startunixtime = $con1pojo->unixtime;
                        
                       }
                        else if($unit==($shiftCnt-1)){
                         
                        $unit_distance  = $con1pojo->dist;
                        $Cur_distance  = floatval($con1pojo->dist);
                          $reporttimeunix =  intval($con1pojo->reporttime);
                          $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                          $workingtime = $workingtime + $workinghours;
                          $workinghours = (int)(strtotime($d2))  - intval($con1pojo->reporttime) ;
                          $workingtime = $workingtime + $workinghours;
                          $shiftendtime = $con1pojo->datetime;
                          $endunixtime = $con1pojo->unixtime;
                           if($Pre_distance <= $Cur_distance)
                                   {
                                     $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                     $Pre_distance = $Cur_distance;
                                     $prereporttimeunix = $reporttimeunix ;
                                    
                                     
                                   }else if($Pre_distance > $Cur_distance){
                                   // dist = dist + $Cur_distance;
                                     $Pre_distance = $Cur_distance ;
                                     $prereporttimeunix = $reporttimeunix ;                                      
                                   }
                      
                  
                                 }else
                                 {
                                   
                                    $Cur_distance  = floatval($con1pojo->dist);
                                          $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                          $workingtime = $workingtime + $workinghours;
                           
                          $reporttimeunix =intval($con1pojo->reporttime);
                          
                                      
                                         
                                        // checking with Prevoius distance value if it is lessthan adding the total distance = (current distance - Prev distance); 
                                       
                                        if($Pre_distance <= $Cur_distance)
                                         {
                                           
                                             $dist = floatval(dist + ($Cur_distance-$Pre_distance));
                                             $Pre_distance = $Cur_distance;
                                             $prereporttimeunix = $reporttimeunix ;
                                            
                                           
                                         }else if($Pre_distance > $Cur_distance){
                                             
                                            // dist = dist + $Cur_distance;
                                             $Pre_distance = $Cur_distance;
                                         
                                            
                                              $prereporttimeunix = $reporttimeunix ;
                                            
                                         }
                             
                                 
                                 
                                 }
                      
                   }
                      
                   
                 }
             
            if($workingtime>$idle)
              {
                if($startunixtime!=0 && $endunixtime!=0)
                {
                  $workingtime = $endunixtime - $startunixtime;
                }else if($startunixtime!=0 && $endunixtime==0){
                    $workingtime = $idle;
                }
              }
              
            if($workingtime!=0 && $workingtime<=idle && $workingtime>0){
              $hours = (int)($workingtime / 3600);
              $remainder = (int)($workingtime % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $TotalHours1 = $disHour.":".$disMinu.":".$disSec;
        
                     $idlehours = intval($idle - $workingtime) ;
                     
                   
            }else{
              $TotalHours1= "00:00:00";
              
            }
            
               if($idlehours!=0 && $idlehours>0){
                 $hours = (int)($idlehours / 3600);
              $remainder = (int)($idlehours % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $idleHours2 = $disHour.":".$disMinu.":".$disSec;
              
                         
               }else{
                   $idleHours2 ="00:00:00";
               }
              $totaldist = $totaldist + $dist;
              $daytotal = $daytotal+$dist;
              $dayworktime = $dayworktime+$workingtime;
              
              $totalworktime = $totalworktime+$workingtime;
              $totaligntime = $totaligntime+$idlehours;
              $temppojo["reportdate"] = $reportdate;
              $temppojo["shifttime"] = $shifttime;
              $temppojo["dist"] = number_format((float)$dist, 1, '.', '');
            $temppojo["TotalHours"] = $TotalHours1; 
              $temppojo["idleHours"] = $idleHours2;
              $temppojo["unitName"] = $unitName;
            $temppojo["groupName"] = $groupName;
            $temppojo["shiftstarttime"] = $shiftstarttime;
            $temppojo["shiftendtime"] = $shiftendtime;
            $temppojo["vehtype"] = $vehtype;
            $temppojo["contractor"] = $contractor;
              
              if($daychange == "22:00")
            {
              $temppojo["tdist"] = number_format((float)$daytotal, 1, '.', '');
              
              $daytotal =0.0;
              if($dayworktime!=0)
              {
                $hours = (int)($dayworktime / 3600);
                $remainder = (int)($dayworktime % 3600);
                $minutes = (int) ($remainder / 60);
                $seconds = (int) ($remainder % 60);
        
                $disHour = ($hours < 10 ? "0" : "") . $hours;
                $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
                $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
        
                $DayTotal = $disHour.":".$disMinu.":".$disSec;
                
                $temppojo["tworkinghours"] = $DayTotal;
                      
              }else
              {
                $temppojo["tworkinghours"] = "00:00:00";
              }
              $dayworktime=0;
            }else{
              $temppojo["tdist"] = "";
              $temppojo["tworkinghours"] = "";
              
            }
             
              $shiftwiseReportFinalList[] = (object)$temppojo;
              
    
                  }else
                  {
                    
                    
                      $idlehours = $idle ;
              $hours = (int)($idlehours / 3600);
              $remainder = (int)($idlehours % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $idleHours2 = $disHour.":".$disMinu.":".$disSec;
            
                   $totaldist = $totaldist + 0.0;
             $totalworktime = $totalworktime+0;
             $daytotal =$daytotal+$dist;
             $totaligntime = $totaligntime+$idlehours;
             
             $temppojo["reportdate"] = $reportdate;
              $temppojo["shifttime"] = $shifttime;
              $temppojo["dist"] = "0.0";
            $temppojo["TotalHours"] = "00:00:00"; 
              $temppojo["idleHours"] = $idleHours2;
              $temppojo["unitName"] = $unitName;
            $temppojo["groupName"] = $groupName;
            $temppojo["shiftstarttime"] = $shiftstarttime;
            $temppojo["shiftendtime"] = $shiftendtime;
            $temppojo["vehtype"] = $vehtype;
            $temppojo["contractor"] = $contractor;
             
               if($daychange == "22:00")
            {
              $temppojo["tdist"] = number_format((float)$daytotal, 1, '.', '');
              
                $daytotal =0.0;
                if($dayworktime!=0)
                {
                  $hours = (int)($dayworktime / 3600);
                  $remainder = (int)($dayworktime % 3600);
                  $minutes = (int) ($remainder / 60);
                  $seconds = (int) ($remainder % 60);
          
                  $disHour = ($hours < 10 ? "0" : "") . $hours;
                  $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
                  $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
          
                  $DayTotal = $disHour.":".$disMinu.":".$disSec;
                         $temppojo["tworkinghours"] = $DayTotal;
                        
                }else
                {
                  $temppojo["tworkinghours"] = "00:00:00";
                }
                $dayworktime=0;
                
              }else{
                $temppojo["tdist"] = "";
                $temppojo["tworkinghours"] = "";
                
              }
              $shiftwiseReportFinalList[] = (object)$temppojo;
                  }
                   
                  $fromdate = $enddatetime;
                  $enddatetime = date("Y-m-d H:i:s",strtotime("+8hours",strtotime($enddatetime)));
                  //echo "from=".$fromdate."====".$enddatetime."<br>";
          /* Calendar cal1 = Calendar.getInstance();  
           cal1.setTime(dateFormat.parse(enddatetime));  
           cal1.add(Calendar.HOUR_OF_DAY, 8);
           enddatetime = dateFormat.format(cal1.getTime());*/
        }
        
        $fromdate = $fromdatee;
        $todate = $todatee;
        $enddatetime = $enddatetimee;
     }
     $result = $shiftwiseReportFinalList;
     if (count($shiftwiseReportFinalList) != 0) {
       if($type == "json"){
          echo json_encode($result);  
      }
      else{
        $this->get3ShiftwiseExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $checkAuto, $companyname, "GroupShiftwiseReport", 'Shiftwise (3 Shifts) Report');
      }
     }
     else{
      echo "[]";
     }
    }
    
  public function get3ShiftwiseExcelreport($dataExport, $start_date, $end_date, $checkAuto, $companyname, $filename, $title){
        $shiftwiseReportFinalList = $dataExport;
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($title);

            $headertext = $title;
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            
         
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O");
            
            
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $this->excel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle("N")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $z = 1;
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Shiftwise Distance Run From ".$start_date." to ".$end_date );
            $z++; $z++; 
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
      if($checkAuto == "1"){
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :ALL");
        }
        else{
          $this->excel->getActiveSheet()->setCellValue('B'.$z, "Group Name :".$dataExport[0]->groupName );
        }
           
            $z++;$z++;  
            //change the font size
            $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->applyFromArray($this->data['styleArray']);
    
      if ($companyname == "Jindal Steel Works" || $companyname == "Jindal Steel"){
    
        //set cell A1 content with some text
          $this->excel->getActiveSheet()->setCellValue('B'.$z, 'GroupName');
            $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Contractor');             
            $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Vehicle Type');             
            $this->excel->getActiveSheet()->setCellValue('E'.$z, 'UnitName');             
            $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Date');
            $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Shift Time');             
            $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Distance(Kms)');
            $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Start time');             
            $this->excel->getActiveSheet()->setCellValue('J'.$z, 'End time');             
            $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Working Hours');              
            $this->excel->getActiveSheet()->setCellValue('L'.$z, 'IgnOff hours ');
            $this->excel->getActiveSheet()->setCellValue('M'.$z, 'Total distance (Kms');              
            $this->excel->getActiveSheet()->setCellValue('N'.$z, 'Total Working Hours');
      }
      else{
        //set cell A1 content with some text
          $this->excel->getActiveSheet()->setCellValue('B'.$z, 'GroupName');            
            $this->excel->getActiveSheet()->setCellValue('C'.$z, 'UnitName');             
            $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Date');
            $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Shift Time');             
            $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Distance(Kms)');
            $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Start time');             
            $this->excel->getActiveSheet()->setCellValue('H'.$z, 'End time');             
            $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Working Hours');              
            $this->excel->getActiveSheet()->setCellValue('J'.$z, 'IgnOff hours ');
            $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Total distance (Kms');              
            $this->excel->getActiveSheet()->setCellValue('L'.$z, 'Total Working Hours');
      }
              
        $total = $sum = 0;
          $j = 0;$i=0;
          $cnt = count($dataExport);
            foreach ($dataExport as $dt){$z++; 
              $range = 'A'.$z.':'.'O'.$z;
            $this->excel->getActiveSheet()
                ->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

               
              if($i==0){
           $group= $dt->groupName;
        }
        else if($dt->groupName == $dataExport[$i-1]->groupName)
        {
          $group = "";
        }else
        {
          $group= $dt->groupName;
        
        }
        //echo "group===".$group."<br>";
              if($i==0){
           $unitname= $dt->unitName;
        }else if($dt->unitName == $shiftwiseReportFinalList[$i-1]->unitName)
          {
            $unitname = "";
          }else
          {
            $unitname= $dt->unitName;
          }
        
              if($i==0){
           $reportdate= explode("-",$dt->reportdate);
           $reportdate = $reportdate[2]."-".$reportdate[1]."-".$reportdate[0];
        }else
        {
          if($dt->reportdate == $shiftwiseReportFinalList[$i-1]->reportdate)
          {
            $reportdate = "";
          }else
          {
            if($dt->reportdate != ""){
              $reportdate= explode("-",$dt->reportdate);
                $reportdate = $reportdate[2]."-".$reportdate[1]."-".$reportdate[0];
            }else{
              $reportdate = $dt->reportdate;
            }
          }
        }
        
        $this->excel->getActiveSheet()->setCellValue('B' . $z, $group);   
        if ($companyname == "Jindal Steel Works" || $companyname == "Jindal Steel"){
          $this->excel->getActiveSheet()->setCellValue('C'.$z, $dt->contractor);              
              $this->excel->getActiveSheet()->setCellValue('D'.$z, $dt->vehtype);             
              $this->excel->getActiveSheet()->setCellValue('E'.$z, $unitname);              
              $this->excel->getActiveSheet()->setCellValue('F'.$z, $reportdate);
              $this->excel->getActiveSheet()->setCellValue('G'.$z, $dt->shifttime);             
              $this->excel->getActiveSheet()->setCellValue('H'.$z, $dt->dist);
              $this->excel->getActiveSheet()->setCellValue('I'.$z, $dt->shiftstarttime);              
              $this->excel->getActiveSheet()->setCellValue('J'.$z, $dt->shiftendtime);              
              $this->excel->getActiveSheet()->setCellValue('K'.$z, $dt->TotalHours);              
              $this->excel->getActiveSheet()->setCellValue('L'.$z, $dt->idleHours);
              $this->excel->getActiveSheet()->setCellValue('M'.$z, $dt->tdist);             
              $this->excel->getActiveSheet()->setCellValue('N'.$z, $dt->tworkinghours);
        }
        else{             
              $this->excel->getActiveSheet()->setCellValue('C'.$z, $unitname);              
              $this->excel->getActiveSheet()->setCellValue('D'.$z, $reportdate);
              $this->excel->getActiveSheet()->setCellValue('E'.$z, $dt->shifttime);             
              $this->excel->getActiveSheet()->setCellValue('F'.$z, $dt->dist);
              $this->excel->getActiveSheet()->setCellValue('G'.$z, $dt->shiftstarttime);              
              $this->excel->getActiveSheet()->setCellValue('H'.$z, $dt->shiftendtime);              
              $this->excel->getActiveSheet()->setCellValue('I'.$z, $dt->TotalHours);              
              $this->excel->getActiveSheet()->setCellValue('J'.$z, $dt->idleHours);
              $this->excel->getActiveSheet()->setCellValue('K'.$z, $dt->tdist);             
              $this->excel->getActiveSheet()->setCellValue('L'.$z, $dt->tworkinghours);
        }    
          
              $i++;
            }
            
      $d = new DateTime();
      
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().$filename.'.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
  function get2Shiftwisedata(){
      $unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
      $group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
      $checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
      $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
      $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
      $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
      $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
      $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
      $groupname = trim(preg_replace('!\s+!', ' ',$this->input->get('groupname')));
      //print_r($_GET);
      $orgstart_date= $start_date;
      $orgend_date= $end_date;
      $start = explode("-", $start_date);     
      $start_date = $start[2]."-".$start[1]."-".$start[0];
      $start = explode("-", $end_date);     
      $end_date = $start[2]."-".$start[1]."-".$start[0];
      $start_datetime = $start_date." ".$start_time;
      $end_datetime = $end_date." ".$end_time;
      
      $fromdate = $reportfrom = $start_datetime;
    $todate = $reportto = $end_datetime;
    $GroupName = $groupname;
      $fromdatee = $fromdate;
    $todatee = $todate;
    
    $shiftwiseReportFinalList = array();
    
    
    $shift1start ="08:00:00";
    $shift1end ="20:00:00";
    $shift2start ="20:00:01";
    $shift2end ="08:00:00";
    $shift4start ="00:00:00";
    $endtime = $enddatetime = $enddatetimee = $vehtype = $contractor = $companyname = "";
    $unitName =  $groupName = $unitnumbers = null;
    
    $str= explode(" ", $fromdate); 
    $fromdate1 = $str[0];
    $fromtime = $str[1];
    $totaldist = $daytotal = 0.0;
    $totalworktime = $totaligntime= $dayworktime = 0;   
    
    if(strtotime($fromtime) >= strtotime($shift1start) && strtotime($fromtime)<= strtotime($shift1end))
    {
      $endtime = $shift1end;
    }
    else if(strtotime($fromtime) >= strtotime($shift2start) && strtotime($fromtime) <= strtotime($shift2end))
    {
      $endtime = $shift2end;
    }
    else if(strtotime($fromtime) >= strtotime($shift4start) && strtotime($fromtime) <= strtotime($shift2end))
    {
      $endtime = $shift2end;
    }
    
    $enddatetime = $fromdate1." ".$endtime;
    
    $enddatetimee = $enddatetime;
      
      $db=array(
          'group'=>$group,
          'checkGroup'=>$checkAuto,
          'start_date'=>$start_datetime,
          'end_date'=>$end_datetime,
          'detail'=>$this->data['detail']         
        );
        
    $unitnumbers = $this->reportsgroup_db->getgroupunits($db);
      $cnt = count($unitnumbers);
      
      for($u=0;$u<=($cnt-1);$u++)
     {
        $odoreportPojo = $unitnumbers[$u];
        $unitno = $odoreportPojo->unitno;
      $unitName = $odoreportPojo->unitname;
      $groupName = $odoreportPojo->groupname;
      
      $vehtype = $odoreportPojo->vehtype;
      $contractor = $odoreportPojo->contractor;
        $companyname = $odoreportPojo->companyname;
      $db['uid'] = $unitno;
      //echo $fromdate."---".$todate."<br>";
        while(strtotime($fromdate) < strtotime($todate))
        {
          $ignOn = 0 ;
          $dist = 0.00;
          $f3= $Pre_distance = $Cur_distance = $f1=  $f2= 0.0;
          $workingtime =  $reporttimeunix =  $prereporttimeunix =  $workinghours =  $idletimeunix = $idlehours = $startunixtime =  $endunixtime = 0;
          $unit_distance = $idleHours2 = $TotalHours1 = $DayTotal =null;
          
          $shiftstarttime= $shiftendtime="";
          
          $temppojo = array();
          
          if(strtotime($todate) <= strtotime($enddatetime))
          {
            $enddatetime = $todate;
          }
          if(count($enddatetime) == 11)
          {
            $enddatetime = $todate; 
          }
          
          $db["start_date"] = $fromdate;
          $db["end_date"] = $enddatetime;
          $historyTableName = $this->home_db->getHistoryTable($fromdate, $enddatetime, $unitno);
          $db["historyTable"] = $historyTableName ." as h";
          
          $shift= explode(" ",$fromdate); 
          $shiftto= explode(" ",$enddatetime); 
          $shift1=explode(":",$shift[1]);
          $shiftto1=explode(":",$shiftto[1]);
          
          $shifttime=$shift1[0].":".$shift1[1]." - ".$shiftto1[0].":".$shiftto1[1];
          $reportdate = $shift[0];
          $daychange =$shift1[0].":".$shift1[1];
          
          $d1 = $d2 = null;
          
          $d1 = date_create($fromdate);
          $d1 = date_format($d1, "Y-m-d H:i:s");
          
          $d2 = date_create($enddatetime);
          $d2 = date_format($d2, "Y-m-d H:i:s");
           
            $idle = strtotime($d2) - strtotime($d1); 
          
            $shiftwiseReportList = $this->reportsgroup_db->getshiftwisedistancereport($db);
            //print_r($shiftwiseReportList);
                $shiftCnt = count($shiftwiseReportList);
          if ($shiftwiseReportList != null && $shiftCnt > 0) {
                      
               for($unit=0;$unit<$shiftCnt;$unit++){
                
                $con1pojo = $shiftwiseReportList[$unit]; 
                
                if($unit==0){
                            $Pre_distance = floatval($con1pojo->dist);
                         }
               if($con1pojo->statusid == "1")
                   {
                             
                         if($ignOn == 0){
                          $f1= 0.0;
                          $Cur_distance  = floatval($con1pojo->dist);
                                      $reporttimeunix =intval($con1pojo->reporttime);
                                      if($Pre_distance <= $Cur_distance)
                                 {
                                   $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                   $Pre_distance = $Cur_distance;
                                   $prereporttimeunix = $reporttimeunix ;
                                 
                                   
                                  }else if($Pre_distance > $Cur_distance){
                                  // dist = dist + $Cur_distance;
                                   $Pre_distance = $Cur_distance ;
                                   $prereporttimeunix = $reporttimeunix ;
                                     
                                 }
                       
                           $ignOn++;
                                      
                         }else if($ignOn == 1)
                         {
                            $f1= 0.0;
                            $Cur_distance  = floatval($con1pojo->dist);
                        
                                      $reporttimeunix =intval($con1pojo->reporttime);
                                      if($Pre_distance <= $Cur_distance)
                                   {
                                     $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                     $Pre_distance = $Cur_distance;
                                     $prereporttimeunix = $reporttimeunix ;
                                   
                                     
                                    }else if($Pre_distance > $Cur_distance){
                                    // dist = dist + $Cur_distance;
                                     $Pre_distance = $Cur_distance ;
                                     $prereporttimeunix = $reporttimeunix ;
                                       
                                   }
                         
                        
                                     
                                      
                                      
                                 }
                         if($unit==0){
                             $shiftstarttime = $con1pojo->datetime;
                             $startunixtime = $con1pojo->unixtime;
                             $Pre_distance = floatval($con1pojo->dist);
                           }
                         else if($unit==($shiftCnt-1)){
                           $shiftendtime = $con1pojo->datetime;
                           $endunixtime = $con1pojo->unixtime;
                         }
                         
                                  
                           }
                    else if($unit!=0 && $con1pojo->statusid == "0") 
                     {
                         $unit_distance  = $con1pojo->dist;
                         $Cur_distance  = floatval($con1pojo->dist);
                         $reporttimeunix =  intval($con1pojo->reporttime);
                   $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                                 $workingtime = $workingtime + $workinghours;
                                
                         if($Pre_distance <= $Cur_distance)
                               {
                                 $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                 $Pre_distance = $Cur_distance;
                                 $prereporttimeunix = $reporttimeunix ;
                               
                                 
                                }else if($Pre_distance > $Cur_distance){
                                // dist = dist + $Cur_distance;
                                 $Pre_distance = $Cur_distance ;
                                 $prereporttimeunix = $reporttimeunix ;
                                   
                               }
                        
                                
                                 $ignOn = 0;
                                 if($unit==0){
                             $shiftstarttime = $con1pojo->datetime;
                             $startunixtime = $con1pojo->unixtime;
                           }
                         else if($unit==($shiftCnt-1)){
                           $shiftendtime = $con1pojo->datetime;
                           $endunixtime = $con1pojo->unixtime;
                         }
                                
                                
                               
                           }  
                   else
                   { 
            
                      if($unit==0){
                        
                      $Pre_distance = floatval($con1pojo->dist);
                                  $reporttimeunix = $reporttimeunix +intval($con1pojo->reporttime);
                                  $prereporttimeunix = $reporttimeunix ;
                                  $workinghours = intval($con1pojo->reporttime) - (int)(strtotime($d1));
                      $workingtime = $workingtime + $workinghours;
                      $shiftstarttime = $con1pojo->datetime;
                        $startunixtime = $con1pojo->unixtime;
                        
                       }
                        else if($unit==($shiftCnt-1)){
                         
                        $unit_distance  = $con1pojo->dist;
                        $Cur_distance  = floatval($con1pojo->dist);
                          $reporttimeunix =  intval($con1pojo->reporttime);
                          $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                          $workingtime = $workingtime + $workinghours;
                          $workinghours = (int)(strtotime($d2))  - intval($con1pojo->reporttime) ;
                          $workingtime = $workingtime + $workinghours;
                          $shiftendtime = $con1pojo->datetime;
                          $endunixtime = $con1pojo->unixtime;
                           if($Pre_distance <= $Cur_distance)
                                   {
                                     $dist = floatval($dist + ($Cur_distance-$Pre_distance));
                                     $Pre_distance = $Cur_distance;
                                     $prereporttimeunix = $reporttimeunix ;
                                    
                                     
                                   }else if($Pre_distance > $Cur_distance){
                                   // dist = dist + $Cur_distance;
                                     $Pre_distance = $Cur_distance ;
                                     $prereporttimeunix = $reporttimeunix ;                                      
                                   }
                      
                  
                                 }else
                                 {
                                   
                                    $Cur_distance  = floatval($con1pojo->dist);
                                          $workinghours = intval($con1pojo->reporttime) - $prereporttimeunix ;
                          $workingtime = $workingtime + $workinghours;
                           
                          $reporttimeunix =intval($con1pojo->reporttime);
                          
                                      
                                         
                                        // checking with Prevoius distance value if it is lessthan adding the total distance = (current distance - Prev distance); 
                                       
                                        if($Pre_distance <= $Cur_distance)
                                         {
                                           
                                             $dist = floatval(dist + ($Cur_distance-$Pre_distance));
                                             $Pre_distance = $Cur_distance;
                                             $prereporttimeunix = $reporttimeunix ;
                                            
                                           
                                         }else if($Pre_distance > $Cur_distance){
                                             
                                            // dist = dist + $Cur_distance;
                                             $Pre_distance = $Cur_distance;
                                         
                                            
                                              $prereporttimeunix = $reporttimeunix ;
                                            
                                         }
                             
                                 
                                 
                                 }
                      
                   }
                      
                   
                 }
             
            if($workingtime>$idle)
              {
                if($startunixtime!=0 && $endunixtime!=0)
                {
                  $workingtime = $endunixtime - $startunixtime;
                }else if($startunixtime!=0 && $endunixtime==0){
                    $workingtime = $idle;
                }
              }
              
            if($workingtime!=0 && $workingtime<=idle && $workingtime>0){
              $hours = (int)($workingtime / 3600);
              $remainder = (int)($workingtime % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $TotalHours1 = $disHour.":".$disMinu.":".$disSec;
        
                     $idlehours = intval($idle - $workingtime) ;
                     
                   
            }else{
              $TotalHours1= "00:00:00";
              
            }
            
               if($idlehours!=0 && $idlehours>0){
                 $hours = (int)($idlehours / 3600);
              $remainder = (int)($idlehours % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $idleHours2 = $disHour.":".$disMinu.":".$disSec;
              
                         
               }else{
                   $idleHours2 ="00:00:00";
               }
              $totaldist = $totaldist + $dist;
              $daytotal = $daytotal+$dist;
              $dayworktime = $dayworktime+$workingtime;
              
              $totalworktime = $totalworktime+$workingtime;
              $totaligntime = $totaligntime+$idlehours;
              $temppojo["reportdate"] = $reportdate;
              $temppojo["shifttime"] = $shifttime;
              $temppojo["dist"] = number_format((float)$dist, 1, '.', '');
            $temppojo["TotalHours"] = $TotalHours1; 
              $temppojo["idleHours"] = $idleHours2;
              $temppojo["unitName"] = $unitName;
            $temppojo["groupName"] = $groupName;
            $temppojo["shiftstarttime"] = $shiftstarttime;
            $temppojo["shiftendtime"] = $shiftendtime;
            $temppojo["vehtype"] = $vehtype;
            $temppojo["contractor"] = $contractor;
              
              if($daychange == "20:00")
            {
              $temppojo["tdist"] = number_format((float)$daytotal, 1, '.', '');
              
              $daytotal =0.0;
              if($dayworktime!=0)
              {
                $hours = (int)($dayworktime / 3600);
                $remainder = (int)($dayworktime % 3600);
                $minutes = (int) ($remainder / 60);
                $seconds = (int) ($remainder % 60);
        
                $disHour = ($hours < 10 ? "0" : "") . $hours;
                $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
                $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
        
                $DayTotal = $disHour.":".$disMinu.":".$disSec;
                
                $temppojo["tworkinghours"] = $DayTotal;
                      
              }else
              {
                $temppojo["tworkinghours"] = "00:00:00";
              }
              $dayworktime=0;
            }else{
              $temppojo["tdist"] = "";
              $temppojo["tworkinghours"] = "";
              
            }
             
              $shiftwiseReportFinalList[] = (object)$temppojo;
              
    
                  }else
                  {
                    
                    
                      $idlehours = $idle ;
              $hours = (int)($idlehours / 3600);
              $remainder = (int)($idlehours % 3600);
              $minutes = (int) ($remainder / 60);
              $seconds = (int) ($remainder % 60);
      
              $disHour = ($hours < 10 ? "0" : "") . $hours;
              $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
              $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
      
              $idleHours2 = $disHour.":".$disMinu.":".$disSec;
            
                   $totaldist = $totaldist + 0.0;
             $totalworktime = $totalworktime+0;
             $daytotal =$daytotal+$dist;
             $totaligntime = $totaligntime+$idlehours;
             
             $temppojo["reportdate"] = $reportdate;
              $temppojo["shifttime"] = $shifttime;
              $temppojo["dist"] = "0.0";
            $temppojo["TotalHours"] = "00:00:00"; 
              $temppojo["idleHours"] = $idleHours2;
              $temppojo["unitName"] = $unitName;
            $temppojo["groupName"] = $groupName;
            $temppojo["shiftstarttime"] = $shiftstarttime;
            $temppojo["shiftendtime"] = $shiftendtime;
            $temppojo["vehtype"] = $vehtype;
            $temppojo["contractor"] = $contractor;
             
               if($daychange == "20:00")
            {
              $temppojo["tdist"] = number_format((float)$daytotal, 1, '.', '');
              
                $daytotal =0.0;
                if($dayworktime!=0)
                {
                  $hours = (int)($dayworktime / 3600);
                  $remainder = (int)($dayworktime % 3600);
                  $minutes = (int) ($remainder / 60);
                  $seconds = (int) ($remainder % 60);
          
                  $disHour = ($hours < 10 ? "0" : "") . $hours;
                  $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
                  $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
          
                  $DayTotal = $disHour.":".$disMinu.":".$disSec;
                         $temppojo["tworkinghours"] = $DayTotal;
                        
                }else
                {
                  $temppojo["tworkinghours"] = "00:00:00";
                }
                $dayworktime=0;
                
              }else{
                $temppojo["tdist"] = "";
                $temppojo["tworkinghours"] = "";
                
              }
              $shiftwiseReportFinalList[] = (object)$temppojo;
                  }
                   
                  $fromdate = $enddatetime;
                  $enddatetime = date("Y-m-d H:i:s",strtotime("+12hours",strtotime($enddatetime)));
                  //echo "from=".$fromdate."====".$enddatetime."<br>";
          /* Calendar cal1 = Calendar.getInstance();  
           cal1.setTime(dateFormat.parse(enddatetime));  
           cal1.add(Calendar.HOUR_OF_DAY, 8);
           enddatetime = dateFormat.format(cal1.getTime());*/
        }
        
        $fromdate = $fromdatee;
        $todate = $todatee;
        $enddatetime = $enddatetimee;
     }
     $result = $shiftwiseReportFinalList;
     if (count($shiftwiseReportFinalList) != 0) {
       if($type == "json"){
          echo json_encode($result);  
      }
      else{
        $this->get3ShiftwiseExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $checkAuto, $companyname, "TwoShiftwiseReport", "Shiftwise DistanceRun for Group");
      }
     }
     else{
      echo "[]";
     }
    }
    
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */
