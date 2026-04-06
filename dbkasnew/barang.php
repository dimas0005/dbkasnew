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

// UPDATE STOCK
if (isset($_POST['update'])) {

    mysqli_query($con,"
        UPDATE menu SET
        stock='$_POST[stock]'
        WHERE id_paket='$_POST[id_paket]'
    ");

    header("Location: barang.php");
}

// AMBIL DATA
$data = mysqli_query($con,"SELECT * FROM menu ORDER BY nama_paket ASC");

if(!$data){
    die("Query Error: " . mysqli_error($con));
}

// LIST DROPDOWN
$list = mysqli_query($con,"SELECT * FROM menu");

// PILIH BARANG
if (isset($_POST['pilih'])) {

    $edit = mysqli_fetch_assoc(mysqli_query($con,"
        SELECT * FROM menu
        WHERE id_paket='$_POST[id_paket]'
    "));
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Stock Barang</title>
</head>

<body style="margin:0;font-family:Arial;background:#f4f6f9;">

<!-- SIDEBAR -->
<div style="
    width: 230px;
    height: 100vh;
    background: linear-gradient(to bottom, #2d7bf0, #5b65f5, #6245f2);
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 20px;
">

<h2 style="text-align:center; margin-top:0; margin-bottom:20px;">Kas Gadget</h2>

<a href="projek.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Dashboard</a>
<a href="kalkulator.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Kalkulator</a>
<a href="hutang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Hutang</a>
<a href="pendapatan.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pendapatan</a>
<a href="pengeluaran.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Pengeluaran</a>
<a href="rekap.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Rekap</a>
<a href="barang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Stock</a>
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
">
Logout
</a>

</div>

<!-- CONTENT -->
<div style="margin-left:260px; padding:20px;">

<h2>Update Stock Barang</h2>

<div style="display:flex; gap:40px; align-items:flex-start;">

<!-- KIRI -->
<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3>Pilih Barang</h3>

<form method="post">

<select name="id_paket" required style="width:100%;">
<option value="">-- Pilih Barang --</option>

<?php while($l=mysqli_fetch_assoc($list)) { ?>
<option value="<?= $l['id_paket'] ?>">
<?= $l['nama_paket'] ?>
</option>
<?php } ?>

</select><br><br>

<input type="submit" name="pilih" value="PILIH">

</form>

</div>

<!-- KANAN -->
<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3>Update Stock</h3>

<form method="post">

<input type="hidden" name="id_paket" value="<?= $edit['id_paket'] ?? '' ?>">

Stock:<br>
<input type="number" name="stock" required value="<?= $edit['stock'] ?? '' ?>" style="width:100%;"><br><br>

<input type="submit" name="update" value="UPDATE">

</form>

</div>

</div>

<hr>

<h3>Data Stock</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">

<tr>
<th>Nama Paket</th>
<th>Stock</th>
</tr>

<?php while($r=mysqli_fetch_assoc($data)) { ?>

<tr>
<td><?= $r['nama_paket'] ?></td>
<td><?= $r['stock'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>