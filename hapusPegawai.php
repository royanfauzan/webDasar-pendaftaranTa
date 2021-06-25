<?php
include 'koneksi.php';

$nip = $_GET['nip'];


mysqli_query($koneksi,"delete from pegawai where nip='$nip'");
mysqli_query($koneksi,"delete from pengguna where id_user='$nip'");
$expire = time()+5;
setcookie('status',3,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-pegawai.php");

?>