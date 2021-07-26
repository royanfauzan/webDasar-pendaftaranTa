<?php
include 'koneksi.php';
$nim = $_POST['nim'];
$persetujuan = $_POST['persetujuan'];
$pembimbing2 = $_POST['pembimbing2'];
$queryBimbing = "";

if ($persetujuan=="2") {
    $queryBimbing = ", pembimbing2 = '$pembimbing2'";
}

$cekQuery = mysqli_query($koneksi,"update tugasAkhir set statusTa='$persetujuan'$queryBimbing where nimMhs = '$nim'");

if ($cekQuery) {
    $expire = time()+5;
    setcookie('status',intval($persetujuan),$expire);
    setcookie('nim',$nim,$expire);
    header("location:list-pengajuan-judul.php");
} else {
    $expire = time()+5;
    setcookie('status',99,$expire);
    setcookie('nim',$nim,$expire);
    header("location:list-pengajuan-judul.php");
}

?>