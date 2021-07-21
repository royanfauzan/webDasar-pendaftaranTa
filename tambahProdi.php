<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nip = mysqli_real_escape_string($koneksi,strip_tags($_POST['nipKaprodi']));
$kodeProdi = mysqli_real_escape_string($koneksi,strip_tags($_POST['kodeProdi']));

$data = mysqli_query($koneksi,"select * from prodi where kodeProdi = '$kodeProdi'");

$cek = mysqli_num_rows($data);

if ($cek>0) {
    $expire = time()+5;
    setcookie('status',0,$expire);
    setcookie('kodeProdi',$nama,$expire);
    header("location:form-tambah-prodi.php");
} else {
    mysqli_query($koneksi,"insert into prodi values('$kodeProdi','$nama','$nip')");
    mysqli_query($koneksi,"update pengguna set lvAkses=5 where id_user='$nip'");
    $expire = time()+5;
    setcookie('status',1,$expire);
    setcookie('kodeProdi',$nama,$expire);
    header("location:form-tambah-prodi.php");
}

?>