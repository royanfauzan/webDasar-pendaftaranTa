<?php
include 'koneksi.php';
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$email = $_POST['email'];
$noHp = $_POST['noHp'];


mysqli_query($koneksi,"update Prodi set namaProdi='$nama', emailProdi='$email', noHpProdi='$noHp' where nip='$nip'");
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-Prodi.php");

?>