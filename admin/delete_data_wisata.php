<?php

include("../model/data_pariwisata.php");
include("../model/db.php");
 
$usr = new data_pariwisata();
$usr->id = (int) $_GET['id'];
$result = $usr->delete(get_connection(include("../api/config.php")));

header("location: beranda.html");

?>