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
while ($row=mysqli_fetch_array($result))
{
  $ladleno=$row['ladleno'];
    $chart_data .="{ ladleno:'".$row["ladleno"]."',ironzone:".$row["ironzone"].",steelzone:".$row["steelzone"].",total:".$row["total"]."},"; 
  
  //  $chart_data .="{ ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL21',ironzone:2,steelzone:3}, { ladleno:'OTL21',ironzone:2,steelzone:3}";
}
//$chart_data .="{ ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL37',ironzone:10,steelzone:3}, { ladleno:'OTL21',ironzone:2,steelzone:3}, { ladleno:'OTL21',ironzone:2,steelzone:3},";

//$chart_data .="{ ladleno:'OTL37',ironzone:10,steelzone:3}";

  // This line is added to close mysql connection
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
<script>
var browsersChart =Morris.Bar({
	element : 'chart',
	data:[<?php echo $chart_data?>],
	xkey:'ladleno',
	ykeys:['ironzone','steelzone','total'],
	labels:['Iron Zone (hrs)','Steel Zone (hrs)','Total (hrs)'],
	hideHover:'auto',	
});


</script>
