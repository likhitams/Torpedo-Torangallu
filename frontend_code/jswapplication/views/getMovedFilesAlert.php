<?php 
if(count($result)){
	foreach ($result as $r){
		echo $r;
		$this->master_db->updateRecord("TLC_GPS_LATEST", array("MSG_FLAG"=>'C'), array("userId"=>$r->userId));?>
		<p id="shake_text" style="width:100% !important;">  <strong><?php echo $r->TAG_DESCRIPTION?> for TrackID :</strong> <span class="text-danger"><strong><?php echo $r->TRACKID?></strong></span> <strong> Ready to Go.. Time @ <?php echo $r->TIME?></strong> </p>
	<?php 
	}
}
?>