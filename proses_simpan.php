<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if (!isset($_POST['kategori'], $_POST['barang'], $_POST['judul'], $_POST['isi'])) {
    die("Data form tidak lengkap");
}

$id_user  = $_SESSION['user']['id'];
$kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
$barang   = mysqli_real_escape_string($koneksi, $_POST['barang']);
$judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
$isi      = mysqli_real_escape_string($koneksi, $_POST['isi']);

$nama_file = null;

// upload foto
if(!empty($_FILES['foto']['name'])){
    $folder = "uploads/";
    $nama_file = time() . "_" . basename($_FILES['foto']['name']);
    $target = $folder . $nama_file;

    $tipe = strtolower(pathinfo($target, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];

    if(in_array($tipe, $allowed)){
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
    }else{
        echo "<script>alert('Format file harus JPG, PNG, atau GIF');history.back();</script>";
        exit();
    }
}

$query = "INSERT INTO aspirasi(id_user, kategori, barang, judul, isi, foto, status, feedback, tanggal)
VALUES('$id_user','$kategori','$barang','$judul','$isi','$nama_file','menunggu','-', NOW())";

if(mysqli_query($koneksi, $query)){
    echo "<script>alert('Aspirasi berhasil dikirim');window.location='dashboard_siswa.php';</script>";
}else{
    echo "Error: ".mysqli_error($koneksi);
}
?>
