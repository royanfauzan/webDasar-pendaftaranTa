<?php
include 'koneksi.php';
$nim = $_POST['nim'];
$persetujuan = $_POST['persetujuan'];

mysqli_query($koneksi,"update pengguna set lvAkses=2 where id_user='$nim'");
mysqli_query($koneksi,"update mahasiswa set statusMhs='Lulus' where nim='$nim'");

$cekQuery = mysqli_query($koneksi,"update tugasAkhir set statusTa='$persetujuan' where nimMhs = '$nim'");

if ($cekQuery) {
    $expire = time()+5;
    setcookie('status',intval($persetujuan),$expire);
    setcookie('nim',$nim,$expire);
    header("location:list-Ta-Adm.php");
} else {
    $expire = time()+5;
    setcookie('status',99,$expire);
    setcookie('nim',$nim,$expire);
    header("location:list-Ta-Adm.php");
}

?>