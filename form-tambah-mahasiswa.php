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
    $namaHalaman = "Halaman Mahasiswa";

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
                            <h1 class="text-primary font-weight-bold">Manajemen Data Mahasiswa</h1>
                        </div>
                        <div class="text-center text-muted font-italic">
                            <small>

                                <?php
                                if (isset($_COOKIE['status'])) {
                                    if ($_COOKIE['status'] == 1) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " Berhasil Disimpan </span>";
                                    } else if ($_COOKIE['status'] == 2) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " telah di Perbarui </span>";
                                    }else if ($_COOKIE['status'] == 3) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nim'] . " telah di Hapus </span>";
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
                                <h3 class="mb-0">Data Mahasiswa</h3>
                            </div>
                            <div class="col-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menambahDataMahasiswa">
                                    Tambah Data Mahasiswa
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama Mahasiswa</th>
                                    <th scope="col">nim</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">No HP</th>
                                    <th scope="col">Status</th>
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
                                $query2 = mysqli_query($koneksi, "select * from Mahasiswa");
                                $jumlahData = mysqli_num_rows($query2);
                                $jumlahHalaman = ceil($jumlahData / $batas);



                                $data = mysqli_query($koneksi, "select * from Mahasiswa LEFT JOIN prodi ON mahasiswa.prodiMhs=prodi.kodeProdi ORDER BY nim desc LIMIT $posisi,$batas");
                                while ($d = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $d['namaMhs']; ?>
                                        </th>
                                        <td>
                                            <?php echo $d['nim']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['emailMhs']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['noHpMhs']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['statusMhs']; ?>
                                        </td>
                                        <td>
                                            <a href="#editDataMahasiswa<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#hapusDataMahasiswa<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-outline-danger">Hapus</a>
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

                            for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                if ($i != $halaman) {
                                    echo "<li class='page-item'><a class='page-link' href='form-tambah-Mahasiswa.php?halaman=$i'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item active'>
                                        <a class='page-link' href='#'>$i <span class='sr-only'>(current)</span></a>
                                        </li>";
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
        <div class="modal fade" id="menambahDataMahasiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-primary font-weight-bold">Menambah Data Mahasiswa</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" role="form" action="tambahMahasiswa.php">
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="NIM" type="text" name="nim">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Nama" type="text" name="nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Email" type="text" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="No HP" type="text" name="noHp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                    </div>
                                    <select class="custom-select" name="prodiMhs" required>
                                        <option>Pilih Prodi Mahasiswa</option>
                                        <?php

                                            $query2 = mysqli_query($koneksi, "select * from prodi");
                                            while ($d = mysqli_fetch_array($query2)) {
                                        ?>
                                                <option value="<?php echo $d['kodeProdi']; ?>"><?php echo $d['namaProdi']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-7">
                                    <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary mt-4">Tambah Mahasiswa</button>

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
        $data = mysqli_query($koneksi, "select * from Mahasiswa LEFT JOIN prodi ON mahasiswa.prodiMhs=prodi.kodeProdi ORDER BY nim desc LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="editDataMahasiswa<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Mahasiswa</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" action="editMahasiswa.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3 invisible">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="nim" type="hidden" name="nim" value="<?php echo $d['nim']; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="nim" name="nimTampil" value="<?php echo $d['nim']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nama" type="text" name="nama" value="<?php echo $d['namaMhs']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $d['emailMhs']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="No HP" type="text" name="noHp" value="<?php echo $d['noHpMhs']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <select class="custom-select" name="statusMhs" required>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Lulus">Lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                        </div>
                                        <select class="custom-select" name="prodiMhs" required>
                                            <option value="<?php echo $d['kodeProdi']; ?>"><?php echo $d['namaProdi']; ?></option>
                                            <?php

                                                $query2 = mysqli_query($koneksi, "select * from prodi");
                                                while ($d2 = mysqli_fetch_array($query2)) {
                                            ?>
                                                    <option value="<?php echo $d2['kodeProdi']; ?>"><?php echo $d2['namaProdi']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mt-4">Update Mahasiswa</button>

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
        $data = mysqli_query($koneksi, "select * from Mahasiswa LEFT JOIN prodi ON mahasiswa.prodiMhs=prodi.kodeProdi ORDER BY nim desc LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="hapusDataMahasiswa<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Mahasiswa</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus data Mahasiswa " <span class="text-danger"><?php echo $d['namaMhs']; ?></span> " ?</p>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <a href="hapusMahasiswa.php?nim=<?php echo $d['nim']; ?>" class="btn btn-danger mt-4">Hapus</a>

                                    </div>
                                </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        <?php
        $no++;
        }

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