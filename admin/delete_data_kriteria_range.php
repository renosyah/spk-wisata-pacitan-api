<?php

include("../model/kriteria_range.php");
include("../model/db.php");

$usr = new kriteria_range();
$usr->id = (int) $_GET['id'];
$result = $usr->delete(get_connection(include("../api/config.php")));

header("location: beranda.html");

?>