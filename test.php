<?php
//include ('index.html');
include ('database.php');
$sql= "SELECT * from readings ORDER BY id DESC  LIMIT 1 ";
$result = mysqli_query($conn, $sql);
$myArray = array();
while ($row = mysqli_fetch_array($result))
{
    array_push($myArray, $row);
}
?>
<!--head -->

<!--body
nav 
main container
-->
<style type="text/css">
    h2{
        color: white;
        font-size: 25px;
        font-family: sans-serif;
        text-align: center;

    }

    p{
        padding-left: 15px;

    }

    h4{
        padding-left: 15px;
    }

    h1{
        color: aliceblue;
        margin-top: 0;
        text-align: center;
    }
    .jumbotron{
        background:url("/images/165699_hero.jpg") top center fixed;
        background-size: cover;
        padding-top: 13em;
        padding-bottom: 13em;
    }

</style>


<div class="jumbotron">
    <div class="container">
        <h1>Endicott Live Buoy Data</h1>
        <br />
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            <?php
            echo "['Humidity', ".number_format($myArray[0]["humidity"],2)."],";
            ?>

        ]);

        var options = {
            width: 500, height: 175,
            redFrom: 90, redTo: 100,
            yellowFrom:75, yellowTo: 90,
            greenFrom:50, greenTo:75,
            minorTicks: 5
        };
        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);


    }
</script>

<head>
    <h2>Real Time Conditions</h2>
    <h4>Welcome to Endicott's Live Buoy</h4>
    <?php
    echo "<p><u>Date and Time Retrieved:</u><br>" .date('F dS Y , g : i A', strtotime($myArray[0]['date'])) ."</p>";
    ?>

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <img src="images/temperatureIcon.png">
            <?php
            echo "<p>Temperature: " . number_format($myArray[0]["temperature"],2)."</p>";
            mysqli_close($conn);
            ?>
        </div>
        <div class="col-sm-3" id="chart_div" style="width: 500px; height: 175px;"></div>
        <div class ='col-sm-3' <p>Water Temperature Place Holder: </p> </div>
    <div class ='col-sm-3' <p>Wind Place Holder: </p> </div>
</div>
</div>
</body>










