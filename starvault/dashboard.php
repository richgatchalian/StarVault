<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
        header('Location: login.php');
        exit;
    }
    
    $username = $_SESSION['user']['username'];
    include('bar-chart.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Starvault</title>
    <?php include('partials/app-header-scripts.php')?>
</head>
<body>
    <div id = "dashboardMainContainer">
        <?php include('partials/app-sidebar.php')?>
        <div class = "dashboard_content_container" id = "dashboard_content_container">
        <?php include('partials/app-topNav.php')?>
            <div class = "dashboard_content"> 
                <div class = "dashboard_content_main"> 
                <figure class="highcharts-figure">
                    <div id="containerBarChart"></div>
                    <p class="highcharts-description">
                        <!--text description if need-->
                    </p>
                </figure>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php')?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var barGraphData = <?= json_encode($bar_chart_data) ?>;
    var barGraphCategories = <?= json_encode($categories) ?>;

    console.log(barGraphCategories, barGraphData);

    Highcharts.chart('containerBarChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Product Count per Supplier',
        align: 'left'
    },
    xAxis: {
        categories: barGraphCategories,
        crosshair: true,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Product Count'
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Suppliers',
            data: barGraphData,
            color: '#808080'
        }
    ]
});
</script>
</body>
</html>
