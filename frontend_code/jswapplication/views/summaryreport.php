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
  // $connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
     $starttime=$start_date." ".$start_time;
     $endtime=$end_date." ".$end_time;    
 
?>

<div class="table-responsive">

                    <table id="datatable" class="table table-bordered dataTables_wrapper nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Torpedo No.</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Life(Heat)</th>
                                <th>Life as on date</th>
                                <th>Cummulative Life(maintenance)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <?php
                              $count=1;

      $sumrep="select id,ladleid,heat_count,today_count,cummulativecount,summarydate,suppliername,remarks from ladle_summary_report where summarydate>='$starttime' and summarydate<='$endtime'";
       $sumrep = mysqli_query($connect, $sumrep);
        while($sumrow=mysqli_fetch_array($sumrep))
        {
              $id=$sumrow['id'];
              $ladleid=$sumrow['ladleid'];
              $heat_count=$sumrow['heat_count'];
              $today_count=$sumrow['today_count'];
              $cummulativecount=$sumrow['cummulativecount'];
              $remarks=$sumrow['remarks']; 
              $suppliername=$sumrow['suppliername'];
              $summarydate=$sumrow['summarydate'];
              $summarydate = date('Y-m-d', strtotime($summarydate));
          $sumlad="select suppliername,ladleno from ladle_master where id='$ladleid'";
          $sumlad=mysqli_query($connect,$sumlad);
          while($rowlad=mysqli_fetch_array($sumlad))
          {
            // $suppliername=$rowlad['suppliername'];
            $ladleno=$rowlad['ladleno'];
            $lifeheat=$cummulativecount-$today_count;
                              ?>
                                <td><?php echo $count;?></td>
                                <td><?php echo $ladleno;?></td>
                                <td><?php echo $summarydate;?></td>
                                <td><?php echo $suppliername;?></td>
                                <td><?php echo $lifeheat;?></td>
                                <td><?php echo $today_count;?></td>
                                <td><?php echo $cummulativecount;?></td>
                                <td><?php echo $remarks;?></td>

                            </tr>

                            <?php
                            $count++;
                             $total_today_count += $today_count;
                          }
                          }
                          
                          ?>
                          <tr><td><b>Total</b></td><td></td><td></td><td></td><td></td><td><b><?php echo $total_today_count; ?></b></td></tr>
                        </tbody>
                    </table> 
 
          </div>
         

</body>

</html>