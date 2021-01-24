<?php

include("../model/kategori.php");
include("../model/db.php");
 
$usr = new kategori();
$usr->id = (int) $_GET['id'];
$result = $usr->delete(get_connection(include("../api/config.php")));

header("location: beranda.html");

?>