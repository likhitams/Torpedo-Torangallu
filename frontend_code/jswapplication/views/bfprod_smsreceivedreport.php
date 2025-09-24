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


</head>



<body onload="getData();" class="dark-sidenav">

<?php 
 $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
 //$connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
     $starttime=$start_date." ".$start_time;
     $endtime=$end_date." ".$end_time;    
 
?>

<div class="datatable-responsive">

                    <table id="datatable" class="table table-bordered dataTables_wrapper nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                            <tr>
                                <th>Bf production</th>
                                <th>SMS Received</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                          <td><b>PhaseI&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b><?php  $bf1 = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>='$starttime' AND lm.GROSS_DATE <= '$endtime'and lm.phase=1"));
                           echo ($bf1[0]->BF_PROD); ;?></td>

                     <td><b>PhaseI&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b><?php
                     $bf3 = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); 
                     echo ($bf3[0]->BF_PROD); ?></td>
                         </tr>
                         <tr>
                                <td><b>PhaseII&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b><?php $bf2 = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT) BF_PROD FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') and GROSS_DATE>='$starttime' AND GROSS_DATE <= '$endtime'"));
                               echo ($bf2[0]->BF_PROD); ?></td>

                               <td><b>PhaseII&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b><?php $bf2 = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') and GROSS_DATE>='$starttime' AND GROSS_DATE <= '$endtime'"));
                               echo ($bf2[0]->BF_PROD); ?></td>
                                

                            </tr>

                            <?php
                            $count++;
                            
                          
                          
                          ?>
                          
                        </tbody>
                    </table> 
 
          </div>
         

</body>

</html>
