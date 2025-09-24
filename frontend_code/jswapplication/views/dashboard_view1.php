<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/css-chart.css" rel="stylesheet">
	<link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
    
    <style>
    
html, body, #map  {
        height: 100%;
        margin-top: 15px;
        padding: 0px
      }
      
  .gm-style{
        
      }
      
      .upt{
        display:none;
      }
      
      
.scrollFix h3 {
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    margin: 0 0 12px;
    padding: 5px 0 8px;
  
}
.scrollFix ul {
    list-style: outside none none;
    padding: 0;
}
.scrollFix ul li {
    margin-bottom: 5px;
}
.scrollFix {
    float: left;
    width: 100%;
  min-width:150px;
  border-radius:15px;
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
.labelbox{
float: left;
}
      
    .gm-style-cc {
      display: none;
    }
    .gmnoprint {
      position: absolute;
      top: 0;
      left: 0;
    }
    
    html, body{
  overflow:hidden;
}

  .refresh {
      background-color: #fff;
      border-radius: 100%;
      bottom: 10px;
      box-shadow: 0 0 12px -1px #505050;
      cursor: pointer;
      font-size: 18px;
      height: 50px;
      padding: 13px;
      position: fixed;
      right: 10px;
      text-align: center;
      width: 50px;
      z-index: 999;
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
  
  <style>
    
   
   /*  .box {
    position: relative;
    border-top: 0;
    margin-bottom: 20px;
    width: 100%;
    background: #fff;
    border-radius: 0;
    padding: 5px;
} */

.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border: 1px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.box.box-primary {
    /*border-top: 3px solid #3c8dbc;*/
}

.box-header {
    background-color: #8a8484;
    display: block;
    padding: 5px;
    position: relative;
    color: #fff;
}

.box-body {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    padding: 10px;
}

.box-widget {
    border: none;
    position: relative;
}

.widget-user-2 .widget-user-header, .widget-user-3 .widget-user-header {
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
    padding: 20px;
}

.widget-user .widget-user-username, .widget-user-2 .widget-user-username, .widget-user-3 .widget-user-username, .widget-user-4 .widget-user-username {
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 300;
}

.widget-user-2 .widget-user-username {
    margin-top: 5px;
    color: #fff;
}
.widget-user-2 .widget-user-desc {
    margin-top: 0;
}
.widget-user-2 .widget-user-desc, .widget-user-2 .widget-user-username {
    margin-left: 75px;
}

.bg-purple {
    background-color: #926dde;
}

.css-bar-pink.css-bar-65 {
    background-image: linear-gradient(324deg, #f05999 50%, transparent 50%, transparent), linear-gradient(270deg, #ff3493 50%, #fafafa 50%, #fafafa);
}

.tiltDiv {
  -ms-transform: rotate(-75deg); /* IE 9 */
  transform: rotate(-75deg);
}
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
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
  
  #map {
    transform: rotateZ(75deg);
  overflow: visible !important;
  }
  
  .scrollFix {
    background-color: #ffffff ;
    transform: rotateZ(-75deg);
    padding-left: 10px;
    width:100%;
  }
  
  .marker {
  transform: rotate(-75deg);

}
    </style>
    
   
  </head>
  <body onload="getData();">
  <span class="refresh"  title="Refresh" onclick="refreshMarkers();"><i class="fa fa-refresh" aria-hidden="true"></i></span>
   <?php echo $header;?>
    
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
      
      <button data-toggle="modal" data-target="#errorModal1" style="display: none;" id="alertbox"></button>
      <div class="modal fade" id="errorModal1" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 1200px;">
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
      
      
        <button data-toggle="modal" data-target="#errorModal2" style="display: none;" id="alertbox"></button>
      <div class="modal fade" id="errorModal2" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 1200px;">
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
      
      <button data-toggle="modal" data-target="#smsModal" style="display: none;" id="sms_chart"></button>
      <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel">
        <div class="modal-dialog" role="document" style="width: 1100px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok1').click();"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="smsModalLabel">SMS Production Data 
                
              <select class="control-group" id="shiftdate" onchange="getSMSData1();">
                <option value="<?php echo date("Y-m-d");?>">Today (<?php echo date("d-M-Y");?>)</option>
                 <option value="<?php echo date("Y-m-d", strtotime("-1 days"));?>">Yesterday (<?php echo date("d-M-Y", strtotime("-1 days"));?>)</option>             
              </select>
              
              <select class="control-group" id="shift" onchange="getSMSData1();">
                <option value="">All Shifts</option>
                 <option value="c">Shift C (10PM - 6AM)</option>
                <option value="a">Shift A (6AM - 2PM)</option>
                <option value="b">Shift B (2PM - 10PM)</option>               
              </select>
              </h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <label class="col-sm-1 control-label">&nbsp;</label>
                  <?php /*?><div class="col-sm-4">
                    <label class="control-label">Filter By: </label> 
                    <select class="control-group" id="shift" onchange="getSMSData();">
                      <option value="">Today (<?php echo date("d-M-Y");?>)</option>
                      <option value="c">Shift C (11PM - 7AM)</option>
                      <option value="a">Shift A (7AM - 3PM)</option>
                      <option value="b">Shift B (3PM - 11PM)</option>                     
                    </select>
                  </div>*/?>
                  
                        <div class="col-sm-6">
                          <!-- Widget: user widget style 1 -->
                          <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-purple">
                                <div id="prod_per" data-label="0%" class="css-bar mb-0 css-bar-pink css-bar-0" style="float: left;margin: 10px;"><i>0%</i></div>
                              <!-- /.widget-user-image -->
                              <h3 class="widget-user-username">Target Production:  <span id="tot_target"></span></h3>
                              <hr/>
                              <h6 class="widget-user-username">Actual Production: <span id="act_target"></span></h6>
                            </div>
                          
                          </div>
                          <!-- /.widget-user -->
                        </div>
                        
                        <div class="col-lg-5">                  
                            <div class="row">
                                <div class="col-sm-4" id="c_per"><div data-label="0%" class="col-sm-4 css-bar mb-0 css-bar-warning css-bar-0" ><i>0%</i></div></div>
                                <div class="col-sm-4" id="a_per"><div data-label="0%" class="col-sm-4 css-bar mb-0 css-bar-warning css-bar-0"><i>0%</i></div></div>
                                <div class="col-sm-4" id="b_per"><div data-label="0%" class="col-sm-4 css-bar mb-0 css-bar-warning css-bar-0"><i>0%</i></div></div>
                            </div>
                      </div>
                            
                  <label class="col-sm-1 control-label">&nbsp;</label>
                </div>
                    
                    <div class="col-lg-6">
                      <div class="box box-primary">
                            <div class="box-header">
                              <h4 class="box-title">Strike Rate of Target Production</h4>
                            </div>
                            <div class="box-body">
                          <div class="chart" id="div-strike-chart">
                                    <canvas id="strike-chart" style="height:230px"></canvas>
                                </div>
                          </div>
                        </div>
                    </div>
                
                <div class="col-lg-6">
                  <div class="box box-primary">
                            <div class="box-header">
                              <h4 class="box-title">Shift wise Production</h4>
                            </div>
                            <div class="box-body">
                          <div class="chart" id="div-bar-chart">
                                    <canvas id="bar-chart" style="height:230px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                    <div class="box box-primary">
                            <div class="box-header">
                              <h4 class="box-title">Ladle wise Production</h4>
                            </div>
                            <div class="box-body">
                          <div class="chart" id="div-laddle-chart">
                                    <canvas id="laddle-chart" style="height:230px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                    <div class="box box-primary">
                            <div class="box-header">
                              <h4 class="box-title">Ladle wise Trip Count</h4>
                            </div>
                            <div class="box-body">
                          <div class="chart" id="div-trip-chart">
                                    <canvas id="trip-chart" style="height:230px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok1">OK</button>
              
            </div>
          </div>
        </div>
      </div>
      
     
    
   <div id="map"></div>
   <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView?>">
    
    <!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCzNXnFP26CcdfxZrvT2OP4q8GbdkdQ3aw"></script> -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBp3xMZSQ1GPHvxzrx_WCE15EjPDtXQ2ng"></script>
    
    
    <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
    <script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
    <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>


<?php echo $jsfile;?>

<style>
.closeImage{
  display: none !important;
}
</style>

      

  </body>
</html>