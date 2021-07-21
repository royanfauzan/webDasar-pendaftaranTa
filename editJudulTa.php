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

$cekQuery = mysqli_query($koneksi,"update tugasAkhir set statusTa='$statusTa', judulTa = '$judul', pembimbing1 = '$pembimbing1', pembimbing2 = '$pembimbing2' where nimMhs = '$nim'");

if ($cekQuery) {
    $expire = time()+5;
    setcookie('status',2,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-daftarTa.php");
} else {
    $expire = time()+5;
    setcookie('status',4,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-daftarTa.php");
}

?>