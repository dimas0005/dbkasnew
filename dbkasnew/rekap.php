<?php
session_start();
ini_set("display_errors","off");
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "dbkasnew";
$con = mysqli_connect($server, $user, $pass, $db);
if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
$data = mysqli_query($con,"
    SELECT 
        t.tanggal,
        IFNULL(p.total_pendapatan,0) AS pendapatan,
        IFNULL(pg.total_pengeluaran,0) AS pengeluaran,
        IFNULL(h.total_hutang,0) AS hutang_masuk,
        (
            IFNULL(p.total_pendapatan,0)
            + IFNULL(h.total_hutang,0)
            - IFNULL(pg.total_pengeluaran,0)
        ) AS total
    FROM (
        SELECT tanggal FROM pendapatan
        UNION
        SELECT tanggal FROM pengeluaran
        UNION
        SELECT tanggal_lunas AS tanggal FROM hutang WHERE status='Lunas'
    ) t
    LEFT JOIN (
        SELECT tanggal, SUM(ABS(total)) total_pendapatan
        FROM pendapatan
        GROUP BY tanggal
    ) p ON t.tanggal = p.tanggal
    LEFT JOIN (
        SELECT tanggal, SUM(ABS(total)) total_pengeluaran
        FROM pengeluaran
        GROUP BY tanggal
    ) pg ON t.tanggal = pg.tanggal
    LEFT JOIN (
        SELECT tanggal_lunas AS tanggal, SUM(ABS(total)) total_hutang
        FROM hutang
        WHERE status='Lunas'
        GROUP BY tanggal_lunas
    ) h ON t.tanggal = h.tanggal
    GROUP BY t.tanggal
    ORDER BY t.tanggal DESC
");
$grand = mysqli_query($con,"
    SELECT SUM(total) AS saldo FROM (
        SELECT 
            t.tanggal,
            (
                IFNULL(p.total_pendapatan,0)
                + IFNULL(h.total_hutang,0)
                - IFNULL(pg.total_pengeluaran,0)
            ) AS total
        FROM (
            SELECT tanggal FROM pendapatan
            UNION
            SELECT tanggal FROM pengeluaran
            UNION
            SELECT tanggal_lunas AS tanggal FROM hutang WHERE status='Lunas'
        ) t
        LEFT JOIN (
            SELECT tanggal, SUM(ABS(total)) total_pendapatan
            FROM pendapatan
            GROUP BY tanggal
        ) p ON t.tanggal = p.tanggal
        LEFT JOIN (
            SELECT tanggal, SUM(ABS(total)) total_pengeluaran
            FROM pengeluaran
            GROUP BY tanggal
        ) pg ON t.tanggal = pg.tanggal
        LEFT JOIN (
            SELECT tanggal_lunas AS tanggal, SUM(ABS(total)) total_hutang
            FROM hutang
            WHERE status='Lunas'
            GROUP BY tanggal_lunas
        ) h ON t.tanggal = h.tanggal
        GROUP BY t.tanggal
    ) rekap
");
$saldo = mysqli_fetch_assoc($grand)['saldo'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Rekap Kas</title>
</head>
<body style="margin:0;font-family:Arial;background:#f4f6f9;">
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
    <a href="kalkulator.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Kalkulator</a>
    <a href="hutang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Hutang</a>
    <a href="pendapatan.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pendapatan</a>
    <a href="pengeluaran.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pengeluaran</a>
    <a href="rekap.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Rekap</a>
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
    <h2>Rekap Kas</h2>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>Tanggal</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
            <th>Hutang Masuk</th>
            <th>Total</th>
        </tr>
        <?php while($r=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $r['tanggal'] ?></td>
            <td>Rp <?= number_format($r['pendapatan'],0,',','.') ?></td>
            <td>Rp <?= number_format($r['pengeluaran'],0,',','.') ?></td>
            <td>Rp <?= number_format($r['hutang_masuk'],0,',','.') ?></td>
            <td><b>Rp <?= number_format($r['total'],0,',','.') ?></b></td>
        </tr>
        <?php } ?>
    </table>
    <h3>Saldo Akhir :
        <b>Rp <?= number_format($saldo,0,',','.') ?></b>
    </h3>
</div>
</body>
</html>