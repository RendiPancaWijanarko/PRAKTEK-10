<?php
include('koneksi.php');

$covidData = mysqli_query($conn, "SELECT * FROM covid_cases");

$nama_negara = [];
$total_deaths = [];
$total_recovered = [];
$active_cases = [];
$total_tests = [];

while ($row = mysqli_fetch_array($covidData)) {
    $nama_negara[] = $row['country'];

    $queryDeaths = mysqli_query($conn, "SELECT SUM(total_deaths) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $rowDeaths = $queryDeaths->fetch_array();
    $total_deaths[] = $rowDeaths['total'];

    $queryRecovered = mysqli_query($conn, "SELECT SUM(total_recovered) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $rowRecovered = $queryRecovered->fetch_array();
    $total_recovered[] = $rowRecovered['total'];

    $queryActive = mysqli_query($conn, "SELECT SUM(active_cases) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $rowActive = $queryActive->fetch_array();
    $active_cases[] = $rowActive['total'];

    $queryTests = mysqli_query($conn, "SELECT SUM(total_tests) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $rowTests = $queryTests->fetch_array();
    $total_tests[] = $rowTests['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Perbandingan COVID-19</title>
    <script src="Chart.js"></script>
</head>
<body>
    <div style="width: 50%; float: left;">
        <canvas id="chart-deaths"></canvas>
    </div>
    <div style="width: 50%; float: left;">
        <canvas id="chart-recovered"></canvas>
    </div>
    <div style="width: 50%; float: left;">
        <canvas id="chart-active"></canvas>
    </div>
    <div style="width: 50%; float: left;">
        <canvas id="chart-tests"></canvas>
    </div>

    <script>
        var ctxDeaths = document.getElementById('chart-deaths').getContext('2d');
        var chartDeaths = new Chart(ctxDeaths, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($nama_negara); ?>,
                datasets: [{
                    label: 'Total Deaths',
                    data: <?php echo json_encode($total_deaths); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 100000 // sesuai skala nilai total deaths
                        }
                    }
                }
            }
        });

        var ctxRecovered = document.getElementById('chart-recovered').getContext('2d');
        var chartRecovered = new Chart(ctxRecovered, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nama_negara); ?>,
                datasets: [{
                    label: 'Total Recovered',
                    data: <?php echo json_encode($total_recovered); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 100000 // sesuai skala nilai total recovered
                        }
                    }
                }
            }
        });

        var ctxActive = document.getElementById('chart-active').getContext('2d');
        var chartActive = new Chart(ctxActive, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($nama_negara); ?>,
                datasets: [{
                    label: 'Active Cases',
                    data: <?php echo json_encode($active_cases); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctxTests = document.getElementById('chart-tests').getContext('2d');
        var chartTests = new Chart(ctxTests, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($nama_negara); ?>,
                datasets: [{
                    label: 'Total Tests',
                    data: <?php echo json_encode($total_tests); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>