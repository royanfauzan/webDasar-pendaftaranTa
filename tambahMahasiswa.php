<?php
include 'koneksi.php';
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$email = $_POST['email'];
$noHp = $_POST['noHp'];
$prodiMhs = $_POST['prodiMhs'];

$statusMhs = 'Aktif';
$pass = $nim."!mhs";
$lvl = 1;

$data = mysqli_query($koneksi,"select * from mahasiswa where nim = '$nim'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $expire = time()+5;
    setcookie('status',0,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-tambah-mahasiswa.php");
} else {
    mysqli_query($koneksi,"insert into mahasiswa values('$nim','$nama','$prodiMhs','$email','$noHp','$statusMhs')");
    mysqli_query($koneksi,"insert into pengguna values('$nim','$nim','$pass','$lvl')");
    $expire = time()+5;
    setcookie('status',1,$expire);
    setcookie('nim',$nim,$expire);
    header("location:form-tambah-mahasiswa.php");
}

?>