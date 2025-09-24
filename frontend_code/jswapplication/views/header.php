<?php $active = $this->uri->segment(1);
$active1 = $this->uri->segment(2);
$active2 = $this->uri->segment(3);
?>
<?php echo $updatelogin;
$uid = $detail[0]->userId;
$compny = $detail[0]->companyid;
$language = $detail[0]->language;
?>

<div class="left-sidenav">

  <div class="brand">
    <a href="<?php echo base_url() ?>dashboard" class=" logo">
      <span>
        <img src="<?php echo base_url(); ?>assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
      </span>

    </a>
  </div>

  <div class="menu-content h-100" data-simplebar>
    <ul class="metismenu left-sidenav-menu">
      <li><?php if ($detail[0]->udashboard == 1) { ?><a href="<?php echo base_url() ?>dashboard"> <i data-feather="grid" class="align-self-center menu-icon <?php if ($active == 'dashboard') echo 'active'; ?>"></i><span>Dashboard</span></a><?php } ?>
      </li>

     
      <li>
         <li><?php if ($detail[0]->ufleetview == 1) { ?><a href="<?php echo base_url() ?>lists/index"> <i data-feather="grid" class="align-self-center menu-icon <?php if ($active == 'lists') echo 'active'; ?>"></i><span>List</span></a><?php } ?></li>
         <li><?php if ($detail[0]->retrac == 1) { ?><a href="<?php echo base_url()?>retrac" class="<?php if ($active == 'retrac') echo 'active'; ?>"> <i data-feather="file" class="align-self-center menu-icon"></i><span>ReTrac</span></a><?php } ?></li>
    

      <li><?php if ($detail[0]->ureports == 1) { ?><a href="<?php echo base_url() ?>reports" class="<?php if ($active == 'reports') echo 'active'; ?>"> <i data-feather="file" class="align-self-center menu-icon"></i><span>Reports</span></a><?php } ?></li>


      <li>
        <?php if ($detail[0]->companyid == 95) { ?>
          <?php if ($detail[0]->uconfig == 1) { ?>
            <a href="javascript: void(0);" class="<?php if ($active == 'maintenance') echo 'active'; ?>"><i data-feather="layers" class="align-self-center menu-icon"></i><span>Maintenance</span><span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/index"><i class="fa-regular fa-circle-dot"></i>Maintenance Details</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/breakdown"><i class="fa-regular fa-circle-dot"></i>Breakdown Details</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/delay"><i class="fa-regular fa-circle-dot"></i>Logistic Issues Details</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/ladleStatus"><i class="fa-regular fa-circle-dot"></i>Torpedo Status</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/dumpDetails"><i class="fa-regular fa-circle-dot"></i>Dumping Details</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/gf_master"><i class="fa-regular fa-circle-dot"></i>GF Threshold & Entry-Exit</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/ladlemaintenance"><i class="fa-regular fa-circle-dot"></i>Ladle Maintenance Details</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>maintenance/geofence10mt"><i class="fa-regular fa-circle-dot"></i>breakss</a></li> -->
            </ul>
          <?php } ?>
        <?php } ?>
      </li>

         <li>
        <?php if ($detail[0]->companyid == 95) { ?>
          <?php if ($detail[0]->uoperations == 1) { ?>
            <a href="javascript: void(0);" class="<?php if ($active == 'operations') echo 'active'; ?>"><i data-feather="settings" class="align-self-center menu-icon"></i><span>Operations</span><span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/cycling_noncycling"><i class="fa-regular fa-circle-dot"></i>Circulation / Non Circulation</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/geofence_track"><i class="fa-regular fa-circle-dot"></i>Create Track</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/carBattery"><i class="fa-regular fa-circle-dot"></i>Battery Status</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/ladleload"><i class="fa-regular fa-circle-dot"></i>Ladle Load Count</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/service"><i class="fa-regular fa-circle-dot"></i>Next Service</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>operations/master"><i class="fa-regular fa-circle-dot"></i>Master Entry</a></li> -->
            </ul>
          <?php } ?>
        <?php } ?>
      </li>


    </ul>


  </div>
</div>


<div class="page-wrapper">

  <div class="topbar">

    <nav class="navbar-custom">
      <ul class="list-unstyled topbar-nav float-right mb-0">
        <?php if($active=='' || $active=='dashboard'){?>
        <!-- <li class="pt-4 mr-2">
          <a href="#tapload" class="btn btn-sm btn-primary dropdown-toggle">
            Tap Hole & BF Production
          </a>

        </li> -->


        <li class="pt-4 mr-2">
          <a href="#" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="hide-cir">Map View</span> <span class="show-cir">Map View</span>
          </a>

        </li>



        <li class="pt-4 mr-2">
          <a href="#" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="hide-data">Hide Data</span> <span class="show-data">Show data</span>
          </a>
        </li>
    <?php } ?>

		<?php if(0){ ?>
        <li class="dropdown notification-list">
         
          <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <i data-feather="bell" class="align-self-center topbar-icon"></i>
            <span class="badge badge-danger badge-pill noti-icon-badge">
           

          233333


            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
            <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
              Notifications <span class="badge badge-primary badge-pill">889888</span>
            </h6>
            99898
            <div class="notification-menu" data-simplebar>
              
                <a href="#" class="dropdown-item py-3">
                  <small class="float-right text-muted pl-2"></small>
                  <div class="media">
                    <div class="avatar-md bg-soft-primary">
                      <img src="<?php echo base_url();?>assets/images/tlc.png" alt="" width="14px">
                     
                    </div>
                    <div class="media-body align-self-center ml-2 text-truncate">

                      <h6 class="my-0 font-weight-normal text-dark">Service is due on 5656</h6>
                      <small class="text-muted mb-0">55555</small>
                    </div><!--end media-body-->
                  </div><!--end media-->
                </a><!--end-item-->
                <!-- item-->
                    
                    <h4 class="notification_l">Empty Torpedo Signal Alerts:</h4>
                    

                <a href="#" class="dropdown-item py-3">
                  <small class="float-right text-muted pl-2"></small>
                  <div class="media">
                    <div class="avatar-md bg-soft-primary">
                    <img src="<?php echo base_url();?>assets/images/track.png" alt="" width="17px">
                    </div>
                    <div class="media-body align-self-center ml-2 text-truncate">
                      <h6 class="my-0 font-weight-normal text-dark">858</h6>
                      <small class="text-muted mb-0"> Ready to Go.. Time @ 220000</small>
                    </div>
                  </div>
                <?php
              
                ?>
                </a> 
            </div>

          </div>
         
        </li>
		<?php } ?>

        <li class="dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <a class="dropdown-item" href="<?php echo base_url() ?>dashboard/logout"><i data-feather="power" class="align-self-center icon-xs icon-dual mr-1"></i> Logout</a>
            <!-- <img src="<?php echo base_url(); ?>assets/images/users/user-5.jpg" alt="profile-user" class="rounded-circle" /> -->
          </a>
          <!-- <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo base_url() ?>dashboard/logout"><i data-feather="power" class="align-self-center icon-xs icon-dual mr-1"></i> Logout</a>
          </div> -->
        </li>
      </ul><!--end topbar-nav-->

      <ul class="list-unstyled topbar-nav mb-0">
        <li>
          <button class="nav-link button-menu-mobile">
            <i data-feather="menu" class="align-self-center topbar-icon"></i>
          </button>
        </li>

      </ul>
    </nav>
    <!-- end navbar-->
  </div>