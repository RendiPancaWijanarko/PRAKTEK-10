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
    <title>Grafik Bar Perbandingan Total Kasus</title>
    <script src="Chart.js"></script>
</head>
<body>
    <div style="width: 800px; height: 800px;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nama_negara); ?>,
                datasets: [{
                    label: 'Total Kasus',
                    data: <?php echo json_encode($total_cases); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return value / 1000000 + "M";
                                } else if (value >= 1000) {
                                    return value / 1000 + "K";
                                } else {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
