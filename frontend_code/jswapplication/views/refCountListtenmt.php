<?php $active=$this->uri->segment(1);
$active1=$this->uri->segment(2);?>
 

<li role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>Total Circulation</strong> <span class="count ornnew_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 order by lm.id"));?></span></li>
            <?php if(count($resLadle)){?>
                <div class="collapse" id="collapseExample">
                  <div class="well">
                  <?php foreach ($resLadle as $r){
                  		if($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202){
                  	?>
                    <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span><?php echo $r->ladleno;?></span></li>
				  <?php }
                  else{?>
                  	<li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span><?php echo $r->ladleno;?></span></li>
                  <?php }
                  }?>
                  </div>
                </div>
                <?php }?>
     <li  role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2"><strong>Maintenance</strong> <span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid = 95 order by lm.id"));?></span></li>
              <?php if(count($resmain)){?>
                <div class="collapse" id="collapseExample2">
                  <div class="well">
                  <?php foreach ($resmain as $r2){ ?>
                  	
                  	<li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname;?></span></li>
                  <?php  
                  }?>
                  </div>
                </div>
                <?php }?>
               
			    <li><strong>Loads</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1  and companyid = 95 "));?></span></li>
   <ol> <li><strong>Before Weighment</strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/LGreen/1.png" /><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1   and companyid = 95 "));?></span></li>
            <li><strong>After Weighment&nbsp;&nbsp;&nbsp;</strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/Green/1.png" /><span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1  and companyid = 95 "));?></span></li></ol>
           
		  <li><strong>Hot Metal on Wheel</strong> <span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");echo $tot[0]->NET_WEIGHT;?></span></li>
              <li><strong>Empty</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1  and companyid = 95 "));?></span></li>
           <ol>  <li><strong>Steel Zone</strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/LRed/1.png" /> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 "));?></span></li>
            <li><strong>Iron Zone&nbsp;&nbsp; </strong> <img src="http://dtrack.jsw.in//jswl/assets/direction_icons1/Red/1.png" /> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1  and companyid = 95 "));?></span></li></ol>  
               <li><strong>SMS PROD (10PM to 10PM)</strong> <span class="count pink_c monospace" onclick="getSMSData1()"><?php $actual = $this->sms_db->getActualProduction(date("Y-m-d"));?>
            <?php if(count($actual) && $actual[0]->BF_PRODA != null){ echo $actual[0]->BF_PRODA; }else{ echo 0;}?></span></li>