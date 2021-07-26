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
    if ($_SESSION['lvAkses'] > 0 && $_SESSION['lvAkses'] < 3) {
        include 'koneksi.php';
        $namaHalaman = "Dashboard";

        $lvlAkses = $_SESSION['lvAkses'];

        $status = 4;
        $kolom_id_Arr = array(" ", "Mhs", "Mhs", "Ta", "Pegawai", "Ta");
        $kolom_status_Arr = array("Ditolak", "Menunggu Disetujui", "Disetujui", "Selesai");
        $kolom_warna_Arr = array("text-danger", "text-warning", "text-success", "text-primary", " ");

        $kolom_id = $kolom_id_Arr[$lvlAkses];
        $tabel = $_SESSION['tabel'];
        $fk = $_SESSION['fk_user'];
        $id_user = $_SESSION['id_user'];
        $data3 = mysqli_query($koneksi, "select * from $tabel where $fk='$id_user'");
        $d4 = mysqli_fetch_array($data3);
        $namaHalaman = "Daftar TA";
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
                                <h1 class="text-primary font-weight-bold">Pendaftaran Tugas Akhir</h1>
                            </div>
                            <div class="text-center text-muted font-italic">
                                <small>

                                    <?php
                                    if (isset($_COOKIE['status'])) {
                                        if ($_COOKIE['status'] == 1) {
                                            echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " Berhasil Disimpan </span>";
                                        } else if ($_COOKIE['status'] == 2) {
                                            echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " telah di Perbarui </span>";
                                        } else if ($_COOKIE['status'] == 3) {
                                            echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " telah di Hapus </span>";
                                        } else if ($_COOKIE['status'] == 4) {
                                            echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " Gagal Disimpan </span>";
                                        } else {
                                            echo "<span class='text-danger font-weight-700'>Data " . $_COOKIE['nim'] . " Sudah ada! </span>";
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
                                    <h3 class="mb-0">Data TA</h3>
                                </div>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Pembimbing1</th>
                                        <th scope="col">Pembimbing2</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Manajemen</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;

                                    // HItung jumlah data dan pembuatan halaman (link)
                                    $data = mysqli_query($koneksi, "select * from tugasAkhir where nimMhs='$id_user'");
                                    $jumlahData = mysqli_num_rows($data);
                                    if ($jumlahData > 0) {

                                        while ($d = mysqli_fetch_array($data)) {
                                    ?>
                                            <tr>
                                                <th scope="row">
                                                    <?php
                                                    echo substr($d['judulTa'], 0, 14);
                                                    ?> ...
                                                </th>
                                                <td>
                                                    <?php echo $d['pembimbing1']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $d['pembimbing2']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status = intval($d['statusTa']);
                                                    $warnaKolom = $kolom_warna_Arr[$status];
                                                    $kataStatus = $kolom_status_Arr[$status];
                                                    echo "<span class='$warnaKolom font-weight-700'> $kataStatus </span>";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($status == 2) {
                                                    ?>
                                                        <a href="#editFileTa<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-success">Upload File</a>
                                                    <?php
                                                    } elseif ($status == 0) {
                                                    ?>
                                                        <a href="#editJudulTa<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-warning">Perbaikan</a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <h5 class="<?php echo $warnaKolom; ?>">No Action</h5>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>

                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menambahDataTa">
                                                    Daftarkan Judul
                                                </button>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="menambahDataTa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Menambah Data Ta</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" action="tambahTa.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <textarea class="form-control" placeholder="Judul Tugas Akhir" name="judul"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <select class="custom-select" name="pembimbing1" required>
                                            <option>Pilih Pembimbing1</option>
                                            <?php
                                            $queryDsn = mysqli_query($koneksi, "select * from dosen");
                                            while ($dDosen = mysqli_fetch_array($queryDsn)) {
                                            ?>
                                                <option value="<?php echo $dDosen['nip']; ?>"><?php echo substr($dDosen['nip'], -3) . " | " . $dDosen['namaDosen']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mt-4">Tambah Ta</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Modal Edit Generator -->
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "select tugasAkhir.*, dospem1.namaDosen AS 'bimbing1', dospem2.namaDosen AS 'bimbing2' from tugasAkhir Left join dosen dospem1 on tugasAkhir.pembimbing1 = dospem1.nip Left join dosen dospem2 on tugasAkhir.pembimbing2 = dospem2.nip where nimMhs='$id_user'");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <div class="modal fade" id="editJudulTa<?php echo $no; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="text-primary font-weight-bold">Edit Data Ta</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" role="form" action="editJudulTa.php">
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative mb-3">
                                            <textarea class="form-control" placeholder="Judul Tugas Akhir" name="judul"><?php echo $d['judulTa']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                            </div>
                                            <select class="custom-select" name="pembimbing1" required>
                                                <option value="<?php echo $d['pembimbing1']; ?>"><?php echo substr($d['pembimbing1'], -3) . " | " . $d['bimbing1']; ?></option>
                                                <?php
                                                $queryDsn = mysqli_query($koneksi, "select * from dosen");
                                                while ($dDosen = mysqli_fetch_array($queryDsn)) {
                                                ?>
                                                    <option value="<?php echo $dDosen['nip']; ?>"><?php echo substr($dDosen['nip'], -3) . " | " . $dDosen['namaDosen']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-7">
                                            <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary mt-4">Perbaiki Ta</button>
                                        </div>
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

            <!-- Modal Upload Generator -->
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "select tugasAkhir.*, dospem1.namaDosen AS 'bimbing1', dospem2.namaDosen AS 'bimbing2', abstrak, fullpaper from tugasAkhir Left join dosen dospem1 on tugasAkhir.pembimbing1 = dospem1.nip Left join dosen dospem2 on tugasAkhir.pembimbing2 = dospem2.nip where nimMhs='$id_user'");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <div class="modal fade" id="editFileTa<?php echo $no; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="text-primary font-weight-bold">Upload File TA</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" role="form" action="editFileTa.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <h3 class="text-dark font-weight-bold"><?php echo $d['judulTa']; ?></h3>
                                        <hr class="my-4" />
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-muted font-weight-bold"> File Abstrak :
                                            <?php
                                            if (!empty($d['abstrak'])) {
                                            ?>
                                                <a href="<?php echo $d['abstrak']; ?>" class="btn btn-sm btn-success"><?php echo pathinfo($d['abstrak'],PATHINFO_BASENAME); ?></a>
                                            <?php
                                            } else {
                                                echo "Pilih File Abstrak..";
                                            }
                                            ?>
                                        </h5>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="abstrak" id="customFileAbstrak">
                                            <label class="custom-file-label" for="customFileAbstrak">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-muted font-weight-bold"> File FullPaper :
                                            <?php
                                            if (!empty($d['fullpaper'])) {
                                                ?>
                                                <a href="<?php echo $d['fullpaper']; ?>" class="btn btn-sm btn-success"><?php echo pathinfo($d['fullpaper'],PATHINFO_BASENAME); ?></a>
                                            <?php
                                            } else {
                                                echo "Pilih File FullPaper..";
                                            }
                                            ?>
                                        </h5>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="fullpaper" id="customFileFullpaper">
                                            <label class="custom-file-label" for="customFileFullpaper">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-7">
                                            <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary mt-4">Upload File</button>
                                        </div>
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
        }else {
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