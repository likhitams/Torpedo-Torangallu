<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tasks_db extends CI_Model{
	
	function getTasks($db = array()){
		$uid = $db['detail'][0]->userId;
		$sql = "Select id , task_name, location_name, latitude, longitude, description, task_date, statusdesc, altContact_no, contact_no, contact_name, created_date, report_date
				FROM (SELECT t.id , t.task_name, t.location_name, t.latitude, t.longitude, t.description, task_date, s.statusdesc, t.altContact_no, t.contact_no, t.contact_name, t.created_date, u.report_date 
				FROM schedule_tasks as t 
				LEFT JOIN schedule_tasksUsers as u on t.id=u.task_id 
				LEFT JOIN statuses as s on u.status_id=s.statusid 
				WHERE t.status=0 and u.user_id=$uid 
				ORDER BY  u.report_date desc) tasks
				GROUP BY id
				ORDER BY created_date asc ";
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function getStatus($db = array()){
		$uid = $db['detail'][0]->companyid;
		$sql = "SELECT s.statusid, s.statusdesc
				FROM statuses as s 
				LEFT JOIN company_status as c on s.statusid=c.status_id  
				WHERE c.company_id=$uid and c.status=0 
				ORDER BY statusdesc asc";
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function gettable_tasks($db = array()){
		$uid = $db['detail'][0]->companyid;
		$sql = "Select id, task_name, location_name, latitude, longitude, task_date, status, altContact_no,contact_no, contact_name, 
				task_status, createdBy, createdDate,modifiedBy,
				modifiedDate, userName, created_date
				FROM (SELECT t.id, t.task_name, t.location_name, t.latitude, t.longitude, DATE_FORMAT(task_date,'%d-%m-%Y %H:%i:%s') task_date, s.statusdesc status, t.altContact_no, t.contact_no, t.contact_name, 
				t.status task_status, t.created_by as createdBy, DATE_FORMAT(t.created_date,'%d-%m-%Y %H:%i:%s') AS createdDate,IF(t.modified_by='','Not yet modified',t.modified_by) AS modifiedBy,
				IF(t.modified_date='0000-00-00 00:00:00','Not yet modified',DATE_FORMAT(t.modified_date,'%d-%m-%Y %H:%i:%s')) AS modifiedDate, usr.user_id as userName,
				t.created_date 
				FROM schedule_tasks as t 
				LEFT JOIN schedule_tasksUsers as u on t.id=u.task_id 
				LEFT JOIN statuses as s on u.status_id=s.statusid 
				LEFT JOIN users usr on usr.id=u.user_id 				
				WHERE usr.company_id=$uid 
				ORDER BY  u.report_date desc) tasks
				GROUP BY id
				ORDER BY created_date asc";
		
		
		/*SELECT t.id, t.task_name, t.location_name, t.latitude, t.longitude, DATE_FORMAT(task_date,'%d-%m-%Y %H:%i:%s') task_date, s.statusdesc status, t.altContact_no, t.contact_no, t.contact_name, 
				t.status task_status, t.created_by as createdBy, DATE_FORMAT(t.created_date,'%d-%m-%Y %H:%i:%s') AS createdDate,IF(t.modified_by='','Not yet modified',t.modified_by) AS modifiedBy,
				IF(t.modified_date='0000-00-00 00:00:00','Not yet modified',DATE_FORMAT(t.modified_date,'%d-%m-%Y %H:%i:%s')) AS modifiedDate, usr.user_id as userName 
				FROM schedule_tasks as t 
				LEFT JOIN schedule_tasksUsers as u on t.id=u.task_id 
				LEFT JOIN statuses as s on u.status_id=s.statusid 
				LEFT JOIN users usr on usr.id=u.user_id 				
				WHERE usr.company_id=$uid 
				GROUP BY t.id, u.user_id
				ORDER BY t.created_date desc, u.report_date desc";*/
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function getUsers($db = array()){
		$uid = $db['detail'][0]->companyid;
		$sql = "SELECT U.id AS id,
				U.user_id AS username
				FROM users U 
				LEFT JOIN companies c ON U.company_id=c.companyid
				WHERE U.role='u' and U.company_id = $uid AND U.is_delete=FALSE AND c.is_delete=false 
				ORDER BY U.user_id asc ";
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function gettable_fleetlist($db=array(), $limit = "", $cond = ""){
		$timezone= $qry1 = $qry2 = $qry3 = $qry4 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		
		if($role == "u"){
            $qry1=" ,IF(gm.groupnumber IS NULL,0,gm.groupnumber) AS groupnumber ";
            $qry3=" AND ur.user_id = $uid  ";
            $qry4 = " AND ui.indent LIKE  $uid ";
        }
        else if($role == "a"){
           	$qry1=" ,IF(gm.groupnumber IS NULL,0,gm.groupnumber) AS groupnumber ";
           	$qry3=" AND ur.user_id=$uid AND g.user_id = $uid ";
           	$qry4 = " AND ur.user_id=$uid ";
        }
        else if($role == "c"){
            $qry1=" ,IF(gm.groupnumber IS NULL,0,gm.groupnumber) AS groupnumber ";
            $qry3=" AND u.companyid = $compny AND g.user_id = $uid  ";
            $qry4 = " AND u.companyid = $compny ";
        }
       // $times = "TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())";
       
       $times = "TIMEDIFF(reporttime, SYSDATE())";
      
       $no_movement = "CONCAT(FLOOR(HOUR($times) / 24), 'd ',MOD(HOUR($times), 24), 'h ',MINUTE($times), 'm ', SECOND($times), 's')";
        if($role != "t"){
        	$qry2 = " LEFT OUTER JOIN groupmembers gm ON gm.unitnumber=un.unitnumber AND gm.is_delete=FALSE
 				LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber AND g.is_delete=FALSE ";
	       
        }
        
        
		
		$sql1 = "SELECT DISTINCT(un.unitnumber) AS unitnumber, 
				un.unitname AS unitname,
				g.groupdesc as groupname,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(un.lastreporttime)+$timezone),'%y-%m-%d %H:%i:%s') AS lastreporttime,
				DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%y-%m-%d %H:%i:%s') AS reporttime,
				DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%d-%m-%y %H:%i:%s') AS reporttime1,
				DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%m-%d-%Y %H:%i:%s') AS trackreporttime,
				un.owner AS owner,
				un.registration AS registration,
				s.statusdesc AS status,s.statusid,
				IF(un.altitudewidth=0,'N/A',un.altitude) AS altitude,
				if(un.fuelwidth=0,'N/A',IFNULL((un.analog1val*un.analog1val*un.analog1val*un.fx3)+(un.analog1val*un.analog1val*un.fx2)+(un.analog1val*un.fx)+(un.fc),'')) AS fuel,
				if(un.temperature=0,'N/A',IFNULL((un.temperature*un.temperature*un.temperature*un.tx3)+(un.temperature*un.temperature*un.tx2)+(un.temperature*un.tx)+(un.tc),'')) AS temperature,
				un.nextservice AS nextservice,
				un.ftc as fuelCapacity,
				IF(s.icon=1,un.direction,'') AS direction,
				s.statuscolor AS statusColor,
				un.status AS units_status,
				IF(un.tx3=1,IF(un.digi01val=0,'Off','On'),'') AS egnaign,
				IF(un.tx3=1,IF(un.digi02val=0,'Off','On'),'') AS egnbign,IFNULL(un.digi03val,0) AS pressure, IFNULL(un.digi04val,0) AS estatus, un.ispressure as ispres,
				un.isengine AS engine,
				un.speed AS speed,
				ROUND(un.currentodo,2) AS currentodo,
				un.latitude AS latitude,un.longitude AS longitude,
				un.loadstatus AS loadstatus, 
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(un.lastloadat)+$timezone),'%y-%m-%d %H:%i:%s') AS lastloadat,
			    ROUND(un.distance,2) AS distance,
				un.location AS locationname,
				ui.routenumber as routenumber,ui.indent as indent,ui.progress as progress,ui.agent as agents,ui.location as agentloc,
			    ui.np as npedate, ui.insurence as insedate,ui.fc as fcdate,ui.amc as amcdate,ui.isalert as alerts, 
				CASE s.statusdesc                 
	                 WHEN 'Ign Off' THEN  TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
	                 WHEN 'Slow/Idle' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
	                 WHEN 'Ign Off (Polled)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE()) 
	                 WHEN 'Ign Off (Health)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE()) 		                 
		
				END AS timehours,
				IF(un.fuelwidth=0,-1,ROUND((IFNULL(un.analog1persentage,0.00)),2))
				AS analog1persentage 
				$qry1
			 	FROM units un
			 	$qry2
					LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber
					LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid
					LEFT JOIN users usr ON usr.id=ur.user_id	
					LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id
					LEFT JOIN statuses s ON s.statusid=un.status 
					LEFT JOIN unit_info ui ON ui.unitnumber = un.unitnumber
					 WHERE s.languageid = '2' AND  g.groupdesc!='All' $cond 
					$qry3
				    GROUP BY u.routeid,un.unitnumber 
					";
		$sql3 = "SELECT DISTINCT(un.unitnumber)  AS unitnumber 
			 	FROM units un
			 	$qry2
					LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber
					LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid
					LEFT JOIN users usr ON usr.id=ur.user_id	
					LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id
					LEFT JOIN statuses s ON s.statusid=un.status 
					LEFT JOIN unit_info ui ON ui.unitnumber = un.unitnumber
					 WHERE s.languageid = '2' AND  g.groupdesc!='All' $cond 
					$qry3
				    GROUP BY u.routeid,un.unitnumber 
					";
		$result = $this->db->query($sql3);
		
			$deptnum = array();
			foreach ($result->result() as $row){
				$deptnum[] = $row->unitnumber;
			}
			$sql3 = "";
			if(count($deptnum)){
				$sql3 = " AND un.unitnumber NOT IN (".implode(",",$deptnum).") ";
			}
			$sql2 = "SELECT DISTINCT(un.unitnumber) AS unitnumber, 
					un.unitname AS unitname,
					'N/A' as groupname,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(un.lastreporttime)+$timezone),'%y-%m-%d %H:%i:%s') AS lastreporttime,
					DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%y-%m-%d %H:%i:%s') AS reporttime,
					DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%d-%m-%y %H:%i:%s') AS reporttime1,
					DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%m-%d-%Y %H:%i:%s') AS trackreporttime,
					un.owner AS owner,
					un.registration AS registration,
					s.statusdesc AS status,s.statusid,
					IF(un.altitudewidth=0,'N/A',un.altitude) AS altitude,
					if(un.fuelwidth=0,'N/A',IFNULL((un.analog1val*un.analog1val*un.analog1val*un.fx3)+(un.analog1val*un.analog1val*un.fx2)+(un.analog1val*un.fx)+(un.fc),'')) AS fuel,
				     ROUND(if(un.temperature=0,'N/A',IFNULL(((un.temperature/tc)/1000),'')),2) AS temperature,
				    un.nextservice AS nextservice,
					un.ftc as fuelCapacity,
					IF(un.status!=0,un.direction,'') AS direction,
					s.statuscolor AS statusColor,  
					un.status AS units_status,
					IF(un.tx3=1,IF(un.digi01val=0,'Off','On'),'') AS egnaign,
					IF(un.tx3=1,IF(un.digi02val=0,'Off','On'),'') AS egnbign,IFNULL(un.digi03val,0) AS pressure, IFNULL(un.digi04val,0) AS estatus, un.ispressure as ispres,
					un.isengine AS engine,
					un.speed AS speed,
					ROUND(un.currentodo,2) AS currentodo,
					un.latitude AS latitude,un.longitude AS longitude,
					un.loadstatus AS loadstatus,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(un.lastloadat)+$timezone),'%y-%m-%d %H:%i:%s') AS lastloadat,
					ROUND(un.distance,2) AS distance,
					un.location AS locationname,
					ui.routenumber as routenumber,ui.indent as indent,ui.progress as progress,ui.agent as agents,ui.location as agentloc,
				    ui.np as npedate, ui.insurence as insedate,ui.fc as fcdate,ui.amc as amcdate,ui.isalert as alerts,
					CASE s.statusdesc                 
		                 WHEN 'Ign Off' THEN  TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                 WHEN 'Slow/Idle' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                 WHEN 'Ign Off (Polled)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE()) 
		                 WHEN 'Ign Off (Health)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE()) 
			        
					END AS timehours,
					IF(un.fuelwidth=0,-1,ROUND((IFNULL(un.analog1persentage,0.00)),2))
					AS analog1persentage, 
					'N/A' AS groupnumber
					
			 	FROM units un
			 	
					LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber
					LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid
					LEFT JOIN users usr ON usr.id=ur.user_id	
					LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id
					LEFT JOIN statuses s ON s.statusid=un.status 
					LEFT JOIN unit_info ui ON ui.unitnumber = un.unitnumber
					 WHERE s.languageid = '2' $cond $sql3 $qry4
				";
			$sql = "(".$sql1.") UNION (".$sql2.") ORDER BY lastreporttime DESC $limit ";
		
		//CONCAT( FLOOR(TIME_FORMAT('172:04:11', '%H')/24), ' days ', (TIME_FORMAT('172:04:11', '%H') MOD 24),   ' hours ', TIME_FORMAT('172:04:11', '%i'), ' minutes ', TIME_FORMAT('172:04:11', '%s'), ' seconds')		
		
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	function getGroupFilter($db = array(), $limit=""){
		$timezone= $qry1 = $qry2 = $qry3 = $qry4 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$groupno = $db['groupno'];
		
		$sql = "SELECT distinct(un.unitnumber) AS unitnumber,G.groupnumber, gr.groupdesc as groupname,
				un.unitname AS unitname,
				DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+$timezone),'%y-%m-%d %H:%i:%s') AS reporttime,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(un.lastreporttime)+$timezone),'%y-%m-%d %H:%i:%s') AS lastreporttime,
				DATE_FORMAT(FROM_UNIXTIME(un.reporttimeunix+19800),'%m-%d-%Y %H:%i:%s') AS trackreporttime,
				s.statusdesc AS status,s.statusid,
				un.nextservice AS nextservice,
				s.statuscolor AS statusColor,
				IF(un.tx3=1,IF(un.digi01val=0,'Off','On'),'') AS egnaign,
				IF(un.tx3=1,IF(un.digi02val=0,'Off','On'),'') AS egnbign,IFNULL(un.digi03val,0) AS pressure, IFNULL(un.digi04val,0) AS estatus, un.ispressure as ispres,
				un.isengine AS engine,
				IF(s.icon=1,un.direction,'') AS direction,
				IF(un.altitudewidth=0,'N/A',un.altitude) AS altitude,
				if(un.fuelwidth=0,'N/A',IFNULL((un.analog1val*un.analog1val*un.analog1val*un.fx3)+(un.analog1val*un.analog1val*un.fx2)+(un.analog1val*un.fx)+(un.fc),'')) AS fuel,
				ROUND(if(un.temperature=0,'N/A',IFNULL(((un.temperature/tc)/1000),'')),2) AS temperature,
				un.direction AS direction,
				un.speed AS speed,
				ROUND(un.currentodo,2) AS currentodo,
				ROUND(un.distance,2) AS distance,
				un.latitude AS latitude,un.longitude AS longitude,
				un.location AS locationname,
				 ui.routenumber as routenumber,ui.indent as indent,ui.progress as progress,ui.agent as agents,ui.location as agentloc,
				CASE s.statusdesc
		                  WHEN 'Ign Off' THEN  TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                  WHEN 'Unreachable' THEN  TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                  WHEN 'Slow/Idle' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                  WHEN 'Ign Off (Polled)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE()) 
		                  WHEN 'Ign Off (Health)' THEN TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                 WHEN 'Unreachable' THEN  TIMESTAMPDIFF(SECOND,reporttime,SYSDATE())
		                 
				END AS timehours,
				IF(un.fuelwidth=0,-1,ROUND((IFNULL(un.analog1persentage,0.00)),2))
				AS analog1persentage
		
				FROM groupmembers G
				LEFT JOIN mst_groups gr ON gr.groupnumber=G.groupnumber AND gr.is_delete=FALSE
				LEFT JOIN units un ON G.unitnumber=un.unitnumber
				LEFT JOIN statuses s ON s.statusid=un.status
				  LEFT JOIN unit_info ui ON ui.unitnumber = un.unitnumber
				WHERE s.languageid = '2' 
				AND G.groupnumber='$groupno' and  G.is_delete=false
				GROUP BY un.unitnumber
				ORDER BY un.reporttime DESC $limit";
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	
	function gettable_replay($db=array()){
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$language = $db['detail'][0]->language;
		$start_date = $db['start_date'];
		$to_date = $db['to_date'];
		$unitno = $db['unitno'];
	
		$tablename = $condition = "";
		
		$tablename = $this->home_db->getHistoryTable($start_date, $to_date, $unitno);
		
		$sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(h.reporttime)+$timezone),'%d-%m %H:%i:%s') AS reportTime, 
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(h.reporttime)+$timezone),'%Y-%m-%d %H:%i:%s') AS reportTime1, 
				h.speed AS speed, h.latitude AS latitude, h.longitude AS longitude, IFNULL(u.ftc,0) as total , IFNULL(u.fp,0) as subval,
				if(fuelwidth=0,'N/A',IFNULL((h.analog1val*h.analog1val*h.analog1val*u.fx3)+(h.analog1val*h.analog1val*u.fx2)+(h.analog1val*u.fx)+(u.fc),'')) AS fuel, ROUND(h.distance,2) AS distance,
				 u.ftc as fuelCapacity, IF(s.icon=1,h.direction,'') AS direction, h.location AS location, h.status as statusid, 
				 h.reporttimeunix as reporttimeunix, s.statusdesc AS STATUS, s.statusdesc AS replayStatus, s.statuscolor AS statusColor,
				  IFNULL(g.geofencename,'') as geoName, if(ge.entry_status is null,'',sg.statusdesc) as geoStatus FROM ($tablename) h 
				  LEFT JOIN units u ON u.unitnumber=h.unitnumber LEFT JOIN geofence_event ge ON ge.timeunix= h.reporttimeunix AND ge.unitnumber = h.unitnumber 
				  LEFT JOIN geofences g ON g.geofencenumber= ge.geofencenumber LEFT JOIN statuses s ON s.statusid=h.status 
				  LEFT JOIN statuses sg ON sg.statusid=ge.entry_status WHERE h.unitnumber='$unitno' AND h.status!= 16 and (s.languageid=$language) 
				  AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_date')-$timezone) AND (UNIX_TIMESTAMP('$to_date')-$timezone) 
				ORDER BY h.reporttimeunix,h.distance,h.status,s.statusdesc,ge.entry_status ASC ";
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	function gettable_GeofenceAll($db=array()){
		$qry1 = $limit = '';
		$type = $db['type'];
		$limit = $db['limit'];
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" AND (g.user_id=$uid OR g.user_id=$compny OR g.user_id IN (SELECT admin_id FROM admin_routing WHERE user_id=$uid)) ";
        }
        else if($role == "a"){
           	$qry1=" AND (g.user_id=$uid OR g.user_id=$compny OR g.user_id IN (SELECT user_id FROM admin_routing WHERE user_id=$uid) or g.user_id IN (SELECT admin_id FROM admin_routing WHERE user_id=$uid)) ";
        }
        else if($role == "c"){
            $qry1=" AND g.companyid=$compny ";
        }
        if($limit){
        	$limit=" ORDER BY geofenceNumber DESC LIMIT 1 ";
        }
        else{
        	$limit=" ORDER BY 4 ";
        }
        if($type != ""){
	        switch($type){
	        	case "1": $sql = "SELECT g.geofencenumber as geofenceNumber,g.geotype as geofenceType,g.geostatus as zone,g.geofencename AS geofenceName,gc.centerLat AS latitude,gc.centerLon AS longitude,gc.radius AS radius,g.maxzonespeed AS maxSpeed
									FROM geofences g
									LEFT JOIN geofencecircle gc ON gc.geofencenumber=g.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=1
									 ".$qry1.$limit;
	        			  break;
	        	case "2": $sql = "SELECT g.geofencenumber as geofenceNumber,g.geotype as geofenceType,g.geostatus as zone,g.geofencename AS geofenceName,g.maxzonespeed AS maxSpeed,
									gr.lat1 AS latitude1,gr.lat2 AS latitude2,gr.lon1 AS longitude1,gr.lon2 AS longitude2
									FROM geofences g
									LEFT JOIN geofencerect gr ON gr.geofencenumber=g.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=2
									 ".$qry1.$limit;
	        			  break;
	        	case "3": $sql = "SELECT gf.geofencenumber AS geofenceNumber,g.geotype AS geofenceType,g.geostatus AS zone,g.geofencename AS geofenceName,
									g.maxzonespeed AS maxSpeed,gf.latlon AS latlon FROM geofencepoly gf 
									LEFT JOIN geofences g ON g.geofencenumber=gf.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=3  ".$qry1." AND g.is_delete is false  and gf.is_delete is false ";
	        			  break;
	        }
	        
	        $result = $this->db->query($sql);
			
			return $result->result();
        }
        else{
        	return array();
        }
	}
	
	function getAllGeofence($db=array()){
		$qry1 = $limit = '';
		
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" AND (g.user_id=$uid OR g.user_id=$compny OR g.user_id IN (SELECT admin_id FROM admin_routing WHERE user_id=$uid)) ";
        }
        else if($role == "a"){
           	$qry1=" AND (g.user_id=$uid OR g.user_id=$compny OR g.user_id IN (SELECT user_id FROM admin_routing WHERE user_id=$uid) or g.user_id IN (SELECT admin_id FROM admin_routing WHERE user_id=$uid)) ";
        }
        else if($role == "c"){
            $qry1=" AND g.companyid=$compny ";
        }
		$sql = "(SELECT g.geofencenumber as geofenceNumber,g.geotype as geofenceType,g.geofencename AS geofenceName,gc.centerLat AS latitude,gc.centerLon AS longitude,0 AS latitude1,0 AS longitude1
									FROM geofences g
									LEFT JOIN geofencecircle gc ON gc.geofencenumber=g.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=1
									 $qry1)
				UNION
				(SELECT g.geofencenumber as geofenceNumber,g.geotype as geofenceType,g.geofencename AS geofenceName,gr.lat1 AS latitude,gr.lon1 AS longitude,gr.lat2 AS latitude1,gr.lon2 AS longitude1
									FROM geofences g
									LEFT JOIN geofencerect gr ON gr.geofencenumber=g.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=2
								  $qry1)
				UNION
				(SELECT gf.geofencenumber AS geofenceNumber,g.geotype AS geofenceType,g.geofencename AS geofenceName,0 AS latitude,0 AS longitude,0 AS latitude1,0 AS longitude1
									FROM geofencepoly gf 
									LEFT JOIN geofences g ON g.geofencenumber=gf.geofencenumber
									LEFT JOIN users usr ON usr.id=g.user_id
									WHERE g.geotype=3  $qry1 AND g.is_delete is false  and gf.is_delete is false ) order by geofenceName";
		$result = $this->db->query($sql);
			
		return $result->result();
	}
	
	function getGroups($db = array()){
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$sql = "SELECT G.groupdesc as groupname,G.groupnumber as id FROM mst_groups G WHERE user_id=$uid ORDER BY G.groupdesc ASC";
		$result = $this->db->query($sql);
			
		return $result->result();
	}
	
	function getConfigGeoUnits($db = array()){
		$qry1 = "";
		$geono = $db['geono'];
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" and ur.user_id=$uid ";
        }
        else if($role == "a"){
           	$qry1=" and ur.user_id=$uid ";
        }
        else if($role == "c"){
            $qry1=" and unr.companyid=$compny ";
        }
		$sql = "SELECT DISTINCT(unitnumber),groupnumber FROM 
			(SELECT DISTINCT(gm.unitnumber) AS unitnumber,IFNULL(g.groupnumber,'0') AS groupnumber
			FROM units u 
			LEFT OUTER JOIN groupmembers g ON u.unitnumber=g.unitnumber AND g.is_delete=FALSE 
			LEFT JOIN mst_groups ge ON ge.groupnumber=g.groupnumber  AND ge.is_delete=FALSE
			LEFT JOIN geofencemembers gm ON gm.unitnumber=u.unitnumber
			LEFT JOIN geofences geo ON geo.geofencenumber=gm.geofencenumber
			WHERE 
			ge.user_id=$uid
			AND gm.geofencenumber=$geono  
			GROUP BY 1 
			UNION
			SELECT DISTINCT(gm.unitnumber) AS unitnumber,0 AS groupnumber
			FROM units u 
			LEFT JOIN unitrouting unr ON unr.unitnumber=u.unitnumber
			LEFT JOIN user_routing ur  ON ur.unitrouting_id=unr.routeid
			LEFT JOIN geofencemembers gm ON gm.unitnumber=u.unitnumber
			LEFT JOIN geofences geo ON geo.geofencenumber=gm.geofencenumber
			WHERE gm.geofencenumber=$geono $qry1
			GROUP BY 1) AS tab
			GROUP BY 1";
		$result = $this->db->query($sql);
			
		return $result->result();		
	}
	
	function getUnitsGroup($db = array()){
		$groups = $db['groups'];
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		$sql = "SELECT distinct(u.unitname) AS unitname, u.unitnumber AS id, ur.routeid as routeId, g.groupdesc as groupname,g.groupnumber as groupnumber 
				FROM groupmembers gm
				LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
				LEFT JOIN units u ON gm.unitnumber=u.unitnumber 
				LEFT JOIN unitrouting ur on ur.unitnumber=u.unitnumber
				WHERE g.groupnumber IN ($groups) and ur.companyid=$compny and gm.is_delete=false and g.is_delete=false and g.user_id=$uid
				group by ur.routeid";
		$result = $this->db->query($sql);
			
		return $result->result();
	}
	
	function getUnitNotGroup($db = array()){
		$qry1 = $from = "";
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
			$from = " user_routing ur LEFT JOIN unitrouting un ON ur.unitrouting_id=un.routeid ";
            $qry1=" ur.user_id = $uid ";
        }
        else if($role == "a"){
        	$from = " user_routing ur LEFT JOIN unitrouting un ON ur.unitrouting_id=un.routeid ";
           	$qry1=" (ur.user_id=$uid) ";
        }
        else if($role == "c"){
        	$from = " unitrouting un LEFT JOIN user_routing ur  ON ur.unitrouting_id=un.routeid ";
            $qry1=" un.companyId = $compny ";
        }
		$sql = "SELECT distinct(un.unitnumber) AS id, un.routeid as routeId, u.unitname AS unitname, 'Other Units' as groupname,0 as groupnumber 
		FROM $from 
				left join units u on u.unitnumber=un.unitnumber
				LEFT JOIN admin_routing ar ON ar.admin_id = ur.user_id OR ar.user_id = ur.user_id
				WHERE $qry1 AND un.unitnumber NOT IN(SELECT gm.unitnumber FROM groupmembers gm 
					LEFT JOIN mst_groups g ON g.groupnumber=gm.groupnumber
					left join user_routing ur on ur.user_id=g.user_id  
					LEFT JOIN unitrouting un ON un.unitnumber=gm.unitnumber
					LEFT JOIN admin_routing ar ON ar.admin_id = ur.user_id OR ar.user_id = ur.user_id
					WHERE gm.is_delete=false and g.is_delete=false and g.user_id= $uid )
					GROUP BY un.unitnumber
					order by un.unitnumber";
		//echo $sql;
		$result = $this->db->query($sql);
			
		return $result->result();
	}
	
	function gettable_LocationAll($db=array()){
		
		$limit = $db['limit'];
		$compny = $db['detail'][0]->companyid;
		
        if($limit){
        	$limit=" ORDER BY locationid  DESC LIMIT 1 ";
        }
        else{
        	$limit=" ORDER BY 2 ";
        }
        $sql = "SELECT locationid AS locationNumber,locationname AS locationName,latitude AS latitude,longitude AS longitude,description AS description,radiusin AS radius,radiusrefer AS radiusRefer 
				FROM location WHERE companyid=$compny
				$limit";
	     
	    $result = $this->db->query($sql);
		return $result->result();
       
	}
	
	function gettable_Columnfleetlist($db=array()){
		
		$reporttime = $db['reporttime'];
		$trackmin = $db['trackmin'];
		$unitnum = $db['unitnum'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;		
		$reporttime = date('Y-m-d H:i:s', strtotime($reporttime));
		$day = date('w', strtotime($reporttime));
		
		switch($day){
			case 1: $historytable = "day_mon";break;
			case 2: $historytable = "day_tue";break;
			case 3: $historytable = "day_wed";break;
			case 4: $historytable = "day_thu";break;
			case 5: $historytable = "day_fri";break;
			case 6: $historytable = "day_sat";break;
			case 7: $historytable = "day_sun";break;
			default: $historytable = "day_sun";break;
		}
		
		
		$sql = "SELECT u.unitnumber AS unitnumber, DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+".$timezone."),'".$dateformat."') as reporttime,s.statusdesc as status,
				h.status as statusid, h.speed AS speed,h.latitude AS latitude, h.reporttimeunix as reporttimeunix,
				IF(s.icon=1,h.direction,'') AS direction,s.statuscolor AS statusColor,  
				 h.longitude AS longitude,h.location AS locationname,
				 u.unitname as unitname
				FROM $historytable as h
				LEFT JOIN units u ON u.unitNumber=h.unitNumber 
				LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.unitNumber=".$unitnum." AND  (  s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('".$reporttime."')-".$timezone."-(".$trackmin."*60)) AND  (UNIX_TIMESTAMP('".$reporttime."')-".$timezone.")  
				ORDER BY h.reporttimeunix ,h.status ASC";
		$result = $this->db->query($sql);
		//echo $sql;
		return $result->result();
	}
	
	function get_unitlist($q, $db=array()){
	$timezone= $qry1 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" and ur.user_id = $uid and un.unitnumber not in (select distinct unit_id from workflow_unit where is_delete is false ) ";
        }
        else if($role == "a"){
           	$qry1=" and (ur.user_id=$uid or
					ar.admin_id = $uid) and un.unitnumber not in (select distinct unit_id from workflow_unit where is_delete is false ) ";
           
        }
        else if($role == "c"){
            $qry1=" and u.companyid = $compny and un.unitnumber not in (select distinct unit_id from workflow_unit where is_delete is false )  ";
        }
		$sql = "SELECT un.unitnumber AS unitnumber, 
				un.unitname AS unitname
				FROM units un       
				LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber   
				LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid   
				LEFT JOIN users usr ON usr.id=ur.user_id         
				LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id 
				WHERE un.unitname LIKE '%%%s%%' $qry1 				
				GROUP BY u.routeid,un.unitnumber
				ORDER BY un.unitname ASC";
	
		$sql = sprintf("$sql LIMIT 20", $q);
		$q=$this->db->query($sql);		
		if($q->num_rows()>0)
		{
			$selectbox='';$loc_arr=array();
			foreach($q->result() as $row)
			{
				//$loc_arr[] = '{"name":'.'"'.str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->unitname))))))).'"'.',
								//"id":"'.$row->unitnumber.'"	}';
				$loc_arr[] = array(
								"name"=>str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->unitname))))))),
								"id"=>$row->unitnumber
								);
			}
			//$selectbox = implode(",", $loc_arr);
			//return '['.$selectbox.']';
			return $loc_arr;
		}
	
	}
	
	function getFilter($columnname, $colors){
		
		switch($columnname){            
				case "unitname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'},  
				cellClassRules: {'alert-disable': function (params) {return applyUnitClass(params,1);} }";
						break;
				case "reporttime": $filter = ", suppressFilter:true, cellRenderer: formatDate";
						break;
				case "lastreporttime": $filter = ", suppressFilter:true, cellRenderer: formatDate";
						break;
				
				/*case "status":cellRenderer: renderUnitName,
							$cases = "default: returnVal = '';break;";
							foreach ($colors as $key=>$val){
								$cases .= "case '".$key."': returnVal='".$val."';break;";
							}
					$filter = ", filter: 'text', filterParams: { apply: true, newRowsAction: 'keep'}, cellClass: function(params) {var returnVal='';switch(params.value){".$cases."} return returnVal;}";
						break;*/
				case "status":
							
					$filter = ", filter: 'text', filterParams: { apply: true, newRowsAction: 'keep'}, 
					cellClassRules: {'user-moving': function (params) {return applyClass(params,[2]);}, 'user-ignoff': function (params) {return applyClass(params,[1]);}, 
									'user-sudden': function (params) {return applyClass(params,[3,18,19,20]);}, 'user-illegal': function (params) {return applyClass(params,[6]);}, 
									'user-ignon': function (params) {return applyClass(params,[12]);}, 'user-overspeed': function (params) {return applyClass(params,[13]);}, 
									'user-slowidle': function (params) {return applyClass(params,[15,17]);}, 'user-unreachable': function (params) {return applyClass(params,[21]);} }";
						break;
				
				case "speed": $filter = ", filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}, cellClass: 'textAlign', comparator: compareNum";
						break;					
				case "currentodo": $filter = ", comparator: compareNum, filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'} , cellRenderer: checkOdo, cellClass: 'textAlign'";
						break;
				case "fuel": $filter = ", comparator: compareNum, filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}, cellClass: 'textAlign'";
						break;
				case "groupname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				
				case "locationname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;					
				case "temperature": $filter = ", filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}, cellClass: 'textAlign'";
						break;
				case "distance": $filter = ",  filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}, cellClass: 'textAlign'";
						break;
				case "timehours": $filter = ",filter:'number', suppressFilter:true, cellRenderer: function (params) {return secondsToString(params);}, cellClass: 'textAlign'";
						break;
				default: $filter = "";break;
			}
			return $filter;
	}
	
	function getFilterInfo($columnname, $colors){
		
		switch($columnname){            
				case "unitname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'},  
				cellClassRules: {'alert-disable': function (params) {return applyUnitClass(params,1);} }";
						break;
				
							
				case "currentodo": $filter = ", filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'} , cellRenderer: checkOdo, cellClass: 'textAlign'";
						break;
				
				
				case "drivername": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "npedate": $filter = ", suppressFilter:true";
						break;
				case "insedate": $filter = ", suppressFilter:true";
						break;
				case "fcdate": $filter = ", suppressFilter:true";
						break;
				case "amcdate": $filter = ", suppressFilter:true";
						break;
				case "tax": $filter = ", filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
						
				case "vehiclemake": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "vehiclemodel": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "showname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "vehicletype": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "yearofmanufacture": $filter = ", suppressFilter:true";
						break;
				case "dateofpurchase": $filter = ", suppressFilter:true";
						break;
				case "onroadprice": $filter = ", filter: 'number', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				case "insurencecompanyname": $filter = ", filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}";
						break;
				default: $filter = "";break;
			}
			return $filter;
	}
	
	function getColorClass($id){
		$class = "";
		switch(intval($id)){
			case 1: $class = "user-ignoff"; break;
			case 2: $class = "user-moving"; break;
			case 3: $class = "user-sudden"; break;
			case 6: $class = "user-illegal"; break;
			case 12: $class = "user-ignon"; break;
			case 13: $class = "user-overspeed"; break;
			case 15: $class = "user-slowidle"; break;
			case 17: $class = "user-slowidle"; break;
			case 18: $class = "user-sudden"; break;
			case 19: $class = "user-sudden"; break;
			case 20: $class = "user-sudden"; break;
			case 21: $class = "user-unreachable"; break;
			default: $class = ""; break;
		}
		return $class;
	}
	
	
	function getColor($id){
		$class = "";
		switch(intval($id)){
			case 1: $class = "#C5D9F1"; break;
			case 2: $class = "#66FF66"; break;
			case 3: $class = "#FF9999"; break;
			case 6: $class = "#D8D8D8"; break;
			case 12: $class = "#DBE5F1"; break;
			case 13: $class = "#CCC0DA"; break;
			case 15: $class = "#FDE9D9"; break;
			case 17: $class = "#FDE9D9"; break;
			case 18: $class = "#FF9999"; break;
			case 19: $class = "#FF9999"; break;
			case 20: $class = "#FF9999"; break;
			case 21: $class = "#B2B2B2"; break;
			default: $class = ""; break;
		}
		return $class;
	}
	
	function getColumnFields(){
		$arr = array(
					"units.unitname"=>"unitname",
					"units.reporttime"=>"reporttime",
					"units.lastreporttime"=>"lastreporttime",
					"units.fuel"=>"fuel",
					"units.status"=>"status",
					"units.odo"=>"currentodo",
					"units.speed"=>"speed",
					"statuses.statusdesc"=>"timehours",
					"units.location"=>"locationname",
					"unit_info.np"=>"npedate",
					"unit_info.insurence"=>"insedate",
					"unit_info.fc"=>"fcdate",
					"unit_info.amc"=>"amcdate",		
					"units.Departmentname"=>"groupname",
					"units.digi01val"=>"egnaign",
					"units.digi02val"=>"egnbign",
					"units.temperature"=>"temperature",
					"unit_info.dop"=>"dateofpurchase",
					"unit_info.indent"=>"indent",
					"unit_info.insuid"=>"vinsuranceid",
					"unit_info.showid"=>"vshowroomid",
					"unit_info.tax"=>"tax",
					"unit_info.vmakeid"=>"vmakeid",
					"unit_info.vmodelid"=>"vmodelid",
					"unit_info.vtype"=>"vehicletype",
					"unit_info.yom"=>"yearofmanufacture",
					"units.altitude"=>"altitude",
					"driver_profile.drivername"=>"drivername",
					"unit_info.orp"=>"onroadprice"
				);
				
		return $arr;
	}
	
	function getUnitDetails($unitid){
		$sql = "SELECT U.unitnumber AS unitnumber,
				U.registration as registration,
				U.unitname AS unitname,
				U.owner AS owner,
				U.drivername AS drivername,
				U.drivernumber AS drivernumber,
				U.contactperson AS contactperson,
				U.contactnumber AS contactnumber,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(U.lastStartreport)+19800),'%d-%m-%Y %H:%i:%s') as laststart,
				U.ftc as tankcap,
				IFNULL(U.nextservice,0) AS nextservice,
				ROUND(IFNULL(U.currentodo,0),2) AS currentodo,
				U.unitserial AS unitserial,
				U.gsmnumber AS gsmnumber,
		        ui.progress as progress,ui.routenumber as routenumber,
		        ui.remarks as remarks,
		        ui.Customer as contractor,
		        ui.indentid as vehicletype
				FROM units U
				LEFT JOIN unit_info ui ON ui.unitnumber=U.unitnumber
				WHERE U.unitnumber='$unitid' ";
		$result = $this->db->query($sql);
		
		return json_encode($result->result());
	}
	
	function gettable_fleetinfolist($db=array()){
		$timezone= $qry1 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1 = " AND ur.user_id = $uid ";
        }
        else if($role == "a"){
           	$qry1 = " AND ur.user_id=$uid ";
        }
        else if($role == "c"){
            $qry1 = " AND u.companyid = $compny ";
        }
		
		$sql = "SELECT DISTINCT(un.unitnumber) AS id,
				un.unitname AS unitname,
				ROUND(un.currentodo,2) AS currentodo,
		        IFNULL(CONCAT(dp.first_name,dp.last_name),'Driver not scheduled') AS drivername,
		      	DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.np)+$timezone),'%d-%m-%Y') as npedate,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.insurence)+$timezone),'%d-%m-%Y') as insedate,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.fc)+$timezone),'%d-%m-%Y') as fcdate,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.amc)+$timezone),'%d-%m-%Y') as amcdate,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.year_mfg)+$timezone),'%d-%m-%Y') as yearofmanufacture,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ui.year_pur)+$timezone),'%d-%m-%Y') as dateofpurchase,
		        ui.onroad_price as onroadprice,vt.type as vehicletype,ui.vmakeid, vma.make as vehiclemake,ui.vmodelid, vmod.model as vehiclemodel,ui.tax as tax,
		        ui.indent,ui.vinsuranceid,ui.vshowroomid,vshow.showroom as showname,vins.name as insurencecompanyname
		        FROM units un
		 	    LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber
				LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid
				LEFT JOIN users usr ON usr.id=ur.user_id
				LEFT JOIN unit_info ui ON ui.unitnumber=un.unitnumber
				LEFT JOIN vehicle_type vt ON ui.vtypeid = vt.id
		   	    LEFT JOIN vehicle_make vma ON ui.vmakeid = vma.id
		        LEFT JOIN vehicle_model vmod ON ui.vmodelid = vmod.id
		        LEFT JOIN vehicle_showroom vshow ON ui.vshowroomid = vshow.id
		        LEFT JOIN vehicle_insurance vins ON ui.vinsuranceid = vins.id
			    LEFT JOIN driver_profile dp ON dp.user_id = un.unitnumber
		     	LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id
				LEFT JOIN statuses s ON s.statusid=un.status
				 WHERE  s.languageid = '2'
				 	$qry1
				GROUP BY u.routeid,un.unitnumber
				ORDER BY un.unitname ASC";
		
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	public function setVehiclemake($db = array()){
		$res = $this->master_db->getRecords("vehicle_make", array("make"=>$db["vehiclemake"]), "id as vmakeid");
		if(count($res) == 0){
			$id = $this->master_db->insertRecord("vehicle_make", array("make"=>$db["vehiclemake"])); 	
		}
		else{
			$id = $res[0]->vmakeid;
		}
		
		$this->master_db->updateRecord('unit_info',array("vmakeid"=>$id),array("unitnumber"=>$db["unitnum"]));
	}
	
	public function setVehicletype($db = array()){
		$res = $this->master_db->getRecords("vehicle_type", array("type"=>$db["vehicletype"]), "id as vtypeid");
		if(count($res) == 0){
			$id = $this->master_db->insertRecord("vehicle_type", array("type"=>$db["vehicletype"])); 	
		}
		else{
			$id = $res[0]->vtypeid;
		}
		
		$this->master_db->updateRecord('unit_info',array("vtypeid"=>$id),array("unitnumber"=>$db["unitnum"]));
	}
	
	public function setShowroom($db = array()){
		$res = $this->master_db->getRecords("vehicle_showroom", array("showroom"=>$db["showroomname"]), "id as showid");
		if(count($res) == 0){
			$id = $this->master_db->insertRecord("vehicle_showroom", array("showroom"=>$db["showroomname"])); 	
		}
		else{
			$id = $res[0]->showid;
		}
		
		$this->master_db->updateRecord('unit_info',array("vshowroomid"=>$id),array("unitnumber"=>$db["unitnum"]));
	}
	
	public function setInsCompany($db = array()){
		$res = $this->master_db->getRecords("vehicle_insurance", array("name"=>$db["inscompanyname"]), "id as insuid");
		if(count($res) == 0){
			$id = $this->master_db->insertRecord("vehicle_insurance", array("name"=>$db["inscompanyname"])); 	
		}
		else{
			$id = $res[0]->insuid;
		}
		
		$this->master_db->updateRecord('unit_info',array("vinsuranceid"=>$id),array("unitnumber"=>$db["unitnum"]));
	}
	
	public function setVehiclemodel($db = array()){
		$res = $this->master_db->getRecords("vehicle_model", array("model"=>$db["vehiclemodel"]), "id as vmodelid");
		if(count($res) == 0){
			$id = $this->master_db->insertRecord("vehicle_model", array("model"=>$db["vehiclemodel"])); 	
		}
		else{
			$id = $res[0]->vmodelid;
		}
		
		$this->master_db->updateRecord('unit_info',array("vmodelid"=>$id),array("unitnumber"=>$db["unitnum"]));
	}
	
	public function getUnits($db = array()){
		$qry1 = $from = "";
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" WHERE ur.user_id = $uid ";
        }
        else if($role == "a"){
        	
           	$qry1=" WHERE (ur.user_id=$uid or ar.admin_id = $uid) ";
        }
        else if($role == "c"){
        	$qry1=" WHERE u.companyid = $compny ";
        }
		$sql = "SELECT un.unitnumber AS id,
		        un.unitname AS unitname
		        FROM units un      
		        LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber  
		        LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid  
		        LEFT JOIN users usr ON usr.id=ur.user_id        
		        LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id
		      	$qry1 		       
		        GROUP BY u.routeid,un.unitnumber
		        ORDER BY un.unitname ASC";
		$result = $this->db->query($sql);
		
		return $result->result();
	}
	
	
	

}

?>