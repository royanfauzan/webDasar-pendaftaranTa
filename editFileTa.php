<?php
session_start();
include 'koneksi.php';
#dari session
$nim = $_SESSION['id_user'];
$data = mysqli_query($koneksi, "select * from tugasAkhir where nimMhs=$nim");
$dataSebelum = mysqli_fetch_assoc($data) ;


if(!$_FILES['abstrak']['error'] == UPLOAD_ERR_NO_FILE || !$_FILES['fullpaper']['error'] == UPLOAD_ERR_NO_FILE){
    $queryTambahan = "";
    if (isset($_FILES['abstrak']) && !$_FILES['abstrak']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors= "";
        $file_name = $_FILES['abstrak']['name'];
        $file_name = str_replace(" ","",$file_name);
        $file_size =$_FILES['abstrak']['size'];
        $file_tmp =$_FILES['abstrak']['tmp_name'];
        $file_type=$_FILES['abstrak']['type'];
        $file_ext= pathinfo($file_name,PATHINFO_EXTENSION);
        $extensions= array("doc","docx","pdf");
        
        if(in_array($file_ext,$extensions)=== false){
            $errors="Jenis file Harus doc, docx atau pdf.";
        }
        
        if($file_size > 2097152){
            $errors='File Melebihi 2 MB';
        }

        if (!empty($dataSebelum['abstrak']) && empty($errors)) {
            $abstrakSebelum = $dataSebelum['abstrak'];
            echo "Sensor Data Sebelum";
            unlink($abstrakSebelum);
        }
        
        $penyimpanan = "fileTugasAkhir/abstrak/".$nim."_".$file_name;
        
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,$penyimpanan);
            echo "Success Abstrak";
            $queryTambahan .= " abstrak='".$penyimpanan."'";
        }else{
            print_r($errors);
        }
    }

    if (isset($_FILES['fullpaper']) && !$_FILES['fullpaper']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors= "";
        $file_name = $_FILES['fullpaper']['name'];
        $file_name = str_replace(" ","",$file_name);
        $file_size =$_FILES['fullpaper']['size'];
        $file_tmp =$_FILES['fullpaper']['tmp_name'];
        $file_type=$_FILES['fullpaper']['type'];
        $file_ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
        $extensions= array("doc","docx","pdf");
        
        if(in_array($file_ext,$extensions)=== false){
            $errors="Jenis file Harus doc, docx atau pdf.";
        }
        
        if($file_size > 2097152){
            $errors='Ukuran File Melebihi 2 MB';
        }

        if (!empty($dataSebelum['fullpaper']) && empty($errors)) {
            $fullSebelum = $dataSebelum['fullpaper'];
            echo "Sensor Data fullpaper Sebelum";
            unlink($fullSebelum);
        }

        $penyimpanan = "fileTugasAkhir/fullpaper/".$nim."_".$file_name;
        
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,$penyimpanan);
            echo "Success Fullpaper";
            if (!empty($queryTambahan)) {
                $queryTambahan .=", ";
            }
            $queryTambahan .= "fullpaper='".$penyimpanan."' ";
            
        }else{
            print_r($errors);
        }
    }

    $jalaninQuery = false;

    if (empty($errors)) {
        $queryFull = "UPDATE tugasAkhir SET ". $queryTambahan. " WHERE nimMhs = $nim" ;
        $jalaninQuery = mysqli_query($koneksi,$queryFull);
    }

    if ($jalaninQuery) {
        $expire = time()+5;
        setcookie('status',2,$expire);
        setcookie('nim',"File TA ".$nim,$expire);
        header("location:form-daftarTa.php");
    } else {
        $expire = time()+5;
        setcookie('status',4,$expire);
        setcookie('nim',"Upload Error :  ".$errors,$expire);
        header("location:form-daftarTa.php");
    }
}else {
$expire = time()+5;
setcookie('status',4,$expire);
setcookie('nim',"File TA ".$nim,$expire);
header("location:form-daftarTa.php");
}


?>