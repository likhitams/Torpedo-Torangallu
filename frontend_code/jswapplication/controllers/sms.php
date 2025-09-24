<?php
class sms extends CI_Controller {
    
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
                $this->home_db->clearSession($this->data['session'],$this->data['session_data']);
                redirect('userlogin','refresh');
            }
        }
        $this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
        $this->data['refCountList']=$this->load->view('refCountList', NULL , TRUE);
        $this->data['header']=$this->load->view('header', $this->data , TRUE);
        $this->data['left']=$this->load->view('left', NULL , TRUE);
        $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);
    }
    
    public function index()
    {
        $this->data['smsJS']=$this->load->view('smsJs', $this->data , TRUE);
        $this->load->view('sms_view',$this->data);
       
    } 
    
    public function getListdata()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->grid_db->gettable_fleetlist_SMS($db));
    }
}



?>