//script agar jumlah penumpang lansia tidak melebihi total penumpang
const elX = document.getElementById("InputJumlahPenumpang");
const elY = document.getElementById("InputJumlahPenumpangLansnia");

function limit() {
    elY.value=Math.min(elX.value,elY.value);
}

elX.onchange=limit;
elY.onchange=limit;

//script agar tanggal yang diinputkan tidak lebih kecil dari tanggal hari ini
let today = new Date();
const dd = String(today.getDate()).padStart(2, '0');
const mm = String(today.getMonth() + 1).padStart(2, '0');
const yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd;
$('#InputJadwal').attr('min',today);