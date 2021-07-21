<?php
session_start();
include 'koneksi.php';
#dari session
$nim = $_SESSION['id_user'];

#dari Form
$judul = mysqli_real_escape_string($koneksi,strip_tags($_POST['judul']));
$pembimbing1 = $_POST['pembimbing1'];
$pembimbing2 = $_POST['pembimbing2'];

$statusTa = 1;
$tanggal = date("Y-m-d");

$data = mysqli_query($koneksi,"select * from mahasiswa where nim = '$nim'");
$detilMhs = mysqli_fetch_array($data);

$kodeProdi = $detilMhs['prodiMhs'];

$sudahDaftar = mysqli_query($koneksi,"select * from tugasAkhir where nimMhs = '$nim'");
$cek = mysqli_num_rows($sudahDaftar);

if ($cek>0) {
    $expire = time()+5;
    setcookie('status',0,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-daftarTa.php");
} else {
    mysqli_query($koneksi,"insert into tugasAkhir(nimMhs, judulTa, tanggaldaftar, statusTa, pembimbing1, pembimbing2, kodeProdiTa) values('$nim','$judul','$tanggal','$statusTa','$pembimbing1','$pembimbing2','$kodeProdi')");
    $expire = time()+5;
    setcookie('status',1,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-daftarTa.php");
}

?>