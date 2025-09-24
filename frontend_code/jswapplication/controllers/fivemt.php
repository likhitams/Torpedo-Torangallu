<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fivemt extends CI_Controller {

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
		$this->data['refCountListfivemt']=$this->load->view('refCountListfivemt', NULL , TRUE);
		$this->data['header']=$this->load->view('header', $this->data , TRUE);
		$this->data['left']=$this->load->view('left', NULL , TRUE);
		$this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);		 
    }

    public function index()
    {    		
    	
		$this->load->view('fivemt_view',$this->data);       
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
    	//echo "[".implode(", ", $arr)."]";
    }
    
    public function getfivemtListCount(){
    	echo $this->data['refCountListfivemt'];    
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