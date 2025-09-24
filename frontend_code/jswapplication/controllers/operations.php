<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class operations extends CI_Controller {

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
        $this->load->model('operations_db');
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
            //echo $this->db->last_query();exit;    battery_installdate
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
        $this->data['jsfileone']=$this->load->view('jsfileone', NULL , TRUE);
        $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);        
    }

    public function attach_detach()
    {                   
        $this->load->view('attachLadle',$this->data);       
    } 
    
    public function getListdata()
    {       
        
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->grid_db->gettable_fleetlist($db, "", "", "ORDER BY isengine asc"));   
    }
    

    public function getLaddleNodata()
    {
        $db=array(
                'detail'=>$this->data['detail'],                
        );
        echo json_encode($this->operations_db->gettable_laddle($db)); 
    }
    
    public function updateLadleDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {       
            $det = $this->data['detail'];       
            $registration=trim(preg_replace('!\s+!', '',$this->input->post('registration')));
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('id')));          
            if($oid != ""){
                if($registration != "" && $registration != "-1"){
                    $db = array("unitnumber != "=>$oid, "registration"=>$registration);    
                    $checkUnit = $this->master_db->getRecords("units",$db,"unitnumber, unitname");
                    if(count($checkUnit) == 0){//if not assigned to any unit then assign laddle
                        
                        $checkUnitreg = $this->master_db->getRecords("units",array("unitnumber"=>$oid),"unitnumber, registration");
                        if($checkUnitreg[0]->registration != NULL){
                            $db=array(
                                    'unitnumber'=>$oid,
                                    'ladleno'=>$checkUnitreg[0]->registration,
                                    'user_id'=>$det[0]->userId, 
                                    'modified_date'=>date('Y-m-d H:i:s'),
                                    'unassign'=>1    
                                );
                            $this->master_db->insertRecord('ladle_assign',$db);//unassign old laddle
                        }
                        
                        $db = array(                
                                'registration'=>$registration
                            );    
                    
                        $this->master_db->updateRecord("units", $db, array("unitnumber"=>$oid));
                        
                        $db=array(
                                'unitnumber'=>$oid,
                                'ladleno'=>$registration,
                                'user_id'=>$det[0]->userId, 
                                'modified_date'=>date('Y-m-d H:i:s')    
                        );
                        $res=$this->master_db->insertRecord('ladle_assign',$db);    //assign new laddle
                        echo 1;
                    }
                    else{
                        echo "Ladle No. $registration is assigned to ".$checkUnit[0]->unitname.". Please unassign.";
                    }
                }
                else if($registration == "-1"){
                    $db = array("unitnumber"=>$oid);    
                    $checkUnit = $this->master_db->getRecords("units",$db,"unitnumber, unitname, registration");
                    $db = array(                
                                'registration'=>NULL
                            );    
                    
                    $this->master_db->updateRecord("units", $db, array("unitnumber"=>$oid));
                    
                    $db=array(
                                'unitnumber'=>$oid,
                                'ladleno'=>$checkUnit[0]->registration,
                                'user_id'=>$det[0]->userId, 
                                'modified_date'=>date('Y-m-d H:i:s'),
                                'unassign'=>1   
                        );
                    $res=$this->master_db->insertRecord('ladle_assign',$db);    
                    echo 1;
                }
                else{
                    echo 1;
                }
            }
            else{
                echo "All fields are Mandatory";
            }
        }
    }
    
    
    public function cycling_noncycling()
    {                   
        $this->load->view('cycle_noncycle',$this->data);       
    } 
    public function addremarks()
    {                   
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
        $remarks=$this->input->POST('remarks') ;
         // Check if the remarks already exist in the database
        $existingRemarks = $this->master_db->getRecords('ladle_remarks', array('remarks' => $remarks));
        // echo "<script>alert('$remarks');</script>";
        
        if (!$existingRemarks) {
        $db = array('remarks' => $remarks);

        // Insert the new remarks into the database
        $this->master_db->insertRecord('ladle_remarks', $db);

        $message1 = '<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Remarks Added Successfully.</div>';
        $this->session->set_flashdata('message', $message1);
       } 
    else 
    {
        $message2 = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Remarks already exist. Please enter a different remark.</div>';
        $this->session->set_flashdata('message', $message2);
    }

    redirect("operations/cycling_noncycling");
    }
       
    } 
 

    public function update_remark()
{
    $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
    //$connect = mysqli_connect("127.0.0.1", "root", '', "suvetracg");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $remarkId = $_POST['remarkId'];
        $editedRemark = $_POST['editedRemark'];

        // Retrieve the existing remark from the database
        $selectSql = "SELECT remarks FROM ladle_remarks WHERE id = $remarkId";
        $result = mysqli_query($connect, $selectSql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $existingRemark = $row['remarks'];

            // Check if the edited remark is different from the existing one
            if ($editedRemark !== $existingRemark) {
                // Check if the edited remark already exists in the database
                $checkDuplicateSql = "SELECT id FROM ladle_remarks WHERE remarks = '$editedRemark' AND id != $remarkId";
                $duplicateResult = mysqli_query($connect, $checkDuplicateSql);

                if ($duplicateResult && mysqli_num_rows($duplicateResult) === 0) {
                    // Update the remark in the database
                    $updateSql = "UPDATE ladle_remarks SET remarks = '$editedRemark' WHERE id = $remarkId";
                    if (mysqli_query($connect, $updateSql)) {
                        echo "Remark updated successfully.";
                        $message3 = '<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Remarks Update Successfully.</div>';
                        $this->session->set_flashdata('message', $message3);
                        redirect("operations/cycling_noncycling");
                    } else {
                        echo "Error updating remark: " . mysqli_error($connect);
                        $message4 = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Failed to update remark.</div>';
                        $this->session->set_flashdata('message', $message4);
                        redirect("operations/cycling_noncycling");
                    }
                } else {
                    echo "Edited remark already exists. No update needed.";
                    $message5 = '<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Edited remark already exists. No update needed.</div>';
                    $this->session->set_flashdata('message', $message5);
                    redirect("operations/cycling_noncycling");
                }
            } else {
                echo "Edited remark is the same as the existing one. No update needed.";
                $message6 = '<div class="alert alert-info alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Edited remark is the same as the existing one. No update needed.</div>';
                $this->session->set_flashdata('message', $message6);
                redirect("operations/cycling_noncycling");
            }
        } else {
            echo "Remark with ID $remarkId does not exist.";
            $message7 = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Remark with ID ' . $remarkId . ' does not exist.</div>';
            $this->session->set_flashdata('message', $message7);
            redirect("operations/cycling_noncycling");
        }
    }
}


    public function delete_remark()
    {
         $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
    //$connect = mysqli_connect("127.0.0.1", "root", '', "suvetracg");
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remarkIdToDelete"]))
         {
                $remarkIdToDelete = $_POST["remarkIdToDelete"];
                $sql = "DELETE FROM ladle_remarks WHERE id = '$remarkIdToDelete'";
             if (mysqli_query($connect, $sql)) {
        echo "Remarks Deleted successfully.";
        } 
        else
         {
            echo "Remark not deleted : " . mysqli_error($connect);
        }   
    $message5='<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Remarks Deleted Successfully.</div>';
            $this->session->set_flashdata('message',$message5);
            redirect("operations/cycling_noncycling");
         }     
    }
    public function saveCycling(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {       
            $det = $this->data['detail'];   
            $laddleid = $this->input->post('laddleid');  
            $oldladleid = $this->input->post('oldladleid');
            $ladlename = $this->input->post('ladlename'); 
            // $ladlename1 = implode(', ', $ladlename);
            // echo "<script>alert('$ladlename1');</script>";
            $cyclingDate = $this->input->post('cyclingDate');
            $cyclingDate1 = implode(', ', $cyclingDate);
            $remarks = $this->input->post('remarks');
            
// echo "laddleid: ";
// print_r($laddleid);


            if(is_array($laddleid) && count($laddleid) > 0){
                foreach ($laddleid as $key=>$l){
                    $cycling=$this->input->post('cycling'.$l);  
                    $date = trim(preg_replace('!\s+!', '',$cyclingDate[$key]));
                    if($oldladleid[$key] != $cycling && $date != ""){
                        
                        $db = array(                
                                    'cycle'=>$cycling
                                );   
                        $up=$this->master_db->updateRecord("ladle_master", $db, array("id"=>$l));
                         
                       echo $this->db->last_query();
                        if($cycling == "1"){
                            $date=date_create($date);$date=date_format($date,"Y-m-d H:i:s");
                            $db=array(
                                    'ladle_id'=>$l,
                                    'cycling_date'=>$date,
                                    'non_cycling_date'=>$date,
                                    'completeCycle'=>0,
                                     
                            );
                            $this->master_db->insertRecord('ladle_cyclingHistory',$db); 
                             echo  $this->db->last_query();
                        }
                        else{
                            $db = array("ladle_id"=>$l, "completeCycle"=>0);    
                            $checkUnit = $this->master_db->getRecords("ladle_cyclingHistory", $db, "id", "cycling_date desc");
                            // echo $this->db->last_query();
                            if(count($checkUnit) && $remarks[$key] != ""){
                            $date=date_create($date);$date=date_format($date,"Y-m-d H:i:s");
                                $db=array(
                                        'ladle_id'=>$l,
                                        'non_cycling_date'=>$date,
                                        'completeCycle'=>1,
                                        'remarks'=>$remarks[$key]
                                );
             if ($remarks[$key] == '14') 
             {
                                   
    // Update the "load" field in the "ladle_master" to "0"
                    $dbUpdate = array(
                        'totalload' => '0'
                    );
                    $this->master_db->updateRecord("ladle_master", $dbUpdate, array("id" => $l));
            }
                                
                                $this->master_db->updateRecord("ladle_cyclingHistory", $db, array("id"=>$checkUnit[0]->id));
                                
                                $checkUnit = $this->master_db->getRecords("ladle_remarks", array("id"=>$remarks[$key]), "remarks");
                                // echo $dbString = serialize($checkUnit);
                                if(count($checkUnit)){
                                    $ab=$this->master_db->updateRecord("ladle_master", array("remarks"=>$checkUnit[0]->remarks), array("id"=>$l));
                                       
                                }
                         // echo $this->db->last_query();
                        
                            }
                        }
                    }
                }
                $message='<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Updated Successfully.</div>';
                
            }
            else{
                $message='<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Data is missing!</div>';
            }
            ///exit; 
            $this->session->set_flashdata('message',$message);
            redirect("operations/cycling_noncycling");
        }
        else{
            redirect("operations/cycling_noncycling");
        }
        
    }
    
    
    public function geofence_track()
    {       
        $db=array(
                'detail'=>$this->data['detail']             
        );
        $this->data['GeofenceAddDetails']=$this->load->view('GeofenceAddDetails', $this->data , TRUE);
        $this->data['LocationAddDetails']=$this->load->view('LocationAddDetails', $this->data , TRUE);
        $this->load->view('geofence_track',$this->data);       
    }

    
    public function ladleLoad()
    {                   
        $this->load->view('ladleload',$this->data);       
    } 
    
    //Service Details
    public function service()
    {
        $this->load->view('service',$this->data);
    } 
    
    public function getLadleServiceData()
    {
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->operations_db->gettable_service($db));
    }
    
    //Update Service Date
    
 public function saveService() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Fetching POST data
        $carid = $this->input->post('carid');
        $batteryno = $this->input->post('batteryno');
        $installDate = $this->input->post('installDate');

        if (is_array($carid) && count($carid) > 0) {
            $message = ''; // Initialize message variable

            foreach ($carid as $key => $l) {
                $battery = trim(preg_replace('!\s+!', '', $batteryno[$key]));
                $installe = trim(preg_replace('!\s+!', '', $installDate[$key]));

                // Check if $installe is valid and $battery is not empty
                if ($installe != "" && $battery != "" && $installe != "00-00-0000") {
                    $date = date_create($installe);
                    $date1 = date_format($date, "Y-m-d");

                    $db = array(
                        'servicedate' => $date1
                    );

                    // Perform database update
                    $this->master_db->updateRecord("ladle_master", $db, array("id" => $l));
                } else {
                    // Optionally, handle case where conditions are not met
                    // This block is empty because your original logic did not specify what to do if conditions fail
                }
            }

            // Set success message if no errors occurred during loop
            $message = '<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Updated Successfully.</div>';
        } else {
            // Handle case where $carid is not an array or is empty
            $message = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Data is missing!</div>';
        }

        // Set flash message and redirect
        $this->session->set_flashdata('message', $message);
        redirect("operations/service");
    } else {
        // Handle case where request method is not POST
        redirect("operations/service");
    }
}

    
    
    public function updateLadleLoadDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {       
            $det = $this->data['detail'];       
            
            
            
            $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
            $load=trim(preg_replace('!\s+!', '',$this->input->post('load')));
            $totalnwt=trim(preg_replace('!\s+!', '',$this->input->post('totalnwt')));
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('id')));          
            if($oid != ""){
                
                $db = array(                
                    'load'=>$load,'totalnwt'=>$totalnwt
                            );    
                    
                $this->master_db->updateRecord("ladle_master", $db, array("id"=>$oid));
                echo 1;
            
            }
            else{
                echo "All fields are Mandatory";
            }
        }
    }
    
    public function carBattery(){
        $this->load->view('carBattery',$this->data);   
    }
    
    public function updatebatteryDetails(){//id: id, batteryno: batteryno, battery_installdate:battery_installdate
        if($_SERVER['REQUEST_METHOD']=='POST')
        {       
            $det = $this->data['detail'];       
            $batteryno=trim(preg_replace('!\s+!', '',$this->input->post('batteryno')));
            $battery_installdate=trim(preg_replace('!\s+!', '',$this->input->post('battery_installdate')));
            $oid=trim(preg_replace('!\s+!', '',$this->input->post('id')));          
            if($oid != "" && $batteryno != "" && $batteryno != "0"){
    
                    $db = array("unitnumber !="=>$oid, "batteryno"=>$batteryno);    
                    /*$checkUnit = $this->master_db->getRecords("units",$db,"unitnumber, unitname, registration");*/
                    if(count($checkUnit)){
                        echo "Battery No.:".$batteryno." already installed to Ladle Car: ".$checkUnit[0]->unitname;
                    }
                    else{
                        echo 1;
                    }
                    /*$date=date_create($battery_installdate);$date=date_format($date,"Y-m-d");
                    $db = array(                
                                'batteryno'=>$batteryno,
                                'battery_installdate'=>$date
                            );    
                    
                    $this->master_db->updateRecord("units", $db, array("unitnumber"=>$oid));
                    */
                    
            
            }
            else{
                echo 1;
            }
        }
    }
    
    
    public function saveBattery(){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {       
            $det = $this->data['detail'];  
  
            $carid = $this->input->post('carid');  
            $batteryno = $this->input->post('batteryno'); 
            $oldbattery = $this->input->post('oldbattery');     
            $installDate = $this->input->post('installDate');
            
            if(is_array($carid) && count($carid) > 0){
                $arr = array();
                foreach ($carid as $key=>$l){
                    $battery=trim(preg_replace('!\s+!', '',$batteryno[$key]));
                    //echo "<br>";
                    $installe=trim(preg_replace('!\s+!', '',$installDate[$key]));
                    //echo "<br>";
                    //$db = array("unitnumber !="=>$l, "batteryno"=>$battery);    
                    //echo "select unitnumber, unitname from units where unitnumber !=$l and batteryno=$battery";
                    $checkUnit = array();
                    if($battery != "0"){
                    /*  $checkUnit = $this->master_db->runQuerySql("select unitnumber, unitname from units where unitnumber !=$l and batteryno=$battery");*/
                    }
                    if(count($checkUnit) == 0){
                        echo $battery;
                        if($installe != "" &&  $battery != ""){
                            $date=date_create($installe);$date=date_format($date,"Y-m-d");
                            
                            $db = array(                
                                        'batteryno'=>$battery,
                                        'battery_installdate'=>$date
                                    );    
                        
                            $this->master_db->updateRecord("units", $db, array("unitnumber"=>$l));
                        }
                    }
                    else{
                        $arr[] = "Battery No.:".$battery." already installed to Ladle Car: ".$checkUnit[0]->unitname;
                    }
                }
                if(count($arr)){
                    $message='<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>'.implode("<br>", $arr).'</div>';
                }
                else{
                $message='<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Updated Successfully.</div>';
                }
            }
            else{
                $message='<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Data is missing!</div>';
            }
        //exit; 
            $this->session->set_flashdata('message',$message);
            redirect("operations/carBattery");
        }
        else{
            redirect("operations/carBattery");
        }
    }
    
    //Master Data Repair Report
    
    public function master()
    {
        $this->load->view('master',$this->data);
    } 
    
    public function getMaintenanceData()
    {
        
        $db=array(
            'detail'=>$this->data['detail'],
        );
        echo json_encode($this->operations_db->gettable_master($db));
    }
    
    public function addDetails(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //print_r($_POST); 
            
            $type=trim(preg_replace('!\s+!', '',$this->input->post('type')));
            $type_desc= trim(preg_replace('!\s+!', '',$this->input->post('type_desc')));
            
            $id = $this->master_db->runQuerySql("select id from maintenance_menu where type ='$type' LIMIT 1");
          
            if(count($id)==0){
                
                $db1 = array("type"=>$type);
                $this->master_db->insertRecord('maintenance_menu',$db1);
                
                $id2 = $this->master_db->runQuerySql("select id from maintenance_menu where type ='$type' LIMIT 1");
                
                $id3 = $id2[0]->id;
                
                $db2 = array("type_id"=>$id3, "type_desc"=>$type_desc);
                $this->master_db->insertRecord('maintenance_submenu',$db2);
                echo 1;
                
            }else{
                $id1 = $id[0]->id;
                
                $db = array("type_id"=>$id1, "type_desc"=>$type_desc);
                $this->master_db->insertRecord('maintenance_submenu',$db);
                echo 1;
            }
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
        
        $this->operations_db->deleteDetails($db);
        echo 1;
    }
}

//BF Entry

public function bf()
{
    $this->load->view('bfentry',$this->data);
}

public function getbfDetails()
{
    
    $db=array(
        'detail'=>$this->data['detail'],
    );
    echo json_encode($this->operations_db->gettable_bf($db));
}

public function addBf(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $det = $this->data['detail'];
        $cid = $det[0]->companyid;
        $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
        $castno=trim(preg_replace('!\s+!', ' ',$this->input->post('castno')));
        $locationid=trim(preg_replace('!\s+!', ' ',$this->input->post('locationid')));
        $loadstatus=trim(preg_replace('!\s+!', '',$this->input->post('loadstatus')));
        $date = date('Y-m-d H:i:s');
       
        if($loadstatus=="Empty"){
            $db = array("locid"=>$locationid,"tstatus"=>'1',);
            $this->master_db->updateRecord("ladle_master", $db, array("id"=>$ladleno));
           }
        else{
            $db = array("locid"=>$locationid,"tstatus"=>'2',);
            $this->master_db->updateRecord("ladle_master", $db, array("id"=>$ladleno));
            }
        
        $db = array(
            "ladleid"=>$ladleno,
            "loadstatus"=>$loadstatus,
            "castno"=>$castno,
            "companyid"=>$cid,
            "locationid"=>$locationid,
            "entrytime"=>$date,
            "is_delete"=>0
            
        );
        
        $this->master_db->insertRecord("bf_entry", $db);
        echo 1;     
        
    }
}

public function modifyBf(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $oid=trim(preg_replace('!\s+!', '',$this->input->post('oid')));
        $det = $this->data['detail'];
        $cid = $det[0]->companyid;
        $ladleno=trim(preg_replace('!\s+!', '',$this->input->post('ladleno')));
        $castno=trim(preg_replace('!\s+!', ' ',$this->input->post('castno')));
        $locationid=$this->input->post('locationid');
        $loadstatus=trim(preg_replace('!\s+!', '',$this->input->post('loadstatus')));
        $date = date('Y-m-d H:i:s');
        if($loadstatus=="Empty"){
            $db = array("locid"=>$locationid,"tstatus"=>'1',);
            $this->master_db->updateRecord("ladle_master", $db, array("id"=>$ladleno));
        }
        else{
            $db = array("locid"=>$locationid,"tstatus"=>'2',);
            $this->master_db->updateRecord("ladle_master", $db, array("id"=>$ladleno));
        }
        
        $db = array(
            "ladleid"=>$ladleno,
            "loadstatus"=>$loadstatus,
            "castno"=>$castno,
            "companyid"=>$cid,
            "locationid"=>$locationid,
            "exittime"=>$date,
            "is_delete"=>0
        );
        $this->master_db->updateRecord("bf_entry", $db, array("id"=>$oid));
        echo 1; 
    }
}

public function deleteBf(){
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $unitIds=$this->input->post('unitIds');
        
        
        $db = array(
            'unitIds'=>"(".implode(",", $unitIds).")"
        );
        
        $this->operations_db->deleteBf($db);
        echo 1;
    }
}
}
