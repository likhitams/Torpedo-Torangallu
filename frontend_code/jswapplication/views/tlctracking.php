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
                                <th>Sl.No</th>
                                <th>TLC No.</th>
                                <th>Date</th>
                                <th>Heat NO</th>
                                <th>Location</th>
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

       $sumrep="select id,ladleno from ladle_master ";
       $sumrep = mysqli_query($connect, $sumrep);
        while($sumrow=mysqli_fetch_array($sumrep))
        {
              $id=$sumrow['id'];
              $ladleno=$sumrow['ladleno'];
              
         
          
                              ?>
                                <td><?php echo $count;?></td>
                                <td><?php echo $ladleno;?></td>
                                <!-- <td><?php echo $suppliername;?></td>
                                <td><?php echo $heat_count;?></td>
                                <td><?php echo $today_count;?></td>
                                <td><?php echo $cummulativecount;?></td>
                                <td><?php echo $remarks;?></td> -->

                            </tr>

                            <?php
                            $count++;
                            $total_today_count += $today_count;
                      
                          }
                          
                          ?>
                          
                        </tbody>
                    </table> 
 
          </div>
         

</body>

</html>
