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
        $this->load->model('grid_db');
    }
  

    public function login(){
    	
    	if($_SERVER['REQUEST_METHOD']==='POST' && $this->input->post('username')!='')
        {
            $db['username']=$this->input->post('username');
            $db['password']=$this->input->post('password');
            $verify = $this->home_db->getlogin($db,1);
            if(count($verify)) // login check
            {
              echo json_encode(array( "status"=>"yes","act"=>"login","msg"=>"Login Successfull","details"=>$verify));
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
    
	public function fleet_list(){
    	
    	if($_SERVER['REQUEST_METHOD']==='POST' && $this->input->post('username')!='')
        {
            $db['username']=$this->input->post('username');
            $start=$this->input->post('start');
            $last=$this->input->post('last');
            $status=$this->input->post('status');
            $unitno=$this->input->post('unitno');
            $verify = $this->home_db->getlogin($db,0);
            $condition = "";
            if(count($verify)) // login check
            {
            	$limit = "";
            	if($start != "" && $last != ""){$limit = " limit $start, $last ";}
            	if($status != ""){
            		$condition = " and s.statusid=$status ";
            	}
            	if($unitno != ""){
            		$condition .= " and un.unitnumber=$unitno ";
            	}
            	$db = array("detail"=>$verify);
              	$fleet = $this->grid_db->gettable_fleetlist($db, $limit, $condition);   
              	echo json_encode(array( "status"=>"yes","msg"=>"success", "details"=>$fleet, "base_url"=>"http://trac6.suveechi.com/WebImages/"));
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
    
	public function dashboard(){
    	
    	if($_SERVER['REQUEST_METHOD']==='POST' && $this->input->post('username')!='')
        {
            $db['username']="SuVeechi";
            
            $verify = $this->home_db->getlogin($db,0);
            if(count($verify)) // login check
            {            	
            	$db = array("detail"=>$verify);
              	$fleet = $this->grid_db->gettable_fleetlist($db); 
              	$array = $totarr = array();
              	foreach($fleet as $f){
              		if(array_key_exists($f->status, $totarr)){
              			$totarr[$f->status] = $array[$f->status] + 1;
              			$array[$f->status]['count'] = $totarr[$f->status];
              		}
              		else{
              			$totarr[$f->status] = 1;
              			$array[$f->status] = array("name"=>$f->status, "statusid"=>$f->statusid, "colorCode"=>$this->grid_db->getColor($f->statusColor), "count"=>1);
              		}
              	}  
              	$totarr = array();
              	foreach ($array as $key=>$a){
              		$totarr[] = $a;
              	}
              	echo json_encode(array( "status"=>"yes","msg"=>"success", "total"=>count($fleet), "status_count"=>array($totarr)));
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

}

?>