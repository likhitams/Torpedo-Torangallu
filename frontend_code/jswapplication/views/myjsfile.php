<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBp3xMZSQ1GPHvxzrx_WCE15EjPDtXQ2ng"></script>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/infobox.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/mapLabel.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script src="<?php echo base_url();?>assets/js/metismenu.min.js"></script>
<script src="<?php echo base_url();?>assets/js/waves.js"></script>
<script src="<?php echo base_url();?>assets/js/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/js/simplebar.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>assets/plugins/apex-charts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="<?php echo base_url();?>assets/pages/jquery.analytics_dashboard.init.js"></script>
<script src="<?php echo base_url();?>assets/plugins/apex-charts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/apex-charts/irregular-data-series.js"></script>
<script src="<?php echo base_url();?>assets/plugins/apex-charts/ohlc.js"></script>
<script src="<?php echo base_url();?>assets/pages/jquery.apexcharts.init.js"></script>
<script src="<?php echo base_url();?>assets/js/app.js"></script>

      <script>
            $(".show-cir").hide();
            $(".hide-cir").click(function(){
                $(".map-v").addClass("col-lg-12");
                $(".Circ").hide();
                $(".hide-cir").hide();
                $(".show-cir").show();
            });


            $(".show-cir").click(function(){
                $(".map-v").removeClass("col-lg-12");
                $(".Circ").show();
                $(".hide-cir").show();
                $(".show-cir").hide();
            });



            $(".data-f").slideUp();
            $(".hide-data").hide();
            $(".hide-data").click(function(){
                 
                $(".data-f").slideUp();
                $(".hide-data").hide();
                $(".show-data").show();
            });


            $(".show-data").click(function(){
                
                $(".data-f").slideDown();
                $(".hide-data").show();
                $(".show-data").hide();
            });




            



        </script>

 
	
	<script>

function base64_encode (data) {
	            	  
	            	  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	            	  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
	            	    ac = 0,
	            	    enc = "",
	            	    tmp_arr = [];

	            	  if (!data) {
	            	    return data;
	            	  }

	            	  do { // pack three octets into four hexets
	            	    o1 = data.charCodeAt(i++);
	            	    o2 = data.charCodeAt(i++);
	            	    o3 = data.charCodeAt(i++);

	            	    bits = o1 << 16 | o2 << 8 | o3;

	            	    h1 = bits >> 18 & 0x3f;
	            	    h2 = bits >> 12 & 0x3f;
	            	    h3 = bits >> 6 & 0x3f;
	            	    h4 = bits & 0x3f;

	            	    // use hexets to index into b64, and append result to encoded string
	            	    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	            	  } while (i < data.length);

	            	  enc = tmp_arr.join('');

	            	  var r = data.length % 3;

	            	  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

	            	}

	$(document).ready(function(){

	     $('body').on('keyup',".onlyalpha", function(event){
                  if (this.value.match(/[^a-zA-Z áéíóúÁÉÍÓÚüÜ]/g)) 
                  {
                    this.value = this.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚüÜ]/g, '');
                  }
	       });

           $('body').on('keyup',".onlynumbers", function(event){
           
               this.value = this.value.replace(/[^[0-9]]*/gi, '');
               
	    });

         


    	$('body').on('keypress',".floatval", function(event){
    		var charCode = (event.which) ? event.which : event.keyCode
           		 if(charCode ==8 || charCode ==9){

           		 }
           		 else if ((charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) {
           		    event.preventDefault();
           		  }
		});


	});


function checkNumLoop(type, val1, val2){
	            	  var flag = 1;
	            	  switch(type){
                   	case "equals": if (val1 == val2) {flag = 0;}break;
                   	case "notEqual": if (val1 != val2) {flag = 0;}break;
                   	case "lessThan": if (val1 < val2) {flag = 0;}break;
                   	case "lessThanOrEqual": if (val1 <= val2) {flag = 0;}break;
                   	case "greaterThan": if (val1 > val2) {flag = 0;}break;
                   	case "greaterThanOrEqual": if (val1 >= val2) {flag = 0;}break;
                   	default: flag = 1;break;
                   }
                       return flag;
	              }

	              function checkStrLoop(type, val1, val2){
	            	  var flag = 1;
	            	  switch(type){
                   	case "equals": if (val1 == val2) {flag = 0;}break;
                   	case "contains": if (val1.indexOf(val2) >= 0) {flag = 0;}break;
                   	case "notEquals": if (val1 != val2) {flag = 0;}break;
                   	case "startsWith": if (val1.startsWith(val2)) {flag = 0;}break;
                   	case "endsWith": if (val1.length >= val2.length && val1.substr(val1.length - val2.length) == val2) {flag = 0;}break;
                   	default: flag = 1;break;
                   }
                       return flag;
	              }
        </script>







<script type="text/javascript" src="<?php echo asset_url(); ?>js/staticConstants.js"></script>
  <script>
    var mapView;
    var on = true;
    var baseUrl = '<?php echo jquery_url() ?>assets/direction_icons1/';
    var httpResponse, map, activeInfoWindow;
    var gmarkers = [],
      newFeature = [];
    var lineCoordinates = new Array();
    var polyArr = new Array(),
      mapPolyLabelArr = new Array(),
      statusesArr = new Array();
    var latitudeArr = new Array(),
      longitudeArr = new Array(),
      unitnameArr = new Array(),
      regArr = new Array();
    var latitude, longitude, unitname, direction, statuses, indent, routenumber, driver, mobile, dist, work, statusdesc, duty, loc, vtype, idel, reporttime;

    function getData() {
      var httpRequest = new XMLHttpRequest();
      httpRequest.open('GET', '<?php echo jquery_url() ?>lists/getListdata');
      httpRequest.send();
      httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
          //alert(httpRequest.responseText);
          httpResponse = JSON.parse(httpRequest.responseText);
          httpResponse.forEach(function(data, index) {
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

    function getEmptySignalAlertsData() {
      $.get("<?php echo base_url() ?>dashboard/getMovedFilesAlert", function(data) {
        data = $.trim(data);
        if (data != "") {

          if ($("#homeModal").hasClass("in")) {

            $('#homeModal').modal('hide')
          }

          if ($("#otherModal").hasClass("in")) {

            $('#otherModal').modal('hide')
          }

          if (!$("#errorModal4").hasClass("in")) {

            $('#errorModal4').modal('show')
          }
          $("#error-msg4").html(data);
          $("#shake_text").effect("shake", {
            times: 1,
            direction: "up",
            distance: 1000
          });
        }
      });
    }

    var CCOUNT = 15;

    var t, count, timer;

    function cddisplay() {
      // displays time in span
      if (CCOUNT >= 0) {
        if (count >= 0) {
          $("#countdown").html(count);
        }
      } else {
        $("#countdown").html("");
      }
    };

    function countdown() {
      // starts countdown
      cddisplay();
      // console.log(count);
      if (count < 0) {
        // time is up
        if (CCOUNT > 0) {
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

    function refreshMarkers() {
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

    function refreshCountList() {
      // $.get("<?php echo base_url() ?>dashboard/getListCount", function(data){
      //   $("#refCount").html(data);
      // });

      // $.get("<?php echo base_url() ?>dashboard/getTaphole", function(data){
      //   $("#taphole_div").html(data);
      // });

      //  $.get("<?php echo base_url() ?>dashboard/getproductiondetails", function(data){
      //   $("#productiondetails_div").html(data);
      // });
      //  $.get("<?php echo base_url() ?>dashboard/tablephase", function(data){
      //   $("#tablephase_div").html(data);
      // });
    }

    // ------------------------------------------------------------------------------- //
    // create markers on the map tooltip
    // ------------------------------------------------------------------------------- //
    function fnPlaceMarkers(markermap, textplace) {


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
        if (activeInfoWindow != null) activeInfoWindow.close();

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
        if (activeInfoWindow != null) activeInfoWindow.close();

        // Open InfoWindow - on click 
        infoWnd2.open(map, markermap);

        // Close "mouseover" infoWindow
        infoWnd.close();

        // Store new open InfoWindow in global variable
        activeInfoWindow = infoWnd2;
        closeImageBtn();
      });

    }

    function laddlecarIcons(ladleid, Color) {
      var directionIcon = "";


      if (ladleid == 1) {
        directionIcon = baseUrl + "Ladle/" + Color + '/1.png';
        // alert(directionIcon);
      } else if (ladleid == 2) {
        directionIcon = baseUrl + "Ladle/" + Color + '/2.png';
      } else if (ladleid == 3) {
        directionIcon = baseUrl + "Ladle/" + Color + '/3.png';
      } else if (ladleid == 4) {
        directionIcon = baseUrl + "Ladle/" + Color + '/4.png';
      } else if (ladleid == 5) {
        directionIcon = baseUrl + "Ladle/" + Color + '/5.png';
        // alert(">>>>"+directionIcon);
      } else if (ladleid == 6) {
        directionIcon = baseUrl + "Ladle/" + Color + '/6.png';
      } else if (ladleid == 7) {
        directionIcon = baseUrl + "Ladle/" + Color + '/7.png';
      } else if (ladleid == 8) {
        directionIcon = baseUrl + "Ladle/" + Color + '/8.png';
      } else if (ladleid == 9) {
        directionIcon = baseUrl + "Ladle/" + Color + '/9.png';
      } else if (ladleid == 10) {
        directionIcon = baseUrl + "Ladle/" + Color + '/10.png';
      } else if (ladleid == 11) {
        directionIcon = baseUrl + "Ladle/" + Color + '/11.png';
      } else if (ladleid == 12) {
        directionIcon = baseUrl + "Ladle/" + Color + '/12.png';
      } else if (ladleid == 13) {
        directionIcon = baseUrl + "Ladle/" + Color + '/13.png';
      } else if (ladleid == 14) {
        directionIcon = baseUrl + "Ladle/" + Color + '/14.png';
      } else if (ladleid == 15) {
        directionIcon = baseUrl + "Ladle/" + Color + '/15.png';
      } else if (ladleid == 16) {
        directionIcon = baseUrl + "Ladle/" + Color + '/16.png';
      } else if (ladleid == 17) {
        directionIcon = baseUrl + "Ladle/" + Color + '/17.png';
      } else if (ladleid == 18) {
        directionIcon = baseUrl + "Ladle/" + Color + '/18.png';
      } else if (ladleid == 19) {
        directionIcon = baseUrl + "Ladle/" + Color + '/19.png';
      } else if (ladleid == 20) {
        directionIcon = baseUrl + "Ladle/" + Color + '/20.png';
      } else if (ladleid == 21) {
        directionIcon = baseUrl + "Ladle/" + Color + '/21.png';
        // alert(directionIcon);
      } else if (ladleid == 22) {
        directionIcon = baseUrl + "Ladle/" + Color + '/22.png';
      } else if (ladleid == 23) {
        directionIcon = baseUrl + "Ladle/" + Color + '/23.png';
      } else if (ladleid == 24) {
        directionIcon = baseUrl + "Ladle/" + Color + '/24.png';
      } else if (ladleid == 25) {
        directionIcon = baseUrl + "Ladle/" + Color + '/25.png';
      } else if (ladleid == 26) {
        directionIcon = baseUrl + "Ladle/" + Color + '/26.png';
      } else if (ladleid == 27) {
        directionIcon = baseUrl + "Ladle/" + Color + '/27.png';
      } else if (ladleid == 28) {
        directionIcon = baseUrl + "Ladle/" + Color + '/28.png';
      } else if (ladleid == 29) {
        directionIcon = baseUrl + "Ladle/" + Color + '/29.png';
      } else if (ladleid == 30) {
        directionIcon = baseUrl + "Ladle/" + Color + '/30.png';
      } else if (ladleid == 31) {
        directionIcon = baseUrl + "Ladle/" + Color + '/31.png';
      } else if (ladleid == 32) {
        directionIcon = baseUrl + "Ladle/" + Color + '/32.png';
      } else if (ladleid == 33) {
        directionIcon = baseUrl + "Ladle/" + Color + '/33.png';
      } else if (ladleid == 34) {
        directionIcon = baseUrl + "Ladle/" + Color + '/34.png';
      } else if (ladleid == 35) {
        directionIcon = baseUrl + "Ladle/" + Color + '/35.png';
      } else if (ladleid == 136) {
        directionIcon = baseUrl + "Ladle/" + Color + '/1.png';
        // alert(directionIcon);
      } else if (ladleid == 137) {
        directionIcon = baseUrl + "Ladle/" + Color + '/2.png';
      } else if (ladleid == 138) {
        directionIcon = baseUrl + "Ladle/" + Color + '/3.png';
      } else if (ladleid == 139) {
        directionIcon = baseUrl + "Ladle/" + Color + '/4.png';
      } else if (ladleid == 140) {
        directionIcon = baseUrl + "Ladle/" + Color + '/5.png';
      } else if (ladleid == 141) {
        directionIcon = baseUrl + "Ladle/" + Color + '/6.png';
      } else if (ladleid == 142) {
        directionIcon = baseUrl + "Ladle/" + Color + '/7.png';
      } else if (ladleid == 143) {
        directionIcon = baseUrl + "Ladle/" + Color + '/8.png';
      }


      return directionIcon;
    }

    function listMarkers() {
      httpResponse,
      latitudeArr = new Array(),
      longitudeArr = new Array(),
      unitnameArr = new Array(),
      regArr = new Array(),
      statusesArr = new Array();
      var temp_gmarkers = gmarkers;

      gmarkers = [];
      $.ajax({
        url: '<?php echo jquery_url() ?>lists/getListdata',
        dataType: 'text',
        success: function(responseText) {
          //    console.log(responseText);
          httpResponse = JSON.parse(responseText);
          httpResponse.forEach(function(data, index) {
            latitudeArr.push(data.latitude);
            longitudeArr.push(data.longitude);
            unitnameArr.push(data.unitname);
            regArr.push(data.registration);
            statusesArr.push(data.LOAD_STATUS);
          });


          latitudeArr.forEach(function(feature, index) {
            if (regArr[index] != "") {
              unitnameArr[index] = regArr[index];
            }
            var dir = httpResponse[index].lmid;
            if (dir == "") {
              dir = 0;
            }
            switch (statusesArr[index]) {
              case "201":
                directionIcon = laddlecarIcons(dir, 'LGreen');
                break;
              case "202":
                directionIcon = laddlecarIcons(dir, 'Green');
                break;
              case "203":
                directionIcon = laddlecarIcons(dir, 'LRed');
                break;
              case "204":
                directionIcon = laddlecarIcons(dir, 'Red');
                break;
              case "205":
                directionIcon = laddlecarIcons(dir, 'Green');
                break;
              default:
                directionIcon = laddlecarIcons(dir, 'Loco');
                break;
            }

            if (httpResponse[index].cycle == 0 && statusesArr[index] != null) {
              directionIcon = laddlecarIcons(dir, "Orange");
            }

            var markerIcon = {
              url: directionIcon,
              //scaledSize: new google.maps.Size(80, 80),
              //origin: new google.maps.Point(0, 0),
              // anchor: new google.maps.Point(32,65),
              labelOrigin: new google.maps.Point(10, 35)
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
            if (regArr[index] != "" && statusesArr[index] != null) {
              var text = "";
              text = getText(statusesArr[index], index);

              //console.log(statusesArr[index]);
              //console.log(text);
              if (text != "") {
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


    function getText(status, index) {
      //<ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul>
      var img = '<?php echo asset_url(); ?>images/battery_emp.png';
      if (parseFloat(httpResponse[index].fuel) > 10) {
        img = '<?php echo asset_url(); ?>images/battery_f.png';
      }

      var timehours = httpResponse[index].timehours;
      var minutes = Math.floor(timehours / 60);
      var idlet = "";
      if (minutes > 19000000 && httpResponse[index].cycle == "1") {
        idlet = "<li><strong>Idle Time(min):</strong> " + minutes + " </li>";
      }
      switch (status) {
        case "201":
          text = "<h3>" + httpResponse[index].ladleno + "<span class='battery_icon'><img src='" + img + "'/></span></h3>" +
            "<ul><li><strong>Cast No:</strong> " + httpResponse[index].TAPNO + " </li>" +
            "<li><strong>Loadtime:</strong> " + httpResponse[index].LOAD_DATE + " </li>" +
            "<li><strong>Source:</strong> " + httpResponse[index].SOURCE + " </li>" +
            "<li><strong>Runner HM Si%:</strong> " + httpResponse[index].SI + " </li>" +
            "<li><strong>Runner HM Sulphur%:</strong> " + httpResponse[index].S + " </li>" +
            "<li><strong>Runner Temp:</strong> " + parseInt(httpResponse[index].TEMP) + " </li>" + idlet + "</ul>";
          break;
        case "202":
          text = "<h3>" + httpResponse[index].ladleno + "<span class='battery_icon'><img src='" + img + "'/></span></h3>" +
            "<ul><li><strong>Cast No:</strong> " + httpResponse[index].TAPNO + " </li>" +
            "<li><strong>Loadtime:</strong> " + httpResponse[index].LOAD_DATE + " </li>" +
            "<li><strong>Source:</strong> " + httpResponse[index].SOURCE + " </li>" +
            "<li><strong>Destination:</strong> " + httpResponse[index].DEST + " </li>" +
            "<li><strong>Runner HM Si%:</strong> " + httpResponse[index].SI + " </li>" +
            "<li><strong>Runner HM Sulphur%:</strong> " + httpResponse[index].S + " </li>" +
            "<li><strong>Runner Temp:</strong> " + parseInt(httpResponse[index].TEMP) + " </li>" +
            "<li><strong>Gross Weight:</strong> " + httpResponse[index].GROSS_WEIGHT + " </li>" +
            "<li><strong>Tare Weight:</strong> " + httpResponse[index].TARE_WEIGHT + " </li>" +
            "<li><strong>Net Weight:</strong> " + httpResponse[index].NET_WEIGHT + " </li>" + idlet + "</ul>";
          break;
        case "203":
          text = "<h3>" + httpResponse[index].ladleno + "<span class='battery_icon'><img src='" + img + "'/></span></h3>" +
            "<ul><li><strong>Unload time:</strong> " + httpResponse[index].smstime + " </li>" +
            "<li><strong>Tare Weight:</strong> " + httpResponse[index].TARE_WEIGHT + " </li>" +
            "<li><strong>Net Weight:</strong> " + 0 + " </li>" + idlet + "</ul>";
          break;
        case "204":
          text = "<h3>" + httpResponse[index].ladleno + "<span class='battery_icon'><img src='" + img + "'/></span></h3>" +
            "<ul><li><strong>Unload time:</strong> " + httpResponse[index].smstime + " </li>" +
            "<li><strong>2nd Tare Weight:</strong> " + httpResponse[index].TARE_WT2 + " </li>" +
            "<li><strong>2nd Net Weight:</strong> " + 0 + " </li>" + idlet;
          if (httpResponse[index].remarks != null) {
            text += "<li><strong>Remarks:</strong> " + httpResponse[index].remarks + " </li>";
          }
          text += "</ul>";
          break;

        case "205":
          text = "<h3>" + httpResponse[index].ladleno + " <span class='battery_icon'><img src='" + img + "'/></span></h3>" +
            "<ul><li><strong>Cast No:</strong> " + httpResponse[index].TAPNO + " </li>" +
            "<li><strong>Loadtime:</strong> " + httpResponse[index].LOAD_DATE + " </li>" +
            "<li><strong>Source:</strong> " + httpResponse[index].SOURCE + " </li>" +
            "<li><strong>Runner HM Si%:</strong> " + httpResponse[index].SI + " </li>" +
            "<li><strong>Runner HM Sulphur%:</strong> " + httpResponse[index].S + " </li>" +
            "<li><strong>Runner Temp:</strong> " + parseInt(httpResponse[index].TEMP) + " </li>" +
            "<li><strong>Gross Weight:</strong> " + httpResponse[index].GROSS_WEIGHT + " </li>" +
            "<li><strong>Tare Weight:</strong> " + httpResponse[index].TARE_WEIGHT + " </li>" +
            "<li><strong>Net Weight:</strong> " + httpResponse[index].NET_WEIGHT + " </li>" + idlet + "</ul>";
          break;

        default:
          text = "";
          break;
      }

      return text;
    }


    function getAlertsData() {
      $.get("<?php echo base_url() ?>dashboard/getServiceAlert", function(data) {
        data = $.trim(data);
        if (data != "") {

          if ($("#homeModal").hasClass("in")) {

            $('#homeModal').modal('hide')
          }

          if ($("#otherModal").hasClass("in")) {

            $('#otherModal').modal('hide')
          }

          if (!$("#errorModal").hasClass("in")) {

            $('#errorModal').modal('show')
          }
          $("#error-msg").html(data);
          //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
        }
      });
    }


    function getBfProduction() {
      $.get("<?php echo base_url() ?>dashboard/getBfProduction", function(data) {

        data = $.trim(data);
        if (data != "") {

          if ($("#homeModal").hasClass("in")) {

            $('#homeModal').modal('hide')
          }

          if ($("#otherModal").hasClass("in")) {

            $('#otherModal').modal('hide')
          }

          if (!$("#errorModal1").hasClass("in")) {

            $('#errorModal1').modal('show')


          }
          $("#error-msg1").html(data);
          //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
        }
      });
    }


    function getSmsMetal() {


      $.get("<?php echo base_url() ?>dashboard/getSmsMetal", function(data) {
        data = $.trim(data);
        if (data != "") {

          if ($("#homeModal").hasClass("in")) {

            $('#homeModal').modal('hide')
          }

          if ($("#otherModal").hasClass("in")) {

            $('#otherModal').modal('hide')
          }

          if (!$("#errorModal2").hasClass("in")) {

            $('#errorModal2').modal('show')
          }
          $("#error-msg2").html(data);
          //$("#shake_text").effect( "shake" , {times:1, direction:"up"});
        }
      });
    }

    function setGeofence() {




      /* $.ajax({
             url:  '<?php echo base_url(); ?>lists/getReplayGeofence?type=2',
             dataType: 'json',
             success: function(data){              
               rectangularGeoStore = data;
             }
         });  */

      $.ajax({
        url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=3',
        dataType: 'json',
        success: function(data) {
          var polyResponse = data;

          polyResponse.forEach(function(data, i) {
            var PolyCoords = new Array();
            var polyGeobounds = new google.maps.LatLngBounds();
            var allGeobounds = new google.maps.LatLngBounds();
            var latlon = data.latlon;
            var latlonsplit = latlon.split(":");
            for (var k = 0; k < latlonsplit.length; k++) {
              if (latlonsplit[k] != "") {
                var s = latlonsplit[k].toString();
                var s1 = s.substring(1, s.length - 1);
                var s2 = s1.split(",");
                var ln = new google.maps.LatLng(parseFloat(s2[0]), parseFloat(s2[1]));
                PolyCoords.push(ln);
              }
            }
            var colr = data.colour;
            var polygon = new google.maps.Polygon({
              map: map,
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
              fontColor: '#000',
              fontWeight: 'bold',
              strokeWeight: 1.2,
              strokeColor: '#000',
              labelClass: "labels",
              align: 'center',
              rotation: 50
            });


            for (var j = 0; j < PolyCoords.length; j++) {
              allGeobounds.extend(PolyCoords[j]);
              polyGeobounds.extend(PolyCoords[j]);

            }

            //console.log(polyGeobounds);//console.log(data.lat);//console.log(data.lon);

            mapLabel.set('position', new google.maps.LatLng(data.lat, data.lon));
            mapLabel.set('text', data.geofenceName);
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
        url: '<?php echo base_url(); ?>lists/getTrack',
        dataType: 'json',
        success: function(data) {
          var polylineResponse = data;

          polylineResponse.forEach(function(data, i) {

            var PolyCoords = new Array();
            var polyGeobounds = new google.maps.LatLngBounds();
            var allGeobounds = new google.maps.LatLngBounds();
            var latlon = data.latlon;
            var latlonsplit = latlon.split(":");
            for (var k = 0; k < latlonsplit.length; k++) {
              if (latlonsplit[k] != "") {
                var s = latlonsplit[k].toString();
                var s1 = s.substring(1, s.length - 1);
                var s2 = s1.split(",");
                var ln = new google.maps.LatLng(parseFloat(s2[0]), parseFloat(s2[1]));
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
        url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=1',
        dataType: 'json',
        success: function(data) {
          cirResponse = data;
          cirResponse.forEach(function(data, i) {
            var colr = data.colour;
            var circle = new google.maps.Circle({

              map: map,
              center: new google.maps.LatLng(data.latitude, data.longitude),
              radius: parseFloat(data.radius) + 0.00,
              options: {
                strokeWeight: 0,
                fillOpacity: 0.45,
                fillColor: colr,
                title: data.geofenceName,
                editable: false,
                visible: true
              }
            });
            var mapLabel = new MapLabel({
              map: map,
              fontSize: 12,
              fontColor: '#fff000',
              fontWeight: 10,
              strokeWeight: 3,
              strokeColor: '#000000',
              labelClass: "labels",
              align: 'center'
            });
            mapLabel.set('position', circle.getCenter());
            mapLabel.set('text', data.geofenceName);
            circle.bindTo('map', mapLabel);
            circle.bindTo('position', mapLabel);
            circle.setVisible(true);
            mapLabel.setMap(map);

          });
        }

      });

    }

    var iconBase = '<?php echo asset_url() ?>images/';


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
      strokeColor: '#FF0000',
      fillColor: '#FF0000',
      fillOpacity: 0

    };

    function initMap1() {
      // alert("oldmap");
      var styledMapType1 = new google.maps.StyledMapType(
        [{
            elementType: 'geometry',
            stylers: [{
              color: '#fff'
            }]
          },
          {
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#fff'
            }]
          },
          {
            elementType: 'labels.text.stroke',
            stylers: [{
              color: '#fff'
            }]
          },
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
            stylers: [{
              color: '#000000'
            }]
          },
          {
            // featureType: 'landscape.natural',
            elementType: 'geometry',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'poi',
            elementType: 'geometry',
            stylers: [{
              color: '#dbecec'
            }]
          },
          // {
          //   featureType: 'poi',
          //   elementType: 'labels.text.fill',
          //   stylers: [{color: '#7aa5cd'}]
          // },
          {
            featureType: 'poi.park',
            elementType: 'geometry.fill',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'poi.park',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#dbecec'
            }]
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
            stylers: [{
              color: 'red'
            }]
          },
          {
            featureType: 'road.highway.controlled_access',
            elementType: 'geometry.stroke',
            stylers: [{
              color: 'red'
            }]
          },
          {
            featureType: 'road.local',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#806b63'
            }]
          },
          // {
          //   featureType: 'transit.line',
          //   elementType: 'geometry',
          //   stylers: [{color: '#dfd2ae'}]
          // },
          {
            featureType: 'transit.line',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#8f7d77'
            }]
          },
          {
            featureType: 'transit.line',
            elementType: 'labels.text.stroke',
            stylers: [{
              color: '#ebe3cd'
            }]
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
        ], {
          name: 'Map'
        });
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        rotation: 5,
        gestureHandling: "greedy",
        // mapTypeId:'styled_map',

        //center: {lat:15.178180945596363, lng:76.65809154510498},
        center: {
          lat: 18.6872633,
          lng: 73.0406250
        },
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
        if (regArr[index] != "") {
          unitnameArr[index] = regArr[index];
        }
        var dir = httpResponse[index].lmid;
        if (dir == "") {
          dir = 0;
        }
        // alert(statuses);
        switch (statuses) {
          // switch(statuses){
          case "201":
            directionIcon = laddlecarIcons(dir, 'LGreen');
            break;
          case "202":
            directionIcon = laddlecarIcons(dir, 'Green');
            break;
          case "203":
            directionIcon = laddlecarIcons(dir, 'LRed');
            break;
          case "204":
            directionIcon = laddlecarIcons(dir, 'Red');
            break;
          case "205":
            directionIcon = laddlecarIcons(dir, 'Green');
            break;
          default:
            directionIcon = laddlecarIcons(dir, 'Loco');
            break;

        }

        if (httpResponse[index].cycle == 0) {
          directionIcon = laddlecarIcons(dir, "Orange");
        }
        // console.log(directionIcon);
        var markerIcon = {
          url: directionIcon,
          //scaledSize: new google.maps.Size(80, 80),
          //origin: new google.maps.Point(0, 0),
          // anchor: new google.maps.Point(32,65),
          labelOrigin: new google.maps.Point(10, 35)
          //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
        };
        //console.log(unitnameArr[index]+"------"+parseInt(dir));

        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(latitude, longitude),
          icon: markerIcon,
          title: unitname,
          label: unitname,
          map: map,
          label: {
            color: '#2a4dce',
            fontWeight: 'bold',
            fontSize: '11px',
            //text: unitname
          },
          optimized: false,

        });

        if (statuses != null) {
          var text = "";
          //console.log(color+"----"+unitnameArr[index]+"----"+statusesArr[index]+"----"+icons[color].icon);
          text = getTextNew(statuses);

          //console.log(statusesArr[index]);
          console.log(text);
          if (text != "") {
            fnPlaceMarkers1(marker, text);
          }
        }
        gmarkers.push(marker);
      });
      var myoverlay = new google.maps.OverlayView();
      myoverlay.draw = function() {
        // add an id to the layer that includes all the markers so you can use it in CSS
        this.getPanes().markerLayer.id = 'markerLayer';
      };
      myoverlay.setMap(map);



      map.mapTypes.set('styled_map', styledMapType1);
      map.setMapTypeId('styled_map');


      //console.log(map);
      google.maps.event.addListenerOnce(map, 'idle', function() {
        //loaded fully
        timer = setTimeout("animateMarkers()", 1000);

      });


    }



    function initMap() {
      var styledMapType5 = new google.maps.StyledMapType(
        [{
            elementType: 'geometry',
            stylers: [{
              color: '#fff'
            }]
          },
          {
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#fff'
            }]
          },
          {
            elementType: 'labels.text.stroke',
            stylers: [{
              color: '#fff'
            }]
          },
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
            stylers: [{
              color: '#000000'
            }]
          },
          {
            // featureType: 'landscape.natural',
            elementType: 'geometry',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'poi',
            elementType: 'geometry',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'poi.park',
            elementType: 'geometry.fill',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'poi.park',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#dbecec'
            }]
          },
          {
            featureType: 'road',
            elementType: 'geometry',

          },
          {
            featureType: 'road.highway.controlled_access',
            elementType: 'geometry',
            stylers: [{
              color: 'red'
            }]
          },
          {
            featureType: 'road.highway.controlled_access',
            elementType: 'geometry.stroke',
            stylers: [{
              color: 'red'
            }]
          },
          {
            featureType: 'road.local',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#806b63'
            }]
          },
          {
            featureType: 'transit.line',
            elementType: 'labels.text.fill',
            stylers: [{
              color: '#8f7d77'
            }]
          },
          {
            featureType: 'transit.line',
            elementType: 'labels.text.stroke',
            stylers: [{
              color: '#ebe3cd'
            }]
          },
        ], {
          name: 'Map'
        });


      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        rotation: 5,
        gestureHandling: "greedy",


        center: {
          lat: 18.6872633,
          lng: 73.0406250
        },

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
        if (regArr[index] != "") {
          unitnameArr[index] = regArr[index];
        }
        var dir = httpResponse[index].lmid;
        if (dir == "") {
          dir = 0;
        }
        switch (statusesArr[index]) {
          case "201":
            directionIcon = laddlecarIcons(dir, 'LGreen');
            break;
          case "202":
            directionIcon = laddlecarIcons(dir, 'Green');
            break;
          case "203":
            directionIcon = laddlecarIcons(dir, 'LRed');
            break;
          case "204":
            directionIcon = laddlecarIcons(dir, 'Red');
            break;
          case "205":
            directionIcon = laddlecarIcons(dir, 'Green');
            break;
          default:
            directionIcon = laddlecarIcons(dir, "Loco");
            break;
        }

        if (httpResponse[index].cycle == 0 && statusesArr[index] != null) {
          directionIcon = laddlecarIcons(dir, "Orange");
        }
        var markerIcon = {
          url: directionIcon,
          labelOrigin: new google.maps.Point(10, 35)

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


        if (regArr[index] != "" && statusesArr[index] != null) {
          var text = "";
          text = getText(statusesArr[index], index);

          if (text != "") {
            fnPlaceMarkers(marker, text);
          }
        }
        gmarkers.push(marker);



      });


      var myoverlay = new google.maps.OverlayView();
      myoverlay.draw = function() {
        this.getPanes().markerLayer.id = 'markerLayer';
      };
      myoverlay.setMap(map);



      map.mapTypes.set('styled_map', styledMapType5);
      map.setMapTypeId('styled_map');



      google.maps.event.addListenerOnce(map, 'idle', function() {

        timer = setTimeout("animateMarkers()", 1000);

      });

    }


    function animateMarkers() {

      httpResponse.forEach(function(feature, index) {
        if (httpResponse[index].registration != "") {
          httpResponse[index].unitname = httpResponse[index].registration;
        }
        var timehours = httpResponse[index].timehours;
        var minutes = Math.floor(timehours / 60);

        if ((httpResponse[index].LOAD_STATUS == "202" && httpResponse[index].cycle == "1"))

        {
          gmarkers[index].setVisible(false);
          setTimeout(function() {
            gmarkers[index].setVisible(true);
          }, 200);

        }
      });
      setTimeout("animateMarkers()", 1000);
    }


    closeImageBtn();

    function closeImageBtn() {
      $(".gm-style-iw").next().remove();
    }
  </script>

