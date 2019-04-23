
<?php
include ('database.php');
$query = "SELECT * FROM readings ";
$result = mysqli_query($conn, $query);
$humidityRow = mysqli_query($conn, $query);

$qry = "SELECT * FROM readings ORDER BY id desc ";
$end = mysqli_query($conn, $query);
$data = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<!--head -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="images/buoy.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Endicott Live Buoy
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
</head>

<!--body-->
<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="images/165699_hero.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="http://18.224.7.205/" class="simple-text logo-normal">
                <img src="images/buoy.png" style="width: 50px; height: 50px"> Endicott Live Buoy
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item   ">
                    <a class="nav-link" href="index.php">
                        <i class="material-icons">home</i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="history.php">
                        <i class="material-icons">show_chart</i>
                        <p>History</p>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="test.php">
                        <i class="material-icons">person</i>
                        <p>About Us</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand">History</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Log out</a>
                    </div>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End of Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Date Picker</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    <input type="text" name= "from_date" id= "from_date" class="form-control" placeholder="From Date">

                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" >
                                </div>
                                <div class="col-md-5">
                                    <input type="button" name='filter' id="filter" value='Filter' class="btn btn-info">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>




                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card card-header-success">
                                <h4 class="card-title">Temperatures</h4>
                                <p class="card-category">Showing All Temperature Records</p>
                            </div>
                            <div class="card-body table-responsive table-wrapper-scroll-y" id="order_table">
                                <table class="table table-hover table table-fixed">
                                    <thead class="text-success">
                                    <tr>
                                        <th> Temperature</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                        while ($row = mysqli_fetch_array($end)){



                                            echo "<tr><td>" . number_format($row['temperature'],2)."</td><td>" . date('F dS Y , g : i  A', strtotime($row['date']))."</td></tr>";
                                        }
                                        //echo "</table>";


                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card card-header-warning">
                                <h4 class="card-title">Humidity</h4>
                                <p class="card-category">Showing All Humidity Records</p>
                            </div>
                            <div class="card-body table-responsive table-wrapper-scroll-y">
                                <table class="table table-hover ">
                                    <thead class="text-warning">
                                    <tr>
                                        <th> Humidity</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($humidityRow-> num_rows > 0){
                                        while ($getHumidityRow = $humidityRow-> fetch_assoc()){
                                            echo "<tr><td>" . number_format($getHumidityRow['humidity'],2)."</td><td>" . date('F dS Y , g : i  A', strtotime($getHumidityRow['date']))."</td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                    else{
                                        echo "0 result";
                                    }
                                    //$conn->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-success">
                                    <h4 class="card-title">Temperature Records</h4>
                                    <p class="card-category"> Showing Records of Temperature Over Time </p>
                                </div>
                                <div class="col-md-12" id="curve_chart" style="width: 900px; height: 500px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-warning">
                                    <h4 class="card-title">Humidity Records</h4>
                                    <p class="card-category"> Showing Records of Humidity Over Time </p>
                                </div>
                                <div class="col-md-12" id="humidity_chart" style="width: 900px; height: 500px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://github.com/scrivaniN">
                                Github
                            </a>
                        </li>
                        <li>
                            <a href="aboutUs.php">
                                About Us
                            </a>
                        </li>
                </nav>
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>, made by
                    <a href="https://www.linkedin.com/in/nicholas-scrivani-93bb9110a/" target="_blank">Nicholas Scrivani</a>
                </div>
                </nav>
            </div>
        </footer>
    </div>
</div>

<script src="../assets/js/core/jquery.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap-material-design.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="../assets/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="../assets/js/plugins/sweetalert2.js"></script>
<!-- Forms Validations Plugin -->
<script src="../assets/js/plugins/jquery.validate.min.js"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="../assets/js/plugins/fullcalendar.min.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="../assets/js/plugins/jquery-jvectormap.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="../assets/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="../assets/js/plugins/arrive.min.js"></script>
<!-- Chartist JS -->
<script src="../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $().ready(function() {
            $sidebar = $('.sidebar');

            $sidebar_img_container = $sidebar.find('.sidebar-background');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                    $('.fixed-plugin .dropdown').addClass('open');
                }

            }

            $('.fixed-plugin a').click(function(event) {
                // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                if ($(this).hasClass('switch-trigger')) {
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                }
            });

            $('.fixed-plugin .active-color span').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-color', new_color);
                }

                if ($full_page.length != 0) {
                    $full_page.attr('filter-color', new_color);
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.attr('data-color', new_color);
                }
            });

            $('.fixed-plugin .background-color .badge').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('background-color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-background-color', new_color);
                }
            });

            $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');


                var new_image = $(this).find("img").attr('src');

                if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    $sidebar_img_container.fadeOut('fast', function() {
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $sidebar_img_container.fadeIn('fast');
                    });
                }

                if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $full_page_background.fadeOut('fast', function() {
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                        $full_page_background.fadeIn('fast');
                    });
                }

                if ($('.switch-sidebar-image input:checked').length == 0) {
                    var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }
            });

            $('.switch-sidebar-image input').change(function() {
                $full_page_background = $('.full-page-background');

                $input = $(this);

                if ($input.is(':checked')) {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar_img_container.fadeIn('fast');
                        $sidebar.attr('data-image', '#');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page_background.fadeIn('fast');
                        $full_page.attr('data-image', '#');
                    }

                    background_image = true;
                } else {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar.removeAttr('data-image');
                        $sidebar_img_container.fadeOut('fast');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page.removeAttr('data-image', '#');
                        $full_page_background.fadeOut('fast');
                    }

                    background_image = false;
                }
            });

            $('.switch-sidebar-mini input').change(function() {
                $body = $('body');

                $input = $(this);

                if (md.misc.sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    md.misc.sidebar_mini_active = false;

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                } else {

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                    setTimeout(function() {
                        $('body').addClass('sidebar-mini');

                        md.misc.sidebar_mini_active = true;
                    }, 300);
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                    clearInterval(simulateWindowResize);
                }, 1000);

            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        md.initDashboardPageCharts();

    });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawHumidityChart);

    function drawChart() {
        var data = new google.visualization.arrayToDataTable([
            ['label', 'Temperature'],

            <?php
            while($row = mysqli_fetch_array($result))
                echo"['".date('M d, y ', strtotime($row["date"]))."', ".$row["temperature"]."],";
            ?>



        ]);



        var options = {
            title: "Records",
            chartArea: {width: '90%', height: '75%'},
            legend:{position: 'bottom',name: 'Temperature'},
            hAxis:{textStyle:{fontSize: 12}},

        };


        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);

    }function drawHumidityChart() {
        var data = new google.visualization.arrayToDataTable([
            ['label', 'Humidity'],

            <?php
            while($hRow = mysqli_fetch_array($data))
                echo"['".date('M d, y ', strtotime($hRow["date"]))."', ".$hRow["humidity"]."],";
            ?>



        ]);
        var options = {
            title: "Records",
            chartArea: {width: '90%', height: '75%'},
            legend:{position: 'bottom',name: 'Humidity'},
            hAxis:{textStyle:{fontSize: 12}},

        };

        var chart = new google.visualization.LineChart(document.getElementById('humidity_chart'));
        chart.draw(data, options);

    }


</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type='text/javascript'>
    $(document).ready(function(){
        $.datepicker.setDefaults({
            dateFormat: "yy-mm-dd"
        });
        $(function(){
            $("#from_date").datepicker();
            $("#to_date").datepicker();
        });
        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date =$('#to_date').val();
            if(from_date != '' && to_date != ''){
                $.ajax({
                    url: "filter.php",
                    method: "POST",
                    data: {from_date: from_date, to_date:to_date},
                    success: function (data) {
                        $('#order_table').html(data);
                    }
                });
            }else{
                alert("please select date");
            }
        });
    });
</script>



</body>

<style>
    .table-wrapper-scroll-y {
        display: block;
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;

    }


</style>

</html>


