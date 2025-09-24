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

    <style>
        .app-search-topbar input {
    width: 100%;
    height: 40px;
    border: none;
    font-size: 12px;
    border-radius: 4px;
    padding-left: 54px;
    padding-right: 15px;
}
        #map {
            width: 100%;
            height: 100%;
            padding-bottom: 59%;
        }
    </style>

</head>



<body onload="getData();" class="dark-sidenav">

    <?php echo $header; ?>



    <?php $active = $this->uri->segment(1);
    $active1 = $this->uri->segment(2);
    $active2 = $this->uri->segment(3);
    ?>

    <?php echo $updatelogin;
    $uid = $detail[0]->userId;
    $compny = $detail[0]->companyid;
    $language = $detail[0]->language;
    ?>

    <?php $active = $this->uri->segment(1);
    $active1 = $this->uri->segment(2);
    $active2 = $this->uri->segment(3);
    ?>

    <?php echo $updatelogin;
    $uid = $detail[0]->userId;
    $compny = $detail[0]->companyid;
    $language = $detail[0]->language;
    ?>



    <?php echo $updatelogin;
    $uid = $detail[0]->userId;
    $compny = $detail[0]->companyid;
    $language = $detail[0]->language;


    ?>

    <div class="page-content">
        <div class="container-fluid">
            <!-- Page-Title -->
            <!-- end page title end breadcrumb -->
            <div class="row justify-content-center data-f pt-2">
                <div class="col-md-6 col-lg-4">
                    <div class="card report-card card-hover" data-toggle="modal" data-target="#bd-example-modal-xl-tc">
                       <div class="card-body">
                         <div class="row d-flex justify-content-center">
                           <div class="col">
                        <p class="text-dark mb-1 font-weight-semibold">Total Circulation</p>
            <h3 class="my-2"><?php echo count($resLadle1= $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 order by lm.id ")); ?></h3>

            <div class="row">
            <div class="media align-items-center col-6">
             <div class="media-body align-self-center">
             <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
             <div class="d-flex justify-content-between">
             <span>
                <a class="" href="#">
                    <span class="badge badge-pink mb-1"><?php echo count($resLadle2 = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='1' order by lm.id ")); ?></span>
                </a>
                
                  <?php $cirtot= count($resLadle1);?>
                  <?php $cirtot;?>
                  <?php $cirph1=count($resLadle2);?>
                  <?php  $cirph1;?>

                  <?php $totalpro=$cirph1/$cirtot*100;?>
                  <?php $totalpro;?>
                  
                 </span>

            </div>

            <div class="progress mt-0" style="height:3px;">
            <div class="progress-bar bg-pink" role="progressbar" style="width:<?php echo $totalpro;?>%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
              </div>
                 </div>


                  <div class="media align-items-center col-6">
                   <div class="media-body ml-3 align-self-center">
              <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                 <div class="d-flex justify-content-between">
               <span>
                 <a class="" href="#">
             <span class="badge badge-pink mb-1"><?php echo count($resLadle3 = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='2' order by lm.id ")); ?></span>
               </a>
                <?php $cirtot= count($resLadle1);?>
                  <?php $cirph3=count($resLadle3);?>
                  <?php $totalpro3=$cirph3/$cirtot*100;?>
             </span>
        </div>
         <div class="progress mt-0" style="height:3px;">
         <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $totalpro3; ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
                    </div>
                        </div>
                            </div>
                              </div>
                <div class="col-auto align-self-center">
                     <div class="report-main-icon bg-light-alt">
                         <i data-feather="users" class="align-self-center text-muted icon-md"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-6 col-lg-4">
                    <div class="card report-card card-hover" data-toggle="modal" data-target="#bd-example-modal-xl-loco">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                    <p class="text-dark mb-1 font-weight-semibold">LOCO</p>
                   <h3 class="my-2"><?php echo count($resLoco1 = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 order by unitname ")); ?></h3>


        <div class="row">
             <div class="media align-items-center col-6">
                 <div class="media-body align-self-center">
                <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
                 <div class="d-flex justify-content-between">
                 <span>
                <a class="" href="#">
                  <span class="badge badge-purple mb-1"><?php echo count($resLoco2 = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 and phase='1' order by unitname "));?></span>
                </a>
                <?php $resloco1= count($resLoco1);?>
                <!-- <?php echo $resloco1; ?> -->
                  <?php $resLoco2=count($resLoco2);?>
                   <!-- <?php echo $resLoco2; ?> -->
                  <?php $totalloco=$resLoco2/$resloco1*100;?>
               </span>
                 </div>
            <div class="progress mt-0" style="height:3px;">
            <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo $totalloco;?>%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
             </div>
                 </div>


             <div class="media align-items-center col-6">
                 <div class="media-body ml-3 align-self-center">
                 <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                    <div class="d-flex justify-content-between">
                        <span>
                           <a class="" href="#">
                             <span class="badge badge-purple mb-1"><?php echo count($resLoco3 = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95  and phase='2' order by unitname "));?></span>
                           </a>
                <?php $resloco1= count($resLoco1);?>
                <!-- <?php echo $resloco1; ?> -->
                <?php $resLoco3=count($resLoco3);?>
                <!-- <?php echo $resLoco3; ?> -->
                <?php $totalloco4=$resLoco3/$resloco1*100;?>
                        </span>
                    </div>
                <div class="progress mt-0" style="height:3px;">
                <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo $totalloco4;?>%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                </div>
                 </div>
                     </div>
                        </div>
                             </div>
                                 </div>
                                <div class="col-auto align-self-center">
                                    <div class="report-main-icon bg-light-alt">
                                        <i data-feather="clock" class="align-self-center text-muted icon-md"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-6 col-lg-4">
                  <div class="card report-card card-hover" data-toggle="modal" data-target="#bd-example-modal-xl-main">
                    <div class="card-body">
                      <div class="row d-flex justify-content-center">
                        <div class="col">
                          <p class="text-dark mb-1 font-weight-semibold">Maintenance</p>
                          <h3 class="my-2"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 order by lm.id")); ?></h3>



                          <div class="row">
                           <div class="media align-items-center col-6">
                            <div class="media-body align-self-center">
                              <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
                              <div class="d-flex justify-content-between">
                               <span>
                                <a class="" href="#">
                                 <span class="badge badge-warning mb-1"><?php echo count($resmain1 = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='1' order by lm.id")); ?></span>
                               </a>
                  <?php $main1= count($resmain);?>
                  <?php $main1;?>
                  <?php $resmain1=count($resmain1);?>
                  <?php $resmain1;?>

                  <?php $totalmain1=$resmain1/$main1*100;?>
                  <?php $totalmain1;?>
                             </span>

                           </div>
                           <div class="progress mt-0" style="height:3px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $totalmain1; ?>%;"aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>


                      <div class="media align-items-center col-6">
                       <div class="media-body ml-3 align-self-center">
                        <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                        <div class="d-flex justify-content-between">
                          <span>
                            <a class="" href="#">
                              <span class="badge badge-warning mb-1"><?php echo count($resmain3 = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='2' order by lm.id")); ?></span>
                            </a>
                  <?php $main1= count($resmain);?>
                  <?php $main1;?>
                  <?php $resmain3=count($resmain3);?>
                  <?php $resmain3;?>

                  <?php $totalmain3=$resmain3/$main1*100;?>
                  <?php $totalmain3;?>
                          </span>
                        </div>

                        <div class="progress mt-0" style="height:3px;">
                         <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $totalmain3;?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
               <div class="col-auto align-self-center">
                <div class="report-main-icon bg-light-alt">
                  <i data-feather="activity" class="align-self-center text-muted icon-md"></i>
                </div>
              </div>
            </div>
          </div><!--end card-body-->
        </div><!--end card-->
      </div> <!--end col-->

     </div><!--end row-->

    
     <style type="text/css">
      .frmSearch {border: 0px solid #a8d4b1;border-radius:4px;}
      #unit-list{float:left;list-style:none;margin-top:-6px;padding:0;width:180px;position: inherit;}
      #unit-list li{padding: 5px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
      #unit-list li:hover{background:#ece3d2;cursor: pointer;}
      #search-box{padding: 20px;border: #a8d4b1 1px solid;border-radius:4px;}
    </style>

            <div class="row">
              <div class="col-lg-9 map-v">
                <div class="card">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <h4 class="card-title">Map View</h4>
                      </div><!--end col-->
                      <div class="col-auto">

                        <div class="app-search-topbar float-left mr-2">
                          <input type="text"  id="search-box" class="srt from-control top-search mb-0" placeholder="Search By Ladle...">
                          <button type="submit"></button>
                          <div id="suggesstion-box"></div>

                        </div>
              <!-- <form action="#" method="get">
               <input type="search" id="search-box" name="search" class="srt from-control top-search mb-0" placeholder="Search here...">
              <div id="suggesstion-box"></div>
              <button type="submit"><i class="ti-search"></i></button>
             </form> -->

                      </div><!--end col-->
                    </div> <!--end row-->
                  </div><!--end card-header-->
                  <div class="card-body p-0">

                    <div id="map"></div>

                  </div><!--end card-body-->
                </div><!--end card-->
              </div> <!--end col-->
                <div class="col-lg-3 Circ">
                    <div class="card">
                      <div class="card-header">
                        <div class="row align-items-center">
                          <div class="col">
                            <h4 class="card-title">Circulation</h4>
                          </div><!--end col-->

                        </div> <!--end row-->
                      </div><!--end card-header-->
       <div class="card-body p-0">
         <div class="table-responsive browser_users">
           <table class="table mb-0">
              <thead class="thead-light">
                <tr>
                  <th class="text-left">Parameters</th>
                   <th class="text-center">Total</th>
                   <th class="text-center">PhaseI</th>
                   <th class="text-center">PhaseII</th>
                </tr>
              </thead>
              <tbody>
        <tr>
        <td>Loads </td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"> <?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 ")); ?></span></td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 and phase='1'")); ?></span></td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (201,202,205) and cycle=1 and companyid = 95 and phase='2'")); ?></span></td>
         </tr>
        <tr>
        <td>Before Weighment
        </td>
        <td class="text-center"> <span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95  ")); ?></span></td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95 and phase='1' ")); ?></span></td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=201 and cycle=1 and companyid = 95  and phase='2'")); ?></span></td>
        </tr>
        <tr>
        <td> After Weighment </td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95   ")); ?></span></td>
        <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='1' ")); ?></span></td>
       <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='2' ")); ?></span></td>
       </tr>
       <tr>
       <td> Hot Metal on Wheel </td>
       <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");                                    
        echo count($tot[0]->NET_WEIGHT); ?></span></td>
       <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 and phase='1'");
       echo count($tot[0]->NET_WEIGHT); ?></span>
       </td>
      <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='2'");
       echo count($tot[0]->NET_WEIGHT); ?></span></td>
      </tr>
       <tr>
        <td>Empty </td>
        <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95  ")); ?></span></td>
        <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95 and phase='1' ")); ?></span></td>
        <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS IN (203,204) and cycle=1 and companyid = 95 and phase='2' ")); ?></span></td>
       </tr>
      <tr>
      <td>Steel Zone </td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 ")); ?></span></td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 and phase='1'")); ?></span></td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=203 and cycle=1  and companyid = 95 and phase='2' ")); ?></span></td>
      </tr>
      <tr>
      <td>Iron Zone </td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 ")); ?></span></td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 and phase='1'")); ?></span></td>
      <td class="text-center"><span class="count red_c monospace badge badge-danger"><?php echo count($this->master_db->runQuerySql("select id from ladle_master where LOAD_STATUS=204 and cycle=1 and companyid = 95 and phase='2'")); ?></span></td>
      </tr>
                                  </tbody>
                                </table>
                            </div>

                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->




            <div class="modal fade bd-example-modal-xl-tc" id="bd-example-modal-xl-tc" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">Total Circulation</h6>
                             
                        </div><!--end modal-header-->
                        <div class="modal-body">


                            <table class="table table-bordered">
                                <thead class="thead-light rth">
                                    <tr>
                                        <th>Phase - I</th>
                                        <th>Phase - II</th>
                                    </tr>
                                </thead>
                                <tr>
  <td><?php  count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='1' order by lm.id "));?>
          <?php if(count($resLadle)){?>        
            <ul class="well">
            <?php foreach ($resLadle as $r){
              if($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202){
              ?>
            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 03 -&gt;At Tap Hole 3 </span></li>
            <?php }
            else
            {?>
            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 05 -&gt;At SMS </span></li>
            <?php }
             }?>
             </ul>
            <?php }?>
            </td>
  <td><?php count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='2' order by lm.id "));?>
            <?php if(count($resLadle)){?>        
            <ul class="well">
              <?php foreach ($resLadle as $r){
                if($r->LOAD_STATUS == 201 || $r->LOAD_STATUS == 202){
               ?>
            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 03 -&gt;At Tap Hole 3 </span></li>
            <?php }
              else{?>
            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 05 -&gt;At SMS </span></li>
            <?php }
            }?>
             </ul>
              <?php }?>
            </td>
            </tr>
            </table>
                  </div><!--end modal-body-->
                      <div class="modal-footer">
                          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->





<div class="modal fade bd-example-modal-xl-loco" id="bd-example-modal-xl-loco" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title m-0" id="myExtraLargeModalLabel">LOCO</h6>
                  </div><!--end modal-header-->
                  <div class="modal-body">
                    <table class="table table-bordered">
                      <thead class="thead-light rth">
                        <tr>
                          <th>Phase - I</th>
                          <th>Phase - II</th>
                        </tr>
                      </thead>
                      <tr>
  <td><?php count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 and phase='1' order by unitname"));?>
   <?php if(count($resLoco)){?>
      <ul class="well">
        <?php foreach ($resLoco as $r1){ ?>
            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span><?php echo $r1->unitname;?> </span></li>
                <?php  
                  }?>
                </ul>
                <?php }?>
  </td>

   <td><?php count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 and phase='2' order by unitname"));?>
        <?php if(count($resLoco)){?>
         <ul class="well">
            <?php foreach ($resLoco as $r1){ ?>
            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span><?php echo $r1->unitname;?> </span></li>
            <?php  
             }?>
            </ul>
            <?php }?>
    </td>
    </tr>
  </table>

              </div><!--end modal-body-->
                <div class="modal-footer">
                  <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                </div><!--end modal-footer-->
              </div><!--end modal-content-->
            </div><!--end modal-dialog-->
            </div><!--end modal-->


<div class="modal fade bd-example-modal-xl-main" id="bd-example-modal-xl-main" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
           <h6 class="modal-title m-0" id="myExtraLargeModalLabel">Maintenance</h6>
              </div><!--end modal-header-->
                <div class="modal-body">
                  <table class="table table-bordered">
                      <thead class="thead-light rth">
                             <tr>
                              <th>Phase - I</th>
                              <th>Phase - II</th>
                             </tr>
                      </thead>
<tr>
  <td><?php count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='1' order by lm.id"));?>
     <?php if(count($resmain)){?>
        <ul class="well">
          <?php foreach ($resmain as $r2){ ?>
           <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname;?></span></li>
           <?php  
            }?>   
       </ul>
     <?php }?>
      </td>
  <td><?php count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='2' order by lm.id"));?>
      <?php if(count($resmain)){?>
        <ul class="well">
         <?php foreach ($resmain as $r2){ ?>
           <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname;?></span></li>
           <?php  
            }?>   
        </ul>
     <?php }?>
         </td>
           </tr>
            </table>
           </div><!--end modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
      </div><!--end modal-footer-->
          </div><!--end modal-content-->
              </div><!--end modal-dialog-->
                 </div><!--end modal-->


<div class="modal fade bd-example-modal-xl-sms" id="bd-example-modal-xl-sms" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
         <h6 class="modal-title m-0" id="myExtraLargeModalLabel">SMS </h6>
        </div><!--end modal-header-->
          <div class="modal-body">
            <div class="chart-demo">
              <div class="pol3"></div>
            </div>

          </div><!--end modal-body-->
          <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
          </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->



            <div class="modal fade bd-example-modal-xl-bfs" id="bd-example-modal-xl-bfs" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">BF PRODUCTION</h6>
                            
                        </div><!--end modal-header-->
                        <div class="modal-body">
                            <div class="chart-demo">
                                <div class="pol4"></div>
                            </div>
                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->


            <div class="modal fade bd-example-modal-xl" id="bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">Tap Hole</h6>
                             
                        </div><!--end modal-header-->
                        <div class="modal-body">

                            <p id="error-msg7">

                            
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
                                        <td>Percentage of Filling (CR Side1111) </td>
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

                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->


            <div class="row mb-2">

                <div class="col-md-4">
                    <div class="card report-card crd-c">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-1 font-weight-semibold">BF Production <small>(10PM to 10PM)</small></p>


                                    <div class="row mt-4 pb-4">
                                        <div class="media align-items-center col-12">

                                            <div class="media-body align-self-center">
     <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
      <div class="d-flex justify-content-between">
     <span>
     <a class="" href="#">
    <span class="badge badge-pink text-white mb-1"><?php $bf1 = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=1"));
    echo ($bf1[0]->BF_PROD); ?></span>
    </a>
    <?php $bf1=$bf1[0]->BF_PROD;?>
    <?php $bfp1=$bf1/10000*100;?>
   </span>
   </div>
    <div class="progress mt-0" style="height:3px;">
    <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $bfp1;?>%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
     </div>
       </div>


  <div class="media align-items-center col-12 mt-4 pt-1">
 <div class="media-body  align-self-center">
   <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
      <div class="d-flex justify-content-between">
         <span>
        <a class="" href="#">
        <span class="badge badge-pink text-white mb-1"><?php $bf2 = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=2"));
        echo ($bf2[0]->BF_PROD); ?></span>
         </a>
         <?php $bf2=$bf2[0]->BF_PROD;?>
         <?php $bfp2=$bf2/10000*100;?>
         </span>

         </div>
         <div class="progress mt-0" style="height:3px;">
        <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $bfp2;?>%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card report-card crd-c">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-1 font-weight-semibold">SMS Received <small> (10PM to 10PM)</small></p>


                                    <div class="row mt-4 pb-4">
                                        <div class="media align-items-center col-12">

                                            <div class="media-body align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
         <a class="" href="#">
         <span class="badge badge-pink text-white mb-1"><?php
         $bf3 = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); 
         echo ($bf3[0]->BF_PROD); ?></span>
        </a>
        <?php $bf3=$bf3[0]->BF_PROD;?>
         <?php $bfp3=$bf3/10000*100;?>
        </span>
        </div>
        <div class="progress mt-0" style="height:3px;">
        <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $bfp3; ?>%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
            </div>
               </div>


        <div class="media align-items-center col-12 mt-4 pt-1">
         <div class="media-body  align-self-center">
            <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                 <div class="d-flex justify-content-between">
                    <span>
                     <a class="" href="#">
                         <span class="badge badge-pink text-white mb-1"><?php
             $bf4 = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); 
             echo ($bf4[0]->BF_PROD); ?> 
             <?php $bf4=$bf4[0]->BF_PROD;?>
             <?php $bfp4=$bf4/10000*100;?>
           </span>
                 </a>
             </span>
         </div>
        <div class="progress mt-0" style="height:3px;">
        <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $bfp4;?>%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
          </div>
                </div>
                   </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-1 font-weight-semibold">BF Production and SMS Receive <small> <?php
               echo date('d M',strtotime("yesterday")); ?> 10PM to <?php echo date('d M',strtotime("today")); 
               ?> 10PM)</small> </p>
                                    <div class="chart-demo">
                                        <div class="pol5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <a name="tapload"></a>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Tap Hole</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <!-- <a href="#" class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#bd-example-modal-xl">
                                                           View Data
                                                       </a> -->

                                    </div>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->


                        <div class="card-body">
                            <!-- <div class="chart-demo">
                                                <div class="pol"></div>
                                            </div>  -->
                            <?php
                            static $track1 = 0;
                            static $track2 = 0;
                            static $signal1 = 1;
                            static $TLC1 = "";
                            static $TLC2 = "";
                            static $signal2 = 1;
                            ?>

<div class="taphole row">
    <div class="col-md-6">
      <table class="table table-bordered table-taphole">
        <thead class="thead-light rth">
          <tr>
            <th class="text-center">Taphole-1</th>
            <th class="text-center">Phase - I</th>
            <th class="text-center">Phase - II</th>
          </tr>
        </thead>
        <tbody>
  <tr>
    <td>Percentage of Filling (CR Side) </td>
      <td align="right">
        <?php
          $T1_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
          $T1_R1_BF = $T1_R1[0]->RADAR1;
          echo $T1_R1_BF . "%";
        ?>
        </td>
    <td align="right">
       % </td>
  </tr>
    <tr>
      <td>Percentage of Filling (DP Side) </td>
        <td align="right">
          <?php
           $T1_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
              $T1_R2_BF = $T1_R2[0]->RADAR2;
             echo $T1_R2_BF . "%";
        ?>
        </td>
      <td align="right">
          % </td>
      </tr>
      <tr>
        <td>Torpedo Number (CR Side) </td>
          <td align="right">
            <?php
              $T1_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
                $T1_CP_BF = $T1_CP[0]->CP;
                echo $T1_CP_BF;
            ?> </td>
        <td align="right">
          </td>
        </tr>
      <tr>
        <td>Torpedo Number (DP Side) </td>
            <td align="right">
              <?php
               $dp = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=1"));
               $DP_bf = $dp[0]->DP;
               echo $DP_bf;
            ?> </td>
        <td align="right">
          </td>
            </tr>
              </tbody>
                </table>
                   </div>
<div class="col-md-6">
    <table class="table table-bordered table-taphole">
      <thead class="thead-light rth">
        <tr>
          <th class="text-center">Taphole-2</th>
          <th class="text-center">Phase - I</th>
          <th class="text-center">Phase -II</th>
        </tr>

      </thead>
        <tbody>
          <tr>
          <td>Percentage of Filling (CR Side) </td>
          <td align="right">
            <?php
            $T2_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
            $T2_R1_BF = $T2_R1[0]->RADAR1;

            echo $T2_R1_BF . "%";
            ?> </td>
            <td align="right">
            % </td>
          </tr>
          <tr>
            <td>Percentage of Filling (DP Side) </td>
            <td align="right">
              <?php
              $T2_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
              $T2_R2_BF = $T2_R2[0]->RADAR2;

              echo $T2_R2_BF . "%";
              ?></td>
              <td align="right">
              % </td>
            </tr>
            <tr>
              <td>Torpedo Number (CR Side) </td>
              <td align="right">
                <?php
                $T2_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
                $T2_CP_BF = $T2_CP[0]->CP;

                echo $T2_CP_BF;
                ?> </td>
                <td align="right">
                </td>
              </tr>
              <tr>
                <td>Torpedo Number (DP Side) </td>
                <td align="right">
                  <?php
                  $T2_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=2"));
                  $T2_DP_BF = $T2_DP[0]->DP;
                  echo $T2_DP_BF;
                  ?> </td>
                  <td align="right">
                  </td>
                </tr>
              </tbody>
              </table>
                </div>
                <div class="col-md-6">

                  <table class="table table-bordered table-taphole">
                    <thead class="thead-light rth">
                      <tr>
                        <th class="text-center">Taphole-3</th>
                        <th class="text-center">Phase - I</th>
                        <th class="text-center">Phase - II</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td>Percentage of Filling (CR Side) </td>
                        <td align="right">
                          <?php
                          $T3_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
                          $T3_R1_BF = $T3_R1[0]->RADAR1;

                          echo $T3_R1_BF . "%";
                          ?> </td>
                          <td align="right">
                          % </td>
                        </tr>
                        <tr>
                          <td>Percentage of Filling (DP Side) </td>
                          <td align="right">
                            <?php
                            $T3_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
                            $T3_R2_BF = $T3_R2[0]->RADAR2;

                            echo $T3_R2_BF . "%";
                            ?></td>
                            <td align="right">
                            % </td>
                          </tr>
                          <tr>
                            <td>Torpedo Number (CR Side) </td>
                            <td align="right"> <?php
                            $T3_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
                            $T3_CP_BF = $T3_CP[0]->CP;

                            echo $T3_CP_BF;
                            ?> </td>
                            <td align="right"> </td>
                          </tr>
                          <tr>
                            <td>Torpedo Number (DP Side) </td>
                            <td align="right">
                              <?php
                              $T3_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=3"));
                              $T3_DP_BF = $T3_DP[0]->DP;
                              echo $T3_DP_BF;
                              ?> </td>
                              <td align="right"> </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-bordered table-taphole">
                          <thead class="thead-light rth">
                            <tr>
                              <th class="text-center">Taphole-4</th>
                              <th class="text-center">Phase - I</th>
                              <th class="text-center">Phase - II</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr>
                              <td>Percentage of Filling (CR Side) </td>
                              <td align="right">
                                <?php
                                $T4_R1 = ($this->master_db->runQuerySql("SELECT RADAR1 as RADAR1 FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
                                $T4_R1_BF = $T4_R1[0]->RADAR1;

                                echo $T4_R1_BF . "%";
                                ?> </td>
                                <td align="right">
                                % </td>
                              </tr>
                              <tr>
                                <td>Percentage of Filling (DP Side) </td>
                                <td align="right">
                                  <?php
                                  $T4_R2 = ($this->master_db->runQuerySql("SELECT RADAR2 as RADAR2 FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
                                  $T4_R2_BF = $T4_R2[0]->RADAR2;

                                  echo $T4_R2_BF . "%";
                                  ?></td>
                                  <td align="right">
                                  % </td>
                                </tr>
                                <tr>
                                  <td>Torpedo Number (CR Side) </td>
                                  <td align="right"> <?php
                                  $T4_CP = ($this->master_db->runQuerySql("SELECT CP as CP FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
                                  $T4_CP_BF = $T4_CP[0]->CP;

                                  echo $T4_CP_BF;
                                  ?> </td>
                                  <td align="right"> </td>
                                </tr>
                                <tr>
                                  <td>Torpedo Number (DP Side) </td>
                                  <td align="right">
                                    <?php
                                    $T4_DP = ($this->master_db->runQuerySql("SELECT DP as DP FROM  PI_DASHBOARD_NEW WHERE tap_hole=4"));
                                    $T4_DP_BF = $T4_DP[0]->DP;
                                    echo $T4_DP_BF;
                                    ?> </td>
                                    <td align="right"> </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="tap_hole1">
                            <!--<span style="color:red">Empty Torpedo Signal Alerts:</span> -->
                            <table class="table table-bordered table-taphole1">
                             <thead class="thead-light rth">
                              <tr>
                                <th class="text-center">TrackID</th>
                                <th class="text-center">Empty Torpedo Signal Time</th>
                                <th class="text-center">TLC NO</th>
                                <th class="text-center">Plug Out - Plug In</th>
                                <th class="text-center">Delay</th>
                              </tr>
                            </thead>

                            <tbody>
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

                                              </tbody>
                                            </table>
                                          </div>

                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->



                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Load</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <!-- <div class="dropdown">
                                                        <a href="#" class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#bd-example-modal-xl-load">
                                                           View Data
                                                        </a>



                                                         
                                                    </div>   -->
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->



                        <div class="card-body">
                            <!-- <div class="chart-demo">
                                                <div  class="pol1"></div>
                                            </div>    -->


                            <div class="taphole">

                                <table class="table table-bordered table-taphole">

                                    <thead class="thead-light rth">
                                        <tr>
                                            <th colspan="4" class="text-center">Production rate(T/Hr)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">BF1</td>
                                            <td><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE SOURCE='BF1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                echo $bf[0]->BF_PROD; 
                                               
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">BF2</td>
                                            <td><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE SOURCE='BF2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                echo $bf[0]->BF_PROD; ?></td>
                                        </tr>
                                    </tbody>
                                    <thead class="thead-light rth">
                                        <tr>
                                            <th colspan="4" class="text-center">Consumption rate(T/Hr)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">SMS1</td>
                                            <td><?php
                                                $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                $res_bf = $bf[0]->BF_PROD;
                                                $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                $res_tot = $tot[0]->NET_WEIGHT;

                                                $result_sms = $res_bf - $res_tot;
                                                echo $result_sms;
                                                ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">SMS2</td>
                                            <td><?php
                                                $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                $res_bf = $bf[0]->BF_PROD;
                                                $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                $res_tot = $tot[0]->NET_WEIGHT;

                                                $result_sms = $res_bf - $res_tot;
                                                echo $result_sms;
                                                ?> </td>
                                        </tr>
                                    </tbody>
                                    <thead class="thead-light rth">

                                        <tr>
                                            <th colspan="4" class="text-center">Load Status</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>WB I</td>
                                        <td>TIC no-<?php
                                                    $bf = ($this->master_db->runQuerySql("SELECT count(ladleid)  BF_PROD   FROM laddle_report WHERE WB_NO='1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                    $res_bf = $bf[0]->BF_PROD;
                                                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                    $res_tot = $tot[0]->NET_WEIGHT;

                                                    $result_sms = $res_bf - $res_tot;
                                                    echo $result_sms;
                                                    ?> </td>
                                        <td>Tons-<?php
                                                    $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE WB_NO='1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                    $res_bf = $bf[0]->BF_PROD;
                                                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                    $res_tot = $tot[0]->NET_WEIGHT;

                                                    $result_sms = $res_bf - $res_tot;
                                                    echo $result_sms;
                                                    ?> </td>
                                    </tr>
                                    <tr>
                                        <td>WB II </td>
                                        <td>TIC no-<?php
                                                    $bf = ($this->master_db->runQuerySql("SELECT count(ladleid)  BF_PROD   FROM laddle_report WHERE WB_NO='2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                    $res_bf = $bf[0]->BF_PROD;
                                                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                    $res_tot = $tot[0]->NET_WEIGHT;

                                                    $result_sms = $res_bf - $res_tot;
                                                    echo $result_sms;
                                                    ?></td>
                                        <td>Tons-<?php
                                                    $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE WB_NO='2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                                                    $res_bf = $bf[0]->BF_PROD;
                                                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                                                    $res_tot = $tot[0]->NET_WEIGHT;

                                                    $result_sms = $res_bf - $res_tot;
                                                    echo $result_sms;
                                                    ?>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>


                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->






            </div><!--end row-->





        </div><!-- container -->


    </div>

    <!-- Notification -->
    <button data-toggle="modal" data-target="#errorModal" style="display: none;" id="alertbox"></button>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="errorModalLabel">Notification Alerts</h4>
                </div>
                <div class="modal-body">
                    <p id="error-msg"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="clickok">OK</button>

                </div>
            </div>
        </div>
    </div>



    <button data-toggle="modal" data-target="#errorModal4" style="display: none;" id="alertbox"></button>
    <div class="modal fade" id="errorModal4" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel4">
        <div class="modal-dialog" role="document" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#closeList').click();"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="errorModalLabel4">Empty Torpedo Signal Alert</h4>
                </div>
                <div class="modal-body">
                    <p id="error-msg4"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="clickok">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!-- BF Producttion -->
    <button data-toggle="modal" data-target="#errorModal1" style="display: none;" id="alertbox"></button>
    <div class="modal fade" id="errorModal1" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="errorModalLabel">HOURLY REPORT(MT) </h4>
                </div>
                <div class="modal-body">
                    <p id="error-msg1"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="clickok">OK</button>

                </div>
            </div>
        </div>
    </div>



    <!-- SMS Model -->
    <button data-toggle="modal" data-target="#errorModal2" style="display: none;" id="alertbox"></button>
    <div class="modal fade" id="errorModal2" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="errorModalLabel">HOURLY REPORT(SMS)</h4>
                </div>
                <div class="modal-body">
                    <p id="error-msg2"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="clickok">OK</button>

                </div>
            </div>
        </div>
    </div>



    <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView ?>">
    </div>
    <?php echo $jsfile; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#search-box").keyup(function() {
                $("#search-box1").val('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>dashboard/searchController",
                    data: 'keyword=' + $(this).val(),
                    beforeSend: function() {
                        $("#search-box").css("background", "#FFF no-repeat 165px");
                    },
                    success: function(data) {
                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(data);
                        $("#search-box").css("background", "#FFF");
                    }
                });
            });
        });


        function selectUnit(val) {
            // alert(val);
            $("#search-box").val(val);
            $("#suggesstion-box").hide();

            var httpRequest = new XMLHttpRequest();
            // alert("<<>>"+val);
            httpRequest.open('GET', '<?php echo jquery_url() ?>lists/getSearch?unit=' + val);
            httpRequest.send();
            // alert(val);
            httpRequest.onreadystatechange = function() {
                // alert(httpRequest.status);
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    // alert("<<>>>"+httpRequest.responseText);
                    httpResponse = JSON.parse(httpRequest.responseText);
                    // alert(httpResponse);
                    httpResponse.forEach(function(data, index) {
                        // alert(httpResponse);
                        ladleno = data.ladleno;
                        TAPNO = data.TAPNO;
                        LOAD_DATE = data.LOAD_DATE;
                        SOURCE = data.SOURCE;
                        DEST = data.DEST;
                        SI = data.SI;
                        S = data.S;
                        TEMP = data.TEMP;
                        GROSS_WEIGHT = data.GROSS_WEIGHT;
                        TARE_WEIGHT = data.TARE_WEIGHT;
                        NET_WEIGHT = data.NET_WEIGHT;
                        idlet = data.idlet;
                        smstime = data.smstime;
                        TARE_WT2 = data.TARE_WT2;

                        // alert(idlet);
                        // alert(TARE_WT2);

                        latitude = data.latitude;
                        longitude = data.longitude;
                        unitname = data.unitname;
                        direction = data.direction;
                        statuses = data.statusColor;
                        // alert(statuses);
                        // indent=data.indent;
                        // routenumber=data.routenumber;
                        // driver=data.driver;
                        // mobile=data.drivermobile;
                        dist = data.distance;
                        // work=data.totalhrs;
                        reporttime = data.reporttime1;
                        statusdesc = data.statusdesc;
                        // duty= data.duty;
                        loc = data.locationname;
                        // vtype = data.vtype;
                        idel = data.timehours;

                        // alert(work);

                        if (idel == "00:00:00") {
                            idel = "";
                        }


                        cdreset1();


                    });
                    // setGeofenceLabels();  
                    initMap1();
                    refreshMarkers1();
                }
            };
        }

        var CCOUNT = 30;

        var t, count, timer;

        function cddisplay1() {
            // alert("cddisplay1");
            // displays time in span
            if (CCOUNT >= 0) {
                if (count >= 0) {
                    $("#countdown1").html(count);
                }
            } else {
                $("#countdown1").html("");
            }
        };

        function countdown1() {
            // alert("countdown1");
            // starts countdown
            cddisplay1();
            // console.log(count);
            if (count < 0) {
                // time is up
                if (CCOUNT > 0) {
                    refreshMarkers1();
                    //refreshCountList();
                }

            } else {
                count--;
                t = setTimeout("countdown1()", 1000);
            }
        };

        function cdpause1() {
            // alert("cdpause1");
            // pauses countdown
            clearTimeout(t);
        };

        function cdreset1() {
            // alert("cdreset1");
            // resets countdown               
            cdpause1();
            CCOUNT = 30;
            count = CCOUNT;
            cddisplay1();
            countdown1();
        };

        function refreshMarkers1() {
            // alert("refreshMarkers1");
            //tollMethod(this);
            /* alert("HI Refresh");
            if (document.getElementById('Ambu').checked) {
                    alert("checked");
                } else {
                    alert("You didn't check it! Let me check it for you.");
                } */
            var bounds = new google.maps.LatLngBounds();
            //alert(gmarkers.length);
            // delete all existing markers first
            //removeElementsByClass('infoBox');


            bounds.extend(new google.maps.LatLng(latitude, longitude));

            //lineCoordinates = [];
            // add new markers from the JSON data
            listMarkers1();
            //console.log(gmarkers.length);
            cdreset1();
            /* for (var i = 0; i < gmarkers.length; i++) {
                 gmarkers[i].setMap(map);
             }*/
            // zoom the map to show all the markers, may not be desirable.
            //  map.fitBounds(bounds);
        }
        //  
        function getTextNew(status) {

            switch (status) {
                case "201":
                    text = "<h3>" + ladleno + "<span class='battery_icon'></span></h3>" +
                        "<ul><li><strong>Cast No:</strong> " + TAPNO + " </li>" +
                        "<li><strong>Loadtime:</strong> " + LOAD_DATE + " </li>" +
                        "<li><strong>Source:</strong> " + SOURCE + " </li>" +
                        "<li><strong>Runner HM Si%:</strong> " + SI + " </li>" +
                        "<li><strong>Runner HM Sulphur%:</strong> " + S + " </li>" +
                        "<li><strong>Runner Temp:</strong> " + TEMP + " </li></ul>";
                    break;
                case "202":
                    text = "<h3>" + ladleno + "<span class='battery_icon'></span></h3>" +
                        "<ul><li><strong>Cast No:</strong> " + TAPNO + " </li>" +
                        "<li><strong>Loadtime:</strong> " + LOAD_DATE + " </li>" +
                        "<li><strong>Source:</strong> " + SOURCE + " </li>" +
                        "<li><strong>Destination:</strong> " + DEST + " </li>" +
                        "<li><strong>Runner HM Si%:</strong> " + SI + " </li>" +
                        "<li><strong>Runner HM Sulphur%:</strong> " + S + " </li>" +
                        "<li><strong>Runner Temp:</strong> " + TEMP + " </li>" +
                        "<li><strong>Gross Weight:</strong> " + GROSS_WEIGHT + " </li>" +
                        "<li><strong>Tare Weight:</strong> " + TARE_WEIGHT + " </li>" +
                        "<li><strong>Net Weight:</strong> " + NET_WEIGHT + " </li></ul>";
                    break;
                case "203":
                    text = "<h3>" + ladleno + "<span class='battery_icon'></span></h3>" +
                        "<ul><li><strong>Unload time:</strong> " + smstime + " </li>" +
                        "<li><strong>Tare Weight:</strong> " + TARE_WEIGHT + " </li>" +
                        "<li><strong>Net Weight:</strong> " + 0 + " </li></ul>";
                    break;
                case "204":
                    text = "<h3>" + ladleno + "<span class='battery_icon'></span></h3>" +
                        "<ul><li><strong>Unload time:</strong> " + smstime + " </li>" +
                        "<li><strong>2nd Tare Weight:</strong> " + TARE_WT2 + " </li>" +
                        "<li><strong>2nd Net Weight:</strong> " + 0 + " </li></ul>";

                    break;

                case "205":
                    text = "<h3>" + ladleno + " <span class='battery_icon'></span></h3>" +
                        "<ul><li><strong>Cast No:</strong> " + TAPNO + " </li>" +
                        "<li><strong>Loadtime:</strong> " + LOAD_DATE + " </li>" +
                        "<li><strong>Source:</strong> " + SOURCE + " </li>" +
                        "<li><strong>Runner HM Si%:</strong> " + SI + " </li>" +
                        "<li><strong>Runner HM Sulphur%:</strong> " + S + " </li>" +
                        "<li><strong>Runner Temp:</strong> " + TEMP + " </li>" +
                        "<li><strong>Gross Weight:</strong> " + GROSS_WEIGHT + " </li>" +
                        "<li><strong>Tare Weight:</strong> " + TARE_WEIGHT + " </li>" +
                        "<li><strong>Net Weight:</strong> " + NET_WEIGHT + " </li></ul>";
                    break;

                default:
                    text = "";
                    break;




                    //     default: text = "<h3>"+ unitname+ "</h3>"  +
                    //     "<ul><li><strong>Last Geo :-</strong> "+ indent+" </li>"+
                    //     "<li><strong>Last GeoTime:-</strong> "+routenumber+" </li>"+
                    // "<li><strong>Report Time:-</strong> "+reporttime+" </li>"+
                    //     "<li><strong>Driver Name:-</strong> "+driver+" </li>"+
                    //     "<li><strong>Mobile No:-</strong> "+mobile+" </li>"+
                    //     "<li><strong>Total KM for the day:-</strong> "+dist+" </li>"+
                    //     "<li><strong>Present Status:-</strong> "+statusdesc+" </li>"+
                    // "<li><strong>Location:-</strong> "+loc+" </li>"+
                    // "<li><strong>Ideal From:-</strong> "+idel+" </li>"+
                    //     "</ul>" ;
                    //   break;


            }

            return text;
        }

        function fnPlaceMarkers1(markermap, textplace){
            
            var infoWnd3 = new google.maps.InfoWindow();    
            infoWnd3.setContent('<div class="scrollFix">' + textplace + '</div>');
            infoWnd3.open(map, markermap);        
            
        }
    </script>
    <?php
       
    $dbhost = 'localhost';
    $dbname = 'suvetracg';  
    $dbuser = 'root';                  
    $dbpass = ''; 
    
    
    try{
        
        $dbcon = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }catch(PDOException $ex){
        
        die($ex->getMessage());
    }
    $stmt=$dbcon->prepare("SELECT TIME_FORMAT(GROSS_DATE,'%h %p') AS time,IFNULL(SUM(NET_WEIGHT),0) BF_PROD FROM laddle_report WHERE GROSS_DATE>CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 0 DAY),' ','23:00:00') group by HOUR(GROSS_DATE) order by GROSS_DATE");
    $stmt->execute();
    $json= [];
    $json2= [];
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $json[]= $time;
        $json2[]= (int)$BF_PROD;
    }

    //Sms received
    $stmt=$dbcon->prepare("SELECT TIME_FORMAT(GROSS_DATE,'%h %p') AS time,IFNULL(SUM(NET_WEIGHT),0) BF_PROD FROM laddle_report WHERE ((GROSS_DATE>CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') AND GROSS_DATE<=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 0 DAY),' ','23:00:00')  and TARE_WT2>0) or (GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') AND SMS_TIME>= CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') )) group by HOUR(GROSS_DATE) order by GROSS_DATE");
    $stmt->execute();
    $json= [];
    $json3= [];
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $json[]= $time;
        $json3[]= (int)$BF_PROD;
    }
  // This line is added to close mysql connection
   $dbcon = null;
?>
<script type="text/javascript">
      /**
 * Theme: Dastyle - Responsive Bootstrap 4 Admin Dashboard
 * Author: Mannatthemes
 * Apexcharts Js
 */
var options = {
    series: [{
      name: "Desktops",
      data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
  }],
    chart: {
    height: 150,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  colors: ['#008ffb'],
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight',
    width: [3],
  },
  title: {
    text: 'Product Trends by Month',
    align: 'left'
  },  
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  }
  };

  var chart = new ApexCharts(document.querySelector("#apex_line1"), options);
  chart.render();


    //line-2

    var ts2 = 1484418600000;
  var dates = [];
  var spikes = [5, -5, 3, -3, 8, -8]
  for (var i = 0; i < 120; i++) {
    ts2 = ts2 + 86400000;
    var innerArr = [ts2, dataSeries[1][i].value];
    dates.push(innerArr)
  }
    var options = {
        series: [{
        name: 'XYZ MOTORS',
        data: dates
      }],
        chart: {
        type: 'area',
        stacked: false,
        height: 150,
        zoom: {
          type: 'x',
          enabled: true,
          autoScaleYaxis: true
        },
        toolbar: {
          autoSelected: 'zoom'
        }
      },
      stroke: {
        width: [3],
      },
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 0,
      },
      
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 90, 100]
        },
      },
      yaxis: {
        labels: {
          formatter: function (val) {
            return (val / 1000000).toFixed(0);
          },
        },
        title: {
          text: 'Price'
        },
      },
      xaxis: {
        type: 'datetime',
      },
      tooltip: {
        shared: false,
        y: {
          formatter: function (val) {
            return (val / 1000000).toFixed(0)
          }
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#apex_line2"), options);
      chart.render();


      var options = {
        chart: {
            height: 160,
            type: 'area',
            stacked: true,
            toolbar: {
              show: false,
              autoSelected: 'zoom'
            },
        },
        colors: ['#2a77f4', '#a5c2f1'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: [3, 3],
            dashArray: [0, 4],
            lineCap: 'round'
        },
        grid: {
          borderColor: "#45404a2e",
          padding: {
            left: 0,
            right: 0
          },
          strokeDashArray: 4,
        },
        markers: {
          size: 0,
          hover: {
            size: 0
          }
        },
        series: [{
            name: 'New Visits',
            data: [0,60,20,90,45,110,55,130,44,110,75,120]
        }, {
            name: 'Unique Visits',
            data: [0,45,10,75,35,94,40,115,30,105,65,110]
        }],
      
        xaxis: {
            type: 'month',
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: {
              show: true,
              color: '#45404a2e',
            },  
            axisTicks: {
              show: true,
              color: '#45404a2e',
            },                  
        },
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.3,
            stops: [0, 90, 100]
          }
        },
        
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right'
        },
      }
      
      var chart = new ApexCharts(
        document.querySelector("#apex_area1"),
        options
      );
      
      chart.render();

      //Area-2
  $(document).ready(function() {
    var options = {
        annotations: {
        yaxis: [{
            y: 30,
            borderColor: '#999',
            label: {
            show: true,
            text: 'Support',
            style: {
                color: "#fff",
                background: '#03d87f'
            }
          }
        }],
        xaxis: [{
            x: new Date('14 Nov 2012').getTime(),
            borderColor: '#999',
            yAxisIndex: 0,
            label: {
              show: true,
              text: 'Rally',
              style: {
                  color: "#fff",
                  background: '#ffb822'
              }
            },
          }]
        },
        chart: {
          type: 'area',
          height: 150,
        },
        stroke: {
          width: [3],
        },
        dataLabels: {
          enabled: false
        },
        series: [{
            data:[
            [1327359600000,30.95],
            [1327446000000,31.34],
            [1327532400000,31.18],
            [1327618800000,31.05],
            [1327878000000,31.00],
            [1327964400000,30.95],
            [1328050800000,31.24],
            [1328137200000,31.29],
            [1328223600000,31.85],
            [1328482800000,31.86],
            [1328569200000,32.28],
            [1328655600000,32.10],
            [1328742000000,32.65],
            [1328828400000,32.21],
            [1329087600000,32.35],
            [1329174000000,32.44],
            [1329260400000,32.46],
            [1329346800000,32.86],
            [1329433200000,32.75],
            [1329778800000,32.54],
            [1329865200000,32.33],
            [1329951600000,32.97],
            [1330038000000,33.41],
            [1330297200000,33.27],
            [1330383600000,33.27],
            [1330470000000,32.89],
            [1330556400000,33.10],
            [1330642800000,33.73],
            [1330902000000,33.22],
            [1330988400000,31.99],
            [1331074800000,32.41],
            [1331161200000,33.05],
            [1331247600000,33.64],
            [1331506800000,33.56],
            [1331593200000,34.22],
            [1331679600000,33.77],
            [1331766000000,34.17],
            [1331852400000,33.82],
            [1332111600000,34.51],
            [1332198000000,33.16],
            [1332284400000,33.56],
            [1332370800000,33.71],
            [1332457200000,33.81],
            [1332712800000,34.40],
            [1332799200000,34.63],
            [1332885600000,34.46],
            [1332972000000,34.48],
            [1333058400000,34.31],
            [1333317600000,34.70],
            [1333404000000,34.31],
            [1333490400000,33.46],
            [1333576800000,33.59],
            [1333922400000,33.22],
            [1334008800000,32.61],
            [1334095200000,33.01],
            [1334181600000,33.55],
            [1334268000000,33.18],
            [1334527200000,32.84],
            [1334613600000,33.84],
            [1334700000000,33.39],
            [1334786400000,32.91],
            [1334872800000,33.06],
            [1335132000000,32.62],
            [1335218400000,32.40],
            [1335304800000,33.13],
            [1335391200000,33.26],
            [1335477600000,33.58],
            [1335736800000,33.55],
            [1335823200000,33.77],
            [1335909600000,33.76],
            [1335996000000,33.32],
            [1336082400000,32.61],
            [1336341600000,32.52],
            [1336428000000,32.67],
            [1336514400000,32.52],
            [1336600800000,31.92],
            [1336687200000,32.20],
            [1336946400000,32.23],
            [1337032800000,32.33],
            [1337119200000,32.36],
            [1337205600000,32.01],
            [1337292000000,31.31],
            [1337551200000,32.01],
            [1337637600000,32.01],
            [1337724000000,32.18],
            [1337810400000,31.54],
            [1337896800000,31.60],
            [1338242400000,32.05],
            [1338328800000,31.29],
            [1338415200000,31.05],
            [1338501600000,29.82],
            [1338760800000,30.31],
            [1338847200000,30.70],
            [1338933600000,31.69],
            [1339020000000,31.32],
            [1339106400000,31.65],
            [1339365600000,31.13],
            [1339452000000,31.77],
            [1339538400000,31.79],
            [1339624800000,31.67],
            [1339711200000,32.39],
            [1339970400000,32.63],
            [1340056800000,32.89],
            [1340143200000,31.99],
            [1340229600000,31.23],
            [1340316000000,31.57],
            [1340575200000,30.84],
            [1340661600000,31.07],
            [1340748000000,31.41],
            [1340834400000,31.17],
            [1340920800000,32.37],
            [1341180000000,32.19],
            [1341266400000,32.51],
            [1341439200000,32.53],
            [1341525600000,31.37],
            [1341784800000,30.43],
            [1341871200000,30.44],
            [1341957600000,30.20],
            [1342044000000,30.14],
            [1342130400000,30.65],
            [1342389600000,30.40],
            [1342476000000,30.65],
            [1342562400000,31.43],
            [1342648800000,31.89],
            [1342735200000,31.38],
            [1342994400000,30.64],
            [1343080800000,30.02],
            [1343167200000,30.33],
            [1343253600000,30.95],
            [1343340000000,31.89],
            [1343599200000,31.01],
            [1343685600000,30.88],
            [1343772000000,30.69],
            [1343858400000,30.58],
            [1343944800000,32.02],
            [1344204000000,32.14],
            [1344290400000,32.37],
            [1344376800000,32.51],
            [1344463200000,32.65],
            [1344549600000,32.64],
            [1344808800000,32.27],
            [1344895200000,32.10],
            [1344981600000,32.91],
            [1345068000000,33.65],
            [1345154400000,33.80],
            [1345413600000,33.92],
            [1345500000000,33.75],
            [1345586400000,33.84],
            [1345672800000,33.50],
            [1345759200000,32.26],
            [1346018400000,32.32],
            [1346104800000,32.06],
            [1346191200000,31.96],
            [1346277600000,31.46],
            [1346364000000,31.27],
            [1346709600000,31.43],
            [1346796000000,32.26],
            [1346882400000,32.79],
            [1346968800000,32.46],
            [1347228000000,32.13],
            [1347314400000,32.43],
            [1347400800000,32.42],
            [1347487200000,32.81],
            [1347573600000,33.34],
            [1347832800000,33.41],
            [1347919200000,32.57],
            [1348005600000,33.12],
            [1348092000000,34.53],
            [1348178400000,33.83],
            [1348437600000,33.41],
            [1348524000000,32.90],
            [1348610400000,32.53],
            [1348696800000,32.80],
            [1348783200000,32.44],
            [1349042400000,32.62],
            [1349128800000,32.57],
            [1349215200000,32.60],
            [1349301600000,32.68],
            [1349388000000,32.47],
            [1349647200000,32.23],
            [1349733600000,31.68],
            [1349820000000,31.51],
            [1349906400000,31.78],
            [1349992800000,31.94],
            [1350252000000,32.33],
            [1350338400000,33.24],
            [1350424800000,33.44],
            [1350511200000,33.48],
            [1350597600000,33.24],
            [1350856800000,33.49],
            [1350943200000,33.31],
            [1351029600000,33.36],
            [1351116000000,33.40],
            [1351202400000,34.01],
            [1351638000000,34.02],
            [1351724400000,34.36],
            [1351810800000,34.39],
            [1352070000000,34.24],
            [1352156400000,34.39],
            [1352242800000,33.47],
            [1352329200000,32.98],
            [1352415600000,32.90],
            [1352674800000,32.70],
            [1352761200000,32.54],
            [1352847600000,32.23],
            [1352934000000,32.64],
            [1353020400000,32.65],
            [1353279600000,32.92],
            [1353366000000,32.64],
            [1353452400000,32.84],
            [1353625200000,33.40],
            [1353884400000,33.30],
            [1353970800000,33.18],
            [1354057200000,33.88],
            [1354143600000,34.09],
            [1354230000000,34.61],
            [1354489200000,34.70],
            [1354575600000,35.30],
            [1354662000000,35.40],
            [1354748400000,35.14],
            [1354834800000,35.48],
            [1355094000000,35.75],
            [1355180400000,35.54],
            [1355266800000,35.96],
            [1355353200000,35.53],
            [1355439600000,37.56],
            [1355698800000,37.42],
            [1355785200000,37.49],
            [1355871600000,38.09],
            [1355958000000,37.87],
            [1356044400000,37.71],
            [1356303600000,37.53],
            [1356476400000,37.55],
            [1356562800000,37.30],
            [1356649200000,36.90],
            [1356908400000,37.68],
            [1357081200000,38.34],
            [1357167600000,37.75],
            [1357254000000,38.13],
            [1357513200000,37.94],
            [1357599600000,38.14],
            [1357686000000,38.66],
            [1357772400000,38.62],
            [1357858800000,38.09],
            [1358118000000,38.16],
            [1358204400000,38.15],
            [1358290800000,37.88],
            [1358377200000,37.73],
            [1358463600000,37.98],
            [1358809200000,37.95],
            [1358895600000,38.25],
            [1358982000000,38.10],
            [1359068400000,38.32],
            [1359327600000,38.24],
            [1359414000000,38.52],
            [1359500400000,37.94],
            [1359586800000,37.83],
            [1359673200000,38.34],
            [1359932400000,38.10],
            [1360018800000,38.51],
            [1360105200000,38.40],
            [1360191600000,38.07],
            [1360278000000,39.12],
            [1360537200000,38.64],
            [1360623600000,38.89],
            [1360710000000,38.81],
            [1360796400000,38.61],
            [1360882800000,38.63],
            [1361228400000,38.99],
            [1361314800000,38.77],
            [1361401200000,38.34],
            [1361487600000,38.55],
            [1361746800000,38.11],
            [1361833200000,38.59],
            [1361919600000,39.60],
            ]
            
          },
        ],
        markers: {
          size: 0,
          style: 'hollow',
        },
        xaxis: {
          type: 'datetime',
          min: new Date('01 Mar 2012').getTime(),
          tickAmount: 6,
          axisBorder: {
            show: true,
            color: '#bec7e0',
          },  
          axisTicks: {
            show: true,
            color: '#bec7e0',
          },    
        },
        colors: ['#008ffb'],
        tooltip: {
          x: {
              format: 'dd MMM yyyy'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.7,
              opacityTo: 0.4,
              stops: [0, 100]
          }
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#apex_area2"),
        options
    );

    chart.render();

    var resetCssClasses = function (activeEl) {
        var els = document.querySelectorAll("button");
        Array.prototype.forEach.call(els, function (el) {
        el.classList.remove('active');
        });

        activeEl.target.classList.add('active')
    }

    document.querySelector("#one_month").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
        xaxis: {
            min: new Date('28 Jan 2013').getTime(),
            max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#six_months").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
        xaxis: {
            min: new Date('27 Sep 2012').getTime(),
            max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#one_year").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
        xaxis: {
            min: new Date('27 Feb 2012').getTime(),
            max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#ytd").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
        xaxis: {
            min: new Date('01 Jan 2013').getTime(),
            max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#all").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
        xaxis: {
            min: undefined,
            max: undefined,
        }
      })
    })

    document.querySelector("#ytd").addEventListener('click', function () {

    })
  })

 //colunm-1
  
 var options = {
  chart: {
      height: 196,
      type: 'bar',
      toolbar: {
          show: false
      },
  },
  plotOptions: {
      bar: {
          horizontal: false,
          endingShape: 'rounded',
          columnWidth: '55%',
      },
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
  },
  colors: ["rgba(42, 118, 244, .18)", '#2a76f4', "rgba(251, 182, 36, .6)"],
  series: [/* {
      name: 'Net Profit',
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
  }, */ {
      name: 'BF Production',
      data: <?php echo json_encode($json2); ?>,
  }, {
      name: 'SMS Received',
      data: <?php echo json_encode($json3); ?>,
  }],
  xaxis: {
      categories: ["", "", "", "", ""],
      axisBorder: {
          show: true,
          color: '#bec7e0',
        },  
        axisTicks: {
          show: true,
          color: '#bec7e0',
      },    
  },
  legend: {
      offsetY: 6,
  },
  yaxis: {
      title: {
          text: '$ (h)'
      }
  },
  fill: {
      opacity: 1

  },
  // legend: {
  //     floating: true
  // },
  grid: {
      row: {
          colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.2
      },
      borderColor: '#f1f3fa'
  },
  tooltip: {
      y: {
          formatter: function (val) {
              return "$ " + val + " h"
          }
      }
  }
}

// var chart = new ApexCharts(
//   document.querySelector(".pol"),
//   options
// );


// chart.render();
// var chart = new ApexCharts(
//   document.querySelector(".pol1"),
//   options
// );

// chart.render();

// var chart = new ApexCharts(
//   document.querySelector(".pol3"),
//   options
// );

// chart.render();


var chart = new ApexCharts(
  document.querySelector(".pol5"),
  options

  
);

chart.render();


// var chart = new ApexCharts(
//   document.querySelector(".pol4"),
//   options
// );

// chart.render();

//apex-column-2


var options = {
  chart: {
      height: 180,
      type: 'bar',
      toolbar: {
          show: false
      },
  },
  plotOptions: {
      bar: {
          dataLabels: {
              position: 'top', // top, center, bottom
          },
      }
  },
  dataLabels: {
      enabled: true,
      formatter: function (val) {
          return val + "%";
      },
      offsetY: -20,
      style: {
          fontSize: '12px',
          colors: ["#304758"]
      }
  },
  colors: ["#2a76f4"],
  series: [{
      name: 'Inflation',
      data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
  }],
  xaxis: {
      categories: ["<?php echo json_encode($json); ?>"],
      position: 'top',
      labels: {
          offsetY: -18,

      },
      axisBorder: {
          show: true,
          color: '#28365f',
      },
      axisTicks: {
          show: true,
          color: '#28365f',
      },
      crosshairs: {
          fill: {
              type: 'gradient',
              gradient: {
                  colorFrom: '#D8E3F0',
                  colorTo: '#BED1E6',
                  stops: [0, 100],
                  opacityFrom: 0.4,
                  opacityTo: 0.5,
              }
          }
      },
      tooltip: {
          enabled: true,
          offsetY: -35,

      }
  },
  fill: {
      gradient: {
          enabled: false,
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.25,
          gradientToColors: undefined,
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [50, 0, 100, 100]
      },
  },
  yaxis: {
      axisBorder: {
          show: false
      },
      axisTicks: {
          show: false,
      },
      labels: {
          show: false,
          formatter: function (val) {
              return val + "%";
          }
      }

  },
  title: {
      text: 'Monthly Inflation in Argentina, 2002',
      floating: true,
      offsetY: 350,
      align: 'center',
      style: {
          color: '#8997bd'
      }
  },
  grid: {
      row: {
          colors: ['#afb7d21a', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.2
      },
      borderColor: '#f1f3fa'
  }
}

var chart = new ApexCharts(
  document.querySelector("#apex_column2"),
  options
);

chart.render();


// apex-bar-1

var options = {
  chart: {
      height: 180,
      type: 'bar',
      toolbar: {
          show: false
      },
  },
  plotOptions: {
      bar: {
          horizontal: true,
      }
  },
  dataLabels: {
      enabled: false
  },
  series: [{
      data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
  }],
  colors: ["#2a76f4"],
  yaxis: {
      axisBorder: {
          show: true,
          color: '#bec7e0',
        },  
        axisTicks: {
          show: true,
          color: '#bec7e0',
      }, 
  },
  xaxis: {
      categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'Germany'],        
  },
  states: {
      hover: {
          filter: 'none'
      }
  },
  grid: {
      borderColor: '#f1f3fa'
  }
}

var chart = new ApexCharts(
  document.querySelector("#apex_bar"),
  options
);

chart.render();

//Mixed-2


var options = {
  chart: {
      height: 180,
      type: 'line',
      stacked: false,
      toolbar: {
          show: false
      },
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: [0, 0, 3]
  },
  series: [{
      name: 'Income',
      type: 'column',
      data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
  }, {
      name: 'Cashflow',
      type: 'column',
      data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
  }, {
      name: 'Revenue',
      type: 'line',
      data: [20, 29, 37, 36, 44, 45, 50, 58]
  }],
  colors: ["rgba(42, 118, 244, .18)", '#2a76f4', "rgba(251, 182, 36, .6)"],
  xaxis: {
      categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
      axisBorder: {
        show: true,
        color: '#bec7e0',
      },  
      axisTicks: {
        show: true,
        color: '#bec7e0',
    }, 
  },
  yaxis: [
      {
          axisTicks: {
              show: true,
          },
          axisBorder: {
              show: true,
              color: '#20016c'
          },
          labels: {
              style: {
                  color: '#20016c',
              }
          },
          title: {
              text: "Income (thousand crores)"
          },
      },

      {
          axisTicks: {
              show: true,
          },
          axisBorder: {
              show: true,
              color: '#77d0ba'
          },
          labels: {
              style: {
                  color: '#77d0ba',
              },
              offsetX: 10
          },
          title: {
              text: "Operating Cashflow (thousand crores)",
          },
      },
      {
          opposite: true,
          axisTicks: {
              show: true,
          },
          axisBorder: {
              show: true,
              color: '#fa5c7c'
          },
          labels: {
              style: {
                  color: '#fa5c7c',
              }
          },
          title: {
              text: "Revenue (thousand crores)"
          }
      },

  ],
  tooltip: {
      followCursor: true,
      y: {
          formatter: function (y) {
              if (typeof y !== "undefined") {
                  return y + " thousand crores"
              }
              return y;
          }
      }
  },
  grid: {
      borderColor: '#f1f3fa'
  },
  legend: {
      offsetY: 6,
  },
  responsive: [{
      breakpoint: 600,
      options: {
          yaxis: {
              show: false
          },
          legend: {
              show: false
          }
      }
  }]
}

var chart = new ApexCharts(
  document.querySelector("#apex_mixed"),
  options
);

chart.render();

//apex-bubble2

/*
// this function will generate output in this format
// data = [
  [timestamp, 23],
  [timestamp, 33],
  [timestamp, 12]
  ...
]
*/
function generateData1(baseval1, count, yrange) {
  var i = 0;
  var series = [];
  while (i < count) {
      //var x =Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

      series.push([baseval1, y, z]);
      baseval1 += 86400000;
      i++;
  }
  return series;
}


var options2 = {
  chart: {
      height: 180,
      type: 'bubble',
      toolbar: {
          show: false
      },
  },
  dataLabels: {
      enabled: false
  },
  series: [{
      name: 'Product 1',
      data: generateData1(new Date('11 Feb 2017 GMT').getTime(), 20, {
          min: 10,
          max: 60
      })
  },
  {
      name: 'Product 2',
      data: generateData1(new Date('11 Feb 2017 GMT').getTime(), 20, {
          min: 10,
          max: 60
      })
  },
  {
      name: 'Product 3',
      data: generateData1(new Date('11 Feb 2017 GMT').getTime(), 20, {
          min: 10,
          max: 60
      })
  },
  {
      name: 'Product 4',
      data: generateData1(new Date('11 Feb 2017 GMT').getTime(), 20, {
          min: 10,
          max: 60
      })
  }
  ],
  fill: {
      type: 'gradient',
  },
  colors: ["#727cf5", "#0acf97", "#fa5c7c", "#39afd1"],
  xaxis: {
      tickAmount: 12,
      type: 'datetime',

      labels: {
          rotate: 0,
      },
      axisBorder: {
        show: true,
        color: '#bec7e0',
      },  
      axisTicks: {
        show: true,
        color: '#bec7e0',
    }, 
  },
  yaxis: {
      max: 70
  },
  legend: {
      offsetY: 6,
  },
  grid: {
      borderColor: '#f1f3fa'
  }
}

var chart = new ApexCharts(
  document.querySelector("#apex_bubble"),
  options2
);

chart.render();

// Candlestick

var options = {
  chart: {
    height: 120,
    type: 'candlestick',
    toolbar: {
      show: false,
    },
  },
  series: [{
    data: [{
        x: new Date(1538778600000),
        y: [6629.81, 6650.5, 6623.04, 6633.33]
      },
      {
        x: new Date(1538780400000),
        y: [6632.01, 6643.59, 6620, 6630.11]
      },
      {
        x: new Date(1538782200000),
        y: [6630.71, 6648.95, 6623.34, 6635.65]
      },
      {
        x: new Date(1538784000000),
        y: [6635.65, 6651, 6629.67, 6638.24]
      },
      {
        x: new Date(1538785800000),
        y: [6638.24, 6640, 6620, 6624.47]
      },
      {
        x: new Date(1538787600000),
        y: [6624.53, 6636.03, 6621.68, 6624.31]
      },
      {
        x: new Date(1538789400000),
        y: [6624.61, 6632.2, 6617, 6626.02]
      },
      {
        x: new Date(1538791200000),
        y: [6627, 6627.62, 6584.22, 6603.02]
      },
      {
        x: new Date(1538793000000),
        y: [6605, 6608.03, 6598.95, 6604.01]
      },
      {
        x: new Date(1538794800000),
        y: [6604.5, 6614.4, 6602.26, 6608.02]
      },
      {
        x: new Date(1538796600000),
        y: [6608.02, 6610.68, 6601.99, 6608.91]
      },
      {
        x: new Date(1538798400000),
        y: [6608.91, 6618.99, 6608.01, 6612]
      },
      {
        x: new Date(1538800200000),
        y: [6612, 6615.13, 6605.09, 6612]
      },
      {
        x: new Date(1538802000000),
        y: [6612, 6624.12, 6608.43, 6622.95]
      },
      {
        x: new Date(1538803800000),
        y: [6623.91, 6623.91, 6615, 6615.67]
      },
      {
        x: new Date(1538805600000),
        y: [6618.69, 6618.74, 6610, 6610.4]
      },
      {
        x: new Date(1538807400000),
        y: [6611, 6622.78, 6610.4, 6614.9]
      },
      {
        x: new Date(1538809200000),
        y: [6614.9, 6626.2, 6613.33, 6623.45]
      },
      {
        x: new Date(1538811000000),
        y: [6623.48, 6627, 6618.38, 6620.35]
      },
      {
        x: new Date(1538812800000),
        y: [6619.43, 6620.35, 6610.05, 6615.53]
      },
      {
        x: new Date(1538814600000),
        y: [6615.53, 6617.93, 6610, 6615.19]
      },
      {
        x: new Date(1538816400000),
        y: [6615.19, 6621.6, 6608.2, 6620]
      },
      {
        x: new Date(1538818200000),
        y: [6619.54, 6625.17, 6614.15, 6620]
      },
      {
        x: new Date(1538820000000),
        y: [6620.33, 6634.15, 6617.24, 6624.61]
      },
      {
        x: new Date(1538821800000),
        y: [6625.95, 6626, 6611.66, 6617.58]
      },
      {
        x: new Date(1538823600000),
        y: [6619, 6625.97, 6595.27, 6598.86]
      },
      {
        x: new Date(1538825400000),
        y: [6598.86, 6598.88, 6570, 6587.16]
      },
      {
        x: new Date(1538827200000),
        y: [6588.86, 6600, 6580, 6593.4]
      },
      {
        x: new Date(1538829000000),
        y: [6593.99, 6598.89, 6585, 6587.81]
      },
      {
        x: new Date(1538830800000),
        y: [6587.81, 6592.73, 6567.14, 6578]
      },
      {
        x: new Date(1538832600000),
        y: [6578.35, 6581.72, 6567.39, 6579]
      },
      {
        x: new Date(1538834400000),
        y: [6579.38, 6580.92, 6566.77, 6575.96]
      },
      {
        x: new Date(1538836200000),
        y: [6575.96, 6589, 6571.77, 6588.92]
      },
      {
        x: new Date(1538838000000),
        y: [6588.92, 6594, 6577.55, 6589.22]
      },
      {
        x: new Date(1538839800000),
        y: [6589.3, 6598.89, 6589.1, 6596.08]
      },
      {
        x: new Date(1538841600000),
        y: [6597.5, 6600, 6588.39, 6596.25]
      },
      {
        x: new Date(1538843400000),
        y: [6598.03, 6600, 6588.73, 6595.97]
      },
      {
        x: new Date(1538845200000),
        y: [6595.97, 6602.01, 6588.17, 6602]
      },
      {
        x: new Date(1538847000000),
        y: [6602, 6607, 6596.51, 6599.95]
      },
      {
        x: new Date(1538848800000),
        y: [6600.63, 6601.21, 6590.39, 6591.02]
      },
      {
        x: new Date(1538850600000),
        y: [6591.02, 6603.08, 6591, 6591]
      },
      {
        x: new Date(1538852400000),
        y: [6591, 6601.32, 6585, 6592]
      },
      {
        x: new Date(1538854200000),
        y: [6593.13, 6596.01, 6590, 6593.34]
      },
      {
        x: new Date(1538856000000),
        y: [6593.34, 6604.76, 6582.63, 6593.86]
      },
      {
        x: new Date(1538857800000),
        y: [6593.86, 6604.28, 6586.57, 6600.01]
      },
      {
        x: new Date(1538859600000),
        y: [6601.81, 6603.21, 6592.78, 6596.25]
      },
      {
        x: new Date(1538861400000),
        y: [6596.25, 6604.2, 6590, 6602.99]
      },
      {
        x: new Date(1538863200000),
        y: [6602.99, 6606, 6584.99, 6587.81]
      },
      {
        x: new Date(1538865000000),
        y: [6587.81, 6595, 6583.27, 6591.96]
      },
      {
        x: new Date(1538866800000),
        y: [6591.97, 6596.07, 6585, 6588.39]
      },
      {
        x: new Date(1538868600000),
        y: [6587.6, 6598.21, 6587.6, 6594.27]
      },
      {
        x: new Date(1538870400000),
        y: [6596.44, 6601, 6590, 6596.55]
      },
      {
        x: new Date(1538872200000),
        y: [6598.91, 6605, 6596.61, 6600.02]
      },
      {
        x: new Date(1538874000000),
        y: [6600.55, 6605, 6589.14, 6593.01]
      },
      {
        x: new Date(1538875800000),
        y: [6593.15, 6605, 6592, 6603.06]
      },
      {
        x: new Date(1538877600000),
        y: [6603.07, 6604.5, 6599.09, 6603.89]
      },
      {
        x: new Date(1538879400000),
        y: [6604.44, 6604.44, 6600, 6603.5]
      },
      {
        x: new Date(1538881200000),
        y: [6603.5, 6603.99, 6597.5, 6603.86]
      },
      {
        x: new Date(1538883000000),
        y: [6603.85, 6605, 6600, 6604.07]
      },
      {
        x: new Date(1538884800000),
        y: [6604.98, 6606, 6604.07, 6606]
      },
    ]
  }],
  
  xaxis: {
    type: 'datetime',
    axisBorder: {
      show: true,
      color: '#bec7e0',
    },  
    axisTicks: {
      show: true,
      color: '#bec7e0',
    },    
  },
  yaxis: {
      // labels: {
      //     formatter: function (value) {
      //         // return "$" + value ;
      //     }
      // },
      tooltip: {
          enabled: true
      }
  },
  grid: {
    strokeDashArray: 4,
  },
}

var chart = new ApexCharts(
  document.querySelector("#apex_candlestick"),
  options
);

chart.render();


//
// Pie Charts
//

  //apex-pie1

  
  var options = {
    chart: {
        height: 120,
        type: 'pie',
    }, 
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    series: [50, 50, 50],
    labels: ["Series 1", "Series 2", "Series 3"],
    colors: ["#d9e6fd", "#4a8af6","#fbc659"],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0,
        offsetY: 6
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 140
            },
            legend: {
                show: false
            },
        }
    }]
  }
  
  var chart = new ApexCharts(
    document.querySelector("#apex_pie1"),
    options
  );
  
  chart.render();
  
    //apex-pie2
  
  var options = {
    chart: {
        height: 120,
        type: 'donut',
    }, 
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    series: [50, 50, 50,],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0,
        offsetY: 6
    },
    labels: ["Series 1", "Series 2", "Series 3"],
    colors: ["#d9e6fd", "#4a8af6","#fbc659"],
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 140
            },
            legend: {
                show: false
            },
        }
    }],
    fill: {
        type: 'gradient'
    }
  }
  
  var chart = new ApexCharts(
    document.querySelector("#apex_pie2"),
    options
  );
  
  chart.render();
  
    //apex-pie3
  
    var options = {
      chart: {
          height: 120,
          type: 'donut',
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      series: [50, 50, 50],
      colors: ["#a3cae0", "#232f5b","#f06a6c"],
      labels: ["Comedy", "Action", "SciFi"],
      dataLabels: {
          dropShadow: {
              blur: 3,
              opacity: 0.8
          }
      },
      fill: {
      type: 'pattern',
        opacity: 1,
        pattern: {
          enabled: true,
          style: ['verticalLines', 'squares', 'horizontalLines', 'circles','slantedLines'], 
        },
      },
      states: {
        hover: {
          enabled: false
        }
      },
      legend: {
          show: true,
          position: 'bottom',
          horizontalAlign: 'center',
          verticalAlign: 'middle',
          floating: false,
          fontSize: '14px',
          offsetX: 0,
          offsetY: 6
      },
      responsive: [{
          breakpoint: 600,
          options: {
              chart: {
                  height: 140
              },
              legend: {
                  show: false
              },
          }
      }]
  }
  
  var chart = new ApexCharts(
      document.querySelector("#apex_pie3"),
      options
  );
  
  chart.render();
  
   
  
  // Apex Radialbar Charts
  
  // Apex-radialbar1
  
  
  var options = {
    chart: {
        height: 120,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            hollow: {
                size: '70%',
            },
            track: {
              background: '#b9c1d4',
              opacity: 0.5,
            },
            dataLabels: {
              name: {
                  fontSize: '18px',
              },
              value: {
                  fontSize: '16px',
                  color: '#8997bd',
              },          
            }
        },
    },
    colors: ["#4a8af6"],
    series: [70],
    labels: ['CRICKET'],
  
  }
  
  var chart = new ApexCharts(
    document.querySelector("#apex_radialbar1"),
    options
  );
  
  chart.render();
  
  
  
  //Apex-radialbar2
  
  var options = {
    chart: {
        height: 150,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
          track: {
              background: '#b9c1d4',
              opacity: 0.5,            
            },
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                    color: '#8997bd',
                },
                total: {
                    show: true,
                    label: 'Total',
                    color: '#8997bd',
                    formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return 249
                    }
                }
            }
        }
    },
    series: [44, 55, 67, 83],
    labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
    
  }
  
  var chart = new ApexCharts(
    document.querySelector("#apex_radialbar2"),
    options
  );
  
  chart.render();
  
  
  
  //Apex-radialbar3
  
  var options = {
    chart: {
        height: 180,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            track: {
              background: '#b9c1d4',
              opacity: 0.3,            
            },
            dataLabels: {
                name: {
                    fontSize: '16px',
                    color: '#8997bd',
                    offsetY: 120
                },
                value: {
                    offsetY: 76,
                    fontSize: '22px',
                    color: '#8997bd',
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            }
        }
    },
    fill: {
        gradient: {
            enabled: true,
            shade: 'dark',
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91]
        },
    },
    stroke: {
        dashArray: 4
    },
    colors: ["#4a8af6"],
    series: [67],
    labels: ['Median Ratio'],
    responsive: [{
        breakpoint: 380,
        options: {
          chart: {
            height: 180
          }
        }
    }]
  }
  
  var chart = new ApexCharts(
    document.querySelector("#apex_radialbar3"),
    options
  );
  
  chart.render();

  //
// Sparkline
//


Apex.grid = {
  padding: {
      right: 0,
      left: 0
  }
}

Apex.dataLabels = {
  enabled: false
}

var randomizeArray = function (arg) {
  var array = arg.slice();
  var currentIndex = array.length, temporaryValue, randomIndex;

  while (0 !== currentIndex) {

      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
  }

  return array;
}

// data for the sparklines that appear below header area
var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];

// the default colorPalette for this dashboard
//var colorPalette = ['#01BFD6', '#5564BE', '#F7A600', '#EDCD24', '#F74F58'];
var colorPalette = ['#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0']

var spark1 = {
  chart: {
      type: 'area',
      height: 160,
      sparkline: {
          enabled: true
      },
  },
  stroke: {
      width: 2,
      curve: 'straight'
  },
  fill: {
      opacity: 0.2,
  },
  series: [{
      name: 'Metrica Sales ',
      data: randomizeArray(sparklineData)
  }],
  yaxis: {
      min: 0
  },
  colors: ['#f93b7a'],
  title: {
      text: '$424,652',
      offsetX: 20,
      style: {
          fontSize: '24px',
          color: '#8997bd',
          fontWeight: '500',
      }
  },
  subtitle: {
      text: 'Sales',
      offsetX: 20,
      style: {
          fontSize: '14px',
          color: '#8997bd',
      }
  }
}
new ApexCharts(document.querySelector("#spark1"), spark1).render();

var spark2 = {
  chart: {
      type: 'area',
      height: 160,
      sparkline: {
          enabled: true
      },
  },
  stroke: {
      width: 2,
      curve: 'straight'
  },
  fill: {
      opacity: 0.2,
  },
  series: [{
      name: 'Metrica Expenses ',
      data: randomizeArray(sparklineData)
  }],
  yaxis: {
      min: 0
  },
  colors: ['#fbb624'],
  title: {
      text: '$235,312',
      offsetX: 20,
      style: {
          fontSize: '24px',
          color: '#8997bd',
          fontWeight: '500',
      }
  },
  subtitle: {
      text: 'Expenses',
      offsetX: 20,
      style: {
          fontSize: '14px',
          color: '#8997bd',
      }
  }
}

new ApexCharts(document.querySelector("#spark2"), spark2).render();

var spark3 = {
  chart: {
      type: 'area',
      height: 160,
      sparkline: {
          enabled: true
      },
  },
  stroke: {
      width: 2,
      curve: 'straight'
  },
  fill: {
      opacity: 0.2,
  },
  series: [{
      name: 'Net Profits ',
      data: randomizeArray(sparklineData)
  }],
  xaxis: {
      crosshairs: {
          width: 1
      },
  },
  yaxis: {
      min: 0
  },
  colors: ['#0acf97'],
  title: {
      text: '$135,965',
      offsetX: 20,
      style: {
          fontSize: '24px',
          color: '#8997bd',
          fontWeight: '500',
      }
  },
  subtitle: {
      text: 'Profits',
      offsetX: 20,
      style: {
          fontSize: '14px',
          color: '#8997bd',
      }
  }
}

new ApexCharts(document.querySelector("#spark3"), spark3).render();
  
</script>
  
  
</body>

</html>