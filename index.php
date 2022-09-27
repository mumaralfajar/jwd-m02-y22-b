<?php
include("utils\utils.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus AKAP</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://www.freeiconspng.com/uploads/bus-icon-10.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php include "layout/navbar.php"; ?>
<br>
<br>
<div class="container shadow mt-4 mb-4 p-4 rounded">
    <div class="row">
        <div class="col">
            <h1 class="display-3 text-center"><b>Ekonomi</b></h1>
            <div class="image-container rounded" id="gEkonomi">
                <img src="img/bus-ekonomi.jpg" alt="logo" class="img-fluid rounded shadow mb-2 image-container">
            </div>
        </div>
        <div class="col">
            <h1 class="display-3 text-center"><b>Bisnis</b></h1>
            <div class="image-container rounded" id="gBisnis">
                <img src="img/bus-bisnis.jpg" alt="logo" class="img-fluid rounded shadow mb-2 image-container">
            </div>
        </div>
        <div class="col">
            <h1 class="display-3 text-center"><b>Eksekutif</b></h1>
            <div class="image-container rounded" id="gEksekutif">
                <img src="img/bus-eksekutif.jpg" alt="logo" class="img-fluid rounded shadow mb-2">
            </div>
        </div>
    </div>
    <div class="row">
        <hr class="mt-4">
        <table class="table table-responsive mx-4 col">
            <caption class="caption-top display-6 mb-1 p-0 text-body">Daftar Harga Tiket</caption>
            <thead>
            <tr>
                <th scope="col">Kelas</th>
                <th scope="col">Harga</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($tipeKelas)) {
                foreach ($tipeKelas as $kelas) {
                    echo "<tr>";
                    echo "<td>$kelas</td>";
                    echo "<td>Rp. " . number_format(hitungHarga($kelas), 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>
        <div class="col">
            <h1 class="display-6">Kelas Bus Paling Laris</h1>
            <canvas id="myChart"></canvas>
        </div>
        <script>
            //get the data from data/data.json
            <?php
            $data = file_get_contents("data/data.json");
            $data = json_decode($data, true);
            ?>
            const ctx = document.getElementById("myChart");
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Jumlah Penjualan"],
                    datasets: [
                        {
                            label: 'Ekonomi',
                            data: [
                                <?php
                                $filtered = filter_array($data,'Ekonomi');
                                echo count($filtered);
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 2
                        },
                        {
                            label: 'Bisnis',
                            data: [
                                <?php
                                $filtered = filter_array($data,'Bisnis');
                                echo count($filtered);
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 2
                        },
                        {
                            label: 'Eksekutif',
                            data: [
                                <?php
                                $filtered = filter_array($data,'Eksekutif');
                                echo count($filtered);
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                            ],
                            borderWidth: 2
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
    </div>
</div>
<script src="js/script.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
