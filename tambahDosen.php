<?php
include 'koneksi.php';
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$email = $_POST['email'];
$noHp = $_POST['noHp'];

$data = mysqli_query($koneksi,"select * from dosen where nip = '$nip'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $expire = time()+5;
    setcookie('status',0,$expire);
    setcookie('nip',$nip,$expire);
    header("location:form-tambah-dosen.php");
} else {
    mysqli_query($koneksi,"insert into dosen values('$nip','$nama','$email','$noHp')");
    $expire = time()+5;
    setcookie('status',1,$expire);
    setcookie('nip',$nip,$expire);
    header("location:form-tambah-dosen.php");
}

?>