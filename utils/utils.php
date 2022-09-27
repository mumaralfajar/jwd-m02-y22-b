<?php
$tipeKelas = array("Ekonomi", "Bisnis", "Eksekutif");

//fungsi untuk menentukan harga kelas
function hitungHarga($kelas): int
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

function filter_array($array,$term){
    $matches = array();
    foreach($array as $a){
        if($a[3] == $term)
            $matches[]=$a;
    }
    return $matches;
}