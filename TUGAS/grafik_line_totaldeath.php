<?php
include('koneksi.php');

$covidData = mysqli_query($conn, "SELECT * FROM covid_cases");

$nama_negara = [];
$total_deaths = [];

while ($row = mysqli_fetch_array($covidData)) {
    $nama_negara[] = $row['country'];

    $query = mysqli_query($conn, "SELECT SUM(total_deaths) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $row = $query->fetch_array();
    $total_deaths[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Line Perbandingan Total Deaths</title>
    <script src="Chart.js"></script>
</head>
<body>
    <div id="canvas-holder" style="width: 50%">
        <canvas id="chart-area"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('chart-area').getContext('2d');
        var chart = new Chart(ctx, {
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
                            stepSize: 100000 // Atur sesuai skala nilai total deaths
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
