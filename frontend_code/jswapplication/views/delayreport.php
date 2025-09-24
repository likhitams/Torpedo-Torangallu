 <script src="<?php echo asset_url();?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url();?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
 <input type="hidden" name="start_date" value="<?php echo $start_date = date("Y-m-d", strtotime($start_date));?>">
 <input type="hidden" name="end_date" value="<?php echo $end_date = date("Y-m-d", strtotime($end_date));?>">
 <input type="hidden" name="start_time" value="<?php echo $start_time = date("H:i:s", strtotime($start_time));?>">
 <input type="hidden" name="end_time" value="<?php echo $end_time = date("H:i:s", strtotime($end_time));?>">
          

<?php 
 $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
//$connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
 $starttime=$start_date." ".$start_time;
 $endtime=$end_date." ".$end_time;
echo $query="select LADLENO ,SMS_TIME,plugout_time, IF(TIMESTAMPDIFF(MINUTE,sc.plugout_time,sc.SMS_TIME) >0,TIMESTAMPDIFF(MINUTE,sc.plugout_time,sc.SMS_TIME),'') as locotime from laddle_report sc where sc.plugout_time is not null and SMS_TIME is not null and sc.plugout_time between  '$starttime' and  '$endtime' "; 
$result = mysqli_query($connect, $query);
while ($row=mysqli_fetch_array($result))
{ 
    //  $LADLENO=$row['LADLENO'];
    //  $SMS_TIME=$row['SMS_TIME'];
    //  $plugout_time=$row['plugout_time'];
    // echo  $locotime=$row['locotime'];
    
  if($row['locotime']!=""){
     // echo  $LADLENO =$row["LADLENO"]; 
    $LADLENO .= "'".$row['LADLENO']."',";
      $SMS_TIME .="{$row["SMS_TIME"]},"; 
      $plugout_time .="{$row["plugout_time"]},"; 
      $locotime .="{$row["locotime"]},";
  }
    // echo $ironzone .="{ ironzone:'".$row["ironzone"]."},"; 
    // echo $steelzone .="{ steelzone:'".$row["steelzone"]."},";  
    // $chart_data .="{ ladleno:'".$row["ladleno"]."',ironzone:".$row["ironzone"].",steelzone:".$row["steelzone"].",total:".$row["total"]."},"; 
    // echo $ladleno=$row['ladleno'];

}

mysqli_close($connect);
?>


<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title> delay </title>

<link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
     <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> -->
     
</head>

<body>
<div class="container" style="width: 1200px">
<div id="chart"></div>
</div>
</body>

</html>
  <?php echo $jsfile; ?>
<script src="<?php echo asset_url() ?>chart/apexcharts.min.js"></script>
<script>
 
    var chart =document.querySelector("#chart")
    var options={
        chart:{
        height:350,
        type:'line',
        toolbar: {
            show: false
          },
        zoom: {
            enabled: false
        }

    },
    stroke: {
          width:1,
          curve: 'straight'
    },
    dataLabels:{
        enabled:false
    },
    grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
    },
    series: [{
            name: "Delay",
            // data: [100, 41, 5, 51, 49, 62, 69, 91, 148]
            data:[<?php echo $locotime;?>],
        }],
   
     xaxis: {
           categories: [<?php echo $LADLENO;?>],
           // categories: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'J','K']
            
        } ,

}

var chartElement = new ApexCharts(chart,options)
chartElement.render();
</script>
