<?php
//pendefinisian variable berkas dan kelas penumpang
$berkas = "data/data.json";
$kelasPenumpang = array("Ekonomi", "Bisnis", "Eksekutif");

//fungsi untuk menghitung harga berdasarkan kelas
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
    return $harga;
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
            <div class="col-10"><input type="text" class="form-control" id="InputNamaLengkap" name="NamaLengkap" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputNomorID" class="form-label">Nomor Identitas</label></div>
            <div class="col-10"><input type="text" class="form-control" id="InputNomorID" name="NomorIdentitas" required></div>
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
                    //menampilkan pilihan kelas penumpang
                    foreach ($kelasPenumpang as $kelas) {
                        echo "<option value='$kelas'>$kelas</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJadwal" class="form-label">Jadwal Keberangkatan</label></div>
            <div class="col-10"><input type="date" class="form-control" id="InputJadwal" name="JadwalBerangkat" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-2"><label for="InputJumlahPenumpang" class="form-label">Jumlah Penumpang</label></div>
            <div class="col-10">
                <input type="number" class="form-control" id="InputJumlahPenumpang" name="JumlahPenumpang" min="0" required>
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
                       min="0" required>
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

//pendefinisian varabel $dataPesanan saat tombol 'Total' ditekan
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
        'TotalBayar' => hitungTotalBayar(hitungHarga($_POST['KelasPenumpang']), $_POST['JumlahPenumpang'], $_POST['JumlahPenumpangLansia'])
    ];

    //mengubah array ke dala mbentuk JSON
    $dataJson = json_encode($dataPesanan, JSON_PRETTY_PRINT);

    //menyimpan data JSON ke dalam file
    if (file_put_contents($berkas, $dataJson)) {
        echo '
            <div class="m-5 fixed-top alert alert-success alert-dismissible fade show" role="alert">
                Data Berhasil Disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
    } else {
        echo '
            <div class="m-5 fixed-top alert alert-warning alert-dismissible fade show" role="alert">
                Data Gagal Disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
    }

    //mengambil data JSON dari file dan menyimpannya ke dalam variable $dataPesananF
    $dataJson = file_get_contents($berkas);
    $dataPesananF = json_decode($dataJson, true);

    //melakukan formatting untuk tangal, harga, dan total bayar
    $dataPesananF['JadwalBerangkat'] = date('d F Y', strtotime($dataPesananF['JadwalBerangkat']));
    $dataPesananF['HargaTiket'] = number_format($dataPesananF['HargaTiket'], 2, ',', '.');
    $dataPesananF['TotalBayar'] = number_format($dataPesananF['TotalBayar'], 2, ',', '.');

    //mempertahankan isian pada form
    echo "
        <script>
            document.getElementById('InputNamaLengkap').value = '$dataPesanan[NamaLengkap]';
            document.getElementById('InputNomorID').value = '$dataPesanan[NomorIdentitas]';
            document.getElementById('InputNomorHP').value = '$dataPesanan[NomorHP]';
            document.getElementById('InputKelasPenumpang').value = '$dataPesanan[KelasPenumpang]';
            document.getElementById('InputJadwal').value = '$dataPesanan[JadwalBerangkat]';
            document.getElementById('InputJumlahPenumpang').value = '$dataPesanan[JumlahPenumpang]';
            document.getElementById('InputJumlahPenumpangLansnia').value = '$dataPesanan[JumlahPenumpangLansia]';
            document.getElementById('HargaTiket').value = 'Rp. $dataPesananF[HargaTiket]';
            document.getElementById('TotalBayar').value = 'Rp. $dataPesananF[TotalBayar]';
        </script>
    ";
} else {
    //mengisi data kosong saat tombol 'Total' belum ditekan untuk mengatasi undefined variable
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

    $dataJson = file_get_contents($berkas);
    $dataPesananF = json_decode($dataJson, true);
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
                //melakukan pengecekan apakah data sudah terisi atau belum
                if ($dataPesanan['NamaLengkap'] == '') {
                    echo '<div class="modal-body text-center">Isi Form Terlebih Dahulu!</div>';
                } else {
                    echo '
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNamaLengkap">Nama Lengkap</label></div>
                            <div class="col-8">: ' . $dataPesananF['NamaLengkap'] . '</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNomorID">Nomor Identitas</label></div>
                            <div class="col-8">: ' . $dataPesananF['NomorIdentitas'] . '</div>
                        </div>   
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputNomorHP">Nomor HP</label></div>
                            <div class="col-8">: ' . $dataPesananF['NomorHP'] . '</div>
                        </div>     
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputKelasPenumpang">Kelas Penumpang</label></div>
                            <div class="col-8">: ' . $dataPesananF['KelasPenumpang'] . '</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJadwal">Jadwal Berangkat</label></div>
                            <div class="col-8">: ' . $dataPesananF['JadwalBerangkat'] . '</div>
                        </div>              
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJumlahPenumpang">Jumlah Penumpang</label></div>
                            <div class="col-8">: ' . $dataPesananF['JumlahPenumpang'] . ' Penumpang</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="InputJumlahPenumpangLansnia">Jumlah Penumpang Lansia</label></div>
                            <div class="col-8">: ' . $dataPesananF['JumlahPenumpangLansia'] . ' Penumpang Lansia</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="HargaTiket">Harga Tiket</label></div>
                            <div class="col-8">: Rp. ' . $dataPesananF['HargaTiket'] . '</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label class="form-label" for="TotalBayar">Total Bayar</label></div>
                            <div class="col-8">: Rp. ' . $dataPesananF['TotalBayar'] . '</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <img class="img-fluid rounded" src="img/' . $dataPesanan['KelasPenumpang'] . '.jpg" alt="Kelas Penumpang">
                            </div>  
                            <div class="col">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $dataPesananF['NomorIdentitas'] . '" alt="QR Code">
                            </div>
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
<!--script agar jumlah penumpang lansia tidak melebihi jumlah penumpang-->
<script>
    const elX = document.getElementById("InputJumlahPenumpang");
    const elY = document.getElementById("InputJumlahPenumpangLansnia");

    function limit() {
        elY.value=Math.min(Math.round(elX.value*.9),elY.value);
    }

    elX.onchange=limit;
    elY.onchange=limit;
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>