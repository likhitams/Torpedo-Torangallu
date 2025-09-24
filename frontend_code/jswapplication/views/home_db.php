<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home_db extends CI_Model{
	

	function sendmailer($to,$subject, $body){
	
		$this->load->library('email');
	
		$config = array (
	
				'mailtype' => 'html',
	
				'charset'  => 'utf-8',
	
				'priority' => '1'
	
		);
	
		$this->email->initialize($config);
	
		$this->email->from("info@ivarustech.com", "info");
	
		$this->email->to($to);
	
		$this->email->subject($subject);
	
		$this->email->message($body);
	
		$sent = $this->email->send();
	
		return $sent;
	
	}
	
	function getHistoryTable($startDate, $endDate, $unitno){
		$tablename = $condition = "";
		
		$start = explode(" ", $startDate);
    	$start1 = explode("-", $start[0]);
    	$startMonth = $start1[1];
    	
    	$end = explode(" ", $endDate);
    	$end1 = explode("-", $end[0]);
    	$toMonth = $end1[1];
    	
		settype($startMonth, "integer"); 
		settype($toMonth, "integer"); 
		for($i=$startMonth; $startMonth <= $toMonth; $startMonth++)  
	    {  
	    	$tablename = $tablename.$condition." (SELECT * FROM history". ($startMonth<10?"0":"") . $startMonth . " where lno='$unitno') " ;
	    	$condition =" UNION ";
	    }
	    
	    $startMonth = $start1[1];
		$toMonth = $end1[1];
		 if($startMonth>$toMonth)
	       {
	    	
	    	   for($i=$startMonth; $startMonth <= 12; $startMonth++)  
	 	      {  
	    		   $tablename = $tablename.$condition." (SELECT * FROM history". ($startMonth<10?"0":"") . $startMonth . "  where lno='$unitno') " ;
	 	    	   $condition = " UNION ";
	 	    	   
	 	       }
	    	  
	    	   for($i=1; $i <= $toMonth; $i++)  
		 	      {  
	    		   
		               $tablename = $tablename.$condition." (SELECT * FROM history". ($i<10?"0":"") . $i . "  where lno='$unitno') " ;
		 	    	   $condition = " UNION ";
		 	    	   
		 	       }
	    	 
	       }
	     return $tablename;  
	}
	
	function getGroupHistoryTable($startDate, $endDate){
		$tablename = $condition = "";
		
		$start = explode(" ", $startDate);
    	$start1 = explode("-", $start[0]);
    	$startMonth = $start1[1];
    	
    	$end = explode(" ", $endDate);
    	$end1 = explode("-", $end[0]);
    	$toMonth = $end1[1];
    	
		settype($startMonth, "integer"); 
		settype($toMonth, "integer"); 
		for($i=$startMonth; $startMonth <= $toMonth; $startMonth++)  
	    {  
	    	$tablename = $tablename.$condition." (SELECT * FROM history". ($startMonth<10?"0":"") . $startMonth . ") " ;
	    	$condition =" UNION ";
	    }
	    
	    $startMonth = $start1[1];
		$toMonth = $end1[1];
		 if($startMonth>$toMonth)
	       {
	    	
	    	   for($i=$startMonth; $startMonth <= 12; $startMonth++)  
	 	      {  
	    		   $tablename = $tablename.$condition." (SELECT * FROM history". ($startMonth<10?"0":"") . $startMonth . "  ) " ;
	 	    	   $condition = " UNION ";
	 	    	   
	 	       }
	    	  
	    	   for($i=1; $i <= $toMonth; $i++)  
		 	      {  
	    		   
		               $tablename = $tablename.$condition." (SELECT * FROM history". ($i<10?"0":"") . $i . "  ) " ;
		 	    	   $condition = " UNION ";
		 	    	   
		 	       }
	    	 
	       }
	     return $tablename;  
	}
	
	function getHistoryTableName($startDate, $endDate){
		$tablename = $condition = "";
		
		$start = explode(" ", $startDate);
    	$start1 = explode("-", $start[0]);
    	$startMonth = $start1[1];
    	
    	$end = explode(" ", $endDate);
    	$end1 = explode("-", $end[0]);
    	$toMonth = $end1[1];
    	
		settype($startMonth, "integer"); 
		settype($toMonth, "integer"); 
		
		if($startMonth != $toMonth ){
			$table = ($startMonth<10?"0":"") . $startMonth. "~".($toMonth<10?"0":"") . $toMonth;
		}
		else{
			$table = ($startMonth<10?"0":"") . $startMonth;
		}
		
	     return $table;  
	}
	
	function getTripTableName($startDate, $endDate, $unitno){
		
		$tablename = $condition = "";
		
		$start = explode(" ", $startDate);
    	$start1 = explode("-", $start[0]);
    	$startMonth = $start1[1];
    	
    	$end = explode(" ", $endDate);
    	$end1 = explode("-", $end[0]);
    	$toMonth = $end1[1];
    	
		settype($startMonth, "integer"); 
		settype($toMonth, "integer"); 
		for($i=$startMonth; $startMonth <= $toMonth; $startMonth++)  
	    {  
	    	$tablename = $tablename.$condition." (SELECT * FROM trips". ($startMonth<10?"0":"") . $startMonth . " where unitnumber=$unitno) " ;
	    	$condition =" UNION ";
	    }
	    
	    $startMonth = $start1[1];
		$toMonth = $end1[1];
		 if($startMonth>$toMonth)
	       {
	    	
	    	   for($i=$startMonth; $startMonth <= 12; $startMonth++)  
	 	      {  
	    		   $tablename = $tablename.$condition." (SELECT * FROM trips". ($startMonth<10?"0":"") . $startMonth . "  where unitnumber=$unitno) " ;
	 	    	   $condition = " UNION ";
	 	    	   
	 	       }
	    	  
	    	   for($i=1; $i <= $toMonth; $i++)  
		 	      {  
	    		   
		               $tablename = $tablename.$condition." (SELECT * FROM trips". ($i<10?"0":"") . $i . "  where unitnumber=$unitno) " ;
		 	    	   $condition = " UNION ";
		 	    	   
		 	       }
	    	 
	       }
	     return $tablename;  
	}
	
	
function getGroupTripTableName($startDate, $endDate){
		
		$tablename = $condition = "";
		
		$start = explode(" ", $startDate);
    	$start1 = explode("-", $start[0]);
    	$startMonth = $start1[1];
    	
    	$end = explode(" ", $endDate);
    	$end1 = explode("-", $end[0]);
    	$toMonth = $end1[1];
    	
		settype($startMonth, "integer"); 
		settype($toMonth, "integer"); 
		for($i=$startMonth; $startMonth <= $toMonth; $startMonth++)  
	    {  
	    	$tablename = $tablename.$condition." (SELECT * FROM trips". ($startMonth<10?"0":"") . $startMonth . " ) " ;
	    	$condition =" UNION ";
	    }
	    
	    $startMonth = $start1[1];
		$toMonth = $end1[1];
		 if($startMonth>$toMonth)
	       {
	    	
	    	   for($i=$startMonth; $startMonth <= 12; $startMonth++)  
	 	      {  
	    		   $tablename = $tablename.$condition." (SELECT * FROM trips". ($startMonth<10?"0":"") . $startMonth . "  ) " ;
	 	    	   $condition = " UNION ";
	 	    	   
	 	       }
	    	  
	    	   for($i=1; $i <= $toMonth; $i++)  
		 	      {  
	    		   
		               $tablename = $tablename.$condition." (SELECT * FROM trips". ($i<10?"0":"") . $i . "  ) " ;
		 	    	   $condition = " UNION ";
		 	    	   
		 	       }
	    	 
	       }
	     return $tablename;  
	}

	function getlogin($db=array(), $check=1, $pas = ""){
		$pass = "";
		if($check){
			require_once 'includes/PkcsKeyGenerator.php';
			require_once 'includes/DesEncryptor.php';
			require_once 'includes/PbeWithMd5AndDes.php';
			
			$salt ='A99BC8325634E303';
	
			// Iteration count
			$iterations = 19;
			$segments = 1;
			$password = $db['password'];	
			//secret key
			$keystring = 'akd89343My Pass Phrase';
				
			//encrypt the user entered password
			$crypt = PbeWithMd5AndDes::encrypt(
						$password, $keystring,
						$salt, $iterations, $segments
					);
			$pass = " AND U.epassword like '".$crypt."' ";
		}
		
		if($pas != ""){
			$pass = " AND U.epassword like '".$pas."' ";
		}

		$sql="SELECT U.id AS userId,
			U.user_id AS username,
			U.epassword AS password,
			U.company_id AS companyid,
			c.timezone AS timezone,
			c.dateformat AS dateformat,
			U.fuelWidth as fuelWidth,
			U.altitudeWidth as altitudeWidth,
			U.mapView as mapView,
			U.dashboard as udashboard,
			U.fleetview as ufleetview,
			U.reports as ureports,
			U.operations as uoperations,
			U.config as uconfig,
			U.retrac as retrac,
			U.fivemt as fivemt,
		    U.tenmt as tenmt,
			c.column8width AS column8width,
			c.column9width AS column9width,
			c.companylogo AS companylogo,
			c.languageid AS language,
			c.message AS welcomeMsg,
			c.is_active As active,
			IFNULL(cn.message,'') AS message,
			IFNULL(cn.date,'') AS greetingmsgdate,
			IFNULL(cn.todate,'') AS todate,
			IFNULL(cn.msgtype,'') AS msgtype,
			U.role AS userRole, 
			U.is_loggedin as loggedIn FROM users U 
			LEFT JOIN companies c ON U.company_id=c.companyid
			LEFT JOIN users_notify cn ON cn.user_id=U.id
			WHERE
			U.user_id = '".$db['username']."' $pass AND U.is_delete=FALSE AND c.is_delete=false";

		$q=$this->db->query($sql); 

		return $q->result();
		
	}
	
	function getQuestion($email, $question = ""){
		$sql="SELECT q.question AS question,q.id AS questionId,uq.answer AS answer, u.id userId, u.user_id AS username
				FROM users_question uq
				LEFT JOIN users u ON u.id=uq.user_id
				LEFT JOIN users_profile up ON up.user_id=u.id
				LEFT JOIN questions q ON q.id=uq.question_id
				WHERE u.is_delete=FALSE AND up.email='".$email."' $question
				ORDER BY RAND() LIMIT 0,1;";

		$q=$this->db->query($sql); 

		return $q->result();
	}
	
	function clearSession($session, $session_data, $session_pwd = ""){
		$this->session->unset_userdata($session);
        $this->session->unset_userdata($session_data);
        $this->session->unset_userdata("unitno");
	    $cookie = array(
	    		'name'   => $session,
	    		'value'  => '',
	    		'expire' => '0',
	    		'domain' => '.suvetracg',
	    		'path'   => '/',
	    		'prefix' => 'suve_',
               );
		delete_cookie($cookie);
		$cookie = array(
	    		'name'   => $session_pwd,
	    		'value'  => '',
	    		'expire' => '0',
	    		'domain' => '.suvetracg',
	    		'path'   => '/',
	    		'prefix' => 'suve_',
               );
		delete_cookie($cookie);
	}
	
	function secondsToTime($ss) {
		$s = $ss%60;
		$m = floor(($ss%3600)/60);
		$h = floor(($ss%86400)/3600);
		//$d = floor(($ss%2592000)/86400);
		//$M = floor($ss/2592000);
	
		$d = floor(($ss)/86400)."d";
	
		// Ensure all values are 2 digits, prepending zero if necessary.
		$s = $s < 10 ? '0' . $s."s" : $s."s";
		$m = $m < 10 ? '0' . $m."m" : $m."m";
		$h = $h < 10 ? '0' . $h."h" : $h."h";
		//$d = $d < 10 ? '0' . $d : $d;
		//$M = $M < 10 ? '0' . $M : $M;
	
		//return "$M:$d:$h:$m:$s";
		
		return "$d $h $m $s";
	
	}
	
	function checkSession($session, $session_data,$cookie, $cookie_pwd=""){
		$det = array();
		if($this->session->userdata($session)){
        	$details = $this->session->userdata($session_data);
        	$db['username']=$details[0]->username;
            $det=$this->home_db->getlogin($db,0, $details[0]->password);	
	        if(count($det)>0 && $det[0]->password != $details[0]->password){
	            $det = array();
	        }		
	    }
	    else if($cookie!=""){
	        $db['username']=$cookie;
	        $det=$this->home_db->getlogin($db,0, $cookie_pwd);
	    }
	    return $det;
	}
	
	function countRec($fname,$tname,$where)
    {
		$sql = "SELECT $fname FROM $tname $where";
    	$q=$this->db->query($sql);
        return $q->num_rows();
    }
		
    function updatelogin($db =array(),$id,$login)
    {
    	$this->db->where('user_id',$id);
    	$this->db->where('login_time',$login); 
    	$q=$this->db->update('login_report',$db);
    	$total = $this->db->affected_rows();
    	if($total>0)
    		return 1;
    	else
    		return 0;
    }

	
	//--Forgot pwd
	
	
	
	public function resizeImage($filename,$width, $height){
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/admin_manage/'.$filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/admin_manage/'.$filename;
		$this->image_lib->initialize($config);
		
		if(!$this->image_lib->resize())
		{
			
			return $this->image_lib->display_errors();
		}
		else{
			
			return 1;
		}
		$this->image_lib->clear();
	
	}
	
	

	public function updatepassword($db = array())
	{
	
		require_once 'includes/PkcsKeyGenerator.php';
		require_once 'includes/DesEncryptor.php';
		require_once 'includes/PbeWithMd5AndDes.php';
			
		$salt ='A99BC8325634E303';
	
		// Iteration count
		$iterations = 19;
		$segments = 1;
		$password = $db['password'];	
		//secret key
		$keystring = 'akd89343My Pass Phrase';
			
		//encrypt the user entered password
		$crypt = PbeWithMd5AndDes::encrypt(
					$password, $keystring,
					$salt, $iterations, $segments
				);
	
		$sql="update users set epassword='".$crypt."' where id = ".$db['user_id'];	
	
		$q=$this->db->query($sql);
	
		return $total = $this->db->affected_rows();
	
	}
	
	
	
	function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
	
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );
		$previous ='';
			
		while( $current <= $last ) {
	
			$start = date( $format, $current );
			$current = strtotime( $step, $current );
			//$end = date( $format, strtotime('-1 day',$current) );
			$dates[] = $start;
		}
			
		return $dates;
	}
	
	public function arrange_dates($fromdate, $todate){
		// Start date
		$date = $fromdate;
		// End date
		$end_date = $todate;
		$array_final = array();
		$finaldate = '';
		$array  = array();
		$i=0;
		while (strtotime($date) <= strtotime($end_date)) {
			if($i%7==0 && $i>0){
				array_push($array_final,$array);
				$array  = array();
				$finaldate = $date;
			}
	
			array_push($array,$date);
	
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			$i++;
		}
		if(strtotime($finaldate) <= strtotime($end_date)){
			array_push($array_final,$array);
		}
	
		return $array_final;
	}
	
	//ALert Notification DB  servicedate<=CURDATE() AND
	
	function getServiceAlert($det){
	    $compny = $det[0]->companyid;
		$sql = "SELECT id, ladleno ladle_no, DATE_FORMAT(STR_TO_DATE(servicedate, '%Y-%m-%d'), '%d-%m-%Y') service_date FROM ladle_master where companyid = '$compny' AND servicedate<=CURDATE() AND  servicedate servicedate is not null order by servicedate  LIMIT 6  ";
	    $result = $this->db->query($sql);
	    
	    return $result->result();
	}
	
	
	 function getMovedFileAlert($db=array()){
		 
		$uid = $db['detail'][0]->userId;
		
		$sql = "SELECT TAG,TAG_DESCRIPTION,DATE_FORMAT(TIME,'%d-%m-%Y %H:%i:%s') as TIME, REPLACE(TRACKID, 'TORPEDO', '') as TRACKID,SEQ_VALUE, INSERT_DT,MSG_FLAG,userId from TLC_GPS_LATEST where  userId= '$uid' order by INSERT_DT DESC  LIMIT 6 ";
        
        $result = $this->db->query($sql);
        return $result->result();
    }
	
	 function getEmptySignalAlertCount($db=array()){
		 
		 $uid = $db['detail'][0]->userId;
		 
		 $sql = "select count(*) as count  from TLC_GPS_LATEST where  MSG_FLAG='N' and userId= '$uid' ";
	
        
        $result = $this->db->query($sql);
		 
        return $result->result();
    }

}

?>