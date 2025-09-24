
  <div class="header">
  <header class="header1">
    <div class="header_in">
      <button type="button" class="toggle" id="toggle">
        <span></span>
      </button>
    </div>
  </header>

  <div class="sidebar" id='sidebar'>
    <ul>
      <li><?php if ($detail[0]->udashboard == 1) { ?><a href="<?php echo base_url() ?>dashboard" class="<?php if ($active == 'dashboard') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> DASHBOARD</a><?php } ?></li>
      <!--   <li><?php if ($detail[0]->tenmt == 1) { ?><a href="<?php echo base_url() ?>tenmt" class="<?php if ($active == '' || $active == 'tenmt') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> SMS</a><?php } ?></li> -->
      <li><?php if ($detail[0]->ufleetview == 1) { ?>
          <button class="dropdown-btn"><a href="#" class="<?php if ($active == 'lists') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> LIST</a>

          </button>
          <div class="dropdown-container">
            <a href="<?php echo base_url() ?>lists/index">BLAST FURNACE</a>
            <a href="<?php echo base_url() ?>sms/index">SMS</a>
          </div>
        <?php } ?>
      </li>

      <li> <?php if ($detail[0]->ureports == 1) { ?><a href="<?php echo base_url() ?>reports" class="<?php if ($active == 'reports') echo 'active'; ?>"><i class="fa fa-flag" aria-hidden="true"></i> REPORTS</a><?php } ?></li>

      <li><?php if ($detail[0]->companyid == 95) { ?>
          <?php if ($detail[0]->uconfig == 1) { ?>
            <button class="dropdown-btn"><a href="#" class="<?php if ($active == 'maintenance') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> MAINTENANCE</a>

            </button>
            <div class="dropdown-container">
              <a href="<?php echo base_url() ?>maintenance/index">MAINTENANCE DETAILS</a>
              <a href="<?php echo base_url() ?>maintenance/breakdown">BREAKDOWN DETAILS</a>
              <a href="<?php echo base_url() ?>maintenance/delay">LOGISTIC ISSUES DETAILS</a>
              <a href="<?php echo base_url() ?>maintenance/inspectionDetails">INSPECTION DETAILS</a>
              <a href="<?php echo base_url() ?>maintenance/cleaningDumpDetails">CLEANING & DUMPING DETAILS</a>
            </div>
          <?php } ?>
        <?php } ?>
      </li>
      <li> <?php if ($detail[0]->companyid == 95) { ?>
          <?php if ($detail[0]->uoperations == 1) { ?>
            <button class="dropdown-btn"><a href="#" class="<?php if ($active == 'operations') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> OPERATIONS</a>

            </button>
            <div class="dropdown-container">
              <a href="<?php echo base_url() ?>operations/cycling_noncycling">CIRCULATION / NON CIRCULATION</a>
              <a href="<?php echo base_url() ?>operations/geofence_track">CREATE TRACK</a>
              <a href="<?php echo base_url() ?>operations/carBattery">BATTERY STATUS</a>
              <a href="<?php echo base_url() ?>operations/ladleload">LADLE LOAD COUNT</a>
              <a href="<?php echo base_url() ?>operations/service">NEXT SERVICE</a>
              <a href="<?php echo base_url() ?>operations/master">MASTER ENTRY</a>
            </div>
          <?php } ?>
        <?php } ?>
      </li>


      <li> <?php if ($active == '' || $active == 'dashboard') { //only dashboard
            ?>
          <button class="dropdown-btn" onclick="getAlertsData()"><a href="#" class="<?php if ($active == 'notification') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> NOTIFICATION</a>
          </button>

        <?php } ?>
      </li>
    </ul>
  </div>
  <!-- <div style="float: left;width: 0%;"><img src="<?php echo base_url() ?>assets/images/logo.png" alt="Logo image">
    </div> -->
  <!--  <img src="<?php echo base_url() ?>assets/images/logo.png" alt="Logo image">
-->
  <span class="loggingout"><span class="log_b">
      <a href="<?php echo base_url() ?>dashboard/logout"><i class="fa fa-power-off" aria-hidden="true"></i></a>
    </span>
  </span>

  <?php if ($active == '' || $active == 'dashboard') { //only dashboard
  ?>
    <span class="circulation4">

      <li>
        <div class="frmSearch">
          <input type="text" id="search-box" placeholder="Search By Ladle" />
          <div id="suggesstion-box"></div>

        </div>

      </li>

    </span>

    <span class="circulationnew"><span class="cir_bnew">Circulation</span>

      <button class="button1" onclick="getTaphole()">Taphole</button>
      <button class="button2" onclick="getproductiondetails()">Load</button>


      <ul id="refCount">
        <?php /*echo $refCountList; */ ?>
        <div class="tap_holenew">
          <!--<span style="color:red">Empty Torpedo Signal Alerts:</span> -->
          <table class="table table-tapholenew">

            <tr>
              <th class="text-center">Parameters &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Total</th>
              <th class="text-center">PhaseI</th>
              <th class="text-left">PhaseII</th>
            </tr>
            <tr>
              <td align="center">
                <li role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>Total Circulation</strong> <span class="count ornnew_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 order by lm.id ")); ?></span></li>
                <?php if (count($resLadle)) { ?>
                  <div class="collapse" id="collapseExample">
                    <div class="well">
                      <?php foreach ($resLadle as $r) {
                        if ($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202) {
                      ?>
                          <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
                        <?php } else { ?>
                          <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
                      <?php }
                      } ?>
                    </div>
                  </div>
                <?php } ?>
              </td>

              <td align="center"><span class="count ornnew_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='1' order by lm.id ")); ?></span> </td>
              <td align="center"><span class="count ornnew_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='2' order by lm.id ")); ?></span></td>

            </tr>
            <tr>
              <td align="center">
                <li role="button" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1"><strong>LOCO</strong> <span class="count blue_c monospace"><?php echo count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 order by unitname ")); ?></span></li>
                <?php if (count($resLoco)) { ?>
                  <div class="collapse" id="collapseExample1">
                    <div class="well">
                      <?php foreach ($resLoco as $r1) { ?>

                        <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span><?php echo $r1->unitname; ?></span></li>
                      <?php
                      } ?>
                    </div>
                  </div>
                <?php } ?>
              </td>
              <td align="center"><span class="count blue_c monospace"><!-- <?php echo count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 and phase='1' order by unitname ")); ?> -->4</span></td>
              <td align="center"><span class="count blue_c monospace"><!-- <?php echo count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95  and phase='2' order by unitname ")); ?> -->4</span></td>
            </tr>
            <tr>
              <td align="center">
                <li role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2"><strong>Maintenance</strong> <span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 order by lm.id")); ?></span></li>
                <?php if (count($resmain)) { ?>
                  <div class="collapse" id="collapseExample2">
                    <div class="well">
                      <?php foreach ($resmain as $r2) { ?>

                        <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname; ?></span></li>
                      <?php
                      } ?>
                    </div>
                  </div>
                <?php } ?>
              </td>
              <td align="center"><span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='1' order by lm.id")); ?></span></td>
              <td align="center"><span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='2' order by lm.id")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Loads</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 ")); ?></span></li>
              </td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 and phase='1'")); ?></span></td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 and phase='2'")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Before Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95  ")); ?></span></li>
              </td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95 and phase='1' ")); ?></span></td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95  and phase='2'")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>After Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95   ")); ?></span></li>
                </li>
              </td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='1' ")); ?></span></td>
              <td align="center"><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='2' ")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Hot Metal on Wheel</strong> <span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                                                              echo $tot[0]->NET_WEIGHT; ?></span></li>
              </td>
              <td align="center"><span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 and phase='1'");
                                                                      echo $tot[0]->NET_WEIGHT; ?></span></td>
              <td align="center"><span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='2'");
                                                                      echo $tot[0]->NET_WEIGHT; ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Empty</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95  ")); ?></span></li>
              </td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95 and phase='1' ")); ?></span></td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95 and phase='2' ")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Steel Zone</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 ")); ?></span></li>
              </td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 and phase='1'")); ?></span></td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 and phase='2' ")); ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li><strong>Iron Zone</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 ")); ?></span></li>
              </td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 and phase='1'")); ?></span></td>
              <td align="center"><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 and phase='2'")); ?></span></td>
            </tr>

            <tr>
              <td align="center">
                <li role="button" data-toggle="modal"><strong>BF PRODUCTION</strong> <span class="count brown_c monospace" onclick="getBfProduction()" ;><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                                                                                                                          echo $bf[0]->BF_PROD; ?></span></li>
              </td>
              <td align="center"><span class="count brown_c monospace"><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=1"));
                                                                        echo $bf[0]->BF_PROD; ?></span></td>
              <td align="center"><span class="count brown_c monospace"><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=2"));
                                                                        echo $bf[0]->BF_PROD; ?></span></td>
            </tr>
            <tr>
              <td align="center">
                <li role="button" data-toggle="modal"><strong>SMS Received </strong> <span class="count brown_c monospace" onclick="getSmsMetal()" ;>
                    <?php
                    $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                    $res_bf = $bf[0]->BF_PROD;
                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                    $res_tot = $tot[0]->NET_WEIGHT;

                    $result_sms = $res_bf - $res_tot;
                    echo $result_sms;
                    ?>
                  </span></li>
              </td>
              <td align="center"><span class="count brown_c monospace"> <?php
                                                                        $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); ?></span></td>
              <td align="center"><span class="count brown_c monospace"><?php
                                                                        $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); ?></span></td>
    </span></td>
    </tr>
    </ul>
    </table>

</div>
</span>
<?php } ?>


<?php if ($active == '' || $active == 'tenmt') { //only dashboard
?>
<span class="circulation"><span class="cir_b">Circulation</span>
  <ul id="refCount">
    <?php /*echo $refCountList; */ ?>

    <li role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>Total Circulation</strong> <span class="count ornnew_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = $compny order by lm.id")); ?></span></li>

    <?php if (count($resLadle)) { ?>
      <div class="collapse" id="collapseExample">
        <div class="well">
          <?php foreach ($resLadle as $r) {
            if ($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202) {
          ?>
              <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
            <?php } else { ?>
              <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
          <?php }
          } ?>
        </div>
      </div>
    <?php } ?>
    <li role="button" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1"><strong>LOCO</strong> <span class="count blue_c monospace"><?php echo count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 order by unitname ")); ?></span></li>
    <?php if (count($resLoco)) { ?>
      <div class="collapse" id="collapseExample1">
        <div class="well">
          <?php foreach ($resLoco as $r1) { ?>

            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span><?php echo $r1->unitname; ?></span></li>
          <?php
          } ?>
        </div>
      </div>
    <?php } ?>

    <li role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2"><strong>Maintenance</strong> <span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid = $compny order by lm.id")); ?></span></li>
    <?php if (count($resmain)) { ?>
      <div class="collapse" id="collapseExample2">
        <div class="well">
          <?php foreach ($resmain as $r2) { ?>

            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname; ?></span></li>
          <?php
          } ?>
        </div>
      </div>
    <?php } ?>

    <li><strong>Loads</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1  and companyid = $compny ")); ?></span></li>
    <ol>
      <li><strong>Before Weighment </strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/LGreen/1.png" /> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1   and companyid = $compny ")); ?></span></li>
      <li><strong>After Weighment&nbsp;&nbsp;&nbsp;</strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/Green/1.png" /><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1  and companyid = $compny ")); ?></span></li>
    </ol>
    <li><strong>Hot Metal on Wheel</strong> <span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = $compny ");
                                                                                  echo $tot[0]->NET_WEIGHT; ?></span></li>
    <li><strong>Empty</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1  and companyid = $compny ")); ?></span></li>
    <ol>
      <li><strong>Steel Zone</strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/LRed/1.png" /> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = $compny ")); ?></span></li>
      <li><strong>Iron Zone&nbsp;&nbsp; </strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/Red/1.png" /><span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1  and companyid = $compny ")); ?></span></li>
    </ol>
    <li><strong>SMS PROD (10PM to 10PM)</strong> <span class="count pink_c monospace" onclick="getSMSData1()"><?php $actual = $this->sms_db->getActualProduction(date("Y-m-d")); ?>
        <?php if (count($actual) && $actual[0]->BF_PRODA != null) {
          echo $actual[0]->BF_PRODA;
        } else {
          echo 0;
        } ?></span></li>

    <li role="button" data-toggle="modal"><strong>Notifications</strong> <span class="count pink_c monospace" onclick="getAlertsData()" ;>
        <?php echo count($this->master_db->runQuerySql("SELECT id FROM ladle_master where servicedate<=CURDATE() AND servicedate!='0000-00-00' and companyid = 95 LIMIT 1")); ?></span></li>

  </ul>
</span>
<?php } ?>

<?php if ($active == 'fivemt' && $active != 'dashboard') { //only dashboard
?>
<span class="circulation"><span class="cir_b">Circulation</span>
  <ul id="refCount">
    <?php /*echo $refCountList; */ ?>

    <li role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>Total Circulation</strong> <span class="count orn_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("select LOAD_STATUS, id, ladleno from ladle_master where 1 and cycle=1 and companyid = 93 ")); ?></span></li>
    <?php if (count($resLadle)) { ?>
      <div class="collapse" id="collapseExample">
        <div class="well">
          <?php foreach ($resLadle as $r) {
            if ($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202) {
          ?>
              <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
            <?php } else { ?>
              <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span><?php echo $r->ladleno; ?></span></li>
          <?php }
          } ?>
        </div>
      </div>
    <?php } ?>
    <li><strong>Loads</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1  and companyid = 93 ")); ?></span></li>
    <li><strong>Before Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1   and companyid = 93 ")); ?></span></li>
    <li><strong>After Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1  and companyid = 93 ")); ?></span></li>
    <li><strong>Hot Metal on Wheel</strong> <span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 93 ");
                                                                                  echo $tot[0]->NET_WEIGHT; ?></span></li>
    <li><strong>Empty</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1  and companyid = 93 ")); ?></span></li>
    <li><strong>Steel Zone</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 93 ")); ?></span></li>
    <li><strong>Iron Zone</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1  and companyid = 93 ")); ?></span></li>
  </ul>
</span>
<?php } ?>





<?php if ($active1 == "cycling_noncycling") { ?>
<span class="circulation"><span class="cir_b">Circulation</span>
  <ul>
    <li>Total Circulation <span class="count gren_c"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where 1 and cycle=1 and companyid=$compny ")); ?></span></li><?php /*LOAD_STATUS is NOT NULL */ ?>
    <li>Total Non Circulation <span class="count orn_c"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where 1 and cycle=0  and companyid=$compny ")); ?></span></li>
  </ul>
</span>
<?php } ?>






<!-- 

<button data-toggle="modal" data-target="#errorModal7" style="display: none;" id="alertbox7"></button>
<div class="modal fade" id="errorModal7" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel7">
<div class="modal-dialog" role="document" style="width: 493px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="errorModalLabel7">Taphole details</h4>
    </div>
    <div class="modal-body">
      <p id="error-msg7"></p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>

    </div>
  </div>
</div>
</div>
-->



<!-- I & II Phase Load Alerts -->
<!-- <button data-toggle="modal" data-target="#errorModal6" style="display: none;" id="alertbox6"></button>
<div class="modal fade" id="errorModal6" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel6">
<div class="modal-dialog" role="document" style="width: 255px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="errorModalLabel6">I & II Phase Load Details</h4>
    </div>
    <div class="modal-body">
      <p id="error-msg6"></p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>

    </div>
  </div>
</div>
</div> -->