<!DOCTYPE html>
<html lang="en" style="overflow: hidden;">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>JSW Ladle</title>


<title><?php echo title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet"> 
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/bootstrap-datepicker.css" rel="stylesheet">
    
    <style>
.card .card-title {
    color: #010101;
    margin-bottom: 1.2rem;
    text-transform: capitalize;
    font-size: 1.125rem;
    font-weight: 600;
}
    
/*html, body,*/ #map  {
       height: 100%;
    margin-top: 47px;
    padding: 290px;
    width: 179%;
    min-width: 180%;
    margin-left: -9PX;


}


      
  .gm-style{
        
      }
      
      .upt{
        display:none;
      }
      
      


/*.gm-style-iw > div {
    display: list-item;
    width: 100%;
}*/
.gm-style div {
}
/*.scrollFix img {
    position: absolute;
    right: -18px;
    top: 3px;
}*/

      
    .gm-style-cc {
      display: none;
    }
    .gmnoprint {
      position: absolute;
      top: 0;
      left: 0;
    }
   /* 
    html, body{
  overflow:hidden;
}*/

  .refresh {
      background-color: #fff;
      border-radius: 100%;
      bottom: 10px;
      box-shadow: 0 0 12px -1px #505050;
      cursor: pointer;
      font-size: 18px;
      height: 50px;
      padding: 13px;
      position: absolute;
      right: 10px;
      text-align: center;
      width: 50px;
      z-index: 999;
  }
  
  .taphole{
    /*position:absolute;*/
    left:0;
    bottom:150px;
    width:460px;
    z-index:9;
  }
  
  .tap_hole1{
    /*position:absolute;*/
    left:0;
    bottom:20px;
    width:460px;
    z-index:9;
  }
  
  .table-taphole{
    margin:0;
    float:left;
    width:50%;
    /*border:1px solid #333;*/
    margin:-1px;
  }
  .table-taphole1{
    margin:0;
    float:left;
    width:100%;
    /*border:1px solid #333;*/
    margin:-1px;
    z-index:9;
  }
  .table-taphole td{
    background-color: #dddddd;
    border: none!important;
    font-size:12px;
    font-weight:500;
  }
  .table-taphole1 td{
    background-color: #dddddd;
    border: none!important;
    font-size:12px;
    font-weight:500;
  }
  .table-taphole th{
    background-color: #9bc2e6;
    color:#333;
    font-weight:600;
    font-size:11px;
  }
  .table-taphole1 th{
    background-color: #9bc2e6;
    color:#333;
    font-weight:600;
    font-size:11px;
  }
  
  .refresh:hover {
      background-color: #005596;
    color:#fff;
  }
  
  .refresh:hover i {
      transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
  }
  .refresh i {
      transition: all 0.5s ease 0s;
    -o-transition: all 0.5s ease 0s;
    -moz-transition: all 0.5s ease 0s;
    -ms-transition: all 0.5s ease 0s;
    -webkit-transition: all 0.5s ease 0s;
  }
    
  .gm-style div {
   /*margin-top: 20px;*/
}
.battery_icon {
    position: absolute;
    right: 25px;
    top: 2px;
}

.battery_icon > img {
    width: 12px;
}

.gm-style div {
    border-radius: 14px!important;
}
  
.gmnoprint{
  display: none;
} 
    
 
  </style>
  <!-- frame style -->
<style type="text/css">
  .card-box {
    position: relative;
    /*color: #fff;*/
    padding: 20px 10px 40px;
    margin: 20px 0px;
}
.card-box:hover {
    text-decoration: none;
    color: black;
}
.card-box:hover .icon i {
    font-size: 100px;
    transition: 1s;
    -webkit-transition: 1s;
}
.card-box .inner {
    padding: 5px 10px 0 10px;
}
.card-box h3 {
    font-size: 27px;
    font-weight: bold;
    margin: 0 0 8px 0;

    white-space: nowrap;
    padding: 0;
    text-align: left;
}
.card-box p {
    font-size: 15px;
}
.card-box .icon {
    position: absolute;
    top: auto;
    bottom: 5px;
    right: 5px;
    z-index: 0;
    font-size: 72px;
    color: rgba(0, 0, 0, 0.15);
}
.card-box .card-box-footer {
    position: absolute;
    left: 0px;
    bottom: 0px;
    text-align: center;
    padding: 3px 0;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(0, 0, 0, 0.1);
    width: 100%;
    text-decoration: none;
}
.card-box:hover .card-box-footer {
    background: rgba(0, 0, 0, 0.3);
}
.bg-blue {
    background-color: #00c0ef !important;
}
.bg-green {
    background-color: #00a65a !important;
}
.bg-orange {
    background-color: #f39c12 !important;
}
.bg-red {
    background-color: #d9534f !important;
}
.row1{
    display: flex;
    /* flex-wrap: wrap; */
    margin-right: 251px;
    margin-left: -26px;
    margin-top: 45px;
}
.main-panel {
  transition: width 0.25s ease, margin 0.25s ease;
  width: calc(119% - -7px)!important;
  min-height: calc(100vh - 60px);
  display: -webkit-flex;
  display: flex;
  -webkit-flex-direction: column;
  flex-direction: column;
}
.rowc {
    display: flex;
    flex-wrap: wrap;
    margin-right: 177px;
    margin-left: -23px;
}
.stretch-card > .card {
    width: 100%;
    min-width: 100%;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e3e3e3;
    border-radius: 20px;
}
.grid-margin {
    margin-bottom: 2.5rem;
}
@media (min-width: 768px)
.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
.col-md-6
{
    position: relative;
    min-height: 1px;
    padding-right: 203px;
    padding-left: 11px;
}
.card {
     box-shadow: none; 
     -webkit-box-shadow: none; 
    -moz-box-shadow: none;
    -ms-box-shadow: none;
     transition: background 0.25s ease; 
     -webkit-transition: background 0.25s ease; 
    -moz-transition: background 0.25s ease;
    -ms-transition: background 0.25s ease;
    border: none;
}
.card .card-body {
    padding: 1.25rem 1.25rem;
}
/*.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}*/
.container-scroller
{
  overflow-x: hidden;
}
</style>

</head>
<body>
 <div>
        
         <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
   
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


.loggingout {
    float: right;
    position: relative;
}

.log_b {
    background-color: unset;
    border-left: 1px solid #e5e5e5;
    color: #fff;
    cursor: pointer;
    float: right;
    font-size: 18px;
    padding: 12px 30px;
    text-transform: uppercase;
}

.log_b:hover ul {
    display: none;
}

.loggingout:hover ul {
    display: none;
}

.monospace {
  font-family: Lucida Console, Courier, monospace;
  font-weight: bolder;
}


.drop_m{
  width: 335px;
}

.circulation ul li{
              display:inline-block;
              float:none;
          }
          
          .well{
              border:none;
              padding:8px;
          }
          
          .circulation .well {
        max-height: 522px;
        overflow: hidden;
    }
</style>



    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      -->
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


.loggingout {
    float: right;
    position: relative;
}

.log_b {
    background-color: unset;
    border-left: 1px solid #e5e5e5;
    color: #fff;
    cursor: pointer;
    float: right;
    font-size: 18px;
    padding: 12px 30px;
    text-transform: uppercase;
}

.log_b:hover ul {
    display: none;
}

.loggingout:hover ul {
    display: none;
}

.monospace {
  font-family: Lucida Console, Courier, monospace;
  font-weight: bolder;
}


.drop_m{
  width: 335px;
}

.circulation ul li{
              display:inline-block;
              float:none;
          }
          
          .well{
              border:none;
              padding:8px;
          }
          
          .circulation .well {
        max-height: 522px;
        overflow: auto;
    }


#map{
  margin: 0!important;
    height: 100%;
    padding: 290px;
    width: 100%;
    min-width: 100%;
  }
</style>
<!-- <style type="text/css">
  .frmSearch {border: 0px solid #a8d4b1;border-radius:4px;}
#unit-list{float:left;list-style:none;margin-top:-6px;padding:0;width:180px;position: inherit;}
#unit-list li{padding: 5px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#unit-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style> -->
  
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<!-- plugins:js -->
        <!-- </div> -->
 </div>


<?php echo $updatelogin;
    
    $uid = $detail[0]->userId;
    $compny = $detail[0]->companyid;
    $language = $detail[0]->language;
    
    
    ?>
    <style type="text/css">
    /* fix for unwanted scroll bar in InfoWindow */
  .scrollFix {
    line-height: 1.35;
    overflow: hidden;
    white-space: nowrap;
  }
    </style>
    
   
  </head>
  <body onload="getData();">




    <div id="map"></div>
     

<!-- <div id="taphole_div"></div> -->
   <!-- <div id="map"></div> -->
   <!-- <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView?>">
     -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBp3xMZSQ1GPHvxzrx_WCE15EjPDtXQ2ng"></script>
    
    <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
    <script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
    <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>


<?php echo $jsfile;?>
<script type="text/javascript" src="<?php echo asset_url();?>js/staticConstants.js"></script>
 <script>
 var mapView;
 var on = true;
  var baseUrl = '<?php echo jquery_url()?>assets/direction_icons1/';
    var httpResponse, map, activeInfoWindow ; 
    var gmarkers = [], newFeature = [];
    var lineCoordinates=new Array();
    var polyArr=new Array(), mapPolyLabelArr = new Array(), statusesArr = new Array();
    var latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array();
    var latitude,longitude,unitname,direction,statuses,indent,routenumber,driver,mobile,dist,work,statusdesc,duty,loc,vtype,idel,reporttime;

    function getData(){
      var httpRequest = new XMLHttpRequest();
      httpRequest.open('GET', '<?php echo jquery_url()?>lists/getListdata');
      httpRequest.send();
      httpRequest.onreadystatechange = function() {
          if (httpRequest.readyState == 4 && httpRequest.status == 200) {
            //alert(httpRequest.responseText);
              httpResponse = JSON.parse(httpRequest.responseText);
              httpResponse.forEach( function(data, index) { 
            latitudeArr.push(data.latitude);
            longitudeArr.push(data.longitude);
            unitnameArr.push(data.unitname);  
            regArr.push(data.registration);
            statusesArr.push(data.LOAD_STATUS);
            cdreset();
          });
                 // console.log(httpResponse);
              initMap();       
        //getEmptySignalAlertsData();
        refreshCountList();
          }
      };
    }
  
  function getEmptySignalAlertsData(){
          $.get("<?php echo base_url()?>dashboard/getMovedFilesAlert", function(data){
            data = $.trim(data);
            if(data != ""){
              
              if($("#homeModal").hasClass("in")){
                
                $('#homeModal').modal('hide')
              }

              if($("#otherModal").hasClass("in")){
                
                $('#otherModal').modal('hide')
              }
              
              if(!$("#errorModal4").hasClass("in")){
                
                $('#errorModal4').modal('show')
              }
              $("#error-msg4").html(data);
              $("#shake_text").effect( "shake" , {times:1, direction:"up", distance:1000});
            }
          });
        }

    var CCOUNT = 15;
    
    var t, count, timer;
    
    function cddisplay() {
        // displays time in span
        if(CCOUNT >= 0){
          if(count >= 0){
          $("#countdown").html(count);
          }
        }
        else{
          $("#countdown").html("");
        }
    };
    
    function countdown() {
        // starts countdown
        cddisplay();
       // console.log(count);
        if (count < 0) {
            // time is up
            if(CCOUNT > 0){
              refreshMarkers();
        //getEmptySignalAlertsData();
              refreshCountList();
            }
            
        } else {
            count--;
            t = setTimeout("countdown()", 1000);
        }
    };
    
    function cdpause() {
        // pauses countdown
        clearTimeout(t);
    };
    
    function cdreset() {
        // resets countdown               
        cdpause();
        CCOUNT = 15;
        count = CCOUNT;
        cddisplay();
        countdown();
    };

    function refreshMarkers(){
    var bounds = new google.maps.LatLngBounds();
    //alert(gmarkers.length);
      // delete all existing markers first
      //removeElementsByClass('infoBox');
      
      lineCoordinates = [];
      // add new markers from the JSON data
      listMarkers();
      //console.log(gmarkers.length);
      cdreset();
      
  }

    function refreshCountList(){
    // $.get("<?php echo base_url()?>dashboard/getListCount", function(data){
    //   $("#refCount").html(data);
    // });
    
    // $.get("<?php echo base_url()?>dashboard/getTaphole", function(data){
    //   $("#taphole_div").html(data);
    // });

    //  $.get("<?php echo base_url()?>dashboard/getproductiondetails", function(data){
    //   $("#productiondetails_div").html(data);
    // });
    //  $.get("<?php echo base_url()?>dashboard/tablephase", function(data){
    //   $("#tablephase_div").html(data);
    // });
  }

 // ------------------------------------------------------------------------------- //
  // create markers on the map tooltip
  // ------------------------------------------------------------------------------- //
  function fnPlaceMarkers(markermap, textplace){
    
     
    // create an InfoWindow - for mouseover
    var infoWnd = new google.maps.InfoWindow();           

    // create an InfoWindow -  for mouseclick
    var infoWnd2 = new google.maps.InfoWindow();
    
    // -----------------------
    // ON MOUSEOVER
    // -----------------------
    
    // add content to your InfoWindow
    infoWnd.setContent('<div class="scrollFix">' + textplace + '</div>');
    //infoWnd.setContent('<div class="scrollFix"><h3>Laddle no 12 <span class="battery_icon"><img src="http://ivarustech.com/jsw/assets/images/battery_f.png"/></span></h3><ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul></div>');
    //console.log(markermap);
    // add listener on InfoWindow for mouseover event
    

   
    google.maps.event.addListener(markermap, 'mouseover', function() {
      //alert("");
      
      // Close active window if exists - [one might expect this to be default behaviour no?]        
      if(activeInfoWindow != null) activeInfoWindow.close();

      // Close info Window on mouseclick if already opened
      infoWnd2.close();
    
      // Open new InfoWindow for mouseover event
      infoWnd.open(map, markermap);
      
      // Store new open InfoWindow in global variable
      activeInfoWindow = infoWnd;   
      closeImageBtn();    
    });               
    
    // on mouseout (moved mouse off marker) make infoWindow disappear
    google.maps.event.addListener(markermap, 'mouseout', function() {
       
      infoWnd.close();  
    });
    
    // --------------------------------
    // ON MARKER CLICK - (Mouse click)
    // --------------------------------
    
    // add content to InfoWindow for click event 
    infoWnd2.setContent('<div class="scrollFix">' + textplace + '</div>');
    //infoWnd2.setContent('<div class="scrollFix"><h3>Laddle no 12 <span class="battery_icon"><img src="http://ivarustech.com/jsw/assets/images/battery_f.png"/></span></h3><ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul></div>');
    
    // add listener on InfoWindow for click event
    google.maps.event.addListener(markermap, 'click', function() {
       
      //Close active window if exists - [one might expect this to be default behaviour no?]       
      if(activeInfoWindow != null) activeInfoWindow.close();

      // Open InfoWindow - on click 
      infoWnd2.open(map, markermap);
      
      // Close "mouseover" infoWindow
      infoWnd.close();
      
      // Store new open InfoWindow in global variable
      activeInfoWindow = infoWnd2;
      closeImageBtn();
    });               
    
  }

  function laddlecarIcons(ladleid, Color){
       var directionIcon = "";
               

       if(ladleid==1)
       {
          directionIcon = baseUrl+"Ladle/"+Color+'/1.png';
          // alert(directionIcon);
       }
       else if(ladleid==2)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/2.png';
       }
       else if(ladleid==3)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/3.png';
       }
       else if(ladleid==4)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/4.png';
       }
       else if(ladleid==5)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/5.png';
// alert(">>>>"+directionIcon);
       }
       else if(ladleid==6)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/6.png';
       }
       else if(ladleid==7)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/7.png';
       }
       else if(ladleid==8)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/8.png';
       }
       else if(ladleid==9)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/9.png';
       }
       else if(ladleid==10)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/10.png';
       }
       else if(ladleid==11)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/11.png';
       }
       else if(ladleid==12)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/12.png';
       }
       else if(ladleid==13)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/13.png';
       }
       else if(ladleid==14)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/14.png';
       }
       else if(ladleid==15)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/15.png';
       }
       else if(ladleid==16)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/16.png';
       }
       else if(ladleid==17)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/17.png';
       }
       else if(ladleid==18)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/18.png';
       }
       else if(ladleid==19)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/19.png';
       }
       else if(ladleid==20)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/20.png';
       }
       else if(ladleid==21)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/21.png';
         // alert(directionIcon);
       }
       else if(ladleid==22)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/22.png';
       }
       else if(ladleid==23)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/23.png';
       }
       else if(ladleid==24)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/24.png';
       }
       else if(ladleid==25)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/25.png';
       }
       else if(ladleid==26)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/26.png';
       }
       else if(ladleid==27)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/27.png';
       }
       else if(ladleid==28)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/28.png';
       }
       else if(ladleid==29)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/29.png';
       }
       else if(ladleid==30)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/30.png';
       }
       else if(ladleid==31)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/31.png';
       }
       else if(ladleid==32)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/32.png';
       }
       else if(ladleid==33)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/33.png';
       }
       else if(ladleid==34)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/34.png';
       }
       else if(ladleid==35)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/35.png';
       }
       else if(ladleid==136)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/1.png';
         // alert(directionIcon);
       }
       else if(ladleid==137)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/2.png';
       }
       else if(ladleid==138)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/3.png';
       }
       else if(ladleid==139)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/4.png';
       }
       else if(ladleid==140)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/5.png';
       }
       else if(ladleid==141)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/6.png';
       }
       else if(ladleid==142)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/7.png';
       }
       else if(ladleid==143)
       {
         directionIcon = baseUrl+"Ladle/"+Color+'/8.png';
       }


      // if(348.75 < mapDirection && mapDirection <= 360)
      //   directionIcon = baseUrl+Color+'/1.png';
      // else if(0 <= mapDirection && mapDirection <= 11.25)
      //   directionIcon = baseUrl+Color+'/1.png'; 
      // else if(11.25 < mapDirection && mapDirection <= 33.75)
      //   directionIcon = baseUrl+Color+'/2.png';
      // else if(33.75 < mapDirection && mapDirection <= 56.25)
      //   directionIcon = baseUrl+Color+'/3.png';
      // else if(56.25 < mapDirection && mapDirection <= 78.75)
      //   directionIcon = baseUrl+Color+'/4.png';
      // else if(78.75 < mapDirection && mapDirection <= 101.25)
      //   directionIcon = baseUrl+Color+'/5.png';   
      // else if(101.25 < mapDirection && mapDirection <= 123.75)
      //   directionIcon = baseUrl+Color+'/6.png';
      // else if(123.75 < mapDirection && mapDirection <= 146.25)
      //   directionIcon = baseUrl+Color+'/7.png';
      // else if(146.25 < mapDirection && mapDirection <= 168.75)
      //   directionIcon = baseUrl+Color+'/8.png';
      // else if(168.75 < mapDirection && mapDirection <= 191.25)
      //   directionIcon = baseUrl+Color+'/9.png';
      // else if(191.25 < mapDirection && mapDirection <= 213.75)
      //   directionIcon = baseUrl+Color+'/10.png';
      // else if(213.75 < mapDirection && mapDirection <= 236.25)
      //   directionIcon = baseUrl+Color+'/11.png';
      // else if(236.25 < mapDirection && mapDirection <= 258.75)
      //   directionIcon = baseUrl+Color+'/12.png';
      // else if(258.75 < mapDirection && mapDirection <= 281.25)
      //   directionIcon = baseUrl+Color+'/13.png';
      // else if(281.25 < mapDirection && mapDirection <= 303.75)
      //   directionIcon = baseUrl+Color+'/14.png';
      // else if(303.75 < mapDirection && mapDirection <= 326.25)
      //   directionIcon = baseUrl+Color+'/15.png';
      // else if(326.25 < mapDirection && mapDirection <= 348.75)
      //   directionIcon = baseUrl+Color+'/16.png';
      return directionIcon;
    }
 
    function listMarkers(){
      httpResponse, latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array(), statusesArr = new Array();
      var temp_gmarkers = gmarkers;
      
        gmarkers = [];
      $.ajax({
             url:  '<?php echo jquery_url()?>lists/getListdata',
             dataType: 'text',
             success: function(responseText){ 
                     //    console.log(responseText);
               httpResponse = JSON.parse(responseText);
                httpResponse.forEach( function(data, index) { 
              latitudeArr.push(data.latitude);
              longitudeArr.push(data.longitude);
              unitnameArr.push(data.unitname);  
              regArr.push(data.registration);
              statusesArr.push(data.LOAD_STATUS);
            });


            latitudeArr.forEach(function(feature, index) {
                    if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
                  var dir = httpResponse[index].lmid;            
                  if(dir == ""){              
                      dir = 0;            
                      } 
                  switch(statusesArr[index]){
                    case "201": directionIcon = laddlecarIcons(dir, 'LGreen');break;
                  case "202": directionIcon = laddlecarIcons(dir, 'Green');break;
                  case "203": directionIcon = laddlecarIcons(dir, 'LRed');break;
                  case "204": directionIcon = laddlecarIcons(dir, 'Red');break;
            case "205": directionIcon = laddlecarIcons(dir, 'Green');break;
                  default: directionIcon = laddlecarIcons(dir, 'Loco');break;
                }

                  if(httpResponse[index].cycle == 0 && statusesArr[index]!=null){
                     directionIcon = laddlecarIcons(dir, "Orange");
                 }
                   
                  var markerIcon = {
                      url: directionIcon,
                      //scaledSize: new google.maps.Size(80, 80),
                      //origin: new google.maps.Point(0, 0),
                     // anchor: new google.maps.Point(32,65),
                      labelOrigin: new google.maps.Point(10,35)
                      //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
                    };
                  
                  var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitudeArr[index], longitudeArr[index]),
                    icon: markerIcon,
                    title: unitnameArr[index],
                    //label: unitnameArr[index],
                    map: map,
                    label: {
                          color: '#2a4dce',
                          fontWeight: 'bold',
                          fontSize: '11px',
                          text: unitnameArr[index]
                      },
                      optimized: false,
                      
                  });
                  
                  //marker.metadata = {type: "point", id: index};
                  if(regArr[index] != "" && statusesArr[index] != null){
                  var text = "";
                  text = getText(statusesArr[index], index);
                    
                    //console.log(statusesArr[index]);
                  //console.log(text);
                  if(text != ""){
                      fnPlaceMarkers(marker, text);
                  }
                  }
               // console.log(marker);
                  gmarkers.push(marker);
                });

            for (var i = 0; i < temp_gmarkers.length; i++) {
              temp_gmarkers[i].setMap(null);
              }
            animateMarkers();
             }
         });  
        
    }
    

    function getText(status, index){
        //<ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul>
        var img = '<?php echo asset_url();?>images/battery_emp.png';
        if(parseFloat(httpResponse[index].fuel) > 10){
          img = '<?php echo asset_url();?>images/battery_f.png';
        }
        
        var timehours = httpResponse[index].timehours;
        var minutes = Math.floor(timehours / 60);
        var idlet = "";
        if(minutes > 19000000 && httpResponse[index].cycle=="1"){
          idlet = "<li><strong>Idle Time(min):</strong> "+minutes+" </li>";
        }
      switch(status){
        case "201": text = "<h3>"+httpResponse[index].ladleno+"<span class='battery_icon'><img src='"+img+"'/></span></h3>"+                          
            "<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
            "<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
            "<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
            "<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
            "<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
            "<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+idlet+"</ul>";
          break;
        case "202": text = "<h3>"+httpResponse[index].ladleno+"<span class='battery_icon'><img src='"+img+"'/></span></h3>"+                          
              "<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
              "<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
              "<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
              "<li><strong>Destination:</strong> "+httpResponse[index].DEST+" </li>"+
              "<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
              "<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
              "<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+
              "<li><strong>Gross Weight:</strong> "+httpResponse[index].GROSS_WEIGHT+" </li>"+
              "<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+httpResponse[index].NET_WEIGHT+" </li>"+idlet+"</ul>";
            break; 
        case "203": text = "<h3>"+httpResponse[index].ladleno+"<span class='battery_icon'><img src='"+img+"'/></span></h3>"+                          
              "<ul><li><strong>Unload time:</strong> "+httpResponse[index].smstime+" </li>"+
              "<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+0+" </li>"+idlet+"</ul>";
            break; 
        case "204": text = "<h3>"+httpResponse[index].ladleno+"<span class='battery_icon'><img src='"+img+"'/></span></h3>"+                          
              "<ul><li><strong>Unload time:</strong> "+httpResponse[index].smstime+" </li>"+
              "<li><strong>2nd Tare Weight:</strong> "+httpResponse[index].TARE_WT2+" </li>"+
              "<li><strong>2nd Net Weight:</strong> "+0+" </li>"+idlet;
                  if(httpResponse[index].remarks != null){ text += "<li><strong>Remarks:</strong> "+httpResponse[index].remarks+" </li>";}
                  text += "</ul>";
            break; 
            
    case "205": text = "<h3>"+httpResponse[index].ladleno+" <span class='battery_icon'><img src='"+img+"'/></span></h3>"+                         
              "<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
              "<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
              "<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
              "<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
              "<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
              "<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+
              "<li><strong>Gross Weight:</strong> "+httpResponse[index].GROSS_WEIGHT+" </li>"+
              "<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+httpResponse[index].NET_WEIGHT+" </li>"+idlet+"</ul>";
            break; 
  
        default: text="";break;
    }
      
      return text;
    }


    /*var ajax_call_alert = function() {
    getAlertsData();        
  };  */

  //var myintr_alert = setInterval(ajax_call_alert);//handler  
  //Alert Notification
  
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
  //getAlertsData();
  
  //BF Production
  
  function getBfProduction(){
    $.get("<?php echo base_url()?>dashboard/getBfProduction", function(data){
      
      data = $.trim(data);
      if(data != ""){
         
          if($("#homeModal").hasClass("in")){
            
            $('#homeModal').modal('hide')
          }

          if($("#otherModal").hasClass("in")){
            
            $('#otherModal').modal('hide')
          }
        
          if(!$("#errorModal1").hasClass("in")){
             
            $('#errorModal1').modal('show')

            
          }
          $("#error-msg1").html(data);
          //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
      }
      });
  }

  
  function getSmsMetal(){

    
    $.get("<?php echo base_url()?>dashboard/getSmsMetal", function(data){
      data = $.trim(data);
      if(data != ""){
        
          if($("#homeModal").hasClass("in")){
            
            $('#homeModal').modal('hide')
          }

          if($("#otherModal").hasClass("in")){
            
            $('#otherModal').modal('hide')
          }
        
          if(!$("#errorModal2").hasClass("in")){
            
            $('#errorModal2').modal('show')
          }
          $("#error-msg2").html(data);
          //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
      }
      });
  }

  function setGeofence(){


       
           
      /* $.ajax({
             url:  '<?php echo base_url();?>lists/getReplayGeofence?type=2',
             dataType: 'json',
             success: function(data){              
               rectangularGeoStore = data;
             }
         });  */

       $.ajax({
             url:  '<?php echo base_url();?>lists/getReplayGeofence?type=3',
             dataType: 'json',
             success: function(data){              
               var polyResponse = data;

               polyResponse.forEach( function(data, i) {
                var PolyCoords= new Array();
                var polyGeobounds = new google.maps.LatLngBounds();
                var allGeobounds = new google.maps.LatLngBounds();
                 var latlon =  data.latlon;
                  var latlonsplit= latlon.split(":");
                 for(var k=0;k<latlonsplit.length;k++)
                 {
                     if(latlonsplit[k]!="")
                     {
                      var s = latlonsplit[k].toString();
                      var s1 = s.substring(1,s.length-1);
                      var s2 = s1.split(",");
                      var ln = new google.maps.LatLng(parseFloat(s2[0]),parseFloat(s2[1]));
                        PolyCoords.push(ln);
                     }
                 }
                               var colr = data.colour;
                       var polygon =  new google.maps.Polygon({
                      map:map,
                      paths: PolyCoords,
                    strokeColor: colr,
                             strokeOpacity: 2.35,
                             strokeWeight: 2,
                             fillColor: colr,
                             fillOpacity: 0.35
                     
                    });
                  //geofence label color
                   var mapLabel = new MapLabel({
                      map: map,
                        fontSize: 14,
                        fontColor:'#000',
                       fontWeight: 'bold',
                        strokeWeight:1.2,
                        strokeColor:'#000',
                        labelClass: "labels",
                        align: 'center',                        
                        rotation: 50
                   });

                 
                 for (var j = 0; j<PolyCoords.length; j++) {
                   allGeobounds.extend(PolyCoords[j]);
                   polyGeobounds.extend(PolyCoords[j]);
                      
                    }
               
              //console.log(polyGeobounds);//console.log(data.lat);//console.log(data.lon);
              
                 mapLabel.set('position',new google.maps.LatLng(data.lat, data.lon));
               mapLabel.set('text',  data.geofenceName);
               polygon.bindTo('map', mapLabel);
               polygon.bindTo('position', mapLabel);
               //addPolygonClick(polygon,mapLabel);
               //map.fitBounds(polyGeobounds);
               polygon.setVisible(true);
              // mapPolyLabelArr.push(mapLabel);
               mapLabel.setMap(map);
              // polyArr.push(polygon);  
              

        });
             }
         });

       $.ajax({
             url:  '<?php echo base_url();?>lists/getTrack',
             dataType: 'json',
             success: function(data){              
               var polylineResponse = data;

               polylineResponse.forEach( function(data, i) {
                 
                var PolyCoords= new Array();
                var polyGeobounds = new google.maps.LatLngBounds();
                var allGeobounds = new google.maps.LatLngBounds();
                 var latlon =  data.latlon;
                  var latlonsplit= latlon.split(":");
                 for(var k=0;k<latlonsplit.length;k++)
                 {
                     if(latlonsplit[k]!="")
                     {
                      var s = latlonsplit[k].toString();
                      var s1 = s.substring(1,s.length-1);
                      var s2 = s1.split(",");
                      var ln = new google.maps.LatLng(parseFloat(s2[0]),parseFloat(s2[1]));
                        PolyCoords.push(ln);
                     }
                 }
                               
              var line = new google.maps.Polyline({
                  path: PolyCoords,
                  strokeOpacity: 0,
                  icons: [{
                    icon: lineSymbol,
                    offset: '0',
                    repeat: '13px',
                    title: data.geofenceName,
                  }],
                  map: map
                });
                  
                
              
               
               //addPolygonClick(polygon,mapLabel);
               //map.fitBounds(polyGeobounds);
               line.setVisible(true);
              

        });
             }
         });
          
      
         $.ajax({
             url:  '<?php echo base_url();?>lists/getReplayGeofence?type=1',
             dataType: 'json',
             success: function(data){ 
               cirResponse = data;
           cirResponse.forEach( function(data, i) {   
                     var colr = data.colour;           
           var circle = new google.maps.Circle({
             
               map:map,
               center:new google.maps.LatLng(data.latitude, data.longitude),
               radius: parseFloat(data.radius)+0.00,
               options:{
                 strokeWeight: 0,
                 fillOpacity: 0.45,
                 fillColor: colr,
                 title:data.geofenceName,
                 editable: false,
                 visible:true
               }            
             });
           var mapLabel = new MapLabel({
             map:map,
             fontSize: 12,
             fontColor:'#fff000',
             fontWeight:10,
             strokeWeight:3,
             strokeColor:'#000000',
             labelClass: "labels",
             align: 'center'
           });
         mapLabel.set('position', circle.getCenter());
         mapLabel.set('text',data.geofenceName);
         circle.bindTo('map', mapLabel);
         circle.bindTo('position', mapLabel);
         circle.setVisible(true);
         mapLabel.setMap(map);
        
            });
          }

         });  
    
  }

  var iconBase = '<?php echo asset_url()?>images/';
    /*var icons = {
      laddlecars: {
        icon: iconBase + 'm.png'
      },
    laddlecarsidel: {
        icon: iconBase + 'm1.png'
      },
      laddlecarOrange: {
        icon: iconBase + 'orange.png'
      },
      laddlecarRed: {
        icon: iconBase + 'red.png'
      },
      laddlecarYellow: {
        icon: iconBase + 'yellow.png'
      },
      laddlecarGreen: {
        icon: iconBase + 'green.png'
      },
      laddlecarsmove: {
          icon: iconBase + 'green.png'
        },
      blink_c: {
        icon: iconBase + 'gg.gif'
      }
      

  };*/

  var icons = {
          laddlecarOrange: {
            icon: 'orange'
          },
          laddlecarRed: {
            icon: 'M46.359001,50.5c-0.205002,0 -0.410999,-0.046001 -0.602001,-0.141998l-13.757,-6.878002l-13.757,6.877998c-0.507,0.255001 -1.121,0.163002 -1.532,-0.230999c-0.411001,-0.393002 -0.531,-1.000999 -0.301001,-1.52l14.360001,-32.307999c0.216,-0.486 0.698,-0.799 1.23,-0.799c0.532001,0 1.014,0.313 1.23,0.799l14.359001,32.307999c0.23,0.519001 0.110001,1.126999 -0.301003,1.52c-0.254997,0.245003 -0.589996,0.373001 -0.928997,0.373001zm-14.359001,-9.872002c0.206001,0 0.412998,0.047001 0.602001,0.141998l11.002998,5.502003l-11.605,-26.111l-11.605,26.111l11.003,-5.501999c0.188999,-0.094002 0.396,-0.142002 0.601999,-0.142002z'
          },
          laddlecarYellow: {
            icon: 'yellow.png'
          },
          laddlecarGreen: {
            icon: 'M46.359001,50.5c-0.205002,0 -0.410999,-0.046001 -0.602001,-0.141998l-13.757,-6.878002l-13.757,6.877998c-0.507,0.255001 -1.121,0.163002 -1.532,-0.230999c-0.411001,-0.393002 -0.531,-1.000999 -0.301001,-1.52l14.360001,-32.307999c0.216,-0.486 0.698,-0.799 1.23,-0.799c0.532001,0 1.014,0.313 1.23,0.799l14.359001,32.307999c0.23,0.519001 0.110001,1.126999 -0.301003,1.52c-0.254997,0.245003 -0.589996,0.373001 -0.928997,0.373001zm-14.359001,-9.872002c0.206001,0 0.412998,0.047001 0.602001,0.141998l11.002998,5.502003l-11.605,-26.111l-11.605,26.111l11.003,-5.501999c0.188999,-0.094002 0.396,-0.142002 0.601999,-0.142002z'
          },
          laddlecarsmove: {
              icon: 'green.png'
            },
          blink_c: {
            icon: 'gg.gif'
          }
          

      };

 // Define a symbol using SVG path notation, with an opacity of 1.
    var lineSymbol = {
      path: 'M 0,-1 0,3',
      strokeOpacity: 1,
      scale: 2.0,
    strokeColor:'#FF0000',
    fillColor: '#FF0000',
    fillOpacity: 0

    };
  
   function initMap1() {
    // alert("oldmap");
    var styledMapType1 = new google.maps.StyledMapType(
            [
              {elementType: 'geometry', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#fff'}]},
              // {
              //   featureType: 'administrative',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'administrative.land_parcel',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
        {
        featureType: 'all',
        elementType: 'labels',
        stylers: [{ 
          visibility: 'off' 
         }]
       },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#000000'}]
              },
              {
                // featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              // {
              //   featureType: 'poi',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                // stylers: [{color: '#ffc000'}]
              },
              // {
              //   featureType: 'road.arterial',
              //   elementType: 'geometry',
              //   stylers: [{color: '#fdfcf8'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa7c7'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa7c7'}]
              // },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
              },
              // {
              //   featureType: 'transit.line',
              //   elementType: 'geometry',
              //   stylers: [{color: '#dfd2ae'}]
              // },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
              },
              // {
              //   featureType: 'transit.station',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'geometry.fill',
              //   stylers: [{color: '#ffffff'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#ffffff'}]
              // }
            ],
            {name: 'Map'});
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
        rotation: 5,
         gestureHandling: "greedy",
         // mapTypeId:'styled_map',
        
            //center: {lat:15.178180945596363, lng:76.65809154510498},
          center: {lat:18.6872633, lng:73.0406250},
        //center: {lat:15.1787608, lng:76.6641855},
        
      mapTypeControl: true,
      zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_TOP
    },
      mapTypeControlOptions: {
      position: google.maps.ControlPosition.BOTTOM_LEFT,
      // mapTypeIds: ['satellite','roadmap']
         mapTypeIds: ['styled_map', 'satellite'],
      },
      zoomControl: true,
      fullscreenControl: true,
      streetViewControl: false,
          });

          
        var features = [];
        setGeofence();
        // Create markers. 

           
            var dir = direction;            
            //alert(unitname+"<<<>>"+longitude);
            // alert(statuses);
             latitudeArr.forEach(function(feature, index) {
            if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
            var dir = httpResponse[index].lmid;            
            if(dir == ""){              
                dir = 0;            
                } 
               // alert(statuses);
            switch(statuses){
            // switch(statuses){
                case "201": directionIcon = laddlecarIcons(dir, 'LGreen');break;
            case "202": directionIcon = laddlecarIcons(dir, 'Green');break;
            case "203": directionIcon = laddlecarIcons(dir, 'LRed');break;
            case "204": directionIcon = laddlecarIcons(dir, 'Red');break;
        case "205": directionIcon = laddlecarIcons(dir, 'Green');break;
            default: directionIcon = laddlecarIcons(dir, 'Loco');break;
         
        }

             if(httpResponse[index].cycle == 0){
              directionIcon = laddlecarIcons(dir, "Orange");
           } 
          // console.log(directionIcon);
            var markerIcon = {
                url: directionIcon,
                //scaledSize: new google.maps.Size(80, 80),
                //origin: new google.maps.Point(0, 0),
               // anchor: new google.maps.Point(32,65),
                labelOrigin: new google.maps.Point(10,35)
                //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
              };
          //console.log(unitnameArr[index]+"------"+parseInt(dir));
              
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(latitude , longitude ),
              icon: markerIcon,
              title: unitname ,
              label: unitname ,
              map: map,
              label: {
                    color: '#2a4dce',
                    fontWeight: 'bold',
                    fontSize: '11px',
                    //text: unitname
                },
                optimized: false,
                
            });
            
            if(statuses  != null){
              var text = "";
              //console.log(color+"----"+unitnameArr[index]+"----"+statusesArr[index]+"----"+icons[color].icon);
              text = getTextNew(statuses);
                
                //console.log(statusesArr[index]);
              console.log(text);
              if(text != ""){
                  fnPlaceMarkers1(marker, text);
              }
              }
          gmarkers.push(marker);
    });
          var myoverlay = new google.maps.OverlayView();
       myoverlay.draw = function () {
           // add an id to the layer that includes all the markers so you can use it in CSS
           this.getPanes().markerLayer.id='markerLayer';
       };
       myoverlay.setMap(map);



     map.mapTypes.set('styled_map', styledMapType1);
        map.setMapTypeId('styled_map');
    
        
    //console.log(map);
    google.maps.event.addListenerOnce(map, 'idle', function(){
        //loaded fully
      timer = setTimeout("animateMarkers()", 1000);
      
    });
      
     
      }


  
      function initMap() {
      // alert("map");
    // Create a new StyledMapType object, passing it an array of styles,
        // and the name to be displayed on the map type control.
        var styledMapType5 = new google.maps.StyledMapType(
            [
              {elementType: 'geometry', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#fff'}]},
              // {
              //   featureType: 'administrative',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'administrative.land_parcel',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
        {
        featureType: 'all',
        elementType: 'labels',
        stylers: [{ 
          visibility: 'off' 
         }]
       },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#000000'}]
              },
              {
                // featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              // {
              //   featureType: 'poi',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                // stylers: [{color: '#ffc000'}]
              },
              // {
              //   featureType: 'road.arterial',
              //   elementType: 'geometry',
              //   stylers: [{color: '#fdfcf8'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa7c7'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa7c7'}]
              // },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
              },
              // {
              //   featureType: 'transit.line',
              //   elementType: 'geometry',
              //   stylers: [{color: '#dfd2ae'}]
              // },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
              },
              // {
              //   featureType: 'transit.station',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'geometry.fill',
              //   stylers: [{color: '#ffffff'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#ffffff'}]
              // }
            ],
            {name: 'Map'});


         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
      rotation: 5,
      gestureHandling: "greedy",

      
          //center: {lat:15.178180945596363, lng:76.65809154510498},
      //center: {lat:15.177870, lng:76.665891},
        center: {lat:18.6872633, lng:73.0406250},
          
    //  center: {lat:15.1787608, lng:76.6641855},
      //mapTypeId: 'terrain',
        zoomControl: true,
    zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_TOP
    },
    scaleControl: true,
    streetViewControl: false,
    fullscreenControl: true,
   /* streetViewControlOptions: {
        position: google.maps.ControlPosition.BOTTOM_CENTER
    },*/
      mapTypeControlOptions: {
        
      position: google.maps.ControlPosition.BOTTOM_LEFT,
            mapTypeIds: ['styled_map', 'satellite']
          }
        });

    
        var features = [];
    
        setGeofence();
    

        // Create markers.
        latitudeArr.forEach(function(feature, index) {
            if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
            var dir = httpResponse[index].lmid;            
            if(dir == ""){              
                dir = 0;            
                } 
            switch(statusesArr[index]){
            case "201": directionIcon = laddlecarIcons(dir, 'LGreen');break;
            case "202": directionIcon = laddlecarIcons(dir, 'Green');break;
            case "203": directionIcon = laddlecarIcons(dir, 'LRed');break;
            case "204": directionIcon = laddlecarIcons(dir, 'Red');break;
        case "205": directionIcon = laddlecarIcons(dir, 'Green');break;
            default: directionIcon = laddlecarIcons(dir, "Loco");break;
          }

             if(httpResponse[index].cycle == 0 && statusesArr[index]!=null){
                directionIcon = laddlecarIcons(dir, "Orange");
           } 
          // console.log(directionIcon);
            var markerIcon = {
                url: directionIcon,
                //scaledSize: new google.maps.Size(80, 80),
                //origin: new google.maps.Point(0, 0),
               // anchor: new google.maps.Point(32,65),
                labelOrigin: new google.maps.Point(10,35)
                //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
              };
          //console.log(unitnameArr[index]+"------"+parseInt(dir));
              
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(latitudeArr[index], longitudeArr[index]),
              icon: markerIcon,
              title: unitnameArr[index],
              //label: unitnameArr[index],
              map: map,
              label: {
                    color: '#2a4dce',
                    fontWeight: 'bold',
                    fontSize: '11px',
                    text: unitnameArr[index]
                },
                optimized: false,
                
            });

            
            if(regArr[index] != "" && statusesArr[index] != null){
              var text = "";
              //console.log(color+"----"+unitnameArr[index]+"----"+statusesArr[index]+"----"+icons[color].icon);
              text = getText(statusesArr[index], index);
                
                //console.log(statusesArr[index]);  
              //console.log(text);
              if(text != ""){
                  fnPlaceMarkers(marker, text);
              }
              }
          gmarkers.push(marker);



        });
      

     // Overlay view allows you to organize your markers in the DOM
        // https://developers.google.com/maps/documentation/javascript/reference#OverlayView
       var myoverlay = new google.maps.OverlayView();
       myoverlay.draw = function () {
           // add an id to the layer that includes all the markers so you can use it in CSS
           this.getPanes().markerLayer.id='markerLayer';
       };
       myoverlay.setMap(map);



     map.mapTypes.set('styled_map', styledMapType5);
        map.setMapTypeId('styled_map');
    
        
    //console.log(map);
    google.maps.event.addListenerOnce(map, 'idle', function(){
        //loaded fully
      timer = setTimeout("animateMarkers()", 1000);
      
    });
    /*
    google.maps.event.addListener(map, 'zoom_changed', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'heading_changed', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'dragstart', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'dragend', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'drag', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'dblclick', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'click', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'center_changed', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'bounds_changed', function() {
      startTimer();
    });
    
    
    google.maps.event.addListener(map, 'maptypeid_changed', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'mousemove', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'mouseout', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'mouseover', function() {
      startTimer();
    });
    
    
    
    google.maps.event.addListener(map, 'projection_changed', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'resize', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'rightclick', function() {
      startTimer();
    });
    
    
    google.maps.event.addListener(map, 'tilesloaded', function() {
      startTimer();
    });

    google.maps.event.addListener(map, 'tilt_changed', function() {
      startTimer();
    });*/
    
    
      }


      function animateMarkers(){
          //console.log("ddd");
          //console.log(gmarkers);
          httpResponse.forEach(function(feature, index) {
         if(httpResponse[index].registration != ""){httpResponse[index].unitname = httpResponse[index].registration;}
         var timehours = httpResponse[index].timehours;
              var minutes = Math.floor(timehours / 60);
          //console.log(minutes+"-----"+httpResponse[index].unitname+"---"+httpResponse[index].cycle);
            /*  if((minutes > 19000000 && httpResponse[index].cycle=="1") || 
                  (httpResponse[index].LOAD_STATUS == "204" && parseInt(httpResponse[index].TARE_WT2) > 410 && httpResponse[index].cycle=="1" && httpResponse[index].lmid >= 1 && httpResponse[index].lmid <= 55) 
                  )*/
       if( (httpResponse[index].LOAD_STATUS == "202"  && httpResponse[index].cycle=="1" ) )
                      
                {
                //gmarkers[index].setMap(null);
                gmarkers[index].setVisible(false);
                //setTimeout(function () {gmarkers[index].setMap(map);}, 200);
                setTimeout(function () {gmarkers[index].setVisible(true);}, 200);
                //gmarkers[index].setAnimation(google.maps.Animation.BOUNCE);
              }
       });
        /*for (var i = 0; i < gmarkers.length; i++) {
      //console.log(gmarkers[i]);
      gmarkers[i].setAnimation(google.maps.Animation.BOUNCE);
        }*/
          setTimeout("animateMarkers()", 1000);
      }

      
      closeImageBtn();
      function closeImageBtn(){
         /* $('img[src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png"]').parent().addClass("closeImage");
          console.log($('img[src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png"]').parent());*/

          $(".gm-style-iw").next().remove();
      }
    </script> 
   <!--  <style>
    .closeImage{
      display: none !important;
    }
    </style>
 -->
 

 <script type="text/javascript">
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

    function refreshMarkers1(){
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
      
                
                 bounds.extend(new google.maps.LatLng(latitude,longitude));
              
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

   function getTextNew(status){
          
       
      switch(status){
       case "201": text = "<h3>"+ladleno+"<span class='battery_icon'></span></h3>"+                          
            "<ul><li><strong>Cast No:</strong> "+TAPNO+" </li>"+
            "<li><strong>Loadtime:</strong> "+LOAD_DATE+" </li>"+
            "<li><strong>Source:</strong> "+SOURCE+" </li>"+
            "<li><strong>Runner HM Si%:</strong> "+SI+" </li>"+
            "<li><strong>Runner HM Sulphur%:</strong> "+S+" </li>"+
            "<li><strong>Runner Temp:</strong> "+TEMP+" </li></ul>";
          break;
        case "202": text = "<h3>"+ladleno+"<span class='battery_icon'></span></h3>"+                          
              "<ul><li><strong>Cast No:</strong> "+TAPNO+" </li>"+
              "<li><strong>Loadtime:</strong> "+LOAD_DATE+" </li>"+
              "<li><strong>Source:</strong> "+SOURCE+" </li>"+
              "<li><strong>Destination:</strong> "+DEST+" </li>"+
              "<li><strong>Runner HM Si%:</strong> "+SI+" </li>"+
              "<li><strong>Runner HM Sulphur%:</strong> "+S+" </li>"+
              "<li><strong>Runner Temp:</strong> "+TEMP+" </li>"+
              "<li><strong>Gross Weight:</strong> "+GROSS_WEIGHT+" </li>"+
              "<li><strong>Tare Weight:</strong> "+TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+NET_WEIGHT+" </li></ul>";
            break; 
        case "203": text = "<h3>"+ladleno+"<span class='battery_icon'></span></h3>"+                          
              "<ul><li><strong>Unload time:</strong> "+smstime+" </li>"+
              "<li><strong>Tare Weight:</strong> "+TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+0+" </li></ul>";
            break; 
        case "204": text = "<h3>"+ladleno+"<span class='battery_icon'></span></h3>"+                          
              "<ul><li><strong>Unload time:</strong> "+smstime+" </li>"+
              "<li><strong>2nd Tare Weight:</strong> "+TARE_WT2+" </li>"+
              "<li><strong>2nd Net Weight:</strong> "+0+" </li></ul>";
                
            break; 
            
    case "205": text = "<h3>"+ladleno+" <span class='battery_icon'></span></h3>"+                         
              "<ul><li><strong>Cast No:</strong> "+TAPNO+" </li>"+
              "<li><strong>Loadtime:</strong> "+LOAD_DATE+" </li>"+
              "<li><strong>Source:</strong> "+SOURCE+" </li>"+
              "<li><strong>Runner HM Si%:</strong> "+SI+" </li>"+
              "<li><strong>Runner HM Sulphur%:</strong> "+S+" </li>"+
              "<li><strong>Runner Temp:</strong> "+TEMP+" </li>"+
              "<li><strong>Gross Weight:</strong> "+GROSS_WEIGHT+" </li>"+
              "<li><strong>Tare Weight:</strong> "+TARE_WEIGHT+" </li>"+
              "<li><strong>Net Weight:</strong> "+NET_WEIGHT+" </li></ul>";
            break; 
  
        default: text="";break;



       
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

 </script>
  
</body>

</html>

