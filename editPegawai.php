<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nip = $_POST['nip'];
$email = mysqli_real_escape_string($koneksi,strip_tags($_POST['email']));
$noHp = mysqli_real_escape_string($koneksi,strip_tags($_POST['noHp']));

$passwordUlang = $nip."!pgw";

if (isset($_POST['resetPass'])) {
    mysqli_query($koneksi,"UPDATE pengguna SET passwordPengguna='$passwordUlang' where `id_user` = '$nip'");
}


mysqli_query($koneksi,"update pegawai set namaPegawai='$nama', emailPegawai='$email', noHpPegawai='$noHp' where nip='$nip'");
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-pegawai.php");

?>