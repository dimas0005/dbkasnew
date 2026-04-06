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

if (isset($_POST['tambah'])) {

    mysqli_query($con, "
        INSERT INTO hutang
        (tanggal, nama_penghutang, jumlah, status, tanggal_lunas, total)
        VALUES
        ('$_POST[tanggal]','$_POST[nama_penghutang]','$_POST[jumlah]',
         'Belum Lunas',NULL,'$_POST[jumlah]')
    ");
}


if (isset($_POST['lunas'])) {

    mysqli_query($con, "
        UPDATE hutang SET
        status='Lunas',
        tanggal_lunas='$_POST[tanggal_lunas]'
        WHERE id='$_POST[id_hutang]'
    ");
}


if (isset($_GET['hapus'])) {

    mysqli_query($con,"
        DELETE FROM hutang
        WHERE id='$_GET[hapus]'
    ");

    header("Location: hutang.php");
}


if (isset($_POST['update'])) {

    mysqli_query($con,"
        UPDATE hutang SET
        tanggal='$_POST[tanggal]',
        nama_penghutang='$_POST[nama_penghutang]',
        jumlah='$_POST[jumlah]',
        total='$_POST[jumlah]'
        WHERE id='$_POST[id]'
    ");

    header("Location: hutang.php");
}


if (isset($_GET['edit'])) {

    $edit = mysqli_fetch_assoc(mysqli_query($con,"
        SELECT * FROM hutang
        WHERE id='$_GET[edit]'
    "));
}

$data = mysqli_query($con,"SELECT * FROM hutang ORDER BY tanggal DESC");

$hutangBelum = mysqli_query($con,"
    SELECT * FROM hutang
    WHERE status='Belum Lunas'
");

$totalQ = mysqli_query($con,"
    SELECT SUM(total) AS total
    FROM hutang WHERE status='Belum Lunas'
");

$total = mysqli_fetch_assoc($totalQ)['total'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Hutang</title>
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
<a href="hutang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Hutang</a>
<a href="pendapatan.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pendapatan</a>
<a href="pengeluaran.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pengeluaran</a>
<a href="rekap.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Rekap</a>
<a href="barang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Stock</a>
<a href="users.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;"> Users</a>

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
">
Logout
</a>

</div>

<div style="margin-left:260px; padding:20px;">

<h2>Kas Hutang</h2>

<div style="display:flex; gap:40px; align-items:flex-start;">

<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3><?= isset($edit) ? "Edit Hutang" : "Hutang" ?></h3>

<form method="post">

<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

Tanggal Hutang:<br>
<input type="date" name="tanggal" required value="<?= $edit['tanggal'] ?? '' ?>"><br><br>

Nama Penghutang:<br>
<input type="text" name="nama_penghutang" required value="<?= $edit['nama_penghutang'] ?? '' ?>"><br><br>

Jumlah:<br>
<input type="number" name="jumlah" required value="<?= $edit['jumlah'] ?? '' ?>"><br><br>

<?php if(isset($edit)){ ?>

<input type="submit" name="update" value="UPDATE">

<?php } else { ?>

<input type="submit" name="tambah" value="SIMPAN">

<?php } ?>

</form>

</div>

<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3>Lunas</h3>

<form method="post">

Pilih Hutang:<br>

<select name="id_hutang" required style="width:100%;">

<option value="">-- Pilih --</option>

<?php while($h=mysqli_fetch_assoc($hutangBelum)) { ?>

<option value="<?= $h['id'] ?>">
<?= $h['nama_penghutang'] ?> - Rp <?= number_format($h['jumlah'],0,',','.') ?>
</option>

<?php } ?>

</select><br><br>

Tanggal Lunas:<br>
<input type="date" name="tanggal_lunas" required><br><br>

<input type="submit" name="lunas" value="LUNAS">

</form>

</div>

</div>

<hr>

<h3>Data Hutang</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">

<tr>
<th>Tanggal</th>
<th>Nama</th>
<th>Jumlah</th>
<th>Status</th>
<th>Tanggal Lunas</th>
<th>Aksi</th>
</tr>

<?php while($r=mysqli_fetch_assoc($data)) { ?>

<tr>

<td><?= $r['tanggal'] ?></td>

<td><?= $r['nama_penghutang'] ?></td>

<td>Rp <?= number_format($r['jumlah'],0,',','.') ?></td>

<td><?= $r['status'] ?></td>

<td><?= $r['tanggal_lunas'] ?></td>

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

<br>

<h3>Total Hutang Belum Lunas:
<b>Rp <?= number_format($total,0,',','.') ?></b>
</h3>

</div>

</body>
</html>