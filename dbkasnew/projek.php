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
ini_set("display_errors","off");
$bulan = date('m');
$tahun = date('Y');
$q_hutang = mysqli_query($con,"SELECT SUM(jumlah) AS total_hutang FROM hutang WHERE status='Belum Lunas'");
$hutang = mysqli_fetch_assoc($q_hutang)['total_hutang'] ?? 0;
$q_hutang_lunas = mysqli_query($con,"SELECT SUM(jumlah) AS total_lunas FROM hutang WHERE status='Lunas'");
$hutang_lunas = mysqli_fetch_assoc($q_hutang_lunas)['total_lunas'] ?? 0;
$q_pendapatan = mysqli_query($con,"SELECT SUM(jumlah) AS total_pend FROM pendapatan");
$pendapatan = mysqli_fetch_assoc($q_pendapatan)['total_pend'] ?? 0;
$q_pengeluaran = mysqli_query($con,"SELECT SUM(jumlah) AS total_keluar FROM pengeluaran");
$pengeluaran = mysqli_fetch_assoc($q_pengeluaran)['total_keluar'] ?? 0;
$q_transaksi = mysqli_query($con,"
    SELECT SUM(jml) AS total_transaksi FROM (
        SELECT COUNT(*) AS jml FROM pendapatan 
        WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'
        UNION ALL
        SELECT COUNT(*) AS jml FROM hutang 
        WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'
    ) x
");
$total_transaksi = mysqli_fetch_assoc($q_transaksi)['total_transaksi'] ?? 0;
$saldo = $pendapatan + $hutang_lunas - $pengeluaran;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kas Gadget</title>
</head>
<body style="margin:0;font-family:Arial;background:#f4f6f9;">
<div style="
    width:230px;
    height:100vh;
    background:linear-gradient(to bottom,#2d7bf0,#5b65f5,#6245f2);
    color:white;
    position:fixed;
    left:0;
    top:0;
">
    <h2 style="text-align:center;padding:20px 0;margin:0;">Kas Gadget</h2>
    <a href="projek.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;background:rgba(0,0,0,.2);">Dashboard</a>
    <a href="kalkulator.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Kalkulator</a>
    <a href="hutang.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Hutang</a>
    <a href="pendapatan.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Pendapatan</a>
    <a href="pengeluaran.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Pengeluaran</a>
    <a href="rekap.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Rekap</a>
    <a href="barang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Stock</a>
    <a href="users.php" style="display:block;padding:12px 20px;color:white;text-decoration:none;">Users</a>
    <a href="?logout=1" style="
        display:block;
        padding:12px 20px;
        color:white;
        text-decoration:none;
        position:absolute;
        bottom:0px;
        width:100%;
        box-sizing:border-box;
        background:rgba(0,0,0,0.25);
    ">Logout</a>
</div>
<div style="margin-left:260px;padding:20px;">
    <h2>Dashboard Kas Gadget</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        <div style="background:#dc3545;color:white;padding:20px;border-radius:10px;">
            Total Hutang<br><br>
            <strong>Rp <?= number_format($hutang,0,',','.') ?></strong>
        </div>
        <div style="background:#3498db;color:white;padding:20px;border-radius:10px;">
            Hutang Lunas<br><br>
            <strong>Rp <?= number_format($hutang_lunas,0,',','.') ?></strong>
        </div>
        <div style="background:#f1a602;color:white;padding:20px;border-radius:10px;">
            Total Pendapatan<br><br>
            <strong>Rp <?= number_format($pendapatan,0,',','.') ?></strong>
        </div>
        <div style="background:#1abc9c;color:white;padding:20px;border-radius:10px;">
            Total Transaksi Bulan Ini<br><br>
            <strong><?= $total_transaksi ?> Transaksi</strong>
        </div>
        <div style="background:#9b59b6;color:white;padding:20px;border-radius:10px;">
            Total Pengeluaran<br><br>
            <strong>Rp <?= number_format($pengeluaran,0,',','.') ?></strong>
        </div>
        <div style="background:#27ae60;color:white;padding:20px;border-radius:10px;">
            Saldo Akhir<br><br>
            <strong>Rp <?= number_format($saldo,0,',','.') ?></strong>
        </div>
    </div>
</div>
</body>
</html>