<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maintenance_db extends CI_Model{
	
	function gettable_data($db=array()){
		
		$compny = $db['detail'][0]->companyid;
		
		$sql = "SELECT m.id, l.ladleno,m.ladleid, `sndTarewt`, `sndTaretime`, type, type_desc, `repairType`, `repairTypesub`, `repairComplete`, `maintainenceTime`, `heatingStarted`, `heatingStopped`, `underHeating`, `cycleCompleted` 
				FROM `maintenance_report` m
				LEFT JOIN maintenance_menu menu ON m.repairType=menu.id
				LEFT JOIN maintenance_submenu sub ON m.repairTypesub=sub.id AND sub.type_id=menu.id
				LEFT JOIN ladle_master l ON l.id=m.ladleid
				LEFT JOIN laddle_report r ON l.id=r.ladleid AND r.ladleid=m.ladleid
				WHERE m.is_delete=0 and m.companyid = '$compny'
				group by m.id
				order by m.id desc";
	
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	function getTaredata($ladleid){
		$sql = "SELECT  DATE_FORMAT(STR_TO_DATE(TARE_DATE, '%Y-%c-%e %H:%i:%s'), '%d-%m-%Y %H:%i:%s') TARE_DATE, TARE_WT2 
				FROM laddle_report
				where ladleid =$ladleid
				order by STR_TO_DATE(TARE_DATE, '%Y-%c-%e %H:%i:%s') desc limit 1";
	
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	function deleteDetails($db = array()){
		$unitIds = $db["unitIds"];
		$sql = "update maintenance_report set is_delete=1
				WHERE id IN $unitIds ";
		$this->db->query($sql);
		
	}
	
	//Breakdown Issues Query
	
	function gettable_breakdown($db=array()){
	    $compny = $db['detail'][0]->companyid;
	    $sql = "SELECT b.id, l.ladleno, b.ladleid, date, shift, description, duration 
        FROM maintenance_breakdown b
        LEFT JOIN ladle_master l on l.id=b.ladleid
        WHERE b.companyid = '$compny'
        AND b.is_delete=0
        ORDER BY b.ladleid";
	    
	    $result = $this->db->query($sql);
	    
	    return $result->result();
	}
	
	function deleteBreakdown($db = array()){
	    $unitIds = $db["unitIds"];
	    $sql = "update maintenance_breakdown set is_delete=1
				WHERE id IN $unitIds ";
	    $this->db->query($sql);
	    
	}
	
	//Logistic Delay Query
	
	function gettable_delay($db=array()){
	    $compny = $db['detail'][0]->companyid;
	    $sql = "SELECT id,loconumber,date,shift,delaycause,duration
        FROM maintenance_delay WHERE companyid = '$compny'
        AND is_delete=0
        ORDER BY loconumber"; 
	    
	    $result = $this->db->query($sql);
	    
	    return $result->result();
	}
	
	function deleteDelay($db = array()){
	    $unitIds = $db["unitIds"];
	    $sql = "update maintenance_delay set is_delete=1
				WHERE id IN $unitIds ";
	    $this->db->query($sql);
	    
	}
	
	//Ladle Status Query
	
	function gettable_status($db=array()){
	    $compny = $db['detail'][0]->companyid;
	    $sql = "SELECT s.id, l.ladleno, s.ladleid, capacity, supplier, guarantee, beats,status,downdate
        FROM maintenance_status s
        LEFT JOIN ladle_master l ON l.id=s.ladleid
        WHERE s.companyid = '$compny'
        AND s.is_delete=0
        ORDER BY s.ladleid";
	    
	    $result = $this->db->query($sql);
	    
	    return $result->result();
	}
	
	function deleteStatus($db = array()){
	    $unitIds = $db["unitIds"];
	    $sql = "update maintenance_status set is_delete=1
				WHERE id IN $unitIds ";
	    $this->db->query($sql);
	    
	}
	
	//Dump Details
	function gettable_dump($db=array()){
	    $compny = $db['detail'][0]->companyid;
	    $sql = "SELECT d.id, l.ladleno, d.ladleid, d.scheduledate, d.executiondate, d.tarewt, d.dumptarewt, d.netwt, d.flakes, d.metal, d.remarks
        FROM maintenance_dump d
        LEFT JOIN ladle_master l ON l.id=d.ladleid
        WHERE d.companyid = '$compny'
        AND d.is_delete=0
        ORDER BY d.ladleid";
	    
	    $result = $this->db->query($sql);
	    
	    return $result->result();
	}
	
	function deleteDump($db = array()){
	    $unitIds = $db["unitIds"];
	    $sql = "update maintenance_dump set is_delete=1
				WHERE id IN $unitIds ";
	    $this->db->query($sql);
	    
	}
}

?>