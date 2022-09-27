<?php
//decode data/data.json
$data = file_get_contents('../data/data.json');
$data = json_decode($data, true);
//mengurutkan array berdasarkan tanggal
array_multisort(array_column($data, 4), SORT_ASC, $data);
//usort($data, function ($a, $b) {
//    return strtotime($a[4]) - strtotime($b[4]);
//});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Data Pesanan</title>
</head>
<body>
<!-- Menampilkan Navigation Bar -->
<?php include "../layout/navbar.php"; ?>
<br>
<br>
<div class="container-fluid shadow mt-4 mb-4 p-4 rounded">
    <!-- Menampilkan Tabel Data Pesanan -->
    <table class="table table-responsive text-center">
        <caption class="caption-top display-5 mb-1 p-0 text-body">Data Pesanan</caption>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Identitas</th>
                <th>No. HP</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jumlah Penumpang</th>
                <th>Jumlah Penumpang Lansia</th>
                <th>Harga</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //menampilkan data pesanan
            $no = 1;
            foreach ($data as $d) {
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>$d[0]</td>";
                echo "<td>$d[1]</td>";
                echo "<td>$d[2]</td>";
                echo "<td>$d[3]</td>";
                echo "<td>" . date('d F Y', strtotime($d[4])) . "</td>";
                echo "<td>$d[5] Orang</td>";
                echo "<td>$d[6] Orang</td>";
                echo "<td>Rp. " . number_format($d[7], 2, ',', '.') . "</td>";
                echo "<td>Rp. " . number_format($d[8], 2, ',', '.') . "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>