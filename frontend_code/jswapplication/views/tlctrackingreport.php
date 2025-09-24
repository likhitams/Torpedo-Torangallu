<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo title; ?></title>
    <link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() ?>chart/apexcharts.css"/>
   <input type="hidden" name="start_date" value="<?php echo $start_date = date("Y-m-d", strtotime($start_date));?>">
 <input type="hidden" name="end_date" value="<?php echo $end_date = date("Y-m-d", strtotime($end_date));?>">
 <input type="hidden" name="start_time" value="<?php echo $start_time = date("H:i:s", strtotime($start_time));?>">
 <input type="hidden" name="end_time" value="<?php echo $end_time = date("H:i:s", strtotime($end_time));?>">
<input type="hidden" name="group" value="<?php echo $group = $unit;?>">



</head>



<!-- <body onload="getData();" class="dark-sidenav">
 -->
<?php 
  $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
  // $connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
    $start_time=$start_date." ".$start_time;
    $end_time=$end_date." ".$end_time;    
    // echo $group111=$group." ".$group;

?>

<div class="table-responsive">

                    <table id="datatable" class="table table-bordered dataTables_wrapper nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Date</th>
                                <th>Heat NO</th>
                                <th>Location</th>
                                <th>TLC No.</th>
                                <th>Tapping Source</th>
                                <th>Pouring Destination</th>
                                <th>Tap Time</th>
                                <th>Pour Time</th>
                                <th>TRT(Turn Around Time)</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                             <tr>
                              <?php
                              $count=1;

$sql="
SELECT sc.TRIP_ID , sc.TAPNO, sc.CARNO, ladleid, u.LADLENO, sc.SOURCE, sc.S, sc.SI, sc.TEMP, sc.DEST,u.load,sc.GROSS_DATE,DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'),
'%d-%m-%Y %H:%i:%s') FIRST_TARE_TIME,IF(DATE_FORMAT(sc.BF_ENTRY, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.BF_ENTRY, '%d-%m-%Y %H:%i:%s')) 
as BF_ENTRY,IF(DATE_FORMAT(sc.BF_EXIT, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.BF_EXIT, '%d-%m-%Y %H:%i:%s')) as BF_EXIT,
IF(DATE_FORMAT(sc.SMS_ENTRY, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.SMS_ENTRY, '%d-%m-%Y %H:%i:%s')) as SMS_ENTRY,
IF(DATE_FORMAT(sc.SMS_TIME, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.SMS_TIME, '%d-%m-%Y %H:%i:%s')) as SMS_TIME,
IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.BF_ENTRY='1970-01-01 05:30:00','',sc.BF_ENTRY),if(sc.BF_EXIT='1970-01-01 05:30:00','',sc.BF_EXIT)),'') as tappingtime,
IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.pouring_start='1970-01-01 05:30:00','',sc.pouring_start),if(sc.pouring_end='1970-01-01 05:30:00','',sc.pouring_end)),'') as pouringtime,
IF(sc.BF_EXIT='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.BF_EXIT='1970-01-01 05:30:00','',sc.BF_EXIT),if(sc.GROSS_DATE='1970-01-01 05:30:00','',
sc.GROSS_DATE)),'')) as timebf,IF(sc.SMS_ENTRY='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.GROSS_DATE='1970-01-01 05:30:00','',sc.GROSS_DATE),
if(sc.SMS_ENTRY='1970-01-01 05:30:00','',sc.SMS_ENTRY)),'')) as timesms,IF(sc.SMS_TIME='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,
if(sc.SMS_TIME='1970-01-01 05:30:00','',sc.SMS_TIME),if(sc.TARE_DATE='1970-01-01 05:30:00','',sc.TARE_DATE)),'')) as locotime,DATE_FORMAT(sc.GROSS_DATE,
 '%d-%m-%Y %H:%i:%s') GROSS_DATE,sc.GROSS_DATE as grdate, sc.GROSS_WEIGHT,sc.TAP_NO as TAPHOLE,TIMESTAMPDIFF(MINUTE, DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, 
'%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), sc.GROSS_DATE) as ironzone,sc.TARE_WEIGHT, sc.NET_WEIGHT, sc.UNLOAD_DATE, IF(sc.BDSTEMP='null', '', sc.BDSTEMP) as BDSTEMP,
 DATE_FORMAT(sc.TARE_DATE, '%d-%m-%Y %H:%i:%s') TARE_DATE, sc.TARE_WT2 as TARE_WT2, sc.NET_WT2, (sc.TARE_WT2-sc.TARE_WEIGHT) as leftover,TIMESTAMPDIFF(MINUTE,
 sc.GROSS_DATE, sc.TARE_DATE) as steelzone FROM unit_groups g left join groupmembers gm on gm.groupnumber = g.groupnumber left join ladle_master u on u.ladleno = gm.lno
left join laddle_report sc on sc.LADLENO =u.ladleno AND sc.LADLENO =gm.lno where g.groupnumber=$group and  sc.GROSS_DATE between  '$start_time' and  '$end_time' and 
g.is_delete is false and gm.is_delete is false  ORDER BY sc.GROSS_DATE asc";                         

// $sql="SELECT sc.TRIP_ID , sc.TAPNO, sc.CARNO, ladleid, u.LADLENO, sc.SOURCE, sc.S, sc.SI, sc.TEMP, sc.DEST,DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'),
// '%d-%m-%Y %H:%i:%s') FIRST_TARE_TIME,IF(DATE_FORMAT(sc.BF_ENTRY, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.BF_ENTRY, '%d-%m-%Y %H:%i:%s')) 
// as BF_ENTRY,IF(DATE_FORMAT(sc.BF_EXIT, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.BF_EXIT, '%d-%m-%Y %H:%i:%s')) as BF_EXIT,
// IF(DATE_FORMAT(sc.SMS_ENTRY, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.SMS_ENTRY, '%d-%m-%Y %H:%i:%s')) as SMS_ENTRY,
// IF(DATE_FORMAT(sc.SMS_TIME, '%d-%m-%Y %H:%i:%s')='01-01-1970 05:30:00','',DATE_FORMAT(sc.SMS_TIME, '%d-%m-%Y %H:%i:%s')) as SMS_TIME,
// IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.BF_ENTRY='1970-01-01 05:30:00','',sc.BF_ENTRY),if(sc.BF_EXIT='1970-01-01 05:30:00','',sc.BF_EXIT)),'') as tappingtime,
// IF(sc.BF_EXIT='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.BF_EXIT='1970-01-01 05:30:00','',sc.BF_EXIT),if(sc.GROSS_DATE='1970-01-01 05:30:00','',
// sc.GROSS_DATE)),'')) as timebf,IF(sc.SMS_ENTRY='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,if(sc.GROSS_DATE='1970-01-01 05:30:00','',sc.GROSS_DATE),
// if(sc.SMS_ENTRY='1970-01-01 05:30:00','',sc.SMS_ENTRY)),'')) as timesms,IF(sc.SMS_TIME='1970-01-01 05:30:00','',IFNULL(TIMESTAMPDIFF(MINUTE,
// if(sc.SMS_TIME='1970-01-01 05:30:00','',sc.SMS_TIME),if(sc.TARE_DATE='1970-01-01 05:30:00','',sc.TARE_DATE)),'')) as locotime,DATE_FORMAT(sc.GROSS_DATE,
//  '%d-%m-%Y %H:%i:%s') GROSS_DATE,sc.GROSS_DATE as grdate, sc.GROSS_WEIGHT,sc.TAP_NO as TAPHOLE,TIMESTAMPDIFF(MINUTE, DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, 
// '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), sc.GROSS_DATE) as ironzone,sc.TARE_WEIGHT, sc.NET_WEIGHT, sc.UNLOAD_DATE, IF(sc.BDSTEMP='null', '', sc.BDSTEMP) as BDSTEMP,
//  DATE_FORMAT(sc.TARE_DATE, '%d-%m-%Y %H:%i:%s') TARE_DATE, sc.TARE_WT2 as TARE_WT2, sc.NET_WT2, (sc.TARE_WT2-sc.TARE_WEIGHT) as leftover,TIMESTAMPDIFF(MINUTE,
//  sc.GROSS_DATE, sc.TARE_DATE) as steelzone FROM unit_groups g left join groupmembers gm on gm.groupnumber = g.groupnumber left join ladle_master u on u.ladleno = gm.lno
// left join laddle_report sc on sc.LADLENO =u.ladleno AND sc.LADLENO =gm.lno where g.groupnumber=$group and  sc.GROSS_DATE between  'start_time' and  'end_time' and 
// g.is_delete is false and gm.is_delete is false  ORDER BY sc.GROSS_DATE asc";

           $result = mysqli_query($connect, $sql);
           while($row=mysqli_fetch_array($result))
             {
                 $LADLENO = $row['LADLENO'];
                 $pouringtime = $row['pouringtime'];
                 $tappingtime = $row['tappingtime'];
                 $source1=$row['SOURCE'];
                 $destination1=$row['DEST'];
                 $ironzone1=$row['ironzone'];
                 $load=$row['load'];
                 $gross_date=$row['GROSS_DATE'];
          
                              ?>
                              <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $gross_date;?></td>
                                <td><?php echo $load;?> </td>
                                <td><?php echo $destination1;?> </td>
                                <td><?php echo $LADLENO;?></td>
                                <td><?php echo $source1;?></td>
                                <td><?php echo $destination1;?></td>
                                <td><?php echo $tappingtime;?></td>
                                <td><?php echo $pouringtime;?></td> 
                                <td><?php echo $ironzone1;?></td> 
                            </tr>

                            <?php
                            $count++;
                           
                      
                          }
                          
                          ?>
                          
                        </tbody>
                    </table> 
 
          </div>
         

</body>

</html>
