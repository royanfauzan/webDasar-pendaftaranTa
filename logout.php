<?php
session_start();
if(isset($_SESSION['id_user'])) {
    session_destroy();
    echo "<script>alert('LogOut Berhasil');window.location='index.php';</script>";
    
} else {
    echo "<script>alert('LogOut Gagal, login terlebih dahulu');window.location='login.php';</script>";
}
?>