<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tenmt extends CI_Controller {

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
        $this->load->model('sms_db');
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
		$this->data['refCountListtenmt']=$this->load->view('refCountListtenmt', NULL , TRUE);
		$this->data['header']=$this->load->view('header', $this->data , TRUE);
		$this->data['left']=$this->load->view('left', NULL , TRUE);
		$this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);		 
    }

    public function index()
    {    		
    	
		//$this->load->view('tenmt_view',$this->data);   
         $this->load->view('dashboard_view1',$this->data);   		
    } 
    
    public function index1()
    {    		
    	
		$this->load->view('dashboard_view1',$this->data);       
    } 
    
	public function getListdata()
    {    	
    	
    	$db=array(
    			'detail'=>$this->data['detail'],       			
    	);
    	$this->data['response'] = $response = $this->grid_db->gettable_fleetlist($db);  
    	$arr = array(); 
    	
    	echo json_encode($response);   
    	//echo "[".implode(", ", $arr)."]"; fivemt
    }
    
    public function gettenmtListCount(){
    	echo $this->data['refCountListtenmt'];    
    }
    
    function shiftData(){
        
         //$date = "2020-03-11";
       $date = $this->input->get("shiftdate");
        $shift = $this->input->get("shift");
        $target = $this->sms_db->getTargetProduction($date);
        $actual = $this->sms_db->getActualProduction($date, $shift);
        $empty = array((object) array("BF_PRODA"=>0));
        $a = $this->sms_db->getActualProduction($date, "a");
        $b = $this->sms_db->getActualProduction($date, "b");
        $c = $this->sms_db->getActualProduction($date, "c");
        
        $total_target = $target[0]->target;
        $a_actual = $a[0]->BF_PRODA;
        $b_actual = $b[0]->BF_PRODA;
        $c_actual = $c[0]->BF_PRODA;
        
        $c_target = intval($total_target/3);
        $c_left = $total_target - $c_actual;
        if($c_left < 0){ $c_left = 0;}
        
        $a_target = intval($c_left/2);
        
       // $b_target = $total_target - $c_actual - $a_actual;
	     $b_target = intval($c_left/2);
		 
        $hour_target = $total_target;
        switch($shift){
            case "a": $total_target = $a_target; $hourwise = $this->sms_db->getActualProduction($date, "a", 1); $hour_target = intval($a_target/8);break;
            case "b": $total_target = $b_target; $hourwise = $this->sms_db->getActualProduction($date, "b", 1); $hour_target = intval($b_target/8);break;
            case "c": $total_target = $c_target; $hourwise = $this->sms_db->getActualProduction($date, "c", 1); $hour_target = intval($c_target/8);break;
            default: $hourwise = $this->sms_db->getActualProduction($date, "", 1); break;
        }
        
        $laddle = $this->sms_db->getLaddleProduction($date, $shift);
        
        $laddle_trip_cnt = $this->sms_db->getLaddleProductionTripCount($date, $shift);
        $textarr = $this->sms_db->getTextColor();
        $labels = $dataset = $dataset_color = array();
        $i=0;
        foreach ($laddle as $l){$i++;if($i > 16){$i=1;}
           
            $l->color = $textarr[$i]["color"];
        } 
        
        $i=0;
        foreach ($laddle_trip_cnt as $l){$i++;if($i > 16){$i=1;}
        
        $l->color = $textarr[$i]["color"];
        } 
        $target_per_actual = intval(($actual[0]->BF_PRODA/$total_target)*100);
        $target_per_actual = $target_per_actual > 100 ? 100 : $target_per_actual;
        $target_per = $this->roundUpToAny($target_per_actual);
        
        $c_per_actual = intval(($c_actual/$c_target)*100);
        $c_per_actual = $c_per_actual > 100 ? 100 : $c_per_actual;
        $c_per = $this->roundUpToAny($c_per_actual);
        
        $a_per_actual = intval(($a_actual/$a_target)*100);
        $a_per_actual = $a_per_actual > 100 ? 100 : $a_per_actual;
        $a_per = $this->roundUpToAny($a_per_actual);
        
        $b_per_actual = intval(($b_actual/$b_target)*100);
        $b_per_actual = $b_per_actual > 100 ? 100 : $b_per_actual;
        $b_per = $this->roundUpToAny($b_per_actual);
                
        echo json_encode(array("target"=>$this->master_db->getnumberformat($total_target), "actual"=>$this->master_db->getnumberformat($actual[0]->BF_PRODA), 
            "target_per_actual"=>$target_per_actual,"target_per"=>$target_per,
            "c_actual"=>$c_actual, "c_target"=>$c_target, "c_per"=>$c_per, "c_per_actual"=>$c_per_actual,
            "a_actual"=>$a_actual, "a_target"=>$a_target, "a_per"=>$a_per, "a_per_actual"=>$a_per_actual, 
            "b_actual"=>$b_actual, "b_target"=>$b_target, "b_per"=>$b_per, "b_per_actual"=>$b_per_actual, 
            "laddle"=>$laddle, "trips"=>$laddle_trip_cnt, "hourwise"=>$hourwise, "hour_target"=>$hour_target));
             
    }
    
    function roundUpToAny($n,$x=5) {
        return (round($n)%$x === 0) ? round($n) : round(($n+$x/2)/$x)*$x;
    }
    
    
	public function getTiming(){
    	echo date('d-m-Y H:i a');
    }

    public function logout()
    {
        $this->home_db->clearSession($this->data['session'],$this->data['session_data']);
        $this->db->close();
        redirect('userlogin');

    }
    
    
    public function updatelogin(){
    	$cookie=$this->data['detail'];
    	if(!empty($cookie))
    	{
    		$id=$cookie[0]->id;
    		$last_login=$cookie[0]->last_login;
    		$db = array(
    				'logout_time'   => date('Y-m-d H:i:s')
    		);
    		$this->home_db->updatelogin($db,$id,$last_login);
    	}
    }
	
	//My profile

	

	public function check_password(){
	if($_SERVER['REQUEST_METHOD']=='GET'){
    		$oldpass = $this->input->get('pass');
    		$det = $this->data['detail'];
    		$id = $det[0]->passwrd;
    		if(strcmp(sha1($oldpass),$id) == 0){   
    			echo 1;
    		}
    		else{
    			echo 0;
    		}
    		//echo $this->account_db->check_password(sha1($oldpass),$id);
    	}
    	else{
    		echo 0;
    	}
	}
	
	public function check_admin(){
    	$business = trim(preg_replace('!\s+!', '',$this->input->get('email')));
    	$id = trim(preg_replace('!\s+!', '',$this->input->get('id')));
    	
    	if($business != "" && $id != ""){
    		$db = array("email"=>$business, "id !="=>$id, "status !="=>2);    
    		$check = $this->master_db->getRecords("admin",$db,"id");
    		//echo $this->db->last_query();
    		if(count($check)>0){
    			echo 1;//exists
    		}
    		else echo 0;//does not exists
    	}
    	else echo 1;
    }
}

/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */