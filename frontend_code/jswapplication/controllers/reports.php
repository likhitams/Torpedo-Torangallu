<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends CI_Controller {

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
        $this->load->model('main_model');
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

		//GET varaibles common for all reports 
		$this->data['unit'] = trim(preg_replace('!\s+!', '',$this->input->get('unit')));
    	$this->data['group'] = trim(preg_replace('!\s+!', '',$this->input->get('group')));
    	$this->data['checkAuto'] = trim(preg_replace('!\s+!', '',$this->input->get('checkAuto')));
    	$this->data['start_date'] = trim(preg_replace('!\s+!', '',$this->input->get('start_date')));
    	$this->data['start_time'] = trim(preg_replace('!\s+!', '',$this->input->get('start_time')));
    	$this->data['end_date'] = trim(preg_replace('!\s+!', '',$this->input->get('end_date')));
    	$this->data['end_time'] = trim(preg_replace('!\s+!', '',$this->input->get('end_time')));
    	
    }

    public function index()
    {	
		$qry = "select gf.geofencenumber as gf_no, gf.geofencename as geofence from geofences gf inner join geofencepoly gp on gf.geofencenumber = gp.geofencenumber where gf.companyid = 95 and gf.is_delete = 0 and gp.is_delete = 0 and gf.geofencename not like 'Exit%' order by gf.geofencename";
		$res = $this->main_model->manRes($qry);
		$this->data['gf_list'] = $res = $res?$res:array();
    	$this->load->view('reports_view',$this->data);       
    } 
    
	function saveReplay(){
    	$unitno = $this->input->get('unit');
    	$tripstart = $this->input->get('tripstart');
    	$tripend = $this->input->get('tripend');
    	$this->session->set_userdata("replayUnit", $unitno);
    	$this->session->set_userdata("tripstart", $tripstart);
    	$this->session->set_userdata("tripend", $tripend);
    	//echo $this->session->userdata("replayUnit");
    	//echo $this->session->userdata("tripstart");
    	//echo $this->session->userdata("tripend");
    }
    
	function getUnits(){
    	$q=trim(preg_replace('!\s+!', ' ',$this->input->get('q')));
    	$db=array(
    			'detail'=>$this->data['detail'],    			
    	);
    	echo json_encode($this->reports_db->get_unitlist($q, $db));
    }
    
	function getLadles(){
    	$q=trim(preg_replace('!\s+!', ' ',$this->input->get('q')));
    	$db=array(
    			'detail'=>$this->data['detail'],    			
    	);
    	echo json_encode($this->reports_db->get_ladlelist($q, $db));
    }
    
    function getLadles1(){
    	$q=trim(preg_replace('!\s+!', ' ',$this->input->get('q')));
    	$db=array(
    			'detail'=>$this->data['detail'],
    	);
    	echo json_encode($this->reports_db->get_ladlelist1($q, $db));
    }
    
	function getGroups(){
    	$q=trim(preg_replace('!\s+!', ' ',$this->input->get('q')));
    	$db=array(
    			'detail'=>$this->data['detail'],    			
    	);
    	echo json_encode($this->reports_db->get_grouplist($q, $db));
    }
    
    function getReportsCombo(){
    	$detail = $this->data['detail'];
    	$q=trim(preg_replace('!\s+!', '',$this->input->post('type')));
    	if($q == 1){
    		$db = array("companyid"=>$detail[0]->companyid, "onunits"=>1, "is_delete"=>0);
    	}
    	else{
    		$db = array("companyid"=>$detail[0]->companyid, "onunits"=>0, "is_delete"=>0);
    	}
    	$result = $this->master_db->getRecords("reports", $db, "reportname, reportid", "reportname");
    	$resData = "<option value=''>Report Type</option>";
    	foreach ($result as $res){
    		$resData .= "<option value='".$res->reportid."'>".$res->reportname."</option>";
    	}
    	echo $resData;
    }
    
	function getGroupReportsCombo(){
    	$detail = $this->data['detail'];
    	$result = $this->master_db->getRecords("reports", array("companyid"=>$detail[0]->companyid, "onunits"=>0, "is_delete"=>0), "reportname, reportid", "reportname");
    	$resData = "<option value=''>Report Type</option>";
    	foreach ($result as $res){
    		$resData .= "<option value='".$res->reportid."'>".$res->reportname."</option>";
    	}
    	echo $resData;
    }
    
    function cycletime(){
    	$this->load->view('cycletime_report',$this->data);       
    }
    
	function cycletimeGroup(){
    	$this->load->view('cycletimegroup_report',$this->data);       
    }
    function cyclecountbargraph()
    {
        $this->load->view('cyclecountbargraph',$this->data);
    }
    function delayreport()
    {
        $this->load->view('delayreport',$this->data);
    }
    function summaryreport()
    {
        $this->load->view('summaryreport',$this->data);
    }
    function tlctracking()
    {
        $this->load->view('tlctrackingreport',$this->data);
    }
    function bfprod_Smsreceived()
    {
        $this->load->view('bfprod_smsreceivedreport',$this->data);
    }
	function movement(){
    	$this->load->view('movement_report',$this->data);       
    }
    
	function movement_group(){
    	$this->load->view('movement_groupreport',$this->data);       
    }
    
    function SMSHM_group(){
    	$this->load->view('sms_groupreport',$this->data);
    }
	
	function Emergency_group(){
    	$this->load->view('emergency_groupreport',$this->data);
    }
	
	function Smsdelay_group(){
    	$this->load->view('smsdelay_groupreport',$this->data);
    }
    
	function Weighment_group(){
    	$this->load->view('weighment_groupreport',$this->data);
    }
    
	function idletime(){
    	$this->load->view('idletime_report',$this->data);       
    }
    
	function idletimeGroup(){
    	$this->load->view('idletimegroup_report',$this->data);       
    }
    
	function geofence(){
    	$this->load->view('geofence_report',$this->data);       
    }
    
	function maintenance(){
    	$this->load->view('maintenance_report',$this->data);       
    }
    
	function maintenanceGroup(){
    	$this->load->view('maintenanceGroup_report',$this->data);       
    } 
    function chartGroup(){
    	$this->load->view('charttimegroup_report',$this->data);
    }
    
    function bflaldeGroup(){
        $this->load->view('bfladlegroup_report',$this->data);
    }  
    function ladlestatus_group(){
    	$this->load->view('ladlestatus_groupreport',$this->data);
    }
	
    
    
    function reportmap(){   	
    	
    	$this->data['lati'] = trim(preg_replace('!\s+!', '',$this->input->get('lati')));
    	$this->data['long'] = trim(preg_replace('!\s+!', '',$this->input->get('long')));
    	$this->data['Unitnamepost'] = trim(preg_replace('!\s+!', ' ',$this->input->get('Unitname')));
    	$this->data['Reportnamepost'] = trim(preg_replace('!\s+!', ' ',$this->input->get('Reportname')));
    	$this->data['direction'] = trim(preg_replace('!\s+!', ' ',$this->input->get('direction')));
    	$this->data['statusid'] = trim(preg_replace('!\s+!', ' ',$this->input->get('statusid')));
    	$this->data['statusArr'] = trim(preg_replace('!\s+!', ' ',$this->input->get('statusArr')));    	
    	$this->data['locArr'] = trim(preg_replace('!\s+!', ' ',$this->input->get('locArr')));
    	$this->data['unitArr'] = trim(preg_replace('!\s+!', ' ',$this->input->get('unitArr')));
    	$this->data['reportArr'] = trim(preg_replace('!\s+!', ' ',$this->input->get('reportArr')));
    	$this->data['Groupnamepost'] = "";
    	$this->load->view('report_map',$this->data);     
    }
    
	function ladleConditionGroup(){
    	$this->load->view('ladleCondition_report',$this->data);       
    }
    
	function ladleLifeGroup(){
    	$this->load->view('ladlelife_report',$this->data);       
    }
    
	function ignition(){
    	$this->load->view('ignition_report',$this->data);       
    }
    
	function stoppage(){
    	$this->load->view('stoppage_report',$this->data);       
    }
    
	function tripSummary(){
    	$this->load->view('tripSummary_report',$this->data);       
    }
    
	function route(){
    	$this->load->view('route_report',$this->data);       
    }
    
	function consolidateSummaryReport(){
    	$this->load->view('consolidateSummary_report',$this->data);       
    }
    
	function groupsms_report(){
    	$this->load->view('groupsms_report',$this->data);       
    }
    
	function groupignition_report(){
    	$this->load->view('ignitiongroup_report',$this->data);       
    }
    
	function groupgeofence(){
    	$this->load->view('groupgeofence_report',$this->data);       
    }
    
	function groupgeofence_transit(){
    	$this->load->view('groupgeofence_transit',$this->data);       
    }
    
    function distancerun(){
        $this->load->view('distancerun_report',$this->data);
    }   
    
    function distancerunGroup(){
        $this->load->view('groupdistancerun_report',$this->data);
    }
    
    function breakdownGroup(){
        $this->load->view('groupbreakdown_report',$this->data);
    }
   
    function issuesGroup(){
        $this->load->view('groupissues_report',$this->data);
    }
    
    function statusGroup(){
        $this->load->view('groupstatus_report',$this->data);
    }
    
    function dumpGroup(){
        $this->load->view('groupdump_report',$this->data);
    }
    function noncycleGroup(){
        $this->load->view('groupnoncycle_report',$this->data);
    }
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */