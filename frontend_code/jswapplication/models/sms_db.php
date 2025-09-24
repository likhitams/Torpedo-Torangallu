<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sms_db extends CI_Model{
    
    function getTargetProduction($date){
        $sql = "Select target from target_prod where date='$date'";
        $result = $this->db->query($sql);
        
        return $result->result();
    }
	
    function getActualProduction($date, $shift = "", $hour = 0){  
        
        switch($shift){
            case "a": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00')";break;
            case "b": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
            case "c": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00')";break;
            default: $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
        }
        $select = $group = "";
        if($hour == 1){
            $select = " ,extract(hour from GROSS_DATE) as theHour ";
            $group = "  group by extract(hour from GROSS_DATE) order by gross_date ";
        }
        
        $sql = "SELECT IFNULL(SUM(NET_WEIGHT), 0)  BF_PRODA $select  FROM laddle_report WHERE NET_WT2>0 $condition $group ";
		$result = $this->db->query($sql);
		
		return $result->result();
    }
	
    function getLaddleProduction($date, $shift = ""){
        
        switch($shift){
            case "a": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00')";break;
            case "b": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
            case "c": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00')";break;
            default: $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
        }
        $sql = "select LADLENO,SUM(NET_WEIGHT) as NetWt, '' color from laddle_report WHERE NET_WT2>0 $condition 
                group by LADLENO order by NetWt DESC";
        $result = $this->db->query($sql);
        
        return $result->result();
    }
    
    function getLaddleProductionTripCount($date, $shift = ""){
        
        switch($shift){
            case "a": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00')";break;
            case "b": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','14:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
            case "c": $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','06:00:00')";break;
            default: $condition = " and GROSS_DATE>=CONCAT(DATE_ADD('$date' , INTERVAL -1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_ADD('$date' , INTERVAL 0 DAY),' ','22:00:00')";break;
        }
        $sql = "select LADLENO,COUNT(id) as tripcnt, '' color from laddle_report WHERE NET_WT2>0 $condition
                group by LADLENO order by tripcnt DESC";
        $result = $this->db->query($sql);
        
        return $result->result();
    }
    
    function getTextColor(){
        $textarr = array(
            "1"=>array("classname"=>"text-red","bgclassname"=>"bg-blue","color"=>"#03a9f4"),
            "2"=>array("classname"=>"text-green","bgclassname"=>"bg-purple","color"=>"#e861ff"),
            "3"=>array("classname"=>"text-yellow","bgclassname"=>"bg-green","color"=>"#08ccce"),
            "4"=>array("classname"=>"text-aqua","bgclassname"=>"bg-brown","color"=>"#e2b35b"),
            "5"=>array("classname"=>"text-light-blue","bgclassname"=>"bg-red","color"=>"#e40503"),
            "6"=>array("classname"=>"text-gray","bgclassname"=>"bg-purple","color"=>"#9c15c1"),
            "7"=>array("classname"=>"text-navy","bgclassname"=>"bg-yellow","color"=>"#dfc225"),
            "8"=>array("classname"=>"text-teal","bgclassname"=>"bg-teal","color"=>"#39cccc"),
            "9"=>array("classname"=>"text-olive","bgclassname"=>"bg-olive","color"=>"#3d9970"),
            "10"=>array("classname"=>"text-orange","bgclassname"=>"bg-orange","color"=>"#ff851b"),
            "11"=>array("classname"=>"text-lime","bgclassname"=>"bg-lime","color"=>"#01ff70"),
            "12"=>array("classname"=>"text-purple","bgclassname"=>"bg-purple","color"=>"#605ca8"),
            "13"=>array("classname"=>"text-blue","bgclassname"=>"bg-blue","color"=>"#0073b7"),
            "14"=>array("classname"=>"text-maroon","bgclassname"=>"bg-maroon",	"color"=>"#d81b60"),
            "15"=>array("classname"=>"text-fuchsia","bgclassname"=>"bg-fuchsia","color"=>"#f012be"),
            "16"=>array("classname"=>"text-black","bgclassname"=>"bg-black","color"=>"#111"),
        );
        return $textarr;
    }
    
    function getBGColor(){
        $textarr = array(
            "1"=>array("classname"=>"text-red","bgclassname"=>"bg-yellow-active","color"=>"#dd4b39"),
            "2"=>array("classname"=>"text-green","bgclassname"=>"bg-blue-active","color"=>"#00a65a"),
            "3"=>array("classname"=>"text-yellow","bgclassname"=>"bg-teal-active","color"=>"#f39c12"),
            "4"=>array("classname"=>"text-aqua","bgclassname"=>"bg-purple-active","color"=>"#00c0ef"),
            "5"=>array("classname"=>"text-light-blue","bgclassname"=>"bg-aqua-active","color"=>"#3c8dbc"),
            "6"=>array("classname"=>"text-gray","bgclassname"=>"bg-lime-active","color"=>"#d2d6de"),
            "8"=>array("classname"=>"text-navy","bgclassname"=>"bg-orange-active","color"=>"#001f3f"),
            "7"=>array("classname"=>"text-teal","bgclassname"=>"bg-green-active","color"=>"#39cccc"),
            "9"=>array("classname"=>"text-olive","bgclassname"=>"bg-light-blue-active","color"=>"#3d9970")
        );
        return $textarr;
    }
    
	
}

?>