<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_db extends CI_Model{
	
	
	function get_grouplist($q, $db = array()){
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		
		$sql = "SELECT G.groupdesc as groupname,G.groupnumber as groupnumber FROM mst_groups G WHERE user_id=$uid and companyid=$compny and G.groupdesc LIKE '%%%s%%' ORDER BY G.groupdesc ASC";
		$sql = sprintf("$sql LIMIT 20", $q);
		$result = $this->db->query($sql);
		$q=$this->db->query($sql);		
		if($q->num_rows()>0)
		{
			$selectbox='';$loc_arr=array();
			foreach($q->result() as $row)
			{
				$loc_arr[] = array(
								"name"=>str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->groupname))))))),
								"id"=>$row->groupnumber
								);
			}
			
			return $loc_arr;
		}	
	}
	
	
	function get_unitlist($q, $db=array()){
		$timezone= $qry1 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		if($role == "u"){
            $qry1=" and ur.user_id = $uid ";
        }
        else if($role == "a"){
           	$qry1=" and (ur.user_id=$uid or ar.admin_id = $uid) ";           
        }
        else if($role == "c"){
            $qry1=" and u.companyid = $compny ";
        }
		$sql = "SELECT un.unitnumber AS unitnumber, 
				un.unitname AS unitname
				FROM units un       
				LEFT JOIN unitrouting u ON un.unitnumber=u.unitnumber   
				LEFT JOIN user_routing ur ON ur.unitrouting_id = u.routeid   
				LEFT JOIN users usr ON usr.id=ur.user_id         
				LEFT JOIN admin_routing ar ON ar.admin_id = usr.id OR ar.user_id = usr.id 
				WHERE un.unitname LIKE '%%%s%%' $qry1 GROUP BY u.routeid,un.unitnumber
				ORDER BY un.unitname ASC";
	
		$sql = sprintf("$sql LIMIT 20", $q);
		$q=$this->db->query($sql);		
		if($q->num_rows()>0)
		{
			$selectbox='';$loc_arr=array();
			foreach($q->result() as $row)
			{
				$loc_arr[] = array(
								"name"=>str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->unitname))))))),
								"id"=>$row->unitnumber
								);
			}
			
			return $loc_arr;
		}	
	}
	
	
	function gettable_distanceRun($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$sql = "SELECT u.registration AS ladleno,ROUND(c.tripdistance,2) AS distance,  c.tripdate AS reportdate, SEC_TO_TIME(c.triptimesec-c.idletimesec) as mhrs FROM trip_summary AS c
		LEFT JOIN units u ON u.unitnumber=c.unitnumber WHERE u.registration='$unitnumber' and  c.tripdate >= '$start_date' AND c.tripdate <= '$end_date'
		ORDER BY c.tripdate";
		$q=$this->db->query($sql);
		return $q->result();
	}
	
	function get_ladlelist($q, $db=array()){
		$timezone= $qry1 = '';
		$timezone = $db['detail'][0]->timezone;
		$role = $db['detail'][0]->userRole;
		$uid = $db['detail'][0]->userId;
		$compny = $db['detail'][0]->companyid;
		
		$sql = "SELECT IFNULL(id,u.unitnumber)AS id, IFNULL(ladleno,u.registration ) AS ladleno FROM units u  
			  LEFT JOIN   ladle_master lm    ON lm.ladleno=u.registration 
				WHERE   u.companyid=$compny and u.registration!='' and ladleno LIKE '%%%s%%' 

				ORDER BY ladleno ASC";
	
		$sql = sprintf("$sql LIMIT 50", $q);
		$q=$this->db->query($sql);		
		if($q->num_rows()>0)
		{
			$selectbox='';$loc_arr=array();
			foreach($q->result() as $row)
			{
				$loc_arr[] = array(
								"name"=>str_replace(",","",(str_replace("'","`",str_replace("}","",str_replace("{","",str_replace("]","",str_replace("[","",$row->ladleno))))))),
								"id"=>$row->ladleno
								);
			}
			
			return $loc_arr;
		}	
	}
	
	function gettable_consolidate($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$unitnumberqry = " u.unitnumber = $unitnumber AND ";
		if($unitnumber == ""){
			$unitnumberqry = "";
		}
		$sql = "SELECT u.unitname AS unitname, DATE_FORMAT(FROM_UNIXTIME(c.ignontimeunix+19800),'%Y-%m-%d %H:%i:%s') AS ignon, if(u.fuelwidth=0,'N/A',u.fuelwidth) as fuelwidth,
             DATE_FORMAT(FROM_UNIXTIME(c.ignofftimeunix+19800),'%Y-%m-%d %H:%i:%s') AS ignoff, ROUND(c.tripdistance,2) AS dist, c.startloc as startloc,c.endloc as endloc,
             ABS(c.triptimesec) AS workinghours , (c.totaltime-c.triptimesec) AS idlehours,
			 SEC_TO_TIME(ABS(c.triptimesec)) AS workinghour,SEC_TO_TIME(c.totaltime-c.triptimesec) AS idlehour,c.ignoffevent AS ignoffcount,
			 c.tripdate AS reportdate , if(c.startodo=0.00,'N/A',c.startodo) as startodo , if(c.endodo=0.00,'N/A',c.endodo)  as endodo,c.highspeed as highspeed, 0 as t1dist, 'N/A' as fuelfill, 'N/A' as fueldrop
			FROM trip_summary c
			LEFT JOIN units u ON u.unitnumber = c.unitnumber
			WHERE $unitnumberqry 
			c.tripdate >= '$start_date' AND c.tripdate <= '$end_date'  ORDER BY c.tripdate";
	
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getFuelFillHtmlReport($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$historyTable = $db['historyTable'];
		$timezone = $db['detail'][0]->timezone;
		$sql = "SELECT u.fv as fuelvar, u.fd as fueldrop,h.status as status,
				if(fuelwidth=0,'0',IFNULL(Round((h.analog1val*h.analog1val*h.analog1val*u.fx3)+(h.analog1val*h.analog1val*u.fx2)+(h.analog1val*u.fx)+(u.fc),0),'')) AS fuelfill
		        FROM $historyTable 
		        LEFT JOIN units u ON u.unitnumber=h.unitnumber  LEFT JOIN statuses s ON s.statusid=h.status 
		        WHERE h.unitnumber=$unitnumber AND h.status not in (16,18) and (s.languageid=2) 
		        AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_date')-$timezone) AND (UNIX_TIMESTAMP('$end_date')-$timezone) 
				ORDER BY h.reporttimeunix";	
		
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
		$sql = "SELECT distinct DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(h.reporttime)+$timezone),'%d-%m-%Y %H:%i:%s') as reporttime,s.statusdesc as status,round(h.speed,2) as speed,h.location as location,h.status as statusid, s.statuscolor AS statusColor,h.latitude AS lat, h.longitude AS lon,IF(s.icon=1,h.direction,'') AS direction ,
				DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime, h.unitname as unitname, u.ladleno as ladleno
				FROM $historyTable
				LEFT JOIN ladle_master u ON u.ladleno=h.lno 
		        LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.ladleno='$unitnumber'  AND (s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-0) AND (UNIX_TIMESTAMP('$end_datetime')-0)
				AND MINUTE(reporttime) % 3 = 0
				ORDER BY h.reporttimeunix ASC";
		
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_cycletime($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		
		$sql = "SELECT TRIP_ID , TAPNO, CARNO, ladleid, LADLENO, SOURCE, S, SI, TEMP, DEST, 
					DATE_FORMAT(STR_TO_DATE(FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%d-%m-%Y %H:%i:%s') FIRST_TARE_TIME, GROSS_DATE as grdate,
					DATE_FORMAT(GROSS_DATE, '%d-%m-%Y %H:%i:%s') GROSS_DATE, GROSS_WEIGHT, 
					TIMESTAMPDIFF(MINUTE, DATE_FORMAT(STR_TO_DATE(FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), GROSS_DATE) as ironzone,
					TARE_WEIGHT, NET_WEIGHT, UNLOAD_DATE, IF(BDSTEMP='null', '', BDSTEMP) as BDSTEMP, DATE_FORMAT(TARE_DATE, '%d-%m-%Y %H:%i:%s') TARE_DATE, TARE_WT2, NET_WT2, (TARE_WT2-TARE_WEIGHT) as leftover,
					TIMESTAMPDIFF(MINUTE, GROSS_DATE, TARE_DATE) as steelzone, 
					(TIMESTAMPDIFF(MINUTE, DATE_FORMAT(STR_TO_DATE(FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), GROSS_DATE) + TIMESTAMPDIFF(MINUTE, GROSS_DATE, TARE_DATE)) ironpsteel
					 
				FROM laddle_report
				WHERE GROSS_DATE between '$start_datetime' and '$end_datetime' and LADLENO='$unitnumber'
				ORDER BY GROSS_DATE asc";
		
		/*$sql = "SELECT distinct u.unitname as unitname,DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat')as reporttime,h.latitude as lat,h.longitude as lon,round(h.speed,2) as speed,st.statusdesc as status,round(s.maxspeed,2) as maxspeed,h.location as location,h.status as statusid, st.statuscolor AS statusColor
				 ,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime ,h.latitude AS lat, h.longitude AS lon,IF(st.icon=1,h.direction,'') AS direction
				 FROM $historyTable
				 LEFT JOIN units u ON u.unitnumber=h.unitnumber
				 LEFT JOIN unitsetting s ON s.unitnumber=h.unitnumber
				 LEFT JOIN statuses st ON st.statusid=h.status
				 WHERE u.unitnumber=$unitnumber AND (h.speed >=2 AND h.status IN (7,15,16,17)) AND (st.languageid='2') 
				 AND h.reporttimeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND h.reporttimeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				 ORDER BY h.reporttimeunix";*/
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_maintenance($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		
		$sql = "SELECT m.id, l.ladleno,m.ladleid, `sndTarewt`, `sndTaretime`, type, type_desc, `repairType`, `repairTypesub`, `repairComplete`, `maintainenceTime`, `heatingStarted`, `heatingStopped`, `underHeating`, `cycleCompleted` 
				FROM `maintenance_report` m
				LEFT JOIN maintenance_menu menu ON m.repairType=menu.id
				LEFT JOIN maintenance_submenu sub ON m.repairTypesub=sub.id AND sub.type_id=menu.id
				LEFT JOIN ladle_master l ON l.id=m.ladleid
				LEFT JOIN laddle_report r ON l.id=r.ladleid AND r.ladleid=m.ladleid
				WHERE m.is_delete=0 AND DATE_FORMAT(STR_TO_DATE(sndTaretime, '%d-%m-%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s') between '$start_datetime' and '$end_datetime' AND l.ladleno='$unitnumber'
				group by m.id
				order by m.id  ";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_idletime($db = array()){
		$lid = $db['lid'];
		$circulation = $db['circulation'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = 19800;
		//$dateformat = $db['detail'][0]->dateformat;
		
		
		$sql = "SELECT lno, unitname, DATE_FORMAT(FROM_UNIXTIME(l.reporttimeunix+$timezone),'%d-%m-%Y %H:%i:%s') as starttime, l.cycle,
				DATE_FORMAT(FROM_UNIXTIME((l.reporttimeunix+idletime)+$timezone),'%d-%m-%Y %H:%i:%s') as endtime, IF(yard='NA',idleloc,yard) AS yard, 
				FORMAT((idletime/60), 0) idletime		   
			   FROM ladle_idlereport l
			   LEFT JOIN units u ON  u.unitnumber=l.unitnumber 
				LEFT JOIN ladle_master s ON s.id=l.lid 
			WHERE l.lno='$lid'   
			AND l.reporttimeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND l.reporttimeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)
			ORDER BY l.reporttimeunix";
				
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_harshaccelerate($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$sql = "SELECT u.unitname as unitname,DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat')as reporttime,h.latitude as lat,h.longitude as lon,round(h.speed,2) as speed,st.statusdesc as status,round(s.maxspeed,2) as maxspeed,h.location as location,h.status as statusid, st.statuscolor AS statusColor,IF(st.icon=1,h.direction,'') AS direction
				,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'$dateformat') as starttime,DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'$dateformat') as endtime
				FROM $historyTable
				LEFT JOIN units u ON u.unitnumber=h.unitnumber
				LEFT JOIN unitsetting s ON s.unitnumber=h.unitnumber
				LEFT JOIN statuses st ON st.statusid=h.status 
				WHERE u.unitnumber=$unitnumber AND (st.statusid IN (6,21) AND st.languageid='2') 
				AND h.reporttimeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND h.reporttimeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				ORDER BY h.reporttimeunix";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_geofence_OLD($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$unitqry = " ge.lno ='$unitnumber' AND ";
		$timezone = 0;
		if($unitnumber == ""){
			$unitqry = "";
		}
		
		$sql = "SELECT g.geofencenumber as id, g.geofencename FROM geofences g 
				LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
				WHERE $unitqry ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone) AND g.companyid =$companyid AND ge.entry_status='101' and g.geofencename not like 'exit%'
				GROUP BY g.geofencename ORDER BY g.geofencenumber";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	
	function gettable_geofence($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$unitqry = " ge.lno ='$unitnumber' AND ";
		if($unitnumber == ""){
			$unitqry = "";
		}
		$sql = "SELECT g.geofencenumber as id, g.geodesc as geofencename FROM geofences g 
				LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
				WHERE $unitqry ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone) AND g.companyid =$companyid AND ge.entry_status='101'
				GROUP BY g.geodesc ORDER BY g.geofencenumber";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	
	function gettable_geofenceModified_OLD($db = array()){
		$unitnumber = $db['unitnumber'];
		$circulation = $db['circulation'];
		$start_datetime = $db['start_date'];
		$geoidlist = $db['geoidlist'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$unitqry = " un.ladleno = '$unitnumber' AND ";
		
		if($unitnumber == ""){
			$unitqry = "";
		}
		$sql = "SELECT g.geofencename as tGeoName,un.ladleno as tUnitName ,ge.timeunix,ge.latitude as tStartLat,ge.cycle,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'%d-%m-%y %H:%i:%s') AS starttime,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'%d-%m-%y %H:%i:%s') AS endtime,
		        DATE_FORMAT(FROM_UNIXTIME(ge.timeunix+$timezone),'%d-%m-%y %H:%i:%s') AS entrytime, ge.entry_status as entrystatus,
		        ge.longitude as tStartLon,ge.location as tStartLoc,'00:00:00' as timespent, 'N/A' as tEndLoc,'N/A' as tEndTime,'N/A' as tStartTime,'' as tEndLat, '' as tEndLon 
		        FROM geofences g 
		        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
		        LEFT JOIN ladle_master un ON un.ladleno = ge.lno
				WHERE $unitqry
			    ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
		        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)  AND ge.entry_status IN(102,103)
		        AND ( '$geoidlist' LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED),',%')  OR '$geoidlist' 
		        LIKE CONCAT(CONVERT(ge.geofencenumber ,UNSIGNED),',%') OR '$geoidlist'=ge.geofencenumber OR '$geoidlist' 
		        LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED)))
		        GROUP BY un.ladleno,ge.timeunix,g.geofencename,ge.entry_status 
		        ORDER BY un.ladleno,ge.timeunix,g.geofencename,ge.entry_status";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_geofenceModified($db = array()){
		$unitnumber = $db['unitnumber'];
		$circulation = $db['circulation'];
		$start_datetime = $db['start_date'];
		$geoidlist = $db['geoidlist'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$companyid = $db['detail'][0]->companyid;
		$unitqry = " un.ladleno = '$unitnumber' AND ";
		if($unitnumber == ""){
			$unitqry = "";
		}
		 $sql = "SELECT g.geodesc as tGeoName,un.ladleno as tUnitName ,ge.timeunix,ge.latitude as tStartLat,ge.cycle,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$start_datetime')),'%d-%m-%y %H:%i:%s') AS starttime,
		        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP('$end_datetime')),'%d-%m-%y %H:%i:%s') AS endtime,
		        DATE_FORMAT(FROM_UNIXTIME(ge.timeunix+ if (ge.entry_status = 102 , 19799, 19800)),'%d-%m-%y %H:%i:%s') AS entrytime, ge.entry_status as entrystatus,
		        ge.longitude as tStartLon,ge.location as tStartLoc,'00:00:00' as timespent, 'N/A' as tEndLoc,'N/A' as tEndTime,'N/A' as tStartTime,'' as tEndLat, '' as tEndLon 
		        FROM geofences g 
		        LEFT JOIN geofence_event ge ON g.geofencenumber =ge.geofencenumber  
		        LEFT JOIN ladle_master un ON un.ladleno = ge.lno
				WHERE $unitqry
			    ge.timeunix >= (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
		        ge.timeunix <= (UNIX_TIMESTAMP('$end_datetime')-$timezone)  AND ge.entry_status IN(102,103)
		        AND ( '$geoidlist' LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED),',%')  OR '$geoidlist' 
		        LIKE CONCAT(CONVERT(ge.geofencenumber ,UNSIGNED),',%') OR '$geoidlist'=ge.geofencenumber OR '$geoidlist' 
		        LIKE CONCAT('%,',CONVERT(ge.geofencenumber ,UNSIGNED)))
		        GROUP BY un.ladleno,ge.timeunix,g.geodesc,ge.entry_status 
		        ORDER BY un.ladleno,ge.timeunix,g.geodesc,ge.entry_status";
	
		//echo $sql;	
		$q=$this->db->query($sql);
			
	//	print_r($q->result());
		return $q->result();
	}
	
	function gettable_SMS($db = array()){
		$unitname = $db['unitname'];
		$start_date = $db['start_date'];
		$end_date = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		//$historyTable = $db['historyTable'];
		$sql = "SELECT  DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(newdate)+19800),'%d-%m-%Y') as reportdate, newtime as reporttime,
		       smstype as smstype,company as companyname,
		       vehicle as unitname,mobileno as mobileno,
		       contactname as contactname FROM sms_count where vehicle='$unitname' and  newdate >= '$start_date'  and newdate <= '$end_date'
		       group by newdate,newtime,contactname order by newdate,newtime";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_Interval($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$sql = "SELECT DISTINCT DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime, h.reporttimeunix as rpttime,s.statusdesc as status,
				h.status as statusid, s.statuscolor AS statusColor,round(h.speed,2) as speed,h.location as location, h.latitude as lat, h.longitude as lon, IF(s.icon=1,h.direction,'') as direction,h.distance as dist,
			     u.unitname as unitname, 0 as totaldist FROM $historyTable
			     LEFT JOIN units u ON u.unitNumber=h.unitNumber 
				LEFT JOIN statuses s ON s.statusid=h.status  
				 WHERE u.unitNumber=$unitnumber AND( s.languageid='2')  
				 AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				 ORDER BY h.reporttimeunix,h.status ASC";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_Stoppage($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$sql = "SELECT DISTINCT DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime, h.reporttimeunix as rpttime,s.statusdesc as status,h.status as statusid, s.statuscolor AS statusColor,round(h.speed,2) as speed,h.location as location, h.latitude as lat, h.longitude as lon, IF(s.icon=1,h.direction,'') as direction,
			     u.unitname as unitname, '' as event FROM $historyTable
			     LEFT JOIN units u ON u.unitNumber=h.unitNumber 
				LEFT JOIN statuses s ON s.statusid=h.status  
				 WHERE u.unitNumber=$unitnumber AND( s.languageid='2')  AND h.status IN(0,1,2,18,19)
				 AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				 ORDER BY h.reporttimeunix,h.status ASC";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_tripsummary($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$sql = "SELECT DISTINCT DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat') as reporttime,h.reporttimeunix as reporttimeunix,s.statusdesc as status,h.status as statusid, s.statuscolor AS statusColor,round(h.speed,2) as speed,h.location as location,h.latitude AS lat, h.longitude AS lon,IF(s.icon=1,h.direction,'') AS direction , 
				 u.unitname as unitname , h.distance 
				FROM $historyTable
				LEFT JOIN units u ON u.unitNumber=h.unitNumber 
				LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.unitNumber=$unitnumber AND  (  s.languageid='2') and h.status not in (16,14,9,23,68,69)
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND (UNIX_TIMESTAMP('$end_datetime')-$timezone)
				ORDER BY h.reporttimeunix,h.distance,h.status ASC";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_ignition($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$compny = $db['detail'][0]->companyid;
		$tripTableName = $db['tripTableName'];
		$sql = "CALL rptTripUnit1($unitnumber,'$tripTableName','$start_datetime','$end_datetime','$timezone','$dateformat',$compny)";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_ignModified($db = array()){
		$unitnumber = $db['unitnumber'];
		$tripStartTime1 = $db['tripStartTime1'];
		$tripEndTime1 = $db['tripEndTime1'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$compny = $db['detail'][0]->companyid;
		$tripTableName = $db['tripTableName'];
		$sql = "CALL rpTripUnit1($unitnumber,'$tripTableName','$tripStartTime1','$tripEndTime1',$timezone,'$dateformat',$compny,'$start_datetime','$end_datetime')";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function gettable_routes($db = array()){
		$unitnumber = $db['unitnumber'];
		$sql = "SELECT DISTINCT rl.route_name AS routeReportName,rsh.id AS locReportId FROM
				route_schedule rsh
				LEFT JOIN route_loc rl ON rl.id = rsh.route_id
				LEFT JOIN route_sch_unit rsu
				ON rsh.id = rsu.sch_id
				WHERE rsu.unit_id = $unitnumber AND rsu.is_delete IS
				FALSE AND rsh.is_delete IS FALSE ";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getRouteConLocHtmlReport($db = array()){
		$unitnumber = $db['unitnumber'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$historyTable = $db['historyTable'];
		$sql = "SELECT DISTINCT
				DATE_FORMAT(FROM_UNIXTIME(h.reporttimeunix+$timezone),'$dateformat')
				as reporttime,s.statusdesc as status,h.status as statusid,
				s.statuscolor AS statusColor,round(h.speed,2) as speed,h.location as
				location,h.latitude AS lat, h.longitude AS lon,
				IF(s.icon=1,h.direction,'') AS direction , h.reporttimeunix as
				reporttimeunix,h.distance as distance, h.idletime as idletime,
				u.unitname as unitname
				FROM $historyTable
				LEFT JOIN units u ON u.unitNumber=h.unitNumber
				LEFT JOIN statuses s ON s.statusid=h.status
				WHERE u.unitNumber=$unitnumber AND ( s.languageid='2')
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				(UNIX_TIMESTAMP('$end_datetime')-$timezone)
				ORDER BY h.reporttimeunix ASC";
		
		$q=$this->db->query($sql);		
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
	
	function getRouteConInsertTemp($db = array()){
		$unitnumber = $db['unitnumber'];
		$companyid = $db['detail'][0]->companyid;
		$historyTable = $db['historyTable'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$sql = "INSERT
				into
				route_temp(unitnumber,reporttimeunix,status,speed,distance,idletime)
				SELECT
				h.unitNumber,h.reporttimeunix,h.status,h.speed,h.distance,h.idletime
				FROM $historyTable
				WHERE h.unitNumber=$unitnumber
				AND h.reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				(UNIX_TIMESTAMP('$end_datetime')-$timezone)
				ORDER BY h.reporttimeunix ASC ";
		
		$this->db->query($sql);
	}
	
	function getRouteChkloc($locReportId){
		
		$sql = "SELECT COUNT(loc_id) AS chkloc FROM route_sch_location WHERE  sch_id=$locReportId";
		
		$q=$this->db->query($sql);	
		if(count($q->result())){
			$res = $q->result();
			return $res[0]->chkloc;
		}	
		return 0;
	}
	
	function getRouteConfigNoSpecificLocList($locReportId){
		$sql = "SELECT l.locationname as locname,rsl.loctype as loctype,rl.route_name AS routeName FROM route_schedule rsh
				LEFT JOIN route_sch_location rsl ON rsl.sch_id = rsh.id
				left join route_loc rl on rl.id = rsh.route_id
				LEFT JOIN location l ON l.locationid = rsl.loc_id WHERE rsh.id = $locReportId AND rsh.is_delete is false and rsl.is_delete is false order by rsl.loctype";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getRouteConfigList($locReportId){
		$sql = "SELECT l.locationname as locname,rsl.loctype as loctype,rl.route_name AS routeName FROM route_schedule rsh
				LEFT JOIN route_sch_location rsl ON rsl.sch_id = rsh.id
				left join route_loc rl on rl.id = rsh.route_id
				LEFT JOIN location l ON l.locationid = rsl.loc_id WHERE rsh.id = $locReportId AND rsh.is_delete is false and rsl.is_delete is false";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getDisRouteLocConHtmlReport($db = array()){
		$unitnumber = $db['unitnumber'];
		$starttimeunix = $db['starttimeunix'];
		$endtimeunix = $db['endtimeunix'];
		
		$sql = "SELECT reporttimeunix as reporttimeunix, status AS status,
				distance AS distance,IFNULL(idletime,0) AS idle
				FROM route_temp WHERE unitNumber=$unitnumber
				AND reporttimeunix BETWEEN '$starttimeunix' AND '$endtimeunix' 
				ORDER BY reporttimeunix ASC";
		
		$q=$this->db->query($sql);		
		return $q->result();
	}
	
	function getRouteLocConMaxSpeed($db = array()){
		$unitnumber = $db['unitnumber'];
		$starttimeunix = $db['starttimeunix'];
		$endtimeunix = $db['endtimeunix'];
		
		$sql = "SELECT max(speed) sp
				FROM route_temp
				where unitnumber = $unitnumber AND reporttimeunix BETWEEN '$starttimeunix' AND
				'$endtimeunix' LIMIT 1";
		
		$q=$this->db->query($sql);		
		if(count($q->result())){
			$res = $q->result();
			return $res[0]->sp;
		}	
		return 0;
	}
	
	function getRouteCondeleteTemp($db = array()){
		$unitnumber = $db['unitnumber'];
		$companyid = $db['detail'][0]->companyid;
		$historyTable = $db['historyTable'];
		$start_datetime = $db['start_date'];
		$end_datetime = $db['end_date'];
		$timezone = $db['detail'][0]->timezone;
		$dateformat = $db['detail'][0]->dateformat;
		$sql = "DELETE
				FROM route_temp
				WHERE unitNumber=$unitnumber AND
				reporttimeunix BETWEEN (UNIX_TIMESTAMP('$start_datetime')-$timezone) AND
				(UNIX_TIMESTAMP('$end_datetime')-$timezone)";
		
		$this->db->query($sql);
	}
}

?>
