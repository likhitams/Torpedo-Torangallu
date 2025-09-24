<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class operations_db extends CI_Model{
	
	function gettable_laddle($db = array()){
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$language = $db['detail'][0]->language;
	
		$tablename = $condition = "";
		
		
		$sql = "SELECT id, ladleno, cycle,totalnwt, '' dateandtime, `load`, '' remarks from ladle_master where companyid = '$compny' order by id";
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	
	function gettable_master($db=array()) {
		$sql="SELECT ms.id, mm.type, ms.type_desc FROM maintenance_menu mm  LEFT JOIN maintenance_submenu ms ON ms.type_id=mm.id WHERE ms.is_delete=0 ORDER BY mm.type ";
		$result = $this->db->query($sql);
		 
		return $result->result();
	}
	
	function deleteDetails($db = array()){
		$unitIds = $db["unitIds"];
		$sql = "update maintenance_submenu set is_delete=1
		WHERE id IN $unitIds ";
		$this->db->query($sql);
		 
	}
	
	
	function gettable_service($db = array()){
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$language = $db['detail'][0]->language;
		 
		$tablename = $condition = "";
		 
		$sql = "SELECT id, ladleno, DATE_FORMAT(STR_TO_DATE(servicedate, '%Y-%m-%d'), '%d-%m-%Y') servicedate FROM ladle_master where companyid = '$compny' order by id";
		$result = $this->db->query($sql);
		 
		return $result->result();
	}
	
	function gettable_bf($db=array()){
		$compny = $db['detail'][0]->companyid;
		$sql = " SELECT b.id,b.castno, l.ladleno, b.ladleid, b.locationid, b.loadstatus
		FROM bf_entry b
		LEFT JOIN ladle_master l ON l.id=b.ladleid
		WHERE b.companyid = '$compny'
		AND b.is_delete=0";
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function deleteBf($db = array()){
		$unitIds = $db["unitIds"];
		$sql = "update bf_entry set is_delete=1
		WHERE id IN $unitIds ";
		$this->db->query($sql);
		 
	}
	
	

}

?>