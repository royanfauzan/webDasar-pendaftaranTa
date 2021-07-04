<?php
include 'koneksi.php';
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$email = $_POST['email'];
$noHp = $_POST['noHp'];
$prodiMhs = $_POST['prodiMhs'];

$statusMhs = $_POST['statusMhs'];

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