<?php
include 'koneksi.php';

$kodeProdi = $_GET['kodeProdi'];
$data = mysqli_query($koneksi,"select * from prodi where kodeProdi = '$kodeProdi'");
$oldProdi = mysqli_fetch_array($data);
$oldKaprodi = $oldProdi['nipKaprodi'];
$nama = $oldProdi['namaProdi'];

mysqli_query($koneksi,"delete from prodi where kodeProdi='$kodeProdi'");
mysqli_query($koneksi,"update pengguna set lvAkses=3 where id_user='$oldKaprodi'");
$expire = time()+5;
setcookie('status',3,$expire);
setcookie('kodeProdi',$nama,$expire);
header("location:form-tambah-Prodi.php");

?>