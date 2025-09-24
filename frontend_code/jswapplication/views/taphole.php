<?php
static $track1 = 0;
static $track2 = 0;
static $signal1 = 1;
static $TLC1 = "";
static $TLC2 = "";
static $signal2 = 1;
?>
<div class="taphole">
	<table class="table table-taphole">
		<tr>
			<th colspan="2" class="text-center">Taphole-1</th>
		</tr>
		<tr>
			<td>Percentage of Filling (CR Side) </td>
			<td align="right">
				<?php
				$T1_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
				$T1_R1_BF = $T1_R1[0]->RADAR1;

				echo $T1_R1_BF . "%";
				?>
			</td>
		</tr>
		<tr>
			<td>Percentage of Filling (DP Side) </td>
			<td align="right">
				<?php
				$T1_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
				$T1_R2_BF = $T1_R2[0]->RADAR2;

				echo $T1_R2_BF . "%";
				?></td>
		</tr>
		<tr>
			<td>Torpedo Number (CR Side) </td>
			<td align="right">
				<?php
				$T1_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
				$T1_CP_BF = $T1_CP[0]->CP;

				echo $T1_CP_BF;
				?>
			</td>
		</tr>
		<tr>
			<td>Torpedo Number (DP Side) </td>
			<td align="right">
				<?php
				$dp = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
				$DP_bf = $dp[0]->DP;

				echo $DP_bf;
				?>
			</td>
		</tr>
	</table>
	<table class="table table-taphole">
		<tr>
			<th colspan="2" class="text-center">Taphole-2</th>
		</tr>
		<tr>
			<td>Percentage of Filling (CR Side) </td>
			<td align="right">
				<?php
				$T2_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
				$T2_R1_BF = $T2_R1[0]->RADAR1;

				echo $T2_R1_BF . "%";
				?>
			</td>
		</tr>
		<tr>
			<td>Percentage of Filling (DP Side) </td>
			<td align="right">
				<?php
				$T2_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
				$T2_R2_BF = $T2_R2[0]->RADAR2;

				echo $T2_R2_BF . "%";
				?></td>
		</tr>
		<tr>
			<td>Torpedo Number (CR Side) </td>
			<td align="right">
				<?php
				$T2_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
				$T2_CP_BF = $T2_CP[0]->CP;

				echo $T2_CP_BF;
				?>
			</td>
		</tr>
		<tr>
			<td>Torpedo Number (DP Side) </td>
			<td align="right">
				<?php
				$T2_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
				$T2_DP_BF = $T2_DP[0]->DP;
				echo $T2_DP_BF;
				?>
			</td>
		</tr>
	</table>
	<table class="table table-taphole">
		<tr>
			<th colspan="2" class="text-center">Taphole-3</th>
		</tr>
		<tr>
			<td>Percentage of Filling (CR Side) </td>
			<td align="right">
				<?php
				$T3_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
				$T3_R1_BF = $T3_R1[0]->RADAR1;

				echo $T3_R1_BF . "%";
				?>
			</td>
		</tr>
		<tr>
			<td>Percentage of Filling (DP Side) </td>
			<td align="right">
				<?php
				$T3_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
				$T3_R2_BF = $T3_R2[0]->RADAR2;

				echo $T3_R2_BF . "%";
				?></td>
		</tr>
		<tr>
			<td>Torpedo Number (CR Side) </td>
			<td align="right"> <?php
								$T3_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
								$T3_CP_BF = $T3_CP[0]->CP;

								echo $T3_CP_BF;
								?>
			</td>
		</tr>
		<tr>
			<td>Torpedo Number (DP Side) </td>
			<td align="right">
				<?php
				$T3_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
				$T3_DP_BF = $T3_DP[0]->DP;
				echo $T3_DP_BF;
				?>
			</td>
		</tr>
	</table>
	<table class="table table-taphole">
		<tr>
			<th colspan="2" class="text-center">Taphole-4</th>
		</tr>
		<tr>
			<td>Percentage of Filling (CR Side) </td>
			<td align="right">
				<?php
				$T4_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
				$T4_R1_BF = $T4_R1[0]->RADAR1;

				echo $T4_R1_BF . "%";
				?>
			</td>
		</tr>
		<tr>
			<td>Percentage of Filling (DP Side) </td>
			<td align="right">
				<?php
				$T4_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
				$T4_R2_BF = $T4_R2[0]->RADAR2;

				echo $T4_R2_BF . "%";
				?></td>
		</tr>
		<tr>
			<td>Torpedo Number (CR Side) </td>
			<td align="right"> <?php
								$T4_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
								$T4_CP_BF = $T4_CP[0]->CP;

								echo $T4_CP_BF;
								?>
			</td>
		</tr>
		<tr>
			<td>Torpedo Number (DP Side) </td>
			<td align="right">
				<?php
				$T4_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
				$T4_DP_BF = $T4_DP[0]->DP;
				echo $T4_DP_BF;
				?>
			</td>
		</tr>
	</table>


</div>
<div class="tap_hole1">
	<!--<span style="color:red">Empty Torpedo Signal Alerts:</span> -->
	<table class="table table-taphole1">

		<tr>
			<th class="text-center">TrackID</th>
			<th class="text-center">Empty Torpedo Signal Time</th>
			<th class="text-center">TLC NO</th>
			<th class="text-left">Plug Out - Plug In</th>
			<th class="text-left">Delay</th>
		</tr>
		<tr>
			<td align="center">1 </td>
			<td align="center"><?php
								$SMS_Track1 = ($this->master_db->runQuerySql("SELECT DATE_FORMAT(reportime,'%d-%m-%Y %H:%i:%s')  as TRACK1 , UNIX_TIMESTAMP(reportime)*1000 as timestamp,is_process as process, lno  as lno FROM  PI_SMS_SIGNAL WHERE id=1"));
								$SMS_Track_1 = $SMS_Track1[0]->TRACK1;
								$track1 = $SMS_Track1[0]->timestamp;
								$signal1 = $SMS_Track1[0]->process;
								$TLC1 = $SMS_Track1[0]->lno;
								echo $SMS_Track_1;

								?> </td>
			<td align="center"><?php echo $TLC1; ?></td>
			<td align="center">


				<script>
					var countDownDate = <?php echo  $track1 ?>;

					var signalp = <?php echo  $signal1 ?>;
					var x;

					if (signalp == 0) {
						// Update the count down every 1 second
						x = setInterval(function() {

							// Get today's date and time
							var now = new Date().getTime();

							// Find the distance between now and the count down date
							var distance = now - countDownDate;

							// Time calculations for days, hours, minutes and seconds
							var days = Math.floor(distance / (1000 * 60 * 60 * 24));
							var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);

							if (hours < 10) {
								hours = "0" + hours;
							}
							if (minutes < 10) {
								minutes = "0" + minutes;
							}
							if (seconds < 10) {
								seconds = "0" + seconds;
							}


							// Output the result in an element with id="demo"
							document.getElementById("demo").innerHTML = hours + ":" + minutes + ":" + seconds + "";



						}, 1000);
					} else {
						clearInterval(x);
					}
				</script>

				<?php if ($signal1 == 0) { ?>
					<p id="demo"></p>
				<?php } ?>
			</td>


			<td align="center">


				<script>
					var countDownDate = <?php echo  $track1 ?>;

					var signalp = <?php echo  $signal1 ?>;
					var x11;

					if (signalp == 0) {
						// Update the count down every 1 second
						x11 = setInterval(function() {

							// Get today's date and time
							var now = new Date().getTime();

							// Find the distance between now and the count down date
							var distance = now - countDownDate - 1200000;

							// Time calculations for days, hours, minutes and seconds
							var days = Math.floor(distance / (1000 * 60 * 60 * 24));
							var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);

							if (hours < 10) {
								hours = "0" + hours;
							}
							if (minutes < 10) {
								minutes = "0" + minutes;
							}
							if (seconds < 10) {
								seconds = "0" + seconds;
							}

							if (distance > 0)

							{
								document.getElementById("demo11").innerHTML = "  " + hours + ":" + minutes + ":" + seconds + "";
							} else {
								document.getElementById("demo11").innerHTML = "";
							}



						}, 1000);
					} else {
						clearInterval(x11);
					}
				</script>
				<?php if ($signal1 == 0) { ?>
					<p id="demo11"></p>
				<?php } ?>
			</td>

		</tr>
		<tr>
			<td align="center">2 </td>
			<td align="center"><?php
								$SMS_Track2 = ($this->master_db->runQuerySql("SELECT DATE_FORMAT(reportime,'%d-%m-%Y %H:%i:%s') as TRACK2, UNIX_TIMESTAMP(reportime)*1000 as timestamp,is_process as process2, lno  as lno FROM  PI_SMS_SIGNAL WHERE id=2"));
								$SMS_Track_2 = $SMS_Track2[0]->TRACK2;
								$track2 = $SMS_Track2[0]->timestamp;
								$signal2 = $SMS_Track2[0]->process2;
								$TLC2 = $SMS_Track2[0]->lno;
								echo $SMS_Track_2;
								?></td>
			<td align="center"><?php echo $TLC2; ?></td>
			<td align="center">


				<script>
					var countDownDate1 = <?php echo  $track2 ?>

					var signalp1 = <?php echo  $signal2 ?>;
					var x1;

					if (signalp1 == 0) {

						// Update the count down every 1 second
						x1 = setInterval(function() {

							// Get today's date and time
							var now1 = new Date().getTime();

							// Find the distance between now and the count down date
							var distance1 = now1 - countDownDate1;

							// Time calculations for days, hours, minutes and seconds
							var days1 = Math.floor(distance1 / (1000 * 60 * 60 * 24));
							var hours1 = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes1 = Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60));
							var seconds1 = Math.floor((distance1 % (1000 * 60)) / 1000);
							if (hours1 < 10) {
								hours1 = "0" + hours1;
							}
							if (minutes1 < 10) {
								minutes1 = "0" + minutes1;
							}
							if (seconds1 < 10) {
								seconds1 = "0" + seconds1;
							}

							// Output the result in an element with id="demo"
							document.getElementById("demo1").innerHTML = "  " + hours1 + ":" + minutes1 + ":" + seconds1 + "";


						}, 1000);

					} else {
						// Output the result in an element with id="demo"


						clearInterval(x1);
					}
				</script>
				<?php if ($signal2 == 0) { ?>
					<p id="demo1"></p>
				<?php } ?>
			</td>


			<td align="center">


				<script>
					var countDownDate21 = <?php echo  $track2 ?>

					var signalp21 = <?php echo  $signal2 ?>;
					var x22;

					if (signalp21 == 0) {

						// Update the count down every 1 second
						x22 = setInterval(function() {

							// Get today's date and time
							var now2 = new Date().getTime();

							// Find the distance between now and the count down date
							var distance21 = now2 - countDownDate21 - 1200000;

							// Time calculations for days, hours, minutes and seconds
							var days21 = Math.floor(distance21 / (1000 * 60 * 60 * 24));
							var hours21 = Math.floor((distance21 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes21 = Math.floor((distance21 % (1000 * 60 * 60)) / (1000 * 60));
							var seconds21 = Math.floor((distance21 % (1000 * 60)) / 1000);

							if (hours21 < 10) {
								hours21 = "0" + hours21;
							}
							if (minutes21 < 10) {
								minutes21 = "0" + minutes21;
							}
							if (seconds21 < 10) {
								seconds21 = "0" + seconds21;
							}
							if (distance21 > 0) {
								document.getElementById("demo22").innerHTML = hours21 + ":" + minutes21 + ":" + seconds21 + "";

							} else {
								document.getElementById("demo22").innerHTML = "";
							}


							// Output the result in an element with id="demo"



						}, 1000);

					} else {
						// Output the result in an element with id="demo"


						clearInterval(x22);
					}
				</script>
				<?php if ($signal2 == 0) { ?>
					<p id="demo22"></p>
				<?php } ?>
			</td>
		</tr>

	</table>
</div>