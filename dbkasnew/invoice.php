<?php
session_start();

if(!isset($_SESSION['invoice'])){
    die("Tidak ada data invoice <a href='index.php'>Kembali</a>");
}

$data = $_SESSION['invoice'];

$tanggal = $data['tanggal'];
$metode  = $data['metode'];
$nama    = $data['nama_penghutang'];
$total   = $data['total'];
$items   = $data['items'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

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
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
text-align:center;
color:#1565c0;
letter-spacing:2px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:#1565c0;
color:white;
padding:10px;
}

td{
border-bottom:1px solid #ddd;
padding:10px;
text-align:center;
}

.total{
text-align:right;
font-size:18px;
margin-top:20px;
background:#f1f5ff;
padding:10px;
border-radius:6px;
}

.info{
margin-top:10px;
line-height:1.6;
}

.btn{
margin-top:20px;
text-align:center;
}

button{
padding:10px 20px;
border:none;
background:#1565c0;
color:#fff;
border-radius:8px;
cursor:pointer;
margin:5px;
}

button:hover{
background:#0d47a1;
}

</style>

</head>

<body>

<div class="box" id="invoiceArea">

<h2>INVOICE</h2>

<div class="info">
Tanggal : <?= $tanggal ?><br>
Metode Pembayaran : <?= strtoupper($metode) ?><br>

<?php if($metode == "hutang"){ ?>
Nama Penghutang : <?= $nama ?><br>
<?php } ?>

</div>

<table>

<tr>
<th>Menu</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>
</tr>

<?php foreach($items as $i){ ?>

<tr>
<td><?= $i['nama'] ?></td>
<td><?= $i['qty'] ?></td>
<td>Rp <?= number_format($i['harga']) ?></td>
<td>Rp <?= number_format($i['subtotal']) ?></td>
</tr>

<?php } ?>

</table>

<div class="total">
<b>Total : Rp <?= number_format($total) ?></b>
</div>

<div class="btn">

<button onclick="window.print()">Print Invoice</button>

<button onclick="downloadInvoice()">Download Invoice</button>

<button onclick="window.location='index.php'">Kembali</button>

</div>

</div>

<script>

function downloadInvoice(){

let html = `
<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

<style>

body{
font-family:Arial;
background:#ffffff;
padding:40px;
}

.container{
max-width:700px;
margin:auto;
border:1px solid #ddd;
padding:30px;
border-radius:10px;
}

h1{
text-align:center;
color:#1565c0;
letter-spacing:3px;
}

.info{
margin-top:20px;
line-height:1.7;
}

table{
width:100%;
border-collapse:collapse;
margin-top:25px;
}

th{
background:#1565c0;
color:white;
padding:12px;
}

td{
border-bottom:1px solid #ddd;
padding:12px;
text-align:center;
}

.total{
text-align:right;
font-size:20px;
margin-top:20px;
padding-top:10px;
border-top:2px solid #1565c0;
}

.footer{
margin-top:40px;
text-align:center;
color:#777;
font-size:13px;
}

</style>

</head>

<body>

<div class="container">

<h1>INVOICE</h1>

<div class="info">
Tanggal : <?= $tanggal ?><br>
Metode Pembayaran : <?= strtoupper($metode) ?><br>
<?php if($metode == "hutang"){ ?>
Nama Penghutang : <?= $nama ?><br>
<?php } ?>
</div>

<table>

<tr>
<th>Menu</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>
</tr>

<?php foreach($items as $i){ ?>

<tr>
<td><?= $i['nama'] ?></td>
<td><?= $i['qty'] ?></td>
<td>Rp <?= number_format($i['harga']) ?></td>
<td>Rp <?= number_format($i['subtotal']) ?></td>
</tr>

<?php } ?>

</table>

<div class="total">
<b>Total : Rp <?= number_format($total) ?></b>
</div>

<div class="footer">
Terima kasih atas transaksi Anda
</div>

</div>

</body>
</html>
`;

let blob = new Blob([html], {type:"text/html"});
let url = URL.createObjectURL(blob);

let a = document.createElement("a");
a.href = url;
a.download = "invoice_<?php echo date('YmdHis'); ?>.html";

document.body.appendChild(a);
a.click();
document.body.removeChild(a);

}

</script>

</body>
</html>