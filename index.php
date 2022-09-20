<?php
$kelasPenumpang = array("Ekonomi", "Bisnis", "Eksekutif");

function hitungHarga($kelas): string
{
    if ($kelas == "Ekonomi") {
        $harga = 100000;
    } else if ($kelas == "Bisnis") {
        $harga = 150000;
    } else if ($kelas == "Eksekutif") {
        $harga = 200000;
    } else {
        $harga = 0;
    }
    return number_format($harga, 2);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form class="rounded shadow mt-4 mb-4 p-4" action="index.php" method="post" id="formPesanan">
        <h1 class="display-5 mb-4">Form Pemesanan</h1>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNamaLengkap" class="form-label">Nama Lengkap</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNamaLengkap" name="NamaLengkap"
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNomorID" class="form-label">Nomor Identitas</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNomorID" name="NomorIdentitas"
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNomorHP" class="form-label">No. HP</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNomorHP" name="NomorHP" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputKelasPenumpang" class="form-label">Kelas Penumpang</label></div>
            <div class="col-10">
                <select class="form-select" id="InputKelasPenumpang" name="KelasPenumpang" required>
                    <option value="" disabled selected>Pilih kelas penumpang</option>
                    <?php
                    foreach ($kelasPenumpang as $kelas) {
                        echo "<option value='$kelas'>$kelas</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJadwal" class="form-label">Jadwal Keberangkatan</label></div>
            <div class="col-10"><input type="date" class="form-control" id="InputJadwal" name="JadwalBerangkat"
                                       required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJumlahPenumpang" class="form-label">Jumlah Penumpang</label></div>
            <div class="col-10">
                <input type="number" class="form-control" id="InputJumlahPenumpang" name="JumlahPenumpang" required>
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
                       required>
                <span class="form-text">Usia 60 tahun ke atas</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label class="form-label" for="HargaTiket">Harga Tiket</label></div>
            <div class="col-10"><input class="form-control" id="HargaTiket" value=0 disabled></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label class="form-label" for="TotalBayar">Total Bayar</label></div>
            <div class="col-10"><input class="form-control" id="TotalBayar" value=0 disabled></div>
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
            <button type="submit" class="col mx-2 btn btn-outline-primary" form="formPesanan" name="Total">Hitung Total
                Bayar
            </button>
            <button type="button" class="col mx-2 btn btn-primary" id="PesanTiket" name="PesanTiket"
                    data-bs-toggle="modal" data-bs-target="#detailModal" disabled>
                Pesan Tiket
            </button>
            <button type="reset" class="col mx-2 btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>

<?php
function hitungTotalBayar($KelasPenumpang, $JumlahPenumpang, $JumlahPenumpangLansia): string
{
    $harga = 0;
    if ($KelasPenumpang == "Ekonomi") {
        $harga = 100000;
    } else if ($KelasPenumpang == "Bisnis") {
        $harga = 200000;
    } else if ($KelasPenumpang == "Eksekutif") {
        $harga = 300000;
    }
    if ($JumlahPenumpangLansia > 0) {
        $total = ($harga * $JumlahPenumpang) - ($harga * $JumlahPenumpangLansia * 0.1);
    } else {
        $total = $harga * $JumlahPenumpang;
    }
    return number_format($total, 2);
}

if (isset($_POST['Total'])) {
    $dataPesanan = [
        'NamaLengkap' => $_POST['NamaLengkap'],
        'NomorIdentitas' => $_POST['NomorIdentitas'],
        'NomorHP' => $_POST['NomorHP'],
        'KelasPenumpang' => $_POST['KelasPenumpang'],
        'JadwalBerangkat' => $_POST['JadwalBerangkat'],
        'JumlahPenumpang' => $_POST['JumlahPenumpang'],
        'JumlahPenumpangLansia' => $_POST['JumlahPenumpangLansia'],
        'HargaTiket' => hitungHarga($_POST['KelasPenumpang']),
        'TotalBayar' => hitungTotalBayar($_POST['KelasPenumpang'], $_POST['JumlahPenumpang'], $_POST['JumlahPenumpangLansia'])
    ];

    echo "
        <script>
            document.getElementById('InputNamaLengkap').value = '$dataPesanan[NamaLengkap]';
            document.getElementById('InputNomorID').value = '$dataPesanan[NomorIdentitas]';
            document.getElementById('InputNomorHP').value = '$dataPesanan[NomorHP]';
            document.getElementById('InputKelasPenumpang').value = '$dataPesanan[KelasPenumpang]';
            document.getElementById('InputJadwal').value = '$dataPesanan[JadwalBerangkat]';
            document.getElementById('InputJumlahPenumpang').value = '$dataPesanan[JumlahPenumpang]';
            document.getElementById('InputJumlahPenumpangLansnia').value = '$dataPesanan[JumlahPenumpangLansia]';
            document.getElementById('HargaTiket').value = 'Rp. $dataPesanan[HargaTiket]';
            document.getElementById('TotalBayar').value = 'Rp. $dataPesanan[TotalBayar]';
        </script>
    ";
} else {
    $dataPesanan = [
        'NamaLengkap' => '',
        'NomorIdentitas' => '',
        'NomorHP' => '',
        'KelasPenumpang' => '',
        'JadwalBerangkat' => '',
        'JumlahPenumpang' => '',
        'JumlahPenumpangLansia' => '',
        'HargaTiket' => '',
        'TotalBayar' => ''
    ];
}
?>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if ($dataPesanan['NamaLengkap'] == '') {
                    echo '<div class="modal-body text-center">Isi Form Terlebih Dahulu!</div>';
                } else {
                    echo '
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNamaLengkap">Nama Lengkap</label></div>
                            <div class="col-8"><input class="form-control" id="InputNamaLengkap" value="' . $dataPesanan['NamaLengkap'] . '" disabled></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNomorID">Nomor Identitas</label></div>
                            <div class="col-8"><input class="form-control" id="InputNomorID" value="' . $dataPesanan['NomorIdentitas'] . '" disabled></div>
                        </div>   
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNomorHP">Nomor HP</label></div>
                            <div class="col-8"><input class="form-control" id="InputNomorHP" value="' . $dataPesanan['NomorHP'] . '" disabled></div>
                        </div>     
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputKelasPenumpang">Kelas Penumpang</label></div>
                            <div class="col-8"><input class="form-control" id="InputKelasPenumpang" value="' . $dataPesanan['KelasPenumpang'] . '" disabled></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJadwal">Jadwal Berangkat</label></div>
                            <div class="col-8"><input class="form-control" id="InputJadwal" value="' . $dataPesanan['JadwalBerangkat'] . '" disabled></div>
                        </div>              
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJumlahPenumpang">Jumlah Penumpang</label></div>
                            <div class="col-8"><input class="form-control" id="InputJumlahPenumpang" value="' . $dataPesanan['JumlahPenumpang'] . '" disabled></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJumlahPenumpangLansnia">Jumlah Penumpang Lansia</label></div>
                            <div class="col-8"><input class="form-control" id="InputJumlahPenumpangLansnia" value="' . $dataPesanan['JumlahPenumpangLansia'] . '" disabled></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="HargaTiket">Harga Tiket</label></div>
                            <div class="col-8"><input class="form-control" id="HargaTiket" value="' . $dataPesanan['HargaTiket'] . '" disabled></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="TotalBayar">Total Bayar</label></div>
                            <div class="col-8"><input class="form-control" id="TotalBayar" value="' . $dataPesanan['TotalBayar'] . '" disabled></div>
                        </div>                                 
                    ';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>