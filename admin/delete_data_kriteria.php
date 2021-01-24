<?php

include("../model/kriteria.php");
include("../model/db.php");

$usr = new kriteria();
$usr->id = (int) $_GET['id'];
$result = $usr->delete(get_connection(include("../api/config.php")));

header("location: beranda.html");

?>