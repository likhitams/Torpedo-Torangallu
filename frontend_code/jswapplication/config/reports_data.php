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
        $this->load->model('grid_db');
        $this->load->model('reports_db');
    	$this->data['detail'] = '';
        $this->data['session'] = "userm";
        $this->data['session_pwd'] = "usermpwd";
        $this->data['session_data'] = "userm";
        $this->data['cookie'] = "suvem_user";
        $this->data['cookie_pwd'] = "suvem_userpwd";
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
                   'domain' => '.suvetracm',
                   'path'   => '/',
                   'prefix' => 'suve_',
               );
				set_cookie($cookie); 
				
				$cookie = array(
                   'name'   => $this->data['session_pwd'],
                   'value'  => $det[0]->password,
                   'expire' => 3600*24*7,
                   'domain' => '.suvetracm',
                   'path'   => '/',
                   'prefix' => 'suve_',
               );
				set_cookie($cookie); 
	        }
	        else{
	        	$this->home_db->clearSession($this->data['session'],$this->data['session_data']);
	            redirect('userlogin','refresh');
	        }   
        }   
		$this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
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

    
	function getTasksdata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;
    	
    	$db=array(
    			'userid'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_tasks($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getTaskExcelreport($result, $orgstart_date, $orgend_date, $unitname);
		}
    }
    
	private function getTaskExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Schedule Tasks Report');

            $headertext = "Schedule Tasks Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(45);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        
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
            
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Task Name');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Description');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Task Date');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Task Location');
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'Contact Person');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Contact No.');
	        $this->excel->getActiveSheet()->setCellValue('G'.$z, 'Report Date');
	        $this->excel->getActiveSheet()->setCellValue('H'.$z, 'Report Time');	            	            
	        $this->excel->getActiveSheet()->setCellValue('I'.$z, 'Status');
	        $this->excel->getActiveSheet()->setCellValue('J'.$z, 'Report Location');	
	        
	        $j = 0;
	        $user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->task_name); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->description);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->task_date);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->location_name);	           
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->contact_name);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->contact_no);
	            $db = array(
	    			'userid'=>$user_id,
	    			'task_id'=>$dt->task_id,			
	    		 );
	    		//print_r($db);
		    	$result = $this->reports_db->gettable_taskModified($db);
		    	
		    	
		    	$status = $this->master_db->getRecords("statuses", array("statusid"=>$dt->open_status));
		    	$movementreportPojo=array(
										"task_name"=>"",
										"location_name"=>"NA",
										"latitude"=>"",
										"longitude"=>"",
										"report_date"=>"NA",
										"report_time"=>"",
										"status"=>$status[0]->statusdesc
									 );	
					$result1 = array((object) $movementreportPojo);
					if(count($result)){
						$result = array_merge($result1, $result);
					}
					
					if($dt->completed_by != ""){
						$movementreportPojo = array(
													"task_name"=>"",
													"location_name"=>"NA",
													"latitude"=>"",
													"longitude"=>"",
													"report_date"=>date('d-m-Y', strtotime($dt->completed_date)),
													"report_time"=>date('H:i', strtotime($dt->completed_date)),
													"status"=>"Closed"
												 );	
						$result[] = (object) $movementreportPojo;
					}
					foreach($result as $res){
			            $this->excel->getActiveSheet()->setCellValue('G' . $z, $res->report_date);
			            $this->excel->getActiveSheet()->setCellValue('H' . $z, $res->report_time);	           
			            $this->excel->getActiveSheet()->setCellValue('I' . $z, $res->status);
			            $this->excel->getActiveSheet()->setCellValue('J' . $z, $res->location_name);
			            $z++;
					}
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'TasksReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
   
	function getTaskModifieddata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$task_id = trim(preg_replace('!\s+!', '',$this->input->get('task_id')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;
    	
    	$db = array(
    			'userid'=>$unit,
    			'task_id'=>$task_id,
    			'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		 );
    		//print_r($db);
    	$result = $this->reports_db->gettable_taskModified($db);
    	
    	$check = $this->master_db->getRecords("schedule_tasks", array("id"=>$task_id), "open_status,completed_date, completed_by");
    	$status = $this->master_db->getRecords("statuses", array("statusid"=>$check[0]->open_status));
    	$movementreportPojo=array(
								"task_name"=>"",
								"location_name"=>"",
								"latitude"=>"",
								"longitude"=>"",
								"report_date"=>"",
								"report_time"=>"",
								"status"=>$status[0]->statusdesc
							 );	
							 
			$result1 = array((object) $movementreportPojo);
			if(count($result)){
				$result = array_merge($result1, $result);
			}
			else{
				$result = $result1;
			}
			
			if($check[0]->completed_by != ""){
				$movementreportPojo = array(
											"task_name"=>"",
											"location_name"=>"",
											"latitude"=>"",
											"longitude"=>"",
											"report_date"=>date('d-m-Y', strtotime($check[0]->completed_date)),
											"report_time"=>date('H:i', strtotime($check[0]->completed_date)),
											"status"=>"Closed"
										 );	
				$result[] = (object) $movementreportPojo;
			}
    	//print_r($result);
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			//$this->getIgnModifiedExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
		}
    }
    
	function getAttendancedata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;
    	
    	$db=array(
    			'userid'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_attendance($db);
    	
    	$finalRes = array();
    	$i = $j = 0;
    	foreach ($result as $res){
    		$arr = array();
    		$arr['id'] = $res->id;
    		$arr['inDateFormat'] = $res->in_datetimeFormat;
    		$arr['inDate'] = $res->in_datetime;
    		//$xplode = explode("*", $res->in_location);
    		$arr['inlocation_name'] = $res->in_location;
    		$arr['inLat'] = $res->in_latitude;
    		$arr['inlon'] = $res->in_longitude;
    		
    		if($res->out_datetime != "0000-00-00 00:00:00"){
	    		$arr['outDateFormat'] = $res->out_datetimeFormat;
	    		$arr['outDate'] = $res->out_datetime;
	    		//$xplode = explode("*", $res->out_location);
	    		$arr['outlocation_name'] = $res->out_location;
	    		$arr['outLat'] = $res->out_latitude;
	    		$arr['outlon'] = $res->out_longitude;
	    		
	    		
	    		$workingtime = strtotime($res->out_datetime) - strtotime($res->in_datetime);
	    		$hours = intval($workingtime / 3600); 
		        $remainder = intval($workingtime % 3600); 
		        $minutes = intval($remainder / 60); 
	            $seconds = intval($remainder % 60);
				$disHour = ($hours < 10 ? "0" : "") . $hours; 
				$disMinu = ($minutes < 10 ? "0" : "") . $minutes; 
				$disSec = ($seconds < 10 ? "0" : "") . $seconds;
				$totalHours = $disHour . ":" . $disMinu . ":" . $disSec;
	    		$arr['timeSpent'] = $totalHours;
    		}
    		else{
    			$arr['outDateFormat'] = "NA";
	    		$arr['outDate'] = "NA";
	    		$arr['outlocation_name'] = "";
	    		$arr['outLat'] = "";
	    		$arr['outlon'] = "";
    			
    			/*$workingtime = strtotime(date("Y-m-d H:i:s")) - strtotime($res->in_datetime);
    			$hours = intval($workingtime / 3600); 
	            $remainder = intval($workingtime % 3600); 
	            $minutes = intval($remainder / 60); 
	            $seconds = intval($remainder % 60);
				$disHour = ($hours < 10 ? "0" : "") . $hours; 
				$disMinu = ($minutes < 10 ? "0" : "") . $minutes; 
				$disSec = ($seconds < 10 ? "0" : "") . $seconds;
				$totalHours = $disHour . ":" . $disMinu . ":" . $disSec;*/
    			$arr['timeSpent'] = "";
    		}
    		$finalRes[] = (object)($arr);
    			
    		}
    	
    
		
		if($type == "json"){
    		echo json_encode($finalRes);  
		}
		else{
			$this->getAttendanceExcelreport($finalRes, $orgstart_date, $orgend_date, $unitname);
		}
    }
    
    
	private function getAttendanceExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Attendance Report');

            $headertext = "Attendance Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "User Name :".$unitname );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Period :".$start_date." to ".$end_date );
            
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'IN Date & Time');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'IN Location Name');	            
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'OUT Date & Time');
	        $this->excel->getActiveSheet()->setCellValue('E'.$z, 'OUT Location Name');	            
	        $this->excel->getActiveSheet()->setCellValue('F'.$z, 'Total Time');		
	        
	        $j = 0;
	       // $user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->inDateFormat); 
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->inlocation_name);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->outDateFormat);
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->outlocation_name);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->timeSpent);	            
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'AttendanceReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
	function getLeavedata(){
    	$unit = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;
    	
    	$db=array(
    			'userid'=>$unit,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_leave($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getLeaveExcelreport($result, $orgstart_date, $orgend_date, $unitname);
		}
    }
    
	private function getLeaveExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Leave Request Report');

            $headertext = "Leave Request Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        $this->excel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        
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
            
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('A'.$z, 'Leave From Date');	            
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Leave To Date');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Reason');	
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Requested Date');		
	        
	        $j = 0;
	        $user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('A' . $z, $dt->from_date); 
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->to_date);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->reason);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->requested_datetime);
	            
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'LeaveRequestReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    
	function getTrackingdata(){
    	$userid = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
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
    			'detail'=>$this->data['detail'],   
    			'userid'=>$userid,
		    	'start_date'=>$start_datetime,
		    	'to_date'=>$end_datetime, 
    			//'startMonth'=>$this->input->get('start_date'),
		    	//'toMonth'=>$this->input->get('to_date'),    			
    	);
    	$result = $this->grid_db->gettable_replay($db);   
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getTrackingExcelreport($result, $orgstart_date." ".$start_time, $orgend_date." ".$end_time, $unitname);
		}
    }
    
	private function getTrackingExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Tracking Report');

            $headertext = "Tracking Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(100);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "UserName :".$unitname );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Period :".$start_date." to ".$end_date );
            
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Report Time');	            
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Status');	  
	        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Location');	
	        
	        $j = 0;
	       // $user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->reportTime);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->STATUS);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->location);	 
	            
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'TrackingReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    
	function getLocationSnapshotdata(){
    	$userid = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;
    	
    	$db=array(
    			'userid'=>$userid,
		    	'start_date'=>$start_datetime,
		    	'end_date'=>$end_datetime,
    			'detail'=>$this->data['detail']   			
    		);
    	$result = $this->reports_db->gettable_snapshot($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else if($type == "download"){
			$this->getSnapshotZip($result, $unitname);
		}
		else{
			$this->getSnapshotExcelreport($result, $orgstart_date, $orgend_date, $unitname);
		}
    }
    
    private function getSnapshotZip($dataExport, $unitname){
    	$this->load->library('zip');
		$d = new DateTime();
    	foreach ($dataExport as $dt)
		{
		    $this->zip->read_file($dt->location_images);
		}
		
		$this->zip->download($d->getTimestamp().$unitname.'.zip');
    }
    
	private function getSnapshotExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Location Snapshot Report');

            $headertext = "Location Snapshot Report";
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        
            
	        
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M");
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "UserName :".$unitname );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Period :".$start_date." to ".$end_date );
            
            $z++;$z++;	
            //change the font size
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	            
    		//set cell A1 content with some text
	        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Report Time');  
	        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Report Location');	
	        
	        $j = 0;
	        //$user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
	            $this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->report_date1);
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->location_name);
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'SnapshotReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
    }
    
    
	function getDistancedata(){
    	$userid = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
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
    			'detail'=>$this->data['detail'],   
    			'userid'=>$userid,
		    	'start_date'=>$start_datetime,
		    	'to_date'=>$end_datetime   			
    	);
    	$result = $this->grid_db->gettable_replay($db);
    	$cnt = count($result);
    	$distance = 0;
    	for ($i = 0; $i<$cnt; $i++){
    		if($i-1 < $cnt-2){
			    	    	
	    	   $a = $result[$i+1]->distance;
	    	   $b = $result[$i]->distance;
				if(floatval($a)>floatval($b) && $a!="" && $b!=""){
					$c = floatval($a) - floatval($b);
					$distance += $c;
					//echo "<br>";
					//tempSum.push(c.toFixed(2));
				}
    	    }
    	}
    	$from = $to = $fromLat = $toLat = $fromLon = $toLon = "";
    	if($cnt > 0){
    		$from = $result[0]->location;
    		$fromLat = $result[0]->latitude;
    		$fromLon = $result[0]->longitude;
    		if($cnt > 1){
    			$to = $result[$cnt-1]->location;
    			$toLat = $result[0]->latitude;
    			$toLon = $result[0]->longitude;
    		}
    	}
    	$resultarr = array();
    	$result = array(
    					"totalDistance"=>number_format((float)$distance, 2, '.', ''), 
    					"fromLocation"=>$from, 
    					"fromLat"=>$fromLat,
    					"fromLon"=>$fromLon, 
    					"toLocation"=>$to,
    					"toLat"=>$toLat, 
    					"toLon"=>$toLon
    				);
    	$resultarr[] = (object)($result);
		
		if($type == "json"){
    		echo json_encode($resultarr);  
		}
    }
    
	function getFormsdata(){
    	$userid = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$start_date = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$start_time = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$end_date = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$end_time = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	$type = trim(preg_replace('!\s+!', '',$this->input->get('type')));
    	$formType = trim(preg_replace('!\s+!', '',$this->input->get('formType')));
    	$unitname = trim(preg_replace('!\s+!', ' ',$this->input->get('unitname')));
    	
    	$orgstart_date= $start_date;
    	$orgend_date= $end_date;
    	$start = explode("-", $start_date);    	
    	$start_date = $start[2]."-".$start[1]."-".$start[0];
    	$start = explode("-", $end_date);    	
    	$end_date = $start[2]."-".$start[1]."-".$start[0];
    	$start_datetime = $start_date;
    	$end_datetime = $end_date;    	
    	
    	$db=array(
    			'detail'=>$this->data['detail'],   
    			'userid'=>$userid,
		    	'start_date'=>$start_datetime,
		    	'to_date'=>$end_datetime,
    			'formType'=>$formType 			
    	);
    	$result = $this->reports_db->gettable_forms($db);
		
		if($type == "json"){
    		echo json_encode($result);  
		}
		else{
			$this->getFormsExcelreport($result, $orgstart_date, $orgend_date, $unitname);
		}
    }
    
	private function getFormsExcelreport($dataExport, $start_date, $end_date, $unitname){
	    	
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Forms Report');

            $headertext = "Forms Report";
            
            $alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
          	$next = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);            
            
            /*foreach (range('E', $this->excel->getActiveSheet()->getHighestDataColumn()) as $col) {
            	echo $col;echo "<br>";
		        $this->excel->getActiveSheet()
		                ->getColumnDimension($col)
		                ->setAutoSize(true);
		        $this->excel->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		    } 
            exit;*/
            $this->excel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	        $this->excel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	       
            
            $z = 1;
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "User Name :".$unitname );
            $z++;	
            $range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
            $this->excel->getActiveSheet()->setCellValue('B'.$z, "Period :".$start_date." to ".$end_date );
            
            $z++;$z++;	
            
            foreach ($dataExport as $dt){
            	
            	$j = 4; $x = 0;
            	$res = $this->master_db->getRecords("submitted_formValues", array("subid"=>$dt->form_id), "field_name, field_value");
            	if(count($res)){
            		$range = 'A'.$z.':'.'D'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->applyFromArray($this->data['styleArray']);
	          
	    		//set cell A1 content with some text
		        $this->excel->getActiveSheet()->setCellValue('B'.$z, 'Form Name');	            
		        $this->excel->getActiveSheet()->setCellValue('C'.$z, 'Location Name');	            
		        $this->excel->getActiveSheet()->setCellValue('D'.$z, 'Report Date & Time');
		        
		        
		        foreach ($res as $r){
		        	if($j == 26){$j=0;$x++;}     
            		//echo "<br>".$next[$x].$alpha[$j++];
            		echo "<br>".$val = $next[$x].$alpha[$j++];
            		
            		$range = 'A'.$z.':'.'D'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						    
					
            		$this->excel->getActiveSheet()->getColumnDimension($val)->setWidth(25);
		        	$this->excel->getActiveSheet()->getStyle($val.($z))->applyFromArray($this->data['styleArray']);
		        	$this->excel->getActiveSheet()->setCellValue($val.($z), $r->field_name);
		        	
		        	$this->excel->getActiveSheet()->getStyle($val.($z+2))->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					$this->excel->getActiveSheet()->setCellValue('B' . $z+1, $dt->form_name); 
	            	$this->excel->getActiveSheet()->setCellValue('C' . $z+1, $dt->location);
	            	$this->excel->getActiveSheet()->setCellValue('D' . $z+1, $dt->filled_dateFormat);
		        	$this->excel->getActiveSheet()->setCellValue($val.($z+1), $r->field_value);
		        	
		        }
            	}
	        	$z++;$z++;	$z++;	
            }

	      /*  $j = 0;
	       // $user_id = $dataExport[0]->user_id;
            foreach ($dataExport as $dt){
            	$z++;$j++;
            	$range = 'A'.$z.':'.'J'.$z;
						$this->excel->getActiveSheet()
						    ->getStyle($range)
						    ->getNumberFormat()
						    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
					
    			$this->excel->getActiveSheet()->setCellValue('B' . $z, $dt->inDateFormat); 
	            $this->excel->getActiveSheet()->setCellValue('C' . $z, $dt->inlocation_name);
	            $this->excel->getActiveSheet()->setCellValue('D' . $z, $dt->outDateFormat);
	            $this->excel->getActiveSheet()->setCellValue('E' . $z, $dt->outlocation_name);
	            $this->excel->getActiveSheet()->setCellValue('F' . $z, $dt->timeSpent);	            
            }
            
			$d = new DateTime();
			
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$d->getTimestamp().'FormsReport.xls"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');*/
    }
	
   
    
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */