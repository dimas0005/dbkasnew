<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "dbkasnew";
$con = mysqli_connect($server, $user, $pass, $db);
if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>