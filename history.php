
<?php
include ('index.html');
$conn = mysqli_connect("ecbuoy.cl7cxw0gh9pq.us-east-2.rds.amazonaws.com", "nick" , "Scribbles1$" , "endicottbuoy");
$query = "SELECT * FROM readings ";
$result = mysqli_query($conn, $query);

$qry = "SELECT * FROM readings ORDER BY id ";
$end = mysqli_query($conn, $query);


$rows = array();
$table = array();
$table['cols'] = array(
    array('label' => 'Date','type' => 'datetime'),
    array('label' => 'Temperature ', 'type' => 'number'),
    array('label' => 'Humidity', 'type' => number)

);





foreach ($result as $r){
    $temp = array();

    $temp[] = array('v' => 'Date(' . date('Y,n,d,H,i,s', strtotime('-1 month' .$r['date'])).')');
    $temp[] = array('v' => number_format($r['temperature'], 0));
    $temp[] = array('v' => number_format($r['humidity'],0));
    $rows[] = array('c' => $temp);

    $table['rows'] = $rows;

    $jsonTable = json_encode($table);

}


?>

<style>
    .table-wrapper-scroll-y {
        display: block;
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;

    }
</style>

<head>
    <link rel="stylesheet" href="https://bootswatch.com/4/materia/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
            var options = {
                title: "Temperatures",
                chartArea: {width: '90%', height: '75%'},
                legend:{position: 'bottom',name: 'Temperature'}

            };


            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);

        }

    </script>


</head>
<body>
<div class="container">
    <br>
    <strong>Showing All Records</strong>
    <h2>Temperatures</h2>
    <div class="row" >
        <div class="col-md-4">
            <div class="table-wrapper-scroll-y">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th> Temperature</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($end-> num_rows > 0){
                        while ($row = $end-> fetch_assoc()){
                            echo "<tr><td>" . number_format($row['temperature'],2)."</td><td>" . date('F dS Y , g : i  A', strtotime($row['date']))."</td></tr>";
                        }
                        echo "</table>";
                    }
                    else{
                        echo "0 result";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8" id="curve_chart" style="width: 900px; height: 500px;"></div>
    </div>
</div>
</body>

