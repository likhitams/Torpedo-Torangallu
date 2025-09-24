<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reportsgroup_db extends CI_Model{
	
	
	
	function gettable_consolidate($db = array()){
		//$unitnumber = $db['unitnumber'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$group = $db['group'];
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}
		$sql = "SELECT g.groupdesc AS groupname, u.unitname AS unitname, ROUND((m.tripdistance),2) AS dist, 
		    DATE_FORMAT(FROM_UNIXTIME(m.ignontimeunix+19800),'%Y-%m-%d %H:%i:%s') AS ignon,
             DATE_FORMAT(FROM_UNIXTIME(m.ignofftimeunix+19800),'%Y-%m-%d %H:%i:%s') AS ignoff,
             m.tripdate AS reportdate ,if(m.startodo=0.00,'N/A',m.startodo) as startodo , if(m.endodo=0.00,'N/A',m.endodo)  as endodo,
		    ((m.triptimesec)) AS workinghours,
            ((m.totaltime-m.triptimesec)) AS idlehours,  (m.ignoffevent) AS ignoffcount,m.highspeed as highspeed
             FROM trip_summary AS m
		  	LEFT JOIN groupmembers gm ON gm.unitnumber=m.unitnumber
	             LEFT JOIN units u ON u.unitnumber=m.unitnumber 
	             LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber 
			WHERE gm.groupnumber $qry
			AND g.is_delete IS FALSE AND gm.is_delete IS FALSE AND 
			m.tripdate >= '$start_date' and m.tripdate <= '$end_date' 
			GROUP BY g.groupdesc,u.unitname,m.tripdate
			ORDER BY g.groupdesc,u.unitname,m.tripdate";	
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getGroupsnum($uid){
		$sql = "SELECT groupnumber FROM mst_groups WHERE user_id = ".$uid." AND is_delete IS FALSE";
		$q=$this->db->query($sql);	
		if($q->num_rows()>0){	
			$res = $q->result();
			$arr = array();
			foreach($res as $r){
				$arr[] = $r->groupnumber;
			}
			return $qry = " in (".implode(",", $arr).")";
		}
		return "";
	}
	
	function getgroupunits($db = array()){
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$group = $db['group'];
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		/*if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}*/
		$sql = "SELECT g.groupdesc AS groupname,u.id as unitno,u.ladleno 
				FROM mst_groups g
		        LEFT JOIN groupmembers gm ON gm.groupnumber = g.groupnumber
		        LEFT JOIN ladle_master u ON u.ladleno = gm.lno
		        WHERE g.groupnumber $qry AND g.is_delete IS FALSE AND gm.is_delete IS FALSE ";	
		
		$q=$this->db->query($sql);		
		$datares = $q->result();
		
		return $datares;
	}
	
	function groupunits($db = array()){
		$group = $db['group'];
		$sql = "SELECT g.unitnumber as unitnumber FROM groupmembers g
    			WHERE g.groupnumber=$group AND is_delete=false";	
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettotaldays($fromdate){
		$sql = "SELECT DAY(LAST_DAY('$fromdate')) as dayscount";		
			
		$q=$this->db->query($sql);		
		if(count($q->result())){
			$res = $q->result();
			return $res[0]->dayscount;
		}	
		return 0;
	}
	
	function gettotaldistance($unitno, $fromdate, $todate){
		$sql = "SELECT DATE_FORMAT('$fromdate','%b-%Y') as month , IFNULL(SUM(tripdistance),0) as dist ,DATE_ADD('$todate', INTERVAL 1 DAY) AS reportdate FROM trip_summary 
    			WHERE unitnumber =$unitno AND tripdate >= '$fromdate' AND tripdate <= '$todate'";		
			
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getshiftwisedistancereport($db = array()){
		$uid = $db['uid'];
		$group = $db['group'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}
		$sql = "SELECT (h.reporttimeunix+19800) as reporttime, h.status AS statusid, h.distance AS dist,u.unitname AS unitname,h.idletime as idlehours,
			    DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+19800),'%d-%m-%y %H:%i') AS datetime, h.reporttimeunix as unixtime,
			    IFNULL(ui.indentid,'') as vehtype,IFNULL(ui.Customer,'') as contractor,
	            h.speed as highspeed FROM $historyTable 
				LEFT JOIN units u ON u.unitnumber= h.unitnumber 
				LEFT JOIN unit_info ui ON u.unitnumber= ui.unitnumber 
				WHERE h.unitnumber = $uid AND h.status not in (14,16,68,69,9) and  
				h.reporttimeunix > (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND h.reporttimeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)  
				order by h.reporttime,h.distance,h.status";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	
	
	function gettable_geofence($db = array()){
		$group = $db['group'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}
/*
		$sql = "SELECT g.geofencenumber as id, g.geodesc as geofencename FROM geofences g 
		        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
				LEFT JOIN groups gr ON gr.companyid = g.companyid
				LEFT JOIN groupmembers grm ON grm.groupnumber = gr.groupnumber
				LEFT JOIN users u ON u.company_id = g.companyid
				WHERE gr.groupnumber $qry
				AND  ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND gr.is_delete IS FALSE  AND 
		        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone) AND g.companyid =$companyid AND ge.entry_status='101' and g.geofencename not like 'exit%' and  g.geofencename is not null
		        GROUP BY g.geodesc ORDER BY g.geofencenumber";
*/
	$sql = "SELECT g.geofencenumber as id, g.geodesc as geofencename FROM geofences g
                        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber
                                LEFT JOIN mst_groups gr ON gr.companyid = g.companyid
                                LEFT JOIN groupmembers grm ON grm.groupnumber = gr.groupnumber
                                LEFT JOIN users u ON u.company_id = g.companyid
				INNER JOIN geofencepoly gp on g.geofencenumber = gp.geofencenumber 
                                WHERE gr.groupnumber $qry
                                AND  ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND gr.is_delete IS FALSE  AND
                        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone) AND g.companyid =$companyid AND ge.entry_status='101' and g.geofencename not like 'exit%' and  g.is_delete = 0 and gp.is_delete = 0
                        GROUP BY g.geodesc ORDER BY g.geofencenumber";

		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	
	
	function gettable_distanceRun($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
		 
		$sql = "SELECT g.groupdesc AS groupname, u.registration AS ladleno, ROUND(c.tripdistance,2) AS distance,  c.tripdate AS reportdate FROM trip_summary AS c
		LEFT JOIN groupmembers gm ON gm.unitnumber = c.unitnumber
		LEFT JOIN units u ON u.unitnumber=c.unitnumber
		LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
		WHERE g.groupnumber= '$group'  and  c.tripdate >= '$start_date' AND c.tripdate <= '$end_date'
		ORDER BY g.groupdesc, u.registration,c.tripdate";
	
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	function gettable_geofenceModified($db = array()){
		$group = $db['group'];
		$circulation = $db['circulation'];
		$start_datetime = $db['start_date'];
		$geoidlist = $db['geoidlist'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}
		
			 $sql = "SELECT gr.groupdesc as tGroupName,g.geodesc as tGeoName,un.ladleno as tUnitName ,ge.timeunix,ge.latitude as tStartLat,ge.cycle,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'%d-%m-%y %H:%i:%s') AS starttime,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'%d-%m-%y %H:%i:%s') AS endtime,
		        DATE_FORMAT(FROM_UNIXTIME(ge.timeunix+19800),'%d-%m-%y %H:%i:%s') AS entrytime, ge.entry_status as entrystatus,
		        ge.longitude as tStartLon,ge.location as tStartLoc FROM geofences g 
		        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
		        LEFT JOIN groups gr ON gr.companyid = g.companyid
				LEFT JOIN groupmembers grm ON grm.groupnumber = gr.groupnumber
				LEFT JOIN ladle_master un ON un.ladleno = grm.lno AND un.ladleno = ge.lno
				LEFT JOIN users u ON u.company_id = g.companyid
				WHERE gr.groupnumber $qry
				AND grm.is_delete IS FALSE AND  un.ladleno is not null and ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				ge.cycle=$circulation AND
		        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)  AND ge.entry_status IN(102,103)
		        AND ( '$geoidlist' LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED),',%')  OR '$geoidlist' 
		        LIKE CONCAT(CONVERT(ge.geofencenumber ,UNSIGNED),',%') OR '$geoidlist'=ge.geofencenumber OR '$geoidlist' 
		        LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED)))
		        GROUP BY un.ladleno,ge.timeunix,g.geodesc,ge.entry_status 
		        ORDER BY un.ladleno,ge.timeunix,g.geodesc,ge.entry_status";
		
		$q=$this->db->query($sql);	
        //print_r($q->result());	
		return $q->result();
	}
	
	function getCompanyname($db = array()){
		$companyid = $db['detail'][0]->companyid;
		$sql = "SELECT companyfullname
				FROM companies
				where companyid = $companyid ";
		
		$q=$this->db->query($sql);		
		if(count($q->result())){
			$res = $q->result();
			return $res[0]->companyfullname;
		}	
		return "";
	}
	
	function getGeoFenceGroupHtmlReport($db = array()){
		$group = $db['group'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$uid = $db['detail'][0]->userId;
		$qry = " in ($group)";
		
		if($db['checkGroup'] == "1"){
			$qry = $this->getGroupsnum($uid);
		}
		$sql = "SELECT g.geofencenumber id, g.geodesc FROM geofences g 
		        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
				LEFT JOIN groups gr ON gr.user_id = g.user_id
				LEFT JOIN groupmembers grm ON grm.groupnumber = gr.groupnumber
				LEFT JOIN users u ON u.id = g.user_id
				WHERE gr.groupnumber $qry
				AND  ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND gr.is_delete IS FALSE  AND 
		        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone) AND g.companyid =$companyid AND ge.entry_status='101'
		        GROUP BY g.geodesc ORDER BY g.geofencenumber";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getGroupGeofenceTripReportExcel($db = array()){
		$group = $db['group'];
		$unitnum = $db['unitnum'];
		$start_datetime = $db['start_date'];
		$geoidlist = $db['geoidlist'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$companyid = $db['detail'][0]->companyid;
		$uid = $db['detail'][0]->userId;
	
		$sql = "CALL getGeoReport(DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(STR_TO_DATE('$start_datetime','%Y-%m-%d %H:%i:%s'))-$timezone),'%Y-%m-%d %H:%i:%s')
				,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(STR_TO_DATE('$end_datetime','%Y-%m-%d %H:%i:%s'))-$timezone),'%Y-%m-%d %H:%i:%s'),$unitnum,'$geoidlist',$timezone,'$dateformat',$companyid) ";
		
		// New Connection
		$db = new mysqli('localhost','ivaruste_suvi','t-!{&&xztpz{','ivaruste_suvetracg');
		
		// Check for errors
		if(mysqli_connect_errno()){
			echo mysqli_connect_error();
		}
		$user_arr = array();
		// 1st Query
		$result = $db->query($sql);
		if($result){
		     // Cycle through results
		    while ($row = $result->fetch_object()){
		        $user_arr[] = $row;
		    }
		    // Free result set
		    $result->close();
		    $db->next_result();
		}
		return $user_arr;
		/*$q=$this->db->query($sql);	
		$datares = $q->result();
		$q->next_result();
		$q->free_result(); 
		return $datares;*/
	}
	
	function gettable_cycletime($db = array()){
		
		$unitqry = "";//otl
		$group = $db['group'];
		/* The following lines are commnted on 22-Aug-2024 by Ganesha to include carnot empty list, ladle number is selected as car no
		if($group == "2"){
			$unitqry = " AND sc.CARNO !='' ";//circulation   
		}
		else if($group == "3"){
			$unitqry = " AND sc.CARNO = '' ";//non-circulation
		}else 
		{
			$unitqry = " AND sc.CARNO !='' ";//circulation  TLC
		}
		*/
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		//$historyTable = $db['historyTable'];
		$sql = "SELECT sc.TRIP_ID , sc.TAPNO, u.LADLENO as CARNO, ladleid, u.LADLENO, sc.SOURCE, sc.S, sc.SI, ROUND(sc.TEMP,2) as TEMP, sc.DEST, 
					DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%d-%m-%Y %H:%i:%s') FIRST_TARE_TIME, 
					DATE_FORMAT(sc.GROSS_DATE, '%d-%m-%Y %H:%i:%s') GROSS_DATE, sc.GROSS_DATE as grdate, sc.GROSS_WEIGHT, 
					TIMESTAMPDIFF(MINUTE, DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), sc.GROSS_DATE) as ironzone,
					sc.TARE_WEIGHT, sc.NET_WEIGHT, sc.UNLOAD_DATE, IF(sc.BDSTEMP='null', '', sc.BDSTEMP) as BDSTEMP, DATE_FORMAT(sc.TARE_DATE, '%d-%m-%Y %H:%i:%s') TARE_DATE, sc.TARE_WT2, sc.NET_WT2,
					TIMESTAMPDIFF(MINUTE, sc.GROSS_DATE, sc.TARE_DATE) as steelzone
			   FROM groups g
		       left join groupmembers gm on gm.groupnumber = g.groupnumber
		       left join ladle_master u on u.ladleno = gm.lno
		       left join laddle_report sc on sc.LADLENO =u.ladleno AND sc.LADLENO =gm.lno
		       where g.groupnumber=$group and  sc.GROSS_DATE between  '$start_date' and  '$end_date' and g.is_delete is false and gm.is_delete is false $unitqry
		       ORDER BY sc.GROSS_DATE asc";
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_movement($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$exp = explode("~",$historyTable);
		if(count($exp) == 1){
		$sql = "SELECT distinct DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime,s.statusdesc as status,round(h.speed,2) as speed,h.location as location,h.status as statusid, s.statuscolor AS statusColor,h.latitude AS lat, h.longitude AS lon,IF(s.icon=1,h.direction,'') AS direction ,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime, h.unitname as unitname, u.ladleno as ladleno
				FROM history".$exp[0]." h
				LEFT JOIN ladle_master u ON u.ladleno=h.lno 
		        LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.ladleno IN ($unitnumber)  AND (s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				AND MINUTE(reporttime) % 3 = 0
				ORDER BY u.id,h.reporttimeunix ASC";
		}
		else{//select reporttime, status, speed, location, statusid, statusColor, lat, lon, direction, starttime, endtime, unitname, ladleno, reporttimeunix FROM (
			$sql = "
				(SELECT distinct DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime,u.id uid, s.statusdesc as status,round(h.speed,2) as speed,h.location as location,h.status as statusid, s.statuscolor AS statusColor,h.latitude AS lat, h.longitude AS lon,IF(s.icon=1,h.direction,'') AS direction ,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime, h.unitname as unitname, u.ladleno as ladleno,h.reporttimeunix
				FROM history".$exp[0]." h
				LEFT JOIN ladle_master u ON u.ladleno=h.lno 
		        LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.ladleno IN ($unitnumber)  AND (s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				AND MINUTE(reporttime) % 3 = 0) 
				UNION 
				(SELECT distinct DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime,u.id uid, s.statusdesc as status,round(h.speed,2) as speed,h.location as location,h.status as statusid, s.statuscolor AS statusColor,h.latitude AS lat, h.longitude AS lon,IF(s.icon=1,h.direction,'') AS direction ,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime, h.unitname as unitname, u.ladleno as ladleno,h.reporttimeunix
				FROM history".$exp[1]." h
				LEFT JOIN ladle_master u ON u.ladleno=h.lno 
		        LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.ladleno IN ($unitnumber)  AND (s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				AND MINUTE(reporttime) % 3 = 0)
				ORDER BY uid,reporttimeunix ASC";
		}
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_ladlelife($db = array()){
		$group = $db['group'];
		$sql = "SELECT groupdesc, ladleno, cycle, '' dateandtime, `load`
				FROM mst_groups g
		        left join groupmembers gm on gm.groupnumber = g.groupnumber
		        left join ladle_master u on u.ladleno = gm.lno
		        where g.groupnumber=$group and g.is_delete is false and gm.is_delete is false
				order by u.id";
		$result = $this->db->query($sql);
		
		return $result->result();
		
	}
	
	function gettable_idletime($db = array()){
		$group = $db['group'];
		$unitqry = "";//otl
		if($group == "2"){
			$unitqry = " AND sc.cycle=1 ";//circulation
		}
		else if($group == "3"){
			$unitqry = " AND sc.cycle=0 ";//non-circulation
		}else 
		{
			$unitqry = " AND sc.cycle=1 ";  //circulation TLC
		}
		$circulation = $db['circulation'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		//$historyTable = $db['historyTable'];
		$sql = "SELECT g.groupdesc, sc.lno, unitname, DATE_FORMAT(FROM_UNIXTIME(sc.reporttimeunix+$timezone),'%d-%m-%Y %H:%i:%s') as starttime, sc.cycle,
				DATE_FORMAT(FROM_UNIXTIME((sc.reporttimeunix+idletime)+$timezone),'%d-%m-%Y %H:%i:%s') as endtime, IF(yard='NA',idleloc,yard) AS yard, 
				FORMAT((idletime/60), 0) idletime	
			   FROM mst_groups g
		       left join groupmembers gm on gm.groupnumber = g.groupnumber
		       left join ladle_master u on u.ladleno = gm.lno
		       left join ladle_idlereport sc on sc.lno =u.ladleno AND sc.lno =gm.lno
		       LEFT JOIN units un ON un.unitnumber=sc.unitnumber
		       where g.groupnumber=$group and g.is_delete is false and gm.is_delete is false $unitqry
		       AND sc.reporttimeunix >= (UNIX_TIMESTAMP('$start_date')-$timezone) AND sc.reporttimeunix <= (UNIX_TIMESTAMP('$end_date')-$timezone)
		       ORDER BY sc.reporttimeunix";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_maintenance($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		
		//$historyTable = $db['historyTable'];
		$sql = "SELECT m.id, u.ladleno,m.ladleid, `sndTarewt`, `sndTaretime`, type, type_desc, `repairType`, `repairTypesub`, `repairComplete`, `maintainenceTime`, `heatingStarted`, `heatingStopped`, `underHeating`, `cycleCompleted`
			   FROM mst_groups g
		       left join groupmembers gm on gm.groupnumber = g.groupnumber
		       left join ladle_master u on u.ladleno = gm.lno
		       left join `maintenance_report` m on m.ladleid = u.id
				LEFT JOIN maintenance_menu menu ON m.repairType=menu.id
				LEFT JOIN maintenance_submenu sub ON m.repairTypesub=sub.id AND sub.type_id=menu.id
		       where g.groupnumber=$group and g.is_delete is false and gm.is_delete is false AND m.is_delete=0 
		       AND DATE_FORMAT(STR_TO_DATE(sndTaretime, '%d-%m-%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'
		       group by m.id
				order by m.id";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_ladlecondition($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		//$historyTable = $db['historyTable'];
		$sql = "SELECT g.groupdesc, count(lc.remarks) cnt,DATE_FORMAT(lc.non_cycling_date, '%d-%m-%Y') non_cycling_date, lc.remarks 
			   FROM mst_groups g
		       left join groupmembers gm on gm.groupnumber = g.groupnumber
		       left join ladle_master u on u.ladleno = gm.lno
		       left join ladle_cyclingHistory lc on lc.ladle_id = u.id
		       where g.groupnumber=$group and g.is_delete is false and gm.is_delete is false AND lc.remarks>0
		       AND lc.non_cycling_date between '$start_date' and '$end_date'
		       group by DATE(lc.non_cycling_date), lc.remarks
			   order by lc.non_cycling_date, lc.remarks";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	//Breakdown Report(Report Id:- 13)
	
	function gettable_breakdown($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
	
		$sql = "SELECT g.groupdesc AS groupname, l.ladleno AS ladleno, b.date AS date, b.shift AS shift, b.description AS description, b.duration AS duration
		FROM maintenance_breakdown AS b
		LEFT JOIN ladle_master l ON l.id = b.ladleid
		LEFT JOIN groupmembers gm ON gm.lno = l.ladleno
		LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
		WHERE g.groupnumber= '$group' AND  STR_TO_DATE(date, '%d-%m-%Y')>= '$start_date' AND
		STR_TO_DATE(date, '%d-%m-%Y') <= '$end_date'  AND b.is_delete=0
		GROUP BY b.date
		ORDER BY g.groupdesc, b.ladleid,b.date ";
	
		$q=$this->db->query($sql);
		return $q->result();
		 
	}
	
	//Logistic Issue Report(Report Id:- 31)
	
	function gettable_issue($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
		 
		$sql = "SELECT g.groupdesc AS groupname, d.loconumber AS loconumber, d.date AS date, d.shift AS shift, d.delaycause AS delaycause, d.duration AS duration
		FROM maintenance_delay d, mst_groups g
		WHERE g.groupnumber= '$group' AND  STR_TO_DATE(date, '%d-%m-%Y')>= '$start_date' AND
		STR_TO_DATE(date, '%d-%m-%Y') <= '$end_date' AND d.is_delete=0
		GROUP BY d.date
		ORDER BY g.groupdesc,d.loconumber,d.date" ;
	
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	//Torpedo Status Report(Report Id:- 12)
	
	function gettable_status($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
		 
		$sql = "SELECT g.groupdesc AS groupname, l.ladleno AS ladleno, s.capacity AS capacity, s.supplier AS supplier, s.guarantee AS guarantee, s.beats AS beats,s.status AS status, s.downdate AS downdate
		FROM maintenance_status AS s
		LEFT JOIN ladle_master l ON l.id = s.ladleid
		LEFT JOIN groupmembers gm ON gm.lno = l.ladleno
		LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
		WHERE g.groupnumber= '$group' AND  STR_TO_DATE(downdate, '%d-%m-%Y')>= '$start_date' AND
		STR_TO_DATE(downdate, '%d-%m-%Y') <= '$end_date'  AND s.is_delete=0
		GROUP BY s.downdate
		ORDER BY g.groupdesc, s.ladleid,s.downdate ";
	
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	
	
	//Dumping Details (Report ID:- 8)
	function gettable_dump($db = array()){
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
		 
		$sql = "SELECT d.id, l.ladleno, d.ladleid, d.scheduledate, d.executiondate, d.tarewt, d.dumptarewt, d.netwt, 	d.flakes, d.metal, d.remarks
		FROM maintenance_dump d
		LEFT JOIN ladle_master l ON l.id=d.ladleid
		LEFT JOIN groupmembers gm ON gm.lno = l.ladleno
		LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
		WHERE g.groupnumber= '$group' AND  STR_TO_DATE(scheduledate, '%d-%m-%Y')>= '$start_date' AND
		STR_TO_DATE(scheduledate, '%d-%m-%Y') <= '$end_date' AND d.is_delete=0
		ORDER BY g.groupdesc, d.ladleid,d.scheduledate";
		 
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	
	
	function gettable_noncycle($db = array()){
		$compny = $db['detail'][0]->companyid;
		$group = $db['group'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$qry = " in ($group)";
		 
		/*$sql = "SELECT l.ladleno, c2.ladle_id, DATE_FORMAT(c2.cycling_date, '%d-%m-%Y %H:%i:%s') as cycling_date, DATE_FORMAT( c1.non_cycling_date, '%d-%m-%Y %H:%i:%s')as non_cycling_date,SEC_TO_TIME(UNIX_TIMESTAMP(c2.cycling_date)-UNIX_TIMESTAMP(c1.non_cycling_date)) AS report, IFNULL(lr.remarks,'') AS remarks
		FROM ladle_cyclingHistory c1
		INNER JOIN ladle_cyclingHistory c2 ON c2.id = c1.id+1
		LEFT JOIN ladle_remarks lr ON lr.id=c1.remarks
		LEFT JOIN ladle_master l ON l.id=c1.ladle_id
		LEFT JOIN groupmembers gm ON gm.lno = l.ladleno
		LEFT JOIN groups g ON g.groupnumber=gm.groupnumber
		WHERE g.groupnumber= '$group'
		AND   c2.cycling_date <= '$end_date' AND
		c1.non_cycling_date  >= '$start_date'
		ORDER BY g.groupdesc, l.ladleno,c1.non_cycling_date";*/
		
		$sql = " SELECT lh.ladle_id, lm.ladleno,DATE_FORMAT(lh.cycling_date,'%d-%m-%Y %H:%i:%s') as cycling_date,
		         DATE_FORMAT(lh.non_cycling_date,'%d-%m-%Y %H:%i:%s') as non_cycling_date,IFNULL(lr.remarks,'') AS remarks,lh.completeCycle
		        FROM ladle_cyclingHistory lh
		        LEFT JOIN ladle_master lm ON lm.id=lh.ladle_id
		        LEFT JOIN ladle_remarks lr ON lr.id=lh.remarks
		        LEFT JOIN groupmembers gm ON gm.lno=lm.ladleno
		        LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
		        WHERE g.groupnumber= '$group'
		        AND ((non_cycling_date >= '$start_date' AND non_cycling_date<='$end_date')
		        OR (cycling_date >='$start_date' AND cycling_date <='$end_date'))
		        ORDER BY lh.ladle_id,lh.cycling_date " ;
		 
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	
	
	
	
	
	
}

?>
