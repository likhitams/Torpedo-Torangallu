<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maintenance extends CI_Controller {

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
        $this->load->model('maintenance_db');
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
        	//echo $this->db->last_query();exit;  maintenance_report
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
        $this->data['jsfileone']=$this->load->view('jsfileone', NULL , TRUE);  
    }

    public function index()
    {                   
        $this->load->view('maintenance_view',$this->data);       
    } 
    
    public function getmaintenancedata()
    {       
        
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->maintenance_db->gettable_data($db));   
    }
    
    function getTareDetails(){
        $ladleno = $this->input->post("ladleno");
        if($ladleno != ""){
            $date = $this->maintenance_db->getTaredata($ladleno);
            if(count($date)){
                echo $date[0]->TARE_DATE."~".$date[0]->TARE_WT2;
            }
            else{
                echo date('d-m-Y H:i:s')."~0";
            }
        }
    }
    
    function getSubmenu(){
        $repairType = $this->input->post("repairType");
        $res = "";
        if($repairType != ""){
            $result = $this->master_db->getRecords("maintenance_submenu",array("type_id"=>$repairType),"id, type_desc");
            if(count($result)){
                foreach ($result as $r){
                    $res .= "<option value='".$r->id."'>".$r->type_desc."</option>";
                }
            }
        }
        echo "<option value=''>Select</option>".$res;
    }
    
    public function addDetails(){
        
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],
                'type'=>$type,
                'limit'=>0
        );
        $compny = $db['detail'][0]->companyid;
        
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $sndtarewt=trim(preg_replace('!\s+!', ' ',$this->input->post('sndtarewt')));
            $sndtaretime=trim(preg_replace('!\s+!', ' ',$this->input->post('sndtaretime')));
            $repairType=trim(preg_replace('!\s+!', '',$this->input->post('repairType')));
            $repairTypesub= trim(preg_replace('!\s+!', '',$this->input->post('repairTypesub')));
            $completedDate=trim(preg_replace('!\s+!', ' ',$this->input->post('completedDate')));
            $maintenanceTime=trim(preg_replace('!\s+!', ' ',$this->input->post('maintenanceTime')));
            $heatStart=trim(preg_replace('!\s+!', ' ',$this->input->post('heatStart')));
            $heatStop= trim(preg_replace('!\s+!', ' ',$this->input->post('heatStop')));
            $underHeat= trim(preg_replace('!\s+!', ' ',$this->input->post('underHeat')));
                        
            if($ladleno != "" && $sndtarewt != "" && $sndtaretime != "" && $repairType != ""){
                $result = $this->master_db->getRecords("maintenance_report",array("ladleid"=>$ladleno, "cycleCompleted"=>0, "is_delete"=>0),"id");
                if(count($result)){
                    echo "Ladle already under Maintenance please complete that report.";
                }
                else{
                    $db = array(                            
                            "ladleid"=>$ladleno,
                            "sndTarewt"=>$sndtarewt,
                            "sndTaretime"=>$sndtaretime,
                            "repairType"=>$repairType,
                            "repairTypesub"=>$repairTypesub, 
                            "repairComplete"=>$completedDate,
                            "maintainenceTime"=>$maintenanceTime,
                            "heatingStarted"=>$heatStart,
                            "heatingStopped"=>$heatStop,
                            "underHeating"=>$underHeat,
                            "companyid"=> $compny,
                            "is_delete"=>0
                        );    
                        if($completedDate != "" && $heatStart != "" && $heatStop != ""){
                            $db["cycleCompleted"] = 1;
                        }
                        else{
                            $db["cycleCompleted"] = 0;
                        }
                $this->master_db->insertRecord("maintenance_report", $db);
                echo 1; 
                }
                
            }
            else{
                echo "All fields are Mandatory";
            }
        }
        else{
            echo "All fields are Mandatory";
        }
    }
    
    public function modifyDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $sndtarewt=trim(preg_replace('!\s+!', ' ',$this->input->post('sndtarewt')));
            $sndtaretime=trim(preg_replace('!\s+!', ' ',$this->input->post('sndtaretime')));
            $repairType=trim(preg_replace('!\s+!', '',$this->input->post('repairType')));
            $repairTypesub= trim(preg_replace('!\s+!', '',$this->input->post('repairTypesub')));
            $completedDate=trim(preg_replace('!\s+!', ' ',$this->input->post('completedDate')));
            $maintenanceTime=trim(preg_replace('!\s+!', ' ',$this->input->post('maintenanceTime')));
            $heatStart=trim(preg_replace('!\s+!', ' ',$this->input->post('heatStart')));
            $heatStop= trim(preg_replace('!\s+!', ' ',$this->input->post('heatStop')));
            $underHeat= trim(preg_replace('!\s+!', ' ',$this->input->post('underHeat')));
                        
            if($oid != "" && $ladleno != "" && $sndtarewt != "" && $sndtaretime != "" && $repairType != ""){
                $result = $this->master_db->getRecords("maintenance_report",array("ladleid"=>$ladleno, "cycleCompleted"=>0, "is_delete"=>0, "id != "=>$oid),"id");
                if(count($result)){
                    echo "Ladle already under Maintenance please complete that report.";
                }
                else{
                    $db = array(                            
                            "ladleid"=>$ladleno,
                            "sndTarewt"=>$sndtarewt,
                            "sndTaretime"=>$sndtaretime,
                            "repairType"=>$repairType,
                            "repairTypesub"=>$repairTypesub, 
                            "repairComplete"=>$completedDate,
                            "maintainenceTime"=>$maintenanceTime,
                            "heatingStarted"=>$heatStart,
                            "heatingStopped"=>$heatStop,
                            "underHeating"=>$underHeat
                        );    
                        if($completedDate != "" && $heatStart != "" && $heatStop != ""){
                            $db["cycleCompleted"] = 1;
                        }
                        else{
                            $db["cycleCompleted"] = 0;
                        }
                $this->master_db->updateRecord("maintenance_report", $db, array("id"=>$oid));
                echo 1; 
                }
                
            }
            else{
                echo "All fields are Mandatory";
            }
        }
        else{
            echo "All fields are Mandatory";
        }
    }
    
    function deleteDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds=$this->input->post('unitIds');
            
            
            $db = array( 
                        'unitIds'=>"(".implode(",", $unitIds).")"
                        //'unitIds'=>"(".$unitIds.")"
                    );
            
            $this->maintenance_db->deleteDetails($db);
            echo 1;
        }
    }
    
    //Breakdown Details
    
    public function breakdown()
    {
        $this->load->view('breakdown',$this->data);
    } 
    
    public function getbreakdowndata()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->maintenance_db->gettable_breakdown($db));
    }
    
    public function addBreakdown(){
        
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],
                'type'=>$type,
                'limit'=>0
        );
        $compny = $db['detail'][0]->companyid;
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $date=trim(preg_replace('!\s+!', ' ',$this->input->post('date')));
            $shift=trim(preg_replace('!\s+!', ' ',$this->input->post('shift')));
            $description=trim(preg_replace('!\s+!', '',$this->input->post('description')));
            $duration= trim(preg_replace('!\s+!', '',$this->input->post('duration')));
            
           
                $db = array(
                    "ladleid"=>$ladleno,
                    "date"=>$date,
                    "shift"=>$shift,
                    "description"=>$description,
                    "duration"=>$duration,
                    "companyid"=> $compny,
                    "is_delete"=>0
                );
                $this->master_db->insertRecord("maintenance_breakdown", $db);
                echo 1; 
            
            
        }
    }
    
    public function modifyBreakdown(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $date=trim(preg_replace('!\s+!', ' ',$this->input->post('date')));
            $shift=trim(preg_replace('!\s+!', ' ',$this->input->post('shift')));
            $description=trim(preg_replace('!\s+!', '',$this->input->post('description')));
            $duration= trim(preg_replace('!\s+!', '',$this->input->post('duration')));
            
            $db = array(
                "ladleid"=>$ladleno,
                "date"=>$date,
                "shift"=>$shift,
                "description"=>$description,
                "duration"=>$duration
                
            );
            $this->master_db->updateRecord("maintenance_breakdown", $db, array("id"=>$oid));
            echo 1; 
        }
    }
    
    function deleteBreakdown(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds=$this->input->post('unitIds');
            
            
            $db = array(
                'unitIds'=>"(".implode(",", $unitIds).")"
                //'unitIds'=>"(".$unitIds.")"
            );
            
            $this->maintenance_db->deleteBreakdown($db);
            echo 1;
        }
    }
    
    //Logistic Issues Details
    
    public function delay()
    {
        $this->load->view('delay',$this->data);
    }
    
    public function getLogisticdelay()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->maintenance_db->gettable_delay($db));
    }
    
    public function addDelay(){
        
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],
                'type'=>$type,
                'limit'=>0
        );
        $compny = $db['detail'][0]->companyid;
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $locono=trim(preg_replace('!\s+!', '',$this->input->post('loconumber')));
            $date=trim(preg_replace('!\s+!', ' ',$this->input->post('date')));
            $shift=trim(preg_replace('!\s+!', ' ',$this->input->post('shift')));
            $delaycause=trim(preg_replace('!\s+!', '',$this->input->post('delaycause')));
            $duration= trim(preg_replace('!\s+!', '',$this->input->post('duration')));
            
            
            $db = array(
                "loconumber"=>$locono,
                "date"=>$date,
                "shift"=>$shift,
                "delaycause"=>$delaycause,
                "duration"=>$duration,
                "companyid"=> $compny,
                "is_delete"=>0
            );
            $this->master_db->insertRecord("maintenance_delay", $db);
            echo 1;
            
            
        }
    }
    
    public function modifyDelay(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
            $loconumber=trim(preg_replace('!\s+!', '',$this->input->post('loconumber')));
            $date=trim(preg_replace('!\s+!', ' ',$this->input->post('date')));
            $shift=trim(preg_replace('!\s+!', ' ',$this->input->post('shift')));
            $delaycause=trim(preg_replace('!\s+!', '',$this->input->post('delaycause')));
            $duration= trim(preg_replace('!\s+!', '',$this->input->post('duration')));
            
            $db = array(
                "loconumber"=>$loconumber,
                "date"=>$date,
                "shift"=>$shift,
                "delaycause"=>$delaycause,
                "duration"=>$duration
            );
            $this->master_db->updateRecord("maintenance_delay", $db, array("id"=>$oid));
            echo 1; 
        }
    }

    function deleteDelay(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds=$this->input->post('unitIds');
            
            
            $db = array(
                'unitIds'=>"(".implode(",", $unitIds).")"
                //'unitIds'=>"(".$unitIds.")"
            );
            
            $this->maintenance_db->deleteDelay($db);
            echo 1;
        }
    }
    
    //Ladle Status Details
    
    public function ladleStatus()
    {
        $this->load->view('ladle_status',$this->data);
    }
    
    public function getLadlestatus()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->maintenance_db->gettable_status($db));
    }
    
    public function addStatus(){
        
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],
                'type'=>$type,
                'limit'=>0
        );
        $compny = $db['detail'][0]->companyid;
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $capacity=trim(preg_replace('!\s+!', ' ',$this->input->post('capacity')));
            $supplier=trim(preg_replace('!\s+!', ' ',$this->input->post('supplier')));
            $guarantee=trim(preg_replace('!\s+!', '',$this->input->post('guarantee')));
            $beats= trim(preg_replace('!\s+!', '',$this->input->post('beats')));
            $status= trim(preg_replace('!\s+!', '',$this->input->post('status')));
            $downdate= trim(preg_replace('!\s+!', '',$this->input->post('downdate')));
            
            $db = array(
                "ladleid"=>$ladleno,
                "capacity"=>$capacity,
                "supplier"=>$supplier,
                "guarantee"=>$guarantee,
                "beats"=>$beats,
                "status"=>$status,
                "downdate"=>$downdate,
                "companyid"=> $compny,
                "is_delete"=>0
            );
            $this->master_db->insertRecord("maintenance_status", $db);
            echo 1;
        }
    }
    
    public function modifyStatus(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $capacity=trim(preg_replace('!\s+!', ' ',$this->input->post('capacity')));
            $supplier=trim(preg_replace('!\s+!', ' ',$this->input->post('supplier')));
            $guarantee=trim(preg_replace('!\s+!', '',$this->input->post('guarantee')));
            $beats= trim(preg_replace('!\s+!', '',$this->input->post('beats')));
            $status= trim(preg_replace('!\s+!', '',$this->input->post('status')));
            $downdate= trim(preg_replace('!\s+!', '',$this->input->post('downdate')));
            
            $db = array(
                "ladleid"=>$ladleno,
                "capacity"=>$capacity,
                "supplier"=>$supplier,
                "guarantee"=>$guarantee,
                "beats"=>$beats,
                "status"=>$status,
                "downdate"=>$downdate      
            );
            $this->master_db->updateRecord("maintenance_status", $db, array("id"=>$oid));
            echo 1;
        }
    }
    
    function deleteStatus(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds=$this->input->post('unitIds');
            
            
            $db = array(
                'unitIds'=>"(".implode(",", $unitIds).")"
                //'unitIds'=>"(".$unitIds.")"
            );
            
            $this->maintenance_db->deleteStatus($db);
            echo 1;
        }
    }
    
    //Dumping Status
    
    public function dumpDetails()
    {
        $this->load->view('dump_details',$this->data);
    }
    
    public function getDumpDetails()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->maintenance_db->gettable_dump($db));
    }
    
    public function addDump(){
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $det = $this->data['detail'];
            $cid = $det[0]->companyid;
          
           // echo $cid;
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            //echo $ladleno;
            $scheduledate=trim(preg_replace('!\s+!', ' ',$this->input->post('scheduledate')));
           // echo $scheduledate;
            $executiondate=trim(preg_replace('!\s+!', ' ',$this->input->post('executiondate')));
           // echo $executiondate;
            $tarewt=trim(preg_replace('!\s+!', '',$this->input->post('tarewt')));
           // echo $tarewt;
            $dumptarewt= trim(preg_replace('!\s+!', '',$this->input->post('dumptarewt')));
            //echo $dumptarewt;
            $netwt= trim(preg_replace('!\s+!', '',$this->input->post('netwt')));
            //echo $netwt;
            $flakes= trim(preg_replace('!\s+!', '',$this->input->post('flakes')));
           // echo $flakes;
            $metal= trim(preg_replace('!\s+!', '',$this->input->post('metal')));
           // echo $metal;
            $remarks= trim(preg_replace('!\s+!', '',$this->input->post('remarks')));
           // echo $remarks;
            
            $db = array(
                "ladleid"=>$ladleno,
                "scheduledate"=>$scheduledate,
                "executiondate"=>$executiondate,
                "tarewt"=>$tarewt,
                "dumptarewt"=>$dumptarewt,
                "netwt"=>$netwt,
                "flakes"=>$flakes,
                "metal"=>$metal,
                "remarks"=>$remarks,
                "companyid"=>$cid,
                "is_delete"=>0
            );
           // echo "";
            $this->master_db->insertRecord("maintenance_dump", $db);
            echo 1;
            
            
        }
    }
    
    public function modifyDump(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $scheduledate=trim(preg_replace('!\s+!', ' ',$this->input->post('scheduledate')));
            $executiondate=trim(preg_replace('!\s+!', ' ',$this->input->post('executiondate')));
            $tarewt=trim(preg_replace('!\s+!', '',$this->input->post('tarewt')));
            $dumptarewt= trim(preg_replace('!\s+!', '',$this->input->post('dumptarewt')));
            $netwt= trim(preg_replace('!\s+!', '',$this->input->post('netwt')));
            $flakes= trim(preg_replace('!\s+!', '',$this->input->post('flakes')));
            $metal= trim(preg_replace('!\s+!', '',$this->input->post('metal')));
            $remarks= trim(preg_replace('!\s+!', '',$this->input->post('remarks')));
            
            $db = array(
                "ladleid"=>$ladleno,
                "scheduledate"=>$scheduledate,
                "executiondate"=>$executiondate,
                "tarewt"=>$tarewt,
                "dumptarewt"=>$dumptarewt,
                "netwt"=>$netwt,
                "flakes"=>$flakes,
                "metal"=>$metal,
                "remarks"=>$remarks
                
            );
            $this->master_db->updateRecord("maintenance_dump", $db, array("id"=>$oid));
            echo 1;
        }
    }
    
    function deleteDump(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds=$this->input->post('unitIds');
            
            
            $db = array(
                'unitIds'=>"(".implode(",", $unitIds).")"
                //'unitIds'=>"(".$unitIds.")"
            );
            
            $this->maintenance_db->deleteDump($db);
            echo 1;
        }
    }
	
	public function gf_master()
    {
        $this->load->view('gf_master',$this->data);
    } 
	
	function get_gfList(){
		//$qry = "select geofencenumber gf_no,geofencename geofence,threashold_interval threashold,entry_exit from geofences where companyid = 95 and lon is not null and lat is not null order by geofencename ";
		$qry = "select gf.geofencenumber as gf_no, gf.geofencename as geofence, gf.threashold_interval as threashold, gf.entry_exit as entry_exit from geofences gf inner join geofencepoly gp on gf.geofencenumber = gp.geofencenumber where gf.companyid = 95 and gf.is_delete = 0 and gp.is_delete = 0 and gf.geofencename not like 'Exit%' order by gf.geofencename";
		$res = $this->main_model->manRes($qry);
		$res = $res?$res:array();
		//$res = $res?$res:[];
		
		echo json_encode($res);
	}
	
	function updateGfData(){
		if($_POST){
			$out['status']  = "Failed";
			$out['message'] = "Something went wrong !";
			
			$gf_no = $this->input->post("gf_no");
			$gf_no = is_numeric($gf_no)?$gf_no:0;
			
			$trs_t = $this->input->post("threashold_time");
			$trs_t = is_numeric($trs_t)?$trs_t:0;
			$trs_t = $trs_t > 0?$trs_t:0;
			
			$is_ok = $this->input->post("entry_exit");
			$is_ok = is_numeric($is_ok)?$is_ok:0;
			
			$err_msg = "";
			
			if(!$gf_no){
				$err_msg = "Invalid Gf.No !";
			}else if($is_ok && !$trs_t){
				$err_msg = "Invalid Threashold Interval !";
			}
			
			if($err_msg != ""){
				$out['message'] = $err_msg;
			}
			
			$upData = $where = array();
			
			$where['geofencenumber'] 	   = $gf_no;
			$where['companyid']     	   = 95;
			
			$upData['threashold_interval'] = $trs_t;
			$upData['entry_exit']          = $is_ok;
			
			$updated = $this->main_model->updateWhere("geofences",$upData,$where);
			if($updated){
				$out['status']  = "success";
				$out['message'] = "Updated Successfull !";
			}else{				
				$out['message'] = "No changes done !";
			}
			
			printout_response:
			echo json_encode($out);
		}
	}
	
	function updateGfDataBulk(){
		if($_POST){
			$out['status']  = "Failed";
			$out['message'] = "Something went wrong !";
			
			$gf_no_arr = $this->input->post("gf_no");			
			$trs_t_arr = $this->input->post("threashold");			
			$is_ok_arr = $this->input->post("entry_exit");
			
			echo "<pre>";print_r($_POST);die;
			
			$err_msg = "";
			
			if(!is_array($gf_no_arr) || !is_array($trs_t_arr) || !is_array($is_ok_arr)){
				$err_msg = "Invalid Data !";
			}
			
			if($err_msg != ""){
				$out['message'] = $err_msg;
			}
			
			$updatedCount = 0;
			$entry_exit_count = 0;
			foreach($gf_no_arr as $ind=>$gf_no){
				$gf_no = is_numeric($gf_no)?$gf_no:0;
				
				$trs_t = isset($trs_t_arr[$ind])?$trs_t_arr[$ind]:0;
				$trs_t = is_numeric($trs_t)?$trs_t:0;
				$trs_t = $trs_t > 0?$trs_t:0;
				
				$is_ok = isset($is_ok_arr[$ind])?$is_ok_arr[$ind]:0;
				$is_ok = is_numeric($is_ok)?$is_ok:0;
				
				if($gf_no && (($is_ok && $trs_t > 0) || $is_ok == 0)){
					$upData = $where = array();
			
					$where['geofencenumber'] 	   = $gf_no;
					$where['companyid']     	   = 95;
					
					$upData['threashold_interval'] = $trs_t;
					$upData['entry_exit']          = $is_ok;
					
					$updated = $this->main_model->updateWhere("geofences",$upData,$where);
					if($updated){
						$updatedCount++;
					}
				}			
			}
						
			if($updatedCount){
				$out['status']  = "success";
				$out['message'] = "$updatedCount record/s Updated Successfull !";
			}else{				
				$out['message'] = "No changes done !";
			}
			
			printout_response:
			echo json_encode($out);
		}
	}
}

/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */
