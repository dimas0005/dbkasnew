<?php
session_start();
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "dbkasnew";
$con = mysqli_connect($server, $user, $pass, $db);
if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
$display = "";
if (isset($_POST['display'])) {
    $display = $_POST['display'];
}
if (isset($_POST['btn'])) {
    $btn = $_POST['btn'];
    if ($btn == "AC") {
        $display = "";
    } elseif ($btn == "DEL") {
        $display = substr($display, 0, -1);
    } elseif ($btn == "=") {
        try {
            $result = eval("return $display;");
            $display = $result;
        } catch (Throwable $e) {
            $display = "Error";
        }
    } else {
        $display .= $btn;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>kalkulator</title>
    <style>
        button {
            width: 50px;
            height: 50px;
            font-size: 20px;
            border-radius: 10px;
            margin: 5px;
        }
    </style>
</head>
<body style="margin:0; background:white;">
<div style="
    width: 230px;
    height: 100vh;
    background: linear-gradient(to bottom, #2d7bf0, #5b65f5, #6245f2);
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 20px;
    font-family: Arial, sans-serif;
">
    <h2 style="text-align:center; margin-top:0; margin-bottom:20px;">Kas Gadget</h2>
    <a href="projek.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Dashboard</a>
    <a href="kalkulator.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Kalkulator</a>
    <a href="hutang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Hutang</a>
    <a href="pendapatan.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pendapatan</a>
    <a href="pengeluaran.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pengeluaran</a>
    <a href="rekap.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Rekap</a>
    <a href="barang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Stock</a>
    <a href="users.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Users</a>
    <a href="?logout=1" style="
        display:block;
        padding:12px 20px;
        color:white;
        text-decoration:none;
        position:absolute;
        bottom:20px;
        width:100%;
        box-sizing:border-box;
        background:rgba(0,0,0,0.25);
    ">Logout</a>
</div>
<div style="margin-left:260px; padding:20px;">
    <div style="display:flex; justify-content:center; align-items:center; height:90vh;">
        <div style="text-align:center; padding:20px; border:1px solid #ccc; border-radius:10px;">
            <form method="post">
                <input type="text" name="display" value="<?= $display ?>" readonly
                       style="width:350px;height:100px;font-size:90px;text-align:right;">
                <br><br>
                <button name="btn" value="7">7</button>
                <button name="btn" value="8">8</button>
                <button name="btn" value="9">9</button>
                <button name="btn" value="+">+</button><br><br>
                <button name="btn" value="4">4</button>
                <button name="btn" value="5">5</button>
                <button name="btn" value="6">6</button>
                <button name="btn" value="-">-</button><br><br>
                <button name="btn" value="1">1</button>
                <button name="btn" value="2">2</button>
                <button name="btn" value="3">3</button>
                <button name="btn" value="*">*</button><br><br>
                <button name="btn" value="0">0</button>
                <button name="btn" value=".">.</button>
                <button name="btn" value="/">/</button>
                <button name="btn" value="=">=</button><br><br>
                <button name="btn" value="AC">AC</button>
                <button name="btn" value="DEL">DEL</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>