 <script src="<?php echo asset_url();?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url();?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
 <input type="hidden" name="start_date" value="<?php echo $start_date = date("Y-m-d", strtotime($start_date));?>">
 <input type="hidden" name="end_date" value="<?php echo $end_date = date("Y-m-d", strtotime($end_date));?>">
 <input type="hidden" name="start_time" value="<?php echo $start_time = date("H:i:s", strtotime($start_time));?>">
 <input type="hidden" name="end_time" value="<?php echo $end_time = date("H:i:s", strtotime($end_time));?>">
          


<?php 
$connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");

 $starttime=$start_date." ".$start_time;
 $endtime=$end_date." ".$end_time;

$query = "SELECT  sc.ladleno as ladleno,
ROUND(AVG(TIMESTAMPDIFF(HOUR, DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), sc.GROSS_DATE)),1) AS ironzone, 
ROUND(AVG(IFNULL(TIMESTAMPDIFF(HOUR, sc.GROSS_DATE, sc.TARE_DATE),0)),1) AS steelzone,
ROUND(AVG(TIMESTAMPDIFF(HOUR, DATE_FORMAT(STR_TO_DATE(sc.FIRST_TARE_TIME, '%e/%c/%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), sc.GROSS_DATE) + IFNULL(TIMESTAMPDIFF(HOUR, sc.GROSS_DATE, sc.TARE_DATE),0)),1) AS total 
FROM mst_groups g 
    LEFT JOIN groupmembers gm ON gm.groupnumber = g.groupnumber
    LEFT JOIN ladle_master u ON u.ladleno = gm.lno
  LEFT JOIN laddle_report sc ON sc.LADLENO =u.ladleno AND sc.LADLENO =gm.lno where sc.GROSS_DATE>='$starttime' and sc.GROSS_DATE<='$endtime'  GROUP BY ladleno ORDER BY ladleno ";
$result = mysqli_query($connect, $query);
$chart_data='';
$ladleno ='';
while ($row=mysqli_fetch_array($result))
{
   // echo $ladleno=$row['ladleno'];
   $ladleno .= "'".$row['ladleno']."',";
    $ironzone .="{$row["ironzone"]},"; 
    $steelzone .="{$row["steelzone"]},"; 
    // echo $ironzone .="{ ironzone:'".$row["ironzone"]."},"; 
    // echo $steelzone .="{ steelzone:'".$row["steelzone"]."},";  
    // $chart_data .="{ ladleno:'".$row["ladleno"]."',ironzone:".$row["ironzone"].",steelzone:".$row["steelzone"].",total:".$row["total"]."},"; 
    // echo $ladleno=$row['ladleno'];
    //  echo $ironzone=$row['ironzone'];
    // echo $steelzone=$row['steelzone'];
  
}

mysqli_close($connect);
?>

<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title> Cycle Time Chart </title>

<link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
     <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
     
</head>

<body>
<div class="container" style="width: 1200px">
<div id="chart"></div>
</div>
</body>

</html>
  <?php echo $jsfile; ?>
<script src="<?php echo asset_url() ?>bar/apexcharts.min.js"></script>
<script>
    var chart =document.querySelector("#chart")
    var options = {
          series: [{
          name: 'BF',
          // data: [13, 23, 20, 8, 13, 27, 90, 40, 30, 80,60]
          data: [<?php echo $ironzone;?>],
        },  {
          name: 'SMS',
          // data: [13, 23, 20, 8, 13, 27, 90, 40, 30, 80,60]
          data: [<?php echo $steelzone;?>],
        }],
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            horizontal: false,
            borderRadius: 10,
            dataLabels: {
              total: {
                enabled: true,
                style: {
                  fontSize: '13px',
                  fontWeight: 900
                }
              }
            }
          },
        },
         xaxis: {
          type: '',
          categories: [<?php echo $ladleno;?>],
        },
        
        
        legend: {
          position: 'right',
          offsetY: 40
        },
        fill: {
          opacity: 1
        }
        };

var chartElement = new ApexCharts(chart,options)
chartElement.render();
</script>
