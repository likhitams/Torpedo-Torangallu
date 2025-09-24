<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title><?php echo title; ?></title>
  <link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
  <link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
  <link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />


  <?php echo $updatelogin;
  $role = $detail[0]->userRole;
  ?>
  <?php echo $updatelogin;
  $uid = $detail[0]->userId;
  $compny = $detail[0]->companyid;

  $language = $detail[0]->language;
  $role = $detail[0]->userRole;

  ?>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="dark-sidenav">

  <button data-toggle="modal" data-target="#errorModal" style="display: none;" id="alertbox"></button>
  <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
    <div class="modal-dialog" role="document" style="width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title" id="errorModalLabel">Alert !!</h4>
        </div>
        <div class="modal-body">
          <p id="error-msg"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="far fa-check-circle"></i> &nbsp;OK</button>

        </div>
      </div>
    </div>
  </div>


  <?php echo $header; ?>
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel">
    <div class="modal-dialog" role="document">
 <form class="form-inline" action="addremarks" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title" id="newModalLabel">Add Remarks</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label class="col-md-4">Remarks</label>
              <span class="col-md-8">
                <input type="text" class="form-control driverClass" name="remarks" id="remarks" required>
              </span>
            </div>

        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-dark closeButton newButton" data-dismiss="modal" id="closeButton"><i class="fa-solid fa-xmark"></i> CLOSE</button>
        
          <button type="submit" id="saveButton" class="btn btn-success newButton"><i class="fa-solid fa-check"></i> SAVE</button>
          <div id="msg_box"></div>
        </div>
      </div>
    </form>
    </div>
  </div>
  <button data-toggle="modal" data-target="#newModal" style="display: none;" id="editbox"></button>

<div class="modal fade" id="newModalremarks" tabindex="-1" role="dialog" aria-labelledby="newModalLabelremarks">
    <div class="modal-dialog" role="document">
 
      <div class="modal-content">
        <div class="modal-header">
          <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title" id="newModalLabelremarks">Edit Remarks</h4>
            <button type="button" class="btn btn-dark closeButton newButton" data-dismiss="modal" id="closeButton"><i class="fa-solid fa-xmark"></i> CLOSE</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
     <?php
      // $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
$connect = mysqli_connect("127.0.0.1", "root", '', "suvetracg");
$sql = "SELECT id, remarks FROM ladle_remarks";
$result = mysqli_query($connect, $sql);

// Display data in a table
echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Remarks</th>';
echo '<th>Action</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['remarks'] . '</td>';
    echo '<td>';
    echo '<button class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal' . $row['id'] . '">Edit</button>';

    echo '<button class="btn btn-danger delete-button" data-toggle="modal"  data-target="#deleteModal' . $row['id'] . '">Delete</button>';
    echo '</td>';
    echo '</tr>';

    // Edit Modal for a Specific Record
echo '<div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id'] . '">';
echo '  <div class="modal-dialog" role="document">';
echo '    <div class="modal-content">';
echo '      <div class="modal-header">';
// echo '        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
echo '        <h4 class="modal-title" id="editModalLabel' . $row['id'] . '">Edit Record</h4>';
echo '      </div>';
echo '      <div class="modal-body">';
echo '        <form action="update_remark" method="POST">'; // Change the form action to your update script
echo '          <div class="form-group">';
echo '            <label for="editedRemark">Edit Remark:</label>';
echo '            <input type="text" class="form-control" required id="editedRemark" name="editedRemark" value="' . $row['remarks'] . '">';
echo '          </div>';
echo '          <input type="hidden" name="remarkId" value="' . $row['id'] . '">';
echo '          <button type="submit" class="btn btn-primary">Update</button>';
echo '        </form>';
echo '      </div>';
echo '      <div class="modal-footer">';
echo '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
echo '      </div>';
echo '    </div>';
echo '  </div>';
echo '</div>';

    // Delete Modal for a Specific Record
echo '<div class="modal fade" id="deleteModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['id'] . '">';
echo '  <div class="modal-dialog" role="document">';
echo '    <div class="modal-content">';
echo '      <div class="modal-header">';
// echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
echo '        <h4 class="modal-title" id="deleteModalLabel' . $row['id'] . '">Delete Record</h4>';
echo '      </div>';
echo '      <div class="modal-body">';
echo '        <form action="delete_remark" method="POST">';
// echo '          <p>Are you sure you want to delete this remark?</p>';
echo '          <input type="hidden" name="remarkIdToDelete" value="' . $row['id'] . '">';
echo '          <button type="submit" class="btn btn-danger">Delete</button>';
echo '          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
echo '        </form>';
echo '      </div>';
echo '    </div>';
echo '  </div>';
echo '</div>';
}

echo '</tbody>';
echo '</table>';
?>

            </div>

        </div>
      
      </div>
    </form>
    </div>
  </div>


  <!-- <button data-toggle="modal" data-target="#newModalremarks" style="display: none;" id="editbox"></button> -->

  <div class="page-content">
    <div class="container-fluid">

      <div class="card mt-4">

        <div class="card-body">
          <h2>Circulation / Non Circulation</h2>

          <form action="<?php echo base_url(); ?>operations/saveCycling" method="post" onsubmit="return validateForm();">
            <div class="full_body">
             
              <?php echo $this->session->flashdata("message"); ?>
              
              <div class="table-responsive">
                <div id="myGrid" style="width: 100%; height: 450px ;" class="ag-blue"></div>
              </div>

            </div>
            <?php if ($detail[0]->userRole == 'c' || $detail[0]->userRole == 'a') { ?>
              <div class="fixed_footer">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newModal" onclick="$('.newButton').show();setDatepicker();$('.updateButton').hide();"><i class="fa-solid fa-plus"></i> Add Remarks</button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newModalremarks" onclick="$('.newButton').show();setDatepicker();$('.updateButton').hide();"><i class="fa-solid fa-plus"></i> view Remarks</button>
              
                <button type="reset" class="btn btn-danger btn-reset"><i class="fa fa-repeat"></i> RESET</button>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-check"></i> SAVE</button>
              
                <!--  <button  class="btn btn-success btn-min" type="button" title="Download Excel" onclick="convertdata();"><i class="fa-solid fa-file-excel"></i></button>  -->
              </div>
            <?php } ?>
          </form>
        </div>

      </div>
    </div>
  </div>
  </div>


  <script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
  <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
  
<?php echo $jsfile; ?>
  <script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

<script src="<?php echo asset_url(); ?>js/jquery.validationEngine.js"></script>
  <script src="<?php echo asset_url(); ?>js/jquery.validationEngine-en.js"></script>
  <?php echo $jsfileone; ?>
  <script src="<?php echo asset_url() ?>js/bootstrap.js"></script>
<script src="<?php echo asset_url(); ?>js/jquery.validate.min.js"></script>

  <script type="text/javascript">
    var empty_string = /^\s*$/;


    var h;
    $(document).ready(function() {
      h = $(document).height() - 170;
    });
    var arra = new Array();
    var columnDefs = [{
        headerName: "id",
        field: "id",
        width: 0,
        hide: true
      },
      {
        headerName: "Laddle No",
        field: "ladleno",
        width: 250,
        cellClass: 'textAlignLeft',
        suppressFilter: true
      },
      {
        headerName: "Move to Circulation",
        field: "cycle",
        width: 250,
        cellClass: 'textAlign',
        cellRenderer: checkCycling,
        suppressFilter: true
      },
      {
        headerName: "Move to Non Circulation",
        field: "cycle",
        width: 250,
        cellClass: 'textAlign',
        cellRenderer: checkNonCycling,
        suppressFilter: true
      },
      {
        headerName: "Date & Time",
        field: "dateandtime",
        width: 250,
        cellClass: 'textAlign',
        cellRenderer: checkDatepicker,
        suppressFilter: true
      },
      {
        headerName: "Remarks",
        field: "remarks",
        width: 250,
        cellClass: 'textAlign',
        cellRenderer: remarksBox,
        suppressFilter: true
      },
    ];

    var id = "",
      valatt = "";
    var gridOptions = {

      debug: true,
      enableServerSideSorting: true,
      enableServerSideFilter: true,
      enableColResize: true,
      rowSelection: 'multiple',
      rowDeselection: true,
      suppressRowClickSelection: true,
      overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
      columnDefs: columnDefs,
      rowModelType: 'infinite',
      paginationPageSize: 50,
      cacheOverflowSize: 2,
      maxConcurrentDatasourceRequests: 2,
      paginationInitialRowCount: 0,
      maxBlocksInCache: 2,
      getRowNodeId: function(item) {
        return item.id;
      },
    };

    gridOptions.rowHeight = 45;

    // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function() {
      var gridDiv = document.querySelector('#myGrid');
      new agGrid.Grid(gridDiv, gridOptions);
      setList();

    });


    function checkCycling(params) {
      var val = "";
      if (params.data === undefined || params.data === null) {
        return false;
      } else {
        var checked = "";
        if (params.data.cycle == 1) {
          checked = "checked";
        }
        reval = '<input class="cycling" type="radio" onclick="displayRemarks(' + params.data.id + ', ' + params.data.cycle + ')" name="cycling' + params.data.id + '" value="1" ' + checked + '/> <input class="ladleid" type="hidden" name="laddleid[]" value="' + params.data.id + '"/> <input class="oldladleid" type="hidden" name="oldladdleid[]" value="' + params.data.cycle + '"/> <input class="ladlename" type="hidden" name="ladlename[]" value="' + params.data.ladleno + '"/> ';
        return reval;
      }
    }

    function checkNonCycling(params) {
      var val = "";
      if (params.data === undefined || params.data === null) {
        return false;
      } else {
        var checked = "";
        //console.log(params.data.cycle);
        if (params.data.cycle == 0) {
          checked = "checked";
        }
        reval = '<input class="noncycling" type="radio" onclick="displayRemarks(' + params.data.id + ', ' + params.data.cycle + ')" id="noncycling' + params.data.id + '" name="cycling' + params.data.id + '" value="0" ' + checked + '/>';
        return reval;
      }
    }

    function displayRemarks(id, cycle) {
      $("#remarks" + id).hide();
      if (cycle == 1 && $("#noncycling" + id).is(":checked")) {
        $("#remarks" + id).show();
      }
    }

    function checkDatepicker(params) {
      var val = "";
      if (params.data === undefined || params.data === null) {
        return false;
      } else {

        reval = '<div class="form-group col-md-10">' +
          '<div class="input-group date date-picker1">' +
          '<input type="text" class="form-control cyclingDate" name="cyclingDate[]" autocomplete="off" id="cyclingDate' + params.data.id + '"/>' +
          '<span class="input-group-addon cal-icon" onclick="$(\'#cyclingDate' + params.data.id + '\').focus();">' +
          '<span class="fa-regular fa-calendar"></span>' +
          '</span>' +
          '</div>' +
          '</div>';

        return reval;
      }
    }

    function remarksBox(params) {
      var val = "";
      if (params.data === undefined || params.data === null) {
        return false;
      } else {
        var opts = '<option value="">Select</option>';
        <?php $remarks = $this->master_db->getRecords("ladle_remarks", array(), "id, remarks");
        foreach ($remarks as $rm) {
        ?>
          opts += '<option value="<?php echo $rm->id ?>"><?php echo $rm->remarks ?></option>';
        <?php } ?>
        reval = '<div class="form-group col-md-10" >' +
          '<select style="display:none;" class="form-control remarksClass" name="remarks[]" id="remarks' + params.data.id + '">' + opts +
          '</select>' +
          '</div>';

        return reval;
      }
    }

    function setGridHeight() {
      $("#myGrid").css("height", h + "px");
    }

    function onBtShowLoading() {
      gridOptions.api.showLoadingOverlay();
    }

    function onBtHide() {
      gridOptions.api.hideOverlay();
    }


    function setList() {
      onBtShowLoading();

      $.ajax({
        url: '<?php echo jquery_url() ?>operations/getLaddleNodata',
        dataType: 'json',
        success: function(data) {
          setRowData(data);
        }
      });
    }

    function validateForm() {
      //alert();
      var cm = gridOptions.columnApi.getAllDisplayedColumns();
      var cyclingDate = $(".cyclingDate");
      var cycling = $(".cycling");
      var noncycling = $(".noncycling");
      var ladleid = $(".ladleid");
      var oldladleid = $(".oldladleid");
      var ladlename = $(".ladlename");
      var remarksClass = $(".remarksClass");

      var cnt = cyclingDate.length;
      if (cnt == 0) {
        $("#error-msg").html("No records found to update.");
        $("#alertbox").click();
        return false;
      } else {
        for (var i = 0; i < cnt; i++) {
          //console.log(cycling[i]);
          var existingval = $("input[name='cycling" + ladleid[i].value + "']:checked").val();
          if (oldladleid[i].value != existingval && empty_string.test(cyclingDate[i].value)) {
            $("#error-msg").html("Please enter Date & Time for Ladle No.: " + ladlename[i].value);
            $("#alertbox").click();
            return false;
          } else if (oldladleid[i].value == "1" && noncycling[i].checked == true && empty_string.test(remarksClass[i].value)) {
            $("#error-msg").html("Please select Remarks for Ladle No.: " + ladlename[i].value);
            $("#alertbox").click();
            return false;
          }

        }
      }

    }


    var datatoExport = [];

    function setRowData(allOfTheData) {
      // give each row an id
      /* allOfTheData.forEach( function(data, index) {
           data.id = (index + 1);
       });*/
      //$("#unitCount").html(allOfTheData.length);
      var dataSource = {
        rowCount: null, // behave as infinite scroll
        getRows: function(params) {
          console.log('asking for ' + params.startRow + ' to ' + params.endRow);
          onBtShowLoading();
          // At this point in your code, you would call the server, using $http if in AngularJS.
          // To make the demo look real, wait for 500ms before returning
          setTimeout(function() {
            // take a slice of the total rows
            var dataAfterSortingAndFiltering = sortAndFilter(allOfTheData, params.sortModel, params.filterModel);
            datatoExport = dataAfterSortingAndFiltering;
            var rowsThisPage = dataAfterSortingAndFiltering.slice(params.startRow, params.endRow);
            // if on or after the last page, work out the last row.
            var lastRow = -1;
            if (dataAfterSortingAndFiltering.length <= params.endRow) {
              lastRow = dataAfterSortingAndFiltering.length;
            }
            // call the success callback
            params.successCallback(rowsThisPage, lastRow);
            //applyOdoClass();
            onBtHide();
          }, 50);
          onBtHide();
        }
      };

      gridOptions.api.setDatasource(dataSource);
      setGridHeight();
      //applyOdoClass();
    }

    function sortAndFilter(allOfTheData, sortModel, filterModel) {
      return sortData(sortModel, filterData(filterModel, allOfTheData))
    }

    function sortData(sortModel, data) {
      var sortPresent = sortModel && sortModel.length > 0;

      if (!sortPresent) {
        //console.log(sortPresent);
        return data;
      }
      // do an in memory sort of the data, across all the fields
      var resultOfSort = data.slice();
      // console.log(resultOfSort);
      resultOfSort.sort(function(a, b) {
        //console.log(a);
        //console.log(b);
        for (var k = 0; k < sortModel.length; k++) {
          var sortColModel = sortModel[k];
          // console.log(sortColModel);
          var cold = gridOptions.columnApi.getColumn(sortColModel.colId);
          //console.log(cold.filter);
          var valueA = a[sortColModel.colId];
          var valueB = b[sortColModel.colId];

          // console.log(valueA+"---"+valueB);
          // this filter didn't find a difference, move onto the next one
          if (valueA == valueB) {
            continue;
          }
          if (valueA === null) {
            valueA = "";
          }

          if (valueB === null) {
            valueB = "";
          }
          var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
          if (cold.filter == "number") {
            if (valueA == 'N/A' || valueA === null || valueA === "") {
              valueA = 0;
            }
            if (valueB == 'N/A' || valueB === null || valueB === "") {
              valueB = 0;
            }
            if (sortDirection == 1) {
              //  console.log("asc");
              return parseFloat(valueA) - parseFloat(valueB);
            } else if (sortDirection == -1) {
              //  console.log("desc");
              return parseFloat(valueB) - parseFloat(valueA);
            }
          } else if (valueA.toLowerCase() > valueB.toLowerCase()) {
            return sortDirection;
          } else {
            return sortDirection * -1;
          }
        }
        // no filters found a difference
        return 0;
      });
      return resultOfSort;
    }


    function filterData(filterModel, data) {

      var filterPresent = filterModel && Object.keys(filterModel).length > 0;

      var resultOfFilter = [];
      for (var i = 0; i < data.length; i++) {
        var item = data[i];

        if (filterPresent && filterModel.unitname) {
          var name = item.unitname;
          var allowedName = filterModel.unitname.filter;
          var flagName = checkStrLoop(filterModel.unitname.type, name.toLowerCase(), allowedName.toLowerCase());

          if (flagName == 1) {
            continue;
          }
        }

        if (filterPresent && filterModel.registration) {
          var contactno = item.registration;
          var allowedName = filterModel.registration.filter;
          var flagName = checkStrLoop(filterModel.registration.type, contactno.toLowerCase(), allowedName.toLowerCase());

          if (flagName == 1) {
            continue;
          }
        }

        resultOfFilter.push(item);
      }
      // $("#unitCount").html(resultOfFilter.length);
      return resultOfFilter;
    }
  </script>

  <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
  <script src="<?php echo asset_url(); ?>js/moment.js"></script>
  <script src="<?php echo asset_url(); ?>js/jquery.datetimepicker.full.js"></script>

  <script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(document).ready(function() {

      $j.datetimepicker.setLocale('en');

      $('body').on('focus', ".cyclingDate", function(event) {
        setdatepicker(this);
      });
    });

    function checkdays() {
      var start_date = $j('#start_date').val();
      var end_date = $j('#end_date').val();
      start_date = start_date.split("-");
      end_date = end_date.split("-");
      if (start_date.length > 1) {
        var a = moment(start_date[1] + "/" + start_date[0] + "/" + start_date[2], 'M/D/YYYY');
        var b = moment(end_date[1] + "/" + end_date[0] + "/" + end_date[2], 'M/D/YYYY');
        var diffDays = b.diff(a, 'days');

        return diffDays;

      } else {
        return -1;
      }
    }

    function checkTimeDiff() {
      var start_date = $j('#start_date').val();
      var end_date = $j('#end_date').val();
      var start_time = $j('#start_time').val();
      var end_time = $j('#end_time').val();
      start_date = start_date.split("-");
      end_date = end_date.split("-");
      //start_date = start_date.split("-");
      //end_date = end_date.split("-");
      if (start_date.length > 1) {
        var a = moment(start_date[1] + "/" + start_date[0] + "/" + start_date[2] + " " + start_time, 'M/D/YYYY HH:mm');
        var b = moment(end_date[1] + "/" + end_date[0] + "/" + end_date[2] + " " + end_time, 'M/D/YYYY HH:mm');
        var diffDays = b.diff(a, 'days');
        return diffDays;

      } else {
        return 1;
      }
    }

    function setdatepicker(val) {

      $j(val).datetimepicker({
        format: 'd-m-Y H:i',
        formatDate: 'd-m-Y',
        formatTime: 'H:i',
        timepicker: true,
        validateOnBlur: true,
        maxDate: 0,
        todayButton: true,
        value: ""
      });
    }

    function createWorksheet() {
      //  Calculate cell data types and extra class names which affect formatting
      var cellType = [],
        title = "Circulation/ Non Circulation Details";
      var cellTypeClass = [];
      var cm = gridOptions.columnApi.getAllDisplayedColumns();
      var totalWidthInPixels = 0;
      var colXml = '';
      var headerXml = '';
      var cnt = cm.length;
      for (var i = 0; i < cnt; i++) {

        var w = cm[i].colDef.width;
        totalWidthInPixels += w;
        colXml += '<ss:Column ss:AutoFitWidth="1" ss:Width="' + w + '" />';
        headerXml += '<ss:Cell ss:StyleID="headercell">' +
          '<ss:Data ss:Type="String">' + cm[i].colDef.headerName + '</ss:Data>' +
          '<ss:NamedCell ss:Name="Print_Titles" /></ss:Cell>';

        cellType.push("String");
        cellTypeClass.push("");

      }
      var visibleColumnCount = cellType.length;

      var result = {
        height: 9000,
        width: Math.floor(totalWidthInPixels * 30) + 50
      };

      //                Generate worksheet header details.
      var t = '<ss:Worksheet ss:Name="' + title + '">' +
        '<ss:Names>' +
        '<ss:NamedRange ss:Name="Print_Titles" ss:RefersTo="=\'' + title + '\'!R1:R2" />' +
        '</ss:Names>' +
        '<ss:Table x:FullRows="1" x:FullColumns="1"' +
        ' ss:ExpandedColumnCount="' + visibleColumnCount +
        '" ss:ExpandedRowCount="' + (datatoExport.length + 2) + '">' +
        colXml +
        '<ss:Row ss:Height="38">' +
        '<ss:Cell ss:StyleID="title" ss:MergeAcross="' + (visibleColumnCount - 1) + '">' +
        '<ss:Data xmlns:html="http://www.w3.org/TR/REC-html40" ss:Type="String">' +
        '<html:B><html:U><html:Font html:Size="15">' + title +
        '</html:Font></html:U></html:B></ss:Data><ss:NamedCell ss:Name="Print_Titles" />' +
        '</ss:Cell>' +
        '</ss:Row>' +
        '<ss:Row ss:AutoFitHeight="1">' +
        headerXml +
        '</ss:Row>';
      // console.log(t);
      var it = datatoExport,
        l = datatoExport.length;

      //                Generate the data rows from the data in the Store
      for (var i = 0; i < l; i++) {
        t += '<ss:Row>';
        var cellClass = (i & 1) ? 'odd' : 'even';
        r = datatoExport[i];

        var k = 0;
        var recordval;

        for (var j = 0; j < cnt; j++) {

          var v = r[cm[j].colDef.field];
          v = v == null ? "" : v;

          t += '<ss:Cell ss:StyleID="' + cellClass + cellTypeClass[k] + '"><ss:Data ss:Type="' + cellType[k] + '">';
          switch (cm[j].colDef.field) {
            default:
              t += v;
              break;
          }


          t += '</ss:Data></ss:Cell>';
          k++;
        }
        t += '</ss:Row>';
      }

      result.xml = t + '</ss:Table>' +
        '<x:WorksheetOptions>' +
        '<x:PageSetup>' +
        '<x:Layout x:CenterHorizontal="1" x:Orientation="Landscape" />' +
        '<x:Footer x:Data="Page &amp;P of &amp;N" x:Margin="0.5" />' +
        '<x:PageMargins x:Top="0.5" x:Right="0.5" x:Left="0.5" x:Bottom="0.8" />' +
        '</x:PageSetup>' +
        '<x:FitToPage />' +
        '<x:Print>' +
        '<x:PrintErrors>Blank</x:PrintErrors>' +
        '<x:FitWidth>1</x:FitWidth>' +
        '<x:FitHeight>32767</x:FitHeight>' +
        '<x:ValidPrinterInfo />' +
        '<x:VerticalResolution>600</x:VerticalResolution>' +
        '</x:Print>' +
        '<x:Selected />' +
        '<x:DoNotDisplayGridlines />' +
        '<x:ProtectObjects>False</x:ProtectObjects>' +
        '<x:ProtectScenarios>False</x:ProtectScenarios>' +
        '</x:WorksheetOptions>' +
        '</ss:Worksheet>';
      return result;
    }

    function exporttoExcel() {
      var title = "Circulation/Non Circulation Details";
      var worksheet = createWorksheet();
      // var totalWidth = this.getColumnModel().getTotalWidth(includeHidden);
      return '<\?xml version="1.0" encoding="utf-8"?>' +
        '<ss:Workbook xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:o="urn:schemas-microsoft-com:office:office">' +
        '<o:DocumentProperties><o:Title>' + title + '</o:Title></o:DocumentProperties>' +
        '<ss:ExcelWorkbook>' +
        '<ss:WindowHeight>' + worksheet.height + '</ss:WindowHeight>' +
        '<ss:WindowWidth>' + worksheet.width + '</ss:WindowWidth>' +
        '<ss:ProtectStructure>False</ss:ProtectStructure>' +
        '<ss:ProtectWindows>False</ss:ProtectWindows>' +
        '</ss:ExcelWorkbook>' +
        '<ss:Styles>' +
        '<ss:Style ss:ID="Default">' +
        '<ss:Alignment ss:Vertical="Top" ss:WrapText="1" />' +
        '<ss:Font ss:FontName="arial" ss:Size="10" />' +
        '<ss:Borders>' +
        '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Top" />' +
        '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Bottom" />' +
        '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Left" />' +
        '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Right" />' +
        '</ss:Borders>' +
        '<ss:Interior />' +
        '<ss:NumberFormat />' +
        '<ss:Protection />' +
        '</ss:Style>' +
        '<ss:Style ss:ID="title">' +
        '<ss:Borders />' +
        '<ss:Font />' +
        '<ss:Alignment ss:WrapText="1" ss:Vertical="Center" ss:Horizontal="Center" />' +
        '<ss:NumberFormat ss:Format="@" />' +
        '</ss:Style>' +
        '<ss:Style ss:ID="headercell">' +
        '<ss:Font ss:Bold="1" ss:Size="10" />' +
        '<ss:Alignment ss:WrapText="1" ss:Horizontal="Center" />' +
        '<ss:Interior ss:Pattern="Solid" ss:Color="#A3C9F1" />' +
        '</ss:Style>' +
        '<ss:Style ss:ID="even">' +
        '<ss:Interior ss:Pattern="Solid" ss:Color="#CCFFFF" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="even" ss:ID="evendate">' +
        '<ss:NumberFormat ss:Format="[ENG][$-409]dd\-mmm\-yyyy;@" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="even" ss:ID="evenint">' +
        '<ss:NumberFormat ss:Format="0" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="even" ss:ID="evenfloat">' +
        '<ss:NumberFormat ss:Format="0.00" />' +
        '</ss:Style>' +
        '<ss:Style ss:ID="odd">' +
        '<ss:Interior ss:Pattern="Solid" ss:Color="#CCCCFF" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="odd" ss:ID="odddate">' +
        '<ss:NumberFormat ss:Format="[ENG][$-409]dd\-mmm\-yyyy;@" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="odd" ss:ID="oddint">' +
        '<ss:NumberFormat ss:Format="0" />' +
        '</ss:Style>' +
        '<ss:Style ss:Parent="odd" ss:ID="oddfloat">' +
        '<ss:NumberFormat ss:Format="0.00" />' +
        '</ss:Style>' +
        '</ss:Styles>' +
        worksheet.xml +
        '</ss:Workbook>';
    }

    function convertdata() {
      //console.log(exporttoExcel());
      document.location = 'data:application/vnd.ms-excel;base64,' + base64_encode(exporttoExcel());
    }
  </script>

    <style>
        /* Styles for the popup/modal */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
  

    <!-- The popup/modal -->
    <div id="dataPopup" class="popup">
        <div class="popup-content">
            <h2>Add Data</h2>
            <input type="text" id="nameInput" placeholder="Name">
            <input type="text" id="emailInput" placeholder="Email">
            <button id="saveButton">Save</button>
            <button id="cancelButton">Cancel</button>
        </div>
    </div>

    <script>
        const addButton = document.getElementById('addButton');
        const dataPopup = document.getElementById('dataPopup');
        const nameInput = document.getElementById('nameInput');
        const emailInput = document.getElementById('emailInput');
        const saveButton = document.getElementById('saveButton');
        const cancelButton = document.getElementById('cancelButton');

        addButton.addEventListener('click', () => {
            nameInput.value = '';
            emailInput.value = '';
            dataPopup.style.display = 'block';
        });

        saveButton.addEventListener('click', () => {
            const newName = nameInput.value;
            const newEmail = emailInput.value;

            // Send the data to PHP script to add to the database
            fetch('addremarks.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `name=${encodeURIComponent(newName)}&email=${encodeURIComponent(newEmail)}`
            })
            .then(response => response.text())
            .then(result => {
                console.log(result);
                dataPopup.style.display = 'none';
            })
            .catch(error => {
                console.error(error);
                alert('Error adding data');
            });
        });

        cancelButton.addEventListener('click', () => {
            dataPopup.style.display = 'none';
        });
    </script>
<script type="text/javascript">
  $(document).ready(function() {
    // Use event delegation to handle clicks on dynamically generated buttons
    $(document).on('click', '.edit-button', function(e) {
        e.preventDefault();
        var targetModal = $(this).data('target');
        $(targetModal).modal('show');
    });
});

</script>
<script type="text/javascript">
  $(document).ready(function() {
    // Use event delegation to handle clicks on dynamically generated buttons
    $(document).on('click', '.delete-button', function(e) {
        e.preventDefault();
        var targetModal = $(this).data('target');
        $(targetModal).modal('show');
    });
});

</script>



</body>

</html>
