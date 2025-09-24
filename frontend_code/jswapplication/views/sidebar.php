<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php $active=$this->uri->segment(1);
$active1=$this->uri->segment(2);
$active2=$this->uri->segment(3);
?>
 <?php echo $updatelogin;
    $uid = $detail[0]->userId;
  $compny = $detail[0]->companyid;
  $language = $detail[0]->language;
    ?>
<style>
body {
  font-family: "Lato", sans-serif;
}

/* Fixed sidenav, full height */
.sidenav {
  height: 100%;
  width: 206px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #f5f5f547;
  overflow-x: hidden;
  padding-top: 59px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: black;
  display: block;
  border: none;
  background: none;
  width: 221%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  background-color: darkblue;
  color: white;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  /*background-color: darkblue;*/
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: darkblue;
  padding-left: 8px;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 59px;}
  .sidenav a {font-size: 18px;}
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
<div class="sidenav">
  <div class="menu">
 <?php if($detail[0]->udashboard == 1){?><a  href="<?php echo base_url()?>dashboard" class="<?php if($active=='dashboard') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> Dashboard</a><?php }?>

  <?php if($detail[0]->tenmt == 1){?><a href="<?php echo base_url()?>tenmt" class="<?php if($active=='' || $active=='tenmt') echo 'active'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> SMS</a><?php }?>

<?php if($detail[0]->ufleetview == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='lists') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> List</a>
   
  </button>
  <div class="dropdown-container">
    <a href="<?php echo base_url()?>lists/index">Blast Furnace</a>
    <a href="<?php echo base_url()?>sms/index">SMS</a>
  </div>
 <?php }?>

 <?php if($detail[0]->ureports == 1){?><a href="<?php echo base_url()?>reports" class="<?php if($active=='reports') echo 'active'; ?>"><i class="fa fa-flag" aria-hidden="true"></i> Reports</a><?php }?>


 <?php if($detail[0]->companyid == 95){?>
        <?php if($detail[0]->uconfig == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='maintenance') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> Maintenance</a>
   
  </button>
  <div class="dropdown-container">
    <a href="<?php echo base_url()?>maintenance/index">Maintenance Details</a>
    <a href="<?php echo base_url()?>maintenance/breakdown">Breakdown Details</a>
    <a href="<?php echo base_url()?>maintenance/delay">Logistic Issues Details</a>
    <a href="<?php echo base_url()?>maintenance/inspectionDetails">Inspection Details</a>
    <a href="<?php echo base_url()?>maintenance/cleaningDumpDetails">Cleaning & Dumping Details</a>
  </div>
<?php }?>
    <?php }?>



 <?php if($detail[0]->companyid == 95){?>
        <?php if($detail[0]->uoperations == 1){?>
  <button class="dropdown-btn"><a href="#" class="<?php if($active=='operations') echo 'active'; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> Operations</a>
   
  </button>
  <div class="dropdown-container">
   <a href="<?php echo base_url()?>operations/cycling_noncycling">Circulation / Non Circulation</a>
   <a href="<?php echo base_url()?>operations/geofence_track">Create Track</a>
   <a href="<?php echo base_url()?>operations/carBattery">Battery Status</a>
   <a href="<?php echo base_url()?>operations/ladleload">Ladle Load Count</a>
   <a href="<?php echo base_url()?>operations/service">Next Service</a>
   <a href="<?php echo base_url()?>operations/master">Master Entry</a>
  </div>
<?php }?>
    <?php }?>
  <?php if($active=='' || $active=='dashboard'){//only dashboard?>
<button class="dropdown-btn" onclick="getAlertsData()"><a href="#" class="<?php if($active=='notification') echo 'active'; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> Notification</a>
  </button>

 <?php }?>
</div>
</div>

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
 <script type="text/javascript">
     function getAlertsData(){
          $.get("<?php echo base_url()?>dashboard/getServiceAlert", function(data){
            data = $.trim(data);
            if(data != ""){
              
              if($("#homeModal").hasClass("in")){
                
                $('#homeModal').modal('hide')
              }

              if($("#otherModal").hasClass("in")){
                
                $('#otherModal').modal('hide')
              }
              
              if(!$("#errorModal").hasClass("in")){
                
                $('#errorModal').modal('show')
              }
              $("#error-msg").html(data);
              //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
            }
          });
        }
   </script>
  
</body>
</html> 
