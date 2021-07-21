<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nip = $_POST['nip'];
$email = mysqli_real_escape_string($koneksi,strip_tags($_POST['email']));
$noHp = mysqli_real_escape_string($koneksi,strip_tags($_POST['noHp']));


mysqli_query($koneksi,"update pegawai set namaPegawai='$nama', emailPegawai='$email', noHpPegawai='$noHp' where nip='$nip'");
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-pegawai.php");

?>