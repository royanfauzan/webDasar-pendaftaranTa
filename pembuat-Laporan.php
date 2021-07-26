<?php
session_start();
require('fpdf183/fpdf.php');
include 'koneksi.php';


// Data Dari Form
$semester = $_POST['semester'];
$tahunPilihan = $_POST['tahun'];
$id_user = $_SESSION['id_user'];
$lvlAkses = $_SESSION['lvAkses'];

if ($lvlAkses>=4) {

    if (isset($_POST['semester']) && isset($_POST['tahun'])) {
            //Fungsi pemotong nama
        function potongNama(string $teksNama){
            $panjangteks = strlen($teksNama);
            if ($panjangteks<20) {
                return $teksNama;
            } else {
                $posisiSpasi = strrpos($teksNama, ' ');
                $teksbuff = substr($teksNama, 0, $posisiSpasi);
                return potongNama($teksbuff);
            }
        }


        // Bahan Query
        $tanggalAwal = "";
        $tanggalAkhir = "";
        $syaratTanggal="";

        // Menyiapkan data Tanggal
        if ($semester == "Genap") {
            $tanggalAwal = $tahunPilihan."-03-02";
            $tanggalAkhir = $tahunPilihan."-08-31";
        } else {
            $tahuntambah = intval($tahunPilihan) + 1;
            $tanggalAwal = $tahunPilihan."-09-01";
            $tanggalAkhir = $tahuntambah."-03-01";
        }

        //Nilai Default Pengisi Tampilan
        $namaProdi="Seluruh Prodi";
        $batasanProdi ="";
        $pencetak="Pegawai";

        if ($lvlAkses==5) {
            // Menyiapkan identitas Prodi
            $queryKaprodi = mysqli_query($koneksi, "select * from prodi JOIN dosen ON nipKaprodi = nip where nipKaprodi ='$id_user'");
            $dataKaprodi = mysqli_fetch_array($queryKaprodi);
            $kodeProdi = $dataKaprodi['kodeProdi'];
            $namaProdi = $dataKaprodi['namaProdi'];
            $namaKaprodi = $dataKaprodi['namaDosen'];
            $batasanProdi = "kodeProdiTa = '$kodeProdi' AND";
            $pencetak = "Kepala Program Studi";
        }elseif($lvlAkses==4){
            $queryKaprodi = mysqli_query($koneksi, "select * from pegawai where nip ='$id_user'");
            $dataKaprodi = mysqli_fetch_array($queryKaprodi);
            $namaKaprodi = $dataKaprodi['namaPegawai'];
        }



        //dataDasar
        $tanggalCetak = date("d-m-Y");
        $penghitungPersen = 0;

        // Data Laporan
        $queryDaftar = "SELECT COUNT(statusTa) AS daftarAll,COUNT(CASE statusTa WHEN 1 THEN 1 ELSE NULL END) AS daftarWait,COUNT(CASE statusTa WHEN 0 THEN 1 ELSE NULL END) AS daftarPerbaikan,COUNT(CASE statusTa WHEN 2 THEN 1 ELSE NULL END) AS daftarProses,COUNT(CASE statusTa WHEN 3 THEN 1 ELSE NULL END) AS daftarSelesai FROM tugasakhir WHERE $batasanProdi tanggalDaftar BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
        $dataDaftar = mysqli_query($koneksi,$queryDaftar);
        $detilDaftar = mysqli_fetch_assoc($dataDaftar);
        $totalDaftar = intval($detilDaftar['daftarAll']);
        $totalDaftarRumus = 1;

        if ($totalDaftar>1) {
            $totalDaftarRumus = $totalDaftar;
        }


        // Data Lampiran
        $queryLmpiran = "SELECT * FROM tugasAkhir JOIN mahasiswa ON tugasAkhir.nimMhs = mahasiswa.nim WHERE $batasanProdi tanggalDaftar BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
        $dataLampiran = mysqli_query($koneksi,$queryLmpiran);
        $jumlahDataJudul = mysqli_num_rows($dataLampiran);
        $kolom_status_Arr = array("Ditolak", "Menunggu", "Proses", "Selesai");

        $pdf = new FPDF('P','mm','A4');

        $pdf->AddPage();

        $pdf->SetFont('Arial','B',14);

        $pdf->Cell(130,10,'LAPORAN PENDAFTARAN TUGAS AKHIR',0,0);
        $pdf->Cell(59,10,$namaProdi,0,1);

        $pdf->SetFont('Arial','I',12);

        $pdf->Cell(130,5,$pencetak,0,1);

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130,5,$namaKaprodi,0,0);
        $pdf->Cell(59,5,'Per : '.$tanggalCetak,1,1);

        $pdf->Cell(130,5,$id_user,0,1);
        $pdf->Cell(130,20,'',0,1);
        $pdf->Cell(130,10,'',0,1);

        $pdf->Cell(50,5,'Data Dipilih ',0,0);
        $pdf->Cell(3,5,':',0,0);
        $pdf->Cell(20,5,'Semester '.$semester.', '. $tahunPilihan,0,1);


        $tglAwalTampil = date('d-m-Y',strtotime($tanggalAwal));
        $tglAkhirTampil = date('d-m-Y',strtotime($tanggalAkhir));

        $pdf->Cell(50,5,'Rentang Tanggal ',0,0);
        $pdf->Cell(3,5,':',0,0);
        $pdf->Cell(25,5,$tglAwalTampil,0,0);
        $pdf->Cell(4,5,'-',0,0);
        $pdf->Cell(25,5,$tglAkhirTampil,0,1);

        $pdf->SetFont('Arial','B',13);

        $pdf->Cell(130,10,'Overview Data Tugas Akhir',0,1);

        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(130,6,'Kategori',1,0,'C');
        $pdf->Cell(59,6,'Jumlah',1,1,'C');

        $pdf->SetFont('Arial','',12);

        $pdf->Cell(130,6,'Judul Diajukan',1,0);
        $pdf->Cell(59,6,$totalDaftar,1,1,'R');

        $pdf->Cell(130,6,'Judul Mengunggu Persetujuan',1,0);
        $pdf->Cell(59,6,$detilDaftar['daftarWait'],1,1,'R');

        $pdf->Cell(130,6,'Tugas Akhir Dalam Perbaikan',1,0);
        $pdf->Cell(59,6,$detilDaftar['daftarPerbaikan'],1,1,'R');

        $pdf->Cell(130,6,'Tugas Akhir Dalam Pengerjaan',1,0);
        $pdf->Cell(59,6,$detilDaftar['daftarProses'],1,1,'R');

        $pdf->Cell(130,6,'Tugas Akhir Selesai',1,0);
        $pdf->Cell(59,6,$detilDaftar['daftarSelesai'],1,1,'R');

        $penghitungPersen = (intval($detilDaftar['daftarSelesai'])/$totalDaftarRumus)*100;

        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(60,5,'',0,0);
        $pdf->Cell(70,7,'Persentase Penyelesaian',1,0);
        $pdf->Cell(59,7,strval($penghitungPersen).'%',1,1,'R');

        $pdf->SetFont('Arial','I',12);
        $pdf->Cell(130,5,'',0,1);
        $pdf->Cell(130,5,'',0,1);
        $pdf->Cell(130,5,'* Terlampir data Judul Terdaftar',0,1);


        //Lampiran

        $pdf->AddPage();

        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(130,10,'Lampiran Data Judul Terdaftar',0,1);

        $pdf->SetFont('Arial','B',10);

        $pdf->Cell(30,5,'NIM',1,0,'C');
        $pdf->Cell(39,5,'Nama Mahasiswa',1,0,'C');
        $pdf->Cell(100,5,'Judul',1,0,'C');
        $pdf->Cell(20,5,'Status',1,1,'C');

        $pdf->SetFont('Arial','',10);

        $perulangan = 0;

        while ($perinci = mysqli_fetch_array($dataLampiran)) {
            if ($perulangan<50) {
                $status = intval($perinci['statusTa']);
                $kataStatus = $kolom_status_Arr[$status];
                $panjangKata = strlen($perinci['judulTa']);

                if ($panjangKata>54) {
                    $tinggi = ceil($panjangKata/54)*5;

                    $pdf->Cell(30,$tinggi,$perinci['nimMhs'],1,0);
                    $pdf->Cell(39,$tinggi,potongNama($perinci['namaMhs']),1,0);

                    $xPos=$pdf->GetX();
                    $yPos=$pdf->GetY();

                    $pdf->MultiCell(100,5,$perinci['judulTa'],1,'L');
                    $pdf->SetXY(($xPos+100),$yPos);
                    $pdf->Cell(20,$tinggi,$kataStatus,1,1,'C');
                } else {
                    $pdf->Cell(30,5,$perinci['nimMhs'],1,0);
                    $pdf->Cell(39,5,potongNama($perinci['namaMhs']),1,0);
                    $pdf->Cell(100,5,$perinci['judulTa'],1,0);
                    $pdf->Cell(20,5,$kataStatus,1,1,'C');
                }
                
                $perulangan++;
            }else {
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',10);

                $pdf->Cell(30,5,'NIM',1,0,'C');
                $pdf->Cell(39,5,'Nama Mahasiswa',1,0,'C');
                $pdf->Cell(100,5,'Judul',1,0,'C');
                $pdf->Cell(20,5,'Status',1,1,'C');

                $pdf->SetFont('Arial','',10);

                $perulangan = 0;
            }
        }


        $pdf->Output();
    } else {
    echo "<script>alert('Semester dan Tahun laporan belum dipilih');</script>";
    header('location:dashboard.php');
    }




} else {
    echo "<script>alert('User Anda tidak dapat mengakses Fitur Laporan');</script>";
    header('location:login.php');

}

