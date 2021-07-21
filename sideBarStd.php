<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="pr-3 sidenav-toggler sidenav-toggler-dark p-3" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner ">
                <i class="sidenav-toggler-line bg-primary"></i>
                <i class="sidenav-toggler-line bg-primary"></i>
                <i class="sidenav-toggler-line bg-primary"></i>
            </div>
        </div>
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                        <a class="nav-link " href="dashboard.php">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <?php

                    if ($lvlAkses <= 2) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="form-daftarTa.php">
                                <i class="ni ni-paper-diploma text-orange"></i>
                                <span class="nav-link-text">Tugas Akhir</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list-Ta.php">
                                <i class="ni ni-archive-2 text-primary"></i>
                                <span class="nav-link-text">List TA</span>
                            </a>
                        </li>
                </ul>
            <?php
                    } else if ($lvlAkses == 3) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="list-Bimbingan.php">
                        <i class="ni ni-collection text-orange"></i>
                        <span class="nav-link-text">List Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list-Ta.php">
                        <i class="ni ni-archive-2 text-primary"></i>
                        <span class="nav-link-text">List TA</span>
                    </a>
                </li>
                </ul>
            <?php
                    } else if ($lvlAkses == 4) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="list-Ta.php">
                        <i class="ni ni-archive-2 text-primary"></i>
                        <span class="nav-link-text">List TA</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list-Ta-Adm.php">
                        <i class="ni ni-single-copy-04 text-orange"></i>
                        <span class="nav-link-text">Konfirmasi File TA</span>
                    </a>
                </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">Manajemen Sistem</span>
                </h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="form-tambah-mahasiswa.php">
                            <i class="ni ni-hat-3"></i>
                            <span class="nav-link-text">Data Mahasiswa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form-tambah-dosen.php">
                            <i class="ni ni-single-02"></i>
                            <span class="nav-link-text">Data Dosen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form-tambah-prodi.php">
                            <i class="ni ni-building"></i>
                            <span class="nav-link-text">Data Prodi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form-tambah-pegawai.php">
                            <i class="ni ni-user-run"></i>
                            <span class="nav-link-text">Data Pegawai</span>
                        </a>
                    </li>
                </ul>
            <?php
                    } else if ($lvlAkses == 5) {
            ?>
                    <li class="nav-item">
                    <a class="nav-link" href="list-pengajuan-judul.php">
                        <i class="ni ni-planet text-orange"></i>
                        <span class="nav-link-text">Pengajuan Judul</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list-Ta.php">
                        <i class="ni ni-archive-2 text-primary"></i>
                        <span class="nav-link-text">List TA</span>
                    </a>
                </li>
                </ul>
            <?php
                    }

            ?>
            </div>
        </div>
    </div>
</nav>