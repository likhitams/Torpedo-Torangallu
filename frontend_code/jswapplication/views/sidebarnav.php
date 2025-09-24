<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #cac7c747;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidebar a,.dropdown-btn{
  /*padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
  transition: 0.3s;*/

  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 20px;
  color: black;
  display: block;
  border: none;
  /*text-align: left;*/
  transition: 0.3s;
  /*background-color: white;*/
}
.active {
    background-color: darkblue;
    color: white;
}
.sidebar a:hover,.dropdown-btn:hover{
  background-color: darkblue;
  color:blue;
}

.sidebar .closebtn {
  position: absolute;
  top: 42px;
  right: 0px;
  font-size: 36px;
  margin-left: 50px;
  background-color: #f5f5f547;
  color: white;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #111;
  color: white;
  padding: 45px 13px;
  border: none;
  position: sticky;
    top: 23px;
    width: 53px;
    height: 63px;
}

.openbtn:hover {
  background-color: #444;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}
.sidebar .active {
  background-color: darkblue;
  color: white;
}
.dropdown-container {
  display: none;
  /*background-color: darkblue;*/
  padding-left: 8px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 60px;}
  .sidebar a {font-size: 18px;}
}
</style>
</head>
<body>
<?php $active=$this->uri->segment(1);
$active1=$this->uri->segment(2);
$active2=$this->uri->segment(3);
?>
 <?php echo $updatelogin;
    $uid = $detail[0]->userId;
  $compny = $detail[0]->companyid;
  $language = $detail[0]->language;
    ?>
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <?php if($detail[0]->udashboard == 1){?><a href="<?php echo base_url()?>dashboard" class="<?php if($active=='dashboard') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> DASHBOARD</a><?php }?>

  <?php if($detail[0]->tenmt == 1){?><a href="<?php echo base_url()?>tenmt" class="<?php if($active=='' || $active=='tenmt') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> SMS</a><?php }?>

<?php if($detail[0]->ufleetview == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='lists') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> LIST</a>
   
  </button>
  <div class="dropdown-container">
    <a href="<?php echo base_url()?>lists/index">BLAST FURNACE</a>
    <a href="<?php echo base_url()?>sms/index">SMS</a>
  </div>
 <?php }?>

 <?php if($detail[0]->ureports == 1){?><a href="<?php echo base_url()?>reports" class="<?php if($active=='reports') echo 'active'; ?>"><i class="fa fa-flag" aria-hidden="true"></i> REPORTS</a><?php }?>


 <?php if($detail[0]->companyid == 95){?>
        <?php if($detail[0]->uconfig == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='maintenance') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> MAINTENANCE</a>
   
  </button>
  <div class="dropdown-container">
    <a href="<?php echo base_url()?>maintenance/index">MAINTENANCE DETAILS</a>
    <a href="<?php echo base_url()?>maintenance/breakdown">BREAKDOWN DETAILS</a>
    <a href="<?php echo base_url()?>maintenance/delay">LOGISTIC ISSUES DETAILS</a>
    <a href="<?php echo base_url()?>maintenance/inspectionDetails">INSPECTION DETAILS</a>
    <a href="<?php echo base_url()?>maintenance/cleaningDumpDetails">CLEANING & DUMPING DETAILS</a>
  </div>
<?php }?>
    <?php }?>



 <?php if($detail[0]->companyid == 95){?>
        <?php if($detail[0]->uoperations == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='operations') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> OPERATIONS</a>
   
  </button>
  <div class="dropdown-container">
   <a href="<?php echo base_url()?>operations/cycling_noncycling">CIRCULATION / NON CIRCULATION</a>
   <a href="<?php echo base_url()?>operations/geofence_track">CREATE TRACK</a>
   <a href="<?php echo base_url()?>operations/carBattery">BATTERY STATUS</a>
   <a href="<?php echo base_url()?>operations/ladleload">LADLE LOAD COUNT</a>
   <a href="<?php echo base_url()?>operations/service">NEXT SERVICE</a>
   <a href="<?php echo base_url()?>operations/master">MASTER ENTRY</a>
  </div>
<?php }?>
    <?php }?>
  <?php if($active=='' || $active=='dashboard'){//only dashboard?>
<button class="dropdown-btn" onclick="getAlertsData()"><a href="#" class="<?php if($active=='notification') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> NOTIFICATION</a>
  </button>

 <?php }?>
</div>

<!-- <div id="main">
  <button class="openbtn" onclick="openNav()">☰ </button>  
  
</div> -->

<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
   
</body>
</html> 
