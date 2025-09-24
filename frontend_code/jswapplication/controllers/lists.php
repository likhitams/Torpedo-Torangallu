<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', '1');


class lists extends CI_Controller {

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
        $this->data['fleetJS']=$this->load->view('fleetJs', $this->data , TRUE);
        $this->data['fleetUnitDetails']=$this->load->view('fleetUnitDetails', $this->data , TRUE);
        $this->load->view('fleet_list',$this->data);       
    } 
    
    function saveReplay(){
        $unitno = $this->input->get('unitname');
        $this->session->set_userdata("replayUnit", $unitno);
        $this->session->set_userdata("tripstart", "");
        $this->session->set_userdata("tripend", "");
        //redirect(base_url()."fleet_view/replay");
    }
    
    function removeReplay(){
        $this->session->set_userdata("replayUnit", "");
        $this->session->set_userdata("tripstart", "");
        $this->session->set_userdata("tripend", "");
    }
    
    public function getListdata()
    {
	    $this->load->model('main_model');
	    $db_data =  array("detail"=>$this->data['detail']);
	 	$res = $this->grid_db->gettable_fleetlist($db_data); 
	 	//$res = $this->grid_db->gettable_fleetlist(["detail"=>$this->data['detail']]); 
	    if($res){
		   foreach($res as $r){
			   $r->is_breached        = 0;		
			   $r->threshold_time     = 0;
			   $r->breached_duration  = 0;
			   $r->geofence           = "";
				   
			   $uno = $r->unitnumber;
			   $lno = $r->ladleno;
			   
			   $qry = "select *from ladle_master where ladleno = '$lno' and cycle = 1";
			   $tmp = $this->main_model->manRow($qry);
			   if($tmp){				   
				   $qry = "select gi.*,gf.geofencename geofence from gf_inside gi join geofences gf on gf.geofencenumber = gi.geofencenumber where unitnumber = '$uno'";
				   $tmp = $this->main_model->manRow($qry);
				   if($tmp){	
					   $now = new DateTime();
					   $unx = $now->getTimestamp();
					   $val = $unx - $tmp->timeunix;				      
					   $dif = $val / 60;
					   $btm = $dif - $tmp->threashold_interval;
					  
					   $r->is_breached        = $btm > 0?1:0;		
					   $r->threshold_time     = $tmp->threashold_interval;	
					   $r->breached_duration  = round($btm);
					   $r->geofence           = trim($tmp->geofence);
				   }
			   }
			   
		   }
	   }
		
        echo json_encode($res);   
    }
    
    
    public function getListfivemtdata()
    {
         
        $db=array(
                'detail'=>$this->data['detail'],
        );
        echo json_encode($this->grid_db->gettable_fleetlist5mt($db));
    }

    public function getSearch()
    {
 
        $unitno = $_GET['unit'];

        
        $db=array(
                'unitnumber'=>$unitno,
                'detail'=>$this->data['detail'],
        );

        echo json_encode($this->grid_db->getSearchData($db));   
         
    }
    
    
    public function getListtenmtdata()
    {       
        
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->grid_db->gettable_fleetlist($db));   
    }
    
    public function getGroupListdata()
    {       
        $db=array(
                'detail'=>$this->data['detail'],  
                'groupno'=>$this->input->get("groupno"),                
        );
        echo json_encode($this->grid_db->getGroupFilter($db));  
        
    }
    
    public function getColumnListdata(){
        $db=array(
                'detail'=>$this->data['detail'], 
                'reporttime'=>$this->input->get('reporttime'),
                'unitnum'=>$this->input->get('unitnum'),
                'trackmin'=>$this->input->get('trackmin')                   
        );
        $result = $this->grid_db->gettable_Columnfleetlist($db);
        $Event = $Idle_Start_Time = $Idle_Start_TimeUnix = $Location = $Idle_time_unix = $idle = $idletime = null;
            
        for ($i=0;$i<=(count($result)-1);$i++){
            
            /*switch($result[$i]->statusid){
                case "0": break;
                case "1": break;
                case "2": break;
                case "3": break;
                case "4": break;
                case "9": break;
                case "14": break;
                case "18": break;
                case "19": break;
                case "23": break;
                default: break;
            }*/
            
            if($result[$i]->statusid == "18")
            {
                $Idle_time_unix = $result[$i]->reporttimeunix;
                     
                     if($Idle_Start_TimeUnix != null)
                     {
                        $result[$i-1]->status = $this->getStatus($Idle_time_unix, $result[$i-1]->status, $Idle_Start_TimeUnix);
                     }
                     $Idle_Start_TimeUnix = $result[$i]->reporttimeunix;
            }
        else if($result[$i]->statusid == "1" ||  
                $result[$i]->statusid == "9" || 
                $result[$i]->statusid == "14" || 
                $result[$i]->statusid == "23")
                {
                    $Idle_time_unix = $result[$i]->reporttimeunix;
                     
                     if($Idle_Start_TimeUnix!=null)
                     {
                        $result[$i-1]->status = $this->getStatus($Idle_time_unix, $result[$i-1]->status, $Idle_Start_TimeUnix);
                     }
                     $Idle_Start_TimeUnix = null;
                }
        else if($result[$i]->statusid == "19" || 
                $result[$i]->statusid == "0" ||
                $result[$i]->statusid == "14" || 
                $result[$i]->statusid == "2" || 
                $result[$i]->statusid == "3" || 
                $result[$i]->statusid == "4")
                {
                     $Idle_time_unix = $result[$i]->reporttimeunix;
                     if($Idle_Start_TimeUnix!=null)
                     {
                         $result[$i-1]->status = $this->getStatus($Idle_time_unix, $result[$i-1]->status, $Idle_Start_TimeUnix);
                     }
                     $Idle_Start_TimeUnix = null;   
                                     
                 }
           if($result[$i]->statusid == "0" || 
                $result[$i]->statusid == "9" || 
                $result[$i]->statusid == "14")
           {
                $Idle_Start_TimeUnix =  $result[$i]->reporttimeunix;
           }
        }  
        echo json_encode($result); 
    }
    
    private function getStatus($Idle_time_unix, $status, $Idle_Start_TimeUnix){
        
        $idle=(intval($Idle_time_unix)-intval($Idle_Start_TimeUnix));
                      
        $hours = intval($idle / 3600);
        $remainder = intval($idle % 3600);
        $minutes = intval($remainder / 60);
        $seconds = intval($remainder % 60);
    
        $disHour = $hours < 10 ? "0".$hours : "".$hours;
        $disMinu = $minutes < 10 ? "0".$minutes : "".$minutes;
        $disSec = $seconds < 10 ? "0".$seconds : "".$seconds ;
                          
        $idletime =$disHour.":".$disMinu.":".$disSec;
        $status = $status ." "."(".$idletime.")" ;
         
        return $status;
    }
    
    public function disableAlerts(){
        $unitnumber = trim(preg_replace('!\s+!', '',$this->input->get('unitnumber')));
        
        if($unitnumber != ""){
            $db = array("isalert"=>1);    
            $check = $this->master_db->updateRecord('unit_info',$db,array("unitnumber"=>$unitnumber));
            //echo $this->db->last_query();UPDATE unit_info SET isalert=1 WHERE unitnumber=#unitnumber#         
        }
    }
    
    public function enableAlerts(){
        $unitnumber = trim(preg_replace('!\s+!', '',$this->input->get('unitnumber')));
        
        if($unitnumber != ""){
            $db = array("isalert"=>0);    
            $check = $this->master_db->updateRecord('unit_info',$db,array("unitnumber"=>$unitnumber));
            //echo $this->db->last_query();UPDATE unit_info SET isalert=1 WHERE unitnumber=#unitnumber#         
        }
    }
    
    public function getUnitDetails(){
        $arr = array();
        $arr = json_encode($arr);
        $unitnumber=trim(preg_replace('!\s+!', '',$this->input->get('unitnumber')));
        if($unitnumber != ""){
            $arr = $this->grid_db->getUnitDetails($unitnumber);
        }
        echo $arr;
    }
    
    public function saveUnitDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitName=trim(preg_replace('!\s+!', ' ',$this->input->post('unitName')));
            $reg=trim(preg_replace('!\s+!', ' ',$this->input->post('reg')));
            $vehType=trim(preg_replace('!\s+!', ' ',$this->input->post('vehType')));
            $contractorName=trim(preg_replace('!\s+!', ' ',$this->input->post('contractorName')));
            $ownerName=trim(preg_replace('!\s+!', ' ',$this->input->post('ownerName')));
            $driverName=trim(preg_replace('!\s+!', ' ',$this->input->post('driverName')));
            $driverPh=trim(preg_replace('!\s+!', '',$this->input->post('driverPh')));
            $contactPerson=trim(preg_replace('!\s+!', ' ',$this->input->post('contactPerson')));
            $contactPh=trim(preg_replace('!\s+!', '',$this->input->post('contactPh')));
            $nextService=trim(preg_replace('!\s+!', '',$this->input->post('nextService')));
            $odometerno=trim(preg_replace('!\s+!', '',$this->input->post('odometerno')));
            $remark=trim(preg_replace('!\s+!', ' ',$this->input->post('remark')));
            $unitnum=trim(preg_replace('!\s+!', '',$this->input->post('unitnum')));
            
            if($unitName != "" && $unitnum != ""){
                $db = array(
                            "unitname"=>$unitName,
                            "registration"=>$reg,
                            "owner"=>$ownerName,
                            "drivername"=>$driverName,
                            "drivernumber "=>$driverPh,
                            "contactperson"=>$contactPerson,
                            "contactnumber"=>$contactPh,
                            "nextservice"=>$nextService,
                            "currentodo"=>$odometerno,
                            //"ftc"=>$unitName,
                        );    
                $check = $this->master_db->updateRecord('units',$db,array("unitnumber"=>$unitnum));
            
                $db = array(
                            "remarks"=>$remark,
                            "Customer"=>$contractorName,
                            "indentid"=>$vehType
                        );    
                $check = $this->master_db->updateRecord('unit_info',$db,array("unitnumber"=>$unitnum));
                echo $this->grid_db->getUnitDetails($unitnum);
            }
        }
    }
    
    public function showColumns(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $uid = $det[0]->userId;
            $showcol=trim(preg_replace('!\s+!', '',$this->input->post('showcol')));
            $id=trim(preg_replace('!\s+!', '',$this->input->post('id')));
            $check = $this->master_db->getRecords('user_columns',array("columnname"=>$id, "user_id"=>$uid)); 
            if(count($check)){
                $db = array("is_delete"=>$showcol);    
                $this->master_db->updateRecord('user_columns',$db,array("columnname"=>$id, "user_id"=>$uid));
            }
            else{
                $db = array(
                            "columnname"=>$id,
                            "user_id"=>$uid,
                            "is_delete"=>$showcol
                        ); 
                $this->master_db->insertRecord("user_columns", $db);       
            }
        }
    }
    
    public function fleet_with_map()
    {           
        $this->data['fleetJS']=$this->load->view('fleetJs', $this->data , TRUE);
        $this->data['fleetUnitDetails']=$this->load->view('fleetUnitDetails', $this->data , TRUE);
        $this->load->view('fleet_with_map',$this->data);       
    } 
    
    public function map()
    {           
        $this->load->view('map',$this->data);       
    } 
    
    public function reTrac()
    {    
        $this->data['GeofenceAddDetails']=$this->load->view('GeofenceAddDetails', $this->data , TRUE);
        $this->data['LocationAddDetails']=$this->load->view('LocationAddDetails', $this->data , TRUE);
        $this->load->view('replay',$this->data);       
    }
    
    function updateManageGeo(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $uid = $det[0]->userId;
            //print_r($_POST);
            $geofenceNumber=trim(preg_replace('!\s+!', '',$this->input->post('geofenceNumber')));
            $getgeoUnitArr=trim(preg_replace('!\s+!', '',$this->input->post('geoUnitArr')));
            $getgeoActualUnit=trim(preg_replace('!\s+!', '',$this->input->post('geoActualUnit')));
            $addArr = $delArr = $insert = $geoUnitArr = $geoActualUnit = array();
            if($getgeoUnitArr != ""){
                $geoUnitArr = explode(",", $getgeoUnitArr);
            }
            if($getgeoActualUnit != ""){
                $geoActualUnit = explode(",", $getgeoActualUnit);
            }
            
            if(is_array($geoUnitArr) && is_array($geoActualUnit)){
                //print_r($geoUnitArr);
                //print_r($geoActualUnit);
                foreach ($geoUnitArr as $actual){
                    if (!in_array($actual, $geoActualUnit)){
                        $addArr[] = $actual;
                    }                   
                }
                
                foreach ($geoActualUnit as $actual){
                    if (!in_array($actual, $geoUnitArr)){
                        $delArr[] = $actual;
                    }
                    
                }
                
                //print_r($addArr);
                foreach ($addArr as $val){
                    $insert[] = "($geofenceNumber,$val,$uid,$companyid)";
                }
                if(count($insert)){
                    $sql = "INSERT INTO geofencemembers(geofencenumber,unitnumber,user_id,companyid) VALUES ".implode(",", $insert);
                    $this->master_db->runQuery($sql);
                }
                //print_r($delArr);
                $query = array();
                foreach ($delArr as $val){
                    $query[] = $val;
                }
                if(count($query)){
                    $ids = implode(",",$query );
                    $sql = "UPDATE  schedule_unit su
                            LEFT JOIN schedule_details sd ON sd.id=su.schedule_details_id SET su.is_delete=TRUE 
                            WHERE schedule_main_id IN (5,6,7) AND sd.conditions=$geofenceNumber AND su.unit_id IN (".$ids.")";
                    $this->master_db->runQuery($sql);
                    
                    $sql = "DELETE from geofencemembers
                            where companyid=$companyid
                            and geofencenumber=$geofenceNumber and unitnumber in (".$ids.")";
                    $this->master_db->runQuery($sql);                   
                }
                echo 1;
            }
            else{
                echo 0;
            }
        }
        else{
            echo 0;
        }
    }

    public function saveGeoDetails(){
    if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $uid = $det[0]->userId;
            $geoName=trim(preg_replace('!\s+!', ' ',$this->input->post('geoName')));
            $geoType=trim(preg_replace('!\s+!', '',$this->input->post('geoType')));
            $geoLatitude=trim(preg_replace('!\s+!', '',$this->input->post('geoLatitude')));
            $geoLongitude=trim(preg_replace('!\s+!', '',$this->input->post('geoLongitude')));
            $geoLatitude2=trim(preg_replace('!\s+!', '',$this->input->post('geoLatitude2')));
            $geoLongitude2=trim(preg_replace('!\s+!', '',$this->input->post('geoLongitude2')));
            $geoRadius=trim(preg_replace('!\s+!', '',$this->input->post('geoRadius')));
            $geoMaxSpeed=trim(preg_replace('!\s+!', ' ',$this->input->post('geoMaxSpeed')));
            $geoPolyLatLong=trim(preg_replace('!\s+!', '',$this->input->post('geoPolyLatLong')));
            
            if($geoName != ""){
                $db = array(
                            "companyid"=>$companyid,
                            "geotype"=>intval($geoType),
                            "geofencename"=>$geoName,
                            "user_id"=>$uid,
                            "maxzonespeed"=>NULL
                        );   
                    
                switch(intval($geoType)){
                    case 1: $check = $this->master_db->insertRecord("geofences", $db);   
                            
                            $db1 = array(
                                    "geofencenumber"=>$check,
                                    "centerLat"=>$geoLatitude,
                                    "centerLon"=>$geoLongitude,
                                    "radius"=>$geoRadius,
                                );   
                            $this->master_db->insertRecord("geofencecircle", $db1);   
                            break;
                    case 2: $db['geostatus'] = 1;
                            $db['maxzonespeed'] = $geoMaxSpeed;                 
                            $check = $this->master_db->insertRecord("geofences", $db);  

                            $db1 = array(
                                    "geofencenumber"=>$check,
                                    "lat1"=>$geoLatitude,
                                    "lon1"=>$geoLongitude,
                                    "lat2"=>$geoLatitude2,
                                    "lon2"=>$geoLongitude2,
                                );   
                            $this->master_db->insertRecord("geofencerect", $db1);   
                            break;
                    case 3: $check = $this->master_db->insertRecord("geofences", $db);  

                            $db1 = array(
                                    "geofencenumber"=>$check,
                                    "latlon"=>$geoPolyLatLong,
                                );   
                            $this->master_db->insertRecord("geofencepoly", $db1);   
                            break;
                    case 4: 
                            $db1 = array(
                                    "name"=>$geoName,
                                    "latlon"=>$geoPolyLatLong,
                                );   
                            $this->master_db->insertRecord("geoployline", $db1);   
                            break;
                }    
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    public function saveLocDetails(){
    if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $locName=trim(preg_replace('!\s+!', ' ',$this->input->post('locName')));
            $locDes=trim(preg_replace('!\s+!', '',$this->input->post('locDes')));
            $locLatitude=trim(preg_replace('!\s+!', '',$this->input->post('locLatitude')));
            $locLongitude=trim(preg_replace('!\s+!', '',$this->input->post('locLongitude')));
            $locRadius=trim(preg_replace('!\s+!', '',$this->input->post('locRadius')));
            $locRefRadius=trim(preg_replace('!\s+!', '',$this->input->post('locRefRadius')));
            
            
            if($locName != "" && $locDes != "" && $locLatitude != "" && $locLongitude != "" && $locRadius != "" && $locRefRadius != ""){
                $db = array(
                            "locationname"=>$locName,
                            "latitude"=>$locLatitude,
                            "longitude"=>$locLongitude,
                            "radiusin"=>$locRadius,
                            "radiusrefer"=>$locRefRadius,
                            "description"=>$locDes,
                            "companyid"=>$companyid,
                        );   
                $check = $this->master_db->insertRecord("location", $db);       
                
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    function updateLocDetails(){
    if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $locName=trim(preg_replace('!\s+!', ' ',$this->input->post('mlocName')));
            $locDes=trim(preg_replace('!\s+!', '',$this->input->post('mlocDes')));
            $locLatitude=trim(preg_replace('!\s+!', '',$this->input->post('mlocLatitude')));
            $locLongitude=trim(preg_replace('!\s+!', '',$this->input->post('mlocLongitude')));
            $locRadius=trim(preg_replace('!\s+!', '',$this->input->post('mlocRadius')));
            $locRefRadius=trim(preg_replace('!\s+!', '',$this->input->post('mlocRefRadius')));
            $locid=trim(preg_replace('!\s+!', '',$this->input->post('locid')));
            
            if($locName != "" && $locDes != "" && $locRadius != "" && $locRefRadius != ""){
                $db = array(
                            "locationname"=>$locName,
                            "radiusin"=>$locRadius,
                            "radiusrefer"=>$locRefRadius,
                            "description"=>$locDes,
                        );   
                $check = $this->master_db->updateRecord('location',$db,array("locationid"=>$locid));    
                
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    public function deleteLocDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
            $longitude=trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
            
            if($latitude != "" && $longitude != ""){
                
                $this->master_db->runQuery("DELETE FROM location WHERE latitude=CAST($latitude AS DECIMAL(10,7)) AND longitude=CAST($longitude AS DECIMAL(10,7)) AND companyid=$companyid");    
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    function deleteCircleGeo(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
            $longitude=trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
            
            if($latitude != "" && $longitude != ""){
                
                $this->master_db->runQuery("DELETE gc.*,g.*,gm.* FROM geofencecircle AS gc
                                            LEFT JOIN geofences AS g ON g.geofencenumber=gc.geofencenumber
                                            left join geofencemembers gm on gm.geofencenumber=gc.geofencenumber
                                            WHERE centerLat= CAST($latitude AS DECIMAL(10,7)) AND centerLon=CAST($longitude AS DECIMAL(10,7))
                                            and g.companyid=$companyid");   
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    function deleteRectGeo(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $latitude=trim(preg_replace('!\s+!', '',$this->input->post('latitude')));
            $longitude=trim(preg_replace('!\s+!', '',$this->input->post('longitude')));
            $latitude1=trim(preg_replace('!\s+!', '',$this->input->post('latitude1')));
            $longitude1=trim(preg_replace('!\s+!', '',$this->input->post('longitude1')));
            
            if($latitude != "" && $longitude != "" && $latitude1 != "" && $longitude1 != ""){
                
                $this->master_db->runQuery("DELETE gr.*,g.*,gm.* FROM geofencerect AS gr
                                            LEFT JOIN geofences AS g ON g.geofencenumber=gr.geofencenumber
                                            LEFT JOIN geofencemembers gm ON gm.geofencenumber=gr.geofencenumber
                                            WHERE lat1= CAST($latitude AS DECIMAL(10,7)) AND lon1=CAST($longitude AS DECIMAL(10,7))
                                            AND lat2=CAST( $latitude1 AS DECIMAL(10,7)) AND lon2=CAST($longitude1 AS DECIMAL(10,7))
                                            AND g.companyid=$companyid"); 
                //echo $this->db->last_query(); 
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    function deletePolyGeo(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $geofenceNumber=trim(preg_replace('!\s+!', '',$this->input->post('geofenceNumber')));
            
            if($geofenceNumber != ""){
                
                $this->master_db->runQuery("UPDATE  geofencepoly gp
                                            LEFT JOIN geofences g
                                            ON      g.geofencenumber = gp.geofencenumber
                                            SET     gp.is_delete = 1 , g.is_delete = 1 
                                            WHERE g.geofencenumber = $geofenceNumber
                                            AND g.companyid=$companyid"); 
                //echo $this->db->last_query(); 
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    
    function deleteTrack(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $det = $this->data['detail'];
            $companyid = $det[0]->companyid;
            $geofenceNumber=trim(preg_replace('!\s+!', '',$this->input->post('geofenceNumber')));
            
            if($geofenceNumber != ""){
                
                $this->master_db->runQuery("UPDATE  geoployline
                                            SET     is_delete = 1
                                            WHERE id = $geofenceNumber"); 
                //echo $this->db->last_query(); 
                echo 1;
                
            }
            else{
                echo 0;
            }
        }
    }
    
    public function replaymap(){
        $this->load->view('replayMap1',$this->data);
    }
    
    public function getReplaydata()
    {       
        $start = $this->input->get('start_date');
        $start = explode(" ", $start);
        $start1 = explode("-", $start[0]);
        $start2 = $start[1];
        $start_date = $start1[2]."-".$start1[1]."-".$start1[0]." ".$start2;
        $end = $this->input->get('to_date');
        $end = explode(" ", $end);
        $end1 = explode("-", $end[0]);
        $end2 = $end[1];
        $end_date = $end1[2]."-".$end1[1]."-".$end1[0]." ".$end2;
        $start_date = date('Y-m-d H:i:s', strtotime($start_date));
        $end_date = date('Y-m-d H:i:s', strtotime($end_date));
        $db=array(
                'detail'=>$this->data['detail'],   
                'unitno'=>$this->input->get('unitno'),
                'start_date'=>$start_date,
                'to_date'=>$end_date, 
                //'startMonth'=>$this->input->get('start_date'),
                //'toMonth'=>$this->input->get('to_date'),              
        );
        echo json_encode($this->grid_db->gettable_replay($db));   
    }
    
    public function getAllGeoData(){
        
        $db=array(
                'detail'=>$this->data['detail'],        
            );
        echo json_encode($this->grid_db->getAllGeofence($db));   
    }
    

    public function getManageGeoGroup(){
        $db=array(
                'detail'=>$this->data['detail'],        
            );
        $array1 = $this->grid_db->getGroups($db);
        $array2 = array(array("groupname"=>"Other Units", "id"=>"0"));
        $result = array_merge($array1, $array2);
        echo json_encode($result);   
    }
    
    public function getGroupUnits(){
        $groups = $this->input->get("groups");
        $db=array(
                'detail'=>$this->data['detail'],  
                'groups'=>$groups,          
            );
        $array1 = $this->grid_db->getUnitsGroup($db);
        //$array2 = $this->grid_db->getUnitNotGroup($db);
        //$result = array_merge($array1, $array2);
        echo json_encode($array1);   
    }
    
    public function getConfigGeo(){
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],    
                'geono'=>$type,         
            );
        $result = $this->grid_db->getConfigGeoUnits($db);
        echo json_encode($result);   
    }
    
    public function getReplayGeofence(){
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],   
                'type'=>$type,
                'limit'=>0          
            );
        echo json_encode($this->grid_db->gettable_GeofenceAll($db));   
    }
    
    public function getTrack(){
        $db=array(
                'detail'=>$this->data['detail']     
            );
        echo json_encode($this->grid_db->gettable_Track($db));   
    }
    
    public function getTrackLatest(){
        $db=array(
                'detail'=>$this->data['detail']     
            );
        echo json_encode($this->grid_db->gettable_TrackLatest($db));  
    }
    
    public function getReplayLocation(){
        $db=array(
                'detail'=>$this->data['detail'],   
                'limit'=>0          
            );
        echo json_encode($this->grid_db->gettable_LocationAll($db));   
    }

    
    public function getLatestReplayGeofence(){
        $type = $this->input->get("type");
        $db=array(
                'detail'=>$this->data['detail'],   
                'type'=>$type,
                'limit'=>1      
            );
        echo json_encode($this->grid_db->gettable_GeofenceAll($db));   
    }
    
    public function getLatestReplayLocation(){
        $db=array(
                'detail'=>$this->data['detail'],   
                'limit'=>1          
            );
        echo json_encode($this->grid_db->gettable_LocationAll($db)); 
    }
    
    public function getReplayUnit(){
        $uid = $this->input->get("pid");//ka01tc189
        
        $check = $this->master_db->getRecords('units',array("unitnumber"=>$uid), "unitnumber, unitname"); 
        $selectbox='';$loc_arr=array();     
        if(count($check))
        {
            foreach($check as $row)
            {
                $loc_arr[] = '{
                                "name":'.'"'.str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->unitname))))))).'"'.',
                                "id":"'.$row->unitnumber.'",
                                
                            }';
                }
                $selectbox = implode(",", $loc_arr);
            }
            echo '['.$selectbox.']';
    }
    
    function getUnits(){
        $q=trim(preg_replace('!\s+!', ' ',$this->input->get('q')));
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->grid_db->get_unitlist($q, $db));
    }
    
     public function fleet_info()
    {           
        $this->data['fleetUnitDetails']=$this->load->view('fleetInfoUnitDetails', $this->data , TRUE);
        $this->data['fleetJS']=$this->load->view('fleetInfoJs', $this->data , TRUE);
        $this->load->view('fleet_info',$this->data);       
    } 
    
    public function getInfoListdata(){
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->grid_db->gettable_fleetinfolist($db));   
    }
    
    public function saveUnitInfoDetails(){
        //print_r($_POST);
        //print_r($_GET);
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $editcolumns = trim(preg_replace('!\s+!', ' ',$this->input->post('editcolumns')));
            $unitName = trim(preg_replace('!\s+!', ' ',$this->input->post('unitName')));
            $npexpdate = trim(preg_replace('!\s+!', '',$this->input->post('npexpdate')));
            $insexpDate = trim(preg_replace('!\s+!', '',$this->input->post('insexpDate')));
            $fcdate = trim(preg_replace('!\s+!', '',$this->input->post('fcdate')));
            $amcdate = trim(preg_replace('!\s+!', '',$this->input->post('amcdate')));
            $taxinfo = trim(preg_replace('!\s+!', ' ',$this->input->post('taxinfo')));
            $vehiclemake = trim(preg_replace('!\s+!', ' ',$this->input->post('vehiclemake')));
            $vehiclemodel = trim(preg_replace('!\s+!', ' ',$this->input->post('vehiclemodel')));
            $showroomname = trim(preg_replace('!\s+!', ' ',$this->input->post('showroomname')));
            $vehicletype = trim(preg_replace('!\s+!', ' ',$this->input->post('vehicletype')));
            $odometerno = trim(preg_replace('!\s+!', ' ',$this->input->post('odometerno')));
            $manfyear = trim(preg_replace('!\s+!', '',$this->input->post('manfyear')));
            $unitnum = trim(preg_replace('!\s+!', '',$this->input->post('unitnum')));           
            $purdate = trim(preg_replace('!\s+!', '',$this->input->post('purdate')));
            $roadPrice = trim(preg_replace('!\s+!', '',$this->input->post('roadPrice')));
            $inscompanyname=trim(preg_replace('!\s+!', ' ',$this->input->post('inscompanyname')));
            
            $db = array(
                            "vehiclemake"=>$vehiclemake,
                            "vehiclemodel"=>$vehiclemodel,
                            "vehicletype"=>$vehicletype,
                            "showroomname"=>$showroomname,
                            "inscompanyname"=>$inscompanyname,
                            "unitnum"=>$unitnum
                        );  
                        //print_r($db);  
            $condition = array();
            if($unitnum != ""){
                $editcolumns = explode(",", $editcolumns);
                foreach ($editcolumns as $val){
                    switch($val){
                        case "Vehicle Make": $this->grid_db->setVehiclemake($db);break;
                        case "Vehicle Type": $this->grid_db->setVehicletype($db);break;
                        case "ShowRoom Name": $this->grid_db->setShowroom($db);break;
                        case "Insurance Company Name": $this->grid_db->setInsCompany($db);break;
                        case "Vehicle Model": $this->grid_db->setVehiclemodel($db);break;
                        case "NP Expiry Date(dd:mm:yyyy)": $dtformat = explode("-", $npexpdate);
                                                            if($npexpdate != "" && count($dtformat)>2){
                                                                $npexpdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                                $npexpdate = date('Y-m-d', strtotime($npexpdate));
                                                            }
                                                            else{
                                                                $npexpdate = '0000-00-00';
                                                            }
                                                            $condition[] = "np = IF(('$npexpdate' = '0000-00-00' ),NULL, '$npexpdate' )";break;
                        case "Insurance Expiry Date(dd:mm:yyyy)": $dtformat = explode("-", $insexpDate);
                                                            if($insexpDate != "" && count($dtformat)>2){
                                                                $insexpDate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                                $insexpDate = date('Y-m-d', strtotime($insexpDate));
                                                            }
                                                            else{
                                                                $insexpDate = '0000-00-00';
                                                             }
                                                            $condition[] = "insurence = IF(('$insexpDate' = '0000-00-00' ),NULL, '$insexpDate')";
                                                            break;
                        case "FC Date(dd:mm:yyyy)": $dtformat = explode("-", $fcdate);
                                                    if($fcdate != "" && count($dtformat)>2){
                                                        $fcdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                        $fcdate = date('Y-m-d', strtotime($fcdate));
                                                    }
                                                    else{
                                                        $fcdate = '0000-00-00';
                                                     }
                                                    $condition[] = "fc =IF(( '$fcdate' = '0000-00-00' ),NULL,  '$fcdate')";
                                                    break;
                        case "AMC Date(dd:mm:yyyy)": $dtformat = explode("-", $amcdate);
                                                     if($amcdate != "" && count($dtformat)>2){
                                                        $amcdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                        $amcdate = date('Y-m-d', strtotime($amcdate));
                                                     }
                                                     else{
                                                        $amcdate = '0000-00-00';
                                                     }
                                                     $condition[] = "amc = IF(('$amcdate' = '0000-00-00' ),NULL, '$amcdate')";
                                                     break;
                        case "Year Of Manufacture": $dtformat = explode("-", $manfyear);
                                                     if($manfyear != "" && count($dtformat)>2){
                                                        $manfyear = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                        $manfyear = date('Y-m-d', strtotime($manfyear));
                                                     }
                                                     else{
                                                        $manfyear = '0000-00-00';
                                                     }
                                                     $condition[] = "year_mfg =IF(('$manfyear' = '0000-00-00' ),NULL,  '$manfyear')";
                                                     break;
                        case "Date Of Purchase": $dtformat = explode("-", $purdate);
                                                     if($purdate != "" && count($dtformat)>2){
                                                        $purdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                                                        $purdate = date('Y-m-d', strtotime($purdate));
                                                     }
                                                     else{
                                                        $purdate = '0000-00-00';
                                                     }
                                                     $condition[] = "year_pur = IF(('$purdate' = '0000-00-00' ),NULL,  '$purdate')";
                                                     break;
                        case "On Road Price": $condition[] = "onroad_price = IF(('$roadPrice' = '' ),NULL,  '$roadPrice')";break;
                        case "Tax": $condition[] = "tax = '$taxinfo'";break;
                        default: break;
                    }
                    
                }
                
                if(count($condition)){
                    $condition = implode(",", $condition);
                    $sql = "update unit_info set $condition where  unitnumber = $unitnum";
                    $this->master_db->runQuery($sql);
                }
            }
        }
        $db=array(
                    'detail'=>$this->data['detail'],                
                );
        echo json_encode($this->grid_db->gettable_fleetinfolist($db)); 
    }
    
    
    public function getUnitsData(){
        
        $db=array(
                'detail'=>$this->data['detail']     
            );
        $array1 = $this->grid_db->getUnits($db);
        echo json_encode($array1);   
    }
    
    public function updateInsuranceInfoRecords(){
        
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $unitIds = $this->input->post('unitIds');
            $npexpdate = trim(preg_replace('!\s+!', '',$this->input->post('npexpdate1')));
            $insexpDate = trim(preg_replace('!\s+!', '',$this->input->post('insexpDate1')));
            $fcdate = trim(preg_replace('!\s+!', '',$this->input->post('fcdate1')));
            $amcdate = trim(preg_replace('!\s+!', '',$this->input->post('amcdate1')));
            
            $dtformat = explode("-", $npexpdate);
            if($npexpdate != "" && count($dtformat)>2){
                $npexpdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                $npexpdate = date('Y-m-d', strtotime($npexpdate));
            }
            else{
                $npexpdate = '0000-00-00';
            }
            
            $dtformat = explode("-", $insexpDate);
            if($insexpDate != "" && count($dtformat)>2){
                $insexpDate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                $insexpDate = date('Y-m-d', strtotime($insexpDate));
            }
            else{
                $insexpDate = '0000-00-00';
            }
            
            $dtformat = explode("-", $fcdate);
            if($fcdate != "" && count($dtformat)>2){
                $fcdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                $fcdate = date('Y-m-d', strtotime($fcdate));
            }
            else{
                $fcdate = '0000-00-00';
            }
            
            $dtformat = explode("-", $amcdate);
            if($amcdate != "" && count($dtformat)>2){
                $amcdate = $dtformat[2]."-".$dtformat[1]."-".$dtformat[0];
                $amcdate = date('Y-m-d', strtotime($amcdate));
            }
            else{
                $amcdate = '0000-00-00';
            }
            
            $unitIds = explode(",", $unitIds);
            foreach ($unitIds as $val){
                $sql = "CALL getInsInfo('$npexpdate','$insexpDate','$fcdate','$amcdate','$val')";
                $this->master_db->runQuery($sql);
            }
        }
        
    }
   
}


/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */
