<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

ini_set("display_errors","off");

$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "dbkasnew";

$con = mysqli_connect($server, $user, $pass, $db);

if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}


if (isset($_POST['tambah'])) {

    mysqli_query($con, "
        INSERT INTO pendapatan
        (tanggal, jumlah, keterangan, total)
        VALUES
        ('$_POST[tanggal]','$_POST[jumlah]','$_POST[keterangan]','$_POST[jumlah]')
    ");
}


if (isset($_GET['hapus'])) {

    mysqli_query($con,"
        DELETE FROM pendapatan
        WHERE id='$_GET[hapus]'
    ");

    header("Location: pendapatan.php");
}


if (isset($_POST['update'])) {

    mysqli_query($con,"
        UPDATE pendapatan SET
        tanggal='$_POST[tanggal]',
        jumlah='$_POST[jumlah]',
        keterangan='$_POST[keterangan]',
        total='$_POST[jumlah]'
        WHERE id='$_POST[id]'
    ");

    header("Location: pendapatan.php");
}


if (isset($_GET['edit'])) {

    $edit = mysqli_fetch_assoc(mysqli_query($con,"
        SELECT * FROM pendapatan
        WHERE id='$_GET[edit]'
    "));
}

$data = mysqli_query($con,"SELECT * FROM pendapatan ORDER BY tanggal DESC");

$totalQ = mysqli_query($con,"
    SELECT SUM(total) AS total FROM pendapatan
");

$total = mysqli_fetch_assoc($totalQ)['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Pendapatan</title>
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
<a href="pendapatan.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Pendapatan</a>
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

<h2>Kas Pendapatan</h2>

<div style="background:#fff; padding:20px; border-radius:10px; width:400px;">

<h3><?= isset($edit) ? "Edit Pendapatan" : "Tambah Pendapatan" ?></h3>

<form method="post">

<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

Tanggal:<br>
<input type="date" name="tanggal" required value="<?= $edit['tanggal'] ?? '' ?>"><br><br>

Jumlah:<br>
<input type="number" name="jumlah" required value="<?= $edit['jumlah'] ?? '' ?>"><br><br>

Keterangan:<br>
<input type="text" name="keterangan" required value="<?= $edit['keterangan'] ?? '' ?>"><br><br>

<?php if(isset($edit)){ ?>

<input type="submit" name="update" value="UPDATE">

<?php } else { ?>

<input type="submit" name="tambah" value="SIMPAN">

<?php } ?>

</form>

</div>

<hr>

<h3>Data Pendapatan</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">

<tr>
<th>Tanggal</th>
<th>Jumlah</th>
<th>Keterangan</th>
<th>Total</th>
<th>Aksi</th>
</tr>

<?php while($r=mysqli_fetch_assoc($data)) { ?>

<tr>

<td><?= $r['tanggal'] ?></td>

<td>
Rp <?= number_format($r['jumlah'],0,',','.') ?>
</td>

<td><?= $r['keterangan'] ?></td>

<td>
Rp <?= number_format($r['total'],0,',','.') ?>
</td>

<td>

<a href="?edit=<?= $r['id'] ?>" style="
background:#ffc107;
padding:4px 8px;
text-decoration:none;
color:black;
border-radius:4px;
">Edit</a>

<a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="
background:#dc3545;
padding:4px 8px;
text-decoration:none;
color:white;
border-radius:4px;
">Hapus</a>

</td>

</tr>

<?php } ?>

</table>

<h3>Total Pendapatan:
<b>Rp <?= number_format($total,0,',','.') ?></b>
</h3>

</div>

</body>
</html>