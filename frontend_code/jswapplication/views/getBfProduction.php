<?Php
       
    $dbhost = 'localhost';
    $dbname = 'suvetracg';  
    $dbuser = 'web';                  
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
        echo $json2[]= (int)$BF_PROD;
    }
  // This line is added to close mysql connection
   $dbcon = null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chart js</title>
</head>
<body>
<div align="center" style="width:900px; height: 400px;">
<canvas id="myChart"></canvas>
</div>

<script src="assets/js/Chart.min.js"></script>
 <script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');
    
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($json); ?>,
        datasets: [{
            label: " BF HM Production (tons)",
            backgroundColor: '#AC58FA',
            borderColor: 'red',
            data: <?php echo json_encode($json2); ?>,
        }]
    },

    // Configuration options go here
    options: {
          tooltips: {
              "enabled": false
            },
        "hover": {
              "animationDuration": 0
            },
        "animation": {
              "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                  ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
    }
    
});

</script>

<!-- 
<script>
 /* alert(arr2); */
var canvas = document.getElementById('myChart').getContext('2d');
new Chart(canvas, {
  type: 'bar',
  data: {
    //labels: arr,
    datasets: [
                {
          //label: "SLAMet%",
          type: "line",
          yAxisID: 'B',
          borderColor: "#3cba9f",
          data: <?php echo json_encode($json2); ?>,
          fill: false
        },{
      //label: 'TotalRMA',
      yAxisID: 'A',
      type: "bar",
      backgroundColor: "#3e95cd",
      data: <?php echo json_encode($json2); ?>,
    }, ]
  },
  options: {
    scales: {
        
        
      yAxes: [{
        id: 'A',
        type: 'linear',
        position: 'left',
        ticks: {
           
            min: 0
          }
      }, {
        id: 'B',
        type: 'linear',
        position: 'right',
        ticks: {
          max: 100,
          min: 0
        }
      }]
    }
  }
});


</script>-->
</body>
</html>

