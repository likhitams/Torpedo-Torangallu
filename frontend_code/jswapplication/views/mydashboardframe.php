<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JSW Ladle</title>


    <title><?php echo title; ?></title>

    <!--   <link href="<?php echo asset_url() ?>css/bootstrap.css" rel="stylesheet"> -->
    <link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
    <!-- <link href="<?php echo asset_url() ?>css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo asset_url() ?>css/bootstrap-datepicker.css" rel="stylesheet">
 -->


    <link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />

    <style>
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
                                    <h3 class="my-2"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 order by lm.id ")); ?></h3>



                                    <div class="row">
                                        <div class="media align-items-center col-6">

                                            <div class="media-body align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">

                                                            <span class="badge badge-pink mb-1"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='1' order by lm.id ")); ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 25%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="media align-items-center col-6">

                                            <div class="media-body ml-3 align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">
                                                            <span class="badge badge-pink mb-1"><?php echo count($resLadle = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as ladleno FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=1 and lm.companyid = 95 and lm.phase='2' order by lm.id ")); ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 45%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    <h3 class="my-2"><?php echo count($resLoco = $this->master_db->runQuerySql("select REPLACE(CONCAT(unitname,' ->',location),'*','') as unitname from units where unitname like 'LOCO%' and companyid = 95 order by unitname ")); ?></h3>


                                    <div class="row">
                                        <div class="media align-items-center col-6">

                                            <div class="media-body align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - I</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">

                                                            <span class="badge badge-purple mb-1">4</span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-purple" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="media align-items-center col-6">

                                            <div class="media-body ml-3 align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">
                                                            <span class="badge badge-purple mb-1">4</span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-purple" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
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

                                                            <span class="badge badge-warning mb-1"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='1' order by lm.id")); ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 45%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="media align-items-center col-6">

                                            <div class="media-body ml-3 align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">
                                                            <span class="badge badge-warning mb-1"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid =95 and lm.phase='2' order by lm.id")); ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
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
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
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
                                        <!-- <form action="#" method="get">
                                            <input type="search" id="search-box" name="search" class="srt from-control top-search mb-0" placeholder="Search here...">
                                            <div id="suggesstion-box"></div>
                                            <button type="submit"><i class="ti-search"></i></button>
                                        </form> -->


                                        <div class="frmSearch">
          <input type="text" id="search-box" placeholder="Search By Ladle"/>
          <div id="suggesstion-box"></div>
          
          </div>

          
                                    </div>




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
                                            <td>Before Weighment</li>
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
                                                                                                                                echo $tot[0]->NET_WEIGHT; ?></span></td>
                                            <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 and phase='1'");
                                                                                                                                echo $tot[0]->NET_WEIGHT; ?></span></td>
                                            <td class="text-center"><span class="count gren_c monospace badge badge-success"><?php $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95  and phase='2'");
                                                                                                                                echo $tot[0]->NET_WEIGHT; ?></span></td>


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
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
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
                                    <td>

                                        <ul class="well">
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 03 -&gt;At Tap Hole 3 </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 05 -&gt;At SMS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 06 -&gt;At TLHS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 07 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 08 -&gt;At Tap Hole 2 </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 10 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 11 -&gt;At Gate 2 Crossing (BF Side) </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 13 -&gt;At Weigh Bridge </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 14 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 15 -&gt;At Tap Hole 2 </span></li>
                                        </ul>
                                    </td>
                                    <td>

                                        <ul class="well">
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 03 -&gt;At Tap Hole 3 </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 05 -&gt;At SMS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 06 -&gt;At TLHS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 07 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 08 -&gt;At Tap Hole 2 </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 10 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 11 -&gt;At Gate 2 Crossing (BF Side) </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 13 -&gt;At Weigh Bridge </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="load"><span class="dot"></span>TLC 14 -&gt;At TLRS </span></li>
                                            <li style="padding: 3px 9px !important;"><span class="empty"><span class="dot"></span>TLC 15 -&gt;At Tap Hole 2 </span></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>




                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->





            <div class="modal fade bd-example-modal-xl-loco" id="bd-example-modal-xl-loco" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">LOCO</h6>
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
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
                                    <td>
                                        <ul class="well">


                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-1 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-2 -&gt;At TLRS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-3 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-4 -&gt;At SGP Conveyor </span></li>

                                        </ul>
                                    </td>

                                    <td>
                                        <ul class="well">


                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-1 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-2 -&gt;At TLRS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-3 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="loco"><span class="dot"></span>LOCO-4 -&gt;At SGP Conveyor </span></li>

                                        </ul>
                                    </td>
                                </tr>
                            </table>



                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->






            <div class="modal fade bd-example-modal-xl-main" id="bd-example-modal-xl-main" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">Maintenance</h6>
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
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


                                    <td>
                                        <ul class="well">




                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 01 -&gt;At SMS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 02 -&gt;At Gate 3 crossing (sms side) </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 04 -&gt;At Tap Hole 3 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 09 -&gt;0.15 KM W of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 12 -&gt;0.20 KM SW of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span></span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span></span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 30 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 31 -&gt;0.21 KM SW of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 33 -&gt;At TLHS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 34 -&gt;At TLRS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 35 -&gt;</span></li>


                                        </ul>
                                    </td>

                                    <td>
                                        <ul class="well">




                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 01 -&gt;At SMS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 02 -&gt;At Gate 3 crossing (sms side) </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 04 -&gt;At Tap Hole 3 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 09 -&gt;0.15 KM W of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 12 -&gt;0.20 KM SW of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span></span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span></span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 30 -&gt;At Weigh Bridge </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 31 -&gt;0.21 KM SW of PCM2 </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 33 -&gt;At TLHS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 34 -&gt;At TLRS </span></li>

                                            <li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span>TLC 35 -&gt;</span></li>


                                        </ul>
                                    </td>


                                </tr>
                            </table>

                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->









            <div class="modal fade bd-example-modal-xl-sms" id="bd-example-modal-xl-sms" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">SMS Received</h6>
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
                        </div><!--end modal-header-->
                        <div class="modal-body">


                            <div class="chart-demo">
                                <div class="pol3"></div>
                            </div>



                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->



            <div class="modal fade bd-example-modal-xl-bfs" id="bd-example-modal-xl-bfs" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">BF PRODUCTION</h6>
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
                        </div><!--end modal-header-->
                        <div class="modal-body">


                            <div class="chart-demo">
                                <div class="pol4"></div>
                            </div>



                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
                        </div><!--end modal-footer-->
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->














            <div class="modal fade bd-example-modal-xl" id="bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0" id="myExtraLargeModalLabel">Tap Hole</h6>
                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-times"></i></span>
                            </button>
                        </div><!--end modal-header-->
                        <div class="modal-body">

                            <p id="error-msg7">

                            <div class="taphole row">

                                <div class="col-md-6">
                                    <table class="table table-bordered table-taphole">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-center">Taphole-1</th>

                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (CR Side) </td>
                                                <td align="right">
                                                    % </td>

                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (DP Side) </td>
                                                <td align="right">
                                                    %</td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (CR Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (DP Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">

                                    <table class="table table-bordered table-taphole">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-center">Taphole-2</th>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (CR Side) </td>
                                                <td align="right">
                                                    % </td>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (DP Side) </td>
                                                <td align="right">
                                                    %</td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (CR Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (DP Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">

                                    <table class="table table-bordered table-taphole">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-center">Taphole-3</th>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (CR Side) </td>
                                                <td align="right">
                                                    % </td>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (DP Side) </td>
                                                <td align="right">
                                                    %</td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (CR Side) </td>
                                                <td align="right"> </td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (DP Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-taphole">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-center">Taphole-4</th>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (CR Side) </td>
                                                <td align="right">
                                                    % </td>
                                            </tr>
                                            <tr>
                                                <td>Percentage of Filling (DP Side) </td>
                                                <td align="right">
                                                    %</td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (CR Side) </td>
                                                <td align="right"> </td>
                                            </tr>
                                            <tr>
                                                <td>Torpedo Number (DP Side) </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
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

                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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

                                                            <span class="badge badge-pink text-white mb-1"><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=1"));
                                                                                                            echo $bf[0]->BF_PROD; ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 5%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="media align-items-center col-12 mt-4 pt-1">

                                            <div class="media-body  align-self-center">
                                                <p class="text-dark mb-1 font-weight-semibold">Phase - II</p>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <a class="" href="#">
                                                            <span class="badge badge-pink text-white mb-1"><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(lr.NET_WEIGHT) BF_PROD FROM laddle_report lr inner join ladle_master lm on lm.id=lr.ladleid WHERE lr.GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00') and lm.phase=2"));
                                                                                                            echo $bf[0]->BF_PROD; ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 5%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                                                            $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); ?></span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 5%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                                                            $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') and GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  ")); ?> </span>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="progress mt-0" style="height:3px;">
                                                    <div class="progress-bar bg-pink" role="progressbar" style="width: 5%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    <p class="text-dark mb-1 font-weight-semibold">BF Production and SMS Receive <small> (24th 10PM to 25 10PM)</small> </p>


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
                                                    ?></td>
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
                                        <tr>

                                            <tbody>
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
            echo $bf[0]->BF_PROD; ?></td>
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
                    <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>

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
                    <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>
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
                    <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>

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
                    <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>

                </div>
            </div>
        </div>
    </div>



    <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView ?>">
    </div>


    


    <?php echo $jsfile; ?>

    







<script type="text/javascript">
    

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


      }

      return text;
    }
  </script>

  <script>


$(document).ready(function(){
            $("#search-box").keyup(function(){
              $("#search-box1").val('');
              $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>dashboard/searchController",
                data:'keyword='+$(this).val(),
                beforeSend: function(){
                  $("#search-box").css("background","#FFF no-repeat 165px");
              },
              success: function(data){
                  $("#suggesstion-box").show();
                  $("#suggesstion-box").html(data);
                  $("#search-box").css("background","#FFF");
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
             httpRequest.open('GET', '<?php echo jquery_url()?>lists/getSearch?unit='+val);
             httpRequest.send();
             // alert(val);
             httpRequest.onreadystatechange = function() {
               // alert(httpRequest.status);
               if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    // alert("<<>>>"+httpRequest.responseText);
                    httpResponse = JSON.parse(httpRequest.responseText);
                    // alert(httpResponse);
                    httpResponse.forEach( function(data, index) {
                        // alert(httpResponse);
                        ladleno=data.ladleno;  
                        TAPNO=data.TAPNO;
                        LOAD_DATE=data.LOAD_DATE;
                        SOURCE=data.SOURCE;
                        DEST=data.DEST;
                        SI=data.SI;
                        S=data.S;
                        TEMP=data.TEMP;
                        GROSS_WEIGHT=data.GROSS_WEIGHT;
                        TARE_WEIGHT=data.TARE_WEIGHT;
                        NET_WEIGHT=data.NET_WEIGHT;
                        idlet=data.idlet;
                        smstime=data.smstime;
                        TARE_WT2=data.TARE_WT2;

                      // alert(idlet);
                      // alert(TARE_WT2);

                      latitude=data.latitude;
                      longitude=data.longitude;
                      unitname=data.unitname;
                      direction=data.direction;
                      statuses=data.statusColor;
                    // alert(statuses);
                    // indent=data.indent;
                    // routenumber=data.routenumber;
                    // driver=data.driver;
                    // mobile=data.drivermobile;
                    dist=data.distance;
                    // work=data.totalhrs;
                    reporttime=data.reporttime1;
                    statusdesc=data.statusdesc;
                   // duty= data.duty;
                   loc = data.locationname;
                 // vtype = data.vtype;
                 idel = data.timehours;
                 
                 // alert(work);

                 if (idel=="00:00:00")
                 {
                     idel="";
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
                if(CCOUNT >= 0){
                  if(count >= 0){
                    $("#countdown1").html(count);
                }
            }
            else{
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
                    if(CCOUNT > 0){
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
</script>
</body>

</html>