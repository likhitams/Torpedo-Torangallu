<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class soilClassification extends CI_Controller {

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
        $this->data['session'] = "w_Admin";
        $this->data['cookie'] = "weigh_w_Admin";
		$cookie=get_cookie($this->data['cookie']);
        
        if(!$this->session->userdata($this->data['session']) && $cookie=="")
        {    
            redirect('adminlogin','refresh');
        }
        else
        {
	        if($this->session->userdata($this->data['session'])){
	            $det=$this->master_db->getRecords("admin",array("email"=>$this->session->userdata($this->data['session']),"login_type"=>"SA","status"=>"0"));			
	        }
	        else if($cookie!=""){
	        	$det=$this->master_db->getRecords("admin",array("email"=>$cookie,"login_type"=>"SA","status"=>"0"));
	        }
        	if(count($det)>0){
            	$this->data['detail']=$det;
	        }
	        else{
	        	redirect('dashboard/logout');
	        }            
        }   
		//echo "dsafdsfsdafdfas".$this->data['detail'];
        $this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
		$this->data['header']=$this->load->view('header', $this->data , TRUE);
		$this->data['left']=$this->load->view('left', NULL , TRUE);
		$this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE); 
    }

    public function index()
    {       
    	$this->load->view('soiltype_view',$this->data);
    }
    
    public function soiltype_table()
    {    	
    	$db=array(
    			'page'=>$this->input->post('page'),
    			'rp'=>$this->input->post('rp'),
    			'sortname'=>$this->input->post('sortname'),
    			'sortorder'=>$this->input->post('sortorder'),
    			'qtype'=>$this->input->post('qtype'),
    			'addt'=>$this->input->get('type'),
    			'query'=>$this->input->post('query'),
    			'letter_pressed'=>$this->input->post('letter_pressed'),
    			'name'=>$this->input->post('name'),
    	);
    	$this->data=$this->grid_db->gettable_soiltypes($db);   
    	echo $this->data; 
    }
    
    public function check_soiltype(){
    	$business = trim(preg_replace('!\s+!', ' ',$this->input->get('business')));
    	$id = trim(preg_replace('!\s+!', '',$this->input->get('id')));
    	
    	if($business != "" && $id != ""){
    		$db = array("company_name"=>$business, "id !="=>$id, "status !="=>2);    
    		$check = $this->master_db->getRecords("soilTypes",$db,"id");
    		//echo $this->db->last_query();
    		if(count($check)>0){
    			echo 1;//exists
    		}
    		else echo 0;//does not exists
    	}
    	else echo 1;
    }
    
    
    public function soiltype_add()
    {
    	$this->data['type']='add';    	
    	$this->load->view('soiltype_add',$this->data);
    }
    
    
	function soiltype_save()
    {
    	$det=$this->data['detail'];
    	if($_SERVER['REQUEST_METHOD']=='POST')
    	{
    		$company_name=trim(preg_replace('!\s+!', ' ',$this->input->post('company_name')));
    		$contact_no=trim(preg_replace('!\s+!', '',$this->input->post('contact_no')));
    		$contact_name=trim(preg_replace('!\s+!', ' ',$this->input->post('contact_name')));
    		$status=trim(preg_replace('!\s+!', '',$this->input->post('status')));
    
    		$db = array("company_name"=>$company_name, "status !="=>2);    
    		$check = $this->master_db->getRecords("soilTypes",$db,"id");
    
    		if(count($check) == 0 && $contact_name != "" && $company_name != ""){
    			$check = $this->master_db->getRecords("soilTypes",array(),"id");
    			$db=array(
    					'company_name'=>$company_name,
    					'contractor_id'=>$this->grid_db->getcustomer_id("CL",count($check)+1),
    					'contact_name'=>$contact_name, 
		    			'contact_number'=>$contact_no, 
		    			'status'=>$status,    		
    					'created_date'=>date('Y-m-d H:i:s'),
    					'created_by'=>$det[0]->id    
    			);
    			$res=$this->master_db->insertRecord('soilTypes',$db);
    			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Sub Contractor Created Successfuly</div>');
    		}
    		else{
    			$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Sub Contractor already registered</div>');
    		}
    		redirect('soilClassification');
    	}
    	else{
    		redirect('soilClassification');
    	}
    }
    
    public function soiltype_status()
    {
    	$id = $this->input->post('items');
    	$det=$this->data['detail'];
    	$explode = explode(",",$id);
    	foreach ($explode as $ex){
    	$db=array(
    			'status'=>2,
    			'modified_date'=>date('Y-m-d H:i:s'),
    			'modified_by'=>$det[0]->id  
    	);
    	 
    	$status=$this->master_db->updateRecord("soilTypes",$db,array("id"=>$ex));
    	}
    	header("Content-type: application/json");
    
    	$json = "";
    
    	$json .= "{";
    
    	$json .= '"query": "",';
    
    	$json .= '"total": "0"';
    
    	$json .= "}";
    
    	echo  $json;
    }
    
    
    public function soiltype_edit(){
    	    	
    	$id=$this->input->get('id');
    	if($id)
    	{
    		$this->data['type']='edit';
    		$this->data['details']=$this->master_db->getRecords('soilTypes',array("id"=>$id,"status !="=>2));
    		$this->load->view('subsoilTypes_add',$this->data);
    	}
    
    	if($_SERVER['REQUEST_METHOD']=='POST')
    	{
    		$id=$this->input->post('id');
    		$company_name=trim(preg_replace('!\s+!', ' ',$this->input->post('company_name')));
    		$contact_no=trim(preg_replace('!\s+!', '',$this->input->post('contact_no')));
    		$contact_name=trim(preg_replace('!\s+!', ' ',$this->input->post('contact_name')));
    		$status=trim(preg_replace('!\s+!', '',$this->input->post('status')));
    		
    		$db = array("company_name"=>$company_name,"status !="=>2, "id !="=>$id);
    		$check = $this->master_db->getRecords("soilTypes",$db,"id");
    		
    		if(count($check) == 0 && $contact_name != "" && $company_name != "" ){
    			$db=array(
    					'company_name'=>$company_name,
    					'contact_name'=>$contact_name, 
		    			'contact_number'=>$contact_no, 
    					'status'=>$status,    		
    					'modified_date'=>date('Y-m-d H:i:s'),
    					'modified_by'=>$det[0]->id   
    			);    			
    			$this->master_db->updateRecord('soilTypes',$db,array("id"=>$id));
    			
    			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Successfull</div>');
    		}
    		else
    		{
    			$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Sub Contractor already registered.</div>');
    		}
    		redirect('soilClassification');
    	}
    }
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */