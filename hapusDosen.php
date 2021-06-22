<?php
include 'koneksi.php';

$nip = $_GET['nip'];


mysqli_query($koneksi,"delete from dosen where nip='$nip'");
$expire = time()+5;
setcookie('status',3,$expire);
setcookie('nip',$nip,$expire);
header("location:form-tambah-dosen.php");

?>