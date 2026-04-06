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


if(isset($_GET['kurang'])){
    $id = $_GET['kurang'];

    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]--;

        if($_SESSION['keranjang'][$id] <= 0){
            unset($_SESSION['keranjang'][$id]);
        }
    }

    header("Location: payment.php");
    exit;
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    if(isset($_SESSION['keranjang'][$id])){
        unset($_SESSION['keranjang'][$id]);
    }

    header("Location: payment.php");
    exit;
}

if (empty($_SESSION['keranjang'])) {
    die("Keranjang kosong <a href='index.php'>Kembali</a>");
}

$total = 0;
$items = [];

foreach ($_SESSION['keranjang'] as $id => $qty) {

    $q = mysqli_query($con,"
        SELECT nama_paket, harga
        FROM menu
        WHERE id_paket='$id'
    ") or die(mysqli_error($con));

    $d = mysqli_fetch_assoc($q);

    $subtotal = $d['harga'] * $qty;
    $total += $subtotal;

    $items[] = [
        'id' => $id,
        'nama' => $d['nama_paket'],
        'qty' => $qty,
        'harga' => $d['harga'],
        'subtotal' => $subtotal
    ];
}

if (isset($_POST['pay'])) {

    if (!isset($_POST['metode'])) {
        die("Pilih metode pembayaran terlebih dahulu");
    }

    $metode = $_POST['metode'];
    $nama   = trim($_POST['nama_penghutang'] ?? '');
    $tgl    = date('Y-m-d');

    if ($metode == 'hutang' && $nama == '') {
        echo "<script>
        alert('Nama penghutang wajib diisi!');
        window.history.back();
        </script>";
        exit;
    }

    if ($metode != 'hutang') {

        mysqli_query($con,"
            INSERT INTO pendapatan (tanggal, jumlah, keterangan, total)
            VALUES ('$tgl','$total','Pembayaran $metode','$total')
        ") or die(mysqli_error($con));

    } else {

        mysqli_query($con,"
            INSERT INTO hutang
            (tanggal, nama_penghutang, jumlah, status, tanggal_lunas, total)
            VALUES ('$tgl','$nama','$total','Belum Lunas',NULL,'$total')
        ") or die(mysqli_error($con));

    }

    // SIMPAN DATA UNTUK INVOICE
    $_SESSION['invoice'] = [
        'tanggal' => $tgl,
        'metode' => $metode,
        'nama_penghutang' => $nama,
        'total' => $total,
        'items' => $items
    ];

    unset($_SESSION['keranjang']);

    header("Location: invoice.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>

<style>

body{
font-family:Arial;
background:#f4f7fb;
}

.box{
width:600px;
margin:40px auto;
background:#fff;
padding:25px;
border-radius:12px;
}

h2{
text-align:center;
color:#1565c0;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border-bottom:1px solid #ddd;
padding:8px;
text-align:center;
}

button{
width:100%;
padding:10px;
background:#1565c0;
color:#fff;
border:none;
border-radius:8px;
margin-top:15px;
cursor:pointer;
}

button:hover{
background:#0d47a1;
}

.metode{
margin-top:15px;
}

.qr-box{
display:none;
text-align:center;
margin-top:15px;
}

.transfer-box{
display:none;
background:#f4f7fb;
padding:10px;
border-radius:8px;
margin-top:10px;
}

.aksi a{
padding:4px 8px;
border-radius:4px;
text-decoration:none;
font-size:12px;
}

.kurang{
background:#ffc107;
color:#000;
}

.hapus{
background:#dc3545;
color:#fff;
}

</style>
</head>

<body>

<div class="box">

<h2>Payment</h2>

<table>
<tr>
<th>Menu</th>
<th>Qty</th>
<th>Subtotal</th>
<th></th>
</tr>

<?php foreach ($items as $i) { ?>

<tr>
<td><?= $i['nama']; ?></td>
<td><?= $i['qty']; ?></td>
<td>Rp <?= number_format($i['subtotal']); ?></td>
<td class="aksi">
<a class="kurang" href="?kurang=<?= $i['id']; ?>">-</a>
<a class="hapus" href="?hapus=<?= $i['id']; ?>">Hapus</a>
</td>
</tr>

<?php } ?>

</table>

<h3>Total: Rp <?= number_format($total); ?></h3>

<form method="post">

<div class="metode">

<label>
<input type="radio" name="metode" value="cash" required onclick="showPay()"> Cash (COD)
</label><br>

<label>
<input type="radio" name="metode" value="qr" onclick="showPay()"> QR Payment
</label><br>

<label>
<input type="radio" name="metode" value="transfer" onclick="showPay()"> Transfer Bank
</label><br>

<label>
<input type="radio" name="metode" value="hutang" onclick="showPay()"> Hutang (COD)
</label>

</div>

<br>

<input type="text" id="nama_penghutang" name="nama_penghutang" placeholder="Nama Penghutang (jika hutang)">

<div class="qr-box" id="qrbox">

<h4>Scan QR untuk pembayaran</h4>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=DummyPaymentKasir" width="200">

<p>QR Dummy Payment</p>

</div>

<div class="transfer-box" id="transferbox">

<h4>Transfer Bank</h4>

Bank BCA<br>
No Rekening : <b>1234567890</b><br>
Atas Nama : <b>D Gadget Store</b>

</div>

<button type="submit" name="pay">Payment Now</button>

</form>

</div>

<script>

function showPay(){

let metode=document.querySelector('input[name="metode"]:checked').value;

document.getElementById("qrbox").style.display="none";
document.getElementById("transferbox").style.display="none";

let namaField = document.getElementById("nama_penghutang");
namaField.required = false;

if(metode=="qr"){
document.getElementById("qrbox").style.display="block";
}

if(metode=="transfer"){
document.getElementById("transferbox").style.display="block";
}

if(metode=="hutang"){
namaField.required = true;
}

}

</script>

</body>
</html>