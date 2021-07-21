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
    $namaHalaman = "Halaman Dosen";

    $lvlAkses = $_SESSION['lvAkses'];
    
    $kolom_id_Arr = array(" ", "Mhs","Mhs","Dosen","Pegawai","Dosen");
    $kolom_id = $kolom_id_Arr[$lvlAkses];
    $tabel = $_SESSION['tabel'];
    $fk = $_SESSION['fk_user'];
    $id_user = $_SESSION['id_user'];
    $data3 = mysqli_query($koneksi, "select * from $tabel where $fk='$id_user'");
    $d4 = mysqli_fetch_array($data3);
    $namaHalaman = "Halaman Dosen";
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
                            <h1 class="text-primary font-weight-bold">Manajemen Data Dosen</h1>
                        </div>
                        <div class="text-center text-muted font-italic">
                            <small>

                                <?php
                                if (isset($_COOKIE['status'])) {
                                    if ($_COOKIE['status'] == 1) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nip'] . " Berhasil Disimpan </span>";
                                    } else if ($_COOKIE['status'] == 2) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nip'] . " telah di Perbarui </span>";
                                    }else if ($_COOKIE['status'] == 3) {
                                        echo "<span class='text-success font-weight-700'>Data " . $_COOKIE['nip'] . " telah di Hapus </span>";
                                    } else {
                                        echo "<span class='text-danger font-weight-700'>Data " . $_COOKIE['nip'] . " Sudah ada! </span>";
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
                                <h3 class="mb-0">Data Dosen</h3>
                            </div>
                            <div class="col-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menambahDataDosen">
                                    Tambah Data Dosen
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama Dosen</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">No HP</th>
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
                                $query2 = mysqli_query($koneksi, "select * from dosen");
                                $jumlahData = mysqli_num_rows($query2);
                                $jumlahHalaman = ceil($jumlahData / $batas);



                                $data = mysqli_query($koneksi, "select * from dosen LIMIT $posisi,$batas");
                                while ($d = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $d['namaDosen']; ?>
                                        </th>
                                        <td>
                                            <?php echo $d['nip']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['emailDosen']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['noHpDosen']; ?>
                                        </td>
                                        <td>
                                            <a href="#editDataDosen<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#hapusDataDosen<?php echo $no; ?>" data-toggle="modal" class="btn btn-sm btn-outline-danger">Hapus</a>
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
                                    echo "<li class='page-item'><a class='page-link' href='form-tambah-dosen.php?halaman=$i'>$i</a></li>";
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
        <div class="modal fade" id="menambahDataDosen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-primary font-weight-bold">Menambah Data Dosen</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" role="form" action="tambahDosen.php">
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="NIP" type="text" name="nip">
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
                            <div class="row justify-content-end">
                                <div class="col-7">
                                    <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary mt-4">Tambah Dosen</button>

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
        $data = mysqli_query($koneksi, "select * from dosen LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="editDataDosen<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Dosen</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" action="editDosen.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3 invisible">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="NIP" type="hidden" name="nip" value="<?php echo $d['nip']; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="NIP" name="nipTampil" value="<?php echo $d['nip']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nama" type="text" name="nama" value="<?php echo $d['namaDosen']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $d['emailDosen']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="No HP" type="text" name="noHp" value="<?php echo $d['noHpDosen']; ?>">
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mt-4">Update Dosen</button>

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
        $data = mysqli_query($koneksi, "select * from dosen LIMIT $posisi,$batas");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="modal fade" id="hapusDataDosen<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Data Dosen</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus data Dosen " <span class="text-danger"><?php echo $d['namaDosen']; ?></span> " ?</p>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <a href="hapusDosen.php?nip=<?php echo $d['nip']; ?>" class="btn btn-danger mt-4">Hapus</a>

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