<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api extends CI_Controller {
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -  
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
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
        $this->load->model('tasks_db');
        $this->load->model('reports_db');
        $this->load->model('forms_db');
    }
  

    public function login(){
    	//$user_id = trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
    	$device_id = trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
    	$gcm_id = trim(preg_replace('!\s+!', ' ',$this->input->post('gcm_id')));
    	$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
    	$password = trim(preg_replace('!\s+!', ' ',$this->input->post('password')));
    	
    	if($_SERVER['REQUEST_METHOD']==='POST' && $device_id!='' && $mobile_no != '')
        {
            $db['username']="";
            $db['password']=$password;
            //$db['device_id']=$device_id;
            $db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and ";
            $checkDevice = $this->home_db->getloginUser($db,1);
            if(count($checkDevice)){
            	if($checkDevice[0]->device_id == ""){
            		$this->master_db->updateRecord("units", array("device_id"=>$device_id, "gcm_id"=>$gcm_id), array("unitnumber"=>$checkDevice[0]->unitId));
            	}
            }
            
            $db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
            $verify = $this->home_db->getloginUser($db,1);
            if(count($verify)) // login check
            {            	
            	if($verify[0]->active == 0){
            		$this->master_db->updateRecord("units", array("gcm_id"=>$gcm_id), array("unitnumber"=>$checkDevice[0]->unitId));
            		echo json_encode(array( "status"=>"yes","act"=>"login","msg"=>"Login Successfull","details"=>$verify));
            	}
            	else{
            		echo json_encode(array( "status"=>"no","act"=>"login","msg"=>"Your account is temporarily deactivated. Please contact SuVeechi Team. support@suveechi.in"));
            	}
              
		    }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid Credentials"));
            }                    
        }
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
        }        
    }
    
	function tasks(){
		$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {
	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
		    	$db=array(
				    	'detail'=>$verify 			
		    		);
		    	$tasks = $this->tasks_db->getTasks($db);  
		    	$status = $this->tasks_db->getStatus($db);  
		    	if(count($tasks)){
		    		echo json_encode(array( "status"=>"yes","msg"=>"success","tasks"=>$tasks, "statusList"=>$status));
		   	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"No Tasks are Assigned"));
		    	}
		    }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    function locn(){
    	echo $this->tasks_db->getLocationName("12.98842145", "77.53778865");
    	 echo $location_name = $this->tasks_db->getCustomLocation("12.98842145", "77.53778865", 24, "Basaveshwar Nagar");
    	echo substr("2019-09-90 20:90:99", 0, 11);
    }
    
	function updateTask(){
		$json = $this->input->post('tasks_json');
    	$data1 = json_decode($json, true);
    	if($_SERVER['REQUEST_METHOD']==='POST' && is_array($data1) && count($data1))
        {
        	if(isset($data1['userid']) && isset($data1['deviceid']) && isset($data1['updates'])){
        		$user_id = $data1['userid'];
    			$user_name = $data1['username'];
    			$device_id = $data1['deviceid'];
	    		$updates = $data1['updates'];
	    		if(is_array($updates)){
	    			foreach ($updates as $val){
	    				$task_id=trim(preg_replace('!\s+!', '',$val['task_id']));
						$status=trim(preg_replace('!\s+!', '',$val['status']));
						$report_time=trim(preg_replace('!\s+!', ' ',$val['report_time']));
						$latitude=trim(preg_replace('!\s+!', '',$val['latitude']));
						$longitude=trim(preg_replace('!\s+!', '',$val['longitude']));
						$location_name=trim(preg_replace('!\s+!', ' ',$val['location_name']));
						$remarks=trim(preg_replace('!\s+!', ' ',$val['remarks']));
						
	    				if($location_name == "" || $location_name == " "){
							$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
						}
						$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $user_id, $location_name);
		    			$db=array(
				    			'user_id'=>$user_id,
				    			'status_id'=>$status,
						    	'task_id'=>$task_id,
						    	'location_name'=>$location_name,
						    	'latitude'=>$latitude,
				    			'longitude'=>$longitude,
						    	'report_date'=>$report_time,
				    			'remarks'=>$remarks,
				    			'received_date'=>date("Y-m-d H:i:s")  			
				    	);
				    	$list = $this->master_db->insertRecord("schedule_tasksUsers", $db);  
				    	if($list){
				    		$this->master_db->updateRecord("schedule_tasks", array("user_status"=>$status), array("id"=>$task_id));				    		
				    	}
				    	
	    			}
	    			echo json_encode(array( "status"=>"yes","msg"=>"success"));
	    		}
        		else{
				    echo json_encode(array( "status"=>"no","msg"=>"No Updates Found"));
				}
        	}
        	else{
				echo json_encode(array( "status"=>"no","msg"=>"No Updates Found"));
			}
        }
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       	}
			
			/*$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
			$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
			$task_id=trim(preg_replace('!\s+!', '',$this->input->post('task_id')));
			$status=trim(preg_replace('!\s+!', '',$this->input->post('status')));
			$report_time=trim(preg_replace('!\s+!', ' ',$this->input->post('report_time')));
			$latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
			$longitude=trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
			$location_name=trim(preg_replace('!\s+!', ' ',$this->input->post('location_name')));
			$remarks=trim(preg_replace('!\s+!', ' ',$this->input->post('remarks')));
			if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $task_id!='' && $status!='' && $latitude!='' && $longitude!='')
	        {
		    	
		    	$db['username']=$user_id;
		    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    		$verify = $this->home_db->getloginUser($db,0);
		        if(count($verify)) // login check
		        { 
			    	$db=array(
			    			'user_id'=>$verify[0]->userId,
			    			'status_id'=>$status,
					    	'task_id'=>$task_id,
					    	'location_name'=>$location_name,
					    	'latitude'=>$latitude,
			    			'longitude'=>$longitude,
					    	'report_date'=>$report_time,
			    			'remarks'=>$remarks,
			    			'received_date'=>date("Y-m-d H:i:s")  			
			    	);
			    	$list = $this->master_db->insertRecord("schedule_tasksUsers", $db);  
			    	if($list){
			    		$this->master_db->updateRecord("schedule_tasks", array("user_status"=>$status), array("id"=>$task_id));
			    		echo json_encode(array( "status"=>"yes","msg"=>"success"));
			    	}
			    	else{
			    		echo json_encode(array( "status"=>"no","msg"=>"Error in updating"));
			    	}
			    }
	            else
	            {
	            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
	            }  
	    	}
	        else{
	        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       		} 
       		}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  */ 
    }
    
	public function tracking(){
		
    	$json = file_get_contents("php://input");
    		
    		$file = 'tracking.txt';
    		$json = print_r($json, true);
    		$log_array = $json."\r\n";
    		file_put_contents($file, $log_array , FILE_APPEND | LOCK_EX);
    		
    		$json = $this->input->post('tracking_json');
    		$unitId = $this->input->post('unitId');
    		$mobile_no = $this->input->post('mobile_no');
    		//if(!empty($json)){
    			
    		$data1 = json_decode($json, true);
    		//print_r($data1);
    		
		if($_SERVER['REQUEST_METHOD']==='POST' && is_array($data1) && count($data1) && $unitId != "" && $mobile_no != "")
        {
			if(isset($data1['userid']) && isset($data1['deviceid']) && isset($data1['tracking_data'])){
    			$user_id = $data1['userid'];
    			$user_name = $data1['username'];
    			$device_id = $data1['deviceid'];
    			$total_distance = $data1['total_distance'];
    			$latitude=$data1['latitude'];
    			$longitude=$data1['longitude'];
    			$location_name=$data1['location_name'];
				$report_time=$data1['report_time'];
						
	    		$tracking_data = $data1['tracking_data'];
	    		$dayArr = array("mon", "tue", "wed", "thu", "fri", "sat", "sun");
	    		$leftout = array();
	    		
	    		if(is_array($tracking_data) && count($tracking_data) && $latitude != "" && $longitude != ""){
	    			//$this->master_db->updateRecord("users", array("status"=>"Tracking", "last_updated"=>date("Y-m-d H:i:s")), array("id"=>$user_id));
	    			if($location_name == ""){
	    				$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
	    			}
	    			$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $user_id, $location_name);	
	    			//echo $location_name
	    			$db = array(
	    					"distance"=>$total_distance,
	    					"latitude"=>$latitude,
	    					"longitude"=>$longitude,
	    					"location"=>$location_name,
	    					"reporttime"=>$report_time,
	    					"status"=>4,
	    					"last_updated"=>date("Y-m-d H:i:s")
	    				);
	    			
	    			
	    			$this->master_db->updateRecord("units", $db, array("unitnumber"=>$unitId));
	    			foreach ($tracking_data as $val){
	    				$report_time=trim(preg_replace('!\s+!', ' ',$val['date']));
	    				//echo strtotime($report_time);
	    				$day = date("D", strtotime($report_time));
	    				$day = strtolower($day);
	    				if(in_array($day, $dayArr)){
	    					$check = $this->master_db->getRecords("day_$day", array("unitnumber"=>$unitId, "status"=>4, "report_date"=>$report_time),"unitnumber");
	    					if(count($check) == 0){
		    					$latitude=trim(preg_replace('!\s+!', '',$val['latitude']));
		    					$distance=trim(preg_replace('!\s+!', '',$val['distance']));
								$longitude=trim(preg_replace('!\s+!', '',$val['longitude']));
								$location_name=trim(preg_replace('!\s+!', ' ',$val['location']));
								if($location_name == "" || $location_name == " "){
									$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
								}
								//$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $user_id, $location_name);
								
						    	$sql = "INSERT INTO day_$day (user_id,unitnumber,mobile_no,user_name,device_id,distance,location_name,latitude,longitude,latitude_day,longitude_day,report_date,received_date,status)
									    VALUES (?,?,?,?,?,?,?,?,?,TRUNCATE($latitude,5),TRUNCATE($longitude,5),?,?,?);";
						    	$this->db->query($sql, array($user_id, $unitId, $mobile_no, $user_name, $device_id, $distance, $location_name, $latitude, $longitude, $report_time, date("Y-m-d H:i:s"), 4));
					    	//$list = $this->master_db->insertRecord("day_".$day, $db); 
	    					} 
	    				}
	    				else{
	    					$leftout[] = 1;
	    				}				
						
	    			}
	    			if(count($leftout) == 0){
	    				echo json_encode(array( "status"=>"yes","msg"=>"success"));
	    			}
	    			else{
	    				echo json_encode(array( "status"=>"no","msg"=>"data missing"));
	    			}
	    	
	    		}
	    		else{
	    			echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
	    		}
        	 	
		   }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
	function updateAttendance(){
		$json = $this->input->post('attendance_json');
    	$data1 = json_decode($json, true);
    	
		if($_SERVER['REQUEST_METHOD']==='POST' && is_array($data1) && count($data1))
        {
			if(isset($data1['userid']) && isset($data1['deviceid']) && isset($data1['attendance'])){
    			$user_id = $data1['userid'];
    			$user_name = $data1['username'];
    			$device_id = $data1['deviceid'];
	    		$attendance = $data1['attendance'];
	    		if(is_array($attendance)){
	    			foreach ($attendance as $val){
	    				
						$type=trim(preg_replace('!\s+!', '',$val['type']));
						$report_time=trim(preg_replace('!\s+!', ' ',$val['report_time']));
						$latitude=trim(preg_replace('!\s+!', '',$val['latitude']));
						$longitude=trim(preg_replace('!\s+!', '',$val['longitude']));
						$location_name=trim(preg_replace('!\s+!', ' ',$val['location']));
	    				if($location_name == "" || $location_name == " "){
							$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
						}
						$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $user_id, $location_name);
	    				$db=array(
				    			'user_id'=>$user_id,
						    	'username'=>$user_name,
						    	'device_id'=>$device_id,
						    	'attendance_type'=>$type,
						    	'location'=>$location_name,
						    	'latitude'=>$latitude,
				    			'longitude'=>$longitude,
						    	'attendance_datetime'=>$report_time,
				    			'received_date'=>date("Y-m-d H:i:s")  			
				    		);
				    	$list = $this->master_db->insertRecord("attendance", $db);
	    			}
	    			echo json_encode(array( "status"=>"yes","msg"=>"success"));
	    		}
				else{
	    			echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
	    		}
			}
        	else{
	    		echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
	    	}
	    }
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
        }  
	    		
		/*$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$type=trim(preg_replace('!\s+!', '',$this->input->post('type')));
		$report_time=trim(preg_replace('!\s+!', ' ',$this->input->post('report_time')));
		$latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
		$longitude=trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
		$location_name=trim(preg_replace('!\s+!', ' ',$this->input->post('location_name')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $type!='' && $latitude!='' && $longitude!='')
        {
	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
		    	$db=array(
		    			'user_id'=>$verify[0]->userId,
				    	'username'=>$user_id,
				    	'device_id'=>$device_id,
				    	'attendance_type'=>$type,
				    	'location'=>$location_name,
				    	'latitude'=>$latitude,
		    			'longitude'=>$longitude,
				    	'attendance_datetime'=>$report_time,
		    			'received_date'=>date("Y-m-d H:i:s")  			
		    	);
		    	$list = $this->master_db->insertRecord("attendance", $db);  
		    	if($list){
		    		echo json_encode(array( "status"=>"yes","msg"=>"success"));
		    	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"Error in updating"));
		    	}
		    }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  */
    }
    
    function attendance(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$login = $logout = "";
	        	$attendance = $this->tasks_db->getAttendance($verify[0]->userId, 1);
	        	if(count($attendance)){
	        		$login = $attendance[0]->attendance_datetime;
	        	}
	        	
	        	$attendance = $this->tasks_db->getAttendance($verify[0]->userId, 0);
	        	if(count($attendance)){
	        		$logout = $attendance[0]->attendance_datetime;
	        	}
	        	echo json_encode(array("status"=>"yes","msg"=>"success", "login"=>$login, "logout"=>$logout));
	        }
            else
            {
            	echo json_encode(array("status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array("status"=>"no","msg"=>"Invalid Request"));
       }
    }
    
    
	function requestLeave(){
		$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		$from_date=trim(preg_replace('!\s+!', '',$this->input->post('from_date')));
		$to_date=trim(preg_replace('!\s+!', ' ',$this->input->post('to_date')));
		$reason=trim(preg_replace('!\s+!', '',$this->input->post('reason')));
		$report_time=trim(preg_replace('!\s+!', ' ',$this->input->post('report_time')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $from_date!='' && $to_date!='' && $mobile_no != '')
        {
	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
		    	$db=array(
		    			'user_id'=>$verify[0]->userId,
				    	'username'=>$user_id,
				    	'device_id'=>$device_id,
				    	'from_date'=>$from_date,
				    	'to_date'=>$to_date,
				    	'reason'=>$reason,
				    	'requested_datetime'=>$report_time,
		    			'received_date'=>date("Y-m-d H:i:s")  			
		    		);
		    	$list = $this->master_db->insertRecord("leave_requested", $db);  
		    	if($list){
		    		echo json_encode(array( "status"=>"yes","msg"=>"success"));
		    	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"Error in updating"));
		    	}
		    }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    function assigned_forms(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$list = $this->forms_db->getUserForms($verify[0]->userId, $verify[0]->companyid); 
	        	if(count($list)){
		    		echo json_encode(array( "status"=>"yes","msg"=>"success", "list"=>$list));
		    	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"No List Found"));
		    	}
	        }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    function form_fields(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		$form_id = trim(preg_replace('!\s+!', ' ',$this->input->post('form_id')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '' && $form_id != "")
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$fields = $this->forms_db->getUserFormsFields($verify[0]->userId, $form_id); 
	        	$field_values = array();
	        	if(count($fields)){
	        		foreach($fields as $f){	        			
	        			$values = $this->master_db->getRecords("form_field_values", array("field_id"=>$f->id, "is_active"=>1), "field_value");
	        			$field_values[] = array("name"=>$f->field_name, "type"=>$f->field_type, "values"=>$values); 
	        		}
		    		echo json_encode(array( "status"=>"yes","msg"=>"success", "fields"=>$field_values));
		    	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"Form Not Found"));
		    	}
	        }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
	function submitFormDetails(){
		$json = $this->input->post('form_json');
    	$data1 = json_decode($json, true);
    	
		if($_SERVER['REQUEST_METHOD']==='POST' && is_array($data1) && count($data1))
        {
			if(isset($data1['userid']) && isset($data1['deviceid']) && isset($data1['form_details'])){
    			$user_id = $data1['userid'];
    			$user_name = $data1['username'];
    			$device_id = $data1['deviceid'];
	    		$form_details = $data1['form_details'];
	    		if(is_array($form_details)){
	    			foreach ($form_details as $val){	    				
						$form_id=trim(preg_replace('!\s+!', '',$val['form_id']));
						$form_name=trim(preg_replace('!\s+!', '',$val['form_name']));
						$report_date=trim(preg_replace('!\s+!', ' ',$val['report_date']));
						$latitude=trim(preg_replace('!\s+!', '',$val['latitude']));
						$longitude=trim(preg_replace('!\s+!', '',$val['longitude']));
						$location_name=trim(preg_replace('!\s+!', ' ',$val['location']));
						$form_fields=$val['form_fields'];
						if(is_array($form_fields) && count($form_fields)){
							if($location_name == "" || $location_name == " "){
								$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
							}
							$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $user_id, $location_name);
							
							$db=array(
					    			'user_id'=>$user_id,
							    	'device_id'=>$device_id,
				    				'form_id'=>$form_id,
				    				'form_name'=>$form_name,
							    	'latitude'=>$latitude,
					    			'longitude'=>$longitude,
		    						'location'=>$location_name,
							    	'filled_by'=>$user_name,
									'filled_date'=>$report_date,
					    			'received_date'=>date("Y-m-d H:i:s")  			
					    		);
					    	$list = $this->master_db->insertRecord("submitted_forms", $db);
							foreach ($form_fields as $f){
								$field_name=trim(preg_replace('!\s+!', ' ',$f['field_name']));
								$field_value=trim(preg_replace('!\s+!', ' ',$f['field_value']));
								
			    				$db=array(
					    				'subid'=>$list,
								    	'field_name'=>$field_name,
								    	'field_value'=>$field_value,		
						    		);
						    	$this->master_db->insertRecord("submitted_formValues", $db);
							}
						}
						
	    			}
	    			echo json_encode(array( "status"=>"yes","msg"=>"success"));
	    		}
				else{
	    			echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
	    		}
			}
        	else{
	    		echo json_encode(array( "status"=>"no","msg"=>"Data is missing"));
	    	}
	    }
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
        }  
    }
    
    function notifications(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$notify = $this->forms_db->getUserNotifications($verify[0]->userId, $verify[0]->companyid); 
	        	$notify_values = array();
	        	if(count($notify)){
	        		foreach($notify as $f){
	        			$notification_date = $f->notification_date;
	        			if($notification_date == "0000-00-00 00:00:00" || $notification_date == null){
	        				$notification_date = date("Y-m-d H:i:s");
	        				$this->master_db->updateRecord("notification_users", array("notification_date"=>$notification_date), array("user_id"=>$f->uid));
	        			}	        			
	        			$notify_values[] = array("id"=>$f->id, "title"=>$f->title, "description"=>$f->description, "notification_date"=>$notification_date); 
	        		}
		    		echo json_encode(array( "status"=>"yes","msg"=>"success", "notifications"=>$notify_values));
		    	}
		    	else{
		    		echo json_encode(array( "status"=>"no","msg"=>"No Notifications"));
		    	}
	        }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    
	function status(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$values = $this->master_db->getRecords("statuses", array("statusid"=>$verify[0]->statusid), "statusdesc");
	        	$statusdesc = "Tracking OFF";
	        	if(count($values)){
	        		$statusdesc = $values[0]->statusdesc;
	        	}
	        	echo json_encode(array( "status"=>"yes","msg"=>"success", "start_date"=>$verify[0]->login_startdate, "status"=>$statusdesc, "last_updated"=>$verify[0]->last_updated));
	        }
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    
    function stopTracking(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		
		$latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
		$longitude = trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
		$location_name = trim(preg_replace('!\s+!', ' ',$this->input->post('location_name')));
		
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id != '' && $device_id != '' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
    			//$this->master_db->updateRecord("users", array("status"=>"Not Tracking", "last_updated"=>date("Y-m-d H:i:s")), array("id"=>$verify[0]->userId));
    			$date = date("Y-m-d H:i:s");
    			$day = date("D", strtotime($date));
	    		$day = strtolower($day);
    			if($latitude != '' && $longitude != ''){
	    			if($location_name == "" || $location_name == " "){
						$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
					}
					$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $verify[0]->userId, $location_name);
					$this->master_db->updateRecord("units", array("latitude"=>$latitude, "longitude"=>$longitude, "location"=>$location_name), array("unitnumber"=>$verify[0]->unitId));
					
					$sql = "INSERT INTO day_$day (user_id,unitnumber,mobile_no,user_name,device_id,distance,location_name,latitude,longitude,latitude_day,longitude_day,report_date,received_date,status)
								    VALUES (?,?,?,?,?,?,?,?,?,TRUNCATE($latitude,5),TRUNCATE($longitude,5),?,?,?);";
					    	$this->db->query($sql, array($verify[0]->userId, $verify[0]->unitId, $mobile_no, $user_id, $device_id, $verify[0]->distance, $location_name, $latitude, $longitude, $date, $date, 5));
    			}
    			$this->master_db->updateRecord("units", array("status"=>5, "reporttime"=>date("Y-m-d H:i:s"), "last_updated"=>date("Y-m-d H:i:s")), array("unitnumber"=>$verify[0]->unitId));
    			echo json_encode(array( "status"=>"yes","msg"=>"success"));
    		}
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
	function startTracking(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && $mobile_no != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
    			//$this->master_db->updateRecord("users", array("status"=>"Tracking", "login_startdate"=>date("Y-m-d H:i:s")), array("id"=>$verify[0]->userId));
    			$this->master_db->updateRecord("units", array("status"=>4, "startdate"=>date("Y-m-d H:i:s")), array("unitnumber"=>$verify[0]->unitId));
    			echo json_encode(array( "status"=>"yes","msg"=>"success"));
    		}
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
	public function getDayName($day){
		$table = null;
		
		switch ($day) {
        case 0:  $table = "day_sun";
                 break;
        case 1:  $table = "day_mon";
                 break;
        case 2:  $table = "day_tue";
                 break;
        case 3:  $table = "day_wed";
                 break;
        case 4:  $table = "day_thu";
                 break;
        case 5:  $table = "day_fri";
                 break;
        case 6: $table = "day_sat";
                 break;
        default: break;
        //case 0: $table = "day_sat";
               //  break;
		}
		
		
		return $table;
		
	}
    
	function updatefile(){
		$lastruntime = $lastruntime_day = "";
    	$lastruntime_month = null;
    	$nextcurrentdate = $currentdate = date("Y-m-d H:i:s");
    	
    	$currenttime_day = date("N");
    	$currenttime_month = date("m");
    	//$myfile = fopen("lastruntime.txt", "r") or die("Unable to open file!");
		//echo fread($myfile,filesize("lastruntime.txt"));
		
		echo $handle = fopen("lastruntime.txt", "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        // process the line read.
		        $lastruntime = $line."\r\n";
		    }
		
		    
		    
		    echo $replace_lt_ct = str_replace($lastruntime, $currentdate, $lastruntime);
		    $file = 'lastruntime.txt';
    		file_put_contents($file, $replace_lt_ct, FILE_APPEND | LOCK_EX);
    		fclose($handle);
		    
    		$lastruntime_day = date("N", strtotime($lastruntime));
	        $lastruntime_month = strtolower(date("m", strtotime($lastruntime)));
    		
		} else {
		    // error opening the file.
		    $file = 'lastruntime.txt';
    		echo $log_array = $currentdate;
    		file_put_contents($file, $log_array , FILE_APPEND | LOCK_EX);
    		//fclose($handle);
		} 
	}
	
	function replayData(){
    	$user_id=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		$start_date=trim(preg_replace('!\s+!', ' ',$this->input->post('start_date')));
		$end_date = trim(preg_replace('!\s+!', ' ',$this->input->post('end_date')));
		if($_SERVER['REQUEST_METHOD']==='POST' && $user_id!='' && $device_id!='' && 
			$mobile_no != '' && $start_date!='' && $end_date != '')
        {	    	
	    	$db['username']=$user_id;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        {
		    	$start = $start_date;
		    	$start = explode(" ", $start);
		    	$start1 = explode("-", $start[0]);
		    	$start2 = $start[1];
		    	$start_date = $start1[2]."-".$start1[1]."-".$start1[0]." ".$start2;
		    	$end = $end_date;
		    	$end = explode(" ", $end);
		    	$end1 = explode("-", $end[0]);
		    	$end2 = $end[1];
		    	$end_date = $end1[2]."-".$end1[1]."-".$end1[0]." ".$end2;
		    	$start_date = date('Y-m-d H:i:s', strtotime($start_date));
		    	$end_date = date('Y-m-d H:i:s', strtotime($end_date));
		    	$db=array(
		    			'detail'=>$verify,   
		    			//'unitno'=>$this->input->post('unitno'),
				    	'start_date'=>$start_date,
				    	'to_date'=>$end_date, 
		    			'startMonth'=>$start1[1],
				    	'toMonth'=>$end1[1],    			
		    	);
		    	echo json_encode(array( "status"=>"yes","msg"=>"success", "data"=>$this->tasks_db->gettable_replay($db)));
	    	}
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }   
	    }
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }    
    }
    
    function day2history(){
    	
    	$lastruntime = $lastruntime_day = "";
    	$lastruntime_month = null;
    	$nextcurrentdate = $currentdate = date("Y-m-d H:i:s");
    	
    	$currenttime_day = date("N");
    	$currenttime_month = date("m");
    	//$myfile = fopen("lastruntime.txt", "r") or die("Unable to open file!");
		//echo fread($myfile,filesize("lastruntime.txt"));
		$file = 'lastruntime.txt';
		$handle = fopen($file, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        // process the line read.
		        $lastruntime = $line;
		    }
		
		    fclose($handle);
		    unlink($file);
		   // echo "before=".$lastruntime;
		    $replace_lt_ct = str_replace($lastruntime, $currentdate, $lastruntime);
		   // echo "after=".$replace_lt_ct;
    		file_put_contents($file, $replace_lt_ct , FILE_APPEND | LOCK_EX);
    		
		    
    		$lastruntime_day = date("N", strtotime($lastruntime));
	        $lastruntime_month = strtolower(date("m", strtotime($lastruntime)));
    		
		} else {
		    // error opening the file.
    		$log_array = $currentdate;
    		file_put_contents($file, $log_array , FILE_APPEND | LOCK_EX);
    		//fclose($handle);
		} 
		$daymap = array();
    	if($lastruntime_day=="" && $lastruntime_month==null){
	        	
        	$daytable = $this->getDayName($currenttime_day);
        	$historytable = "history".$currenttime_month;
        	$daymap["daytable"] = $daytable;
        	$daymap["historytable"] = $historytable;
        	$daymap["currentdate"] = $currentdate;
        	$this->tasks_db->insertdayintohistory($daymap);	        	
        }
        else if($lastruntime_day!=0 && $lastruntime_month!=null)
        {
	        	if($currenttime_day == $lastruntime_day && $currenttime_month == $lastruntime_month)
	        	{
	        		$daytable = $this->getDayName($currenttime_day);
	        		$predaytable = $this->getDayName($currenttime_day-1);
		        	$historytable = "history".$currenttime_month;
		        	$daymap["daytable"] = $daytable;
		        	$daymap["predaytable"] = $predaytable;
		        	$daymap["historytable"] = $historytable;
		        	$daymap["currentdate"] = $currentdate;
		        	$daymap["lastruntime"] = $lastruntime;
		        	$daymap["timeinterval"] = "1";
		        	$this->tasks_db->insertdayintohistoryinterval($daymap);
		        	
	        	}
	        	else{
	        		   if($lastruntime_day!=0 && $lastruntime_month!=null){
			        		$daytable = $this->getDayName($lastruntime_day);
			        		$predaytable = $this->getDayName($currenttime_day-1);
				        	$historytable = "history".$lastruntime_month;
				        	$currentdate = substr($lastruntime, 0, 11);
				        	$currentdate=$currentdate."23:59:59";
				        	$daymap["daytable"] = $daytable;
				        	$daymap["predaytable"] = $predaytable;
				        	$daymap["historytable"] = $historytable;
				        	$daymap["lastruntime"] = $lastruntime;
				        	$daymap["currentdate"] = $currentdate;
				        	$daymap["timeinterval"] = "0";
				        	$this->tasks_db->insertdayintohistoryinterval($daymap);
				        	
	        		    }
			        	if($currenttime_day!=0 && $currenttime_month!=null)
			        	 {
			        		    $daytable = $this->getDayName($currenttime_day);
			        		    $predaytable = $this->getDayName($currenttime_day-1);
					        	$historytable = "history".$currenttime_month;
					        	$lastruntime = substr($nextcurrentdate, 0, 11);
					        	$lastruntime = $lastruntime."00:00:00";
					        	$daymap["daytable"] = $daytable;
					        	$daymap["predaytable"] = $predaytable;
					        	$daymap["historytable"] = $historytable;
					        	$daymap["lastruntime"] = $lastruntime;
					        	$daymap["currentdate"] = $nextcurrentdate;
					        	$daymap["timeinterval"] = "1";
					        	$this->tasks_db->insertdayintohistoryinterval($daymap);
					        	
			        	 }
             	}
        }
		$this->tasks_db->setOffline();
     	//unlink('../' . $check[0]->categ_image);
    }
    
    public function location_snapshot(){
		
    	//$json = file_get_contents("php://input");
    		
    		/*$file = 'location.txt';
    		$log_array = $_FILES['files']['type'];
    		$log_array .= $_FILES['files']['size'];
    		$log_array .= $_FILES['files']['name'];
    		file_put_contents($file, $log_array , FILE_APPEND | LOCK_EX);*/
    	
    	$datetime = trim(preg_replace('!\s+!', ' ',$this->input->post('report_date')));
    	$latitude = trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
    	$longitude = trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
    	$location_name = trim(preg_replace('!\s+!', ' ',$this->input->post('location_name')));
    	$user_name=trim(preg_replace('!\s+!', ' ',$this->input->post('username')));
		$device_id=trim(preg_replace('!\s+!', ' ',$this->input->post('device_id')));
		$mobile_no = trim(preg_replace('!\s+!', ' ',$this->input->post('mobile_no')));
		
    	if($_SERVER['REQUEST_METHOD'] == 'POST' && $user_name!='' && $device_id!='' && $mobile_no != '' && 
    			isset($_FILES) && isset($_FILES['files']) && $datetime != "" && $latitude != "" && $longitude != "")
    	{
    		
    		$db['username']=$user_name;
	    	$db['condition'] = " U.role='u' and un.gsmnumber='$mobile_no' and un.device_id='".$device_id."' and ";
	    	$verify = $this->home_db->getloginUser($db,0);
	        if(count($verify)) // login check
	        { 
	        	$foldername = $verify[0]->folder_name;
	    		$arry = array("gif","jpg","png","ico","jpeg");
	    		$uploaddir = 'assets/'.$foldername.'/';
	    		$uploadDBdir= "assets/".$foldername."/";
	    		
	    		$arrayImage=$_FILES['files']['name'];
	    		$arrayTemp=$_FILES['files']['tmp_name'];
	    		$imagename = explode(".", $arrayImage);
				$ext = strtolower($imagename[1]);
				$imagename = $imagename[0];
	        	if(in_array($ext,$arry)){    					
		        	if(!is_dir("assets/".$foldername)){
						mkdir("assets/".$foldername);
					}
    					
					$image_name = $imagename.time().'.'.$ext;
    				$uploadfile = $uploaddir.$image_name;
    				$uploadfileTable1 = $uploadDBdir.$image_name;
    				$img1up = move_uploaded_file($arrayTemp,$uploadfile);
                    // $this->home_db->resizeImagef($uploadfileTable1, 1000, 500);
	        		if($location_name == "" || $location_name == " "){
						$location_name = $this->tasks_db->getLocationName($latitude, $longitude);
					}
					$location_name = $this->tasks_db->getCustomLocation($latitude, $longitude, $verify[0]->userId, $location_name);
					$db = array(
							'location_images'=>$uploadfileTable1,
							'location_name'=>$location_name,
							'latitude'=>$latitude,
							'longitude'=>$longitude,
							'report_date'=>$datetime,
							'received_date'=>date("Y-m-d H:i:s"),
							'user_id'=>$verify[0]->userId,
							'username'=>$user_name,
							'device_id'=>$device_id
						);
					$this->master_db->insertRecord('location_snapshot',$db);
					echo json_encode(array( "status"=>"yes","msg"=>"Success"));
                }
                else{
                	echo json_encode(array( "status"=>"no","msg"=>"Invalid Image File. Error in uploading."));
                }	
    		
    		}
            else
            {
            	echo json_encode(array( "status"=>"no","msg"=>"Invalid User"));
            }  
    	}
        else{
        	echo json_encode(array( "status"=>"no","msg"=>"Invalid Request"));
       }  
    }
    
    function generatePass(){
    	require_once 'includes/PkcsKeyGenerator.php';
			require_once 'includes/DesEncryptor.php';
			require_once 'includes/PbeWithMd5AndDes.php';
			
			$salt ='A99BC8325634E303';
	
			// Iteration count
			$iterations = 19;
			$segments = 1;
			$password = '12345678';

			//secret key
			$keystring = 'akd89343My Pass Phrase';
				
			//encrypt the user entered password
			echo $crypt = PbeWithMd5AndDes::encrypt(
						$password, $keystring,
						$salt, $iterations, $segments
					);
					
					$this->tasks_db->setOffline();
    }
  

}

?>