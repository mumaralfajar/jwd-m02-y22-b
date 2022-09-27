<?php
//membaca berkas yang berupa JSON
$berkas = "data/data.json";
$dataJson = file_get_contents($berkas);
$dataPesananAll = json_decode($dataJson, true);

include("utils\utils.php");

//fungsi untuk menghitung total harga tiket
function hitungTotalBayar($harga, $JumlahPenumpang, $JumlahPenumpangLansia)
{
    if ($JumlahPenumpangLansia > 0) {
        $total = ($harga * $JumlahPenumpang) - ($harga * $JumlahPenumpangLansia * 0.1);
    } else {
        $total = $harga * $JumlahPenumpang;
    }
    return $total;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://www.freeiconspng.com/uploads/bus-icon-10.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<!-- Menampilkan Navigation Bar -->
<?php include "layout/navbar.php"; ?>
<br>
<br>
<div class="container">
    <form class="rounded shadow mt-4 mb-4 p-4" action="form.php" method="post" id="formPesanan">
        <h1 class="display-5 mb-4">Form Pemesanan</h1>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNamaLengkap" class="form-label">Nama Lengkap</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNamaLengkap" name="NamaLengkap"
                                       value="" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNomorID" class="form-label">Nomor Identitas</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNomorID" name="NomorIdentitas" value=""
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNomorHP" class="form-label">No. HP</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNomorHP" name="NomorHP" value=""
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputKelasPenumpang" class="form-label">Kelas Penumpang</label></div>
            <div class="col-10">
                <select class="form-select" id="InputKelasPenumpang" name="KelasPenumpang" required>
                    <option value="" disabled selected>Pilih kelas penumpang</option>
                    <?php
                    //menampilkan pilihan kelas penumpang
                    if (!empty($tipeKelas)) {
                        foreach ($tipeKelas as $kelas) {
                            echo "<option value='$kelas'>$kelas</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Kelas Kosong</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJadwal" class="form-label">Jadwal Keberangkatan</label></div>
            <div class="col-10"><input type="date" class="form-control" id="InputJadwal" name="JadwalBerangkat" value=""
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJumlahPenumpang" class="form-label">Jumlah Penumpang</label></div>
            <div class="col-10">
                <input type="number" class="form-control" id="InputJumlahPenumpang" name="JumlahPenumpang" min="0"
                       value="" required>
                <span class="form-text">Bukan lansia (usia < 60)</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2">
                <label for="InputJumlahPenumpangLansnia" class="form-label">
                    Jumlah Penumpang Lansia
                </label>
            </div>
            <div class="col-10">
                <input type="number" class="form-control" id="InputJumlahPenumpangLansnia" name="JumlahPenumpangLansia"
                       min="0" value="" required>
                <span class="form-text">Usia 60 tahun ke atas</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label class="form-label" for="HargaTiket">Harga Tiket</label></div>
            <div class="col-10"><input class="form-control" id="HargaTiket" value="" disabled></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label class="form-label" for="TotalBayar">Total Bayar</label></div>
            <div class="col-10"><input class="form-control" id="TotalBayar" value="" disabled></div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="formCheck"
                   onchange="document.getElementById('PesanTiket').disabled = !this.checked;">
            <label class="form-check-label" for="formCheck">
                Saya dan/atau rombongan telah membaca, memahami, dan
                setuju berdasarkan syarat dan ketentuan yang telah ditetapkan
            </label>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="col mx-2 btn btn-outline-primary" name="Total">
                Hitung Total Bayar
            </button>
            <button type="submit" class="col mx-2 btn btn-primary" id="PesanTiket" name="PesanTiket" disabled>
                Pesan Tiket
            </button>
            <button type="reset" class="col mx-2 btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>

<?php
//pendefinisian variabel-variabel ketika tombol Hitung Total atau Pesan Tiket diklik
$pesanTiket = isset($_POST['PesanTiket']);
$hitungTotal = isset($_POST['Total']);
if ($pesanTiket || $hitungTotal) {
    $namaLengkap = $_POST['NamaLengkap'];
    $nomorIdentitas = $_POST['NomorIdentitas'];
    $nomorHP = $_POST['NomorHP'];
    $kelasPenumpang = $_POST['KelasPenumpang'];
    $jadwalBerangkat = $_POST['JadwalBerangkat'];
    $jumlahPenumpang = $_POST['JumlahPenumpang'];
    $jumlahPenumpangLansia = $_POST['JumlahPenumpangLansia'];
    $hargaTiket = hitungHarga($_POST['KelasPenumpang']);
    $totalBayar = hitungTotalBayar(hitungHarga($_POST['KelasPenumpang']), $_POST['JumlahPenumpang'], $_POST['JumlahPenumpangLansia']);

    //pendefinisian array data pesanan yang berisi hasil inputan form
    if ($pesanTiket) {
        $dataPesanan = [$namaLengkap, $nomorIdentitas, $nomorHP, $kelasPenumpang, $jadwalBerangkat, $jumlahPenumpang, $jumlahPenumpangLansia, $hargaTiket, $totalBayar];
        $dataPesananAll[] = $dataPesanan;
        $dataJson = json_encode($dataPesananAll, JSON_PRETTY_PRINT);

        //menyimpan data pesanan ke file json
        if (file_put_contents($berkas, $dataJson)) {
            echo '
                <div class="m-5 fixed-top alert alert-success alert-dismissible fade show " role="alert">
                    Data Berhasil Disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        } else {
            echo '
                <div class="m-5 fixed-top alert alert-danger alert-dismissible fade show " role="alert">
                    Data Gagal Disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    } else {
        //menampilkan total bayar dengan mempertahankan data yang sudah diinputkan pada form
        echo "
        <script>
            window.scrollTo(0, document.body.scrollHeight);
            document.getElementById('InputNamaLengkap').value = '$namaLengkap';
            document.getElementById('InputNomorID').value = '$nomorIdentitas';
            document.getElementById('InputNomorHP').value = '$nomorHP';
            document.getElementById('InputKelasPenumpang').value = '$kelasPenumpang';
            document.getElementById('InputJadwal').value = '$jadwalBerangkat';
            document.getElementById('InputJumlahPenumpang').value = '$jumlahPenumpang';
            document.getElementById('InputJumlahPenumpangLansnia').value = '$jumlahPenumpangLansia';
            document.getElementById('HargaTiket').value = 'Rp. " . number_format($hargaTiket, 2, ',', '.') . "';
            document.getElementById('TotalBayar').value = 'Rp. " . number_format($totalBayar, 2, ',', '.') . "';
        </script>
    ";
    }
}
?>

<script src="js/script.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>