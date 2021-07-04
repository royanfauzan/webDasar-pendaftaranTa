<?php
include 'koneksi.php';

$nim = $_GET['nim'];


mysqli_query($koneksi,"delete from mahasiswa where nim='$nim'");
mysqli_query($koneksi,"delete from pengguna where id_user='$nim'");
$expire = time()+5;
setcookie('status',3,$expire);
setcookie('nim',$nim,$expire);
header("location:form-tambah-mahasiswa.php");

?>