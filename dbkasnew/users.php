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


if (isset($_POST['tambah'])) {

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    mysqli_query($con,"
        INSERT INTO users (nama, username, password, role)
        VALUES ('$nama','$username','$password','$role')
    ");
}


if (isset($_POST['ubah_role'])) {

    mysqli_query($con,"
        UPDATE users SET role='$_POST[role_baru]'
        WHERE id='$_POST[id_user]'
    ");
}


if (isset($_GET['hapus'])) {

    mysqli_query($con,"
        DELETE FROM users
        WHERE id='$_GET[hapus]'
    ");

    header("Location: users.php");
}


if (isset($_POST['update'])) {

    mysqli_query($con,"
        UPDATE users SET
        nama='$_POST[nama]',
        username='$_POST[username]',
        role='$_POST[role]'
        WHERE id='$_POST[id]'
    ");

    header("Location: users.php");
}


if (isset($_GET['edit'])) {

    $edit = mysqli_fetch_assoc(mysqli_query($con,"
        SELECT * FROM users
        WHERE id='$_GET[edit]'
    "));
}

$dataUsers = mysqli_query($con,"SELECT * FROM users ORDER BY nama ASC");

?>

<!DOCTYPE html>
<html>
<head>
<title>Users - Kas Gadget</title>
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
<a href="rekap.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Rekap</a>
<a href="barang.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Stock</a>
<a href="users.php" style="display:block; padding:12px 20px; color:white; text-decoration:none; background:rgba(0,0,0,0.2);">Users</a>

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

<h2>Manajemen Users</h2>

<div style="display:flex; gap:40px; align-items:flex-start;">

<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3><?= isset($edit) ? "Edit User" : "Tambah User" ?></h3>

<form method="post">

<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

Nama:<br>
<input type="text" name="nama" required value="<?= $edit['nama'] ?? '' ?>"><br><br>

Username:<br>
<input type="text" name="username" required value="<?= $edit['username'] ?? '' ?>"><br><br>

<?php if(!isset($edit)){ ?>

Password:<br>
<input type="password" name="password" required><br><br>

<?php } ?>

Role:<br>
<select name="role" required>

<option value="pemilik" <?= (isset($edit) && $edit['role']=="pemilik")?"selected":"" ?>>Pemilik</option>
<option value="karyawan" <?= (isset($edit) && $edit['role']=="karyawan")?"selected":"" ?>>Karyawan</option>

</select><br><br>

<?php if(isset($edit)){ ?>

<input type="submit" name="update" value="UPDATE">

<?php } else { ?>

<input type="submit" name="tambah" value="SIMPAN">

<?php } ?>

</form>

</div>

<div style="flex:1; background:#fff; padding:20px; border-radius:10px;">

<h3>Ubah Role User</h3>

<form method="post">

Pilih User:<br>

<select name="id_user" required style="width:100%;">

<option value="">-- Pilih --</option>

<?php
$q = mysqli_query($con,"SELECT * FROM users");
while($u=mysqli_fetch_assoc($q)){
    echo "<option value='$u[id]'>$u[nama] ($u[role])</option>";
}
?>

</select><br><br>

Role Baru:<br>

<select name="role_baru" required>

<option value="pemilik">Pemilik</option>
<option value="karyawan">Karyawan</option>

</select><br><br>

<input type="submit" name="ubah_role" value="UBAH ROLE">

</form>

</div>

</div>

<hr>

<h3>Data Users</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">

<tr>
<th>ID</th>
<th>Nama</th>
<th>Username</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php while($r=mysqli_fetch_assoc($dataUsers)) { ?>

<tr>

<td><?= $r['id'] ?></td>
<td><?= $r['nama'] ?></td>
<td><?= $r['username'] ?></td>
<td><?= $r['role'] ?></td>

<td>

<a href="?edit=<?= $r['id'] ?>" style="
background:#ffc107;
padding:4px 8px;
text-decoration:none;
color:black;
border-radius:4px;
">Edit</a>

<a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Yakin ingin menghapus user?')" style="
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

</div>

</body>
</html>