<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_data extends CI_Controller {

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
        $this->load->model('reports_db');
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
		
		error_reporting(E_ALL);
ini_set('display_errors', '1');
    }

    
    function getConsolidatedata(){
    	//$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." 00:00:00";
    	$end_datetime = $end_date." 23:59:59";
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime      			
    	);
    	$result = $this->reports_db->gettable_consolidate($db);
    	$workingtime = $idletime = $totalignoff = $prev_fill = $fuel = $total_fill = $total_loss = $total = $utz = $totalidlehours = $totaldist = 0;
    	$count = count($result);
    	$totaldist2 = $totaldist = 0.0;$j = 1;
    	$totalHours = $idleHours = $ignon = $ignoff = "";
    	
    	
    	foreach ($result as $res){
    		$res->ignon = substr($res->ignon, 0, 10) == "1970-01-01" ? "N/A" : $res->ignon;
			$res->ignoff = substr($res->ignoff, 0, 10) == "1970-01-01" ? "N/A" : $res->ignoff;
			
			$workingtime = $workingtime + $res->workinghours;
			$idletime = $idletime + $res->idlehours;
			$reportdate = $res->reportdate;
			$reportfromdate = $reportdate . " " . "00:00:00";
			$reporttodate = $reportdate . " " . "23:59:59";
			
			$total_fuel = $total_theft = 0;
			$fuelfill = "NA";
			$fuelfillFinalList = array();
			
			$historyTableName = $this->home_db->getHistoryTable($reportfromdate, $reporttodate, $unit);
			if ($result[0]->fuelwidth != "N/A") {
				$db=array(
		    			'unitnumber'=>$unit,
				    	'start_date'=>$start_datetime,
				    	'end_date'=>$end_datetime,
						'detail'=>$this->data['detail'],
						'historyTable'=>$historyTableName." as h"      			
		    		);
				$fuelfillReportList = $this->reports_db->getFuelFillHtmlReport($db);
							
				if($prev_fill>0 && count($fuelfillReportList)>0)
				{
					 
	    			 $fuelfillFinalList[] = array("Fuelfill" =>$prev_fill, "Fuelvar" =>$fuelfillReportList[0]->fuelvar, "Fueldrop" =>$fuelfillReportList[0]->fueldrop);					
				}
				$cnt = count($fuelfillReportList);
				for ($j1 = 0; $j1 <= ($cnt - 1); $j1++) {
					
					$fuelfillreportPojo = $fuelfillReportList[$j1];
			    		
		    		 if(intval($fuelfillreportPojo->fuelfill) != 0){
			    		 $fuel = $fuel + $fuelfillreportPojo->fuelfill;
			    		 if(intval($fuelfillreportPojo->status) != 0){
			    			  if($j==10)
				    		 {
				    			 $fuel = $fuel/10;
				    			 if($fuel!=0){
					    			 $fuelfillFinalList[] = array("Fuelfill" =>$fuel, "Fuelvar" =>$fuelfillreportPojo->fuelvar, "Fueldrop" =>$fuelfillreportPojo->fueldrop);			    			
				    			 }
				    			 $fuel =0;
				    			 $j=1;
				    		 }else{
					    		
					    		 $j++;
				    		 }
			    		 }
			    		 else if(intval($fuelfillreportPojo->status) == 0)
			    		 {
			    			 
			    		   if($fuel!=0){
			    		     $fuel= $fuel/$j;
			    			 $fuelfillFinalList[] = array("Fuelfill" =>$fuel, "Fuelvar" =>$fuelfillreportPojo->fuelvar, "Fueldrop" =>$fuelfillreportPojo->fueldrop);
			    		   }
			    			 $fuel=0;
			    			 $j=1;
			    		 }
		    		 }
		    		 else if(intval($fuelfillreportPojo->fuelfill) == 0 && intval($fuelfillreportPojo->status) == 0 )
		    		 {
		    			
		    			 if($fuel != 0 && $j>5){
			    			 $fuel= $fuel/($j-1);
			    			 $fuelfillFinalList[] = array("Fuelfill" =>$fuel, "Fuelvar" =>$fuelfillreportPojo->fuelvar, "Fueldrop" =>$fuelfillreportPojo->fueldrop);		    			
		    			 }
		    			 $fuel=0;
		    			 $j=1;
		    		 }
				}

				$cnt = count($fuelfillFinalList);
				for($fv=0; $fv<=($cnt-2); $fv++)
		    	 {		   
					$fuelfillreportPojo = $fuelfillFinalList[$fv];
					$fuelfillreportPojo1 = $fuelfillFinalList[$fv+1]; 
					if ($fuelfillreportPojo1["Fuelfill"] - $fuelfillreportPojo["Fuelfill"] > $fuelfillreportPojo["Fuelvar"])
					{
    		            $total_fuel = $total_fuel + ($fuelfillreportPojo1["Fuelfill"] - $fuelfillreportPojo["Fuelfill"]);
					}
    		        else if (($fuelfillreportPojo["Fuelfill"] - $fuelfillreportPojo1["Fuelfill"]) > $fuelfillreportPojo["Fueldrop"]) {
    		            $total_theft  = $total_theft + ($fuelfillreportPojo["Fuelfill"] - $fuelfillreportPojo1["Fuelfill"]);
					}
		    		$prev_fill = $fuelfillreportPojo1["Fuelfill"]; 			
        		 }
					    	
			}
			
    		if ($count > 0) {
				if ($result[0]->fuelwidth == "N/A") {
					$res->fuelfill = "N/A";
					$res->fueldrop = "N/A";
				} else {
					$res->fuelfill = $total_fuel;
					$res->fueldrop = $total_theft;
					$total_fill = $total_fill + $total_fuel;
					$total_loss = $total_loss + $total_theft;
				}
			} 
			else {
				$res->fuelfill = "N/A";
				$res->fueldrop = "N/A";
			}
			
    		if ($count > 1) {
					if ($workingtime != 0) {
						$hours = intval($workingtime / 3600); $remainder = intval($workingtime % 3600); $minutes = intval($remainder / 60); $seconds = intval($remainder % 60);
						$disHour = ($hours < 10 ? "0" : "") . $hours; 
						$disMinu = ($minutes < 10 ? "0" : "") . $minutes; 
						$disSec = ($seconds < 10 ? "0" : "") . $seconds;
						$totalHours = $disHour . ":" . $disMinu . ":" . $disSec;
					}
				}
				
				if ($idletime != 0) {
					$hours = intval($idletime / 3600); $remainder = intval($idletime % 3600); $minutes = intval($remainder / 60); $seconds = intval($remainder % 60);
					$disHour = ($hours < 10 ? "0" : "") . $hours; 
					$disMinu = ($minutes < 10 ? "0" : "") . $minutes; 
					$disSec = ($seconds < 10 ? "0" : "") . $seconds;
					$idleHours = $disHour . ":" . $disMinu . ":" . $disSec;
				}
				
				$totaldist2 = floatval($totaldist2) + floatval($res->dist);
				$aDouble = $totaldist2;
				$totaldist1 = str_replace(",","",number_format((float)$aDouble, 2, '.', ''));
				$res->t1dist = $totaldist1;
				$totalignoff = $totalignoff + $res->ignoffcount;
    	}
    	
    	if ($count > 1) { 
			$arr = array("unitname"=>"","ignon"=>"","fuelwidth"=>"N/A","ignoff"=>"","dist"=>"",
					"startloc"=>"","endloc"=>"","workinghours"=>"","idlehours"=>"","workinghour"=>"","idlehour"=>"",
					"ignoffcount"=>"","reportdate"=>"","startodo"=>"","endodo"=>"","highspeed"=>"","t1dist"=>"","fuelfill"=>"N/A","fueldrop"=>"N/A");
			$object = (object) $arr; 
			$result[$count] = $object;
			$result[$count]->fuelfill = $total_fill;
		    $result[$count]->dist = $totaldist1;
		    $result[$count]->ignoffcount = $totalignoff;
		    $result[$count]->workinghour = $totalHours;
		    $result[$count]->idlehour = $idleHours;
			
		}
		
		if($type == "json"){
			
			
    		echo json_encode($result);  
		}
		else{
			$this->getConsolidateExcelreport($result, $orgstart_date, $orgend_date);
		}
    }
    
	public function getConsolidateExcelreport($dataExport, $start_date, $end_date){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Consolidated Summary');

            $headertext = "Consolidated Summary";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Consolidated Summary  From '.$start_date.' to '.$end_date);
            $z++;$z++;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "UnitName" );
            $this->excel->getActiveSheet()->setCellValue('C'.$z, $dataExport[0]->unitname );
            $z++;  $z++;  	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
    		
			$this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, '');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'First Ignition On At');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Last Ignition Off At');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Distance');
	        
	        if($dataExport[0]->fuelfill != "N/A"){
	        	$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		        
	        	$this->excel->getActiveSheet()->setCellValue('E'.$z, 'Fuel fill(ltrs)');
	        	$this->excel->getActiveSheet()->setCellValue('F'.$z, 'Operating & Idle Hours');
		        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'IgnOff Hours');	            
		        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'IgnOff Count');
		        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Report Date');
		        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Total Distance');
	        }
	        else{
	        	$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		        
		        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Operating & Idle Hours');
		        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'IgnOff Hours');	            
		        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'IgnOff Count');
		        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Report Date');
		        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Total Distance');
	        }
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            
            if(count($dataExport) == $j){
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            }
         
    			$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				
					
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, ''); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->ignon);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->ignoff);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->dist);
	            if($dataExport[0]->fuelfill != "N/A"){
	            	$this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->fuelfill);
	            	$this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->workinghour);
		            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->idlehour);
		            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->ignoffcount);
		            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->reportdate);
		    		$this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->t1dist);
	            }
	            else{
		            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->workinghour);
		            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->idlehour);
		            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->ignoffcount);
		            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->reportdate);
		    		$this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->t1dist);
	            }
		        
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'ConsolidatedSummaryReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	
	function getMovementdata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail'],
				'historyTable'=>$historyTableName." as h"     			
    		);
    	$result = $this->reports_db->gettable_movement($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getMovementExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
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
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Ladle No. :".$unitname );
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
    
    //Distance Run Report
    
    function getDistanceRun(){
        //$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
        $unit = $this->input->get('unit');
        $start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
        $start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
        $end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
        $end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
        $unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
        
        $orgstart_date= $start_date;
        $orgend_date= $end_date;
        $start = explode("-", $start_date);
        $start_date = $start[2]."-".$start[1]."-".$start[0];
        $start = explode("-", $end_date);
        $end_date = $start[2]."-".$start[1]."-".$start[0];
        $start_datetime = $start_date." ".$start_time.":00";
        $end_datetime = $end_date." ".$end_time.":00";
        
        
        
        $db=array(
            'unitnumber'=>$unit,
            'start_date'=>$start_datetime,
            'end_date'=>$end_datetime,
            'detail'=>$this->data['detail']  
        );
        $result = $this->reports_db->gettable_distanceRun($db);
        
        if($type == "json"){
            echo json_encode($result);
        }
        else{
            $this->getDistanceRunExcelReport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
        }
    }
    
    function getDistanceRunExcelReport($dataExport, $start_date, $end_date){
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Distance Run Report');
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $sheet->setTitle('Distance Run Report');
      
        $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
        $k=0;
        
        $sheet->mergeCells("A1:D1");
        
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        
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
        $sheet->setCellValue('A'.$z, "Distance Run Report" );
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
        $range = 'A'.$z.':'.'C'.$z;
        $sheet->getStyle($range)->applyFromArray($style);
        
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Ladle No');
        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Distance (KMS)');
        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Moving Hours');
        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Report Time');
        
        $j = 0;
        foreach ($dataExport as $dt){$z++;$j++;
        $range = 'A'.$z.':'.'C'.$z;
        $this->excel->getActiveSheet()
        ->getStyle($range)
        ->getNumberFormat()
        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        
        
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
    
    
	function getCycletimedata(){
    	//$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']     			
    		);
    	$result = $this->reports_db->gettable_cycletime($db);
    	
	//print_r($result);
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
            												LEFT JOIN ladle_remarks	lr ON lr.id=lc.remarks 
            												where non_cycling_date between '$from' and '$to' AND lc.ladle_id=".$dt->ladleid." and completeCycle=1 order by lc.id desc");
            		if(count($remarks)){
            				/*	$date1=strtotime($remarks[0]->non_cycling_date);
								$date2=strtotime($dt->grdate); 
								$diff = abs($date1 - $date2);
								$diff = floor($diff/60);
            			//$diff = $this->dateDifference($dt->GROSS_DATE , $remarks[0]->non_cycling_date , '%i' );
            			if($diff > 0){
            				$diffText = " (".$diff." min)";
            			}
            			$remarksText = $remarks[0]->remarks.$diffText;*/
            			
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
								"TAPNO"=>$dt->TAPNO,
								"SOURCE"=>$dt->SOURCE,
								"TEMP"=>$dt->TEMP,
								"BDSTEMP"=>$dt->BDSTEMP,
								"DEST"=>$dt->DEST,
								"FIRST_TARE_TIME"=>$dt->FIRST_TARE_TIME,				
								"GROSS_DATE"=>$dt->GROSS_DATE,
								"ironzone"=>$ironzonetime,//-$diff
								"TARE_DATE"=>$dt->TARE_DATE,
								"steelzone"=>$dt->steelzone,
            					"ironpsteel"=>$ironzonetime+$dt->steelzone,
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
								"GROSS_DATE"=>"Avg TAT:",
								"ironzone"=>number_format((float)$ironzone/$cnt, 2, '.', ''),
								"TARE_DATE"=>"Avg TAT:",
								"steelzone"=>number_format((float)$steelzone/$cnt, 2, '.', ''),
            					"ironpsteel"=>"Avg TAT/Day: ".number_format((float)$total/$cnt, 2, '.', ''),
            					"remarks"=>""			
							);
						
          	$result = $final;
            }
		
		if($type == "json"){
			
           // print_r($result);
    		echo json_encode($result);  
		}
		else{
			$this->getCycleTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time);
		}
    }
    
	public function getCycleTimeExcelreport($dataExport, $start_date, $end_date){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            //name the worksheet
            $sheet->setTitle('Cycle Time Report');

            $headertext = "Cycle Time Report";
            
            
		    $sheet->mergeCells("B1:P1");
		    
		    $sheet->mergeCells("J2:L2");
		    $sheet->mergeCells("M2:O2");
		    $sheet->mergeCells("B2:B3");
		    $sheet->mergeCells("C2:C3");
		    $sheet->mergeCells("D2:D3");
		    $sheet->mergeCells("E2:E3");
		    $sheet->mergeCells("F2:F3");
		    $sheet->mergeCells("G2:G3");
		    $sheet->mergeCells("H2:H3");
		    $sheet->mergeCells("I2:I3");
		    $sheet->mergeCells("P2:P3");
		    $sheet->mergeCells("Q2:Q3");
		    
		    $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","O","P","Q","R");
		    $k = 0;
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(7);
            $sheet->getColumnDimension('C')->setWidth(0);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(10);
            $sheet->getColumnDimension('G')->setWidth(0);
            $sheet->getColumnDimension('H')->setWidth(0);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->getColumnDimension('L')->setWidth(14);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(18);
          	$sheet->getColumnDimension('Q')->setWidth(18);
            
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
            $sheet->setCellValue('B'.$z, "Iron Making - Hot Metal Ladle Turn around time Report " );
            
            $sheet->getStyle('B2:Q2')
    				->getAlignment()->setWrapText(true); 
    				
    		$sheet->getStyle('J3:O3')
    				->getAlignment()->setWrapText(true); 
            $z++;	
            /*$range = 'A'.$z.':'.'J'.$z;
						$sheet
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $sheet->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
            $z++;$z++;	*/
            //change the font size
            $range = 'A'.$z.':'.'Q'.$z;
						$sheet
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $sheet->setCellValue('A'.$z, '');	            
	        $sheet->setCellValue('B'.$z, 'S.No');	            
	        $sheet->setCellValue('C'.$z, 'Ladle Car No.');	            
	        $sheet->setCellValue('D'.$z, 'Ladle No.');
	        $sheet->setCellValue('E'.$z, 'Cast. No');	            
	        $sheet->setCellValue('F'.$z, 'Source');	            
	        $sheet->setCellValue('G'.$z, 'Runner HM Temp Deg.C');
	        $sheet->setCellValue('H'.$z, 'BDS Temp Deg.C');	            
	        $sheet->setCellValue('I'.$z, 'Destination');	            
	        $sheet->setCellValue('J'.$z, 'Iron zone cycle');
	        $sheet->setCellValue('M'.$z, 'Steel zone cycle');	            
	        $sheet->setCellValue('P'.$z, 'Total Turn around Time (TAT) (in min)');
	        $sheet->setCellValue('Q'.$z, 'Remarks');
	        
	        $z++;
	        $sheet->setCellValue('J'.$z, 'Empty Tare wt-1 Timing');	            
	        $sheet->setCellValue('K'.$z, 'Gross wt Timing');	            
	        $sheet->setCellValue('L'.$z, 'Iron Zone Time  (in min)');	            
	        $sheet->setCellValue('M'.$z, 'Gross wt Timing');
	        $sheet->setCellValue('N'.$z, 'Empty Tare wt-2 Timing');	
	        $sheet->setCellValue('O'.$z, 'Steel Zone Time (in min)');	
	        
	        $ironzone = $steelzone = $total = 0;
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'Q'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('B' . $z, $j); 
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->CARNO);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->LADLENO);
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->TAPNO);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->SOURCE); 
	            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->TEMP);
	            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->BDSTEMP);
	            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->DEST);
	            $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->FIRST_TARE_TIME); 
	            $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->GROSS_DATE);
	            $this->excel->getActiveSheet()->setCellValue('L' . $z, $dt->ironzone);$ironzone += $dt->ironzone;
	            $this->excel->getActiveSheet()->setCellValue('M' . $z, $dt->GROSS_DATE);
	            $this->excel->getActiveSheet()->setCellValue('N' . $z, $dt->TARE_DATE);
	            $this->excel->getActiveSheet()->setCellValue('O' . $z, $dt->steelzone);$steelzone += $dt->steelzone;
	            $this->excel->getActiveSheet()->setCellValue('P' . $z, $dt->ironpsteel);	
	            $this->excel->getActiveSheet()->setCellValue('Q' . $z, $dt->remarks);	                 
            }
            $z++;
            /*$cnt = count($dataExport);
            if($cnt){
            $this->excel->getActiveSheet()->setCellValue('K' . $z, 'Avg TAT:');	
            $this->excel->getActiveSheet()->setCellValue('L' . $z, number_format((float)$ironzone/$cnt, 2, '.', ''));	
            $this->excel->getActiveSheet()->setCellValue('N' . $z, 'Avg TAT:');
            $this->excel->getActiveSheet()->setCellValue('O' . $z, number_format((float)$steelzone/$cnt, 2, '.', ''));	
            $this->excel->getActiveSheet()->setCellValue('P' . $z, 'Avg TAT/Day: '.number_format((float)$total/$cnt, 2, '.', ''));	
            
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
    
	function getIdleTimedata(){
    	//$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    
    	$db=array(
    			'lid'=>$unit,
    			'circulation'=>$circulation,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']     			
    		);
    	$result = $this->reports_db->gettable_idletime($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getIdleTimeExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $circulation);
		}
    }
    
	public function getIdleTimeExcelreport($dataExport, $start_date, $end_date, $circulation){
			$name = "";
	    	if(count($dataExport) && $circulation == "1"){
	    		$name = "Circulation ";
	    	}
	    	else{
	    		$name = "Non-Circulation ";
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
            $sheet->setCellValue('A'.$z, "IM-Ladle Day $name Idle time report" );
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
    
	function getGeofencedata(){
    	//$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	
    	$orgstart_date = $start_date;
    	$orgend_date = $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_geofence($db);
		
		$retArr = array();
		if($result){
			foreach($result as $r){
				if($r->geofencename != null){
					$retArr[] = $r;
				}
			}
		}
		
		echo json_encode($retArr);  
    }
    
	function getGeoModifieddata_OLD(){
    	$unit = $this->input->get('unit');
    	$circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
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
    			'unitnumber'=>$unit,
    			'circulation'=>$circulation,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'geoidlist'=>$geoid,
    			'detail'=>$this->data['detail']   			
    		);
    	$result1 = $this->reports_db->gettable_geofenceModified($db);
		//echo "<pre>";print_r($result1);die;
    	
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
						$geomodifiedhtmlreportPojo["tEndLon"] = $geomodifiedReportList[$i+1]->tStartLon;
						$geomodifiedhtmlreportPojo["tEndLoc"] = $geomodifiedReportList[$i+1]->tStartLoc;
						$geomodifiedhtmlreportPojo["tEndTime"] = $geomodifiedReportList[$i+1]->entrytime;
						$geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i+1]->starttime;
						$geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i+1]->endtime;
						
						
						$timespent = $geomodifiedReportList[$i+1]->timeunix - $unixtime;
						 if($timespent!=0 && $timespent >0 ){
						 		//$minutes = intval($timespent / 60);
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
					    geomodifiedhtmlreportPojo.settEndLoc("N/A");
						geomodifiedhtmlreportPojo.settEndTime("N/A");
						geomodifiedhtmlreportPojo.setTimespent("N/A");
						geomodifiedhtmlreportPojo.setStarttime(geomodifiedReportList.get(i).getStarttime());
						geomodifiedhtmlreportPojo.setEndtime(geomodifiedReportList.get(i).getEndtime());
						
						$geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
						$geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
						$geomodifiedhtmlreportPojo["timespent"] = "N/A";
						$geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i]->starttime;
						$geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i]->endtime;
					}
					if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
						($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00") && $timespent>=600){
						$geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
					}
				}
				
				if(($i==$count-1) && $geomodifiedReportList[$i]->entrystatus == "102")
				{
					 $geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
					 $geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
					 $geomodifiedhtmlreportPojo["timespent"] = "N/A";
					if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
						($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00" && $timespent>=600)){
						$geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
					}
				}
				
			}else if($geomodifiedReportList[i]->entrystatus == "103")
			{
				
				$geomodifiedhtmlreportPojo=array(
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
					($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00" && $timespent>=600)){
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
    
	
	function getGeoModifieddata(){
    	$unit =$this->input->get('unit');
    	$circulation = trim(preg_replace('!\s+!', '',$this->input->get('circulation')));
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
    			'unitnumber'=>$unit,
    			'circulation'=>$circulation,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'geoidlist'=>$geoid,
    			'detail'=>$this->data['detail']   			
    		);
    	$result1 = $this->reports_db->gettable_geofenceModified($db);
    	//echo "<pre>";print_r($result1);die;
		
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
						$geomodifiedhtmlreportPojo["tEndLon"] = $geomodifiedReportList[$i+1]->tStartLon;
						$geomodifiedhtmlreportPojo["tEndLoc"] = $geomodifiedReportList[$i+1]->tStartLoc;
						$geomodifiedhtmlreportPojo["tEndTime"] = $geomodifiedReportList[$i+1]->entrytime;
						$geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i+1]->starttime;
						$geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i+1]->endtime;
						
						
						$timespent = $geomodifiedReportList[$i+1]->timeunix - $unixtime;
						 if($timespent!=0 && $timespent >0 ){
						 		//$minutes = intval($timespent / 60);
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
					    geomodifiedhtmlreportPojo.settEndLoc("N/A");
						geomodifiedhtmlreportPojo.settEndTime("N/A");
						geomodifiedhtmlreportPojo.setTimespent("N/A");
						geomodifiedhtmlreportPojo.setStarttime(geomodifiedReportList.get(i).getStarttime());
						geomodifiedhtmlreportPojo.setEndtime(geomodifiedReportList.get(i).getEndtime());
						
						$geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
						$geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
						$geomodifiedhtmlreportPojo["timespent"] = "N/A";
						$geomodifiedhtmlreportPojo["starttime"] = $geomodifiedReportList[$i]->starttime;
						$geomodifiedhtmlreportPojo["endtime"] = $geomodifiedReportList[$i]->endtime;
					}
					if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
						($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00")){
						$geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
					}
				}
				
				if(($i==$count-1) && $geomodifiedReportList[$i]->entrystatus == "102")
				{
					 $geomodifiedhtmlreportPojo["tEndLoc"] = "N/A";
					 $geomodifiedhtmlreportPojo["tEndTime"] = "N/A";
					 $geomodifiedhtmlreportPojo["timespent"] = "N/A";
					if(isset($geomodifiedhtmlreportPojo["timespent"]) && 
						($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00")){
						$geogroupmodifiedReportList[] = (object) $geomodifiedhtmlreportPojo;
					}
				}
				
			}else if($geomodifiedReportList[i]->entrystatus == "103")
			{
				
				$geomodifiedhtmlreportPojo=array(
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
					($geomodifiedhtmlreportPojo["timespent"] != "N/A" && $geomodifiedhtmlreportPojo["timespent"] != "00")){
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
            $this->excel->getActiveSheet()->setTitle('Geofence Report');

            $headertext = "Geofence Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, $name."IM-Ladle Geo fence area delay Report" );
            $z++;	$z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Ladle No." );
             $this->excel->getActiveSheet()->setCellValue('C'.$z, $dataExport[0]->tUnitName );
           
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	                    
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Sl No.');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'From Time');	            
	       // $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Exit Location');
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'To Time');	
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Geofence Area');	            
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Time (min`s)');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			
	            $this->excel->getActiveSheet()->setCellValue('A' . $z, $j);
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->tStartTime);
	            //$this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tEndLoc);	           
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->tEndTime);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tGeoName); 
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->timespent);
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
    	//$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unit = $this->input->get('unit');
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']     			
    		);
    	$result = $this->reports_db->gettable_maintenance($db);
    	
	
		if($type == "json"){
			
           // print_r($result);
    		echo json_encode($result);  
		}
		else{
			$this->getMaintenanceExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time);
		}
    }
    
	public function getMaintenanceExcelreport($dataExport, $start_date, $end_date){
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
            $sheet->setCellValue('A'.$z, "IM-Ladle Maintenance report" );
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
    
	function getIntervaldata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	$interval = trim(preg_replace('!\s+!', '',$this->input->get('interval')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail'],
				'historyTable'=>$historyTableName." as h"     			
    		);
    	$result = $this->reports_db->gettable_Interval($db);
    	
    	$Location = $lat = $lon = $unitname = $statusId = $statuscolor = $status = null;
		$timeinterval = $pre_report_time_unix = $report_time_unix = $idle =0;
			//jsonMap=new HashMap();
			
			$histories=array();
		$reporttime = $location = "";
		$dist = $Prev_dist = $totaldist = 0.00;
		
		$timeinterval=(intval($interval)*60);
			$count = count($result);
			for($i=0;$i<$count;$i++)
			{
				if($i==0)
				{
					$pre_report_time_unix = intval($result[$i]->rpttime);
					$dist = $result[$i]->dist;
					$totaldist = floatval($totaldist) + floatval($result[$i]->dist) ;
					$result[$i]->dist = number_format((float)$dist, 2, '.', '');
					$result[$i]->totaldist = number_format((float)$totaldist, 2, '.', '');
					
					$histories[] = (object) $result[$i];
					$Prev_dist = $dist ;
					
					
				}else if($i == ($count-1)){
					
					$dist = $result[$i]->dist;
					
					  if(floatval($Prev_dist) <= floatval($dist))
	              	   {
						$totaldist = floatval($totaldist) + (floatval($dist) - floatval($Prev_dist)) ;
	              	   }
						
						$result[$i]->dist = number_format((float)$dist, 2, '.', '');
						$result[$i]->totaldist = number_format((float)$totaldist, 2, '.', '');
						$histories[] = (object) $result[$i];
				}
				else 
				{ 
					$report_time_unix = intval($result[$i]->rpttime);
					if((floatval($report_time_unix)-floatval($pre_report_time_unix)) >= floatval($timeinterval))
					{
						//echo "yesy";
						$dist = $result[$i]->dist;
						//echo "prev=$Prev_dist dist=$dist";
						if(floatval($Prev_dist) <= floatval($dist))
                 	   {
							   $totaldist = floatval($totaldist) + (floatval($dist) - floatval($Prev_dist)) ;
                 			   $pre_report_time_unix = $report_time_unix ;
                     
                 	   }else if(floatval($Prev_dist) > floatval($dist)){
                 		      $pre_report_time_unix = $report_time_unix ;
                 	   }
						
						$result[$i]->dist = number_format((float)$dist, 2, '.', '');
						$result[$i]->totaldist = number_format((float)$totaldist, 2, '.', '');
						$histories[] = (object) $result[$i];
						$Prev_dist = $dist ;
						
                	}else
					{
                		$dist = $result[$i]->dist;
                		if(floatval($Prev_dist) <= floatval($dist))
                  	   {
 							   $totaldist = floatval($totaldist) + (floatval($dist) - floatval($Prev_dist)) ;
                      
                  	   }else if(floatval($Prev_dist) > floatval($dist)){
                  		     // totaldist = totaldist + dist ; 
                  		     
                  	   }
                		$Prev_dist = $dist ;
                		
					}
				}
			}
			
		$result = $histories;
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getIntervalExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time);
		}
    }
    
	public function getIntervalExcelreport($dataExport, $start_date, $end_date){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Interval Report');

            $headertext = "Interval Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName :".$dataExport[0]->unitname );
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
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Report Time');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Location');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Distance');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Total Distance');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->reporttime); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->location);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->dist);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->totaldist);	           
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'IntervalReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	function getStoppagedata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	$hrs = trim(preg_replace('!\s+!', '',$this->input->get('hrs')));
    	$min = trim(preg_replace('!\s+!', '',$this->input->get('min')));
    	$sec = trim(preg_replace('!\s+!', '',$this->input->get('sec')));
    	$idleCheck = trim(preg_replace('!\s+!', '',$this->input->get('idleCheck')));
    	$ignOff = trim(preg_replace('!\s+!', '',$this->input->get('ignOff')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail'],
				'historyTable'=>$historyTableName." as h"     			
    		);
    	$result = $this->reports_db->gettable_Stoppage($db);
    	$Idletime = $idle = 0;
    	$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location= $Idle_time_unix = null;
		$lat = $lon = $idletime = null;
		$ignoff = isset($ignOff);
		
    	if(isset($idleCheck)){
			$Idletime = ((intval($hrs)*60*60)+(intval($min)*60)+intval($sec));
		}
		$histories = array();
		$count = count($result);
		foreach($result as $res){
			if(intval($res->statusid) == 18){

				$Idle_time_unix = $res->rpttime;

				if($Idle_Start_TimeUnix!=null){

					$idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));

					if($idle > $Idletime){

						$hours = (int)($idle / 3600);
						$remainder = (int)($idle % 3600);
						$minutes = (int) ($remainder / 60);
						$seconds = (int) ($remainder % 60);

						$disHour = ($hours < 10 ? "0" : "") . $hours;
						$disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
						$disSec = ($seconds < 10 ? "0" : "") . $seconds ;

						$idletime = $disHour.":".$disMinu.":".$disSec;

						$res->event = $Event;
						$res->reporttime = $Idle_Start_Time;
						$res->idletime = $idletime;
						$res->location = $Location;
						$res->lat = $lat;
						$res->lon = $lon;
						
						$histories[] = (object) $res;
					}

					$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $lat = $lon = null;

				}	        	 

				$Event = "Idle";
				$Idle_Start_Time = $res->reporttime;
				$Idle_Start_TimeUnix = $res->rpttime;
				$Location = $res->location;;
				$lat = $res->lat;
				$lon = $res->lon;
			}
			else if(intval($res->statusid) == 1){
				$Idle_time_unix = $res->rpttime;
				if($Idle_Start_TimeUnix != null)
				{
					$idle=(intval($Idle_time_unix) - intval($Idle_Start_TimeUnix));

					if($ignoff){
						$hours = (int)($idle / 3600);
						$remainder = (int)($idle % 3600);
						$minutes = (int) ($remainder / 60);
						$seconds = (int) ($remainder % 60);

						$disHour = ($hours < 10 ? "0" : "") . $hours;
						$disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
						$disSec = ($seconds < 10 ? "0" : "") . $seconds ;

						$idletime = $disHour.":".$disMinu.":".$disSec;

						$res->event = $Event;
						$res->reporttime = $Idle_Start_Time;
						$res->idletime = $idletime;
						$res->location = $Location;
						$res->lat = $lat;
						$res->lon = $lon;
						$histories[] = (object) $res;
					}
					else
					{
						if($idle > $Idletime)
						{
							$hours = (int)($idle / 3600);
							$remainder = (int)($idle % 3600);
							$minutes = (int) ($remainder / 60);
							$seconds = (int) ($remainder % 60);
	
							$disHour = ($hours < 10 ? "0" : "") . $hours;
						$disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
						$disSec = ($seconds < 10 ? "0" : "") . $seconds ;
	
							$idletime = $disHour.":".$disMinu.":".$disSec;

							$res->event = $Event;
							$res->reporttime = $Idle_Start_Time;
							$res->idletime = $idletime;
							$res->location = $Location;
							$res->lat = $lat;
							$res->lon = $lon;
							
							$histories[] = (object) $res;

						} 	
					}

					$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $lat = $lon=null;

				}      
				else{

					$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $lat = $lon=null;
				}

			}
			else if(intval($res->statusid) == 19 || intval($res->statusid) == 0)
			{
				$Idle_time_unix = $res->rpttime;
				if($Idle_Start_TimeUnix != null)
				{
					$idle = (intval($Idle_time_unix) - intval($Idle_Start_TimeUnix));
					if($idle > $Idletime)
					{

						$hours = (int)($idle / 3600);
						$remainder = (int)($idle % 3600);
						$minutes = (int) ($remainder / 60);
						$seconds = (int) ($remainder % 60);

						$disHour = ($hours < 10 ? "0" : "") . $hours;
						$disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
						$disSec = ($seconds < 10 ? "0" : "") . $seconds ;
						$idletime = $disHour.":".$disMinu.":".$disSec;
						
						$res->event = $Event;
						$res->reporttime = $Idle_Start_Time;
						$res->idletime = $idletime;
						$res->location = $Location;
						$res->lat = $lat;
						$res->lon = $lon;
						
						$histories[] = (object) $res;
					}

					$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $lat = $lon=null;
				}
				else{
					$Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $lat = $lon=null;
				}
			}
			if(intval($res->statusid) == 0)
			{

				$Event ="Ign Off";
				$Idle_Start_Time = $res->reporttime;
				$Idle_Start_TimeUnix = $res->rpttime;

				$Location = $res->location;
				$lat = $res->lat;
				$lon = $res->lon;
			}

		}
		$result = $histories;
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getStoppageExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time);
		}
    }
    
	public function getStoppageExcelreport($dataExport, $start_date, $end_date){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Stoppage Report');

            $headertext = "Stoppage Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName :".$dataExport[0]->unitname );
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
    		$this->excel->getActiveSheet()->setCellValue('A'.$z, 'Event Start Time');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Event Duration');	
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Event');
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Location');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			
				$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->reporttime);
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->idletime);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->event); 	            
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->location);	           
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'StoppageReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	function getTripSummarydata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$historyTableName = $this->home_db->getHistoryTable($start_date, $end_date, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail'],
				'historyTable'=>$historyTableName." as h"     			
    		);
    	$result = $this->reports_db->gettable_tripsummary($db);
    	$count = count($result);
    	
    	$Idle_Start_Time = $Idle_Start_TimeUnix = $Ign_Off_TimeUnix = $Location = $Idle_time_unix = null;
		$IdleHours = $IgnOffHours = $WorkHours = $IgnOff = $Moving = $Overspeed = $SuddenBreak = $HashBreak = $Idle = 0;
		$starttimeunix =$endtimeunix = "0";
		$idle = $ignofftime = $workingtime = $idletime = 0 ;
	    $startlat = $startlon = $startcolor = $startstatus = $startdir = $endlat = null;
	    $endlon = $endcolor = $endstatus= $enddir= null;
	    $dist = $igndist = $Pre_distance = $Cur_distance = 0.0;
    	$tripmovementReportList = array();
    	$maxspeed = array();
    	if($count > 0){
    		$startloc = $result[0]->location;
			$starttimeunix = $result[0]->reporttimeunix;
			$starttime = $result[0]->reporttime;
			$startlat = $result[0]->lat;
			$startlon = $result[0]->lon;
			$startcolor = $result[0]->statusColor;
			$startstatus = $result[0]->status;
			$startdir = $result[0]->direction;
			$endloc = $result[$count-1]->location;
			$endtime = $result[$count-1]->reporttime;
			$endtimeunix =  $result[$count-1]->reporttimeunix;
			$endlat = $result[$count-1]->lat;
			$endlon = $result[$count-1]->lon;
			$endcolor = $result[$count-1]->statusColor;
			$endstatus = $result[$count-1]->status;
			$enddir = $result[$count-1]->direction;
    	}
		for($i=0; $i < $count; $i++){
			
			$maxspeed[] = intval($result[$i]->speed);
				
			if($i==0){
			   $Pre_distance = floatval($result[0]->distance);
			}

			if(intval($result[$i]->statusid) == 18){
            	$Idle++;
            	$Idle_time_unix = $result[$i]->reporttimeunix;
            	$Cur_distance = floatval($result[$i]->distance);
            	
            	if($Idle_Start_TimeUnix != null){
            		$idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
					$idletime = $idletime + $idle;
   	        	}
            	$Idle_Start_TimeUnix = $result[$i]->reporttimeunix;
            	if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
               		$Pre_distance = $Cur_distance ;
              	}
            }
			else if(intval($result[$i]->statusid) == 1 ||  intval($result[$i]->statusid) == 9 || 
					intval($result[$i]->statusid) == 14 || intval($result[$i]->statusid) == 23)
			{
	            $Idle_time_unix = $result[$i]->reporttimeunix;
	           	$Cur_distance = floatval($result[$i]->distance);
	           	if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
               		$Pre_distance = $Cur_distance ;
              	}
	           		
	           	if($Ign_Off_TimeUnix != null){
	           		$ignofftime = $ignofftime + intval($Idle_time_unix) - intval($Ign_Off_TimeUnix) ;
	           		$Ign_Off_TimeUnix = null;
	           	}
	           	else if($Idle_Start_TimeUnix != null){
	           			 $idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
						 $idletime = $idletime + $idle;
	           	}
	           	$Idle_Start_TimeUnix = null;
            }
            else if(intval($result[$i]->statusid) == 9 || intval($result[$i]->statusid) == 14 || intval($result[$i]->statusid) == 23){
            		
           		$Idle_time_unix = $result[$i]->reporttimeunix;
           		$Cur_distance = floatval($result[$i]->distance);
           	 
           		if($Idle_Start_TimeUnix != null){
           			$idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
					$idletime = $idletime + $idle;
           		}
           		$Idle_Start_TimeUnix = null;
           		 
           		 if($Pre_distance <= $Cur_distance)
        		 {
        			 $dist = $dist + ($Cur_distance-$Pre_distance);
          		     $Pre_distance = $Cur_distance;
        		 }else if($Pre_distance > $Cur_distance){
        			 $Pre_distance = $Cur_distance ;
          	   }
         	}
            else if(intval($result[$i]->statusid) == 19){
            	$Idle_time_unix = $result[$i]->reporttimeunix;
            	$Cur_distance = floatval($result[$i]->distance);
            	if($Idle_Start_TimeUnix != null){
            		$idle=(intval($Idle_time_unix) - intval($Idle_Start_TimeUnix));
            		$idletime = $idletime + $idle;
            	}
            	$Idle_Start_TimeUnix = null;
            	if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance - $Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
               		 $Pre_distance = $Cur_distance ;
              	}
            }
            else if(intval($result[$i]->statusid) == 2 || intval($result[$i]->statusid) == 3 || intval($result[$i]->statusid) == 4){
            	$Idle_time_unix = $result[$i]->reporttimeunix;
            	$Cur_distance = floatval($result[$i]->distance);
            	if($Idle_Start_TimeUnix != null){
            		$idle = (intval($Idle_time_unix) - intval($Idle_Start_TimeUnix));
   	        		$idletime = $idletime + $idle;
            	}
            	$Idle_Start_TimeUnix = null;
            	$Moving++;
            		 
            	if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
               		$Pre_distance = $Cur_distance ;
              	}	
            }
            else if( intval($result[$i]->statusid) == 7 || intval($result[$i]->statusid) == 15 ){
	           	$Idle_time_unix = $result[$i]->reporttimeunix;
	           	$Cur_distance = floatval($result[$i]->distance);
	           	
	           	if($Idle_Start_TimeUnix!=null){
	           		$idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
	           		$idletime = $idletime + $idle;
		   	    }
	           		 
		   	    $Idle_Start_TimeUnix = null;
	           	$Overspeed++;

	            if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
            		$Pre_distance = $Cur_distance ;
              	}
           else if( intval($result[$i]->statusid) ==17 ){
            	$Idle_time_unix = $result[$i]->reporttimeunix;
    	        $Cur_distance = floatval($result[$i]->distance);
    	         if($Idle_Start_TimeUnix != null){
    	           	$idle = (intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
    	           	$idletime = $idletime + $idle;
    		   	 }
    	           		 
    		   	 $Idle_Start_TimeUnix = null;
    	         if($Pre_distance <= $Cur_distance){
                	$dist = $dist + ($Cur_distance-$Pre_distance);
                  	$Pre_distance = $Cur_distance;
                 }
                 else if($Pre_distance > $Cur_distance){
                	$Pre_distance = $Cur_distance ;
                 }
    	     }
	      }
	       else if( intval($result[$i]->statusid) == 20){
	           $Cur_distance = floatval($result[$i]->distance);
	           $SuddenBreak++;
	           if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
               }
               else if($Pre_distance > $Cur_distance){
               		$Pre_distance = Cur_distance ;
               }
	           		 
	      }
	      else if( intval($result[$i]->statusid) == 21){
	           	$Cur_distance = floatval($result[$i]->distance);
	            $HashBreak++;
	            if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}else if($Pre_distance > $Cur_distance){
               		$Pre_distance = $Cur_distance ;
              	}
	           		 
	      }
	      else if(intval($result[$i]->statusid) == 0){
	            $IgnOff++;
	            $Idle_time_unix = $result[$i]->reporttimeunix;
            	$Cur_distance = floatval($result[$i]->distance);
            	$Ign_Off_TimeUnix = $result[$i]->reporttimeunix;
            	if($Idle_Start_TimeUnix!=null){
            		$idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
            		$idletime = $idletime + $idle;
	   	        }
            	$Idle_Start_TimeUnix = null;
            	if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
            		$Pre_distance = $Cur_distance ;
              	}
	         }
	         else{
	           	$Cur_distance = floatval($result[$i]->distance);
	            if($Pre_distance <= $Cur_distance){
            		$dist = $dist + ($Cur_distance-$Pre_distance);
              		$Pre_distance = $Cur_distance;
            	}
            	else if($Pre_distance > $Cur_distance){
            		$Pre_distance = $Cur_distance ;
              	}
	        }
	       }
			
			if($count > 0){
				if($idletime != 0){
					$hours = (int) ($idletime / 3600);
	     		  	$remainder = (int) ($idletime % 3600);
	     		  	$minutes = (int) ($remainder / 60);   
	     			$seconds = (int) ($remainder % 60);
	             	$disHour = ($hours < 10 ? "0" : "") . $hours;
	     		    $disMinu = ($minutes < 10 ? "0" : "") . $minutes ;
	     		    $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
	                $IdleHours = $disHour.":".$disMinu.":".$disSec;
			}
			if($ignofftime!=0){
				$hours = (int) ($ignofftime / 3600);
	     		$remainder = (int) ($ignofftime % 3600);
	     		$minutes = (int) ($remainder / 60);   
	     		$seconds = (int) ($remainder % 60);
	            $disHour = ($hours < 10 ? "0" : "") . $hours;
	     		$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
	     		$disSec = ($seconds < 10 ? "0" : "") . $seconds ;
	            $IgnOffHours = $disHour.":".$disMinu.":".$disSec;
			}
				
			 $workingtime = intval($endtimeunix) - intval( $starttimeunix);
			
			 if($workingtime!=0){
		     	$hours = (int) ($workingtime / 3600);
	     		$remainder = (int) ($workingtime % 3600);
		     	$minutes = (int) ($remainder / 60);   
	     		$seconds = (int) ($remainder % 60);
	            $disHour = ($hours < 10 ? "0" : "") . $hours;
	     		$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
	     		$disSec = ($seconds < 10 ? "0" : "") . $seconds ;
		        $WorkHours = $disHour.":".$disMinu.":".$disSec;
			}		
			$avgspeed = ((($dist)*3600)/ $workingtime);
		    $highspeed = max($maxspeed);
			    
			$movementreportPojo=array(
									"startloc"=>$startloc,
									"endloc"=>$endloc,
									"distance"=>str_replace(",","",number_format((float)$dist, 2, '.', '')),
									"tripstarttime"=>$starttime,
									"tripendtime"=>$endtime,
									"OSevents"=>$Overspeed,
									"IOevents"=>$IgnOff,
									"SIevents"=>$Idle,
									"HBevents"=>$HashBreak,
									"SBevents"=>$SuddenBreak,
									"MOevents"=>$Moving,
									"workHours"=>$WorkHours,
									"ignOffHours"=>$IgnOffHours,
									"idleHours"=>$IdleHours,
									"avgspeed"=>str_replace(",","",number_format((float)$avgspeed, 2, '.', '')),
									"maxspeed"=>$highspeed,
									"lat"=>$startlat,
									"lon"=>$startlon,
									"endlat"=>$endlat,
									"endlon"=>$endlon,
									"statusColor"=>$startcolor,
									"endstatusColor"=>$endcolor,
									"direction"=>$startdir,
									"status"=>$startstatus,
									"enddirection"=>$enddir,
									"endstatus"=>$endstatus
									);
			
			
			$tripmovementReportList = array();
			$tripmovementReportList[] = (object) $movementreportPojo;
			
		}
		$result = $tripmovementReportList;
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getTripSummaryExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
		}
    }
    
	public function getTripSummaryExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Trip Summary Report');

            $headertext = "Trip Summary Report";
	
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P");
            $z = 1;
            
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName :".$unitname );
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
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Start Loc');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Start Time');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'End Loc');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'End Time');	        
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Distance (Kms)');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Transit Time (hh:mm:ss)');	            
	        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Idle Time (hh:mm:ss)');	            
	        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'IgnOff Time (hh:mm:ss)');	        
	        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Avg Speed (kmph)');	            
	        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Max Speed (kmph)');	            
	        $this->excel->getActiveSheet()->setCellValue('K'.$z, 'Moving Events');	        
	        $this->excel->getActiveSheet()->setCellValue('L'.$z, 'Idle Events');	            
	        $this->excel->getActiveSheet()->setCellValue('M'.$z, 'OverSpeed Events');	            
	        $this->excel->getActiveSheet()->setCellValue('N'.$z, 'SuddenBreak Events');
	        $this->excel->getActiveSheet()->setCellValue('O'.$z, 'HarshBreak Events');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
           
				$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->startloc); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->tripstarttime);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->endloc);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->tripendtime);
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->distance); 
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->workHours);
	            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->idleHours);
	            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->ignOffHours);	            
	            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->avgspeed); 
	            $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->maxspeed);
	            $this->excel->getActiveSheet()->setCellValue('K' . $z, $dt->MOevents);
	            $this->excel->getActiveSheet()->setCellValue('L' . $z, $dt->SIevents);
	            $this->excel->getActiveSheet()->setCellValue('M' . $z, $dt->OSevents); 
	            $this->excel->getActiveSheet()->setCellValue('N' . $z, $dt->SBevents);
	            $this->excel->getActiveSheet()->setCellValue('O' . $z, $dt->HBevents);
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'TripSummaryReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	function getIgnitiondata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	$tripTableName = $this->home_db->getTripTableName($start_date, $end_date, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail'],
				'tripTableName'=>"(".$tripTableName.")"     			
    		);
    	$result = $this->reports_db->gettable_ignition($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getIgnitionExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
		}
    }
    
	private function getIgnitionExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Ignition Report');

            $headertext = "Ignition Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName :".$unitname );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Period :".$start_date." to ".$end_date );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "* Completed Trips Only" );
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'IgnOn Time');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'IgnOn Location');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'IgnOff Time');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'IgnOff Location');
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Distance');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Duration');
	        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Idle Time');	            
	        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Max Speed');
	        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Avg Speed');	            
	        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Mileage');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->tripstart); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->startlocation);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->tripend);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->endlocation);	           
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->tripdistance);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->tripduration);
	            
	            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->tripidle);
	            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->highspeed);	           
	            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->avgspeed);
	            $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->mileage);
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'IgnitionReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
   
	function getIgnModifieddata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$tripStartTime1 = trim(preg_replace('!\s+!', ' ',$this->input->get('tripStartTime1')));
    	$tripEndTime1 = trim(preg_replace('!\s+!', ' ',$this->input->get('tripEndTime1')));
    	$tripStartLocation = trim(preg_replace('!\s+!', ' ',$this->input->get('tripStartLocation')));
    	$tripEndLocation = trim(preg_replace('!\s+!', ' ',$this->input->get('tripEndLocation')));
    	//print_r($_GET);
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
    	
    	
    	//$date = date_create($row[0]);

//echo date_format($date, 'Y-m-d H:i:s');
#output: 2012-03-24 17:45:12
			/*if($dateformat == "%d-%m-%Y %H:%i:%s")
				$formate="d-m-Y H:i:s";
			else if($dateformat == "%Y-%m-%d %H:%i:%s")
				$formate="Y-m-d H:i:s";
			else if($dateformat == "%m-%d-%Y %H:%i:%s")
				$formate="m-d-Y H:i:s";*/
				
			$date = date_create($tripStartTime1);
			$tripStartTime1=date_format($date, 'Y-m-d H:i:s');
			$date = date_create($tripEndTime1);
			$tripEndTime1=date_format($date, 'Y-m-d H:i:s');
    	
    	$tripTableName = $this->home_db->getTripTableName($tripStartTime1, $tripEndTime1, $unit);
    	
    	$db=array(
    			'unitnumber'=>$unit,
    			'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
		    	'tripStartTime1'=>$tripStartTime1,
		    	'tripEndTime1'=>$tripEndTime1,
    			'tripTableName'=>"(".$tripTableName.")",
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_ignModified($db);
    	
    	if(count($result)){
	    	$result[0]->tripstart1 = $tripStartTime1;
	    	$result[0]->tripend1 = $tripEndTime1;
	    	$result[0]->startlocation = $tripStartLocation;
	    	$result[0]->endlocation = $tripEndLocation;
    	}
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getIgnModifiedExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
		}
    }
    
	public function getIgnModifiedExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Ignition Modified Report');

            $headertext = "Ignition Modified Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Ignition Modified From ".$start_date." to ".$end_date );
            $z++;	$z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName" );
             $this->excel->getActiveSheet()->setCellValue('B'.$z, $unitname );
           
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
		
						    
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'IgnOn Time');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'IgnOn Location');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'IgnOff Time');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'IgnOff Location');
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Distance');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Duration');
	        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Idle Time');	            
	        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Max Speed');
	        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Avg Speed');	            
	        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Mileage');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->tripstart1); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->startlocation);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->tripend1);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->endlocation);	           
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->sdist);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->sTrip);
	            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->sIdle);
	            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->mHSpeed);	           
	            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->avgspeed);
	            $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->mileage);
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'IgnitionModifiedReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	function getRoutedata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	
    	$db=array(
    			'unitnumber'=>$unit,  			
    		);
    	$result = $this->reports_db->gettable_routes($db);
		
		echo json_encode($result);  
    }
    
    function getRouteModifieddata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$group = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$checkAuto = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$routeUnitNumber = trim(preg_replace('!\s+!', '',$this->input->get('routeUnitNumber')));
    	$routeStartDate = trim(preg_replace('!\s+!', ' ',$this->input->get('routeStartDate')));
    	$routeEndDate = trim(preg_replace('!\s+!', ' ',$this->input->get('routeEndDate')));
    	$routename = trim(preg_replace('!\s+!', ' ',$this->input->get('routeName')));
    	$locReportId= $startdt= $enddt = "";
    	
    	$locReportId = $routeList = trim(preg_replace('!\s+!', ' ',$this->input->get('routeList')));
    	
    	
		$historyTableName = $location_report= $routeReports = $summaryReports = null;
		$distance= $prev_dis= $pres_dis=0;
		$routeReports = array();
    	//print_r($_GET);exit;
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date." ".$start_time;
    	$end_datetime = $end_date." ".$end_time;
				
		$date = date_create($routeStartDate);
		$routeStartDate=date_format($date, 'Y-m-d H:i:s');
		$date = date_create($routeEndDate);
		$routeEndDate=date_format($date, 'Y-m-d H:i:s');
    	
    	$historyTableName = $this->home_db->getHistoryTable($routeStartDate, $routeEndDate, $unit);
    	
    	$db =array(
    			'unitnumber'=>$unit,
    			'start_date'=>$routeStartDate,
		    	'end_date'=>$routeEndDate,
    			'historyTable'=>$historyTableName." as h",      
    			'detail'=>$this->data['detail']   			
    		);
    	$routeConreportList = $this->reports_db->getRouteConLocHtmlReport($db);
    	
		$companyName = $this->reports_db->getCompanyname($db);
		
    	$this->reports_db->getRouteConInsertTemp($db);
    	$chkloc =  $this->reports_db->getRouteChkloc($locReportId);
    	$indloc = $routeConMod1reportList = $routeConModreportList = array();
    	$singleentry = $end_loc_int = $start_loc_int = $route_size = 0;$singleloc = 2;
    	$startloc = $endloc = "";
    	if($chkloc == 2){
            $routeLocConfigList = $this->reports_db->getRouteConfigNoSpecificLocList($locReportId);
            $trip_sp = count($routeLocConfigList) - 1;
            $startloc = $routeLocConfigList[0]->locname;
            $endloc = $routeLocConfigList[1]->locname;
            $route_size = count($routeConreportList);
        }
        else if($chkloc == 1){
            $routeLocConfigList = $this->reports_db->getRouteConfigNoSpecificLocList($locReportId);
            $trip_sp = count($routeLocConfigList) - 1;
            $startloc = $routeLocConfigList[0]->locname;
            $endloc = $routeLocConfigList[0]->locname;
            $route_size = count($routeConreportList);
        }
        else{
            $routeLocConfigList = $this->reports_db->getRouteConfigList($locReportId);
            $trip_sp = count($routeLocConfigList) - 1;
            for($i = 0; $i <= $trip_sp; $i++){
                if($routeLocConfigList[$i]->loctype == "0"){
                    $startloc = $routeLocConfigList[$i]->locname;
                } 
                else if($routeLocConfigList[$i]->loctype == "2"){
                    $endloc = $routeLocConfigList[$i]->locname;
                } 
                else{
                    $indloc[] = $routeLocConfigList[$i]->locname;
                }
            }

           $route_size = count($routeConreportList);
        }
        $count = count($routeConreportList)-1;
    	for($i=0; $i <= $count; $i++){
		    if(substr($routeConreportList[$i]->location, 0, 2) === "At"){
	    		 $routeLocConPojo=array();
	    		 $loc = $routeConreportList[$i]->location;
	    		
	    		 $atloc=explode("*", $loc);
	    		 //print_r($atloc);
	    		 $location = substr($atloc[0], 4);
                   	 //echo $loc."======".$startloc ."=======".$location;
    				//echo "<br>";
	    		 if ($chkloc == 1 && $singleentry == 0 && strtolower($startloc) == strtolower($location)){
	    			    $routeLocConModPojo= array(
							    			    "reporttime" => $routeConreportList[$i]->reporttime,
							    			    "reporttimeunix" => $routeConreportList[$i]->reporttimeunix,
							    			    "location" => $location,
							    			    "distance" => $routeConreportList[$i]->distance,
							    			    "idletime" => $routeConreportList[$i]->idletime,
							    			    "lat" => $routeConreportList[$i]->lat,
							    			    "lon" => $routeConreportList[$i]->lon,
							    			    "direction" => $routeConreportList[$i]->direction,
							    			    "status" => $routeConreportList[$i]->status,
							    			    "statusColor" => $routeConreportList[$i]->statusColor,
							    			    "entrystatus" => "102"
							    			    );
	    			    
		    	 		$routeConMod1reportList[] = (object)$routeLocConModPojo;
	    		        $singleloc = 0;
	    		        $singleentry++;
	    		 }
	    		 else if($chkloc != 1){
	    			 $routeLocConPojo = array(
						    			    "location" => $location,
						    			    "reporttime" => $routeConreportList[$i]->reporttime,
	    			 						"reporttimeunix" => $routeConreportList[$i]->reporttimeunix,
						    			    "statusid" => $routeConreportList[$i]->statusid,
						    			    "distance" => $routeConreportList[$i]->distance,
						    			    "idletime" => $routeConreportList[$i]->idletime,
						    			    "lat" => $routeConreportList[$i]->lat,
						    			    "lon" => $routeConreportList[$i]->lon,
						    			    "direction" => $routeConreportList[$i]->direction,
						    			    "status" => $routeConreportList[$i]->status,
						    			    "statusColor" => $routeConreportList[$i]->statusColor,
						    			    "id" => $i
						    			);
	    			 
	    			 $routeConModreportList[] = (object)$routeLocConPojo;
	    			 //print_r($routeConModreportList);
	    		 }
	    	}
	    	else{
	    		if($chkloc == 1 && $singleloc==0 &&  strtolower($startloc) == strtolower($location)){
	    			  
	    			 $routeLocConModPojo= array(
						    			    "reporttime" => $routeConreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConreportList[$i]->reporttimeunix,
						    			    "location" => $location,
						    			    "distance" => $routeConreportList[$i]->distance,
						    			    "idletime" => $routeConreportList[$i]->idletime,
						    			    "lat" => $routeConreportList[$i]->lat,
						    			    "lon" => $routeConreportList[$i]->lon,
						    			    "direction" => $routeConreportList[$i]->direction,
						    			    "status" => $routeConreportList[$i]->status,
						    			    "statusColor" => $routeConreportList[$i]->statusColor,
						    			    "entrystatus" => "103"
						    			    );
    			    
	    	 		$routeConMod1reportList[] = (object)$routeLocConModPojo;
		    		 $singleloc++;
		    		 $singleentry = 0;
	    		}
	    		
	    	}

		}
		
		$count = count($routeConModreportList)-1;
		//print_r($routeConModreportList);
    	for($i=0; $i<=$count; $i++){
    		
		    if(strtolower($startloc) == strtolower($routeConModreportList[$i]->location)){ 
		    	$start_loc_int++;
		    	if($start_loc_int==1){
		    			$routeLocConModPojo= array(
						    			    "reporttime" => $routeConModreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
						    			    "location" => $routeConModreportList[$i]->location,
						    			    "distance" => $routeConModreportList[$i]->distance,
						    			    "idletime" => $routeConModreportList[$i]->idletime,
						    			    "lat" => $routeConModreportList[$i]->lat,
						    			    "lon" => $routeConModreportList[$i]->lon,
						    			    "direction" => $routeConModreportList[$i]->direction,
						    			    "status" => $routeConModreportList[$i]->status,
						    			    "statusColor" => $routeConModreportList[$i]->statusColor,
						    			    "entrystatus" => "102"
						    			    );
		    	 		$routeConMod1reportList[] = (object)$routeLocConModPojo;
		    		}
		    		
		    		if($i<$count && $i<$route_size)
		    		{	
	                   if(strtolower($routeConModreportList[$i]->location) == strtolower($routeConModreportList[$i+1]->location))
			    		{
			    			
			    		}
	                   else{
	                		$start_loc_int = 0;
	                		$routeLocConModPojo= array(
						    			    "reporttime" => $routeConModreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
						    			    "location" => $routeConModreportList[$i]->location,
						    			    "distance" => $routeConModreportList[$i]->distance,
						    			    "idletime" => $routeConModreportList[$i]->idletime,
						    			    "lat" => $routeConModreportList[$i]->lat,
						    			    "lon" => $routeConModreportList[$i]->lon,
						    			    "direction" => $routeConModreportList[$i]->direction,
						    			    "status" => $routeConModreportList[$i]->status,
						    			    "statusColor" => $routeConModreportList[$i]->statusColor,
						    			    "entrystatus" => "103"
						    			    );
		    	 			$routeConMod1reportList[] = (object)$routeLocConModPojo;
	                   }	
		    		}
                   else{
                		$start_loc_int = 0; 
                   }
		    	}else if( strtolower($endloc) == strtolower($routeConModreportList[$i]->location))
		    	{  
		    		
		    		$end_loc_int++;
		    		if($end_loc_int==1){
		    			$routeLocConModPojo= array(
						    			    "reporttime" => $routeConModreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
						    			    "location" => $routeConModreportList[$i]->location,
						    			    "distance" => $routeConModreportList[$i]->distance,
						    			    "idletime" => $routeConModreportList[$i]->idletime,
						    			    "lat" => $routeConModreportList[$i]->lat,
						    			    "lon" => $routeConModreportList[$i]->lon,
						    			    "direction" => $routeConModreportList[$i]->direction,
						    			    "status" => $routeConModreportList[$i]->status,
						    			    "statusColor" => $routeConModreportList[$i]->statusColor,
						    			    "entrystatus" => "102"
						    			    );
		    	 		$routeConMod1reportList[] = (object) $routeLocConModPojo;
		    		} 
		    		$rescount = count($routeConModreportList)-1;
		    		if($i<$rescount && $i<$route_size)
		    		{
		    			if(strtolower($routeConModreportList[$i]->location) == strtolower($routeConModreportList[$i+1]->location))
			    		{
			    			
			    		}
			    		else{
	                		$end_loc_int = 0;
	                		$routeLocConModPojo= array(
						    			    "reporttime" => $routeConModreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
						    			    "location" => $routeConModreportList[$i]->location,
						    			    "distance" => $routeConModreportList[$i]->distance,
						    			    "idletime" => $routeConModreportList[$i]->idletime,
						    			    "lat" => $routeConModreportList[$i]->lat,
						    			    "lon" => $routeConModreportList[$i]->lon,
						    			    "direction" => $routeConModreportList[$i]->direction,
						    			    "status" => $routeConModreportList[$i]->status,
						    			    "statusColor" => $routeConModreportList[$i]->statusColor,
						    			    "entrystatus" => "103"
						    			    );
	                        $routeConMod1reportList[] = (object) $routeLocConModPojo; 	  
	                   }	
		    		}
                   else{
                		$end_loc_int = 0;
                         	  
                   }	
		    	}
		    	else
		    	{
		    		$ind_loc_int = 0;
		    		//print_r($indloc);
		    		$indcount = count($indloc)-1;
		    		
		   		   for($ind=0;$ind<=$indcount;$ind++){
		   		    	$ind_loc_int++;
		   		    	//echo $indloc[$ind]."=======".$routeConModreportList[$i]->location;
    					//echo "<br>";
		   		        if($indloc[$ind] == $routeConModreportList[$i]->location)
		   		    	{
		   		    		
		   		    		if($ind_loc_int == 1){
		   		    			$routeLocConModPojo= array(
								    			    "reporttime" => $routeConModreportList[$i]->reporttime,
								    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
								    			    "location" => $routeConModreportList[$i]->location,
								    			    "distance" => $routeConModreportList[$i]->distance,
								    			    "idletime" => $routeConModreportList[$i]->idletime,
								    			    "lat" => $routeConModreportList[$i]->lat,
								    			    "lon" => $routeConModreportList[$i]->lon,
								    			    "direction" => $routeConModreportList[$i]->direction,
								    			    "status" => $routeConModreportList[$i]->status,
								    			    "statusColor" => $routeConModreportList[$i]->statusColor,
								    			    "entrystatus" => "102"
								    			    );
		    	 				$routeConMod1reportList[] = (object) $routeLocConModPojo;
				    		}
		   		    		
		   		    		if($i<(count($routeConModreportList)-1) && $i<$route_size)
				    		{
				    			
					    		if(strtolower($routeConModreportList[$i]->location) == strtolower($routeConModreportList[$i+1]->location))
					    		{
					    			
					    		}
					    		else{
			                		$ind_loc_int = 0;
			                		$routeLocConModPojo= array(
						    			    "reporttime" => $routeConModreportList[$i]->reporttime,
						    			    "reporttimeunix" => $routeConModreportList[$i]->reporttimeunix,
						    			    "location" => $routeConModreportList[$i]->location,
						    			    "distance" => $routeConModreportList[$i]->distance,
						    			    "idletime" => $routeConModreportList[$i]->idletime,
						    			    "lat" => $routeConModreportList[$i]->lat,
						    			    "lon" => $routeConModreportList[$i]->lon,
						    			    "direction" => $routeConModreportList[$i]->direction,
						    			    "status" => $routeConModreportList[$i]->status,
						    			    "statusColor" => $routeConModreportList[$i]->statusColor,
						    			    "entrystatus" => "103"
						    			    );
	                        		$routeConMod1reportList[] = (object) $routeLocConModPojo; 	
			                         	  
			                   }	
				    		}
		                   else{
		                	  $ind_loc_int = 0;
		                         	  
		                   }	
		   		    		
		   		    	}
		   		    	else{
		   		    		$ind_loc_int = 0;
		   		    	}
		   		}	
		   }
		   
		}
		
     	$map = $summarymap = $tripname = $entryloc = $entrystatus = $avgspeed  = null;
     	
		$routeConMod2reportList = array();
		for($i=0; $i<=(count($routeConMod1reportList)-1);$i++){
		    $routeLocConModPojo=array();
				   if($i==0){
				   		$routeLocConModPojo= array(
							    			    "reporttime" => $routeConMod1reportList[$i]->reporttime,
							    			    "reporttimeunix" => $routeConMod1reportList[$i]->reporttimeunix,
							    			    "location" => $routeConMod1reportList[$i]->location,
							    			    "distance" => $routeConMod1reportList[$i]->distance,
							    			    "idletime" => $routeConMod1reportList[$i]->idletime,
							    			    "lat" => $routeConMod1reportList[$i]->lat,
							    			    "lon" => $routeConMod1reportList[$i]->lon,
							    			    "direction" => $routeConMod1reportList[$i]->direction,
							    			    "status" => $routeConMod1reportList[$i]->status,
							    			    "statusColor" => $routeConMod1reportList[$i]->statusColor,
							    			    "entrystatus" => $routeConMod1reportList[$i]->entrystatus,
						    			    );
	                   $routeConMod2reportList[] = (object) $routeLocConModPojo; 
				       $entryloc = $routeConMod1reportList[$i]->location;
					   $entrystatus = $routeConMod1reportList[$i]->entrystatus;
					    	
				    	
				    }
				    else{				    	
					    if($entrystatus != $routeConMod1reportList[$i]->entrystatus){
						    $routeLocConModPojo= array(
							    			    "reporttime" => $routeConMod1reportList[$i]->reporttime,
							    			    "reporttimeunix" => $routeConMod1reportList[$i]->reporttimeunix,
							    			    "location" => $routeConMod1reportList[$i]->location,
							    			    "distance" => $routeConMod1reportList[$i]->distance,
							    			    "idletime" => $routeConMod1reportList[$i]->idletime,
							    			    "lat" => $routeConMod1reportList[$i]->lat,
							    			    "lon" => $routeConMod1reportList[$i]->lon,
							    			    "direction" => $routeConMod1reportList[$i]->direction,
							    			    "status" => $routeConMod1reportList[$i]->status,
							    			    "statusColor" => $routeConMod1reportList[$i]->statusColor,
							    			    "entrystatus" => $routeConMod1reportList[$i]->entrystatus,
						    			    );
	                   		$routeConMod2reportList[] = (object) $routeLocConModPojo; 
					    }
					    $entryloc = $routeConMod1reportList[$i]->location;
					    $entrystatus = $routeConMod1reportList[$i]->entrystatus;
				    } 
            }
            
            $count = count($routeConMod2reportList)-2;
    		for($i=0;$i<=$count;$i++){

				$idleTime= $ignofftimeunix= $ignontimeunix= $endtimeunix1 = $ign_off = $halttime = $duration = 0;
				$distance = $prev_dis = $pres_dis = $avgspeed = 0.0;
				$halttimehours = null;
				$map = $summarymap = array();
				
		    	 $startTime = $routeConMod2reportList[$i]->reporttime;
		    	 $endTime = $routeConMod2reportList[$i+1]->reporttime;
		    	 $statTime1 = $routeConMod2reportList[$i]->reporttime;
		    	 $endTime1 = $routeConMod2reportList[$i+1]->reporttime;
		    	 $starttimeunix = intval($routeConMod2reportList[$i]->reporttimeunix);
		    	 $endtimeunix = intval($routeConMod2reportList[$i+1]->reporttimeunix);
				  
		    	 $startLoc = $routeConMod2reportList[$i]->location;
		    	 $endLoc = $routeConMod2reportList[$i+1]->location;
		    	 $startlat = $routeConMod2reportList[$i]->lat;
		    	 $startlon =  $routeConMod2reportList[$i]->lon;
		    	 $startstatus = $routeConMod2reportList[$i]->status;
		    	 $startstatuscolor = $routeConMod2reportList[$i]->statusColor;
		    	 $endstatuscolor = $routeConMod2reportList[$i+1]->statusColor;
		    	 $endstatus = $routeConMod2reportList[$i+1]->status;
		    	 $endlat = $routeConMod2reportList[$i+1]->lat;
		    	 $endlon =  $routeConMod2reportList[$i+1]->lon;
		    	 $startdirection = $routeConMod2reportList[$i]->direction;
		    	 $enddirection = $routeConMod2reportList[$i+1]->direction;
				  
		    	 if($i<(count($routeConMod2reportList)-2)){
		    	 
			    	 $endtimeunix1 = intval($routeConMod2reportList[$i+2]->reporttimeunix);
			    	 $halttime = intval($endtimeunix1 - $endtimeunix) ;
			    	 if($halttime != 0 && $halttime > 0){
					 	$hours = (int) ($halttime / 3600);
				       	$remainder = (int) ($halttime % 3600);
				       	$minutes = (int) ($remainder / 60);   
				       	$seconds = (int) ($remainder % 60);
				        $disHour = ($hours < 10 ? "0" : "") . $hours;
				       	$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
				        $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
				            $halttimehours = $disHour.":".$disMinu.":".$disSec;
				 		}else{
				 			$halttimehours= "NA";
				 		}
	    		
		    	 }
		    	 $duration = intval($endtimeunix - $starttimeunix) ;
		    	 $db["starttimeunix"] = $starttimeunix;
		    	 $db["endtimeunix"] = $endtimeunix;
		    	 
		    	 if($duration!=0){
			 		$hours = (int) ($duration / 3600);
	       			$remainder = (int) ($duration % 3600);
		       		 $minutes = (int) ($remainder / 60);   
			       	$seconds = (int) ($remainder % 60);
			        $disHour = ($hours < 10 ? "0" : "") . $hours;
			       	$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
			        $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
		            $workinghours = $disHour.":".$disMinu.":".$disSec;
			 	}
			 	else{
			 		$workinghours= "00:00:00";
			 	}
				    	 
			    $routeLocDisReportList = $this->reports_db->getDisRouteLocConHtmlReport($db);
			    $maxspeed = $this->reports_db->getRouteLocConMaxSpeed($db);

			    $dist_count = count($routeLocDisReportList)-1; 
				for($z=0 ;$z <= $dist_count;$z++){
				   if($z==0){
				    	$prev_dis = $routeLocDisReportList[$z]->distance;
				   }
				   else{
				    	$pres_dis = $routeLocDisReportList[$z]->distance;
				    	if($pres_dis > $prev_dis){
				    		$distance = floatval($distance) + floatval( $pres_dis - $prev_dis);
				    		$prev_dis =  $pres_dis ;
                        } 
                        else if(floatval($pres_dis) == 0){
				    		$distance =   floatval($distance) + floatval($pres_dis) ;
				    		$prev_dis = 0.0 ;
				    	}
		          }
				}

				$locDistCount = count($routeLocDisReportList)-1;
				for($z=0 ;$z<=$locDistCount;$z++){				    		 
				    		
		    		 if($routeLocDisReportList[$z]->status == 0 && ($z==0)){
		    			 //distance =  routeLocDisReportList.get(z).getDistance() - Double.parseDouble(routeConMod1reportList.get(i).getDistance());
		    			 $idleTime = intval($routeLocDisReportList[$z]->idle - $routeConMod1reportList[$i]->idletime);
		    			 $ignofftimeunix = intval($routeLocDisReportList[$z]->reporttimeunix);
		    			 $ign_off++;
		    			
		    		 }
		    		 else if($routeLocDisReportList[$z]->status == 1 ){
		    			 $ign_off++;		
		    			 if($ignofftimeunix != 0){
		    				$idleTime = intval($idleTime + (intval($routeLocDisReportList[$z]->reporttimeunix) - $ignofftimeunix));
			    			$ignofftimeunix =0;
		    			 }
		    			 
		    		 }
		    		 else if($routeLocDisReportList[$z]->status == 0 && $z!=0){
		    			 $ign_off++;	
		    			 $ignofftimeunix = intval($routeLocDisReportList[$z]->reporttimeunix);
		    			
		    		 }		    		 
		    	 }
		    	 
		    	 if(count($routeLocDisReportList)>0 && $ign_off>0){
		    		 $idleTime = intval($idleTime + $routeLocDisReportList[count($routeLocDisReportList)-1]->idle);
		    		
		    		 
		    	 }
		    	 else if(count($routeLocDisReportList)>0){
		    		 $idleTime = intval($routeLocDisReportList[count($routeLocDisReportList)-1]->idle - $routeLocDisReportList[0]->idle);		    	    	
		    	 }
				    	 
				    	 
		    	 if($idleTime!=0 && $idleTime >0 && $duration>$idleTime){
		    	 	$hours = (int) ($idleTime / 3600);
	       			$remainder = (int) ($idleTime % 3600);
		       		 $minutes = (int) ($remainder / 60);   
			       	$seconds = (int) ($remainder % 60);
			        $disHour = ($hours < 10 ? "0" : "") . $hours;
			       	$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
			        $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
		            $idlehours = $disHour.":".$disMinu.":".$disSec;
		            
		 		}else{
		 			$idlehours= "00:00:00";
		 		}
				    	 
		    	 if($halttimehours==null){
		    		 $endtimeunix1 = intval($routeConMod2reportList[$i+1]->reporttimeunix);
			    	 $halttime =  $endtimeunix1 - $endtimeunix ;
			    	 if($halttime!=0 && $halttime>0){
			    	 	$hours = (int) ($halttime / 3600);
		       			$remainder = (int) ($halttime % 3600);
			       		 $minutes = (int) ($remainder / 60);   
				       	$seconds = (int) ($remainder % 60);
				        $disHour = ($hours < 10 ? "0" : "") . $hours;
				       	$disMinu = ($minutes < 10 ? "0" : "") . $minutes;
				        $disSec = ($seconds < 10 ? "0" : "") . $seconds ;
			            $halttimehours = $disHour.":".$disMinu.":".$disSec;
					 	
			 		}else{
			 			$halttimehours= "NA";
			 		}
		    	 }
		    	
		    	
		    	$distanceRun= str_replace(",","",number_format((float)$distance, 2, '.', ''));
		    	if($duration != 0){
		    		$avgspeed = (floatval($distanceRun)*3600)/$duration;
		    	}
		    	$avgspeed= str_replace(",","",number_format((float)$avgspeed, 2, '.', ''));
				    	
				
		    	$map["distance"] = $distanceRun;
		    	$map["workinghours"] = $workinghours;
		    	$map["idleTime"] = $idlehours;
		    	$map["startLoc"] = $startLoc;
		    	$map["endLoc"] = $endLoc;
		        $map["locReportId"] = $locReportId;
		    	$map["starttime"] = $startTime;
		    	$map["endtime"] = $endTime;
		    	$map["startlat"] = $startlat;
		    	$map["startlon"] = $startlon;
		    	$map["endlat"] = $endlat;
		    	$map["endlon"] = $endlon;
		    	$map["startstatus"] = $startstatus;
		    	$map["endstatus"] = $endstatus;
		    	$map["startstatuscolor"] = $startstatuscolor;
		    	$map["endstatuscolor"] = $endstatuscolor;
		    	$map["startdirection"] = $startdirection;
		    	$map["enddirection"] = $enddirection;
		    	$map["unitname"] = $unitname;
		    	$map["maxspeed"] = $maxspeed;
		    	$map["avgspeed"] = $avgspeed;
		    	$map["halttime"] = $halttimehours;  
				    	
				if($routeConMod2reportList[$i]->entrystatus != "102"){
				    if(strtoupper($companyName) == "SATHYA SAI TRAVELS"){
	    		    	if(floatval($distance) > 5.0)
	    		    	{
	    		    		$routeReports[] = (object)$map;
	    		    	}
	    		    }else{
	    		    	
	    		    	 $routeReports[] = (object)$map;
	    		         
	    		    }
                      	      
				    	}
    			}
    			
    	$this->reports_db->getRouteCondeleteTemp($db);
        $result = $routeReports;
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getRouteModifiedExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname, $routename);
		}
    }
    
	public function getRouteModifiedExcelreport($dataExport, $start_date, $end_date, $unitname, $routename){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Route Modified Report');

            $headertext = "Route Modified Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Route Modified From ".$start_date." to ".$end_date );
            $z++;	$z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "UnitName" );
             $this->excel->getActiveSheet()->setCellValue('B'.$z, $unitname );
             
             $z++;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('A'.$z, "Route Name" );
             $this->excel->getActiveSheet()->setCellValue('B'.$z, $routename );
           
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
		
						    
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Dep Location');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Dep Time');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Arr Location');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Arr Time');
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Distance');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Halt Time');
	        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Transit Time');	            
	        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Idle Time');
	        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Avg Speed');	            
	        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Max Speed');
	        
	        $j = 0;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->startLoc); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->starttime);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->endLoc);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->endtime);	           
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->distance);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->halttime);
	            $this->excel->getActiveSheet()->setCellValue('G' . $z, $dt->workinghours);
	            $this->excel->getActiveSheet()->setCellValue('H' . $z, $dt->idleTime);	           
	            $this->excel->getActiveSheet()->setCellValue('I' . $z, $dt->avgspeed);
	            $this->excel->getActiveSheet()->setCellValue('J' . $z, $dt->maxspeed);
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'RouteModifiedReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */
