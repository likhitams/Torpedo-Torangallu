<?php
$connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
 // $connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
// $yesterday = new DateTime('yesterday');
// $yesdate1=$yesterday->format('Y-m-d 00:00:00');
// $yesterday = new DateTime('yesterday');
// $yesdate2=$yesterday->format('Y-m-d 23:59:59');

// echo $querymst="SELECT LADLENO,ladleid, count(LADLENO) as today,max(c_load) as c_load, max(m_load) as m_load, DATE_SUB(CURDATE(), INTERVAL 1 DAY) as yesterdaydate FROM laddle_report WHERE date(TARE_DATE) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP by ladleid";

echo $querymst="SELECT lr.LADLENO,lr.ladleid, count(lr.LADLENO) as today,max(lr.c_load) as c_load, max(lr.m_load) as m_load,lm.load ,DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY),'%Y-%m-%d %H:%i:%s') as yesterdaydate FROM laddle_report lr JOIN ladle_master lm ON lr.ladleid = lm.id WHERE date(lr.TARE_DATE) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP by lr.ladleid";


  // $querymst="SELECT lr.LADLENO, lr.ladleid, COUNT(lr.LADLENO) AS today, MAX(lr.c_load) AS c_load, MAX(lr.m_load) AS m_load, lm.load  FROM laddle_report lr JOIN ladle_master lm ON lr.ladleid = lm.id WHERE lr.TARE_DATE BETWEEN '2023-10-18 00:00:00' AND '2023-10-18 23:00:00' GROUP BY lr.ladleid";

$result = mysqli_query($connect, $querymst);
 while($row=mysqli_fetch_array($result))
      {

               $ladleid = $row['ladleid'];
               $LADLENO = $row['LADLENO'];
               $c_load  = $row['c_load'];
               $m_load  = $row['m_load'];
               $todaycount   = $row['today'];
               $yesterdaydate=$row['yesterdaydate'];
               $TARE_DATE =$row['TARE_DATE'];
               $load=$row['load'];
               // $cummulativecount=$load+$todaycount;

               $remarks="Running";
               if($todaycount==0)
              {
                $remarks='';
              }

     
 echo $insertquery="insert into ladle_summary_report(ladleid,LADLENO,heat_count,today_count,cummulativecount,summarydate,suppliername,remarks)values('$ladleid','$LADLENO','$load','$todaycount','$c_load','$yesterdaydate','$suppliername','$remarks')";
  
  $insertquery=mysqli_query($connect,$insertquery);
  
    
   }
   
?>