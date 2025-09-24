<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class userlogin extends CI_Controller {

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
        //echo sha1("f4ccd3fa146ff39c27e0bd2664a5077fd105783");
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->data['session'] = "user";
        $this->data['session_data'] = "user";
        $this->data['session_pwd'] = "userpwd";
        $this->data['cookie'] = "jsw_user";
        $this->data['cookie_pwd'] = "jsw_userpwd";
       
    }
    
    public function index()
    {
        $arr['user_id'] = "231";
        $arr['password'] = "TCL2018";
        $res = $this->home_db->updatepassword($arr);
    	$cookies=get_cookie($this->data['cookie']);
        if($this->session->userdata($this->data['session']) || $cookies!="")
        {
        	$cookie=get_cookie($this->data['cookie']);
			$cookie_pwd=get_cookie($this->data['cookie_pwd']);
			$det = $this->home_db->checkSession($this->data['session'],$this->data['session_data'],$cookie, $cookie_pwd);
			if(count($det)>0){
				if($det[0]->udashboard == 1){
					redirect('dashboard');
				}
				else if($det[0]->tenmt == 1){
					redirect('dashboard');
					//redirect('tenmt');
				}
				else if($det[0]->fivemt == 1){
					redirect('fivemt');
				}
				
				else if($det[0]->ufleetview == 1){
					redirect('lists');
				}
				else if($det[0]->retrac == 1){
					redirect('replay');
				}
				else if($det[0]->ureports == 1){
					redirect('reports');
				}
				else if($det[0]->uconfig == 1){
					redirect('maintenance');
				}
				else if($det[0]->uoperations == 1){
					redirect('operations/cycling_noncycling');
				}
			}
			else{
				$this->home_db->clearSession($this->data['session'],$this->data['session_data'],$this->data['session_pwd']);
	            redirect('userlogin','refresh');
			}
            
        }
        else{
        	$this->load->library('captcha');
			$this->data['captcha'] = $this->captcha->main();
			$this->session->set_userdata('captcha_info', $this->data['captcha']);
        	$this->load->view('login',$this->data);
        }

    }  

    public function getCaptch(){
    	$this->load->library('captcha');
		$this->data['captcha'] = $this->captcha->main();
		$this->session->set_userdata('captcha_info', $this->data['captcha']);
		echo '<img src="'.$this->data['captcha']['image_src'].'" alt="Loading..." style="width: 128px; height: 37px;"/> ';
		echo '<img src="'.asset_url().'images/refresh.png" alt="Refresh" title="Refresh" onclick="changeCaptcha();" style="cursor: pointer;"/> ';
		echo '<input name="validCaptcha" type="hidden" value="'.$this->data['captcha']['code'].'" />';
    }
    
    function getQuestions(){
    	$email=$this->input->get('email');
    	$qt = $this->home_db->getQuestion($email);	  
    	if(count($qt)){
    		echo "<option value=''>Select Answer Type</option>";
    		foreach ($qt as $q){
    			echo "<option value='".$q->questionId."'>".$q->question."</option>";
    		}
    	}
    	else{
    		echo 0;
    	}
    }
    
    function checkDetails(){
    	if($_SERVER['REQUEST_METHOD']==='POST' && $this->input->post('email')!=''  && $this->input->post('answer')!='' 
    			&& $this->input->post('enterCaptcha')!='' && $this->input->post('answer_type')!='')
        {
            $db['email']=$this->input->post('email');
            $db['enterCaptcha']=$this->input->post('enterCaptcha');
            $db['answer_type']=$this->input->post('answer_type');
            $db['answer']=$this->input->post('answer');
            $captcha_info = $this->session->userdata('captcha_info');
            if($captcha_info['code'] != $db['enterCaptcha']){
            	echo 1; exit;
            }
            $qt = $this->home_db->getQuestion($db['email'], " and q.id='".$db['answer_type']."' ");
            if(count($qt) == 0){
            	echo 2; exit;
            }
            if(strtolower($qt[0]->answer) != strtolower($db['answer'])){
            	echo 3; exit;
            }
            $newpass = rand();
            $pdb = array("user_id"=>$qt[0]->userId, "password"=>$newpass);
            $this->home_db->updatepassword($pdb);
            $body='Hi Admin, <br><br>Your Account Details are below: <br><br><strong>Username</strong> : '.$qt[0]->username.'<br><strong>Password</strong> : '.$newpass.'<br><br><a href="'.base_url().'">Click Here</a> to Login.';
			$this->home_db->sendmailer($db['email'],"Password", $body);
			echo 0;     
        }
        else{
       	 echo -1;
        }
    }
    
    function checklogin(){
    	if($_SERVER['REQUEST_METHOD']==='POST' && $this->input->post('username')!='')
        {
            $db['username']=$this->input->post('username');
            $db['password']=$this->input->post('password');
            $verify = $this->home_db->getlogin($db,1,"");
            if(count($verify)) // login check
            {
            	//print_r($verify);
            	if($verify[0]->active == 0){
	                $this->session->set_userdata($this->data['session'], $db['username']);
	                $this->session->set_userdata($this->data['session_data'], $verify);
	                
	                $cookie = array(
	                   'name'   => $this->data['session'],
	                   'value'  => $db['username'],
	                   'expire' => 3600*24*7,
	                   'domain' => '.jsw',
	                   'path'   => '/',
	                   'prefix' => 'jsw_',
	               );
 
					set_cookie($cookie); 
					
					$cookie = array(
		                   'name'   => $this->data['session_pwd'],
		                   'value'  => $verify[0]->password,
		                   'expire' => 3600*24*7,
		                   'domain' => '.jsw',
		                   'path'   => '/',
		                   'prefix' => 'jsw_',
		               );
					set_cookie($cookie); 
	                echo 1;exit;
            	}
            	else{
            		echo 2;exit;
            	}
            }
            else
            {
            	echo 0;exit;
               
            }                    
        }
        echo 0;
    }
    
    
	public function forgotpass()
    {
    	
    	if($this->input->post('email')!='')
    	{
    		$db=$this->input->post('email');    		    		//echo "cdsdfdsf".$db;
    		$em=$this->master_db->getRecords("admin", array("email"=>$db),"email,id");	  
    		if(count($em)) // login check
    		{    		 
    			$newpass=$this->home_db->updatepassword($db);
    			$data1['id']=$db;
				$data1['mail']=$newpass;
				
				$body='Hi Admin, <br><br>Upweigh Account Details are below: <br><br><strong>Username</strong> : '.$em[0]->email.'<br><strong>Password</strong> : '.$newpass.'<br><br><a href="'.base_url().'">Click Here</a> to Login.';
			
				$this->load->library('email');
				$config = array (
					'mailtype' => 'html',
					'charset'  => 'utf-8',
					'priority' => '1'
				);
				$this->email->initialize($config);
				$this->email->from('info@upweigh.com.au','info');
				$this->email->to($db);
				$this->email->subject('Upweigh Account Password');
				$this->email->message($body);
				$this->email->send();
				echo 1;
    		}    			
    		else 
    		{   
    			echo 0;
    		}				
				
    		}
    		else
    		{    			
    			echo 0;
    		}
    	
    
    }

    
   
    
}

/* End of file groclogin.php */
/* Location: ./application/controllers/hmAdmin.php */