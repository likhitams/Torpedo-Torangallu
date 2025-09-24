<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->load->model('main_model');
        $this->load->model('grid_db');

        $this->data['detail'] = '';
        $this->data['session'] = "user";
        $this->data['session_pwd'] = "userpwd";
        $this->data['session_data'] = "user";
        $this->data['cookie'] = "jsw_user";
        $this->data['cookie_pwd'] = "jsw_userpwd";

        $cookie = get_cookie($this->data['cookie']);
        $cookie_pwd = get_cookie($this->data['cookie_pwd']);

        if(!$this->session->userdata($this->data['session']) && $cookie=="")
        {
            redirect('userlogin','refresh');
        }
        else
        {
            $det = $this->home_db->checkSession($this->data['session'],$this->data['session_data'],$cookie, $cookie_pwd);

            if(is_array($det) && count($det)>0){
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
        $this->data['header']=$this->load->view('header', $this->data , TRUE);
        $this->data['left']=$this->load->view('left', NULL , TRUE);
        $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);
    }

    /** Small helper: always pass a float into round() */
    private function r($v, $p = 2) {
        return round(is_numeric($v) ? (float)$v : 0.0, $p);
    }

    public function index()
    {
        $this->load->view('dashboardframe',$this->data);
    }

    public function index1()
    {
        $this->load->view('dashboard_view1',$this->data);
    }

    public function tablephase()
    {
        $this->load->view('tablephase',$this->data);
    }

    public function getListdata()
    {
        $db = array(
            'detail' => $this->data['detail'],
        );

        $response = $this->grid_db->gettable_fleetlist($db);
        if (!is_array($response)) {
            $response = $response ? (array)$response : array();
        }

        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    public function getListdatamap()
    {
        if ($this->input->is_ajax_request())
        {
            $selection = $this->input->post('type');

            $db = array(
                'detail' => $this->data['detail'],
            );

            $this->data['response'] = $response = $this->grid_db->gettable_fleetlistmap($db, '', '', $selection);
            echo json_encode($response);
        }
    }

    public function refCountList()
    {
        $this->load->view('refCountList',$this->data);
    }

    public function taphole(){
        $this->load->view('taphole',$this->data);
    }

    public function productiondetails(){
        $this->load->view('productiondetails',$this->data);
    }

    public function getTiming(){
        echo date('d-m-Y H:i a');
    }

    function searchController(){
        $this->load->view('search',$this->data);
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
            if(is_array($check) && count($check)>0){
                echo 1;//exists
            }
            else echo 0;//does not exist
        }
        else echo 1;
    }

    // Alerts
    public function getServiceAlert(){
        $result = $this->home_db->getServiceAlert($this->data['detail']);
        $this->data['result'] = $result;
        $this->load->view('getServiceAlert',$this->data);
    }

    // BF Production
    public function getBfProduction(){
        $this->load->view('getBfProduction',$this->data);
    }

    // SMS Metal Alert
    public function getSmsMetal(){
        $this->load->view('getSmsMetal',$this->data);
    }

    function getMovedFilesAlert(){
        $db=array(
            'detail'=>$this->data['detail'],
        );

        $result = $this->home_db->getEmptySignalAlertCount($db);

        if ($result && isset($result[0]->count) && $result[0]->count > 0) {
            $result  = $this->home_db->getMovedFileAlert($db);
            $this->data['result'] = $result;
            $this->load->view('getMovedFilesAlert',$this->data);
        }
    }

    function get_circulations(){
        $res = $this->getCirculations();
        echo json_encode($res);
    }

    function get_counters(){
        $res = $this->getCounters();
        echo json_encode($res);
    }

    function get_prodata(){
        $res = $this->getProdata();
        echo json_encode($res);
    }

    function get_taregraphdata(){
        $type = strtolower(trim($this->input->post("type")));
        $res  = $this->getTaregraphdataNew($type);
        echo json_encode($res);
    }

    function get_tatgraphdata(){
        $type = strtolower(trim($this->input->post("type")));
        $ldno = strtolower(trim($this->input->post("ladle_no")));
        $res  = $this->getTatgraphdata($type,$ldno);
        echo json_encode($res);
    }

    function getCirculations(){

        $det = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $finalArr['loads']['tmt']          = 0;
        $finalArr['loads']['fmt']          = 0;
        $finalArr['loads']['ttl']          = 0;

        $finalArr['bf_weighment']['tmt']   = 0;
        $finalArr['bf_weighment']['fmt']   = 0;
        $finalArr['bf_weighment']['ttl']   = 0;

        $finalArr['af_weighment']['tmt']   = 0;
        $finalArr['af_weighment']['fmt']   = 0;
        $finalArr['af_weighment']['ttl']   = 0;

        $finalArr['hm_onwheel']['tmt']     = 0;
        $finalArr['hm_onwheel']['fmt']     = 0;
        $finalArr['hm_onwheel']['ttl']     = 0;

        $finalArr['empty']['tmt']          = 0;
        $finalArr['empty']['fmt']          = 0;
        $finalArr['empty']['ttl']          = 0;

        $finalArr['steel_zone']['tmt']     = 0;
        $finalArr['steel_zone']['fmt']     = 0;
        $finalArr['steel_zone']['ttl']     = 0;

        $finalArr['iron_zone']['tmt']      = 0;
        $finalArr['iron_zone']['fmt']      = 0;
        $finalArr['iron_zone']['ttl']      = 0;

        // in circulations
        $qry = "select count(lm.id) total from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $ttl = $tmp?$tmp->total:0;
        $in_circulation = $ttl;

        // LOADS
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (201,202) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['loads']['tmt'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (201,202) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['loads']['fmt'] = $tmp?$tmp->total:0;

        $finalArr['loads']['ttl'] = $finalArr['loads']['tmt'] + $finalArr['loads']['fmt'];

        // BEFORE WEIGHMENT
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (201) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['bf_weighment']['tmt'] = $bf_tmt = ($tmp?$tmp->total:0);

        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (201) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['bf_weighment']['fmt'] = $bf_fmt = ($tmp?$tmp->total:0);

        $finalArr['bf_weighment']['ttl'] = $bf_tmt + $bf_fmt;

        // AFTER WEIGHMENT
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (202) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['af_weighment']['tmt'] = $af_tmt = ($tmp?$tmp->total:0);

        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (202) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['af_weighment']['fmt'] = $af_fmt = ($tmp?$tmp->total:0);

        $finalArr['af_weighment']['ttl'] = $af_tmt + $af_fmt;

        // HOT METAL ON WHEEL (avoid NULL → round())
        $qry = "select COALESCE(sum(lm.NEW_GROSS_WEIGHT - lm.NEW_TARE_WEIGHT),0) total from ladle_master lm where lm.LOAD_STATUS in (202) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['hm_onwheel']['tmt'] = $this->r($ttl, 2);

        $qry = "select COALESCE(sum(lm.NEW_GROSS_WEIGHT - lm.NEW_TARE_WEIGHT),0) total from ladle_master lm where lm.LOAD_STATUS in (202) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['hm_onwheel']['fmt'] = $this->r($ttl, 2);

        $finalArr['hm_onwheel']['ttl'] = $this->r((float)$finalArr['hm_onwheel']['tmt'] + (float)$finalArr['hm_onwheel']['fmt'], 2);

        // EMPTY
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (203,204) and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['empty']['ttl'] = $tmp?$tmp->total:0;

        // STEEL ZONE
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (203) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['steel_zone']['tmt'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (203) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['steel_zone']['fmt'] = $tmp?$tmp->total:0;

        $finalArr['steel_zone']['ttl'] = $finalArr['steel_zone']['tmt'] + $finalArr['steel_zone']['fmt'];

        // IRON ZONE
        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (204) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['iron_zone']['tmt'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.LOAD_STATUS in (204) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['iron_zone']['fmt'] = $tmp?$tmp->total:0;

        $finalArr['iron_zone']['ttl'] = $finalArr['iron_zone']['tmt'] + $finalArr['iron_zone']['fmt'];

        return (object) $finalArr;
    }

    function getCounters(){
        $det = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $finalArr['total']           = 0;
        $finalArr['in_circulation']  = 0;
        $finalArr['maintenance']     = 0;
        $finalArr['non_circulation'] = 0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['total'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 1 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['in_circulation'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 0 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['maintenance'] = $tmp?$tmp->total:0;

        $qry = "select count(lm.id) total from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 0 and lm.companyid = '$company_id'";
        $tmp = $this->main_model->manRow($qry);
        $finalArr['non_circulation'] = $tmp?$tmp->total:0;

        return (object) $finalArr;
    }

    function getProdata(){

        $det = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $finalArr['bf_production']['tmt']  = 0;
        $finalArr['bf_production']['fmt']  = 0;
        $finalArr['bf_production']['ttl']  = 0;

        $finalArr['sms_received']['tmt']   = 0;
        $finalArr['sms_received']['fmt']   = 0;
        $finalArr['sms_received']['ttl']   = 0;

        $finalArr['at_weighbridge']['tmt'] = 0;
        $finalArr['at_weighbridge']['fmt'] = 0;
        $finalArr['at_weighbridge']['ttl'] = 0;

        // BF PRODUCTION
        $fromTime = date('Y-m-d',strtotime("-1 days"))." 00:00";
        $toTime   = date('Y-m-d')." 23:59";

        $where_fromto = " and TARE_DATE_dt IS NOT NULL  and (lr.FIRST_TARE_TIME_dt >= '$fromTime' and lr.FIRST_TARE_TIME_dt <= '$toTime')";

        $qry = "select COALESCE(sum(calc_value),0) total from (select lr.GROSS_WEIGHT - lr.TARE_WEIGHT as calc_value from laddle_report lr where lr.SOURCE in ('BF3','BF4') $where_fromto) as t1";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['bf_production']['tmt'] = $this->r($ttl, 2);

        $qry = "select COALESCE(sum(calc_value),0) total from (select lr.GROSS_WEIGHT - lr.TARE_WEIGHT as calc_value from laddle_report lr where lr.SOURCE in ('BF1','BF2','Corex1','Corex2') $where_fromto) as t1";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['bf_production']['fmt'] = $this->r($ttl, 2);

        $finalArr['bf_production']['ttl'] = $this->r((float)$finalArr['bf_production']['tmt'] + (float)$finalArr['bf_production']['fmt'], 2);

        // SMS RECEIVED
        $fromTime = date('Y-m-d',strtotime("-1 days"))." 00:00";
        $toTime   = date('Y-m-d')." 23:59";

        $where_fromto = " and TARE_DATE_dt IS NOT NULL and (lr.FIRST_TARE_TIME_dt >= '$fromTime' and lr.FIRST_TARE_TIME_dt <= '$toTime')";

        $qry = "select COALESCE(sum(calc_value),0) total from (select lr.GROSS_WEIGHT - lr.TARE_WT2 as calc_value from laddle_report lr where lr.SOURCE in ('BF3','BF4') $where_fromto) as t1";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['sms_received']['tmt'] = $this->r($ttl, 2);

        $qry = "select COALESCE(sum(calc_value),0) total from (select lr.GROSS_WEIGHT - lr.TARE_WT2 as calc_value from laddle_report lr where lr.SOURCE in ('BF1','BF2','Corex1','Corex2') $where_fromto) as t1";
        $tmp = $this->main_model->manRow($qry);
        $ttl = isset($tmp->total) ? (float)$tmp->total : 0.0;
        $finalArr['sms_received']['fmt'] = $this->r($ttl, 2);

        $finalArr['sms_received']['ttl'] = $this->r((float)$finalArr['sms_received']['tmt'] + (float)$finalArr['sms_received']['fmt'], 2);

        return (object) $finalArr;
    }

    function get_torpedosHtml(){
        $html = "<center>No data fetched !</center>";

        $det  = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $list_type  = trim(strtolower($this->input->post("list_type")));

        $qry = "";

        if($list_type == "total"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.companyid = '$company_id'";
        }else if($list_type == "maintenance"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 0 and lm.companyid = '$company_id'";
        }else if($list_type == "in-circulation"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "non-circulation"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.ladletype LIKE 'TLC%' and lm.cycle = 0 and lm.companyid = '$company_id'";
        }else if($list_type == "ld-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201,202) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "ld-tmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201,202) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "ld-fmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201,202) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "bw-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "bw-tmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201) and lm.SOURCE in ('BF3','BF4') and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "bw-fmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (201) and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "aw-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (202) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "aw-tmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (202) and lm.cycle = 1 and lm.SOURCE in ('BF3','BF4') and lm.companyid = '$company_id'";
        }else if($list_type == "aw-fmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (202) and lm.cycle = 1 and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.companyid = '$company_id'";
        }else if($list_type == "em-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (203,204) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "sz-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (203) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "sz-tmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (203) and lm.cycle = 1 and lm.SOURCE in ('BF3','BF4') and lm.companyid = '$company_id'";
        }else if($list_type == "sz-fmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (203) and lm.cycle = 1 and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.companyid = '$company_id'";
        }else if($list_type == "iz-ttl"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (204) and lm.cycle = 1 and lm.companyid = '$company_id'";
        }else if($list_type == "iz-tmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (204) and lm.cycle = 1 and lm.SOURCE in ('BF3','BF4') and lm.companyid = '$company_id'";
        }else if($list_type == "iz-fmt"){
            $qry = "select ladleno ladle_no from ladle_master lm where lm.LOAD_STATUS in (204) and lm.cycle = 1 and lm.SOURCE in ('BF1','BF2','Corex1','Corex2') and lm.companyid = '$company_id'";
        }

        if($qry != ""){
            $res = $this->main_model->manRes($qry);
            if($res){
                $i = 1;
                $html = "<table id='tbl-torpedo' class='table'>";
                $html.= "<tr>";
                $html.= "<th>Sl.No.</th>";
                $html.= "<th>Torpedo</th>";
                $html.= "</tr>";
                foreach($res as $r){
                    $html.= "<tr>";
                    $html.= "<td>".$i++."</td>";
                    $html.= "<td>".$r->ladle_no."</td>";
                    $html.= "</tr>";
                }
                $html.= "</table>";
            }
        }

        echo $html;
    }

    function get_ladle_autocomplete() {
        $term = $this->input->get('term');

        $this->db->select('ladleno');
        $this->db->from('ladle_master');
        $this->db->like('ladleno', $term);
        $this->db->where('companyid', 95);
        $query = $this->db->get();

        $result = $query->result_array();
        echo json_encode($result);
    }

    function get_breachedGFs(){
        $type = trim(strtolower($this->input->post("type")));
        $res  = $this->getBreachedGfs($type);
        echo json_encode($res);
    }

    function getTatgraphdata($type = "",$ladle_no = ""){
        $det  = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $finalArr = array();
        $dataArr  = array();

        $categoriesArr = array();
        $seriesArr     = array();

        $ladle_no = str_replace("-"," ",$ladle_no);
        $ladle_no = str_replace("#","",$ladle_no);
        $ladle_no = trim($ladle_no);

        for($i = 7;$i >= 1;$i--){
            $newi = 30 - $i;
            $date = date("Y-m-d", strtotime("-$i days"));

            $qry = "SELECT ROUND(AVG(TIMESTAMPDIFF(HOUR, trip_start_dt, load_dt)),2) as iz_avg, ROUND(AVG(TIMESTAMPDIFF(HOUR, load_dt, trip_end_dt)), 2) as sz_avg, ROUND(AVG(TIMESTAMPDIFF(HOUR, trip_start_dt, trip_end_dt)), 2) as tt_avg from tat_summary where TIMESTAMPDIFF(HOUR, trip_start_dt, trip_end_dt) < 48 and date(trip_end_dt) = '$date'";

            if($ladle_no != ""){
                $qry .= " and ladleno = '$ladle_no'";
            }else{
                if($type == "fmt"){
                    $qry .= " and source_gf_id IN (select geofencenumber FROM geofences where companyid = '$company_id' and geofencename IN ('BF1', 'BF2', 'Corex1','Corex2'))";
                }else if($type == "tmt"){
                    $qry .= " and source_gf_id IN (select geofencenumber FROM geofences where companyid = '$company_id' and geofencename IN ('BF3','BF4'))";
                }
            }

            $tmp = $this->main_model->manRow($qry);

            $dataArr[date("D d",strtotime($date))]['iz_avg'] = $tmp?$tmp->iz_avg:0;
            $dataArr[date("D d",strtotime($date))]['sz_avg'] = $tmp?$tmp->sz_avg:0;
            $dataArr[date("D d",strtotime($date))]['tt_avg'] = $tmp?$tmp->tt_avg:0;

            $categoriesArr[] = date("D d",strtotime($date));
        }

        if($dataArr){
            $iz_arr = $sz_arr = $tt_arr = $labels = array();
            foreach($dataArr as $day=>$arr){
                $iz_arr[] = $arr['iz_avg'];
                $sz_arr[] = $arr['sz_avg'];
                $tt_arr[] = $arr['tt_avg'];
            }

            $izData         = array();
            $izData['name'] = "Iron Zone";
            $izData['data'] = $iz_arr;
            $seriesArr[]    = $izData;

            $szData         = array();
            $szData['name'] = "Steel Zone";
            $szData['data'] = $sz_arr;
            $seriesArr[]    = $szData;

            $ttData         = array();
            $ttData['name'] = "TAT";
            $ttData['data'] = $tt_arr;
            $seriesArr[]    = $ttData;

            $finalArr['categories'] = $categoriesArr;
            $finalArr['series']     = $seriesArr;
        }

        return $finalArr;
    }

    function getTaregraphdataNew($type = ""){
        $finalArr      = array();
        $dataArr       = array();

        $bfpArr        = array();
        $smsArr        = array();

        $categoriesArr = array();
        $seriesArr     = array();

        for($i = 7;$i >= 1;$i--){
            $newi = 40 - $i;
            $date = date("Y-m-d", strtotime("-$i days"));

            $where = "";

            if($type == "fmt"){
                $where = " and source in ('BF1','BF2','Corex1','Corex2')";
            }else if($type == "tmt"){
                $where = " and source in ('BF3','BF4')";
            }

            $qry = "select source,dest,sum(bf_prod) bf_total,sum(sms_prod) sms_total from day_prod_summary where prod_date = '$date' $where group by source,dest";
            $res = $this->main_model->manRes($qry);
            foreach($res as $r){
                $source = strtolower(trim($r->source));
                $source = strtoupper(substr($source, 0, 1) === "r"?"RFL":$source);

                $dest   = strtolower(trim($r->dest));
                $dest   = strtoupper(substr($dest, 0, 1) === "r"?"RFL":$dest);

                if(isset($dataArr[date("d",strtotime($date))]['BFP'][$source])){
                    $dataArr[date("d",strtotime($date))]['BFP'][$source] += $r->bf_total;
                }else{
                    $dataArr[date("d",strtotime($date))]['BFP'][$source]  = $r->bf_total;
                }

                if(isset($dataArr[date("d",strtotime($date))]['SMS'][$dest])){
                    $dataArr[date("d",strtotime($date))]['SMS'][$dest] += $r->sms_total;
                }else{
                    $dataArr[date("d",strtotime($date))]['SMS'][$dest]  = $r->sms_total;
                }

                if(!in_array($source,$bfpArr)){
                    $bfpArr[] = $r->source;
                }

                if(!in_array($dest,$smsArr)){
                    $smsArr[] = $r->dest;
                }
            }

            $day  = date("D d", strtotime("-$i days"));
            $categoriesArr[] = $day;
        }

        if($dataArr){
            if($bfpArr){
                foreach($bfpArr as $source){
                    $tmp = array();
                    $tmp['name']  = $source;
                    $tmp['group'] = "BFP";
                    for($i = 7;$i >= 1;$i--){
                        $newi = 40 - $i;
                        $day  = date("d", strtotime("-$i days"));
                        $val  = isset($dataArr[$day]['BFP'][$source])?$dataArr[$day]['BFP'][$source]:0;

                        $tmp['data'][] = $val;
                    }

                    $seriesArr[] = $tmp;
                }
            }

            if($smsArr){
                foreach($smsArr as $dest){
                    $tmp = array();
                    $tmp['name']  = $dest;
                    $tmp['group'] = "SMS";
                    for($i = 7;$i >= 1;$i--){
                        $newi = 40 - $i;
                        $day  = date("d", strtotime("-$i days"));
                        $val  = isset($dataArr[$day]['SMS'][$dest])?$dataArr[$day]['SMS'][$dest]:0;

                        $tmp['data'][] = $val;
                    }

                    $seriesArr[] = $tmp;
                }
            }
        }

        $finalArr['categories'] = $categoriesArr;
        $finalArr['series']     = $seriesArr;

        return $finalArr;
    }

    function getBreachedGfs($type = ""){

        $det  = $this->data['detail'];

        $company_id = $det?$det[0]->companyid:0;
        $company_id = is_numeric($company_id)?$company_id:0;

        $html = "";
        $whr  = "";

        if($type == "fmt"){
            $whr = " and ts.source_gf_id IN (select geofencenumber FROM geofences where companyid = '$company_id' and geofencename IN ('BF1', 'BF2', 'Corex1','Corex2'))";
        }else if($type == "tmt"){
            $whr = " and ts.source_gf_id IN (select geofencenumber FROM geofences where companyid = '$company_id' and geofencename IN ('BF3','BF4'))";
        }

        // Excluding specific gf_ids from breach calculation
        $qry  = "SELECT gf.geofencename,sum(td.tat_breach_interval) breach_time
        FROM tat_detail td
        INNER JOIN tat_summary ts on ts.trip_id = td.trip_id
        INNER JOIN geofences gf ON td.gf_id = gf.geofencenumber
        WHERE gf.companyid = 95
        AND td.exit_dt  >= NOW() - INTERVAL 1 DAY
        AND td.tat_breach_interval > 0 and td.gf_id not in (518, 519, 563) $whr
        GROUP BY td.gf_id
        ORDER BY sum(td.tat_breach_interval) DESC
        LIMIT 5";

        $res  = $this->main_model->manRes($qry);

        return $res?$res:array();
    }

    function testit(){
        echo date("Y-m-d H:i:s", strtotime('+1 hours 13 mins'));
    }
}

/* End of file hmAdmin.php */
/* Location: ./application/controllers/hmAdmin.php */
