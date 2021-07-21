<?php
session_start();
if(isset($_SESSION['id_user'])) {
    session_destroy();
    echo "<script>alert('Logout Berhasil');window.location='index.php';</script>";
    
} else {
    echo "<script>alert('Logout Gagal, login terlebih dahulu');window.location='login.php';</script>";
}
?>