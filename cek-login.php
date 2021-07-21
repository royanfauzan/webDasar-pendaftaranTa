<?php
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi,strip_tags($_POST['username']));
$password = mysqli_real_escape_string($koneksi,strip_tags($_POST['password']));


$data = mysqli_query($koneksi,"select * from pengguna where `username` = '$username' AND passwordPengguna = '$password'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $dataUser = mysqli_fetch_array($data);
    $levelAkses = intval($dataUser['lvAkses']);
    $id_user = $dataUser['id_user'];
    $_SESSION['lvAkses']=$levelAkses;
    $_SESSION['id_user']=$id_user;
    $_SESSION['fk_user']='nip';
    if ($levelAkses <= 2) {
        $_SESSION['tabel']='mahasiswa';
        $_SESSION['fk_user']='nim';
    } else if ($levelAkses == 3) {
        $_SESSION['tabel']='dosen';
    }else if ($levelAkses == 4) {
        $_SESSION['tabel']='pegawai';
    } else if ($levelAkses == 5) {
        $_SESSION['tabel']='dosen';
    }
    header('location:dashboard.php');
} else {
    $expire = time()+5;
    setcookie('gagal',1,$expire);
    header('location:login.php');
}

?>