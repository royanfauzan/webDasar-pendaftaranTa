<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nip = mysqli_real_escape_string($koneksi,strip_tags($_POST['nip']));
$email = mysqli_real_escape_string($koneksi,strip_tags($_POST['email']));
$noHp = mysqli_real_escape_string($koneksi,strip_tags($_POST['noHp']));
$passwordUlang = $nip."!dsn";

if (isset($_POST['resetPass'])) {
    mysqli_query($koneksi,"UPDATE pengguna SET passwordPengguna='$passwordUlang' where `id_user` = '$nip'");
}


mysqli_query($koneksi,"update dosen set namaDosen='$nama', emailDosen='$email', noHpDosen='$noHp' where nip='$nip'");

$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-dosen.php");

?>