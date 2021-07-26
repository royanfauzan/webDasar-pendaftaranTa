<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Argon Dashboard - Free Dashboard for Bootstrap 4</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
    <link rel="stylesheet" href="assets/css/myStyle.css" type="text/css">
</head>

<body>
    <!-- page info -->
    <?php
    session_start();
    if (isset($_SESSION['lvAkses'])) {

        include 'koneksi.php';
        $namaHalaman = "Dashboard";

        $pencarian = "";
        $alamatCari = "";

        if ( isset($_POST['cari'])) {
            $cari = trim($_POST['cari']);
            $pencarian=" WHERE tugasAkhir.judulTa LIKE '%$cari%' OR tugasAkhir.kodeProdiTa LIKE '%$cari%' OR mahasiswa.namaMhs LIKE '%$cari%' OR prodi.namaProdi LIKE '%$cari%'";
            $alamatCari="&cari=$cari";
        }

        if (isset($_GET['cari'])) {
            $cari = trim($_GET['cari']);
            $pencarian=" WHERE tugasAkhir.judulTa LIKE '%$cari%' OR tugasAkhir.kodeProdiTa LIKE '%$cari%' OR mahasiswa.namaMhs LIKE '%$cari%' OR prodi.namaProdi LIKE '%$cari%'";
            $alamatCari="&cari=$cari";
        }

        $lvlAkses = $_SESSION['lvAkses'];

        $kolom_id_Arr = array(" ", "Mhs", "Mhs", "Dosen", "Pegawai", "Dosen");
        $kolom_status_Arr = array("Ditolak", "Menunggu Disetujui", "Disetujui", "Selesai");
        $kolom_warna_Arr = array("text-danger", "text-warning", "text-success", "text-primary", " ");
        $kolom_id = $kolom_id_Arr[$lvlAkses];
        $tabel = $_SESSION['tabel'];
        $fk = $_SESSION['fk_user'];
        $id_user = $_SESSION['id_user'];
        $data3 = mysqli_query($koneksi, "select * from $tabel where $fk='$id_user'");
        $d4 = mysqli_fetch_array($data3);
        // $queryKaprodi = mysqli_query($koneksi, "select * from prodi where nipKaprodi ='$id_user'");
        // $dataKaprodi = mysqli_fetch_array($queryKaprodi);
        // $kodeProdi = $dataKaprodi['kodeProdi'];
        $namaHalaman = "List Tugas Akhir";

    ?>

        <!-- Side Bar -->
        <?php include('sideBarStd.php'); ?>

        <!-- COntent -->
        <div class="main-content" id="panel">

            <!-- navbar -->
            <?php include('navbarStd.php'); ?>

            <div class="container-fluid padding-nol">


                <div class="row justify-content-center margin-kosong">
                    <div class="col-6">
                        <div class="card-body px-lg-5 py-lg-5 ">
                            <div class="text-center mb-4">
                                <h1 class="text-primary font-weight-bold">List Tugas Akhir</h1>
                            </div>
                            <div class="text-center text-muted font-italic">
                                <small>

                                    <?php
                                    if (isset($_COOKIE['status'])) {
                                        if ($_COOKIE['status'] == 0) {
                                            echo "<span class='text-warning font-weight-700'>Penolakan Tugas Akhir " . $_COOKIE['nim'] . " Berhasil Disimpan </span>";
                                        } else if ($_COOKIE['status'] == 2) {
                                            echo "<span class='text-success font-weight-700'>Persetujuan Tugas Akhir " . $_COOKIE['nim'] . " Berhasil Disimpan </span>";
                                        } else {
                                            echo "<span class='text-danger font-weight-700'>Opsi Persetujuan TA : " . $_COOKIE['nim'] . " Gagal Disimpan</span>";
                                        }
                                    } else {
                                        echo " ";
                                    }
                                    ?>

                                </small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center margin-kosong">
                <div class="col">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <h3 class="mb-0">Tugas Akhir</h3>
                                </div>
                                <div>
                                    <form class="form-inline" method="post" action="?">
                                        <input name="cari" class="form-control mr-sm-2" type="search" placeholder="<?php echo isset($_GET['cari'])?$_GET['cari']:( isset($_POST['cari'])?$_POST['cari']:"Cari"); ?>" aria-label="Search">
                                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Cari</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Judul</th>
                                        <th scope="col">NIM</th>
                                        <th scope="col">Prodi</th>
                                        <th scope="col">Detil</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;

                                    //Menentukan Batas, cek halaman dan posisi data
                                    $batas = 5;
                                    $halaman = @$_GET['halaman'];
                                    if (empty($halaman)) {
                                        $posisi = 0;
                                        $halaman = 1;
                                    } else {
                                        $posisi = ($halaman - 1) * $batas;
                                    }
                                    // HItung jumlah data dan pembuatan halaman (link)
                                    $data = mysqli_query($koneksi, "select * from (SELECT * FROM tugasAkhir left join mahasiswa on tugasAkhir.nimMhs = mahasiswa.nim Left join prodi on kodeprodita = kodeprodi $pencarian) AS tbFilter where tbFilter.statusTa=3");
                                    $jumlahData = mysqli_num_rows($data);
                                    $jumlahHalaman = ceil($jumlahData / $batas);

                                    $data = mysqli_query($koneksi, "select * from (SELECT * FROM tugasAkhir left join mahasiswa on tugasAkhir.nimMhs = mahasiswa.nim Left join prodi on kodeprodita = kodeprodi $pencarian) AS tbFilter where tbFilter.statusTa=3 LIMIT $posisi,$batas");
                                    if ($jumlahData > 0) {

                                        while ($d = mysqli_fetch_array($data)) {
                                    ?>
                                            <tr>
                                                <th scope="row">
                                                    <?php
                                                    echo substr($d['judulTa'], 0, 20);
                                                    ?> ...
                                                </th>
                                                <td>
                                                    <?php echo $d['nimMhs']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $namaProdi = $d['namaProdi'];
                                                    echo "<span class='font-weight-700'> $namaProdi </span>";
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="#editDataTa<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-warning">Detail</a>
                                                </td>

                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">
                                                <p class='text-warning text-center font-weight-700'>Data yang dicari tidak ditemukan</p>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <div class="pagination justify-content-end mb-0">
                                <?php
                                echo '
                                <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                ';

                                if ($jumlahHalaman>3) {
                                    $awalHalaman = (ceil($halaman/3)*3)-2;                             
                                    $batasHalaman = (ceil($halaman/3)*3);
                                    $nextPaging = $batasHalaman+1;
                                    $sisaHalaman = $jumlahHalaman - $batasHalaman;
                                    

                                    if ($sisaHalaman<=0) {
                                        $batasHalaman = $jumlahHalaman;
                                    }

                                    
                                    if ($halaman>3) {
                                        $halSebelum = floor($halaman/3)*3;
                                        echo "<li class='page-item'><a class='page-link' href='list-Ta.php?halaman=$halSebelum$alamatCari'>...</a></li>";
                                    }
                                    for ($i = $awalHalaman; $i <= $batasHalaman; $i++) {
                                        if ($i != $halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='list-Ta.php?halaman=$i$alamatCari'>$i</a></li>";
                                        } else {
                                            echo "<li class='page-item active'>
                                            <a class='page-link' href='#'>$i <span class='sr-only'>(current)</span></a>
                                            </li>";
                                        }
                                    }
                                    if ($sisaHalaman>0) {
                                        echo "<li class='page-item'><a class='page-link' href='list-Ta.php?halaman=$nextPaging$alamatCari'>...</a></li>";
                                    }
                                } else {
                                    for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                        if ($i != $halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='list-Ta.php?halaman=$i$alamatCari'>$i</a></li>";
                                        } else {
                                            echo "<li class='page-item active'>
                                            <a class='page-link' href='#'>$i <span class='sr-only'>(current)</span></a>
                                            </li>";
                                        }
                                    }
                                }
                                

                                echo '
                                </ul>
                                </nav>
                                ';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Generator -->
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "select judulTa, abstrak, fullpaper, nimMhs, tanggalDaftar, dospem1.namaDosen AS 'bimbing1',dospem2.namaDosen AS 'bimbing2' from tugasAkhir Left join dosen dospem1 on tugasAkhir.pembimbing1 = dospem1.nip Left join dosen dospem2 on tugasAkhir.pembimbing2 = dospem2.nip where statusTa=3 LIMIT $posisi,$batas");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <div class="modal fade" id="editDataTa<?php echo $no; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="text-primary font-weight-bold">Detail Proposal</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 class='text-dark'>Judul : </h5>
                                <p class="text-dark font-weight-bold"><?php echo $d['judulTa']; ?></p>
                                <hr class="my-4" />
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Informasi Pengajuan</h6>
                                <form method="post" role="form">
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-email">NIM Pembuat</label>
                                                    <input type="email" id="input-email" readonly class="form-control-plaintext" name="nimTampil" placeholder="<?php echo $d['nimMhs']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 invisible">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-username">NIM</label>
                                                    <input type="text" id="input-username" class="form-control" name="nim" placeholder="NIM" value="<?php echo $d['nimMhs']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-first-name">Pembimbing1</label>
                                                    <input type="text" id="input-first-name" readonly class="form-control-plaintext" placeholder="Pembimbing 1" value="<?php echo $d['bimbing1']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-last-name">Pembimbing2</label>
                                                    <input type="text" id="input-last-name" class="form-control-plaintext" placeholder="Pembimbing 2" value="<?php echo $d['bimbing2']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-first-name">Tanggal Pengajuan</label>
                                                    <input type="text" id="input-first-name" readonly class="form-control-plaintext" placeholder="Pembimbing 1" value="<?php echo $d['tanggalDaftar']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="form-group">
                                        <h4 class="text-muted font-weight-bold"> File Abstrak :
                                            <?php
                                            if (file_exists($d['abstrak'])) {
                                            ?>
                                                <a href="<?php echo $d['abstrak']; ?>" class="btn btn-sm btn-success"><?php echo pathinfo($d['abstrak'], PATHINFO_BASENAME); ?></a>
                                            <?php
                                            } else {
                                                echo "File Abstrak Tidak Ditemukan!!";
                                            }
                                            ?>
                                        </h4>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="form-group">
                                        <h4 class="text-muted font-weight-bold"> File FullPaper :
                                            <?php
                                            if (file_exists($d['fullpaper']) && $lvlAkses > 1) {
                                            ?>
                                                <a href="<?php echo $d['fullpaper']; ?>" class="btn btn-sm btn-success"><?php echo pathinfo($d['fullpaper'], PATHINFO_BASENAME); ?></a>
                                            <?php
                                            } else {
                                                echo "Tidak Tersedia";
                                            }
                                            ?>
                                        </h4>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Address -->

                                    <div class="row justify-content-between align-items-end">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
                $no++;
            }
            ?>

            <!-- Modal Hapus Generator -->
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "select judulTa, nimMhs, tanggalDaftar, dospem1.namaDosen AS 'bimbing1',dospem2.namaDosen AS 'bimbing2' from tugasAkhir Left join dosen dospem1 on tugasAkhir.pembimbing1 = dospem1.nip Left join dosen dospem2 on tugasAkhir.pembimbing2 = dospem2.nip where statusTa=3 LIMIT $posisi,$batas");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <div class="modal fade" id="hapusDataTa<?php echo $no; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="text-primary font-weight-bold">Persetujuan Judul TA</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin akan Menyetujui Judul Tugas Akhir " <span class="text-info"><?php echo $d['judulTa']; ?></span> " ?</p>
                                <form method="post" role="form" action="editTaKaprodi.php">
                                    <div class="col-lg-6 invisible">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">NIM</label>
                                            <input type="text" id="input-username" class="form-control" name="nim" placeholder="NIM" value="<?php echo $d['nimMhs']; ?>">
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Address -->
                                    <h6 class="heading-small text-muted mb-4">Opsi Persetujuan</h6>

                                    <div class="row justify-content-between align-items-end">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button name="persetujuan" type="submit" class="btn btn-success w-25 text-center" value="2">Setujui</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
        <?php
                $no++;
            }
        } else {
            header('location:login.php');
        }
        ?>

        </div>





        <!-- Core -->
        <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>
</body>

</html>