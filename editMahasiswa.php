<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nim = mysqli_real_escape_string($koneksi,strip_tags($_POST['nim']));
$email = mysqli_real_escape_string($koneksi,strip_tags($_POST['email']));
$noHp = mysqli_real_escape_string($koneksi,strip_tags($_POST['noHp']));
$prodiMhs = $_POST['prodiMhs'];

$statusMhs = $_POST['statusMhs'];
$passwordUlang = $nim."!mhs";

if (isset($_POST['resetPass'])) {
    mysqli_query($koneksi,"UPDATE pengguna SET passwordPengguna='$passwordUlang' where `id_user` = '$nim'");
}


if ($statusMhs!="Lulus") {
    mysqli_query($koneksi,"update pengguna set lvAkses=1 where id_user='$nim'");
}else {
    mysqli_query($koneksi,"update pengguna set lvAkses=2 where id_user='$nim'");
}

mysqli_query($koneksi,"update mahasiswa set namaMhs='$nama', noHpMhs='$noHp', emailMhs='$email', prodiMhs='$prodiMhs', statusMhs='$statusMhs' where nim = '$nim'");
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nim',$nim,$expire);
header("location:form-tambah-mahasiswa.php");

?>