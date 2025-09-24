<?php 
foreach ($result as $r){
?>
<p id="shake_text" style="width:100% !important;"><span class="text-danger"><strong><?php echo $r->ladle_no?></strong></span>   <strong> Service is due on  </strong><strong><?php echo $r->service_date?></strong></p>
<?php 
}
?>
<br>
 
<h4 class="text-danger">Empty Torpedo Signal Alerts:</h4>
<?php
 include 'mysqli_connect.php';
 
 $query=mysqli_query($connect,"SELECT TAG,TAG_DESCRIPTION,DATE_FORMAT(TIME,'%d-%m-%Y %H:%i:%s') as TIME,TRACKID,SEQ_VALUE, INSERT_DT,MSG_FLAG,userId from TLC_GPS_LATEST where  userId= '231' order by INSERT_DT DESC  LIMIT 6");
while ($row = mysqli_fetch_array($query))  
{
?>
	<p id="shake_text" style="width:100% !important;">  <strong><?php echo $row[1]; ?>  for TrackID :</strong> <span class="text-danger"><strong><?php echo $row[3]; ?></strong></span> <strong> Ready to Go.. Time @ <?php echo $row["TIME"]; ?></strong> </p>
<?php 
}
?>

 