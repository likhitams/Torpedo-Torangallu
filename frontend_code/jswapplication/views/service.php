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


    <div class="page-content">
        <div class="container-fluid">


            <div class="card mt-4">
                <div class="card-body">

                        <h2>Ladle Next Service Details</h2>
                    <form action="<?php echo base_url(); ?>operations/saveService" method="post" onsubmit="return validateForm();">
                        <div class="full_body">
                            <?php echo $this->session->flashdata("message"); ?>
                            <div class="table-responsive">

                                <div id="myGrid" style="width: 100%; height: 450px ;" class="ag-blue"></div>





                            </div>

                        </div>
                        <?php if ($detail[0]->userRole == 'c' || $detail[0]->userRole == 'a') { ?>
                            <div class="fixed_footer">
                                <button type="submit" class="btn btn-success"><i class="fa-solid fa-check"></i> SAVE</button>
                                <button type="reset" class="btn btn-danger btn-reset"><i class="fa fa-repeat"></i> RESET</button>
                                <button class="btn btn-success btn-min" type="button" title="Download Excel" onclick="convertdata();"><i class="fa-solid fa-file-excel"></i> DOWNLOAD EXCEL</button>
                            </div>
                        <?php } ?>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>



    <script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url() ?>js/bootstrap.js"></script>
    <?php echo $jsfileone; ?>

    <script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

    <?php echo $jsfile; ?>

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
                headerName: "Ladle No",
                field: "ladleno",
                width: 675,
                cellClass: 'textAlignLeft',
                filter: 'number',
                cellEditor: NumericCellEditor
            },
            {
                headerName: " Next Service Date",
                field: "servicedate",
                width: 670,
                filter: 'text',
                cellClass: 'textAlignLeft',
                cellRenderer: checkDatepicker,
                suppressFilter: true
            }
        ];


        function checkDatepicker(params) {
            var val = "";
            if (params.data === undefined || params.data === null) {
                return false;
            } else {

                reval = '<div class="form-group col-md-10">' +
                    '<div class="input-group date date-picker1">' +
                    '<input type="text" class="form-control installDate" name="installDate[]" autocomplete="off" id="installDate' + params.data.id + '" value="' + params.value + '"/>' +
                    '<span class="input-group-addon cal-icon" onclick="$(\'#installDate' + params.data.id + '\').focus();">' +
                    '<span class="fa-regular fa-calendar"></span>' +
                    '</span>' +
                    '</div>' +
                    '</div><input class="oldbattery" type="hidden" name="oldbattery[]" value="' + params.data.oldbattery + '"/><input class="batteryno" type="hidden" id="batteryno' + params.data.id + '" name="batteryno[]" value="' + params.data.batteryno + '"/>' +
                    '<input class="unitname" type="hidden" name="unitname[]" value="' + params.data.unitname + '"/><input class="carid" type="hidden" name="carid[]" value="' + params.data.id + '"/>';
                return reval;
            }
        }

        function validateForm() {
            //alert();
            var cm = gridOptions.columnApi.getAllDisplayedColumns();
            var installDate = $(".installDate");
            var oldbattery = $(".oldbattery");
            var batteryno = $(".batteryno");
            var unitname = $(".unitname");
            var id = $(".carid");

            var cnt = installDate.length;
            //console.log(cnt);
            //alert(cnt);
            if (cnt == 0) {
                $("#error-msg").html("No records found to update.");
                $("#alertbox").click();
                return false;
            } else {
                for (var i = 0; i < cnt; i++) {
                    var existingval = oldbattery[i].value;
                    //console.log(batteryno[i].value);
                    if (batteryno[i].value != existingval && empty_string.test(installDate[i].value)) {
                        $("#error-msg").html("Please enter Battery Install Date for Ladle Car: " + unitname[i].value);
                        $("#alertbox").click();
                        return false;
                    }
                }
            }
        }



        // function to act as a class
        function NumericCellEditor() {}

        // gets called once before the renderer is used
        NumericCellEditor.prototype.init = function(params) {
            // we only want to highlight this cell if it started the edit, it is possible
            // another cell in this row started teh edit
            //this.focusAfterAttached = params.cellStartedEdit;

            // create the cell
            this.eInput = document.createElement('input');
            this.eInput.style.width = '100%';
            this.eInput.style.height = '100%';
            //this.eInput.value = isCharNumeric(params.charPress) ? params.charPress : params.value;
            this.eInput.value = params.value;
            //this.eInput.className = "exbatteryno";
            var that = this;
            this.eInput.addEventListener('keydown', function(event) {
                that.onKeyDown(event);
            });

            this.eInput.addEventListener('keyup', function(event) {

                string = this.value;
                string = string.replace(',', '.').replace(/[^\d]/g, "").replace(/\./, "x").replace(/\./g, "").replace(/x/, ".");
                //string = Math.round( parseFloat(string) * 100) / 100;
                //console.log(string);
                this.value = string;
                $("#batteryno" + params.node.data.id).val(string);
            });
        };



        NumericCellEditor.prototype.onKeyDown = function(event) {
            var key = event.which || event.keyCode;
            if (key === 37 || // left
                key === 39) { // right
                event.stopPropagation();
            }
        };

        // gets called once when grid ready to insert the element
        NumericCellEditor.prototype.getGui = function() {
            return this.eInput;
        };

        // focus and select can be done after the gui is attached
        NumericCellEditor.prototype.afterGuiAttached = function() {
            // only focus after attached if this cell started the edit
            if (this.focusAfterAttached) {
                this.eInput.focus();
                this.eInput.select();
            }
        };


        // returns the new value after editing
        NumericCellEditor.prototype.getValue = function() {
            return this.eInput.value;
        };

        // when we tab onto this editor, we want to focus the contents
        NumericCellEditor.prototype.focusIn = function() {
            var eInput = this.getGui();
            eInput.focus();
            eInput.select();
            console.log('NumericCellEditor.focusIn()');
        };

        // when we tab out of the editor, this gets called
        NumericCellEditor.prototype.focusOut = function() {
            // but we don't care, we just want to print it for demo purposes
            console.log('NumericCellEditor.focusOut()');
        };

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
            editType: 'fullRow',
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
                url: '<?php echo jquery_url() ?>operations/getLadleServiceData',
                dataType: 'json',
                success: function(data) {
                    setRowData(data);
                }
            });

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

                if (filterPresent && filterModel.batteryno) {
                    var contactno = item.batteryno;
                    var allowedName = filterModel.batteryno.filter;
                    var flagName = checkNumLoop(filterModel.batteryno.type, contactno, allowedName);

                    if (flagName == 1) {
                        continue;
                    }
                }

                resultOfFilter.push(item);
            }
            // $("#unitCount").html(resultOfFilter.length);
            return resultOfFilter;
        }


        function createWorksheet() {
            //	Calculate cell data types and extra class names which affect formatting
            var cellType = [],
                title = "Next Service Details";
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

            //		                Generate worksheet header details.
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

            //		                Generate the data rows from the data in the Store
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
            var title = "Next Service Details";
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

    <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
    <script src="<?php echo asset_url(); ?>js/moment.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.datetimepicker.full.js"></script>

    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(document).ready(function() {

            $j.datetimepicker.setLocale('en');

            $('body').on('focus', ".installDate", function(event) {
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
                format: 'd-m-Y',
                formatDate: 'd-m-Y',
                //formatTime:'H:i',
                timepicker: false,
                validateOnBlur: true,
                //maxDate:0,
                minDate: new Date(),
                todayButton: true,
                value: ""
            });


        }
    </script>


</body>

</html>