<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_POST['tambah'])) {
    $id = $_POST['id_paket'];
    $_SESSION['keranjang'][$id] = ($_SESSION['keranjang'][$id] ?? 0) + 1;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>D Gadget</title>

<style>

body{
font-family:Arial,sans-serif;
background:#f4f7fb;
margin:0;
}

/* HEADER */

.header{
background:linear-gradient(135deg,#1565c0,#42a5f5);
color:white;
text-align:center;
padding:30px 20px;
position:relative;
}

.header h1{
margin:0;
}

/* LOGIN */

.login{
position:absolute;
top:13%;
right:20px;
transform:translateY(-40%);
z-index:999;
}

/* SEARCH */

#search{
margin-top:15px;
padding:10px;
width:260px;
border:none;
border-radius:20px;
outline:none;
font-size:14px;
}

/* BUTTON */

button{
background:#1565c0;
color:white;
border:none;
padding:8px 14px;
border-radius:8px;
cursor:pointer;
font-weight:bold;
transition:0.2s;
}

button:hover{
background:#0d47a1;
transform:scale(1.05);
}

/* GRID */

.menu-container{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:20px;
padding:30px;
}

/* CARD */

.card{
background:#fff;
border-radius:12px;
padding:16px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,0.15);
transition:transform 0.2s,box-shadow 0.2s;
position:relative;
}

.card:hover{
transform:translateY(-5px);
box-shadow:0 8px 18px rgba(0,0,0,0.25);
}

/* BADGE */

.badge{
position:absolute;
top:10px;
left:10px;
background:#ff3d00;
color:white;
font-size:12px;
padding:3px 8px;
border-radius:5px;
font-weight:bold;
z-index:3;
}

/* RATING */

.rating{
color:#ffc107;
font-size:14px;
margin-bottom:5px;
}

.card h4{
margin:10px 0 5px;
}

.harga{
font-weight:bold;
margin:10px 0;
color:#1565c0;
}

/* SLIDER */

.slider{
position:relative;
width:100%;
height:170px;
overflow:hidden;
border-radius:10px;
margin-bottom:10px;
}

/* tombol info */

.info-btn{
position:absolute;
top:8px;
right:8px;
background:#1565c0;
color:white;
border-radius:50%;
width:22px;
height:22px;
font-size:14px;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
z-index:5;
}

/* SLIDE */

.slide-container{
display:flex;
transition:transform 0.4s ease;
}

.slide-container img{
width:100%;
height:170px;
object-fit:contain;
background:#fff;
flex-shrink:0;
}

/* tombol slider */

.prev, .next{
position:absolute;
top:50%;
transform:translateY(-50%);
background:rgba(0,0,0,0.5);
color:white;
border:none;
padding:5px 10px;
cursor:pointer;
border-radius:5px;
font-size:12px;
z-index:4;
}

.prev{left:5px;}
.next{right:5px;}

/* MODAL */

.modal{
display:none;
position:fixed;
z-index:1000;
left:0;
top:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
}

.modal-content{
background:white;
margin:10% auto;
padding:20px;
width:350px;
border-radius:10px;
text-align:center;
}

.close{
float:right;
font-size:20px;
cursor:pointer;
}

/* FOOTER */

.footer{
background:#e3f2fd;
border-top:3px solid #1565c0;
padding:20px 30px;
display:flex;
justify-content:space-between;
align-items:center;
font-size:16px;
}

</style>

</head>

<body>

<div class="login">
<a href="login.php"><button>Login</button></a>
</div>

<div class="header">
<h1>D Gadget</h1>
<p>Pilih Gadget yang kamu pengen</p>

<input type="text" id="search" placeholder="Cari gadget..." onkeyup="cariProduk()">

</div>

<div class="menu-container">

<?php
$sql="SELECT id_paket,nama_paket,isi_paket,harga FROM menu";
$query=mysqli_query($con,$sql);

if(!$query){
die("Query error: ".mysqli_error($con));
}

while($row=mysqli_fetch_assoc($query)){
$id=$row['id_paket'];
?>

<div class="card">

<div class="badge">HOT</div>

<div class="rating">⭐⭐⭐⭐☆</div>

<div class="slider">

<div class="info-btn" onclick="lihatInfo(`<?= htmlspecialchars($row['isi_paket']); ?>`)">
i
</div>

<div class="slide-container" id="slide<?= $id ?>">

<?php
$huruf = ['a','b','c','d','e'];

foreach($huruf as $h){

$namaFile = $id.$h.".jpeg";

if(file_exists($namaFile)){
echo '<img src="'.$namaFile.'" alt="gambar">';
}

}
?>

</div>

<button class="prev" onclick="geser('<?= $id ?>',-1)">❮</button>
<button class="next" onclick="geser('<?= $id ?>',1)">❯</button>

</div>

<h4><?= htmlspecialchars($row['nama_paket']); ?></h4>

<div class="harga">Rp <?= number_format($row['harga']); ?></div>

<form method="post">
<input type="hidden" name="id_paket" value="<?= $row['id_paket']; ?>">
<button type="submit" name="tambah">Masukan Keranjang</button>
</form>

</div>

<?php } ?>

</div>

<div class="footer">

<a href="payment.php">
<button>Payment here</button>
</a>

<strong>

<?php
$total=0;

foreach($_SESSION['keranjang'] as $id=>$qty){

$q=mysqli_query($con,"SELECT harga FROM menu WHERE id_paket='$id'");

if($q){
$d=mysqli_fetch_assoc($q);
$total+=$d['harga']*$qty;
}

}

echo "Total Harga: Rp ".number_format($total);
?>

</strong>

</div>

<div id="modalInfo" class="modal">

<div class="modal-content">

<span class="close" onclick="tutupInfo()">&times;</span>

<h3>Informasi Gadget</h3>

<p id="isiInfo"></p>

</div>

</div>

<script>

function geser(id,arah){

let container=document.getElementById("slide"+id);

let slideWidth=container.clientWidth;

let posisi=container.dataset.posisi ? parseInt(container.dataset.posisi) : 0;

let jumlah=container.children.length;

posisi+=arah;

if(posisi<0)posisi=0;
if(posisi>=jumlah)posisi=jumlah-1;

container.style.transform="translateX(-"+(posisi*slideWidth)+"px)";

container.dataset.posisi=posisi;

}

function lihatInfo(text){

document.getElementById("isiInfo").innerText=text;

document.getElementById("modalInfo").style.display="block";

}

function tutupInfo(){

document.getElementById("modalInfo").style.display="none";

}

function cariProduk(){

let input=document.getElementById("search").value.toLowerCase();

let card=document.querySelectorAll(".card");

card.forEach(function(el){

let nama=el.querySelector("h4").innerText.toLowerCase();

if(nama.includes(input)){
el.style.display="";
}else{
el.style.display="none";
}

});

}

</script>

</body>
</html>