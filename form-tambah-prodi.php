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
    if ($_SESSION['lvAkses']==4) {
    include 'koneksi.php';
    $namaHalaman = "Dashboard";

    $lvlAkses = $_SESSION['lvAkses'];
    
    $kolom_id_Arr = array(" ", "Mhs","Mhs","Dosen","Pegawai","Dosen");
    $kolom_id = $kolom_id_Arr[$lvlAkses];
    $tabel = $_SESSION['tabel'];
    $fk = $_SESSION['fk_user'];
    $id_user = $_SESSION['id_user'];
    $data3 = mysqli_query($koneksi, "select * from $tabel where $fk='$id_user'");
    $d4 = mysqli_fetch_array($data3);
    $namaHalaman = "Halaman Prodi";
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
                            <h1 class="text-primary font-weight-bold">Manajemen Data Prodi</h1>
                        </div>
                        <div class="text-center text-muted font-italic">
                            <small>

                                <?php
                                if (isset($_COOKIE['status'])) {
                                    if ($_COOKIE['status'] == 1) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['kodeProdi'] . " Berhasil Disimpan </span>";
                                    } else if ($_COOKIE['status'] == 2) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['kodeProdi'] . " telah di Perbarui </span>";
                                    }else if ($_COOKIE['status'] == 3) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['kodeProdi'] . " telah di Hapus </span>";
                                    } else {
                                        echo "<span class='text-danger font-weight-700'>Data " . $_COOKIE['kodeProdi'] . " Sudah ada! </span>";
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
                                <h3 class="mb-0">Data Prodi</h3>
                            </div>
                            <div class="col-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menambahDataProdi">
                                    Tambah Data Prodi
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama Prodi</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Kaprodi</th>
                                    <th scope="col">Manajemen</th>
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
                                $query2 = mysqli_query($koneksi, "select * from Prodi");
                                $jumlahData = mysqli_num_rows($query2);
                                $jumlahHalaman = ceil($jumlahData / $batas);



                                $data = mysqli_query($koneksi, "select * from Prodi inner join dosen on prodi.nipKaprodi=dosen.nip ORDER BY kodeProdi desc LIMIT $posisi,$batas");
                                while ($d = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $d['namaProdi']; ?>
                                        </th>
                                        <td>
                                            <?php echo $d['kodeProdi']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['namaDosen']; ?>
                                        </td>
                        
                                        <td>
                                            <a href="#editDataProdi<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#hapusDataProdi<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-outline-danger">Hapus</a>
                                        </td>

                                    </tr>
                                <?php
                                    $no++;
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
                                        echo "<li class='page-item'><a class='page-link' href='form-tambah-prodi.php?halaman=$halSebelum'>...</a></li>";
                                    }
                                    for ($i = $awalHalaman; $i <= $batasHalaman; $i++) {
                                        if ($i != $halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='form-tambah-prodi.php?halaman=$i'>$i</a></li>";
                                        } else {
                                            echo "<li class='page-item active'>
                                            <a class='page-link' href='#'>$i <span class='sr-only'>(current)</span></a>
                                            </li>";
                                        }
                                    }
                                    if ($sisaHalaman>0) {
                                        echo "<li class='page-item'><a class='page-link' href='form-tambah-prodi.php?halaman=$nextPaging'>...</a></li>";
                                    }
                                } else {
                                    for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                        if ($i != $halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='form-tambah-prodi.php?halaman=$i'>$i</a></li>";
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

        <!-- Modal -->
        <div class="modal fade" id="menambahDataProdi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-primary font-weight-bold">Menambah Data Prodi</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" role="form" action="tambahProdi.php">
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="kodeProdi" type="text" name="kodeProdi" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Nama Prodi" type="text" name="nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <select class="custom-select" name="nipKaprodi" required>
                                        <option>Pilih Nama Kaprodi</option>
                                        <?php

                                            $query2 = mysqli_query($koneksi, "select * from dosen");
                                            while ($d = mysqli_fetch_array($query2)) {
                                        ?>
                                                <option value="<?php echo $d['nip']; ?>"><?php echo $d['namaDosen']; ?></option>
                                        <?php
                                            }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-7">
                                    <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary mt-4">Tambah Prodi</button>

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
        $data = mysqli_query($koneksi, "select * from Prodi inner join dosen on prodi.nipKaprodi=dosen.nip ORDER BY kodeProdi desc LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="editDataProdi<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Prodi</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" action="editProdi.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3 invisible">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="kodeProdi" type="hidden" name="kodeProdi" value="<?php echo $d['kodeProdi']; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="kodeProdi" name="kodeProdiTampil" value="<?php echo $d['kodeProdi']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nama" type="text" name="nama" value="<?php echo $d['namaProdi']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <select class="custom-select" name="nipKaprodi" required>
                                            <option value="<?php echo $d['nip']; ?>"><?php echo substr($d['nip'],-3)." | ".$d['namaDosen']; ?></option>
                                            <?php
                                                $query2 = mysqli_query($koneksi, "select * from dosen");
                                                while ($d2 = mysqli_fetch_array($query2)) {
                                            ?>
                                                    <option value="<?php echo $d2['nip']; ?>"><?php echo substr($d2['nip'],-3)." | ".$d2['namaDosen']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mt-4">Update Prodi</button>

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
        $no = 1;
        $data = mysqli_query($koneksi, "select * from Prodi inner join dosen on prodi.nipKaprodi=dosen.nip ORDER BY kodeProdi desc LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="hapusDataProdi<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Prodi</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus data Prodi " <span class="text-danger"><?php echo $d['namaProdi']; ?></span> " ?</p>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <a href="hapusProdi.php?kodeProdi=<?php echo $d['kodeProdi']; ?>" class="btn btn-danger mt-4">Hapus</a>

                                    </div>
                                </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        <?php
        $no++;
        }
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