<?php
include 'koneksi.php';
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$email = $_POST['email'];
$noHp = $_POST['noHp'];
$pass = $nip."!pgw";
$lvl = 4;

$data = mysqli_query($koneksi,"select * from pegawai where nip = '$nip'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $expire = time()+5;
    setcookie('status',0,$expire);
    setcookie('nip',$nip,$expire);
    header("location:form-tambah-pegawai.php");
} else {
    mysqli_query($koneksi,"insert into pegawai values('$nip','$nama','$email','$noHp')");
    mysqli_query($koneksi,"insert into pengguna values('$nip','$nip','$pass','$lvl')");
    $expire = time()+5;
    setcookie('status',1,$expire);
    setcookie('nip',$nip,$expire);
    header("location:form-tambah-pegawai.php");
}

?>