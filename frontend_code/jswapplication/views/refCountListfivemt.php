<?php $active=$this->uri->segment(1);
$active1=$this->uri->segment(2);?>


<li role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>Total Circulation</strong> <span class="count orn_c monospace"><?php echo count($resLadle = $this->master_db->runQuerySql("select LOAD_STATUS, id, ladleno from ladle_master where 1 and cycle=1 and companyid = 93 "));?></span></li>
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
            <li><strong>Loads</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 93 "));?></span></li>
            <li><strong>Before Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1   and companyid = 93 "));?></span></li>
            <li><strong>After Weighment</strong> <span class="count gren_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1  and companyid = 93 "));?></span></li>
            <li><strong>Total net wt</strong> <span class="count gren_c monospace"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 93 ");echo $tot[0]->NET_WEIGHT;?></span></li>
            <li><strong>Empty</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1  and companyid = 93 "));?></span></li>
            <li><strong>SMS Side</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 93 "));?></span></li>
            <li><strong>Furnace Side</strong> <span class="count red_c monospace"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1  and companyid = 93 "));?></span></li>