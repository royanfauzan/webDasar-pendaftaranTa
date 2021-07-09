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
    if (isset($_SESSION['id_user'])) {
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

    ?>

    <!-- Side Bar -->
    <?php include('sideBarStd.php'); ?>

    <!-- COntent -->
    <div class="main-content" id="panel">

        <!-- navbar -->
        <?php include('navbarStd.php'); ?>

        <!-- Header -->
        <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(assets/img/theme/dashboard.jpg); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <h1 class="display-2 text-white">Hello <?php echo explode(" ",trim($d4['nama'.$kolom_id]))[0]; ?></h1>
                        <p class="text-white mt-0 mb-5">Selamat datang di sistem pendaftaran Tugas Akhir, Sistem ini akan membantu mengelola pendaftaran serta administrasi tugas akhir..</p>
                        <a href="#!" class="btn btn-neutral">Lihat List TA</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--5">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mt-4">
                    <div class="card card-profile">
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-sm btn-info  mr-4 "></a>
                                <a href="#" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#editKontak"> Edit Kontak</a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center">
                                        <div>
                                            <span class="heading"><?php echo date("l"); ?></span>
                                            <span class="description">Hari</span>
                                        </div>
                                        <div>
                                            <span class="heading"><?php echo date("d-m"); ?></span>
                                            <span class="description">Tanggal</span>
                                        </div>
                                        <div>
                                            <span class="heading"><?php echo date("Y"); ?></span>
                                            <span class="description">Tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="h3">
                                    <?php echo $d4['nama'.$kolom_id]; ?>
                                </h5>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i><?php echo $d4['email'.$kolom_id]; ?>
                                </div>
                                <div class="h5 mt-4">
                                    <i class="ni business_briefcase-24 mr-2"><?php echo $d4['noHp'.$kolom_id];?></i>
                                </div>
                                <div>
                                    <i class="ni education_hat mr-2"></i><?php echo ucfirst($tabel); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Ringkasan.. </h3>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <h6 class="heading-small text-muted mb-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-username">Username</label>
                                                <input type="text" id="input-username" class="form-control" placeholder="Username" value="lucky.jesse">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>
                                                <input type="email" id="input-email" class="form-control" placeholder="jesse@example.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-first-name">First name</label>
                                                <input type="text" id="input-first-name" class="form-control" placeholder="First name" value="Lucky">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-last-name">Last name</label>
                                                <input type="text" id="input-last-name" class="form-control" placeholder="Last name" value="Jesse">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-address">Address</label>
                                                <input id="input-address" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">City</label>
                                                <input type="text" id="input-city" class="form-control" placeholder="City" value="New York">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Country</label>
                                                <input type="text" id="input-country" class="form-control" placeholder="Country" value="United States">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Postal code</label>
                                                <input type="number" id="input-postal-code" class="form-control" placeholder="Postal code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <!-- Description -->
                                <h6 class="heading-small text-muted mb-4">About me</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">About Me</label>
                                        <textarea rows="4" class="form-control" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center margin-kosong">
            
        </div>
        <!-- Modal Edit Generator -->

            <div class="modal fade" id="editKontak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-primary font-weight-bold">Edit Kontak</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" action="editKontak.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $d4['email'.$kolom_id]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="No HP" type="text" name="noHp" value="<?php echo $d4['noHp'.$kolom_id]; ?>">
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mt-4">Update Kontak</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        <?php
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