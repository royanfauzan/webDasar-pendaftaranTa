<?php
session_start();

include 'koneksi.php';

$lvlAkses = $_SESSION['lvAkses'];
$kolom_id_Arr = array(" ", "Mhs","Mhs","Dosen","Pegawai","Dosen");
$kolom_id = $kolom_id_Arr[$lvlAkses];
$tabel = $_SESSION['tabel'];
$fk = $_SESSION['fk_user'];
$id_user = $_SESSION['id_user'];
$email = mysqli_real_escape_string($koneksi,strip_tags($_POST['email']));
$noHp = mysqli_real_escape_string($koneksi,strip_tags($_POST['noHp']));

$query = "update $tabel set email".$kolom_id."='$email', noHp".$kolom_id."='$noHp' where $fk = '$id_user'";

mysqli_query($koneksi,$query);
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('nip',$nip,$expire);
header("location:dashboard.php");
