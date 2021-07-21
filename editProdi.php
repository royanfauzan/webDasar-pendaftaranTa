<?php
include 'koneksi.php';
$nama = mysqli_real_escape_string($koneksi,strip_tags($_POST['nama']));
$nip = $_POST['nipKaprodi'];
$kodeProdi = $_POST['kodeProdi'];
$data = mysqli_query($koneksi,"select * from prodi where kodeProdi = '$kodeProdi'");
$oldKaprodi = mysqli_fetch_array($data)['nipKaprodi'];

if ($nip!=$oldKaprodi) {
    mysqli_query($koneksi,"update pengguna set lvAkses=5 where id_user='$nip'");
    mysqli_query($koneksi,"update pengguna set lvAkses=3 where id_user='$oldKaprodi'");
}

mysqli_query($koneksi,"update Prodi set namaProdi='$nama', nipKaprodi='$nip' where kodeProdi = '$kodeProdi'");
$expire = time()+5;
setcookie('status',2,$expire);
setcookie('kodeProdi',$nama,$expire);
header("location:form-tambah-Prodi.php");

?>