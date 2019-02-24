<?php
include ('index.html');
$conn = mysqli_connect("ecbuoy.cl7cxw0gh9pq.us-east-2.rds.amazonaws.com", "nick" , "Scribbles1$" , "endicottbuoy");
$query = "SELECT * FROM readings ORDER BY id ";
$result = mysqli_query($conn, $query);
?>

<style>
    .table-wrapper-scroll-y {
        display: block;
        max-height: 350px;
        overflow-y: auto;
        overflow-x: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;

    }
</style>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

</head>
<body>



<div class="row" style="padding-left: 5%">
    <div class="one-third-column" style="margin-top: 5%; height: 300px">
        <strong>Showing All Records</strong>
        <h2>Temperatures</h2>
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
                if($result-> num_rows > 0){
                    while ($row = $result-> fetch_assoc()){
                        echo "<tr><td>" . number_format($row['temperature'],2)."</td><td>" . date('F dS Y , g : i : s A', strtotime($row['date']))."</td></tr>";
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
</div>