<?php
include('koneksi.php');

$covidData = mysqli_query($conn, "SELECT * FROM covid_cases");

$nama_negara = [];
$total_cases = [];

while ($row = mysqli_fetch_array($covidData)) {
    $nama_negara[] = $row['country'];

    $query = mysqli_query($conn, "SELECT SUM(total_cases) AS total FROM covid_cases WHERE country='" . $row['country'] . "'");
    $row = $query->fetch_array();
    $total_cases[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Pie Perbandingan Total Kasus</title>
    <script src="Chart.js"></script>
</head>
<body>
    <div id="canvas-holder" style="width: 50%">
        <canvas id="chart-area"></canvas>
    </div>

    <script>
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: <?php echo json_encode($total_cases); ?>,
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
                    label: 'Total Kasus'
                }],
                labels: <?php echo json_encode($nama_negara); ?>
            },
            options: {
                responsive: true
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(ctx, config);
        };
    </script>
</body>
</html>
