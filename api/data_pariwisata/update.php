<?php 

header("Content-Type: application/json; charset=UTF-8");
include_once "../handler.php";

// menggabungkan kode dari file kota.php
// yg mana model kota dibutuhkan
// untuk query
include("../../model/data_pariwisata.php");

// menggabungkan kode dari file db.php
// yg mana db digunakan untuk memanggil koneksi
// ke database
include("../../model/db.php");


// fungsi yg akan dipanggil untuk
// menghandle request yg dikirim client
$data = handle_request();

$usr = new data_pariwisata();
$usr->set($data);
$result = $usr->update(get_connection(include("../config.php")));

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>