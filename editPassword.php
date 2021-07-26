<?php
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi,strip_tags($_POST['username']));
$password = mysqli_real_escape_string($koneksi,strip_tags($_POST['password']));
$passwordBaru = mysqli_real_escape_string($koneksi,strip_tags(trim($_POST['passwordBaru'])));


$data = mysqli_query($koneksi,"select * from pengguna where `username` = '$username' AND passwordPengguna = '$password'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $dataUser = mysqli_fetch_array($data);
    $levelAkses = intval($dataUser['lvAkses']);
    $id_user = $dataUser['id_user'];
    
    if (strlen($passwordBaru)<7) {
        $expire = time()+5;
        setcookie('gagal',2,$expire);
        header('location:update-password.php');
    }

    mysqli_query($koneksi,"UPDATE pengguna SET passwordPengguna='$passwordBaru' where `id_user` = '$id_user'");
    $cekPassword = mysqli_query($koneksi,"select * from pengguna where `username` = '$username' AND passwordPengguna = '$passwordBaru'");
    if ($cekPassword>0) {
        echo "<script>alert('Password Baru Berhasil Disimpan');</script>";
        header('location:login.php');
    }
} else {
    $expire = time()+5;
    setcookie('gagal',1,$expire);
    header('location:update-password.php');
}

?>